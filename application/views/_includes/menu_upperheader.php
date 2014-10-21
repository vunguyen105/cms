<script type="text/javascript">
    $(function () {
        $(".staff_info_dialog").click(function (e) {
            e.preventDefault();
            var url = $(this).attr('href');
            var messageTitle = $(this).attr('title');

            $("#modal_dialog_top").load(url).dialog({
                minHeight:300,
                minWidth:600,
                modal:true,
                draggable:false,
                title:"SIS @ VanPhuc * 2012-2013",
                closeText:"Close",
                closeOnEscape:true,
                buttons:{
                    Close:function () {
                        $(this).dialog("close");
                    }
                },
                show:{
                    effect:"scale",
                    duration:200
                },
                hide:{
                    effect:"clip",
                    duration:200
                }
            });
            $(".ui-widget-overlay").click(function () {
                $("#modal_dialog_top").dialog('close');
            });
        });

        $("#btn_change_pwd").click(function (e) {
            e.preventDefault();
            var url = $(this).attr('href');
            $("#modal_dialog_top").load(url).dialog({
                minHeight:300,
                minWidth:600,
                modal:true,
                draggable:false,
                title:"Change your password",
                closeText:"Close",
                closeOnEscape:true,
                buttons:{
                    Close:function () {
                        $(this).dialog("close");
                    }
                },
                show:{
                    effect:"scale",
                    duration:200
                },
                hide:{
                    effect:"clip",
                    duration:200
                }
            });
            $(".ui-widget-overlay").click(function () {
                $("#modal_dialog_top").dialog('close');
            });
        });
    });
</script>
<div id="upper_header">
    <div style="width: 100%;text-align: center;">
        <div class="container_16">
            <div id="modal_dialog_top"></div>
            <!-- Search box-->
            <div class="left_col">
                <a href="<?=base_url()?>">
                    <img src="<?=base_url('styles/img/home.png')?>" alt="Home"
                         title="<?=$this->config->item('system_full_name')?> - Home page"/>
                </a>
                <!--                <a href="--><?//=base_url('attendance/user_guide/')?><!--"-->
                <!--                   onclick="alert('Not yet documented! :(');return false;">-->
                <!--                    <img src="-->
                <?//=base_url('styles/img/bullet_question.png')?><!--" alt="User Guide" title="User Manual"/>-->
                <!--                </a>-->
                <a href="mailto:huy.nguyenkim@vanphuc.sis.edu.vn">
                    <img src="<?=base_url('styles/img/email.png')?>" alt="Support" title="Ask for support"/>
                </a>
                <span style="margin-left: 5px;">:: Today is: <strong><?=date('d/m/Y')?></strong></span>


            </div>
            <div class="right_col">
                <?if (($this->session->userdata('CURRENT_USER_ID') != "")) { ?>
                <label>Hello, </label>
                <a class="staff_info_dialog"
                   href="<?=base_url('staff/' . $this->session->userdata('CURRENT_USER_ID'))?>">
                    <?=$this->session->userdata('CURRENT_USER_NAME')?>
                </a> |
                <a id="btn_change_pwd" href="<?=base_url('change-password')?>" title="Change your password">Change
                    password </a>|
                <a href="<?=base_url('logout')?>">
                    <img src="<?=base_url('styles/img/power2.png')?>" alt="Logout" title="Logout"/>
                </a>
                <? }?>
            </div>
        </div>
    </div>
</div>
