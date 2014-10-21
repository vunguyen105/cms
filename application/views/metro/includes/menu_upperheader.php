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
                    <img src="<?=base_url('asset/themes/_img/home.png')?>" alt="Home"
                         title="<?=$this->config->item('system_full_name')?> - Home page"/>
                </a>
                <!--                <a href="--><?//=base_url('attendance/user_guide/')?><!--"-->
                <!--                   onclick="alert('Not yet documented! :(');return false;">-->
                <!--                    <img src="-->
                <?//=base_url('asset/themes/_img/bullet_question.png')?><!--" alt="User Guide" title="User Manual"/>-->
                <!--                </a>-->
                <a href="mailto:huy.nguyenkim@vanphuc.sis.edu.vn">
                    <img src="<?=base_url('asset/themes/_img/email.png')?>" alt="Support" title="Ask for support"/>
                </a>
                <span style="margin-left: 5px;">:: Today is: <strong><?=date('d/m/Y')?></strong></span>


            </div>

        </div>
    </div>
</div>
