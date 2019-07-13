<?php
	class Query extends CI_Controller {
		
	public function __construct()
	{
		parent::__construct();
		if($this->login_model->check_login())
		{
			$this->lang->load('custom',$this->session_library->get_session_data('Language'));
			$this->data['Login']['Login_as'] = $this->session_library->get_session_data('Login_as');
			$this->data['Login']['Name'] = $this->session_library->get_session_data('Name');
			$this->data['Login']['Added_by'] = $this->session_library->get_session_data('Added_by');
			$this->data['Login']['Email'] = $this->session_library->get_session_data('Email');
			$this->data['Login']['ID'] = $this->session_library->get_session_data('ID');
			$this->data['Date_format'] = $this->date_library->get_date_format();
			$this->load->model('Support_model');
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
		$this->data['breadcrumb']['heading'] = 'Show Support Ticket';  
		$this->data['breadcrumb']['route'] = array(array('title'=>'Support','path'=>'Query'),'Show');  
		//$this->data['messages'] = $this->Support_model->getChatMsg();
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/support_view',$this->data);
		$this->load->view('includes/footer',$this->data);		
	}

	public function add($id=NULL)
 	{
 		$this->data['breadcrumb']['heading'] = 'Create Support Ticket';  
		$this->data['breadcrumb']['route'] = array(array('title'=>'Support','path'=>'Query'),'Add');  

		$check = $this->Support_model->check($id,$this->data['Login']['Login_as']);
	 		define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
	        if(IS_AJAX)
			{
				if($this->Support_model->add($this->data['Login']['Email']))
				{
					$name2 = $this->fetch_model->show(array('SS'=>array('ID'=>$_POST['pdf_ID'])));
					if (empty($_POST['pdf_ID'])) 
					{
						$name2[0]['path'] = NULL;
					}
					$name = $this->fetch_model->show(array('C'=>array('ID'=>$_POST['customer_ID'])),'name');
					if (($r = $this->submit($_POST['email'],$_POST['ticket_ID'],$name[0]['name'],$name2[0]['path'])) === TRUE)
					{
						echo 1;
					}
					else
					{
						echo json_encode($r);
					}
				}
				else
				{
					echo 0;
				}
			}
			else
			{
				if($check)
				{
					if(!is_null($id))
					{
						$this->data['breadcrumb']['heading'] = 'Edit Support Ticket';  
						$this->data['breadcrumb']['route'] = array(array('title'=>'Support','path'=>'Query'),'Edit');
						$this->data['What'] = 'Edit';
						$item = $this->fetch_model->show(array('SP'=>array('ID'=>$id))); 
						// $this->data['View'] = $item[0];
					}
					$this->data['Customer'] = $this->fetch_model->show('C',array('ID','name'));
					$this->data['User'] = $this->fetch_model->show(array('US'=>array('Type'=>'Team Member||Admin')));
					$this->load->view('includes/header',$this->data);
					$this->load->view('pages/support_add_edit_view',$this->data);
					$this->load->view('includes/footer',$this->data);			
				}
				else
				{
			 		return FALSE;
				}
			}	
 	}

 	public function addReply($tStatus)
 	{
 		// $check = $this->Support_model->check($t_ID,$this->data['Login']['Login_as']);
	 		define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
	 		$mail=@$_POST['sendmail'];
				if($this->Support_model->addReply($this->data['Login']['Email'],$tStatus))
				{
					if ($mail == 'Yes') 
					{
						$name = $this->fetch_model->show(array('SP'=>array('ticket_ID'=>$_POST['ticket_ID'])),'email');
	 					$name2 = $this->fetch_model->show(array('C'=>array('email'=>$name[0]['email'])),'name');
						if (($r = $this->submit($name[0]['email'],$_POST['ticket_ID'],$name2[0]['name'],NULL,$tStatus)) === TRUE)
						{
							echo 1;
						}
						else
						{
							echo json_encode($r);
						}
					}
					else
					{
						echo 1;
					}
				}
				else
				{
					echo 0;
				}
 	}

		public function chkmail($id=NULL,$user,$s)
 	{
 		if ($s == "yes")
 		{
	 		if (($res = $this->Support_model->add($id,$user)) === TRUE) 
			{
				$this->accept($id,$user);
			}
			else
			{
				echo json_encode($res);
			}	
 		}
 		else
 		{
 			if (($res = $this->Support_model->delete($id)) === TRUE) 
 			{
				echo 1;
			}
			else
			{
				echo json_encode($res);
			}	
 		}
 		
 	}

	public function get_show_data($item_id = NULL)
	{
		$res = $this->Support_model->get_show_data(array('SP'=>array('whom'=>'Q','user_ID'=>$this->data['Login']['ID'],'reply_status'=>NULL,'request_status'=>'A')),array('subject','ticket_ID','ID'));
		foreach ($res['data'] as $key => $value) {
			$status=$this->fetch_model->show(array('SP'=>array('ticket_ID'=>$value[1])));
			$status=end($status);
			if ($status['ticket_status']==='O') {
				$res['data'][$key][2]="Open <sup><span class='btn-danger btn-sm'><i class='fa fa-folder-open'></i></span></sup>";
			}else if ($status['ticket_status']==='P') {
				$res['data'][$key][2]="Pending <sup><span class='btn-warning btn-sm'><i class='fa fa-spinner fa-spin'></i></span></sup>";
			}else if ($status['ticket_status']==='C') {
				$res['data'][$key][2]="Closed <sup><span class='btn-success btn-sm'><i class='fa fa-times'></i></span></sup>";
			}
			$res['data'][$key][3]=$value[2];
		}
		// $res = $this->Support_model->get_show_data(array('SP'=>array('user_email'=>$this->data['Login']['Email'],'whom'=>'Q')),array('>>Name:>fr>US>Name:ID=^Added_by^','subject','ticket_ID','ID'));

		echo json_encode($res);
 	}

 	public function get_show_data2($item_id = NULL)
	{
		$res = $this->Support_model->get_show_data(array('SP'=>array('whom'=>'Q','user_ID !='=>$this->data['Login']['ID'],'reply_status'=>NULL,'request_status'=>'A')),array('subject','ticket_ID','ID'));
		foreach ($res['data'] as $key => $value) {
			$status=$this->fetch_model->show(array('SP'=>array('ticket_ID'=>$value[1])));
			$status=end($status);
			if ($status['ticket_status']==='O') {
				$res['data'][$key][2]="Open <sup><span class='btn-danger btn-sm'><i class='fa fa-folder-open'></i></span></sup>";
			}else if ($status['ticket_status']==='P') {
				$res['data'][$key][2]="Pending <sup><span class='btn-warning btn-sm'><i class='fa fa-spinner fa-spin'></i></span></sup>";
			}else if ($status['ticket_status']==='C') {
				$res['data'][$key][2]="Closed <sup><span class='btn-success btn-sm'><i class='fa fa-times'></i></span></sup>";
			}
			$res['data'][$key][3]=$value[2];
		}
		// $res = $this->Support_model->get_show_data(array('SP'=>array('user_email'=>$this->data['Login']['Email'],'whom'=>'Q')),array('>>Name:>fr>US>Name:ID=^Added_by^','subject','ticket_ID','ID'));

		echo json_encode($res);
 	}

 	public function ticket($id = NULL)
	{
		$this->data['breadcrumb']['heading'] = 'Show Support Ticket';  
		$this->data['breadcrumb']['route'] = array(array('title'=>'Support','path'=>'Query'),'Show');  
		$this->data['messages'] = $this->Support_model->getChatMsg($id);
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/support_detail_view',$this->data);
		$this->load->view('includes/footer',$this->data);		
	}

	public function get_item_details($pm_id = NULL)
 	{
 		if(!is_null($pm_id))
 		{
 			header('Content-Type:application/x-json; charset=utf-8');
 			$id_detail = $this->Support_model->get_item_details($pm_id);
 			echo json_encode($id_detail);
 		}
 		else
 		{
 			return FALSE;
 		}
 	}


	function post($id=NULL)
	{
		if (($res = $this->Support_model->add($id)) === TRUE) 
		{
			echo 1;
		}
		else
		{
			echo json_encode($res);
		}
	}

	public function submit($email=NULL,$t_id=NULL,$name=NULL,$path=NULL,$t_Status=NULL)
	{
		// echo "stringewrwe";
		//define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
        if(IS_AJAX)
		{
				// echo "ajax";
				$user = 'pawan@skyq.in';//'support@skyq.in';
				$config = array(
					'protocol' => 'smtp',
					'smtp_host' => 'mail.skyq.in',
					'smtp_port' => 587,
					'smtp_user' => $user,//'support@skyq.in',
					'smtp_pass' => 'pawan@12345',
					'mailtype'  => 'html', 
					//'charset'   => 'iso-8859-1'
				);
				$this->load->library('email', $config);
				if ($t_Status=='C') 
				{
					$body = "Dear ".$name.",

					<p>This is to inform that your support ticket has been close with the ticket Id - ".$t_id." </p>	";
				}
				else
				{
					$body = "Dear ".$name.",

					<p>This is to inform that your support ticket has been generated with the ticket Id - ".$t_id." </p>

					<p>We will get into touch with you as soon as possible.</p>";
		    	}
		    	$body1 = '<table border="0" cellpadding="0" cellspacing="0" style="background-color: #E4E6E9" width="100%"> <tr> <td align="center" style="background-color: #E4E6E9; min-height: 200px" valign="top" width="100%"> <table> <tr> <td align="center" class="table-td-wrap" width="458"> <table border="0" cellpadding="0" cellspacing="0" class="table-space" style="background-color: #e4e6e9; font-size: 0px; height: 18px; line-height: 0; width: 450px" width="450"> <tbody> <tr> <td align="left" class="table-space-td" height="18" style="background-color: #e4e6e9; height: 18px; width: 450px" valign="middle" width="450">&nbsp;</td></tr></tbody> </table> <table border="0" cellpadding="0" cellspacing="0" class="table-space" style="background-color: #1867B4; font-size: 0px; height: 8px; line-height: 0; width: 450px" width="450"> <tbody> <tr> <td align="left" class="table-space-td" height="8" style="background-color: #1867B4; height: 8px; width: 450px" valign="middle" width="450">&nbsp;</td></tr></tbody> </table> <table border="0" cellpadding="0" cellspacing="0" class="table-row" style="background-color: #1867B4; table-layout: fixed" width="450"> <tbody> <tr> <td align="left" class="table-row-td" style="font-family: Arial, sans-serif; line-height: 19px; color: #1867B4; font-size: 13px; font-weight: normal; padding-left: 36px; padding-right: 36px;" valign="top"> <table align="left" border="0" cellpadding="0" cellspacing="0" class="table-col" style="table-layout: fixed;" width="378"> <tbody> <tr> <td align="left" class="table-col-td" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; width: 378px;" valign="top" width="378"> <table border="0" cellpadding="0" cellspacing="0" class="header-row" style="table-layout: fixed;" width="378"> <tbody> <tr> <td align="left" class="header-row-td" style="font-family: Arial, sans-serif; font-weight: normal; line-height: 30px; color: white; margin: 0px; font-size: 25px; padding-bottom: 10px; padding-top: 15px;text-align: center; " width="378"><b>SKYQ</b></td></tr></tbody> </table> </td></tr></tbody> </table> </td></tr><tr> <td> <table border="0" cellpadding="0" cellspacing="0" class="table-space" style="background-color: #ffffff; font-size: 0px; height: 12px; line-height: 0; width: 450px" width="450"> <tbody> <tr> <td align="left" class="table-space-td" height="12" style="background-color: #ffffff; height: 12px; width: 450px" valign="middle" width="450">&nbsp;</td></tr></tbody> </table> </td></tr><tr> <td> <table border="0" cellpadding="0" cellspacing="0" class="table-space" style="background-color: #ffffff; font-size: 15px; height: 12px; line-height: 2; width: 450px" width="450"> <tbody> <tr> <td colspan="2" align="left" class="table-space-td" height="12" style="background-color: #ffffff; height: 12px; padding-left: 16px; padding-right: 16px; width: 450px" valign="middle" width="450"></td></tr><tr> <td colspan="2" align="left" class="table-space-td" height="12" style="background-color: #ffffff; height: 12px; padding-left: 16px; padding-right: 16px; width: 450px" valign="middle" width="450">'.$body.'</td></tr><tr> <td>&nbsp;</td></tr><tr> <td colspan="2" align="left" class="table-space-td" height="12" style="background-color: #ffffff; height: 12px; padding-left: 16px; padding-right: 16px; width: 450px" valign="middle" width="450">Kind Regards</td></tr><tr> <td colspan="2" align="left" class="table-space-td" height="12" style="background-color: #ffffff; height: 12px; padding-left: 16px; padding-right: 16px; width: 450px" valign="middle" width="450">Skyq Team</td></tr></tbody> </table> <table border="0" cellpadding="0" cellspacing="0" class="table-space" style="background-color: #ffffff; font-size: 0px; height: 16px; line-height: 0; width: 450px" width="450"> <tbody> <tr> <td align="left" class="table-space-td" height="16" style="background-color: #ffffff; height: 16px; width: 450px" valign="middle" width="450">&nbsp;</td></tr></tbody> </table> </td></tr></tbody> </table> <table border="0" cellpadding="0" cellspacing="0" class="table-space" style="background-color: #ffffff; font-size: 0px; height: 12px; line-height: 0; width: 450px" width="450"> <tbody> <tr> <td align="left" class="table-space-td" height="12" style="background-color: #ffffff; height: 12px; width: 450px" valign="middle" width="450">&nbsp;</td></tr></tbody> </table> <table border="0" cellpadding="0" cellspacing="0" style="background-color: #E8E8E8" width="100%"> <tbody> <tr> <td align="left" height="1" style="background-color: #E8E8E8; font-size: 0; height: 1px" valign="top" width="100%">&nbsp;</td></tr></tbody> </table> <table border="0" cellpadding="0" cellspacing="0" class="table-space" style="background-color: #ffffff; font-size: 0px; height: 12px; line-height: 0; width: 450px" width="450"> <tbody> <tr> <td align="left" class="table-space-td" height="12" style="background-color: #ffffff; height: 12px; width: 450px" valign="middle" width="450">&nbsp;</td></tr></tbody> </table> <table border="0" cellpadding="0" cellspacing="0" class="table-space" style="background-color: #ffffff; font-size: 0px; height: 6px; line-height: 0; width: 450px" width="450"> <tbody> <tr> <td align="left" class="table-space-td" height="6" style="background-color: #ffffff; height: 6px; width: 450px" valign="middle" width="450">&nbsp;</td></tr></tbody> </table> <table border="0" cellpadding="0" cellspacing="0" class="table-row-fixed" style="background-color: #ffffff; table-layout: fixed" width="450"> <tbody> <tr> <td align="left" class="table-row-fixed-td" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; padding-left: 1px; padding-right: 1px;" valign="top"> <table align="left" border="0" cellpadding="0" cellspacing="0" class="table-col" style="table-layout: fixed;" width="448"> <tbody> <tr> <td align="left" class="table-col-td" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal;" valign="top" width="448"> <table border="0" cellpadding="0" cellspacing="0" style="table-layout: fixed;" width="100%"> <tbody> <tr> <td align="center" style="background-color: #f5f5f5; border-color: #e3e3e3; border-style: solid; border-width: 1px 0px 0px; color: #bbbbbb; font-family: Arial, sans-serif; font-size: 13px; font-weight: normal; line-height: 24px; padding: 9px; text-align: center" valign="top" width="100%"> <a href="#" style="color: #428bca; text-decoration: none; background-color: transparent;"> Copyright &copy; all rights reserved with skyq.in</a> </td></tr></tbody> </table> </td></tr></tbody> </table> </td></tr></tbody> </table> <table border="0" cellpadding="0" cellspacing="0" class="table-space" style="background-color: #ffffff; font-size: 0px; height: 1px; line-height: 0; width: 450px" width="450"> <tbody> <tr> <td align="left" class="table-space-td" height="1" style="background-color: #ffffff; height: 1px; width: 450px" valign="middle" width="450">&nbsp;</td></tr></tbody> </table> <table border="0" cellpadding="0" cellspacing="0" class="table-space" style="background-color: #e4e6e9; font-size: 0px; height: 36px; line-height: 0; width: 450px" width="450"> <tbody> <tr> <td align="left" class="table-space-td" height="36" style="background-color: #e4e6e9; height: 36px; width: 450px" valign="middle" width="450">&nbsp;</td></tr></tbody> </table> </td></tr></table> </td></tr></table>'; 
		    
		    	// $body2 = "<center><img src='".base_url('assets/images/logo.png')."' class='logo' alt=''><h1>Message</h1></center><hr />".$body."<hr /><center><b>Thank you for contacting us on RajivTambe!</b></center>";
			 	$this->email->from('support@skyq.in');
		        $this->email->to($email); 
		        $this->email->subject($_POST['subject']);
		        $this->email->message($body1);
		        $this->email->attach($_SERVER['DOCUMENT_ROOT'].'/'.$path);
		       //echo $_SERVER['DOCUMENT_ROOT'].$path;
				if($this->email->send())
				{
					return TRUE;
				}
				else
				{
					echo 0;
				}
		}
		else{
			return FALSE;
		}
	}

	public function pdf_upload($width=null,$height=null)
    {
    	// print_r($_FILES);
    	// var_dump($_FILES);
    	if(!empty($_FILES))
    	{
			header('Content-Type:application/x-json; charset=utf-8');
			$new_name = str_replace(" ", "-", time().$_FILES["file"]['name']);
	        $config['upload_path']          = './upload/';
	        $config['allowed_types']        = '*';
	        $config['max_size']             = '1000000';
			$config['file_name'] = $new_name;
	        $this->load->library('upload', $config);
	        $this->upload->initialize($config);
	        if ( ! $this->upload->do_upload('file'))
	        {
	        	echo json_encode($this->upload->display_errors());
	        }
	        else
	        {
	        	$this->load->model('form_model');
	        	$file_name = $new_name;
	        	if($this->form_model->add(array('table'=>'SS','columns'=>array('path'=>'upload/'.$file_name))))
	        	{
	        		$id = $this->db_library->find_max_id('SS');
	        		$result = $this->fetch_model->show(array('SS'=>array('ID'=>$id)));
	        		 echo json_encode($result[0]);
	        	}
	        	else{
	        		echo json_encode("PDF file Not found");
	        	}
	        }
	    }
	    else{
	    	echo json_encode("PDF file Not found");
	    }
    }	

	public function accept($id,$u)
	{
		// echo "stringewrwe";
		define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
        if(IS_AJAX)
		{
				// echo "ajax";
				$user = 'pawan@skyq.in';//'support@skyq.in';
				$config = array(
					'protocol' => 'smtp',
					'smtp_host' => 'mail.skyq.in',
					'smtp_port' => 587,
					'smtp_user' => $user,//'support@skyq.in',
					'smtp_pass' => 'pawan@12345',
					'mailtype'  => 'html', 
					//'charset'   => 'iso-8859-1'
				);
				$this->load->library('email', $config);
				$body = "Dear ".$this->data['Login']['Name'].",

				<p>This is to inform that your request has been accepted with the request Id - ".$id." </p>

				<p>You will get your queries answer very shortly.</p>";
		    
		    	$body1 = '<table border="0" cellpadding="0" cellspacing="0" style="background-color: #E4E6E9" width="100%"> <tr> <td align="center" style="background-color: #E4E6E9; min-height: 200px" valign="top" width="100%"> <table> <tr> <td align="center" class="table-td-wrap" width="458"> <table border="0" cellpadding="0" cellspacing="0" class="table-space" style="background-color: #e4e6e9; font-size: 0px; height: 18px; line-height: 0; width: 450px" width="450"> <tbody> <tr> <td align="left" class="table-space-td" height="18" style="background-color: #e4e6e9; height: 18px; width: 450px" valign="middle" width="450">&nbsp;</td></tr></tbody> </table> <table border="0" cellpadding="0" cellspacing="0" class="table-space" style="background-color: #1867B4; font-size: 0px; height: 8px; line-height: 0; width: 450px" width="450"> <tbody> <tr> <td align="left" class="table-space-td" height="8" style="background-color: #1867B4; height: 8px; width: 450px" valign="middle" width="450">&nbsp;</td></tr></tbody> </table> <table border="0" cellpadding="0" cellspacing="0" class="table-row" style="background-color: #1867B4; table-layout: fixed" width="450"> <tbody> <tr> <td align="left" class="table-row-td" style="font-family: Arial, sans-serif; line-height: 19px; color: #1867B4; font-size: 13px; font-weight: normal; padding-left: 36px; padding-right: 36px;" valign="top"> <table align="left" border="0" cellpadding="0" cellspacing="0" class="table-col" style="table-layout: fixed;" width="378"> <tbody> <tr> <td align="left" class="table-col-td" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; width: 378px;" valign="top" width="378"> <table border="0" cellpadding="0" cellspacing="0" class="header-row" style="table-layout: fixed;" width="378"> <tbody> <tr> <td align="left" class="header-row-td" style="font-family: Arial, sans-serif; font-weight: normal; line-height: 30px; color: white; margin: 0px; font-size: 25px; padding-bottom: 10px; padding-top: 15px;text-align: center; " width="378"><b>'.$_SERVER['DOCUMENT_ROOT'].'/Udyamatantra_software/impImg/logo-white.png'.'</b> </td></tr></tbody> </table> </td></tr></tbody> </table> </td></tr><tr> <td> <table border="0" cellpadding="0" cellspacing="0" class="table-space" style="background-color: #ffffff; font-size: 0px; height: 12px; line-height: 0; width: 450px" width="450"> <tbody> <tr> <td align="left" class="table-space-td" height="12" style="background-color: #ffffff; height: 12px; width: 450px" valign="middle" width="450">&nbsp;</td></tr></tbody> </table> </td></tr><tr> <td> <table border="0" cellpadding="0" cellspacing="0" class="table-space" style="background-color: #ffffff; font-size: 15px; height: 12px; line-height: 2; width: 450px" width="450"> <tbody> <tr> <td colspan="2" align="left" class="table-space-td" height="12" style="background-color: #ffffff; height: 12px; padding-left: 16px; padding-right: 16px; width: 450px" valign="middle" width="450"></td></tr><tr> <td colspan="2" align="left" class="table-space-td" height="12" style="background-color: #ffffff; height: 12px; padding-left: 16px; padding-right: 16px; width: 450px" valign="middle" width="450">'.$body.'</td></tr><tr> <td>&nbsp;</td></tr><tr> <td colspan="2" align="left" class="table-space-td" height="12" style="background-color: #ffffff; height: 12px; padding-left: 16px; padding-right: 16px; width: 450px" valign="middle" width="450">Kind Regards</td></tr><tr> <td colspan="2" align="left" class="table-space-td" height="12" style="background-color: #ffffff; height: 12px; padding-left: 16px; padding-right: 16px; width: 450px" valign="middle" width="450">Bagbootstrap Team</td></tr></tbody> </table> <table border="0" cellpadding="0" cellspacing="0" class="table-space" style="background-color: #ffffff; font-size: 0px; height: 16px; line-height: 0; width: 450px" width="450"> <tbody> <tr> <td align="left" class="table-space-td" height="16" style="background-color: #ffffff; height: 16px; width: 450px" valign="middle" width="450">&nbsp;</td></tr></tbody> </table> </td></tr></tbody> </table> <table border="0" cellpadding="0" cellspacing="0" class="table-space" style="background-color: #ffffff; font-size: 0px; height: 12px; line-height: 0; width: 450px" width="450"> <tbody> <tr> <td align="left" class="table-space-td" height="12" style="background-color: #ffffff; height: 12px; width: 450px" valign="middle" width="450">&nbsp;</td></tr></tbody> </table> <table border="0" cellpadding="0" cellspacing="0" style="background-color: #E8E8E8" width="100%"> <tbody> <tr> <td align="left" height="1" style="background-color: #E8E8E8; font-size: 0; height: 1px" valign="top" width="100%">&nbsp;</td></tr></tbody> </table> <table border="0" cellpadding="0" cellspacing="0" class="table-space" style="background-color: #ffffff; font-size: 0px; height: 12px; line-height: 0; width: 450px" width="450"> <tbody> <tr> <td align="left" class="table-space-td" height="12" style="background-color: #ffffff; height: 12px; width: 450px" valign="middle" width="450">&nbsp;</td></tr></tbody> </table> <table border="0" cellpadding="0" cellspacing="0" class="table-space" style="background-color: #ffffff; font-size: 0px; height: 6px; line-height: 0; width: 450px" width="450"> <tbody> <tr> <td align="left" class="table-space-td" height="6" style="background-color: #ffffff; height: 6px; width: 450px" valign="middle" width="450">&nbsp;</td></tr></tbody> </table> <table border="0" cellpadding="0" cellspacing="0" class="table-row-fixed" style="background-color: #ffffff; table-layout: fixed" width="450"> <tbody> <tr> <td align="left" class="table-row-fixed-td" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; padding-left: 1px; padding-right: 1px;" valign="top"> <table align="left" border="0" cellpadding="0" cellspacing="0" class="table-col" style="table-layout: fixed;" width="448"> <tbody> <tr> <td align="left" class="table-col-td" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal;" valign="top" width="448"> <table border="0" cellpadding="0" cellspacing="0" style="table-layout: fixed;" width="100%"> <tbody> <tr> <td align="center" style="background-color: #f5f5f5; border-color: #e3e3e3; border-style: solid; border-width: 1px 0px 0px; color: #bbbbbb; font-family: Arial, sans-serif; font-size: 13px; font-weight: normal; line-height: 24px; padding: 9px; text-align: center" valign="top" width="100%"> <a href="#" style="color: #428bca; text-decoration: none; background-color: transparent;"> Copyright &copy; all rights reserved with Bagbootstrap.com</a> </td></tr></tbody> </table> </td></tr></tbody> </table> </td></tr></tbody> </table> <table border="0" cellpadding="0" cellspacing="0" class="table-space" style="background-color: #ffffff; font-size: 0px; height: 1px; line-height: 0; width: 450px" width="450"> <tbody> <tr> <td align="left" class="table-space-td" height="1" style="background-color: #ffffff; height: 1px; width: 450px" valign="middle" width="450">&nbsp;</td></tr></tbody> </table> <table border="0" cellpadding="0" cellspacing="0" class="table-space" style="background-color: #e4e6e9; font-size: 0px; height: 36px; line-height: 0; width: 450px" width="450"> <tbody> <tr> <td align="left" class="table-space-td" height="36" style="background-color: #e4e6e9; height: 36px; width: 450px" valign="middle" width="450">&nbsp;</td></tr></tbody> </table> </td></tr></table> </td></tr></table>'; 
		    
		    	// $body2 = "<center><img src='".base_url('assets/images/logo.png')."' class='logo' alt=''><h1>Message</h1></center><hr />".$body."<hr /><center><b>Thank you for contacting us on RajivTambe!</b></center>";
			 	$this->email->from($u.'@skyq.in');
		        $this->email->to($this->data['Login']['Email']); 
		        $this->email->subject("skyq - Support");
		        $this->email->message($body1);
		        //$this->email->attach($_SERVER['DOCUMENT_ROOT'].'/Invertor-2.0.1/sendMails/'.$name.'.html');
				if($this->email->send())
				{
					echo 1;
				}
				else
				{
					echo 0;
				}
		}
		else{
			return FALSE;
		}
	}	

}
?>