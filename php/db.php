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
			$sql	= "select * from users where email='".$user."' AND password='".$pass."'";

			$result = mysql_query($sql,$this->link);
			$count	= mysql_num_rows($result);
			
			return $count;
		}

		function get_info_arr($table,$where="1")
		{
			$sql 	= "select * from ".$table." where 1 AND ".$where;

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
	}
?>