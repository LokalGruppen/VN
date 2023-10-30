rue;<?php

$item = $displayData;

$layout = new JLayoutFile('vn.common.blocks.address');
echo $layout->render($item);

$item->skipAddress = true;