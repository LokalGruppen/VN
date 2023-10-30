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

jimport('joomla.application.component.modelitem');
jimport('joomla.event.dispatcher');

/**
 * Visitnordic Data Model.
 */
class VNModelItem extends JModelItem
{
    public function getData($id = null)
    {
        $db = JFactory::getDbo();

        if ($this->_item === null) {
            $this->_item = false;

            if (empty($id)) {
                $id = $this->getState($this->modeltype . '.id');
            }

            $table = $this->getTable();

            if (!$table->load($id)) {
//				throw new Exception(ucfirst($this->modeltype) .' not loaded', 404);
//                $this->setError(ucfirst($this->modeltype) . ' not loaded');
                return $this->_item;
            }

            if (!$table->id) {
//				throw new Exception(ucfirst($this->modeltype) .' not found', 404);
//                $this->setError(ucfirst($this->modeltype) . ' not found');
                return $this->_item;
            }

            if ($table->state != 1) {
//                throw new Exception(ucfirst($this->modeltype) .' not found', 404);
//                $this->setError(ucfirst($this->modeltype) . ' not published');
                return $this->_item;
            }

            if (strtotime($table->publish_up) > strtotime(JFactory::getDate()) || ((strtotime($table->publish_down) < strtotime(JFactory::getDate())) && $table->publish_down != JFactory::getDbo()->getNullDate())) {
                return $this->_item;
            }

            // Convert the JTable to a clean JObject.
            $properties = $table->getProperties(1);
            $this->_item = JArrayHelper::toObject($properties, 'JObject');
        }

        if (isset($this->_item->images)) {
            $this->_item->images = json_decode($this->_item->images);
        }

        if (isset($this->_item->videos)) {
            $this->_item->videos = json_decode($this->_item->videos);
        }

        if (isset($this->_item->links)) {
            $this->_item->links = json_decode($this->_item->links);
        }

        if (isset($this->_item->speaking)) {
            $this->_item->speaking = json_decode($this->_item->speaking);
        }

        if (isset($this->_item->sharing)) {
            $this->_item->sharing = json_decode($this->_item->sharing);
        }

        if (isset($this->_item->region) && (int) $this->_item->region > 0) {
            $value = (int) $this->_item->region;

            $query = $db->getQuery(true);
            $query
                ->select('*')
                ->from('`#__visitnordic_regions`')
                ->where('id = ' . $db->quote($value));
            $db->setQuery($query);
            $this->_item->region = $db->loadObject();
        }

        if (isset($this->_item->tags)) {
            $tags = explode(",", $this->_item->tags);
            $this->_item->tags = array();

            foreach ($tags as $tag) {
                $query = $db->getQuery(true);
                $query->select('id,title');
                $query->from('`#__tags`');
                $query->where('id = ' . intval($tag));

                $db->setQuery($query);
                $rows = (array) $db->loadObjectList();

                foreach ($rows as $row) {
                    $id = $row->id;
                    $title = $row->title;

                    if ($id && $value) {
                        $this->_item->tags[$id] = $title;
                    }
                }
            }
        }

        return $this->_item;
    }

    public function getTable($type = null, $prefix = 'VisitnordicTable', $config = array())
    {
        $type = ($type === null ? ucfirst($this->modeltype) : $type);

        $this->addTablePath(JPATH_COMPONENT_ADMINISTRATOR . '/tables');

        return JTable::getInstance($type, $prefix, $config);
    }

    public function getCategoryName($id)
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true)
            ->select('title')
            ->from('#__categories')
            ->where('id = ' . (int) $id);
        $db->setQuery($query);
        return $db->loadObject();
    }

    protected function populateState()
    {
        $app = JFactory::getApplication('com_visitnordic');

        // Load state from the request userState on edit or from the passed variable on default
        if (JFactory::getApplication()->input->get('layout') == 'edit') {
            $id = JFactory::getApplication()->getUserState('com_visitnordic.edit.' . $this->modeltype . '.id');
        } else {
            $id = JFactory::getApplication()->input->get('id');
            JFactory::getApplication()->setUserState('com_visitnordic.edit.' . $this->modeltype . '.id', $id);
        }
        $this->setState($this->modeltype . '.id', $id);

        // Load the parameters.
        $params = $app->getParams();
        $params_array = $params->toArray();
        if (isset($params_array['item_id'])) {
            $this->setState($this->modeltype . '.id', $params_array['item_id']);
        }
        $this->setState('params', $params);
    }
}
