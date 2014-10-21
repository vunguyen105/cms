<? $staff = $staff_info[0];
$imgurl = base_url('photos/staff') . '/';
$imgurl .= ($staff->img == '') ? 'user.png' : $staff->img;
?>
<!--[if IE]>
<style type="text/css">
#staff_details {height: 350px; width: 580px;margin-bottom: 10px;}
#staff_details img {width: 200px; height: auto;}
#staff_details td {font-size: 9pt;}
</style>
<![endif]-->
<p class="module_title">STAFF INFO</p>
<div id="staff_details">
    <div class="img_wrapper">
        <a class="ttest" target="_blank" href="<?=$imgurl?>" tabindex="-1">
            <img title="<?=$staff->name?>" src="<?=$imgurl?>"/>

            <div class="shadow" tabindex="-1"></div>
        </a>
    </div>
    <div class="staff_info">
        <table class="table_standard table_left">
            <tr>
                <td width="150px">Name:</td>
                <td width="100%" tabindex="0"><?=$staff->name?></td>
            </tr>
            <tr>
                <td>Title:</td>
                <td><?=$staff->job_title?></td>
            </tr>
            <tr>
                <td>Nationality:</td>
                <td><?=$staff->nation?></td>
            </tr>
            <tr>
                <td>E-mail:</td>
                <td><a tabindex="1" href="mailto:<?=$staff->email?>"><?=$staff->email?></a></td>
            </tr>
            <tr>
                <td>Other info:</td>
                <td>
                    <?if (count($classes_assigned) > 0) {
                    foreach ($classes_assigned as $class) {
                        echo "<label>" . $class->class_name . '</label>' . "<br/>";
                    }
                } else {
                    echo ".";
                }?>
                </td>
            </tr>
            <?if ($this->permission->canAccessAdminPanel()) { ?>
            <tr>
                <td>Mobile:</td>
                <td><?=$staff->mobile?></td>
            </tr>
            <?
            $modRequiredRoles = array(ROLE_SYSTEM);
            if ($this->permission->hasRoles($modRequiredRoles)) { ?>
                <tr>
                    <td></td>
                    <td><a class="button_standard" href="<?=base_url('admin/staff/edit/'.$staff->id)?>">Edit</a></td>
                </tr>
                <? } ?>
            <? }?>
        </table>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $(".ttest").click(function (e) {
            e.preventDefault();
//            var html = $(this).attr('href');
//            html = "<img src='"+html+"'/>";
//            var messageTitle = $(this).attr('title');
//
        });
    });
</script>