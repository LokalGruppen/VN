<?php
/**
 * @version     1.0.0
 * @package     com_visitnordic
 * @copyright   Copyright (C) 2015. Alle rettigheder forbeholdes.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      CGOnline.dk <info@cgonline.dk> - http://www.cgonline.dk
 */

// No direct access.
defined('_JEXEC') or die;

require_once __DIR__ . '/vndata.php';

/**
 * Visitnordic model.
 */
class VisitnordicModelArticle extends VNModelItem
{
    protected $modeltype = 'article';
    protected $modeltable = '#__visitnordic_articles';
}
