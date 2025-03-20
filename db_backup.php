<?php
	session_start();

	require_once("config.php");
	
	Class DBAccess
	{
		var $link = null;
		
		function DBAccess()
		{
			$this->link = mysql_connect(IP_ADDR,USER_NAME,USER_PASS);

			mysql_select_db(DB_NAME,$this->link);
		}

		function verify_userlogin($user, $pass)
		{
			$sql	= "select * from tbl_user where user='".$user."' AND pass='".$pass."'";

			$result = mysql_query($sql,$this->link);
			$count	= mysql_num_rows($result);
			
			return $count;
		}

		function get_info_arr($table, $order="", $where="1")
		{
			$sql 	= "select * from ".$table." where 1 AND ".$where.$order;

			$result = mysql_query($sql);
			$rows 	= array();

			while($res = mysql_fetch_assoc($result))
			{
				$rows[] = $res;
			}

			return $rows;
		}

		function run_sql($sql)
		{
			mysql_query($sql);

			return mysql_insert_id();
		}

		function get_pages()
		{
			$menu_html 	= "";
			$page_html  = "";
			$title 		= "";

			$filter_arr	= $this->get_info_arr("tbl_filters", " ORDER BY order_num", "is_show=1");

			for($i = 0; $i < count($filter_arr); $i ++)
			{
				$tbl_name  = $filter_arr[$i]["tbl_name"];
				$sort_data = "";

				if($tbl_name == "tbl_size")
				{
					$sort_data = " ORDER BY width";
				}

				$tbl_data  = $this->get_info_arr($tbl_name, $sort_data);
				$pg_name   = str_replace("tbl_", "page_", $tbl_name);
				$title 	   = $filter_arr[$i]["name"];

				if($title == "EXTERIOR")
					$title = "COLOR";
				
				$menu_html .= "<li><span>".$title."</span></li>";
				$page_html .= $this->get_page_content($pg_name, $tbl_data);
				
			}

			$ret["menu"] = $menu_html;
			$ret["page"] = $page_html;

			return $ret;
		}

		function get_page_content($pg_name, $tbl_data)
		{
			$page_html = "";

			switch($pg_name) 
			{
				case "page_style":
					$page_html .= '<page id="'.$pg_name.'">';
					$page_html .= '<ul>';

					for($j = 0; $j < count($tbl_data); $j ++)
					{
						$page_html .= '<li obj="'.$tbl_data[$j]["path_obj"];
						$page_html .= '" mtl="'.$tbl_data[$j]["path_mtl"].'" d_id="'.$tbl_data[$j]["id"].'">';
						$page_html .= '<img src="img/thumbs/style/'.$tbl_data[$j]["path_thumb"].'">';
						$page_html .= '<h5>'.$tbl_data[$j]["name"].'</h5></li>';
					}

					$page_html .= "</ul></page>";
				break;

				case "page_grills":
					$page_html .= '<page id="'.$pg_name.'">';
					$page_html .= '';
					$last_s_id = -1;

					for($j = 0; $j < count($tbl_data); $j ++)
					{
						if($tbl_data[$j]["style_id"] != $last_s_id)
						{
							if($j)
							{
								$page_html .= "</ul>";
								$page_html .= "<ul s_id='".$tbl_data[$j]["style_id"]."'>";
							}
							else
							{
								$page_html .= "<ul class='show' s_id='".$tbl_data[$j]["style_id"]."'>";
							}
						}

						$page_html .= '<li obj="'.$tbl_data[$j]["path_obj"];
						$page_html .= '" mtl="'.$tbl_data[$j]["path_mtl"].'">';
						$page_html .= '<img src="img/thumbs/grill/'.$tbl_data[$j]["path_thumb"].'">';
						$page_html .= '<h5>'.$tbl_data[$j]["name"].'</h5></li>';

						$last_s_id = $tbl_data[$j]["style_id"];
					}

					$page_html .= "</ul></page>";
				break;

				case "page_glass":
					$page_html .= '<page id="'.$pg_name.'">';
					$page_html .= '<ul>';

					for($j = 0; $j < count($tbl_data); $j ++)
					{
						$page_html .= '<li>';
						$page_html .= '<img src="img/thumbs/glass/'.$tbl_data[$j]["path_img"].'">';
						$page_html .= '<h5>'.$tbl_data[$j]["name"].'</h5></li>';
					}

					$page_html .= "</ul></page>";
				break;

				case "page_material":
					$page_html .= '<page id="'.$pg_name.'">';
					$page_html .= '<ul>';

					for($j = 0; $j < count($tbl_data); $j ++)
					{
						$page_html .= '<li>';
						$page_html .= '<img src="img/thumbs/material/'.$tbl_data[$j]["path_img"].'">';
						$page_html .= '<h5>'.$tbl_data[$j]["name"].'</h5></li>';
					}

					$page_html .= "</ul></page>";
				break;
				
				case "page_size" :

					$info_arr  = array();
					$width 	   = 0;

					for($j = 0; $j < count($tbl_data); $j ++)
					{
						if($width != $tbl_data[$j]["width"])
						{
							$width = $tbl_data[$j]["width"];
							$info_arr[$width] = array();
						}

						array_push($info_arr[$width], $tbl_data[$j]["height"]);
					}

					$page_html .= '<page id="'.$pg_name.'">';
					$page_html .= "<input type='hidden' value='".json_encode($info_arr)."' id='txt_size'>";
					$page_html .= '<table>';
					$page_html .= '<tr><td>Width: </d><td><div class="slider" id="width_slider"></div>';
					$page_html .= '<input type="number" id="num_width" readonly="readonly"></td></tr>';
					$page_html .= '<tr><td>Height: </td><td><div class="slider" id="height_slider"></div>';
					$page_html .= '<input type="number" id="num_height" readonly="readonly"></td></tr>';
					$page_html .= '</table></page>';

				break;

				case "page_interior":
					$page_html .= '<page id="'.$pg_name.'">';
					$page_html .= '<ul>';

					$page_html .= '<li><div class="color"></div><h6>None</h6></li>';

					for($j = 0; $j < count($tbl_data); $j ++)
					{
						$page_html .= '<li>';
						$page_html .= '<div class="color" color="'.$tbl_data[$j]["color"].'"></div>';
						$page_html .= '<h6>'.$tbl_data[$j]["name"].'</h6></li>';
					}

					$page_html .= "</ul></page>";
				break;

				case "page_exterior":
					$page_html .= '<page id="'.$pg_name.'">';
					$page_html .= '<ul>';

					$page_html .= '<li><div class="color"></div><h6>None</h6></li>';

					for($j = 0; $j < count($tbl_data); $j ++)
					{
						$page_html .= '<li>';
						$page_html .= '<div class="color" color="'.$tbl_data[$j]["color"].'"></div>';
						$page_html .= '<h6>'.$tbl_data[$j]["name"].'</h6></li>';
					}

					$page_html .= "</ul></page>";
				break;
			}

			return $page_html;
		}

		function get_next_table($curr_order)
		{
			$data 	= $this->get_info_arr("tbl_filters", "", "order_num=".($curr_order + 1));

			return $data[0]["tbl_name"];
		}

		function get_item_list($prev_params, $curr_order)
		{
			$next_tbl 	= $this->get_next_table($curr_order);
			$param_arr 	= explode(",", $prev_params);
			$where  	= "";
			$window_id 	= str_replace("tbl_", "id_", $next_tbl);
			$pg_name 	= str_replace("tbl_", "page_", $next_tbl);

			if($window_id == "id_exterior")
				$window_id = "id_color";

			for($i = 0; $i < count($param_arr); $i ++)
			{
				$info_arr = explode(":", $param_arr[$i]);
				$where   .= $info_arr[0]."=".$info_arr[1];

				if($i != count($param_arr) - 1)
				{
					$where .= " OR ";
				}
			}

			$sql  = "SELECT * FROM tbl_window ";
			$sql .= "LEFT JOIN ".$next_tbl." ON (tbl_window.".$window_id."=".$next_tbl.".id) ";
			$sql .=" WHERE 1 AND ".$where;

			$result = mysql_query($sql);
			$rows 	= array();

			while($res = mysql_fetch_assoc($result))
			{
				$rows[] = $res;
			}

			return $this->get_page_content($pg_name, $rows);
		}
	}
?>
