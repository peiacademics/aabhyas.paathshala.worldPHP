<?php
	class report_model extends CI_Model
	{
		public function check($id=NULL,$login_as="Client")
		{
			$user = count($this->fetch_model->show(array('BA' =>array('ID'=>$id))));
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
				$this->errorlog_library->entry('Bank_model > check > argument ID is invalid.');
				redirect('bank/add/');
			}
		}

		public function getSell()
		{
			if(!empty($_POST['branch_ID']))
			{
				if (!empty($_POST['date']))
				{
					$date = explode('-', $_POST['date']);
					$start = $this->date_library->date2db(trim($date[0]),'m/d/Y');
					$end = $this->date_library->date2db(trim($date[1]),'m/d/Y');
						if ($start === $end) {
							$data = $this->fetch_model->show(array('C'=> array('Added_by'=>$this->data['Login']['ID'],'branch_id'=>$_POST['branch_ID'],'date'=>$start,'call_Status LIKE'=>'%'.@$_POST['Status'].'%')));
						}
						else
						{
							$data = $this->fetch_model->show(array('C'=> array('Added_by'=>$this->data['Login']['ID'],'branch_id'=>$_POST['branch_ID'],'date >='=>$start,'date <='=>$end,'call_Status LIKE'=>'%'.@$_POST['Status'].'%')));
						}
						
				}
				else
				{

					$data = $this->fetch_model->show(array('C'=> array('Added_by'=>$this->data['Login']['ID'],'branch_id'=>$_POST['branch_ID'],'call_Status LIKE'=>'%'.@$_POST['Status'].'%')));
				}
			}
			else
			{
				if (!empty($_POST['date']))
				{
					$date = explode('-', $_POST['date']);
					$start = $this->date_library->date2db(trim($date[0]),'m/d/Y');
					$end = $this->date_library->date2db(trim($date[1]),'m/d/Y');
						if ($start === $end) {
							$data = $this->fetch_model->show(array('C'=> array('Added_by'=>$this->data['Login']['ID'],'date'=>$start,'call_Status LIKE'=>'%'.@$_POST['Status'].'%')));
						}
						else
						{
							$data = $this->fetch_model->show(array('C'=> array('Added_by'=>$this->data['Login']['ID'],'date >='=>$start,'date <='=>$end,'call_Status LIKE'=>'%'.@$_POST['Status'].'%')));
						}
						
				}
				else
				{

					$data = $this->fetch_model->show(array('C'=> array('Added_by'=>$this->data['Login']['ID'],'call_Status LIKE'=>'%'.@$_POST['Status'].'%')));
				}
			}
			if ($data)
			{
				foreach ($data as $key => $value) {
					$data[$key]['l_Name']=1;
				}
				foreach ($data as $ktbl => $vtbl)
				{
					$recalls = $this->fetch_model->show(array('R'=> array('contactID'=>$vtbl['ID'],'Status'=>'P')),'count(ID)');
					if (!empty($vtbl['uploadedFileName'])) { 
              			 $vtbl['list_Name']=$vtbl['list_Name']." <span class='label label-warning'>Imported</span> <span class='label label-danger'>".$recalls[0]['count(ID)']."</span>";
          			}else{
              			$vtbl['list_Name']=$vtbl['list_Name']." <span class='label label-primary'>Inserted</span> <span class='label label-danger'>".$recalls[0]['count(ID)']."</span>";
                	} 
						unset($vtbl['Added_by']);
						unset($vtbl['Status']);
						unset($vtbl['ID']);
						unset($vtbl['Added_on']);
						unset($vtbl['list_ID']);
						unset($vtbl['call_Status']);
						unset($vtbl['uploadedFileName']);
						unset($vtbl['leadDescription']);
						unset($vtbl['recall_ID']);
						unset($vtbl['l_Name']);
						$dtbl[]= array_values($vtbl);
				}

			    // $result = array_values($billData);
			    $result = array_values($data);
			   	foreach ($result as $key2 => $value2)
				{
					$arr[] = (object) array('y'=>$value2['date'],'item1'=>$value2['l_Name']);
				}
				header('Content-Type: application/x-json; charset=utf-8');
				echo json_encode(array('map'=>$arr,'dataset'=>@$dtbl,'dataReturn'=>@$drtbl));
			}
			else
			{
				header('Content-Type: application/x-json; charset=utf-8');
				$arr1[] = (object) array('y'=>0,'item1'=>0);
				echo json_encode(array('map'=>$arr1,'dataset'=>false,'dataReturn'=>false));
			}
		}		


		public function sumAmt($d)

		{

			$result = array();

			foreach ($d as $val)

			{

			    if (!isset($result[$val['date']]))

			        $result[$val['date']] = $val;

			    else

			        $result[$val['date']]['grand_total'] = 0;//+= $val['grand_total'];

			}

			$result = array_values($result);

			return $result;

		}



		public function getProduct($data,$tbl,$IDs)

		{

			// $id=explode('-', $IDs);

			// $Product_ID=trim($id[0]);

			// $model_ID=trim($id[1]);

			if ($tbl==='RP')

			{

				$bID='';

				foreach ($data as $key => $value)

				{

					$d = $this->fetch_model->show(array($tbl=> array('product_ID'=>$IDs,'returnNote_ID'=>$value['ID'])));

					foreach ($d as $k => $v)

					{

						$da[]=array("returnNote_number"=>$value['returnNote_number'],"date"=>$value['date'],"customer_ID"=>$value["customer_ID"],"grand_total"=>$v['amount'],);

					}

				}

				

				return isset($da) ? $da : false;

			}

			else

			{

				$bID='';

				foreach ($data as $key => $value)

				{

					$d = $this->fetch_model->show(array($tbl=>array('product_ID'=>$IDs,'bill_ID'=>$value['ID'])));

					foreach ($d as $k => $v)

					{

						$da[]=array("bill_number"=>$value['bill_number'],"date"=>$value['date'],"customer_ID"=>$value["customer_ID"],"grand_total"=>$v['amount'],"product_ID"=>$v['product_ID']);

					}

					// $da[]=array("");

				}

				// $bID=trim($bID,'|');

				// print_r($d);

				return isset($da) ? $da: false;

			}

		}



		public function getPurchase()

		{

			if (!empty($_POST['date']))

			{

				$date=explode('-', $_POST['date']);

				$start=$this->date_library->date2db(trim($date[0]),'m/d/Y');

				$end=$this->date_library->date2db(trim($date[1]),'m/d/Y');

				if (!empty($_POST['Product_ID']))

				{

					$data = $this->fetch_model->show(array('PU'=> array('date >='=>$start,'date <'=>$end,'vendor_ID LIKE'=>'%'.@$_POST['Vender_ID'].'%')));

					$data=$this->getPurchaseProduct($data,'PP',$_POST['Product_ID']);



				}

				else

				{

					$data = $this->fetch_model->show(array('PU'=> array('date >='=>$start,'date <'=>$end,'vendor_ID LIKE'=>'%'.@$_POST['Vender_ID'].'%')));

				}

			}

			else

			{

				if (!empty($_POST['Product_ID']))

				{

					$data = $this->fetch_model->show(array('PU'=> array('vendor_ID LIKE'=>'%'.@$_POST['Vender_ID'].'%')));

					$data=$this->getPurchaseProduct($data,'PP',$_POST['Product_ID']);

				}

				else

				{

					$data = $this->fetch_model->show(array('PU'=> array('vendor_ID LIKE'=>'%'.@$_POST['Vender_ID'].'%')));

				}

			}

			if ($data)

			{

				foreach ($data as $key => $value)

				{

					$data[$key]['grand_total']=$value['amount'];

				}

				$billData=$this->sumAmt($data);

				if ($billData){

					foreach ($data as $ktbl => $vtbl)

					{

						// print_r($vtbl);

						if (@$vtbl['vendor_ID'])

						{

							$vender=$this->str_function_library->call('fr>V>name:ID=`'.$vtbl['vendor_ID'].'`');

							// 	$vtbl['product_ID']=$prod[0]['Title'].'-'.$cate;

		     //    			unset($vtbl['reference_ID']);

							$vtbl['vendor_ID']=$vender;

							unset($vtbl['Added_by']);

							unset($vtbl['Status']);

							unset($vtbl['ID']);

							unset($vtbl['tax']);

							unset($vtbl['discount']);

							unset($vtbl['details']);

							unset($vtbl['purchase_product_ID']);

							unset($vtbl['amount']);

							$dtbl[]= array_values($vtbl);

						}

						else

						{

							$vender=$this->str_function_library->call('fr>V>name:ID=`'.$vtbl['vendor'].'`');

							$vtbl['vendor']=$vender;

							unset($vtbl['amount']);

							$dtbl[]= array_values($vtbl);

						}

						

					}

				}

				foreach ($billData as $key2 => $value2)

				{

					$arr[]=(object) array('y'=>$value2['date'],'item1'=>$value2['grand_total']);

				}

				header('Content-Type: application/x-json; charset=utf-8');

				// echo json_encode($arr);

				echo json_encode(array('map'=>$arr,'dataset'=>$dtbl));



			}

			else

			{

				header('Content-Type: application/x-json; charset=utf-8');

				$arr1[]=(object) array('y'=>0,'item1'=>0);

				// echo json_encode($arr1);

				echo json_encode(array('map'=>$arr1,'dataset'=>false));

			}

		}



		public function getPurchaseProduct($data,$tbl,$IDs)

		{

			// $id=explode('-', $IDs);

			// $Product_ID=trim($id[0]);

			// $model_ID=trim($id[1]);

			$bID='';

			$da=array();

			foreach ($data as $key => $value)

			{

				// print_r($value);

				$purchase_product_ID=trim($value['purchase_product_ID'],',');

				$purchase_product_ID=explode(',', $purchase_product_ID);

				foreach ($purchase_product_ID as $k => $v)

				{

					$d = $this->fetch_model->show(array($tbl=>array('product_ID'=>$IDs,'ID'=>$v)));

					if ($d)

					{

						foreach ($d as $ke => $ve)

						{

							$da[]=array('bill_number'=>$value['bill_number'],'date'=>$value['date'],'vendor'=>$value['vendor_ID'],'amount'=>$ve['purchase_cost']);

						}

					}

				}

			}

			return isset($da) ? $da : false;

		}



		/*public function getStock()

		{

			if (!empty($_POST['Product_ID']))

			{

				$id=explode('-', $_POST['Product_ID']);

				$Product_ID=trim($id[0]);

				$Size_ID=trim($id[1]);

			}

			if (!empty($_POST['date']))

			{

				$date=explode('-', $_POST['date']);

				$start=$this->date_library->date2db(trim($date[0]),'m/d/Y');

				$end=$this->date_library->date2db(trim($date[1]),'m/d/Y');

				$data = $this->fetch_model->show(array('S'=> array('date >='=>$start,'date <'=>$end,'product_ID LIKE'=>'%'.@$Product_ID.'%','size_ID LIKE'=>'%'.@$Size_ID.'%')));

			}

			else

			{

				$data = $this->fetch_model->show(array('S'=> array('product_ID LIKE'=>'%'.@$Product_ID.'%','size_ID LIKE'=>'%'.@$Size_ID.'%')));

			}

			if ($data)

			{

				foreach ($data as $key => $value)

				{

					$data[$key]['grand_total']=$value['volume'];

				}

				$billData=$this->sumAmt($data);

				foreach ($data as $ktbl => $vtbl)

				{

					// print_r($vtbl);

					$prod=$this->fetch_model->show(array('P'=> array('ID'=>$vtbl['product_ID'])));

					$sizeData=$this->fetch_model->show(array('SZ'=> array('ID'=>$vtbl['size_ID'])));

					if ($sizeData)

					{

						$vtbl['size_ID']=$sizeData[0]['Quantity'].'-'.$sizeData[0]['Unit'];

					}

					if ($prod)

					{

						$cate=$this->str_function_library->call('fr>PC>Title:ID=`'.$prod[0]['Category_ID'].'`');

						$vtbl['product_ID']=$prod[0]['Title'].'-'.$cate;

					}

        			unset($vtbl['reference_ID']);

					unset($vtbl['Added_by']);

					unset($vtbl['Status']);

					unset($vtbl['ID']);

					unset($vtbl['volume']);

					unset($vtbl['Boxes']);

					$dtbl[]= array_values($vtbl);

				}

				foreach ($billData as $key2 => $value2)

				{

					$arr[]=(object) array('y'=>$value2['date'],'a'=>$value2['grand_total']);

				}

				header('Content-Type: application/x-json; charset=utf-8');

				// echo json_encode($arr);

				echo json_encode(array('map'=>$arr,'dataset'=>$dtbl));



			}

			else

			{

				header('Content-Type: application/x-json; charset=utf-8');

				$arr1[]=(object) array('y'=>0,'a'=>0);

				// echo json_encode($arr1);

				echo json_encode(array('map'=>$arr1,'dataset'=>false));



			}

		}*/



		public function getExpCat()

		{

			if (!empty($_POST['date']))

			{

				$date=explode('-', $_POST['date']);

				$start=$this->date_library->date2db(trim($date[0]),'m/d/Y');

				$end=$this->date_library->date2db(trim($date[1]),'m/d/Y');

				$data = $this->fetch_model->show(array('T'=> array('date >='=>$start,'date <'=>$end,'transaction_type LIKE'=>'%'.@$_POST['transaction_type'].'%','expence_category_ID LIKE'=>'%'.@$_POST['expence_category_ID'].'%')));

			}

			else

			{

				$data = $this->fetch_model->show(array('T'=> array('transaction_type LIKE'=>'%'.@$_POST['transaction_type'].'%','expence_category_ID LIKE'=>'%'.@$_POST['expence_category_ID'].'%')));

			}

			if ($data)

			{

				foreach ($data as $key => $value)

				{

					$data[$key]['grand_total']=$value['amount'];

				}

				$billData=$this->sumAmt($data);

				// print_r($billData);

				foreach ($data as $ktbl => $vtbl)

				{

					// print_r($vtbl);

        			$acc = $this->str_function_library->call('fr>BA>account_no:ID=`'.$vtbl['bank_ID'].'`');

        			$payMode= $this->str_function_library->call('fr>PM>title:ID=`'.$vtbl['payment_mode_ID'].'`');

        			$vtbl['bank_ID']=$acc;

        			if ($payMode==='Cash')

        			{

        				$vtbl['payment_mode_ID']="<span class='label label-success'>".$payMode."</span>";

        			}

        			else

        			{

        				$vtbl['payment_mode_ID']="<span class='label label-warning'>".$payMode."</span>";

        			}



        			unset($vtbl['expence_category_ID']);

					unset($vtbl['Added_by']);

					unset($vtbl['Status']);

					unset($vtbl['ID']);

					unset($vtbl['reference_ID']);

					$dtbl[]= array_values($vtbl);

				}

				foreach ($billData as $key2 => $value2)

				{

					$arr[]=(object) array('y'=>$value2['date'],'item1'=>$value2['grand_total']);

				}

				header('Content-Type: application/x-json; charset=utf-8');

				echo json_encode(array('map'=>$arr,'dataset'=>$dtbl));

			}

			else

			{

				header('Content-Type: application/x-json; charset=utf-8');

				$arr1[]=(object) array('y'=>0,'item1'=>0);

				echo json_encode(array('map'=>$arr1,'dataset'=>false));

			}

		}

		public function get_show_data($input,$output)
		{
		 	$this->load->library('datatable_library');
	 		return $this->datatable_library->get_data($input,$output);
		}

		public function add_or_edit()
		{
			$this->load->model('form_model');
			$_POST['to'] = date("Y-m-d H:i:s", strtotime($_POST['to']));
			$_POST['from'] = date("Y-m-d H:i:s", strtotime($_POST['from']));
			if(empty($_POST['ID']))
			{
				unset($_POST['ID']);
				$result = $this->form_model->add(array("table"=>"DAT","columns"=>$_POST));
			}
			else
			{
				$result = $this->form_model->edit(array("table"=>"DAT","columns"=>$_POST,"where"=>array('ID'=>$_POST['ID'])));
			}
			echo json_encode($result);
		}

		public function delete($item_ID = NULL)
	 	{
	 		$this->load->model('form_model');
	 		$delete_parent = $this->form_model->delete(array('DAT'=>array('ID'=>$item_ID)));
	 		return $delete_parent;
	 	}

	 	public function get_scorecard($branch_ID=NULL)
		{
			$data = array();
			if(!is_null($branch_ID))
			{
				$data = $this->fetch_model->show(array('TK'=>array('branch_ID'=>$branch_ID,'ratings !='=>NULL)));
				if(!empty($data))
				{

					foreach ($data as $key => $value) {
						$assignedto = explode(',',$value['assignTo']);
						unset($data[$key]['assignTo']);
						$data[$key]['assignTo'] = '';
						foreach ($assignedto as $assignto) {
							$epmData = $this->fetch_model->show(array('US'=> array('ID'=>$assignto)),array('>>emp:>fr>SS>path:ID=^Image_ID^','Name'));
							$data[$key]['assignTo'] .= '<img src="'.base_url($epmData[0]['emp']).'" class="crlwName"> <b>'.$epmData[0]['Name'].'</b><br>';
						}
						$ratings = json_decode($value['ratings'],true);
						$data[$key]['ratings'] = '';
						$total_rating = 0;
						foreach ($ratings as $user => $rating) {
							$total_rating += $rating;
							$epm = $this->fetch_model->show(array('US'=> array('ID'=>$user)),array('>>emp:>fr>SS>path:ID=^Image_ID^','Name'));
							$data[$key]['ratings'] .= '<img src="'.base_url($epm[0]['emp']).'" class="crlwName"> <b>'.$epm[0]['Name'].'</b> - '.$rating.' points<div class="progress progress-mini"><div style="width: '.($rating*10).'%;" class="progress-bar"></div></div><br>';
						}
						$data[$key]['avg_rating'] = $total_rating/count($ratings);
						// $data[$key]['rating']
					}
				}
			}
			return $data;
		}

		public function get_task_reports($branch_ID=NULL)
		{
			$data = array();
			if(!is_null($branch_ID))
			{
				$data['tb1'] = $this->fetch_model->show(array('TK'=>array('branch_ID'=>$branch_ID,'tStatus'=>'Inprocess')));
				if(!empty($data['tb1']))
				{
					foreach ($data['tb1'] as $key1 => $value1) {
						$assignedto = explode(',',$value1['assignTo']);
						unset($data['tb1'][$key1]['assignTo']);
						$data['tb1'][$key1]['assignTo'] = '';
						foreach ($assignedto as $assignto) {
							$epmData = $this->fetch_model->show(array('US'=> array('ID'=>$assignto)),array('>>emp:>fr>SS>path:ID=^Image_ID^','Name'));
							$data['tb1'][$key1]['assignTo'] .= '<img src="'.base_url($epmData[0]['emp']).'" class="crlwName"> <b>'.$epmData[0]['Name'].'</b><br>';
							$data['tb1'][$key1]['end_time'] = $value1['expected_end_time'];
						}
					}
				}
				$data['tb2'] = $this->fetch_model->show(array('TK'=>array('branch_ID'=>$branch_ID,'tStatus'=>'Pending Approval','ratings'=>NULL)));
				if(!empty($data['tb2']))
				{
					foreach ($data['tb2'] as $key2 => $value2) {
						$assignedto = explode(',',$value2['assignTo']);
						unset($data['tb2'][$key2]['assignTo']);
						$data['tb2'][$key2]['assignTo'] = '';
						foreach ($assignedto as $assignto) {
							$epmData = $this->fetch_model->show(array('US'=> array('ID'=>$assignto)),array('>>emp:>fr>SS>path:ID=^Image_ID^','Name'));
							$data['tb2'][$key2]['assignTo'] .= '<img src="'.base_url($epmData[0]['emp']).'" class="crlwName"> <b>'.$epmData[0]['Name'].'</b><br>';
						}
					}
				}
				$data['tb3'] = $this->fetch_model->show(array('TK'=>array('branch_ID'=>$branch_ID,'tStatus'=>'Pending Approval','ratings !='=>NULL)));
				if(!empty($data['tb3']))
				{
					foreach ($data['tb3'] as $key3 => $value3) {
						$assignedto = explode(',',$value3['assignTo']);
						unset($data['tb3'][$key3]['assignTo']);
						$data['tb3'][$key3]['assignTo'] = '';
						foreach ($assignedto as $assignto) {
							$epmData = $this->fetch_model->show(array('US'=> array('ID'=>$assignto)),array('>>emp:>fr>SS>path:ID=^Image_ID^','Name'));
							$data['tb3'][$key3]['assignTo'] .= '<img src="'.base_url($epmData[0]['emp']).'" class="crlwName"> <b>'.$epmData[0]['Name'].'</b><br>';
							$rating1s = json_decode($value3['ratings'],true);
							$data['tb3'][$key3]['ratings'] = '';
							$total_rating = 0;
							foreach ($rating1s as $user1 => $rating1) {
								$total_rating += $rating1;
								$epm = $this->fetch_model->show(array('US'=> array('ID'=>$user1)),array('>>emp:>fr>SS>path:ID=^Image_ID^','Name'));
								$data['tb3'][$key3]['ratings'] .= '<img src="'.base_url($epm[0]['emp']).'" class="crlwName"> <b>'.$epm[0]['Name'].'</b> - '.$rating1.' points<div class="progress progress-mini"><div style="width: '.($rating1*10).'%;" class="progress-bar"></div></div><br>';
							}
						}
					}
				}
				$data['tb4'] = $this->fetch_model->show(array('TK'=>array('branch_ID'=>$branch_ID,'tStatus'=>'Completed')));
				if(!empty($data['tb4']))
				{
					foreach ($data['tb4'] as $key4 => $value4) {
						$assignedto = explode(',',$value4['assignTo']);
						unset($data['tb4'][$key4]['assignTo']);
						$data['tb4'][$key4]['assignTo'] = '';
						foreach ($assignedto as $assignto) {
							$epmData = $this->fetch_model->show(array('US'=> array('ID'=>$assignto)),array('>>emp:>fr>SS>path:ID=^Image_ID^','Name'));
							$data['tb4'][$key4]['assignTo'] .= '<img src="'.base_url($epmData[0]['emp']).'" class="crlwName"> <b>'.$epmData[0]['Name'].'</b><br>';
							$rating2s = json_decode($value4['ratings'],true);
							$total_rating = 0;
							foreach ($rating2s as $user2 => $rating2) {
								$total_rating += $rating2;
							}
							$data['tb4'][$key4]['avg_rating'] = $total_rating/count($rating2s);
						}
					}
				}	
			}
			return $data;
		}
	}

?>