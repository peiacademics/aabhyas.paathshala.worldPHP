<?php

	class Account_model extends CI_Model

	{

		public function get_input_output($type)

		{

			$my_config = $this->config->item('skyq');

			$cash_mode_id = $my_config['payment_mode_cash'];

			// $output = array('other_details','>>Date:>fn>library>date_library:db2date(^date^)','>>Reference:>fn>model>account_model:get_reference_id_value(^reference_ID^)','>>Credit:>fn>library>user_library:getSameValue(^amount^)','>>Debit:>fn>library>user_library:getSameValue(^blank^)','ID');



			// $output1 = array('other_details','>>Date:>fn>library>date_library:db2date(^date^)','>>Reference:>fn>model>account_model:get_reference_id_value(^reference_ID^)','>>Credit:>fn>library>user_library:getSameValue(^blank^)','>>Debit:>fn>library>user_library:getSameValue(^amount^)','ID');

			$output = array('other_details','>>Date:>fn>library>date_library:db2date(^date^)','>>Reference:>fn>model>account_model:get_reference_new(^reference_ID^,^referance_Name^)','>>Credit:>fn>library>user_library:getSameValue(^amount^)','>>Debit:>fn>library>user_library:getSameValue(^blank^)','transaction_type','ID');



			$output1 = array('other_details','>>Date:>fn>library>date_library:db2date(^date^)','>>Reference:>fn>model>account_model:get_reference_new(^reference_ID^,^referance_Name^)','>>Credit:>fn>library>user_library:getSameValue(^blank^)','>>Debit:>fn>library>user_library:getSameValue(^amount^)','transaction_type','ID');

			if($type=='bank')

			{

				if (!empty($_POST['dateRange']))

				{

					$date=explode('to', $_POST['dateRange']);

					$start=$this->date_library->date2db(trim($date[0]),'m/d/Y');

					$end=$this->date_library->date2db(trim($date[1]),'m/d/Y');

					$input = array('T'=>array('payment_mode_ID !='=>$cash_mode_id,'transaction_type'=>'Credit','date >='=>$start,'date <'=>$end,'transaction_type LIKE'=>'%'.@$_POST['transaction_type'].'%','other_details LIKE'=>'%'.@$_POST['Search'].'%'));

					$output1[] = $output[] = '>>Bank:>fr>BA>bank_name:ID=^bank_ID^';

	 				$input1 = array('T'=>array('payment_mode_ID !='=>$cash_mode_id,'transaction_type'=>'Debit','date >='=>$start,'date <'=>$end,'transaction_type LIKE'=>'%'.@$_POST['transaction_type'].'%','other_details LIKE'=>'%'.@$_POST['Search'].'%'));

				}

				else

				{

					$input = array('T'=>array('payment_mode_ID !='=>$cash_mode_id,'transaction_type'=>'Credit','transaction_type LIKE'=>'%'.@$_POST['transaction_type'].'%','other_details LIKE'=>'%'.@$_POST['Search'].'%'));

					$output1[] = $output[] = '>>Bank:>fr>BA>bank_name:ID=^bank_ID^';

	 				$input1 = array('T'=>array('payment_mode_ID !='=>$cash_mode_id,'transaction_type'=>'Debit','transaction_type LIKE'=>'%'.@$_POST['transaction_type'].'%','other_details LIKE'=>'%'.@$_POST['Search'].'%'));

				}

			}

			elseif($type=='cash')

			{

				if (!empty($_POST['dateRange']))

				{

					$date=explode('to', $_POST['dateRange']);

					$start=$this->date_library->date2db(trim($date[0]),'m/d/Y');

					$end=$this->date_library->date2db(trim($date[1]),'m/d/Y');

					$input = array('T'=>array('payment_mode_ID ='=>$cash_mode_id,'transaction_type'=>'Credit','date >='=>$start,'date <'=>$end,'transaction_type LIKE'=>'%'.@$_POST['transaction_type'].'%','other_details LIKE'=>'%'.@$_POST['Search'].'%'));

	 				$input1 = array('T'=>array('payment_mode_ID ='=>$cash_mode_id,'transaction_type'=>'Debit','date >='=>$start,'date <'=>$end,'transaction_type LIKE'=>'%'.@$_POST['transaction_type'].'%','other_details LIKE'=>'%'.@$_POST['Search'].'%'));

				}

				else

				{

					$input = array('T'=>array('payment_mode_ID ='=>$cash_mode_id,'transaction_type'=>'Credit','transaction_type LIKE'=>'%'.@$_POST['transaction_type'].'%','other_details LIKE'=>'%'.@$_POST['Search'].'%'));

	 				$input1 = array('T'=>array('payment_mode_ID ='=>$cash_mode_id,'transaction_type'=>'Debit','transaction_type LIKE'=>'%'.@$_POST['transaction_type'].'%','other_details LIKE'=>'%'.@$_POST['Search'].'%'));

				}

			}

			else{

				return FALSE;

			}

			return array('output'=>$output,'input'=>$input,'output1'=>$output1,'input1'=>$input1);

		}



		public function get_reference_new($reference_id,$reference_name)

		{

			return $this->str_function_library->call('fr>B>bill_number:ID=`'.$reference_id.'`')."-".$this->str_function_library->call('fr>C>name:ID=`'.$reference_name.'`');

		}	

		public function get_show_data($type=NULL)

		{

			if(!is_null($type))

			{

				$this->load->library('datatable_library');

				$arr = $this->get_input_output($type);



				$res1 = $this->fetch_model->show($arr['input'],$arr['output']);

				$res2 = $this->fetch_model->show($arr['input1'],$arr['output1']);

				//var_dump($res2);

				if ($res1 ===false)

				{

					return $res2;

				}

				else if ($res2===false) {

					return $res1;

				}

				else

				{

					$res=array_merge_recursive($res1,$res2);

				}

				return $res;

			}

			else

			{

				$this->errorlog_library->entry('Account_model > get_show_data > argument type is null.');

				return FALSE;

			}

		}



		public function get_balance($type=NULL)

		{

			if(!is_null($type))

			{

				$arr = $this->get_input_output($type);

				$res1 = $this->fetch_model->show($arr['input'],$arr['output']);

				$res2 = $this->fetch_model->show($arr['input1'],$arr['output1']);

				$credit = 0;

				$debit =0;

				if(!empty($res1))

				{

					foreach ($res1 as $key => $value) {

 						$credit += $value['Credit'];

 					}

 				}

 				if(!empty($res2))

				{

	 				foreach ($res2 as $key => $value) {

	 					$debit += $value['Debit'];

	 				}

	 			}

 				return (float)$credit-$debit;

			}

			else

			{



			}

		}



		public function get_reference_id_value($reference_id,$reference_bill=NULL)

		{

			print_r($reference_id);

			print_r($reference_bill);

			if(!is_null($reference_id) && !empty($reference_id))

			{

				$my_config = $this->config->item('skyq');

				$data = '';

				$cache = explode($my_config['seperator'], $reference_id);

				$table = $this->db_library->get_tbl($cache[0]);

				$reference_name = $this->str_function_library->call('fr>'.$cache[0].'>name:ID=`'.$reference_id.'`');

				$data .= '<b>'.ucfirst($table).' Name : </b>'.$reference_name;

				if(!is_null($reference_bill) && !empty($reference_bill))

				{

					$cache = explode($my_config['seperator'], $reference_bill);

					$table = $this->db_library->get_tbl($cache[0]);

					if($cache[0] == 'A')

					{

						$reference_bill_no = $this->str_function_library->call('fr>'.$cache[0].'>amc_no:ID=`'.$reference_bill.'`');

					}

					else

					{

						$reference_bill_no = $this->str_function_library->call('fr>'.$cache[0].'>bill_number:ID=`'.$reference_bill.'`');

					}

					$data .=', <b>'.ucfirst($table).' Number : </b>'.$reference_bill_no;

				}

				return $data;

			}

			else

			{

				return ' Other';

			}

		}



		public function getCashBookData($type)

		{

			if (!empty($_POST['dateRange']))

			{

				$date=explode('to', $_POST['dateRange']);

				$start=$this->date_library->date2db(trim($date[0]),'m/d/Y');

				$end=$this->date_library->date2db(trim($date[1]),'m/d/Y');

				$res=$this->get_show_data($type);

			}

			else

			{

				$res=$this->get_show_data($type);

			}

			$this->actions_config = $this->config->item('actions');

			if (!empty($res))

			{

				foreach ($res as $key => $value)

				{

					$res[$key]['Link'] = "<div>";

		 			foreach($this->actions_config['T'] as $action)

		 			{
		 				// print_r($action);

		 				if(array_key_exists('function', $action))

		 				{

				 			$res[$key]['Link'] .= "<span class='label label-".$action['class']."' onClick=".$action['function']."('".$value['ID']."')><i class='fa fa-".$action['icon']." bigger-130'></i></span>&nbsp;&nbsp;";

		 				}

		 				else

		 				{

		 					

		 					if($action['class']=="red")

		 					{

		 						$res[$key]['Link'] .= "<span class='label label-danger ".$action['class']."' id='item".$value['ID']."' onClick='deletef(\"".$value['ID']."\",\"".base_url($action['link'].$value['ID'])."\")'><i class='fa fa-".$action['icon']." bigger-130'></i></span>&nbsp;&nbsp;";

		 					}else
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
		 					else

		 					{

		 						$res[$key]['Link'] .= "<a class='label label-".$action['class']."' href=".base_url($action['link'].$value['ID'])."><i class='fa fa-".$action['icon']." bigger-130'></i></a>&nbsp;&nbsp;";

		 					}



		 				}

			 			unset($res[$key]['ID']);
			 			unset($res[$key]['transaction_type']);

			 		}

		 		$res[$key]['Link'] .= "</div>";

		    	}



	    		foreach ($res as $key => $value)

				{

					$d[]= array_values($value);

				}

				$data['data']=$d;

				return json_encode($d);

			}

			else

			{

				return json_encode($res);

			}

		}

		

	}

?>