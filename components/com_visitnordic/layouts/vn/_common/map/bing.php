<?php

$options = $displayData;

$mapkey = 'Ag0oESqxvOpgWZmlM9Szsg6JXlDqLmUrxz078G3nSDgo9FlKmohJui8uPrW0c-zt';

?>

<?php if (count($options)): ?>

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
    switch ($type) {
        case 'ROADMAP':
            $type = 'road';
            break;
        case 'TERRAIN':
            $type = 'arial';
            break;
        case 'SATELLITE':
            $type = 'birdseye';
            break;
        default:
            $type = 'road';
    }

    // Sanitize input: Zoom
    if ($zoom < 2 || $zoom > 19) {
        $zoom = 8;
    }

    if ($query) {
        $href = 'http://www.bing.com/maps/default.aspx?where1=' . urlencode($query) . '';
    } elseif ($lat && $long) {
        $href = 'http://www.bing.com/maps/?cp=' . urlencode($lat) . '~' . urlencode($long) . '&lvl=' . urlencode($zoom) . '&dir=0&sty=c';
    }

    /*
     * https://alastaira.wordpress.com/2012/06/19/url-parameters-for-the-bing-maps-website/
     *
     * */
    ?>


    <?php if (isset($dir)): ?>
        <p class="map-link pull-right"><a target="_blank"
                                          href="<?php echo $dir; ?>"><?php echo JText::_('COM_VISITNORDIC_MAP_DIRECTIONS_LINK'); ?></a>
        </p>
    <?php endif; ?>

    <?php if ($href || $direction || $coordinate): ?>
        <div class="row extra">
            <?php if ($href): ?>
                <div class="col-sm-12 <?php echo($direction ? '' : 'center'); ?>">
                    <p class="link"><a target="_blank"
                                       href="<?php echo $href; ?>"><?php echo JText::_('COM_VISITNORDIC_MAP_BING_OPEN'); ?></a>
                    </p>
                </div>
            <?php endif; ?>

            <?php if ($direction): ?>
                <div class="col-sm-6 direction">
                    <h3><?php echo JText::_('COM_VISITNORDIC_MAP_DIRECTIONS_TITLE'); ?></h3>
                    <p><?php echo JText::_('COM_VISITNORDIC_MAP_DIRECTIONS_TEXT'); ?></p>
                    <form action="http://www.bing.com/maps/default.aspx" method="get" target="_blank"
                          class="bingdirection">
                        <input type="text" name="from" id="from" class="saddr required"
                               placeholder="<?php echo JText::_('COM_VISITNORDIC_MAP_DIRECTIONS_TIP'); ?>" required/>
                        <input type="hidden" name="to" id="to" value="<?php echo $query; ?>"/>
                        <input type="hidden" name="rtp" id="rtp" value=""/>
                        <input type="submit" value="<?php echo JText::_('COM_VISITNORDIC_MAP_DIRECTIONS_BTN'); ?>"/>
                    </form>
                </div>
            <?php endif; ?>

            <?php if ($coordinate): ?>
                <div class="col-sm-6 coordinates">
                    <h5><?php echo JText::_('COM_VISITNORDIC_MAP_COORDINATES_TITLE'); ?></h5>
                    <ul>
                        <li><?php echo JText::_('COM_VISITNORDIC_MAP_COORDINATES_LATTITUDE'); ?><?php echo $lat; ?></li>
                        <li><?php echo JText::_('COM_VISITNORDIC_MAP_COORDINATES_LONGITUDE'); ?><?php echo $long; ?></li>
                        <li class="d-block d-lg-none d-xl-block"><a href="geo:<?php echo $lat; ?>,<?php echo $long; ?>"><?php echo JText::_('COM_VISITNORDIC_MAP_COORDINATES_LINK'); ?></a>
                        </li>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>


    <?php
    JFactory::getDocument()->addScriptDeclaration("
            window.onload = function(){
                bmap_render('" . $id . "', '" . $zoom . "', Microsoft.Maps.MapTypeId." . $type . ");
            };
        ");

    if (!defined('MAP_BING_INIT')) {
        $js = '
                    var bmaps = {};
                    var bmap_infobox = null;

                    function bmap_render(id, zoom, type)
                    {
                        var canvas  = jQuery("#map"+ id +"-canvas");
                        var markers = jQuery("#map"+ id +"-markers");
                        var args    = {
                            zoom                : parseInt(zoom),
                            credentials         : "' . $mapkey . '",
                            mapTypeId           : type,
                            center              : new Microsoft.Maps.Location(0, 0),
                            disableMouseInput   : false,
                            showDashboard       : false,
                            showScalebar        : false,
                            showMapTypeSelector : false,
                            enableClickableLogo : false,
                            enableSearchLogo    : false
                        };

                        // Create map
                        var map = new Microsoft.Maps.Map(canvas[0], args);


                        // Init infobox
                        bmap_infobox = new Microsoft.Maps.Infobox(new Microsoft.Maps.Location(0,0), {
                            visible: false
                        });
                        map.entities.push(bmap_infobox);


                        // Init markers array
                        map.markers = [];


                        // Add markers
                        index=0;
                        jQuery(markers).find(".marker").each(function() {
                            bmap_addmarker(jQuery(this), map, index, id);
                            index++;
                        });


                        // Create cluster
                        //var pinClusterer = new PinClusterer(map);
                        //pinClusterer.cluster(map.markers);


                        // Center map
                        bmap_center(map, args.zoom);

                        bmaps[id] = map;
                    }


                    function bmap_addmarker($marker, map, index, id)
                    {
                        var latlng = new Microsoft.Maps.Location($marker.attr("data-lat"), $marker.attr("data-lng"));
                        //var image = "' . JUri::base() . 'templates/visitnordic/images/pin.png";

                        // Create marker
                        var pin = new Microsoft.Maps.Pushpin(latlng, {
                            //icon: image,
                        });
                        pin.id = id;

                        // If marker contains HTML, add it to an infoWindow
                        if ($marker.html())
                        {
                            pin.Html =  $marker.html();

                            // Add a handler for the pushpin click event.
                            Microsoft.Maps.Events.addHandler(pin, "click", bmap_displayInfobox);

                            // Hide the info box when the map is moved.
                            //Microsoft.Maps.Events.addHandler(map, "viewchange", bmap_hideInfobox);
                        }

                        // Add to markers array
                        map.markers.push(latlng);

                        // Add to array
                        map.entities.push(pin);
                    }


                    function bmap_displayInfobox(e)
                    {
                        if (e.targetType == "pushpin")
                        {
                            var pin = e.target;
                            var popupHtml = "<div class=\"mappopup\"><span class=\"fa fa-times close\" onclick=\"bmap_hideInfobox()\"></span>{content}</div>";

                            bmap_infobox.setHtmlContent(popupHtml.replace("{content}", pin.Html));

                            bmap_infobox.setOptions({
                            showCloseButton: true,
                                visible:        true,
                                offset:         new Microsoft.Maps.Point(-3, pin.getHeight() - 5)
                            });

                            bmap_infobox.setLocation(e.target.getLocation());
                            bmap_positionInfobox(e, pin.id);
                        }
                    }


                    function bmap_positionInfobox(e, id)
                    {
                        // Min width to boundaries
                        var buffer = 40;
                        var map = bmaps[id];

                        var infoboxOffset = bmap_infobox.getOffset();
                        var infoboxAnchor = bmap_infobox.getAnchor();
                        var infoboxLocation = map.tryLocationToPixel(e.target.getLocation(), Microsoft.Maps.PixelReference.control);

                        var dx = infoboxLocation.x + infoboxOffset.x - infoboxAnchor.x;
                        var dy = infoboxLocation.y - buffer - infoboxAnchor.y;

                        if (dy < buffer) {
                            dy *= -1;
                            dy += buffer;
                        } else {
                            dy = 0;
                        }

                        if (dx < buffer) {
                            dx *= -1;
                            dx += buffer;
                        } else {
                            dx = map.getWidth() - infoboxLocation.x + infoboxAnchor.x - bmap_infobox.getWidth();

                            if (dx > buffer) {
                                dx = 0;
                            } else {
                                dx -= buffer;
                            }
                        }

                        if (dx != 0 || dy != 0) {
                            map.setView({ centerOffset: new Microsoft.Maps.Point(dx, dy), center: map.getCenter() });
                        }
                    }


                    function bmap_hideInfobox()
                    {
                        bmap_infobox.setOptions({ visible: false });
                    }


                    function bmap_center(map, zoom)
                    {
                        // Only 1 marker?
                        if (map.markers.length == 1)
                        {
                            map.setView({
                                center: map.markers[0],
                                zoom: zoom
                            });
                        }
                        else
                        {
                            // fit to bounds
                            var boundaries = Microsoft.Maps.LocationRect.fromLocations(map.markers);
                            map.setView({bounds: boundaries});
                        }
                    }

                    jQuery(document).ready(function($) {
                        $(".bingdirection").submit( function(e) {
                            var rtp = "adr."+ $(".bingdirection #from").val() +"~adr."+ $(".bingdirection #to").val();
                            $(".bingdirection #rtp").val(rtp);
                            return true;
                        });
                    });
            ';

        JFactory::getDocument()->addScriptDeclaration($js);

        // Add Bing Map
        JFactory::getDocument()->addScript('https://ecn.dev.virtualearth.net/mapcontrol/mapcontrol.ashx?v=7.0');

        // Add PinClusterer (https://github.com/rtsinani/PinClusterer)
        //JFactory::getDocument()->addScript('templates/visitnordic/js/pinclusterer.min.js');
        //JFactory::getDocument()->addStyleSheet('templates/visitnordic/css/pinclusterer.css');

        define('MAP_BING_INIT', 1);
    }
    ?>

<?php endif; ?>
