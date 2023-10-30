<?php

$item = $displayData;

$datatype = 'tour';
$skipfields = array(71, 55, 61, 65, 27, 44, 23, 24, 59, 67, 57);
$skipgroups = array(25);

$fields = VNAttributes::getFields($datatype);
$values = VNAttributes::getValues($datatype, $item->id);

$layout = new JLayoutFile('vn.common.attributes.field');

$data = new stdClass();
$data->type = $datatype;
$data->id = $item->id;
$data->field = null;

$buffer = '';

foreach ($fields as $field) {
    if (in_array($field->group_id, $skipgroups)) {
        continue;
    }

    if (in_array($field->id, $skipfields)) {
        continue;
    }

    $field->values = array();

    foreach ($values as $value) {
        if ($value->field_id == $field->id) {
            $field->values[] = $value;
        }
    }

    $data->field = $field;

    $buffer .= $layout->render($data);
}

$buffer = trim($buffer);

?>
<?php if (!empty($item->company)): ?>
    <dt class="col-sm-4"><?php echo JText::_('COM_VISITNORDIC_COMMON_CONTACT_COMPANY'); ?></dt>
    <dd class="col-sm-8"><?php echo $item->company; ?></dd>
<?php endif; ?>

<?php echo $buffer; ?>