<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Date_library 
{
	public function __construct()
	{
		$this->ci =& get_instance();
		$this->ci->load->library('session_library');
		$this->ci->config->load('skyq/my_config');
		$this->my_config = $this->ci->config->item('skyq');
	}

	public function converter($str=NULL,$informat='Y-m-d h:i:s',$outformat='Y-m-d h:i:s a')
	{
		$str = is_null($str) ? date('Y-m-d h:i:s') : $str;
		$d = @DateTime::createFromFormat($informat,$str);
		return $d === FALSE ? date($outformat) : $d->format($outformat);
	}

	public function db2date($str=NULL,$format=NULL)
	{		
		if(is_null($format))
		{
			$format = $this->get_date_format();
		}
		$str = is_null($str) ? date('Y-m-d h:i:s') : $str;
		if($str == '0000-00-00')
		{
			return '';
		}
		elseif ($str == '0000-00-00 00:00:00')
		{
			return '';
		}
		$d = @new DateTime($str);
		return $d === FALSE ? FALSE : $d->format($format);
	}

	public function date2db($str=NULL,$format='Y-m-d h:i:s')
	{
		if(!is_null($format))
		{
			$str = is_null($str) ? date('Y-m-d h:i:s') : $str;
			return $this->converter($str,$format,'Y-m-d');
		}
		else {
			return FALSE;
		}
	}
	
	public function date2dbdttm($str=NULL,$format=NULL)
	{
		if(!is_null($format))
		{
			$str = is_null($str) ? date('Y-m-d H:i:s') : $str;
			return $this->converter($str,$format,'Y-m-d H:i:s');
		}
		else {
			return FALSE;
		}
	}

	public function get_current_time($format="Y-m-d h:i:s")
	{
		return date($format);
	}

	public function get_time_format($user_id=NULL)
	{
		if(is_null($user_id)){
			$uid = $this->ci->session_library->get_session_data('ID');
		}
		else{
			$uid = $user_id;	
		}

		$tbl = $this->ci->db_library->get_tbl('US');
		$uid = $this->ci->db->escape_str($uid);
		$this->ci->db->select('Time_Format');
		$query = $this->ci->db->get_where($tbl,array("Status"=>"A","ID"=>$uid));
		if($query->num_rows() > 0)
		{
			if(!empty($query->first_row()->Time_Format))
			{
				return $query->first_row()->Time_Format;
			}
			else
			{
				return $this->my_config['default_time_format'];
			}
		}
		else{
			return FALSE;
		}
	}

	public function get_date_format($user_id=NULL)
	{
		if(is_null($user_id)){
			$uid = ($this->ci->session_library->get_session_data('ID') === FALSE) ? 'd F Y':$this->ci->session_library->get_session_data('ID');
		}
		else{
			$uid = $user_id;	
		}

		$tbl = $this->ci->db_library->get_tbl('US');
		$uid = $this->ci->db->escape_str($uid);
		$this->ci->db->select('Date_Format');
		$query = $this->ci->db->get_where($tbl,array("Status"=>"A","ID"=>$uid));
		if($query->num_rows() > 0)
		{
			if(!empty($query->first_row()->Date_Format))
			{
				return $query->first_row()->Date_Format;
			}
			else
			{
				return $this->my_config['default_date_format'];
			}
		}
		else{
			return FALSE;
		}

	}

	public function get_timezone($user_id=NULL)
	{
		if(is_null($user_id)){
			$uid = $this->ci->session_library->get_session_data('ID');
		}
		else{
			$uid = $user_id;	
		}

		$tbl = $this->ci->db_library->get_tbl('US');
		$uid = $this->ci->db->escape_str($uid);
		$this->ci->db->select('Timezone');
		$query = $this->ci->db->get_where($tbl,array("Status"=>"A","ID"=>$uid));
		if($query->num_rows() > 0)
		{
			return $query->first_row()->Timezone;
			if(!empty($query->first_row()->Timezone))
			{
				return $query->first_row()->Timezone;
			}
			else
			{
				return $this->my_config['default_time_zone'];
			} 
		}
		else{
			return FALSE;
		}
	}

	public function dateformat_PHP_to_javascript($php_format = NULL)
	{
		if(!is_null($php_format))
		{
			$SYMBOLS_MATCHING = array(
				// Day
				'd' => 'dd',
				'D' => 'D',
				'j' => 'd',
				'l' => 'DD',
				'N' => '',
				'S' => '',
				'w' => '',
				'z' => 'o',
				// Week
				'W' => '',
				// Month
				'F' => 'MM',
				'm' => 'mm',
				'M' => 'M',
				'n' => 'm',
				't' => '',
				// Year
				'L' => '',
				'o' => '',
				'Y' => 'yyyy',
				'y' => 'yy',
				// Time
				'a' => '',
				'A' => '',
				'B' => '',
				'g' => '',
				'G' => '',
				'h' => '',
				'H' => '',
				'i' => '',
				's' => '',
				'u' => ''
			);
			$jqueryui_format = "";
			$escaping = false;
			for($i = 0; $i < strlen($php_format); $i++)
			{
				$char = $php_format[$i];
				if($char === '\\') // PHP date format escaping character
				{
					$i++;
					if($escaping) $jqueryui_format .= $php_format[$i];
					else $jqueryui_format .= '\'' . $php_format[$i];
					$escaping = true;
				}
				else
				{
					if($escaping) { $jqueryui_format .= "'"; $escaping = false; }
					if(isset($SYMBOLS_MATCHING[$char]))
						$jqueryui_format .= $SYMBOLS_MATCHING[$char];
					else
						$jqueryui_format .= $char;
				}
			}
			return $jqueryui_format;
		}
		else
		{
			return FALSE;
		}
	}

}
?>