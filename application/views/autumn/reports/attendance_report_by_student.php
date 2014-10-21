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
//                document.class_list.submit();
            }
        });
    });
</script>
<script type="text/javascript">
    function reloadClassList() {
        document.class_list.submit();
    }
</script>

<p class="module_title">Student Report For This School Year</p>
<? if (isset($report_list)) { ?>
<div id="student_list" class="standard_block border_standard grid_12">
    <div class="box_title">
        <label class="table_title">Detailed list:</label>
        <span class="table_title grid_4 right_col align_right">
            Total: <strong><?=count($report_list)?></strong> time(s)
        </span>
    </div>

    <table class="table_standard">
        <tr class="table_header">
            <td>No.</td>
            <td>Class</td>
            <td class="align_left">Student name</td>
            <td>Absent dates</td>
            <td>Comments</td>
        </tr>
        <? if (count($report_list) > 0) {
        $iCount = 0;
        foreach ($report_list as $stu) {
            $iCount++; ?>
            <tr class="table_body_row">
                <td><?=$iCount?>.</td>
                <td><?=$stu->class_name?></td>
                <td class="align_left"><?=$stu->name?></td>
                <td><?=$stu->absent_date?></td>
                <td><?=$stu->comment?></td>
            </tr>
            <?
        }?>
        <tr class="table_header">
            <td colspan="7">
                <p class="align_right">Total: <strong><?=count($report_list)?></strong> time(s)</p>
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
    echo "Please (select class), choose start date, end date for the report!";
}?>