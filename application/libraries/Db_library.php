<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Db_library 
{
	public function __construct()
	{
		$this->ci =& get_instance();
		$this->ci->load->library('errorlog_library');
		//$this->ci->load->library('database');//,'date_library','session_library');
		$this->ci->load->model('fetch_model');
		$this->ci->load->library('datalog_library');
		$this->ci->config->load('skyq/table','skyq/my_config');
		$this->tables = $this->ci->config->item('table');
		$this->lock_status = array();
	}
	
	public function get_tbl($short_code=NULL)
	{
		if(!is_null($short_code))
		{
			if(array_key_exists($short_code, $this->tables))
			{
				return $this->tables[$short_code];	
			}
			else
			{
				$this->ci->errorlog_library->entry('Db_library > get_tbl > Table name of specified shortcode is not present');
				return FALSE;
			}
		}
		else
		{
			$this->ci->errorlog_library->entry('Db_library > get_tbl > variable short_code is not defined');
			return FALSE;
		}
	}

	private function lock_table($tbl,$action='WRITE')
	{
		$attempts = 0;
		while($attempts <= 10)
		{
			$attempts++;
			if(!array_key_exists($tbl, $this->lock_status))
			{
				$tbl = $this->get_tbl($tbl);
				$this->lock_status[$tbl] = TRUE;
	 	   		$this->ci->db->query('LOCK TABLE '.$tbl.' '.$action);
	 	   		return TRUE;
	 	   		break 1;
	 	   	}
	 	   	else
	 	   	{
	 	   		sleep(1);
	 	   		continue;
	 	   	}
		}
		$this->ci->errorlog_library->entry('Db_library > lock_table > !!! Failed To Lock after 10 Attempts - `'.$tbl.'`!');
		return FALSE;
	}

	private function unlock_tables()
	{
		if(count($this->lock_status) > 0)
		{
			if($this->ci->db->query('UNLOCK TABLES'))
			{
	 	   		$this->lock_status = array();
				return TRUE;
			}
			else
			{
				$this->ci->errorlog_library->entry('Db_library > unlock_tables > !!! Unnecessarily function called!');
				return FALSE;
			}
		}
		else
		{
			//Software to be seized
			$this->ci
			->errorlog_library->entry('Db_library > unlock_tables > !!! Unnecessarily function called!');
			return FALSE;
		}
	}

	//Find Max ID
	public function find_max_id($tbl_sc = NULL)
	{
		if(!is_null($tbl_sc))
		{		
			$tbl = $this->get_tbl($tbl_sc);
		    $this->ci->db->select_max('ID');
		    $query = $this->ci->db->get($tbl);
		    if($query->num_rows() > 0)
	        {
	            $row = $query->row()->ID;
	            return $row;
	        }	        
	        else 
	        {
				$this->ci->errorlog_library->entry('Db_library > find_max_id > variable tbl_sc is not defined');
	            return FALSE;
	        }
		}
		else
		{
			$this->ci->errorlog_library->entry('Db_library > find_max_id > variable tbl_sc is not defined');
			return FALSE;
		}
	}


    //Find Next ID
    public function find_next_id($tbl_sc = NULL)
    {
		if(!is_null($tbl_sc))
		{
			$row = $this->find_max_id($tbl_sc);
	        $skyq = $this->ci->config->item('skyq');
            if(!empty($row))
            {
                //find next ID
                $next_num = explode($skyq['seperator'],$row);
                $next_num = $next_num[1];
                return strtoupper($tbl_sc).$skyq['seperator'].($next_num + 1);
            }
            else {
                //Generate First ID Here
                return strtoupper($tbl_sc).$skyq['seperator'].$skyq['number'];
            }	        
	    }
		else
		{
			$this->ci->errorlog_library->entry('Db_library > find_next_id > variable tbl_sc is not defined');
			return FALSE;
		}
    }

    public function insert($table=NULL,$col_val=NULL,$status='A')
    {
    	if(!is_null($table) && !is_null($col_val))
    	{
			$tbl = $this->get_tbl($table);
    		$this->lock_table($table);
			$default_insert = array(
				'ID'=> $this->find_next_id($table),
				'Status' => $status,
				'Added_by' => $this->ci->session_library->get_session_data('ID')
			);
			foreach ($col_val as $col => $value)
    		{
    			if(is_array($value))
    			{
    				$col_val[$col] = implode(',',$value);
    				//$table[$tbl_sc] = $col_val;
    			}
    		}
			$insert_array = array_merge($default_insert,$col_val);
			$query = $this->ci->db->insert($tbl,$insert_array);
			if($query)
			{
				$this->unlock_tables();
       			$this->ci->datalog_library->add('Inserted',$table);
				return TRUE;
			}
			else
			{
				$this->unlock_tables();
				return FALSE;
			}
    	}
    	elseif (is_array($table) && is_null($col_val))
    	{  
    		$results = array();
    		foreach ($table as $tbl_sc => $columnarray)
    		{
        		foreach ($columnarray as $col => $value)
        		{
        			if(is_array($value))
        			{
        				$columnarray[$col] = implode(',',$value);
        				$table[$tbl_sc] = $columnarray;
        			}
        		}
    			
    			$results[$tbl_sc] = $this->insert($tbl_sc,$columnarray);
        	}
   			return FALSE === in_array(FALSE, $results) ? TRUE : $results;
		}
    	else
    	{
			$this->ci->errorlog_library->entry('Db_library > insert > variable tbl or col_val is not defined');
			return FALSE;
    	}
    }

    public function update($table=NULL,$col_val=NULL,$where=NULL,$status='A')
    {
    	if(!is_null($table) && !is_null($col_val) && !is_null($where))
    	{
			$tbl = $this->get_tbl($table);
			$default_update = array(
				'Status' => $status,
				'Added_by' => $this->ci->session_library->get_session_data('ID')
			);
			foreach ($col_val as $col => $value)
    		{
    			if(is_array($value))
    			{
    				$col_val[$col] = implode(',',$value);
    				//$table[$tbl_sc] = $col_val;
    			}
    		}
			$update_array = array_merge($default_update,$col_val);
			$before_data = $this->ci->fetch_model->show(array($table=>$where));
			/*if(array_key_exists('ID', $where))
			{*/
				$this->ci->db->where($where);
			/*}
			else
			{
				$this->ci->errorlog_library->entry('Db_library > update > argument where contains invalid where condition');
				return FALSE;
			}*/
			$query = $this->ci->db->update($tbl,$update_array);
			if($query)
			{
				$this->ci->datalog_library->update($table,$update_array,$where,$before_data);
       			$this->ci->datalog_library->add('Updated',$table);
				return TRUE;
			}
			else
			{
				return FALSE;
			}
    	}
    	elseif (is_array($table) && is_null($col_val))
    	{
    		$results = array();
    		foreach ($table as $tbl_sc => $columnarray)
    		{
     			if(array_key_exists('ID',$columnarray) === TRUE)
	       		{
        			$where['ID'] =  $columnarray['ID'];
        			unset($columnarray['ID']);
	       		}
       			foreach ($columnarray as $col => $value)
        		{
        			if(is_array($value))
        			{
        				$columnarray[$col] = implode(',',$value);
        				$table[$tbl_sc] = $columnarray;
        			}
        		}
        		//var_dump($columnarray);
	    		$results[$tbl_sc] = $this->update($tbl_sc,$columnarray,$where);
        	}
   			return FALSE === in_array(FALSE, $results) ? TRUE : $results;
		}
    	else
    	{
			$this->ci->errorlog_library->entry('Db_library > update > variable tbl or col_val is not defined');
			return FALSE;
    	}
    }

	public function delete($input = NULL)
    {
		$c = NULL;
    	if(!is_null($input) && is_array($input))
    	{
			foreach ($input as $tbl => $where_array)
			{
				$table = $this->get_tbl($tbl);
				$this->ci->db->where($where_array);
				$this->ci->db->update($table,array('Status'=>'D'));
				$results[$tbl] = $this->ci->db->affected_rows();
			}
 			foreach ($results as $tbl => $value)
   			{
   				if($value === 0)
   				{
					$c .= $this->ci->errorlog_library->entry('Db_library > delete > Data of `'.$tbl.'` table not deleted');
				}
				else
				{
					$this->ci->datalog_library->add('Deleted',$tbl);
				}
   			}
   			return !is_null($c) ? FALSE : TRUE; 
    	}
    	else
    	{
			$this->ci->errorlog_library->entry('Db_library > delete > variable input is undefined');
			return FALSE;
    	}
    }

    public function table_seperator($columns=NULL,$where=NULL)
    {
    	if(!is_null($columns) && is_array($columns))
    	{
	    	$input_tbl_array = array();
	    	if(!is_null($where))
	    	{
		    	foreach ($where as $tbl_column => $col_value)
		    	{
		    		if(strpos($tbl_column, '>') !== FALSE)
		    		{
						$cache1 = explode('>', $tbl_column);
			    		if(array_key_exists($cache1[0],$input_tbl_array))
						{
							$input_tbl_array[$cache1[0]] = array_merge($input_tbl_array[$cache1[0]],array($cache1[1]=>$col_value));
						}  
						else {	
							$input_tbl_array[$cache1[0]] = array($cache1[1]=>$col_value);
						}
					}
					else
					{
						$this->ci->errorlog_library->entry('Db_library > table_seperator > variable tbl_column not contains `>`');
						return FALSE;
					}
		    	}
		    }
			foreach ($columns as $tbl_column => $col_value)
			{
				$cache1 = explode('>', $tbl_column);
				if(array_key_exists($cache1[0],$input_tbl_array))
				{
					$input_tbl_array[$cache1[0]] = array_merge($input_tbl_array[$cache1[0]],array($cache1[1]=>$col_value));
				}  
				else {	
					$input_tbl_array[$cache1[0]] = array($cache1[1]=>$col_value);
				}
			}
			return $input_tbl_array;
		}
		else
		{
			$this->ci->errorlog_library->entry('Db_library > table_seperator > Either variable column is null or not an array');
			return FALSE;
		}
    }
}
?>