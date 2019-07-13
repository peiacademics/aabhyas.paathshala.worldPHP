<?php
	class Exams extends CI_Controller {
		
	public function __construct()
	{
		parent::__construct();
		if($this->login_model->check_login())
		{
			$this->lang->load('custom',$this->session_library->get_session_data('Language'));
			$this->data['Login']['Login_as'] = $this->session_library->get_session_data('Login_as');
			$this->data['Login']['Name'] = $this->session_library->get_session_data('Name');
			$this->data['Login']['Email'] = $this->session_library->get_session_data('Email');
			$this->data['Login']['ID'] = $this->session_library->get_session_data('ID');
			$this->data['Date_format'] = $this->date_library->get_date_format();
			$this->load->model('exam_model');
			$this->load->model('dashboard_model');
			$this->data['my_config'] = $this->my_config = $this->config->item('skyq');
            $this->data['menu'] = $this->dashboard_model->get_list();
		}
		else 
		{
			redirect($this->config->item('skyq')['default_login_page']);
		}
 	}

	public function index()
	{
		$this->data['breadcrumb']['heading'] = 'Exams';  
		$this->data['breadcrumb']['route'] = array(array('title'=>'Exams','path'=>'Exams'),'Show');  
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/exams_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	public function get_show_data($item_id = NULL)
	{
		$res = $this->exam_model->get_show_data('EX',array('name','no_of_questions','marks_per_question','exam_time','ID'));
		echo json_encode($res);
 	}

 	public function add($id=NULL)
 	{
 		$this->data['breadcrumb']['heading'] = 'Exams';
		$this->data['breadcrumb']['route'] = array(array('title'=>'Exams','path'=>'Exams'),'Add');
		$check = $this->exam_model->check($id,$this->data['Login']['Login_as']);
	 		define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
	        if(IS_AJAX)
			{
				echo json_encode($this->exam_model->add_or_edit());
			}
			else
			{
				if($check)
				{
					if(!is_null($id))
					{
						$this->data['breadcrumb']['heading'] = 'Edit Exam';  
						$this->data['breadcrumb']['route'] = array(array('title'=>'Exams','path'=>'Exams'),'Edit');  
						$this->data['What'] = 'Edit';
						$item = $this->fetch_model->show(array('EX'=>array('ID'=>$id))); 
						$qa = $this->fetch_model->show(array('QA'=>array('exam_ID'=>$id))); 
						$this->data['View'] = $item[0];
						$this->data['View']['qa'] = $qa;
					}
					$this->load->view('includes/header',$this->data);
					$this->load->view('pages/exams_add_edit_view',$this->data);
					$this->load->view('includes/footer',$this->data);			
				}
				else
				{
			 		return FALSE;
				} 
			}	
	}

 	public function delete($item_id=NULL)
 	{
 		$this->load->model('form_model');
 		$delete_data = $this->form_model->delete(array('QA' => array('exam_ID' => $item_id)));
 		$delete_data = $this->form_model->delete(array('EX' => array('ID' => $item_id)));
 		define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
		if($delete_data)
 		{
		    if(IS_AJAX)
			{
				echo json_encode($delete_data);	
			}
			else
			{
	 			redirect('Exams');
	 		}
		}
 	}

 	public function treeview()
 	{
 		$this->data['breadcrumb']['heading'] = 'Exams';  
		$this->data['breadcrumb']['route'] = array(array('title'=>'Exams','path'=>'Exams'),'Show');  
		$this->load->view('includes/header',$this->data);
 		$this->load->view('pages/tree_view');
 		$this->load->view('includes/footer',$this->data);
 	}
}

?>