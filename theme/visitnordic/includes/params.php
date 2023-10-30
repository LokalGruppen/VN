<?php
/**
 * @author CGOnline.dk
 * @copyright Copyright © 2016 CGOnline.dk - All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */
defined('_JEXEC') or die;

include_once __DIR__ .'/helper.php';

// Init usefull ressources
$app	    = JFactory::getApplication();
$doc	    = JFactory::getDocument();
$user       = JFactory::getUser();
$config     = JFactory::getConfig();

// Getting params from template
$params	= JFactory::getApplication()->getTemplate(true)->params;

// Build up direct path to template
$tpath	= $this->baseurl . '/templates/' . $this->template;

$doc->addScriptOptions($tpath . '/dist/bundle.js','912345');

$doc->addStyleSheetVersion($tpath . '/dist/bundle.css','912345');

// Generator & Favicon tags
$doc->setGenerator(null);
$doc->addFavicon($tpath . '/favicon.png');
$doc->setMetadata('x-ua-compatible', 'IE=edge,chrome=1');
$doc->setMetadata('viewport', 'width=device-width, initial-scale=1, shrink-to-fit=no');