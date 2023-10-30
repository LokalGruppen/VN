<?php

$item = $displayData;

$position = trim($item->aside_module3);

$layout = new JLayoutFile('vn.common.blocks.module');
echo $layout->render($position);
