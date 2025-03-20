<?php
	ini_set("display_errors", 0);
	require_once("php/db.php");

	$db = new DBAccess();
	$data = $db->get_pages();
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Window Customize</title>

    <link rel="stylesheet" type="text/css" href="style/style.css" />
    <link rel="stylesheet" type="text/css" href="style/overlay.css" />
    <link rel="stylesheet" type="text/css" href="style/jquery-ui.css" />
</head>

<script type="text/javascript" src="js/library/jquery.min.js"></script>
<script type="text/javascript" src="js/library/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/library/SimpleAjaxUploader.js"></script>

<script type="text/javascript" src="js/library/three/three.js"></script>
<script type="text/javascript" src="js/library/three/OBJLoader.js"></script>
<script type="text/javascript" src="js/library/three/MTLLoader.js"></script>
<script type="text/javascript" src="js/library/three/OrbitControls.js"></script>

<script type="text/javascript" src="js/mine/popup.js"></script>
<script type="text/javascript" src="js/mine/main.js"></script>
<script type="text/javascript" src="js/mine/engine.js"></script>

<body>
	<?php require_once("theme/popup.html"); ?>
	<div id="header-area">
		<img src="img/logo_2.png" id="btn_logo"></img>
		<h3>Window Customize</h3>
	</div>

	<div id="content-body">
		<ul id="progress-bar">
			<?php echo $data["menu"]; ?>
		</ul>
		<div id="main-body">
			<h3>Style List</h3>
			<div id="content">
				<page id="page_style" class="active">
					<ul>
						<li mode="Normal_Casement" class="sel">
							<img src="img/thumbs/screen/JW-Casement-2500-VerticalRectangle.jpg">
							<h5>Casement/Single</h5>
						</li>
						<li mode="Normal_Single_Hung">
							<img src="img/thumbs/screen/AC-SingleHung-VerticalRectangle-50.jpg">
							<h5>Hung/Double Hung</h5>
						</li>
					</ul>
				</page>
				<page id="page_size">
					<!--table>
						<tr>
							<td>Width : </td>
							<td>
								<div class="slider"></div>
								<input type="number" id="num_width" value="10.8" readonly="readonly">
							</td>
						</tr>
						<tr>
							<td>Height : </td>
							<td>
								<div class="slider"></div>
								<input type="number" id="num_height" value="16.0" readonly="readonly">
							</td>
						</tr>
						<tr>
							<td>Length : </td>
							<td>
								<div class="slider"></div>
								<input type="number" id="num_length" value="1.7" readonly="readonly">
							</td>
						</tr>
					</table-->
					<table>
						<tr>
							<td>Size:</td>
							<td>
								<select>
									<option sizex="34" sizey="56">34 x 56</option>
									<option sizex="34" sizey="56">34 x 56</option>
									<option sizex="34" sizey="56">34 x 56</option>
								</select>
							</td>
						</tr>
					</table>
				</page>
				<page id="page_grill">
					<ul>
						<li data="colonial" class="sel">
							<img src="img/thumbs/grill/colonial.jpg">
							<h5>Colonial</h5>
						</li>
						<li data="fractional">
							<img src="img/thumbs/grill/fractional.jpg">
							<h5>Fractional</h5>
						</li>
						<li data="prairie">
							<img src="img/thumbs/grill/prairie.jpg">
							<h5>Prairie</h5>
						</li>
						<li data="none">
							<img src="img/thumbs/grill/none.png">
							<h5>None</h5>
						</li>
					</ul>
				</page>
				<page id="page_glass">
					<ul>
						<li class="sel">
							<img src="img/thumbs/glass/baltique.jpg">
							<h5>Baltique</h5>
						</li>
						<li>
							<img src="img/thumbs/glass/chinchilla_clair.jpg">
							<h5>Chinchilla</h5>
						</li>
						<li>
							<img src="img/thumbs/glass/delta_matte_blanc.jpg">
							<h5>Delta Matte</h5>
						</li>
						<li>
							<img src="img/thumbs/glass/etre.jpg">
							<h5>Etre</h5>
						</li>
						<li>
							<img src="img/thumbs/glass/julie.jpg">
							<h5>Julie</h5>
						</li>
					</ul>
				</page>
				<page id="page_material">
					<ul>
						<li class="sel">
							<img src="img/thumbs/wood/beech.jpg">
							<h5>Beech</h5>
						</li>
						<li>
							<img src="img/thumbs/wood/knotty-alder.jpg">
							<h5>Knotty Alder</h5>
						</li>
						<li>
							<img src="img/thumbs/wood/knotty-pine.jpg">
							<h5>Knotty Pine</h5>
						</li>
						<li>
							<img src="img/thumbs/wood/red-oak.jpg">
							<h5>Red Oak</h5>
						</li>
						<li>
							<img src="img/thumbs/wood/walnut.jpg">
							<h5>Walnut</h5>
						</li>
					</ul>
				</page>
				<page id="page_render">
					<div id="render_area"></div>
				</page>
			</div>
			<div id="action-area">
	           	<input type="button" id="btn_next" value="Next">
	           	<input type="button" id="btn_prev" value="Prev" disabled="disabled">
	        </div>
		</div>
	</div>

	<div id="footer-area">
		Copyright&copy;2017, All rights reserved.
	</div>
</body>