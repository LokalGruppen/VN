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

require_once JPATH_COMPONENT . '/controller.php';

/**
 * Visitnordic Tour List Controller
 */
class VisitnordicControllerTours extends VisitnordicController
{
    public function &getModel($name = 'Tours', $prefix = 'VisitnordicModel', $config = array())
    {
        return parent::getModel($name, $prefix, array('ignore_request' => true));
    }
}