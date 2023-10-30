<?php
/**
 * @version     1.0.0
 * @package     com_visitnordic
 * @copyright   Copyright (C) 2015. Alle rettigheder forbeholdes.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      CGOnline.dk <info@cgonline.dk> - http://www.cgonline.dk
 */

// No direct access.
defined('_JEXEC') or die;

require_once __DIR__ . '/vnlist.php';

/**
 * Visitnordic model.
 */
class VisitnordicModelCollectionitems extends VNModelList
{
    protected $modeltype = 'collectionitems';
    protected $modeltable = '#__visitnordic_collectionitems';

    public function __construct($config = array())
    {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                'id', 'a.id',
                'collection_id', 'a.collection_id',
                'ordering', 'a.ordering',
                'state', 'a.state',
                'title', 'a.title',
                'text', 'a.text',
                'table', 'a.table',
                'link', 'a.link',
                'linktext', 'a.linktext',
            );
        }

        parent::__construct($config);
    }

    public function getItems()
    {
        $items = parent::getItems();
        $db = Factory::getDbo();

        foreach ($items as $key => $item) {
            if ($item->data_type == 'link') {
                continue;
            }

            $q = $db->getQuery(true)
                ->select('*')
                ->from(VisitnordicHelper::getDataTable($item->data_type))
                ->where('id = ' . $item->data_id);
            $db->setQuery($q);
            $row = $db->loadObject();

            if (!$row || $row->state != 1) {
                unset($items[$key]);
                continue;
            }

            if (empty($item->title)) {
                $item->title = $row->title;
            }
/* Viser intro tekst på listevisninger */
            if (empty($item->text)) {
                if (isset($row->introtext) && !empty($row->introtext)) {
                    $item->text = nl2br($row->introtext);
                } else if (isset($row->description) && !empty($row->description)) {
                    $item->text = nl2br($row->description);
                } else if (isset($row->text) && !empty($row->text)) {
                    $item->text = $row->text;
                }
            }


/* Viser main tekst på listevisninger 
            if (empty($item->text)) {
                if (isset($row->text) && !empty($row->text)) {
                    $item->text = nl2br($row->text);
                } else if (isset($row->description) && !empty($row->description)) {
                    $item->text = nl2br($row->description);
                } else if (isset($row->text) && !empty($row->text)) {
                    $item->text = $row->text;
                }
            }
*/
            if (empty($item->link)) {
                $item->link = JRoute::_('index.php?option=com_visitnordic&view=' . $item->data_type . '&id=' . $item->data_id);
            }

            if (empty($item->linktext)) {
                $item->linktext = '';
            }

            if (empty($item->image)) {
                $item->image = (isset($row->thumbnail) ? $row->thumbnail : '');
            }

            $slideshowImages = null;
            if (isset($row->intromedia)) {
              if (in_array($row->intromedia, [1,2]) && $row->images) {
                $slideshowImages = json_decode($row->images, true);
              }
            } else if (isset($row->image_type)) {
              if (in_array($row->image_type, [1,2]) && $row->image_list) {
                $slideshowImages = json_decode($row->image_list, true);
              }
            }

            if (!empty($slideshowImages['source'][0])) {
              $item->image = $slideshowImages['source'][0];
            }

            $item->logo = @$row->logo;

            $map = new stdClass();
            $map->title = $item->title;
            $map->text = $item->text;
            $map->link = $item->link;
            $map->homepage = @$row->homepage;  // If this is a collection, no map info is available
            $map->query = @$row->mapquery;  // If this is a collection, no map info is available
            $map->lattitude = @$row->lattitude; // If this is a collection, no map info is available
            $map->longitude = @$row->longitude; // If this is a collection, no map info is available

            $item->map = $map;
        }

        return $items;
    }

    protected function populateState($ordering = 'ordering', $direction = 'ASC')
    {
        $app = Factory::getApplication();
        $user = Factory::getUser();

        // Filter on state for those who do not have edit or edit.state rights
        if ((!$user->authorise('core.edit.state', 'com_visitnordic')) && (!$user->authorise('core.edit', 'com_visitnordic'))) {
            $this->setState('filter.state', 1);
        }

        // Filter on language if Multi language site
        if (JLanguageMultilang::isEnabled()) {
            //$this->setState('filter.language', Factory::getLanguage()->getTag());
        }

        //$this->setState('list.limit', 999);
        //$this->setState('list.start', 0);
        $this->setState('list.ordering', $ordering);
        $this->setState('list.direction', $direction);

        // Set layout
        $this->setState('layout', $app->input->getString('layout'));
    }

    protected function getStoreId($id = '')
    {
        // Compile the store id.
        $id .= ':' . serialize($this->getState('filter.state'));
        //$id .= ':' . serialize($this->getState('filter.language'));
        $id .= ':' . serialize($this->getState('filter.collection_id'));

        return parent::getStoreId($id);
    }

    protected function getListQuery()
    {
        // Create a new query object.
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        $query
            ->select(
                $this->getState('list.select', 'DISTINCT a.*')
            );

        $query->from($db->qn($this->modeltable) . ' AS a');

        // Join over Language
        //$query->select('l.title AS language_title');
        //$query->join('LEFT', $db->quoteName('#__languages') . ' AS l ON (l.lang_code = a.language)');

        /*
         * @Todo: Join over data items
         * @Todo: Join over attributes, etc?
         */

        // Filter by state
        if ($state = $this->getState('filter.state')) {
            $query->where('a.state = ' . $db->quote($state));
        }

        // Filter by language
        if ($language = $this->getState('filter.language')) {
            //$query->where('a.language = ' . $db->quote($language));
        }

        // Filter by Collection
        $collection_id = $this->getState('filter.collection_id');
        if (is_numeric($collection_id)) {
            $query->where('a.collection_id = ' . (int) $collection_id);
        }

        // Filter by start and end dates.
        $nullDate = $db->quote($db->getNullDate());
        $date = Factory::getDate();
        $nowDate = $db->quote($date->toSql());

        $query->join('LEFT', '#__visitnordic_collections collection on (a.data_id = collection.id AND a.data_type = "collection")');
        $query->join('LEFT', '#__visitnordic_articles article on (a.data_id = article.id AND a.data_type = "article")');
        $query->join('LEFT', '#__visitnordic_attractions attraction on (a.data_id = attraction.id AND a.data_type = "attraction")');
        $query->join('LEFT', '#__visitnordic_hotels hotel on (a.data_id = hotel.id AND a.data_type = "hotel")');
        $query->join('LEFT', '#__visitnordic_restaurants restaurant on (a.data_id = restaurant.id AND a.data_type = "restaurant")');
        $query->join('LEFT', '#__visitnordic_tours tour on (a.data_id = tour.id AND a.data_type = "tour")');

        $query->where('(
                (a.data_type = ' . $db->quote('article') . ' AND (article.publish_up = ' . $nullDate . ' OR article.publish_up <= ' . $nowDate . ') AND (article.publish_down = ' . $nullDate . ' OR article.publish_down >= ' . $nowDate . '))
                OR
                (a.data_type = ' . $db->quote('attraction') . ' AND (attraction.publish_up = ' . $nullDate . ' OR attraction.publish_up <= ' . $nowDate . ') AND (attraction.publish_down = ' . $nullDate . ' OR attraction.publish_down >= ' . $nowDate . '))
                OR
                (a.data_type = ' . $db->quote('collection') . ' AND (collection.publish_up = ' . $nullDate . ' OR collection.publish_up <= ' . $nowDate . ') AND (collection.publish_down = ' . $nullDate . ' OR collection.publish_down >= ' . $nowDate . '))
                OR
                (a.data_type = ' . $db->quote('hotel') . ' AND (hotel.publish_up = ' . $nullDate . ' OR hotel.publish_up <= ' . $nowDate . ') AND (hotel.publish_down = ' . $nullDate . ' OR hotel.publish_down >= ' . $nowDate . '))
                OR
                (a.data_type = ' . $db->quote('restaurant') . ' AND (restaurant.publish_up = ' . $nullDate . ' OR restaurant.publish_up <= ' . $nowDate . ') AND (restaurant.publish_down = ' . $nullDate . ' OR restaurant.publish_down >= ' . $nowDate . '))
                OR
                (a.data_type = ' . $db->quote('tour') . ' AND (tour.publish_up = ' . $nullDate . ' OR tour.publish_up <= ' . $nowDate . ') AND (tour.publish_down = ' . $nullDate . ' OR tour.publish_down >= ' . $nowDate . '))
                OR
                (a.data_type != ' . $db->quote('article') . ' AND a.data_type != ' . $db->quote('attraction') . ' AND a.data_type != ' . $db->quote('collection') . ' AND a.data_type != ' . $db->quote('hotel') . ' AND a.data_type != ' . $db->quote('restaurant') . ' AND a.data_type != ' . $db->quote('tour') . ')
        )');

        // Filter by search in title
        $search = $this->getState('filter.search');
        if (!empty($search)) {
            if (stripos($search, 'id:') === 0) {
                $query->where('a.id = ' . (int) substr($search, 3));
            } else {
                $search = $db->q('%' . $db->escape($search, true) . '%');

                $where = array();
                foreach ($this->filter_fields as $field) {
                    $parts = (array) explode('.', $field);
                    $fname = end($parts);
                    $where[$fname] = $db->qn($field) . ' LIKE ' . $search . '';
                }

                $query->where('(' . implode(' OR ', $where) . ')');
            }
        }

        // Add the list ordering clause.
        $orderCol = $this->state->get('list.ordering', 'a.id');
        $orderDirn = $this->state->get('list.direction', 'desc');
        if ($orderCol && $orderDirn) {
            $query->order($db->escape($orderCol . ' ' . $orderDirn));
        }

        return $query;
    }

}
