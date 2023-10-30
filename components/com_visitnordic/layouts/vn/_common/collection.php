<?php

$item = $displayData;

?>

<?php if (count($item->items)): ?>

    <div class="card mb-3">
        <div class="card-body">
            <?php
            $layout = new JLayoutFile('vn.common.collection.items', null, array('main_content' => true));
            echo $layout->render($item);
            ?>
        </div>
    </div>

<?php endif; ?>