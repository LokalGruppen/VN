<?php

$data = $displayData;

$field = $data->field;
$values = $data->values;
$namekey = $data->namekey;

$path = 'images/cards/offers/';
$logos = array(
    69 => array('link' => '', 'img' => 'copenhagen-card.jpg'),
    242 => array('link' => '', 'img' => 'aarhus-card.jpg'),
    244 => array('link' => '', 'img' => 'odense-city-pas.jpg'),
    246 => array('link' => '', 'img' => 'stockholm-card.jpg'),
    247 => array('link' => '', 'img' => 'goteborg-card.jpg'),
    248 => array('link' => '', 'img' => 'oslopass.jpg'),
    249 => array('link' => '', 'img' => 'bergen-card.jpg'),
    250 => array('link' => '', 'img' => 'helsinki-card.jpg'),
    251 => array('link' => '', 'img' => 'reykjavik-card.jpg'),
);

$html1 = '';
$html2 = '';

foreach ($values as $value) {
    $link = (isset($logos[$value->attribute_id]) && !empty($logos[$value->attribute_id]['link']) ? $logos[$value->attribute_id]['link'] : '');
    $image = (isset($logos[$value->attribute_id]) && !empty($logos[$value->attribute_id]['img']) ? $logos[$value->attribute_id]['img'] : '');

    if ($image) {
        //$cache = VNHTMLHelper::getResizedImage($path . $image, 256, 256);
        $cache = $path . $image;

        if ($link) {
            $html1 .= '<li><a href="' . $link . '" target="_blank" title="' . $value->$namekey . '">';
            $html1 .= '<img src="' . $cache . '" alt="' . $value->$namekey . '" title="' . $value->$namekey . '"> ';
            $html1 .= '</a></li>';
        } else {
            $html1 .= '<li class="col-xs-12 col-lg-6"><img src="' . $cache . '" alt="' . $value->$namekey . '" title="' . $value->$namekey . '" class="img-fluid"  ></li>';
        }
    } else {
        if ($link) {
            $html2 .= '<li><a href="' . $link . '" target="_blank" title="' . $value->$namekey . '">';
            $html2 .= $value->$namekey;
            $html2 .= '</a></li>';
        } else {
            $html2 .= '<li>' . $value->$namekey . '</li>';
        }
    }
}

?>

<p class="h4"><?php echo $field->$namekey; ?></p>
<ul class="list-unstyled row">
    <?php if (!empty($html1)): ?>
        <?php echo $html1; ?>
    <?php endif; ?>
    <?php if (!empty($html2)): ?>
        <?php echo $html2; ?>
    <?php endif; ?>
</ul>