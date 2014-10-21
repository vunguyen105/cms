<p class="module_title">manage classes</p>
<? if (isset($class_list) && count($class_list) > 0) { ?>
<div class="right_col highlight_red"><strong>Total result: <?=count($class_list) ?></strong></div>
<table class="table_standard">
    <tr class="table_header">
        <td width="10px">No.</td>
        <td width="200px" class="align_left">Class name</td>
        <td>Campus</td>
        <td>Programme</td>
        <td>Edit</td>
    </tr>
    <? $iCount = 0;
    foreach ($class_list as $cam) {
        $iCount++; ?>
        <tr class="table_body_row">
            <td class="align_center">
                <?=$iCount?>.
            </td>
            <td class="align_left"><a
                href="<?=base_url('student/view_details/' . $cam->id)?>"><?=$cam->class_name?></a></td>
            <td class="align_left"><?=$cam->cam_id?></td>
            <td class="align_left"><?=$cam->programme?></td>
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
