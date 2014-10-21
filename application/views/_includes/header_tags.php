<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <? if (!isset($title)) {
    $title = $this->config->item('system_short_name') . ' - ' . $this->config->item('system_full_name');
}?>
    <title><?= $title ?></title>
    <link href="<?=base_url()?>styles/reset.css" rel="stylesheet" type="text/css"/>
    <link href="<?=base_url()?>styles/text.css?v=4.1" rel="stylesheet" type="text/css"/>
    <link href="<?=base_url()?>styles/960.css" rel="stylesheet" type="text/css"/>
    <link href="<?=base_url()?>styles/style.css?v=4.1" rel="stylesheet" type="text/css"/>
    <link href="<?=base_url()?>styles/jquery-ui-1.10.3.custom.min.css?v=4.1" rel="stylesheet" type="text/css"/>
    <script src="<?=base_url()?>scripts/jquery-1.7.2.min.js"></script>
    <script src="<?=base_url()?>scripts/jquery-ui-1.10.3.custom.min.js"></script>
    <link rel="icon" type="image/icon" href="<?=base_url('styles/img/favicon.ico')?>"/>