<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
function pdf_create($html, $filename='', $stream=TRUE,$gatepass=FALSE) 
{
    require_once("dompdf/dompdf_config.inc.php");
    $dompdf = new DOMPDF();
	$base_path = $_SERVER['DOCUMENT_ROOT'].'/skyqinfotech/';
	//echo $html;
	$dompdf->set_paper("A4","portrait");
    $dompdf->load_html($html);
	if ( isset($base_path) ) {
    $dompdf->set_base_path($base_path);
}
    $dompdf->render();
	$canvas = $dompdf->get_canvas();
    $font = Font_Metrics::get_font("Century Gothic", "normal");
    //$canvas->page_text(500, 800, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font,10, array(0,0,0));
    
	/*$canvas = $dompdf->get_canvas();
    $font = Font_Metrics::get_font("helvetica", "normal");
	$canvas->page_text(16, 800, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font,10, array(0,0,0));*/
	//echo $html;
	//$dompdf->output();
	//echo $file_location = $base_path."pdfReports/".$filename.".pdf";
	
	 if($gatepass == TRUE)
	 {
		$pdf = $dompdf->output();
        $file_location = $base_path."pdfReports/".$filename.".pdf";
        if(file_put_contents($file_location,$pdf))
		{
			return TRUE;
		}
	 }
	 else
	 {
		 $dompdf->stream($filename.".pdf" , array( 'Attachment' => 0 ));
	 }
	/* */
	
	
	
    /*if ($stream) {
        $dompdf->stream($filename.".pdf" , array( 'Attachment'=>0 ));
    } else {
        return $dompdf->output();
    }*/ 
}
?>