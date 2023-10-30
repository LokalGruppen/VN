<?php
/**
 * @author CGOnline.dk
 * @copyright Copyright © 2016 CGOnline.dk - All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */
defined('_JEXEC') or die;

// Getting params from template
$params				= $app->getTemplate(true)->params;
$menu               = $app->getMenu()->getActive();

// Column widths
$leftcolgrid		= ($helper->countModules('left') == 0) ? 0 : $params->get('leftColumnWidth', 3);
$rightcolgrid		= ($helper->countModules('right') == 0) ? 0 : $params->get('rightColumnWidth', 3);

$pageclass          = array();
$pageclass[]      	= $params->get('pageclass_sfx');

$pageclass[]        = $app->input->getCmd('view', '');
$pageclass[]        = $app->input->getCmd('layout', '');
$pageclass[]        = $app->input->getCmd('task', '');

foreach ($pageclass as $key => $class)
{
    if (empty($class)) { unset($pageclass[$key]); }
}

if ($helper->isErrorPage())
{
    if ($helper->error->getCode() == '404')
    {
        http_response_code(404);
        exit;
    }
    else
    {
        http_response_code(500);
    }
}

$logo_file = $params->get('logo_file');
if (!$logo_file) {
	$logo_file = $tpath .'images/logo.png';
}

$logo_link = $params->get('logo_link');
if (!$logo_link) {
	$logo_link = JUri::base(true) .'/';
}

?>
<!DOCTYPE html>
<html lang="<?php echo $doc->language; ?>" dir="<?php echo $doc->direction; ?>">
<head>
    <?php $helper->renderHead(); ?>
        <script src="templates/visitnordic/assets/js/DOMAssistantCompressed-2.8.1.js"></script>
    <script src="templates/visitnordic/assets/js/map.js"></script>
    <link type="text/css" rel="stylesheet" href="templates/visitnordic/assets/scss/overrides.css">
    <script async
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCnlZRqdaevzu6aaZWP4EH-FlDjcsYqjbg&callback=initMap">
</script>
<script src="https://cdn.lightwidget.com/widgets/lightwidget.js"></script>
<script async src="https://www.googletagmanager.com/gtag/js?id=G-HW2M6TTYHN"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-HW2M6TTYHN');
</script>
</head>
<body class="<?php echo implode(' ', $pageclass); ?>">

		<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
			<div class="container" style="position:relative;">
                <div class="navbar-search" style="display:none;">
                    <input type="text" id="q" name="q" class="form-control form-control-lg" placeholder="<?php echo JText::_('COM_VISITNORDIC_COMMON_SEARCH_PLACEHOLDER'); ?>">
                    <a class="nav-link"><i class="material-icons md-dark">close</i></a>
                </div>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-toggle" aria-controls="navbar-toggle" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand col-6 col-md-auto p-0 mr-lg-3" href="<?php echo $logo_link; ?>">
                    <img src="templates/visitnordic/images/VN_logo_hvid_generisk.svg" alt="<?php echo $config->get('sitename', ''); ?>" class="img-fluid">
                </a>
                <div class="navbar-toggler" style="border:0;"></div>
                <!--
                <button class="navbar-toggler navbar-toggler-search" type="button">
                    <i class="material-icons" style="font-size:30px !important;">&#xE8B6;</i>
                </button>
                -->
                <div class="collapse navbar-collapse mt-sm-2" id="navbar-toggle">
                    <?php if ($helper->countModules('navigation')) : ?>
                        <?php $helper->renderModules('navigation', 'none', true); ?>
                    <?php endif; ?>
                </div>
			</div>
        </nav>
        <?php
if(JRequest::getVar('view') == "home" ) {
if ($helper->countModules('fullwidth-outside')) : ?>
    <?php $helper->renderModules('fullwidth-outside', 'block'); ?>
    <?php endif;
}else{}?>
           
        <div class="container-fluid">
            
            <?php if ($helper->countModules('fullwidth')) : ?>
				<?php $helper->renderModules('fullwidth', 'block'); ?>
			<?php endif; ?>

			<?php if ($helper->countModules('showcase')) : ?>
                <?php $helper->renderModules('showcase', 'block'); ?>
			<?php endif; ?>

			<?php if ($helper->countModules('feature')) : ?>
                <?php $helper->renderModules('feature', 'block'); ?>
			<?php endif; ?>


            <?php if ($helper->countModules('breadcrumbs')) : ?>
                <div id="breadcrumb">
                    <?php $helper->renderModules('breadcrumbs', 'block'); ?>
                </div>
            <?php endif; ?>

				<div class="row">
					<?php if ($helper->countModules('left')) : ?>
						<div class="col col-sm-<?php echo $leftcolgrid; ?>">
                            <?php $helper->renderModules('left', 'block'); ?>
						</div>
					<?php endif; ?>

					<div class="col">
						<?php if ($helper->countModules('content-top')) : ?>
                            <?php $helper->renderModules('content-top', 'block'); ?>
						<?php endif; ?>

						<?php if ($params->get('frontpageshow', 0)) : ?>
                            <?php $helper->renderMessage(); ?>
                            <?php $helper->renderComponent(); ?>
						<?php elseif ($menu->getActive() !== $menu->getDefault()) : ?>
                            <?php $helper->renderComponent(); ?>
						<?php endif; ?>

						<?php if ($helper->countModules('content-bottom')) : ?>
                            <?php $helper->renderModules('content-bottom', 'block'); ?>
						<?php endif; ?>
					</div>

					<?php if ($helper->countModules('right')) : ?>
						<div class="col col-sm-<?php echo $rightcolgrid; ?>">
                            <?php $helper->renderModules('right', 'block'); ?>
						</div>
					<?php endif; ?>
				</div>

                <?php if ($helper->countModules('bottom')) : ?>
                    <?php $helper->renderModules('bottom', 'block'); ?>
                <?php endif; ?>
            </div>

		<?php if ($helper->countModules('footer')): ?>
            <div class="footer mt-3 py-4">
				<div class="container-fluid">
                    <div class="row">
                        <?php if ($helper->countModules('footer')) : ?>
                            <?php $helper->renderModules('footer', 'none', true); ?>
                        <?php endif; ?>
                    </div>
                    <hr class="my-3">
                    <div class="row">
                        <div class="col-12 col-md-3">
                            <a href="<?php echo JUri::base(true); ?>"><img class="img-fluid" alt="<?php echo $config->get('sitename', ''); ?>" src="<?php echo $tpath; ?>/images/logo.png"></a>
                        </div>
                        <div class="col-12 col-md-6 text-md-center">
                            <?php $helper->renderModules('copylinks', 'none', true); ?>
                        </div>
                        <div class="col-12 col-md-3 text-md-right">
                            <?php $helper->renderModules('social', 'none', true); ?>
                        </div>
                        <?php if ($helper->countModules('copy')) : ?>
                        <div class="col-12">
                            <hr class="my-3">
                            <?php $helper->renderModules('copy', 'none', true); ?>
                        </div>
                        <?php endif; ?>
                    </div>
				</div>
			</div>
		<?php endif; ?>

        <div class="modal fade" id="video-modal" tabindex="-1" role="dialog" aria-labelledby="video-modal" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <a href="#0" class="cd-top"></a>

        <script type="text/javascript">
            WebFontConfig = {
                google: { families: [ 'Raleway:400,500', 'Material Icons' ] },
                custom: {
                    families: [
                        'Ionicons',
                    ],
                    urls: [
                        '//cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css'
                    ]
                }
            };
            (function() {
                var wf = document.createElement('script');
                wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
                    '://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js';
                wf.type = 'text/javascript';
                wf.async = 'true';
                var s = document.getElementsByTagName('script')[0];
                s.parentNode.insertBefore(wf, s);
            })();
        </script>
        <script>
            !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
                n.callMethod.apply(n,arguments):n.queue.push(arguments)};
                if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
                n.queue=[];t=b.createElement(e);t.async=!0;
                t.src=v;s=b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t,s)}(window,document,'script',
                'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '1967145343299004');
            fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" src="https://www.facebook.com/tr?id=1967145343299004&ev=PageView&noscript=1"/></noscript>
        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-58d41d4e1bf80916" defer></script>

        <?php //if(!isset($_SERVER["HTTP_CF_IPCOUNTRY"]) || (isset($_SERVER["HTTP_CF_IPCOUNTRY"]) && !in_array($_SERVER["HTTP_CF_IPCOUNTRY"], array('AD', 'AL', 'AT', 'AX', 'BA', 'BE', 'BG', 'BY', 'CH', 'CZ', 'DE', 'DK', 'EE', 'ES', 'FI', 'FO', 'FR', 'GB', 'GG', 'GI', 'GR', 'HR', 'HU', 'IE', 'IM', 'IS', 'IT', 'JE', 'LI', 'LT', 'LU', 'LV', 'MC', 'MD', 'ME', 'MK', 'MT', 'NL', 'NO', 'PL', 'PT', 'RO', 'RS', 'RU', 'SE', 'SI', 'SJ', 'SK', 'SM', 'UA', 'VA')))): ?>
        <script>
            jQuery(document).ready(function ($) {
                window.cookieconsent.initialise({
                    container: document.getElementById("content"),
                    palette:{
                        popup: {background: "#fff"},
                        button: {background: "#aa0000"},
                    },
                    revokable:true,
                    location: true,
                    showLink: false,
                    content: {
                        message: '<?php echo JText::_('COM_VISITNORDIC_COOKIE_MESSAGE'); ?>',
                        dismiss: '<?php echo JText::_('COM_VISITNORDIC_COOKIE_DISMISS'); ?>',
                        link: '<?php echo JText::_('COM_VISITNORDIC_COOKIE_LINK'); ?>',
                        href: '#',
                        close: '&#x274c;',
                    }
                });
            });
        </script>
        <?php //endif; ?>
</body>
</html>