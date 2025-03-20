<?php
	require_once("db.php");

	ini_set("display_errors", "0");

	$db = new DBAccess();

	switch ($_REQUEST['mode'])
	{
		case "save_house" :
			rename("../upload/".$_REQUEST["url_image"], "../img/house/".$_REQUEST["url_image"]);
			rename("../upload/".$_REQUEST["url_thumb"], "../img/house/".$_REQUEST["url_thumb"]);

			$sql  = "INSERT INTO table_house SET ";
			$sql .= "`url_image`='".$_REQUEST["url_image"]."', ";
			$sql .= "`url_thumb`='".$_REQUEST["url_thumb"]."'  ";

			echo $db->run_sql($sql);
		break;
		case "save_stone" :
			rename("../upload/".$_REQUEST["url_thumb"], "../img/stones/".$_REQUEST["url_thumb"]);

			$sql  = "INSERT INTO table_stone SET ";
			$sql .= "`title`	='".$_REQUEST["txt_title"]."', ";
			$sql .= "`image`	='".$_REQUEST["url_stone"]."'  ";

			echo $db->run_sql($sql);
		break;
		case "remove_house" : 
			$ids 		= explode(",", $_REQUEST["id_list"]);
			$where 		= "";
			$img_arr  	= array();
			$path 		= "../img/house/";

			for($i = 0; $i < count($ids) - 1; $i ++)
			{
				$where .= "id='".$ids[$i]."'";

				if($i < count($ids) - 2)
					$where .= " OR ";
			}

			$img_arr = $db->get_info_arr("table_house", $where);

			$db->run_sql("DELETE FROM table_house WHERE ".$where);

			for($i = 0; $i < count($img_arr); $i ++)
			{
				unlink($path.$img_arr[$i]["url_image"]);
				unlink($path.$img_arr[$i]["url_thumb"]);
			}
		break;
		case "remove_stone" : 
			$ids 		= explode(",", $_REQUEST["id_list"]);
			$where 		= "";
			$img_arr  	= array();
			$path 		= "../img/stones/";

			for($i = 0; $i < count($ids) - 1; $i ++)
			{
				$where .= "id='".$ids[$i]."'";

				if($i < count($ids) - 2)
					$where .= " OR ";
			}

			$img_arr = $db->get_info_arr("table_stone", $where);

			$db->run_sql("DELETE FROM table_stone WHERE ".$where);

			for($i = 0; $i < count($img_arr); $i ++)
			{
				unlink($path.$img_arr[$i]["image"]);
			}
		break;
	}
?>