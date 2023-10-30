<?php

$item = $displayData;

?>

<!-- TODO: Why is active class bugging? -->
<ul class="nav nav-tabs card-header-tabs" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" href="#overview" role="tab"
           data-toggle="tab"><?php echo JText::_('COM_VISITNORDIC_COMMON_TAB_OVERVIEW'); ?></a>
    </li>
    <?php if ($item->lattitude && $item->longitude): ?>
        <li class="nav-item">
            <a class="nav-link" href="#maproute" role="tab"
               data-toggle="tab"><?php echo JText::_('COM_VISITNORDIC_COMMON_TAB_MAP2'); ?></a>
        </li>
    <?php endif; ?>
    <li id="tab-facilities" class="nav-item">
        <a class="nav-link" href="#goodtoknow" role="tab"
           data-toggle="tab"><?php echo JText::_('COM_VISITNORDIC_COMMON_TAB_GOODTOKNOW'); ?></a>
    </li>
</ul>
