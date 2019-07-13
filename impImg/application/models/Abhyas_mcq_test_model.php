<?php
	class Abhyas_mcq_test_model extends CI_Model
	{
		public function check($id=NULL,$login_as="Client")
		{
			$user = count($this->fetch_model->show(array('AQT' =>array('ID'=>$id))));
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
				$this->errorlog_library->entry('Abhyas_mcq_test_model > check > argument ID is invalid.');
				redirect('Abhyas_mcq_test/add/');
			}
		}

		public function add_or_edit()
		{
			$this->load->model('form_model');
			if(empty($_POST['ID']))
			{
				unset($_POST['ID']);
				$result = $this->form_model->add(array("table"=>"AQT","columns"=>$_POST));
			}
			else
			{
				$result = $this->form_model->edit(array("table"=>"AQT","columns"=>$_POST,"where"=>array('ID'=>$_POST['ID'])));
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

	    public function delete($item_id = NULL)
	 	{
	 		$this->load->model('form_model');
	 		$delete_data = $this->form_model->delete(array('AQT' => array('ID' => $item_id)));
			return $delete_data;
	 	}

	 	public function get_questions()
	 	{
	 		if(!empty($_POST['subject_ID']) && !empty($_POST['lesson_ID']) && !empty($_POST['topic_ID']))
	 		{
	 			$data['students'] = $this->fetch_model->show(array('AQB'=>array('subject_ID'=>$_POST['subject_ID'],'lesson_ID'=>$_POST['lesson_ID'],'topic_ID'=>$_POST['topic_ID'])));
	 		}
	 		else
	 		{
	 			$data = FALSE;
	 		}
	 		return $data;
	 	}

	}
?>