<?php

$item = $displayData;

?>

<?php if ($item->intro_title || $item->intro_text): ?>

    <article class="card mb-3">
        <div class="card-body">

            <?php
            $text = new stdClass();

            $text->header = '1';
            $text->class = 'content';
            $text->title = $item->intro_title;
            $text->description = $item->intro_description;
            $text->text = $item->intro_text;

            $layout = new JLayoutFile('vn.common.text');
            echo $layout->render($text);
            ?>
        </div>
    </article>

<?php endif; ?>

