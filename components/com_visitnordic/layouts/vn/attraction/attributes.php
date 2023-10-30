<?php

$item = $displayData;

$datatype = 'attraction';
$skipfields = array(71, 41, 72, 23);
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

echo $buffer;
