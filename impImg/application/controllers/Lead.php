<?php



class Lead extends CI_Controller

{

	public function __construct()

	{

		parent::__construct();

		if($this->login_model->check_login())

		{

			$this->data['Login']['Name'] = $this->session_library->get_session_data('Name');

			$this->data['Login']['Login_as'] = $this->session_library->get_session_data('Login_as');

			$this->data['Date_format'] = $this->date_library->get_date_format();

			$this->data['Login']['ID'] = $this->session_library->get_session_data('ID');

			$this->load->model('lead_model');

			$this->data['my_config'] = $this->my_config = $this->config->item('skyq');

            $this->data['menu'] = $this->setting_model->get_menus($this->data,$this->my_config);

		}

		else

		{

			redirect($this->config->item('skyq')['default_login_page']);

		}

 	}

	

	function index()

	{

		$this->data['breadcrumb']['heading'] = 'Lead';  

		$this->data['breadcrumb']['route'] = array(array('title'=>'Leads','path'=>'lead'),'Show');

		$this->data['menu_active'] = 'Vendors-Show';

		$this->load->view('includes/header',$this->data);

		$this->load->view('pages/lead_view',$this->data);

		$this->load->view('includes/footer',$this->data);

	}



	function add($id=NULL)

	{

		$this->data['breadcrumb']['heading'] = 'Generate Lead';

		$this->data['breadcrumb']['route'] = array(array('title'=>'Lead','path'=>'lead'),'Generate');

		$check = $this->lead_model->check($id,$this->data['Login']['Login_as']);

		define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');

        if(IS_AJAX)

		{

			if (($res = $this->lead_model->add_or_edit()) === TRUE) {
				if (!empty($_POST['ID'])) {
					echo json_encode($_POST['ID']);
				}
				else
				{
					echo json_encode($this->db_library->find_max_id("LD"));
				}
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

					$this->data['breadcrumb']['heading'] = 'Edit Leads';  

					$this->data['breadcrumb']['route'] = array(array('title'=>'Lead','path'=>'lead'),'Edit');  

					$this->data['DETAIL'] = $this->lead_model->get_details($id);

				}

				if(is_null($id))

				{

					$this->data['menu_active'] = 'Lead-Add';

				}

				$this->load->view('includes/header',$this->data);

				$this->load->view('pages/lead_add_edit_view',$this->data);

				$this->load->view('includes/footer',$this->data);			

			}

			else

			{

		 		return FALSE;

			}

		}

	}

	

	public function get_show_data($item_id = NULL)
 	{
 		$res = $this->lead_model->get_show_data(array('LD'=>array('show_status'=>'Ongoing')),array('Name','Email','City','Referance','phone_no_ID','company_name','ID'));
		// $res = $this->lead_model->get_show_data('LD',array('Name','Email','City','Referance','phone_no_ID','company_name','ID'));
		foreach ($res['data'] as $key => $value) {
			$data=$this->fetch_model->show(array("PH" => array('ID' => str_replace(',', '||', trim($value[4],',')))),array('phone_type','phone_number'));
			if ($data) {
				// var_dump($data);
				$str='';
				foreach ($data as $k => $v) {
					$str .= $v['phone_type']." - ".$v['phone_number']."<br>";
				}
				$res['data'][$key][4]=$str;
			}
		}
		echo json_encode($res);
 	}

 	public function get_show_data1($item_id = NULL)
 	{
		$res = $this->lead_model->get_show_data(array('LD'=>array('show_status'=>'Hold')),array('Name','Email','City','Referance','phone_no_ID','company_name','ID'));
		foreach ($res['data'] as $key => $value) {
			$data=$this->fetch_model->show(array("PH" => array('ID' => str_replace(',', '||', trim($value[4],',')))),array('phone_type','phone_number'));
			if ($data) {
				// var_dump($data);
				$str='';
				foreach ($data as $k => $v) {
					$str .= $v['phone_type']." - ".$v['phone_number']."<br>";
				}
				$res['data'][$key][4]=$str;
			}
		}
		echo json_encode($res);
 	}



 	public function get_show_data2($id = NULL)

	{

		$res = $this->lead_model->get_show_data(array('PU'=>array('vendor_ID like'=>'%'.$id.'%')),array('bill_number','amount','>>Date:>fn>library>date_library:db2date(^date^)','ID'));

		echo json_encode($res);

	}



	public function get_show_data3($id = NULL)

	{

		$res = $this->lead_model->get_show_data(array('T'=>array('reference_ID like'=>'%'.$id.'%')),array('amount','>>PMN:>fr>PM>title:ID=^payment_mode_ID^','bank_ID','other_details','>>Date:>fn>library>date_library:db2date(^date^)','ID'));

		echo json_encode($res);

	}

	public function get_show_data5($item_id = NULL)
 	{
 		$res = $this->lead_model->get_show_data('EB',array('Email','count'));
 		// print_r($res);
		echo json_encode($res);
 	}



 	public function view($id = NULL)

 	{

		define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');

	    if(!IS_AJAX)

		{

	 		$this->data['breadcrumb']['heading'] = 'Lead Details';

			$this->data['breadcrumb']['route'] = array(array('title'=>'Lead','path'=>'lead'),'View'); 

			$this->data['meetType']=$this->fetch_model->show('LMT');

			$this->data['DETAIL'] = $this->lead_model->get_details($id);

			$this->load->view('includes/header',$this->data);

			$this->load->view('pages/lead_detail_view',$this->data);

			$this->load->view('includes/footer',$this->data);

		}

 	}



	public function delete($item_id=NULL)

 	{

 		$this->load->model('form_model');

 		$delete_data = $this->lead_model->delete($item_id);

 		define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');

		if($delete_data)

 		{

		    if(IS_AJAX)

			{

				echo json_encode(true);	

			}

			else

			{

	 			redirect('vendor');

	 		}

		}

 	}



 	public function meet($value='')

 	{

 		$this->data['breadcrumb']['heading'] = 'Meet Type';  

		$this->data['breadcrumb']['route'] = array(array('title'=>'Dashboard','path'=>'dashboard'),array('title'=>'Settings','path'=>'settings'),'Meet Type');  

		$this->load->view('includes/header',$this->data);

		$this->load->view('pages/meettype_mode_view',$this->data);

		$this->load->view('includes/footer',$this->data);

	}



	public function get_show_data_meet($item_id = NULL)

 	{

 		$res = $this->lead_model->get_show_data('LMT',array('name','icon','ID'));

 		foreach ($res['data'] as $key => $value) {

 			$res['data'][$key][1]="<span class='fa ".$value[1]."'></span>";

 		}

		echo json_encode($res);

 	}



 	public function addmeet($id=NULL)

 	{

 		$this->data['breadcrumb']['heading'] = 'Add Meet Type';  

		$this->data['breadcrumb']['route'] = array(array('title'=>'Dashboard','path'=>'dashboard'),array('title'=>'settings','path'=>'settings'),array('title'=>'Meet Type','path'=>'lead/meet'),'Add');  



		define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');

        if(IS_AJAX)

		{

			$this->lead_model->add_or_editmeet();

		}

		else

		{

			if(!is_null($id))

			{

				$this->data['breadcrumb']['heading'] = 'Edit Meet Type';  

				$this->data['breadcrumb']['route'] = array(array('title'=>'Dashboard','path'=>'dashboard'),array('title'=>'settings','path'=>'settings'),array('title'=>'Meet Type','path'=>'lead/meet'),'Edit');

				$this->data['What'] = 'Edit';

				$item = $this->fetch_model->show(array('LMT'=>array('ID'=>$id))); 

				$this->data['View'] = $item[0];

			}

			

			$this->load->view('includes/header',$this->data);

			$this->load->view('pages/meet_add_edit_view',$this->data);

			$this->load->view('includes/footer',$this->data);			

		}

 	}



 	public function addTimelineData()

 	{

 		define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');

 		 if(IS_AJAX)

		{

			header('Content-Type:application/x-json; charset=utf-8');

			if (($result=$this->lead_model->addTimelineData())===true) {

				echo json_encode($result);

			}

			else

			{

				echo json_encode($result);

			}

		}

 	}



 	public function getMeetData($id)

 	{

 		header('Content-Type:application/x-json; charset=utf-8');

 		$item = $this->fetch_model->show(array('LMT'=>array('ID'=>$id)));

 		if ($item) {

 			echo json_encode($item[0]);

 		}

 		else

 		{

 			echo false;

 		}

 	}



 	public function convertAsCostomer()

 	{

 		header('Content-Type:application/x-json; charset=utf-8');

 		echo json_encode($this->lead_model->convertAsCostomer());

 	}



 	public function isEmailPresent($id)

 	{

 		header('Content-Type:application/x-json; charset=utf-8');

 		echo json_encode($this->lead_model->isEmailPresent($id));

 	}


 	public function hold()
 	{
 		header('Content-Type:application/x-json; charset=utf-8');
 		echo json_encode($this->lead_model->hold());
 	}

 	public function unhold()
 	{
 		header('Content-Type:application/x-json; charset=utf-8');
 		echo json_encode($this->lead_model->unhold());
 	}

 	public function convertProcess()
 	{
 		header('Content-Type:application/x-json; charset=utf-8');
 		echo json_encode($this->lead_model->convertProcess());
 	}
 	

}	

?>