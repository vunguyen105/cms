<div>
	<h2>Search LDAP</h2>
    <form id="frmSearch" name="frmSearch" method="POST" action="ldap.php">
        <table class="table_custom">
            <tr>
                <td>Full name:</td>
                <td><input type="text" name="fullname" value=""/></td>
                <td></td>
            </tr>
			<tr>
                <td>First name:</td>
                <td><input type="text" name="firstname" value=""/></td>
                <td></td>
            </tr>
            <tr>
                <td>Last Name:</td>
                <td><input type="text" name="lastname" value=""/></td>
                <td></td>
            </tr>
            <tr>
                <td>Email:</td>
                <td><input type="text" name="email" value=""/></td>
                <td></td>
            </tr>
            <tr>
                <td>Job Title:</td>
                <td><input type="text" name="title" value=""/></td>
                <td></td>
            </tr>
            <tr>
                <td>Staff ID:</td>
                <td><input type="text" name="code" value=""/></td>
                <td></td>
            </tr>
            
            <tr>
                <td></td>
                <td>
                    <input class="button_standard" type="submit" value="Search"/>
                    <input class="button_standard" type="reset" value="Reset"/>
                </td>
                <td></td>
            </tr>
        </table>
    </form>
</div>