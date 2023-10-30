<?php
/**
 * @version     1.0.0
 * @package     com_visitnordic
 * @copyright   Copyright (C) 2015. Alle rettigheder forbeholdes.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      CGOnline.dk <info@cgonline.dk> - http://www.cgonline.dk
 */

// No direct access
defined('_JEXEC') or die;

require_once JPATH_ADMINISTRATOR . '/components/com_visitnordic/helpers/visitnordic.php';

//
// Dear maintainer:
//
// When I wrote this, only Joomla and I understood what was doing on.
// Now, only Joomla knows.
//
// Once you are done trying to 'optimize' this routine,
// and have realized what a terrible mistake that was,
// please increment the following counter as a warning
// to the next guy:
//
// total_hours_wasted_here = 11
//

class VisitnordicRouter extends JComponentRouterBase
{
    // Build a route
    function build(&$query)
    {
        $segments = array();
        $menuItem = $view = $id = null;

        // If we're building a menu item link, only itemid and option is set
        if (isset($query['Itemid']) && !isset($query['view'])) {
            $item = $this->menu->getItem($query['Itemid']);
            if ($item) {
                $menuItem = $item;
                //unset($query['view']);
            }
        }

        // If we're building a link to an itempage, view, id and option is set
        if (isset($query['id'])) {
            if ($item = $this->getMenuItem($query['view'], $query['id'])) {
                $menuItem = $item;
                unset($query['view']);
            } else if ($alias = $this->getDataSlug($query['view'], $query['id'])) {
                $id = $alias;
            } else {
                $id = $query['id'];
            }

            unset($query['id']);
        }

        // If view is a link, return correct link from its params
        if ($menuItem && isset($menuItem->query) && $menuItem->query['view'] == 'link' && isset($menuItem->query['data_type']) && isset($menuItem->query['data_id'])) {
            $menuItem->query['view'] = $menuItem->query['data_type'];
            $menuItem->query['id'] = $menuItem->query['data_id'];

            $query = array_merge($query, $menuItem->query);

            unset($query['data_type']);
            unset($query['data_id']);

            return self::build($query);
        }

        // If we're building a link to a listpage, view and option is set
        if (isset($query['view'])) {
            if ($test = $this->getMenuItem($query['view'])) {
                $menuItem = $test;
            } else {
                $view = $query['view'];
            }

            unset($query['view']);
        }

        // Set a default home item?
        if (!$menuItem || (isset($menuItem) && $menuItem->component != 'com_visitnordic')) {
            $menuItem = $this->getMenuItem('home');
            unset($query['Itemid']);
        }

        // Dont add /collection/ to urls
        if ($view && $view != 'collection') {
            $segments[] = $view;
        }

        if ($id) {
            $parts = explode(':', $id);
            if (count($parts) > 1) {
                array_shift($parts);
            }

            $segments[] = implode('-', $parts);;
        }

        if ($menuItem) {
            $query['Itemid'] = $menuItem->id;
        }

        return $segments;
    }

    // Parse a route

    function getMenuItem($view = null, $id = null)
    {
        $db = JFactory::getDBO();
        $url = 'index.php?option=com_visitnordic';

        if ($view) {
            $url .= '&view=' . $view;
        }

        if ($id) {
            $url .= '&id=' . $id;
        }

        $query = $db->getQuery(true)
            ->select($db->quoteName('id'))
            ->from($db->quoteName('#__menu'))
            ->where($db->quoteName('link') . ' LIKE ' . $db->quote($url))
            ->where($db->quoteName('published') . ' = 1')
            ->where($db->quoteName('menutype') . ' <> ' . $db->quote('main'))
            ->order($db->quoteName('id') . ' ASC');

        // Filter on language if Multi language site
        if (JLanguageMultilang::isEnabled()) {
            $query->where($db->quoteName('language') . ' = ' . $db->quote(JFactory::getLanguage()->getTag()));
        }

        $db->setQuery($query);

        $id = 0;
        $id = ($id ? $id : $db->loadResult());

        return $this->menu->getItem($id);
    }

    // Get menu item by view & id

    protected function getDataSlug($view = null, $id = null)
    {
        if (strpos($id, ':') !== false) {
            return $id;
        }

        if (!VisitnordicHelper::isDataTable($view)) {
            return $id;
        }

        $db = JFactory::getDBO();
        $table = VisitnordicHelper::getDataTable($view);

        $query = $db->getQuery(true)
            ->select($db->quoteName('alias'))
            ->from($db->quoteName($table))
            ->where($db->quoteName('id') . ' = ' . $db->quote($id));
        $db->setQuery($query);

        $alias = $db->loadResult();

        return $id . ($alias ? ':' : '') . $alias;
    }

    // Get data slug by view & id

    public function parse(&$segments)
    {
        $vars = array();

        // If first segment == valid datatable => Try and find its item
        if (VisitnordicHelper::isDataTable($segments[0])) {
            // Shift first slug
            $view = array_shift($segments);

            // Loop through the rest
            while (!empty($segments)) {
                $segment = array_pop($segments);

                if (strpos($segment, '.') !== false) {
                    // Set task
                    $vars['task'] = $vars['view'] . '.' . $segment;
                } else {
                    // Convert alias -> id?
                    if (!is_numeric($segment)) {
                        $segment = $this->getDataId($view, $segment);
                    }

                    $vars['id'] = (int) $segment;
                }
            }

            $vars['view'] = $view;

            return $vars;
        }

        // If this is not a home item, this is a collection (or subcollection) - Let's try and find it
        if ($segments[0] != 'home') {
            $view = 'collection';

            while (!empty($segments)) {
                $segment = array_pop($segments);

                // Convert alias to id
                if (!is_numeric($segment)) {
                    $segment = $this->getDataId($view, $segment);
                }

                $vars['id'] = (int) $segment;
            }

            $vars['view'] = $view;

            return $vars;
        }

        // If we reached this, we're screwed
        $vars['view'] = $this->menu->getActive()->query['view'];

        return $vars;
    }

    // Get data id by view & alias

    protected function getDataId($view = null, $alias = null)
    {
        if (!VisitnordicHelper::isDataTable($view)) {
            return $alias;
        }

        $db = JFactory::getDBO();
        $table = VisitnordicHelper::getDataTable($view);

        $query = $db->getQuery(true)
            ->select($db->quoteName('id'))
            ->from($db->quoteName($table))
            ->where($db->quoteName('alias') . ' = ' . $db->quote($alias));

        if (JFactory::getApplication()->getLanguageFilter()) {
            $query->where($db->quoteName('language') . ' = ' . $db->quote(JFactory::getLanguage()->getTag()));
        }

        $db->setQuery($query);

        return $db->loadResult();
    }
}

function VisitnordicBuildRoute(&$query)
{
    $router = new VisitnordicRouter;
    return $router->build($query);
}

function VisitnordicParseRoute($segments)
{
    $router = new VisitnordicRouter;
    return $router->parse($segments);
}
