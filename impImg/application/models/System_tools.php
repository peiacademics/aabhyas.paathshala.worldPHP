<?php
	class System_tools extends CI_Model{
		
		public function primary_check()
		{
			$con_f = $this->config->item("skyq");
			$files = $con_f['log_files'];
			$log_dir = $con_f['app_log_directory'];
			$extension = $con_f['log_file_extension'];
			$folder_path =	APPPATH.$log_dir.DIRECTORY_SEPARATOR;

			//Check if 'logs' directory exists with '777' permission.
			// if(file_exists($folder_path))
			// {
			// 	foreach($files as $log_file)
			// 	{
			// 		//Check if log files exist
			// 		if(!file_exists($folder_path.$log_file.$extension))
			// 		{
			// 			$data = $log_file.' file initialised at '.date('Y-m-d H:i:s');
			// 			if(!write_file(APPPATH.$log_dir.DIRECTORY_SEPARATOR.$log_file.$extension, $data,"a"))
			// 			{
			// 				die('Unable to create '.$log_file.$extension.' file');
			// 			}
			// 		}
			// 	}

			// 	//Change zip files extention
			// 	$get_filenames = get_filenames($folder_path);
			// 	if(count($get_filenames) )
			// 	{
			// 		foreach ($get_filenames as $key => $filename)
			// 		{
			// 			if(strrpos($filename, '.zip') !== FALSE)
			// 			{
			// 				$filen = preg_replace('"\.zip$"', '.zip.skyq', $filename);
			// 				rename($folder_path.$filename,$folder_path.$filen);
			// 			}
			// 		}
			// 	}
			// 	return TRUE;
			// }
			// else
			// {
			// $ex =explode($log_dir, $folder_path);
			// 	die('Either directory `Logs` is not present in '.$ex[0].' or access denied!!'); 
			// }
		}
		
		public function auto_error_report()
		{
				
		}
	}
?>