<?php

/**
* 
*/
class TandC_model extends CI_model
{
	public function add()
	{
		$this->load->model('form_model');
		$update= $this->form_model->edit( array('table'=> 'US','columns'=> array('T_C'=>$this->input->post('text')),'where'=> array('ID'=>$this->data['Login']['ID'])));
		if ($update)
		{
			echo 1;
		}
		else
		{
			echo 2;
		}
	}
	
}
?>