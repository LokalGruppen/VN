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

require_once __DIR__ . '/vndata.php';

/**
 * Visitnordic model.
 */
class VisitnordicModelCollection extends VNModelItem
{
    protected $modeltype = 'collection';
    protected $modeltable = '#__visitnordic_collections';

    public function getData($id = null)
    {
        $db = Factory::getDbo();

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

            if (strtotime($table->publish_up) > strtotime(Factory::getDate()) || ((strtotime($table->publish_down) < strtotime(Factory::getDate())) && $table->publish_down != Factory::getDbo()->getNullDate())) {
                return $this->_item;
            }

            // Convert the JTable to a clean JObject.
            $properties = $table->getProperties(1);
            $this->_item = JArrayHelper::toObject($properties, 'JObject');
        }

        $this->_item->items = array();

        if (isset($this->_item->id) && (int) $this->_item->id > 0) {
            $model = JModelLegacy::getInstance('CollectionItems', 'VisitnordicModel');
            $model->setState('filter.collection_id', (int) $this->_item->id);
            $this->_item->items = $model->getItems();
        }

        return $this->_item;
    }
}
