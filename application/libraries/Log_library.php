<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Log_library 
{
	public function __construct()
	{
		$this->ci =& get_instance();
		$this->ci->load->library('db_library','errorlog_library','database','date_library','session_library');
	}
	private function get_type($type)
	{
		if(!empty($type))
		{
			$type_array = array(
				'Login' => "Login",
				'Logout' => "Logout",
				'Created'=>"Created",
				'Modified'=>"Modified"
			);
		}	
		return in_array($type, $type_array) ? $type_array[$type] : FALSE;
	}

	private function get_subtype($type)
	{
		if(!empty($type))
		{
			$type_array = array(
				'Added' => "Added",
				'Removed' => "Removed"
			);
		}	
		return in_array($type, $type_array) ? $type_array[$type] : FALSE;
	}

	public function Mark($type=NULL,$activity=NULL)
	{
		//validate type
		if(!is_null($type))
		{
			$type_val = $this->get_type($type) ? $this->get_type($type) : "";
			$subtype = $this->get_subtype($type) ? $this->get_subtype($type) : "";
		}

		//validate activity
		if(!is_null($activity))
		{
			if (is_array($activity))
			{
				$last_record = json_encode($activity);
			}
			elseif (is_array(json_decode($activity)))
			{
				$last_record = $activity;
			}
			else
			{
				$this->ci->errorlog_library->entry('Log_library > Mark > variable activity is invalid.');
				return FALSE;
			}
		}
		else
		{
			$last_record = NULL;
			$this->ci->errorlog_library->entry('Log_library > Mark > variable activity is not defined.');
			//return FALSE;
		}
		$tbl = $this->ci->db_library->get_tbl('LO');
		$data = array(
			'Added_on'=>$this->ci->date_library->get_current_time(),
			'Added_by'=>$this->ci->session_library->get_session_data('ID'),
			'Type'=>$type_val ,
			'Sub_type'=>$subtype ,
			'Last_record'=>$last_record
		);
		if($this->ci->db->insert($tbl, $data))
		{
			return TRUE;
		}
		else
		{
			$this->ci->errorlog_library->entry('Log_library > Mark > data was not inserted successfully.');
			return FALSE;
		}
	}
	
}