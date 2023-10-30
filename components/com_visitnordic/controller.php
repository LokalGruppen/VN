<?php
/**
 * @version     1.0.0
 * @package     com_visitnordic
 * @copyright   Copyright (C) 2015. Alle rettigheder forbeholdes.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      CGOnline.dk <info@cgonline.dk> - http://www.cgonline.dk
 */

// No direct access
defined('_JEXEC') or die;

class VisitnordicController extends JControllerLegacy
{
    public function display($cachable = false, $urlparams = false)
    {
        require_once JPATH_COMPONENT_ADMINISTRATOR . '/helpers/visitnordic.php';
        require_once JPATH_COMPONENT . '/helpers/visitnordic.php';

        JHtml::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR . '/helpers/html');

        $view = JFactory::getApplication()->input->getCmd('view', 'collections');
        JFactory::getApplication()->input->set('view', $view);

        parent::display($cachable, $urlparams);

        return $this;
    }
}
