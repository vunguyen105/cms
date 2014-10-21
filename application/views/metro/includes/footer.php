<div class="page">
    <div class="nav-bar">
        <div class="nav-bar-inner padding10">
                <span class="element">
                    &copy; 2012 - <?=date('Y')?>
                    <a class="fg-color-white" href="<?=base_url()?>"
                       title="<?=$this->config->item('system_full_name')?>. [Version <?=$this->config->item('system_version')?>]"
                       onclick=" alert('Developed by Nguyen Kim Huy.\nCopyright © 2012 - 2013.');return false;">
                        <strong><?=$this->config->item('system_short_name')?></strong>
                        v<?=$this->config->item('system_version')?>
                    </a>
                </span>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?=base_url('asset/themes/' . CURRENT_THEME)?>/js/google-code-prettify/prettify.js"></script>
<script type="text/javascript">
    $(function () {
        $("table").addClass('bordered hovered');
    });
</script>
</body>
</html>
