<?php
	class Employee_model extends CI_Model
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
				$this->errorlog_library->entry('Employee_model > check > argument id is invalid.');
				redirect('employee/add/');
			}
		}

		public function add_or_edit()
		{
			$bt_arr = $_POST;
			if(empty($_POST['ID']))
			{
				return $this->add($bt_arr);
			}
			else
			{
				return $this->edit($bt_arr); //,$num_row
			}
		}


		public function add($bt_arr)
		{
			if (!empty($_POST['vendor_ID'])) {
				$vID=$_POST['vendor_ID'];
				$pID=$_POST['purchase_cost'];
				unset($_POST['vendor_ID'],$_POST['purchase_cost']);
			}
			else
			{
				unset($_POST['vendor_ID'],$_POST['purchase_cost']);
			}
			$this->load->model('form_model');
			unset($_POST['ID']);
			$b_add = $this->form_model->add(array("table"=>"P","columns"=>$_POST));
			if($b_add === TRUE)
			{
				// $tbl_id = $this->db_library->find_max_id('P');
				if (!empty($vID) || isset($vID)) {
					$add=$this->adddPurchase($vID,$pID);
					if ($add===true) {
						$b_edit = $this->form_model->edit(array("table"=>"P","columns"=>array('purchase_ID'=>$this->db_library->find_max_id('PU')),"where"=>array('ID'=>$this->db_library->find_max_id('P'))));
						return true;
					}
					else
					{
						return $add;
					}
				}
				else
				{
					return true;
				}
			}
			else
			{	
				return $b_add;
			}
		}

		public function edit($bt_arr) //,$num_row
		{
			if (!empty($_POST['vendor_ID'])) {
				$vID=$_POST['vendor_ID'];
				$pID=$_POST['purchase_cost'];
				unset($_POST['vendor_ID'],$_POST['purchase_cost']);
			}
			else
			{
				unset($_POST['vendor_ID'],$_POST['purchase_cost']);
			}
			$this->load->model('form_model');
			$b_edit = $this->form_model->edit(array("table"=>"P","columns"=>$_POST,"where"=>array('ID'=>$_POST['ID'])));
			if($b_edit === TRUE)
			{
				if (!empty($vID) || isset($vID)) {
					$add=$this->editPurchase($vID,$pID);
					if ($add===true) {
						return true;
					}
					else
					{
						return $add;
					}
				}
				else
				{
					return true;
				}
			}
			else
			{	
				return $b_edit;
			}
		}

		public function adddPurchase($vID,$pID)
		{
			$this->load->model('purchase_model');
			$bill_number=$this->purchase_model->get_bill_number();
			$result = $this->form_model->add(array("table"=>"PU","columns"=>array('vendor_ID'=>$vID,'amount'=>$pID,'date'=>date('Y-m-d'),'bill_number'=>$bill_number)));
			if ($result===true) {
				$tbl_id = $this->db_library->find_max_id('PU');
				$p_id = $this->db_library->find_max_id('P');
				$res = $this->form_model->add(array("table"=>"PP","columns"=>array('quantity'=>1,'purchase_cost'=>$pID,'product_ID'=>$p_id,'purchase_ID'=>$tbl_id)));
				if ($res===true) {
					$trans=$this->form_model->add(array("table"=>"T","columns"=>array('referance_Name'=>$vID,'amount'=>$pID,'date'=>date('Y-m-d'),'transaction_type'=>'Debit','payment_mode_ID'=>'PMSK10000001','expence_category_ID'=>'ECSK10000002','reference_ID'=>$tbl_id,'referance_Name'=>$vID)));
					if ($trans===true) {
						return true;
					}
					else
					{
						return $trans;
					}
				}
				else
				{
					return $res;
				}
			}
			else
			{
				return $result;
			}
		}

		public function editPurchase($vID,$pID)
		{
			$purID=$this->fetch_model->show(array('P'=>array('ID'=>$_POST['ID'])));
			if ($purID) {
				$purID=$purID[0]['purchase_ID'];
				$pEdit = $this->form_model->edit(array("table"=>"PU","columns"=>array('amount'=>$pID,'vendor_ID'=>$vID),"where"=>array('ID'=>$purID)));
				$pEdit = $this->form_model->edit(array("table"=>"PP","columns"=>array('purchase_cost'=>$pID),"where"=>array('purchase_ID'=>$purID)));
				$pEdit = $this->form_model->edit(array("table"=>"T","columns"=>array('amount'=>$pID),"where"=>array('reference_ID'=>$purID,'referance_Name'=>$vID)));
				if ($pEdit) {
					return true;
				}
				else
				{
					return $pEdit;
				}
			}
		}

		
		public function get_show_data($input,$output)
		{
		 	$this->load->library('datatable_library');
	 		return $this->datatable_library->get_data($input,$output);
		}

		public function get_details($id=NULL)
		{
			$date=date("Y-m");
			$data=$this->fetch_model->show(array('US' =>array('ID'=>$id,'Type !='=>'DSSK10000001')));
			if ($data){
				$data['What'] = 'Edit'; 
				$data['List']['Phone'] = $this->fetch_model->get_multiadd_data('PH',$data[0]['phone_no_ID']);
				$data['List']['Address'] = $this->fetch_model->get_multiadd_data('AD',$data[0]['address_ID']);
			}
			return $data;
		}

	public function delete($item_id=NULL)
 	{
 		$this->load->model('form_model');
 		$pid = $this->fetch_model->show(array('P'=>array('ID'=>$item_id)));
 		$del = $this->form_model->delete(array('P' => array('ID' => $item_id)));
 		if($del == TRUE)
 		{
 			if ($pid[0]['purchase_ID'] !== NULL) 
 			{
 				$ppdelete = $this->form_model->delete(array('PP' => array('purchase_ID' => $pid[0]['purchase_ID'])));
	 			$vid = $this->fetch_model->show(array('PU'=>array('ID'=>$pid[0]['purchase_ID'])));
	 			// var_dump($vid);
	 			$pdelete = $this->form_model->delete(array('PU' => array('ID' => $pid[0]['purchase_ID'])));
	 			$tdelete = $this->form_model->delete(array('T' => array('reference_ID' => $pid[0]['purchase_ID'],'referance_Name'=>$vid[0]['vendor_ID'])));
 			}
 			return TRUE;
 		}
 		else
		{
			$this->errorlog_library->entry('Product_model > delete > Product record is not getting deleted.');
			return FALSE;
		}
 	}
	
	public function get_model($tbl_sc=NULL,$tbl_fr_sc=NULL)
	{
		if(!is_null($tbl_sc) && !is_null($tbl_fr_sc))
		{
			$prod_mod = array();
	 		$tbl_id = $this->db_library->find_max_id($tbl_sc);
			$res = $this->fetch_model->show(array($tbl_sc=>array('ID'=>$tbl_id)),array('model_ID','name'));
			if(!empty($res))
			{
				$model = explode(',',rtrim($res[0]['model_ID'],','));
				foreach ($model as $key => $value)
				{
					$d = $this->str_function_library->call('fr>M>model_name:ID=`'.$value.'`');
					$prod_mod[$tbl_id.'-'.$value] = $res[0]['name'].' - '.$d;
				}
			}
			return $prod_mod;
		}
	}		
}
?>