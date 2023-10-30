<?php

$item = $displayData;

// Show aside?
$aside = false;

// Render rightside to figure out which width to use
if ($item->aside_box) {
    $layout = new JLayoutFile('vn.attraction.aside');
    $buffer = $layout->render($item);
    $buffer = trim($buffer);

    if (!empty($buffer)) {
        $aside = true;
    }
}

?>


<div class="row">

    <div class="<?php echo $aside ? 'col-md-9' : 'col-md-12'; ?>">

        <?php if ($item->intromedia): ?>
            <?php
            $layout = new JLayoutFile('vn.common.mediabox');
            echo $layout->render($item);
            ?>
        <?php endif; ?>

        <div class="card mb-3">
            <div class="card-header">
                <?php
                $layout = new JLayoutFile('vn.attraction.tabs');
                echo $layout->render($item);
                ?>
            </div>

            <div class="card-body">
                <div class="tab-content py-3">

                    <?php
                    $layout = new JLayoutFile('vn.attraction.tab1');
                    echo $layout->render($item);
                    ?>

                    <?php
                    $layout = new JLayoutFile('vn.attraction.tab2');
                    echo $layout->render($item);
                    ?>

                    <?php
                    $layout = new JLayoutFile('vn.attraction.tab3');
                    echo $layout->render($item);
                    ?>
                </div>
            </div>
        </div>

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