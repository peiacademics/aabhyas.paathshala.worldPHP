<?php
	class Transaction_model extends CI_Model
	{
		public function check($id=NULL,$login_as="Client")
		{
			if (strpos($id,'CT') !== false) 
			{
				$user = count($this->fetch_model->show(array('CT' =>array('ID'=>$id))));
			}
			else
			{
				$user = count($this->fetch_model->show(array('T' =>array('ID'=>$id))));
			}
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
				$this->errorlog_library->entry('Transaction_model > check > argument id is invalid.');
				redirect('transaction/add/');
			}
		}

		public function get_reference($expense_id = NULL)
		{
			if(!is_null($expense_id))
			{
				$res = array();
				$my_config = $this->config->item('skyq');
				if($my_config['Teacher_Debit'] == $expense_id)
				{
					$tbl = 'US';
					$type = 'Employee';
				}
				else if($my_config['Student_Credit'] == $expense_id)
				{
					$tbl = 'ST';
					$type = 'Student';
				}
				else if($my_config['Contra'] == $expense_id)
				{
					$tbl = 'BA';
					$type = 'Bank';
				}
				else
				{
					return TRUE;
				}
				if(isset($tbl))
				{
					if ($tbl == 'US') 
					{
						return $res=array($type => $this->fetch_model->show(array($tbl=>array('Type !='=>'DSSK10000001'))));	
					}
					else
					{
						return $res=array($type => $this->fetch_model->show($tbl));
					}
				}
			}
			else
			{
				$this->errorlog_library->entry('Transaction_model > get_reference > argument expense_id is null.');
				return FALSE;
			}
		}

		public function get_reference_bill($reference = NULL)
		{
			if(!is_null($reference))
			{
				$res = array();
				$my_config = $this->config->item('skyq');
				$cache = explode($my_config['seperator'], $reference);
				/*echo "<pre>";
				var_dump($cache);
				echo "</pre>";*/
				if($cache[0] == 'V')
				{
					$where = array('vendor_ID'=>$reference);
					$res['Bill'] = $this->fetch_model->show(array('PU'=>$where));
					return $res;
				}
				else if($cache[0] == 'C')
				{
					$where = array('customer_ID'=>$reference,'bill_type'=>'Invoice');
					$res['Bill'] = $this->fetch_model->show(array('B'=>$where));
					$res['AMC'] = $this->fetch_model->show(array('A'=>array('customer_ID'=>$reference)));
					return $res;
				}
				else
				{
					return TRUE;
				}
			}
			else
			{
				$this->errorlog_library->entry('Transaction_model > get_reference_bill > argument reference is null.');
				return FALSE;
			}
		}

		public function add_or_edit($branch_ID = NULL)
		{
			$_POST['date'] = $this->date_library->date2db($_POST['date'],$this->date_library->get_date_format());
			if(isset($_POST['reference_ID']))
			{
				if(empty($_POST['reference_ID']))
				{
					$_POST['reference_ID'] = NULL;
				}
				else
				{
					$_POST['referance_Name'] = $_POST['reference_ID'];
					// $_POST['reference_ID'] = $_POST['reference_ID_1'];
					unset($_POST['reference_ID']);
				}
			}
			else
			{
				$_POST['reference_ID'] = NULL;
				$_POST['referance_Name'] = 'Other';
			}
			if(empty($_POST['ID']))
			{
				return $this->add($branch_ID);
			}
			else
			{
				return $this->edit($branch_ID);				
			}
		}


		public function add($branch_ID)
		{
			$this->load->model('form_model');
			unset($_POST['ID']);
			if($branch_ID != NULL)
			{		
				$_POST['branch_ID'] = $branch_ID;
			}
			if (strpos($_POST['referance_Name'],'BA') !== false) 
			{
				unset($_POST['month_year']);
				unset($_POST['salary']);
				$b_add = $this->form_model->add(array("table"=>"CT","columns"=>$_POST));
			}
			else
			{
				if ($_POST['referance_Name'] == 'Other') 
				{
					unset($_POST['referance_Name']);
				}
				$b_add = $this->form_model->add(array("table"=>"T","columns"=>$_POST));
			}
			// $this->addtimeline($_POST);
			if ($_POST['transaction_type']==='Credit')
			{
				// $checkStatus=$this->checkStatus($_POST);
			}
			return $b_add;
		}

		public function edit($branch_ID)
		{
			$this->load->model('form_model');
			if($branch_ID != NULL)
			{		
				$_POST['branch_ID'] = $branch_ID;
			}
			if (strpos($_POST['referance_Name'],'BA') !== false) 
			{
				$b_edit = $this->form_model->edit(array("table"=>"CT","columns"=>$_POST,"where"=>array('ID'=>$_POST['ID'])));
			}
			else
			{
				if ($_POST['referance_Name'] == 'Other') 
				{
					unset($_POST['referance_Name']);
				}
				$b_edit = $this->form_model->edit(array("table"=>"T","columns"=>$_POST,"where"=>array('ID'=>$_POST['ID'])));
			}
			return $b_edit;
		}
		
		public function addtimeline($data)
		{
			$t_ID = $this->db_library->find_max_id('T');
			if ($data['payment_mode_ID']==='PMSK10000001') {
				$desc= $data['transaction_type'].' Transaction made on '.$this->date_library->db2date($data['date'],$this->date_library->get_date_format()).' through '.$this->str_function_library->call('fr>PM>title:ID=`'.$data['payment_mode_ID'].'`');
			}
			else
			{
				$bank=$this->fetch_model->show(array('BA'=>array('ID'=>$data['bank_ID'])));
				$desc= $data['transaction_type'].' Transaction made on '.$this->date_library->db2date($data['date'],$this->date_library->get_date_format()).' through '.$this->str_function_library->call('fr>PM>title:ID=`'.$data['payment_mode_ID'].'`').' from '.$bank[0]['bank_name'].' '.$bank[0]['branch_name'].' with acc no '.$bank[0]['account_no'];
			}
			
			$t_add = $this->form_model->add(array("table"=>"LT","columns"=>array('title'=>'<a target="_blank" href='.base_url('transaction/view/'.$t_ID).'><code>'.$this->data['Login']['Name'].'</code> Creates Transaction of Rs. <span class="text-navy">'.$_POST['amount'].'</span></a>','heading_status'=>'Main','lead_ID'=>$data['referance_Name'],'reference_ID'=>$t_ID,'description'=>$desc)));
			if ($t_add === TRUE) 
			{
				return true;
			}
		}
		

		public function checkStatus()
		{
			//$seprt=explode(',', $_POST['reference_ID']);
			$billID = $_POST['reference_ID'];//trim($seprt[1]);
			$billDetails=$this->fetch_model->show(array('B'=>array('ID'=>$billID)));
			if ($billDetails)
			{
				$grand_total=$billDetails[0]['grand_total'];
				$c2 = $this->fetch_model->show(array('T'=>array('reference_ID LIKE'=>'%'.$billID.'%')),'sum(amount)');
				$amount=$c2[0]['sum(amount)'];
				$balance=$grand_total-$amount;
				if ($balance <= 0)
				{
					$b_edit = $this->form_model->edit(array("table"=>"B","columns"=>array('bill_Category'=>'AutoPaid'),"where"=>array('ID'=>$billID)));
					if ($b_edit)
					{
						return TRUE;
					}
					else
					{
						return FALSE;
					}
				}
			}
		}

		public function get_show_data($input,$output)
		{
		 	$this->load->library('datatable_library');
	 		return $this->datatable_library->get_data($input,$output);
		}

		public function get_details($id = NULL)
		{
			$data = array();
			$trs = explode('SK', $id);
			if($trs[0] != 'BR')
			{
				if(!is_null($id))
				{
					$data['What'] = 'Edit'; 
					if (strpos($id,'CT') !== false) 
					{
						$data['View'] = $this->fetch_model->show(array('CT'=>array('ID'=>$id)));
					}
					else
					{
						$data['View'] = $this->fetch_model->show(array('T'=>array('ID'=>$id)));
					}

					if (strpos($data['View'][0]['referance_Name'], 'CSK') !== false) {
					    $data['Persn']=$this->fetch_model->show(array('C'=>array('ID'=>$data['View'][0]['referance_Name'])));
					}
					else
					{
						 $data['Persn']=$this->fetch_model->show(array('V'=>array('ID'=>$data['View'][0]['referance_Name'])));
					}
					$res = (!is_null($data['View'][0]['referance_Name'])) ? explode(',',$data['View'][0]['referance_Name']) : FALSE;
					if($res !== FALSE)
					{
						if(!empty($res[0]))
						{
							$data['Bill'] = $this->get_reference_bill($res[0]);
							//$data['Reference2'] = $res[1];
						}
						$data['Reference'] = $this->get_reference($data['View'][0]['expence_category_ID']);
						$data['Reference1'] = $res[0];
					}
				}
			}
			$av = $this->session_library->get_session_data('ID');
			$data['User'] = $this->fetch_model->show(array('US'=>array('ID'=>$av)));
			
			$cid = $data['User'][0]['currency_ID'];
			if (!empty($cid)) 
			{
				$data['Currency'] = $this->fetch_model->show(array('CU'=>array('ID'=>$cid)));
				if(empty($data['Currency'][0]['symbol']))
				{
					$data['Currency'][0]['symbol'] = $data['Currency'][0]['title'];
				}
			}
			$data['View2']= $this->fetch_model->show(array('T'=>array('ID'=>$id)),array('ID','transaction_type','amount','other_details','month_year','salary','>>Date:>fn>library>date_library:db2date(^date^)','>>Payment:>fr>PM>title:ID=^payment_mode_ID^','>>bank:>fr>BA>bank_name:ID=^bank_ID^','>>Expence:>fr>EC>title:ID=^expence_category_ID^'));
			$data['Payment'] = $this->fetch_model->show('PM',array('ID','title'));
			$data['Bank'] = $this->fetch_model->show('BA',array('ID','bank_name','branch_name'));
			$data['Expence'] = $this->fetch_model->show('EC',array('ID','title'));
			$data['Branch'] = $this->fetch_model->show('BR',array('ID','name'));
			return $data;
		}


		public function getTransactions($branch_ID = NULL)
		{
			if (!empty($_POST['dateRange']))
			{
				$date = explode('to', $_POST['dateRange']);
				$start = $this->date_library->date2db(trim($date[0]),'m/d/Y');
				$end = $this->date_library->date2db(trim($date[1]),'m/d/Y');
				if($branch_ID === NULL)
				{
					$res = $this->fetch_model->show(array('T'=> array('date >='=>$start,'date <'=>$end,'transaction_type LIKE'=>'%'.@$_POST['transaction_type'].'%','other_details LIKE'=>'%'.@$_POST['Search'].'%','reference_ID'=>NULL)),array('transaction_type','amount','>>Date:>fn>library>date_library:db2date(^date^)','>>Payment:>fr>PM>title:ID=^payment_mode_ID^','>>Expence:>fr>EC>title:ID=^expence_category_ID^','other_details','referance_Name','branch_ID','ID'));
				}
				else
				{
					$res = $this->fetch_model->show(array('T'=> array('date >='=>$start,'date <'=>$end,'transaction_type LIKE'=>'%'.@$_POST['transaction_type'].'%','other_details LIKE'=>'%'.@$_POST['Search'].'%','reference_ID'=>NULL,'branch_ID'=>$branch_ID)),array('transaction_type','amount','>>Date:>fn>library>date_library:db2date(^date^)','>>Payment:>fr>PM>title:ID=^payment_mode_ID^','>>Expence:>fr>EC>title:ID=^expence_category_ID^','other_details','referance_Name','branch_ID','ID'));
				}
			}
			else
			{
				if($branch_ID === NULL)
				{
					$res = $this->fetch_model->show(array('T'=>array('other_details LIKE'=>'%'.@$_POST['Search'].'%')),array('transaction_type','amount','>>Date:>fn>library>date_library:db2date(^date^)','>>Payment:>fr>PM>title:ID=^payment_mode_ID^','>>Expence:>fr>EC>title:ID=^expence_category_ID^','other_details','referance_Name','branch_ID','ID'));
					/*=> array('transaction_type LIKE'=>'%'.@$_POST['transaction_type'].'%','reference_ID'=>NULL)*/
				}
				else
				{
					$res = $this->fetch_model->show(array('T'=> array('branch_ID'=>$branch_ID)),array('transaction_type','amount','>>Date:>fn>library>date_library:db2date(^date^)','>>Payment:>fr>PM>title:ID=^payment_mode_ID^','>>Expence:>fr>EC>title:ID=^expence_category_ID^','other_details','referance_Name','branch_ID','ID'));
					// var_dump($res);
					/*'transaction_type LIKE'=>'%'.@$_POST['transaction_type'].'%','other_details LIKE'=>'%'.@$_POST['Search'].'%','reference_ID'=>NULL,*/
				}
			}
			$this->actions_config = $this->config->item('actions');
			if (!empty($res))
			{
				foreach ($res as $key => $value)
				{
					$res[$key]['Link'] = "<div>";
		 			foreach($this->actions_config['T'] as $action)
		 			{
		 				if(array_key_exists('function', $action))
		 				{
				 			$res[$key]['Link'] .= "<span class='label label-".$action['class']."' onClick=".$action['function']."('".$value['ID']."')><i class='fa fa-".$action['icon']." bigger-130'></i></span>&nbsp;&nbsp;";
		 				}
		 				else
		 				{
		 					if($action['icon']=="print" || $action['icon']=="download")
	 						{
	 							if ($value['transaction_type']==='Credit') {
	 								$res[$key]['Link'] .= "<a class='label label-".$action['class']."' href='#' onclick='window.open(\"".base_url($action['link'].$value['ID'])."\",\"_blank\",\"toolbar=yes, scrollbars=yes, resizable=yes, left=500, width=900, height=800\")'><i class='fa fa-".$action['icon']." bigger-130'></i></a>&nbsp;&nbsp;";
	 							}
	 							else
	 							{
	 								$res[$key]['Link'] .='';
	 							}
	 							
	 						}
		 					else if($action['class']=="red")
		 					{
		 						$res[$key]['Link'] .= "<span class='label label-danger ".$action['class']."' id='item".$value['ID']."' onClick='deletef(\"".$value['ID']."\",\"".base_url($action['link'].$value['ID'])."\")'><i class='fa fa-".$action['icon']." bigger-130'></i></span>&nbsp;&nbsp;";
		 					}
		 					else
		 					{
		 						$res[$key]['Link'] .= "<a class='label label-".$action['class']."' href=".base_url($action['link'].$value['branch_ID'].'/'.$value['ID'])."><i class='fa fa-".$action['icon']." bigger-130'></i></a>&nbsp;&nbsp;";
		 					}

		 				}
		 				unset($res[$key]['branch_ID']);
			 			unset($res[$key]['ID']);
			 		}
		 		$res[$key]['Link'] .= "</div>";
		    	}

	    		foreach ($res as $key => $value)
				{
					$d[]= array_values($value);
				}
				$data['data']=$d;
				foreach ($d as $key => $value) 
				{
					if (strrpos($value[3], 'US') !== false) 
					{
						$cid = $this->fetch_model->show(array('US'=>array('ID'=>$value[3])));
						$d[$key][2] = $cid[0]['Name'];
					}
					else if (strrpos($value[3], 'ST') !== false) 
					{
						$cid = $this->fetch_model->show(array('ST'=>array('ID'=>$value[3])));
						$d[$key][2] = $cid[0]['Name'];
					}
					else if (strrpos($value[3], 'BA') !== false) 
					{
						$cid = $this->fetch_model->show(array('BA'=>array('ID'=>$value[3])));
						$d[$key][2] = $cid[0]['bank_name'];
					}
					else
					{
						// $cid = $this->fetch_model->show(array('V'=>array('ID'=>$value[3])));
						$d[$key][2] = '-NA-';	
					}
					$d[$key][0]=$value[4];
					$d[$key][1]=$value[6];
					$d[$key][3]=$value[5];
					if ($value[0] !== 'Debit') 
					{
						$d[$key][4] = $value[1];
						$d[$key][5] = 0;
					}
					else
					{
						$d[$key][4] = 0;
						$d[$key][5] = $value[1];
					}
					$d[$key][6] = $value[2];

				}
				return json_encode($d);
			}
			else
			{
				return json_encode($res);
			}
		}

		public function getcontraTransactions($branch_ID = NULL)
		{
			if (!empty($_POST['dateRange']))
			{
				$date=explode('to', $_POST['dateRange']);
				$start=$this->date_library->date2db(trim($date[0]),'m/d/Y');
				$end=$this->date_library->date2db(trim($date[1]),'m/d/Y');
				if($branch_ID === NULL)
				{
					$res = $this->fetch_model->show(array('CT'=> array('date >='=>$start,'date <'=>$end,'transaction_type LIKE'=>'%'.@$_POST['transaction_type'].'%','other_details LIKE'=>'%'.@$_POST['Search'].'%','reference_ID'=>NULL)),array('transaction_type','amount','>>Date:>fn>library>date_library:db2date(^date^)','>>Payment:>fr>PM>title:ID=^payment_mode_ID^','>>Expence:>fr>EC>title:ID=^expence_category_ID^','other_details','referance_Name','branch_ID','ID'));
				}
				else
				{
					$res = $this->fetch_model->show(array('CT'=> array('date >='=>$start,'date <'=>$end,'transaction_type LIKE'=>'%'.@$_POST['transaction_type'].'%','other_details LIKE'=>'%'.@$_POST['Search'].'%','reference_ID'=>NULL,'branch_ID'=>$branch_ID)),array('transaction_type','amount','>>Date:>fn>library>date_library:db2date(^date^)','>>Payment:>fr>PM>title:ID=^payment_mode_ID^','>>Expence:>fr>EC>title:ID=^expence_category_ID^','other_details','referance_Name','branch_ID','ID'));
				}
			}
			else
			{
				if($branch_ID === NULL)
				{
					$res = $this->fetch_model->show(array('CT'=> array('transaction_type LIKE'=>'%'.@$_POST['transaction_type'].'%','other_details LIKE'=>'%'.@$_POST['Search'].'%','reference_ID'=>NULL)),array('transaction_type','amount','>>Date:>fn>library>date_library:db2date(^date^)','>>Payment:>fr>PM>title:ID=^payment_mode_ID^','>>Expence:>fr>EC>title:ID=^expence_category_ID^','other_details','referance_Name','branch_ID','ID'));
				}
				else
				{
					$res = $this->fetch_model->show(array('CT'=> array('transaction_type LIKE'=>'%'.@$_POST['transaction_type'].'%','other_details LIKE'=>'%'.@$_POST['Search'].'%','reference_ID'=>NULL,'branch_ID'=>$branch_ID)),array('transaction_type','amount','>>Date:>fn>library>date_library:db2date(^date^)','>>Payment:>fr>PM>title:ID=^payment_mode_ID^','>>Expence:>fr>EC>title:ID=^expence_category_ID^','other_details','referance_Name','branch_ID','ID'));
				}
			}
			$this->actions_config = $this->config->item('actions');
			if (!empty($res))
			{
				foreach ($res as $key => $value)
				{
					$res[$key]['Link'] = "<div>";
		 			foreach($this->actions_config['T'] as $action)
		 			{
		 				if(array_key_exists('function', $action))
		 				{
				 			$res[$key]['Link'] .= "<span class='label label-".$action['class']."' onClick=".$action['function']."('".$value['ID']."')><i class='fa fa-".$action['icon']." bigger-130'></i></span>&nbsp;&nbsp;";
		 				}
		 				else
		 				{
		 					if($action['icon']=="print" || $action['icon']=="download")
		 						{
		 							if ($value['transaction_type']==='Credit') {
		 								$res[$key]['Link'] .= "<a class='label label-".$action['class']."' href='#' onclick='window.open(\"".base_url($action['link'].$value['ID'])."\",\"_blank\",\"toolbar=yes, scrollbars=yes, resizable=yes, left=500, width=900, height=800\")'><i class='fa fa-".$action['icon']." bigger-130'></i></a>&nbsp;&nbsp;";
		 							}
		 							else
		 							{
		 								$res[$key]['Link'] .='';
		 							}
		 							
		 						}
		 						else if($action['class']=="red")
		 					{
		 						$res[$key]['Link'] .= "<span class='label label-danger ".$action['class']."' id='item".$value['ID']."' onClick='deletef(\"".$value['ID']."\",\"".base_url($action['link'].$value['ID'])."\")'><i class='fa fa-".$action['icon']." bigger-130'></i></span>&nbsp;&nbsp;";
		 					}
		 					else
		 					{
		 						$res[$key]['Link'] .= "<a class='label label-".$action['class']."' href=".base_url($action['link'].$value['branch_ID'].'/'.$value['ID'])."><i class='fa fa-".$action['icon']." bigger-130'></i></a>&nbsp;&nbsp;";
		 					}

		 				}
		 				unset($res[$key]['branch_ID']);
			 			unset($res[$key]['ID']);
			 		}
		 		$res[$key]['Link'] .= "</div>";
		    	}

	    		foreach ($res as $key => $value)
				{
					$d[]= array_values($value);
				}
				$data['data']=$d;
				foreach ($d as $key => $value) 
				{
					if (strrpos($value[3], 'US') !== false) 
					{
						$cid = $this->fetch_model->show(array('US'=>array('ID'=>$value[3])));
						$d[$key][2] = $cid[0]['Name'];
					}
					else if (strrpos($value[3], 'ST') !== false) 
					{
						$cid = $this->fetch_model->show(array('ST'=>array('ID'=>$value[3])));
						$d[$key][2] = $cid[0]['Name'];
					}
					else if (strrpos($value[3], 'BA') !== false) 
					{
						$cid = $this->fetch_model->show(array('BA'=>array('ID'=>$value[3])));
						$d[$key][2] = $cid[0]['bank_name'];
					}
					else
					{
						// $cid = $this->fetch_model->show(array('V'=>array('ID'=>$value[3])));
						$d[$key][2] = '-NA-';	
					}
					$d[$key][0]=$value[4];
					$d[$key][1]=$value[6];
					$d[$key][3]=$value[5];
					if ($value[0] !== 'Debit') 
					{
						$d[$key][4] = $value[1];
						$d[$key][5] = 0;
					}
					else
					{
						$d[$key][4] = 0;
						$d[$key][5] = $value[1];
					}
					$d[$key][6] = $value[2];

				}
				return json_encode($d);
			}
			else
			{
				return json_encode($res);
			}
		}


		public function get_print_details($id)
		{
			$data = array();
			$data['DETAILS'] = $this->fetch_model->show(array('T'=>array('ID'=>$id)),array('transaction_type','date','amount','>>paymentMode:>fr>PM>title:ID=^payment_mode_ID^','bank_ID','other_details','>>expenceCategory:>fr>EC>title:ID=^expence_category_ID^','reference_ID','referance_Name','branch_ID','ID'));
			// var_dump($DETAILS);
			if ($data['DETAILS'][0]['reference_ID'])
			{
				$this->load->model('bill_model');
				$data['DETAILS2'][0]['words'] = $this->bill_model->convert_number($data['DETAILS'][0]['amount']);
				$ids = explode(',', $data['DETAILS'][0]['reference_ID']);
				$ID = $data['DETAILS'][0]['reference_ID'];
				$refID = $data['DETAILS'][0]['referance_Name'];
				if (strpos($ID,"INSK") !== false)
				{
					$referal = $this->fetch_model->show(array('ST'=>array('ID'=>$refID)));
					if ($referal)
					{
						$data['referal'] = $referal[0];
						$data['referal']['name'] = $data['referal']['Name'].' '.$data['referal']['Middle_name'].' '.$data['referal']['Last_name'];
						$data['referal']['address'] = $this->str_function_library->call('fr>AD>address:person_ID=`'.$data['referal']['ID'].'`');
						$data['referal']['date'] = $this->str_function_library->call('fr>IN>date:ID=`'.$ID.'`');
						/*$data['referal']['business_name'] = $referal[0]['company_name'];
						$addID = explode(',', $referal[0]['address_ID']);
						$data['referal']['address'] = $this->str_function_library->call('fr>AD>address:ID=`'.$addID[0].'`');*/
					}
					$c2 = $this->fetch_model->show(array('T'=>array('reference_ID LIKE'=>'%'.$ID.'%')),'sum(amount)');
					$data['collection'] = $c2[0]['sum(amount)'];
					$t2 = $this->fetch_model->show(array('IN'=>array('ID'=>$ID)),array('amount','date'));
					$data['grandtotal'] = $t2[0]['amount'];
					$data['billNo'] = $t2[0]['date'];
					$data['balance'] = $data['grandtotal']-$data['collection'];
					$data['percent'] = ($data['collection']/$data['grandtotal'])*100;
					/*if ($t2[0]['bill_Category'] !== 'AutoPaid')
					{
						if($data['balance'] > 0)
	        			{
	        				$data['status'] = "UNPAID";
        					$data['class'] = "danger";
	        			}
	        			else
	        			{
        					$data['class'] = "success";
	        				$data['status'] = "PAID";
	        			}
					}
					else
					{
						$data['status'] = "PAID";
        				$data['class'] = "success";
					}*/
					
				}
				else
				{
					$referal = $this->fetch_model->show(array('V'=>array('ID'=>$refID)));
					if ($referal)
					{
						$data['referal'] = $referal[0];
					}
					$c2 = $this->fetch_model->show(array('T'=>array('reference_ID LIKE'=>'%'.$ID.'%')),'sum(amount)');
					$data['collection'] = $c2[0]['sum(amount)'];
					$t2 = $this->fetch_model->show(array('PU'=>array('ID'=>$ID)),array('amount','bill_number'));
					$data['grandtotal'] = $t2[0]['amount'];
					$data['billNo'] = $t2[0]['bill_number'];
					$data['percent'] = ($data['collection']/$data['grandtotal'])*100;
					$data['balance'] = $data['grandtotal']-$data['collection'];
					if($data['balance'] > 0)
        			{
        				$data['status'] = "UNPAID";
        				$data['class'] = "danger";
        			}
        			else
        			{
        				$data['status'] = "PAID";
        				$data['class'] = "success";
        			}
				}
			}
			$data['USER'] = $this->fetch_model->show(array('US'=>array('ID'=>@$this->data['Login']['ID'])),array('Name','Company_Name','address_ID','phone_no_ID','Email','Image_ID','currency_ID','ID'));
			$cid = $data['USER'][0]['currency_ID'];
			$data['Currency'] = $this->fetch_model->show(array('CU'=>array('ID'=>$cid)));
			//$data['Currency'][0]['symbol']='';
			/*if(empty($data['Currency'][0]['symbol']))
			{
				$data['Currency'][0]['symbol'] = $data['Currency'][0]['title'];
			}*/
			//$data['DETAILS'][0]['amount'] = '';
			//$data['USER'][0]['vat_tin_no'] = '';
			$data['Img'] = $this->fetch_model->show(array('SS'=> array('ID'=>$data['USER'][0]['Image_ID'])));
			return $data;
		}

		public function get_monthly_fees($branch_ID = NULL, $date = NUL)
		{
			if($date == NULL)
			{
				$date = date('Y-m-d');
			}
			else
			{
				$date = $this->date_library->converter($date,'m-Y','Y-m-d');
			}
			$start = date('Y-m-01', strtotime($date));
			$end = date('Y-m-t', strtotime($date));
			$year = date('Y', strtotime($date));
			if(($branch_ID != NULL) && !empty($branch_ID) && ($branch_ID != FALSE))
			{
				$students = $this->fetch_model->show(array('ST'=>array('branch_ID'=>$branch_ID,'admStatus'=>'Active')));
			}
			else
			{
				$students = $this->fetch_model->show(array('ST'=>array('admStatus'=>'Active')));
			}
			$admission_year = array();
			foreach ($students as $keyyr => $valueyr) {
				$year_adm = $this->fetch_model->show(array('ADT'=>array('Year'=>$year,'Student_ID'=>$valueyr['ID'])),array('Student_ID'));
				$admission_year[] = $year_adm[0]['Student_ID'];
			}
			foreach ($students as $keych => $valuech) {
				if(!in_array($valuech['ID'], $admission_year))
				{
					unset($students[$keych]);
				}
			}
			$data = array();
			foreach ($students as $keyst => $valuest) {
				$data[$keyst]['name'] = $valuest['Name'].' '.$valuest['Middle_name'].' '.$valuest['Last_name'];
				$fees = $this->fetch_model->show(array('FR'=>array('student_ID'=>$valuest['ID'])),array('total_fees','Pending_fees'));
				if(($fees == NULL) || empty($fees) || ($fees == FALSE))
				{
					$data[$keyst]['total_fees'] = 0;
					$data[$keyst]['pending_fees'] = 0;
				}
				else
				{
					$data[$keyst]['total_fees'] = $fees[0]['total_fees'];
					$data[$keyst]['pending_fees'] = $fees[0]['Pending_fees'];
				}
				$inst_det = $this->fetch_model->show(array('IN'=>array('student_ID'=>$valuest['ID'],'date >='=>$start,'date <='=>$end)),array('sum(amount) as sum_amount'));
				if(($inst_det[0]['sum_amount'] == NULL) || empty($inst_det) || ($inst_det == FALSE))
				{
					$data[$keyst]['monthly_fees'] = 0;
				}
				else
				{
					$data[$keyst]['monthly_fees'] = $inst_det[0]['sum_amount'];
				}
				$trans = $this->fetch_model->show(array('T'=>array('referance_Name'=>$valuest['ID'],'date >='=>$start,'date <='=>$end,'transaction_type'=>'Credit')),array('sum(amount) as sum_amount'));
				if(($trans[0]['sum_amount'] == NULL) || empty($trans) || ($trans == FALSE))
				{
					$data[$keyst]['paid_fees'] = 0;
				}
				else
				{
					$data[$keyst]['paid_fees'] = $trans[0]['sum_amount'];	
				}
				if($data[$keyst]['monthly_fees'] <= $data[$keyst]['paid_fees'])
				{
					$data[$keyst]['status'] = 'Paid';
				}
				else
				{
					$data[$keyst]['status'] = 'Pending';
				}
			}
			return array('data'=>array_values($data));
		}
	}
?>