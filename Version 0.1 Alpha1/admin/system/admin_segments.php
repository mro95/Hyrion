<?php
class CW_admin_segments
{
	function get_segments()
	{
		$segments = array();
		foreach(explode('/', substr($_SERVER['PHP_SELF'], strlen(substr($_SERVER['PHP_SELF'], 0, strlen('/' . 'cmswire/v3/admin/'))))) as $segment)
		{
			if(!empty($segment))
			{
				array_push($segments, $segment);
			}
		}
		return $segments;
	}
}