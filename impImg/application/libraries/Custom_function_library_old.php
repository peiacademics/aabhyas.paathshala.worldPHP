<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Custom_function_library 
{
	public function __construct()
	{
		$this->ci =& get_instance();
		$this->ci->load->helper('file');
		$this->ci->load->library('errorlog_library','database');
	}

	public function fn($arguments=NULL)
	{
		if(!is_null($arguments))
		{
			if(is_array($arguments))
			{
				//Caching
				$cache1 = explode(':', $arguments[2]);//Separate Function call syntax
				$cache2step1 = str_replace('`', '', $cache1[1]); //Remove Quotes
				$cache2step2 = str_replace('(', '|', $cache2step1); //Separate Function name & Arguments
				$cache2step3 = str_replace(')', '', $cache2step2); //Remove Ending Bracket
				$cache2step4 = explode('|', $cache2step3); //Syntax Rendering
				$cache2step5 = explode(',', $cache2step4[1]); //Arguments Separation

				$file_type = $arguments[1]; //Render File Type
				$class = $cache1[0]; //Render Class & Name of File
				$function = $cache2step4[0]; //Render Function name
				$arguments = $cache2step5; //Render arguments array

				//Loading File To CodeIgniter
				$this->ci->load->$file_type($class);
				/*var_dump($function);
				var_dump($class);*/
				//var_dump($cache2step5);
				//Caching Response from Custom Function Call
				$response = @call_user_func_array(array($this->ci->$class, $function), $arguments);
				//print_r($response);
				if(!empty($response))
				{
					return $response;
				}
				else
				{
					$this->ci->errorlog_library->entry('Custom_function_library > fn > Errors in parent function While execution strFn > fn.');
					return FALSE;
				}
			}
			else {
				$this->ci->errorlog_library->entry('Custom_function_library > fn > Errors While execution strFn > fn.');
				return FALSE;
			}
		}
		else
		{
			$this->ci->errorlog_library->entry('Custom_function_library > fn > Argument arguments is not defined.');
			return FALSE;
		}
	}

	public function fr($arguments=NULL)
	{
		if(!is_null($arguments))
		{
			if(is_array($arguments))
			{
				//Caching
				$cache1 = explode(':', $arguments[2]);//Separate Title Column and Where Condition 
				$cache2step1 = str_replace('`', '', $cache1[1]); //Replace '`' with quotes 
				$cache2step2 = (strpos($cache2step1,',') !== FALSE) ? explode(',',$cache2step1):array($cache2step1); //Checks for more than one condition.
				foreach ($cache2step2 as $where_condns) {
					$cache2step3[] = explode('=', $where_condns); //Seperate Array of Columns and Values
				}

				//Load Libraries..
				$this->ci->load->library('db_library','database');

				$tbl = $this->ci->db_library->get_tbl($arguments[1]); // Table Name from where Title is to be fetched
				foreach ($cache2step3 as $condn) {
					$where_array[$condn[0]] = $condn[1]; // Render Where array 
				}
				$select_column = $cache1[0]; // Render Select Column
				//Execute Query
				$this->ci->db->select($select_column);
				$this->ci->db->where($where_array);
				$this->ci->db->where('Status','A');
				$query = $this->ci->db->get($tbl);
				if($query->num_rows() > 0)
				{
					$row = $query->row_array();
					return $row[$select_column];
				}
				else
				{
					$this->ci->errorlog_library->entry('Custom_function_library > fr > No result found in table.');
					return '-NA-';
					//return FALSE;
				}
			}
			else {
				$this->ci->errorlog_library->entry('Custom_function_library > fr > Errors While execution strFn > fr.');
				return FALSE;
			}
		}
		else
		{
			$this->ci->errorlog_library->entry('Custom_function_library > fr > Argument arguments is not defined.');
			return FALSE;
		}
	}
}