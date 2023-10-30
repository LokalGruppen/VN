<?php

$data = $displayData;

$type = @$data->type;
$id = @$data->id;
$field = @$data->field;
$values = @$data->field->values;

if (!$values) {
    $values = VNAttributes::getValues($type, $id, $field->id);
}

if (count($values)) {
    if (stripos($values[0]->title, '- select') === false) {
        // Build field details
        $details = new stdClass();
        $details->field = $field;
        $details->values = $values;
        $details->namekey = VNAttributes::getNameField();
        $details->ftype = (@$field->type ? @$field->type : 'text');

        // Test for a specialised layout
        $test = new JLayoutFile('vn.common.attributes.field-' . @$field->id);
        $content = $test->render($details);

        if (empty($content)) {
            // Fallback
            $layout = new JLayoutFile('vn.common.attributes.' . $details->ftype);
            $content = $layout->render($details);
        }

        echo $content;
    }
}

