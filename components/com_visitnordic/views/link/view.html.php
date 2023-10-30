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

/**
 * Visitnordic Data View
 */
class VisitnordicViewLink extends JViewLegacy
{
    public function display($tpl = null)
    {
        $app = Factory::getApplication();
        $view = $app->input->get('data_type', '', 'string');
        $id = $app->input->get('data_id', '', 'int');

        if ($view && $id) {
            $link = 'index.php?option=com_visitnordic&view=' . $view . '&id=' . $id;
            $uri = JRoute::_($link);

            $app->redirect($uri, 301);
            $app->close(0);
        }

        throw new Exception(JText::_('Article not found'), 404);
    }
}
