<script>
    $(function () {
        $('.txtDatePicker').datepicker({
            defaultDate:+1,
            beforeShowDay:$.datepicker.noWeekends,
            firstDay:+0,
            dateFormat:"yy-mm-dd",
            showCurrentAtPos:1,
            numberOfMonths:[1, 3],
            maxDate:"+1",
            onSelect:function (dateText, inst) {
                document.class_list.submit()
            }
        });
    });
</script>
<script type="text/javascript">
    function reloadClassList() {
        document.class_list.submit();
    }
</script>

<h2>Custom Report</h2>

<div id="studentSearchForm" class="standard_block border_square">
    <div title="Chọn khoảng thời gian muốn report!">
        <form name="class_list" method="GET" action="<?=base_url(URL_ATTENDANCE_REPORT_CUSTOM_TIME)?>">
            <strong>Class:</strong>
            <select name="class" onchange="reloadClassList()">
                <option value="">--All--</option>
                <?foreach ($class_list as $class) { ?>
                <option <?if ($class->id == $input_data['class']) echo "selected=true"?>
                    value="<?=$class->id?>"><?=$class->class_name?></option>
                <? }?>
            </select>
            <strong>From date:</strong> <input title="Tính từ ngày:" name="from" type="text"
                                               class="datepicker txtDatePicker"
                                               value="<?=$input_data['from']?>"/>
            <strong>To:</strong> <input title="Đến ngày:" name="to" type="text" class="datepicker txtDatePicker"
                                        value="<?=$input_data['to']?>"/>
            <input class="button_standard" type="submit" value="Generate"/>
        </form>
    </div>
</div>

<? if (isset($report_list)) { ?>
<div id="student_list" class="standard_block border_standard">
    <div class="box_title">
        <label class="table_title">Detailed list:</label>
        <span class="table_title grid_4 right_col align_right">
            Result: <strong><?=count($report_list)?></strong> students
        </span>
    </div>

    <table class="table_standard">
        <tr class="table_header">
            <td>No.</td>
            <td>Class</td>
            <td class="align_left">Student name</td>
            <td>Total Absent dates</td>
            <!--                    <td>Details</td>-->
        </tr>
        <? if (count($report_list) > 0) {
        $iCount = 0;
        foreach ($report_list as $stu) {
            $iCount++; ?>
            <tr class="table_body_row" title="Click to see more details about <?=$stu->name?>">
                <td><?=$iCount?>.</td>
                <td><?=$stu->class_name?></td>
                <td class="align_left">
                    <a href="<?=base_url(URL_ATTENDANCE_REPORT_BY_STUDENT . $stu->sid)?>"><?=$stu->name?></a>
                </td>
                <td title="<?=$stu->name . ': ' . $stu->count_absent_dates?> day(s)">
                    <? if ($stu->count_absent_dates > 0) { ?>
                    <strong style="color:red;"><?=$stu->count_absent_dates?></strong>
                    <?
                } else {
                    echo '0';
                }?>
                </td>
                <!--                        <td></td>-->
            </tr>
            <?
        }?>
        <tr>
            <td colspan="7">
                <p class="align_right">Result: <strong><?=count($report_list)?></strong> students
                </p>
            </td>
        </tr>
        <?
    } else {
        ?>
        <td class="align_left" colspan="7" style="font-style: italic;">Found no result!</td>
        <? } ?>
    </table>
</div>
<?
} else {
    echo "<p>Please (select class), choose start date, end date for the report!</p>";
}?>