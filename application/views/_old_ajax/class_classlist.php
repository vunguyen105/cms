<script>
    $(function () {
        $("ul.droptrue").sortable({
            connectWith:"ul"
        });

        $("#sortable1, #sortable2, #sortable3").disableSelection();
    });
</script>
<script>
    function reloadClassList() {
        document.formClasses.submit();
    }
</script>
<p class="module_title">Manage Class List</p>

<div class="grid_6 standard_block border_standard">
    <?if (!isset($class_list)) {
    echo 'no data';
} ?>
    <div title="Chọn lớp!">
        <strong>Select your class: </strong>

        <form name="formClasses" action="<?=base_url('admin/classes/class-list')?>" method="POST">
            <select id="cbxClasses" name="select_class" onchange="reloadClassList()">
                <option value="">--Select your class--</option>
                <?foreach ($class_list as $class) { ?>
                <option
                    value="<?=$class->id?>"><?=$class->class_name?></option>
                <? }?>
            </select>
        </form>
    </div>

    <div id="currentClassList" class="standard_block">
        <?if (isset($student_list) && count($student_list) > 0) { ?>
        <ul id="sortable1" class="droptrue">
            <?foreach ($student_list as $stu) { ?>
            <li class="ui-state-default" value="<?=$stu->id?>"><?=$stu->name?></li>
            <? }?>
        </ul>
        <?
    } else {
        echo "Select class<br/><br/>";
    }?>
    </div>
</div>
<div id="wholeSchoolList" class="grid_6 standard_block border_standard">

    <div class="standard_block">
        <?if (isset($student_list_all) && count($student_list_all) > 0) { ?>
        <ul id="sortable3" class="droptrue">
            <? $iCount = 0;
            foreach ($student_list_all as $stu) {
                $iCount++; ?>
                <li class="ui-state-default" value="<?=$stu->id?>"><?=$stu->name?></li>
                <? }?>
        </ul>
        <!--<table class="table_standard">
            <tr class="table_header">
                <td width="10px">No.</td>
                <td width="200px" class="align_left">Student name</td>
                <td>Gender</td>
                <td>Edit</td>
            </tr>
            <?/* $iCount = 0;
            foreach ($student_list_all as $stu) {
                $iCount++; */?>
                <tr class="table_body_row">
                    <td class="align_center">
                        <?/*=$iCount*/?>.
                        <input name="txtStudentId[<?/*=$stu->id*/?>]" type="hidden" value="<?/*=$stu->id*/?>"/>
                    </td>
                    <td class="align_left"><a
                        href="<?/*=base_url('student/view_details/' . $stu->id)*/?>"><?/*=$stu->name*/?></a></td>
                    <td><?/*=($stu->gender == 1) ? 'M' : 'F'*/?></td>
                    <td>
                        <a href="<?/*=base_url('admin/student/edit/add-to-class' . $stu->id)*/?>" class="btn_edit"></a>
                    </td>
                </tr>
                <?/* }*/?>
            <tr class="table_header">
                <td colspan="8"></td>
            </tr>
        </table>-->
        <?
    } else {
        echo "Select class<br/><br/>";
    }?>
    </div>
</div>
