<?php $this->load->view('reports/report_header'); ?>
<p class="module_title">user guide (ICT)</p>
<style type="text/css">
    #listItem, a {
        color: #2f3e46;
    }
    ol {
        font-size: 10pt;
        line-height: 1.8em;
    }
    #listItem a{}
    #listItem a:hover{color:#ff4500;font-weight: bold;}
    /*#listItem a:visited{color:#a52a2a;}*/

</style>
<div id="listItem" class="standard_block border_standard">
    <ol>
        <?php if (!isset($guide_list) || count($guide_list) < 1) {
        echo "Sorry. There's not any content available yet!";
        return;
    }
        foreach ($guide_list as $guide) {
            if($guide->category==''){$guide->category='Others';}
            ?>
            <li style="list-style-type: decimal;"><a
                href="<?=base_url(URL_USERGUIDE_HOME.'/' . $guide->id)?>">[<?=$guide->category?>] - <?=$guide->title?></a></li>
            <? }?>
    </ol>
</div>
<?php $this->load->view('reports/report_footer');