<?php
	ini_set("display_errors", 0);
	require_once("php/db.php");

	$db = new DBAccess();
	$login = $db->verify_userlogin($_REQUEST["txt_username"], $_REQUEST["txt_password"]);

	if(isset($_GET["mode"]) && $_GET["mode"] == "logout")
	{
		session_destroy();
	}

	if($login)
	{
		$_SESSION["login"] = "login";
		header("location:admin.php");
	}
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Window Customize Admin</title>

    <link rel="stylesheet" type="text/css" href="style/admin.css" />
    <link rel="stylesheet" type="text/css" href="style/overlay.css" />
</head>

<script type="text/javascript" src="js/library/jquery.min.js"></script>
<script type="text/javascript" src="js/library/jquery-ui.min.js"></script>

<body>
	<div id="header-area">
		<!--img src="img/img_logo.png" id="btn_logo"></img-->
		<h3>Administrator</h3>
	</div>
	
	<div id="login-body">
		<form method="POST" action="login.php">
			<center>Please Update Price information</center>
			<table id="tbl_main">
				<tr>
					<td>Username :</td>
					<td><input type="text" id="txt_username" name="txt_username"></td>
				</tr>
				<tr>
					<td>Password :</td>
					<td><input type="password" id="txt_password" name="txt_password"></td>
				</tr>
			</table>

			<center>
				<input type="submit" id="btn_login" value="Login">
			</center>
		</form>
	</div>
</body>