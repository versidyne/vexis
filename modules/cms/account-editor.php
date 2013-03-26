<?php

	if ($validator['code'] != md5($validator['key'])) { echo "Please do not access this file directly."; exit; }

	// Retreive Credentials
		
	$credentials = retreive_credentials(cookie_data($settings[cookie_prefix]));
				
	// Retreive Member Variables
		
	$mvar = member_vars(lookup_member_id($credentials[email]));

	// Continue

	if ($act == save_settings) {

		mysql_query ("UPDATE members SET email = '$email_input', nickname = '$nickname_input', first_name = '$first_name_input', last_name = '$last_name_input' WHERE id = '$mvar[id]'") or die (mysql_error() );

		// update the session's email

		header ("Location: $website/?page=membercp");

	}

	else {

		$custom_title = "Edit Account";
		$custom_header = "Edit Account";
		$custom_body = "<form action='$website/?page=account-editor&act=save_settings' method='post'>
		<input type='hidden' name='id_input' value='$mvar[id]'>

		<table>

		<tr>
			<td>Email Address:</td>
			<td><input type='text' name='email_input' size='33' value='$mvar[email]'></td>
		</tr>

		<tr>
			<td>Nickname:</td>
			<td><input type='text' name='nickname_input' size='33' value='$mvar[handle]'></td>
		</tr>

		<tr>
			<td>First Name:</td>
			<td><input type='text' name='first_name_input' size='33' value='$mvar[first_name]'></td>
		</tr>

		<tr>
			<td>Last Name:</td>
			<td><input type='text' name='last_name_input' size='33' value='$mvar[last_name]'></td>
		</tr>

		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>

		<tr>
			<td>&nbsp;</td>
			<td><input class='button' type='submit' value='Save' title='Save Changes'></td>
		</tr>

		</table>

		</form>";

	}

?>
