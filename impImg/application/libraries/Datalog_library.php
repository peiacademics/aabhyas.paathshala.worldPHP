<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Datalog_library 
{
	public function __construct()
	{
		$this->ci =& get_instance();
		$this->ci->load->library('session_library','date_library','errorlog_library','database');
//		$this->ci->load->library();
		$this->ci->config->load('skyq/my_config','skyq/table');
		$this->my_config = $this->ci->config->item('skyq');
		$this->table = $this->ci->config->item('table');
	}

	public function add($type = NULL,$table = NULL,$comment = NULL)
	{
		if(!is_null($type))
		{
			$data = array(
				'Added_on' => $this->ci->date_library->get_current_time(),
				'Added_by' => $this->ci->session_library->get_session_data('ID'),
				'Type' => $type
			);
			if(!is_null($table))
			{
				$data['Table'] = $table;
				$data['Comment'] = $comment;
 			}
			else
			{
				$data['Comment'] = $comment;
			}
			$query = $this->ci->db->insert($this->my_config['table_prefix'].$this->table['L'],$data);
			if($query)
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
		else
		{
			$this->ci->errorlog_library->entry('Datalog_library > add > argument type is undefined');
			return FALSE;
		}

	}

	public function update($table=NULL,$update_array=NULL,$where=NULL,$before_data)
	{
		if(!is_null($table) || !is_null($update_array) || !is_null($where))
		{
			$before_data = empty($before_data) ? $before_data : @$before_data[0];
			unset($before_data['ID']);
			if($table=="CL")
			{
				unset($before_data['Email']);
			}
			$result=array_diff($before_data,$update_array);
			unset($result['ID']);
			if(!empty($result))
			{
				foreach($result as $col=>$val)
				{
					$data = array(
						'Added_by'=>$this->ci->session_library->get_session_data('ID'),
						'Table_sc'=>$table,
						'Column_name'=>$col,
						'Updated_ID'=>json_encode($where),
						'Past_value'=>$val
					);
					$this->ci->db->insert($this->my_config['table_prefix'].$this->table['U'],$data);
				}
			}
		}
		else
		{
			$this->ci->errorlog_library->entry('Datalog_library > update > argument table or update_array or where is undefined');
		}
	}
}
?>