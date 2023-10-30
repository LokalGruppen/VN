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

/**
 * Visitnordic Data View
 */
class VisitnordicViewHotel extends JViewLegacy
{
    protected $state;
    protected $item;
    protected $form;
    protected $params;

    public function display($tpl = null)
    {
        $app = Factory::getApplication();
        $user = Factory::getUser();

        $this->state = $this->get('State');
        $this->item = $this->get('Data');
        $this->params = $app->getParams('com_visitnordic');

        if (!$this->item) {
            throw new Exception('Page not found', 404);
        }

        if (!empty($this->item)) {
            $this->item->category_title = $this->getModel()->getCategoryName($this->item->category)->title;
        }

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors));
        }

        if ($this->_layout == 'edit') {
            $authorised = $user->authorise('core.create', 'com_visitnordic');

            if ($authorised !== true) {
                throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'));
            }
        }

        $this->_prepareDocument();

        parent::display($tpl);
    }

    protected function _prepareDocument()
    {
        $app = Factory::getApplication();
        $menus = $app->getMenu();
        $menu = $menus->getActive();

        if ($menu) {
            $this->params->def('page_heading', $this->params->get('page_title', $menu->title));
        } else {
            $this->params->def('page_heading', JText::_('COM_VISITNORDIC_DEFAULT_PAGE_TITLE'));
        }

        VNViewHelper::setMetaData('hotel', $this, $this->item, $this->params);
    }
}
