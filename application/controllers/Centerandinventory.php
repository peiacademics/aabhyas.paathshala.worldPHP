<?php
	class Centerandinventory extends CI_Controller {
		
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
			$this->load->model('centerandinventory_model');
			$this->my_config = $this->config->item('skyq');
            $this->data['menu'] = $this->setting_model->get_menus($this->data,$this->my_config);
		}
		else 
		{
			redirect($this->config->item('skyq')['default_login_page']);
		}
 	}

	public function index($branch_ID = NULL)
	{
		$this->data['breadcrumb']['heading'] = 'Center & Inventory';  
		$this->data['breadcrumb']['route'] = array(array('title'=>'Center & Inventory','path'=>'Centerandinventory/index/'.$branch_ID),'Show');
		$this->data['branch_ID'] = $branch_ID;
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/centerandinventory_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	public function view($branch_ID = NULL)
	{
		$this->data['breadcrumb']['heading'] = 'Center & Inventory';  
		$this->data['breadcrumb']['route'] = array(array('title'=>'Center & Inventory','path'=>'Centerandinventory/view/'.$branch_ID),'Show');
		$this->data['branch_ID'] = $branch_ID;
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/centerandinventory_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	public function get_show_data($branch_ID = NULL)
	{
		$res = $this->centerandinventory_model->get_show_data(array('IT'=>array('branch_ID'=>$branch_ID)),array('name','description','quantity','ID'));
		foreach ($res['data'] as $key => $value) {
			if (strpos($value[3], '/add') !== false) {
				$res['data'][$key][3] = str_replace('/add', '/add/'.$branch_ID, $value[3]);
			}
		}
		echo json_encode($res);
 	}
	
	public function add($branch_ID = NULL, $id = NULL)
 	{
 		$this->data['breadcrumb']['heading'] = 'Add Center & Inventory';
		$this->data['breadcrumb']['route'] = array(array('title'=>'Center & Inventory','path'=>'Centerandinventory/index/'.$branch_ID),'Add');
		$check = $this->centerandinventory_model->check($id,$this->data['Login']['Login_as']);
		define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
        if(IS_AJAX)
		{
			$this->centerandinventory_model->add_or_edit();
		}
		else
		{
			if($check)
			{
				if(!is_null($id))
				{
					$this->data['breadcrumb']['heading'] = 'Edit Center & Inventory';  
					$this->data['breadcrumb']['route'] = array(array('title'=>'Center & Inventory','path'=>'Centerandinventory/index/'.$branch_ID),'Edit');  
					$this->data['What'] = 'Edit';
					$this->data['View'] = $this->centerandinventory_model->get_details($id); 
				}
				$this->load->view('includes/header',$this->data);
				$this->load->view('pages/centerandinventory_add_edit_view',$this->data);
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
 		$delete_data = $this->centerandinventory_model->delete($item_id);
 		echo json_encode($delete_data);	
 	}

 	public function delete_item($item_id = NULL)
 	{
 		$this->load->model('form_model');
 		$item = $this->str_function_library->call('fr>ITI>item_ID:ID=`'.$item_id.'`');
 		$qty = $this->str_function_library->call('fr>IT>quantity:ID=`'.$item.'`');
 		$qty--;
 		$delete_data = $this->form_model->delete(array('ITI'=>array('ID'=>$item_id)));
 		if($delete_data == TRUE)
 		{
 			$edit_data = $this->form_model->edit(array("table"=>"IT","columns"=>array('quantity'=>$qty),"where"=>array('ID'=>$item)));
 			echo json_encode($edit_data);
 		}
 		else
 		{
 			echo json_encode($delete_data);	
 		}
 	}

 	public function get_details($id = NULL)
 	{
 		$data = $this->centerandinventory_model->get_details($id); 
 		echo json_encode($data);
 	}
}
?>