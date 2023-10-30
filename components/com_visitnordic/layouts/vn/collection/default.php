<?php

$item = $displayData;

// Show aside?
$aside = false;

// Render rightside to figure out which width to use
if ($item->aside_box) {
    $layout = new JLayoutFile('vn.collection.aside');
    $buffer = $layout->render($item);
    $buffer = trim($buffer);

    if (!empty($buffer)) {
        $aside = true;
    }
}

$content1 = '';
if ($item->content_module1) {
    $layout = new JLayoutFile('vn.common.blocks.html');
    $content1 = $layout->render($item->content_module1);
}

$content2 = '';
if ($item->content_module2) {
    $layout = new JLayoutFile('vn.common.blocks.html');
    $content2 = $layout->render($item->content_module2);
}

$content3 = '';
if ($item->content_module3) {
    $layout = new JLayoutFile('vn.common.blocks.html');
    $content3 = $layout->render($item->content_module3);
}

$content4 = '';
if ($item->content_module4) {
    $layout = new JLayoutFile('vn.common.blocks.html');
    $content4 = $layout->render($item->content_module4);
}

?>


<div class="row">

    <div class="<?php echo $aside ? 'col-md-9' : 'col-md-12'; ?>">

        <?php if ($item->content_module1): ?>
            <?php
            $layout = new JLayoutFile('vn.common.blocks.module');
            echo $layout->render($item->content_module1);
            ?>
        <?php endif; ?>

        <?php if ($item->image_box): ?>
            <?php
            $layout = new JLayoutFile('vn.common.mediabox');
            echo $layout->render($item);
            ?>
        <?php endif; ?>

        <?php if ($item->content_module2): ?>
            <?php
            $layout = new JLayoutFile('vn.common.blocks.module');
            echo $layout->render($item->content_module2);
            ?>
        <?php endif; ?>

        <?php if ($item->intro_box): ?>
            <?php
            $layout = new JLayoutFile('vn.collection.introbox');
            echo $layout->render($item);
            ?>
        <?php endif; ?>

        <?php if ($item->content_module3): ?>
            <?php
            $layout = new JLayoutFile('vn.common.blocks.module');
            echo $layout->render($item->content_module3);
            ?>
        <?php endif; ?>

        <?php if (count($item->items)): ?>
            <?php
            $layout = new JLayoutFile('vn.collection.itemsbox', null, array(
                'main_content' => true
            ));
            echo $layout->render($item);
            ?>
        <?php endif; ?>

        <?php if ($item->content_module4): ?>
            <?php
            $layout = new JLayoutFile('vn.common.blocks.module');
            echo $layout->render($item->content_module4);
            ?>
        <?php endif; ?>

        <?php
        $layout = new JLayoutFile('vn.common.collection_extra_box1');
        echo $layout->render($item);
        ?>

        <?php
        $layout = new JLayoutFile('vn.common.collection_extra_list1');
        echo $layout->render($item);
        ?>

        <?php
        $layout = new JLayoutFile('vn.common.collection_extra_box2');
        echo $layout->render($item);
        ?>

        <?php
        $layout = new JLayoutFile('vn.common.collection_extra_list2');
        echo $layout->render($item);
        ?>

    </div>

    <?php if ($aside): ?>
        <div class="col-md-3 side">
            <?php echo $buffer; ?>
        </div>
    <?php endif; ?>

</div>