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
                title:"SIS @ VanPhuc * 2012-2013",
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
    $(function(){
        $('.staff_photo').each(function(i) {
            var img_src = $(this).attr('realsrc');
            var staff_photo = this;
            var img = new Image();
            img.src = img_src;
            $(img).load(function() {
                staff_photo.src = this.src;
            });
        });
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
	<div class="border_square standard_block" id="studentSearchForm">
        <form method="GET" action="<?=base_url('staff/filter')?>" name="filter_staff">
            <label class="standard_label">Filter by group: </label>
            <select name="department" onchange="reloadStaffList()">
                <option value="">--All--</option>
                <?
				if (!isset($department)){$department="";}
                foreach ($position_list as $pos) {
                    ?>
                    <option value="<?=$pos->department?>" <?=($pos->department==$department)?" selected=true":""?>><?=$pos->department?></option>
                    <? }?>
            </select>
			<span class="right_col"><strong>Total: <?=count($staff_list) ?></strong></span>
        </form>
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
                <img class="staff_photo" realsrc="<?=$imgurl?>" src="<?=base_url('styles/img/loadingfb.gif')?>"/>
                <div class="shadow"></div>
            </a>
                    <span class="name" href="<?=$imgurl?>">
                        <a href="" title="Click to view bigger photo">
                            <?=$staff->name?>
                        </a>
                    </span>
                    <span class="title">
                        <?=$staff->job_title?><br/>
						<?if ($this->permission->canAccessAdminPanel()) { ?>
                        <?= $staff->mobile ?><br/>
                        <? }?>
						<?if ($staff->left_on) { echo " Till ";echo date("m/Y", strtotime($staff->left_on));}?>
                    </span>
        </div>
        <? } ?>
    <? }?>

</div>
