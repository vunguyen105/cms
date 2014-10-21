<? if (isset($student_list) && count($student_list) > 0) { ?>
<div data-role="fieldcontain">
    <fieldset data-role="controlgroup">
        <legend>Select absent:</legend>
        <ul>
            <? foreach ($student_list as $stu) { ?>
            <li>
                <? if ($stu->absent_date == '') { ?>
                <input name="ckbIsAbsent[]" type="checkbox" value="<?=$stu->id?>" id="<?=$stu->id?>"/>
                <label for="<?=$stu->id?>"><?=$stu->name?></label>
                <? } else {echo 'Absent';} ?>
            </li>
            <? } ?>
        </ul>
    </fieldset>
</div>
<?
} else {
    echo 'No data';
} ?>
