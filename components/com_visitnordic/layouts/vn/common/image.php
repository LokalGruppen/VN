<?php

$image = $displayData;

?>

    <div class="container-image mb-1 mb-lg-3" style="position:relative;overflow:hidden;">

        <?php $cache = VNHTMLHelper::getResizedImage($image->source, 1280, 640); ?>
        <img class="visitnordic_billede" src="<?php echo $cache; ?>" alt="<?php echo $image->title; ?>" title="<?php echo $image->title; ?>" class="img-fluid">
        <div style="background-color:rgba(0,0,0,0.25);height:100%;width:100%;top:0;left:0;position:absolute;"></div>

        <?php if ($image->title || $image->text): ?>
            <div class="d-flex caption w-100 h-100 align-items-center text-center justify-content-md-center" style="position:absolute;top:0;left:0;">
                <?php if ($image->title): ?>
                    <h4 class="display-4 m-4" style="color:#fff!important; font-weight: 600!important;"><?php echo $image->title; ?></h4>
                <?php endif; ?>

                <?php if ($image->text): ?>
                    <p><?php echo nl2br($image->text); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ($image->credit): ?>
            <span class="credits d-none d-lg-block"><?php echo nl2br($image->credit); ?></span>
        <?php endif; ?>

    </div>
<?php if ($image->credit): ?>
    <p style="font-size:12px;" class="small text-muted d-lg-none text-right"><?php echo nl2br($image->credit); ?></p>
<?php endif; ?>