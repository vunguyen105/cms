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
<p class="module_title">Edit staff information</p>
<div class="standard_block">
    <form method="POST" action="<?=base_url('admin/staff/do-edit')?>" enctype="multipart/form-data">
        <table class="table_standard table_left table_full">
            <tr>
                <td class="td_label" width="150px">Campus:</td>
                <td>
                    <select name="cam_id">
                        <option value="">--All--</option>
                        <?foreach ($campus_list as $cam) { ?>
                        <option value="<?=$cam->id?>"
                                selected="<?echo $cam->id == $staff->cam_id ? 'true' : 'false'?>"><?=$cam->name?></option>
                        <? }?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Name:</td>
                <td>
                    <input type="text" value="<?=$staff->name?>" name="name"/>
                </td>
            </tr>
            <tr>
                <td>Gender:</td>
                <td>
                    Male <input type="radio" name="gender"
                                value="1" <?=($staff->gender == 1) ? ' checked="true"' : ''?>>
                    Female <input type="radio" name="gender"
                                  value="0" <?=($staff->gender == 0) ? ' checked="true"' : ''?>>
                </td>
            </tr>
            <tr>
                <td>Title:</td>
                <td>
                    <input type="text" value="<?=$staff->job_title?>" name="job_title"/>
                </td>
            </tr>
            <tr>
                <td>Group:</td>
                <td>
                    <input type="text" value="<?=$staff->department?>" name="department"/>
                </td>
            </tr>

            <tr>
                <td>E-mail:</td>
                <td>
                    <input type="text" value="<?=$staff->email?>" name="email"/>
                </td>
            </tr>
            <tr>
                <td>Mobile:</td>
                <td>
                    <input type="text" value="<?=$staff->mobile?>" name="mobile"/>
                </td>
            </tr>
            <tr>
                <td><label for="photo">Photo</label></td>
                <td>
                    <?
                    $imgurl = base_url('photos/staff') . '/';
                    $imgurl .= ($staff->img == '') ? 'user.png' : $staff->img;
                    ?>
                    <img title="<?=$staff->name?>" src="<?=$imgurl?>" width="200px"/>
                    <br/>
                    <input type="file" name="photo" id="photo" size="50"/>(max 500KB)</td>
            </tr>
            <tr>
                <td>Nationality:</td>
                <td>
                    <input type="text" value="<?=$staff->nation?>" name="nation"/>
                </td>
            </tr>
            <tr>
                <td>Staff Code (MC Online):</td>
                <td>
                    <input type="text" name="staff_code" value="<?=$staff->staff_code?>"/>
                </td>
            </tr>
            <tr>
                <td>Password:</td>
                <td>
                    <input type="text" name="password"/>
                </td>
            </tr>
			<tr>
                <td>Joined on:</td>
                <td>
                    <input class="txtDatePicker" type="text" value="<?=$staff->joined_on?>" name="joined_on"/>
                </td>
            </tr>
			<tr>
                <td>Left on:</td>
                <td>
                    <input class="txtDatePicker" type="text" value="<?=$staff->left_on?>" name="left_on"/>
                </td>
            </tr>
            <tr>
                <td>Status:</td>
                <td>
                    Working <input type="radio" name="status"
                                   value="1" <?=($staff->status == 1) ? ' checked="true"' : ''?>>
                    Quitted <input type="radio" name="status"
                                  value="0" <?=($staff->status == 0) ? ' checked="true"' : ''?>>
                </td>
            </tr>

            <tr class="table_header">
                <td colspan="3">
                    <input name="staff_id" type="hidden" value="<?=$staff->id?>"/>
                    <input class="button_standard" type="submit" value="Save"/>
                    <input class="button_standard" type="reset" value="Cancel"/>
                    <a href="<?=base_url('admin/staff')?>" class="button_standard">Staff list</a>
                </td>
            </tr>
        </table>
    </form>
</div>