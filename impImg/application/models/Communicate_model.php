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
			$this->load->model('form_model');
			$_POST['msgto']=implode(",",$_POST['msgto']);
			if ($_POST['typeofPerson']==='Employee') {
				$_POST['toTypeStudent']='no_need';
				$_POST['toTypeG1']='no_need';
				$_POST['toTypeG2']='no_need';
			}
			if ($_POST['message_type']==='email') {
				$emails = $this->getEmails();
				$addData = $this->form_model->add(array("table"=>"COMD","columns"=>$_POST));
				if ($addData) {
					$this->sendEmails($emails,$_POST['message']);
					return true;
				}
			}
			elseif ($_POST['message_type']==='mobile' || $_POST['message_type']==='gateway') {
				$numners=$this->getNumbers();
				$addData=$this->form_model->add(array("table"=>"COMD","columns"=>$_POST));
				if ($addData) {
					return array('types'=>$_POST['message_type'],'data'=>implode(',', $numners['NOS']));
					// return array('types'=>$_POST['message_type'],'data'=>$numners['NOS']);
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

		public function sendEmails($emails,$msgs)
		{
			foreach ($emails['NOS'] as $key => $value) {
				$Edata['Msg'] = $msgs;
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
	        	$this->email->subject('Welcome to Paathshala.');
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

		public function getEmails()
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
				foreach ($to as $key => $value) {
					$stEmail=$this->fetch_model->show(array('ST' =>array('ID'=>$value)));
					$data['studentEmail'][]=$stEmail[0]['Email'];
					if ($_POST['toTypeG1']=='true' || $_POST['toTypeG2']=='true') {
						$gdEmail=$this->fetch_model->show(array('GD' =>array('Student_ID'=>$value)));
						$data['gd1'][]=$gdEmail[0]['Email'];
						$data['gd2'][]=$gdEmail[1]['Email'];
					}
				}
				if ($_POST['toTypeStudent']=='true' && $_POST['toTypeG1']=='true' && $_POST['toTypeG2']=='true') {
					$dd=array_merge($data['studentEmail'],$data['gd1']);
					$newMainArray['NOS']=array_merge($dd,$data['gd2']);
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

		public function getNumbers()
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
				foreach ($to as $key => $value) {
					$stPhones=$this->fetch_model->show(array('PH' =>array('person_ID'=>$value)));
					$data['studentNo'][]=$stPhones[0]['phone_number'];
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
	 		$setting = $this->fetch_model->show(array('CMS'=>array('ID'=>$_POST['rec_id'])));
	 		$res['setting'] = $setting[0];
	 		return $res;
	 	}

	}
?>