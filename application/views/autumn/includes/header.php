<!--[if IE]><style type="text/css">#container{margin-top: 10;}</style><![endif]-->
</head>
<body xmlns="http://www.w3.org/1999/html">
<div id="container" class="container_16">
    <? $this->load->view(CURRENT_THEME.'/includes/menu_upperheader'); ?>
    <div id="header">
        <div id="company">
            <a href="<?=base_url()?>" class="logo">
                <?
                $img_url = base_url('asset/themes/'.CURRENT_THEME.'/img/logo.png');
                if (file_exists('\''.$img_url.'\'')) {
                    $img_url=base_url('asset/themes/'.CURRENT_THEME.'/img/logo.png');
                } else {
                    $img_url=base_url('asset/base/images/logo.png');
                }
                ?>
                <img src="<?=$img_url?>" alt="SMS Logo"/>
            </a>
<!--            <label class="customer_name">--><?//=$this->config->item('customer_name')?><!--</label>-->
        </div>
        <div id="nav_menu_wrapper">
            <? $this->load->view(CURRENT_THEME.'/includes/menu_navigation'); ?>
        </div>
    </div>
    <div class="clearfix"></div>
