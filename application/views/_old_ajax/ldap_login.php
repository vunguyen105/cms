<div id="login-wrapper">
    <form method="POST" action="<?=base_url('ldap/do_login')?>" class="login">
        <p>
            <label for="login">Username:</label>
            <input id="login" name="username" type="text" tabindex="0" value="">
        </p>

        <p>
            <label for="password">Password:</label>
            <input id="password" name="password" type="password"/>
        </p>

        <p class="login-submit">
            <button type="submit" class="login-button">Login</button>
        </p>

        <p class="forgot-password">
            <?if ((isset($error)) && $error != '') {
            echo $error;
        }?>
            <a href="<?=base_url('feedback')?>" class="login-button">Support</a></p>
    </form>
</div>
