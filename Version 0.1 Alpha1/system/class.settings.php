<?php
class Settings
{

	function __construct()
	{
		$this->mysql = new Mysql();
	}
	
	function get_setting_value($setting_name)
	{
		$sql = "SELECT * FROM settings WHERE setting_name={val}";
		$data = array('{val}' => $setting_name);
		if($this->mysql->num_row($sql, $data) == 1)
		{
			$row =	$this->mysql->assoc($sql, $data);
			return $row['setting_value'];
		}else{
			//
			if($this->mysql->num_row($sql, $data) > 1)
			{
				throw new Exception('More results then 1 on setting: '.$setting_name);
			}
			return false;
		}
	}
	
	function base_url()
	{
	
		$sql1 = "SELECT * FROM settings WHERE setting_name={val}";
		$data1 = array('{val}' => 'prefix_url');
		
		$sql2 = "SELECT * FROM settings WHERE setting_name={val}";
		$data2 = array('{val}' => 'website_url');
		
		$sql3 = "SELECT * FROM settings WHERE setting_name={val}";
		$data3 = array('{val}' => 'path_url');
		
		if($this->mysql->num_row($sql1, $data1) && $this->mysql->num_row($sql2, $data2) && $this->mysql->num_row($sql3, $data3))
		{
			$row1 =	$this->mysql->assoc($sql1, $data1);
			$row2 =	$this->mysql->assoc($sql2, $data2);
			$row3 =	$this->mysql->assoc($sql3, $data3);
			$url = $row1['setting_value'].$row2['setting_value'].'/'.$row3['setting_value'];
			return $url;
		}
	}

}