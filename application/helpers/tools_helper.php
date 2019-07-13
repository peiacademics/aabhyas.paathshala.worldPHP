<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('strip_data'))
{
    function strip_data($var = NULL)
    {
    	if(!is_null($var))
    	{
    		return str_replace(array('_'), ' ', $var);
    	}
    	else
    	{
    		return FALSE;
    	}
    }   
}

if ( ! function_exists('get_array_dimensions'))
{
    function get_array_dimensions($array)
    {
        if (is_array(reset($array)))
        {
            $return = get_array_dimensions(reset($array)) + 1;
        }

        else
        {
            $return = 1;
        }

        return $return;
    }
}
?>