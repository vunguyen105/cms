<style type="text/css">
    legend {
        padding: 2px;
        font-size: 10pt;
        font-weight: bold
    }
</style>
<script type="text/javascript">
    $(function () {
        $("#btn_test_login").click(function (e) {
            e.preventDefault();
            $("#ad_login_status").html('<img src="<?=base_url()?>styles/img/loading.gif">');

            var user = $("#login").val();
            var pwd = $("#password").val();
            var url = "<?=base_url('ad/ldap_is_authenticated_user')?>";
            $.post(url, {current_user_us:user, current_user_pwd:pwd},
                function (response) {
                    $("#ad_login_status").hide().html(response).effect('fade', '1000');
                    <!--                    $("#ad_login_status").append('<img src="--><?//=base_url()?><!--styles/img/accept-24.png">');-->
                }).error(function (xhr, status, error) {
                    alert(xhr.statusText);
                });
        });
        $("#btn_switch_account").click(function (e) {
            $("#div_switch_account").fadeToggle();
        });
    });
</script>
<p class="module_title">Search Active Directory</p>

<form id="frmSearch" name="frmSearch" method="POST" action="<?=base_url('ad/do_search')?>">
    <fieldset id="div_switch_account" style="display: none; border: 1px solid #111;padding: 5px">
        <legend>Use another account</legend>
        <p>
            <label for="login">Username:</label>
            <input id="login" name="current_user_us" type="text" tabindex="0" value="<?='vnp'//$current_user?>">
            <label for="password">Password:</label>
            <input id="password" name="current_user_pwd" type="password" value="<?=''//$current_pwd?>"/>
            <input id="btn_test_login" class="button_standard" type="button" value="Login"/>
            <span id="ad_login_status"></span>

        </p>
    </fieldset>

    <fieldset style="border: 1px solid #111;padding: 5px">
        <legend>Search By</legend>
        <table class="table_custom">
            <!--<tr>
                <td>First name:</td>
                <td><input type="text" name="firstname" value="<?/*=$params['firstname']*/?>"/></td>
                <td></td>
            </tr>
            <tr>
                <td>Last Name:</td>
                <td><input type="text" name="lastname" value="<?/*=$params['lastname']*/?>"/></td>
                <td></td>
            </tr>-->
            <tr>
                <td>Name:</td>
                <td><input type="text" name="fullname" value="<?=$params['fullname']?>"/></td>
                <td></td>
            </tr>
            <tr>
                <td>Email:</td>
                <td><input type="text" name="email" value="<?=$params['email']?>"/></td>
                <td></td>
            </tr>
            <tr>
                <td>Job Title:</td>
                <td><input type="text" name="title" value="<?=$params['title']?>"/></td>
                <td></td>
            </tr>
            <tr>
                <td>Staff Code:</td>
                <td><input type="text" name="code" value="<?=$params['code']?>"/></td>
                <td></td>
            </tr>
            <tr>
                <td>Sort by:</td>
                <td>
                    <select name="sort" onchange="document.frmSearch.submit()">
                        <option value="">Default</option>
                        <option <?=$params['sort'] == "samaccountname" ? "selected=true" : ""?> value="samaccountname">
                            Staff Code
                        </option>
                        <option <?=$params['sort'] == "givenname" ? "selected=true" : ""?> value="givenname">First
                            Name
                        </option>
                        <option <?=$params['sort'] == "title" ? "selected=true" : ""?> value="title">Job Title</option>
                        <option <?=$params['sort'] == "physicaldeliveryofficename" ? "selected=true" : ""?>
                            value="physicaldeliveryofficename">Location
                        </option>
                        <option <?=$params['sort'] == "whencreated" ? "selected=true" : ""?> value="whencreated">
                            Created
                        </option>
                    </select>
                </td>
                <td></td>
            </tr>

            <tr>
                <td></td>
                <td>
                    <input class="button_standard" type="submit" value="Search"/>
                    <input class="button_standard" type="reset" value="Reset"/>
                    <input id="btn_switch_account" type="button" value="Use another account"/>
                </td>
                <td></td>
            </tr>

        </table>
    </fieldset>
</form>
<div id="staff_list" class="standard_block">
    <?if (isset($list_ad_user) && count($list_ad_user) > 0) { ?>
    <div class="right_col highlight_red"><strong>Total: <?=count($list_ad_user) ?></strong></div>
    <div class="clearfix"></div>
    <div class="standard_block border_standard">
	<table class="table_left table_standard">
        <tr class="table_header">
            <td>No.</td>
            <td>Code</td>
            <td>Name</td>
            <td>Title</td>
            <td>Office</td>
            <td>Email</td>
            <td>Created</td>
        </tr>
    <? $iCount = 0;
    foreach ($list_ad_user as $staff) {
        $iCount++?>
        <tr>
            <td><?=$iCount?></td>
            <td><?=isset($staff['samaccountname']) ? $staff['samaccountname'] : ''?></td>
            <td><?=isset($staff['displayname']) ? $staff['displayname'] : ''?></td>
            <td><?=isset($staff['title']) ? $staff['title'] : ''?></td>
            <td><?=isset($staff['physicaldeliveryofficename']) ? $staff['physicaldeliveryofficename'] : ''?></td>
            <td><?if (isset($staff['mail'])) {
                echo "<a href='mailto:" . $staff['mail'] . "'>" . $staff['mail'] . "</a>";
            }?></td>
            <td><?=isset($staff['whencreated']) ? substr($staff['whencreated'], 0, 8) : ''?></td>
        </tr>
        <? } ?>
    <? } elseif (isset($error) && ($error != '')) { ?>
    <div class="ui-widget">
        <div class="ui-state-error ui-corner-all">
            <p>
                <span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
                <strong>Error:</strong> <?=$error?>.</p>
        </div>
    </div>
    <? } else { ?>
    <div class="ui-widget">
        <div class="ui-state-highlight ui-corner-all">
            <p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
                No result.</p>
        </div>
    </div>
    <? }?>
</table>
</div>
</div>