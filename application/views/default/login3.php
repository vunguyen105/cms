<? $this->load->view(CURRENT_THEME.'/includes/header_tags'); ?>
<?

$events = array(
	array('start'=>'10-12','end'=>'25-12','login_bg_img'=>'christmas.jpg','name'=>'Christmas','title'=>'Merry Christmas!'),
	array('start'=>'26-12','end'=>'10-01','login_bg_img'=>'2014.jpg','name'=>'Newyear','title'=>'Happy New Year'),
	array('start'=>'10-08','end'=>'10-09','login_bg_img'=>'backtoschool.gif','name'=>'BackToSchool','title'=>'Welcome'),
	array('start'=>'10-02','end'=>'14-02','login_bg_img'=>'valentine.jpg','name'=>'Nalentine','title'=>'Happy Valentine!')
);

$today = date('d-M');
$bg_img='none.jpg';
//var_dump($events);die;
foreach ($events as $event) {
	if ($event['start']<=$today && $event['end']>=$today)
	{
		$bg_img=base_url('asset/themes/default/img/'.$event['login_bg_img']);
		break;
	}
}
$bg_img=base_url('asset/themes/default/img/default.jpg');
?>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link rel="stylesheet" href="<?=base_url('asset/mods/iview')?>/login-form-style.css"/>
<style type="text/css">
    body{
        background: url(<?=$bg_img?>) no-repeat fixed #ABC6DD;
        -webkit-background-size: cover;
       -moz-background-size: cover;
       -o-background-size: cover;
       background-size: cover;
    }
    #upper_header {
        border: 1px solid #000;
        border-top: none;
        height: 40px;
        width: 900px;
        padding: 10px 5px 2px 5px;
        color: #fff;
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
                <div class="align_right">
                    <?if (($this->session->userdata('CURRENT_USER_ID') == "")) { ?>
                    <div>
                        <form class="form-4" method="POST" action="<?=base_url('home/do_login')?>">
                            <span id="welcome_msg">Please login: </span><label for="txtUsername">Username / email</label>
                            <input title="Username" type="text" id="txtUsername" name="txtUsername"
                                   placeholder="Username"
                                   required>
                            <label for="txtPassword">Password</label>
                            <input title="Your password" type="password" id='txtPassword' name='txtPassword'
                                   placeholder="Password"
                                   required>
                            <input type="submit" name="submit" value="Login" class="button_standard">
                            <a title="Send e-mail to: support@vanphuc.sis.edu.vn" class="button_standard" href="mailto:support@vanphuc.sis.edu.vn">Support</a>
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
</div>
<? $this->load->view(CURRENT_THEME.'/includes/footer'); ?>