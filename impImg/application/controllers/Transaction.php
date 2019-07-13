<?php
class Transaction extends CI_Controller {
	
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
			$this->load->model('transaction_model');
			$this->data['my_config'] = $this->my_config = $this->config->item('skyq');
            $this->data['menu'] = $this->setting_model->get_menus($this->data,$this->my_config);
		}
		else 
		{
			$my_config = $this->config->item('skyq');
			redirect($my_config['default_login_page']);
		}
 	}

	public function index($branch_ID = NULL)
	{
		$this->data['transactionData'] = $this->transaction_model->getTransactions($branch_ID);
		$this->data['contratransactionData'] = $this->transaction_model->getcontraTransactions($branch_ID);
		$this->data['breadcrumb']['heading'] = 'Finance Accounting';  
		$this->data['breadcrumb']['route'] = array(array('title'=>'Finance Accounting','path'=>'transaction'),'Show');
		$this->data['branch_ID'] = $branch_ID;
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/Transaction_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	public function get_reference($expense_id = NULL)
	{
		define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
	    if(IS_AJAX)
		{
			$res = $this->transaction_model->get_reference($expense_id);
			if($res !== FALSE)
			{
				echo json_encode($res);
			}
			else
			{
				echo 0;
			}
		}
	}

	public function get_reference_bill($reference = NULL)
	{
		define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
	    if(IS_AJAX)
		{
			$res = $this->transaction_model->get_reference_bill($reference);
			if($res !== FALSE)
			{
				echo json_encode($res);
			}
			else
			{
				echo 0;
			}
		}
		else
		{
			$this->errorlog_library->entry('Transaction > get_reference_bill > function is not called through ajax.');
			echo 0;
		}
	}
	public function get_show_data($item_id = NULL)
	{
		$res = $this->transaction_model->get_show_data('T',array('transaction_type','amount','>>Date:>fn>library>date_library:db2date(^date^)','>>Payment:>fr>PM>title:ID=^payment_mode_ID^','>>Expence:>fr>EC>title:ID=^expence_category_ID^','ID'));
		echo json_encode($res);
 	}

 	public function get_show_data2($id = NULL)
	{
		$this->data['DETAIL'] = $this->Transaction_model->get_details($id);
		$mids = $this->data['DETAIL']['View'][0]['model_ID'];
		$mi = rtrim(str_replace(',', '||', $mids),"||");
		$res = $this->Transaction_model->get_show_data(array('M'=>array('ID'=>$mi)),array('model_name','warranty_period','capacity','unit','price','ID'));
		echo json_encode($res);
	}

	function add($branch_ID = NULL, $id = NULL)
	{
		$this->data['breadcrumb']['heading'] = 'Add Transaction';
		$this->data['breadcrumb']['route'] = array(array('title'=>'Transaction','path'=>'Transaction'),'Add');
		// $check = $this->transaction_model->check($id,$this->data['Login']['Login_as']);
 		define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
        if(IS_AJAX)
		{
			if (($res = $this->transaction_model->add_or_edit($branch_ID)) === true) {
				echo 1;
			}
			else
			{
				echo json_encode($res);
			}
		}
		else
		{
			/*if($check)
			{*/
				if(!is_null($id))
				{
					$this->data['breadcrumb']['heading'] = 'Edit Transaction';  
					$this->data['breadcrumb']['route'] = array(array('title'=>'Transaction','path'=>'Transaction'),'Edit');  
				}
				$this->data['DETAIL'] = $this->transaction_model->get_details($id);
				$this->load->view('includes/header',$this->data);
				$this->load->view('pages/Transaction_add_edit_view',$this->data);
				$this->load->view('includes/footer',$this->data);			
			/*}
			else
			{
		 		return FALSE;
			}*/
		}
	}

	public function view($id = NULL)
 	{
 		define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
	    if(!IS_AJAX)
		{
	 		$this->data['breadcrumb']['heading'] = 'Transaction Details';
			$this->data['breadcrumb']['route'] = array(array('title'=>'Transaction','path'=>'Transaction'),'View');  
			$this->data['DETAIL'] = $this->transaction_model->get_details($id);
			
			$this->load->view('includes/header',$this->data);
			// $this->load->view('pages/payment_view',$this->data);
			$this->load->view('pages/Transaction_detail_view',$this->data);
			$this->load->view('includes/footer',$this->data);
			
		}
 	}

 	public function delete($item_id=NULL)
 	{
 		$this->load->model('form_model');
 		if (strpos($item_id, 'CT') !== false) 
 		{
 			$delete_data = $this->form_model->delete(array('CT' => array('ID' => $item_id)));	
 		}
 		else
 		{
 			$delete_data = $this->form_model->delete(array('T' => array('ID' => $item_id)));
 		}
 		define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
		if($delete_data)
 		{
 			// $timeline = $this->fetch_model->show(array('LT'=>array('reference_ID'=>$item_id)));
 			// if (count($timeline) > 0) 
 			// {
 			// 	$t_edit = $this->form_model->edit(array("table"=>"LT","columns"=>array('delete_status'=>'D'),"where"=>array('reference_ID'=>$item_id)));	
 			// }
		    if(IS_AJAX)
			{
				echo json_encode($delete_data);	
			}
			else
			{
	 			redirect('transaction');
	 		}
		}
 	}

 	public function show()
 	{
 		define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
	    if(!IS_AJAX)
		{
	 		$this->data['breadcrumb']['heading'] = 'Transactions';
			$this->data['breadcrumb']['route'] = array(array('title'=>'Transaction','path'=>'Transaction'),'View');  
			$this->load->view('includes/header',$this->data);
			$this->load->view('pages/Transaction_show',$this->data);
			$this->load->view('includes/footer',$this->data);
		}
 	}

 	function print_view($download='print',$amc_id=NULL)
 	{
 		if(!is_null($amc_id))
 		{
			$this->load->model('form_model');
 			$get =$this->fetch_model->show(array('T'=>array('ID'=>$amc_id)));
			$check = $this->transaction_model->check($amc_id,$this->data['Login']['Login_as'],'T');
	 		if($check)
	 		{
	 			$this->load->helper(array('dompdf', 'file'));
				$this->data['DETAIL'] = $this->transaction_model->get_print_details($amc_id);
				if($download == 'print')
				{
					$this->data['print'] = 'yes';
					$this->load->view('others/transaction_mail_viewNew',$this->data);
				}
				else
				{
					$this->data['download'] = 'yes';
					$html = $this->load->view('others/transaction_mail_viewNew',$this->data,TRUE);
					pdf_create($html,'fsdf');
				}
	 		}
	 	}
 		else
 		{
	 		$this->errorlog_library->entry('Bill > print_mail > Argument bill_type or amc_id is undefined or invalid.');
	 		return FALSE;
 		}
 	}

 	public function sendMailToUser()
 	{
 		$userDetail=$this->fetch_model->show(array('US'=>array('ID'=>$this->data['Login']['ID'])));
 		if ($userDetail)
 		{
 			$userDetail=$userDetail[0];
 			$configDetail=$userDetail['emailConfigID'];
 			if (!empty($configDetail))
 			{
 				$configDetail1=json_decode($configDetail);
 				if ((!empty($configDetail1->Host)) && (!empty($configDetail1->Username)) && (!empty($configDetail1->Password)))
 				{
 					if (!empty($_POST['email']))
 					{
 						$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
 						if ($this->form_validation->run() != TRUE)
						{
							header('Content-Type:application/x-json; charset=utf-8');
							echo json_encode($this->form_validation->error_array());
						}
						else
						{
							$this->load->model('form_model');
	 						$b_edit = $this->form_model->edit(array("table"=>"T","columns"=>array('token'=>md5(time())),"where"=>array('ID'=>$_POST['ID'])));
	 						// var_dump($b_edit);
	 						$this->data['DETAIL'] = $this->transaction_model->get_print_details($_POST['ID']);
	 						$save = $this->load->view('others/transaction_mail_viewNew',$this->data,TRUE);
	 							$html = $this->load->view('others/t_mail_view',$this->data,TRUE);
								$name=time().$_POST['ID'];
								// print_r($save);
								$this->pdf_create($save, $name);
	 						$config = Array(
								'protocol' => 'smtp',
								'smtp_host' => $configDetail1->Host,
								'smtp_port' => 465,
								'smtp_user' => $configDetail1->Username,
								'smtp_pass' => $configDetail1->Password,
								'mailtype'  => 'html', 
								'charset'   => 'iso-8859-1'
								);
	 						$this->load->library('email', $config);
						 	$this->email->from($configDetail1->Username, 'SkyQ Infotech');
					        $this->email->to($_POST['email']); 
					        $this->email->cc('saurabh@skyq.in');
					        $this->email->subject('Receipt #'.$this->data['DETAIL']['DETAILS'][0]['ID']);
					        $this->email->message($html);
					        $this->email->attach(getcwd().'/sendMails/'.$name.'.pdf');
					        
							if(@$this->email->send())
							{
								 $desc="Receipt send on ".$this->date_library->db2date(date('Y-m-d'),$this->date_library->get_date_format());
								 unlink(getcwd().'/sendMails/'.$name.'.pdf');
								$t_add = $this->form_model->add(array("table"=>"LT","columns"=>array('title'=>'<a target="_blank" href='.base_url('Transaction/view/'.$_POST['ID']).'><code>'.$this->data['Login']['Name'].'</code> Send Receipt to '.$_POST['email'].'</span></a>','heading_status'=>'Main','lead_ID'=>$this->data['DETAIL']['DETAILS'][0]['referance_Name'],'reference_ID'=>$_POST['ID'],'description'=>$desc)));
								// var_dump($t_add);
								echo 0;
							}
							else
							{
								header('Content-Type:application/x-json; charset=utf-8');
	 							echo json_encode(array("email"=>"Something went wrong in yout Email setting Please Check your Email setting <a href='".base_url('Settings/email_setting')."'>Click here</a> to Check"));
								echo show_error($this->email->print_debugger());
							}					
						}		
 					}
 					else
 					{
 						header('Content-Type:application/x-json; charset=utf-8');
 						echo json_encode(array("email"=>"Email is must"));
 					}
 				}
 				else
 				{
 					header('Content-Type:application/x-json; charset=utf-8');
 					echo json_encode(array("email"=>"Must have to configure your Email setting <a href='".base_url('Settings/email_setting')."'>Click here</a> to Configure"));
 				}
 			}
 			else
 			{
 				header('Content-Type:application/x-json; charset=utf-8');
 				echo json_encode(array("email"=>"Must have to configure your Email setting <a href='".base_url('Settings/email_setting')."'>Click here</a> to Configure"));
 			}
 		}
 	}

 	function pdf_create($html, $filename, $stream=FALSE, $orientation='portrait')
	{
	    require_once(getcwd().'/application/helpers/dompdf/dompdf_config.inc.php');
	    spl_autoload_register('DOMPDF_autoload');

	    $dompdf = new DOMPDF();
	    $dompdf->load_html($html);
	    $dompdf->render();
	    if ($stream)
	    {
	        $dompdf->stream($filename.".pdf");
	    }
	    else
	    {
	        $CI =& get_instance();
	        $CI->load->helper('file');
	        write_file("./sendMails/$filename.pdf", $dompdf->output());
	    }
	}
}
?>