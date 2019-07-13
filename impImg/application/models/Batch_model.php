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
			$_POST['start_date'] = date('Y-m-d', strtotime($date[0]));
			$_POST['end_date'] = date('Y-m-d', strtotime($date[1]));
			unset($_POST['Date']);
			unset($_POST['date']);
			if($_POST['type'] === 'add')
			{
				unset($_POST['ID']);
				unset($_POST['type']);
				$result = $this->form_model->add(array("table"=>"CL","columns"=>$_POST));
			}
			else
			{
				unset($_POST['type']);
				$result = $this->form_model->edit(array("table"=>"CL","columns"=>$_POST,"where"=>array('ID'=>$_POST['ID'])));
			}
			return $result;
		}

		public function classes($branch_ID = NULL)
		{
			if ($this->data['Login']['Login_as'] === 'DSSK10000001') {
				if(!array_key_exists('Date', $_POST) && !array_key_exists('Class_ID', $_POST))
				{
					$data = $this->fetch_model->show(array('CL'=>array('Branch_ID'=>$branch_ID)),array('start_date','end_date','Subject','>>src:>fr>US>Image_ID:ID=^professor_ID^','>>EmpName:>fr>US>Name:ID=^professor_ID^','>>EmpID:>fr>US>ID:ID=^professor_ID^','ID','chapter','student_ID','Class_ID','Time','topic','description','student_ID'));
					$_POST['Date'] = date('Y-m-d');
				}
				else
				{
					$data = $this->fetch_model->show(array('CL' =>array('Class_ID LIKE'=>'%'.@$_POST['Class_ID'].'%','Branch_ID'=>$branch_ID)),array('start_date','end_date','Subject','>>src:>fr>US>Image_ID:ID=^professor_ID^','>>EmpName:>fr>US>Name:ID=^professor_ID^','>>EmpID:>fr>US>ID:ID=^professor_ID^','ID','Class_ID','chapter','Time','student_ID','topic','description','student_ID'));
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
					if($value1['Class_ID'] != 'all')
					{
						$class = $this->fetch_model->show(array('BT'=>array('ID'=>$value1['Class_ID'])),array('name'));
						$data[$key1]['class'] = $class[0]['name'];
					}
					else
					{
						if(strpos($value1['student_ID'], ',') !== FALSE)
						{
							$studs = explode(',', $value1['student_ID']);
							$students = '';
							foreach ($studs as $keys => $values) {
								$students .= $this->str_function_library->call('fr>ST>name:ID=`'.$values.'`').',';
							}
							$students = rtrim($students,',');
							$data[$key1]['class'] = $students;
						}
						else
						{
							$class = $this->fetch_model->show(array('ST'=>array('ID'=>$value1['student_ID'])),array('name'));
							$data[$key1]['class'] = $class[0]['Name'];
						}
					}
					$data[$key1]['title'] = $sub[0]['name'];
					$data[$key1]['date'] = $_POST['Date'].' '.$value1['Time'];
				}

				foreach ($data as $key => $value) {
					$start_date = $value['start_date'].' '.$value['Time']; 
					$start_date = date('Y-m-d h:i:s', strtotime($start_date));
					$end_date = $value['end_date'].' '.$value['Time']; 
					$end_date = date('Y-m-d h:i:s', strtotime($end_date));
					if ($value['src'] !== '-NA-') {
						$img = $this->str_function_library->call('fr>SS>path:ID=`'.$value['src'].'`');
						if ($img !== '-NA-') {
							$arr[] = array('title'=>$value['title'].' - '.$value['class'],'start'=>$start_date,'end'=>$end_date,'imageurl'=>$img,'id'=>$value['ID'],'EmpName'=>ucfirst($value['EmpName']),'EmpID'=>$value['EmpID'],'start_date'=>$value['start_date'],'end_date'=>$value['end_date'],'time'=>$value['Time'],'class_ID'=>$value['Class_ID'],'professor'=>$value['EmpID'],'subject'=>$value['Subject'],'topic'=>$value['topic'],'description'=>$value['description'],'date'=>$value['date'],'chapter'=>$value['chapter'],'student_ID'=>$value['student_ID']);
						}
						else
						{
							$arr[] = array('title'=>$value['title'],'start'=>$start_date,'end'=>$end_date,'imageurl'=>'img/tony.png','id'=>$value['ID'],'EmpName'=>ucfirst($value['EmpName']),'EmpID'=>$value['EmpID'],'start_date'=>$value['start_date'],'end_date'=>$value['end_date'],'time'=>$value['Time'],'class_ID'=>$value['Class_ID'],'professor'=>$value['EmpID'],'subject'=>$value['Subject'],'topic'=>$value['topic'],'description'=>$value['description'],'date'=>$value['date'],'chapter'=>$value['chapter'],'student_ID'=>$value['student_ID']);
						}
					}
					else
					{
						$arr[] = array('title'=>$value['title'],'start'=>$value['Date'],'imageurl'=>'img/tony.png','id'=>$value['ID'],'end'=>$value['dueDate'],'EmpName'=>ucfirst($value['EmpName']),'EmpID'=>$value['EmpID'],'start_date'=>$value['start_date'],'end_date'=>$value['end_date'],'time'=>$value['Time'],'class_ID'=>$value['Class_ID'],'professor'=>$value['EmpID'],'subject'=>$value['Subject'],'topic'=>$value['topic'],'description'=>$value['description'],'date'=>$value['date'],'chapter'=>$value['chapter'],'student_ID'=>$value['student_ID']);
					}
				}
				return array_reverse($arr);
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