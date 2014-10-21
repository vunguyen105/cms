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
            showOn:"both",
            buttonImage:"<?=base_url('asset/themes/_img/calendar.gif')?>",
            buttonImageOnly:true,
            buttonText:"Click to select report date",
            beforeShowDay:$.datepicker.noWeekends,
            defaultDate:0,
            firstDay:+1,
            maxDate:0,
            dateFormat:"yy-mm-dd",
            onSelect:function (dateText, inst) {
                document.class_list.submit();
            }
        });
        $(".ttest").click(function (e) {
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

        $(".class_name").click(function (e) {
            e.preventDefault();
            var class_id = $(this).attr('id');
            var messageTitle = 'Teachers of class: ' + $(this).attr('title');
            $.post("<?=base_url('staff/teachers_by_class')?>", {class_id:class_id},
                function (response) {
                    $("#modal_dialog").html(response).dialog({
                        minHeight:120,
                        minWidth:300,
                        maxHeight:400,
                        maxWidth:300,
                        modal:true,
                        title:messageTitle,
                        closeText:"Close",
                        closeOnEscape:true,
                        position:{my:"left top", at:"right top", of:"#" + class_id},
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
                }).error(function (xhr, status, error) {
                    alert(xhr.statusText);
                });
        });
        $('#btn_rank_board,#btn_hide_rank').click(function (e) {
            $('#rank_board').slideToggle('100');
        });
    })
    ;
</script>
<script type="text/javascript">
    function reloadClassList() {
        document.class_list.submit();
    }
</script>
<div id="modal_dialog"></div>
<p class="module_title">Attendance Report</p>
<div id="studentSearchForm" class="standard_block border_square">
    <div title="Chọn ngày điểm danh!" class="grid_6">
        <form name="class_list" method="GET" action="<?=base_url(URL_ATTENDANCE_REPORT_DAILY)?>">
            <strong>Report date:</strong>
            <input name="date" type="text" class="datepicker" id="txtDateReport"
                   value="<?=$selected_date?>"/>
        </form>

    </div>
    <div class="grid_6 right_col align_right">
        <div class="highlight_note">
            Submitted: <strong><?=$count_submitted . '</strong>/' . count($all_classes_attendance) . ' classes.'?>
            <?=($count_absent > 1) ? '<strong>' . $count_absent . '</strong> students are absent.' : '<strong>' . $count_absent . '</strong> student is absent.'?>
        </div>
    </div>
    <br/><br/>
</div>
<? if (count($best_staff) > 0) { ?>
<div class="align_center">
    <input id="btn_rank_board" type="button" title="Ranking starts from 8:30 AM" value="..:: TOP 3 ::..">
</div>
<div id="rank_board" style="background: #044062;border: 1px solid;text-align: center" title="Ranking starts from 8:30 AM">
    <img id="btn_hide_rank" src="<?=base_url('asset/themes/_img/x.png')?>" style="float: right" title="Click to hide this panel"/>
    <img src="<?=base_url('asset/themes/_img/tip_info.png')?>" style="float: right" title="To keep it fair, only submissions taken from 8:30 AM & afterward are eligible for ranking. You can still submit before 8:30 AM but it won't be counted for ranking."/>
    
    <ul style="display: inline-block;">
        <?$iCount = 0;
        foreach ($best_staff as $item) {
            $iCount++;
            $objSubmitTime = new DateTime($item->updated_on);
            $objSubmitTime = $objSubmitTime->format('H:i:s');
            ?>
            <li style="width: 90px;float: left;text-align: center;color: #b3c7e1;">
                <a class="ttest"
                   href="<?=base_url('staff/' . $item->staff_id)?>">
                    <img src="<?=base_url('photos/staff/' . $item->img)?>" width="90px"
                         title="<?=$item->updated_by . ' - ' . $objSubmitTime?>">

                </a>

                <p>
                    <img src="<?=base_url('asset/themes/_img/medal' . $iCount . '.png')?>" width="30px" alt=""><br/>
                    <label><?=$item->class_name?></label><br/>

                <p><?=$objSubmitTime?></p>
                </p>

            </li>
            <? }?>
    </ul>

</div>
<? }?>
<div class="clearfix" style="margin-bottom: 5px;"></div>
<div class="standard_block border_standard grid_6" style="margin-left: 0;">
    <div class="box_title">
        <label class="table_title">All Classes</label>
    </div>
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
                    <a id="<?=$item->id?>" class="class_name" title="<?=$item->class_name?>" href="">
                        <?
                        $objSubmitTime = new DateTime($item->updated_on);
                        $objSubmitTime = $objSubmitTime->format('H:i:s');
                        if ($objSubmitTime > DEADLINE_ATTENDANCE_SUBMIT) {
                            ?>
                            <label style="color: red;font-weight:normal"><?=$item->class_name?></label>
                            <img class="late_img" src="<?=base_url('asset/themes/_img/emoticon_sad.png')?>" height="20px"
                                 title="Late..">
                            <? } else { ?>
                            <?= $item->class_name ?>
                            <? }?>
                    </a>
                </td>
                <td>
                    <?
                    if ($item->has_absent == '') {
                        echo '<p title="Not submitted yet!">..</p>';
                    } else if ($item->has_absent == 0) {
                        ?>
                        <a class="icon_checked_green" title="Fully attended. Lớp đủ."></a>
                        <?
                    } else if ($item->has_absent == 1) {
                        ?>
                        <a class="icon_checked_red" title="Absent. Click to see details! Lớp vắng."
                           href="<?=base_url('attendance/report_absent/' . $item->id)?>"></a>
                        <? }?>
                </td>
                <?if ($item->updated_by == '') { ?>
                <td title="Hasn't submitted"></td>
                <? } else { ?>
                <td class="align_left" title="Submitted on <?=$item->updated_on?>">
                    <a class="ttest" href="<?=base_url('staff/' . $item->staff_id)?>">
                        <?=$item->updated_by?>
                    </a>
                </td>
                <? }?>

            </tr>
            <?
        }?>
        <!--<tr>
            <td colspan="3">
                <a class="button_standard" title="Submit attendance for your class"
                   href="<?/*=base_url(URL_ATTENDANCE_SUBMIT)*/?>">
                    <img src="<?/*=base_url('asset/themes/_img/register.png')*/?>" height="20px" width="20px"
                         alt="Submit new">
                    Submit</a>
            </td>
        </tr>-->
        <?
    } else {
        ?>
        <td colspan="3" style="font-style: italic;">No data!</td>
        <? }?>
    </table>
</div>
<div id="student_list" class="standard_block border_standard grid_6">
    <div class="box_title">
        <label class="table_title">Absent students</label>
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
                    <img src="<?=base_url('asset/themes/_img/comment.png')?>" height="20px" width="20px" alt="Edit">
                    <? }?>
                </td>
                <? if ($selected_date == date('Y-m-d')) { ?>
                <td>
                    <a class="btn_person_checked"
                       title="Click vào đây để báo '<?=$stu->name?>' đã đến! Click to inform that '<?=$stu->name?>' came."
                       href="<?=base_url('attendance/came_already/' . $stu->id . '/' . $selected_date)?>"
                       onclick="return confirm('\'<?=$stu->name?>\' đã đến trường? Are you sure (s)he arrived?')">
                    </a>
                </td>
                <? }?>
            </tr>
            <?
        }?>
        <tr>
            <td colspan="7">
                <a class="button_standard" href="<?=base_url('attendance/report_absent')?>">
                    <img src="<?=base_url('asset/themes/_img/report.png')?>" height="20px" width="20px"
                         alt="Absent list">
                    Details</a>
            </td>
        </tr>
        <?
    } else {
        ?>
        <td class="align_left" colspan="7" style="font-style: italic;">No student is absent today!</td>
        <? }?>
    </table>
    <?
} else {
    echo "Please select your class first!";
}?>
</div>