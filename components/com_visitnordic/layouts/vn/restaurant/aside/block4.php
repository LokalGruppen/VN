<?php

$item = $displayData;

$layout = new JLayoutFile('vn.common.tripadvisor');
echo $layout->render($item);

$layout = new JLayoutFile('vn.common.blocks.daodao');
echo $layout->render($item);

$item->skipTripadvisor = true;