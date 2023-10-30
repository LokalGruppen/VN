<?php
use Joomla\CMS\Factory;

/**
 * @author CGOnline.dk
 * @copyright Copyright © 2016 CGOnline.dk - All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */
defined('_JEXEC') or die;

include_once __DIR__ .'/helper.php';

// Init usefull ressources
$app	    = Factory::getApplication();
$doc	    = Factory::getDocument();
$user       = Factory::getUser();
$config     = Factory::getConfig();

// Getting params from template
$params	= Factory::getApplication()->getTemplate(true)->params;

// Build up direct path to template
$tpath	= $this->baseurl . '/templates/' . $this->template;

// Updated WebAssetManager for stylesheets
$webAssetManager = $doc->getWebAssetManager();
$webAssetManager->registerAndUseScript('bundle-js', $tpath . '/dist/bundle.js', [], ['version' => '912345']);
$webAssetManager->registerAndUseStylesheet('bundle-css', $tpath . '/dist/bundle.css', [], ['version' => '912345']);

// Generator & Favicon tags
$doc->setGenerator(null);
$doc->addFavicon($tpath . '/favicon.png');
$doc->setMetadata('x-ua-compatible', 'IE=edge,chrome=1');
$doc->setMetadata('viewport', 'width=device-width, initial-scale=1, shrink-to-fit=no');