</div>
<script type="text/javascript">
    $(function () {
        $("input[type=button],input[type=submit],input[type=reset],button,.button_standard").button();
        $(document).tooltip();
    });
</script>
<div class="shadow"></div>
<div class="clear_inside" style="height: 20px;"></div>
<div id="footer">
    <div class="container_16">
        <div class="grid_16" id="footer_content">
            <a onclick="return confirm('Send me an e-mail?')" href="mailto:huy.ltv@gmail.com"
               title="<?=$this->config->item('system_full_name')?>. [Version <?=$this->config->item('system_version')?>]">
                <strong><?=$this->config->item('system_short_name')?></strong>
                v<?=$this->config->item('system_version')?>
            </a> &copy; 2012 - <?=date('Y')?> by <a class="author_info" href="<?=base_url('author')?>">Huy</a>.
            <span>
            Hỗ trợ tốt trên <strong>FireFox & Chrome</strong>. Works best on <strong>FireFox &
                Chrome</strong>.
        </span>

            <p></p>
        </div>

    </div>
</div>
</body>
</html>
