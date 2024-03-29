<?php
class Template_parser
{
	
	public $file;
	public $content;
	var $errors = '';
	var $getfile = false;
	var $l_delim = '{';
	var $r_delim = '}';
	
	/*
	public function __construct($file=false)	
	{
	} */
	
	public function parse2($filename,$data='',$setting_enable=true)
	{
		$setting = new settings();
		$data['setting.base_url'] = $setting->base_url();
	}
	
	
	public function parse($filename,$data='')
	{
		if(isset($filename))
		{
			$content = $this->get_file($filename);
			if($content)
			{
				if(isset($data))
				{
					//Hier returnt hij de content naar de controller
					$setting = new settings();
					$data['setting.base_url'] = $setting->base_url();
					return $this->start_parce($content,$data);
				}else{
					//only include
					return $content;
				}
			}else{
				return false;
			}
		}
	}
	
	function get_file($filename)
	{
		$filename = $filename.".php";
		if(file_exists($filename))
		{
			return file_get_contents($filename);
		}else{
			return false;
		}
	}
	
	function start_parce($content,$data)
	{
		
		if($content == '' || empty($content))
		{
			//Als er geen content is dan return False
			return false;
		}
		
		foreach($data as $key => $val)
		{
			if(!is_array($val))
			{
				$content = $this->parse_one($key,$val,$content);		
			}
			else
			{
				//als er meerdere values zijn in de array
				$content = $this->parse_array($key,$val,$content);
			}
		}
		
		return $content;
	}
	
	function parse_one($key, $val, $content)
	{
		$key = "{".$key."}";
		return str_replace($key, $val, $content);
	}
	
	function parse_array($var,$data,$content)
	{
		if (false === ($match = $this->match($content, $var)))
		{
			return $content;
		}
		$data_all = '';
		if(!empty($data))
		{
			foreach($data as $value)
			{
				$cache = $match['1'];
				foreach($value as $key => $val)
				{
					if(is_array($val))
					{
						$cache = $this->parse_array($key,$val,$cache);
					}else{
						$cache = $this->parse_one($key,$val,$cache);
					}
				}
				$data_all .= $cache;
			}
		}
		return str_replace($match['0'], $data_all, $content);
	}
	
	function match($content, $var)
	{
		// if(!preg_match("|{".$var."}(.+?){/".$var."}|s", $content, $match))
		if (!preg_match("|".preg_quote("{").$var.preg_quote("}")."(.+?)".preg_quote("{").'/' .$var.preg_quote("}")."|s", $content, $match))
		{
			return FALSE;
		}else{
			return $match;
		}
	}
}