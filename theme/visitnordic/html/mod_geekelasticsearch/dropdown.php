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
		<div class="search-form">

			<form action="<?php echo JRoute::_('index.php');?>" method="post">
				<div class="search-box form-group no-padding">
					<div class="input-group input-append input-large">
						<input type="text" name="searchword" class="form-control" value="" placeholder="<?php echo $hint; ?>" autocomplete="off" />
						<?php if($showRightSearchButton): ?>
						<span class="input-group-addon add-on"><?php echo $buttonText; ?></span>
						<?php endif; ?>
					</div>
				</div>
				<div class="search-results-dropdown">
					<div class="inner">
						<a href="#" class="btn-close-result-box" title="<?php echo JText::_('MOD_GEEKELASTICSEARCH_BTN_CLOSE'); ?>"></a>
						<?php if($showType): ?>
							<div class="filter-types form-group">
								<div class="controls">
									<?php foreach($types as $type): ?>
										<?php if(empty($selectedTypes) || in_array($type->type, $selectedTypes)): ?>
											<span class="document-type selected" data-type="<?php echo $type->type; ?>"><?php echo $type->text; ?></span>
										<?php endif; ?>
									<?php endforeach; ?>
								</div>
							</div>
						<?php endif; ?>
						<?php if($showSearchPhrase): ?>
							<div class="phrases-box form-group">
								<div class="controls">
									<span class="control-label">
										<?php echo JText::_('MOD_GEEKELASTICSEARCH_SEARCH_FOR'); ?>
									</span>
									<label class="radio-inline">
										<input type="radio" name="searchphrase" value="all" <?php if($defaultSearchPhrase == 'all') echo ' checked="checked"'; ?>>
										<?php echo JText::_('MOD_GEEKELASTICSEARCH_SEARCHPHRASE_MODE_ALL'); ?>
									</label>
									<label class="radio-inline">
										<input type="radio" name="searchphrase" value="any"<?php if($defaultSearchPhrase == 'any') echo ' checked="checked"'; ?>>
										<?php echo JText::_('MOD_GEEKELASTICSEARCH_SEARCHPHRASE_MODE_ANY'); ?>
									</label>
									<label class="radio-inline">
										<input type="radio" name="searchphrase" value="exact"<?php if($defaultSearchPhrase == 'exact') echo ' checked="checked"'; ?>>
										<?php echo JText::_('MOD_GEEKELASTICSEARCH_SEARCHPHRASE_MODE_EXACT'); ?>
									</label>
								</div>
							</div>
						<?php endif; ?>
						<?php if($showCategories && count($categories)): ?>
							<div class="filter-categories form-group">
								<div class="controls">
									<span class="control-label">
										<?php echo JText::_('MOD_GEEKELASTICSEARCH_FILTER_BY_CATEGORIES'); ?>
									</span>
									<select name="cat_id[]" multiple="multiple" class="categories chosen-list">
										<?php foreach($categories as $type => $cats): ?>
											<optgroup label="<?php echo $cats['group']; ?>">
												<?php foreach($cats['items'] as $cat): ?>
													<?php $prefix = (isset($cat->level) && $cat->level > 1) ? str_pad('', (intval($cat->level) - 1) * 3, '+--') . ' ' : ''; ?>
													<option value="<?php echo $type.':'.$cat->id; ?>"><?php echo $prefix . $cat->title; ?></option>
												<?php endforeach; ?>
											</optgroup>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
						<?php endif; ?>
						<?php if($showOrderby): ?>
							<div class="phrases-box form-group">
								<div class="controls">
									<span class="control-label">
										<?php echo JText::_('MOD_GEEKELASTICSEARCH_ORDER_BY'); ?>
									</span>
									<select name="orderby">
										<?php foreach($orderbyOptions as $value => $text): ?>
											<option value="<?php echo $value; ?>" <?php echo $value == $orderby ? ' selected="selected"' : ''; ?>><?php echo $text; ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
						<?php endif; ?>
						<?php if($showSearchButton): ?>
							<div class="form-group">
								<div class="controls">
									<button class="btn btn-primary btn-search"><?php echo $buttonText; ?></button>
								</div>
							</div>
						<?php endif; ?>

						<hr>
						<div class="search-results"></div>
						<div class="footer">
							<a href="https://www.joomlageek.com/product/component-geek-elasticsearch" title="Geek ElasticSearch Component">Geek ElasticSearch</a> powered by <a href="https://www.joomlageek.com" title="JoomlaGeek.com">JoomlaGeek.com</a>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>

	<?php require JModuleHelper::getLayoutPath('mod_geekelasticsearch', '_result'); ?>

</div>
