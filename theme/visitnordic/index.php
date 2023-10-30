<?php
use Joomla\CMS\Factory;

defined('_JEXEC') or die;

require_once __DIR__ . '/includes/helper.php';  // Explicitly include helper.php
include __DIR__ .'/includes/params.php';

$helper = vnTemplateHelper::getInstance($this);  // Removed the namespace
$app = Factory::getApplication();

include __DIR__ .'/template.php';