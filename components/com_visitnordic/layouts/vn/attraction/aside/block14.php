<?php

$item = $displayData;

$coid = (int) $item->aside_collection4;
$coll = VNHelper::getCollection($coid);

if ($coll) {
    $coll->item_layout = 'box';
    $coll->item_columns = 1;

    $layout = new JLayoutFile('vn.common.blocks.collection');
    echo $layout->render($coll);
}
