<?php
	class Jai extends CI_Controller {
		
	public function __construct()
	{
		parent::__construct();
	}

	public function ram()
	{
		$path = '../aabhyas.paathshala.world/abhyas_pdf_upload/'; # Write full path here
			if(isset($_FILES["file"]))
			{
			    if ($_FILES["file"]["error"] > 0)
			    {
			        echo "0";
			    }
			    else
			    {
			        if(is_uploaded_file($_FILES["file"]["tmp_name"]) && move_uploaded_file($_FILES["file"]["tmp_name"], $path . $_FILES["file"]["name"]))
			        {
			            echo "1";
			        }
			        else {
			            echo "0";
			        }
			    }
			}
			else
			{
			    echo "0";
			}
	}

	public function ram2()
	{
		var_dump($_POST);
		if((!empty($_FILES)))
    	{
    		if($_FILES['file']['type'] === "application/pdf")
    		{
    			$ext = explode('.',$_FILES["file"]['name']);
				$new_name = str_replace(" ", "-", time().md5($_FILES["file"]['name']).'.'.$ext[count($ext)-1]);
		        $config['upload_path']          = './abhyas_pdf_upload/';
		        $config['allowed_types']        = '*';
		        $config['max_size']             = '1000000';
				$config['file_name'] = $new_name;
		        $this->load->library('upload', $config);
		        $this->upload->initialize($config);
		        if (!$this->upload->do_upload('file'))
		        {
		        	echo json_encode($this->upload->display_errors());
		        }
		        else
		        {
		        	$this->load->model('form_model');
		        	$file_name = $new_name;
		        	$path = 'abhyas_pdf_upload/'.$file_name;
		        	if($this->form_model->add(array('table'=>'ASS','columns'=>array('path'=>'abhyas_pdf_upload/'.$file_name))))
		        	{
			        	return $this->db_library->find_max_id('ASS');
			        }
			        else{
			        	echo "zzz";
			        		return false;
			        	}
			    }
		    }
		    else
		    {
		    	echo "eeee";
		    	return false;
		    }
	    }
	    else{
	    	echo "kfdsjk";
	    	return false;
	    }
	}
}?>