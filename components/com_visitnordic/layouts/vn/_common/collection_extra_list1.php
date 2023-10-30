<?php

$item = $displayData;

$buffer = '';
$layout = new JLayoutFile('vn.common.collection');

$collections = array(
    array(
        'title' => trim($item->extra1_title),
        'coid' => (int) $item->extra1_collection,
    ),
    array(
        'title' => trim($item->extra2_title),
        'coid' => (int) $item->extra2_collection,
    ),
    array(
        'title' => trim($item->extra3_title),
        'coid' => (int) $item->extra3_collection,
    ),
    array(
        'title' => trim($item->extra4_title),
        'coid' => (int) $item->extra4_collection,
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

