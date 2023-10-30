<?php

$item = $displayData;

$title = '';
$map = 0;
$namekey = VNAttributes::getNameField();

$field = VNAttributes::getField(40);
$values = VNAttributes::getValues('tour', $item->id, $field->id);
if ($values) {
    $title = $field->$namekey;
    $map = $values[0]->value;
}

?>

<?php if ($map): ?>

    <a href="<?php echo $map; ?>" title="<?php echo $title; ?>" class="luminous">
        <img src="<?php echo $map; ?>" alt="<?php echo $title; ?>" class="img-fluid mb-3">
    </a>

<?php endif; ?>
