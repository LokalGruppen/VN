<?php

$position = $displayData;

$document = Factory::getDocument();
$renderer = $document->loadRenderer('module');

$modules = JModuleHelper::getModules($position);
$params = array('style' => 'none');
$html = '';

ob_start();

foreach ($modules as $module) {
    echo $renderer->render($module, $params);
}

$html = ob_get_clean();

?>

<?php if (!empty($html)): ?>

    <?php echo $html; ?>

<?php endif; ?>

