<style type="text/css">
    legend {
        padding: 2px;
        font-size: 10pt;
        font-weight: bold
    }

    input[type=text], input[type=password] {
        width: 200px
    }
</style>
<script type="text/javascript">
    $(function () {
        $("#form_ad_login").submit(function() {
            $("#login_status").html('<img src="<?=base_url()?>styles/images/loading.gif"/>');
            var user = $("#login").val();
            var pwd = $("#password").val();
            var url = "<?=base_url('ad/ldap_is_authenticated_user')?>";
            $.post(url, {current_user_us:user, current_user_pwd:pwd},
                function (response) {
                    $("#login_status").hide().html(response).effect('fade', '1000');
                    $("#login_status").append('<br/>');
                    if (response=='Logged in successfully'){
                        window.location.href = "<?=base_url('ad/search')?>";
                    }
                }).error(function (xhr, status, error) {
                    alert(xhr.statusText);
                });
            return false;
        });
        $("#btn_reset").click(function (e) {$("#login_status").hide('fade','500');});
        $("#login").select();
    });
</script>
<form id="form_ad_login" method="POST" action="<?=base_url('ad/do_login')?>">
    <fieldset style="border: 1px solid #111;padding: 5px">
        <legend>Login with your AD Account</legend>
        <table class="table_left table_standard">
            <tr>
                <td width="120px">Username:</td>
                <td><input id="login" name="current_user_us" type="text" tabindex="0" value="<?=$current_user?>"></td>
            </tr>
            <tr>
                <td>Password:</td>
                <td><input id="password" name="current_user_pwd" type="password" value="<?=$current_pwd?>"/></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <span id="login_status"><? if (isset($error) && ($error != '')) {echo $error.'<br/>';}?></span>
                    <input id="btn_login" class="button_standard" type="submit" value="Login"/>
                    <input id="btn_reset" class="button_standard" type="reset" value="Clear"/>
                </td>
            </tr>

        </table>
    </fieldset>
</form>