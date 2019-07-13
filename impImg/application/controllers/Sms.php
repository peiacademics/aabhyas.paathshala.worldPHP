<?php
	class Sms extends CI_Controller {
		
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
			$this->load->model('sms_model');
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
		$this->data['breadcrumb']['heading'] = 'Message Masters';  
		$this->data['breadcrumb']['route'] = array(array('title'=>'Settings','path'=>'settings'),'Message Masters');  
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/sms_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	public function get_show_data($item_id = NULL)
	{
		$res = $this->sms_model->get_show_data('SM',array('sms','>>name:>fr>MT>type:ID=^message_type_ID^','desc','ID'));
		echo json_encode($res);
 	}

 	public function add($id = NULL)
 	{
 		$this->data['breadcrumb']['heading'] = 'Add Message Master';
		$this->data['breadcrumb']['route'] = array(array('title'=>'Settings','path'=>'settings'),array('title'=>'Message Masters','path'=>'sms'),'Add');
		$check = $this->sms_model->check($id,$this->data['Login']['Login_as']);
		define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
        if(IS_AJAX)
		{
			$this->sms_model->add_or_edit();
		}
		else
		{
			if($check)
			{
				if(!is_null($id))
				{
					$this->data['breadcrumb']['heading'] = 'Edit Message Master';  
					$this->data['breadcrumb']['route'] = array(array('title'=>'Settings','path'=>'settings'),array('title'=>'Message Masters','path'=>'sms'),'Edit');
					$this->data['What'] = 'Edit';
					$item = $this->fetch_model->show(array('SM'=>array('ID'=>$id)));
					$this->data['View'] = $item[0];
				}
				$this->data['type'] = $this->fetch_model->show('MT');
				$this->load->view('includes/header',$this->data);
				$this->load->view('pages/sms_add_edit_view',$this->data);
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
 		$this->load->model('form_model');
 		$delete_data = $this->form_model->delete(array('SM' => array('ID' => $item_id)));
 		define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
		if($delete_data)
 		{
		    if(IS_AJAX)
			{
				echo json_encode($delete_data);	
			}
			else
			{
	 			redirect('sms');
	 		}
		}
 	}

}
?>