    <?php $tpath = JUri::base(true) .'/templates/'. Factory::getApplication()->getTemplate(); ?>

    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="x-ua-compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=1370, maximum-scale=1" />

    <title>Error: <?php echo $this->error->getCode(); ?></title>

    <link href="<?php echo $tpath; ?>/favicon.png" rel="shortcut icon" type="image/ico" />
    <link rel="stylesheet" href="<?php echo $tpath; ?>/css/bootstrap.min.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo $tpath; ?>/css/template.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo $tpath; ?>/css/font-awesome.min.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo $tpath; ?>/css/error.css" type="text/css" />
    <script src="<?php echo $tpath; ?>/js/jui/jquery.min.js" type="text/javascript"></script>
    <script src="<?php echo $tpath; ?>/js/jui/jquery-noconflict.js" type="text/javascript"></script>
    <script src="<?php echo $tpath; ?>/js/jui/jquery-migrate.min.js" type="text/javascript"></script>
    <script src="<?php echo $tpath; ?>/js/jui/bootstrap.min.js" type="text/javascript"></script>
