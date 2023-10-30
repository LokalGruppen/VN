<?php

$item = $displayData;

$booking_title = '';
$booking_url = '';
$readmore_title = '';
$readmore_url = '';
$namekey = VNAttributes::getNameField();

$field = VNAttributes::getField(42);
$values = VNAttributes::getValues('restaurant', $item->id, $field->id);
if ($values) {
    $booking_title = $field->$namekey;
    $booking_url = VNHTMLHelper::cleanLink($values[0]->value);
}

$field = VNAttributes::getField(43);
$values = VNAttributes::getValues('restaurant', $item->id, $field->id);
if ($values) {
    $readmore_title = $field->$namekey;
    $readmore_url = VNHTMLHelper::cleanLink($values[0]->value);
}

$data = new stdClass();
$data->title = $field->$namekey;
$data->text = '';

?>

<?php if ($booking_url || $readmore_url): ?>

    <?php if ($booking_url): ?>
        <a class="btn btn-success" href="<?php echo $booking_url; ?>"
           target="_blank"><?php echo JText::_('COM_VISITNORDIC_RESTAURANT_BOOKING_LINK'); ?></a>
    <?php endif; ?>

    <?php if ($readmore_url): ?>
        <a class="btn btn-success" href="<?php echo $readmore_url; ?>"
           target="_blank"><?php echo JText::_('COM_VISITNORDIC_RESTAURANT_BOOKING_READMORE'); ?></a>
    <?php endif; ?>

<?php endif; ?>