<?php

$item = $displayData;

$field = VNAttributes::getField(41);
$namekey = VNAttributes::getNameField();
$values = VNAttributes::getValues('attraction', $item->id, $field->id);

$data = new stdClass();
$data->title = $field->$namekey;
$data->text = '';
$data->rollout = true;

if ($values) {
    if (is_array($values)) {
        foreach ($values as $value) {
            $data->text .= $value->value;
        }
    } else {
        $data->text .= $values->value;
    }

    $data->text = nl2br($data->text);
}

?>

<?php if ($field && !empty($data->text)): ?>

    <?php
    $layout = new JLayoutFile('vn.common.text');
    echo $layout->render($data);
    ?>

<?php endif; ?>