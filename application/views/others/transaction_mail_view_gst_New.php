<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Fee Receipt with GST</title>
</head>
<style>
    @page { margin: 20px 20px 80px 20px; }
    #footer { position: fixed; left: -20px; bottom: 10px; right: -20px; }
    .td1 { height:25px; }
    @font-face {
        font-family: Futura Md BT;
        src: url('<?php echo site_url('fonts/futura.ttf'); ?>');
    }
    @font-face {
        font-family: Futura BD BT;
        src: url('<?php echo site_url('fonts/futura_bd.ttf'); ?>');
    }
    #billing_tbl {
        border:0;
        margin:0 auto;
        padding:0;
        border-collapse:collapse;   
    }
    #billing_tbl td {
        border-bottom:1px #333 solid;
        padding:2px;
        margin:0;
    }
  .term{
        width:100%;
        height:90px;
        font-size:12px;
      }
      #table11 > tr,th,td
      {
        border: 1px solid #000000;
        text-align: left;
       padding: 8px;
       font-size:12px;
       border-collapse: collapse;
      }
      ul>li 
      {
        list-style-type: square;
      }
</style>

<body style="font-family:'Futura Md BT'">
<table border="0" align="center" width="100%">
  <tr>
    <td width="50%">
    <img src="<?php echo base_url() ;?>img/logo0.png" height="70" />
    </td>
    <td width="50%">
     <?php
     //     if($DETAIL['DETAILS2'][0]['bill_type'] != "Estimate" && $DETAIL['DETAILS2'][0]['bill_Category'] =="Paid" )
        // {
    ?>
    <ul>
    <li>Engineering Entrances</li>
    <li>Pre-Medical Entrances</li>
    <li>Foundations</li>
    <li>Olympiads</li>
    </ul>
    <?php //} ?>
    </td>
   
  </tr>
  <tr>
    <td width="100%"><p style= "font-size:12px;">Paathshala Education Address: 201, Dighe House,
Lohar Ali Lane, Thane west | 9004908560 | 022 49708979 | www.paathshalaiit.com</p></td>
<td><p style="line-height:15px; padding:0; margin:0; font-size:12px; text-align: right;">Receipt No.: <?php echo $DETAIL['DETAILS'][0]['receipt_no'];?></p></td>
  </tr>
</table>
<p style="background:#606062; vertical-align:center; text-align:center; color:white;  font-size:12px; font-family: Futura BD BT;">&nbsp;FEES RECEIPT</p><hr>
<p style="background:#606062; vertical-align:center; text-align:center; color:white;  font-size:12px; font-family: Futura BD BT;">&nbsp;Student Details</p>
<table width="100%" border="1px">
  <tr>
    <td width="25%" style="font-size: 12px;">Name Of Student:</td>
    <td width="25%"><p style="font-size:12px;"><?php echo (@$DETAIL['referal']) ? @$DETAIL['referal']['name'] : '____________';?></p></td>
    <td width="25%"  style="font-size: 12px;">Phone 1:</td>
    <td width="25%"  style="font-size: 12px;"><?php echo (@$DETAIL['referal']['phone_number'][0]['phone_number']) ? @$DETAIL['referal']['phone_number'][0]['phone_number'] : '____________';?></td>
  </tr>
  <tr>
    <td width="25%"  style="font-size: 12px;">Center:</td>
    <td width="25%"><p style="font-size:12px;"><?php echo @$DETAIL['referal']['branch']; ?></p></td>
    <td width="25%" style="font-size: 12px;">Phone 2:</td>
    <td width="25%"  style="font-size: 12px;"><?php echo (@$DETAIL['referal']['phone_number'][1]['phone_number']) ? @$DETAIL['referal']['phone_number'][1]['phone_number'] : '____________';?></td>
  </tr>
  <tr>
    <td width="25%" style="font-size: 12px;">Course Fees:</td>
    <td width="30%" colspan="3" style="font-size: 12px"><?php echo @$DETAIL['referal']['course_fee']; ?></td>
  </tr>
  <tr>
    <td width="25%" style="font-size: 12px;">Email ID:(Parents)</td>
    <td width="25%" style="font-size: 12px;"><?php echo @$DETAIL['referal']['Email'];?></td>
    <td width="25%" style="font-size: 12px;">Current Installment due date:</td>
    <td width="25%" style="font-size: 12px;"><?php echo $DETAIL['DETAILS'][0]['date'];?></td> 
  </tr>
   <tr>
    <td width="25%" style="font-size: 12px;">Payment Mode:</td>
    <td colspan="3" style="font-size: 12px;"><?php echo @$DETAIL['DETAILS'][0]['paymentMode'];?></td>
     
  </tr>
  </table>
  
  <!--   Footer start......  -->

<div id="footer">
<table border="0" align="center" width="100%">
  <tr>
    <td  style="text-align:center; " width='30%'><p style="line-height:20px; height:20px; vertical-align:middle;"><img src="<?php echo base_url() ;?>img/mail.png" style="height:20px;" /> paathshala@gmail.com</p></td>
    <td style="text-align:center;" width='60%'><p style="line-height:20px; height:20px; vertical-align:middle;"><img src="<?php echo base_url() ;?>img/mob.png" style="height:40px;" /> 9867998388 | 9987457772 | 02249708979</p></td>
    <td style="text-align:center;" width='30%'><p style="line-height:20px; height:20px; vertical-align:middle;"><img src="<?php echo base_url() ;?>img/at.png" style="height:20px;"/> www.paathshalaiit.com</p></td>
</table>
    <br>
    <div style="background:#006cb5;color:#FFF; line-height:30px;">
        <div  style="text-align:center; padding:0px 0px 15px 0px;">Thane, Pin Code - 400601. </div>
    </div>
</div>
 <!--   Footer End......  -->
 <br>
  <!--  start  Products...   -->
  <table width="100%" border="1px" style="padding: 8px;font-size:12px;">
      <tr>
      <th>Installments</th>
      <th>% of Fees</th>
      <th>Amount</th>
      <th>GST(%)</th>
      <th>Total</th>
      <th>Cheque No / Ref No</th>
      <th>Next Due / Paid Date</th>
      <th>Sign & Date by Paathshala Office Staff (after payment)</th>
    </tr>
    <tr>
      <td>Current</td>
      <td><?php echo @$DETAIL['referal']['percent_of_fee']; ?></td>
      <td><?php echo @$DETAIL['DETAILS'][0]['amount']; ?></td>
      <td><?php echo @$DETAIL['referal']['gst']; ?></td>
      <td><?php echo @$DETAIL['referal']['total']; ?></td>
      <td><?php echo @$DETAIL['DETAILS'][0]['other_details']; ?></td>
      <td>&nbsp;</td>
      <td rowspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="7"><p style="font-size: 12px;">Total Paid After this Installmentst - <?php echo @$DETAIL['referal']['paid']; ?> & Balance After this Installment - <?php echo @$DETAIL['referal']['pending']; ?> 
      <p style="font-size: 10px;">Inclusive Of taxes</p></td>
    </tr>
  </table>
 <p style="font-size: 12px;">We hereby certify that our registration certificate under Maharashtra State Shop act license has been sanctioned and enforced for the services provided by us.</p>
<p style="font-size: 12px;"><b>Refund Policy:</b> The fees paid are subject to no refund under any conditions whatsoever.
Thank you for being a part of Paathshala Education.</p>
    <br><br><p style="font-size: 12px;">Parents Signature&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Stamp with Paathshala Authority Signature</span>
       
    </table>
<!-- 
<table border="0" style="text-align:center; font-size:16px; color:#96989A" width="100%">
  <tr>
    <td colspan="3"  style="text-align:center;"><hr size="2.2"/>If you have any query or comment regarding this <?php echo strtolower($DETAIL['DETAILS2'][0]['bill_type']); ?>, please contact.</td>
  </tr>
  <tr>
    <td colspan="3" style="text-align:center;">Thank You For Choosing Us.</td>
  </tr>
</table> -->



</body>
</html>
