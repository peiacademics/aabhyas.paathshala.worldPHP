<?php
	class Financeaccounting extends CI_Controller {
		
	public function __construct()
	{
		parent::__construct();
		if($this->login_model->check_login())
		{
			$this->data['Customers'] = $this->setting_model->getCustomers();
			// $this->data['Products'] = $this->setting_model->getProducts();
			//$this->load->model('product_model');
			$this->load->model('bill_model');
			$this->data['Vendors']=$this->fetch_model->show('V');
			$this->data['ExpnseCategory']=$this->fetch_model->show('EC');
			$this->data['Products'] = $this->bill_model->get_details();
			$this->lang->load('custom',$this->session_library->get_session_data('Language'));
			$this->data['Login']['Login_as'] = $this->session_library->get_session_data('Login_as');
			$this->data['Login']['Name'] = $this->session_library->get_session_data('Name');
			$this->data['Login']['Email'] = $this->session_library->get_session_data('Email');
			$this->data['Login']['ID'] = $this->session_library->get_session_data('ID');
			$this->data['Date_format'] = $this->date_library->get_date_format();
			$this->load->model('report_model');
			$this->my_config = $this->config->item('skyq');
            $this->data['menu'] = $this->setting_model->get_menus($this->data,$this->my_config);
		}
		else 
		{
			redirect($this->config->item('skyq')['default_login_page']);
		}
 	}

	public function index()
	{
		$this->data['breadcrumb']['heading'] = 'Reports';  
		$this->data['breadcrumb']['route'] = array(array('title'=>'Dashboard','path'=>'dashboard'),'Reports');  
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/report_show_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	public function view($branch_ID = NULL)
	{
		$this->data['breadcrumb']['heading'] = 'Finance Accounting';  
		$this->data['breadcrumb']['route'] = array(array('title'=>'Dashboard','path'=>'dashboard'),'Finance Accounting');
		$this->data['team'] = $this->fetch_model->show(array('US'=>array('Type !='=>'DSSK10000001','branch_ID'=>$branch_ID)));
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/Financeaccounting_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	
	
}
?>