</div>
<script type="text/javascript">
$(function() {
	$("input[type=button],input[type=submit],input[type=reset],button,.button_standard").button();
    $( document ).tooltip();
});
<!--    $("#container").hide();-->
<!--    $(document).ready(function () {-->
<!--        $("#container").fadeIn('100');-->
<!--    });-->
</script>
<div class="shadow"></div>
    <div class="clear_inside" style="height: 20px;"></div>
<div id="footer">
    <div class="container_16">
        <div class="grid_16" id="footer_content">
            © 2012 - <?=date('Y')?> <a href="<?=base_url()?>"
               title="<?=$this->config->item('system_full_name')?>. [Version <?=$this->config->item('system_version')?>]"
               onclick=" alert('Developed by Nguyen Kim Huy.\nCopyright © 2012 - 2013.');return false;">
                <strong><?=$this->config->item('system_short_name')?></strong>
                v<?=$this->config->item('system_version')?>
            </a>.
        <span>
            Hỗ trợ tốt trên <strong>FireFox & Chrome</strong>. Works well on <strong>FireFox &
            Chrome</strong>.
        </span>
            <p></p>
        </div>

    </div>
</div>
</body>
</html>
