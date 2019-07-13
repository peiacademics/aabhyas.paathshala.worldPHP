<?php
	class Report extends CI_Controller {
		
	public function __construct()
	{
		parent::__construct();
		if($this->login_model->check_login())
		{
			// $this->data['Customers'] = $this->setting_model->getCustomers();
			// $this->data['Products'] = $this->setting_model->getProducts();
			//$this->load->model('product_model');
			// $this->data['Vendors']=$this->fetch_model->show('V');
			// $this->data['ExpnseCategory']=$this->fetch_model->show('EC');
			// $this->data['Products'] = $this->bill_model->get_details();
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
		// $this->load->view('pages/report_show_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	public function call($branch_ID = NULL)
	{
		$this->data['breadcrumb']['heading'] = 'Marketing Telecalling';  
		$this->data['breadcrumb']['route'] = array(array('title'=>'Marketing Telecalling','path'=>'report/call'),'Report');  
		$this->data['users'] = $this->fetch_model->show(array('US'=>array('branch_ID'=>$branch_ID)));
		$this->data['branch_ID'] = $branch_ID;
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/report_call_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	public function view()
	{
		$this->data['breadcrumb']['heading'] = 'Reports';  
		$this->data['breadcrumb']['route'] = array(array('title'=>'Dashboard','path'=>'dashboard'),'Reports');  
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/report_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	public function score($branch_ID = NULL)
	{
		$this->data['breadcrumb']['heading'] = 'Score Report';  
		$this->data['breadcrumb']['route'] = array(array('title'=>'Score Report','path'=>'Report/score/'.$branch_ID),'Show');
		//$this->data['team'] = $this->fetch_model->show(array('US'=>array('Type !='=>'DSSK10000001','branch_ID'=>$branch_ID)));
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/score_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	public function Sells($branch_ID = NULL)
	{
		$this->data['breadcrumb']['heading'] = 'Reports';  
		$this->data['breadcrumb']['route'] = array(array('title'=>'Dashboard','path'=>'dashboard'),'Reports');
		//$this->data['team'] = $this->fetch_model->show(array('US'=>array('Type !='=>'DSSK10000001','branch_ID'=>$branch_ID)));
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/report_sell_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	public function Purchase($branch_ID = NULL)
	{
		$this->data['breadcrumb']['heading'] = 'Reports';  
		$this->data['breadcrumb']['route'] = array(array('title'=>'Dashboard','path'=>'dashboard'),'Reports');
		// $this->data['team'] = $this->fetch_model->show(array('US'=>array('Type !='=>'DSSK10000001','branch_ID'=>$branch_ID)));
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/report_purchase_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	/*public function Stock()
	{
		$this->data['breadcrumb']['heading'] = 'Reports';  
		$this->data['breadcrumb']['route'] = array(array('title'=>'Dashboard','path'=>'dashboard'),'Reports');  
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/report_stock_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}*/

	public function Expences($branch_ID = NULL)
	{
		$this->data['breadcrumb']['heading'] = 'Reports';  
		$this->data['breadcrumb']['route'] = array(array('title'=>'Dashboard','path'=>'dashboard'),'Reports');
		// $this->data['team'] = $this->fetch_model->show(array('US'=>array('Type !='=>'DSSK10000001','branch_ID'=>$branch_ID)));
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/report_expences_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	public function getSell()
	{
		$this->report_model->getSell();
	}

	public function getPurchase()
	{
		$this->report_model->getPurchase();
	}

	/*public function getStock()
	{
		$this->report_model->getStock();
	}*/

	public function getExpCat()
	{
		$this->report_model->getExpCat();
	}

	public function daily_base($branch_ID = NULL)
	{
		// $this->data['team'] = $this->fetch_model->show(array('US'=>array('Type !='=>'DSSK10000001','branch_ID'=>$branch_ID)));
		$this->data['branch_ID'] = $branch_ID;
		$this->data['breadcrumb']['heading'] = 'Daily Task Report';  
		$this->data['breadcrumb']['route'] = array(array('title'=>'Daily Task Report','path'=>'report/daily_base/'.$branch_ID),'show');
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/daily_task_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	public function add($branch_ID = NULL, $id = NULL)
 	{
 		$this->data['breadcrumb']['heading'] = 'Add Daily Task';
		$this->data['breadcrumb']['route'] = array(array('title'=>'Dashboard','path'=>'dashboard'),array('title'=>'Daily Task','path'=>'report/daily_base/'.$branch_ID),'Add');
		$check = $this->report_model->check($id,$this->data['Login']['Login_as']);
		define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
        if(IS_AJAX)
		{
			$this->report_model->add_or_edit();
		}
		else
		{
			if($check)
			{
				if(!is_null($id))
				{
					$this->data['breadcrumb']['heading'] = 'Edit Daily Task';  
					$this->data['breadcrumb']['route'] = array(array('title'=>'Dashboard','path'=>'dashboard'),array('title'=>'Daily Task','path'=>'report/daily_base/'.$branch_ID),'Edit');  
					$this->data['What'] = 'Edit';
					$item = $this->fetch_model->show(array('DAT'=>array('ID'=>$id)));
					$this->data['View'] = $item[0];
				}
				$this->data['subjects'] = $this->fetch_model->show('SB');
				$this->load->view('includes/header',$this->data);
				$this->load->view('pages/daily_task_add_edit_view',$this->data);
				$this->load->view('includes/footer',$this->data);
			}
			else
			{
	 			return FALSE;
			}
		}
	}

	public function task_base($branch_ID = NULL)
	{
		$this->data['breadcrumb']['heading'] = 'Tasks Report';  
		$this->data['breadcrumb']['route'] = array(array('title'=>'Tasks Report','path'=>'report/task_base/'.$branch_ID),'Show');
		//$this->data['team'] = $this->fetch_model->show(array('US'=>array('Type !='=>'DSSK10000001','branch_ID'=>$branch_ID)));
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/task_base_report_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	public function get_show_data($branch_ID = NULL)
	{
		if($this->data['Login']['Login_as'] == 'DSSK10000001')
		{
			$res = $this->report_model->get_show_data(array('DAT'=>array('branch_ID'=>$branch_ID,'to >='=>date('Y-m-d 00:00:00'),'to <='=>date('Y-m-d 23:59:59'))),array('to','from','description','ID'),array('ORDER'=>array('to','DESC')));
		}
		else
		{
			$res = $this->report_model->get_show_data(array('DAT'=>array('branch_ID'=>$branch_ID,'Added_by'=>$this->data['Login']['ID'],'to >='=>date('Y-m-d 00:00:00'),'to <='=>date('Y-m-d 23:59:59'))),array('to','from','description','ID'),array('ORDER'=>array('to','DESC')));
		}
		echo json_encode($res);
 	}

 	public function delete($item_id = NULL)
 	{
 		$delete_data = $this->report_model->delete($item_id);
 		define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
		if($delete_data)
 		{
		    if(IS_AJAX)
			{
				echo json_encode($delete_data);	
			}
			else
			{
	 			redirect('report');
	 		}
		}
 	}
	
	public function get_scorecard($branch_ID=NULL)
	{	
		echo json_encode($this->report_model->get_scorecard($branch_ID));
	}

	public function get_task_reports($branch_ID=NULL)
	{	
		echo json_encode($this->report_model->get_task_reports($branch_ID));
	}
}
?>