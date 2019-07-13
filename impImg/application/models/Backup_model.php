<?php
	class Backup_model extends CI_Model{
		public function __construct()
		{
			//echo BASEPATH;
			parent::__construct();
			$con_f = $this->config->item("skyq");
			$extension = $con_f['log_file_extension'];
			$this->log_dir = $con_f['base_log_directory'];
			$this->backup_file = BASEPATH.$this->log_dir.DIRECTORY_SEPARATOR.'backup'.$extension;
			$this->current_date = $this->date_library->get_current_time('d-m-Y');
			//echo $this->current_date;
			if($last_backup = $this->check_last_backup())
			{
				$date1=date_create($last_backup);
				$date2=date_create($this->current_date);
				$diff=date_diff($date1,$date2);
				$dif = $diff->format("%d%");
				if($dif > 0)
				{
					$this->create_backup();
				}
			}
			else
			{
				$this->create_backup();
			}
		}


		public function backup()
		{
			$this->create_backup();
		}
		
		private function check_last_backup()
		{
			if(file_exists($this->backup_file))
			{
				$last_backup = read_file($this->backup_file);
				return ($last_backup != "")? $last_backup : FALSE; 
			}
			else
			{
				return FALSE;
			}
		}

		private function create_backup()
		{
			if(file_exists($filepath = APPPATH.'config'.DIRECTORY_SEPARATOR.'database.php'))
			{
				include($filepath);
				$filename = $db[$active_group]['database'];
			}
			else
			{
				$app_info = $this->config->item('app');
				$filename = 'skyqin_'.$app_info['appname'].'_'.$app_info['version'].$this->skyq['backup_file_extension'];
			}
			$prefs = array(
		        'format'        => 'zip',                      
		        'filename'      => $filename,             
		        'add_insert'    => TRUE                       
			);
			$this->load->dbutil();
			$backup = $this->dbutil->backup($prefs);
			$this->load->helper('file');
			$time = $this->date_library->get_current_time('d-m-Y');
			//echo BASEPATH.$this->log_dir.DIRECTORY_SEPARATOR.$time.'.zip';
			if(write_file(BASEPATH.$this->log_dir.DIRECTORY_SEPARATOR.$time.'.zip', $backup))
			{
				$this->errorlog_library->update_backup();
				unset($backup);	
			}
			else 
			{
				$this->errorlog_library->update_backup('Unable to create file.');
			}
			$this->update_backup_time();
		}

		private function update_backup_time()
		{
			$date = $this->date_library->get_current_time('d-m-Y');
			if(write_file($this->backup_file,$date,'w+'))
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}

		public function download_backup($file=NULL,$type='client')
		{
			$path = BASEPATH.$this->log_dir.DIRECTORY_SEPARATOR.$file;
			$this->load->helper('download');
			if(file_exists($path))
			{
				force_download($path,NULL);
				return TRUE;
			}
			else
			{
				die('Oops..File Does not exists');
			}
		}
		
		public function app_folder_backup()
		{
			$this->load->library('zip');
			$name = str_replace('/','', FCPATH);
			$name = explode(trim('\ '), $name);
			$name = end($name);
			$this->zip->read_dir(FCPATH);
			$this->zip->download($name.'.zip');
			redirect('settings/add_full_backup_form');
		}
	}
?>