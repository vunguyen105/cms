<script>
    if (window.top == window) {
        // you're not in a frame so you reload the site
        window.setTimeout('location.reload()', 300000); //reloads after 5 minutes
    } else {
        //you're inside a frame, so you stop reloading
    }
</script>
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
<script>
    $(function () {
        $(".class_name").click(function (e) {
            e.preventDefault();
            var class_id = $(this).attr('id');
            var messageTitle = 'Teachers of class: ' + $(this).attr('title');

            $.post("<?=base_url('staff/teachers_by_class_a')?>", {class_id:class_id},
                function (response) {
                    $(".modal").html(response).dialog({
                        minHeight:120,
                        minWidth:300,
                        modal:true,
                        title:messageTitle,
                        closeText:"Close",
                        closeOnEscape:true,
                        position:{my:"left top", at:"right top", of:"#" + class_id}
                    }).hide().show();
                    $(".ui-widget-overlay").click(function () {
                        $(".modal").dialog('close');
                    });
                }).error(function (xhr, status, error) {
                    alert(xhr.statusText);
                });
        });
		
		$("#list_unsubmitted").click(function (e) {
			e.preventDefault();
			var ref_date=$("#txtDateReport").val();
            var url = "<?=base_url('ws/get_unsubmitted_classes')?>/" + ref_date;;
            var title = 'Unsubmitted classes of ' + ref_date;
			
            $(".modal").load(url).dialog({
                minHeight:300,
                minWidth:600,
                stack:false,
                modal:true,
                draggable:false,
                title:title,
                closeText:"Close",
                closeOnEscape:true
            }).effect("fadeIn", 100);

            $(".ui-widget-overlay").click(function () {
                $(".modal").dialog('close');
            });
        });
    });

</script>

<p class="module_title">Attendance Report</p>

<div class="modal"></div>
<div id="studentSearchForm" class="standard_block">
    <div title="Chọn ngày điểm danh!" class="grid_6">
        <form name="class_list" method="POST" action="<?=base_url('attendance/submit_admin')?>">
            <strong>Choose date:</strong>
            <input name="txtDateReport" type="text" class="datepicker" id="txtDateReport"
                   value="<?=$selected_date?>"/>
        </form>
    </div>
    <div class="right_col grid_6 align_right">
        Submitted: <strong><?=$count_submitted . '</strong>/' . count($all_classes_attendance) . ' classes.'?>
        <?=($count_absent > 1) ? '<strong>' . $count_absent . '</strong> students are absent.' : '<strong>' . $count_absent . '</strong> student is absent.'?>
    </div>
    <br/><br/>
</div>
<div class="clearfix" style="margin-bottom: 5px;"></div>
<a id="list_unsubmitted" href="abc" title="Click here to see which classes haven't submitted"><h6>Which classes haven't submitted?</h6></a>
<div class="standard_block border_standard grid_6" style="margin-left: 0;">
    <table class="table_standard">
        <tr class="table_header">
            <!--                    <td>No.</td>-->
            <td class="align_left">Class</td>
            <td>Status</td>
            <td>Updated by</td>
        </tr>

        <? if (count($all_classes_attendance) > 0) {
        $iCount = 0;
        foreach ($all_classes_attendance as $item) {
            $iCount++; ?>
            <tr class="table_body_row">
                <td class="align_left">
                    <a class="class_name" id="<?=$item->id?>" href="" title="<?=$item->class_name?>">
                        <?=$item->class_name?>
                    </a>
                </td>
                <td>
                    <?
                    if ($item->has_absent == '') {
                        $outputHTML = '<a title="Click to report this class as FULLY ATTENDED" href="' . base_url('attendance/do_submit_full/' . $item->id . '/' . $selected_date) . '"';
                        $outputHTML .= ' onclick="return confirm(\'Lớp ' . $item->class_name . ' đủ à? Is this class FULLY ATTENDED?\')"';
                        $outputHTML .= '>Full?</a>';
                        echo $outputHTML;
                    } else if ($item->has_absent == 0) echo '<a class="icon_checked_green" title="Fully attended. Lớp đủ."></a>';
                    else if ($item->has_absent == 1) {
                        ?>
                        <a class="icon_checked_red" title="Absent. Click to see details! Lớp vắng."
                           href="<?=base_url('attendance/report_absent/' . $item->id)?>"></a>
                        <? }?>
                </td>

                <?if ($item->updated_by == '') { ?>
                <td title="Hasn't submitted"></td>
                <? } else { ?>
                <td class="align_left" title="Submitted on <?=$item->updated_on?>">
                    <a class="staff_info_dialog" href="<?=base_url('staff/' . $item->staff_id)?>"><?=$item->updated_by?></a>
                </td>
                <? }?>
            </tr>
            <?
        }?>
        <tr>
            <td colspan="7">
                <a class="button_standard" href="<?=base_url(URL_ATTENDANCE_SUBMIT)?>">
                    <img src="<?=base_url('styles/img/register.png')?>" height="20px" width="20px"
                         alt="Submit new">
                    Submit</a>
            </td>
        </tr>
        <?
    } else {
        ?>
        <td colspan="7" style="font-style: italic;">No data!</td>
        <? }?>
    </table>
</div>
<div id="student_list" class="standard_block border_standard grid_6">
    <div class="box_title">
        <label class="table_title">Who are absent:</label>
    </div>

    <?if (isset($student_list)) { ?>

    <table class="table_standard">
        <tr class="table_header">
            <td>No.</td>
            <td>Class</td>
            <td class="align_left">Student name</td>
            <td>Edit</td>
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
                <td class="align_left"><?=$stu->class_name?></td>
                <td class="align_left" title="<?=$stu->comment?>">
                    <?=$stu->name?>
                    <?if ($stu->comment != '') { ?>
                    <img src="<?=base_url('styles/img/comment.png')?>" height="20px" width="20px" alt="Edit">
                    <? }?>
                </td>
                <td>
                    <a class="btn_person_checked" href="<?=base_url('attendance/came_already/' . $stu->id . '/' . $selected_date)?>"
                       onclick="return confirm('Bạn có chắc là học sinh \'<?=$stu->name?>\' đã đến trường không? Are you sure?')">
                    </a>
                </td>
            </tr>
            <?
        }?>
        <tr class="table_header">
            <td colspan="7"></td>
        </tr>
        <?
    } else {
        ?>
        <td class="align_left" colspan="7" style="font-style: italic;">No student is absent today!</td>
        <? }?>
    </table>
    <? }?>

</div>
