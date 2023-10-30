<?php

$item = $displayData;

$data = new stdClass();
$data->title = JText::_('COM_VISITNORDIC_COMMON_OPENINGHOURS_TITLE');
$data->text = $item->openinghours;
$data->rollout = true;

// Convert only if no tags are found in text
if (strpos($data->text, '<') === false) {
    $data->text = nl2br($data->text);
}

?>

<?php if (!empty($item->openinghours)): ?>
    <?php
    $layout = new JLayoutFile('vn.common.text');
    echo $layout->render($data);
    ?>
<?php endif; ?>