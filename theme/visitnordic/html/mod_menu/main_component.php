<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_menu
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

if ($item->menu_image)
{
	$item->params->get('menu_text', 1) ?
	$linktype = '<img src="' . $item->menu_image . '" alt="' . $item->title . '" /><span class="image-title">' . $item->title . '</span> ' :
	$linktype = '<img src="' . $item->menu_image . '" alt="' . $item->title . '" />';
}
else
{
	$linktype = $item->title;
}

switch ($item->browserNav)
{
	default:
	case 0:
        echo '<a href="'.$item->flink.'" class="nav-link">'.(!empty($item->anchor_css) ? '<i class="material-icons">'.$item->anchor_css.'</i> ' : '').$linktype.'</a>';
		break;
	case 1:
	    echo '<a href="'.$item->flink.'" target="_blank" class="nav-link">'.$linktype.'</a>';
		break;
	case 2:
	    echo '<a href="'.$item->flink.'" onclick="window.open(this.href,\'targetWindow\',\'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes\');return false;">'.$linktype.'</a>';
		break;
}
