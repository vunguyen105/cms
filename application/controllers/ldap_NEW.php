<?php 
	$user['givenname'] = trim($_POST['firstname']);
	$user['sn'] = trim($_POST['lastname']);
	$user['displayname'] = trim($_POST['fullname']);
	$user['title']= trim($_POST['title']);
	$user['mail'] = trim($_POST['email']);
	$user['cn']= trim($_POST['code']);

	$ldap_query = "(&";
	$ldap_query .= "(objectClass=user)";
	
	if ($user['displayname']!='') {$ldap_query.="(displayname=*".$user['displayname']."*)";};
	if ($user['givenname']!='') {$ldap_query.="(givenname=*".$user['givenname']."*)";};
	if ($user['sn']!='') {$ldap_query.="(sn=*".$user['sn']."*)";};
	if ($user['title']!='') {$ldap_query.="(title=*".$user['title']."*)";};
	if ($user['mail']!='') {$ldap_query.="(mail=*".$user['mail']."*)";};
	if ($user['cn']!='') {$ldap_query.="(cn=*".$user['cn']."*)";};

	$ldap_query .= ")";

	// Setup LDAP
	$user = 'vnp1976v';
	$password = 'sms.vanphuc';
	// For Vanphuc 
	$host = 'vp-ads-s01';
	//$host = 'CON-ADS-S01';
	$domain = 'kinderworldgroup.com';
	$basedn = 'dc=kinderworldgroup,dc=com';
	$group = 'kinderworldgroup.com';

	$ad = ldap_connect("ldap://{$host}.{$domain}") or die('Could not connect to LDAP server.');
	ldap_set_option($ad, LDAP_OPT_PROTOCOL_VERSION, 3);
	ldap_set_option($ad, LDAP_OPT_REFERRALS, 0);

	//if ($bind = ldap_bind($ad, "{$user}@{$domain}", $password)){
	$account="kinderworld\\vnp1976v";
	if ($bind = ldap_bind($ad, $account, $password)){
		// limit attributes we want to look for
		$attributes_ad = array("displayName","description","cn","givenName","sn","mail","co","mobile","company","title");
		$attributes_ad = array();
		$sr = ldap_search($ad, "DC=kinderworldgroup,DC=com", $ldap_query,$attributes_ad);
		$data = ldap_get_entries($ad, $sr);

		
		// SHOW ALL DATA
		echo '<h1>Dump all data</h1><pre>';
		echo 'Found: '.$data["count"].' records';
		//print_r($data);
		echo '</pre>';

		

		// iterate over array and print data for each entry
		for ($i=0; $i<$data["count"];$i++) {
			for ($j=0;$j<$data[$i]["count"];$j++){
				echo "<strong>".$data[$i][$j]."</strong>: ".$data[$i][$data[$i][$j]][0]."<br/>";
			}
			echo "<br /><br />";
		}
		
		//echo json_encode($data);
	}
	echo "Finished";

	ldap_unbind($ad);

/*
function ldap_do_search() {
	$post_data = $this->input->post();
	$condition = "";
	if (isset($post_data['givenname'])){
		$condition .= " givenname=".$post_data['givenname'];
	}
	if (isset($post_data['givenname'])){
		$condition .= " givenname=".$post_data['givenname'];
	}
	if (isset($post_data['givenname'])){
		$condition .= " givenname=".$post_data['givenname'];
	}
}

function ldapff()
{
	$user = 'vnp1976v';
	$password = 'sms.vanphuc';
	$host = 'vp-ads-s01';
	$domain = 'kinderworldgroup.com';
	$basedn = 'dc=kinderworldgroup,dc=com';
	$group = 'kinderworldgroup.com';

	$ad = ldap_connect("ldap://{$host}.{$domain}") or die('Could not connect to LDAP server.');
	ldap_set_option($ad, LDAP_OPT_PROTOCOL_VERSION, 3);
	ldap_set_option($ad, LDAP_OPT_REFERRALS, 0);

	if ($bind = ldap_bind($ad, "{$user}@{$domain}", $password)){
		// limit attributes we want to look for
		$attributes_ad = array("displayName","description","cn","givenName","sn","mail","co","mobile","company","memberof");
		$sr = ldap_search($ad, "DC=kinderworldgroup,DC=com", "givenname=huy",$attributes_ad);
		$data = ldap_get_entries($ad, $sr);

		// SHOW ALL DATA
		echo '<h1>Dump all data</h1><pre>';
		echo 'Found: '.$data["count"].' records';
		//print_r($data);
		echo '</pre>';


		// iterate over array and print data for each entry
		for ($i=0; $i<$data["count"];$i++) {
			for ($j=0;$j<$data[$i]["count"];$j++){
				echo "<strong>".$data[$i][$j]."</strong>: ".$data[$i][$data[$i][$j]][0]."<br/>";
			}
			echo "<br /><br />";
		}
	}
	echo "Finished";

	ldap_unbind($ad);
}
*/