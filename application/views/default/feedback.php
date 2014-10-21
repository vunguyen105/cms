<?php $this->load->view(CURRENT_THEME.'/reports/report_header'); ?>
<p class="module_title">Feedback</p>
<div class="border_standard standard_block">

    <form method="POST" action="<?=base_url('home/do_feedback')?>">
        <table class="table_full table_left">
            <tr>
                <td>Category:</td>
                <td>
                    <select name="category">
                        <option value="login" title="Cannot login,..">Login problems</option>
                        <option value="design" title="The design looks bad, anything">Design problems</option>
                        <option value="information" title="Information is not correct,..">Information problems</option>
                        <option value="others" title="Anything else">Others</option>
                    </select>
                    <span style="padding-left: 10px">Urgent!<input type="checkbox" name="position" value="9"/></span>
                </td>
            </tr>
            <tr>
                <td>Subject:</td>
                <td><input type="text" name="title" value="" class="textbox_fullw"/></td>
            </tr>
            <tr>
                <td>Message:</td>
                <td>
                    <textarea name="content" rows="10" class="textbox_fullw"></textarea>
                </td>
            </tr>
            <tr>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input class="button_standard" type="submit" value="Submit"/>
                    <input class="button_standard" type="reset" value="Clear"/>
                </td>
            </tr>
        </table>
    </form>
</div>
<?php $this->load->view(CURRENT_THEME.'/reports/report_footer');