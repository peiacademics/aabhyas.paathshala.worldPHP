<?php
	class Customer_model extends CI_Model
	{
		public function check($id=NULL,$login_as="Client")
		{
			$user = count($this->fetch_model->show(array('C' =>array('ID'=>$id))));
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
				$this->errorlog_library->entry('customer_model > check > argument id is invalid.');
				redirect('customer/add/');
			}
		}

		public function add_or_edit()
		{
			// var_dump($_POST);
			$num_row1 = $_POST['num_row1'];
			unset($_POST['num_row1']);
			foreach($_POST as $key => $value){
			    $exp_key = explode('-', $key);
			    if($exp_key[0] == 'C'){
			         $bt_arr[$exp_key[2]][$exp_key[1]] = $value;
			         $bt_arr[$exp_key[2]]['list_ID'] = $_POST['list_ID'];
			         $bt_arr[$exp_key[2]]['branch_id'] = $_POST['branch_id'];
			         $bt_arr[$exp_key[2]]['list_Name'] = $_POST['list_Name'];
			         $bt_arr[$exp_key[2]]['assign_to'] = $_POST['assign_to'];
			         $bt_arr[$exp_key[2]]['date'] = date('Y-m-d');
			    	 unset($_POST[$key]);
			    }
			}
			if(empty($_POST['ID']))
			{
				return $this->add($bt_arr);
			}
			else
			{
				return $this->edit($bt_arr,$num_row1,$ad_arr,$num_row2);
			}
		}

		public function add($bt_arr)
		{  
			$this->load->model('form_model');
			foreach ($bt_arr as $key => $value)
			{
				$add = $this->form_model->add(array("table"=>"C","columns"=>$value));
			}
			if ($add)
			{
				return TRUE;
			}
			else
			{
				return $add;
			}
		}

		public function edit($bt_arr,$num_row1,$ad_arr,$num_row2)
		{
			$this->load->model('form_model');
			$b_edit = $this->form_model->edit(array("table"=>"C","columns"=>$_POST,"where"=>array('ID'=>$_POST['ID'])));
			if($b_edit === TRUE)
			{
				$c = 0;
				$d = 0;
				$v = count($bt_arr);
				$a = count($ad_arr);
				$bt_c = 1;
				$ad_c = 1;
				$ph_id = "";
				$ad_id = "";
				$is_add = FALSE;
				foreach($bt_arr as $key => $columns)
				{
					if($c < $num_row1)
					{
						$result = $this->form_model->edit(array("table"=>"PH","columns"=>$columns,"where"=>array('ID'=>$columns['ID'])));
						$is_add = FALSE;
					}
					else
					{
						if(empty($columns['phone_number']))
						{
							$is_add = TRUE;
						}
						else
						{
							$result = $this->form_model->add(array("table"=>"PH","columns"=>$columns));
							$is_add = TRUE;
						}
					}
					if($result === TRUE)
					{
					    $ph_id .= ($is_add) ? $this->db_library->find_max_id('PH').',': $columns['ID'].',';
						$c++;
						$bt_c++;
					}
				}

				foreach($ad_arr as $key => $columns)
				{
					if($d < $num_row2)
					{
						$result = $this->form_model->edit(array("table"=>"AD","columns"=>$columns,"where"=>array('ID'=>$columns['ID'])));
						$is_add = FALSE;
					}
					else
					{
						$result = $this->form_model->add(array("table"=>"AD","columns"=>$columns));
						$is_add = TRUE;
					}
					if($result === TRUE)
					{
					    $ad_id .= ($is_add) ? $this->db_library->find_max_id('AD').',': $columns['ID'].',';
						$d++;
						$ad_c++;
					}
				}

				if($c == $v && $c != 0 && $d == $a && $d != 0)
				{
					$this->form_model->edit(array("table"=>"C","columns"=>array('phone_no_ID'=>$ph_id,'address_ID'=>$ad_id),'where'=>array('ID'=>$_POST['ID'])));
					return TRUE;
				}
				else
				{
					return $result;
				}
			}
			else
			{	
				return $b_edit;
			}
		}


 		public function get_bill_number($column,$added_by=NULL)
		{
				if(isset($this->data['Login']['ID']) && is_null($added_by))
				{
					$added_by = $this->data['Login']['ID'];
				}

				// // if(isset($this->data['Login']['ID']) && is_null($added_by))
				// // {
				// 	// $added_by = $this->data['Login']['ID'];
				// 	$added_by = $this->data['Login']['Added_by'];
				// // }
					// var_dump($this->data['Login']['Added_by']);
				$tbl = $this->db_library->get_tbl('C');

				$this->db->select_max($column);
				$bill_no = $this->db->get_where($tbl,array('Status'=>'A','Added_by'=>$added_by));
				$result = $bill_no->result_array();
				if(empty($result[0]['list_ID']))
				{
					return "LSSK10000001";
				}
				else
				{
					return $this->increment($result[0]['list_ID']);
				}
		}

		public function increment($str)
		{
			preg_match_all('!\d+!', $str, $matches);
			foreach ($matches as $key => $value) {
				$count = strlen(end($value));
				$strarr = str_split(end($value));
				$cd = 0;
				foreach(array_reverse($strarr) as $value) 
				{
					if($value == 9)
					{
						$cd++;
					}
					else
					{
						break;
					}
				}
				if($cd == 0)
				{
					$s[] = $strarr[$count-1] +1;  
				}
				else
				{
					for($n=1;$n<=$cd;$n++)
					{
						$a = $strarr[$count-$n-1];
						if(!array_key_exists($n, $strarr))
						{
							continue;
						}
						elseif($strarr[$count-$n] == 9)
						{
							$s[] = 0;
							if($strarr[$count-$n-1] == 9)
							{
								$s[] = 0;
							}
							else
							{
								$s[] = $a+1;
							}
						}
						else
						{
							$s[] = $strarr[$count-$n]+1;
						}
						if(count($s) != 1)
						{
							unset($s[$count-$n]);
						}
					}
					if(count($s) > 3)
					{
						unset($s[0]);
					}
				}
				$replace = strrev(implode("", $s));
				return substr_replace($str,$replace,-strlen($replace));
			}
		}


	public function importDatabase1($branch_ID = NULL)
	{
		if(($_POST['column-1'] == NULL) || ($_POST['column-2'] == NULL) || ($_POST['column-3'] == NULL))
		{
			return false;
		}
		if(!in_array('f_Name', $_POST) || !in_array('contact_No', $_POST))
		{
			return false;
		}
		$col1 = $_POST['column-1'];
		$col2 = $_POST['column-2'];
		$col3 = $_POST['column-3'];
		$columns = array();
		foreach ($_POST as $keyp => $valuep) {
			$exp_key = explode('-', $keyp);
		    if($exp_key[0] == 'column'){
		        $columns[$exp_key[1]][$exp_key[0]] = $valuep;
		        unset($_POST[$keyp]);
		    }
		}
		if (!extension_loaded('zip'))
		{
	    	if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') 
	    	{
	        	dl('php_zip.dll');
	    	}
    	 	else
    	 	{
	        	// dl('php_zip.so');
	    	}
		}
		$t = time();
		$date = date('Y-m-d');
		// $listName = "List-".$date."-".$t;
		$this->load->model('form_model');
		$this->load->library('PHPExcel');
		//$objReader= PHPExcel_IOFactory::createReader('Excel2007');
		//$objReader->setReadDataOnly(true);
		//$objReader->setIncludeCharts(TRUE);
		//var_dump($objReader);
		$listID = $this->customer_model->get_bill_number('list_ID',$this->data['Login']['ID']);
		$targetDir = "uploads/";
		$x = 0;
		foreach ($_FILES['file']['name'] as $key => $value) {
		$ext = explode('.', $value);
		$ext = $ext[1];
		if ($ext === 'xls' || $ext === 'xlt') 
		{
			$objReader = PHPExcel_IOFactory::createReader('Excel5');
		}
		else
		{
			$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		}
		$objReader->setReadDataOnly(true);
	   		$fileName = $value;
	    	$targetFile = $targetDir.$fileName;
	    	if(move_uploaded_file($_FILES['file']['tmp_name'][$x],getcwd().'/'.$targetFile)){
				$objPHPExcel = $objReader->load($targetFile);
				$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
					foreach ($cell_collection as $cell) {
					    $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
					}
				$objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
				$row_add = array();
				for($i=2; $i<=$row; $i++)
	            {
	            	foreach ($columns as $keyb => $valueb) {
	            		$_POST[$valueb['column']] = $objWorksheet->getCellByColumnAndRow(--$keyb,$i)->getValue();
	            	}
					unset($_POST['null']);
					unset($_POST['']);
					$_POST['list_ID'] = $listID;
					// $_POST['list_Name'] = $listName;
					$_POST['uploadedFileName'] = $fileName;
					$_POST['branch_id'] = $branch_ID;
					//$_POST['date'] = $this->date_library->date2db($date,$this->date_library->get_date_format());
					$_POST['date'] = $date;
					$add = $this->form_model->add(array("table"=>"C","columns"=>$_POST),array($col1=>array('rules'=> 'required'),$col2=>array('rules'=> 'required'),$col3=>array('rules'=> 'required')));
					if($add !== true)
					{
						return array('errormultiple' => $add);
					}
		        }
		    }
			$x++;
		}
		return true;
	}

	public function lists($id = NULL)
	{
		if ($this->data['Login']['Login_as'] === 'DSSK10000007') {
			$data = $this->fetch_model->show(array('C'=>array('assign_to'=>$this->data['Login']['ID'],'branch_id'=>$id)));
		}
		else if($this->data['Login']['Login_as'] === 'DSSK10000001')
		{
			$data = $this->fetch_model->show(array('C'=>array('branch_id'=>$id)));
		}
		else
		{
			$data = $this->fetch_model->show(array('C'=>array('Added_by'=>$this->data['Login']['ID'],'branch_id'=>$id)));
		}
		if ($data) {
			foreach($data as $k => $v) 
			{
			    foreach($data as $key => $value) 
			    {
			        if($k != $key && $v['list_Name'] == $value['list_Name'])
			        {
			            unset($data[$k]);
			        }
			    }
			}
			return $data;
		}
		else
		{
			return false;
		}
		
	}

	public function get_details1()
	{
		
		$data = $this->fetch_model->show(array('C'=>array('Added_by'=>$this->data['Login']['ID'],'call_Status'=>'customer')));
		if ($data)
		{
			foreach ($data as $key => $value) {
				$recall=$this->fetch_model->show(array('R'=>array('contactID'=>$value['ID'],'Status'=>'P')),'count(ID)');
				if ($recall){
					$data[$key]['recall']=$recall[0]['count(ID)'];
				}
				else
				{
					$data[$key]['recall']=0;
				}
			}
			return $data;
		}
		else
		{
			return false;
		}
	}

	public function lead_call_status($id,$status)
	{
		$this->load->model('form_model');
		if($status === 'lead')
		{
			$lead_call = $this->form_model->add(array('table'=>'LC','columns'=>array('contact_ID'=>$id)));
		}
		$result = $this->form_model->edit(array("table"=>"CC","columns"=>array('call_Status'=>$status),"where"=>array('contact_ID'=>$id)));
		if ($result)
		{
			$data = $this->fetch_model->show(array('C'=>array('ID'=>$id)));
			return $data[0];
		}
		else
		{
			return false;
		}
	}

	public function get_details($branch_ID = NULL)
	{
		$data['recs'] = $this->fetch_model->show(array('C'=>array('branch_ID'=>$branch_ID,'call_Status'=>'customer')));
		if ($data['recs'])
		{
			foreach ($data['recs'] as $key => $value) {
				$recall = $this->fetch_model->show(array('R'=>array('contactID'=>$value['ID'],'Status'=>'P')),'count(ID)');
				$lead_calls = $this->fetch_model->show(array('CC'=>array('contact_ID'=>$value['ID'])));
				if(($lead_calls != NULL) && !empty($lead_calls) && ($lead_calls != FALSE))
				{
					$data['recs'][$key]['cust_calls'] = $lead_calls[0];	
				}
				/*else
				{
					$data['recs'][$key]['cust_calls'] = NULL;
				}*/
				if ($recall){
					$data['recs'][$key]['recall'] = $recall[0]['count(ID)'];
				}
				else
				{
					$data['recs'][$key]['recall'] = 0;
				}
				// $data['recs'][$key]['lead_reason'] = $this->str_function_library->call('fr>LR>reason:ID=`'.$value['lead_reason_ID'].'`');
			}
			$data['seniority'] = $this->fetch_model->show(array('US'=>array('branch_ID'=>$branch_ID)));
			return $data;
		}
		else
		{
			return false;
		}
	}

	public function get_show_data2()
	{
		if($_POST['date'] != NULL)
		{
			$date = explode(' - ', $_POST['date']);
			$start = $this->date_library->date2db(trim($date[0]),'m/d/Y');
			$end = $this->date_library->date2db(trim($date[1]),'m/d/Y');
			if($_POST['user_ID'] != NULL)
			{
				$assign_to = $this->fetch_model->show(array('C'=>array('branch_id'=>$_POST['branch_ID'],'date >='=>$start,'date <='=>$end,'assign_to LIKE'=>'%'.$_POST['user_ID'].'%','Added_by not LIKE'=>'%'.$_POST['user_ID'].'%')),array('ID','call_Status','contact_No','date','assign_to','Added_by'));
				if(($assign_to == FALSE) || ($assign_to == NULL) || empty($assign_to))
				{
					$assign_to = array();
				}
				$added_by = $this->fetch_model->show(array('C'=>array('branch_id'=>$_POST['branch_ID'],'date >='=>$start,'date <='=>$end,'assign_to'=>'','Added_by LIKE'=>'%'.$_POST['user_ID'].'%')),array('ID','call_Status','contact_No','date','assign_to','Added_by'));
				if(($added_by == FALSE) || ($added_by == NULL) || empty($added_by))
				{
					$added_by = array();
				}
				$recs['data'] = array_merge($assign_to,$added_by);
			}
			else
			{
				$recs['data'] = $this->fetch_model->show(array('C'=>array('branch_id'=>$_POST['branch_ID'],'date >='=>$start,'date <='=>$end)),array('ID','call_Status','contact_No','date','assign_to','Added_by'));
			}
		}
		else
		{
			if($_POST['user_ID'] != NULL)
			{
				$assign_to = $this->fetch_model->show(array('C'=>array('branch_id'=>$_POST['branch_ID'],'assign_to LIKE'=>'%'.$_POST['user_ID'].'%','Added_by not LIKE'=>'%'.$_POST['user_ID'].'%')),array('ID','call_Status','contact_No','date','assign_to','Added_by'));
				if(($assign_to == FALSE) || ($assign_to == NULL) || empty($assign_to))
				{
					$assign_to = array();
				}
				$added_by = $this->fetch_model->show(array('C'=>array('branch_id'=>$_POST['branch_ID'],'assign_to'=>'','Added_by LIKE'=>'%'.$_POST['user_ID'].'%')),array('ID','call_Status','contact_No','date','assign_to','Added_by'));
				if(($added_by == FALSE) || ($added_by == NULL) || empty($added_by))
				{
					$added_by = array();
				}
				$recs['data'] = array_merge($assign_to,$added_by);
			}
			else
			{
				$recs['data'] = $this->fetch_model->show(array('C'=>array('branch_id'=>$_POST['branch_ID'])),array('ID','call_Status','contact_No','date','assign_to','Added_by'));
			}
		}
		if($recs['data'] != NULL && !empty($recs['data']))
		{
		 	foreach ($recs['data'] as $key => $value) {
		 		if($value['assign_to'] == NULL || empty($value['assign_to']))
		 		{
		 			$recs['data'][$key]['caller'] = $value['Added_by'];
		 		}
		 		else
		 		{
		 			$recs['data'][$key]['caller'] = $value['assign_to'];
		 		}
		 	}
			$blank_arr = array();
		 	foreach ($recs['data'] as $key1 => $value1) {
		 		if(array_key_exists($value1['caller'], $blank_arr) && array_key_exists($value1['call_Status'], $value1))
		 		{
		 			$blank_arr[$value1['caller']][$value1['call_Status']][] = $value1;
		 		}
		 		else
		 		{
		 			$blank_arr[$value1['caller']][$value1['call_Status']][] = $value1;
		 		}
		 	}
		 	$data = array();
		 	$i = 0;
		 	$abort = 0;
		 	$accept = 0;
		 	$blank = 0;
		 	$called = 0;
		 	$customer = 0;
		 	$lead = 0;
		 	$noResponce = 0;
		 	$recall = 0;
		 	$reject = 0;
		 	// print_r($blank);
		 	foreach ($blank_arr as $key2 => $value2) {
		 		$i++;
		 		$data['map'][$i]['Sr.No.'] = $i;
		 		$data['map'][$i]['Name'] = $this->str_function_library->call('fr>US>Name:ID=`'.$key2.'`');
		 		if(array_key_exists('abort', $value2))
		 		{
		 			$data['map'][$i]['abort'] = count($value2);
		 			$abort += count($value2);
		 		}
		 		else
		 		{
		 			$data['map'][$i]['abort'] = 0;
		 		}
		 		if(array_key_exists('accept', $value2))
		 		{
		 			$data['map'][$i]['accept'] = count($value2);
		 			$accept += count($value2);
		 		}
		 		else
		 		{
		 			$data['map'][$i]['accept'] = 0;
		 		}
		 		if(array_key_exists('blank', $value2))
		 		{
		 			$data['map'][$i]['blank'] = count($value2);
		 			$blank += count($value2);
		 		}
		 		else
		 		{
		 			$data['map'][$i]['blank'] = 0;
		 		}
		 		if(array_key_exists('called', $value2))
		 		{
		 			$data['map'][$i]['called'] = count($value2);
		 			$called += count($value2);
		 		}
		 		else
		 		{
		 			$data['map'][$i]['called'] = 0;
		 		}
		 		if(array_key_exists('customer', $value2))
		 		{
		 			$data['map'][$i]['customer'] = count($value2);
		 			$customer += count($value2);
		 		}
		 		else
		 		{
		 			$data['map'][$i]['customer'] = 0;
		 		}
		 		if(array_key_exists('lead', $value2))
		 		{
		 			$data['map'][$i]['lead'] = count($value2);
		 			$lead += count($value2);
		 		}
		 		else
		 		{
		 			$data['map'][$i]['lead'] = 0;
		 		}
		 		if(array_key_exists('noResponce', $value2))
		 		{
		 			$data['map'][$i]['noResponce'] = count($value2);
		 			$noResponce += count($value2);
		 		}
		 		else
		 		{
		 			$data['map'][$i]['noResponce'] = 0;
		 		}
		 		if(array_key_exists('recall', $value2))
		 		{
		 			$data['map'][$i]['recall'] = count($value2);
		 			$recall += count($value2);
		 		}
		 		else
		 		{
		 			$data['map'][$i]['recall'] = 0;
		 		}
		 		if(array_key_exists('reject', $value2))
		 		{
		 			$data['map'][$i]['reject'] = count($value2);
		 			$reject += count($value2);
		 		}
		 		else
		 		{
		 			$data['map'][$i]['reject'] = 0;
		 		}
		 	}
		 	$records = array();
		 	foreach ($data['map'] as $keyrecs => $valuerecs) {
		 		$records[] = array_values($valuerecs);
		 	}
		 	$data['records'] = $records;
		 	foreach ($data['map'] as $keymap => $valuemap) {
		 		unset($data['map'][$keymap]['Sr.No.']);
		 		unset($data['map'][$keymap]['Name']);
		 	}
		 	$data['map']['abort'] = $abort;
		 	$data['map']['accept'] = $accept;
		 	$data['map']['blank'] = $blank;
		 	$data['map']['called'] = $called;
		 	$data['map']['customer'] = $customer;
		 	$data['map']['lead'] = $lead;
		 	$data['map']['noResponce'] = $noResponce;
		 	$data['map']['recall'] = $recall;
		 	$data['map']['reject'] = $reject;
		}
		else
		{
			$data = array();
			$data['map']['abort'] = 0;
		 	$data['map']['accept'] = 0;
		 	$data['map']['blank'] = 0;
		 	$data['map']['called'] = 0;
		 	$data['map']['customer'] = 0;
		 	$data['map']['lead'] = 0;
		 	$data['map']['noResponce'] = 0;
		 	$data['map']['recall'] = 0;
		 	$data['map']['reject'] = 0;
		 	$data['records'] = 0;
		}
	 	// print_r($data);
	 	return $data;
	}

	public function recall()
	{
		$stat = $_POST['call_Status'];
		unset($_POST['call_Status']);
		$this->load->model('form_model');
		if ($stat === 'recall')
		{
			$_POST['Timestamp'] = time();
			if(array_key_exists('Interval', $_POST))
			{
				if(($_POST['Interval'] === NULL) || empty($_POST['Interval']))
				{
					$futureDate = date("Y-m-d H:i:s", strtotime("+1 day"));
					$_POST['alertTime'] = $futureDate;
				}
				else
				{
					$_POST['Interval'] = date("Y-m-d H:i:s", strtotime($_POST['Interval']));
					$_POST['alertTime'] = $_POST['Interval'];
				}
			}
			else
			{
				$futureDate = date("Y-m-d H:i:s", strtotime("+1 day"));
				$_POST['alertTime'] = $futureDate;
			}
			if(($_POST['description'] === NULL) || empty($_POST['description']))
			{
				$_POST['description'] = 'Conveyed message on.';
			}
			$assign_to = $_POST['assign_to'];
			unset($_POST['assign_to']);
			$result = $this->form_model->add(array("table"=>"R","columns"=>$_POST));
		}
		else
		{
			/*$result = $this->form_model->edit(array("table"=>"C","columns"=>array('leadDescription'=>$_POST['description'],'assign_to'=>$_POST['assign_to']),"where"=>array('ID'=>$_POST['contactID'])));
			$result_lead = $this->form_model->edit(array("table"=>"CC","columns"=>array('call_Status'=>$stat),"where"=>array('contact_ID'=>$_POST['contactID'])));*/
			$result_lead = $this->form_model->add(array("table"=>"CC","columns"=>array('call_Status'=>$stat)));
		}
		if ($result === true)
		{
			if ($stat === 'recall') {
				$id = $this->db_library->find_max_id('R');
				/*$result = $this->form_model->edit(array("table"=>"C","columns"=>array('recall_ID'=>$id,'assign_to'=>$assign_to),"where"=>array('ID'=>$_POST['contactID'])));
				$result_lead = $this->form_model->edit(array("table"=>"CC","columns"=>array('call_Status'=>$stat),"where"=>array('contact_ID'=>$_POST['contactID'])));*/
				$result_lead = $this->form_model->add(array("table"=>"CC","columns"=>array('call_Status'=>$stat)));
			}
			return true;
		}
		else
		{
			return false;
		}
	}
}
?>