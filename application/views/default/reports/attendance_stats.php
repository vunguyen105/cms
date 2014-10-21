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
    function report_export(){
        window.location = "/attendance/custom-report-export?"+$("#form_export").serialize();
		
    	return false;
    }
</script>

<p class="module_title">Custom Report</p>

<div id="studentSearchForm" class="standard_block border_square">
    <div title="Chọn khoảng thời gian muốn report!">
        <form id='form_export' name="class_list" method="GET" action="<?=base_url(URL_ATTENDANCE_REPORT_STATS)?>">
            <strong>Grade:</strong>
            <select name="class" onchange="reloadClassList()">
                <option value="">--Select--</option>
                <?foreach ($class_list as $class) { ?>
                <option <?if ($class->grade == $input_data['class']) echo "selected=true"?>
                    value="<?=$class->grade?>"><?php if($class->grade == 0) echo "Prep"; else echo $class->grade?></option>
                <? }?>
            </select>
            <strong>From date:</strong> <input title="Tính từ ngày:" name="from" type="text"
                                               class="datepicker txtDatePicker"
                                               value="<?=$input_data['from']?>"/>
            <strong>To:</strong> <input title="Đến ngày:" name="to" type="text" class="datepicker txtDatePicker"
                                        value="<?=$input_data['to']?>"/>
										<br>
										<br>
             <strong>The number of shool days:</strong> <input name='day' onchange=" return reloadClassList();" type="text" value="<?php if($input_data['day'] == "") echo 200;else echo $input_data['day'];?>"/>
        </form>
    </div>
</div>
<div class="clearfix" style="margin-bottom: 5px;"></div>

<? if (isset($sum_student)) { ?>
<div id="student_list" class="standard_block border_standard">
   
    <table class="table_standard">
        <tr class="table_header">
            <td>Grade</td>
			<td>Attended days</td>
            <td>Attendance percentage</td>
			
			
        </tr>
            <tr class="table_body_row" title="Click to see more details about">
                <td><?php if($year == 0) echo "Prep";else echo $year;?></td>
				<?php //echo $sum; die;?>
				<?php $day =($input_data['day'] == "")? 200: (int)$input_data['day'];// echo $sum;die; ($sum_student*$day - $sum)."  ".$sum_student*$day;die;
				$percentage = ($sum_student*$day - $sum)*100/($sum_student*$day)?>
				<td><?php echo $sum_student*$day - $sum;?></td>
                <td><?php echo number_format($percentage,2,',',' ')." %";?></td>
				 
            </tr>
    </table>
</div>
<?
} else {
    echo "Please (select grade), choose start date, end date for the report!";
}?>