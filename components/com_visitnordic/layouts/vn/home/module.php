<?php

$position = $displayData;

$document = JFactory::getDocument();
$renderer = $document->loadRenderer('module');

$modules = JModuleHelper::getModules($position);
$params = array('style' => 'none');

foreach ($modules as $module) {
    echo $renderer->render($module, $params);
}
