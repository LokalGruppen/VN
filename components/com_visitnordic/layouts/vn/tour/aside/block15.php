<?php

$item = $displayData;

$coid = (int) $item->aside_collection5;
$coll = VNHelper::getCollection($coid);

if ($coll) {
    $coll->item_layout = 'list';
    $coll->item_columns = 1;

    $layout = new JLayoutFile('vn.common.blocks.collection');
    echo $layout->render($coll);
}
