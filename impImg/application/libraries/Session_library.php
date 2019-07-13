<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Session_library 
{
	public function __construct()
	{
		$this->ci =& get_instance();
		$this->ci->load->library('session','errorlog_library');
	}

	public function set_session_data($sess_data=NULL,$var=NULL)
	{
		if(!is_null($sess_data))
		{
			if(gettype($sess_data) === 'array')
			{
				$this->ci->session->set_userdata($sess_data);
				return TRUE;
			}
			elseif(gettype($sess_data) === 'string' && !is_null($var))
			{
				$this->ci->session->set_userdata($sess_data,$var);
				return TRUE;
			}
			else {
				$this->ci->errorlog_library->entry('Session_library > set_session_data > variable variable var is undefined');
				return FALSE;
			}
		}
		else {
			$this->ci->errorlog_library->entry('Session_library > set_session_data > variable sess_data is not defined');
			return FALSE;
		}
	}

	public function get_session_data($sess_name=NULL)
	{
		if(!is_null($sess_name))
		{
			return $this->ci->session->userdata($sess_name);
		}
		else {
			$this->ci->errorlog_library->entry('Session_library > get_session_data > variable sess_name is not defined');
			return FALSE;
		}

	}
}
?>