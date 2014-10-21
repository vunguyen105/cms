<script>
    $(function () {
        $('.txtDatePicker').datepicker({
            defaultDate:+1,
            firstDay:+0,
            dateFormat:"yy-mm-dd",
            changeMonth:true,
            changeYear:true
        });
    });
</script>
    <p class="module_title">Add new student</p>
<div class="standard_block">
	<form id="frmAdd" method="POST" action="<?=base_url('admin/student/do-add')?>">
    <table class="table_standard table_left">
        <tr class="table_header">
            <td colspan="3">
                Student information
            </td>
        </tr>
        <tr>
            <td width="150px">Name:</td>
            <td width="300px">
                <input name="name" type="text" class="textbox_fullw"/>
            </td>
            <td></td>
        </tr>
        <tr>
            <td>Gender:</td>
            <td>
                <input type="radio" name="radGender" checked="true">Male |
                <input type="radio" name="radGender">Female
            </td>
            <td></td>
        </tr>
        <tr>
            <td>Class:</td>
            <td>
                <select id="cbxClassList" name="select_class">
                    <option value="">--All--</option>
                    <?foreach ($class_list as $class) { ?>
                    <option value="<?=$class->id?>"><?=$class->class_name?></option>
                    <? }?>
                </select>
            </td>
            <td></td>
        </tr>
        <tr>
            <td class="td_label">Date of birth:</td>
            <td>
                <input name="dob" type="text" class="datepicker txtDatePicker" id="txtDateOfBirth"/>
            </td>
            <td></td>
        </tr>
        <tr>
            <td>Status:</td>
            <td>
                Active <input type="radio" name="radStatus" checked="true" value="1"/>
                Inactive <input type="radio" name="radStatus"/>
            <td></td>
        </tr>
        <tr>
            <td class="td_label">Enrollment date:</td>
            <td>
                <input name="doe" type="text" class="datepicker txtDatePicker"
                       id="txtDateOfEnroll"/>
            </td>
            <td></td>
        </tr>
        <tr>
            <td class="td_label">Nationality:</td>
            <td>
                <input name="nationality" type="text"/>
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
                <input class="button_standard" type="submit" value="Submit"/>
                <input class="button_standard" type="reset" value="Cancel"/>
            </td>
        </tr>
    </table>
</form>
</div>