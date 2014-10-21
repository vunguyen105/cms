<? $this->load->view('includes/header_tags'); ?>
<link rel="stylesheet" type="text/css" href="<?=base_url('themes/slidebackground')?>/css/style.css"/>
<link rel="stylesheet" type="text/css" href="<?=base_url('themes/slidebackground')?>/css/sbimenu.css"/>
<link href='http://fonts.googleapis.com/css?family=PT+Sans+Narrow' rel='stylesheet' type='text/css'/>
<link href='http://fonts.googleapis.com/css?family=News+Cycle&v1' rel='stylesheet' type='text/css'/>
</head>
<body xmlns="http://www.w3.org/1999/html">
<? $this->load->view('includes/header_menu_top'); ?>
<div class="container">
    <div class="container_16">
        <div class="header grid_16">
            <h1><?=$this->config->item('system_full_name')?><span><?=$this->config->item('system_short_name')?></span></h1>
            <h2>v<?=$this->config->item('system_version')?></h2>
        </div>
    </div>
    <div class="content">
        <div id="sbi_container" class="sbi_container">
            <div class="sbi_panel" data-bg="<?=base_url('photos/slider')?>/photo1.jpg">
                <a class="sbi_label" href="<?=base_url('')?>">Home</a>
            </div>
            <div class="sbi_panel" data-bg="<?=base_url('photos/slider')?>/photo2.jpg">
                <a class="sbi_label" href="<?=base_url('daily-report')?>">Attendance</a>

                <div class="sbi_content">
                    <ul>
                        <li><a href="<?=base_url('submit-attendance')?>">Submit</a></li>
                        <li><a href="<?=base_url('attendance-admin')?>">*Quick Submit</a></li>
                        <li><a href="<?=base_url('monthly-report')?>">Month report</a></li>
                        <li><a href="<?=base_url('daily-report')?>">Report - all classes</a></li>
                        <li><a href="<?=base_url('absent-list')?>">Report - absent list</a></li>
                    </ul>
                </div>
            </div>
            <div class="sbi_panel" data-bg="<?=base_url('photos/slider')?>/photo3.jpg">
                <a class="sbi_label" href="<?=base_url('admin/classes')?>">Classes</a>

                <div class="sbi_content">
                    <ul>
                        <li><a href="<?=base_url('admin/classes')?>">Add</a></li>
                        <li><a href="<?=base_url('admin/classes')?>">Search</a></li>
                    </ul>
                </div>
            </div>
            <div class="sbi_panel" data-bg="<?=base_url('photos/slider')?>/photo4.jpg">
                <a class="sbi_label" href="<?=base_url('staff')?>">Staff</a>

                <div class="sbi_content">
                    <ul>
                        <li><a href="<?=base_url('staff/add')?>">Add</a></li>
                        <li><a href="<?=base_url('staff/assign')?>">Assign 2 class</a></li>
                        <li><a href="<?=base_url('staff/assign')?>">List all</a></li>
                    </ul>
                </div>
            </div>
            <div class="sbi_panel" data-bg="<?=base_url('photos/slider')?>/photo5.jpg">
                <a class="sbi_label" href="<?=base_url('admin')?>">Manage</a>
            </div>
        </div>
    </div>
    <!--    <div class="more">-->
    <!--        -->
    <!--    </div>-->

</div>
<script type="text/javascript" src="<?=base_url('themes/slidebackground')?>/js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="<?=base_url('themes/slidebackground')?>/js/jquery.bgImageMenu.js"></script>
<script type="text/javascript">
    $(function () {
        $('#sbi_container').bgImageMenu({
            defaultBg:'<?=base_url('photos/slider')?>/photo2.jpg',
            border:1,
            menuSpeed:300,
            type:{
                mode:'horizontalSlide',
                speed:250,
                easing:'jswing',
                seqfactor:100
            }
        });
    });
</script>
<!--<div class="topbar"></div>-->
<? $this->load->view('includes/footer'); ?>
