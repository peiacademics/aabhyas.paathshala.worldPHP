<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Combination_lib 
{
	public function __construct()
	{
		$this->ci =& get_instance();
		$this->ci->load->helper('file');
		$this->ci->load->library('errorlog_library');
		$this->extra_combinations = array('XX','XS','XV');
		$this->array_dimensions = array('LA','L1','L2','L3','LX');
	}

	public function null_fn($module=NULL,$type=NULL,$element=NULL)
	{
		switch($module)
		{
			case 'show':
				return $this->extra_combinations[0];
			break;

			case 'view':
				return $this->extra_combinations[0];
			break;

			default:
				//error
				return FALSE;
			break;
		}
	}

	public function boolean_fn($module=NULL,$type=NULL,$element=NULL)
	{
		switch($module)
		{
			case 'show':
				return $this->extra_combinations[0];
			break;

			case 'view':
				return $this->extra_combinations[0];
			break;

			default:
				//error
				return FALSE;
			break;
		}
	}

	public function numeric_fn($module=NULL,$type=NULL,$element=NULL)
	{
		switch($module)
		{
			case 'show':
				return $this->extra_combinations[0];
			break;

			case 'view':
				return $this->extra_combinations[0];
			break;

			default:
				//error
				return FALSE;
			break;
		}
	}

	public function string_fn($module=NULL,$type=NULL,$element=NULL)
	{
		switch($module)
		{
			case 'show':
				if($element === '*')
				{
					return $this->extra_combinations[1];
				}
				else
				{
					return $this->extra_combinations[2];
				}
			break;

			case 'view':
				if($element === '*')
				{
					return $this->extra_combinations[1];
				}
				else
				{
					return $this->extra_combinations[2];
				}
			break;

			default:
				//error
				return FALSE;
			break;
		}
	}

	public function array_fn($module=NULL,$type=NULL,$element=NULL)
	{
		switch($module)
		{
			case 'show':
				return $this->array_dimensions[get_array_dimensions($element)];
			break;

			case 'view':
				return $this->array_dimensions[get_array_dimensions($element)];
			break;

			default:
				//error
				return FALSE;
			break;
		}
	}

	public function object_fn($module=NULL,$type=NULL,$element=NULL)
	{
		switch($module)
		{
			case 'show':
				return $this->extra_combinations[0];
			break;

			case 'view':
				return $this->extra_combinations[0];
			break;

			default:
				//error
				return FALSE;
			break;
		}
	}
}