<?

$item = $displayData;



$data = VNHTMLHelper::repeatableToArray($item->aside_map);



// Set default (if no map in backend is set on collection)

if (!count($data)) {

    $default = new stdClass();

    $default->results = 1;

    $default->lattitude = 0;

    $default->longitude = 0;

    $default->zoomlevel = 8;

    $default->type = 'ROADMAP';



    $data[0] = $default;

}



if (count($data)) {

    $markers = array();



    if ((int) $data[0]->results == 1) {

        // Add collection items if map is set to show results

        foreach ($item->items as $entry) {

            $markers[] = $entry->map;

        }

    } else {

        // Else add a dummy marker from the map options

        $marker = new stdClass();

        $marker->title = $item->title;

        $marker->text = '';

        $marker->link = '';

        $marker->homepage = '';

        $marker->query = '';

        $marker->lattitude = $data[0]->lattitude;

        $marker->longitude = $data[0]->longitude;



        $markers[] = $marker;

    }



    $options = array(

        'zoomlevel' => $data[0]->zoomlevel,

        'maptype' => $data[0]->type,

        'markers' => $markers,

    );



    $layout = new JLayoutFile('vn.common.blocks.map_aside');

    echo $layout->render($options);

}

