<!--Head.start-->
<? $this->load->view('includes/header_tags'); ?>
<script>
    $(function () {
        $('.txtDatePicker').datepicker({
            defaultDate:+1,
            beforeShowDay:$.datepicker.noWeekends,
            firstDay:+0,
            dateFormat:"yy-mm-dd",
            showCurrentAtPos: 1,
            numberOfMonths: [1, 3],
            maxDate: "+1",
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
</head>
<!--Head.end-->
<!--Body.start-->
<body xmlns="http://www.w3.org/1999/html">
<!--Upper header.start-->
<? $this->load->view('includes/header_menu_top'); ?>
<!--Upper header.end-->
<div id="container" class="container_16">
    <!--Header.start-->
    <? $this->load->view('includes/header'); ?>
    <!--Header.end-->

    <!--Body Left Column.start-->
    <? $this->load->view('includes/body_left_side'); ?>
    <!--Body Left Column.end-->

    <!--Body Middle Column.start-->
    <div class="grid_13">
        <p class="module_title">Custom Report</p>

        <div id="studentSearchForm" class="grid_12 border_standard standard_block">
            <div title="Chọn khoảng thời gian muốn report!">
                <form name="class_list" method="GET" action="<?=base_url('monthly-report-details')?>">
                    <strong>Class:</strong>
                    <select name="class" onchange="reloadClassList()">
                        <option value="">--All--</option>
                        <?foreach ($class_list as $class) { ?>
                        <option <?if ($class->id == $input_data['class']) echo "selected=true"?>
                            value="<?=$class->id?>"><?=$class->name?></option>
                        <? }?>
                    </select>
                    <strong>From date:</strong> <input title="Tính từ ngày:" name="from" type="text" class="datepicker txtDatePicker"
                                                       value="<?=$input_data['from']?>"/>
                    <strong>To:</strong> <input title="Đến ngày:" name="to" type="text" class="datepicker txtDatePicker"
                                                value="<?=$input_data['to']?>"/>
                    <input class="button_standard" type="submit" value="Generate"/>
                </form>
            </div>
        </div>
        <div class="clearfix" style="margin-bottom: 5px;"></div>

        <?if (isset($report_list)) { ?>
        <div id="student_list" class="standard_block border_standard grid_12">
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
                    <tr class="table_body_row">
                        <td><?=$iCount?>.</td>
                        <td><?=$stu->class_name?></td>
                        <td class="align_left"><?=$stu->name?></td>
<!--                        <td title="--><?//=$stu->name.': '.$stu->count_absent_dates?><!-- day(s)">-->
<!--                            --><?// if ($stu->count_absent_dates > 0) { ?>
<!--                            <strong style="color:red;">--><?//=$stu->count_absent_dates?><!--</strong>-->
<!--                            --><?//
//                        } else {
//                            echo '0';
//                        }?>
<!--                        </td>-->
                        <td><?=$stu->absent_date?></td>
                    </tr>
                    <?
                }?>
                <tr class="table_header">
                    <td colspan="7">
                        <p class="align_right" style="color: red;">Result: <strong><?=count($report_list)?></strong> students</p>
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
    </div>
    <!--Body Middle Column.end-->
</div>
<!--Footer.start-->
<? $this->load->view('includes/footer_menu'); ?>
<? $this->load->view('includes/footer'); ?>
<!--Footer.end-->