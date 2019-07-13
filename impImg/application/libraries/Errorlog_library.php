<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Errorlog_library 
{
	public function __construct()
	{
		$this->ci =& get_instance();
		$this->ci->load->helper('file');
		$this->ci->load->config('skyq'.DIRECTORY_SEPARATOR.'my_config');
		$this->ci->load->library('session_library','database');
		$this->extension = $this->ci->config->item('skyq')['log_file_extension'];
		$this->log_dir = $this->ci->config->item('skyq')['app_log_directory'];
	}

	public function entry($message)
	{
		$timestamp = date('Y-m-d H:i:s');
		$userid = $this->ci->session_library->get_session_data('ID');
		$data = "\r\n".$userid." at ".$timestamp." marked(".$this->ci->db->escape_str($message).")";
		return (!write_file(APPPATH.$this->log_dir.DIRECTORY_SEPARATOR.'errorlog'.$this->extension, $data,"a")) ? TRUE : FALSE;
	}

	public function clear()
	{
		$timestamp = date('Y-m-d H:i:s');
		$userid = $this->ci->session_library->get_session_data('ID');
		$data = "\r\n".$userid." cleaned log at ".$timestamp." ";
		return (!write_file(APPPATH.$this->log_dir.DIRECTORY_SEPARATOR.'errorlog'.$this->extension, $data,"w")) ? TRUE : FALSE;
	}

	public function update_backup($error=FALSE)
	{
		if($error === FALSE)
		{
			$timestamp = date('Y-m-d H:i:s');
			$data = "\r\nBackup at ".$timestamp." is Successfully stored!";
			return (!write_file(APPPATH.$this->log_dir.DIRECTORY_SEPARATOR.'backuplog'.$this->extension, $data,"a")) ? TRUE : FALSE;
		}
		else {
			$timestamp = date('Y-m-d H:i:s');
			$data = "\r\nBackup at ".$timestamp." is Unuccessful > Error (".$error.")!";
			return (!write_file(APPPATH.$this->log_dir.DIRECTORY_SEPARATOR.'backuplog'.$this->extension, $data,"a")) ? TRUE : FALSE;
		}
	}
}
?>