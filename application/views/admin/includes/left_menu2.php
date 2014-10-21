<style>
    .topnav {
        /*width: 213px;*/
        padding: 40px 28px 25px 0;
        /*font-family: "CenturyGothicRegular", "Century Gothic", Arial, Helvetica, sans-serif;*/
    }

    ul.topnav {
        padding: 0;
        margin: 0;
        font-size: 1em;
        line-height: 0.5em;
        list-style: none;
    }

    ul.topnav li {
        margin-left: 5px;
    }

    ul.topnav li a {
        line-height: 10px;
        font-size: 11px;
        padding: 10px 5px;
        color: #000;
        display: block;
        text-decoration: none;
        font-weight: bolder;
    }

    ul.topnav li a:hover {
        background-color: #675C7C;
        color: white;
    }

    ul.topnav ul {
        margin: 0;
        padding: 0;
        display: none;
    }

    ul.topnav ul li {
        margin: 0;
        padding: 0;
        clear: both;
    }

    ul.topnav ul li a {
        padding-left: 20px;
        font-size: 11px;
        font-weight: normal;
        outline: 0;
    }

    ul.topnav ul li a:hover {
        background-color: #D3C99C;
        color: #675C7C;
    }

    ul.topnav ul ul li a {
        color: silver;
        padding-left: 40px;
    }

    ul.topnav ul ul li a:hover {
        background-color: #D3CEB8;
        color: #675C7C;
    }

    ul.topnav span {
        float: right;
    }
</style>
<script type="text/javascript" src="<?=base_url('scripts')?>/menu_accordion.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $(".topnav").accordion({
            accordion:false,
            speed:200,
            closedSign:'[+]',
            openedSign:'[-]'
        });

        $(".under_development").click(function(){
            alert('Sorry! This feature is under development!');
        });
    });
</script>
<div class="left_menu_box border_standard">
    <ul class="topnav">
        <li><a href="<?=base_url('admin')?>">Home</a></li>
        <li>
            <a>Reports</a>
            <ul>
                <li><a href="<?=base_url('admin/student/overall')?>">Enrollment/Withdrawal</a></li>
                <li><a href="<?=base_url('admin/student/grade-ratio')?>">Student by Grades</a></li>
                <li><a href="<?=base_url('admin/student/gender-ratio')?>">Student by Genders</a></li>
                <li><a href="<?=base_url('admin/attendance/report-absence')?>">Student Absence</a></li>
            </ul>
        </li>
        <li>
            <a>Enrollment</a>
            <ul>
                <li><a class="under_development" >Overall report</a></li>
                <li><a class="under_development" >By year</a></li>
                <li><a class="under_development" >By campus</a></li>
                <li><a class="under_development" >All campuses</a></li>
            </ul>
        </li>
        <li>
            <a>Attendance</a>
            <ul>
                <li><a class="under_development" ">Report absent</a></li>
                <li><a class="under_development" ">Report by campus</a></li>
                <li><a class="under_development" ">All campuses</a></li>
            </ul>
        </li>
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
    </ul>
</div>
