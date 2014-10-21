<script type="text/javascript">
    function reloadClassList() {
        document.class_list.submit();
    }
</script>
<? $this->load->view(CURRENT_THEME.'/includes/header_tags'); ?>
<? $this->load->view(CURRENT_THEME.'/includes/header'); ?>
<div class="grid_16">

    <p class="module_title">Nice report here:</p>

    <h2></h2>

    <div id="studentSearchForm" class=" border_standard standard_block">
        <div title="Chọn khoảng thời gian muốn report!">
            <form name="class_list" method="GET" action="<?=base_url('test/test_report')?>">
                <strong>Class:</strong>
                <select name="class" onchange="reloadClassList()">
                    <option value="">--All--</option>
                    <?foreach ($class_list as $class) { ?>
                    <option <?if ($class->id == $input_data['class']) echo "selected=true"?>
                        value="<?=$class->id?>"><?=$class->class_name?></option>
                    <? }?>
                </select>
                <strong>Select month:</strong>
                <select name="month" onchange="reloadClassList()">
                    <option value="">--All--</option>
                    <?for ($iMonth = 1; $iMonth < 13; $iMonth++) { ?>
                    <option <?if ($iMonth == $input_data['month']) echo "selected=true"?>
                        value="<?=$iMonth?>"><?=$iMonth?></option>
                    <? }?>
                </select>
                <input class="button_standard" type="submit" value="Generate"/>
            </form>
        </div>
    </div>
    <div class="clearfix" style="margin-bottom: 5px;"></div>

    <div id="student_list" class="standard_block border_standard">
        <div>
                <span class="grid_5">
                    <h6 style="color:orangered">Detailed list:</h6>
                </span>
                <span class="grid_4 right_col align_right" style="color: red;font-size: 8pt;">
                    Result: <strong><?=count($report_list)?></strong> students
                </span>
        </div>
        <table class="table_standard">
            <tr class="table_header">
                <td>Student Name</td>
                <td>Class</td>
                <? for ($iDate = 1; $iDate < 32; $iDate++) { ?>
                <td><?=$iDate?></td><? }?>
            </tr>
            <? foreach ($report_list as $stu) { ?>
            <tr>
                <td class="align_left"><?=$stu->name?></td>
                <td width="80px" class="align_center"><?=$stu->class_name?></td>
                <? for ($iDate = 1; $iDate < 32; $iDate++) {
                echo '<td width="15px">';
                if ($iDate == $stu->absent_day) {
                    echo 'A';
                }
                echo '</td>';
            } ?>
            </tr>
            <? }?>
        </table>

        <table class="table_standard">
            <tr class="table_header">
                <td>Student Name</td>
                <td>Class</td>
                <? for ($iDate = 1; $iDate < 32; $iDate++) { ?>
                <td><?=$iDate?></td><? }?>
            </tr>
            <tr>
                <td class="align_left"><?=$stu->name?></td>
                <td width="80px" class="align_center"><?=$stu->class_name?></td>

                <? for ($iDate = 1; $iDate < 32; $iDate++) {
                echo '<td width="15px">';
                if ($iDate == $stu->absent_day) {
                    echo 'A';
                }
                ?>

                <? foreach ($report_list as $stu) { ?>
                    <tr>
                    <td class="align_left"><?=$stu->name?></td>
                    <td width="80px" class="align_center"><?=$stu->class_name?></td>

                    <? } ?>
                <? }?>
            </tr>
        </table>


    </div>