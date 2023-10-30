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
class VisitnordicModelAttractions extends VNModelList
{
    protected $modeltype = 'attraction';
    protected $modeltable = '#__visitnordic_attractions';
}
