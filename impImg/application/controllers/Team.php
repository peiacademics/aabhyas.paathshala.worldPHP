<?php



class Team extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if($this->login_model->check_login())
		{
			$this->data['Login']['Name'] = $this->session_library->get_session_data('Name');
			$this->data['Login']['Login_as'] = $this->session_library->get_session_data('Login_as');
			$this->data['Login']['ID'] = $this->session_library->get_session_data('ID');
			$this->data['Date_format'] = $this->date_library->get_date_format();
			$this->load->model('team_model');
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
		$this->data['breadcrumb']['heading'] = 'Staff';  
		$this->data['breadcrumb']['route'] = array("Staff");
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/team_show_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	function add($id=NULL)
	{
		$this->data['breadcrumb']['heading'] = 'Add Employee';
		$this->data['breadcrumb']['route'] = array(array('title'=>'Employees','path'=>'Team/lists'),'Add'); 
		$check = $this->team_model->check($id,$this->data['Login']['Login_as']);
		define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
        if(IS_AJAX)
		{
			if (($res = $this->team_model->add_or_edit()) === true) {
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
					$this->data['breadcrumb']['route'] = array(array('title'=>'Employee','path'=>'Team/lists'),'Edit');  
				}
				$this->data['DETAIL'] = $this->team_model->get_details($id);
				$this->data['designation'] = $this->fetch_model->show('DS');
				$this->data['branch'] = $this->fetch_model->show('BR');
				$this->data['seniority'] = $this->fetch_model->show('US');
				$this->load->view('includes/header',$this->data);
				$this->load->view('pages/team_add_edit_view',$this->data);
				$this->load->view('includes/footer',$this->data);			
			}
			else
			{
		 		return FALSE;
			}
		}
	}

	function lists($branch_ID = NULL)
	{
		$this->data['breadcrumb']['heading'] = 'Employees';  
		$this->data['breadcrumb']['route'] = array(array('title'=>'Employees','path'=>'team/lists/'.$branch_ID),'Show');
		$this->data['DETAIL'] = $this->fetch_model->show(array('US'=>array('Type !='=>'DSSK10000001','branch_ID'=>$branch_ID)));
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/team_list_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	function edit($id=NULL)
	{  
		$this->data['designation']=$this->fetch_model->show('DS');
		$check = $this->team_model->check($id,$this->data['Login']['Login_as']);
		define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
        if(IS_AJAX)
		{
			$_POST['employee_ID']=$id;
			if(($res = $this->team_model->add_or_edit()) === TRUE)
			{
				echo json_encode(1);
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
					$this->data['breadcrumb']['route'] = array(array('title'=>'Employee','path'=>'Team/lists'),'Edit');  
					$this->data['DETAIL'] = $this->team_model->get_details($id);
				}
				$this->load->view('includes/header',$this->data);
				$this->load->view('pages/team_add_edit_view',$this->data);
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
 		$res = $this->team_model->get_show_data('US',array('>>Branch:>fr>BR>name:ID=^branch_ID^','>>Designation:>fr>DS>post:ID=^Position_ID^','Name','details','Email','ID'));
 		foreach ($res['data'] as $key => $value) 
 		{
 			$res['data'][$key][0] = $value[0];
 			$res['data'][$key][1] = $value[3];
 			$res['data'][$key][2] = $value[4];
 			$res['data'][$key][3] = $value[2];
 			$res['data'][$key][4] = $value[1];
 			$res['data'][$key][5] = $value[5];
 		}
		echo json_encode($res);
 	}

 	// public function view($id = NULL)
 	// {
 	// 	$id = $this->data['Login']['ID'];
 	// 	define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
	 //    if(!IS_AJAX)
		// {
	 // 		$this->data['breadcrumb']['heading'] = 'Team Details';
		// 	$this->data['breadcrumb']['route'] = array(array('title'=>'Team','path'=>'Team'),'View');  
		// 	// $this->data['DETAIL'] = $this->team_model->get_details($id);
		// 	$this->load->view('includes/header',$this->data);
		// 	// $this->load->view('pages/team_detail_view',$this->data);
		// 	$this->load->view('pages/team_profile_view',$this->data);
		// 	$this->load->view('includes/footer',$this->data);
		// }
 	// }

 	public function view($id = NULL)
 	{
 		define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
	    if(!IS_AJAX)
		{
	 		$this->data['breadcrumb']['heading'] = 'Employee Details';
			$this->data['breadcrumb']['route'] = array(array('title'=>'Employee','path'=>'Team/lists'),'View');
			$this->data['DETAIL'] = $this->team_model->get_details2($id);
			$this->load->view('includes/header',$this->data);
			$this->load->view('pages/employee_detail_view',$this->data);
			$this->load->view('includes/footer',$this->data);
		}
 	}

	public function delete($item_id=NULL)
 	{
 		/*echo "<pre>";
	 	var_dump($item_id);
	 	echo "</pre>";*/
 		$delete_data = $this->team_model->delete($item_id);
 		define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
		if($delete_data)
 		{
		    if(IS_AJAX)
			{
				echo json_encode($delete_data);	
			}
			else
			{
	 			redirect('team');
	 		}
		}
 	}



 	public function deletes($item_id=NULL)
 	{
 		$delete_data = $this->team_model->deletes($item_id);
 		define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
		if($delete_data)
 		{
		    if(IS_AJAX)
			{
				echo json_encode($delete_data);	
			}
			else
			{
	 			redirect('team');
	 		}
		}
 	}



 	public function attendance($id=null,$date=null)
 	{
 		$attendance = $this->team_model->attendance($id,$date);
 		define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
		if($attendance)
 		{
		    if(IS_AJAX)
			{
				echo json_encode($attendance);	
			}
			else
			{
	 			redirect('team');
	 		}
		}
 	}



 	public function getAttenceData()
 	{
 		echo json_encode($this->team_model->getAttenceData());
 	}



 	public function addSalary($value='')
 	{
 		if(($res = $this->team_model->addSalary()) === TRUE)
		{
			echo 1;
		}
		else
		{
			echo json_encode($res);
		}
 	}



 	public function isPresentSalary()
 	{
 		$date=$_POST['date'];
 		$id=$_POST['id'];
 		$data = $this->fetch_model->show(array('SL' =>array('employee_ID'=>$id,'date LIKE'=>'%'.@$date.'%')));
		if (empty($data)) 
		{
			echo json_encode(false);
		}
		else
		{
			echo json_encode(true);
		}
 	}

 	function print_view($download='print',$bill_id=NULL)
 	{
		$this->load->model('form_model');
		$get =$this->fetch_model->show(array('SL'=>array('ID'=>$bill_id)));
		$this->load->helper(array('dompdf', 'file'));
		$this->data['DETAIL'] = $this->team_model->get_print_details($bill_id);
		if($download == 'print')
		{
			$this->data['print'] = 'yes';
			$this->load->view('others/salary_mail_view',$this->data);
			// $pdf = $this->fetch_model->show(array('SS'=>array('ID'=>$get[0]['file_path'])));
			// 	if(!empty($pdf) && $pdf !== NULL)
			// 	{
			// 		$this->load->file(base_url($pdf[0]['path']),true);
			// 	}
		}
		else
		{
			$this->data['download'] = 'yes';
			$html = $this->load->view('others/salary_mail_view',$this->data,TRUE);
			pdf_create($html,'fsdf');
		}
 	}

 	public function delete_File($id,$Student)
	{
		echo json_encode($this->team_model->delete_File($id,$Student));
	}

	public function upload_AnyFile()
	{
		echo $this->team_model->upload_AnyFile();
	}

	public function attendance_veiw($branch_ID = NULL)
	{
		$this->data['breadcrumb']['heading'] = 'Employee Attendance';  
		$this->data['breadcrumb']['route'] = array(array('title'=>'Employee Attendance','path'=>'team/attendance_veiw/'.$branch_ID),'Show');
		$this->data['team'] = $this->fetch_model->show(array('US'=>array('Type !='=>'DSSK10000001','branch_ID'=>$branch_ID)));
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/team_attendance_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	public function open_task($branch_ID = NULL)
	{
		$this->data['team'] = $this->fetch_model->show(array('US'=>array('Type !='=>'DSSK10000001','branch_ID'=>$branch_ID)));
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/team_open_task_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}
    
    public function notice_board($branch_ID = NULL)
	{
		$this->data['team'] = $this->fetch_model->show(array('US'=>array('Type !='=>'DSSK10000001','branch_ID'=>$branch_ID)));
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/team_notice_board_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	public function payment($branch_ID = NULL)
	{
		$this->data['breadcrumb']['heading'] = 'Employee Payments';  
		$this->data['breadcrumb']['route'] = array(array('title'=>'Employee Payments','path'=>'team/payment/'.$branch_ID),'Show');
		$this->data['team'] = $this->fetch_model->show(array('US'=>array('Type !='=>'DSSK10000001','branch_ID'=>$branch_ID)));
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/payment_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	public function award($branch_ID = NULL)
	{
		$this->data['breadcrumb']['heading'] = 'Employee Awards';  
		$this->data['breadcrumb']['route'] = array(array('title'=>'Employee Awards','path'=>'team/ward/'.$branch_ID),'Show');
		$this->data['branch_ID'] = $branch_ID;
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/employee_award_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	public function get_show_data2($branch_ID = NULL)
 	{
 		$res = $this->team_model->get_show_data(array('EA'=>array('branch_ID'=>$branch_ID)),array('date','>>Employee:>fr>US>Name:ID=^employee_ID^','>>Award:>fr>AW>title:ID=^award_ID^','ID'));
		foreach ($res['data'] as $key => $value) {
			if (strpos($value[3], '/add') !== false) {
				$res['data'][$key][3] = str_replace('/add_employee_award', '/add_employee_award/'.$branch_ID, $value[3]);
			}
		}
		echo json_encode($res);
 	}

 	public function add_employee_award($branch_ID = NULL, $id = NULL)
	{
		$this->data['breadcrumb']['heading'] = 'Add Employee Award';
		$this->data['breadcrumb']['route'] = array(array('title'=>'Employee Awards','path'=>'team/award/'.$branch_ID),'Add');
		// $check = $this->team_model->check($id,$this->data['Login']['Login_as']);
		define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
        if(IS_AJAX)
		{
			if (($res = $this->team_model->add_or_edit_award()) === true) {
				echo 1;
			}
			else
			{
				echo json_encode($res);
			}
		}
		else
		{
			if(!is_null($id))
			{
				$this->data['breadcrumb']['heading'] = 'Edit Employee Award';  
				$this->data['breadcrumb']['route'] = array(array('title'=>'Employee Awards','path'=>'team/award/'.$branch_ID),'Edit');
				$this->data['What'] = 'Edit';
				$item = $this->fetch_model->show(array('EA'=>array('ID'=>$id))); 
				$this->data['View'] = $item[0];
			}
			$this->data['branch_ID'] = $branch_ID;
			$this->load->view('includes/header',$this->data);
			$this->load->view('pages/employee_award_add_edit_view',$this->data);
			$this->load->view('includes/footer',$this->data);
		}
	}

	public function raised_doubts($branch_ID = NULL)
	{
		$this->data['breadcrumb']['heading'] = 'Raised Doubts';  
		$this->data['breadcrumb']['route'] = array(array('title'=>'Raised Doubts','path'=>'team/raised_doubts/'.$branch_ID),'Show');
		$this->data['Team'] = $this->team_model->get_student_doubts($branch_ID);
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/raised_doubts_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	public function resolve_doubt()
	{
		$res = $this->team_model->resolve_doubt();
		echo json_encode($res);
	}

	public function get_proff_status()
	{
		$res = $this->team_model->get_proff_status();
		echo json_encode($res);
	}

}	

?>