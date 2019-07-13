<?php
	class Bank extends CI_Controller {
		
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
			$this->load->model('bank_model');
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
		$this->data['breadcrumb']['heading'] = 'Bank Accounts';  
		$this->data['breadcrumb']['route'] = array(array('title'=>'Dashboard','path'=>'dashboard'),array('title'=>'Settings','path'=>'settings'),'Bank Accounts');
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/bank_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	public function get_show_data($item_id = NULL)
	{
		$res = $this->bank_model->get_show_data('BA',array('bank_name','branch_name','ifsc_code','account_no','account_opening_date','ID'));//>>Language:>fr>LN>Title:ID=^Language_ID^
		echo json_encode($res);
 	}

 	public function add($id=NULL)
 	{
 		$this->data['breadcrumb']['heading'] = 'Add Bank Account';
		$this->data['breadcrumb']['route'] = array(array('title'=>'Dashboard','path'=>'dashboard'),array('title'=>'Settings','path'=>'settings'),array('title'=>'Bank Accounts','path'=>'bank'),'Add');
		$check = $this->bank_model->check($id,$this->data['Login']['Login_as']);
		define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
        if(IS_AJAX)
		{
			$this->bank_model->add_or_edit();
		}
		else
		{
			if($check)
			{
				if(!is_null($id))
				{
					$this->data['breadcrumb']['heading'] = 'Edit Bank Account';  
					$this->data['breadcrumb']['route'] = array(array('title'=>'Dashboard','path'=>'dashboard'),array('title'=>'Settings','path'=>'settings'),array('title'=>'Bank Accounts','path'=>'bank'),'Edit');  
					$this->data['What'] = 'Edit';
					$item = $this->fetch_model->show(array('BA'=>array('ID'=>$id))); 
					$this->data['View'] = $item[0];
				}
				$this->load->view('includes/header',$this->data);
				$this->load->view('pages/bank_add_edit_view',$this->data);
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
 		$delete_data = $this->form_model->delete(array('BA' => array('ID' => $item_id)));
 		define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
		if($delete_data)
 		{
		    if(IS_AJAX)
			{
				echo json_encode($delete_data);	
			}
			else
			{
	 			redirect('bank');
	 		}
		}
 	}


 	public function getPersons()
 	{
 		echo json_encode($this->bank_model->getPersons());
 	}

 	public function getMeet()
 	{
 		echo json_encode($this->fetch_model->show('LMT'));
 	}

 	public function addTimeline()
 	{
 		echo json_encode($this->bank_model->addTimeline());
 	}

 	public function getChosenData()
 	{
 		echo json_encode($this->bank_model->getChosenData());
 	}

 	public function downloadFile($file,$fileName)
 	{
 		// echo $file;
 		// file_put_contents($file, fopen(base_url().$file, 'r'));
 		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename=');
		header('Pragma: no-cache');
		readfile(base_url().$file.'/'.$fileName);
 	}
}
?>