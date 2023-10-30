<?php

$links = $displayData;

?>

<?php if (count($links)): ?>

    <div class="card mb-3">
        <div class="card-body">

            <h4><?php echo JText::_('COM_VISITNORDIC_COMMON_LINKS_TITLE'); ?></h4>

            <ul class="list-unstyled m-0">
                <?php foreach ($links as $link): ?>
                    <?php if (!empty($link->href)): ?>
                        <li>
                            <a href="<?php echo $link->href; ?>"
                               target="<?php echo $link->target; ?>"><?php echo(!empty($link->text) ? $link->text : $link->href); ?></a>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>

        </div>
    </div>

<?php endif; ?>
