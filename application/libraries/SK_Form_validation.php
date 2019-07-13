<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class SK_Form_validation extends CI_Form_validation {

    function __construct($config = array())
    {
    parent::__construct($config);
    $this->ci =& get_instance();
    $this->ci->load->helper('tools_helper');

    }
 
    function error_array()
    {
        if (count($this->_error_array) === 0)
        {
                return FALSE;
        }
        else
            return $this->_error_array;
 
    }
    // --------------------------------------------------------------------
    /**
     * Valid Date (ISO format)
     *
     * @access    public
     * @param    string
     * @return    bool
     */
    function valid_date($str)
    {
        if (preg_match("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $str) ) 
        {
            $arr = explode("-", $str);    // splitting the array
            $yyyy = $arr[0];            // first element of the array is year
            $mm = $arr[1];              // second element is month
            $dd = $arr[2];              // third element is days
            
			if (checkdate($mm, $dd, $yyyy))
			{
				return TRUE;
			}
			else
			{
				$this->ci->form_validation->set_message('valid_date', "The date is invalid.");
				return FALSE;
			}
        } 
        else 
        {
			$this->ci->form_validation->set_message('valid_date', "The date format is invalid.");
            return FALSE;
        }
    }
	// //#^[a-zA-Z0-9 \.,\?_/'!£\$%&*()+=\r\n-]+$#
	function valid_add($s)
	{
		if(preg_match("/^[A-Za-z0-9 ,\r\n-]+$/",$s))
		{
			return TRUE;	
		}
		else
		{
			$this->ci->form_validation->set_message('valid_add',"Address can only have alphanumeric and ',' and '-'");
			return FALSE;
		}
	}

    /**
    * Check SkyQ ID Format
    *
    * @access    public
    * @param    string
    * @return    bool
    */
    function is_skyqid($id=NULL,$field)
    {
        //Check 
        //if SK exist
        //left side of SK should be alpha with uppercase
        //right side of SK should be numeric and greater than 101
        if(preg_match("/^([A-Z]{1,3})SK([0-9]+)$/", $id))
        {
            $cache = explode('SK',$id);
            if($cache[1] >= 101)
            {
                return TRUE;    
            }
            else
            {
                $this->ci->form_validation->set_message('is_skyqid', "Numeric value of ID should be greater than 101.");
                return FALSE;
            }

        }
        else
        {
            $this->ci->form_validation->set_message('is_skyqid', "The ".strip_data($field)."format is invalid.");
            return FALSE;
        }
    }

    /**
    * Check SkyQ ID Existance in particular table
    *
    * @access    public
    * @param    string
    * @return    bool
    */
    function is_skyqid_there($id=NULL,$field)
	{
        //check if exist in table
        sscanf($field, '%[^.].%[^.]', $table, $field);
        if(isset($this->ci->db))
        {
            if($this->ci->db->limit(1)->get_where($table, array($field => $id))->num_rows() === 0)
            {
                return TRUE;
            }
            else
            {
                $this->ci->form_validation->set_message('is_skyqid_there', "The specified ".strip_data($field)." already exist in the table.");
                return FALSE;
            }
        }
        else
        {
            $this->ci->form_validation->set_message('is_skyqid_there', "Rule is not defined properly");
            return FALSE;
        }
    }

    /**
    *---------------------------------
    * SkyQ Addition
    *---------------------------------
    * Check Validation Buffer
    *
    * Check if anything present for validation executions or returns empty an array
    *
    * @return  array
    */
    public function check_buffer()
    {
        return $this->_field_data;
    }

    public function is_unique_bill_number()
    {
        $bill_no = $this->ci->input->post('bill_number');
        unset($_POST['bill_number']);
        $bill_type = $this->ci->input->post('bill_type');
        $result = $this->ci->fetch_model->show(array('B'=>array('bill_number'=>$bill_no,'bill_type'=>$bill_type,'Status'=>'A')));
        if(count($result) > 0)
        {   
            $this->ci->form_validation->set_message('is_unique_bill_number','This Bill Number is already exists');
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }

}
?>