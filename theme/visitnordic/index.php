<?php
// Explicitly use the full namespace
use \Joomla\CMS\Factory;

/**
 * @author CGOnline.dk
 * @copyright Copyright © 2016 CGOnline.dk - All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */
defined('_JEXEC') or die;

include __DIR__ .'/includes/params.php';
$helper = \VisitNordic\vnTemplateHelper::getInstance($this);


include __DIR__ .'/template.php';
