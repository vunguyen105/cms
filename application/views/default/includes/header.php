<!--[if IE]><style type="text/css">#container{margin-top: 10;}</style><![endif]-->
</head>
<body xmlns="http://www.w3.org/1999/html">
<div id="container" class="container_16">
    <? $this->load->view(CURRENT_THEME.'/includes/menu_upperheader'); ?>
    <div id="header">
        <div id="company">
            <a href="<?=base_url()?>" class="logo">
                                <?
                $files = glob("asset/logos/*.{jpg,JPG,png,PNG,gif,GIF}", GLOB_BRACE);
                $img_url = base_url($files[array_rand($files)]);
                ?>
				<img src="<?=$img_url?>" alt="SMS Logo" style="max-width: 110px;max-height: 100px"/>
                <!--<img src="<?//=base_url('asset/themes/default/img/chalk-board.gif')?>" alt="SMS Logo" style="max-width: 110px;max-height:100px"/>-->
            </a>
<!--            <label class="customer_name">--><?//=$this->config->item('customer_name')?><!--</label>-->
        </div>
        <div id="nav_menu_wrapper">
            <? $this->load->view(CURRENT_THEME.'/includes/menu_navigation'); ?>
        </div>
    </div>
    <div class="clearfix"></div>
