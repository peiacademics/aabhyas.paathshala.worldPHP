<?php
	class Team_model extends CI_Model
	{
		public function check($id=NULL,$login_as="Client")
		{
			$user = count($this->fetch_model->show(array('US' =>array('ID'=>$id))));
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
				$this->errorlog_library->entry('team_model > check > argument id is invalid.');
				redirect('team/add/');
			}
		}

		public function cmp($a,$b){
		    return strtotime($a['start_time'])<strtotime($b['start_time'])?1:-1;
		}

		public function get_details2($id = NULL)
		{
			$date = date("Y-m");
			$data = $this->fetch_model->show(array('US' =>array('ID'=>$id,'Type !='=>'DSSK10000001')));
			if ($data){
				$data['What'] = 'Edit'; 
				$data['List']['Phone'] = $this->fetch_model->get_multiadd_data('PH',$data[0]['phone_no_ID']);
				$data['List']['Address'] = $this->fetch_model->get_multiadd_data('AD',$data[0]['address_ID']);
				$doc = $this->fetch_model->get_multiadd_data('SS',trim($data[0]['document_ID']));
				$data['doc'] = $doc;
				$tasks = $this->fetch_model->show(array('TK'=>array('assignTo'=>$id)));
				$classes = $this->fetch_model->show(array('CL'=>array('professor_ID'=>$id)));
				foreach ($classes as $keyc => $valuec) {
					$classes[$keyc]['start_time'] = $valuec['start_date'];
				}
				$data['Task'] = array_merge($tasks,$classes);
				usort($data['Task'], array($this, 'cmp'));
				foreach ($data['Task'] as $key => $value) {
					$type = explode('SK', $value['ID']);
					if($type[0] === 'TK')
					{
						$data['Task'][$key]['type'] = 'Task';
						$data['Task'][$key]['assigned_by'] = $this->str_function_library->call('fr>US>Name:ID=`'.$value['assigned_by'].'`');
					}
					else
					{
						$data['Task'][$key]['type'] = 'Class';
						$data['Task'][$key]['Class_ID'] = $this->str_function_library->call('fr>BT>name:ID=`'.$value['Class_ID'].'`');
						$data['Task'][$key]['Subject'] = $this->str_function_library->call('fr>SB>name:ID=`'.$value['Subject'].'`');
					}
					$image_ID = $this->str_function_library->call('fr>US>Image_ID:ID=`'.$value['Added_by'].'`');
					$data['Task'][$key]['path'] = $this->str_function_library->call('fr>SS>path:ID=`'.$image_ID.'`');
					$data['Task'][$key]['user'] = $this->str_function_library->call('fr>US>Name:ID=`'.$value['Added_by'].'`');
				}
			}
			return $data;
		}

		public function get_details($id,$date=null)
		{
			$date=date("Y-m");
			$data=$this->fetch_model->show(array('US' =>array('ID'=>$id)));
			if ($data)
			{
				$data['What'] = 'Edit'; 
				$data['List']['Phone'] = $this->fetch_model->get_multiadd_data('PH',$data[0]['phone_no_ID']);
				$data['List']['Address'] = $this->fetch_model->get_multiadd_data('AD',$data[0]['address_ID']);
				$doc =$this->fetch_model->get_multiadd_data('SS',trim($data[0]['document_ID']));
				$data['doc']=$doc;

				// $designation=$this->fetch_model->show(array('DS'=>array('ID'=>$data[0]['Type'])));
				// $branch=$this->fetch_model->show(array('BR'=>array('ID'=>$data[0]['branch_ID'])));
				$data['designation']=$data[0]['Type'];
				$data['branch']=$data[0]['branch_ID'];
				$data['seniority1']=$data[0]['seniority1_ID'];
				$data['seniority2']=$data[0]['seniority2_ID'];
				$data['seniority3']=$data[0]['seniority3_ID'];
			}
			/*echo "<pre>";
			var_dump($data);
			echo "</pre>";*/
			return $data;
		}

		public function attendance($id=null,$date=null)
		{
			$date=($date===null || $date==='undefined') ? date('Y-m') : $date ;
			$attendance=$this->fetch_model->show(array('AT' =>array('employee_ID'=>$id,'date LIKE'=>'%'.@$date.'%',)),array('date','time','employee_ID'));
			if ($attendance) {
				$attendance=$this->status($attendance);
				foreach ($attendance as $key => $value) {
					$arr[]= (object)array('title'=>(isset($value['status']))? $value['status'] : '-','start'=>$value['date']." ".$value['time'],'color'=>$value['color']);
				}
				return $arr;
			}
			else
			{
				$date=explode("-", $date);
				$month=$this->getDatesFromMonth($date[0],$date[1]);
				$att=$this->fetch_model->show('AT');
	 			$lastEntry=end($att);
	 			$lastEntry=explode(" ", $lastEntry['Added_on']);
	 			$arr=array();
	 			foreach ($month as $key => $value) {
	 				if ($lastEntry[0]>$value) {
						$arr[]= (object)array('title'=>'Absent','start'=>$value,'color'=>'red');
	 				}

	 			}
				return $arr;
			}
		}

		public function status($data)
		{
			foreach ($data as $key => $value) {
					// print_r($value);
					$data[$key]['status']="In";
					$x=0;
		 			foreach ($data as $k => $v) {
		 				if ($k != $key && $value['date'] === $v['date'] && $value['employee_ID'] === $v['employee_ID']) {
			 					if ($x%2===0) {
			 						$data[$k]['status']="In";
			 						$data[$key]['status']="Out";
				 					$x++;
			 					}
			 					else
			 					{
			 						$data[$k]['status']="Out";
				 					$data[$key]['status']="In";
				 					$x++;
								}
		 					}
		 			}
		 		}

	 		return $this->getEventColor($data);
		}

		public function getEventColor($data)
		{
			foreach ($data as $key => $value) {
				if ($value['status']==='In') {
					$data[$key]['color']="#1c84c6";
				}
				else
				{
					$data[$key]['color']="#f8ac59";
				}
			}
			return $data;
		}

		public function checkUniqEmail()
		{
			if (!empty($_POST['Email'])) {
				$emailPresentInLead=$this->fetch_model->show(array("US" =>array('Email'=>$_POST['Email'])));
				if ($emailPresentInLead) {
					$email=$this->fetch_model->show(array("US" =>array('ID'=>@$_POST['ID'])));
					if ($email) {
						if ($email[0]['Email']===$_POST['Email']) {
							return true;
						}
						else
						{
							return array('error'=>'Email Is already present in Employee');
						}
					}
					else
					{
						return array('error'=>'Email Is already present in Employee');
					}
				}
				else
				{
					// $emailPresentInCust=$this->fetch_model->show(array("C" =>array('email'=>$_POST['Email'])));
					// if ($emailPresentInCust) {
						// return array('error'=>'Email Is already present');
					// }
					// else
					// {
						return true;
					// }
				}
			}
			else
			{
				return true;
			}
			
		}

		public function add_or_edit()
		{
			$num_row1 = $_POST['num_row1'];
			$num_row2 = $_POST['num_row2'];	
			unset($_POST['num_row1']);
			unset($_POST['num_row2']);
			if(array_key_exists('subject_ID', $_POST) == FALSE)
			{
				$_POST['subject_ID'] = NULL;
			}
			$d=$this->checkUniqEmail();
			if ($d===true) 
			{
				foreach($_POST as $key => $value){
				    $exp_key = explode('-', $key);
				    if($exp_key[0] == 'PH'){
				         $bt_arr[$exp_key[2]][$exp_key[1]] = $value;
				    	 unset($_POST[$key]);
				    }
				    else if($exp_key[0] == 'AD'){
				         $ad_arr[$exp_key[2]][$exp_key[1]] = $value;
				    	 unset($_POST[$key]);
				    }
				    else if($exp_key[0] == 'DC')
				    {
				         $docID[$exp_key[2]][$exp_key[1]] = $value;
				    	 unset($_POST[$key]);
				    }
				}
				if(empty($_POST['ID']))
				{
					return $this->add($bt_arr,$ad_arr,$docID);
				}
				else
				{
					return $this->edit($bt_arr,$num_row1,$ad_arr,$num_row2,$docID);
				}
			}
			else
			{
				return $d;
			}	
		}

		public function add($bt_arr,$ad_arr,$docID)
		{
			$this->load->model('form_model');
			unset($_POST['ID']);
			$_POST['document_ID']='';
			foreach ($docID as $key => $value) {
				$_POST['document_ID'] .= $value['document_ID'].',';
			}
			if (empty($_POST['Image_ID'])) 
			{
				$_POST['Image_ID'] = 'SSSK10000001';
			}
			$b_add = $this->form_model->add(array("table"=>"US","columns"=>$_POST));
			if($b_add === TRUE)
			{
				$c = 0;
				$d = 0;
				$ph_id = '';
				$ad_id = '';
				$v = count($bt_arr);
				$a = count($ad_arr);
				foreach($bt_arr as $key => $columns)
				{
					if(empty($columns['phone_number']))
					{
						$c++;
						continue;
					}
					else
					{
						$columns['person_ID'] = $this->db_library->find_max_id('US');
						$result1 = $this->form_model->add(array("table"=>"PH","columns"=>$columns));
						if($result1 === TRUE)
						{
							$ph_id .= $this->db_library->find_max_id('PH').',';
							$c++;
						}
						else
						{
							$this->form_model->delete(array('US' => array('ID'=>$this->db_library->find_max_id('US'))));						
						}
					}
				}
				foreach($ad_arr as $key1 => $columns1)
				{
					$columns1['person_ID'] = $this->db_library->find_max_id('US');
					$result = $this->form_model->add(array("table"=>"AD","columns"=>$columns1));
					if($result === TRUE)
					{
						$ad_id .= $this->db_library->find_max_id('AD').',';
						$d++;
					}
					else
					{
						$this->form_model->delete(array('US' => array('ID'=>$this->db_library->find_max_id('US'))));						
					}
				}
				if($c == $v && $c != 0 && $d == $a && $d != 0)
				{
					$this->form_model->edit(array("table"=>"US","columns"=>array('phone_no_ID'=>$ph_id,'address_ID'=>$ad_id),'where'=>array('ID'=>$this->db_library->find_max_id('US'))));
					return TRUE;
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

		public function edit($bt_arr,$num_row1,$ad_arr,$num_row2,$docID)
		{
			$USER = $_POST;
			$this->load->model('form_model');
			$_POST['document_ID']='';
			foreach ($docID as $key => $value) {
				$_POST['document_ID'] .= $value['document_ID'].',';
			}
			/*echo "<pre>";
			var_dump($_POST);
			echo "</pre>";*/
			$b_edit = $this->form_model->edit(array("table"=>"US","columns"=>$_POST,"where"=>array('ID'=>$_POST['ID'])));
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
					$result = FALSE;
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
							//$result = TRUE;//continue;
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
					$this->form_model->edit(array("table"=>"US","columns"=>array('phone_no_ID'=>$ph_id,'address_ID'=>$ad_id),'where'=>array('ID'=>$_POST['ID'])));

					// $USER['Type'] = "Client";
					// unset($USER['ID']);
					// unset($USER['project_name']);
					// $result2 = $this->form_model->edit(array("table"=>"US","columns"=>array('Type'=>$USER['Type'],'Name'=>$USER['name'],'Email'=>$USER['email'],'Password'=>$USER['password']),'where'=>array('ID'=>$data['user'][0]['ID'])));

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

		public function delete($item_id=NULL)
	 	{	/*echo "<pre>";
	 		var_dump($item_id);
	 		echo "</pre>";*/
	 		$this->load->model('form_model');
	 		$del = $this->form_model->delete(array('US' => array('ID' => $item_id)));
	 		if($del == TRUE)
	 		{
	 			return TRUE;
	 		}
	 		else
			{
				$this->errorlog_library->entry('Team_model > delete > Employee record is not getting deleted.');
				return FALSE;
			}
	 	}

	 	public function deletes($item_id=NULL)
	 	{	/*echo "<pre>";
	 		var_dump($item_id);
	 		echo "</pre>";*/
	 		$this->load->model('form_model');
	 		$del = $this->form_model->delete(array('SL' => array('ID' => $item_id)));
	 		if($del == TRUE)
	 		{
	 			return TRUE;
	 		}
	 		else
			{
				$this->errorlog_library->entry('Team_model > deletes > Salary record is not getting deleted.');
				return FALSE;
			}
	 	}

	 	public function getDatesFromMonth($year,$month)
	 	{
	 		$list=array();
			for($d=1; $d<=31; $d++)
			{
			    $time=mktime(12, 0, 0, $month, $d, $year);          
			    if (date('m', $time)==$month)       
			        $list[]=date('Y-m-d', $time);
			        // $list[]=date('Y-m-d-D', $time);
			}
			return $list;
	 	}

	 	public function getHolidays($year,$month)
	 	{
	 		$dates=$this->getDatesFromMonth($year,$month);
	 		if ($dates) {
	 			foreach ($dates as $key => $value) {
	 			// print_r($value);
		 			$attendance=$this->fetch_model->show(array('AT' =>array('date LIKE'=>'%'.@$value.'%')));
		 			if (empty($attendance)) {
		 				$arr[]=$value;
		 			}
		 		}

		 		return $arr;
	 		}
	 		else
	 		{
	 			return false;
	 		}
	 	}

	 	public function getPresentDay($id,$year,$month)
	 	{
	 		// print_r($id);
	 		// print_r(@$year."-".@$month);
	 		$attendance=$this->fetch_model->show(array('AT' =>array('employee_ID'=>$id,'date LIKE'=>'%'.@$year."-".@$month.'%')));
	 		if ($attendance){
	 			foreach ($attendance as $key => $value) {
		 			foreach ($attendance as $k => $v) {
		 				if ($k != $key && $value['date'] === $v['date']) {
								unset($attendance[$key]);
							}
		 			}
		 		}
		 		return $attendance;
	 		}
	 		else
	 		{
	 			return false;
	 		}
	 	}


	 	public function getFullMonthData($id,$year,$month)
	 	{
	 		$dates=$this->getDatesFromMonth($year,$month);
	 		if ($dates) {
	 			$newDate=array();
	 			foreach ($dates as $key => $value) {
		 			$attendance=$this->fetch_model->show(array('AT' =>array('employee_ID'=>$id,'date LIKE'=>'%'.@$value.'%')),'time');
		 			// $newDate[$key]["date"]=$this->date_library->db2date($value,$this->date_library->get_date_format());
		 			$newDate[$key]["date"]=$value;
		 			$newDate[$key]["attendance"]=$attendance;
		 		}
		 		return $this->addStatus($newDate,$year,$month,$id);

	 		}
	 		else
	 		{
	 			return false;
	 		}
	 	}

	 	public function addStatus($data,$year,$month,$id)
	 	{
	 		$att=$this->fetch_model->show('AT');
	 		$lastEntry=end($att);
	 		$time='10:00';
	 		$holidays=$this->getHolidays($year,$month);
	 		// print_r($holidays);
	 		foreach ($data as $key => $value) {
	 			foreach ($holidays as $k => $v) {
	 				if ($value['date']===$v) {
	 					$data[$key]['Status']="holiday";
	 					$data[$key]['isLate']="Holiday";
	 				}
	 			}
	 		}
			
			foreach ($data as $key => $value) {
				if ($lastEntry['Added_on']<$value['date']) {
					$data[$key]['isLate']="Data Not Found.";
				}
				if (count($value['attendance'])===1) {
					$data[$key]['Status']="Hypothetical";
					if ($value['attendance'][0]['time']>$time) {
						$data[$key]['isLate']="Late";
					}
					else
					{
						$data[$key]['isLate']="Hypothetical";
					}
				}
				if (empty($value['attendance']) && @$value['Status']!=='holiday') {
					$data[$key]['Status']="-";
					$data[$key]['isLate']="Absent";
				}
				if (count($value['attendance'])>1) {
					$endTime=end($value['attendance']);
					$endTime=$endTime['time'];
					$houres=$this->getHoures($value['attendance'][0]['time'],$endTime);
					$data[$key]['Status']=$houres;
					if ($value['attendance'][0]['time']>$time) {
						$data[$key]['isLate']="Late";
					}
					else
					{
						$data[$key]['isLate']="<span class='label label-primary'><i class='fa fa-check'></i></span>";
					}
				}
				// print_r($data);
			}
			return $this->modification($data);
			
	 	}

	 	public function modification($data)
	 	{
	 		foreach ($data as $key => $value) {
	 			$data[$key]['ogDate']=$value['date'];
				$data[$key]['date']=$this->date_library->db2date($value['date'],$this->date_library->get_date_format());
				if ($value['isLate']==='holiday' || $value['isLate']==='Holiday') {
					$data[$key]['isLate']="<span class='label label-info'>".$value['isLate']."</span>";
				}
				if ($value['isLate']==='Late') {
						$data[$key]['isLate']="<span class='label label-warning'>".$value['isLate']."</span>";
				}
				 if ($value['isLate']==='Absent') {
					$data[$key]['isLate']="<span class='label label-danger'>".$value['isLate']."</span>";
				}
				if ($value['Status']==='holiday') {
					$data[$key]['Status']='-';
				}

				if ($value['Status']!=='-' && $value['Status']!=='holiday' && $value['Status']!=='Hypothetical') {
					$data[$key]['Status']='<span class="fa fa-clock-o"></span> '.$value['Status']." hrs";
				}
				// var_dump($value['Status']);
			}

			return $data;
	 	}
	 	public function getHoures($time1,$time2)
	 	{
			list($hours, $minutes) = explode(':', $time1);
			$startTimestamp = mktime($hours, $minutes);

			list($hours, $minutes) = explode(':', $time2);
			$endTimestamp = mktime($hours, $minutes);

			$seconds = $endTimestamp - $startTimestamp;
			$minutes = ($seconds / 60) % 60;
			$hours = floor($seconds / (60 * 60));
			return $hours.":".$minutes;
	 	}

	 	public function addSalary()
	 	{
	 		$this->load->model('form_model');
	 		foreach($_POST as $key => $value){
			    $exp_key = explode('-', $key);
			    if($exp_key[0] == 'PP'){
			        $bt_arr[$exp_key[2]][$exp_key[1]] = $value;
			    	unset($_POST[$key]);
			    }
			}
			$isPresent=$this->fetch_model->show(array('SL' =>array('employee_ID'=>$_POST['employee_ID'],'date LIKE'=>'%'.@$_POST['date'].'%')));
			if (empty($isPresent)) {
				$result = $this->form_model->add(array("table"=>"SL","columns"=>$_POST));
				if ($result === true) {
					foreach ($bt_arr as $key => $value) {
						$value['salary_ID'] = $this->db_library->find_max_id('SL');
						$addPerticular=$this->form_model->add(array("table"=>"SLP","columns"=>$value));
					}
					if ($addPerticular) {
						$send=$this->sendMailToUser($_POST['employee_ID'],$this->db_library->find_max_id('SL'),$_POST['date']);
						if ($send===true) {
							return true;
						}
						else
						{
							return $send;
						}
						
					}
					else
					{
						return $addPerticular;
					}
				}
				else
				{
					return $result;
				}
			}
			else
			{
				return array('date'=>'The date field must contain a unique value.');
			}
	 	}

	 	public function get_show_data($input,$output)
		{
		 	$this->load->library('datatable_library');
	 		return $this->datatable_library->get_data($input,$output);
		}


		public function get_print_details($id)
		{
			$data = array();
			$data['detailsEarnings']=$this->fetch_model->show(array('SLP'=>array('salary_ID'=>$id,'amountType'=>'E')));
			$data['detailsDeductions']=$this->fetch_model->show(array('SLP'=>array('salary_ID'=>$id,'amountType'=>'D')));
			$data['DETAILS2']=$this->fetch_model->show(array('SL'=>array('ID'=>$id)));
			$data['customer'] = $this->fetch_model->show(array('EP'=>array('ID'=>$data['DETAILS2'][0]['employee_ID'])),array('employee_ID','Name','>>designation:>fr>DS>post:ID=^Position_ID^'));
			if (!empty($data['DETAILS2'][0]['Total_Amount'])) 
			{
				$this->load->model('bill_model');
				$data['DETAILS2'][0]['words'] = $this->bill_model->convert_number($data['DETAILS2'][0]['Total_Amount']);

				$monthNum  = explode('-', $data['DETAILS2'][0]['date']);
				$data['DETAILS2'][0]['year'] = $monthNum[0];
				// $data['totalDaysOfMonth']=count($this->getDatesFromMonth($monthNum[0],$monthNum[1]));
				$_POST['id']=$data['DETAILS2'][0]['employee_ID'];
				$_POST['date']=$data['DETAILS2'][0]['date'];
				$data['attData']=$this->getAttenceData();
				$monthNum=$monthNum[1];
				$dateObj   = DateTime::createFromFormat('!m', $monthNum);
				$data['DETAILS2'][0]['month'] = $dateObj->format('F');
			}
			$data['USER']=$this->fetch_model->show(array('US'=>array('ID'=>$this->data['Login']['ID'])),array('Company_Name','Address','Contact','Email','Image_ID','vat_tin_no','cst_tin_no','ID','T_C'));
			$data['Img']=$this->fetch_model->show(array('SS'=> array('ID'=>$data['USER'][0]['Image_ID'])));
			return $data;
		}


	public function getAttenceData()
 	{
 		$id=$_POST['id'];
 		$date=$_POST['date'];
 		$date=explode('-', $date);
 		$year=$date[0];
 		$month=$date[1];
 		$data['ttlDays']=count($this->team_model->getDatesFromMonth($year,$month));
 		$data['holidays']=count($this->team_model->getHolidays($year,$month));
 		if ($this->team_model->getPresentDay($id,$year,$month)!==false) {
 			$data['presentDay']=count($this->team_model->getPresentDay($id,$year,$month));
 			$data['workingDays']=$data['ttlDays']-$data['holidays'];
	 		$data['percent']=($data['presentDay']/$data['workingDays'])*100;
 		}
 		else
 		{
 			$data['presentDay']=0;
 			$data['workingDays']=$data['ttlDays']-$data['holidays'];
 			$data['percent']=0;
 		}
 		$data['absentDay']=$data['workingDays']-$data['presentDay'];

 		$data['dataTable']=$this->team_model->getFullMonthData($id,$year,$month);
 		$data['attendance']=$this->attendance($id,$year."-".$month);
 		return $data;
 	}


 	public function sendMailToUser($id,$salary_ID,$date)
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
 					$empl=$this->fetch_model->show(array('EP' =>array('employee_ID'=>$id)),array('Name','employee_ID','phone_no_ID','address_ID','Position_ID','img_ID','details','ID','Email'));
 					if (!empty($empl[0]['Email']))
 					{
 						$da['click']="Dear ".$empl[0]['Name']." <p> Please check the Salary Slip of ".$date." is given. To see the details please download given attachment</p><p>For any kind of Question/Discrepancy please revert us back</p>";
 						$da['DETAIL'] = $this->get_print_details($salary_ID);
 						$html = $this->load->view('messages/invoice_mail_view',$da,TRUE);

 						$this->load->helper(array('dompdf', 'file'));
 						$da['download'] = 'yes';
						$save = $this->load->view('others/salary_mail_view',$da,TRUE);
						$name=time().$salary_ID;
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
				        $this->email->to($empl[0]['Email']); 
				        $this->email->subject('SkyQ Salary Slip');
				        $this->email->message($html);
				        $this->email->attach(getcwd().'/sendMails/'.$name.'.pdf');
						if(@$this->email->send())
						{
							unlink(getcwd().'/sendMails/'.$name.'.pdf');
							return true;
						}
						else
						{
 							return (array("email"=>"Something went wrong in yout Email setting Please Check your Email setting <a href='".base_url('Settings/email_setting')."'>Click here</a> to Check"));
							// echo show_error($this->email->print_debugger());
						}
 					}
 					else
 					{
 						return (array("email"=>"Email is must"));
 					}
 				}
 				else
 				{
 					return (array("email"=>"Must have to configure your Email setting <a href='".base_url('Settings/email_setting')."'>Click here</a> to Configure"));
 				}
 			}
 			else
 			{
 				return (array("email"=>"Must have to configure your Email setting <a href='".base_url('Settings/email_setting')."'>Click here</a> to Configure"));
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

		public function delete_File($id,$employee)
		{
			$this->load->model('form_model');
			$result=$this->form_model->delete(array('SS' => array('ID' => $id)));
			$docID = $this->str_function_library->call('fr>US>document_ID:ID=`'.$employee.'`');
			if ($docID) {
				$docID=explode(',',trim($docID,','));
				$doc='';
				foreach ($docID as $key => $value) {
					if ($value!==$id) {
						$doc .=$value.',';
					}
				}
				$b_add = $this->form_model->edit(array("table"=>'US',"columns"=>array('document_ID'=>$doc),"where"=>array('ID'=>$employee)));
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
    		// var_dump($_FILES);
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
	        		return $this->db_library->find_max_id('SS');;
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

    public function get_student_doubts($branch_ID)
    {
    	if($this->data['Login']['Login_as'] == 'DSSK10000001')
		{
    		$team = $this->fetch_model->show(array('DR'=>array('branch_ID'=>$branch_ID,'doubt_status'=>'raised')));
    	}
    	else
    	{
    		$id = $this->data['Login']['ID'];
    		$subs = $this->str_function_library->call('fr>US>subject_ID:ID=`'.$id.'`');
    		if($subs != NULL)
    		{
    			$user_sub = explode(',', $subs);
    			foreach ($user_sub as $key_as => $value_as) {
					$sub_ids[] = $value_as;
				}
				$ids = implode('||', $sub_ids);
    			$team = $this->fetch_model->show(array('DR'=>array('branch_ID'=>$branch_ID,'doubt_status'=>'raised','subject_ID'=>$ids)));
    		}
    		else
    		{
    			$team = NULL;
    		}
    	}
    	if($team != NULL)
    	{
			foreach ($team as $key => $value) {
				$student = $this->fetch_model->show(array('ST'=>array('ID'=>$value['student_ID'])));
				foreach ($student as $key_st => $value_st) {
					$team[$key]['name'] = $value_st['Name'].' '.$value_st['Middle_name'].' '.$value_st['Last_name'];
					$team[$key]['path'] = $this->str_function_library->call('fr>SS>path:ID=`'.$value_st['img_ID'].'`');
				}
			}
		}
		return $team;
    }

    public function resolve_doubt()
	{
		$this->load->model('form_model');
		$doubt_record = $this->fetch_model->show(array('DR'=>array('ID'=>$_POST['ID'])));
		$doubt = $this->fetch_model->show(array('DB'=>array('ID'=>$doubt_record[0]['doubt_ID'])));
		$solved_doubts = $doubt[0]['solved_doubts'];
		$solved_doubts++;
		$doubt_change = $this->form_model->edit(array("table"=>'DB',"columns"=>array('solved_doubts'=>$solved_doubts),"where"=>array('ID'=>$doubt_record[0]['doubt_ID'])));
		if($doubt_change == TRUE)
		{
			$doubt_resolved = $this->form_model->edit(array("table"=>'DR',"columns"=>array('doubt_status'=>'solved','solved_by_ID'=>$this->session_library->get_session_data('ID'),'solved_on'=>date('Y-m-d H:i:s')),"where"=>array('ID'=>$_POST['ID'])));
			return $doubt_resolved;
		}
		else
		{
			return FALSE;
		}
	}

	public function add_or_edit_award()
	{
		$_POST['date'] = date("Y-m-d H:i:s", strtotime($_POST['date']));
		$this->load->model('form_model');
		if(empty($_POST['ID']))
		{
			unset($_POST['ID']);
			$result = $this->form_model->add(array("table"=>"EA","columns"=>$_POST));
		}
		else
		{
			$result = $this->form_model->edit(array("table"=>"EA","columns"=>$_POST,"where"=>array('ID'=>$_POST['ID'])));
		}				
		return $result;
	}

	public function get_proff_status()
	{
		$res = $this->fetch_model->show(array('DS'=>array('ID'=>$_POST['ID'])));
		// var_dump($res);
		return $res;
	}

}
?>