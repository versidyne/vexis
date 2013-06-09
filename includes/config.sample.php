<?php
	
	// Main Database (mysql or pgsql)
	$config['database']['type'] = "mysql";
	$config['database']['host'] = "localhost";
	$config['database']['name'] = "database";
	$config['database']['user'] = "username";
	$config['database']['pass'] = "password";
	
	// Email Database
	$config['email']['type'] = "mysql";
	$config['email']['host'] = "localhost";
	$config['email']['name'] = "database";
	$config['email']['user'] = "username";
	$config['email']['pass'] = "password";
	
	// General Security
	$config['security']['key'] = "thiswillkeepmyfilessafe";
	$config['security']['install'] = "thiswillunlocktheinstaller";
	
	// General Defaults
	$config['defaults']['gateway'] = "cms";
	
	// Developer Options
	$config['developer']['debug'] = false;
	
?>
