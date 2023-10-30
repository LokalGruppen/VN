<?php

$item = $displayData;

$links = VNHTMLHelper::repeatableToArray($item->aside_links);
$links = VNHTMLHelper::cleanLinks($links);

$layout = new JLayoutFile('vn.common.blocks.link');
echo $layout->render($links);
