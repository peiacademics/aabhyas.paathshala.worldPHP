<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Str_function_library 
{
	public function __construct()
	{
		$this->ci =& get_instance();
		$this->ci->load->helper('file');
		$this->ci->load->library('errorlog_library','database');
	}

	public function compile($strFn=NULL)
	{
		if(!is_null($strFn))
		{
			$flags = array(FALSE, FALSE); //Checklist

			if(strpos($strFn, '>>') === 0) //Remove strFn Starter Syntax
			{
				$strFn = str_replace('>>', '', $strFn);
			}
			$params = explode('>',$strFn); //Fetch Parameters
			$fn = $params[0]; //Fetch Function name
			unset($params[0]); //Remove Function name from Parameters

			//Function name Checker
			if(!empty($fn))
			{
				$flags[0] = TRUE;
			}
			else {
				$this->ci->errorlog_library->entry('Str_function_library > Compile > Syntax Error : Function name is undefined.');
				return FALSE;
			}

			//Parameters Checker
			if(count($params) > 0)
			{
				$flags[1] = TRUE;
			}
			else {
				$this->ci->errorlog_library->entry('Str_function_library > Compile > Syntax Error : Parameters are undefined.');
				return FALSE;
			}

			//Final Checker
			if(!in_array(FALSE, $flags))
			{
				return (object) array(
					'function' => $fn,
					'arguments' => $params
				);
			}
			else {
				$this->ci->errorlog_library->entry('Str_function_library > Compile > Compiler Crashed! :(');
				return FALSE;
			}
		}
		else
		{
			$this->ci->errorlog_library->entry('Str_function_library > Compile > strFn is not defined.');
			return FALSE;
		}
	}
	
	public function call($strFn=NULL)
	{
		if(!is_null($strFn))
		{
			if(is_object($strFn = $this->compile($strFn)))
			{
				switch ($strFn->function) //Check strFn
				{
					case 'fn':
						$this->ci->load->library('custom_function_library');
						return $this->ci->custom_function_library->fn($strFn->arguments);
					break;

					case 'fr':
						$this->ci->load->library('custom_function_library');$this->ci->custom_function_library->fr($strFn->arguments);
						return $this->ci->custom_function_library->fr($strFn->arguments);
					break;
					
					default:
						$this->ci->errorlog_library->entry('Str_function_library > Call > Undefined Function Called.');
						return FALSE;
					break;
				}
			}
			else {
				$this->ci->errorlog_library->entry('Str_function_library > Call > Error While Compilation of strFn.');
				return FALSE;
			}
		}
		else
		{
			$this->ci->errorlog_library->entry('Str_function_library > Call > strFn is not defined.');
			return FALSE;
		}
	}

	public function get_careted_columns($str=NULL)
	{
		if(!is_null($str))
		{
			$count = substr_count($str,'^');
			if($count%2 === 0)
			{
				$count = $count/2;
				$string = explode('^', $str); 
				$odd = array();
				foreach( $string as $k => $v)
				{ 
				    if ( $k %2 != 0 )
				    { 
				       $odd[] = $v;
				    }
				} 
				return $odd;
			}
			else
			{
				$this->ci->errorlog_library->entry('Str_function_library > get_caret_columns > argument str contains odd carets.');
				return FALSE;
			}
		}
		else {
			$this->ci->errorlog_library->entry('Str_function_library > get_caret_columns > argument str is null.');
			return FALSE;
		}
	}

	public function substitutor($strFn=NULL,$row=NULL)
	{
		if(!empty($strFn) && is_array($row))
		{
			$col_array = $this->get_careted_columns($strFn);
			//print_r($col_array);
			foreach ($col_array as $key => $column)
			{
				$strFn = str_replace('^'.$column.'^', "`".$row[$column]."`", $strFn);
			}
			return $strFn;
		}
		else {
			$this->ci->errorlog_library->entry('Str_function_library > substitutor > arguments strFn OR row is null or not an array respectively.');
			return FALSE;
		}
	}
}
?>