<?php
	class Task_model extends CI_Model{

		public function check($id=NULL,$login_as="Client")
		{
			$user = count($this->fetch_model->show(array('TK' =>array('ID'=>$id))));
			if(is_null($id))
			{
				return TRUE;
			}
			elseif($user > 0)
			{
				return TRUE;
			}
			else
			{
				$this->errorlog_library->entry('customer_model > check > argument id is invalid.');
				redirect('task/add/');
			}
		}

		public function add_or_edit()
		{
			$this->load->model('form_model');
			$_POST['Date'] = date('Y-m-d');
			$_POST['start_time'] = $this->date_library->date2db($_POST['start_time'],$this->date_library->get_date_format());
			$_POST['start_time'] = $_POST['start_time'].' '.date("H:i:s", strtotime($_POST['sTime']));
			$_POST['expected_end_time'] = $this->date_library->date2db($_POST['expected_end_time'],$this->date_library->get_date_format());
			$_POST['expected_end_time'] = $_POST['expected_end_time'].' '.date("H:i:s", strtotime($_POST['exTime']));
			if(array_key_exists('end_time', $_POST) === true)
			{
				$_POST['end_time'] = $this->date_library->date2db($_POST['end_time'],$this->date_library->get_date_format());
				$_POST['end_time'] = $_POST['end_time'].' '.date("H:i:s", strtotime($_POST['eTime']));
			}
			if (!array_key_exists('tStatus', $_POST)) {
    			$_POST['tStatus'] = 'Inprocess';
    		}
			unset($_POST['eTime']);
			unset($_POST['sTime']);
			unset($_POST['exTime']);
			if(empty($_POST['ID']))
			{
				unset($_POST['ID']);
				$b_add = $this->form_model->add(array("table"=>"TK","columns"=>$_POST));
				return $b_add;
			}
			else
			{
				$b_edit = $this->form_model->edit(array("table"=>"TK","columns"=>$_POST,"where"=>array('ID'=>$_POST['ID'])));
				return $b_edit;
			}
		}

		public function get_details($id=NULL)
		{
			$data = array();
			if(!is_null($id))
			{
				$data['What'] = 'Edit'; 
				$data['View'] = $this->fetch_model->show(array('TK'=>array('ID'=>$id)));
				foreach ($data['View'] as $key => $value) {
					$sdate = explode(' ', $value['start_time']);
					$data['View'][$key]['sdate'] = $sdate[0];
					$data['View'][$key]['stime'] = $sdate[1];
					$exdate = explode(' ', $value['expected_end_time']);
					$data['View'][$key]['exdate'] = $exdate[0];
					$data['View'][$key]['extime'] = $exdate[1];
					if($value['end_time'] != NULL && !empty($value['end_time']))
					{
   						$edate = explode(' ', $value['end_time']);
						$data['View'][$key]['edate'] = $edate[0];
						$data['View'][$key]['etime'] = $edate[1];
					}
					if(($value['file_path'] != NULL) && !empty($value['file_path']))
					{
						$file = $this->fetch_model->show(array('SS'=>array('ID'=>$value['file_path'])),array('path'));
						$path = explode('/', $file[0]['path']);
						$data['View'][$key]['file_path'] = $path[1];
					}
				}
			}
			return $data;
		}

		public function mainTaskAdd()
		{
			if ($this->data['Login']['Login_as']==='DSSK10000001') {
				if (array_key_exists('ismeet', $_POST)) {
					$result = $this->form_model->add(array("table"=>"TK","columns"=>array('title'=>$_POST['title'],'Date'=>$_POST['Date'],'meet_referance'=>$_POST['Person'].','.$_POST['meetType'])));
				}
				else
				{
					$result = $this->form_model->add(array("table"=>"TK","columns"=>array('title'=>$_POST['title'],'Date'=>$_POST['Date'])));
				}
			}
			else
			{
				if (array_key_exists('ismeet', $_POST) && @$_POST['ismeet']===true) {
					$result = $this->form_model->add(array("table"=>"TK","columns"=>array('title'=>$_POST['title'],'Date'=>$_POST['Date'],'assignTo'=>$this->data['Login']['employeeID'],'meet_referance'=>$_POST['Person'].','.$_POST['meetType'])));
				}
				else
				{
					$result = $this->form_model->add(array("table"=>"TK","columns"=>array('title'=>$_POST['title'],'Date'=>$_POST['Date'],'assignTo'=>$this->data['Login']['employeeID'])));
				}
			}
			if ($result) {
			 	return $this->db_library->find_max_id('TK');
			}
		}

		public function mainTaskUpdate()
		{
			if (!empty($_FILES)) {
				header('Content-Type:application/x-json; charset=utf-8');
				$new_name = str_replace(" ", "-", time().$_FILES["file"]['name']);
		        $config['upload_path']          = './upload/';
		        $config['allowed_types']        = '*';
		        $config['max_size']             = '1000000';
				$config['file_name'] = $new_name;
		        $this->load->library('upload', $config);
		        $this->upload->initialize($config);
		        if ( ! $this->upload->do_upload('file'))
		        {
		        	return $this->upload->display_errors();
		        }
		        else
		        {
		        	$this->load->model('form_model');
		        	$file_name = $new_name;
		        	$path = 'upload/'.$file_name;
		        	//$id = $this->db_library->find_max_id('B');
		        	if($this->form_model->add(array('table'=>'TKS','columns'=>array('sub_task'=>'upload/'.$file_name,'task_ID'=>$_POST['ID'],'type'=>'file'))))
		        	{
		        		$id = $this->db_library->find_max_id('TKS');
		        		$result = $this->fetch_model->show(array('TKS'=>array('ID'=>$id)));
		        		$result[0]['Date']=$this->date_library->db2date($result[0]['Date'],$this->date_library->get_date_format());
						$result[0]['Name']=substr($result[0]['sub_task'], 17);
						$result[0]['extention']=pathinfo($result[0]['sub_task'], PATHINFO_EXTENSION);
		        		return $result[0];
		        	}
		        	else{
		        		return "PDF file Not found";
		        	}
		        }
			}
			else
			{
				switch ($_POST['sw']) {
					case 'title':
						$b_edit = $this->form_model->edit(array("table"=>"TK","columns"=>array('title'=>$_POST['title']),"where"=>array('ID'=>$_POST['ID'])));
						break;
					case 'assignTo':
						$b_edit = $this->form_model->edit(array("table"=>"TK","columns"=>array('assignTo'=>$_POST['assignTo']),"where"=>array('ID'=>$_POST['ID'])));
						$data=$this->fetch_model->show(array('EP' =>array('ID'=>$_POST['assignTo'])),array('Name','>>src:>fr>SS>path:ID=^Image_ID^','ID'));
						if ($data) {
							$b_edit = $this->form_model->edit(array("table"=>"TKS","columns"=>array('assign_To'=>$_POST['assignTo']),"where"=>array('task_ID'=>$_POST['ID'])));
						}
						if (@$_POST['is_req']==='true') {
							$this->req_status('mainTask',$_POST['rID'],$_POST['rStatus']);
						}
						return $data;
						break;

					case 'Date':
						$b_edit = $this->form_model->edit(array("table"=>"TK","columns"=>array('Date'=>$_POST['Date']),"where"=>array('ID'=>$_POST['ID'])));
						break;

					case 'description':
						$b_edit = $this->form_model->edit(array("table"=>"TK","columns"=>array('description'=>$_POST['description']),"where"=>array('ID'=>$_POST['ID'])));
						break;

					case 'comments':
						$b_edit = $this->form_model->edit(array("table"=>"TK","columns"=>array('comments'=>$_POST['comments']),"where"=>array('ID'=>$_POST['ID'])));
						break;

					case 'tStatus':
						$b_edit = $this->form_model->edit(array("table"=>"TK","columns"=>array('tStatus'=>$_POST['tStatus']),"where"=>array('ID'=>$_POST['ID'])));
						if ($b_edit) {
							$b_edit = $this->form_model->edit(array("table"=>"TKS","columns"=>array('tStatus'=>$_POST['tStatus']),"where"=>array('task_ID'=>$_POST['ID'],'tStatus'=>'Inprocess')));
						}
						break;

					case 'project_ID':
						$b_edit = $this->form_model->edit(array("table"=>"TK","columns"=>array('project_ID'=>$_POST['project_ID']),"where"=>array('ID'=>$_POST['ID'])));
						break;

					case 'end_time':
						$b_edit = $this->form_model->edit(array("table"=>"TK","columns"=>array('end_time'=>$_POST['end_time']),"where"=>array('ID'=>$_POST['ID'])));
						break;
						

					case 'copiedDate':
						$mainTaskData=$this->fetch_model->show(array('TK' =>array('ID'=>$_POST['ID'])),array('title','assignTo','project_ID','description','copiedID'));
						if ($mainTaskData) {
							if ($this->checkTaskPresentOnDateByTitle($mainTaskData,$_POST['copiedDate'])===true) {
								$copyIDs=$mainTaskData[0]['copiedID'];
								unset($mainTaskData[0]['copiedID']);
								$mainTaskData[0]['Date']=$_POST['copiedDate'];
								$mainTaskData[0]['tStatus']='Inprocess';
								$addMainTask = $this->form_model->add(array("table"=>"TK","columns"=>$mainTaskData[0]));
								if ($addMainTask) {
									$subTaskData=$this->fetch_model->show(array('TKS' =>array('task_ID'=>$_POST['ID'])),array('sub_task','assign_To','type'));
									if ($subTaskData) {
										foreach ($subTaskData as $key => $value) {
											$value['task_ID']=$this->db_library->find_max_id('TK');
											$value['tStatus']='Inprocess';
											$addMainTask = $this->form_model->add(array("table"=>"TKS","columns"=>$value));
										}
									}
									if (!empty($copyIDs)) {
										$copyIDs=$copyIDs.','.$this->db_library->find_max_id('TK');
									}
									else
									{
										$copyIDs=$this->db_library->find_max_id('TK');
									}
									$b_edit = $this->form_model->edit(array("table"=>"TK","columns"=>array('copiedID'=>$copyIDs),"where"=>array('ID'=>$_POST['ID'])));
								}
							}
							else
							{
								return "Same Task Present on ".$_POST['copiedDate']." Please Check";
							}
						}
						break;
						
					default:
						# code...
						break;
				}
				if ($b_edit) {
				 	return true;	
				}
			}
		}

		public function subTaskAdd()
		{
			if ($this->data['Login']['Login_as']==='DSSK10000001') {
				if (array_key_exists('assignTo', $_POST)) {
					$result = $this->form_model->add(array("table"=>"TKS","columns"=>array('sub_task'=>$_POST['sub_task'],'task_ID'=>$_POST['task_ID'],'assign_To'=>$_POST['assignTo'])));
				}
				else
				{
					$result = $this->form_model->add(array("table"=>"TKS","columns"=>array('sub_task'=>$_POST['sub_task'],'task_ID'=>$_POST['task_ID'])));
				}
			}
			else
			{
				$result = $this->form_model->add(array("table"=>"TKS","columns"=>array('sub_task'=>$_POST['sub_task'],'task_ID'=>$_POST['task_ID'],'assign_To'=>$this->data['Login']['employeeID'])));
			}
			
			if ($result) {
			 	return $this->db_library->find_max_id('TKS');	
			}
		}

		public function subTaskUpdate()
		{
			switch ($_POST['sw']) {
				case 'sub_task':
					$b_edit = $this->form_model->edit(array("table"=>"TKS","columns"=>array('sub_task'=>$_POST['sub_task']),"where"=>array('ID'=>$_POST['ID'])));
					break;

				case 'tStatus':
					$b_edit = $this->form_model->edit(array("table"=>"TKS","columns"=>array('tStatus'=>$_POST['tStatus']),"where"=>array('ID'=>$_POST['ID'])));
					if ($b_edit) {
						$data=$this->fetch_model->show(array('TKS' =>array('ID'=>$_POST['ID'])),array('ID','task_ID'));
						if ($data) {
							$count=$this->fetch_model->show(array('TKS' =>array('task_ID'=>$data[0]['task_ID'],'tStatus'=>'Inprocess','type'=>'text')));

							if (count($count)===0) {
								$b_edit = $this->form_model->edit(array("table"=>"TK","columns"=>array('tStatus'=>'Completed'),"where"=>array('ID'=>$data[0]['task_ID'])));
								return 'You Completed Whole Tasks';
							}
							else
							{
								return 'You still have to Complete '.count($count).' Tasks';
							}
						}
					}
					break;

				case 'assignTo':
					$subTask=$this->fetch_model->show(array('TKS' =>array('ID'=>$_POST['ID'])));
					if ($subTask) {
						$mainTask=$this->fetch_model->show(array('TK' =>array('ID'=>$subTask[0]['task_ID'])));
						if ($mainTask) {
							if (!empty($mainTask[0]['assignTo'])) {
								$mainTaskPresent=$this->fetch_model->show(array('TK' =>array('Date'=>$mainTask[0]['Date'],'assignTo'=>$_POST['assignTo'],'copiedFrom'=>$mainTask[0]['ID'])));
								if ($mainTaskPresent) {
									$addNewsubTask = $this->form_model->add(array("table"=>"TKS","columns"=>array('sub_task'=>$subTask[0]['sub_task'],'task_ID'=>$mainTaskPresent[0]['ID'],'assign_To'=>$_POST['assignTo'])));
									$this->form_model->edit(array("table"=>"TKS","columns"=>array('tStatus'=>'Copied','copiedTo'=>$this->db_library->find_max_id('TK')),"where"=>array('ID'=>$_POST['ID'])));
									$data=$this->fetch_model->show(array('US' =>array('ID'=>$_POST['assignTo'])),array('Name','>>src:>fr>SS>path:ID=^Image_ID^','ID'));
									// $this->checkAllCompleted($subTask[0]['task_ID']);
									if (@$_POST['is_req']==='true') {
										$this->req_status('mainTask',$_POST['rID'],$_POST['rStatus']);
									}
									return array('type'=>'perticular','data'=>$data[0]);
								}
								else
								{
									$addNewTask = $this->form_model->add(array("table"=>"TK","columns"=>array('title'=>$mainTask[0]['title'],'Date'=>$mainTask[0]['Date'],'assignTo'=>$_POST['assignTo'],'copiedFrom'=>$mainTask[0]['ID'])));
									$addNewsubTask = $this->form_model->add(array("table"=>"TKS","columns"=>array('sub_task'=>$subTask[0]['sub_task'],'task_ID'=>$this->db_library->find_max_id('TK'),'assign_To'=>$_POST['assignTo'])));
									if ($addNewsubTask) {
										$this->form_model->edit(array("table"=>"TKS","columns"=>array('tStatus'=>'Copied','copiedTo'=>$this->db_library->find_max_id('TK')),"where"=>array('ID'=>$_POST['ID'])));
										$data=$this->fetch_model->show(array('US' =>array('ID'=>$_POST['assignTo'])),array('Name','>>src:>fr>SS>path:ID=^Image_ID^','ID'));
										if (@$_POST['is_req']==='true') {
											$this->req_status('mainTask',$_POST['rID'],$_POST['rStatus']);
										}
										return array('type'=>'perticular','data'=>$data[0]);
									}
								}
							}
							else
							{
								$b_edit = $this->form_model->edit(array("table"=>"TKS","columns"=>array('assign_To'=>$_POST['assignTo']),"where"=>array('task_ID'=>$subTask[0]['task_ID'])));
								$b_edit = $this->form_model->edit(array("table"=>"TK","columns"=>array('assignTo'=>$_POST['assignTo']),"where"=>array('ID'=>$subTask[0]['task_ID'])));
								$data=$this->fetch_model->show(array('US' =>array('ID'=>$_POST['assignTo'])),array('Name','>>src:>fr>SS>path:ID=^Image_ID^','ID'));
								if (@$_POST['is_req']==='true') {
										$this->req_status('mainTask',$_POST['rID'],$_POST['rStatus']);
									}
								return array('type'=>'allset','data'=>$data[0]);
							}
						}
						else
						{
							return false;
						}
					}
					else
					{
						return false;
					}
				
					break;
				
				default:
					# code...
					break;
			}
				
				if ($b_edit) {
				 	return true;	
				}
		}

		public function addCopiedID($mainTask){
			if (!empty($mainTask[0]['copiedID'])) {
				$copyIDs=$mainTask[0]['copiedID'].','.$this->db_library->find_max_id('TK');
			}
			else
			{
				$copyIDs=$this->db_library->find_max_id('TK');
			}
			$b_edit = $this->form_model->edit(array("table"=>"TK","columns"=>array('copiedID'=>$copyIDs),"where"=>array('ID'=>$mainTask[0]['ID'])));
			return $b_edit;
		}

		public function tasks()
		{
			// var_dump($_POST);
			if ($this->data['Login']['Login_as'] === 'DSSK10000001') {
				$data = $this->fetch_model->show(array('TK' =>array('Date LIKE'=>'%'.@$_POST['Date'].'%',)),array('Date','title','>>src:>fr>US>Image_ID:ID=^assignTo^','ID','tStatus','end_time','expected_end_time'));
			}
			else
			{
				$data=$this->fetch_model->show(array('TK' =>array('Date LIKE'=>'%'.@$_POST['Date'].'%','assignTo'=>$this->data['Login']['employeeID'])),array('Date','title','>>src:>fr>US>Image_ID:ID=^assignTo^','ID','tStatus','end_time','expected_end_time'));
			}
			if ($data) {
				foreach ($data as $key => $value) {
					if ($value['src']!=='-NA-') {
						$img = $this->str_function_library->call('fr>SS>path:ID=`'.$value['src'].'`');
						if ($img!=='-NA-') {
							if($value['end_time'] != NULL)
							{
								$arr[] = array('title'=>$value['title'],'start'=>$value['Date'],'description'=>$value['tStatus'],'imageurl'=>$img,'id'=>$value['ID'],'end'=>$value['end_time']);
							}
							else
							{
								$arr[] = array('title'=>$value['title'],'start'=>$value['Date'],'description'=>$value['tStatus'],'imageurl'=>$img,'id'=>$value['ID'],'end'=>$value['expected_end_time']);
							}
						}
						else
						{
							$arr[] = array('title'=>$value['title'],'start'=>$value['Date'],'description'=>$value['tStatus'],'imageurl'=>'img/tony.png','id'=>$value['ID'],'end'=>$value['end_time']);
						}
					}
					else
					{
						if($value['end_time'] != NULL)
						{
							$arr[] = array('title'=>$value['title'],'start'=>$value['Date'],'description'=>$value['tStatus'],'imageurl'=>'img/tony.png','id'=>$value['ID'],'end'=>$value['end_time']);
						}
						else
						{
							$arr[] = array('title'=>$value['title'],'start'=>$value['Date'],'description'=>$value['tStatus'],'imageurl'=>$img,'id'=>$value['ID'],'end'=>$value['expected_end_time']);
						}
					}
				}
				return $arr;
			}
		}

		public function taskByDate()
		{
			if ($this->data['Login']['Login_as']==='DSSK10000001') {
				$data = $this->fetch_model->show(array('TK' =>array('Date LIKE'=>'%'.@$_POST['Date'].'%')));
			}else
			{
				$data = $this->fetch_model->show(array('TK' =>array('Date LIKE'=>'%'.@$_POST['Date'].'%','assignTo'=>$this->data['Login']['employeeID'])));
			}
			if (!empty($data[0]['assignTo'])) {
				$data[0]['emp'] = $this->fetch_model->show(array('US' =>array('ID'=>$data[0]['assignTo'])),array('Name','>>src:>fr>SS>path:ID=^Image_ID^','ID'));
			}
			if ($data) {
				foreach ($data as $key => $value) {
					$subTask = $this->fetch_model->show(array('TKS' =>array('task_ID'=>$value['ID'])));
					if ($subTask) {
						$data[$key]['Subtask']=$subTask;
					}
					else
					{
						$data[$key]['Subtask']=null;
					}
				}
				if (empty($data[0]['assignTo'])) {
					$data[0]['emp']=null;
				}
				return $data;
			}
			else
			{
				return false;
			}
		}

		public function subTaskByTask()
		{
			$data = $this->fetch_model->show(array('TK' =>array('ID'=>$_POST['ID'])));
			if (!empty($data[0]['assignTo'])) {
				$data[0]['emp'] = $this->fetch_model->show(array('US' =>array('ID'=>$data[0]['assignTo'])),array('Name','>>src:>fr>SS>path:ID=^Image_ID^','ID'));
			}
			else
			{
				$data[0]['emp']=null;
			}
			if (!empty($data[0]['copiedFrom'])) {
				$prevAssignedData = $this->fetch_model->show(array('TK' =>array('ID'=>$data[0]['copiedFrom'])));
				$prevAssignedEmpData = $this->fetch_model->show(array('US' =>array('ID'=>$prevAssignedData[0]['assignTo'])),array('Name','>>src:>fr>SS>path:ID=^Image_ID^','ID'));
				$data[0]['isPrevAssigned'] = 'task Was previously assigned to <img src="'.base_url($prevAssignedEmpData[0]['src']).'" class="crlSmall"> '.$prevAssignedEmpData[0]['Name'];
			}
			else
			{
				$data[0]['isPrevAssigned'] = null;
			}

			/*$isCopied = $this->fetch_model->show(array('TK' =>array('copiedID LIKE'=>'%'.$_POST['ID'].'%')));
			if ($isCopied) {
				$prevAssignedEmpData = $this->fetch_model->show(array('US' =>array('ID'=>$isCopied[0]['assignTo'])),array('Name','>>src:>fr>SS>path:ID=^Image_ID^','ID'));
				$data[0]['isCopied'] = 'task is copied from previous task was assigned to <br><img src="'.base_url($prevAssignedEmpData[0]['src']).'" class="crlSmall"> '.$prevAssignedEmpData[0]['Name'].'on '.$isCopied[0]['Date'];
			}
			else
			{
				$data[0]['isCopied'] = null;
			}
*/

			if ($data) {
				foreach ($data as $key => $value) {
					$subTask=$this->fetch_model->show(array('TKS' =>array('task_ID'=>$value['ID'])));
					if ($subTask) {
						foreach ($subTask as $k => $v) {
							if ($v['type']==='file') {
								$subTask[$k]['Date']=$this->date_library->db2date($v['Date'],$this->date_library->get_date_format());
								$subTask[$k]['Name']=substr($v['sub_task'], 17);
								$subTask[$k]['extention']=pathinfo($v['sub_task'], PATHINFO_EXTENSION);
							}
							if (!empty($v['assign_To'])) {
								if ($v['tStatus']==='Copied') {
									$cTask=$this->fetch_model->show(array('TK' =>array('ID'=>$v['copiedTo'])));
									// var_dump($mTask);
									$imgID=$this->str_function_library->call('fr>US>Image_ID:ID=`'.$cTask[0]['assignTo'].'`');
									$subTask[$k]['path']=$this->str_function_library->call('fr>SS>path:ID=`'.$imgID.'`');
								}
								else
								{
									$imgID=$this->str_function_library->call('fr>US>Image_ID:ID=`'.$v['assign_To'].'`');
									$subTask[$k]['path']=$this->str_function_library->call('fr>SS>path:ID=`'.$imgID.'`');
								}
							}
							else
							{
								$subTask[$k]['path']='img/tony.png';
							}
						}
						$data[$key]['Subtask']=$subTask;
					}
					else
					{
						$data[$key]['Subtask']=null;
					}
				}
				return $data;
			}
			else
			{
				return false;
			}
		}

		public function getEmployee()
		{
			// $emp=$this->fetch_model->show('US',array('Name','ID','>>src:>fr>SS>path:ID=^Image_ID^','Email'));
			$emp=$this->fetch_model->show(array('US' =>array('Name LIKE'=>'%'.@$_POST['search'].'%')),array('Name','ID','>>src:>fr>SS>path:ID=^Image_ID^','Email'));
			if ($emp) {
				return $emp;
			}
			else
			{
				return false;
			}
		}

		public function downloadAttc($path)
		{
			$file = getcwd().'/'.$path;
			// print_r($file);
			header('Content-Description: File Transfer');
		    header('Content-Type: application/octet-stream');
		    header('Content-Disposition: attachment; filename="'.basename($file).'"');
		    header('Expires: 0');
		    header('Cache-Control: must-revalidate');
		    header('Pragma: public');
		    header('Content-Length: ' . filesize($file));
		    readfile($file);
		    exit;
		}

		public function checkTaskPresentOnDateByTitle($data,$toDate)
		{
			$TaskData=$this->fetch_model->show(array('TK' =>array('Date'=>$toDate)));
			if ($TaskData) {
				foreach ($TaskData as $key => $value) {
					if ($value['title']===$data[0]['title']) {
						return false;
					}
				}
			}
			else
			{
				return true;
			}
			return true;
		}

		public function creatMainTaskForMeeting($value='')
		{
			if (!empty($_POST['person']) && !empty($_POST['meetType'])) {
				if (strpos($_POST['person'], 'LDSK') !== false) {
				    $person=$this->fetch_model->show(array('LD' =>array('ID'=>$_POST['person'])));
				    $person=$person[0]['Name'];
				}
				else
					if (strpos($_POST['person'], 'CSK') !== false) {
					    $person=$this->fetch_model->show(array('C' =>array('ID'=>$_POST['person'])));
					    $person=$person[0]['name'];
					}

					$meetType=$this->fetch_model->show(array('LMT' =>array('ID'=>$_POST['meetType'])));
					$meetType=$meetType[0]['name'];

					return 'Need To Contact '.$person.' on '.$meetType;
			}
			else
			{
				return false;
			}
		}

		public function sendreq()
		{
			$checkActiveReq=$this->fetch_model->show(array('RQ' =>array('main_task'=>$_POST['main_task'],'req_status'=>'Active')));
			// var_dump($checkActiveReq
			if ($checkActiveReq) {
				foreach ($checkActiveReq as $key => $value) {
					if ($value['sub_task']==='WholeTask') {
						return "Allredy requisted...please wait";
					}
					else if ($value['sub_task']===$_POST['sub_task']) {
						return "Allredy requisted...please wait";
					}
				}
				unset($_POST['count']);
				$_POST['req_from']=$this->data['Login']['employeeID'];
				$result = $this->form_model->add(array("table"=>"RQ","columns"=>$_POST));
				return $result;
			}
			else
			{
				unset($_POST['count']);
				$_POST['req_from']=$this->data['Login']['employeeID'];
				$result = $this->form_model->add(array("table"=>"RQ","columns"=>$_POST));
				return $result;
			}
			
		}

		public function checkreq($value='')
		{
			$d=array();
			$checkActiveReq=$this->fetch_model->show(array('RQ' =>array('req_to'=>$this->data['Login']['employeeID'],'req_status'=>'Active')));
			if ($checkActiveReq) {
				 $frpm = $this->str_function_library->call('fr>EP>Name:ID=`'.$checkActiveReq[0]['req_from'].'`');
				 $d=array('reqMsg'=>$frpm." requsted to help ",'details'=>$checkActiveReq[0],'statusMsg');
				return $d;
			}
			else
			{
				return false;
			}
		}

		public function req_status($type,$ID,$status)
		{
			// echo $ID;
			// echo $status;
			// echo $type;
			$b_edit = $this->form_model->edit(array("table"=>"RQ","columns"=>array('req_status'=>$status),"where"=>array('ID'=>$ID)));
			return $b_edit;
		}

		// public function checkAllCompleted($ID)
		// {
		// 	$TaskData=$this->fetch_model->show(array('TKS' =>array('task_ID'=>$ID,'type'=>'text')));
		// 	if ($TaskData) {
		// 		foreach ($TaskData as $key => $value) {
					
		// 		}
		// 	}
		// }
		public function upload_AnyFile()
	    {
	       	if(!empty($_FILES))
	    	{
	    		// var_dump($_FILES);
				$new_name = str_replace(" ", "-", time().$_FILES["file"]['name']);
		        $config['upload_path']          = './upload/';
		        $config['allowed_types']        = '*';
		        $config['max_size']             = '1000000';
				$config['file_name'] = $new_name;
		        $this->load->library('upload', $config);
		        $this->upload->initialize($config);
		        if ( ! $this->upload->do_upload('file'))
		        {
		        	echo json_encode($this->upload->display_errors());
		        }
		        else
		        {
		        	$this->load->model('form_model');
		        	$file_name = $new_name;
		        	$path = 'upload/'.$file_name;
		        	if($this->form_model->add(array('table'=>'SS','columns'=>array('path'=>'upload/'.$file_name,'description'=>'Deepak','date'=>date('Y-m-d h:i:s')))))
		        	{
		        		return $this->db_library->find_max_id('SS');;
		        	}
		        	else{
		        		return false;
		        	}
		        }
		    }
		    else{
		    	return false;
		    }
	    }
	    
	    public function addCalendarTask()
	    {
	    	// print_r($_POST);
	    	unset($_POST['type']);
	    	$_POST['date'] = $_POST['date'].' '.date('H:i:s');
			return $this->form_model->add(array('table'=>'CTK','columns'=>$_POST));
	    }

	    public function calendarTasks($branch_ID = NULL)
		{
			$data = $this->fetch_model->show(array('CTK' =>array('Date LIKE '=>'%'.$_POST['Date'].'%')),array('date','title','>>dept:>fr>TT>title:ID=^task_type_ID^','ID','description','Added_by','Added_on','task_status'),array('ORDER'=>array('date','ASC')));

			$data_prev = $this->fetch_model->show(array('CTK' =>array('Date <'=>$_POST['Date'].' 00:00:00','task_status'=>'Pending')),array('date','title','>>dept:>fr>TT>title:ID=^task_type_ID^','ID','description','Added_by','Added_on','task_status'),array('ORDER'=>array('date','ASC')));
			if(!empty($data_prev))
			{
				$data = (!empty($data)) ? $data : array();
				$data_prev = (!empty($data_prev)) ? $data_prev : array();
				$data = array_merge($data_prev,$data);
			}
			if ($data) {
				// var_dump($data);
				foreach ($data as $key => $value) {
					$comments = $this->fetch_model->show(array('TC' =>array('calender_task_ID'=>$value['ID'])));
					$image = $this->str_function_library->call('fr>US>Image_ID:ID=`'.$value['Added_by'].'`');
					$name = $this->str_function_library->call('fr>US>Name:ID=`'.$value['Added_by'].'`');
					$path = $this->str_function_library->call('fr>SS>path:ID=`'.$image.'`');
					$arr[] = array('title'=>$value['title'],'start'=>$value['date'],'imageurl'=>$path,'name'=>$name,'id'=>$value['ID'],'description'=>$value['description'],'date'=>$value['date'],'Added_by'=>$value['Added_by'],'dept'=>$value['dept'],'Added_on'=>$value['Added_on'],'comments'=>$comments,'task_status'=>$value['task_status']);
				}
				foreach ($arr as $keyc => $valuec) {
					if(($valuec['comments'] != NULL) && !empty($valuec['comments']) && ($valuec['comments'] != NULL))
					{
						foreach ($valuec['comments'] as $keyr => $valuer) {
							$imager = $this->str_function_library->call('fr>US>Image_ID:ID=`'.$valuer['Added_by'].'`');
							$namer = $this->str_function_library->call('fr>US>Name:ID=`'.$valuer['Added_by'].'`');
							$pathr = $this->str_function_library->call('fr>SS>path:ID=`'.$imager.'`');
							$arr[$keyc]['comments'][$keyr]['pathr'] = $pathr;
							$arr[$keyc]['comments'][$keyr]['namer'] = $namer;
						}
					}
					else
					{
						$arr[$keyc]['comments'] = '';
					}
				}
				return $arr;
				// return array_reverse($arr);
			}
		}

		public function add_comment()
	 	{
	 		$this->load->model('form_model');
	 		return $this->form_model->add(array('table'=>'TC','columns'=>$_POST));
	 	}

	 	public function lists($branch_ID)
	 	{
	 		$data = $this->fetch_model->show(array('CTK'=>array('branch_ID'=>$branch_ID)),array('title','task_status','Added_by','date'),array('ORDER'=>array('date','ASC')));
	 		if(!empty($data))
	 		{
	 			foreach ($data as $key => $value) {
	 				$value['path'] = $this->str_function_library->call('fr>US>Image_ID:ID=`'.$value['Added_by'].'`');
	 				// print_r($value['path']);
	 				$img = $this->str_function_library->call('fr>SS>path:ID=`'.$value['path'].'`');
					if ($img !== '-NA-') {
	 					$data[$key]['imageurl'] = $img;
	 				}
	 				else{
	 					$data[$key]['imageurl'] = 'img/tony.png';
	 				}
	 			}
	 		}
	 		return$data;
	 	}

	 	public function mark_completed($task_ID)
	 	{
	 		$this->load->model('form_model');
	 		// var($task_ID);
	 		return $this->form_model->edit(array('table'=>'CTK','columns'=>array('task_status'=>'Completed'),'where'=>array('ID'=>$task_ID)));
	 	}

	 	public function make_approval()
	 	{
	 		$data = $this->fetch_model->show(array('TK'=>array('ID'=>$_POST['ID'])));
	 		if(!empty($data))
	 		{
	 			$users = str_replace(',','||',$data[0]['assignTo']);
	 			$us = $this->fetch_model->show(array('US'=>array('ID'=>$users)),array('seniority1_ID','seniority2_ID','seniority3_ID'));
	 			$seniors = array();
	 			foreach ($us as $k => $v) {
	 				if(!empty($v['seniority1_ID']))
	 				{
	 					if(!in_array($v['seniority1_ID'], $seniors))
	 					{
	 						$seniors[] = $v['seniority1_ID'];
	 					}
	 				} 
	 				if(!empty($v['seniority2_ID']))
	 				{
	 					if(!in_array($v['seniority2_ID'], $seniors))
	 					{
	 						$seniors[] = $v['seniority2_ID'];
	 					}
	 				} 
	 				if(!empty($v['seniority3_ID']))
	 				{
	 					if(!in_array($v['seniority3_ID'], $seniors))
	 					{
	 						$seniors[] = $v['seniority3_ID'];
	 					}
	 				}
	 			}
	 			$ratings_json = json_decode($data[0]['ratings'],true);
	 			// print_r($seniors);
	 			// print_r($_POST);
	 			// var_dump($ratings_json);
	 			if(empty($ratings_json))
	 			{
	 				$column_arr = array($this->data['Login']['ID']=>$_POST['rating']);
	 				$columns = json_encode($column_arr);
	 			}
	 			else{
	 				$column_arr = $ratings_json;
	 				$column_arr[$this->data['Login']['ID']] = $_POST['rating'];
	 				$columns = json_encode($column_arr);
	 			}
		 		$this->load->model('form_model');
		 		$flag = true;
		 		foreach ($seniors as $senior) {
		 			if(!array_key_exists($senior,$column_arr))
		 			{
		 				$flag = false;
		 			}
		 		}

		 		return ($flag == true) ? $this->form_model->edit(array('table'=>'TK','columns'=>array('tStatus'=>'Completed','ratings'=>$columns),'where'=>array('ID'=>$_POST['ID']))) : $this->form_model->edit(array('table'=>'TK','columns'=>array('ratings'=>$columns),'where'=>array('ID'=>$_POST['ID'])));
		 	}
	 	}
	}
?>