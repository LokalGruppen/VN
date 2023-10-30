<?php
/**
 * @version     1.0.0
 * @package     com_visitnordic
 * @copyright   Copyright (C) 2015. Alle rettigheder forbeholdes.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      CGOnline.dk <info@cgonline.dk> - http://www.cgonline.dk
 */

// no direct access
defined('_JEXEC') or die;

?>

<?php if ($this->item) : ?>

    <?php
    $layout = new JLayoutFile('vn.tour.default');
    echo $layout->render($this->item);
    ?>

<?php else: ?>

    <p><?php echo JText::_('COM_VISITNORDIC_ITEM_NOT_LOADED'); ?></p>

<?php endif; ?>