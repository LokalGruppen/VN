<?php

$item = $displayData;

$buffer = '';
$layout = new JLayoutFile('vn.common.collection');

$collections = array(
    array(
        'title' => trim($item->extra9_title),
        'coid' => (int) $item->extra9_collection,
    ),
    array(
        'title' => trim($item->extra10_title),
        'coid' => (int) $item->extra10_collection,
    ),
    array(
        'title' => trim($item->extra11_title),
        'coid' => (int) $item->extra11_collection,
    ),
    array(
        'title' => trim($item->extra12_title),
        'coid' => (int) $item->extra12_collection,
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

