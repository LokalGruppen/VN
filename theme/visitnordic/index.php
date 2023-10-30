<?php
namespace VisitNordic;

use Joomla\CMS\Factory;

defined('_JEXEC') or die;

include __DIR__ .'/includes/params.php';
$helper = \VisitNordic\vnTemplateHelper::getInstance($this);
$app = \Joomla\CMS\Factory::getApplication();

include __DIR__ .'/template.php';
