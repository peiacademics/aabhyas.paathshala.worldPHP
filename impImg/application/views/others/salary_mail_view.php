<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Invoice</title>

</head>

<style>

	@page { margin: 20px 20px 80px 20px; }

	#footer { position: fixed; left: -20px; bottom: 27px; right: -20px; }

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

		/*border-bottom:1px #333 solid;*/

		padding:2px;

		margin:0;

	}

  .term{

        width:100%;

        height:90px;

        font-size:12px;

      }

      .mr-top-20

    {

      margin-top: 50px;

    }

    .row{

          margin-right: -15px;

      margin-left: -15px

    }

</style>



<body style="font-family:'Futura Md BT'">

<table border="0" align="center" width="100%">

  <tr>

    <td width="55%" style="text-align:right;">

    </td>

    <td width="45%"  style="text-align:right;" >

      <img src="<?php echo base_url() ;?>img/logo.png" height="100" style="margin:10px;" />

    </td>

   

  </tr>

</table>

<!-- Company  -->

<table border="1" align="center" width="100%">

  <tr>

    <td colspan="2" style="text-align:center; padding-left:30px;">

    <b><?php echo @$DETAIL['USER'][0]['Company_Name']; ?></b><br>

     <?php echo @$DETAIL['USER'][0]['Address']; ?><br>

     Payslip for the Month <?php echo @$DETAIL['DETAILS2'][0]['month']." ".$DETAIL['DETAILS2'][0]['year']; ?>

     </td>

  </tr>

  </table>

  

  <br>

   <!-- /Employee Detail -->

<div>

 <table cellpadding="0" cellspacing="0" width="100%" border="0" align="center">

      <tr style=" text-align:left; font-size:12px;" >

        <td>Name of the Employee:-</td>

        <td><?php echo @$DETAIL['customer'][0]['Name']; ?></td>

        <td>Days in a month:-</td>

        <td><?php echo @$DETAIL['attData']['ttlDays']; ?></td>



      </tr>

       <tr style=" text-align:left; font-size:12px;" >

        <td>Employee Code:-</td>

        <td><?php echo @$DETAIL['customer'][0]['employee_ID']; ?></td>

        <td>Holidays Days:-</td>

        <td><?php echo @$DETAIL['attData']['holidays']; ?></td>

      </tr>

       <tr style=" text-align:left; font-size:12px;" >

        <td>Designation:-</td>

        <td><?php echo @$DETAIL['customer'][0]['designation']; ?></td>

        <td>Present Days:-</td>

        <td><?php echo @$DETAIL['attData']['presentDay']; ?></td>

      </tr>

       <tr style=" text-align:left; font-size:12px;" >

        <td>Bank A/c. No.:-</td>

        <td>004512345878</td>

        <td>PF Number :-</td>

        <td>AVSFSS12456666</td>

      </tr>

      

   </table>

</div>

   <!-- /Employee Detail -->

  <!--  start  Products...   -->

  <br>

  <br>

  <table width="100%">

    <tr>

      <td>

          <table cellpadding="0" cellspacing="0"  width="100%"  border="0" align="left" id="billing_tbl">

            <?php if(!empty($DETAIL['detailsEarnings']))

                      { ?>

                <tr style="background:#606062; color:#ffffff; text-align:left; font-size:12px; padding-top: -80px;" >

                  <td>Earnings</td>

                  <td align="center">Amount(Rs)</td>

                </tr>

                <?php

              $Earnings = 0; 

              foreach(@$DETAIL['detailsEarnings'] as $key => $value) { ?>

                <tr style="font-size:12px;">

                  <td class="td1" valign="top"><?php echo $value['perticular']; ?></td>

                  <td class="td1" align="center" valign="top"><?php echo $value['amount'];?></td>

                </tr>

<?php $Earnings += $value['amount']; 

              ?>

                <?php } }?>

                <?php

             if (count($DETAIL['detailsDeductions'])!==count($DETAIL['detailsEarnings'])) {

             if (count($DETAIL['detailsDeductions']) > count($DETAIL['detailsEarnings'])) {

                $count=count($DETAIL['detailsDeductions'])-count($DETAIL['detailsEarnings']);

            for($i=0; $i<$count; $i++) { ?>

             <tr style="font-size:12px;">

              <td class="td1" valign="top">-</td>

              <td class="td1" align="center" valign="top">-</td>

            </tr>

         <?php  }

            }

          } ?>

          <tr style=" text-align:right;">

            <td><b>Total Earnings</b></td>

            <td><?php echo $Earnings;?></td>

          </tr>

             </table>

      </td>

      <td>

        <table cellpadding="0" cellspacing="0"  width="90%"border="0" align="right" id="billing_tbl">

        <?php if(!empty($DETAIL['detailsEarnings']))

                  { ?>

            <tr style="background:#606062; color:#ffffff; text-align:left; font-size:12px; padding-top: -80px;" >

              <td>Deduction</td>

              <td align="center">Amount(Rs)</td>

            </tr>

            <?php

          $count = 0; 

          if (count($DETAIL['detailsDeductions'])!==count($DETAIL['detailsEarnings'])) {

           if (count($DETAIL['detailsDeductions']) > count($DETAIL['detailsEarnings'])) {

              $count=count($DETAIL['detailsDeductions'])-count($DETAIL['detailsEarnings']);

           }

           else

           {

              $count=count($DETAIL['detailsEarnings'])-count($DETAIL['detailsDeductions']);

           }

          }

          $Deduction=0;

          foreach(@$DETAIL['detailsDeductions'] as $key => $value) { ?>

            <tr style="font-size:12px;">

              <td class="td1" valign="top"><?php echo $value['perticular']; ?></td>

              <td class="td1" align="center" valign="top"><?php echo $value['amount'];?></td>

            </tr>

            <?php $Deduction +=$value['amount'];

            } }?>

            <?php

             if (count($DETAIL['detailsDeductions'])!==count($DETAIL['detailsEarnings'])) {

             if (count($DETAIL['detailsDeductions']) < count($DETAIL['detailsEarnings'])) {

                $count=count($DETAIL['detailsEarnings'])-count($DETAIL['detailsDeductions']);

              // print_r($count);

            for($i=0; $i<$count; $i++) { ?>

             <tr style="font-size:12px;">

              <td class="td1" valign="top">-</td>

              <td class="td1" align="center" valign="top">-</td>

            </tr>

         <?php  }

            }

          } ?>

          <tr style=" text-align:right;">

            <td><strong>Total Deduction</strong></td>

            <td><?php echo $Deduction;?></td>

          </tr>

         </table>

      </td>

    </tr>

  </table>





     



<table class="mr-top-20" style="font-size:14px;" width=100%>

  <tr>

    <td colspan="2" align="right">TOTAL AMOUNT : <?php echo 'Rs.'.@$DETAIL['DETAILS2'][0]['Total_Amount']; ?>

    </td>

  </tr>

  <tr>

    <td colspan="2" align="center">

        Amount In Words -  <?php echo @$DETAIL['DETAILS2'][0]['words']; ?> Rupees Only  

    </td>

  </tr> 

</table>



<table class="term">

      <tr>

        <td>

          <br><br>

<?php

if(!empty($DETAIL['USER'][0]['T_C']))

{ 

 echo $DETAIL['USER'][0]['T_C']; 

 } ?>    

        </td>

      </tr> 

    </table>







<table border="0" style="text-align:center; font-size:16px; color:#96989A" width="100%">

  <tr>

    <td colspan="3"  style="text-align:center;"><hr size="2.2"/>If you have any query or comment regarding this <?php //echo strtolower($DETAIL['DETAILS2'][0]['bill_type']); ?>, please contact.</td>

  </tr>

  <tr>

    <td colspan="3" style="text-align:center;">Thank You For Choosing Us.</td>

  </tr>

</table>





  <!--   Footer start......  -->



<div id="footer">

<table border="0" align="center" width="100%">

  <tr>

    <td  style="text-align:center; " width='30%'><p style="line-height:20px; height:20px; vertical-align:middle;"><img src="<?php echo base_url() ;?>img/mail.png" style="height:20px;" /> Info@skyq.in</p></td>

    <td style="text-align:center;" width='40%'><p style="line-height:20px; height:20px; vertical-align:middle;"><img src="<?php echo base_url() ;?>img/mob.png" style="height:20px;" /> +91 809 757 8727</p></td>

    <td style="text-align:center;" width='30%'><p style="line-height:20px; height:20px; vertical-align:middle;"><img src="<?php echo base_url() ;?>img/at.png" style="height:20px;"/> www.skyq.in</p></td>

  </tr>

</table>



  <div style="background:#006cb5;color:#FFF; line-height:30px;">

      <div  style="text-align:center; padding:0px 0px 15px 0px;">A-05, Yashodarshan Apartment, Near Virupaksh Mandir, Panvel, Raigad. </div>

    </div>

</div>

 <!--   Footer End......  -->

</body>

</html>



<script type="text/javascript">

<?php if (@$print==='yes') { ?>

console.log("ddfsdsd");

window.print();

setTimeout(function(){window.close();}, 100);

<?php } ?>

</script>

