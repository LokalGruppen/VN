<?
$item = $displayData;

// Create default marker for this item
$marker = new stdClass();
$marker->title = $item->title;
$marker->text = $item->introtext;
//$marker->link      = JRoute::_('index.php?option=com_visitnordic&view='. $item->tableType .'&id='. $item->id);
$marker->homepage = $item->homepage;
$marker->query = $item->mapquery;
$marker->lattitude = $item->lattitude;
$marker->longitude = $item->longitude;

if (!empty($item->homepage)) {
    $marker->text .= '<a href="' . $item->homepage . '" target="_blank" class="btn btn-md btn-link">' . JText::_('COM_VISITNORDIC_MAP_POPUP_VISIT') . '</a>';
}

$options = array(
    'lattitude' => $item->lattitude,
    'longitude' => $item->longitude,
    'query' => $item->mapquery,
    'zoomlevel' => $item->zoomlevel,
    'maptype' => 'ROADMAP',
    'direction' => false,
    'coordinates' => false,
    'markers' => array($marker),
);

$layout = new JLayoutFile('vn.common.blocks.map_aside');
echo $layout->render($options);

$item->skipMap = true;
