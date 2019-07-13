<?php
	class Exam_model extends CI_Model
	{
		public function check($id=NULL,$login_as="Client")
		{
			$user = count($this->fetch_model->show(array('EX' =>array('ID'=>$id))));
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
				$this->errorlog_library->entry('Exam_model > check > argument ID is invalid.');
				redirect('Exams/add/');
			}
		}

		public function add_or_edit()
		{
			$bt_arr = array();
			$num_row = $_POST['num_rows'];
			unset($_POST['num_rows']);
			$this->load->model('form_model');
			foreach($_POST as $key => $value){
			    $exp_key = explode('-', $key);
			    if($exp_key[0] == 'QA'){
			         $bt_arr[$exp_key[2]][$exp_key[1]] = $value;
			    	 unset($_POST[$key]);
			    }
			}
			if(empty($_POST['ID']))
			{
				return $this->add($bt_arr);
			}
			else
			{
				return $this->edit($bt_arr,$num_row);
			}
		}

		public function get_show_data($input,$output)
		{
		 	$this->load->library('datatable_library');
	 		return $this->datatable_library->get_data($input,$output);
		}

		public function add($bt_arr=array())
		{
			$this->load->model('form_model');
			unset($_POST['ID']);
			$b_add = $this->form_model->add(array("table"=>"EX","columns"=>$_POST));
			if($b_add === TRUE)
			{
				$id = $this->db_library->find_max_id('EX');
				if(!empty($bt_arr))
				{
					foreach($bt_arr as $key => $columns)
					{
						$columns['exam_ID'] = $id;
						$result = $this->form_model->add(array("table"=>"QA","columns"=>$columns));
					}
				}
				return $id;
			}
			else
			{	
				return $b_add;
			}
		}

		public function edit($bt_arr,$num_row)
		{
			$this->load->model('form_model');
			$b_edit = $this->form_model->edit(array("table"=>"EX","columns"=>$_POST,"where"=>array('ID'=>$_POST['ID'])));
			if($b_edit === TRUE)
			{
				$c = 0;
				$v = count($bt_arr);
				$bt_c = 1;
				if(!empty($bt_arr))
				{
					foreach($bt_arr as $key => $columns)
					{
						$columns['exam_ID'] = $_POST['ID'];
						if(array_key_exists('ID', $columns))
						{
							$result = $this->form_model->edit(array("table"=>"QA","columns"=>$columns,"where"=>array('ID'=>$columns['ID'])));
						}
						else
						{
							$result = $this->form_model->add(array("table"=>"QA","columns"=>$columns));
						}
					}
				}
				return $_POST['ID'];
			}
			else
			{	
				return $b_edit;
			}
		}
	}
?>