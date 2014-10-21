<? $this->load->view('includes/header_tags'); ?>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link rel="stylesheet" href="<?=base_url('styles')?>/iview_style1.css"/>
<link rel="stylesheet" href="<?=base_url('styles')?>/iview.css" type="text/css" media="screen"/>
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

        $('input:text, input:password')
            .button()
            .css({
                'font-size':'9pt',
                'font-weight':'100',
                'text-align':'left',
                'cursor':'text',
                'height':'10px',
                'width':'100px',
                'padding-left':'2px',
                'vertical-align':'middle'
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
        border: 1px solid #7e7783;
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
                    <?if (($this->session->userdata('CURRENT_USER_ID') != "")) { ?>
                    <a href="<?=base_url()?>">
                        <img id="logo" src="<?=base_url('styles/img/home1.png')?>" alt="Home"
                             title="<?=$this->config->item('system_full_name')?> - Home page"/>
                    </a>
                    <a href="mailto:huy.nguyenkim@vanphuc.sis.edu.vn">
                        <img src="<?=base_url('styles/img/email2.png')?>" alt="Support" title="Contact supporter"/>
                    </a>
                    <span>::<strong><?=date('d/m/Y')?></strong></span>
                    <?
                } else {
                    ?>
                    <a href="<?=base_url()?>" title="<?=$this->config->item('system_full_name')?>">
                        <img id="logo" src="<?=base_url('styles/img/favicon.ico')?>"
                             alt="<?=$this->config->item('system_full_name')?>">
                    </a>
                    <label id="welcome_msg">Welcome, please login =>></label>
                    <? }?>
                </div>
                <div class="align_right">
                    <?if (($this->session->userdata('CURRENT_USER_ID') != "")) { ?>
                    <label>Hello, </label>
                    <a class="staff_info_dialog">
                        <?=$this->session->userdata('CURRENT_USER_NAME')?>
                    </a>|
                    <a id="btn_change_pwd" title="Change your password">Change
                        password</a> |
                    <a href="<?=base_url('logout')?>">
                        <img src="<?=base_url('styles/img/power2.png')?>" alt="Logout" title="Logout"/>
                    </a>
                    <? } else { ?>
                    <div>
                        <form method="POST" action="<?=base_url('home/do_login')?>">
                            Username: <input class="textbox" name="txtUsername" value="" type="text" tabindex="0"/>
                            Password: <input class="textbox" name="txtPassword" type="password"/>
                            <input class="" type="submit" value="Login"/>
                            | <a href="<?=base_url('feedback')?>">
                            <img src="<?=base_url('styles/img/email2.png')?>" alt="Support"
                                 title="Cannot login? Click here to contact supporter!"/>
                        </a>
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
                "Singapore International School @ VanPhuc",
                "A baby is God's opinion that the world should go on",
                "We have joy, we have fun"
            );
            $capTranEffects = array("wipeLeft", "wipeRight", "wipeTop", "wipeBottom", "expandLeft", "expandRight", "expandTop", "expandBottom", "fade");
            $captionStyles = array("4", "5", "6", "7");
            $positionsX = array("10", "20", "30", "220", "240", "260");
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
<!--    <img src="--><?//=base_url('styles/img/iview')?><!--/bckg.jpg" style="width: 100%;height: 100%;"/>-->
</div>
<script type="text/javascript" src="js/jquery.fullscreen.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#background-image").fullscreenBackground();
    });
</script>
</body>
</html>