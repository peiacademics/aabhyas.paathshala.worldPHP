<?php
	class Bank_model extends CI_Model
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

		public function add_or_edit()
		{
			$_POST['account_opening_date'] = $this->date_library->date2db($_POST['account_opening_date'],$this->date_library->get_date_format());
			$this->load->model('form_model');
			if(empty($_POST['ID']))
			{
				unset($_POST['ID']);
				$result = $this->form_model->add(array("table"=>"BA","columns"=>$_POST));
			}
			else
			{
				$result = $this->form_model->edit(array("table"=>"BA","columns"=>$_POST,"where"=>array('ID'=>$_POST['ID'])));
			}				
			if($result === TRUE)
			{
				echo 1;
			}
			else
			{
				echo json_encode($result);
			}
		}

		public function get_show_data($input,$output)
		{
		 	$this->load->library('datatable_library');
	 		return $this->datatable_library->get_data($input,$output);
		}

		public function getPersons($value='')
		{
			$Customer = $this->fetch_model->show('C',array('ID','name','company_name'));
			$lead = $this->fetch_model->show('LD',array('ID','Name','company_name'));
			$output = array_merge($Customer, $lead);
			if ($output) {
				foreach ($output as $key => $value) {
					if (array_key_exists('name', $value)) {
						$output[$key]['mainName']=$value['company_name'].' - '.$value['name'];
					}
					else
					{
						$output[$key]['mainName']=$value['company_name'].' - '.$value['Name'].'<span class="text-danger"> ( Lead )</span>';
					}
					
				}
			}
			return $output;
		}

		public function addTimeline()
		{
			// print_r($_POST);
			if ($_POST['type']==='withClient') {
				if (array_key_exists('lead_ID', $_POST)) {
					if (array_key_exists('meet_type', $_POST)) {
						if (!empty($_POST['DateTime'])) {
							if (!empty($_POST['time'])) {
								unset($_POST['type']);
								// print_r($_POST['DateTime']);
								$_POST['DateTime']=$this->date_library->date2dbdttm($_POST['DateTime'].', '.$_POST['time'],'m/d/Y, H:i a');
								// print_r($_POST['DateTime']);
								if ($_POST['DateTime']>date("Y-m-d H:i:s")) {
									$_POST['cnt_Result']='NeedToContact';
								}
								else
								{
									$_POST['cnt_Result']='Contacted';
								}
								unset($_POST['time']);
								return $this->addTData('C');
								
							}
							else
							{
								return array('time'=>"Please select Time");
							}
						}
						else
						{
							return array('DateTime'=>"Please select Date");
						}
					}
					else
					{
						return array('meet_type'=>"Please select meet Type");
					}
				}
				else
				{
					return array('lead_ID'=>"Please select Customer or lead first");
				}
			}
			else
			{
				if (!empty($_POST['title'])) {
					if (!empty($_POST['DateTime'])) {
						if (!empty($_POST['time'])) {
							unset($_POST['type']);
							$_POST['DateTime']=$this->date_library->date2dbdttm($_POST['DateTime'].', '.$_POST['time'],'m/d/Y, H:i a');
								unset($_POST['time']);
							return $this->addTData('S');
						}
						else
						{
							return array('time'=>"Please select Time");
						}
					}
					else
					{
						return array('DateTime'=>"Please select Date");
					}
				}
				else
				{
					return array('title'=>"Please select title");
				}
			}
		}

		public function addTData($type)
		{
			$this->load->model('form_model');
			$_POST['heading_status']='Sub';
			if ($type==='C') {
				$title = $this->fetch_model->show(array("LMT"=>array("ID"=>$_POST['meet_type'])));
				$_POST['title'] = '<code>'.$this->data['Login']['Name'].'</code> '.$title[0]['title'];
				$t_add = $this->form_model->add(array("table"=>"LT","columns"=>$_POST));
				if ($t_add===true) {
					return TRUE;
				}
				else
				{
					return $t_add;
				}
			}
			else
			{
				$_POST['title']=$_POST['title']." <code>(".$this->data['Login']['Name'].")</code>";
				$t_add = $this->form_model->add(array("table"=>"LT","columns"=>$_POST));
				if ($t_add===true) {
					return TRUE;
				}
				else
				{
					return $t_add;
				}
			}
		}

		public function getErrorLogs()
		{
			$errors = $this->fetch_model->show('EL');

			if ($errors) {
				// foreach ($errors as $key => $value) {
				// 	foreach ($errors as $k => $v) {
				// 		if ($k!==$key && $v['Page_path']===$value['Page_path'] ) {
				// 			unset($errors[$key]);
				// 		}
				// 	}
				// }
				// return $errors;
				$errors1 = array();
				foreach ($errors as $key => $value) {
					if(array_key_exists($value['Page_path'], $errors))
					{
						$errors1[$value['Page_path'].'%-'.$value['Type']][]=$value;
					}
					else
					{
						$errors1[$value['Page_path'].'%-'.$value['Type']][]=$value;
					}
				}
				return $errors1;
			}
			else
			{
				return false;
			}
		}

		public function getChosenData()
		{
			if (array_key_exists('where', $_POST)) {

				$data=$this->fetch_model->show(array($_POST['tbl'] =>$_POST['where'][0]),array($_POST['contents'][0]['label'],$_POST['contents'][0]['value']));
			}
			else
			{
				$data=$this->fetch_model->show($_POST['tbl'],array($_POST['contents'][0]['label'],$_POST['contents'][0]['value']));
			}
			return $data;
		}
	}
?>