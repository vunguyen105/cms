<script>
    $(function () {
        $('#date_published').datepicker({
            defaultDate:+1,
            beforeShowDay:$.datepicker.noWeekends,
            firstDay:+0,
            dateFormat:"yy-mm-dd"
        });
    });
</script>
<script language="javascript" type="text/javascript" src="<?=base_url('scripts')?>/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
    tinyMCE.init({
        // General options
        mode:"textareas",
        theme:"advanced",
        plugins:"autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

        // Theme options
        theme_advanced_buttons1:"save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
        theme_advanced_buttons2:"cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
        theme_advanced_buttons3:"tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
        theme_advanced_buttons4:"insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",
        theme_advanced_toolbar_location:"top",
        theme_advanced_toolbar_align:"left",
        theme_advanced_statusbar_location:"bottom",
        theme_advanced_resizing:true,

        // Skin options
        skin:"o2k7",
        skin_variant:"silver",

        // Example content CSS (should be your site CSS)
        content_css:"css/example.css",

        // Drop lists for link/image/media/template dialogs
        template_external_list_url:"js/template_list.js",
        external_link_list_url:"js/link_list.js",
        external_image_list_url:"js/image_list.js",
        media_external_list_url:"js/media_list.js",

        // Replace values for the template plugin
        template_replace_values:{
            username:"Some User",
            staffid:"991234"
        }
    });
</script>
<p class="module_title">User Guide Management</p>
<div class="standard_block border_standard">
    <form method="POST" action="<?=base_url('admin/cms/do-add')?>">
        <label>Title:</label><input type="text" name="title" style="width: 500px"><br/>
        <label>Category:</label><input type="text" name="category">
        <label>Date publish:</label><input type="text" name="date_published" id="date_published"><br/>
        <label>Display position:</label><input type="text" name="position" value="10"><br/>
        <label>Disabled:</label><input type="checkbox" name="position" value="-1">
        <textarea name="content" rows="30" style="width: 100%"></textarea><br/>
        <input type="submit" value="Add">
        <input type="reset" value="Clear">
    </form>
</div>