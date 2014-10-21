<!--[if lt IE 8]>
<style type="text/css">
li a {display:inline-block;}
li a {display:block;}
</style>
<![endif]-->
<script type="text/javascript">
    function initMenu() {
        $('#menu ul').hide();
        $('#menu li a').click(function () {
                $(this).next().slideToggle('fast');
            });
    }
    $(document).ready(function () {
        initMenu();
    });
</script>
<div class="left_menu_box border_standard">
    <ul id="menu">
        <li><a href="<?=base_url('admin')?>">Home</a></li>
        <li>
            <a>Reports</a>
            <ul>
                <li><a href="<?=base_url('admin/student/overall')?>">Enrollment/Withdrawal</a></li>
                <li><a href="<?=base_url('admin/student/grade-ratio')?>">Student by Grades</a></li>
                <li><a href="<?=base_url('admin/student/gender-ratio')?>">Student by Genders</a></li>
                <li><a href="<?=base_url('admin/attendance/report-absence')?>">Student Absence</a></li>
                <li><a href="<?=base_url('admin/attendance/report-absence-by-days')?>">Student Absence Days</a></li>
            </ul>
        </li>
        <!--        <li>-->
        <!--            <a>Enrollment</a>-->
        <!--            <ul>-->
        <!--                <li><a class="under_development">Overall report</a></li>-->
        <!--                <li><a class="under_development">By year</a></li>-->
        <!--                <li><a class="under_development">By campus</a></li>-->
        <!--                <li><a class="under_development">All campuses</a></li>-->
        <!--            </ul>-->
        <!--        </li>-->
        <!--        <li>-->
        <!--            <a>Attendance</a>-->
        <!--            <ul>-->
        <!--                <li><a class="under_development" ">Report absent</a></li>-->
        <!--                <li><a class="under_development" ">Report by campus</a></li>-->
        <!--                <li><a class="under_development" ">All campuses</a></li>-->
        <!--            </ul>-->
        <!--        </li>-->
        <li><a>Student</a>
            <ul>

                <li><a href="<?=base_url('admin/student/add')?>">Add</a></li>
                <li><a href="<?=base_url('admin/student/list')?>">List</a></li>

            </ul>
        </li>
        <li>
            <a>Classes</a>
            <ul>
                <li><a href="<?=base_url('admin/classes/add')?>">Add</a></li>
                <li><a href="<?=base_url('admin/classes/class-list')?>">Class list</a></li>
                <li><a href="<?=base_url('admin/classes/list')?>">List</a></li>
            </ul>

        </li>
        <li>
            <a>Staff</a>
            <ul>
                <li><a href="<?=base_url('admin/staff/add')?>">Add</a></li>
                <li><a href="<?=base_url('admin/staff/assign')?>">Assign to class</a></li>
                <li><a href="<?=base_url('admin/staff/manage-account')?>">User accounts</a></li>
                <li><a href="<?=base_url('admin/staff/list')?>">List all</a></li>
            </ul>
        </li>
        <li>
            <a>Campus</a>
            <ul>
                <li><a href="<?=base_url('admin/campus/add')?>">Add</a></li>
                <li><a href="<?=base_url('admin/campus/list')?>">List all</a></li>
            </ul>
        </li>
        <li>
            <a>CMS</a>
            <ul>
                <li><a href="<?=base_url('admin/cms')?>">Feedback</a></li>
                <li><a href="<?=base_url('admin/cms')?>">User guide</a></li>
            </ul>
        </li>
    </ul>
</div>
