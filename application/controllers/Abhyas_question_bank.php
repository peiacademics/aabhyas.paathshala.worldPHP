<?php
	class Abhyas_question_bank extends CI_Controller {
		
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
			$this->load->model('abhyas_question_bank_model');
			$this->data['my_config'] = $this->my_config = $this->config->item('skyq');
            $this->data['menu'] = $this->setting_model->get_menus($this->data,$this->my_config);
		}
		else 
		{
			redirect($this->config->item('skyq')['default_login_page']);
		}
 	}

	public function index()
	{
		$this->data['breadcrumb']['heading'] = 'Aabhyas Question Bank';  
		$this->data['breadcrumb']['route'] = array(array('title'=>'Aabhyas','path'=>'Abhyas_mcq'),array('title'=>'Abhyas Question Bank','path'=>'Abhyas_question_bank'),'Show');
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/abhyas_question_bank_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	public function get_show_data($item_id = NULL)
	{
		$res = $this->abhyas_question_bank_model->get_show_data('AQB',array('name','description','>>Subject:>fr>SB>name:ID=^subject_ID^','>>Lesson:>fr>LS>name:ID=^lesson_ID^','>>Topic:>fr>TP>name:ID=^topic_ID^','ID'));
		echo json_encode($res);
 	}

 	public function add($id=NULL)
 	{
 		$this->data['breadcrumb']['heading'] = 'Add Aabhyas Question Bank';
		$this->data['breadcrumb']['route'] = array(array('title'=>'Aabhyas','path'=>'Abhyas_mcq'),array('title'=>'Abhyas Question Bank','path'=>'Abhyas_question_bank'),'Add');
		$check = $this->abhyas_question_bank_model->check($id,$this->data['Login']['Login_as']);
		define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
        if(IS_AJAX)
		{
			$this->abhyas_question_bank_model->add_or_edit();
		}
		else
		{
			if($check)
			{
				if(!is_null($id))
				{
					$this->data['breadcrumb']['heading'] = 'Edit Aabhyas Question Bank';  
					$this->data['breadcrumb']['route'] = array(array('title'=>'Aabhyas','path'=>'Abhyas_mcq'),array('title'=>'Aabhyas Question Bank','path'=>'Abhyas_question_bank'),'Edit');
					$this->data['What'] = 'Edit';
					$this->data['View'] = $this->abhyas_question_bank_model->get_details($id);
				}
				$this->load->view('includes/header',$this->data);
				$this->load->view('pages/abhyas_question_bank_add_edit_view',$this->data);
				$this->load->view('includes/footer',$this->data);
			}
			else
			{
	 			return FALSE;
			}
		}
	}

 	public function delete($item_id = NULL)
 	{
 		echo json_encode($this->abhyas_question_bank_model->delete($item_id));	
 	}

 	public function upload_Q()
	{
		echo json_encode($this->abhyas_question_bank_model->upload_Q());
	}

	public function upload_A()
	{
		echo json_encode($this->abhyas_question_bank_model->upload_A());
	}

	public function delete_question($item_id = NULL)
 	{
 		echo json_encode($this->abhyas_question_bank_model->delete_question($item_id));	
 	}

 	public function delete_answer($item_id = NULL)
 	{
 		echo json_encode($this->abhyas_question_bank_model->delete_answer($item_id));	
 	}

 	public function print_pdf($id = NULL)
 	{
 		if(($id != NULL) && !empty($id) && ($id != FALSE))
 		{
	 		$rec = $this->abhyas_question_bank_model->print_details($id);
	 		if(($rec != NULL) && !empty($rec) && ($rec != FALSE))
	 		{
	 			$this->load->helper(array('dompdf', 'file'));
	 			$this->data['DETAIL'] = $rec;
	 			$html = $this->load->view('others/question_bank_pdf_view',$this->data,TRUE);
				pdf_create($html,'MCQ');
				// $this->load->view('others/mcq_pdf_view',$this->data);
	 		}
	 		else
	 		{
	 			$this->errorlog_library->entry('Abhyas_mcq > print_pdf > no MCQ entry, questions or answers found for this ID.');
		 		return FALSE;
	 		}
	 	}
	 	else
	 	{
	 		$this->errorlog_library->entry('Abhyas_mcq > print_pdf > Argument id is undefined or invalid.');
		 	return FALSE;
	 	}
 	}

}
?>