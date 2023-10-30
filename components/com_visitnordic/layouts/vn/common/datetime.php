<?php

$item = $displayData;

$data = new stdClass();
$data->title = JText::_('COM_VISITNORDIC_COMMON_DATETIME_TITLE');
$data->text = $item->datetime;
$data->rollout = true;

// Convert only if no tags are found in text
if (strpos($data->text, '<') === false) {
    $data->text = nl2br($data->text);
}

?>

<?php if (!empty($item->datetime)): ?>
    <?php
    $layout = new JLayoutFile('vn.common.text');
    echo $layout->render($data);
    ?>
<?php endif; ?>
