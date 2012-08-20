<?php
class check_style
{
	var $mysql;
	
	function __construct()
	{
		require_once('system/framework/class.mysql.php');
		$this->mysql = new Mysql();
	}
	
	function default_style()
	{
		//Als de user geen style heeft ingesteld word deze functie geladen
		$sql = "SELECT * FROM settings WHERE setting_name='default_style'";
		if($this->mysql->num_row($sql) > 0)
		{
			$row =	$this->mysql->assoc($sql);
			return $row['setting_value'];
		}else{
			//
		}
	}
	
	function user_style()
	{
		//Als de user een style heeft ingesteld word deze functie geladen
		//Omdat het inlog systeem nog niet bestaat of nog niet af is, is dit een tijdelijk script
		return "stop";
	}
	
	function load()
	{
		//Deze functie word ingeladen in een andere class
		//if($this->user_style() !== "stop")
		//{
			$style = $this->default_style();
			return $style;
		//}else{
			//return 'yo';
		//}
	}
}
?>
