
<div class="carousel <?php echo JFactory::getApplication()->input->get('view') != "home" && count($displayData) > 1 ? 'mb-1' : 'mb-3'; ?>" style="position:relative;overflow:hidden;">
        <div class="slick m-0">
            <?php $i = 0; ?>
            <?php foreach ($displayData as $slide): ?>
                <div class="carousel-item">
                    <?php if ($slide->type == 'image'): ?>
                    <?php $cache = VNHTMLHelper::getResizedImage($slide->source, 1280, 640); ?>
                    <div style="background-image:url(<?php echo $cache; ?>);background-repeat:no-repeat;background-size:cover;background-position:center;height:400px;width:100%;top:0;left:0;position:absolute; width:100%;" title="<?php echo $slide->title; ?>"></div>
                    <div class="w-100 h-100" style="background-color:rgba(0,0,0,0.25);top:0;left:0;position:absolute;"></div>
                    <?php if (@$slide->link): ?>
                    <a href="<?php echo $slide->link; ?>">
                        <?php endif; ?>
                        <div class="d-flex align-items-center flex-column justify-content-center text-center col-12 col-sm-10 mx-auto" style="position:relative;min-height:400px;color:#fff;">
                            <p class="display-4 m-4" style="font-weight:normal;"><?php echo $slide->title; ?></p>
                            <?php if ($slide->text): ?>
                                <p><?php echo nl2br($slide->text); ?></p>
                            <?php endif; ?>
                        </div>
                        <?php if (@$slide->link): ?>
                    </a>
                    <?php endif; ?>
                    <?php if ($slide->credit): ?>
                        <p class="credits"><?php echo nl2br($slide->credit); ?></p>
                    <?php endif; ?>
                    </a>
                    <?php elseif ($slide->type == 'video'): ?>
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src="<?php echo $slide->url; ?>"></iframe>
                    </div>
                    <?php endif; ?>
                </div>
                <?php $i++; ?>
            <?php endforeach; ?>
        </div>
        <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
</div>


<?php if(JFactory::getApplication()->input->get('view') != "home" && count($displayData) > 1): ?>
<div class="slick-nav mb-3" style="overflow:hidden;">
    <?php foreach ($displayData as $slide): ?>

            <?php if ($slide->type == 'image'): ?>

                <?php $cache = VNHTMLHelper::getResizedImage($slide->source, 220, 131); ?>
                <img src="<?php echo $cache; ?>" alt="<?php echo $slide->title; ?>" class="img-fluid">

            <?php elseif ($slide->type == 'video'): ?>

                <div class="d-flex align-items-center text-center justify-content-center display-3" style="position:relative;">
                    <?php $cache = VNHTMLHelper::getResizedImage($slide->source, 220, 131); ?>
                    <img src="<?php echo $cache; ?>" alt="<?php echo $slide->title; ?>" class="img-fluid">
                    <div class="w-100 h-100" style="position:absolute;background:rgba(0,0,0,.6);"></div>
                    <i class="material-icons md-light hover-scale" style="position:absolute;">play_circle_outline</i>
                </div>
            <?php endif; ?>

    <?php endforeach; ?>
</div>
<?php endif; ?>