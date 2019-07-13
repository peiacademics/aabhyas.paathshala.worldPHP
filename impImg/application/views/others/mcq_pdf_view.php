<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>MCQ PDF</title>
    <link href="<?php echo base_url("font-awesome/css/font-awesome.css"); ?>" rel="stylesheet">
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
  		border-bottom:1px #333 solid;
  		padding:2px;
  		margin:0;
  	}
    .term{
      width:100%;
      height:90px;
      font-size:12px;
    }
    .row_margin {
      margin-top: 50px !important;
    }
  </style>

  <body style="font-family:'Futura Md BT'">
    <table border="0" align="center" width="100%">
      <tr>
        <td width="55%" style="text-align:right;">
          <img src="<?php echo base_url() ;?>img/logo.jpg" height="100" style="margin:10px;" />
        </td>
        <td width="45%"  style="text-align:right;" >
        </td>
       
      </tr>
    </table>

    <table cellpadding="0" cellspacing="0" width="100%" border="0" align="center">
      <tr>
          <td colspan="4">Subject : <?php echo $this->str_function_library->call('fr>SB>name:ID=`'.$DETAIL['subject_ID'].'`'); ?></td>
        </tr>
        <tr>
          <td colspan="4">Lesson : <?php echo $this->str_function_library->call('fr>LS>name:ID=`'.$DETAIL['lesson_ID'].'`'); ?></td>
        </tr>
        <tr>
          <td colspan="4">Topic : <?php echo $this->str_function_library->call('fr>TP>name:ID=`'.$DETAIL['topic_ID'].'`'); ?></td>
        </tr>
    </table>
  
    <table cellpadding="0" cellspacing="0" width="100%" border="1" align="center" id="billing_tbl">
      <?php if(!empty($DETAIL['questions']))
      {
        $i = 1; ?>
        <?php foreach(@$DETAIL['questions'] as $key => $value) { ?>
        <tr class="<?php echo ($i >= 2) ? 'row_margin' : ''; ?>" style="background:#606062; color:#ffffff; text-align:center; font-size:12px;">
          <td>Q.No.<?php echo $i; ?></td>
          <td><?php echo @$value['question']; ?></td>
          <td>
            <?php if($value['question_path'] != NULL) { ?>
              <img src="<?php echo base_url().$value['question_path']; ?>" width="100px" height="100px" class="img-responsive">
            <?php } ?>
          </td>
          <td><?php echo @$value['type']; ?></td>
        </tr>
        <?php
          $count = 1; 
          foreach(@$value['answers'] as $key1 => $value1) { ?>
          <tr style="font-size:12px;">
            <!-- <td>Ans.No.<?php //echo $count; ?></td> -->
            <td class="td1" align="center" valign="top">
              <?php if($value1['correct'] == 'yes') { ?>Correct<?php } ?>
            </td>
            <td class="td1" align="center" valign="top">
              <?php if (($value1['order_seq'] != NULL) && ($value1['order_seq'] != 'None')) { ?>
              <?php echo $value1['order_seq']; ?>
              <?php } ?>    
            </td>
            <td class="td1" align="center" valign="top"><?php echo $value1['answer'];?></td>
            <td class="td1" align="center" valign="top">
              <?php if($value1['ans_path'] != NULL) { ?>
                <img src="<?php echo base_url().$value1['ans_path']; ?>" width="100px" height="100px" class="img-responsive">
              <?php } ?>
            </td>
          </tr>
      <?php $count++; } $i++; } } else { ?>
        <tr>
          <td colspan="4">
            <strong class="text-center h1">No records found.</strong>
          </td>
        </tr>
      <?php } ?>
    </table>
  </body>
</html>
