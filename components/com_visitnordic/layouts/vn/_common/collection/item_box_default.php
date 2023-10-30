<?php

$item = $displayData;

$title = $item->title;
$title2 = '';
$title3 = '';
$text = VNHTMLHelper::truncate($item->text, 600, '...', '<br>');
$link = $item->link;
$info = $item->linktext;
$image = VNHTMLHelper::getResizedImage($item->image, 512, 512);

$namekey = VNAttributes::getNameField();

if ($item->data_type == 'tour') {
    $info1 = $info2 = $info3 = '';

    $values = VNAttributes::getValues($item->data_type, $item->data_id);

    $seasons = VNAttributes::extractValue($values, 56);
    if ($seasons) {
        $info1 .= '<i class="material-icons mr-1">date_range</i>';
        foreach ($seasons as $season) {
            $info1 .= '<span>' . $season->value . '</span>';
        }
    }

    $durations = VNAttributes::extractValue($values, 66);
    if ($durations) {
        $info2 .= '<i class="material-icons mr-1">schedule</i>';
        foreach ($durations as $duration) {
            $info2 .= $duration->value;
        }
    }

    $pricepp = VNAttributes::extractValue($values, 39);
    if ($pricepp) {
        $price = (int) $pricepp[0]->value;
        if ($price) {
            $info3 .= '<span class="pricepp">' . JText::sprintf('COM_VISITNORDIC_TOUR_PRICE_BOX', $price) . '</span>';
        }
    }

    $info = '<div class="row no-gutters small">';
    $info .= '<div class="col">' . $info1 . '</div>';
    $info .= ($durations ? '<div class="col text-center">' . $info2 . '</div>' : '');
    $info .= '<div class="col text-right">' . $info3 . '</div>';
    $info .= '</div>';
} else if ($item->data_type == 'hotel') {
    $values = VNAttributes::getValues($item->data_type, $item->data_id);

    $info1 = $info2 = $info3 = '';

    $rating = VNAttributes::extractValue($values, 16);
    if ($rating) {
        // Convert title text to rating
        $count = intval($rating[0]->title);
        $info1 .= str_repeat('<i class="material-icons">star</i>', $count);
    }

    $listprice = VNAttributes::extractValue($values, 70);
    $listprice = @$listprice[0]->value;
    $pricefrom = VNAttributes::extractValue($values, 50);
    $pricefrom = @$pricefrom[0]->value;
    $info2 = ($listprice ? $listprice : ($pricefrom ? JText::sprintf('COM_VISITNORDIC_HOTEL_PRICEFROM', $pricefrom) : false));

    if ($info1 || $info2) {
        $info = '<div class="row no-gutters">';
        $info .= '<div class="col">' . $info1 . '</div>';
        $info .= '<div class="col text-right">' . $info2 . '</div>';
        $info .= '</div>';
    }
}

?>
<!-- card-hover efter $text ? '    ' : '';  -->
<?php if ($link): ?>
        <a href="<?php echo $link; ?>" title="<?php echo $title; ?>" style="position:relative;">
<div class="card card-inverse<?php echo $text ? '' : ''; ?> mb-3">
            <?php if ($image): ?>
                <img class="card-img img-fluid" src="<?php echo $image; ?>" alt="<?php echo $title; ?>"/>
            <?php endif; ?>
            <div class="cover w-100 h-100" style="position:absolute;top:0;background:rgba(0,0,0,.0);"></div>
        
    <?php endif; ?>

    <?php if ($title): ?>
        <a href="<?php echo $link; ?>" title="<?php echo $title; ?>" style="position:relative;">
        <div class="card-img-overlay-footer">
            <h3 class="card-title h4">
                <?php if ($link): ?>
                    <a href="<?php echo $link; ?>" title="<?php echo $title; ?>">
                        <?php echo $title; ?>
                    </a>
                <?php else: ?>
                    <?php echo $title; ?>
                <?php endif; ?>
                <?php if ($title2): ?>
                    <small> / <?php echo $title2; ?></small>
                <?php endif; ?>
            </h3>

            <?php if ($info): ?>
                <hr class="my-3" style="background-color:#fff;">
                <?php echo $info; ?>
            <?php endif; ?>
        </div>
            </a>
    <?php endif; ?>

    <?php if ($text): ?>
        <div class="card-img-overlay-footer">
            <h3 class="card-title h4">
                <?php if ($link): ?>
                    <a href="<?php echo $link; ?>" title="<?php echo $title; ?>">
                        <?php echo $title; ?>
                    </a>
                <?php else: ?>
                    <?php echo $title; ?>
                <?php endif; ?>
                <?php if ($title2): ?>
                    <small> / <?php echo $title2; ?></small>
                <?php endif; ?>
            </h3>

            <?php if ($info): ?>
                <hr class="my-3" style="background-color:#fff;">
                <?php echo $info; ?>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    </a>
</div>
