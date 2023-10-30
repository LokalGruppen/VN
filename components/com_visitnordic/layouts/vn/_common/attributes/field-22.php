<?php

$data = $displayData;

$field = $data->field;
$values = $data->values;
$namekey = $data->namekey;

$path = 'images/cards/hotels/';
$logos = array(
    127 => array('link' => '', 'img' => 'sas-eurobonus.jpg'),
    128 => array('link' => '', 'img' => 'one-world-card.jpg'),
    129 => array('link' => '', 'img' => 'hiltonhonors.jpg'),
    130 => array('link' => '', 'img' => 'mariott-awards.jpg'),
    131 => array('link' => '', 'img' => 'world-leading-hotels.jpg'),
    132 => array('link' => '', 'img' => 'slh-card-small-luxery-hotel.jpg'),
    133 => array('link' => '', 'img' => 'spg-card.jpg'),
    135 => array('link' => '', 'img' => 'gha-discovery.jpg'),
    136 => array('link' => '', 'img' => 'best-western.jpg'),
    506 => array('link' => '', 'img' => 'nordic-choice-club.jpg'),
    507 => array('link' => '', 'img' => 'worldhotels-club.jpg'),
    508 => array('link' => '', 'img' => 'club-carlson-card.jpg'),
    509 => array('link' => '', 'img' => 'epoque-hotels-member.jpg'),
    510 => array('link' => '', 'img' => 'ihg-rewards-club.jpg'),
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
            $html1 .= '<li class="thumbnail"><a href="' . $link . '" target="_blank" title="' . $value->$namekey . '">';
            $html1 .= '<img src="' . $cache . '" alt="' . $value->$namekey . '" title="' . $value->$namekey . '" style="max-width:250px;"> ';
            $html1 .= '</a></li>';
        } else {
            $html1 .= '<li class="thumbnail" ><img src="' . $cache . '" alt="' . $value->$namekey . '" title="' . $value->$namekey . '" style="max-width:250px;"></li>';
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

<dt class="col-sm-4"><?php echo $field->$namekey; ?></dt>
<dd class="col-sm-8">
    <ul class="list-unstyled">
        <?php if (!empty($html1)): ?>
            <?php echo $html1; ?>
        <?php endif; ?>

        <?php if (!empty($html2)): ?>
            <?php echo $html2; ?>
        <?php endif; ?>
    </ul>
</dd>