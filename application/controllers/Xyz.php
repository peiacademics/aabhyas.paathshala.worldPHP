<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Xyz extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('date');
		$this->skyq = $this->config->item('skyq');
	}
	
	public function index($str,$format='Y-m-d')
	{
		if(!empty($str))
		{
			if($format === 'Y-m-d')
			{
				$d = new DateTime($str);
				echo $d->format($format);
			}
			else {
				$ustr = strtotime($str);
				if(((string) (int) $ustr === $ustr) && ($ustr <= PHP_INT_MAX) && ($ustr >= ~PHP_INT_MAX))
				{
					echo date($format,strtotime($str));
				}
				else {
					echo $ustr;
					//	echo "Wrong timestamp Format";
				}
			}
		}
		else {
			return FALSE;
		}
		/*$now = now('Australia/Victoria');
		echo unix_to_human($now)."<br>";
		$datestring = 'Year: %Y Month: %m Day: %d - %h:%i %a';
		$time = time();
		echo mdate($datestring, $time)."</br>";
		$format = 'DATE_RFC822';
		$time = time();
		echo standard_date($format, $time)."<br>";
		$unix = mysql_to_unix('20061124192345');
		echo $unix."<br>";
		$human = unix_to_human($unix);
		echo $human."<br>";
		$unix1 = human_to_unix($human);
		echo $unix1;//$this->load->view('welcome_message');
		echo timezone_menu('UM8');*/
	}

	function clear()
	{
		$this->errorlog_library->clear();
	}
	public function db_format_to_any_format($timestamp = '10:11:14',$t='',$req_format='%d %m %Y')
	{
		if($t == 'time')
		{
			$timestamp = '0000-00-00 '.$timestamp;
		}
		//$timestamp = '2015-04-13 10:11:14';
		//$ts = explode(' ', $timestamp);
		//if($type == 'date')
		//{
			//echo $ts[0];
			echo "<br>".$req_format;
			//$datestring = '%d/%M/%Y %h %i %s %a';
			$unix = mysql_to_unix($timestamp);
			echo "<br>".$unix."<br>";
			echo mdate($req_format,$unix);
		/*}
		elseif($type == 'time') 
		{
			echo $ts[1];
			$unix = mysql_to_unix($timestamp);
			echo "<br>".$unix."<br>";
			echo mdate($req_format,$unix);	
		}*/

		//$datestring = '%Y %M %d';
		//$date = now();
		//echo $date;
		//echo mdate($datestring, $date);

	}

	public function error_log_entry($message = "\r\n saurabh hprit phrtip bnfghlkj dfohg hndfh khgfds fdgh\r\n")
	{
		$this->load->helper('file');
		 //$message = 'My Text here';
		//echo APPPATH.'/files/errorlog.txt';
		$timestamp = date('Y-m-d H:i:s');
		$userid = "";
		$data = $timestamp." ".$userid."\r\n".$message."\r\n";
		  if ( !write_file(APPPATH.'files/errorlog.txt', $data,"a")){ 
		  	echo 'Unable to write the file'; 
		  } else {
		  	echo "write successfull";
		  }
	}

	public function update_languages()
	{
		$this->load->library('lang_library');
		$this->lang_library->update_languages();
	}

	public function languages()
	{
		$query = $this->db->get_where('translations', array('Language_ID' => 'LNSK10000002','Status'=>'A'));
		$result = $query->result_array();
		$id = '100000021';
		foreach($result as $row){
			$data = array(
				'ID' => 'TRSK'.$id,
				'Status' => 'A',
				'Added_on' => '2015-04-28 17:27:48',
				'Word' => $row['Word'],
				'Language_ID' =>'LNSK10000003'
				);
			$this->db->insert('translations',$data);

			$id++;
		}
	}

	public function backup()
	{
		if(file_exists($filepath = APPPATH.'config/database.php'))
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
		if(write_file(APPPATH.'files/'.$time.'.zip', $backup))
		{
			$this->errorlog_library->update_backup();
			unset($backup);	
		}
		else 
		{
			$this->errorlog_library->update_backup('Unable to create file.');
		}
	}

	public function test()
	{	
		$this->load->helper('directory'); //load directory helper
		$dir = BASEPATH. "files/";
		$map = directory_map($dir);
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($map);		

		//echo "<select name='yourfiles'>";

		// function show_dir_files($in,$path)
		// {
		// 	 foreach ($in as $k => $v)
		// 	{
		// 		if (!is_array($v))
		// 		{
		// 			echo "<option>".$path,$v."</option>";				 
		// 		}
		// 		 else
		// 		{
		// 			 print_dir($v,$path.$k.DIRECTORY_SEPARATOR);
		// 		}
		// 	 }
		// }

		// show_dir_files($map,'');  // call the function 
		//echo "</select>";		
	}

	// public function dir_scan($folder) {
	// 	  $files = glob($folder);
	// 	  foreach ($files as $f) {
	// 	    if (is_dir($f)) {
	// 	      $files = array_merge($files, $this->dir_scan($f . '/*')); // scan subfolder
	// 	    }
	// 	  }
	// 	  return $files;	
	// 	}

	public function app_folder_backup()
		{
			$this->load->library('zip');
			$name = date("d-m-Y H:i:s");
			$path = FCPATH;
			$cur_dir = explode('\\', getcwd());
			$dir = $cur_dir[count($cur_dir)-1];		
			$this->zip->read_dir($path); 
			$this->zip->download($dir.'_'.$name.'.zip'); 
		}
	
	

}
