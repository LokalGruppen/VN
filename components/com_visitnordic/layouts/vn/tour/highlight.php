<?php

$item = $displayData;

$title = '';
$highlights = '';
$namekey = VNAttributes::getNameField();

$field = VNAttributes::getField(35);
$values = VNAttributes::getValues('tour', $item->id, $field->id);
if ($values) {

    $highlights = VNHTMLHelper::cleanLink();
}

?>

<?php if ($values && !empty($values[0]->value)): ?>


    <h3><?php echo $field->$namekey; ?></h3>

    <div>
        <?php echo nl2br($values[0]->value); ?>
    </div>

<?php endif; ?>