<?php

$html = $displayData;

?>

<?php if (!empty($html)): ?>
    <?php echo JHtml::_('content.prepare', $html); ?>
<?php endif; ?>
