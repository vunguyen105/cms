<?php $this->load->view(CURRENT_THEME.'/reports/report_header');
if (!isset($guide_details) || count($guide_details)<1){
    echo "Sorry. The content is not available!";
    return;
} $guide_details = $guide_details[0];?>
<style type="text/css">
    #cms_content {
        /*font-family: Arial;*/
        /*font-size: 10pt;*/
    }
    #cms_content h4 {text-transform: uppercase;}
    #cms_content img {max-width: 700px;}
</style>
<a class="module_title" href="<?=base_url(URL_USERGUIDE_HOME)?>">USER GUIDE
    <?=($guide_details->category)?' / '.$guide_details->category:''?>
</a>
<div id="cms_content" class="standard_block border_standard">
   <h4><?=$guide_details->title?></h4>
    <?=$guide_details->content?><br/>
</div>
<a class="button_standard" href="<?=base_url(URL_USERGUIDE_HOME)?>">Back to list</a>

<?php $this->load->view(CURRENT_THEME.'/reports/report_footer');