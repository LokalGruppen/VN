<?php

$item = $displayData;

$title = '';
$price = 0;
$namekey = VNAttributes::getNameField();

$field = VNAttributes::getField(39);
$values = VNAttributes::getValues('tour', $item->id, $field->id);
if ($values) {
    $title = $field->$namekey;
    $price = $values[0]->value;
}

?>

<?php if ($price): ?>

    <h3 class="mb-3"><?php echo JText::_('COM_VISITNORDIC_TOUR_PRICE_TITLE'); ?></h3>

    <p><strong><?php echo JText::sprintf('COM_VISITNORDIC_TOUR_PRICE', $price); ?></strong></p>

<?php endif; ?>
