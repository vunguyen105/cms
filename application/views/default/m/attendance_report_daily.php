<? $this->load->view(CURRENT_THEME.'/m/p_header'); ?>

<script type="text/javascript">
    function reloadClassList() {
        document.class_list.submit();
    }
</script>
<div>
    Submitted: <strong><?=$count_submitted . '</strong>/' . count($all_classes_attendance) . ' classes.'?>
    <?=($count_absent > 1) ? '<strong>' . $count_absent . '</strong> students are absent.' : '<strong>' . $count_absent . '</strong> student is absent.'?>
</div>
<? if (count($all_classes_attendance) > 0) { ?>
<ul data-role="listview" data-icon-pos="right">
    <?foreach ($all_classes_attendance as $item) { ?>
    <li>
        <?=$item->class_name?>
        <?
        if ($item->has_absent == '') {
            ?>
            <img src="<?=base_url('asset/themes/_img/x.png')?>" alt=".." class="ui-li-icon">
            <?
        } else if ($item->has_absent == 0) {
            ?>
            <img src="<?=base_url('asset/themes/_img/accept-24.png')?>" alt="Full" class="ui-li-icon">

            <?
        } else if ($item->has_absent == 1) {
            ?>
            <img src="<?=base_url('asset/themes/_img/checked-red.png')?>" alt="Absent" class="ui-li-icon">
            <? }?>
    </li>

    <? } ?>
</ul>

<a data-role="button" href="<?=base_url('m/attendance_submit')?>">Submit</a>
<?
} else {
    ?>
<p>No data!</p>
<? } ?>
<div>
<ol data-role="listview">
<? if (isset($student_list) && (count($student_list) > 0)) {
    $iCount = 0;
    foreach ($student_list as $stu) {
        $iCount++; ?>
    <li>
        <input name="txtStudentId" type="hidden" value="<?=$stu->id?>"/>
        <?= $stu->class_name ?>
        <?= $stu->name ?>
    <a class="btn_person_checked"
       title="Click vào đây để báo '<?=$stu->name?>' đã đến! Click to inform that '<?=$stu->name?>' came."
       href="<?=base_url('attendance/came_already/' . $stu->id . '/' . $selected_date)?>"
       onclick="return confirm('\'<?=$stu->name?>\' đã đến trường? Are you sure (s)he arrived?')">
    </a>
    </li>
    <?}} ?>
</ol>
</div>
