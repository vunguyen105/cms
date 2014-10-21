<?
if (isset($student_list) && count($student_list) > 0) {
    if (isset($error_msg)) {
        echo "<h6 class=\"error_message\">" . $error_msg . "</h6>";
    }?>
<p class="error_message">Click on the students <strong>who are absent</strong> today.</p>
<table class="table_standard">
    <tr class="table_header">
        <td>No.</td>
        <td class="align_left">Student name</td>
        <td>Absent</td>
        <td class="align_left">Comment</td>
    </tr>

    <? if (isset($student_list)) {
    $iCount = 0;
    foreach ($student_list as $stu) {
        $iCount++; ?>
        <tr <?if ($stu->absent_date != '') echo 'class="table_body_row highlighted_item" title="' . $stu->name . ' is reported already!"'; else echo 'class="table_body_row"';?>>
            <td>
                <?=$iCount?>.
                <input name="txtStudentId[<?=$stu->id?>]" type="hidden" value="<?=$stu->id?>"/>
            </td>
            <td class="align_left"><?=$stu->name?></td>
            <td>
                <?if ($stu->absent_date == '') { ?>
                <input name="ckbIsAbsent[]" type="checkbox" value="<?=$stu->id?>"/>
                <? } else { ?>Absent<? } ?>
            </td>
            <td class="align_left">
                <input class="textbox_fullw" name="txtComment[<?=$stu->id?>]" type="text"
                       value="<?=$stu->comment?>" <?=($stu->absent_date != '') ? ' disabled="true"' : ''?>/>
            </td>
        </tr>
        <?
    }
}?>
    <tr class="table_header">
        <td colspan="4" class="align_center">
            <input class="button_standard" type="submit" title="Gửi đi" value="Submit"/>
            <input class="button_standard" type="reset" value="Clear"/>
        </td>
    </tr>
</table>
<?
} else {
    ?>
<p>Select your class from the class list first!
    <img src="<?=base_url('styles/img/hand_icon.jpg')?>" height="80px" width="80px" alt="">
</p>

<? } ?>