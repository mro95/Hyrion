<?php
abstract class Controller 
{
	protected $load;
	protected $uri;
	protected $input;

	function construct()
	{
		/*
		$this->load = new Loader();
		if(isset($GLOBALS['autoload_helpers']) && is_array($GLOBALS['autoload_helpers']))
			foreach($GLOBALS['autoload_helpers'] as $name => $class)
				$this->{$name} = $this->load->helper($class);
		if(isset($GLOBALS['autoload_models']) && is_array($GLOBALS['autoload_models']))
			foreach($GLOBALS['autoload_models'] as $name => $class)
				$this->{$name} = $this->load->model($class);
		if(isset($GLOBALS['autoload_views']) && is_array($GLOBALS['autoload_views']))
			foreach($GLOBALS['autoload_views'] as $name => $class)
				$this->{$name} = $this->load->view($class);
				*/
				$this->load = new load();
	}
}
?>