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
                    <a class="highlight_note" title="Access school email via web" href="http://mail.office365.com" target="_blank">
                        <strong>School Email [new]</strong>
                    </a>
                </li>
                <li>
                    <a title="Request for support with ICT problems" href="http://sms.kinderworld.vn" target="_blank">
                        S.M.S Help desk
                    </a>
                </li>
                <li>
                    <a class="highlight_note" title="Request for any support" href="mailto:support@vanphuc.sis.edu.vn">
                        VanPhuc Support [Email]
                    </a>
                </li>
            </ul>
        </div>
        <div class="left_menu_box border_standard">
            <h5 class="box_title"><a>About <?=$this->config->item('system_short_name')?></a></h5>
            <ul>
                <li><a class="author_info" href="<?=base_url('author')?>">About</a></li>
                <li><a href="mailto:support@vanphuc.sis.edu.vn">Support</a></li>
            </ul>
        </div>
    </div>
</div>
<div id="author_area"></div>
<script type="text/javascript">
    $(function () {
        $(".author_info").click(function (e) {
            e.preventDefault();
            var url = $(this).attr('href');
            $("#author_area").load(url).dialog({
                minHeight:450,
                minWidth:450,
                modal:true,
                draggable:true,
                title:"About me",
                closeText:"Close",
                closeOnEscape:true,
                show:{
                    effect:"explode",
                    duration:500
                },
                hide:{
                    effect:"clip",
                    duration:200
                }
            });
        });
    });
</script>