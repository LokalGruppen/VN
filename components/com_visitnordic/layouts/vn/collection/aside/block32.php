<?php

$item = $displayData;

$position = trim($item->aside_module2);

$layout = new JLayoutFile('vn.common.blocks.module');
echo $layout->render($position);
