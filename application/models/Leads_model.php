<?php
	class leads_model extends CI_Model
	{


		public function get_details($branch_ID = NULL)
		{
			$data['recs'] = $this->fetch_model->show(array('C'=>array('branch_ID'=>$branch_ID,'call_Status'=>'lead')));
			if ($data['recs'])
			{
				foreach ($data['recs'] as $key => $value) {
					$recall = $this->fetch_model->show(array('R'=>array('contactID'=>$value['ID'],'Status'=>'P')),'count(ID)');
					$lead_calls = $this->fetch_model->show(array('LC'=>array('contact_ID'=>$value['ID'])));
					if(($lead_calls != NULL) && !empty($lead_calls) && ($lead_calls != FALSE))
					{
						$data['recs'][$key]['lead_calls'] = $lead_calls[0];
					}
					else
					{
						$data['recs'][$key]['lead_calls'] = NULL;
					}
					if ($recall){
						$data['recs'][$key]['recall'] = $recall[0]['count(ID)'];
					}
					else
					{
						$data['recs'][$key]['recall'] = 0;
					}
					$data['recs'][$key]['lead_reason'] = $this->str_function_library->call('fr>LR>reason:ID=`'.$value['lead_reason_ID'].'`');
				}
				$data['seniority'] = $this->fetch_model->show(array('US'=>array('branch_ID'=>$branch_ID)));
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
			if($status === 'customer')
			{
				$lead_call = $this->form_model->add(array('table'=>'CC','columns'=>array('contact_ID'=>$id)));
			}
			$result = $this->form_model->edit(array("table"=>"LC","columns"=>array('call_Status'=>$status),"where"=>array('contact_ID'=>$id)));
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
				// $result = $this->form_model->edit(array("table"=>"C","columns"=>array('leadDescription'=>$_POST['description'],'assign_to'=>$_POST['assign_to']),"where"=>array('ID'=>$_POST['contactID'])));
				// $result_lead = $this->form_model->edit(array("table"=>"LC","columns"=>array('call_Status'=>$stat),"where"=>array('contact_ID'=>$_POST['contactID'])));
				$result_lead = $this->form_model->add(array("table"=>"LC","columns"=>array('call_Status'=>$stat)));
			}
			if ($result === true)
			{
				if ($stat === 'recall') {
					$id = $this->db_library->find_max_id('R');
					// $result = $this->form_model->edit(array("table"=>"C","columns"=>array('recall_ID'=>$id,'assign_to'=>$assign_to),"where"=>array('ID'=>$_POST['contactID'])));
					// $result_lead = $this->form_model->edit(array("table"=>"LC","columns"=>array('call_Status'=>$stat),"where"=>array('contact_ID'=>$_POST['contactID'])));
					$result_lead = $this->form_model->add(array("table"=>"LC","columns"=>array('call_Status'=>$stat)));
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