<? $this->load->view(CURRENT_THEME.'/m/p_header'); ?>
<div data-role="page" data-title="Greenwich Websitess" id="pone">
    <div data-role="header" data-position="fixed">
        <div style="width: 20%;height:50px;border: 1px dotted white;float: left;padding: 2px;">
            <a href="<?=base_url('m')?>">HMS</a>
        </div>
        <div style="width: 70%;border: 1px dotted red;float: left">
            <h3>HMS Mobile</h3>
        </div>
    </div>
    <div data-role="navbar">
        <a data-role="button" data-icon="star" href="<?=base_url('m/attendance_submit')?>">Submit</a>
        <a data-role="button" data-icon="info" href="<?=base_url('m/attendance_submit')?>">Report</a>
        <a data-role="button" data-icon="check" href="<?=base_url('m/logout')?>">Logout</a>
    </div>
    <div data-role="collapsible">
        <h5>Input your info</h5>

        <form>
            <input type="text" name="fname" value="first name">
            <input type="text" name="lname" value="last name">
            <input type="text" name="address" value="address">
            <input type="email" name="email" value="email">
            <fieldset data-role="controlgroup" data-mini="true" data-type="horizontal">
                <input type="radio" name="radio-mini" id="radio-mini-1" value="choice-1" checked="checked"/>
                <label for="radio-mini-1">Male</label>
                <input type="radio" name="radio-mini" id="radio-mini-2" value="choice-2"/>
                <label for="radio-mini-2">Female</label>
            </fieldset>
        </form>
        <a data-role="button" data-icon="home" href="#ptwo" data-transition="pop">Page 2</a>
        <a data-role="button" data-icon="home" href="#dlone" data-transition="pop" data-rel="dialog">Popup</a>
    </div>
    <div data-role="collapsible">
        <h5>Choose template</h5>
    </div>
    <div data-role="collapsible">
        <h5>Publish</h5>
        <label for="flip-mini">Publish option:</label>
        <select name="flip-mini" id="flip-mini" data-role="slider" data-mini="true">
            <option value="off">Private</option>
            <option value="on">Public</option>
        </select>
    </div>


<? $this->load->view(CURRENT_THEME.'/m/p_footer'); ?>
