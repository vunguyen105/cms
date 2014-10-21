<div class="page">
    <div class="nav-bar">
        <div class="nav-bar-inner padding10">
            <span class="pull-menu"></span>
            <a href="<?php echo base_url()?>">
                <span class="element brand">
                    <img class="place-left" src="<?=base_url('asset/themes/' . CURRENT_THEME . '/images/win8.png')?>"
                         style="height: 20px"/>
                    <?=$this->config->item('customer_name')?>
                </span>
            </a>

            <div class="divider"></div>

            <ul class="menu">
                <li><a title="Go to homepage" href="<?php echo base_url()?>">Home</a></li>
                <li data-role="dropdown">
                    <a title="">Attendance</a>
                    <ul class="dropdown-menu">
                        <li><a href="<?=base_url('attendance/submit')?>">Submit</a></li>
                        <li><a href="<?=base_url(URL_ATTENDANCE_REPORT_DAILY)?>">Daily report</a></li>
                        <li><a href="<?=base_url('attendance/custom-report')?>">Term report</a></li>
                        <?if ($this->permission->canAccessAdminPanel()) { ?>
                        <li><a href="<?=base_url('attendance/submit_admin')?>">Admin Panel</a></li>
                        <? }?>
                    </ul>
                </li>
                <li data-role="dropdown"><a>Staff</a>
                    <ul class="dropdown-menu">
                        <li><a href="<?=base_url('staff')?>">Current</a></li>
                        <li><a href="<?=base_url('staff/former')?>">Former</a></li>
                    </ul>
                </li>
                <li><a href="<?=base_url('home/gallery')?>">Gallery</a></li>
                <li><a href="<?=base_url(URL_USERGUIDE_HOME)?>">User Guide</a></li>
                <!--            <li><a href="--><?//=base_url(URL_FEEDBACK)?><!--">Feedback</a></li>-->

                <?if (($this->session->userdata('CURRENT_USER_ID') != "")) { ?>
                <div class="divider"></div>
                <li data-role="dropdown">
                    <a><?=$this->session->userdata('CURRENT_USER_NAME')?></a>
                    <ul class="dropdown-menu">
                        <li><a class="staff_info_dialog"
                               href="<?=base_url('staff/' . $this->session->userdata('CURRENT_USER_ID'))?>">
                            <?=$this->session->userdata('CURRENT_USER_NAME')?>
                        </a></li>
                        <li><a id="btn_change_pwd" href="<?=base_url('change-password')?>" title="Change your password">Change
                            password </a></li>
                        <li><a href="<?=base_url('logout')?>">Logout</a></li>
                    </ul>
                </li>
                <? }?>
                <?if ($this->permission->canAccessAdminPanel()) { ?>
                <li data-role="dropdown">
                    <a>
                        <img src="<?=base_url('asset/themes/_img/setting3.png')?>" alt="Admin">
                    </a>
                    <ul class="dropdown-menu">
                        <? if ($this->permission->hasRoles(array(ROLE_SYSTEM, ROLE_SCHOOL_ENROLLMENT))) { ?>
                        <li><a href="<?=base_url('admin/student/add')?>">Add Student</a></li>
                        <li><a href="<?=base_url('admin/student/list')?>">List Student</a></li>
                        <? }?>
                        <? if ($this->permission->hasRoles(array(ROLE_SYSTEM))) { ?>
                        <li><a href="<?=base_url('admin/staff/add')?>">Add Staff</a></li>
                        <li><a href="<?=base_url('admin/staff/list')?>">List Staff</a></li>
                        <? }?>
                        <li class="divider"></li>
                        <li><a href="<?=base_url('ad')?>">Active Directory</a></li>
                        <li><a href="<?=base_url('admin')?>">Settings</a></li>
                    </ul>
                </li>
                <? }?>
            </ul>
        </div>
    </div>
</div>
