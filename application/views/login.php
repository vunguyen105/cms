<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]> <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]> <html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!-->
<html lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Login</title>
    <script src="<?=base_url()?>scripts/jquery-1.7.2.min.js"></script>
    <link href="<?=base_url()?>styles/reset.css" rel="stylesheet" type="text/css"/>
    <link href="<?=base_url()?>styles/960.css" rel="stylesheet" type="text/css"/>
    <link href="<?=base_url('styles')?>/style.css" rel="stylesheet"/>
    <link href="<?=base_url('styles')?>/login.css?v=1.1" rel="stylesheet" />
    <link href="<?=base_url()?>styles/text.css" rel="stylesheet" type="text/css"/>
    <!--[if lt IE 9]>
    <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</head>
<body>
<div id="container">

    <div style="text-align: center;margin:80px 0 10px 0;padding-top: 20px;">
        <h1 style="font-size: 26pt;">
            <?=$this->config->item('system_full_name')?>
        </h1>
        <br/>

        <h3 style="">v<?=$this->config->item('system_version')?></h3>
    </div>
    <div>
        <?if (($this->session->userdata('CURRENT_USER_ID') != "")) { ?>
        <a class="staff_info_dialog">
            <?=$this->session->userdata('CURRENT_USER_NAME')?>
        </a>|
        <a id="btn_change_pwd" title="Change your password">Change password</a> |
        <a href="<?=base_url('logout')?>">
            <img src="<?=base_url('styles/img/power2.png')?>" alt="Logout" title="Logout"/>
        </a>
        <? } else { ?>
        <div id="login-wrapper">
            <form method="POST" action="<?=base_url('home/do_login')?>" class="login">
                <p>
                    <label for="login">Username:</label>
                    <input id="login" name="txtUsername" type="text" tabindex="0" value="">
                </p>

                <p>
                    <label for="password">Password:</label>
                    <input id="password" name="txtPassword" type="password"/>
                </p>

                <p class="login-submit">
                    <button type="submit" class="login-button">Login</button>
                </p>

                <p class="forgot-password">
                    <?if ((isset($error)) && $error != '') {
                    echo $error;
                }?>
                    <a href="<?=base_url('feedback')?>" class="login-button">Support</a></p>
            </form>
        </div>
        <? } ?>
    </div>
</div>
<script type="text/javascript">
    $("#container").hide();
    $(document).ready(function () {
        $("#container").fadeIn('200');
    });
</script>