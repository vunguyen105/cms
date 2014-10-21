<div class="grid_3">
    <div>
        <div class="left_menu_box border_standard">
            <h5 class="box_title"><a>Attendance</a></h5>
            <ul>
                <?if ($this->permission->canAccessAdminPanel()) { ?>
                <li><a href="<?=base_url('attendance/submit_admin')?>">Admin Submit</a></li>
                <? }?>
                <li><a href="<?=base_url(URL_ATTENDANCE_SUBMIT)?>">Submit</a></li>
                <li><a href="<?=base_url(URL_ATTENDANCE_REPORT_DAILY)?>">Daily report</a></li>
                <li><a href="<?=base_url(URL_ATTENDANCE_REPORT_ABSENT_LIST)?>">Absent list</a></li>
                <li><a href="<?=base_url(URL_ATTENDANCE_REPORT_CUSTOM_TIME)?>">Custom report</a></li>
            </ul>
        </div>
        <div class="left_menu_box border_standard">
            <h5 class="box_title"><a>Useful links</a></h5>
            <ul>
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
        </div>
        <div class="left_menu_box border_standard">
            <h5 class="box_title"><a>About <?=$this->config->item('system_short_name')?></a></h5>
            <ul>
                <li><a href=""
                       onclick="alert('Demo version. Huy © 2012 ');return false;">About</a></li>
                <li><a href="mailto:huy.nguyenkim@vanphuc.sis.edu.vn">Support</a></li>
            </ul>
        </div>
    </div>
</div>