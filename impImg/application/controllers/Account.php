<?php
class Account extends CI_Controller {
	
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
			$this->load->model('account_model');
			$this->data['my_config'] = $this->my_config = $this->config->item('skyq');
            $this->data['menu'] = $this->setting_model->get_menus($this->data,$this->my_config);
		}
		else 
		{
			$my_config = $this->config->item('skyq');
			redirect($my_config['default_login_page']);
		}
 	}

 	function index()
	{
		redirect('Transaction/');
	}

 	public function cash()
 	{
		$this->data['cashBookData']=$this->account_model->getCashBookData('cash');
		$this->data['breadcrumb']['heading'] = 'Cash';  
		$this->data['breadcrumb']['route'] = array(array('title'=>'Account','path'=>'account'),'Cash');
		$this->data['balance'] = $this->account_model->get_balance('cash');
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/cash_book_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

 	public function bank()
 	{
		$this->data['cashBookData']=$this->account_model->getCashBookData('bank');
		$this->data['breadcrumb']['heading'] = 'Bank';
		$this->data['breadcrumb']['route'] = array(array('title'=>'Account','path'=>'account'),'Bank');
		$this->data['balance'] = $this->account_model->get_balance('bank');
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/bank_book_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}
	public function get_show_data($type=NULL)
	{
		define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
	    if(IS_AJAX)
		{
			echo json_encode($this->account_model->get_show_data($type));
		}
		else
		{
			$this->errorlog_library->entry('Account > get_show_data > ajax function is not called.');
			return FALSE;
		}
	}

	public function showCashBook($value='')
	{
		$this->data['breadcrumb']['heading'] = 'Cash';  
		$this->data['breadcrumb']['route'] = array(array('title'=>'Account','path'=>'account'),'Cash');
		$this->data['balance'] = $this->account_model->get_balance('cash');
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/search_cash_book_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	public function showBankBook($value='')
	{
		$this->data['breadcrumb']['heading'] = 'Bank';  
		$this->data['breadcrumb']['route'] = array(array('title'=>'Account','path'=>'account'),'Bank');
		$this->data['balance'] = $this->account_model->get_balance('bank');
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/search_bank_book_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}
}
?>