<p class="module_title">Add new class</p>
<div class="standard_block">
<form method="POST" action="<?=base_url('admin/classes/do-add')?>">
    <table class="table_standard table_left">
        <tr class="table_header">
            <td colspan="3">
                Add new class
            </td>
        </tr>
        <tr>
            <td class="td_label">Campus:</td>
            <td>
                <select name="campus">
                    <option value="">--All--</option>
                    <?foreach ($campus_list as $cam) { ?>
                    <option value="<?=$cam->id?>"><?=$cam->name?></option>
                    <?}?>
                </select>
            </td>
            <td></td>
        </tr>
        <tr>
            <td width="150px">Name:</td>
            <td width="300px">
                <input name="class_name" type="text" class="textbox_fullw"/>
            </td>
            <td></td>
        </tr>
        <tr>
            <td class="td_label">Grade:</td>
            <td>
                <input name="address" type="text"/>
            </td>
            <td></td>
        </tr>
        <tr>
            <td class="td_label">Programme:</td>
            <td>
                <select name="programme">
                    <option value="integrated">Integrated</option>
                    <option value="international">International</option>
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