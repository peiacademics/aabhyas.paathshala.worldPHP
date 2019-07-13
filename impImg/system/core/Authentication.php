<?php

class CI_Authentication {

	protected $auth = FALSE;

	private $progress = TRUE;

	private $queue = array();

	public $appDefaults = array();

	public $serverStatus = FALSE;

	public function __construct()
	{
		// $CFG =& load_class('Config', 'core');
		// $CFG->load('skyq/my_config');
		// $this->config_data = $CFG->item('skyq');
		// $this->dumper =& load_class('Loader','core');
		// $this->t = date('U');
		// $this->serverStatus = $this->is_connected() ? TRUE : FALSE; 
		// $this->appDefaults = array();//$this->serverStatus ? $this->getAppPrivateSpace() : array();
		// log_message('info', 'Authentication Class Initialized');
		//$this->authorize() ? $this->progress = FALSE : $this->auth = FALSE;
		//$this->run = (FALSE === empty($this->queue)) ? $this->runEssentials('processQueue') : $this->runEssentials('preparePool');
		/*echo "<pre>";
		print_r($this->sync(NULL,'up'));
		echo "</pre>";*/
	}

	public function authorize()
	{
		//Authenticate last check Config & Last attandance with server and Authorizes Permission to user
		// if(!$this->auth && is_callable(array($this, 'authenticate')))// && $this->is())
		// {
		// 	$this->auth = TRUE;
		// 	return TRUE;
		// }
		// return FALSE;
	}

	public function get_directions()
	{
		return empty($this->appDefaults['defaults']['FTP']) ? FALSE : json_decode($this->appDefaults['defaults']['FTP'],TRUE);
	}

	public function queue($activity, $params = array())
	{
		//Check queued Activities to perform
		if(empty($activity) && !$this->progress)
		{
			return FALSE;
		}

		if(!isset($this->queue[$activity]))
		{
			$this->queue[$activity] = $params;
			return TRUE;
		}
		return FALSE;
	}

	public function process_queue()
	{	
		//Execute queue
		if($this->progress)
		{
			return FALSE;
		}

		return $this->processing();
	}

	/* Processes */
	public function sync($file = NULL,$direction=NULL)
	{
		//Mirror system files
		$this->dumper->helper('file_helper');
		$this->dumper->helper('directory_helper');
		if(count($this->appDefaults) > 0 && $this->serverStatus)
		{
			$FTP =& load_class('ftp');
	 		$config = $this->get_directions();
			if($FTP->connect($config))
			{	
				if(is_null($file) && is_null($direction))
				{
					//Upload or Download all files and folders to or from server 
					return directory_map(APPPATH);
				}
				elseif(!is_null($file) && is_null($direction))
				{
					//Uploads specified file
					$ftp_modified_time = $FTP->modified_time('/'.$file);
					$server_time = date("Y m d h:i:s",$ftp_modified_time);
					$local_modified_time = get_file_info(FCPATH.$file)['date'];
					$local_time = date("Y m d h:i:s",$local_modified_time);
					$ftp_1 = explode('/', $file);
					$ftp_file = $ftp_1[count($ftp_1)-1];
					unset($ftp_1[count($ftp_1)-1]);
					$ftp_path = implode('/', $ftp_1);
					if(!in_array($ftp_file, $FTP->list_files($ftp_path)))
					{
						return $this->upload($file) ? TRUE : FALSE;
					}
					elseif(!file_exists(FCPATH.$file))
					{
						return $this->download($file) ? TRUE : FALSE;
					}
					else
					{
						if($local_time > $server_time)
						{
							return $this->upload($file) ? TRUE : FALSE;
						}
						else
						{
							return $this->download($file) ? TRUE : FALSE;
						}
					}
				}
				elseif(is_null($file) && $direction === 'up')
				{
					//Upload all files and folder to server
					$FTP =& load_class('ftp');
			 		$config = $this->get_directions();
					if($FTP->connect($config))
					{
						return $FTP->mirror(FCPATH,'/') ? TRUE : FALSE;
					}
				}
				elseif(is_null($file) && $direction === 'down')
				{
					//Download all files and folder form server
					/*$FTP =& load_class('ftp');
			 		$config = $this->get_directions();
					if($FTP->connect($config))
					{	
						//In Progress
					}*/
					$download_arr = $this->get_ftp_files('/application/');
						//$download_arr = $this->get_ftp_files();
						//return $download_arr;
						$g = array();
						/*Latest */
						foreach ($download_arr as $key => $filepath)
						{
							$FTP->close();
							if($FTP->connect($config))
							{
								$filename = strrchr($filepath, '/');
								$newpath = str_replace($filename, '', $filepath);
								//echo $newpath;
								$fcpath =FCPATH.'application';//strstr(FCPATH, '/',true);
								@mkdir($fcpath.$newpath, 0700,true);
								$f[] = $fcpath.$filepath;

								 $g = $FTP->download($filepath, $fcpath.$filepath);
							//$FTP->download($download_arr[0], FCPATH.$download_arr[0],'auto');
							//$FTP->close();
							}
						}
							echo "<pre>";
							var_dump($f);
							echo "</pre>";
							
						/*$arr = $FTP->list_detail_files('/');
						print_r($arr);
						if(is_array($arr))
						{
							$arr1 = array();
							unset($arr[0]);
							unset($arr[1]);
							foreach ($arr as $folder => $file)
							{
								if(is_file($file))
								{
									$arr1[$folder] = $file;
								}
								else
								{
									$arr1[$folder][$file] = $FTP->list_files('/'.$file);
									unset($arr1[$folder][$file][0]);
									unset($arr1[$folder][$file][1]);
								}
							}
						}*/
						//return $arr1;
						//}
				}
				$FTP->close();
			}
		}
		return FALSE;
	}

	private function get_ftp_files($dir='/',$i=0)
	{
		$FTP =& load_class('ftp');
		$arr = $FTP->list_detail_files($dir,true);
		$a = 0;
		for($j=0;$j<=$i;$j++)
		{
			$a = $j;
		}
		var_dump($arr);
		foreach ($arr as $key => $file_folder)
		{
			if(strpos($file_folder, '//') !== FALSE)
			{
				$i++;
				$n=array();
				$x = $FTP->list_detail_files(str_replace(':','/',str_replace('//', '/', $file_folder)));

				unset($x[0]);
				unset($x[1]);
				foreach($x as $k=>$v)
				{
					if(strpos($v, '.')!==false)
					{
						$j = explode(' ', $v);
						$c = count($j);
						for($count=0;$count<$c;$count++)
						{
							//unset($j[$count]);
							if(empty($j[$count]))
							{
								unset($j[$count]);
							}
							if(array_key_exists($count, $j))
							{
								$z = $j[$count];
								
								unset($j[$count]);
								/*var_dump(strpos($z,':'));*/
														
								if(strpos($z,':') === 2)
								{
									break;
								}
							}
						}
						$fl = implode(' ', $j);
						$n[$k] = $fl;
					}
				}
				var_dump($file_folder);
				$arr1[str_replace(':','/',str_replace('//', '/', $file_folder))] = $n;
			}
		}
		$b=array();
		foreach($arr1 as $folder=>$file_arr)
		{
			foreach($file_arr as $file)
			{
				//$folder = str_replace('/application', '', $folder);
				$b[] = $folder.''.$file;
			}
		}
		echo "<pre>";
		print_r($b);
		echo "</pre>";
		
		return $b;
		/*$data['list'] = $FTP->list_files('/'.$dir);
		foreach ($data['list'] as $item){
			$path_parts= pathinfo($item);

			if (isset($path_parts["extension"]))
			{
			//echo 'File: '.$item.'';
				$data['list'][$item] = $this->get_ftp_files($item.'/');
			}
			else {
			//      echo 'directory:'. $item.'';
			}
		}
		return $data;*/
/*		print_r('dads');
		//$i++;
		$this->arr[$i] = $FTP->list_files('/'.$dir);
		if(is_array($this->arr))
		{
			//$arr1 = array();
			//unset($this->arr[$i][0]);
			//unset($this->arr[$i][1]);
			$j = 0;
			foreach ($this->arr[$i] as $folder => $file)
			{
				//$this->arr[$i][$file] = '';
				if(strpos($file,'.') !== false)
				{
					$this->arr[$j][$file][] = $file;
				}
				else
				{
					$this->arr[$j][$file] = $this->get_ftp_files($file.'/',$j);
				}
				$j++;
				//$arr1[$folder][$file] = $FTP->list_files('/'.$file);
				//unset($arr1[$folder][$file][0]);
				//unset($arr1[$folder][$file][1]);
			}
		}*/
	}

	public function ping()
	{
		//Update Last seen to server
		if(is_null(@$_COOKIE['ping']))
		{
			if(!empty($this->appDefaults))
			{
				$interval = is_numeric($this->appDefaults['defaults']['Ping_interval']) ? $this->appDefaults['defaults']['Ping_interval'] : (int)-10;
				setcookie('ping', TRUE, time() + $interval);
				if(@file_get_contents('http://skyq.office/Udyamatantra_Server/signal/ping/'.APKID.'/'.SKEY))
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
				return FALSE;
			}
		}
	}

	public function update()
	{
		//Download & Replace the file from FTP
		if(is_null(@$_COOKIE['update'.APKID]))
		{	
			$datas = 'http://skyq.office/Udyamatantra_Server/Signal/get_expiry/'.APKID.'/'.SKEY;
			$data = @file_get_contents($datas);
			setcookie('update'.APKID, $data, time() + $this->config_data['aps_interval']);
		}
		else
		{	
			$data = $_COOKIE['update'.APKID];
			setcookie('update'.APKID, $data, time() -10);
		}

		$this->dumper->helper('file_helper');
		if(!write_file(SKO, $data,"w"))
		{
			return FALSE;
		}
		return TRUE;
	}

	private function runEssentials($what = 'unknown')
	{
		switch($what)
		{
			case 'everythingElse':
				$this->update();
				$this->ping();
				//$this->sync_log();
			break;

			case 'processQueue':
				return $this->process_queue();
			break;

			case 'preparePool':
				$i = $this->preparePool();
				$this->runEssentials('processQueue');
				return $i;
			break;
		}

		return FALSE;
	}
	/* Activites */

	private function is_connected()
	{
	    if ($t = @fsockopen(SKS, SKP))
	    {
	        @fclose($t);
	        return TRUE;
	    }
	    return FALSE;
	}

	private function preparePool()
	{
		if(empty($this->appDefaults['processes']['Tasks']))
		{
			return FALSE;
		}
		$c = 0;
		$processes = json_decode($this->appDefaults['processes']['Tasks'],TRUE);
		foreach ($processes as $activity => $process)
		{
			$c++;
			$this->queue($activity,$process);
		}	
		return;
	}

	private function getAppPrivateSpace()
	{
		$this->runEssentials('everythingElse');
		if($this->serverStatus && empty($this->appDefaults))
		{
			if(is_null(@$_COOKIE[APKID]))
			{	
				if(defined('APKID') && defined('SKEY') && defined('APPKEY'))
				{	
					//Get Active Private Space
					$gaps = @file_get_contents('http://skyq.office/Udyamatantra_Server/signal/gaps/'.APKID.'/'.SKEY);
					setcookie(APKID, $gaps, time() + $this->config_data['aps_interval']);
				}
				else
				{
					show_error("Application is not Configured Properly!");
				}
			}
			else
			{	
				$gaps = @$_COOKIE[APKID];
				setcookie(APKID, $gaps, time() - 10);
			}
			$ENCP =& load_class('Encrypt');
			$all_details = $ENCP->decrypt_string(trim($gaps),APPKEY);
			return json_decode($all_details,true);
		}
		else
		{
			return $this->appDefaults;
		}
	}
					
	public function sync_log() //from private to public on 15 oct 2015
	{
		//Upload Log to Server
		$log_files_arr = $this->config_data['log_files'];
		$log_dir = $this->config_data['app_log_directory'];
		$extension = $this->config_data['log_file_extension'];
		$folder_path = APPPATH.$log_dir.DIRECTORY_SEPARATOR;
		$c = 0;
		foreach ($log_files_arr as $log_file) {
			$c += ($this->upload('application/'.$log_dir.'/'.$log_file.$extension)) ? $c++ : 0;
		}
		return ($c > 0) ? TRUE : FALSE;
	}

	private function upload($file = NULL,$permission = '0644',$comment = "Successful")
	{	
		//Upload file to FTP
		$FTP =& load_class('ftp');
 		$str_seperator = $this->config_data['string_seperator'];
 		$config = $this->get_directions();
		if($FTP->connect($config))
		{	
			if(file_exists(FCPATH))
			{
				if(file_exists(FCPATH.$file))
				{	
					if($FTP->upload(FCPATH.$file,"/".$file,'ascii', $permission))
					{	
						$FTP->close();
						if(strpos($file,'.skyq') !== FALSE)
						{
							return ($this->clear_file(FCPATH,$file,'local')) ? 'TRUE'.$str_seperator.$comment : 'FALSE'.$str_seperator.$comment;
						}
						else
						{
							return TRUE;
						}
					}
					else
					{
						return FALSE;
					}
				}
				else
				{
					return 'FALSE'.$str_seperator.$comment;
				}
			}
		}
	}

	private function download($file=NULL,$permission = '0644',$comment = NULL)
	{	
		//Download file From FTP
		$FTP =& load_class('ftp', 'libraries');
 		$str_seperator = $this->config_data['string_seperator'];
		$config = $this->get_directions();	
		if($FTP->connect($config))
		{	
			if(file_exists(FCPATH))
			{	
				if($FTP->download("/".$file,FCPATH.$file,'auto'))
				{	
					$FTP->close();
					if(strpos($file,'.skyq') !== FALSE)
					{
						return ($this->clear_file(FCPATH,$file,'server')) ? 'TRUE'.$str_seperator.$comment : 'FALSE'.$str_seperator.$comment;
					}
					else
					{
						return TRUE;
					}
				}
				else
				{
					return FALSE;
				}
			}
			else
			{
				return 'FALSE'.$str_seperator.$comment;
			}
		}
	}

	public function remove_file($file=NULL,$from = 'local')
	{	
		//Removes the file specified
		if($from == 'local')
		{
			if(file_exists(FCPATH.$file))
			{	
				unlink(FCPATH.$file);
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
		else
		{
			$FTP =& load_class('ftp', 'libraries');
			$config = $this->get_directions();	
			if($FTP->connect($config))
			{
				$arr = explode('/',$file);
				$file_name = $arr[count($arr)- 1]; 
				unset($arr[count($arr)- 1]);
				if(in_array($file_name,$FTP->list_files('/'.implode('/', $arr).'/')))
				{
					if($FTP->delete_file('/'.$file))
					{
						$FTP->close();
						return TRUE;
					}
					else
					{
						$FTP->close();
						return FALSE;
					}
				}
				$FTP->close();
				return FALSE;
			}	
		}
	}

	private function clear_file($directory=FCPATH,$file=NULL,$from = 'local')
	{
		$this->dumper->helper('file_helper');
		$data = $file.' file cleared at '.date('Y-m-d H:i:s');
		if($from == 'local')
		{	
			if(!is_null($file) && file_exists($directory.$file))
			{
				if(!write_file($directory.$file, $data,"w"))
				{
					return FALSE;
				}
				return TRUE;
			}
		}
		else
		{	
			$FTP =& load_class('ftp', 'libraries');
			$config = $this->get_directions();	
			if($FTP->connect($config))
			{
				if(!file_exists($directory.$file.'d'))
				{	
					if(!write_file($directory.$file.'d', $data,"w"))
					{
						$FTP->close();
						return FALSE;
					}
					if($FTP->upload(FCPATH.$file.'d','/'.$file,'ascii','0644'))
					{
						$FTP->close();
						unlink(FCPATH.$file.'d');
						return TRUE;
					}
					$FTP->close();
					return TRUE;
				}
				$FTP->close();
				return FALSE;
			}
		}
	}

	private function is()
	{
		//Authenticate license
		$expiry_date_original = @file_get_contents(SKO);
		$ENCP =& load_class('Encrypt');
		//var_dump($expiry_date_original);
		$secret_key_decrypted = $ENCP->decode(trim($expiry_date_original),APKID);
		return (date("Y-m-d H:i:s", base64_decode($secret_key_decrypted)) > date("Y-m-d H:i:s")) ? TRUE : FALSE;
	}

	private function freeze($data = NULL)
	{
		//Seal The Software
		$this->dumper->helper('file_helper');
		$data = is_null($data) ? $this->t : $data;
		if(!write_file(SKO, $data,'w'))
		{
			return FALSE;
		}
		return TRUE;
	}

	private function unfreeze($data = 'Failed')
	{
		//unlock The Software
		$this->dumper->helper('file_helper');
		if(!write_file(SKO, $data,'w'))
		{
			return FALSE;
		}
		return TRUE;
	}

	private function blast()
	{
		//Zip all files project files and Delete all
		return TRUE;
	}

	private function processing()
	{	
		//Actual queue Execution
		if(count($this->queue) > 0 && !$this->progress)
		{
			$seperator = $this->config_data['seperator'];
			foreach ($this->queue as $processs => $activities)
			{
				foreach ($activities as $activity => $params)
				{
					$activity = strstr($activity, $seperator,true);	
					if(is_callable(array($this, $activity)) && $this->progress === FALSE)
					{
						$results[$processs][] = call_user_func_array(array($this, $activity), $params);
					}
					else
					{
						$results[$processs][] = NULL;
					}
				}	
			}
			//print_r($results);
			$ENCP =& load_class('Encrypt');
			$process_log = $ENCP->encode(json_encode($results),APKID);
			$this->dumper->helper('file_helper');
			if(!write_file(FCPATH.SPL, $process_log,'w'))
			{
				return FALSE;
			}
			$up = $this->upload(SPL);
			//Reset Everything
			$this->reset();

			return FALSE === in_array(FALSE, $results) ? TRUE : FALSE;
		}
		else {
			return FALSE;
		}
	}

	public function authenticate()
	{
		// if(!$this->auth)
		// {
		// 	seal();
		// }
		// return;
	}

	private function reset()
	{
		//Reset queue And Stop Activites
		$this->queue = array();
		$this->progress = FALSE;
		$this->appDefaults = array();
	}
}