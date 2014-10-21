<?if (isset($student_list) && count($student_list) > 0) { ?>
<script type="text/javascript">
    $(function(){
        $('.photo').each(function(i) {
            var img_src = $(this).attr('realsrc');
            var photo = this;
            var img = new Image();
            img.src = img_src;
            $(img).load(function() {
                photo.src = this.src;
            });
        });
    });
</script>
<div class="right_col highlight_red"><strong>Total result: <?=count($student_list) ?></strong></div>
<table class="table_standard">
    <tr class="table_header">
        <td width="10px">No.</td>
        <td width="200px" class="align_left">Student name</td>
        <td>Gender</td>
        <td>Class</td>
        <td>Nationality</td>
        <td>Enrolled on</td>
        <td>Status</td>
        <td>Details</td>
        <td>Edit</td>
    </tr>
    <? $iCount = 0;
    foreach ($student_list as $stu) {
        $iCount++;
        $imgurl = base_url('photos/students') . '/';
        $imgurl .= ($stu->img == '') ? 'user.png' : $stu->img;
        ?>
        <tr class="table_body_row">
            <td class="align_center">
                <?=$iCount?>.
                <input name="txtStudentId[<?=$stu->id?>]" type="hidden" value="<?=$stu->id?>"/>
            </td>
            <td class="align_left"><a
                href="<?=base_url('admin/student/details/' . $stu->id)?>">
                <?=$stu->name?></a>
            </td>
<!--            <td><a class="icon_gender_--><?//=($stu->gender == 1) ? 'male' : 'female'?><!--"></a></td>-->
            <td><?=($stu->gender == 1) ? 'M' : 'F'?></td>
            <td><?=$stu->class_name?></td>
            <td>
                <a
                    href="<?=base_url('admin/student/details/' . $stu->id)?>">
                    <img class="photo" realsrc="<?=$imgurl?>" src="<?=base_url('asset/themes/_img/loadingfb.gif')?>" style="max-width: 70px"/>
                    </a>
            </td>
            <td><?=$stu->doe?></td>
            <td><a class="<?=($stu->status == 1) ? 'icon_checked_green' : 'icon_inactive'?>"></a></td>
            <td><a href="<?=base_url('admin/student/details/' . $stu->id)?>" class="btn_detail"></a></td>
            <td><a href="<?=base_url('admin/student/edit/' . $stu->id)?>" class="btn_edit"></a></td>
        </tr>
        <? }?>
    <tr class="table_header">
        <td colspan="9">
            <!--<a class="button_standard" href="<?//=base_url('student/export_excel')?>">Export to Excel</a>-->
        </td>
    </tr>
</table>
<?
} else {
    echo "Select class, input student name,.. then click on SEARCH button to list students.";
    echo "<br/><br/><br/><br/>";
}?>