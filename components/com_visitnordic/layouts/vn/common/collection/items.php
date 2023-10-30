<?php

$item = $displayData;

$cols = (int) $item->item_columns;
$limit = (int) $item->item_limit;
$tmpl = $item->item_layout;

// Sanitize variables or set defaults
{
    if ($cols < 1 || $cols > 12) {
        $cols = 3;
    }

    if ($limit < 1 || $limit > 999) {
        $limit = 9;
    }

    if (!in_array($tmpl, array('list', 'box'))) {
        $tmpl = 'box';
    }
}

// Calculate needed span value
$cols = ($cols > 0 ? $cols : 3);
$span = floor(12 / $cols);

// Set layout
$layout = new JLayoutFile('vn.common.collection.item_' . $tmpl . '_default', null, array('main_content' => $this->options->get('main_content', false)));

// Override lists
if ($tmpl == 'list') {
    $span = 12;
}
?>
<?php if (count($item->items)): ?>
    <article><center>
    <?php if (!empty($item->item_title) || !empty($item->intro_title)): ?>

        <?php $headerSize = (int) (isset($item->header_size) ? $item->header_size : ($this->options->get('main_content', true) && !defined('H1_USED') ? 1 : 2)); ?>

        <h<?php echo $headerSize; ?>><?php echo (!empty($item->item_title) ? $item->item_title : $item->title); ?></h<?php echo $headerSize; ?>>

        <?php if(!defined('H1_USED') && $headerSize == 1) define('H1_USED', true); ?>

    <?php endif; ?>
    </center>
    <?php if (!empty($item->item_description)): ?>
        <p class="description"><?php echo $item->item_description; ?></p>
    <?php endif; ?>

    <?php if(!$this->options->get('main_content', false) && $tmpl == 'list'): ?>
    <div class="card mb-3">
        <div class="card-body">
        <?php endif; ?>

        <div class="row">
            <?php
            $i = 0;
            $false = '';
            ?>

            <?php foreach ($item->items as $entry): ?>

                <?php $i++; ?>

                <div class="col-12<?php echo($span < 12 ? ' col-sm-6 col-lg-' . $span : ''); ?> <?php echo $entry->data_type; ?> <?php echo $i > $limit ? 'readon" style="display:none;' : ''; ?>">
                    <?php echo $layout->render($entry); ?>
                </div>

            <?php endforeach; ?>
            </div>

        <?php if ($i > $limit): ?>
            <button class="btn btn-outline-primary btn-sm btn-block btn-more" data-count="<?php echo $limit; ?>"><?php echo JText::_('COM_VISITNORDIC_COMMON_SEEMORE'); ?></button>
        <?php endif; ?>

        <?php if(!$this->options->get('main_content', false) && $tmpl == 'list'): ?>
        </div>
    </div>
    <?php endif; ?>
    </article>
<?php endif; ?>