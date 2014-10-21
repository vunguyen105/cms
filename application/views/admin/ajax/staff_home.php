<link href="<?=base_url()?>styles/jquery.lightbox-0.5.css" rel="stylesheet" type="text/css"/>
<!--[if IE]>
<style type="text/css">
#staff_list .item_block {*display: inline;}
#staff_list .item_block img {}
#staff_details img {height: 100px;}
</style>
<![endif]-->
<script src="<?=base_url()?>scripts/jquery.lightbox-0.5.min.js"></script>
<script type="text/javascript">
    $(function () {
        $('#staff_list .lightbox').lightBox();

        $(".staff_info_modal").click(function (e) {
            e.preventDefault();
            var url = $(this).attr('href');
            var messageTitle = $(this).attr('title');

            $("#modal_dialog").load(url).dialog({
                minHeight:300,
                minWidth:600,
                modal:true,
                draggable:false,
                title:"SIS @ VanPhuc * 2012-2013",
                closeText:"Close",
                closeOnEscape:true
            }).effect("slide", 300);
            $(".ui-widget-overlay").click(function () {
                $("#modal_dialog").dialog('close');
            });
        });


    });
    $(document).ready(function () {
//        alert('ddd');
    });
</script>
<script type="text/javascript">
    function reloadStaffList() {
        document.filter_staff.submit();
    }
</script>
<p class="module_title">OUR SUPER STAFF</p>
<div class="clearfix"></div>
<div id="modal_dialog"></div>
<div id="staff_list" class="standard_block">
    <?if (isset($staff_list) && count($staff_list) > 0) { ?>
    <div id="studentSearchForm">
        <form method="POST" action="<?=base_url('staff/list_by_title')?>" name="filter_staff">
            <label class="standard_label">Filter by position: </label>
            <select name="job_title" onchange="reloadStaffList()">
                <option value="">---</option>
                <?
                foreach ($position_list as $pos) {
                    ?>
                    <option value="<?=$pos->job_title?>"><?=$pos->job_title?></option>
                    <? }?>
            </select>
            <a class="standard_label button_standard" href="<?=base_url('staff')?>">Show all</a>
        </form>
        <div class="right_col"><strong>Total: <?=count($staff_list) ?></strong></div>
    </div>
    <div class="clearfix"></div>
    <? $iCount = 0;
    foreach ($staff_list as $staff) {
        $iCount++;
        $imgurl = base_url('photos/staff') . '/';
        $imgurl .= ($staff->img == '') ? 'user.png' : $staff->img;
        ?>
        <div title="Click to view details of <?=$staff->name?>" class="staff_info_modal item_block border_standard"
             href="<?=base_url('staff/' . $staff->id)?>">
            <a id="<?=$staff->id?>" href="<?=$imgurl?>">
                <img src="<?=$imgurl?>"/>

                <div class="shadow"></div>
            </a>
                    <span class="name lightbox" href="<?=$imgurl?>">
                        <a href="" title="Click to view bigger photo">
                            <?=$staff->name?>
                        </a>
                    </span>
                    <span class="title">
                        <?=$staff->job_title?><br/>
                        <?if ($this->permission->canAccessAdminPanel()) { ?>
                        <?=$staff->mobile?>
                        <?}?>
                    </span>
        </div>
        <? } ?>
    <? }?>

</div>
