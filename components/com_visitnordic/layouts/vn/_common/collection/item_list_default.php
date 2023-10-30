<?php

$item = $displayData;

$title = $item->title;
$title2 = '';
$title3 = '';
$right = '';
$text = VNHTMLHelper::truncate($item->text, $this->options->get('main_content') ? 600 : 80, '...', '<br>');
$link = $item->link;
$info = $item->linktext;
$image = VNHTMLHelper::getResizedImage($item->image, 512, 512);

$namekey = VNAttributes::getNameField();
if ($item->data_type == 'tour') {
    $info1 = $info2 = $info3 = '';
    $box1 = $box2 = $box3 = '';

    $values = VNAttributes::getValues($item->data_type, $item->data_id);

    $tourtypes = VNAttributes::extractValue($values, 46);
    if ($tourtypes) {
        $title3 .= JText::_('COM_VISITNORDIC_TOUR_TYPE') . ': ';
        foreach ($tourtypes as $tourtype) {
            $title3 .= '<span>' . $tourtype->$namekey . '</span>';
        }
    }

    $pricepp = VNAttributes::extractValue($values, 39);
    if ($pricepp) {
        $box1 .= '<span class="h5 text-success text-right">' . JText::sprintf('COM_VISITNORDIC_TOUR_PRICE_LIST', $pricepp[0]->value) . '</span>';
    }

    if ($item->logo) {
        $logo = VNHTMLHelper::getResizedImage($item->logo, 256, 128);
        $box2 .= '<img src="' . ($logo ? $logo : $item->logo) . '" alt="' . $item->title . '" class="img-fluid my-3">';
    }

    $box3 .= '<span style="font-size:1rem!important;" class="btn btn-success btn-block btn-lg mt-auto">' . JText::_('COM_VISITNORDIC_TOUR_VIEWOFFER') . '</span>';

    $seasons = VNAttributes::extractValue($values, 56);
    if ($seasons) {
        $info1 .= '<i class="material-icons mr-1">date_range</i>';
        foreach ($seasons as $season) {
            $info1 .= $season->value;
        }
    }

    $durations = VNAttributes::extractValue($values, 66);
    if ($durations) {
        $info2 .= '<i class="material-icons mr-1">schedule</i>';
        foreach ($durations as $duration) {
            $info2 .= $duration->value;
        }
    }

    $services = VNAttributes::extractValue($values, 55);
    $included = false;
    if ($services) {
        foreach ($services as $service) {
            if ($service->attribute_id == 298) {

            }
            $included = $service->$namekey;

            $info3 .= '<i class="material-icons mr-1">flight_takeoff</i>';
            $info3 .= $included;
        }
    }

    $info = '<div class="row no-gutters small">';
    $info .= '<div class="col">' . $info1 . '</div>';
    $info .= '<div class="col text-center">' . $info2 . '</div>';
    $info .= '<div class="col text-right">' . $info3 . '</div>';
    $info .= '</div>';

    $right .= $box1;
    $right .= $box2;
    $right .= $box3;
} else if ($item->data_type == 'hotel') {
    $values = VNAttributes::getValues($item->data_type, $item->data_id);

    $info1 = $info2 = $info3 = '';
    /* NY */
    $box1 = $box2 = $box3 = '';
    $pricepp = VNAttributes::extractValue($values, 39);
    if ($pricepp) {
        $box1 .= '<span class="h5 text-success text-right">' . JText::sprintf('COM_VISITNORDIC_HOTEL_TOUR_LIST', $pricepp[0]->value) . '</span>';
    }

    if ($item->logo) {
        $logo = VNHTMLHelper::getResizedImage($item->logo, 256, 128);
        $box2 .= '<img src="' . ($logo ? $logo : $item->logo) . '" alt="' . $item->title . '" class="img-fluid my-3">';
    }

    $box3 .= '<span style="font-size:1rem!important;" class="btn btn-success btn-block btn-lg mt-auto">'. JText::sprintf('COM_VISITNORDIC_TOUR_LINK_BOOK_2020').'</span>';
     $right .= $box1;
    $right .= $box2;
    $right .= $box3;
/* NY SLUT */
    $rating = VNAttributes::extractValue($values, 16);
    if ($rating) {
        // Convert title text to rating
        $count = intval($rating[0]->title);
        $info1 .= '<i class="material-icons">';
        $info1 .= '' . str_repeat('star ', $count) . '';
        $info1 .= '</i>';
    }

    $listprice = VNAttributes::extractValue($values, 70);
    $listprice = @$listprice[0]->value;
    $pricefrom = VNAttributes::extractValue($values, 50);
    $pricefrom = @$pricefrom[0]->value;
    $tmp = ($listprice ? $listprice : ($pricefrom ? JText::sprintf('COM_VISITNORDIC_HOTEL_PRICEFROM', $pricefrom) : false));

    if ($tmp) {
        $info2 .= '<span class="pricefrom"> ';
        $info2 .= '<span>' . $tmp . '</span>';
        $info2 .= '</span>';
    }

    if ($info1 || $info2) {
        $info = '<div class="row">';
        $info .= '<div class="col-md-3">' . $info1 . '</div>';
        $info .= '<div class="col-md-3">' . $info2 . '</div>';
        $info .= '</div>';
    }
}

?>

<a href="<?php echo $link; ?>"<?php echo $this->options->get('main_content') ? ' class="list"' : ''; ?>>
    <div class="row py-3">
        <div class="col-12 col-md-6 <?php echo $this->options->get('main_content') ? 'col-lg-3' : 'col-lg-5'; ?>">
            <?php if ($image): ?>
                <img class="img-fluid" src="<?php echo $image; ?>" alt="<?php echo $title; ?>">
            <?php endif; ?>
        </div>
        <div class="d-flex flex-column col-12 col-md-6 <?php echo $this->options->get('main_content') ? !$right ? 'col-lg-6' : 'col-lg-6' : 'col-lg-7 pl-lg-3 my-sm-2'; ?>">

            <?php echo $this->options->get('main_content') ? '<h4>'.$title.'</h4>' : '<h5 class="h6">'.$title.'</h5>'; ?>

            <?php if ($text): ?>
                <p class="<?php echo $this->options->get('main_content') ? 'mb-auto' : 'text-muted small m-0 d-none d-lg-block'; ?>"><?php echo $text; ?></p>
                <?php if ($info && $this->options->get('main_content')): ?>
                    <hr class="my-2">
                    <div class="text-muted align-bottom">
                        <?php echo $info; ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <?php if ($right && $this->options->get('main_content')): ?>
        <div class="col-12 col-md-12 col-lg-3 d-flex flex-column">
            <?php echo $right; ?>
        </div>
        <?php endif; ?>
    </div>
</a>
<hr>