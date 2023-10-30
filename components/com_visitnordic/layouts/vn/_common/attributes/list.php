<?php

$data = $displayData;

$field = $data->field;
$values = $data->values;
$namekey = $data->namekey;

?>

<dt class="col-sm-4"><?php echo $field->$namekey; ?></dt>
<dd class="col-sm-8">
    <ul class="list-unstyled">
        <?php foreach ($values as $value): ?>

            <?php
            echo '<li>' . $value->$namekey . '</li>';
            ?>
        <?php endforeach; ?>
    </ul>
</dd>
