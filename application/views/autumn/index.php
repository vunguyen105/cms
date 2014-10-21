<? $this->load->view(CURRENT_THEME.'/includes/header_tags'); ?>
<? $this->load->view(CURRENT_THEME.'/includes/header'); ?>
<? $this->load->view(CURRENT_THEME.'/includes/body_left_side') ?>
<div class="grid_13">
    <p class="module_title">Notice board:</p>
    <!--    <a onclick="return confirm('View staff list?');" href="--><?//=base_url('staff')?><!--">    </a>-->
    
    <div id="photo_wrapper">
<!--        <img src="--><?//=base_url()?><!--asset/themes/_img/loadingfb.gif">-->
        <?//$this->load->view('admin/charts/attendance_absence_by_days');?>
		<p style="color:blue;font-size:12pt;">
		Dear all, <br/><br/>Here are our new web mail addresses: 
		<a target="_blank" class="highlight_note" href="http://mail.office365.com">http://mail.office365.com</a> or <a target="_blank" class="highlight_note" href="http://outlook.com/sis.edu.vn">http://outlook.com/sis.edu.vn</a>
		<br/>
		Please email to <a href="mailto:support@vanphuc.sis.edu.vn">VanPhuc Support</a> if you need further instructions.<br/><br/>
		Regards,<br/>
		<i>IT</i>
		</p>
    </div>
</div>
<? $this->load->view(CURRENT_THEME.'/includes/footer'); ?>
<script type="text/javascript">
    $(function () {
<!--        $('div#photo_wrapper').hide().html('<img src="--><?//=base_url()?><!--photos/2013.jpg">').effect('fade','1000');-->
    });
</script>
