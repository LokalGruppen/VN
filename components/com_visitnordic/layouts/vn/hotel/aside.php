<?php

$item = $displayData;

$order = trim($item->aside_ordering);
$order = explode(',', $order);

?>

<?php foreach ($order as $idx): ?>

    <?php
    $layout = new JLayoutFile('vn.hotel.aside.block' . (int) $idx);
    echo $layout->render($item);
    ?>

<?php endforeach; ?>