<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <? if (!isset($title)) {
    $title = $this->config->item('system_short_name') . ' - ' . $this->config->item('system_full_name');
}?>
    <title><?= $title ?></title>
    <link rel="icon" type="image/icon" href="<?=base_url('asset/base/images/favicon.ico')?>"/>
    <link href="<?=base_url()?>asset/base/css/reset.css" rel="stylesheet" type="text/css"/>
    <link href="<?=base_url()?>asset/base/css/960.css" rel="stylesheet" type="text/css"/>
    <link href="<?=base_url()?>asset/base/css/jquery-ui-1.10.3.custom.min.css?v=4.1" rel="stylesheet" type="text/css"/>
    <script src="<?=base_url()?>asset/base/js/jquery-1.9.1.min.js"></script>
    <script src="<?=base_url()?>asset/base/js/jquery-ui-1.10.3.custom.min.js"></script>

    <link href="<?=base_url('asset/themes/'.CURRENT_THEME)?>/layout.css" rel="stylesheet" type="text/css"/>
    <link href="<?=base_url('asset/themes/'.CURRENT_THEME.'/style.css?v='.$this->config->item('system_version'))?>" rel="stylesheet" type="text/css"/>
