<p class="module_title">Add new staff</p>
<div class="standard_block">
    <form method="POST" action="<?=base_url('admin/staff/do-add')?>" enctype="multipart/form-data">
        <table class="table_standard table_left table_full">
            <tr>
                <td class="td_label" width="150px">Campus:</td>
                <td>
                    <select name="cam_id">
<!--                        <option value="">--All--</option>-->
                        <?foreach ($campus_list as $cam) { ?>
                        <option value="<?=$cam->id?>"><?=$cam->name?></option>
                        <? }?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Name:</td>
                <td>
                    <input type="text" value="" name="name"/>
                </td>
            </tr>
            <tr>
                <td>Gender:</td>
                <td>
                    <input type="radio" name="gender">Male |
                    <input type="radio" name="gender" checked="true">Female
                </td>
            </tr>
            <tr>
                <td>Title:</td>
                <td>
                    <input type="text" value="" name="job_title"/>
                </td>
            </tr>

            <tr>
                <td>E-mail:</td>
                <td>
                    <input type="text" value="" name="email"/>
                </td>
            </tr>
            <tr>
                <td>Mobile:</td>
                <td>
                    <input type="text" value="" name="mobile"/>
                </td>
            </tr>
            <tr>
                <td><label for="photo">Photo</label></td>
                <td><input type="file" name="photo" id="photo" size="20"/></td>
            </tr>
            <tr>
                <td>Nationality:</td>
                <td>
                    <input type="text" value="Vietnamese" name="nation"/>
                </td>
            </tr>
            <tr>
                <td>Staff Code (MC Online):</td>
                <td>
                    <input type="text" name="staff_code" value="<?=date('Ymd_His')?>"/>
                </td>
            </tr>
            <tr>
                <td>Password:</td>
                <td>
                    <input type="text" value="sis<?=date('mY')?>" name="password"/>
                </td>
            </tr>
            <tr>
                <td>Status:</td>
                <td>
                    <input type="radio" name="status" value="1" checked="true">Working |
                    <input type="radio" name="status" value="0">Quited
                </td>
            </tr>

            <tr class="table_header">
                <td colspan="3">
                    <input class="button_standard" type="submit" value="Save"/>
                    <input class="button_standard" type="reset" value="Cancel"/>
                </td>
            </tr>
        </table>
    </form>
</div>