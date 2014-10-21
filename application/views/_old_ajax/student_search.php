<!--<script>-->
<!--    $(function () {-->
<!--        $('#frmSearch').submit(function (e) {-->
<!--//            e.preventDefault();-->
<!--            var $inputs = $('form#frmSearch :input');-->
<!--            var values = {};-->
<!--            $inputs.each(function () {-->
<!--                values[this.name] = $(this).val();-->
<!--            });-->
<!--            $.post("--><?//=base_url('admin/student/do-search')?><!--", values,function (response) {-->
<!--                $("#student_list").html(response).hide().fadeIn();-->
<!--            }).error(function (xhr, status, error) {-->
<!--                    $('#ajax_load')-->
<!--                        .html("")-->
<!--                        .hide()-->
<!--                        .fadeIn(500, function () {-->
<!--                            $('#container').append("<img width=\"20px\" src='--><?//=base_url('styles/img/cancel_red.png')?><!--' />");-->
<!--                        });-->
<!---->
<!--                });-->
<!--            return false;-->
<!--        });-->
<!--    });-->
<!--    $(function () {-->
<!--        $.post()-->
<!--    });-->
<!--</script>-->
<script type="text/javascript">
    function reloadStudentList() {
        document.frmSearch.submit();
    }
</script>
<div id="studentSearchForm">
    <form id="frmSearch" name="frmSearch" method="POST" action="<?=base_url('admin/student/do-search')?>">
        <table class="table_custom">
            <tr>
                <td>Name:</td>
                <td>
                    <input type="text" name="name" value="<?=$keywords['name']?>"
                           onchange="reloadStudentList()"/>
                </td>
                <td class="col_2">Class:</td>
                <td>
                    <select id="cbxClassList" name="class" onchange="reloadStudentList()">
                        <option value="">--All--</option>
                        <?foreach ($class_list as $class) { ?>
                        <option <?if ($class->id == $keywords['class']) echo "selected=true"?>
                            value="<?=$class->id?>"><?=$class->class_name?></option>
                        <? }?>
                    </select>
                </td>
                <td></td>
                <td>
                </td>
            </tr>
            <tr>
                <td>Gender:</td>
                <td>
                    Male <input type="radio" name="gender"
                                value="1" <?=($keywords['gender'] == '1') ? ' checked="true"' : ''?>
                                onchange="reloadStudentList()"/>
                    Female <input type="radio" name="gender"
                                  value="0" <?=($keywords['gender'] == '0') ? ' checked="true"' : ''?>
                                  onchange="reloadStudentList()"/>
                    All <input type="radio" name="gender"
                               value="2" <?=(!isset($keywords['gender']) || $keywords['gender'] == '2') ? ' checked="true"' : ''?>
                               onchange="reloadStudentList()"/>
                </td>
                <td>Status:</td>
                <td>
                    Current <input type="radio" name="status"
                                   value="1" <?=(!isset($keywords['status']) || $keywords['status'] == '1') ? ' checked="true"' : ''?>
                                   onchange="reloadStudentList()"/>
                    Withdrawn <input type="radio" name="status"
                                     value="0" <?=($keywords['status'] == '0') ? ' checked="true"' : ''?>
                                     onchange="reloadStudentList()"/>
                    All <input type="radio" name="status"
                               value="2" <?=($keywords['status'] == '2') ? ' checked="true"' : ''?>
                               onchange="reloadStudentList()"/>
                </td>
            </tr>

            <tr>
                <td>DOB from:</td>
                <td>
                    <input class="txtDatePicker" type="text" name="dob_from"
                           value="<?=$keywords['dob_from']?>"/>
                </td>
                <td>To:</td>
                <td>
                    <input class="txtDatePicker" type="text" name="dob_to" value="<?=$keywords['dob_to']?>"/>
                </td>
            </tr>
            <tr>
                <td>Enroll from:</td>
                <td>
                    <input class="txtDatePicker" type="text" name="enroll_from"
                           value="<?=$keywords['enroll_from']?>"/>
                </td>
                <td>To:</td>
                <td>
                    <input class="txtDatePicker" type="text" name="enroll_to"
                           value="<?=$keywords['enroll_to']?>"/>
                </td>
            </tr>
            <tr>
                <td>Father:</td>
                <td>
                    <input type="text" name="father" value="<?=$keywords['father']?>"/>
                </td>
                <td>Mother:</td>
                <td>
                    <input type="text" name="mother" value="<?=$keywords['mother']?>"/>
                </td>
            </tr>

            <tr>
                <td>Street:</td>
                <td>
                    <input type="text" name="street" value="<?=$keywords['street']?>"/>
                </td>
                <td>District:</td>
                <td>
                    <input type="text" name="district" value="<?=$keywords['district']?>"/>
                </td>
            </tr>
            <tr>
                <td>Phone:</td>
                <td>
                    <input type="text" name="phone" value="<?=$keywords['phone']?>"/>
                </td>
                <td>E-mail:</td>
                <td>
                    <input type="text" name="email" value="<?=$keywords['email']?>"/>
                </td>
            </tr>

            <tr>
                <td></td>
                <td>
                    <input class="button_standard" type="submit" value="Search"/>
                    <input class="button_standard" type="reset" value="Reset"/>
                </td>
                <td></td>
            </tr>
        </table>
    </form>
</div>