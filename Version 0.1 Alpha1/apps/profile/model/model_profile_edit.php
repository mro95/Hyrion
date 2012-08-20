<?php
class model_profile_edit extends Model
{
	function __construct()
    {
        parent::construct();
    }
	
	function get_profile_data($user_id)
	{
		$sql = "SELECT * FROM profile";
		//$sql = "SELECT * FROM profile_data JOIN profile ON profile.profile_id = profile_data.profile_id WHERE user_id=1";
		$result = mysql_query($sql);
		$result_array = array();
		while($row = mysql_fetch_assoc($result))
		{
			$sql2 = "SELECT * FROM profile_data WHERE user_id=".$this->mysql->escape($user_id)." AND profile_id=".$this->mysql->escape($row['profile_id']);
			$result2 = mysql_query($sql2);
			$row2 = mysql_fetch_assoc($result2);
			if($row2['profile_data_value'] != NULL || $row2['profile_data_value'] != '')
			{
				$row['profile_data_value'] = $row2['profile_data_value'];
			}else{
				$row['profile_data_value'] = '';
			}
			
			if($row['required'] != 1)
			{
				$row['required2'] = "";
			}else{
				$row['required2'] = "*";
			}
			
			array_push($result_array, $row);
		}
		return $result_array;
	}
	
	function create_profile($user_id)
	{
		foreach($_POST as $key => $value) {
			if($key != "button")
			{
				//echo $key.":".$value."<br />";
				$sql_profile = "SELECT * FROM profile WHERE profile_field='".$this->mysql->escape($key)."'";
				$result1 = mysql_query($sql_profile);
				$row1 = mysql_fetch_assoc($result1);
				
				$select_sql = "SELECT * FROM profile_data WHERE user_id=".$this->mysql->escape($user_id)." AND profile_id='".$this->mysql->escape($row1['profile_id'])."'";
				if($this->mysql->num_row($select_sql, $data=null) < 1)
				{
					$sql = "INSERT INTO profile_data (user_id,profile_id,profile_data_value)VALUES(".$this->mysql->escape($user_id).",".$this->mysql->escape($row1['profile_id']).",'".$this->mysql->escape($value)."')";
					$this->mysql->query($sql, $data=null);
				}
				
			}
		}
		return true;
		//$sql = "INSERT INTO profile_data (user_id,profile_id,profile_data_value)VALUES(".$this->mysql->escape($user_id).",".$this->mysql->escape($_POST[]).",'".$this->mysql->escape($_POST[])."')";
	}
	
	function edit_profile($user_id)
	{
		$check_array = array();
		foreach($_POST as $key => $value) 
		{
			if($key != "button")
			{
				//echo $key.":".$value."<br />";
				$sql_profile = "SELECT * FROM profile WHERE profile_field='".$this->mysql->escape($key)."'";
				$result1 = mysql_query($sql_profile);
				$row1 = mysql_fetch_assoc($result1);
				
				$select_sql = "SELECT * FROM profile_data WHERE user_id=".$this->mysql->escape($user_id)." AND profile_id='".$this->mysql->escape($row1['profile_id'])."'";
				if($this->mysql->num_row($select_sql, $data=null) > 0)
				{	
					if($row1['required'] == 1)
					{
						if($value == '' || empty($value))
						{
							$check_array[] = 1;
						}
					}
					$sql = "UPDATE profile_data SET profile_data_value='".$this->mysql->escape($value)."' WHERE user_id=".$this->mysql->escape($user_id)." AND profile_id=".$this->mysql->escape($row1['profile_id']);
					$this->mysql->query($sql, $data=null);
				}
				
			}
		}
		//print_r($check_array);
		$eentrue=0;
		foreach($check_array as $value){
			$eentrue=$eentrue|$value;
		}
		if($eentrue){
			return 'forgot';
		}else{
			return 'success';	
		}
	}
	
	function check_profile($user_id)
	{
		$sql_profile = "SELECT * FROM profile";
		$result1 = mysql_query($sql_profile);
		$check_array = array();
		while($row1 = mysql_fetch_assoc($result1))
		{
			$select_sql = "SELECT * FROM profile_data WHERE user_id=".$this->mysql->escape($user_id)." AND profile_id='".$this->mysql->escape($row1['profile_id'])."'";
			$result2 = $this->mysql->query($select_sql, $data=null);
			$row2 = mysql_fetch_assoc($result2);
			if($this->mysql->num_row($select_sql, $data=null) > 0)
			{
				//echo "1";
				//echo $this->mysql->num_row($select_sql, $data=null);
				if($row2['profile_data_value'] == '' || empty($row2['profile_data_value']))
				{
					$check_array[] = 1;
				}
			}else{
				$check_array[] = 1;
			}
		}
		$eentrue=0;
		foreach($check_array as $value){
			$eentrue=$eentrue|$value;
		}
		if($eentrue){
			return 0;
		}else{
			return 1;	
		}
	}
}