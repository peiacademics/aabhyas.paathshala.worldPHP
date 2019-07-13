<?php
	class Student_model extends CI_Model
	{
		public function check($id=NULL,$login_as="Client")
		{
			$user = count($this->fetch_model->show(array('ST' =>array('ID'=>$id))));
			if(is_null($id))
			{
				return TRUE;
			}
			elseif($user > 0)
			{
				return TRUE;
			}
			else
			{
				$this->errorlog_library->entry('Student_model > check > argument ID is invalid.');
				redirect('Student/add/');
			}
		}

		public function add_or_edit($step,$id)
		{
			if(empty($id))
			{
				return $this->add();
			}
			else
			{
				return $this->edit($step,$id);			
			}

		}

		public function add()
		{
			$num_row1 = $_POST['num_row1'];
			$num_row2 = $_POST['num_row2'];	
			$date = $this->date_library->date2db($_POST['DOB'],$this->date_library->get_date_format());
			$_POST['DOB'] = $date;
			unset($_POST['num_row1']);
			unset($_POST['num_row2']);
			unset($_POST['CR-ID']);
			unset($_POST['PR-ID']);
			$lang = NULL;
			if(array_key_exists('language', $_POST) == TRUE)
			{
				if(($_POST['language'] == NULL) || empty($_POST['language']) || ($_POST['language'] == FALSE))
				{				
					$lang = NULL;
				}
				else
				{
					foreach ($_POST['language'] as $k => $v) {
						$lang .= $v.',';
					}
				}
			}
			$_POST['language'] = $lang;
			foreach($_POST as $key => $value)
			{
			    $exp_key = explode('-', $key);
			    if($exp_key[0] == 'PH')
			    {
			        $bt_arr[$exp_key[2]][$exp_key[1]] = $value;
			    	unset($_POST[$key]);
			    }
			    else if($exp_key[0] == 'AD')
			    {
			        $ad_arr[$exp_key[2]][$exp_key[1]] = $value;
			    	unset($_POST[$key]);
			    }
			    else if($exp_key[0] == 'PR')
			    {

			        $prevInfo[$exp_key[1]] = $value;
			    	unset($_POST[$key]);
			    }
			    else if($exp_key[0] == 'CR')
			    {
			        $curInfo[$exp_key[1]] = $value;
			    	unset($_POST[$key]);
			    }
			    else if($exp_key[0] == 'DC')
			    {
			        $docID[$exp_key[2]][$exp_key[1]] = $value;
			    	unset($_POST[$key]);
			    }
			}
			$this->load->model('form_model');
			unset($_POST['ID']);
			$_POST['document_ID'] = '';
			foreach ($docID as $key => $value) {
				$_POST['document_ID'] .= $value['document_ID'].',';
			}
			if($_POST['document_ID'] == ',')
			{
				$_POST['document_ID'] = NULL;
			}
			$curInfo['student_ID'] = $prevInfo['student_ID'] = $this->db_library->find_next_id('ST');
			if(empty($curInfo['ID']) && (!empty($curInfo['School']) || !empty($curInfo['Maths']) || !empty($curInfo['Science']) || !empty($curInfo['Per'])))
			{
				$curInfo = $this->form_model->add(array("table"=>"CI","columns"=>$curInfo));
			}
			else
			{
				$curInfo = FALSE;
			}
			if(empty($prevInfo['ID']) && (!empty($prevInfo['School']) || !empty($prevInfo['Maths']) || !empty($prevInfo['Science']) || !empty($prevInfo['Per'])))
			{
				$prevInfo = $this->form_model->add(array("table"=>"PI","columns"=>$prevInfo));
			}
			else
			{
				$prevInfo = FALSE;
			}
			if ($curInfo == TRUE && $prevInfo === TRUE) {
				$_POST['previnfo_ID'] = $this->db_library->find_max_id('PI');
				$_POST['curinfo_ID'] = $this->db_library->find_max_id('CI');
			}
			$b_add = $this->form_model->add(array("table"=>"ST","columns"=>$_POST));
			if($b_add === TRUE)
			{
				foreach($bt_arr as $key => $columns)
				{
					if($columns['phone_number'] == NULL)
					{
						$result1 = TRUE;
					}
					else
					{
						$columns['person_ID'] = $this->db_library->find_max_id('ST');
						$result1 = $this->form_model->add(array("table"=>"PH","columns"=>$columns));
					}
				}
				foreach($ad_arr as $key1 => $columns1)
				{
					if($columns1['address'] == NULL)
					{
						$result = TRUE;
					}
					else
					{
						$columns1['person_ID'] = $this->db_library->find_max_id('ST');
						$result = $this->form_model->add(array("table"=>"AD","columns"=>$columns1));
					}
				}
				if($result === true && $result1 === true)
				{
					$id = $this->db_library->find_max_id('ST');
					return $id;
				}
				else
				{
					return $result;
				}
			}
			else
			{
				return $b_add;
			}
		}

		public function edit($step,$id)
		{
			$this->load->model('form_model');
			switch ($step) {
				case 'step':
					$lang = NULL;
					if(array_key_exists('language', $_POST) == TRUE)
					{
						if(($_POST['language'] == NULL) || empty($_POST['language']) || ($_POST['language'] == FALSE))
						{				
							$lang = NULL;
						}
						else
						{
							foreach ($_POST['language'] as $k => $v) {
								$lang .= $v.',';
							}
						}
					}
					$_POST['language'] = $lang;
					$num_row1 = $_POST['num_row1'];
					$num_row2 = $_POST['num_row2'];	
					$date = $this->date_library->date2db($_POST['DOB'],$this->date_library->get_date_format());
					$_POST['DOB'] = $date;
					unset($_POST['num_row1']);
					unset($_POST['num_row2']);
					unset($_POST['num_row']);
					foreach($_POST as $key => $value)
					{
					    $exp_key = explode('-', $key);
					    if($exp_key[0] == 'PH')
					    {
					         $bt_arr[$exp_key[2]][$exp_key[1]] = $value;
					    	 unset($_POST[$key]);
					    }
					    else if($exp_key[0] == 'AD')
					    {
					         $ad_arr[$exp_key[2]][$exp_key[1]] = $value;
					    	 unset($_POST[$key]);
					    }
					    else if($exp_key[0] == 'PR')
					    {

					         $prevInfo[$exp_key[1]] = $value;
					    	 unset($_POST[$key]);
					    }
					    else if($exp_key[0] == 'CR')
					    {
					         $curInfo[$exp_key[1]] = $value;
					    	 unset($_POST[$key]);
					    }
					    else if($exp_key[0] == 'DC')
					    {
					         $docID[$exp_key[2]][$exp_key[1]] = $value;
					    	 unset($_POST[$key]);
					    }
					}
					$_POST['document_ID'] = NULL;
					foreach ($docID as $key => $value) {
						$_POST['document_ID'] .= $value['document_ID'].',';
					}
					if($_POST['document_ID'] == ',')
					{
						$_POST['document_ID'] = NULL;
					}
					if(empty($bt_arr[1]['phone_number']))
					{
						$updatePhn = true;
					}
					else{
						$updatePhn = $this->EditMultiaddData($bt_arr,'PH',$id);
					}
					if(empty($ad_arr[1]['address']))
					{
						$updateAddr = true;
					}
					else{
						$updateAddr = $this->EditMultiaddData($ad_arr,'AD',$id);
					}
					if ($updatePhn === true && $updateAddr === true) {
						if(empty($prevInfo['ID']) && empty($prevInfo['School']) && empty($prevInfo['Maths']) && empty($prevInfo['Science']) && empty($prevInfo['Per']))
						{
							$prevData = true;
						}
						else{
							$prevData = $this->EditData($prevInfo,'PI',$id);
						}
						if(empty($curInfo['ID']) && empty($curInfo['School']) && empty($curInfo['Maths']) && empty($curInfo['Science']) && empty($curInfo['Per']))
						{
							$curData = true;
						}
						else{
							$curData = $this->EditData($curInfo,'CI',$id);
						}
						if ($curData === true && $prevData === true) {
							return $this->updateMainForm($id);
						}
					}
					break;
				
				case 'step1':
					foreach($_POST as $key => $value)
					{
					    $exp_key = explode('-', $key);
					    if($exp_key[0] == 'GD')
					    {
					         $bt_arr[$exp_key[2]][$exp_key[1]] = $value;
					    	 unset($_POST[$key]);
					    }
					    else
					    	if ($exp_key[0] == 'PH') {
					    		$ph_arr[$exp_key[2]][$exp_key[1]] = $value;
					    	 	unset($_POST[$key]);
					    	}
					}
					foreach($bt_arr as $key1 => $columns1)
					{
						if(empty($columns1['ID']))
						{
							unset($columns1['ID']);
							unset($ph_arr[$key1]['phnID']);
							$columns1['Student_ID'] = $id;
							$result = $this->form_model->add(array("table"=>"GD","columns"=>$columns1));
							$ph_arr[$key1]['person_ID'] = $this->db_library->find_max_id('GD');
							if(($ph_arr[$key1]['phone_number'] != NULL) && !empty($ph_arr[$key1]['phone_number']))
							{
								$addPh = $this->form_model->add(array("table"=>"PH","columns"=>$ph_arr[$key1]));
							}
							else
							{
								$addPh = true;
							}
						}
						else
						{
							$GID = $columns1['ID'];
							unset($columns1['ID']);
							$result = $this->form_model->edit(array("table"=>"GD","columns"=>$columns1,"where"=>array('ID'=>$GID)));
							$phID = $ph_arr[$key1]['phnID'];
							unset($ph_arr[$key1]['phnID']);
							if(($ph_arr[$key1]['phone_number'] != NULL) && !empty($ph_arr[$key1]['phone_number']))
							{
								$addPh = $this->form_model->edit(array("table"=>"PH","columns"=>$ph_arr[$key1],"where"=>array('ID'=>$phID)));
							}
							else
							{
								$addPh = true;
							}
						}
					}
					if ($result === true && $addPh === true) {
						return true;
					}
					else
					{
						return $result;
					}
					break;

					case 'step2':
						$sub = NULL;
						if(array_key_exists('Subject', $_POST) == TRUE)
						{
							if(($_POST['Subject'] == NULL) || empty($_POST['Subject']) || ($_POST['Subject'] == FALSE))
							{				
								$sub = NULL;
							}
							else
							{
								foreach ($_POST['Subject'] as $k => $v) {
									$doubts = $this->form_model->add(array('table'=>'DB','columns'=>array('student_ID'=>$id,'doubts'=>'100','solved_doubts'=>'0','price'=>'0','where_from'=>'admission','description'=>'Added from Admission.','subject_ID'=>$v,'branch_ID'=>$this->str_function_library->call('fr>ST>branch_ID:ID=`'.$id.'`'),'Added_by_og'=>$this->session_library->get_session_data('ID'))));
									$sub .= $v.',';
								}
							}
						}
						$_POST['Subject'] = $sub;
						$docID = NULL;
						foreach($_POST as $key => $value)
						{
						    $exp_key = explode('-', $key);
							if($exp_key[0] == 'DC')
						    {
						         $docID[$exp_key[2]][$exp_key[1]] = $value;
						    	 unset($_POST[$key]);
						    }
						}
						$_POST['document_ID'] = NULL;
						if(($docID == NULL) || empty($docID) || ($docID == FALSE))
						{
							$_POST['document_ID'] = NULL;
						}
						else
						{
							foreach ($docID as $key => $value) {
								$_POST['document_ID'] .= $value['document_ID'].',';
							}
						}
						$_POST['Student_ID'] = $id;
						if (!empty($_POST['ID'])) {
							$result = $this->form_model->edit(array("table"=>"ADT","columns"=>$_POST,"where"=>array('ID'=>$_POST['ID'])));
						}
						else
						{
							unset($_POST['ID']);
							$result = $this->form_model->add(array("table"=>"ADT","columns"=>$_POST));
						}
						return $result;
						break;

						case 'step3':
							foreach($_POST as $key => $value)
							{
							    $exp_key = explode('-', $key);
								if($exp_key[0] == 'IN')
							    {
							         $installments[$exp_key[2]][$exp_key[1]] = $value;
							    	 unset($_POST[$key]);
							    }
							}
							if ($installments) {
								/*echo "<pre>";
								var_dump($installments);($installments[1]['date'] != 0) && ($installments[1]['amount'] != 0)
								echo "</pre>";*/
								// $_POST['reconfig']
								$conf = 0;
								foreach ($installments as $key => $value) {
									$conf++;
									if ($_POST['reconfig']>1 && $conf===1) {
									}
									else{
										$value['date'] = $this->date_library->date2db($value['date'],$this->date_library->get_date_format());
										$value['reconfig'] = $_POST['reconfig'];
										$value['Student_ID'] = $id;
										$paidStatus = $value['paid'];
										unset($value['paid']);
										if (empty($value['ID'])) {
											unset($value['ID']);
											$result = $this->form_model->add(array("table"=>"IN","columns"=>$value));
											if ($paidStatus === 'true' && $result === true) {
												$result = $this->form_model->add(array("table"=>"T","columns"=>array('transaction_type'=>'Credit','date'=>$value['date'],'amount'=>$value['amount'],'payment_mode_ID'=>$value['paymentmode'],'bank_ID'=>@$value['bank'],'other_details'=>$value['Description'],'reference_ID'=>$this->db_library->find_max_id('IN'),'referance_Name'=>$value['Student_ID'])));
											}
										}
										else
										{
											$result = $this->form_model->edit(array("table"=>"IN","columns"=>$value,"where"=>array('ID'=>$value['ID'])));
											$ispaidPresent=$this->fetch_model->show(array('T'=>array('reference_ID'=>$value['ID'])));
											if ($paidStatus==='true' && $result===true && !empty($ispaidPresent)) {
												$result = $this->form_model->edit(array("table"=>"T","columns"=>array('transaction_type'=>'Credit','date'=>$value['date'],'amount'=>$value['amount'],'payment_mode_ID'=>$value['paymentmode'],'bank_ID'=>@$value['bank'],'other_details'=>$value['Description'],'referance_Name'=>$value['Student_ID']),"where"=>array('reference_ID'=>$value['ID'])));
											}
											else if ($paidStatus==='true' && $result===true && empty($ispaidPresent))
											{
												$result = $this->form_model->add(array("table"=>"T","columns"=>array('transaction_type'=>'Credit','date'=>$value['date'],'amount'=>$value['amount'],'payment_mode_ID'=>$value['paymentmode'],'bank_ID'=>@$value['bank'],'other_details'=>$value['Description'],'reference_ID'=>$value['ID'],'referance_Name'=>$value['Student_ID'])));
											}
										}
									}
								}
								unset($_POST['reconfig']);
								if ($result) {
									$_POST['Student_ID'] = $id;
									if (empty($_POST['ID'])) {
										unset($_POST['ID']);
										$finalresult = $this->form_model->add(array("table"=>"FR","columns"=>$_POST));
									}
									else
									{
										$finalresult = $this->form_model->edit(array("table"=>"FR","columns"=>$_POST,"where"=>array('ID'=>$_POST['ID'])));
									}
									$add_doubts = $this->form_model->edit(array("table"=>"ST","columns"=>array('admStatus'=>'Active'),"where"=>array('ID'=>$id)));
									return $finalresult;
								}
							}
							/*else{
								$_POST['Student_ID'] = $id;
								if (empty($_POST['ID'])) {
									unset($_POST['ID']);
									$finalresult = $this->form_model->add(array("table"=>"FR","columns"=>$_POST));
								}
								else
								{
									$finalresult = $this->form_model->edit(array("table"=>"FR","columns"=>$_POST,"where"=>array('ID'=>$_POST['ID'])));
								}
								$this->form_model->edit(array("table"=>"ST","columns"=>array('admStatus'=>'Active'),"where"=>array('ID'=>$id)));
								return $finalresult;
							}*/
							break;
				default:
					# code...
					break;
			}

			// if ($step === 'step1') {
			// 	unset($_POST['previousBalance']);
			// 	unset($_POST['previousBalanceUnit']);
			// 	unset($_POST['quantity_produced_new']);
			// 	unset($_POST['Batch_Unit_new']);
			// 	// print_r($_POST);
			// 	$_POST['remaining_Unit'] = $_POST['waste_Unit'] =$_POST['Batch_Unit'];
			// 	$_POST['produced_date']=$this->date_library->date2db($_POST['produced_date'],$this->date_library->get_date_format());
			// 	// $_POST['batch_Status']='Processed';
			// }else 
			// if ($step === 'step2')
			// {
			// 	$_POST['packed_date']=$this->date_library->date2db($_POST['packed_date'],$this->date_library->get_date_format());
			// 	$_POST['Status']='A';
			// 	$isParentPresent=$this->fetch_model->show(array('S'=>array('reference_ID'=>$id,'Status'=>'A||P')));
			// 	if (!empty($isParentPresent))
			// 	{
			// 		foreach($_POST as $key => $value){
			// 		    $exp_key = explode('-', $key);
			// 		    if($exp_key[0] == 'S'){
			// 			    $bt_arr[$exp_key[2]][$exp_key[1]] = $value;
			// 		    	unset($_POST[$key]);
			// 		    }
			// 		}

			// 		foreach ($bt_arr as $key => $value) {
			// 			$idd=$value['ID'];
			// 			unset($value['ID']);
			// 			$b_add = $this->form_model->edit(array("table"=>"S","columns"=>$value,"where"=>array('ID'=>$idd)));
			// 		}

			// 		if ($b_add)
			// 		{
	  //                   $_POST['Status']='A';
			// 		}
			// 		else
			// 		{
			// 			return $b_add;
			// 		}
			// 	}
			// 	else
			// 	{
			// 		foreach($_POST as $key => $value){
			// 		    $exp_key = explode('-', $key);
			// 		    if($exp_key[0] == 'S'){
			// 			    $bt_arr[$exp_key[2]][$exp_key[1]] = $value;
			// 		    	unset($_POST[$key]);
			// 		    }
			// 		}

			// 		foreach ($bt_arr as $key => $value) {
			// 			$value['reference_ID']=$id;
			// 			$value['source']='Batch';
			// 			$value['date']=$_POST['packed_date'];
			// 			$b_add = $this->form_model->add(array("table"=>"S","columns"=>$value));
			// 		}
			// 		if ($b_add)
			// 		{
	  //                   $_POST['Status']='A';
			// 		}
			// 		else
			// 		{
			// 			return $b_add;
			// 		}
			// 	}
			// } 

		}

		public function updateMainForm($id)
		{
			$b_edit = $this->form_model->edit(array("table"=>"ST","columns"=>$_POST,"where"=>array('ID'=>$id)));
			if($b_edit === TRUE)
			{
				return true;
			}
			else
			{	
				return $b_edit;
			}
		}

		public function EditData($bt_arr,$tbl,$id)
		{
			if(($bt_arr['ID'] != NULL) && !empty($bt_arr['ID']))
			{
				$iddd = $bt_arr['ID'];
				unset($bt_arr['ID']);
				$b_add = $this->form_model->edit(array("table"=>$tbl,"columns"=>$bt_arr,"where"=>array('ID'=>$iddd)));
			}
			else{
				unset($bt_arr['ID']);
				$bt_arr['student_ID'] = $id;
				$b_add = $this->form_model->add(array("table"=>$tbl,"columns"=>$bt_arr));
			}
			return $b_add;
		}

		public function EditMultiaddData($bt_arr,$tbl,$id)
		{
			foreach ($bt_arr as $key => $value) {
				if (array_key_exists('ID', $value)){
					$iddd = $value['ID'];
					unset($value['ID']);
					$b_add = $this->form_model->edit(array("table"=>$tbl,"columns"=>$value,"where"=>array('ID'=>$iddd)));
				}
				else
				{
					$value['person_ID'] = $id;
					$b_add = $this->form_model->add(array("table"=>$tbl,"columns"=>$value));
				}
			}
			if ($b_add === true) {
				return true;
			}
			else
			{
				return false;
			}
		}

		public function get_details($id = NULL)
		{
			$data = array();
			if(!is_null($id))
			{                 
				$data['studentDetail'] = $this->fetch_model->show(array('ST'=>array('ID'=>$id,'Status'=>'A||P')));
				if (!empty($data['studentDetail']))
				{
					$prevDetail = $this->fetch_model->show(array('PI'=>array('ID'=>$data['studentDetail'][0]['previnfo_ID'])));
					$curDetail = $this->fetch_model->show(array('CI'=>array('ID'=>$data['studentDetail'][0]['curinfo_ID'])));
					if($prevDetail != NULL)
					{
						$data['prevDetail'] = $prevDetail[0];
					}
					else{
						$data['prevDetail'] = NULL;
					}
					if($curDetail != NULL)
					{
						$data['curDetail'] = $curDetail[0];
					}
					else{
						$data['curDetail'] = NULL;
					}
					$phone = $this->fetch_model->show(array('PH'=>array('person_ID'=>$id)));
					if($phone == NULL)
					{
						$data['List']['Phone'] = NULL;
					}
					else{
						$data['List']['Phone'] = $phone;
					}
					$address = $this->fetch_model->show(array('AD'=>array('person_ID'=>$id)));
					if($address == NULL)
					{
						$data['List']['Address'] = NULL;
					}
					else{
						$data['List']['Address'] = $address;
					}
					$doc = $this->fetch_model->get_multiadd_data('SS',trim($data['studentDetail'][0]['document_ID']));
					$data['doc'] = $doc;
					$lc = explode('/', $this->str_function_library->call('fr>SS>path:ID=`'.$data['studentDetail'][0]['lc_ID'].'`'));
					if($lc[0] == '-NA-')
					{
						$data['lc'] = NULL;
					}
					else{
						$data['lc'] = $lc[1];
					}
					$guardianDetail = $this->fetch_model->show(array('GD'=>array('Student_ID'=>$id)));
					if ($guardianDetail) {
						foreach ($guardianDetail as $key => $value) {
							$phnNo = $this->fetch_model->show(array('PH'=>array('person_ID'=>$value['ID'])));
							if($phnNo != NULL)
							{
								$guardianDetail[$key]['phone_type'] = $phnNo[0]['phone_type'];
								$guardianDetail[$key]['phone_number'] = $phnNo[0]['phone_number'];
								$guardianDetail[$key]['phnID'] = $phnNo[0]['ID'];
							}
						}
						$data['parentDetail'] = $guardianDetail;
					}
					$admissionDetail = $this->fetch_model->show(array('ADT'=>array('Student_ID'=>$id)));
					if ($admissionDetail) {
						$admsnDoc = $this->fetch_model->get_multiadd_data('SS',trim($admissionDetail[0]['document_ID']));
						$data['AdmissionDoc'] = $admsnDoc;
						$data['admissionDetail'] = $admissionDetail[0];
						$subject = explode(',', trim($data['admissionDetail']['Subject'],','));
						if (!empty($subject)) {
							foreach ($subject as $key_s => $value_s) {
								$data['doubts'][ $value_s]= $this->fetch_model->show(array('DB'=>array('student_ID'=>$id,'subject_ID'=>$value_s)));
								if ($data['doubts'][ $value_s]) {
									foreach ($data['doubts'][ $value_s] as $kr => $vr) {
										$raised= $this->fetch_model->show(array('DR'=>array('doubt_ID'=>$vr['ID'])));
										$data['doubts'][ $value_s][$kr]['Raised']=$raised;
									}
								}
							}
						}
						else
						{
							$data['doubts']=array();
						}
					}
					$fees = $this->fetch_model->show(array('FR'=>array('Student_ID'=>$id)));
					if ($fees) {
						$installments=$this->fetch_model->show(array('IN'=>array('Student_ID'=>$id)));
						$installments1 = array();
						foreach ($installments as $key => $value) {
							$issTransaction = $this->fetch_model->show(array('T'=>array('reference_ID'=>$value['ID'])));
							if ($issTransaction) {
								$value['isTransaction']=$issTransaction[0]['ID'];
							}
							else
							{
								$value['isTransaction']='';
							}
							if (array_key_exists($value['reconfig'], $installments1)) {
								$installments1[$value['reconfig']][] = $value;
							}
							else
							{
								$installments1[$value['reconfig']][] = $value;
							}
						}
						$fees[0]['installments']=$installments1;
						$data['fees']=$fees[0];
					}
				}


				// $data['doubts'] = $this->fetch_model->show(array('DB'=>array('student_ID'=>$id,'where_from'=>'admission')));


				// $adm_dt_into = array();
				// foreach ($data['doubts'] as $key_adm => $value_adm) {
				// 	$adm_dt_into = $this->fetch_model->show(array('DR'=>array('doubt_ID'=>$value_adm['ID'])));
				// 	// $data['doubts']['admission'][$key_adm]['adm_info'] = $adm_dt_into;
				// }
			}
			return $data;
		}

		public function delete_Field($id)
		{
			$this->load->model('form_model');
			if ($type === 'phone') {
				$result = $this->form_model->delete(array('PH' => array('ID' => $id)));
			}
			else
			{
				$result = $this->form_model->delete(array('AD' => array('ID' => $id)));
			}
			return $result;
		}

		public function delete_File($id,$Student)
		{
			$this->load->model('form_model');
			$result=$this->form_model->delete(array('SS' => array('ID' => $id)));
			$docID = $this->str_function_library->call('fr>ST>document_ID:ID=`'.$Student.'`');
			if ($docID) {
				$docID=explode(',',trim($docID,','));
				$doc='';
				foreach ($docID as $key => $value) {
					if ($value!==$id) {
						$doc .=$value.',';
					}
				}
				$b_add = $this->form_model->edit(array("table"=>'ST',"columns"=>array('document_ID'=>$doc),"where"=>array('ID'=>$Student)));
				return $b_add;
			}
			else
			{
				return 'Something Went Wrong';
			}
			echo $docID;
		}

	public function upload_AnyFile()
    {
       	if(!empty($_FILES))
    	{
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
	        	$path = 'upload/'.$file_name;
	        	if($this->form_model->add(array('table'=>'SS','columns'=>array('path'=>'upload/'.$file_name,'description'=>'Deepak','date'=>date('Y-m-d h:i:s')))))
	        	{
	        		return $this->db_library->find_max_id('SS');
	        	}
	        	else{
	        		return false;
	        	}
	        }
	    }
	    else{
	    	return false;
	    }
    }

    public function addInstallments()
    {
    	print_r($_POST);
   //  	if (empty($value['ID'])) {
			// unset($value['ID']);
		// $result = $this->form_model->add(array("table"=>"IN","columns"=>$_POST));
		// }
		// else
		// {
		// 	$result = $this->form_model->edit(array("table"=>"IN","columns"=>$value,"where"=>array('ID'=>$value['ID'])));
		// }
    }

    public function make_solved_doubt()
  	{
  		$this->load->model('form_model');

  		$result = $this->form_model->add(array('table'=>'DR','columns'=>array('student_ID'=>$_POST['studentID'],'doubt_ID'=>$_POST['doubt_ID'],'doubt_status'=>'raised','branch_ID'=>$_POST['branch_ID'],'subject_ID'=>$_POST['subject_ID'],'Added_by_og'=>$this->session_library->get_session_data('ID'))));
			if($result == TRUE)
			{
		  		$raised_doubts = $this->fetch_model->show(array('DB'=>array('ID'=>$_POST['doubt_ID'])),array('raised_doubts'));
		  		$doubts_asked = $raised_doubts[0]['raised_doubts'];
		  		$doubts_asked++;
				$result = $this->form_model->edit(array("table"=>"DB","columns"=>array('raised_doubts'=>$doubts_asked),"where"=>array('ID'=>$_POST['doubt_ID'])));
	  		}
	  		else
	  		{
	  			$result = FALSE;
	  		}
  		return $result;
  	}

  	public function add_doubts()
  	{

  		$this->load->model('form_model');
  		$_POST['branch_ID'] = $_POST['branch_ID_modal'];
  		unset($_POST['branch_ID_modal']);
  		$result = $this->form_model->add(array('table'=>'DB','columns'=>$_POST));
  		if($result == TRUE)
  		{
  			$max_ID = $this->db_library->find_max_id('DB');
  			$data = $this->fetch_model->show(array('DB'=>array('ID'=>$max_ID)));
  			if($data[0]['price'] > 0)
  			{
  				$transaction_add = $this->form_model->add(array("table"=>"T","columns"=>array('transaction_type'=>'Credit','date'=>$data[0]['Added_on'],'amount'=>$data[0]['price'],'payment_mode_ID'=>'PMSK10000001','other_details'=>'Sold doubts to Student','reference_ID'=>$data[0]['ID'],'referance_Name'=>$data[0]['student_ID'])));
  			}
  			$data[0]['buy']=$this->str_function_library->call('fr>US>Name:ID=`'.$data[0]['Added_by_og'].'`');
  			return $data[0];
  		}
  		else
  		{
  			return $result;
  		}
  	}

  	public function get_branchwise_students($branch_ID = NULL)
  	{
  		if(!empty($_POST))
  		{
	  		if($_POST['batch_ID'] == 'other')
	  		{
	  			$student_IDs = $this->fetch_model->show(array('ADT'=>array('Batch'=>'')),array('student_ID'));
	  		}
	  		else
	  		{
	  			$student_IDs = $this->fetch_model->show(array('ADT'=>array('Batch'=>$_POST['batch_ID'])),array('student_ID'));
	  		}
	  	}
	  	else{
	  		if($this->session_library->get_session_data('Login_as') == 'DSSK10000012')
	  		{
	  			$student_IDs = $this->fetch_model->show(array('ADT'=>array('student_ID'=>$this->session_library->get_session_data('student_ID'))),array('student_ID'));
	  		}
	  		else{
		  		$student_IDs = $this->fetch_model->show(array('ADT'=>array('student_ID'=>$this->session_library->get_session_data('ID'))),array('student_ID'));
		  	}

	  	}
  	  	if(($student_IDs != NULL) && !empty($student_IDs) && ($student_IDs != FALSE))
	  	{
			$students = array();
	  		foreach ($student_IDs as $key => $value) {
	  			$student = $this->fetch_model->show(array('ST'=>array('ID'=>$value['student_ID'])),array('ID','Added_by','Name','Middle_name','Last_name','branch_ID','img_ID','chat_mute'));
	  			// var_dump($branch_ID);
	  			// var_dump($student);
	  			if($student[0]['branch_ID'] == $branch_ID)
	  			{
		  			$students[$key] = $student[0];
		  			$students[$key]['path'] = $this->str_function_library->call('fr>SS>path:ID=`'.$student[0]['img_ID'].'`');
		  			$adm_details = $this->fetch_model->show(array('ADT'=>array('Student_ID'=>$student[0]['ID'])));
		  			if(!empty($adm_details))
		  			{
		  				$subject = explode(',',trim($adm_details[0]['Subject'],','));
		  				// print_r($subject);
		  				$teach = array();
		  				$teach[] = $value['student_ID'];
		  				foreach ($subject as $sk => $sv) {
		  					$teacher = $this->fetch_model->show(array('US'=>array('subject_ID LIKE '=>'%'.$sv.'%')));
		  					if(!empty($teacher))
		  					{
		  						foreach ($teacher as $tk => $tv) {
		  							if(!in_array($tv['ID'],$teach))
		  							{
		  								$teach[] = $tv['ID'];
		  							}
		  						}
		  					}
		  				}
		  				$parents = $this->fetch_model->show(array('GD'=>array('Student_ID'=>$student[0]['ID'])));
		  				if(!empty($parents))
		  				{
		  					foreach ($parents as $pk => $pv) {
		  						$teach[] = $pv['ID'];
		  					}
		  				}
		  				$br = $this->str_function_library->call('fr>US>ID:branch_ID=`'.$student[0]['branch_ID'].'`,Type=`DSSK10000002`');
		  				$sa = $this->str_function_library->call('fr>US>ID:Type=`DSSK10000001`');
		  				if($br!='-NA-') { $teach[] = $br; }
		  				if($sa!='-NA-') { $teach[] = $sa; }
		  			}
		  			$students[$key]['group_IDs'] = implode(',',$teach);
		  		}
				// print_r($teacher);
				// print_r(array($student[0]['ID']=>$teach));
	  		}
	  	}
	  	else
	  	{
	  		$students = NULL;
	  	}
  		// var_dump($students);
  		return $students;
  	}

  	public function get_chats()
  	{
  		//print_r($_POST);
  		$this->load->model('form_model');
  		if(array_key_exists('student_ID',$_POST) && !empty($_POST['student_ID']))
  		{
	  		$data = $this->fetch_model->show(array('CH'=>array('branch_ID'=>$_POST['branch_ID'],'group_IDs LIKE '=>'%'.$this->session_library->get_session_data('ID').'%','group_IDs LIKE '=>'%'.$_POST['student_ID'].'%')),'*',array('ORDER'=>array('Added_on','DESC'),'LIMITS'=>array($_POST['len'],$_POST['start'])));
	  		if(!empty($data))
	  		{
		  		foreach ($data as $key => $value){
		  			$make_read = $this->form_model->edit(array("table"=>"CV","columns"=>array('chat_status'=>'read'),"where"=>array('chat_ID'=>$value['ID'],'member_ID'=>$this->session_library->get_session_data('ID'))));
		  			$ex = explode('SK',$value['from_ID']);
		  			//var_dump($ex);
		  			if($ex[0] == 'US')
		  			{
		  				// $img_id = $this->str_function_library->call('fr>US>Image_ID:ID=`'.$value['from_ID'].'`');
		  				// $data[$key]['image'] = $this->str_function_library->call('fr>SS>path:ID=`'.$img_id.'`');
		  				$data[$key]['image'] = '/img/logo.jpg';
		  				$user = $this->str_function_library->call('fr>US>Name:ID=`'.$value['from_ID'].'`');
		  				$dsgn = $this->str_function_library->call('fr>US>Type:ID=`'.$value['from_ID'].'`');
		  				$dsg = $this->str_function_library->call('fr>DS>post:ID=`'.$dsgn.'`');
		  				// $data[$key]['who'] = $user.' ('.$dsg.') ';
		  				$data[$key]['who'] = 'Paathshala (Admin)';
		  			}
		  			else if($ex[0] == 'ST')
		  			{
		  				$img_id = $this->str_function_library->call('fr>ST>img_ID:ID=`'.$value['from_ID'].'`');
		  				$data[$key]['image'] = $this->str_function_library->call('fr>SS>path:ID=`'.$img_id.'`');
		  				$data[$key]['who'] = $this->str_function_library->call('fr>ST>Name:ID=`'.$value['from_ID'].'`').' (Student)';
		  			}
		  			else{
		  				$data[$key]['image'] = 'img/user.jpg';
		  				$data[$key]['who'] = $this->str_function_library->call('fr>GD>Name:ID=`'.$value['from_ID'].'`').' (Guardian)';
		  			}
		  			if($value['from_ID'] == $this->session_library->get_session_data('ID'))
		  			{
		  				$data[$key]['position'] = 'right';
		  				$data[$key]['who'] = 'Me';
		  			}
		  			else{
		  				$data[$key]['position'] = 'left';
		  			}
	  			}
	  			return array_reverse($data);
	  		}
	  		else{
	  			return array();
	  		}
	  	}
	  	else{
	  		return array();
	  	}
	}

	public function send_msg()
  	{
  		$this->load->model('form_model');
  		$_POST['from_ID'] = $this->data['Login']['ID'];
  		$query = $this->form_model->add(array('table'=>'CH','columns'=>$_POST));
  		if($query == TRUE)
  		{
  			$member_IDs = explode(',', $_POST['group_IDs']);
  			$chat_ID = $this->db_library->find_max_id('CH');
  			foreach ($member_IDs as $key => $value) {
  				if($value == $_POST['from_ID'])
  				{
  					$chat_status = 'read';
  				}
  				else
  				{
  					$chat_status = 'unread';
  				}
  				$chat_visit = $this->form_model->add(array('table'=>'CV','columns'=>array('chat_ID'=>$chat_ID,'member_ID'=>$value,'chat_status'=>$chat_status,'group_IDs'=>$_POST['group_IDs'])));
  			}
  		}
  		return $query;
  	}

  	public function get_chat_notification()
  	{
  		$unread_mess = $this->fetch_model->show(array('CV'=>array('member_ID'=>$_POST['member_ID'],'chat_status'=>'unread')),array('count(ID) as cnt_ur'));
  		$unread_grs = $this->fetch_model->show(array('CV'=>array('member_ID'=>$_POST['member_ID'],'chat_status'=>'unread')),array('count(ID) as cnt_gr','group_IDs'),array('GROUP_BY'=>array('group_IDs')));
  		$data = array();
  		$mess = $unread_mess[0]['cnt_ur'];
  		if(!empty($unread_mess) && !empty($unread_grs))
  		{
	  		foreach ($unread_grs as $key => $value) {
	  			if(strpos($value['group_IDs'], 'STSK') !== FALSE)
	  			{
	  				$group_IDs = $value['group_IDs'];
	  				$members = explode(',', $value['group_IDs']);
	  				$chat_mute = $this->str_function_library->call('fr>ST>chat_mute:ID=`'.$members[0].'`');
	  				if($chat_mute != 'yes')
	  				{
						$data['rec'][$key]['student_ID'] = $members[0];
						$data['rec'][$key]['group_IDs'] = $group_IDs;
						$data['rec'][$key]['branch_ID'] = $this->str_function_library->call('fr>ST>branch_ID:ID=`'.$members[0].'`');
						$data['rec'][$key]['cnt'] = $value['cnt_gr'];
						$data['rec'][$key]['student'] = $this->str_function_library->call('fr>ST>Name:ID=`'.$members[0].'`').' '.$this->str_function_library->call('fr>ST>Middle_name:ID=`'.$members[0].'`').' '.$this->str_function_library->call('fr>ST>Last_name:ID=`'.$members[0].'`');
					}
					else
					{
						$unread_stu = $this->fetch_model->show(array('CV'=>array('member_ID'=>$_POST['member_ID'],'chat_status'=>'unread','group_IDs LIKE'=>'%'.$members[0].'%')),array('count(ID) as cnt_stu'));
						$mess = $mess - $unread_stu[0]['cnt_stu'];
					}
	  			}
	  		}
	  		$data['count'] = $mess;
	  	}
	  	else
	  	{
	  		$data['count'] = 0;
	  		$data['rec'] = 0;
	  	}
  		return $data;
  	}

  	public function get_chat_student()
  	{
  		$gr_ids = $this->fetch_model->show(array('CV'=>array('member_ID'=>$_POST['student_ID'])));
  		$rec['group_IDs'] = $gr_ids[0];
  		$batch_ID = $this->str_function_library->call('fr>ADT>Batch:ID=`'.$_POST['student_ID'].'`');
  		if(($batch_ID != NULL) && !empty($batch_ID) && ($batch_ID != FALSE) && ($batch_ID != '-NA-'))
  		{
  			$rec['batch_ID'] = $batch_ID;
  			$rec['batch_name'] = $this->str_function_library->call('fr>BT>name:ID=`'.$batch_ID.'`');
  		}
  		else
  		{
  			$rec['batch_ID'] = 'other';
  			$rec['batch_name'] = 'Other';
  		}
  		$image = $this->str_function_library->call('fr>ST>img_ID:ID=`'.$_POST['student_ID'].'`');
  		$img_path = $this->str_function_library->call('fr>SS>path:ID=`'.$image.'`');
  		$rec['student_name'] = '<img class="chat-avatar" src="'.base_url($img_path).'" alt="Student">'.' '.$this->str_function_library->call('fr>ST>Name:ID=`'.$_POST['student_ID'].'`').' '.$this->str_function_library->call('fr>ST>Middle_name:ID=`'.$_POST['student_ID'].'`').' '.$this->str_function_library->call('fr>ST>Last_name:ID=`'.$_POST['student_ID'].'`');
  		return $rec;
  	}

  	public function change_mute()
  	{
  		$this->load->model('form_model');
  		if($_POST['status'] == 'checked')
  		{
  			$res = $this->form_model->edit(array("table"=>"ST","columns"=>array('chat_mute'=>'yes'),"where"=>array('ID'=>$_POST['student_ID'])));
  		}
  		else
  		{
  			$res = $this->form_model->edit(array("table"=>"ST","columns"=>array('chat_mute'=>'no'),"where"=>array('ID'=>$_POST['student_ID'])));
  		}
  		return $res;
  	}
}
?>