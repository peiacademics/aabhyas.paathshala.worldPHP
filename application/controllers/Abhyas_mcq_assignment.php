<?php
	class Abhyas_mcq_assignment extends CI_Controller {
		
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
			$this->load->model('abhyas_mcq_assignment_model');
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
		$this->data['breadcrumb']['heading'] = 'Aabhyas Assignment';  
		$this->data['breadcrumb']['route'] = array(array('title'=>'Aabhyas','path'=>'Abhyas_mcq'),array('title'=>'Aabhyas Assignment','path'=>'Abhyas_mcq_assignment'),'Show');
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/abhyas_mcq_assignment_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	public function get_show_data($item_id = NULL)
	{
		$res = $this->abhyas_mcq_assignment_model->get_show_data('AQS',array('name','description','>>Subject:>fr>SB>name:ID=^subject_ID^','>>Lesson:>fr>LS>name:ID=^lesson_ID^','>>Topic:>fr>TP>name:ID=^topic_ID^','ID'));
		echo json_encode($res);
 	}

 	public function add($id=NULL)
 	{
 		$this->data['breadcrumb']['heading'] = 'Add Aabhyas Assignment';
		$this->data['breadcrumb']['route'] = array(array('title'=>'Aabhyas','path'=>'Abhyas_mcq'),array('title'=>'Abhyas Assignment','path'=>'Abhyas_mcq_assignment'),'Add');
		$check = $this->abhyas_mcq_assignment_model->check($id,$this->data['Login']['Login_as']);
		define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
        if(IS_AJAX)
		{
			$this->abhyas_mcq_assignment_model->add_or_edit();
		}
		else
		{
			if($check)
			{
				if(!is_null($id))
				{
					$this->data['breadcrumb']['heading'] = 'Edit Aabhyas Assignment';  
					$this->data['breadcrumb']['route'] = array(array('title'=>'Aabhyas','path'=>'Abhyas_mcq'),array('title'=>'Aabhyas Assignment','path'=>'Abhyas_mcq_assignment'),'Edit');
					$this->data['What'] = 'Edit';
					$rec = $this->fetch_model->show(array('AQS'=>array('ID'=>$id)));
					$this->data['questions'] = $this->fetch_model->show('AQB');
					$this->data['View'] = $rec[0];
				}
				$this->load->view('includes/header',$this->data);
				$this->load->view('pages/abhyas_mcq_assignment_add_edit_view',$this->data);
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
 		echo json_encode($this->abhyas_mcq_assignment_model->delete($item_id));	
 	}

 	public function get_questions()
 	{
 		$res = $this->abhyas_mcq_assignment_model->get_questions();
 		echo json_encode($res);
 	}
}
?>