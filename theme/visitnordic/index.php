<?php
/**
 * @author CGOnline.dk
 * @copyright Copyright © 2016 CGOnline.dk - All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */
defined('_JEXEC') or die;


use Joomla\CMS\Factory;

include __DIR__ .'/includes/params.php';
$helper = vnTemplateHelper::getInstance($this);


include __DIR__ .'/template.php';
