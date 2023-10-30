<?php

$item = $displayData;

?>

<?php if (count($item->items)): ?>

    <?php
    $mainContent = $this->options->get('main_content', false);

    $layout = new JLayoutFile('vn.common.collection', null, $mainContent ? array('main_content' => true) : null);
    echo $layout->render($item);
    ?>

<?php endif; ?>