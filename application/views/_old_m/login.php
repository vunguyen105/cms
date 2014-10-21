<? $this->load->view('m/p_header'); ?>
<? if (($this->session->userdata('CURRENT_USER_ID') == "")) { ?>
<div>
    <form method="POST" action="<?=base_url('m/do_login')?>">
        <label for="login">Username / email</label>
        <input id="login" type="text" name="txtUsername" placeholder="Username or email" required>
        <label for="password">Password</label>
        <input id="password" type="password" name='txtPassword' placeholder="Password" required>
        <input type="submit" name="submit" value="Login" class="button_standard">
    </form>
    <?if ((isset($error)) && $error != '') {
    echo '<p id="error">' . $error . '</p>';
}?>
</div>
<? $this->load->view('m/p_footer'); ?>
<? } else {?>
    <h4>You already logged in.</h4>
        <a href="<?=base_url('m')?>">Home</a>
        <a href="<?=base_url('m/logout')?>">Logout</a>
    <?}?>
