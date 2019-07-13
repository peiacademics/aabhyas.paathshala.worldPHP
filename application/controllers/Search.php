<?php
/**
* 
*/
class Search extends CI_controller
{
	
	public function __construct()
	{
		parent::__construct();
		if($this->login_model->check_login())
		{
			$this->load->model('bill_model');
			$this->data['Customers'] = $this->setting_model->getCustomers();
			$this->data['Products'] = $this->bill_model->get_product_and_model();
			$this->lang->load('custom',$this->session_library->get_session_data('Language'));
			$this->data['Login']['Login_as'] = $this->session_library->get_session_data('Login_as');
			$this->data['Login']['Name'] = $this->session_library->get_session_data('Name');
			$this->data['Login']['ID'] = $this->session_library->get_session_data('ID');
			$this->data['Login']['Email'] = $this->session_library->get_session_data('Email');
			$this->data['Date_format'] = $this->date_library->get_date_format();
			$this->load->model('search_model');
			$this->my_config = $this->config->item('skyq');
            $this->data['menu'] = $this->setting_model->get_menus($this->data,$this->my_config);
		}
		else 
		{
			$my_config = $this->config->item('skyq');
			redirect($my_config['default_login_page']);
		}
 	}

	public function index()
	{
		if (!empty(@$_POST['searchItem']))
		{
			$this->data['breadcrumb']['heading'] = 'Search';  
			$this->data['breadcrumb']['route'] = array(array('title'=>'Dashboard','path'=>'dashboard'),'Search ');
			$searchTerm=$_POST['searchItem'];
			$this->data['searchData'] = $this->search_model->getData($searchTerm);
			$this->data['searchTerm']=$searchTerm;
			$this->load->view('includes/header',$this->data);
			$this->load->view('pages/Search_view',$this->data);
			$this->load->view('includes/footer',$this->data);
		}
		else
		{
			redirect('dashboard');
		}
	}

	public function view($searchTerm)
	{
		$this->search_model->getDataJson($searchTerm);
	}
}
?>