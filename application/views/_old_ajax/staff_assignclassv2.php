<script>
    $(function () {
        $("input[name=ckbAssignStaff]:checked").live('click', function (e) {
            if (!confirm('Are you sure?')) {
                return false;
            }

            var staff_id = $(this).attr('id');
            var class_id = $("#cbxClassList").val();
            var note = $("#txtNote" + staff_id).val();

            $.post("<?=base_url('admin/staff_do_assign')?>", {sid:staff_id, cid:class_id, note:note},
                function (response) {
                    $('#msg_holder' + staff_id)
                        .html("")
                        .hide()
                        .fadeIn(500, function () {
                            $('#msg_holder' + staff_id).append("<img width=\"20px\" src='<?=base_url('styles/img/accept-24.png')?>' />");
                        });
                }).error(function (xhr, status, error) {
                    $('#msg_holder' + staff_id)
                        .html("")
                        .hide()
                        .fadeIn(500, function () {
                            $('#msg_holder' + staff_id).append("<img width=\"20px\" src='<?=base_url('styles/img/x.png')?>' />");
                        });

                });
        });
    });

</script>
<script type="text/javascript">
    function reloadClassList() {
        document.class_list.submit();
    }
</script>
<p class="module_title">Assign staff to class</p>

<div id="student_list" class="standard_block border_standard">
    <?if (!isset($class_list)) {
    echo 'no class data';
} ?>

    <div title="Chọn lớp!">
        <table class="table_standard">
            <tr class="table_header">
                <td>No.</td>
                <td class="align_left">Class name</td>
                <td>Assign</td>
                <td class="align_left">Note</td>
            </tr>

            <? if (isset($class_list)) {
            $iCount = 0;
            foreach ($class_list as $class) {
                $iCount++; ?>
                <tr>
                    <td>
                        <?=$iCount?>.
                        <input name="txtClassId[<?=$class->id?>]" type="hidden" value="<?=$class->id?>"/>
                    </td>
                    <td class="align_left"><?=$class->class_name?></td>
                    <td id="msg_holder<?=$class->id?>">

                    </td>
                    <td class="align_left">
                    </td>
                </tr>
                <?
            }
        }?>
            <tr class="table_header">
                <td colspan="4" class="align_center">
                    <a class="button_standard" href="<?=base_url('admin/staff/assign')?>"
                       title="Attendance report for today">Refresh</a>
                </td>
            </tr>
        </table>
        <strong>Select your class: </strong>

        <form name="class_list" action="<?=base_url('admin/staff/assign')?>" method="POST">
            <select id="cbxClassList" name="select_class" onchange="reloadClassList()">
                <option value="">--Select your class--</option>
                <?foreach ($class_list as $class) { ?>
                <option
                    value="<?=$class->id?>" <?if ($class->id == $selected_class) echo 'selected="true"'?>><?=$class->class_name?></option>
                <? }?>
            </select>
        </form>
    </div>
    <div>
        <table class="table_standard">
            <tr class="table_header">
                <td>No.</td>
                <td class="align_left">Staff name</td>
                <td>Assign</td>
                <td class="align_left">Note</td>
            </tr>

            <? if (isset($staff_list)) {
            $iCount = 0;
            foreach ($staff_list as $staff) {
                $iCount++; ?>
                <tr>
                    <td>
                        <?=$iCount?>.
                        <input name="txtStaffId[<?=$staff->id?>]" type="hidden" value="<?=$staff->id?>"/>
                    </td>
                    <td class="align_left"><?=$staff->name?></td>
                    <td id="msg_holder<?=$staff->id?>">
                        <input id="<?=$staff->id?>" name="ckbAssignStaff" type="checkbox" value="<?=$staff->id?>"
                            <?if ($staff->sid != '') echo ' checked="true"'?>/>
                    </td>
                    <td class="align_left">
                        <input id="txtNote<?=$staff->id?>" name="txtNote<?=$staff->id?>" value="<?=$staff->note?>"/>
                    </td>
                </tr>
                <?
            }
        }?>
            <tr class="table_header">
                <td colspan="4" class="align_center">
                    <a class="button_standard" href="<?=base_url('admin/staff/assign')?>"
                       title="Attendance report for today">Refresh</a>
                </td>
            </tr>
        </table>
    </div>

</div>
