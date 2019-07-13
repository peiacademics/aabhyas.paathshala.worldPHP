<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User_library 
{
	public function __construct()
	{
		$this->ci =& get_instance();
		$this->ci->load->library('errorlog_library');
		$this->ci->load->library('str_function_library');
	}

	public function getSameValue($value=NULL)
	{
		if(!is_null($value) && !empty($value))
		{
			return $value;
		}
		else
		{
			return '-';
		}
	}

	public function calAge($dob=NULL,$sec)
	{
		if(!is_null($dob))
		{
			if(!empty($dob))
			{
				return $dob." ".$sec;
			}
			else
			{
				$this->ci->errorlog_library->entry('User_library > calAge > argument dob is empty.');
				return FALSE;
			}
		}
		else
		{
			$this->ci->errorlog_library->entry('User_library > calAge > argument dob is not defined.');
			return FALSE;
		}
	}

	public function sort($order,$sortby_array,$sort_array)
	{
		if($order==='desc')
		{
			array_multisort($sortby_array, SORT_DESC, $sort_array);
		}
		elseif($order === 'asc')
		{
			array_multisort($sortby_array, SORT_ASC, $sort_array);
		}
		else
		{
			redirect('themes/all');
		}
		return $sort_array;
	}

	
}
?>