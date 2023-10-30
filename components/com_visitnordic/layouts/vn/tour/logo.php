<?php

$item = $displayData;

?>

<?php if (!empty($item->logo)): ?>


    <?php $title = (!empty($item->company) ? $item->company : $item->title); ?>

    <?php if (!empty($item->homepage)): ?>
        <a href="<?php echo $item->homepage; ?>" target="_blank" title="<?php echo $title; ?>">
    <?php endif; ?>

    <?php $cache = VNHTMLHelper::getResizedImage($item->logo, 300);
    $cache = $item->logo;
    ?>
    <img src="<?php echo $cache; ?>" alt="<?php echo $title; ?>" class="img-fluid tourlogo mb-3"
         title="<?php echo $title; ?>"/>

    <?php if (!empty($item->homepage)): ?>
        </a>
    <?php endif; ?>

<?php endif; ?>
