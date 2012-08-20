<?php
class URL_Lib 
{
	function base_url()
	{
		$this->settings = new settings();
		$path = $this->settings->get_setting_value("path");
		return $path;
	}
}