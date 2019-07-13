<?php
	class List_model extends CI_Model{
		public function check($id=NULL,$login_as="Client")
		{
			$user = count($this->fetch_model->show(array('P' =>array('ID'=>$id))));
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
				redirect('clients/add/');
			}
		}

		public function get_details($branch_ID = NULL, $id = NULL)
		{
			$data = array();
			if ($this->data['Login']['Login_as']==='DSSK10000007') {
				$img_path = $this->str_function_library->call('fr>US>Added_by:ID=`'.$this->data['Login']['ID'].'`');
				// $data = $this->fetch_model->show(array('C'=>array('list_ID'=>$id,'assign_to'=>$this->data['Login']['ID'],'Added_by'=>$img_path)));
				$data['list'] = $this->fetch_model->show(array('C'=>array('list_ID'=>$id,'assign_to'=>$this->data['Login']['ID'])));

				/*$seniority = $this->fetch_model->show(array('US'=>array('ID'=>$this
					->data['Login']['ID'])));
				$seniority1 = empty($seniority[0]['seniority1_ID']) ? '-NA-' : $seniority[0]['seniority1_ID'];
				if ($seniority1 !== '-NA-') 
				{
					$seniority1name = $this->fetch_model->show(array('US'=>array('ID'=>$seniority1))); 	
				}
				else
				{
					$seniority1name[0]['ID'] = '-NA-';
					$seniority1name[0]['Name'] = '-NA-';
				}	
				$seniority2 = empty($seniority[0]['seniority2_ID']) ? '-NA-' : $seniority[0]['seniority2_ID']; 
				if ($seniority2 !== '-NA-') 
				{
					$seniority2name = $this->fetch_model->show(array('US'=>array('ID'=>$seniority2))); 	
				}
				else
				{
					$seniority2name[0]['ID'] = '-NA-';
					$seniority2name[0]['Name'] = '-NA-';
				}
				$seniority3 = empty($seniority[0]['seniority3_ID']) ? '-NA-' : $seniority[0]['seniority3_ID']; 
				if ($seniority3 !== '-NA-') 
				{
					$seniority3name = $this->fetch_model->show(array('US'=>array('ID'=>$seniority3))); 	
				}
				else
				{
					$seniority3name[0]['ID'] = '-NA-';
					$seniority3name[0]['Name'] = '-NA-';
				}
 				$data['seniority'] = array('0'=>array('ID'=>$seniority1name[0]['ID'],'Name'=>$seniority1name[0]['Name']),'1'=>array('ID'=>$seniority2name[0]['ID'],'Name'=>$seniority2name[0]['Name']),'2'=>array('ID'=>$seniority3name[0]['ID'],'Name'=>$seniority3name[0]['Name']));*/
 				$data['seniority'] = $this->fetch_model->show(array('US'=>array('branch_ID'=>$branch_ID)));

				if ($data)
				{
					return $data;
				}
				else
				{
					return false;
				}
			}
			else
			{
				// var_dump($id);,'Added_by'=>$this->data['Login']['ID']
				$data['list'] = $this->fetch_model->show(array('C'=>array('list_ID'=>$id)));
				/*$seniority = $this->fetch_model->show(array('US'=>array('ID'=>$this
					->data['Login']['ID'])));
				$seniority1 = empty($seniority[0]['seniority1_ID']) ? '-NA-' : $seniority[0]['seniority1_ID'];
				if ($seniority1 !== '-NA-') 
				{
					$seniority1name = $this->fetch_model->show(array('US'=>array('ID'=>$seniority1)));
				}
				else
				{
					$seniority1name[0]['ID'] = '-NA-';
					$seniority1name[0]['Name'] = '-NA-';
				}	
				$seniority2 = empty($seniority[0]['seniority2_ID']) ? '-NA-' : $seniority[0]['seniority2_ID']; 
				if ($seniority2 !== '-NA-') 
				{
					$seniority2name = $this->fetch_model->show(array('US'=>array('ID'=>$seniority2))); 	
				}
				else
				{
					$seniority2name[0]['ID'] = '-NA-';
					$seniority2name[0]['Name'] = '-NA-';
				}
				$seniority3 = empty($seniority[0]['seniority3_ID']) ? '-NA-' : $seniority[0]['seniority3_ID']; 
				if ($seniority3 !== '-NA-') 
				{
					$seniority3name = $this->fetch_model->show(array('US'=>array('ID'=>$seniority3)));
				}
				else
				{
					$seniority3name[0]['ID'] = '-NA-';
					$seniority3name[0]['Name'] = '-NA-';
				}*/
 				// $data['seniority'] = array('0'=>array('ID'=>$seniority1name[0]['ID'],'Name'=>$seniority1name[0]['Name']),'1'=>array('ID'=>$seniority2name[0]['ID'],'Name'=>$seniority2name[0]['Name']),'2'=>array('ID'=>$seniority3name[0]['ID'],'Name'=>$seniority3name[0]['Name']));
 				$data['seniority'] = $this->fetch_model->show(array('US'=>array('branch_ID'=>$branch_ID)));
				if ($data)
				{
					return $data;
				}
				else
				{
					return false;
				}
			}
			
		}

		public function chnageStatus($id,$status)
		{
			$this->load->model('form_model');
			if($status === 'lead')
			{
				$lead_call = $this->form_model->add(array('table'=>'LC','columns'=>array('contact_ID'=>$id)));
			}
			else if($status === 'customer')
			{
				$lead_call = $this->form_model->add(array('table'=>'CC','columns'=>array('contact_ID'=>$id)));
			}
			else
			{}
			if(array_key_exists('reason', $_POST))
			{
				$reason = $_POST['reason'];
			}
			else
			{
				$reason = NULL;
			}
			$result = $this->form_model->edit(array("table"=>"C","columns"=>array('call_Status'=>$status,'lead_reason_ID'=>$reason),"where"=>array('ID'=>$id)));
			if ($result)
			{
				/*if($status === 'called')
				{
					$this->form_model->delete(array('R'=>array('contactID'=>$id)));
				}*/
				$data = $this->fetch_model->show(array('C'=>array('ID'=>$id)));
				if($data[0]['lead_reason_ID'] != NULL)
				{
					$data[0]['lead_reason'] = $this->str_function_library->call('fr>LR>reason:ID=`'.$data[0]['lead_reason_ID'].'`');
				}
				return $data[0];
			}
			else
			{
				return false;
			}
		}

		public function getDetails($id)
		{
			$data = $this->fetch_model->show(array('C'=>array('ID'=>$id)));
			if ($data)
			{
				return $data[0];
			}
			else
			{
				return false;
			}
		}

		public function cmp($a,$b){
		    return strtotime($a['date'])<strtotime($b['date'])?1:-1;
		}

		public function call_recs($id)
		{
			
			$data['mainData'] = $this->fetch_model->show(array('C'=>array('ID'=>$id)),array('call_Status','ID','>>Added_Name:>fr>US>Name:ID=^Added_by^'));
			if ($data['mainData'] && $data['mainData'][0]['call_Status']==='abort') {
				$data['abortCntct'] = $this->fetch_model->show(array('AC'=>array('contact_ID'=>$id)),array('>>reasons:>fr>AR>reason:ID=^reason^','ID','>>Added_Name:>fr>US>Name:ID=^Added_by^'));
			}
			$data['recs'] = $this->fetch_model->show(array('CR'=>array('contact_ID'=>$id)),array('reason','date','contact_ID','ID','>>Added_Name:>fr>US>Name:ID=^Added_by^'));

			$data['recall'] = $this->fetch_model->show(array('R'=>array('contactID'=>$id,'Status'=>'A||P')));
			if ($data['recall']) {
				foreach ($data['recall'] as $key => $value) {
					$data['recall'][$key]['Added_Name']=$this->str_function_library->call('fr>US>Name:ID=`'.$value['Added_by'].'`');
					$data['recall'][$key]['date']=$value['Added_on'];
				}
			}
			$data['sms'] = $this->fetch_model->show(array('STR'=>array('contact_ID'=>$id)));
			if ($data['sms']) {
				foreach ($data['sms'] as $key => $value) {
					$data['sms'][$key]['Added_Name'] = $this->str_function_library->call('fr>US>Name:ID=`'.$value['Added_by'].'`');
					$data['sms'][$key]['date'] = $value['Added_on'];
				}
			}
			if (!empty($data['recs']) && !empty($data['recall']))
			{
				$data['meargeArray'] = array_merge($data['recs'],$data['recall']);
			}
			else
			{
				if (!empty($data['recs'])) {
					$data['meargeArray'] = $data['recs'];
				}
				elseif (!empty($data['recall'])) {
					$data['meargeArray'] = $data['recall'];
				}
				else
				{
					$data['meargeArray'] = array();
				}
			}
			if (!empty($data['sms']))
			{
				$data['meargeArray'] = array_merge($data['meargeArray'],$data['sms']);
			}
			usort($data['meargeArray'], array($this, 'cmp'));

			$cno = $this->fetch_model->show(array('C'=>array('ID'=>$id)),array('contact_No'));
			$data['contact_No'] = $cno[0]['contact_No'];
			if ($data)
			{
				return $data;
				//var_dump($data['recs']);
			}
			else
			{
				return false;
			}
			
		}

		public function updateInfo()
		{
			$this->load->model('form_model');
			$result = $this->form_model->edit(array("table"=>"C","columns"=>$_POST,"where"=>array('ID'=>$_POST['ID'])));
			if ($result)
			{
				// $data = $this->fetch_model->show(array('C'=>array('ID'=>$_POST['ID'])));
				return true;
			}
			else
			{
				return false;
			}
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
				$result = $this->form_model->edit(array("table"=>"C","columns"=>array('call_Status'=>$stat,'leadDescription'=>$_POST['description'],'assign_to'=>$assign_to),"where"=>array('ID'=>$_POST['contactID'])));
			}
			if ($result === true)
			{
				if ($stat === 'recall') {
					$id = $this->db_library->find_max_id('R');
					$result = $this->form_model->edit(array("table"=>"C","columns"=>array('call_Status'=>$stat,'recall_ID'=>$id,'assign_to'=>$assign_to),"where"=>array('ID'=>$_POST['contactID'])));
				}
				return true;
			}
			else
			{
				return false;
			}
		}

		public function getCount($id)
	 	{
			$e = $this->fetch_model->show(array('C'=>array('Added_by'=>$this->data['Login']['ID'],'list_ID'=>$id,'call_Status'=>'lead')),'count(ID)');
			$data['leads'] = $e[0]['count(ID)'];
			$f = $this->fetch_model->show(array('C'=>array('Added_by'=>$this->data['Login']['ID'],'list_ID'=>$id,'call_Status'=>'customer')),'count(ID)');
			$data['customer'] = $f[0]['count(ID)'];
			$g = $this->fetch_model->show(array('C'=>array('Added_by'=>$this->data['Login']['ID'],'list_ID'=>$id,'call_Status'=>'abort')),'count(ID)');
			$data['abort'] = $g[0]['count(ID)'];
			$h = $this->fetch_model->show(array('C'=>array('Added_by'=>$this->data['Login']['ID'],'list_ID'=>$id,'call_Status'=>'reject')),'count(ID)');
			$data['reject'] = $h[0]['count(ID)'];
			$i = $this->fetch_model->show(array('C'=>array('Added_by'=>$this->data['Login']['ID'],'list_ID'=>$id,'call_Status'=>'noResponce')),'count(ID)');
			$data['noResponce'] = $i[0]['count(ID)'];
			$j = $this->fetch_model->show(array('C'=>array('Added_by'=>$this->data['Login']['ID'],'call_Status'=>'customer')),'count(ID)');
			$data['totlCust'] = $j[0]['count(ID)'];
			
			return $data;
		}

		public function call_record()
	 	{
	 		$this->load->model('form_model');
	 		unset($_POST['ID']);
	 		$res = $this->form_model->add(array("table"=>"CR","columns"=>$_POST));
	 		return $res;
	 	}

	 	public function abort_contacts()
	 	{
	 		$this->load->model('form_model');
	 		unset($_POST['ID']);
	 		$res = $this->form_model->add(array("table"=>"AC","columns"=>$_POST));
	 		return $res;
	 	}

	 	public function get_sms_list($id)
	 	{
	 		$no = $this->fetch_model->show(array('C'=>array('ID'=>$id)),'contact_No');
	 		$recs['no'] = $no[0]['contact_No'];
	 		$recs['sms'] = $this->fetch_model->show('SM');
 			return $recs;
	 	}

	 	public function save_sms()
	 	{
	 		$this->load->model('form_model');
	 		$res = $this->form_model->add(array("table"=>"STR","columns"=>$_POST));
	 		return $res;
	 	}
	}
?>