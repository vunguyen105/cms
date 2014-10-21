﻿<? $this->load->view(CURRENT_THEME.'/includes/header_tags'); ?>
<script>
    $(function () {
        $("#radio").buttonset();
        $('#txtDateReport').datepicker({
            defaultDate:+1,
            beforeShowDay:$.datepicker.noWeekends,
            firstDay:+1,
			maxDate:0,
			minDate:-30,
            dateFormat:"yy-mm-dd",
            onSelect:function (dateText, inst) {
                reloadData();
            }
        });

        $("#cbxClassList").change(function () {
            reloadData();
        });

        // Display/ Hide Student List
        $("#radFull").click(function () {
            hideStudentList();
        });
        $("#radNotFull").click(function () {
            loadStudentList();
        });
        $("#btnReset").click(function () {
            hideStudentList();
        });

        // Display/hide as well as reload data when params changed
        function reloadData() {
            if ($("input:radio[name='radHasAbsent']:checked").val()) {
                if ($("input:radio[name='radHasAbsent']:checked").val() == 1) {
                    loadStudentList();
                } else {
                    hideStudentList();
                }
            }
        }

        function loadStudentList() {
            var class_id = $("#cbxClassList").val();
            var submit_date = $("#txtDateReport").val();

            if (class_id == '') {
                hideStudentList();
                return false;
            }

            $.post("<?=base_url('attendance/loadStudentList')?>", {class_id:class_id, submit_date:submit_date},
                function (response) {
                    $('#student_list').html(response).fadeIn(500);
                }).error(function (xhr, status, error) {
                    $('#student_list')
                        .html("<img width=\"20px\" src='<?=base_url('asset/themes/_img/cancel_red.png')?>' />Sorry. Error happened!")
                        .fadeIn(500);
                });
        }

        function hideStudentList() {
            $('#student_list').fadeOut();
        }

        // Validate form on client before submit
        $('#form_attendance').submit(function () {
            if (!$("#cbxClassList").val()) {
                alert('<?=MSG_WARN_MUST_SELECT_CLASS?>');
                return false;
            }

            if (!$("input:radio[name='radHasAbsent']:checked").val()) {
                alert('<?=MSG_WARN_MUST_SELECT_FULL_ABSENT?>');
                return false;
            } else if ($("input:radio[name='radHasAbsent']:checked").val() == 1) {
                // if no checkbox has been checked
                if ($("form input:checkbox:checked").length < 1) {
                    alert('Please select the absent students!');
                    return false;
                }
            }

            return confirm("Continue to submit? \nGửi đi nhé?");
        });

        /*$("#header").mouseover(function () {
            $("#header").css('height','400px');
        });
        $("#header").mouseleave(function () {
            $("#header").css('height','100px');
        });*/
//
    });
</script>

<? $this->load->view(CURRENT_THEME.'/includes/header'); ?>
<? $this->load->view(CURRENT_THEME.'/includes/body_left_side') ?>
<div class="grid_13">
    <p class="module_title align_left">Submit Attendance</p>

    <div class="grid_9 standard_block align_center">
        <form name="form_attendance" id="form_attendance" method="POST"
              action="<?=base_url('attendance/do_submit')?>">
            <div style="font-size: 10pt; margin-top: 10px">
                <label for="cbxClassList">Select your class:</label>
                <select id="cbxClassList" name="select_class" onchange="">
                    <option value="">Select your class</option>
                    <?foreach ($class_list as $class) { ?>
                    <option value="<?=$class->id?>"><?=$class->class_name?></option>
                    <? }?>
                </select>
                <label for="txtDateReport">Date:</label>
                <input name="txtDateReport" type="text" class="datepicker" id="txtDateReport"
                       value="<?=$selected_date?>" readonly="readonly"/>
            </div>
            <br/>
            <div class="standard_block">
                <div id="radio">
                    <label for="radFull">FULLY attended (Đủ)</label>
                    <input title="Lớp đủ" type="radio" name="radHasAbsent" id="radFull" class="radio_button"
                           value="0"/>
                    <label for="radNotFull">NOT full (Vắng)</label>
                    <input title="Lớp vắng" type="radio" name="radHasAbsent" id="radNotFull" class="radio_button"
                           value="1"/>
                </div>
                <br/>

                <div>
                    <input class="button_standard temp_button button_submit" type="submit" value="Submit"
                           title="Send to Admin staff"/>
                    <input class="button_standard temp_button" id="btnReset" type="reset" value="Cancel"/>
                    <a class="button_standard" href="<?=base_url(URL_ATTENDANCE_REPORT_DAILY)?>">View report</a>
                </div>
            </div>
            <div id="student_list" class="standard_block"></div>
        </form>
    </div>
</div>
<? $this->load->view(CURRENT_THEME.'/includes/footer'); ?>
