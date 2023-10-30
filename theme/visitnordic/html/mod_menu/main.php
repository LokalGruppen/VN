<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_menu
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>

<?php

if(count($list) == 0) return;

$treeMap = array();

foreach($list as $i => $item) {
    $treeMap[$item->parent_id][] = $item;
}

$root = array_keys($treeMap)[0];

if (!function_exists('get_item_class_names')) {

    function get_item_class_names($item, $path, $treeMap = null)
    {

        $class[] = 'nav-item';
        if (in_array($item->id, $path)) {
            $class[] = 'active';
        }

        if ($item->parent && $item->level == 1) {
            $class[] = 'dropdown';
        }

        if (@$treeMap[$item->tree[0]][0]->deeper) {
            $class[] = 'dropdown-large';
        }

        return implode(" ", $class);
    }
}

?>

<ul class="navbar-nav <?php echo $class_sfx;?>">

    <?php
    foreach($treeMap[$root] as $item):
        $class = get_item_class_names($item, $path, $treeMap);
    ?>
    <li class="<?php echo $class ?>">

        <?php
        switch ($item->type) :
            case 'separator':
            case 'url':
            case 'component':
            case 'heading' && $item->level == 1:
                require JModuleHelper::getLayoutPath('mod_menu', 'main_' . $item->type);
                break;

            default:
                require JModuleHelper::getLayoutPath('mod_menu', 'main_url');
                break;
        endswitch;
        ?>

        <?php if(isset($treeMap[$item->id])): ?>

            <?php /* Mobile menu */ ?>
            <ul class="dropdown-menu<?php $treeMap[$item->id][0]->deeper ? 'd-lg-none' : ''; ?>">
            <?php $i = 0; ?>
                <?php foreach($treeMap[$item->id] as $n1Item): ?>

                    <?php if($n1Item->deeper): ?>
                        <li class="dropdown dropdown-item">
                            <a class="nav-link trigger" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-target="#<?php echo $n1Item->id; ?>"><?php echo $n1Item->title; ?> <i class="material-icons caret">&#xE5C5;</i></a>
                            <ul id="<?php echo $n1Item->id; ?>" class="dropdown-menu">
                                <?php foreach($treeMap[$n1Item->id] as $n2Item): ?>
                                    <?php if($n2Item->type == 'separator'): ?>
                                    <li class="dropdown-header"><?php echo $n2Item->title; ?></li>
                                    <?php else: ?>
                                    <li class="dropdown-item">
                                        <a href="<?php echo $n2Item->flink ? $n2Item->flink : '#'; ?>" class="nav-link"><?php if($n1Item->anchor_css): ?><i class="<?php echo $n1Item->anchor_css; ?> mr-2"></i><?php endif; ?><?php echo $n2Item->title; ?></a>
                                    </li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                    <?php else: ?>
                    <li class="dropdown-item">
                        <a href="<?php echo $n1Item->flink ? $n1Item->flink : '#'; ?>" class="nav-link"><?php if($n1Item->anchor_css): ?><i class="<?php echo $n1Item->anchor_css; ?> mr-2"></i><?php endif; ?><?php echo $n1Item->title; ?></a>
                    </li>
                    <?php endif; ?>

                    <?php $i++; ?>
                <?php endforeach; ?>
            </ul>

            <?php /* Desktop menu */ ?>
            <?php if($treeMap[$item->id][0]->deeper): ?>
            <div class="dropdown-menu d-none d-lg-block">
                <div class="row no-gutters">
                    <div class="col-md-3">
                        <div class="list-group nav-tabs">
                            <?php $i = 0; ?>
                            <?php foreach($treeMap[$item->id] as $n1Item): ?>
                                <a href="#tab-<?php echo $n1Item->id; ?>" data-toggle="tab" role="tab" class="list-group-item<?php echo $i == 0 ? ' active' : '';?>"><?php if($n1Item->anchor_css): ?><i class="<?php echo $n1Item->anchor_css; ?> mr-2"></i><?php endif; ?><?php echo $n1Item->title; ?></a>
                                <?php $i++; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="col-md-9 hidden-md-down">
                        <div class="tab-content px-4 mt-3 p-4-lg">
                            <?php $tabPaneCount = 0;?>
                            <?php foreach($treeMap[$item->id] as $n1Item): $tabPaneCount++; ?>
                                <div class="tab-pane <?php echo $tabPaneCount == 1 ? 'active' : ''?>" id="tab-<?php echo $n1Item->id; ?>">
                                    <div class="row">
                                        <div class="col-md mb-3-lg">
                                            <ul class="list-unstyled">
                                            <?php
                                            $firstSeparator = true;
                                            foreach($treeMap[$n1Item->id] as $n2Item):
                                                if($n2Item->type == 'separator' && !$firstSeparator):
                                            ?>
                                            </ul>
                                        </div>
                                        <div class="col-md mb-3-lg">
                                            <ul class="list-unstyled">
                                            <?php endif; $firstSeparator = false; //Ignore first separator ?>

                                            <?php if($n2Item->type == 'separator') { ?>
                                                <li class="h5"><?php echo $n2Item->title; ?></li>
                                            <?php } else { ?>
                                                <li><a href="<?php echo $n2Item->flink?>"><?php echo $n2Item->title?></a></li>
                                            <?php } ?>

                                        <?php endforeach?>
                                            </ul>
                                        </div>
                                    </div>

                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

        <?php endif; ?>

    </li>
    <?php endforeach; ?>
</ul>
