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

?>
<script class="search-result-template" type="x-tmpl-mustache">
{{#data.error}}
<div class="alert alert-danger">
	{{#data.error.root_cause}}
	<p>[{{{type}}}] {{{reason}}}</p>
	{{/data.error.root_cause}}
</div>
{{/data.error}}
{{^data.error}}

	{{#texts.summary}}
	<p class="result-statistics clearfix">
	{{texts.summary}}
	</p>
	{{/texts.summary}}

	{{#data.hits.hits}}
	<div class="result-item clearfix">
		{{#_source.showImage}}
		{{#_source.image}}
		<div class="img-intro">
			<a href="{{{_source.routeUrl}}}" title="{{_source.title}}">
			<img class="img-responsive" src="{{{_source.image}}}" alt="{{{_source.image}}}">
			</a>
		</div>
		{{/_source.image}}
		{{/_source.showImage}}
		<h3 class="result-title">
			<a href="{{{_source.routeUrl}}}" title="{{_source.title}}">{{{_source.title}}}</a>
		</h3>
		{{#_source.showLink}}
		<p>
			<a href="{{{_source.routeUrl}}}" title="" class="text-muted muted">{{{_source.routeUrl}}}</a>
		</p>
		{{/_source.showLink}}

		<p class="result-text">
		{{{_source.description}}}
		</p>
		{{#_source.additionalInfo}}
		<p>
			{{#_source.taxonomy}}
			<span class="taxonomy"><span class="branch">{{{branch}}}:</span> {{{title}}}</span>
			{{/_source.taxonomy}}
		</p>
		{{/_source.additionalInfo}}
	</div>
	{{/data.hits.hits}}
	<div class="clearfix">
		<div class="pagination">
		</div>
	</div>
{{/data.error}}
</script>