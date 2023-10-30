<?php

$item = $displayData;

$links = VNHTMLHelper::repeatableToArray($item->links);
$links = VNHTMLHelper::cleanLinks($links);

$layout = new JLayoutFile('vn.common.blocks.link');
echo $layout->render($links);

$item->skipLinks = true;