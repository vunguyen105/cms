<!--[if IE]>
<style type="text/css">
#staff_details {height: 350px; width: 650px;margin-bottom: 10px;}
#staff_details img {width: 200px; height: auto;}
</style>
<![endif]-->

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

<? $staff = $staff_info[0];
$imgurl = base_url('photos/staff') . '/';
$imgurl .= ($staff->img == '') ? 'user.png' : $staff->img;
?>
<p class="module_title">STAFF INFO</p>
<div id="staff_details">
    <div class="img_wrapper">
        <a class="ttest" target="_blank"
           href="<?=$imgurl?>">
            <img title="<?=$staff->name?>" src="<?=$imgurl?>"/>
            <div class="shadow"></div>
        </a>
    </div>
    <div class="staff_info">
        <table class="table_standard table_left">
            <tr>
                <td width="150px">Name:</td>
                <td width="100%"><?=$staff->name?></td>
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
                <td><a href="mailto:<?=$staff->email?>"><?=$staff->email?></a></td>
            </tr>
            <tr>
                <td>Other info:</td>
                <td></td>
            </tr>
            <?if ($this->permission->canAccessAdminPanel()) { ?>
            <tr>
                <td>Mobile:</td>
                <td><?=$staff->mobile?></td>
            </tr>

            <? }?>
        </table>
    </div>
</div>
