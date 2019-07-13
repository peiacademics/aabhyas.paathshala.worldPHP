<?php
	class Process_model extends CI_Model{
		
		public function buffer($appid=NULL)
		{ 
			$this->load->model('fetch_model');
			$query = $this->fetch_model->show(array('PS'=>array("Status"=>"inqueue","Application_id"=>$appid)));
			
			if(count($query) == 1)
			{
				//return array(count($query));
				return $query[0];
			}
			else
			{
				$this->errorlog_library->entry('Processor > buffer > query returns an empty array.');
				return FALSE;
			}
		}

		public function get_reports($appid=NULL)
		{ 
			$get_report = @file_get_contents(FCPATH.'application/logs/process_log');
			$this->load->library('Encrypt');
			$report = $this->encrypt->decode($get_report,$appid);
			$report = json_decode($report,true);
			return $report;
			//print_r($report);
		}

	}
?>