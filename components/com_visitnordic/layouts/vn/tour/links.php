<?php

$item = $displayData;

$links = VNHTMLHelper::repeatableToArray($item->links);
$links = VNHTMLHelper::cleanLinks($links);

?>

<?php if (count($links)): ?>

    <h4 class="mb-3"><?php echo JText::_('COM_VISITNORDIC_COMMON_LINKS_TITLE'); ?></h4>

    <ul class="list-unstyled">
        <?php foreach ($links as $link): ?>
            <?php if (!empty($link->href)): ?>
                <li>
                    <a href="<?php echo $link->href; ?>"
                       target="<?php echo $link->target; ?>"><?php echo(!empty($link->text) ? $link->text : $link->href); ?></a>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>

<?php endif; ?>
