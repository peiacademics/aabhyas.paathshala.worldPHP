<?php
	class Batch_model extends CI_Model
	{
		public function check($id=NULL,$login_as="Client")
		{
			$user = count($this->fetch_model->show(array('BT' =>array('ID'=>$id))));
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
				$this->errorlog_library->entry('Batch_model > check > argument ID is invalid.');
				redirect('batch/add/');
			}
		}

		public function add_or_edit()
		{
			$this->load->model('form_model');
			if(empty($_POST['ID']))
			{
				unset($_POST['ID']);
				$result = $this->form_model->add(array("table"=>"BT","columns"=>$_POST));
			}
			else
			{
				$result = $this->form_model->edit(array("table"=>"BT","columns"=>$_POST,"where"=>array('ID'=>$_POST['ID'])));
			}				
			if($result === TRUE)
			{
				echo 1;
			}
			else
			{
				echo json_encode($result);
			}
		}

		public function get_show_data($input,$output)
		{
		 	$this->load->library('datatable_library');
	 		return $this->datatable_library->get_data($input,$output);
		}

		public function addClass()
		{
			$this->load->model('form_model');
			$date = explode(' - ', $_POST['Date']);
			$date[0] = str_replace('|', '-', $date[0]);
			$date[1] = str_replace('|', '-', $date[1]);
			$_POST['start_date'] = date('Y-m-d', strtotime($date[0]));
			$_POST['end_date'] = date('Y-m-d', strtotime($date[1]));
			unset($_POST['Date']);
			unset($_POST['date']);
			if($_POST['type'] === 'add')
			{
				unset($_POST['ID']);
				unset($_POST['type']);
				$result['stat'] = $this->form_model->add(array("table"=>"CL","columns"=>$_POST));
				$result['id'] = $this->db_library->find_max_id('CL');
			}
			else
			{
				unset($_POST['type']);
				$result['stat'] = $this->form_model->edit(array("table"=>"CL","columns"=>$_POST,"where"=>array('ID'=>$_POST['ID'])));
				$result['id'] = $_POST['ID'];
			}
			return $result;
		}

		public function classes($branch_ID = NULL, $display = 'no')
		{
			if ($this->data['Login']['Login_as'] === 'DSSK10000001') {
				if(!array_key_exists('Date', $_POST) && !array_key_exists('Class_ID', $_POST))
				{
					$data = $this->fetch_model->show(array('CL'=>array('Branch_ID'=>$branch_ID)),array('start_date','end_date','Subject','>>src:>fr>US>Image_ID:ID=^professor_ID^','>>EmpName:>fr>US>Name:ID=^professor_ID^','>>EmpID:>fr>US>ID:ID=^professor_ID^','ID','chapter','student_ID','Class_ID','Time','Totime','topic','description','student_ID','Days'));
					$_POST['Date'] = date('Y|m|d');
				}
				else
				{
					$data = $this->fetch_model->show(array('CL' =>array('Class_ID LIKE'=>'%'.@$_POST['Class_ID'].'%','Branch_ID'=>$branch_ID)),array('start_date','end_date','Subject','>>src:>fr>US>Image_ID:ID=^professor_ID^','>>EmpName:>fr>US>Name:ID=^professor_ID^','>>EmpID:>fr>US>ID:ID=^professor_ID^','ID','Class_ID','chapter','Time','Totime','student_ID','topic','description','student_ID','Days'));
					if ($data) {
						foreach ($data as $keyd => $valued) {
							// if(($_POST['Date'] >= $valued['start_date']) && ($_POST['Date'] <= $valued['end_date']))
							if(($_POST['Date'] = $valued['start_date']) && ($_POST['Date'] = $valued['end_date']))
							{
								
							}
							else
							{
								unset($data[$keyd]);
							}
						}
					}
				}
			}
			else if ($this->data['Login']['Login_as'] === 'DSSK10000011') {
				$batch = $this->str_function_library->call('fr>ADT>Batch:ID=`'.$this->data['Login']['ID'].'`');
				if(!array_key_exists('Date', $_POST))
				{
					if(($batch != '-NA-') && ($batch != NULL) && !empty($batch))
					{
						$data = $this->fetch_model->show(array('CL' =>array('Class_ID LIKE'=>'%'.@$batch.'%','Branch_ID'=>$branch_ID)),array('start_date','end_date','Subject','>>src:>fr>US>Image_ID:ID=^professor_ID^','>>EmpName:>fr>US>Name:ID=^professor_ID^','>>EmpID:>fr>US>ID:ID=^professor_ID^','ID','Class_ID','chapter','Time','Totime','student_ID','topic','description','student_ID','Days'));
					}
					else
					{
						$data = $this->fetch_model->show(array('CL' =>array('Class_ID'=>'all','student_ID LIKE'=>'%'.$this->data['Login']['ID'].'%','Branch_ID'=>$branch_ID)),array('start_date','end_date','Subject','>>src:>fr>US>Image_ID:ID=^professor_ID^','>>EmpName:>fr>US>Name:ID=^professor_ID^','>>EmpID:>fr>US>ID:ID=^professor_ID^','ID','Class_ID','chapter','Time','Totime','student_ID','topic','description','student_ID','Days'));
					}
					$_POST['Date'] = date('Y|m|d');
				}
				else
				{
					if(($batch != '-NA-') && ($batch != NULL) && !empty($batch))
					{
						$data = $this->fetch_model->show(array('CL' =>array('Class_ID LIKE'=>'%'.@$batch.'%','Branch_ID'=>$branch_ID)),array('start_date','end_date','Subject','>>src:>fr>US>Image_ID:ID=^professor_ID^','>>EmpName:>fr>US>Name:ID=^professor_ID^','>>EmpID:>fr>US>ID:ID=^professor_ID^','ID','Class_ID','chapter','Time','Totime','student_ID','topic','description','student_ID','Days'));
					}
					else
					{
						$data = $this->fetch_model->show(array('CL' =>array('Class_ID'=>'all','student_ID LIKE'=>'%'.$this->data['Login']['ID'].'%','Branch_ID'=>$branch_ID)),array('start_date','end_date','Subject','>>src:>fr>US>Image_ID:ID=^professor_ID^','>>EmpName:>fr>US>Name:ID=^professor_ID^','>>EmpID:>fr>US>ID:ID=^professor_ID^','ID','Class_ID','chapter','Time','Totime','student_ID','topic','description','student_ID','Days'));
					}
					if ($data) {
						foreach ($data as $keyd => $valued) {
							if(($_POST['Date'] >= $valued['start_date']) && ($_POST['Date'] <= $valued['end_date']))
							{
								
							}
							else
							{
								unset($data[$keyd]);
							}
						}
					}
				}
			}
			else if ($this->data['Login']['Login_as'] === 'DSSK10000012') {
				$student_ID = $this->str_function_library->call('fr>GD>Student_ID:ID=`'.$this->data['Login']['ID'].'`');
				$batch = $this->str_function_library->call('fr>ADT>Batch:ID=`'.$student_ID.'`');
				if(!array_key_exists('Date', $_POST))
				{
					if(($batch != '-NA-') && ($batch != NULL) && !empty($batch))
					{
						$data = $this->fetch_model->show(array('CL' =>array('Class_ID LIKE'=>'%'.@$batch.'%','Branch_ID'=>$branch_ID)),array('start_date','end_date','Subject','>>src:>fr>US>Image_ID:ID=^professor_ID^','>>EmpName:>fr>US>Name:ID=^professor_ID^','>>EmpID:>fr>US>ID:ID=^professor_ID^','ID','Class_ID','chapter','Time','Totime','student_ID','topic','description','student_ID','Days'));
					}
					else
					{
						$data = $this->fetch_model->show(array('CL' =>array('Class_ID'=>'all','student_ID LIKE'=>'%'.$this->data['Login']['ID'].'%','Branch_ID'=>$branch_ID)),array('start_date','end_date','Subject','>>src:>fr>US>Image_ID:ID=^professor_ID^','>>EmpName:>fr>US>Name:ID=^professor_ID^','>>EmpID:>fr>US>ID:ID=^professor_ID^','ID','Class_ID','chapter','Time','Totime','student_ID','topic','description','student_ID','Days'));
					}
					$_POST['Date'] = date('Y|m|d');
				}
				else
				{
					if(($batch != '-NA-') && ($batch != NULL) && !empty($batch))
					{
						$data = $this->fetch_model->show(array('CL' =>array('Class_ID LIKE'=>'%'.@$batch.'%','Branch_ID'=>$branch_ID)),array('start_date','end_date','Subject','>>src:>fr>US>Image_ID:ID=^professor_ID^','>>EmpName:>fr>US>Name:ID=^professor_ID^','>>EmpID:>fr>US>ID:ID=^professor_ID^','ID','Class_ID','chapter','Time','Totime','student_ID','topic','description','student_ID','Days'));
					}
					else
					{
						$data = $this->fetch_model->show(array('CL' =>array('Class_ID'=>'all','student_ID LIKE'=>'%'.$this->data['Login']['ID'].'%','Branch_ID'=>$branch_ID)),array('start_date','end_date','Subject','>>src:>fr>US>Image_ID:ID=^professor_ID^','>>EmpName:>fr>US>Name:ID=^professor_ID^','>>EmpID:>fr>US>ID:ID=^professor_ID^','ID','Class_ID','chapter','Time','Totime','student_ID','topic','description','student_ID','Days'));
					}
					if ($data) {
						foreach ($data as $keyd => $valued) {
							if(($_POST['Date'] >= $valued['start_date']) && ($_POST['Date'] <= $valued['end_date']))
							{
								
							}
							else
							{
								unset($data[$keyd]);
							}
						}
					}
				}
			}
			else
			{
				$data = $this->fetch_model->show(array('TK' =>array('Date LIKE'=>'%'.@$_POST['Date'].'%','assignTo'=>$this->data['Login']['ID'])),array('start_time','end_time','title','>>src:>fr>US>Image_ID:ID=^assignTo^','ID','tStatus'));
			}
			if ($data) {
				foreach ($data as $key1 => $value1) {
					$sub = $this->fetch_model->show(array('SB'=>array('ID'=>$value1['Subject'])),array('name'));
					$color = $this->fetch_model->show(array('SB'=>array('ID'=>$value1['Subject'])),array('color'));
					/*if(strpos($value1['Days'], ',') !== FALSE)
					{
						$days = explode(',', $value1['Days']);
						$data[$key1]['Days'] = $days;
					}*/
					if($value1['Class_ID'] != 'all')
					{
						if(strpos($value1['Class_ID'], ',') !== FALSE)
						{
							$lects = explode(',', $value1['Class_ID']);
							$cls = '';
							foreach ($lects as $keyl => $valuel) {
								$cls .= $this->str_function_library->call('fr>BT>name:ID=`'.$valuel.'`').',';
							}
							$data[$key1]['class'] = rtrim($cls,',');
							$data[$key1]['Class_ID'] = $lects;
						}
						else
						{
							$data[$key1]['class'] = $this->str_function_library->call('fr>BT>name:ID=`'.$value1['Class_ID'].'`');
						}
					}
					else
					{
						$data[$key1]['class'] = 'all';
						if(strpos($value1['student_ID'], ',') !== FALSE)
						{
							$studs = explode(',', $value1['student_ID']);
							$students = '';
							foreach ($studs as $keys => $values) {
								$students .= $this->str_function_library->call('fr>ST>name:ID=`'.$values.'`').',';
							}
							$students = rtrim($students,',');
							$data[$key1]['Class_ID'] = $students;
						}
						else
						{
							$class = $this->fetch_model->show(array('ST'=>array('ID'=>$value1['student_ID'])),array('name'));
							$data[$key1]['Class_ID'] = $class[0]['Name'];
						}
					}
					$data[$key1]['title'] = $sub[0]['name'];
					$data[$key1]['color'] = $color[0]['color'];
					$data[$key1]['date'] = $_POST['Date'].' '.$value1['Time'];
					$lectures = $this->fetch_model->show(array('LEC'=>array('date'=>$_POST['Date'],'class_ID'=>$value1['ID'])));
					if(($lectures != FALSE) && !empty($lectures) && ($lectures != NULL))
					{
						$data[$key1]['chapter'] = $lectures[0]['chapter'];
						$data[$key1]['lect_ID'] = $lectures[0]['ID'];
						$data[$key1]['topic'] = $lectures[0]['topic'];
						$data[$key1]['description'] = $lectures[0]['description'];
					}
					else
					{
						$data[$key1]['lect_ID'] = NULL;
						$data[$key1]['chapter'] = NULL;
						$data[$key1]['topic'] = NULL;
						$data[$key1]['description'] = NULL;
					}
				}
				foreach ($data as $key => $value) {
					$start_date = $value['start_date'].' '.$value['Time']; 
					$start_date = date('Y-m-d h:i:s', strtotime($start_date));
					$end_date = $value['end_date'].' '.$value['Time']; 
					$end_date = date('Y-m-d h:i:s', strtotime($end_date));
					$value['date'] = date('d|m|Y', strtotime($value['date']));
					$i = $start_date;
					while($i <= $end_date)
					{
						$day = date('l', strtotime($i));
						$i = date('Y-m-d h:i:s', strtotime($i));
						if(strpos($value['Days'], $day) !== FALSE)
						{
							if ($value['src'] !== '-NA-')
							{
								$img = $this->str_function_library->call('fr>SS>path:ID=`'.$value['src'].'`');
								if ($img !== '-NA-')
								{
									// $arr[] = array('title'=>$value['title'].' - '.$value['class'],'start'=>$start_date,'end'=>$end_date,'imageurl'=>$img,'id'=>$value['ID'],'EmpName'=>ucfirst($value['EmpName']),'EmpID'=>$value['EmpID'],'start_date'=>$value['start_date'],'end_date'=>$value['end_date'],'time'=>$value['Time'],'class_ID'=>$value['Class_ID'],'professor'=>$value['EmpID'],'subject'=>$value['Subject'],'topic'=>$value['topic'],'description'=>$value['description'],'date'=>$value['date'],'chapter'=>$value['chapter'],'student_ID'=>$value['student_ID'],'color'=>$value['color'],'Days'=>$value['Days'],'Totime'=>$value['Totime'],'lect_ID'=>$value['lect_ID']);
									$arr[] = array('title'=>$value['title'].' - '.$value['class'],'start'=>$i,'end'=>$i,'imageurl'=>$img,'id'=>$value['ID'],'EmpName'=>ucfirst($value['EmpName']),'EmpID'=>$value['EmpID'],'start_date'=>$i,'end_date'=>$i,'time'=>$value['Time'],'class_ID'=>$value['Class_ID'],'professor'=>$value['EmpID'],'subject'=>$value['Subject'],'topic'=>$value['topic'],'description'=>$value['description'],'date'=>$i,'chapter'=>$value['chapter'],'student_ID'=>$value['student_ID'],'color'=>$value['color'],'Days'=>$value['Days'],'Totime'=>$value['Totime'],'lect_ID'=>$value['lect_ID']);
								}
								else
								{
									// $arr[] = array('title'=>$value['title'],'start'=>$start_date,'end'=>$end_date,'imageurl'=>'img/tony.png','id'=>$value['ID'],'EmpName'=>ucfirst($value['EmpName']),'EmpID'=>$value['EmpID'],'start_date'=>$value['start_date'],'end_date'=>$value['end_date'],'time'=>$value['Time'],'class_ID'=>$value['Class_ID'],'professor'=>$value['EmpID'],'subject'=>$value['Subject'],'topic'=>$value['topic'],'description'=>$value['description'],'date'=>$value['date'],'chapter'=>$value['chapter'],'student_ID'=>$value['student_ID'],'color'=>$value['color'],'Days'=>$value['Days'],'Totime'=>$value['Totime'],'lect_ID'=>$value['lect_ID']);
									$arr[] = array('title'=>$value['title'],'start'=>$i,'end'=>$i,'imageurl'=>'img/tony.png','id'=>$value['ID'],'EmpName'=>ucfirst($value['EmpName']),'EmpID'=>$value['EmpID'],'start_date'=>$i,'end_date'=>$i,'time'=>$value['Time'],'class_ID'=>$value['Class_ID'],'professor'=>$value['EmpID'],'subject'=>$value['Subject'],'topic'=>$value['topic'],'description'=>$value['description'],'date'=>$i,'chapter'=>$value['chapter'],'student_ID'=>$value['student_ID'],'color'=>$value['color'],'Days'=>$value['Days'],'Totime'=>$value['Totime'],'lect_ID'=>$value['lect_ID']);
								}
							}
							else
							{
								// $arr[] = array('title'=>$value['title'],'start'=>$value['Date'],'imageurl'=>'img/tony.png','id'=>$value['ID'],'end'=>$value['dueDate'],'EmpName'=>ucfirst($value['EmpName']),'EmpID'=>$value['EmpID'],'start_date'=>$value['start_date'],'end_date'=>$value['end_date'],'time'=>$value['Time'],'class_ID'=>$value['Class_ID'],'professor'=>$value['EmpID'],'subject'=>$value['Subject'],'topic'=>$value['topic'],'description'=>$value['description'],'date'=>$value['date'],'chapter'=>$value['chapter'],'student_ID'=>$value['student_ID'],'color'=>$value['color'],'Days'=>$value['Days'],'Totime'=>$value['Totime'],'lect_ID'=>$value['lect_ID']);
								$arr[] = array('title'=>$value['title'],'start'=>$i,'imageurl'=>'img/tony.png','id'=>$value['ID'],'end'=>$i,'EmpName'=>ucfirst($value['EmpName']),'EmpID'=>$value['EmpID'],'start_date'=>$i,'end_date'=>$i,'time'=>$value['Time'],'class_ID'=>$value['Class_ID'],'professor'=>$value['EmpID'],'subject'=>$value['Subject'],'topic'=>$value['topic'],'description'=>$value['description'],'date'=>$i,'chapter'=>$value['chapter'],'student_ID'=>$value['student_ID'],'color'=>$value['color'],'Days'=>$value['Days'],'Totime'=>$value['Totime'],'lect_ID'=>$value['lect_ID']);
							}
						}
						$i = date('Y-m-d h:i:s', strtotime('+1 day', strtotime($i)));
					}
				}
				if($display == 'no')
				{
					return array_reverse($arr);
				}
				else
				{
					$arr = array_map("unserialize", array_unique(array_map("serialize", $arr)));
					return array_reverse($arr);
				}
			}
			else
			{
				return false;
			}
		}

		public function get_all_students($branch_ID = NULL)
	 	{
	 		$all_students = $this->fetch_model->show(array('ADT'=>array('Batch'=>'')),array('student_ID'));
	 		$data = array();
	 		foreach ($all_students as $key => $value) {
	 			$data[$key]['ID'] = $value['student_ID'];
	 			$data[$key]['name'] = $this->str_function_library->call('fr>ST>Name:ID=`'.$value['student_ID'].'`').' '.$this->str_function_library->call('fr>ST>Middle_name:ID=`'.$value['student_ID'].'`').' '.$this->str_function_library->call('fr>ST>Last_name:ID=`'.$value['student_ID'].'`');
	 		}
	 		return $data;
	 	}

	}
?>