<!--[if IE]>
<style type="text/css">
#staff_list .item_block {*display: inline;}
#staff_list .item_block img {width:180px;}
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
                closeOnEscape:true
            }).effect("slide", 300);
            $(".ui-widget-overlay").click(function () {
                $("#modal_dialog").dialog('close');
            });
        });


    });
</script>

<p class="module_title">OUR SUPER STAFF</p>
<div class="clearfix"></div>
<div id="modal_dialog"></div>
<div id="staff_list" class="standard_block">
    <?if (isset($staff_list) && count($staff_list) > 0) { ?>
    <div class="right_col highlight_red"><strong>Total: <?=count($staff_list) ?></strong></div>
    <div class="clearfix"></div>
    <div class="standard_block border_standard">
	<table class="table_standard table_left">
        <tr class="table_header">
            <td>No.</td>
            <!--            <td>Img</td>-->
            <td>Name</td>
            <td>Name</td>
            <td>Title</td>
            <td>Joined</td>
            <td>Username</td>
            <!--            <td>Mobile</td>-->
            <td colspan="3">Edit</td>
        </tr>
    <? $iCount = 0;
    foreach ($staff_list as $staff) {
        $iCount++;
        $imgurl = base_url('photos/staff') . '/';
        $imgurl .= ($staff->img == '') ? 'user.png' : $staff->img;
        ?>
        <tr>
            <td><?=$iCount?>.</td>
            <td><img class="staff_photo" realsrc="<?=$imgurl?>" src="<?=base_url('asset/base/images/loading.gif')?>" width="50px"/></td>
            <td><a href="<?=base_url('admin/staff/edit/'.$staff->id)?>"><?=$staff->name?></a></td>
            <td width="100px"><?=$staff->job_title?></td>
            <td><?=$staff->joined_on?></td>
            <td><?=$staff->staff_code?></td>
            <!--            <td>--><?//=$staff->m?><!--</td>-->
            <td title="Reset staff account to default password">
                <a class="icon_password_reset"  title="<?=$staff->password?>"
                   onclick="return confirm('Reset password for [<?=$staff->name?>]? Continue?')"
                   href="<?=base_url('admin/staff/reset-password/' . $staff->id)?>"></a>
            </td>
            <td title="Staff quited!">
                <a class="icon_leave" onclick="return confirm('[<?=$staff->name?>] quited the company already? Are you sure?')"
                   href="<?=base_url('admin/staff/quit/' . $staff->id)?>"></a>
            </td>
            <td title="NOT recommend. Delete staff info permanently">
                <a class="icon_x_red" onclick="return confirm('This will DELETE information of [<?=$staff->name?>] PERMANENTLY. \nAre you sure to continue?')"
                    href="<?=base_url('admin/staff/delete/' . $staff->id)?>"></a>
            </td>
        </tr>
        <? } ?>
    <? }?>
</table>
</div>
</div>
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