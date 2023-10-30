<?php



$item = $displayData;



?>



<?php if ($item->lattitude && $item->longitude): ?>



    <div class="tab-pane" id="maproute" role="tabpanel">



        <?php



        // Build infowindow

        $html = '';



        // Try and get an image

        $images = VNHTMLHelper::repeatableToArray($item->images);

        $images = VNHTMLHelper::cleanImages($images);

        $image = @$images[0];



        if (is_object($image) && isset($image->source)) {

            $cache = VNHTMLHelper::getResizedImage($image->source, 160, 160);

            $html = '<img src="' . JUri::root() . $cache . '" alt="' . $item->title . '">';

        }



        $html .= '<h4>' . $item->title . '</h4>';

        $html .= '<p>' . $item->introtext . '</p>';



        if (!empty($item->homepage)) {

            $html .= '<a href="' . $item->homepage . '" target="_blank" class="btn btn-md btn-link">' . JText::_('COM_VISITNORDIC_MAP_POPUP_VISIT') . '</a>';

        }



        // Create default marker for this item

        $marker = new stdClass();

        $marker->title = '';

        $marker->text = '<div class="popup">' . $html . '</div>';

        $marker->link = '';

        $marker->homepage = $item->homepage;

        $marker->query = $item->mapquery;

        $marker->lattitude = $item->lattitude;

        $marker->longitude = $item->longitude;



        $options = array(

            'lattitude' => $item->lattitude,

            'longitude' => $item->longitude,

            'query' => $item->mapquery,

            'zoomlevel' => $item->zoomlevel,

            'maptype' => 'ROADMAP',

            'direction' => true,

            'coordinates' => true,

            'markers' => array($marker),

        );



        $layout = new JLayoutFile('vn.common.blocks.map');

        echo $layout->render($options);



        ?>



    </div>



<?php endif; ?>