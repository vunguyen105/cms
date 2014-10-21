<? $stu = $student_list[0]; ?>

<p class="module_title" title="<?=$stu->id?>">Student Details</p>
<div class="standard_block">
    <form method="POST" action="<?=base_url('admin/student_do_transfer/'.$stu->id)?>">

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
        <tr class="table_header">
            <td colspan="3">
                Transfer to
            </td>
        </tr>
        <tr>
            <td class="td_label">Transfer to:</td>
            <td>
                <select name="select_class">
                    <option value="">--All--</option>
                    <?foreach ($campus_list as $cam) { ?>
                    <?foreach ($class_list as $class) { ?>
                        <option <?if ($class->id == $stu->class_id) echo "selected=true"?>
                            value="<?=$class->id?>"><?=$cam->name?> - <?=$class->class_name?></option>
                        <? }?>
                    <?}?>
                </select>
            </td>
            <td></td>
        </tr>
        <tr class="table_header">
            <td colspan="4">
                <input class="button_standard" type="submit" value="Submit"/>
                <input class="button_standard" type="reset" value="Cancel"/>
            </td>
        </tr>
    </table>
</form>
</div>