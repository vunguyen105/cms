<!DOCTYPE html>
<html>
<head>
    <? $this->load->view(CURRENT_THEME.'/includes/head_tags'); ?>
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
                tooltipY:-15
            });
        });
    </script>
</head>

<body>
<div id="cont">
    <div id="upper_header" style="height: 30px;">
        <div style="width: 100%;text-align: center;">
            <div class="container_16" style="color: orange;">
                <div class="left_col">
                    <a href="<?=base_url()?>">
                        <img src="<?=base_url('asset/themes/_img/home1.png')?>" alt="Home"
                             title="<?=$this->config->item('system_full_name')?> - Home page"/>
                    </a>
                    <a href="mailto:huy.nguyenkim@vanphuc.sis.edu.vn">
                        <img src="<?=base_url('asset/themes/_img/email2.png')?>" alt="Support" title="Ask for support"/>
                    </a>
                    <span>::<strong><?=date('d/m/Y')?></strong></span>
                </div>
                <div class="right_col align_right">
                    <?if (($this->session->userdata('CURRENT_USER_ID') != "")) { ?>
                    <label>Hello, </label>
                    <a class="staff_info_dialog"
                       href="<?=base_url('staff/' . $this->session->userdata('CURRENT_USER_ID'))?>">
                        <?=$this->session->userdata('CURRENT_USER_NAME')?>
                    </a>|
                    <a id="btn_change_pwd" href="<?=base_url('change-password')?>" title="Change your password">Change
                        password</a>|
                    <a href="<?=base_url('logout')?>">
                        <img src="<?=base_url('asset/themes/_img/power2.png')?>" alt="Logout" title="Logout"/>
                    </a>
                    <? } else { ?>
                    <div>
                        <form method="POST" action="<?=base_url('home/do_login')?>">
                            Username: <input class="textbox" name="txtUsername" value="" type="text" tabindex="0"/>
                            Password: <input class="textbox" name="txtPassword" type="password"/>
                            <input class="" type="submit" value="Login"/>
                        </form>
                    </div>
                    <? } ?>
                </div>
            </div>
        </div>
    </div>


    <div id="iview" style="margin-top: 80px">
        <div data-iview:image="<?=base_url('photos')?>/photo1.jpg"
             data-iview:transition="slice-top-fade,slice-right-fade">
            <div class="iview-caption" data-x="80" data-y="400" data-transition="wipeRight">Vietnamese staff</div>
            <div class="iview-caption" data-x="80" data-y="450" data-transition="wipeLeft"<i>took in 2012</i></div>
        </div>

        <div data-iview:image="<?=base_url('photos')?>/photo2.jpg"
             data-iview:transition="zigzag-drop-top,zigzag-drop-bottom" data-iview:pausetime="3000">
            <div class="iview-caption caption5" data-x="60" data-y="280" data-transition="wipeDown">Captions can be
                positioned and resized freely
            </div>
            <div class="iview-caption caption6" data-x="300" data-y="350" data-transition="wipeUp"><a href="#">Example
                URL-link</a></div>
        </div>

        <div data-iview:image="<?=base_url('photos')?>/photo6.jpg"
             data-iview:transition="strip-right-fade,strip-left-fade" data-iview:pausetime="8000">
            <div class="iview-caption caption2" data-x="450" data-y="340" data-transition="wipeRight">Video</div>
            <div class="iview-caption caption3" data-x="600" data-y="345" data-transition="wipeLeft">Support</div>
        </div>

        <div data-iview:image="<?=base_url('photos')?>/photo3.jpg">
            <div class="iview-caption caption4" data-x="50" data-y="80" data-width="312" data-transition="fade">Some
                of iView's Options:
            </div>
            <div class="iview-caption blackcaption" data-x="50" data-y="135" data-transition="wipeLeft"
                 data-easing="easeInOutElastic">Touch swipe for iOS and Android devices
            </div>
            <div class="iview-caption blackcaption" data-x="50" data-y="172" data-transition="wipeLeft"
                 data-easing="easeInOutElastic">Image And Thumbs Fully Resizable
            </div>
            <div class="iview-caption blackcaption" data-x="50" data-y="209" data-transition="wipeLeft"
                 data-easing="easeInOutElastic">Customizable Transition Effect
            </div>
            <div class="iview-caption blackcaption" data-x="50" data-y="246" data-transition="wipeLeft"
                 data-easing="easeInOutElastic">Freely Positionable and Stylable Captions
            </div>
            <div class="iview-caption blackcaption" data-x="50" data-y="283" data-transition="wipeLeft"
                 data-easing="easeInOutElastic">Cross Browser Compatibility!
            </div>
        </div>

        <div data-iview:image="<?=base_url('photos')?>/photo4.jpg">
            <div class="iview-caption caption7" data-x="0" data-y="0" data-width="180" data-height="480"
                 data-transition="wipeRight"><h3>The Responsive Caption</h3>This is the product that you <b><i>all
                have been waiting for</b></i>!<br><br>Customize this slider with just a little HTML and CSS to your
                very needs. Give each slider some captions to transport your message.<br><br>All in all it works on
                every browser (including IE6 / 7 / 8) and on iOS and Android devices!
            </div>
        </div>

        <div data-iview:image="<?=base_url('photos')?>/photo5.jpg">
            <div class="iview-caption caption5" data-x="60" data-y="150" data-transition="wipeLeft">What are you
                waiting for?
            </div>
            <div class="iview-caption caption6" data-x="160" data-y="230" data-transition="wipeRight">Get it Now!
            </div>
        </div>
    </div>
    <div>Huy &copy 2012.</div>
</div>

<div id="background-image">
    <img src="<?=base_url('asset/themes/_img/iview')?>/bckg.jpg" width="1820" height="1024"/>
</div>
<script type="text/javascript" src="js/jquery.fullscreen.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#background-image").fullscreenBackground();
    });
</script>
</body>
</html>