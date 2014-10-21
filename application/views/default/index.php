<? $this->load->view(CURRENT_THEME . '/includes/header_tags'); ?>
<? $this->load->view(CURRENT_THEME . '/includes/header'); ?>
<? $this->load->view(CURRENT_THEME . '/includes/body_left_side') ?>

<div class="grid_13">
    <p class="module_title">Notice board:</p>

    <!--Select randomly a staff each time refresh-->
    <?
    $sql = "SELECT * FROM staff  where 1=1 ORDER BY RAND() LIMIT 3";
    $query = $this->db->query($sql);
    $staff_list = $query->result();
    $staff = $staff_list[0];
    ?>
<!--
<div class="">
    <img class="border_standard" width="745px" src="<?//=base_url('asset/themes/default/img/td.jpg')?>" alt="">
</div>
-->
<h6 style="color: #2B6FB6">Random of the day</h6>
<div id="staff_list" class="standard_block">
    <?if (isset($staff_list) && count($staff_list) > 0) { ?>

    <? $iCount = 0;
    foreach ($staff_list as $staff) {
        $iCount++;
        $imgurl = base_url('photos/staff') . '/';
        $imgurl .= ($staff->img == '') ? 'user.png' : $staff->img;
        ?>
        <div title="Click to view details of <?=$staff->name?>" class="staff_info_modal item_block border_standard"
             href="<?=base_url('staff/' . $staff->id)?>">
            <a id="<?=$staff->id?>" href="<?=$imgurl?>">
                <img style="border: none;" class="staff_photo" realsrc="<?=$imgurl?>" src="<?=base_url
                ('asset/themes/_img/loadingfb.gif')
                    ?>"/>

                <div class="shadow"></div>
            </a>
                <span class="name" href="<?=$imgurl?>">
                    <a href="" title="Click to view bigger photo">
                        <?=$staff->name?>
                    </a>
                </span>
                <span class="title">
                    <?=$staff->job_title?><br/>
                    <?if ($staff->joined_on) {
                        echo 'Since: '. date("m/Y", strtotime($staff->joined_on));
                    }?>
                    <?if ($staff->left_on) {
                    echo 'Till: '. date("m/Y", strtotime($staff->left_on));
                }?>
                </span>
        </div>
        <? } ?>
    <? }?>

</div>
</div>
<div id="modal_dialog"></div>
<? $this->load->view(CURRENT_THEME . '/includes/footer'); ?>
<!--[if IE]>
<style type="text/css">
#staff_list .item_block {*display: inline;}
#staff_list .item_block img {}
#staff_details img {height: 100px;}
</style>
<![endif]-->
<script type="text/javascript">
    $(function () {
        $(".staff_info_modal").click(function (e) {
            e.preventDefault();
            var url = $(this).attr('href');
            var messageTitle = $(this).attr('title');

            $("#modal_dialog").load(url).dialog({
                minHeight:300,
                minWidth:600,
                modal:true,
                draggable:false,
                title:"SIS @ VanPhuc * <?=date('Y')?>",
                closeText:"Close",
                closeOnEscape:true,
                show:{
                    effect:"scale",
                    duration:200
                },
                hide:{
                    effect:"clip",
                    duration:200
                }
            });
            $(".ui-widget-overlay").click(function () {
                $("#modal_dialog").dialog('destroy');
            });
        });
    });
</script>
<script type="text/javascript">
    $(function () {
        $('.staff_photo').each(function (i) {
            var img_src = $(this).attr('realsrc');
            var staff_photo = this;
            var img = new Image();
            img.src = img_src;
            $(img).load(function () {
                staff_photo.src = this.src;
            });
        });
    });
</script>
