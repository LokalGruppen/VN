<?php

$item = $displayData;

?>

<ul class="nav nav-tabs card-header-tabs" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" href="#introduction" role="tab"
           data-toggle="tab"><?php echo JText::_('COM_VISITNORDIC_COMMON_TAB_INTRODUCTION'); ?></a>
    </li>
    <?php if ($item->lattitude && $item->longitude): ?>
        <li class="nav-item">
            <a class="nav-link" href="#maproute" role="tab"
               data-toggle="tab"><?php echo JText::_('COM_VISITNORDIC_COMMON_TAB_MAP'); ?></a>
        </li>
    <?php endif; ?>
    <li id="tab-facilities" class="nav-item">
        <a class="nav-link" href="#facilities" role="tab"
           data-toggle="tab"><?php echo JText::_('COM_VISITNORDIC_COMMON_TAB_FACILITIES'); ?></a>
    </li>
</ul>