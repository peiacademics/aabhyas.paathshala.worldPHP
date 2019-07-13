<?php

	class Employee extends CI_Controller {

		

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

				$this->load->model('employee_model');

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

			$this->data['breadcrumb']['heading'] = 'Employee';  

			$this->data['breadcrumb']['route'] = array(array('title'=>'Employee','path'=>'Employee'),'Show');  

			$this->load->view('includes/header',$this->data);

			$this->load->view('pages/employee_view',$this->data);

			$this->load->view('includes/footer',$this->data);

		}



	// public function get_show_data($item_id = NULL)

	// {

	// 	$res = $this->product_model->get_show_data('P',array('>>prod:>fr>PT>title:ID=^product_type^','name','description','validity','unit','price','purchase_ID','ID'));
	// 	foreach ($res['data'] as $key => $value) 
	// 	{
	// 		// var_dump($value);
	// 		if ($value[5] !== NULL) 
	// 		{
	// 			$data=$this->fetch_model->show(array("PU" => array('ID' => $value[5])));
	// 			if ($data) 
	// 			{
	// 				$str='';
	// 				foreach ($data as $k => $v) 
	// 				{
	// 					$vname = $this->fetch_model->show(array('V'=>array('ID'=>$v['vendor_ID'])));
	// 					$str .= "<b> Name:-</b>".$vname[0]['name']." <br><b>Price:- Rs.</b>".$v['amount']."<br>";
	// 				}
	// 				$res['data'][$key][5]=$value[6];
	// 				$res['data'][$key][6]=$str;
	// 			}
	// 		}
	// 		else
	// 		{
	// 			$res['data'][$key][5]=$value[6];	
	// 			$res['data'][$key][6]="-NA-";	
	// 		}	

	// 	}
	// 	echo json_encode($res);

 // 	}



 // 	public function get_show_data2($id = NULL)

	// {

	// 	$this->data['DETAIL'] = $this->product_model->get_details($id);

	// 	$mids = $this->data['DETAIL']['View'][0]['model_ID'];

	// 	$mi = rtrim(str_replace(',', '||', $mids),"||");

	// 	$res = $this->product_model->get_show_data(array('M'=>array('ID'=>$mi)),array('model_name','warranty_period','capacity','unit','price','ID'));

	// 	echo json_encode($res);

	// }



	function add($id=NULL)

	{

		$this->data['breadcrumb']['heading'] = 'Add Employee';

		$this->data['breadcrumb']['route'] = array(array('title'=>'Employee','path'=>'Employee'),'Add'); 
		// $this->data['Vendors']=$this->fetch_model->show('V');
		$check = $this->employee_model->check($id,$this->data['Login']['Login_as']);

		define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');

        if(IS_AJAX)

		{

			if (($res = $this->employee_model->add_or_edit()) === true) {

				echo 1;

			}

			else

			{

				echo json_encode($res);

			}

		}

		else

		{

			if($check)

			{

				if(!is_null($id))

				{

					$this->data['breadcrumb']['heading'] = 'Edit Employee';  

					$this->data['breadcrumb']['route'] = array(array('title'=>'Employee','path'=>'Employee'),'Edit');  

				}

				$this->data['DETAIL'] = $this->employee_model->get_details($id);

				$this->load->view('includes/header',$this->data);

				$this->load->view('pages/employee_add_edit_view',$this->data);

				$this->load->view('includes/footer',$this->data);			

			}

			else

			{

		 		return FALSE;

			}

		}

	}



	public function view($id = NULL)

 	{

 		define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');

	    if(!IS_AJAX)

		{

	 		$this->data['breadcrumb']['heading'] = 'Employee Details';

			$this->data['breadcrumb']['route'] = array(array('title'=>'Employee','path'=>'Employee'),'View');  

			$this->data['DETAIL'] = $this->employee_model->get_details($id);
			

			$this->load->view('includes/header',$this->data);

			$this->load->view('pages/employee_detail_view',$this->data);

			$this->load->view('includes/footer',$this->data);

			

		}

 	}



 	public function delete($item_id=NULL)

 	{

 		$delete_data = $this->employee_model->delete($item_id);

 		define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');

		if($delete_data)

 		{

		    if(IS_AJAX)

			{

				echo json_encode($delete_data);	

			}

			else

			{

	 			redirect('Employee');

	 		}

		}

 	}



 // 	public function deletepm($item_id=NULL)

 // 	{

 // 		$arr = array();

 // 		$this->load->helper('string');

 // 		$this->load->model('form_model');

 // 		$res = $this->fetch_model->show('P',array('model_ID','ID'));

 // 		define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');

 // 		foreach ($res as $key => $value)

	// 	{

	// 			if (strpos($value['model_ID'],$item_id) !==false)

	// 			{

 //    				$new = str_replace($item_id.',', '', $value['model_ID']);

 //    				$new = (!empty($new)) ? $new : $this->form_model->delete(array('P' => array('ID' => $value['ID'])));

 //    				if(IS_AJAX)

	// 				{

	//     				if($new === TRUE)

	//     				{

 //    						$arr = array('1');

	//     				}

	//     			}

	//     			if($new !== TRUE)

	//     			{

	//     				$result = $this->form_model->edit(array("table"=>"P","columns"=>array('model_ID'=>$new),"where"=>array('ID'=>$value['ID'])));

	//     			}

	// 			}

	// 	}

 // 		$delete_data = $this->form_model->delete(array('M' => array('ID' => $item_id)));

	// 	if($delete_data)

 // 		{

	// 	    if(IS_AJAX)

	// 		{

	// 			echo (empty($arr)) ? json_encode($delete_data) : json_encode(@$arr); 	

	// 		}

	// 		else

	// 		{

	//  			redirect('product');

	//  		}

	// 	}

	// }

}

?>