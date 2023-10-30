<?php

$data = $displayData;

$field = $data->field;
$values = $data->values;
$namekey = $data->namekey;

?>

<dt class="col-sm-4"><?php echo $field->$namekey; ?></dt>
<dd class="col-sm-8">
    <?php if (is_array($values)): ?>

        <ul class="list-unstyled">
            <?php foreach ($values as $value): ?>
                <li>
                    <img src="<?php echo $value->value; ?>" alt="<?php echo $field->$namekey; ?>">
                </li>
            <?php endforeach; ?>
        </ul>

    <?php else: ?>

        <img src="<?php echo $values->value; ?>"/>

    <?php endif; ?>
</dd>


