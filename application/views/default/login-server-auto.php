<? $this->load->view(CURRENT_THEME.'/includes/header_tags'); ?>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link rel="stylesheet" href="<?=base_url('styles')?>/iview_style1.css"/>
<link rel="stylesheet" href="<?=base_url('styles')?>/iview.css" type="text/css" media="screen"/>
<!--<script src="--><?//=base_url('scripts')?><!--/modernizr.custom.63321.js" type="text/javascript"></script>-->
<link rel="stylesheet" href="<?=base_url('styles')?>/login-form-style.css"/>
<script src="<?=base_url('scripts')?>/raphael-min.js" type="text/javascript"></script>
<script src="<?=base_url('scripts')?>/jquery.easing.js" type="text/javascript"></script>
<script src="<?=base_url('scripts')?>/iview.pack.js" type="text/javascript"></script>
<script>
    $(document).ready(function () {
        $('#iview').iView({
            pauseTime:4000,
            directionNav:false,
            controlNav:false,
            tooltipY:-15,
            timer:'360Bar',
            timerBg:'#000', // Timer background
            timerColor:'#33CC33', // Timer color
            timerOpacity:0.7,
            timerDiameter:25
        });

    });
</script>
<style type="text/css">
    #upper_header {
        border: 1px solid #000;
        border-top: none;
        height: 35px;
        width: 900px;
        padding: 5px 5px 2px 5px;
        color: orange;
        -webkit-box-shadow: 1px 1px 5px black;
        -moz-box-shadow: 1px 1px 5px black;
        box-shadow: 1px 1px 5px black;
    }

    #upper_header label, a {
        padding-top: 100px;
    }

    #upper_header #logo {
        width: 30px;
        height: 30px;
        /*border: 1px solid #7e7783;*/
    }

    #welcome_msg {
        font-family: "MS Sans Serif";
        font-size: 12pt;
    }

    #error {
        opacity: 0.9;
        background: #c4302b;
        box-shadow: rgba(0, 0, 0, 0.7) 3px 3px 8px 0px;
        text-shadow: #ccc 10px 10px 10px;
        color: #fff;
        font-size: 12px;
        font-weight: bold;
        text-shadow: none;
        display: inline-block;
        margin-top: 14px;
        padding: 3px 5px;
        border-radius: 3px;
        -moz-border-radius: 3px;
        -webkit-border-radius: 3px;
    }
</style>
</head>

<body>
<div id="cont">
    <div class="container">
        <div id="upper_header">
            <div id="wrapper_inside">
                <div class="left_col">
                    <a href="<?=base_url()?>" title="<?=$this->config->item('system_full_name')?>">
                        <img id="logo" src="<?=base_url('asset/themes/_img/logo.png')?>"
                             alt="<?=$this->config->item('system_full_name')?>">
                    </a>
                    <label id="welcome_msg">Welcome, please login =>></label>
                </div>
                <div class="align_right">
                    <?if (($this->session->userdata('CURRENT_USER_ID') == "")) { ?>
                    <div>
                        <form class="form-4" method="POST" action="<?=base_url('home/do_login')?>">
                            <label for="login">Username / email</label>
                            <input type="text" name="txtUsername" placeholder="Username or email" value="admin" required>
                            <label for="password">Password</label>
                            <input type="password" name='txtPassword' placeholder="Password" value="admin@admin" required>
                            <input type="submit" name="submit" value="Login">
                            <a class="button_standard" href="<?=base_url('feedback')?>">Contact</a>
                        </form>
                        <?if ((isset($error)) && $error != '') {
                        echo '<p id="error">' . $error . '</p>';
                    }?>
                    </div>
                    <? } ?>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div id="iview" style="margin-top: 70px">
            <?
            $files = glob("photos/slider/*.{jpg,JPG}", GLOB_BRACE);
            $captionList = array(
                "Various Report types",
                "Attendance Submitting online",
                "Class list managing, Student list managing",
                "Enrollment report by years, campuses"
            );
            $capTranEffects = array("wipeLeft", "wipeRight", "expandLeft", "expandRight", "expandTop", "expandBottom", "fade");
            $captionStyles = array("5");
            $positionsX = array("10", "260");
            $positionsY = array("10", "420", "430");
            foreach ($files as $file) {
                $file_url = base_url($file);

                $iCaption = array_rand($captionList, 1);
                $caption = $captionList[$iCaption];

                $iEffect = array_rand($capTranEffects, 1);
                $transition = $capTranEffects[$iEffect];

                $iCapStyle = array_rand($captionStyles, 1);
                $capStyle = $captionStyles[$iCapStyle];

                $positionY = $positionsY[array_rand($positionsY, 1)];
                $positionX = $positionsX[array_rand($positionsX, 1)];
                ?>
                <div data-iview:image="<?=$file_url?>">
                    <div class="iview-caption caption<?=$capStyle?>" data-x="<?=$positionX?>" data-y="<?=$positionY?>"
                         data-transition="<?=$transition?>">
                        <?=$caption?>
                    </div>
                </div>
                <? }?>
        </div>
        <div style="color: #ccc">
            <a style="color: orange;" href=""
               title="<?=$this->config->item('system_full_name')?>. [Version <?=$this->config->item('system_version')?>]"
               onclick=" alert('Developed by Nguyen Kim Huy.\nCopyright © 2012. All rights reserved.');return false;">
                <strong><?=$this->config->item('system_short_name')?></strong>
                v<?=$this->config->item('system_version')?>
            </a>
            <!--        © 2012.-->
        <span class="mess" title="Hệ thống chỉ hỗ trợ tốt trên FireFox & Chrome">
            Hỗ trợ tốt trên <strong>FireFox & Chrome</strong>. Currently works on <strong>FireFox &
            Chrome</strong> only.
        </span>
        </div>
    </div>
</div>

<div id="background-image">
    <img src="<?/*=base_url('asset/themes/_img/iview')*/?>/bg.jpg" style="width: 100%;height: 100%;"/>
</div>
<!--
<script type="text/javascript" src="js/jquery.fullscreen.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#background-image").fullscreenBackground();
    });
</script>-->
</body>
</html>