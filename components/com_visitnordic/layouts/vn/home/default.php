<?php
$view = $displayData;
$layout = new JLayoutFile('vn.home.module');

// Render rightside to figure out if there are any modules
ob_start();
echo $layout->render('frontpage-right');
$aside = ob_get_clean();

// Render component area to figure out if there are any modules
ob_start();
echo $layout->render('frontpage');
$component = ob_get_clean();

// Could be bogus content - Trim them!
$aside = trim($aside);
$component = trim($component);
?>

<div class="row">
    <div class="<?php echo $aside ? 'col-md-9' : 'col-md-12'; ?>">
        <?php echo $component; ?>
    </div>
    <?php if ($aside): ?>
        <div class="col-md-3 side">
            <?php echo $buffer; ?>
        </div>
    <?php endif; ?>
</div>
