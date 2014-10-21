<? $this->load->view('m/p_header'); ?>
<div data-role="page" id="attendance_submit">
    <div data-role="content">
        <form name="form_attendance" id="form_attendance" method="POST" action="<?=base_url('m/attendance_do_submit')?>">
            <div data-role="fieldcontain">
                <fieldset data-role="controlgroup">
                    <legend>Report Date:</legend>
                    <input name="txtDateReport" type="text" class="datepicker" id="txtDateReport"
                           value="<?=$selected_date?>" readonly="readonly"/>
                </fieldset>
            </div>
            <div data-role="fieldcontain">
                <fieldset data-role="controlgroup">
                    <legend>Select class:</legend>
                    <label for="cbxClassList">Select class:</label>
                    <select id="cbxClassList" name="select_class" data-native-menu="false">
                        <option value="">--Select--</option>
                        <?foreach ($class_list as $class) { ?>
                        <option value="<?=$class->id?>"><?=$class->class_name?></option>
                        <? }?>
                    </select>
                </fieldset>
            </div>
            <div data-role="fieldcontain">
                <fieldset data-role="controlgroup" data-type="horizontal">
                    <legend>Attendance Status:</legend>
                    <label for="radFull">FULL (Đủ)</label>
                    <input title="Lớp đủ" type="radio" name="radHasAbsent" id="radFull" value="0"/>
                    <label for="radNotFull">ABSENT (Vắng)</label>
                    <input title="Lớp vắng" type="radio" name="radHasAbsent" id="radNotFull" value="1"/>
                </fieldset>
            </div>
            <div id="student_list"></div>
            <div>
                <fieldset data-role="controlgroup" data-type="horizontal">
                    <input type="submit" value="Submit"/>
                    <input id="btnReset" type="reset" value="Cancel"/>
                </fieldset>
            </div>
        </form>
    </div>
</div>
</div>


<script>
    $(function () {
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
            $.post("<?= base_url('m/attendance_loadStudentList') ?>", {class_id:class_id, submit_date:submit_date},
                function (response) {
                    $('#student_list').html(response).fadeIn(300);
                    $("#student_list ul").listview();
                }).error(function (xhr, status, error) {
                    $('#student_list')
                        .html("<img width=\"20px\" src='<?= base_url('styles/img/cancel_red.png') ?>' />Sorry. Error happened!" + error)
                        .fadeIn(300);
                });

        }

        function hideStudentList() {
            $('#student_list').fadeOut();
        }

        // Validate form on client before submit
        $('#form_attendance').submit(function () {
            if (!$("#cbxClassList").val()) {
                alert('<?= MSG_WARN_MUST_SELECT_CLASS ?>');
                return false;
            }

            if (!$("input:radio[name='radHasAbsent']:checked").val()) {
                alert('<?= MSG_WARN_MUST_SELECT_FULL_ABSENT ?>');
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
    });
</script>


<? $this->load->view('m/p_footer'); ?>
