<?php

$item = $displayData;

$buffer = '';
$layout = new JLayoutFile('vn.common.collection');

$collections = array(
    array(
        'title' => trim($item->extra13_title),
        'coid' => (int) $item->extra13_collection,
    ),
    array(
        'title' => trim($item->extra14_title),
        'coid' => (int) $item->extra14_collection,
    ),
    array(
        'title' => trim($item->extra15_title),
        'coid' => (int) $item->extra15_collection,
    ),
    array(
        'title' => trim($item->extra16_title),
        'coid' => (int) $item->extra16_collection,
    )
);

foreach ($collections as $collection) {
    if ($collection['coid']) {
        $data = VNHelper::getCollection($collection['coid']);

        if ($data) {
            // Override values
            $data->item_layout = 'list';
            $data->item_columns = 1;

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

