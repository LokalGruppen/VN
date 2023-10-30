<?php

$collection = $displayData;

?>

<?php if ($collection && (int) $collection->state == 1): ?>

    <?php
    $collection->header_size = 3;

    $layout = new JLayoutFile('vn.common.collection.items', null, array('main_content' => false));
    echo $layout->render($collection);
    ?>

<?php endif; ?>

