<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_languages
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

if ($params->get('dropdown', 1) && !$params->get('dropdownimage', 0))
{
    JHtml::_('formbehavior.chosen');
}
?>

<?php if ($params->get('dropdown', 1) && !$params->get('dropdownimage', 0)) : ?>
    <form name="lang" method="post" action="<?php echo htmlspecialchars(JUri::current(), ENT_COMPAT, 'UTF-8'); ?>">
        <select class="inputbox advancedSelect" onchange="document.location.replace(this.value);" >
            <?php foreach ($list as $language) : ?>
                <option dir=<?php echo $language->rtl ? '"rtl"' : '"ltr"'; ?> value="<?php echo $language->link; ?>" <?php echo $language->active ? 'selected="selected"' : ''; ?>>
                    <?php echo $language->title_native; ?></option>
            <?php endforeach; ?>
        </select>
    </form>
<?php elseif ($params->get('dropdown', 1) && $params->get('dropdownimage', 0)) : ?>

    <ul class="navbar-nav navbar-language ml-auto">
        <?php foreach ($list as $language) : ?>
        <?php if ($language->active) : ?>
        <?php $flag = ''; ?>
        <?php $flag .= "&nbsp;" . JHtml::_('image', 'mod_languages/' . $language->image . '.gif', $language->title_native, array('title' => $language->title_native), true); ?>
        <?php $flag .= "&nbsp;" . $language->title_native; ?>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span><?php echo $language->title_native; ?></span>
            </a>
            <?php endif; ?>
            <?php endforeach; ?>
            <div class="dropdown-menu" dir="<?php echo Factory::getLanguage()->isRtl() ? 'rtl' : 'ltr'; ?>">
                <?php foreach ($list as $language) : ?>
                    <?php if ($params->get('show_active', 0) || !$language->active) : ?>
                        <a class="dropdown-item<?php echo $language->active ? ' active' : ''; ?>" href="<?php echo $language->link; ?>">
                            <?php //echo JHtml::_('image', 'mod_languages/' . $language->image . '.gif', $language->title_native, array('title' => $language->title_native), true); ?>
                            <?php echo $language->title_native; ?>
                        </a>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </li>
    </ul>
<?php else : ?>
    <ul class="<?php echo $params->get('inline', 1) ? 'lang-inline' : 'lang-block'; ?>">
        <?php foreach ($list as $language) : ?>
            <?php if ($params->get('show_active', 0) || !$language->active) : ?>
                <li class="<?php echo $language->active ? 'lang-active' : ''; ?>" dir="<?php echo $language->rtl ? 'rtl' : 'ltr'; ?>">
                    <a href="<?php echo $language->link; ?>">
                        <?php if ($params->get('image', 1)) : ?>
                            <?php echo JHtml::_('image', 'mod_languages/' . $language->image . '.gif', $language->title_native, array('title' => $language->title_native), true); ?>
                        <?php else : ?>
                            <?php echo $params->get('full_name', 1) ? $language->title_native : strtoupper($language->sef); ?>
                        <?php endif; ?>
                    </a>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>