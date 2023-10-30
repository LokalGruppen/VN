<?php

$item = $displayData;

$header = (int) @$item->header;
$header = ($header ? $header : 3);

$id = uniqid();
?>

<?php if(isset($item->rollout)): ?>
<div id="accordion-<?php echo $id; ?>" role="tablist" aria-multiselectable="true">
    <div class="card">
        <div class="card-header" role="tab" id="heading-<?php echo $id; ?>">
<?php endif; ?>

    <?php if (!empty($item->title)): ?>
        <h<?php echo $header; ?> class="<?php echo(isset($item->rollout) ? 'm-0 h5' : ''); ?>">

            <?php if(isset($item->rollout)): ?>
            <a data-toggle="collapse" data-parent="#accordion-<?php echo $id; ?>" href="#collapse-<?php echo $id; ?>" aria-expanded="true" aria-controls="collapse-<?php echo $id; ?>">
            <?php endif; ?>

            <?php echo JHtml::_('content.prepare', $item->title); ?>

            <?php if(isset($item->rollout)): ?>
            </a>
            <?php endif; ?>

        </h<?php echo $header; ?>>
    <?php endif; ?>

    <?php if(isset($item->rollout)): ?>
        </div>
    <?php endif; ?>

<?php if (!empty($item->text)): ?>

<div id="collapse-<?php echo $id; ?>" class="<?php echo (isset($item->rollout) ? 'collapse ' : '').(isset($item->class) ? $item->class. ' ' : ''); ?>mb-3">

    <?php if(isset($item->rollout)): ?>
        <div class="card-body">
    <?php endif; ?>

    <?php if (isset($item->description) && !empty($item->description)): ?>
            <p style="color:#444;">
                <strong>
            <?php echo JHtml::_('content.prepare', nl2br($item->description)); ?>
                </strong>
            </p>
    <?php endif; ?>

    <?php if (!empty($item->text)): ?>
        <?php echo JHtml::_('content.prepare', $item->text); ?>
    <?php endif; ?>

    <?php if(isset($item->rollout)): ?>
        </div>
    <?php endif; ?>



</div>

    <?php endif; ?>

<?php if(isset($item->rollout)): ?>
    </div>
</div>
<?php endif; ?>