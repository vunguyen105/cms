<script>
    $(function () {
        $('#txtDateReport').datepicker({
            defaultDate:+1,
            beforeShowDay:$.datepicker.noWeekends,
            firstDay:+0,
            dateFormat:"yy-mm-dd",
            onSelect:function (dateText, inst) {
                document.class_list.submit();
            }
        });
    });
</script>
<script type="text/javascript">
    function reloadClassList() {
        document.class_list.submit();
    }
</script>
<p class="module_title">Attendance Detailed Report</p>

<div class="border_standard standard_block" id="studentSearchForm">
    <form name="class_list" method="POST" action="<?=base_url('attendance/absent-list')?>">
                    <span title="Chọn lớp của mình!">
                            <strong>Choose class:</strong>
                        <select name="select_class" onchange="reloadClassList()" style="width: 200px;">
                            <option value="">--All--</option>
                            <?foreach ($class_list as $class) { ?>
                            <option <?if ($class->id == $selected_class) echo "selected=true"?>
                                value="<?=$class->id?>"><?=$class->class_name?></option>
                            <? }?>
                        </select>
                    </span>
                    <span title="Chọn ngày điểm danh!" style="margin-left: 30px;">
                        <strong>Choose date:</strong>
                    <input name="txtDateReport" type="text" class="datepicker" id="txtDateReport"
                           value="<?=$selected_date?>"/>
                    </span>
    </form>
</div>
<div id="student_list" class="standard_block border_standard">
    <?if (isset($student_list)) { ?>

    <table class="table_standard">
        <tr class="table_header">
            <td>No.</td>
            <td class="align_left">Student name</td>
            <td>Class</td>
            <td>Comment</td>
            <td>Updated by</td>
            <td>Updated on</td>
            <td></td>
        </tr>
        <? if (count($student_list) > 0) {
        $iCount = 0;
        foreach ($student_list as $stu) {
            $iCount++; ?>
            <tr class="table_body_row">
                <td>
                    <?=$iCount?>.
                    <input name="txtStudentId" type="hidden" value="<?=$stu->id?>"/>
                </td>
                <td class="align_left"><?=$stu->name?></td>
                <td class="align_left"><?=$stu->class_name?></td>
                <td class="align_left"><?=$stu->comment?></td>
                <td class="align_left"><?=$stu->updated_by?></td>
                <td width="140px"><?=$stu->updated_on?></td>
                <td>
                    <!--<a class="btn_person_checked"
                        title="Click vào đây để báo '<?//=$stu->name?>' đã đến!"
                       href="<?//=base_url('attendance/came_already/' . $stu->id . '/' . $selected_date . '/' . $selected_class)?>"
                       onclick="return confirm('Bạn có chắc là học sinh \'<?//=$stu->name?>\' đã đến trường không?')">
                    </a>
					-->
                </td>
            </tr>
            <?
        }?>
        <tr>
            <td colspan="7">
                <a class="button_standard" href="<?=base_url(URL_ATTENDANCE_SUBMIT)?>">
                    <img src="<?=base_url('styles/img/register.png')?>" height="20px" width="20px"
                         alt="Submit new"> Submit new</a>
                <a class="button_standard" href="<?=base_url(URL_ATTENDANCE_REPORT_DAILY)?>">
                    <img src="<?=base_url('styles/img/report.png')?>" height="20px" width="20px"
                         alt="Submit new">School's report</a>
            </td>
        </tr>
        <?
    } else {
        ?>
        <td colspan="7" style="font-style: italic;">No data!</td>
        <? }?>
    </table>
    <?
} else {
    echo "Please select your class first!";
}?>

</div>
