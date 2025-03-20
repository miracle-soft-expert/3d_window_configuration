<?php
	ini_set("display_errors", 0);

	require_once("php/db.php");

	$fname 		= "config.txt";
	$message	= "";

	$db 		= new DBAccess();
	$house_arr 	= $db->get_info_arr("table_house");
	$li_html 	= "";

	for($i = 0; $i < count($house_arr); $i ++)
	{
		$li_html .= "<li info='".$house_arr[$i]["id"]."'><img src='img/house/".$house_arr[$i]["url_thumb"]."'></li>";
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
<script type="text/javascript" src="js/library/SimpleAjaxUploader.js"></script>
<script type="text/javascript" src="js/mine/popup.js"></script>
<script type="text/javascript" src="js/mine/admin.js"></script>

<body>
	<?php require_once("theme/popup.html"); ?>
	<div id="header-area">
		<!--img src="img/img_logo.png" id="btn_logo"></img-->
		<h3>Administrator</h3>
	</div>

	<div id="admin-left">
		<ul>
			<li class="active">FILTERS DISPLAY</li>
			<li>FILTERS DETAIL</li>
		</ul>
	</div>
	<div id="admin-right">
		<div id="admin-body">
			<page class="admin-page" id="page_filter">
				<form method="POST">
					<h3>Filters Display</h3>
					<div class="page-content">
						<ul class="filter_list" id="filters_available">
							<li>Style</li>
							<li>Material</li>
							<li>Style</li>
							<li>Material</li>
							<li>Style</li>
							<li>Material</li>
						</ul>
						<ul class="filter_list" id="filters_dispaly">
							<li>Style</li>
							<li>Material</li>
							<li>Style</li>
							<li>Material</li>
							<li>Style</li>
							<li>Material</li>
						</ul>
					</div>					
				</form>
			</page>
			<div id="action-area">
				<input type="button" id="btn_del" value="Delete">
				<input type="button" id="btn_add" value="Add">
			</div>
		</div>
	</div>
</body>