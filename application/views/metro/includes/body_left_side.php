<div class="page-sidebar">
    <ul>
        <li class="sticker sticker-color-green dropdown active" data-role="dropdown">
            <a><i class="icon-list"></i>Attendance</a>
            <ul class="sub-menu light sidebar-dropdown-menu keep-opened open">
                <?if ($this->permission->canAccessAdminPanel()) { ?>
                <li><a href="<?=base_url('attendance/submit_admin')?>">Admin Submit</a></li>
                <? }?>
                <li><a href="<?=base_url(URL_ATTENDANCE_SUBMIT)?>">Submit</a></li>
                <li><a href="<?=base_url(URL_ATTENDANCE_REPORT_DAILY)?>">Daily report</a></li>
                <li><a href="<?=base_url(URL_ATTENDANCE_REPORT_ABSENT_LIST)?>">Absent list</a></li>
                <li><a href="<?=base_url(URL_ATTENDANCE_REPORT_CUSTOM_TIME)?>">Custom report</a></li>
            </ul>
        </li>
        <li class="sticker sticker-color-pink dropdown active" data-role="dropdown">
            <a><i class="icon-list"></i>Useful links</a>
            <ul class="sub-menu light sidebar-dropdown-menu">
                <li>
                    <a title="E-learning website - MC Online" href="http://mconline.vn" target="_blank">
                        MC Online
                    </a>
                </li>
                <li>
                    <a title="Access school email" href="http://live.com" target="_blank">
                        School Email
                    </a>
                </li>
                <li>
                    <a title="Request for support with ICT problems" href="http://sms.kinderworld.vn" target="_blank">
                        S.M.S Help desk
                    </a>
                </li>
            </ul>
        </li>
        <li class="sticker sticker-color-orange"><a href="#" onclick="alert('Demo version. Huy © 2012 ');return false;"><i class="icon-cart"></i>About</a></li>
        <li class="sticker sticker-color-orangeDark"><a href="mailto:huy.nguyenkim@vanphuc.sis.edu.vn"><i class="icon-clipboard"></i> Support</a></li>
    </ul>
</div>