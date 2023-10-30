<?php

$item = $displayData;

$buffer = '';
$layout = new JLayoutFile('vn.common.collection');

$collections = array(
    array(
        'title' => trim($item->extra5_title),
        'coid' => (int) $item->extra5_collection,
    ),
    array(
        'title' => trim($item->extra6_title),
        'coid' => (int) $item->extra6_collection,
    ),
    array(
        'title' => trim($item->extra7_title),
        'coid' => (int) $item->extra7_collection,
    ),
    array(
        'title' => trim($item->extra8_title),
        'coid' => (int) $item->extra8_collection,
    )
);

foreach ($collections as $collection) {
    if ($collection['coid']) {
        $data = VNHelper::getCollection($collection['coid']);

        if ($data) {
            // Override values
            $data->item_layout = 'box';

            if (!empty($collection['title'])) {
                $data->item_title = $collection['title'];
            }

            $buffer .= trim($layout->render($data));
        }
    }
}

if (!empty($buffer)) {
    echo $buffer;
}

