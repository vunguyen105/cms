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
    $(function () {
        <!-- Lazy load images -->
        $('.staff_photo').each(function (i) {
            var staff_photo = this;
            var img_src = $(this).attr('realsrc');
            var img = new Image();
            img.src = img_src;
            $(img).load(function () {
                staff_photo.src = this.src;
            }).height(50).width(50);
        });
    });
</script>
<script type="text/javascript">
    function reloadStaffList() {
        document.filter_staff.submit();
    }
</script>

<h2>OUR SUPER STAFF</h2>
<? if (isset($staff_list) && count($staff_list) > 0) { ?>
<div class="" id="studentSearchForm">
    <form method="GET" action="<?=base_url('staff/filter')?>" name="filter_staff">
        <label class="standard_label">Filter by group: </label>
        <select name="department" onchange="reloadStaffList()">
            <option value="">--All--</option>
            <?
            if (!isset($department)) {
                $department = "";
            }
            foreach ($position_list as $pos) {
                ?>
                <option
                    value="<?=$pos->department?>" <?=($pos->department == $department) ? " selected=true" : ""?>><?=$pos->department?></option>
                <? }?>
        </select>
        <span class="right_col"><strong>Total: <?=count($staff_list) ?></strong></span>
    </form>
</div>
<div id="staff_list">
<? $iCount = 0;
    foreach ($staff_list as $staff) {
        $iCount++;
        $imgurl = base_url('photos/staff') . '/';
        $imgurl .= ($staff->img == '') ? 'user.png' : $staff->img;
        ?>
        <a href="" title="Click to view bigger photo">
            <div title="Click to view details of <?=$staff->name?>"
                 class="staff_info_modal image-container place-left item_block">

                <img class="staff_photo" realsrc="<?=$imgurl?>" src="<?=base_url('asset/themes/_img/loadingfb.gif')?>"/>

                <div class="overlay">
                    <?=$staff->name?><br/>
                    <?=$staff->job_title?><br/>
                    <?if ($this->permission->canAccessAdminPanel()) { ?>
                    <?= $staff->mobile ?>
                    <? }?>
                </div>
            </div>
        </a>
        <? } ?>
    <? } ?>

</div>
