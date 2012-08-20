<?php
class cw_permissions
{

	function get_rank_id()
	{
		$mysql = new Mysql();
		if(isset($_SESSION['user_id']) && isset($_SESSION['session_code']))
		{
			$sql = "SELECT rank_id FROM user_ranks WHERE user_id='".$_SESSION['user_id']."'";
			if($mysql->num_row($sql))
			{
				$row = $mysql->select_query($sql);
				$rank_id = $row;
			}else{
				$rank_id = Array ( 0 => Array ( 'rank_id' => 1 ) );
			}
		}else{
			$rank_id = Array (0 => Array ( 'rank_id' => 1 ));
		}
		return $rank_id;
	}
	
	function check_app_permissions($app_name, $rank_id)
	{
		$mysql = new Mysql();
		if(isset($rank_id))
		{
			if(is_array($rank_id))
			{
				$arrayding = array();
				foreach($rank_id as $val1)
				{
					foreach($val1 as $q1 => $q2)
					{
						$sql1 = "SELECT * FROM app_permissions WHERE app_name='".$app_name."' AND rank_id='".$q2."'";
						if($mysql->num_row($sql1))
						{
							$row = $mysql->assoc($sql1);
							if($row['access'] == 1)
							{
								$arrayding[$q2] = 1;
							}else{
								$arrayding[$q2] = 0;
							}
						}else{
							$arrayding[$q2] = 1;
							//echo "numrow".$app_name ;
						}
					}
				}
				//print_r($rank_id);
				$eentrue=0;
				foreach($arrayding as $value){
					$eentrue=$eentrue|$value;
				}
				if($eentrue){
					return false;
					
				}else{
					return true;
				}
			}
		}
	}

}