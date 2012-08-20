<?php
class Parser2 
{

	var $l_delim = '{';
	var $r_delim = '}';
	var $object;

	public function parse($template, $data, $return = FALSE)
	{
		$template = file_get_contents("test-p.php");
		return $this->_parse($template, $data, $return);
	}

	// --------------------------------------------------------------------

	function parse_string($template, $data, $return = FALSE)
	{
		return $this->_parse($template, $data, $return);
	}

	// --------------------------------------------------------------------


	function _parse($template, $data, $return = FALSE)
	{
		if ($template == '')
		{
			return FALSE;
		}

		foreach ($data as $key => $val)
		{
			if (is_array($val))
			{
				$template = $this->_parse_pair($key, $val, $template);
			}
			else
			{
				$template = $this->_parse_single($key, (string)$val, $template);
			}
		}

		return $template;
	}

	// --------------------------------------------------------------------

	function set_delimiters($l = '{', $r = '}')
	{
		$this->l_delim = $l;
		$this->r_delim = $r;
	}

	// --------------------------------------------------------------------

	function _parse_single($key, $val, $string)
	{
		return str_replace($this->l_delim.$key.$this->r_delim, $val, $string);
	}

	// --------------------------------------------------------------------
	function _parse_pair($variable, $data, $string)
	{
		if (FALSE === ($match = $this->_match_pair($string, $variable)))
		{
			return $string;
		}

		$str = '';
		foreach ($data as $row)
		{
			$temp = $match['1'];
			foreach ($row as $key => $val)
			{
				if ( ! is_array($val))
				{
					$temp = $this->_parse_single($key, $val, $temp);
				}
				else
				{
					$temp = $this->_parse_pair($key, $val, $temp);
				}
			}

			$str .= $temp;
		}

		return str_replace($match['0'], $str, $string);
	}

	// --------------------------------------------------------------------

	function _match_pair($string, $variable)
	{
		if (!preg_match("|" . preg_quote("{").$variable .preg_quote("}")."(.+?)".preg_quote("{").'/' .$variable .preg_quote("}")."|s",$string, $match))
		{
			return FALSE;
		}else{
			return $match;
		}
	}

}