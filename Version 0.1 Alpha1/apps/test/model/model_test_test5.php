<?php
class model_test_test5 extends Model
{
	function __construct()
    {
        parent::construct();
    }
	
	function noobje()
	{
		
		$username = "maarten2";
		$data = array("username" => $username);
		if($this->mysql_helper->num_row('users',$data) > 0)
		{
			echo "helaas";
		}else{
			$data2 = array("username" => $username,
					  	  "password" => "hallo");
			$test = $this->mysql_helper->insert_array('users', $data2);
			echo "goedzo!";
		} 
		
		
	}
}