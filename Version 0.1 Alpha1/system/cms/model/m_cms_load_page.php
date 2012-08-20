<?php
class m_cms_load_page extends Model_CMS
{

	function load_home()
	{
		$sql = "SELECT * FROM pages WHERE page_is_homepage=1";
		if($this->mysql->num_row($sql) == 1)
		{
			$row = $this->mysql->assoc($sql);
			$row['page_content'] = stripslashes($row['page_content']);
			return $row;
		}
		return false;
	}
	
	function load_page($page_id)
	{
		$sql = "SELECT * FROM pages WHERE page_id='".$this->mysql->escape($page_id)."'";
		if($this->mysql->num_row($sql) == 1)
		{
			$row = $this->mysql->assoc($sql);
			$row['page_content'] = stripslashes($row['page_content']);
			return $row;
		}
		return false;
	}
}