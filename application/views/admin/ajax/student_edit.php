<script>
    $(function () {
        $('.txtDatePicker').datepicker({
            defaultDate:+1,
            firstDay:+0,
            changeMonth:true,
            changeYear:true,
            dateFormat:"yy-mm-dd"
        });
    });
</script>
<p class="module_title">Edit Student Details</p>
<? $stu = $student_list[0]; ?>
<div class="standard_block">
<form method="POST" action="<?=base_url('admin/student/do-edit/' . $stu->id)?>" enctype="multipart/form-data">
<input name="txtStudentId" type="hidden" value="<?=$stu->id?>"/>
<table class="table_standard table_left">
<tr class="table_header">
    <td colspan="3">
        Student information
    </td>
</tr>
<tr>
    <td width="150px">Name:</td>
    <td width="300px">
        <input name="name" type="text" class="textbox_fullw" value="<?=$stu->name?>"/>
    </td>
    <td rowspan="7">
        <?
        $imgurl = base_url('photos/students') . '/';
        $imgurl .= ($stu->img == '') ? 'user.png' : $stu->img;
        ?>
        <img title="<?=$stu->name?>" src="<?=$imgurl?>" width="200px"/>
        <br/>
        <input type="file" name="photo" id="photo" size="50"/>(max 500KB)
    </td>
</tr>
<tr>
    <td>Gender:</td>
    <td>
        Male <input type="radio" name="radGender"
                    value="1" <?=($stu->gender == 1) ? ' checked="true"' : ''?>>
        Female <input type="radio" name="radGender"
                      value="0" <?=($stu->gender == 0) ? ' checked="true"' : ''?>>
    </td>
</tr>
<tr>
    <td>Class:</td>
    <td>
        <select id="cbxClassList" name="select_class">
            <option value="">--All--</option>
            <?foreach ($class_list as $class) { ?>
            <option <?if ($class->id == $stu->class_id) echo "selected=true"?>
                value="<?=$class->id?>"><?=$class->class_name?></option>
            <? }?>
        </select>
    </td>

</tr>
<tr>
    <td class="td_label">Date of birth:</td>
    <td>
        <input name="dob" type="text" class="datepicker txtDatePicker" id="txtDateOfBirth"
               value="<?=$stu->dob?>"/>
    </td>
</tr>
<tr>
    <td>Status:</td>
    <td>
        Active <input type="radio" name="radStatus"
                      value="1" <?=($stu->status == 1) ? ' checked="true"' : ''?>/>
        Inactive <input type="radio" name="radStatus"
                        value="0" <?=($stu->status == 0) ? ' checked="true"' : ''?>/>
    </td>
</tr>
<tr>
    <td class="td_label">Enrollment date:</td>
    <td>
        <input name="doe" type="text" class="datepicker txtDatePicker" id="txtDateOfEnroll"
               value="<?=$stu->doe?>"/>
    </td>
</tr>
<tr>
    <td class="td_label">Nationality:</td>
    <td>
        <input name="nationality" type="text" value="<?=$stu->nation?>"/>
    </td>
</tr>
<tr>
    <td class="td_label">Student Code:</td>
    <td>
        <input name="student_code" type="text" value="<?=$stu->code?>"/>
    </td>
    <td></td>
</tr>
<tr>
    <td class="td_label">MConline:</td>
    <td>
        <input name="mconline" type="text" value="<?=$stu->mconline?>"/>
    </td>
    <td></td>
</tr>

<!--<tr class="table_header">
                <td colspan="3">
                    Parents information
                </td>
            </tr>
            <tr>
                <td class="td_label">Father:</td>
                <td>
                    <input name="father" type="text" class="textbox_fullw" value="<?/*=$stu->father_name*/?>"/>
                </td>
                <td></td>
            </tr>
            <tr>
                <td class="td_label">
                    - Passport No.:
                </td>
                <td>
                    <input name="fpassport" type="text" value="<?/*=$stu->father_passport*/?>"/><br/>
                </td>
                <td></td>
            </tr>
            <tr>
                <td class="td_label">
                    - Company:
                </td>
                <td>
                    <input name="fcompany" type="text" value="<?/*=$stu->father_company*/?>"/><br/>
                </td>
                <td></td>
            </tr>
            <tr>
                <td class="td_label">
                    - Position:
                </td>
                <td>
                    <input name="fposition" type="text" value="<?/*=$stu->father_occupation*/?>"/><br/>
                </td>
                <td></td>
            </tr>
            <tr>
                <td class="td_label">
                    - Mobile:
                </td>
                <td>
                    <input name="fmobile" type="text" value="<?/*=$stu->father_mobile*/?>"/><br/>
                </td>
                <td></td>
            </tr>
            <tr>
                <td class="td_label">- Email:</td>
                <td>
                    <input name="femail" type="text" value="<?/*=$stu->father_email*/?>"/>
                </td>
                <td></td>
            </tr>
            <tr>
                <td class="td_label">Mother:</td>
                <td><input name="mother" type="text" class="textbox_fullw" value="<?/*=$stu->mother_name*/?>"/></td>
                <td></td>
            </tr>
            <tr>
                <td class="td_label">- Mobile:</td>
                <td><input name="mmobile" type="text" value="<?/*=$stu->mother_mobile*/?>"/></td>
                <td></td>
            </tr>
            <tr>
                <td class="td_label">- Email:</td>
                <td><input name="memail" type="text" value="<?/*=$stu->mother_email*/?>"/></td>
                <td></td>
            </tr>
            <tr>
                <td class="td_label">Emergency:</td>
                <td><input name="emergency" type="text" class="textbox_fullw" value="<?/*=$stu->emergency*/?>"/></td>
                <td></td>
            </tr>
            <tr>
                <td class="td_label">Home:</td>
                <td><input name="home_number" type="text" class="" value="<?/*=$stu->home_number*/?>"/></td>
                <td></td>
            </tr>

            <tr>
                <td class="td_label">District:</td>
                <td><input name="district" type="text" class="" value="<?/*=$stu->district*/?>"/></td>
                <td></td>
            </tr>
            <tr>
                <td class="td_label">Education Background:</td>
                <td><input name="edu_background" type="text" class="" value="<?/*=$stu->education_history*/?>"/></td>
                <td></td>
            </tr>
            <tr>
                <td class="td_label">Relationship:</td>
                <td><input name="relationship" type="text" class="" value="<?/*=$stu->relationship*/?>"/></td>
                <td></td>
            </tr>
            <tr>
                <td class="td_label">Medical history:</td>
                <td><input name="medical_history" type="text" class="" value="<?/*=$stu->medical_history*/?>"/></td>
                <td></td>
            </tr>-->
<tr class="table_header">
    <td colspan="4">
        <input class="button_standard" type="submit" value="Update" onclick="return confirm('Are you sure to edit?')
                    "/>
        <a class="button_standard" href="<?=base_url('admin/student/details/' . $stu->id)?>">Details</a>
        <a class="button_standard" href="<?=base_url('admin/student/transfer/' . $stu->id)?>">Transfer</a>
        <a onclick="return confirm('Are you sure to withdraw [<?=$stu->name?>]?')" class="button_standard"
           href="<?=base_url('admin/student/withdraw/' . $stu->id)?>">Withdraw</a>
        <a class="button_standard" href="<?=base_url('admin/student/list')?>">Back to list</a>
        <a onclick="return confirm('Be careful!. This will delete PERMANENTLY. \nAre you sure to remove student ' +
            '[<?=$stu->name?>] FOREVER?')"
           class="button_standard
            highlight_note" href="<?=base_url
        ('admin/student/delete/' .
            $stu->id)
        ?>">Delete</a>
    </td>
</tr>
</table>
</form>
</div>