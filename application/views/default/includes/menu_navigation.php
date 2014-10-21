<script type="text/javascript">
    $(document).ready(function () {
        $(" #nav ul ").css({display:"none"}); // Opera Fix
        $(" #nav li").hover(function () {
            $(this).find('ul:first').css({visibility:"visible", display:"none"}).show(200);
        }, function () {
            $(this).find('ul:first').css({visibility:"hidden"});
        });
    });
</script>

<ul id="nav">
    <li><a title="Go to homepage" href="<?php echo base_url()?>">Home</a></li>
    <li>
        <a title="" href="<?=base_url(URL_ATTENDANCE_REPORT_DAILY)?>">Attendance</a>
        <ul>
            <li><a href="<?=base_url('attendance/submit')?>">Submit</a></li>
            <li><a href="<?=base_url(URL_ATTENDANCE_REPORT_DAILY)?>">Daily report</a></li>
            <li><a href="<?=base_url('attendance/custom-report')?>">Term report</a></li>
            <!--            <li><a href="--><?//=base_url('attendance/absent-list')?><!--">Absent list</a></li>-->
            <?if ($this->permission->canAccessAdminPanel()) { ?>
            <li><a href="<?=base_url('attendance/submit_admin')?>">Admin Panel</a></li>
            <? }?>
        </ul>
    </li>
    <li><a href="<?=base_url('staff')?>">Staff</a>
        <ul>
            <li><a href="<?=base_url('staff')?>">Current</a></li>
            <li><a href="<?=base_url('staff/former')?>">Former</a></li>
        </ul>
    </li>
    <li><a href="<?=base_url('home/gallery')?>">Gallery</a></li>
    <li><a href="<?=base_url(URL_USERGUIDE_HOME)?>">User Guide</a></li>
    <!--    <li><a href="--><?//=base_url(URL_FEEDBACK)?><!--">Feedback</a></li>-->
    <?if ($this->permission->canAccessAdminPanel()) { ?>
    <li>
        <a href="<?=base_url('admin')?>">
            <img height="13px" src="<?=base_url('asset/themes/_img/setting3.png')?>" alt="Admin">
        </a>
        <ul>
            <? if ($this->permission->hasRoles(array(ROLE_SYSTEM, ROLE_SCHOOL_ENROLLMENT))) { ?>
            <li><a href="<?=base_url('admin/student/add')?>">Add Student</a></li>
            <li><a href="<?=base_url('admin/student/list')?>">List Student</a></li>
            <? }?>
            <? if ($this->permission->hasRoles(array(ROLE_SYSTEM))) { ?>
            <li><a href="<?=base_url('admin/staff/add')?>">Add Staff</a></li>
            <li><a href="<?=base_url('admin/staff/list')?>">List Staff</a></li>
            <? }?>
            <li><a href="<?=base_url('ad')?>">Active Directory</a></li>
            <li><a href="<?=base_url('admin')?>">Settings</a></li>
        </ul>
    </li>
    <? }?>
</ul>
