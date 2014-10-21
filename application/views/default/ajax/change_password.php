<h6>Update your password</h6>
<div id="login_form" class="border_standard" title="Change password!">
    <form method="POST" action="<?=base_url('home/do_change_password')?>">
        <table>
            <?if (isset($error)) { ?><p
            style="color: red; text-align: center; font-weight: bold;"><?=$error?></p><? }?>
            <tr title="New password">
                <td>New password:</td>
                <td><input class="textbox" name="txtPassword" value="" type="password" tabindex="0"/></td>
                <td><?=isset($error) ? '<p style="color: red; font-weight: bold;">*</p>' : ""?></td>
            </tr>
            <tr title="Confirm new password">
                <td>Confirm password:</td>
                <td><input class="textbox" name="txtPassword1" type="password"/></td>
                <td><?=isset($error) ? '<p style="color: red; font-weight: bold;">*</p>' : ""?></td>
            </tr>
            <tr>
                <td colspan="3">
                </td>
            </tr>
            <tr>
                <td></td>
                <td colspan="3">
                    <input class="button_standard" type="submit" value="Save"/>
                    <input class="button_standard" type="reset" value="Cancel"/>
                </td>
            </tr>
        </table>
    </form>
</div>
