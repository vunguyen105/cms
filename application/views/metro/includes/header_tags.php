<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="target-densitydpi=device-dpi, width=device-width, initial-scale=1.0, maximum-scale=1">

    <? if (!isset($title)) {
    $title = $this->config->item('system_short_name') . ' - ' . $this->config->item('system_full_name');
}?>
    <title><?= $title ?></title>
    <link rel="icon" type="image/icon" href="<?=base_url('asset/base/img/favicon.ico')?>"/>


    <!-- THEME METRO -->
    <link href="<?=base_url('asset/themes/'.CURRENT_THEME)?>/css/style.css" rel="stylesheet" type="text/css"/>
    <link href="<?=base_url('asset/themes/'.CURRENT_THEME)?>/css/modern.css" rel="stylesheet">
    <link href="<?=base_url('asset/themes/'.CURRENT_THEME)?>/css/modern-responsive.css" rel="stylesheet">
    <link href="<?=base_url('asset/themes/'.CURRENT_THEME)?>/css/site.css" rel="stylesheet" type="text/css">
    <link href="<?=base_url('asset/themes/'.CURRENT_THEME)?>/js/google-code-prettify/prettify.css" rel="stylesheet" type="text/css">

    <script type="text/javascript" src="<?=base_url('asset/themes/'.CURRENT_THEME)?>/js/assets/jquery.mousewheel.min.js"></script>
    <script type="text/javascript" src="<?=base_url('asset/themes/'.CURRENT_THEME)?>/js/assets/moment.js"></script>
    <script type="text/javascript" src="<?=base_url('asset/themes/'.CURRENT_THEME)?>/js/assets/moment_langs.js"></script>

    <script type="text/javascript" src="<?=base_url('asset/themes/'.CURRENT_THEME)?>/js/modern/accordion.js"></script>
    <script type="text/javascript" src="<?=base_url('asset/themes/'.CURRENT_THEME)?>/js/modern/buttonset.js"></script>
    <script type="text/javascript" src="<?=base_url('asset/themes/'.CURRENT_THEME)?>/js/modern/carousel.js"></script>
    <script type="text/javascript" src="<?=base_url('asset/themes/'.CURRENT_THEME)?>/js/modern/input-control.js"></script>
    <script type="text/javascript" src="<?=base_url('asset/themes/'.CURRENT_THEME)?>/js/modern/pagecontrol.js"></script>
    <script type="text/javascript" src="<?=base_url('asset/themes/'.CURRENT_THEME)?>/js/modern/rating.js"></script>
    <script type="text/javascript" src="<?=base_url('asset/themes/'.CURRENT_THEME)?>/js/modern/slider.js"></script>
    <script type="text/javascript" src="<?=base_url('asset/themes/'.CURRENT_THEME)?>/js/modern/tile-slider.js"></script>
    <script type="text/javascript" src="<?=base_url('asset/themes/'.CURRENT_THEME)?>/js/modern/tile-drag.js"></script>
    <script type="text/javascript" src="<?=base_url('asset/themes/'.CURRENT_THEME)?>/js/modern/calendar.js"></script>

    <script src="<?=base_url()?>asset/base/js/jquery-1.9.1.min.js"></script>
    <link href="<?=base_url()?>asset/base/css/jquery-ui-1.10.3.custom.min.css" rel="stylesheet" type="text/css"/>
    <script src="<?=base_url()?>asset/base/js/jquery-ui-1.10.3.custom.min.js"></script>
    <script type="text/javascript" src="<?=base_url('asset/themes/'.CURRENT_THEME)?>/js/modern/dropdown.js"></script>
