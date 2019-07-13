<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Security_lib
{
	public function __construct()
	{
		$this->ci =& get_instance();
		$this->ci->load->helper('file');
		$this->ci->load->library('errorlog_library');
		$this->ci->load->library('process/combination_lib');
		$this->combinations = array('UL','OB','MN','TS','YA','JB','NU');
		$this->needle = 0;
		//$this->combination = 'AA';
	}

	public function get_combination($module = NULL,$input = NULL,$output = NULL)
	{
		$elements = array('input'=>$input,'output'=>$output);
		$str = '';
		$element_counter = 1;
		foreach ($elements as $type => $element)
		{
			switch(gettype($element))
			{
				case 'NULL':
					$this->needle = 1;
					$str .= $this->needle.$this->combinations[$this->needle-1];
					$str .= $this->ci->combination_lib->null_fn($module,$type,$element);
				break;

				case 'boolean':
					$this->needle = 2;
					$str .= $this->needle.$this->combinations[$this->needle-1];
					$str .= $this->ci->combination_lib->boolean_fn($module,$type,$element);
				break;

				case 'integer':
				case 'double':
				case 'float':
					$this->needle = 3;
					$str .= $this->needle.$this->combinations[$this->needle-1];
					$str .= $this->ci->combination_lib->numeric_fn($module,$type,$element);
				break;

				case 'string':
					$this->needle = 4;
					$str .= $this->needle.$this->combinations[$this->needle-1];
					$str .= $this->ci->combination_lib->string_fn($module,$type,$element);
				break;
				
				case 'array':
					$this->needle = 5;
					$str .= $this->needle.$this->combinations[$this->needle-1];
					$str .= $this->ci->combination_lib->array_fn($module,$type,$element);
				break;
				
				case 'object':
					$this->needle = 6;
					$str .= $this->needle.$this->combinations[$this->needle-1];
					$str .= $this->ci->combination_lib->object_fn($module,$type,$element);
				break;
				
				default:
					$this->ci->errorlog_library->entry('Process > Security_lib > get_combination > '.$type.' > Non Supported Datatype : `'.gettype($element).'('.$element.')`');
				break;
			}
			if($element_counter < count($elements))
			{
				$str .= 'SK';
			}
			$element_counter++;
		}
		return $str;
	}

	
	function encrypt_string($msg = NULL,$key = NULL)
	{
		if(!is_null($msg) && !is_null($key))
		{
			$this->ci->load->library('encrypt');
			$encrypted_string = $this->ci->encrypt->encode($msg);
			$final_encrypted_string = $this->ci->encrypt->encode($encrypted_string,$key);
			return $final_encrypted_string;
		}
		else
		{
			$this->ci->errorlog_library->entry('Process > Security_lib > encrypt_string > Argument msg or key is undefined.');
			return FALSE;
		}
	}

	function decrypt_string($msg = NULL,$key = NULL)
	{
		if(!is_null($msg) && !is_null($key))
		{
			$this->ci->load->library('encrypt');
			$decrypted_string =$this->ci->encrypt->decode($msg, $key);
			$final_decrypted_string =$this->ci->encrypt->decode($decrypted_string);
			return $final_decrypted_string;
		}
		else
		{
			$this->ci->errorlog_library->entry('Process > Security_lib > decrypt_string > Argument msg or key is undefined.');
			return FALSE;
		}
	}

}