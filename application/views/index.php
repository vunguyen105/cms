<? $this->load->view('includes/header_tags'); ?>
<? $this->load->view('includes/header'); ?>
<? $this->load->view('includes/body_left_side') ?>
<div class="grid_13">
    <p class="module_title">Notice board:</p>
    <!--    <a onclick="return confirm('View staff list?');" href="--><?//=base_url('staff')?><!--">    </a>-->
    
    <div id="photo_wrapper">
        <img src="<?=base_url()?>styles/img/loadingfb.gif">
    </div>
</div>
<? $this->load->view('includes/footer'); ?>
<script type="text/javascript">
    $(function () {
        $('div#photo_wrapper').hide().html('<img src="<?=base_url()?>photos/2013.jpg">').effect('fade','1000');
    });
</script>
