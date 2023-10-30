<?php

$item = $displayData;

$data = new stdClass();
$data->title = '';
$data->text = $item->tripadvisor;

?>

<?php if (!empty($item->tripadvisor)): ?>
    <?php
    $layout = new JLayoutFile('vn.common.text');
    echo $layout->render($data);
    ?>
<?php endif; ?>


