<?php

$item = $displayData;

// Show aside?
$aside = false;

// Render rightside to figure out which width to use
$buffer = '';

if (!isset($item->skipAddress) || !$item->skipAddress) {
    $layout = new JLayoutFile('vn.common.blocks.address');
    $buffer .= $layout->render($item);
}

if (!isset($item->skipTripadvisor) || !$item->skipTripadvisor) {
    $layout = new JLayoutFile('vn.common.tripadvisor');
    $buffer .= $layout->render($item);

    $layout = new JLayoutFile('vn.common.blocks.daodao');
    $buffer .= $layout->render($item);
}

if (!isset($item->skipLinks) || !$item->skipLinks) {
    $links = VNHTMLHelper::repeatableToArray($item->links);
    $links = VNHTMLHelper::cleanLinks($links);
    $layout = new JLayoutFile('vn.common.blocks.link');
    $buffer .= $layout->render($links);
}

$buffer = trim($buffer);

if (!empty($buffer)) {
    $aside = true;
}

?>

<div class="tab-pane active" id="introduction" role="tabpanel">

    <div class="row">

        <div class="<?php echo $aside ? 'col-md-8' : 'col-md-12'; ?>">

            <?php
            $text = $item;
            $text->header = '1';
            $text->class = 'content';
            $layout = new JLayoutFile('vn.common.text');
            echo $layout->render($text);
            ?>

            <?php
            $layout = new JLayoutFile('vn.common.openinghours');
            echo $layout->render($item);
            ?>

            <?php
            $layout = new JLayoutFile('vn.restaurant.book');
            echo $layout->render($item);
            ?>

            <div class="addthis_inline_share_toolbox mt-3"></div>

        </div>

        <?php if ($aside): ?>
            <div class="col-md-4 small">
                <?php echo $buffer; ?>
            </div>
        <?php endif; ?>

    </div>

</div>