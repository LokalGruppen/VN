<?php

$item = $displayData;

?>


<?php if (count($item->speaking)): ?>

    <dt class="col-sm-4"><?php echo JText::_('COM_VISITNORDIC_COMMON_SPOKENLANGUAGES_TITLE'); ?></dt>
    <dd class="col-sm-8">
        <ul class="list-unstyled">
            <?php foreach ($item->speaking as $tag): ?>
                <li><?php echo JText::_('COM_VISITNORDIC_OPTION_SPEAKING_' . strtoupper($tag)); ?></li>
            <?php endforeach; ?>
        </ul>
    </dd>

<?php endif; ?>
