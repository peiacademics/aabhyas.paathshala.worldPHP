<?php
	class Chat_model extends CI_Model{

		public function insert_data()
		{
			
			$id = $this->db_library->find_next_id('C');
	 		$partner_id = $this->input->post('partner_id');
	 		$my_id = $this->data['Login']['id'];
	 		$conversat = $this->input->post('conversat');
	 		$val = array(
	 			'Added_on' => $this->date_library->get_current_time(),
	 			'My_ID' => $my_id,
	 			'Partner_ID' => $partner_id,
	 			'Conversation' => $conversat
	 		);

			$q = $this->form_model->add(array('table'=>'C','columns'=>$val));
	 		if($q)
	 		{
	 			return $this->get_my_conversat($my_id,$partner_id);
	 		}
	 		else
	 		{
	 			return FALSE;
	 		}
		}

		public function get_my_conversat($my_id=NULL,$part_id=NULL)
		{
			if(!is_null($my_id) && !is_null($my_id))
			{
				$my = $this->fetch_model->show(array('C'=>array('My_ID'=>$my_id,'Partner_ID'=>$part_id)));
				$partner = $this->fetch_model->show(array('C'=>array('My_ID'=>$part_id,'Partner_ID'=>$my_id)));
				return array_merge($my, $partner);
			}
			else
			{
				$this->errorlog_library->entry('chat model > get_my_conversat > arguments missing');
				return FALSE;
			}
		}

		public function get_recent_conversat()
		{
			
		}

	}
?>