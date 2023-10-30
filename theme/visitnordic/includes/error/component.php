<?php $app = JFactory::getApplication(); ?>

<div class="error well">

    <i class="fa big fa-globe"></i>

    <div class="message">
        <h1 class="page-header"><?php echo JText::_('JERROR_LAYOUT_PAGE_NOT_FOUND'); ?></h1>

        <p><strong><?php echo JText::_('JERROR_LAYOUT_ERROR_HAS_OCCURRED_WHILE_PROCESSING_YOUR_REQUEST'); ?></strong></p>

        <p><?php echo JText::_('JERROR_LAYOUT_NOT_ABLE_TO_VISIT'); ?></p>

        <ul>
            <li><?php echo JText::_('JERROR_LAYOUT_AN_OUT_OF_DATE_BOOKMARK_FAVOURITE'); ?></li>
            <li><?php echo JText::_('JERROR_LAYOUT_MIS_TYPED_ADDRESS'); ?></li>
            <li><?php echo JText::_('JERROR_LAYOUT_SEARCH_ENGINE_OUT_OF_DATE_LISTING'); ?></li>
            <li><?php echo JText::_('JERROR_LAYOUT_YOU_HAVE_NO_ACCESS_TO_THIS_PAGE'); ?></li>
        </ul>

        <p><?php echo JText::_('JERROR_LAYOUT_PLEASE_CONTACT_THE_SYSTEM_ADMINISTRATOR'); ?></p>

		<?php if ($this->document->debug) : ?>
			<blockquote>
				<span class="label label-inverse"><?php echo $this->error->getCode(); ?></span> <?php echo htmlspecialchars($this->error->getMessage(), ENT_QUOTES, 'UTF-8');?>
			</blockquote>
		<?php endif; ?>

        <p>
            <!-- <?php echo JText::_('JERROR_LAYOUT_GO_TO_THE_HOME_PAGE'); ?> -->
            <a class="btn btn-warning btn-lg" href="<?php echo JUri::base(true); ?>" title="<?php echo JText::_('HOME'); ?>"><span class="fa fa-home"></span> <?php echo JText::_('JERROR_LAYOUT_HOME_PAGE'); ?></a>
        </p>
    </div>

    <?php if ($this->document->debug) : ?>
        <pre>
            <?php echo $this->document->renderBacktrace(); ?>
        </pre>
    <?php endif; ?>

</div>
