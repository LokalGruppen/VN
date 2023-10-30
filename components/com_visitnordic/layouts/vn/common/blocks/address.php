<?php

$item = $displayData;

if (isset($item->address) && $item->company || $item->address || $item->city || $item->homepage || $item->email): ?>

<div class="card mb-3">
    <div class="card-body">
    <h3><?php echo JText::_('COM_VISITNORDIC_COMMON_CONTACT_TITLE'); ?></h3>

    <address>
        <?php if (!empty($item->company)): ?>
            <strong class="company"><?php echo $item->company; ?></strong><br>
        <?php endif; ?>

        <?php if (!empty($item->address)): ?>
            <?php echo $item->address; ?><br>
        <?php endif; ?>

        <?php if ((int) $item->zip): ?>
            <?php echo $item->zip; ?>
        <?php endif; ?>

        <?php if (!empty($item->city)): ?>
            <?php echo $item->city; ?>
        <?php endif; ?>

        <?php if ($item->region && $item->region->id != 9999): ?>
            <div class="mb-3">
                <?php if (!empty($item->region->city)): ?>
                    <?php echo $item->region->city; ?>,
                <?php endif; ?>

                <?php if (!empty($item->region->region)): ?>
                    <?php echo $item->region->region; ?><br>
                <?php endif; ?>

                <?php if (!empty($item->region->country)): ?>
                    <?php echo $item->region->country; ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <dl class="details m-0">
            <?php if ($item->homepage): ?>
                <?php
                $url = VNHTMLHelper::cleanLink($item->homepage);
                $host = VNHTMLHelper::getUrlDomain($url);
                ?>
                <dt><?php echo JText::_('COM_VISITNORDIC_COMMON_CONTACT_WEB'); ?></dt>
                <dd><a target="_blank" href="<?php echo $url; ?>" title="<?php echo $url; ?>"><?php echo $host; ?></a>
                </dd>
            <?php endif; ?>

            <?php if ($item->email): ?>
                <dt><?php echo JText::_('COM_VISITNORDIC_COMMON_CONTACT_EMAIL'); ?></dt>
                <dd><a href="mailto:<?php echo $item->email; ?>"><?php echo $item->email; ?></a></dd>
            <?php endif; ?>

            <?php if ($item->phone): ?>
                <?php
                $phone = VNHTMLHelper::cleanPhonenumber($item->phone, true);
                $number = VNHTMLHelper::cleanPhonenumber($item->phone);
                ?>
                <dt><?php echo JText::_('COM_VISITNORDIC_COMMON_CONTACT_PHONE'); ?></dt>
                <dd><a href="tel:<?php echo $phone; ?>"><?php echo $number; ?></a></dd>
            <?php endif; ?>

            <?php if ($item->fax): ?>
                <dt><?php echo JText::_('COM_VISITNORDIC_COMMON_CONTACT_FAX'); ?></dt>
                <dd><?php echo $item->fax; ?></dd>
            <?php endif; ?>
        </dl>

        <?php $title = (!empty($item->company) ? $item->company : $item->title); ?>

        <?php if (!empty($item->logo)): ?>
            <?php if (!empty($item->homepage)): ?>
                <a href="<?php echo $item->homepage; ?>" target="_blank" title="<?php echo $title; ?>">
            <?php endif; ?>

            <?php $cache = VNHTMLHelper::getResizedImage($item->logo, 300); ?>
            <img src="<?php echo $cache; ?>" class="img-fluid" alt="<?php echo $title; ?>"
                 title="<?php echo $title; ?>"/>

            <?php if (!empty($item->homepage)): ?>
                </a>
            <?php endif; ?>
        <?php endif; ?>

    </address>
    </div>
</div>
<?php endif; ?>


<?php

// Hardcoded solution ahead - We know!
$itemType = (isset($item->tableType) ? strtolower($item->tableType) : '');
if ($itemType) {
    $renderFields = array(0);

    if ($itemType == 'attraction') {
        $renderFields[] = 5;
    }
    if ($itemType == 'hotel') {
        $renderFields[] = 22;
    }

    $fields = VNAttributes::getFields($item->tableType, $renderFields);
    $values = VNAttributes::getValues($item->tableType, $item->id);

    $layout = new JLayoutFile('vn.common.attributes.field');

    $data = new stdClass();
    $data->type = $item->tableType;
    $data->id = $item->id;
    $data->field = null;

    $buffer = '';

    foreach ($fields as $field) {
        $field->values = array();

        foreach ($values as $value) {
            if ($value->field_id == $field->id) {
                $field->values[] = $value;
            }
        }

        $data->field = $field;

        $buffer .= $layout->render($data);
    }

    $buffer = trim($buffer);

    if (!empty($buffer)) {

        echo $buffer;

    }
}