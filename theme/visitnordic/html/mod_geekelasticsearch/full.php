<?php
/**
 * @package    com_geekelasticsearch
 * @version    1.5.6
 *
 * @copyright  Copyright (C) 2015 - 2017 JoomlaGeek. All Rights Reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 * @author     JoomlaGeek <admin@joomlageek.com>
 * @link       http://www.joomlageek.com
 */

defined('_JEXEC') or die;

// Including fallback code for the placeholder attribute in the search field.
//JHtml::_('script', 'system/html5fallback.js', false, true);
JHtml::_('formbehavior.chosen', '.geek-search .chosen-list', null, array('disable_search_threshold' => 0, 'placeholder_text_multiple' => JText::_('MOD_GEEKELASTICSEARCH_FILTER_BY_CATEGORIES_HINT') ));

?>

<div id="<?php echo $searchId; ?>" class="geek-search-wrapper <?php echo $moduleclass_sfx ?>">
	<div class="geek-search <?php echo $moduleclass_sfx ?>">
		<!--<h2 id="modal-title-<?php /*echo $module->id; */?>"><?php /*echo $boxTitle; */?></h2>-->
		<div class="search-form">
			<?php require JModuleHelper::getLayoutPath('mod_geekelasticsearch', '_form'); ?>
			<hr>
			<div class="search-results"></div>
			<div class="footer">
				<a href="https://www.joomlageek.com/product/component-geek-elasticsearch" title="Geek ElasticSearch Component">Geek ElasticSearch</a> powered by <a href="https://www.joomlageek.com" title="JoomlaGeek.com">JoomlaGeek.com</a>
			</div>
		</div>
	</div>
	<?php require JModuleHelper::getLayoutPath('mod_geekelasticsearch', '_result'); ?>
</div>
