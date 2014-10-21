<!--[if IE]><style type="text/css">#container{margin-top: 10;}</style><![endif]-->
</head>
<body xmlns="http://www.w3.org/1999/html">
<div id="container" class="container_16">
    <? $this->load->view('includes/menu_upperheader'); ?>
    <div id="header">
        <div id="company">
            <a href="<?=base_url()?>" class="logo">
                <img src="<?=base_url('styles/img/support.png')?>" alt=""/>
            </a>
<!--            <label class="customer_name">--><?//=$this->config->item('customer_name')?><!--</label>-->
        </div>
<!--        <span style="border: 1px solid;width: 300px;">-->
<!--            <a href="--><?////=base_url()?><!--">-->
<!--                <img src="--><?//=base_url('photos/staff/huy.jpg')?><!--" alt="" height="50px"/><br/>-->
<!--            </a>-->
<!--        </span>-->
        <div id="nav_menu_wrapper">
            <? $this->load->view('includes/menu_navigation'); ?>
        </div>
    </div>
    <div class="clearfix"></div>
