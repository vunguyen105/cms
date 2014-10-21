<? $stu = $student_list[0]; ?>

<p class="module_title" title="<?=$stu->id?>">Student Details</p>
<div id="modal_dialog"></div>
<div class="standard_block">
    <table class="table_standard table_left">
        <tr class="table_header">
            <td width="180px">
                <label>Name: </label>
            </td>
            <td>
                <label class="name_color font_uppercase"><?=$stu->name?></label>
            </td>
        </tr>
        <tr>
            <td class="td_label"><label>Gender: </label></td>
            <td><?=($stu->gender == 1) ? 'Male' : 'Female'?></td>
        </tr>
        <tr>
            <td>Class:</td>
            <td>
                <?=$stu->class_name?>
            </td>
        </tr>
        <tr>
            <td class="td_label"><label>Date of birth:</label></td>
            <td><?=$stu->dob?></td>
        </tr>
        <tr>
            <td class="td_label"><label>Enrollment date:</label></td>
            <td><?=$stu->doe?></td>
        </tr>
        <tr>
            <td class="td_label">Nationality:</td>
            <td>
                <?=$stu->nation?>
            </td>
        </tr>
        <tr>
            <td class="td_label">Other</td>
            <td>
                Last modified on: <?=$stu->modified_on?>
                <?if ($stu->modified_by){?>by <strong><a class="staff_info_modal" href="<?=base_url('staff/'.$stu->modified_by)?>">Staff <?=$stu->modified_by?></a></strong><?}?>
            </td>
        </tr>
        <tr class="table_header">
            <td colspan="4">
                <a class="button_standard" href="<?=base_url('admin/student/edit/' . $stu->id)?>">Edit</a>
                <a class="button_standard" href="<?=base_url('admin/student/transfer/' . $stu->id)?>">Transfer</a>
                <a onclick="return confirm('Are you sure to withdraw this student?')" class="button_standard" href="<?=base_url('admin/student/withdraw/' . $stu->id)?>">Withdraw</a>
                <a onclick="return confirm('Are you sure to DELETE PERMANENTLY this student?')" class="button_standard" href="<?=base_url('admin/student/delete/' . $stu->id)?>">Delete</a>
                <a class="button_standard" href="<?=base_url('admin/student')?>">Show class list</a>
            </td>
        </tr>
    </table>
</div>
<script type="text/javascript">
    $(function () {
        $(".staff_info_modal").click(function (e) {
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
    });
</script>
