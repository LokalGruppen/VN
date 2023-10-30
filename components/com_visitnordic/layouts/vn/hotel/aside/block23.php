<?php

$item = $displayData;

$html = trim($item->aside_html3);

$layout = new JLayoutFile('vn.common.blocks.html');
echo $layout->render($html);
