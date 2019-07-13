<?php
	class Communicate_model extends CI_Model
	{
		public function getTypeList()
		{
			if ($_POST['type']==='Student') {
				// $result['data'] = $this->fetch_model->show('BT');
				$result['data']=$this->fetch_model->show(array('BT' =>array('branch_ID'=>$_POST['branch_ID'])));
				$result['type']='Batch';
				return $result;
			}
			elseif ($_POST['type']==='Employee') {
				$result['data'] = $this->fetch_model->show('DS');
				if ($result['data']) {
					foreach ($result['data'] as $key => $value) {
						$result['data'][$key]['name']=$value['post'];
					}
					$result['type']='Designation';
					return $result;
				}
			}
			else
			{
				return false;
			}
		}

		public function personsToSendMsg()
		{
			if ($_POST['type']==='Employee') {
				$mainData=array();
				$typeArray=array();
				

				if ($_POST['typeList'][0]==='all') {

					$mainData['data']=$this->fetch_model->show(array('US' =>array('branch_ID'=>$_POST['branch_ID'])));
					$mainData['type']=$_POST['type'];
					$mainData['list'][0]=array('ID'=>'all','Name'=>'all');
					return $mainData;
				}
				else
				{
					foreach ($_POST['typeList'] as $key => $value) {
						$result[]=$this->fetch_model->show(array('US' =>array('branch_ID'=>$_POST['branch_ID'],'Type'=>$value)));
						$typeArray[]=array('ID'=>$value,'Name'=>$this->str_function_library->call('fr>DS>post:ID=`'.$value.'`'));
					}
					if ($result) {
						foreach ($result as $k => $v) {
							foreach ($v as $ke => $va) {
								$mainData['data'][]=$va;
							}
						}
						$mainData['type']=$_POST['type'];
						$mainData['list']=$typeArray;
						return $mainData;
					}
					else
					{
						return false;
					}
				}
			}
			elseif ($_POST['type']==='Student') {
					$typeArray=array();
					$mainData=array();

					if ($_POST['typeList'][0]==='all') {
						$mainData['data']=$this->fetch_model->show(array('ST' =>array('branch_ID'=>$_POST['branch_ID'])));
						$mainData['type']=$_POST['type'];
						$mainData['list'][0]=array('ID'=>'all','Name'=>'all');
						return $mainData;
					}
					else
					{
						foreach ($_POST['typeList'] as $k => $v) {
							$typeArray[]=array('ID'=>$v,'Name'=>$this->str_function_library->call('fr>BT>name:ID=`'.$v.'`'));
							$mainDataofAD=$this->fetch_model->show(array('ADT' =>array('Batch'=>$v)));
							if ($mainDataofAD) {
								foreach ($mainDataofAD as $key => $value) {
									$Datas=$this->fetch_model->show(array('ST' =>array('branch_ID'=>$_POST['branch_ID'],'ID'=>$value['Student_ID'])));
									if ($Datas) {
										$Datas[0]['Type']=$v;
										$mainData['data'][]=$Datas[0];
									}
								}
							}
						}
						$mainData['list']=$typeArray;
						$mainData['type']=$_POST['type'];
						return $mainData;
					}
				}
				else
				{
					return false;
				}
		}

		public function getMsgMaster()
		{
			$Datas=$this->fetch_model->show(array('SM' =>array('message_type_ID'=>$_POST['msgID'])));
			return $Datas;
		}

		public function sendMsg()
		{
			$this->load->library('email');
			if ($_POST['toTypeStudent']=='false' && $_POST['toTypeG1']=='false' && $_POST['toTypeG2']=='false') {
				$_POST['toTypeStudent']=true;
			}
			// var_dump($_POST);
			$this->load->model('form_model');
			$send_type = $_POST['send_type'];
			$tbl_name = $_POST['tbl_name'];
			$tbl_ID = $_POST['tbl_ID'];
			unset($_POST['tbl_name']);
			unset($_POST['tbl_ID']);
			unset($_POST['send_type']);
			

			$_POST['msgto'] = implode(",",$_POST['msgto']);
			if ($_POST['typeofPerson']==='Employee') {
				$_POST['toTypeStudent']='no_need';
				$_POST['toTypeG1']='no_need';
				$_POST['toTypeG2']='no_need';
			}
			if ($_POST['message_type']==='email') {
				$emails = $this->getEmails($send_type,$tbl_name,$tbl_ID);
				$addData = $this->form_model->add(array("table"=>"COMD","columns"=>$_POST));
				if ($addData) {
					$this->sendEmails($emails,$_POST['message'],$send_type,$_POST['Subject']);
					return true;
				}
			}
			elseif ($_POST['message_type']==='mobile' || $_POST['message_type']==='gateway') {
				$numners = $this->getNumbers($_POST['message_type'], $send_type, $tbl_name, $tbl_ID);
				$addData = $this->form_model->add(array("table"=>"COMD","columns"=>$_POST));
				if ($addData) {
					if($send_type == 'bulk')
					{
						return array('types'=>$_POST['message_type'],'data'=>implode(',', $numners['NOS']));
					}
					else
					{
						foreach ($numners['NOS'] as $keyn => $valuen) {
							// $numners['NOS'][$keyn]['msg'] = "Dear ".$valuen['name'].", You have received following marks in ".$valuen['test_name']." dated on ".$valuen['date'].", ".$valuen['obtained']." / ".$valuen['total'].".";
							/*unset($numners['NOS'][$keyn]['name']);
							unset($numners['NOS'][$keyn]['test_name']);
							unset($numners['NOS'][$keyn]['obtained']);
							unset($numners['NOS'][$keyn]['total']);*/
						}
						return array('types'=>$_POST['message_type'],'data'=>$numners['NOS']);
					}
				}
				else
				{
					return false;
				}
				
			}
			elseif ($_POST['message_type'] === 'app') {
				$numners = $this->getPlayer($_POST['message_type'], $send_type, $tbl_name, $tbl_ID);
				$addData = $this->form_model->add(array("table"=>"COMD","columns"=>$_POST));
				if ($addData) {
					if($send_type == 'bulk')
					{
						return array('types'=>$_POST['message_type'],'data'=>implode(',', $numners['NOS']));
					}
					else
					{
						foreach ($numners['NOS'] as $keyn => $valuen) {
							// $numners['NOS'][$keyn]['msg'] = "Dear ".$valuen['name'].", You have received following marks in ".$valuen['test_name']." dated on ".$valuen['date'].", ".$valuen['obtained']." / ".$valuen['total'].".";
							/*unset($numners['NOS'][$keyn]['name']);
							unset($numners['NOS'][$keyn]['test_name']);
							unset($numners['NOS'][$keyn]['obtained']);
							unset($numners['NOS'][$keyn]['total']);*/
						}
						return array('types'=>$_POST['message_type'],'data'=>$numners['NOS']);
					}
				}
				else
				{
					return false;
				}
			}
			else
			{
				// Comming soon
			}
		}

		public function sendEmails($emails,$msgs,$send_type,$sub)
		{
			if($send_type == 'bulk')
			{
				foreach ($emails['NOS'] as $key => $value) {
					$Edata['Msg'] = $msgs;
					$Edata['time'] = date("Y-m-d H:i:s");
					$config = array(
						'protocol' => 'smtp',
						'smtp_host' => 'mx00.1and1.com',
						'smtp_port' => 25,
						'smtp_user' => 'mailer@paathshala.world',
						'smtp_pass' => '',
						'mailtype'  => 'html',
					);
					$this->email->initialize($config);
		        	$this->email->from('support@paathshala.in','Paathshala');
			   		$save = $this->load->view('messages/comunication_msg',$Edata,TRUE);
		        	$this->email->subject($sub);
		        	$this->email->message($save);
					$this->email->to($value);
					if($this->email->send())
					{
						// echo "done";
					}
					else
					{
						// echo "flase";
					}
				}
			}
			else
			{
				foreach ($emails['NOS'] as $key => $value) {
					// $Edata['Msg'] = "Dear ".$value['name'].",<br><br><p>You have received following marks in ".$value['test_name']." dated on ".$value['date'].", ".$value['obtained']." / ".$value['total'].".<p>";
					$Edata['Msg'] = $value['msg'];
					$Edata['time'] = date("Y-m-d H:i:s");
					$config = array(
						'protocol' => 'smtp',
						'smtp_host' => 'mail.skyq.in',
						'smtp_port' => 587,
						'smtp_user' => 'pawan@skyq.in',
						'smtp_pass' => 'pawan@12345',
						'mailtype'  => 'html',
					);
					$this->email->initialize($config);
		        	$this->email->from('support@paathshala.in','Paathshala');
			   		$save = $this->load->view('messages/comunication_msg',$Edata,TRUE);
		        	$this->email->subject($value['sub']);
		        	$this->email->message($save);
					$this->email->to($value['email']);
					if($this->email->send())
					{
						// echo "done";
					}
					else
					{
						// echo "flase";
					}
				}
			}
		}

		public function getEmails($send_type = NULL,$tbl_name = NULL, $tbl_ID = NULL)
		{
			$data=array();
			$to=explode(",",$_POST['msgto']);
			if ($_POST['typeofPerson']==='Employee') {
				foreach ($to as $key => $value) {
					$empEmail=$this->fetch_model->show(array('US' =>array('ID'=>$value)));
					$data['NOS'][]=$empEmail[0]['Email'];
				}
				return $data;
			}
			else
			{
				$highest = $this->get_highest_marks($tbl_name,$tbl_ID);
				$marks_rec = array();
				foreach ($to as $key => $value) {
					$stEmail=$this->fetch_model->show(array('ST' =>array('ID'=>$value)));
					if($send_type != 'bulk')
					{
						$data['studentEmail'][] = $this->getTableRecs($stEmail[0]['ID'],$tbl_name,$tbl_ID,'email',$highest);
					}
					else
					{
						$data['studentEmail'][] = $stEmail[0]['Email'];
					}
					if ($_POST['toTypeG1']=='true' || $_POST['toTypeG2']=='true') {
						$gdEmail=$this->fetch_model->show(array('GD' =>array('Student_ID'=>$value)));
						$data['gd1'][]=$gdEmail[0]['Email'];
						$data['gd2'][]=$gdEmail[1]['Email'];
						if($send_type != 'bulk')
						{
							$data['gd1']['marks'] = $this->getTableRecs($value,$tbl_name,$tbl_ID,'email',$highest);
							$data['gd2']['marks'] = $this->getTableRecs($value,$tbl_name,$tbl_ID,'email',$highest);
						}
					}
				}
				if ($_POST['toTypeStudent']=='true' && $_POST['toTypeG1']=='true' && $_POST['toTypeG2']=='true') {
					$dd=array_merge($data['studentEmail'],$data['gd1']);
					$dd1=array_merge($dd,$data['gd2']);
					var_dump($data['studentmarks']);
					$newMainArray['NOS']=array_merge($dd1,$data['studentmarks']);
					return $newMainArray;
				}
				elseif ($_POST['toTypeStudent']=='true' && $_POST['toTypeG1']=='true') {
					unset($data['gd2']);
					$newMainArray['NOS']=array_merge($data['studentEmail'],$data['gd1']);
					return $newMainArray;
				}
				elseif ($_POST['toTypeG1']=='true' && $_POST['toTypeG2']=='true') {
					unset($data['studentEmail']);
					$newMainArray['NOS']=array_merge($data['gd1'],$data['gd2']);
					return $newMainArray;
				}
				elseif ($_POST['toTypeStudent']=='true' && $_POST['toTypeG1']=='true') {
					unset($data['gd2']);
					$newMainArray['NOS']=array_merge($data['studentEmail'],$data['gd1']);
					return $newMainArray;
				}
				elseif ($_POST['toTypeStudent']=='true' && $_POST['toTypeG2']=='true') {
					unset($data['gd1']);
					$newMainArray['NOS']=array_merge($data['studentEmail'],$data['gd2']);
					return $newMainArray;
				}
				elseif ($_POST['toTypeStudent']=='true') {
					unset($data['gd1']);
					unset($data['gd2']);
					$newMainArray['NOS']=$data['studentEmail'];
					return $newMainArray;
				}
				elseif ($_POST['toTypeG1']=='true') {
					unset($data['studentEmail']);
					unset($data['gd2']);
					$newMainArray['NOS']=$data['gd1'];
					return $newMainArray;
				}
				elseif ($_POST['toTypeG2']=='true') {
					unset($data['studentEmail']);
					unset($data['gd1']);
					$newMainArray['NOS']=$data['gd2'];
					return $newMainArray;
				}
				else
				{
					return false;
				}
			}
		}

		public function getNumbers($message_type = NULL, $send_type = NULL, $tbl_name = NULL, $tbl_ID = NULL)
		{
			$data=array();
			$to=explode(",",$_POST['msgto']);
			if ($_POST['typeofPerson']==='Employee') {
				foreach ($to as $key => $value) {
					$empPhones=$this->fetch_model->show(array('PH' =>array('person_ID'=>$value)));
					$data['NOS'][]=$empPhones[0]['phone_number'];
				}
				return $data;
			}
			else
			{
				$highest = $this->get_highest_marks($tbl_name,$tbl_ID);
				foreach ($to as $key => $value) {
					if($send_type != 'bulk')
					{
						$data['studentNo'][] = $this->getTableRecs($value,$tbl_name,$tbl_ID,'gateway',$highest);
					}
					else
					{
						$stPhones = $this->fetch_model->show(array('PH' =>array('person_ID'=>$value)));
						$data['studentNo'][] = $stPhones[0]['phone_number'];
					}
					if ($_POST['toTypeG1']=='true' || $_POST['toTypeG2']=='true') {
						$stPhones=$this->fetch_model->show(array('GD' =>array('Student_ID'=>$value)));
						$gdPhones=$this->fetch_model->show(array('PH' =>array('person_ID'=>$stPhones[0]['ID'])));
						$gdPhones1=$this->fetch_model->show(array('PH' =>array('person_ID'=>$stPhones[1]['ID'])));
						$data['gd1'][]=$gdPhones[0]['phone_number'];
						$data['gd2'][]=$gdPhones1[0]['phone_number'];
					}
				}
				if ($_POST['toTypeStudent']=='true' && $_POST['toTypeG1']=='true' && $_POST['toTypeG2']=='true') {
					$dd=array_merge($data['studentNo'],$data['gd1']);
					$newMainArray['NOS']=array_merge($dd,$data['gd2']);
					return $newMainArray;
				}
				elseif ($_POST['toTypeStudent']=='true' && $_POST['toTypeG1']=='true') {
					unset($data['gd2']);
					$newMainArray['NOS']=array_merge($data['studentNo'],$data['gd1']);
					return $newMainArray;
				}
				elseif ($_POST['toTypeG1']=='true' && $_POST['toTypeG2']=='true') {
					unset($data['studentNo']);
					$newMainArray['NOS']=array_merge($data['gd1'],$data['gd2']);
					return $newMainArray;
				}
				elseif ($_POST['toTypeStudent']=='true' && $_POST['toTypeG1']=='true') {
					unset($data['gd2']);
					$newMainArray['NOS']=array_merge($data['studentNo'],$data['gd1']);
					return $newMainArray;
				}
				elseif ($_POST['toTypeStudent']=='true' && $_POST['toTypeG2']=='true') {
					unset($data['gd1']);
					$newMainArray['NOS']=array_merge($data['studentNo'],$data['gd2']);
					return $newMainArray;
				}
				elseif ($_POST['toTypeStudent']=='true') {
					unset($data['gd1']);
					unset($data['gd2']);
					$newMainArray['NOS']=$data['studentNo'];
					return $newMainArray;
				}
				elseif ($_POST['toTypeG1']=='true') {
					unset($data['studentNo']);
					unset($data['gd2']);
					$newMainArray['NOS']=$data['gd1'];
					return $newMainArray;
				}
				elseif ($_POST['toTypeG2']=='true') {
					unset($data['studentNo']);
					unset($data['gd1']);
					$newMainArray['NOS']=$data['gd2'];
					return $newMainArray;
				}
				else
				{
					return false;
				}
			}
		}

		public function add_communication_setting()
	 	{
	 		$this->load->model('form_model');
	 		$recs = array();
	 		foreach($_POST as $key => $value)
			{
				if(strpos($key, '-') != FALSE)
		 		{
		 			$first_digit = explode('-', $key);
		 			$recs[$first_digit[1]][$first_digit[0]] = $value;
		 		}
			}
			$cnt = count($recs);
			$i = 0;
			if(($recs != NULL) && !empty($recs) && ($recs != FALSE))
		 	{
		 		foreach ($recs as $keyr => $valuer) {
		 			if(array_key_exists('self', $valuer) != FALSE)
		 			{
		 				$valuer['self'] = 'Y';
		 			}
		 			else
		 			{
		 				$valuer['self'] = 'N';
		 			}
		 			if(array_key_exists('guardian1', $valuer) != FALSE)
		 			{
		 				$valuer['guardian1'] = 'Y';
		 			}
		 			else
		 			{
		 				$valuer['guardian1'] = 'N';
		 			}
		 			if(array_key_exists('guardian2', $valuer) != FALSE)
		 			{
		 				$valuer['guardian2'] = 'Y';
		 			}
		 			else
		 			{
		 				$valuer['guardian2'] = 'N';
		 			}
		 			$res = $this->form_model->edit(array("table"=>"CMS","columns"=>$valuer,"where"=>array('ID'=>$keyr)));
		 			if($res == TRUE)
		 			{
		 				$i++;
		 			}
		 		}
		 	}
		 	else
		 	{
		 		return FALSE;
		 	}
		 	if($cnt == $i)
		 	{
		 		return TRUE;
		 	}
		 	else
		 	{
		 		return FALSE;
		 	}
	 	}

	 	public function get_record()
	 	{
	 		$rec = $this->fetch_model->show(array($_POST['tbl']=>array('ID'=>$_POST['ID'])));
	 		$res['rec'] = $rec[0];
	 		if(($_POST['tbl'] == 'CL') && ($res['rec']['student_ID'] == NULL))
	 		{
	 			if(strpos($res['rec']['Class_ID'], ',') !== FALSE)
	 			{
	 				$batches = explode(',', $res['rec']['Class_ID']);
	 				$students = array();
	 				foreach ($batches as $key => $value) {
	 					$students[] = $this->fetch_model->show(array('ADT'=>array('Batch'=>$value)),array('Student_ID'));
	 				}
	 			}
	 			else
	 			{
	 				$students[] = $this->fetch_model->show(array('ADT'=>array('Batch'=>$res['rec']['Class_ID'])),array('Student_ID'));
	 			}
	 			$sts = '';
	 			foreach ($students as $keys => $values) {
					if(($values[0] != NULL) && !empty($values[0]) && ($values[0] != FALSE))
					{
						$sts .= $values[0]['Student_ID'].',';
					}
	 			}
	 			$res['rec']['student_ID'] = $sts;
	 		}
	 		$setting = $this->fetch_model->show(array('CMS'=>array('ID'=>$_POST['rec_id'])));
	 		$res['setting'] = $setting[0];
	 		return $res;
	 	}

	 	public function getTableRecs($stEmail = NULL, $tbl_name = NULL, $tbl_ID = NULL, $style = NULL, $highest = NULL)
	 	{
	 		$marks = array();
	 		switch ($tbl_name) {
	 			case 'TS':
	 				$student_inf = $this->fetch_model->show(array('TS'=>array('test_ID'=>$tbl_ID,'student_ID LIKE'=>'%'.$stEmail.'%')));
	 				$marks['ID'] = $stEmail;
	 				$marks['name'] = $this->str_function_library->call('fr>ST>Name:ID=`'.$stEmail.'`').' '.$this->str_function_library->call('fr>ST>Last_name:ID=`'.$stEmail.'`');
	 				$test_name = $this->str_function_library->call('fr>TE>title:ID=`'.$tbl_ID.'`');
	 				$date = $this->str_function_library->call('fr>TE>test_date:ID=`'.$tbl_ID.'`');
	 				$date_1 = date('d-m-Y h:i A', strtotime($date));
	 				if($style === 'gateway')
	 				{
	 					$stPhones = $this->fetch_model->show(array('PH' =>array('person_ID'=>$stEmail)));
	 					$marks['studentNo'] = $stPhones[0]['phone_number'];
	 					$marks['msg'] = 'Dear Parent, your ward scored "'.$student_inf[0]['marks'].' / '.$student_inf[0]['out_of'].'"  [Highest : '.$highest.'/'.$student_inf[0]['out_of'].'] in the Test "'.$test_name.'" conducted on "'.$date_1.'".';
	 				}
	 				else if($style === 'email')
	 				{
	 					$marks['email'] = $this->str_function_library->call('fr>ST>Email:ID=`'.$stEmail.'`');
	 					$marks['msg'] = 'Dear Parent, your ward scored "'.$student_inf[0]['marks'].' / '.$student_inf[0]['out_of'].'"  [Highest : '.$highest.'/'.$student_inf[0]['out_of'].'] in the Test "'.$test_name.'" conducted on "'.$date_1.'".';
	 					$marks['sub'] = '[Paathshala Education] Test Marks | "'.$test_name.'" | "'.$date_1.'"';
	 				}
	 				else if($style === 'app')
	 				{
	 					$marks['player_ID'] = $this->str_function_library->call('fr>ST>player_ID:ID=`'.$stEmail.'`');
	 					$marks['msg'] = 'Dear Parent, your ward scored "'.$student_inf[0]['marks'].' / '.$student_inf[0]['out_of'].'"  [Highest : '.$highest.'/'.$student_inf[0]['out_of'].'] in the Test "'.$test_name.'" conducted on "'.$date_1.'".';
	 				}
	 				else
	 				{}
	 				return $marks;
	 				break;

	 			case 'SA':
	 				$student_inf = $this->fetch_model->show(array('SA'=>array('test_ID'=>$tbl_ID,'student_ID LIKE'=>'%'.$stEmail.'%')));
	 				$marks['ID'] = $stEmail;
	 				$marks['name'] = $this->str_function_library->call('fr>ST>Name:ID=`'.$stEmail.'`').' '.$this->str_function_library->call('fr>ST>Last_name:ID=`'.$stEmail.'`');
	 				$test_name = $this->str_function_library->call('fr>AS>title:ID=`'.$tbl_ID.'`');
	 				$subject_ID = $this->str_function_library->call('fr>AS>subject_ID:ID=`'.$tbl_ID.'`');
	 				$subject = $this->str_function_library->call('fr>SB>name:ID=`'.$subject_ID.'`');
	 				$lesson_ID = $this->str_function_library->call('fr>AS>chapter:ID=`'.$tbl_ID.'`');
	 				$lesson = $this->str_function_library->call('fr>LS>name:ID=`'.$lesson_ID.'`');
	 				$date = $this->str_function_library->call('fr>AS>submission_date:ID=`'.$tbl_ID.'`');
	 				$date_1 = date('d-m-Y h:i A', strtotime($date));
	 				$topic = $this->str_function_library->call('fr>AS>topic:ID=`'.$tbl_ID.'`');
	 				$desc = $this->str_function_library->call('fr>AS>desc:ID=`'.$tbl_ID.'`');
	 				if($style === 'gateway')
	 				{
	 					$stPhones = $this->fetch_model->show(array('PH' =>array('person_ID'=>$stEmail)));
	 					$marks['studentNo'] = $stPhones[0]['phone_number'];
	 					$marks['msg'] = $subject.' Chapter : '.$lesson.' Topic : '.$topic.' Assignment Name : '.$test_name.' Submission Date '.$date_1.' Details : '.$desc.'<br><br>SUBMISSION STATUS : '.$student_inf[0]['asgn_status'].' Latency Reason : '.$student_inf[0]['late'].' Assignment Remarks : '.$student_inf[0]['remark'];
	 				}
	 				else if($style === 'email')
	 				{
	 					$marks['email'] = $this->str_function_library->call('fr>ST>Email:ID=`'.$stEmail.'`');
	 					$marks['msg'] = $subject.' Chapter : '.$lesson.' Topic : '.$topic.' Assignment Name : '.$test_name.' Submission Date '.$date_1.' Details : '.$desc.'<br><br>SUBMISSION STATUS : '.$student_inf[0]['asgn_status'].' Latency Reason : '.$student_inf[0]['late'].' Assignment Remarks : '.$student_inf[0]['remark'];
	 					$marks['sub'] = '[Paathshala Education] Assignment Submission Update | "'.$test_name.'" | Due Date "'.$date_1.'"';
	 				}
	 				else if($style === 'app')
	 				{
	 					$marks['player_ID'] = $this->str_function_library->call('fr>ST>player_ID:ID=`'.$stEmail.'`');
	 					$marks['msg'] = $subject.' Chapter : '.$lesson.' Topic : '.$topic.' Assignment Name : '.$test_name.' Submission Date '.$date_1.' Details : '.$desc.'<br><br>SUBMISSION STATUS : '.$student_inf[0]['asgn_status'].' Latency Reason : '.$student_inf[0]['late'].' Assignment Remarks : '.$student_inf[0]['remark'];
	 				}
	 				else
	 				{}
	 				return $marks;
	 				break;

	 			case 'LEC':
	 				$student_inf = $this->fetch_model->show(array('LEC'=>array('ID'=>$tbl_ID)));
	 				$marks['ID'] = $stEmail;
	 				$marks['name'] = $this->str_function_library->call('fr>ST>Name:ID=`'.$stEmail.'`').' '.$this->str_function_library->call('fr>ST>Last_name:ID=`'.$stEmail.'`');
	 				$subject_ID = $this->str_function_library->call('fr>CL>Subject:ID=`'.$student_inf[0]['class_ID'].'`');
	 				$subject = $this->str_function_library->call('fr>SB>name:ID=`'.$subject_ID.'`');
	 				$lesson = $this->str_function_library->call('fr>LS>name:ID=`'.$student_inf[0]['chapter'].'`');
	 				if($style === 'gateway')
	 				{
	 					$stPhones = $this->fetch_model->show(array('PH' =>array('person_ID'=>$stEmail)));
	 					$marks['studentNo'] = $stPhones[0]['phone_number'];
	 					$marks['msg'] = 'Dear Parent, Please Note. | Daily Class Update '.$student_inf[0]['date'].' | Sub: '.$subject.' | Chap: '.$lesson.' | Topics: '.$student_inf[0]['topic'].' | Des: '.$student_inf[0]['description'];
	 				}
	 				else if($style === 'email')
	 				{
	 					$marks['email'] = $this->str_function_library->call('fr>ST>Email:ID=`'.$stEmail.'`');
	 					$marks['msg'] = 'Dear Parent, Please Note. | Daily Class Update '.$student_inf[0]['date'].' | Sub: '.$subject.' | Chap: '.$lesson.' | Topics: '.$student_inf[0]['topic'].' | Des: '.$student_inf[0]['description'];
	 					$marks['sub'] = '[Paathshala Education] Daily Class Update '.$student_inf[0]['date'];
	 				}
	 				else if($style === 'app')
	 				{
	 					$marks['player_ID'] = $this->str_function_library->call('fr>ST>player_ID:ID=`'.$stEmail.'`');
	 					$marks['msg'] = 'Dear Parent, Please Note. | Daily Class Update '.$student_inf[0]['date'].' | Sub: '.$subject.' | Chap: '.$lesson.' | Topics: '.$student_inf[0]['topic'].' | Des: '.$student_inf[0]['description'];
	 				}
	 				else
	 				{}
	 				return $marks;
	 				break;
	 				
	 			default:
	 				$res = array();
	 				break;
	 		}
	 	}

	 	public function get_highest_marks($tbl_name = NULL, $tbl_ID = NULL)
	 	{
	 		switch ($tbl_name) {
	 			case 'TS':
	 				$marks = $this->fetch_model->show(array('TS'=>array('test_ID'=>$tbl_ID)),array('marks'));
	 				// $total = '';
	 				foreach ($marks as $keym => $valuem) {
	 					$total[] = $valuem['marks'];
	 				}
	 				// $total = rtrim($total,',');
	 				$highest = max($total);
	 				return $highest;
	 			default:
	 				$highest = NULL;
	 				return $highest;
	 				break;
	 		}
	 	}

	 	public function getPlayer($message_type = NULL, $send_type = NULL, $tbl_name = NULL, $tbl_ID = NULL)
		{
			$data=array();
			$to=explode(",",$_POST['msgto']);
			if ($_POST['typeofPerson']==='Employee') {
				foreach ($to as $key => $value) {
					$empEmail = $this->fetch_model->show(array('US' =>array('ID'=>$value)));
					$data['NOS'][] = $empEmail[0]['player_ID'];
				}
				return $data;
			}
			else
			{
				$highest = $this->get_highest_marks($tbl_name,$tbl_ID);
				foreach ($to as $key => $value) {
					$stEmail = $this->fetch_model->show(array('ST' =>array('ID'=>$value)));
					if($send_type != 'bulk')
					{
						$data['studentNo'][] = $this->getTableRecs($stEmail[0]['ID'],$tbl_name,$tbl_ID,'app',$highest);
					}
					else
					{
						$data['studentNo'][] = $stEmail[0]['player_ID'];
					}
					if ($_POST['toTypeG1'] == 'true' || $_POST['toTypeG2'] == 'true') {
						$stPhones = $this->fetch_model->show(array('GD' =>array('Student_ID'=>$value)));
						$data['gd1'][] = $gdEmail[0]['player_ID'];
						$data['gd2'][] = $gdEmail[0]['player_ID'];
					}
				}
				if ($_POST['toTypeStudent']=='true' && $_POST['toTypeG1']=='true' && $_POST['toTypeG2']=='true') {
					$dd=array_merge($data['studentNo'],$data['gd1']);
					$newMainArray['NOS']=array_merge($dd,$data['gd2']);
					return $newMainArray;
				}
				elseif ($_POST['toTypeStudent']=='true' && $_POST['toTypeG1']=='true') {
					unset($data['gd2']);
					$newMainArray['NOS']=array_merge($data['studentNo'],$data['gd1']);
					return $newMainArray;
				}
				elseif ($_POST['toTypeG1']=='true' && $_POST['toTypeG2']=='true') {
					unset($data['studentNo']);
					$newMainArray['NOS']=array_merge($data['gd1'],$data['gd2']);
					return $newMainArray;
				}
				elseif ($_POST['toTypeStudent']=='true' && $_POST['toTypeG1']=='true') {
					unset($data['gd2']);
					$newMainArray['NOS']=array_merge($data['studentNo'],$data['gd1']);
					return $newMainArray;
				}
				elseif ($_POST['toTypeStudent']=='true' && $_POST['toTypeG2']=='true') {
					unset($data['gd1']);
					$newMainArray['NOS']=array_merge($data['studentNo'],$data['gd2']);
					return $newMainArray;
				}
				elseif ($_POST['toTypeStudent']=='true') {
					unset($data['gd1']);
					unset($data['gd2']);
					$newMainArray['NOS']=$data['studentNo'];
					return $newMainArray;
				}
				elseif ($_POST['toTypeG1']=='true') {
					unset($data['studentNo']);
					unset($data['gd2']);
					$newMainArray['NOS']=$data['gd1'];
					return $newMainArray;
				}
				elseif ($_POST['toTypeG2']=='true') {
					unset($data['studentNo']);
					unset($data['gd1']);
					$newMainArray['NOS'] = $data['gd2'];
					return $newMainArray;
				}
				else
				{
					return false;
				}
			}
		}
	}
?>