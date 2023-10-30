<?php $app = JFactory::getApplication(); ?>

<div class="offline well">
	<?php if ($app->get('offline_image')) : ?>
		<img src="<?php echo $app->get('offline_image'); ?>" alt="<?php echo $app->get('sitename'); ?>" />
	<?php endif; ?>
	
	<h1>
		<?php echo htmlspecialchars($app->get('sitename')); ?>
	</h1>
	
	<?php if ($app->get('display_offline_message', 1) == 1 && str_replace(' ', '', $app->get('offline_message')) != ''): ?>
		<p><?php echo $app->get('offline_message'); ?></p>
	<?php elseif ($app->get('display_offline_message', 1) == 2 && str_replace(' ', '', JText::_('JOFFLINE_MESSAGE')) != ''): ?>
		<p><?php echo JText::_('JOFFLINE_MESSAGE'); ?></p>
	<?php endif; ?>
	
	<form action="<?php echo JRoute::_('index.php', true); ?>" method="post" name="login" id="form-login">
		<fieldset class="input">
			<p id="form-login-username">
				<label for="username"><?php echo JText::_('JGLOBAL_USERNAME'); ?></label><br />
				<input type="text" name="username" id="username" class="inputbox" alt="<?php echo JText::_('JGLOBAL_USERNAME'); ?>" size="18" />
			</p>
			<p id="form-login-password">
				<label for="passwd"><?php echo JText::_('JGLOBAL_PASSWORD'); ?></label><br />
				<input type="password" name="password" id="password" class="inputbox" alt="<?php echo JText::_('JGLOBAL_PASSWORD'); ?>" size="18" />
			</p>
			<p id="form-login-submit">
				<input type="submit" name="Submit" class="btn btn-info" value="<?php echo JText::_('JLOGIN'); ?>" />
			</p>
		</fieldset>
		
		<input type="hidden" name="option" value="com_users" />
		<input type="hidden" name="task" value="user.login" />
		<input type="hidden" name="return" value="<?php echo base64_encode(JURI::base()); ?>" />
		<?php echo JHTML::_( 'form.token' ); ?>
	</form>
</div>
