<?php
	class Attachment_model extends CI_Model
	{

		public function view($token,$download)
		{
			$Bdata=$this->fetch_model->show(array('B'=>array('token'=>$token)));
			if ($Bdata) {
				$this->load->model('bill_model');
				$pDAta['DETAIL']=$this->get_print_details($Bdata[0]['ID']);
				if ($Bdata[0]['bill_type']==='Estimate') {
					$save = $pDAta['DETAIL']['path'][0]['path'];
					$ext = pathinfo($save, PATHINFO_EXTENSION);
					$save2 = explode("/", $save);
					$name=time().$save2[1];
					copy($save, 'attachments/'.$name);
					$file = getcwd().'/attachments/'.$name;
					if ($download==='yes') {
						header('Content-Description: File Transfer');
					    header('Content-Type: application/octet-stream');
					    header('Content-Disposition: attachment; filename="'.basename($file).'"');
					    header('Expires: 0');
					    header('Cache-Control: must-revalidate');
					    header('Pragma: public');
					    header('Content-Length: ' . filesize($file));
					    readfile($file);
					    exit;
					}
					else
					{
						if ($ext==='pdf') {
							$filename = $name;
							// print_r($file);
							header('Content-type: application/pdf');
							header('Content-Disposition: inline; filename="' . basename($file) . '"');
							header('Content-Transfer-Encoding: binary');
							header('Content-Length: ' . filesize($file));
							header('Accept-Ranges: bytes');
							@readfile($file);
						}
						else
						{
							header('Content-Description: File Transfer');
						    header('Content-Type: application/octet-stream');
						    header('Content-Disposition: attachment; filename="'.basename($file).'"');
						    header('Expires: 0');
						    header('Cache-Control: must-revalidate');
						    header('Pragma: public');
						    header('Content-Length: ' . filesize($file));
						    readfile($file);
						    exit;
						}
					}
				}
				else
				{
					// $this->load->helper(array('dompdf', 'file'));
					// $save = $this->load->view('others/bill_mail_view',$pDAta,TRUE);

					$save = $this->load->view('others/bill_mail_view',$pDAta,TRUE);
					$name=time().$Bdata[0]['bill_number'].'.pdf';
					$this->pdf_create($save, $name);
					$file = getcwd().'/attachments/'.$name;
					if ($download==='yes') {
						header('Content-Description: File Transfer');
					    header('Content-Type: application/octet-stream');
					    header('Content-Disposition: attachment; filename="'.basename($file).'"');
					    header('Expires: 0');
					    header('Cache-Control: must-revalidate');
					    header('Pragma: public');
					    header('Content-Length: ' . filesize($file));
					    readfile($file);
					    exit;
					}
					else
					{
						// pdf_create($save,'fsdf');
						header('Content-type: application/pdf');
						header('Content-Disposition: inline; filename="' . basename($file) . '"');
						header('Content-Transfer-Encoding: binary');
						header('Content-Length: ' . filesize($file));
						header('Accept-Ranges: bytes');
						@readfile($file);

					}
				}
			}
			else
			{
				redirect('Attachment');
			}
			// var_dump(connection_aborted());
			// if (connection_aborted()) {
			// 	unlink($file);
			// }
			
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
		        $dompdf->stream($filename);
		    }
		    else
		    {
		        $CI =& get_instance();
		        $CI->load->helper('file');
		        write_file("./attachments/$filename", $dompdf->output());
		    }
		}

		public function get_print_details($id)
		{
			$data = array();
			$data['DETAILS']=$this->fetch_model->show(array('BP'=>array('bill_ID'=>$id)),array('price','vat','quantity','amount','warranty_start_date','warranty_end_date','>>Name:>fr>P>name:ID=^product_ID^','serial_number','ID'));
			$data['DETAILS2']=$this->fetch_model->show(array('B'=>array('ID'=>$id)),array('order_number','bill_number','>>Date:>fn>library>date_library:db2date(^date^)','customer_ID','bill_type','discount_value','discount_percent','net_total','grand_total','tnc','tax_percent','taxes','file_path','bill_Category','ID'));
			if (strpos($data['DETAILS2'][0]['customer_ID'], 'CSK') !== false) {
			    $data['customer'] = $this->fetch_model->show(array('C'=>array('ID'=>$data['DETAILS2'][0]['customer_ID'])));
				if (!empty($data['customer'][0]['address_ID'])) 
				{
					$address_ID = explode(',', $data['customer'][0]['address_ID']);
					$data['address'] = $this->fetch_model->show(array('AD'=>array('ID'=>$address_ID[0])));	
				}
			}
			else
				if (strpos($data['DETAILS2'][0]['customer_ID'], 'LDSK') !== false) {
					$data['customer'] = $this->fetch_model->show(array('LD'=>array('ID'=>$data['DETAILS2'][0]['customer_ID'])));
					if (!empty($data['customer'][0]['address_ID'])) 
					{
						$data['customer'][0]['name']=$data['customer'][0]['Name'];
						// $address_ID = explode(',', $data['customer'][0]['address_ID']);
						$data['address'] = $data['customer'][0]['Address'];

					}
				}
			
			if (!empty($data['DETAILS2'][0]['grand_total'])) 
			{
				$data['DETAILS2'][0]['words'] = $this->bill_model->convert_number($data['DETAILS2'][0]['grand_total']);
			}	
			if (!empty($data['DETAILS2'][0]['file_path'])) 
			{
				$data['path'] =  $this->fetch_model->show(array('SS'=> array('ID'=>$data['DETAILS2'][0]['file_path'])));
			}
			$data['USER']=$this->fetch_model->show(array('US'=>array('ID'=>'USSK10000001')),array('Company_Name','Address','Contact','Email','Image_ID','vat_tin_no','cst_tin_no','ID'));
			$data['Img']=$this->fetch_model->show(array('SS'=> array('ID'=>$data['USER'][0]['Image_ID'])));
			return $data;
		}

		public function transaction($token,$download)
		{
			$Bdata=$this->fetch_model->show(array('T'=>array('token'=>$token)));
			if ($Bdata) {
				$this->load->model('transaction_model');
				$pDAta['DETAIL']=$this->get_tprint_details($Bdata[0]['ID']);
				$save = $this->load->view('others/transaction_mail_viewNew',$pDAta,TRUE);
				$name=time().$Bdata[0]['bill_number'].'.pdf';
				$this->pdf_create($save, $name);
				$file = getcwd().'/attachments/'.$name;
				if ($download==='yes') {
					header('Content-Description: File Transfer');
				    header('Content-Type: application/octet-stream');
				    header('Content-Disposition: attachment; filename="'.basename($file).'"');
				    header('Expires: 0');
				    header('Cache-Control: must-revalidate');
				    header('Pragma: public');
				    header('Content-Length: ' . filesize($file));
				    readfile($file);
				    exit;
				}
				else
				{
					// pdf_create($save,'fsdf');
					header('Content-type: application/pdf');
					header('Content-Disposition: inline; filename="' . basename($file) . '"');
					header('Content-Transfer-Encoding: binary');
					header('Content-Length: ' . filesize($file));
					header('Accept-Ranges: bytes');
					@readfile($file);

				}
			}
			else
			{
				redirect('Attachment');
			}
		}

		public function get_tprint_details($id)
		{
			$data = array();
			$data['DETAILS']=$this->fetch_model->show(array('T'=>array('ID'=>$id)),array('transaction_type','date','amount','>>paymentMode:>fr>PM>title:ID=^payment_mode_ID^','bank_ID','other_details','>>expenceCategory:>fr>EC>title:ID=^expence_category_ID^','reference_ID','referance_Name','token','ID'));
			// var_dump($DETAILS);
			if ($data['DETAILS'][0]['reference_ID'])
			{
				$this->load->model('bill_model');
				$data['DETAILS2'][0]['words'] = $this->bill_model->convert_number($data['DETAILS'][0]['amount']);
				$ids=explode(',', $data['DETAILS'][0]['reference_ID']);
				$ID=$data['DETAILS'][0]['reference_ID'];
				$refID=$data['DETAILS'][0]['referance_Name'];
				if (strpos($ID,"BSK")!==false)
				{
					$referal=$this->fetch_model->show(array('C'=>array('ID'=>$refID)));
					if ($referal)
					{
						$data['referal']=$referal[0];
						$data['referal']['business_name']=$referal[0]['company_name'];
						$addID=explode(',', $referal[0]['address_ID']);
						$data['referal']['address']=$this->str_function_library->call('fr>AD>address:ID=`'.$addID[0].'`');
					}
					$c2 = $this->fetch_model->show(array('T'=>array('reference_ID LIKE'=>'%'.$ID.'%')),'sum(amount)');
					$data['collection'] = $c2[0]['sum(amount)'];
					$t2 = $this->fetch_model->show(array('B'=>array('ID'=>$ID)),array('grand_total','bill_Category','bill_number'));
					$data['grandtotal'] = $t2[0]['grand_total'];
					$data['billNo']=$t2[0]['bill_number'];
					$data['balance']=$data['grandtotal']-$data['collection'];
					$data['percent']=($data['collection']/$data['grandtotal'])*100;
					if ($t2[0]['bill_Category']!=='AutoPaid')
					{
						if($data['balance'] > 0)
	        			{
	        				$data['status']="UNPAID";
        					$data['class']="danger";
	        			}
	        			else
	        			{
        					$data['class']="success";
	        				$data['status']="PAID";
	        			}
					}
					else
					{
						$data['status']="PAID";
        				$data['class']="success";
					}
					
				}
				else
				{
					$referal=$this->fetch_model->show(array('V'=>array('ID'=>$refID)));
					if ($referal)
					{
						$data['referal']=$referal[0];
					}
					$c2 = $this->fetch_model->show(array('T'=>array('reference_ID LIKE'=>'%'.$ID.'%')),'sum(amount)');
					$data['collection'] = $c2[0]['sum(amount)'];
					$t2 = $this->fetch_model->show(array('PU'=>array('ID'=>$ID)),array('amount','bill_number'));
					$data['grandtotal'] = $t2[0]['amount'];
					$data['billNo']=$t2[0]['bill_number'];
					$data['percent']=($data['collection']/$data['grandtotal'])*100;
					$data['balance']=$data['grandtotal']-$data['collection'];
					if($data['balance'] > 0)
        			{
        				$data['status']="UNPAID";
        				$data['class']="danger";
        			}
        			else
        			{
        				$data['status']="PAID";
        				$data['class']="success";
        			}
				}
			}
			$data['USER']=$this->fetch_model->show(array('US'=>array('ID'=>'USSK10000001')),array('Name','Company_Name','Address','Contact','Email','Image_ID','vat_tin_no','currency_ID','cst_tin_no','ID'));
			$cid = $data['USER'][0]['currency_ID'];
			$data['Currency'] = $this->fetch_model->show(array('CU'=>array('ID'=>$cid)));
			//$data['Currency'][0]['symbol']='';
			if(empty($data['Currency'][0]['symbol']))
			{
				$data['Currency'][0]['symbol'] = $data['Currency'][0]['title'];
			}
			//$data['DETAILS'][0]['amount'] = '';
			//$data['USER'][0]['vat_tin_no'] = '';
			$data['Img']=$this->fetch_model->show(array('SS'=> array('ID'=>$data['USER'][0]['Image_ID'])));
			return $data;
		}
	}
?>