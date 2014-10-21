<div>
    <form method="POST" action="<?=base_url('admin/do_add_campus/')?>">
        <table class="table_standard table_left">
            <tr class="table_header">
                <td colspan="3">
                    Add new campus
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
                <td class="td_label">Address:</td>
                <td>
                    <input name="address" type="text"/>
                </td>
                <td></td>
            </tr><tr>
                <td class="td_label">Tel/Fax:</td>
                <td>
                    <input name="tel" type="text"/>
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