<?php

$item = $displayData;

$type = (int) isset($item->intromedia) ? $item->intromedia : $item->image_type;

$images = VNHTMLHelper::repeatableToArray(isset($item->intromedia) ? $item->images : $item->image_list);
$images = VNHTMLHelper::cleanImages($images);

$videos = VNHTMLHelper::repeatableToArray(isset($item->intromedia) ? $item->videos : $item->video_list);
$videos = VNHTMLHelper::cleanVideos($videos);

?>

<?php if ($type == 1 && count($images)): /* First image */ ?>

    <?php
    $layout = new JLayoutFile('vn.common.image');
    echo $layout->render($images[0]);
    ?>

<?php elseif ($type == 2 && (count($images) || count($videos))): /* Slideshow */ ?>

    <?php
    $layout = new JLayoutFile('vn.common.slideshow');
    echo $layout->render(array_merge($images, $videos));
    ?>

<?php elseif ($type == 3 && count($videos)): /* Videos */ ?>

    <?php
    $layout = new JLayoutFile('vn.common.slideshow');
    echo $layout->render($videos);
    ?>

<?php endif; ?>
