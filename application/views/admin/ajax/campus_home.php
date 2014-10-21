<p class="module_title">manage campuses</p>
<div class="">
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
            </tr>
            <tr>
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
<div class="border_standard standard_block">
    <?if (isset($campus_list) && count($campus_list) > 0) { ?>
    <div class="right_col highlight_red"><strong>Total result: <?=count($campus_list) ?></strong></div>
    <table class="table_standard">
        <tr class="table_header">
            <td width="10px">No.</td>
            <td width="200px" class="align_left">Student name</td>
            <td>Address</td>
            <td>Contact</td>
            <td>Edit</td>
        </tr>
        <? $iCount = 0;
        foreach ($campus_list as $cam) {
            $iCount++; ?>
            <tr class="table_body_row">
                <td class="align_center">
                    <?=$iCount?>.
                </td>
                <td class="align_left"><a
                    href="<?=base_url('student/view_details/' . $cam->id)?>"><?=$cam->name?></a></td>
                <td class="align_left"><?=$cam->address?></td>
                <td class="align_left"><?=$cam->tel?></td>
                <td>
                    <a href="<?=base_url('student/edit/' . $cam->id)?>" class="btn_edit"></a>
                </td>
            </tr>
            <? }?>
        <tr class="table_header">
            <td colspan="8">
                <!--<a class="button_standard" href="<?//=base_url('student/export_excel')?>">Export to Excel</a>-->
            </td>
        </tr>
    </table>
    <?
} else {
    echo "Select class, input student name,.. then click on SEARCH button to list students.";
    echo "<br/><br/><br/><br/>";
}?>

</div>
