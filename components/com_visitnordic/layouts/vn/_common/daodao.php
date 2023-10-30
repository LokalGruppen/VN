<?php

$item = $displayData;

$data = new stdClass();
$data->title = '';
$data->text = $item->daodao;

?>

<?php if (!empty($item->daodao)): ?>
    <?php
    $layout = new JLayoutFile('vn.common.text');
    echo $layout->render($data);
    ?>
<?php endif; ?>


