<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Lang_library 
{
	public function __construct()
	{
		$this->ci =& get_instance();
		$this->ci->config->load('skyq/my_config');
		$this->my_config = $this->ci->config->item('skyq');

    	$this->ci->load->library('str_function_library','session_library');
		$this->english_id = $this->my_config['english_language_id'];
		$this->current_lang_id_sess = $this->ci->session_library->get_session_data('Language_ID');
		$this->current_lang_id = empty($this->current_lang_id_sess) ? $this->english_id : $this->current_lang_id_sess;
		$this->current_lang = $this->ci->str_function_library->call('fr>LN>Title:ID=`'.$this->current_lang_id.'`');
		$this->ci->lang->load('custom',$this->current_lang);
	}

	public function get_all_languages()
	{
		$tbl = $this->ci->db_library->get_tbl('LN');
		$this->ci->db->select('ID,Title');
		$query = $this->ci->db->get_where($tbl,array("Status"=>"A"));
		if($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		else{
			return FALSE;
		}
	}

	function updatelangfile($lang_id=NULL)
	{
		if(!is_null($lang_id)){
			$my_lang = $this->ci->str_function_library->call('fr>LN>Title:ID=`'.$lang_id.'`');
			
	        $this->ci->db->where('Language_ID',$lang_id);
	        $query=$this->ci->db->get('translations');

	        $lang=array();
	        $langstr="<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	                /**
	                *
	                * Created:  2014-05-31 by Vickel
	                *
	                * Description:  ".$my_lang." language file for general views
	                *
	                */"."\n\n\n";
	                
	        foreach ($query->result() as $row)
	        {
	        	if($row->Translation == " "){
	        		continue;
	           	}
	            //$lang['error_csrf'] = 'This form post did not pass our security checks.';
	            $langstr.= "\$lang['".$row->Word."'] = \"$row->Translation\";"."\n";
	        }
	        if(write_file($_SERVER['DOCUMENT_ROOT'].'/Udyamatantra/application/language/'.$my_lang.'/custom_lang.php', $langstr))
	        {
	        	return TRUE;
	        }
	        else {
	        	return FALSE;
	        }
	    }
	    else{
	    	$this->ci->errorlog_library->entry('Lang_library > updatelangfile > Language_ID is absent.');
	    	return FALSE;
	    }
    }

    public function translate($word=NULL,$lang_id=NULL)
    {
    	if(!is_null($word))
    	{
			if($lang_id != $this->my_config['english_language_id'] && !is_null($lang_id))
			{
				$lang = $this->ci->str_function_library->call('fr>LN>Title:ID=`'.$lang_id.'`');
				$this->ci->lang->load('custom',$lang);
				$substitute = $this->ci->str_function_library->call('fr>LN>Substitute_English:ID=`'.$lang_id.'`');

				$out = @$this->ci->lang->line($word);

				if($out == '')
				{
					return ('1'==$substitute)? $word : '';
				}
				else {
					return $this->ci->lang->line($word);
				}
			}
			elseif ($this->current_lang_id != $this->my_config['english_language_id'] && is_null($lang_id)) 
			{
				$substitute = $this->ci->str_function_library->call('fr>LN>Substitute_English:ID=`'.$this->current_lang_id.'`');
				$trans = $this->ci->lang->line($word);
				if(empty($trans))
				{	
					return ('1'==$substitute)? $word : '';
				}
				else
				{
					return $trans;
				}	
			}
			else {
				return $word;
			}
	  	}
    	else
    	{
    		$this->ci->errorlog_library->entry('Lang_library > translate > Word argument missing. for ->'.$word);
    		return $word;
    	}
    }

    public function translation_by_word_lang($word=NULL,$lang_id="LNSK10000001")
    {
	    if(!is_null($word)){	
			$tbl = $this->ci->db_library->get_tbl('TR');
			$this->ci->db->select('Translation');
			$query = $this->ci->db->get_where($tbl,array("Status"=>"A","Word"=>$word,"Language_ID"=>$lang_id));
			if($query->num_rows() > 0){
				return $query->row()->Translation;
			}
			else{
				$this->ci->errorlog_library->entry('Lang_library > translation_by_word_lang > Translation not available.');
				return FALSE;
			}
		}
		else{
			$this->ci->errorlog_library->entry('Lang_library > translation_by_word_lang > Word argument missing.');
			return FALSE;
		}
	}

	public function update_languages($lang=NULL)
	{
		if(is_null($lang))
		{
			$lang = $this->get_all_languages();
		}

		if(gettype($lang) === 'string')
		{
			$title = $this->ci->str_function_library->call('fr>LN>Title:ID=`'.$lang.'`');
			if($this->updatelangfile($lang))
			{
				echo ucfirst($title)." language file Updated Successfully!";
				return TRUE;
			}
			else {
				echo "Something Went Wrong!";
				return FALSE;
			}
		}
		elseif (gettype($lang) === 'array')
		{
			foreach ($lang as $value)
			{
				$title = $this->ci->str_function_library->call('fr>LN>Title:ID=`'.$value['ID'].'`');
				if($this->updatelangfile($value['ID']))
				{
					echo ucfirst($title)." language file Updated Successfully!<br />";
				}
				else {
					echo "Something Went Wrong!";
				}
			}
			return TRUE;
		}
		else {
			return FALSE;
		}
	}

	public function update_lang()
	{
		$this->current_lang_id = $this->ci->session_library->get_session_data('Language_ID');
		$this->current_lang = $this->ci->str_function_library->call('fr>LN>Title:ID=`'.$this->current_lang_id.'`');
	}

	public function get_lang_image($img_name=NULL)
	{
		if(!is_null($img_name))
		{
			if(strpos($img_name,'http') == 0){
				$img_arr = explode('.',$img_name);
				$img = $img_arr[0].'_'.$this->current_lang.'.'. $img_arr[1];
				$filename = $_SERVER['DOCUMENT_ROOT'].'/Udyamatantra/uploads/'.$img;
				//return $img;
				if(file_exists($filename))
				{
					return $img_name;
				}
				else
				{
					return $img_arr[0].'_'.$this->current_lang.'.'. $img_arr[1];
				}
			}
			else
			{
				$this->ci->errorlog_library->entry('Lang_library > get_lang_image > image_name argument invalid.');
				return FALSE;
			}	
		}
		else
		{
			$this->ci->errorlog_library->entry('Lang_library > get_lang_image > image_name argument missing.');
			return FALSE;
		}
	}

	public function create_language_folder($title = NULL)
	{
		if(!is_null($title))
		{
			$dir = APPPATH.'language/'.$title;
			$data = "<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	                /**
	                *
	                * Created:  2014-05-31 by Vickel
	                *
	                * Description:  ".$title." language file for general views
	                *
	                */


					";
			if(!file_exists($dir))
			{
				mkdir($dir);
					if ( ! write_file($dir.'/custom_lang.php', $data))
					{
					     return FALSE;
					}
					else
					{
					     return TRUE;
					}
			}
			else
			{
					if ( ! write_file($dir.'/custom_lang.php', $data))
					{
					     return FALSE;
					}
					else
					{
					     return TRUE;
					}
			}
		}
		else
		{
			$this->ci->errorlog_library->entry('Lang_library > create_language_folder > title argument missing.');
			return FALSE;
		}
	}
}
?>