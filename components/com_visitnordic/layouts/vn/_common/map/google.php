<?php



$options = $displayData;

$mapkey = 'AIzaSyBlouwJDDAZeRanEGlZgsbSogP6MHmnUu4';



if (count($options)): ?>



    <?php



    // Used for map

    $id = @$options['id'];

    $zoom = (int) @$options['zoomlevel'];

    $type = strtoupper(@$options['maptype']);



    // Used for links below map

    $query = @$options['query'];

    $lat = @$options['lattitude'];

    $long = @$options['longitude'];

    $direction = (bool) @$options['direction'];

    $coordinate = (bool) @$options['coordinates'];

    $href = '';



    // Maybe used

    $markers = @$options['markers'];



    // Sanitize input: Type

    if (!in_array($type, array('ROADMAP', 'TERRAIN', 'SATELLITE'))) {

        $type = 'ROADMAP';

    }



    // Sanitize input: Zoom

    if ($zoom < 2 || $zoom > 19) {

        $zoom = 8;

    }



    if ($query) {

        $href = 'https://www.google.com/maps/place/' . urlencode($query) . '/';

    } elseif ($lat && $long) {

        $href = 'https://www.google.com/maps/place/' . '@' . urlencode($lat) . ',' . urlencode($long) . ',' . urlencode($zoom) . 'z';

    }

    ?>

<style>
       /* Set the size of the div element that contains the map */
      #map {
        height: 400px;  /* The height is 400 pixels */
        width: 100%;  /* The width is the width of the web page */
       }
    </style>
    <!--The div element for the map -->
    <div id="map"></div>
    <script>
// Initialize and add the map
function initMap() {
  // The location of Uluru
  var uluru = {lat: <?php echo $lat; ?>, lng: <?php echo $long; ?>};
  // The map, centered at Uluru
  var map = new google.maps.Map(
      document.getElementById('map'), {zoom: 4, center: uluru});
  // The marker, positioned at Uluru
  var marker = new google.maps.Marker({position: uluru, map: map});
}

    </script>
        <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBlouwJDDAZeRanEGlZgsbSogP6MHmnUu4&callback=initMap">
    </script>
<br/><br/>



    <?php if (isset($dir)): ?>

        <p class="small text-right"><a target="_blank"

                                       href="<?php echo $dir; ?>"><?php echo JText::_('COM_VISITNORDIC_MAP_DIRECTIONS_LINK'); ?></a>

        </p>

    <?php endif; ?>



    <?php if ($href || $direction || $coordinate): ?>

        <div class="row extra">

            <?php if ($href): ?>

                <div class="col-sm-12 <?php echo($direction ? 'text-right' : 'text-center'); ?>">

                </div>

            <?php endif; ?>



            <?php if ($direction): ?>

                <div class="col-sm-6 direction">

                    <h3><?php echo JText::_('COM_VISITNORDIC_MAP_DIRECTIONS_TITLE'); ?></h3>

                    <p><?php echo JText::_('COM_VISITNORDIC_MAP_DIRECTIONS_TEXT'); ?></p>

                    <form action="http://maps.google.com/maps" method="get" target="_blank">

                        <div class="form-group">

                            <input type="text" name="saddr" class="form-control"

                                   placeholder="<?php echo JText::_('COM_VISITNORDIC_MAP_DIRECTIONS_TIP'); ?>"

                                   required/>

                        </div>

                        <input type="hidden" name="daddr" value="<?php echo $query; ?>"/>

                        <input type="submit" class="btn btn-primary"

                               value="<?php echo JText::_('COM_VISITNORDIC_MAP_DIRECTIONS_BTN'); ?>"/>

                    </form>

                </div>

            <?php endif; ?>



            <?php if ($coordinate): ?>

                <div class="col-sm-6 coordinates">

                    <h5><?php echo JText::_('COM_VISITNORDIC_MAP_COORDINATES_TITLE'); ?></h5>

                    <ul class="list-unstyled">

                        <li><?php echo JText::_('COM_VISITNORDIC_MAP_COORDINATES_LATTITUDE'); ?><?php echo $lat; ?></li>

                        <li><?php echo JText::_('COM_VISITNORDIC_MAP_COORDINATES_LONGITUDE'); ?><?php echo $long; ?></li>

                    </ul>

                </div>

            <?php endif; ?>

        </div>

    <?php endif; ?>



    <?php

    if (!defined('WINDOW_ONLOAD_STACK')) {

        JFactory::getDocument()->addScriptDeclaration("

            window.onload = function () {

                gmap_render('" . $id . "', '" . $zoom . "', google.maps.MapTypeId." . $type . ");

            };

        ");

    } else {

        JFactory::getDocument()->addScriptDeclaration("

            var prev_handler = window.onload;

            window.onload = function () {

                if (prev_handler) {

                    prev_handler();

                }

                

                $('a[href=\"#maproute\"]').on('shown.bs.tab', function (e) {

                       console.log(123);

                    gmap_render('" . $id . "', '" . $zoom . "', google.maps.MapTypeId." . $type . ");

                    

                    if (e.target.href.indexOf('#map') !== -1)

                    {

                        var map = gmaps[" . $id . "];

                        if (map)

                        {

                            google.maps.event.trigger(map, 'resize');

                            gmap_center(map, '" . $zoom . "');

                        }

                        gmaps[" . $id . "] = false;

                    }

                });

  

                gmap_render('" . $id . "', '" . $zoom . "', google.maps.MapTypeId." . $type . ");

            };

        ");

    }



    if (!defined('MAP_GOOGLE_INIT')) {

        $js = '

                    var gmaps = {};

                    function gmap_render(id, zoom, type)

                    {

                                        

                        var canvas  = jQuery("#map"+ id +"-canvas");

                        var markers = jQuery("#map"+ id +"-markers");

                        var args    = {

                            zoom        : parseInt(zoom),

                            center      : new google.maps.LatLng(0, 0),

                            mapTypeId   : type,

                            scrollwheel : false,

                            panControl  : false,

                            streetViewControl: false,

                            rotateControl: false,

                            scaleControl: false,

                            mapTypeControlOptions: {

                                mapTypeIds: []

                            },

                            zoomControl: true,

                            zoomControlOptions: {

                                //style: google.maps.ZoomControlStyle.SMALL

                            }

                        };



                        // Create map

                        var map = new google.maps.Map(canvas[0], args);



                        // Add a markers reference

                        map.markers = [];



                        // Add markers

                        index=0;

                        jQuery(markers).find(".marker").each(function() {

                            gmap_addmarker(jQuery(this), map, index);

                            index++;

                        });



                        // Create cluster

                        var markerCluster = new MarkerClusterer(map, map.markers, { 

							imagePath: \'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m\'

						});



                        // Create custom style

                        var styles = [{

                            stylers: [

								{ hue: "#136080" },

								{ lightness: 15 },

                            ]

                        }];

                        //map.setOptions({styles: styles});

                        

                        // Center map

                        gmap_center(map, args.zoom);



                        gmaps[id] = map;

                    }





                    function gmap_addmarker($marker, map, index)

                    {

                        var latlng = new google.maps.LatLng($marker.attr("data-lat"), $marker.attr("data-lng"));

                        //var image = "' . JUri::base() . 'templates/visitnordic/images/pin.png";



                        // Create marker

                        var marker = new google.maps.Marker({

                            position    : latlng,

                            map         : map,

                            //icon        : image

                        });



                        // Add to array

                        map.markers.push(marker);



                        // If marker contains HTML, add it to an infoWindow

                        if ($marker.html())

                        {

                            // jQuery("#listdata").append("<div class=\"linkage\" id=\"p" + index + "\">"+ $marker.html() +"</div>");



                            jQuery(document).on("click", "#p" + index, function() {

                                infowindow.open(map, marker);

                                //setTimeout(function () { infowindow.close(); }, 5000);

                            });



                            var infowindow = new google.maps.InfoWindow({

                                content     : $marker.html(),

                                maxWidth    : 420,

                            });



                            google.maps.event.addListener(marker, "click", function() {

                                infowindow.open( map, marker );

                            });

                        }

                    }





                    function gmap_center(map, zoom)

                    {

                        var bounds = new google.maps.LatLngBounds();



                        // Loop through all markers and create bounds

                        jQuery.each(map.markers, function(i, marker) {

                            var latlng = new google.maps.LatLng(marker.position.lat(), marker.position.lng());

                            bounds.extend(latlng);

                        });



                        // Only 1 marker?

                        if (map.markers.length == 1)

                        {



                            map.setCenter( bounds.getCenter() );

                            map.setZoom(parseInt(zoom));



                        }

                        else

                        {

                            // fit to bounds

                            map.fitBounds( bounds );

                        }

                    }

            ';



        JFactory::getDocument()->addScript('//maps.googleapis.com/maps/api/js??v=3&&amp;key=' . $mapkey, 'text/javascript', true, true);

        JFactory::getDocument()->addScript('https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js', 'text/javascript', true, true);

        JFactory::getDocument()->addScriptDeclaration($js);



        define('MAP_GOOGLE_INIT', 1);

        define('WINDOW_ONLOAD_STACK', 1);

    }

    ?>

<?php endif; ?>

