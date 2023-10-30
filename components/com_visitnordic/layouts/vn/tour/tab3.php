<?php

$item = $displayData;

$buffer = '';

$layout = new JLayoutFile('vn.tour.attributes');
$buffer .= $layout->render($item);

$layout = new JLayoutFile('vn.common.speaking');
$buffer .= $layout->render($item);

$buffer = trim($buffer);

?>

<?php if (!empty($buffer)): ?>

    <div class="tab-pane" id="goodtoknow" role="tabpanel">

        <h3 class="mb-3"><?php echo JText::_('COM_VISITNORDIC_COMMON_GOODTOKNOW_TITLE'); ?></h3>
        <dl class="row">
            <?php echo $buffer; ?>
        </dl>
    </div>

<?php else: ?>

    <style type="text/css">
        #tab-facilities {
            display: none;
        }
    </style>

<?php endif; ?>
