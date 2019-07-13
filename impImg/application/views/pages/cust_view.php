 <div class="page-content">
      <div class="row">
        <div class="ibox-content">
          <!-- <div class="ibox-title">
              <h5><?php echo ucfirst($this->lang_library->translate('Customers')); ?></h5>
              <div class="ibox-tools">
                  <a class="collapse-link">
                      <i class="fa fa-chevron-up"></i>
                  </a>
              </div>
          </div> -->
          
          <div class="">
             <div class="row">
                <div class="col-sm-4 col-sm-offset-8">
                <div class="input-group">
                  <input type="text" class="form-control" placeholder="Search " onkeyup="doSearch()" id="searchTerm">
                  <span class="input-group-addon" >
                    <i class="fa fa-search fa2"></i>
                  </span>
                </div>
                </div>
              </div>
            <div id="data_table" class="teble-responsive">
        <table id='dataTable' class="table" cellspacing="0" >
          <thead>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
          </thead>
          <?php 
        if (!empty($lists)) {
          foreach ($lists as $key => $value) { ?>
          <tr>
            <!-- <td class="feed-element">
               <img src="<?php //echo base_url('impImg/cus.jpg'); ?>" height="50" width="75">
            </td> -->
            <td class="issue-info">
              <h3>
                <a href="#" onClick="get_call_details('<?php echo $value['ID'];?>')" id="no<?php echo $value['ID'];?>"><?php if ($value['call_Status']==='abort') { 
                     echo "<strike>".$value['contact_No']."</strike>"; 
                   }else{
                     echo $value['contact_No']; 
                   }?>
                </a>
              </h3>
                <small>
                   <?php echo $value['f_Name']." , ".$value['l_Name']; ?>
                   <br>
                   <?php echo $value['city']." , "; ?>
                </small>
                <span class="label label-warning-light "><?php echo @$value['recall']?> Recall</span>

            </td>
            <td>
              <?php echo $value['list_Name']; ?>
              <?php if (!empty($value['uploadedFileName'])) { ?>
               <span class="label label-warning">Imported</span>
              <?php }else{?>
              <span class="label label-primary">Inserted</span>
              <?php } ?>
            </td>
            <td>
                 <?php echo $value['leadDescription']; ?>
            </td>
          </tr>
          <?php }
          }else{ ?>
          <tr>
            <td colspan='3'>No Customer</td>
          </tr>
          <?php } ?>
          <tbody>
          </tbody>
        </table>
      </div>
        </div>
      </div>
</div>
</div>

<div class="modal inmodal" id="detailModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
  <div class="modal-content animated bounceInRight">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
              <i class="fa fa-phone modal-icon text-primary"></i>
              <h4 class="modal-title" id="phNoDet"></h4>
              <small class="font-bold">Call details of contact number.</small>
          </div>
          <div class="modal-body">
              <div class="feed-activity-list ibox-content" id="callrecsPP">
              </div>
              <div class="feed-activity-list ibox-content" id="callrecs">
              </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-white" data-dismiss="modal">Okay</button>
          </div>
      </div>
  </div>
</div>

<script type="text/javascript">
  function doSearch()
  {
    var searchText = document.getElementById('searchTerm').value;
    var targetTable = document.getElementById('dataTable');
    var targetTableColCount;
    for (var rowIndex = 0; rowIndex < targetTable.rows.length; rowIndex++)
    {
        var rowData = '';
        if (rowIndex == 0)
        {
           targetTableColCount = targetTable.rows.item(rowIndex).cells.length;
           continue; 
        }
        for (var colIndex = 0; colIndex < targetTableColCount; colIndex++)
        {
          rowData += targetTable.rows.item(rowIndex).cells.item(colIndex).textContent;
        }
        if (rowData.indexOf(searchText) == -1)
            targetTable.rows.item(rowIndex).style.display = 'none';
        else
            targetTable.rows.item(rowIndex).style.display = 'table-row';
    }
  }

function get_call_details(id){
  $('#callrecs').html('');
  $('#calls').html('');
  $.ajax({
    type:'POST',
    dataType: "json",
    url: '<?php echo base_url(); ?>'+'lists/call_recs/'+id,
    success:function(response)
    {
      if (typeof response === 'object'){
        $('#detailModal').modal('show');
        // $(".customscrollbar").mCustomScrollbar({
        //   axis:"y",
        //   scrollbarPosition: "inside",
        //   setHeight: 10,
        //           onInit:function(){
        //       console.log("Scrollbars initialized");
        //     }
        // });
        $('#phNoDet').html(response.contact_No);
        data ='';
        var data_calls = '';
        var reason = '';
        var tot_rej = 0;
        var tot_no = 0;
        var tot_received = 0;
        var tot_recall = 0;
        var tot_sms = 0;
        if(response.recs.length != 0)
        {
          $.each(response.meargeArray, function(key,value){
            if (value.ID[0] === 'C') {
              if(value.reason == 'reject')
              {
                reason = 'Rejected';
                tot_rej++;
              }
              else
              {
                reason = 'Not responded';
                tot_no++;
              }
              data +='<div class="feed-element"><div class="media-body "><small class="pull-right">'+moment(value.date).fromNow()+'</small><strong>'+value.Added_Name+'</strong> called <strong class="text-warning">'+response.contact_No+'</strong>, Person <code>'+reason+'</code> call <br><small class="text-muted">'+moment(value.date).format('dddd h:mm a')+' - '+moment(value.date).format('MMMM Do YYYY')+'</small></div></div>';
              tot_received++;
            }
            else if (value.ID[0] === 'R')
            {
              tot_recall++;
              data +='<div class="feed-element"><div class="media-body "><small class="pull-right">'+moment(value.date).fromNow()+'</small><strong>'+value.Added_Name+'</strong> called <strong class="text-success">'+response.contact_No+'</strong> Person requested To <code>Call Back</code> at '+moment(value.alertTime).format('MMMM Do YYYY dddd h:mm a')+'. <br><small class="text-muted">'+moment(value.date).format('dddd h:mm a')+' - '+moment(value.date).format('MMMM Do YYYY')+'</small><div class="well">'+value.description+'</div></div></div>';
              tot_received++;
            }
            else
            {
              tot_sms++;
              data +='<div class="feed-element"><div class="media-body "><small class="pull-right">'+moment(value.date).fromNow()+'</small><strong>'+value.Added_Name+'</strong> sent SMS <strong class="text-success">'+response.contact_No+'</strong> at '+moment(value.date).format('MMMM Do YYYY dddd h:mm a')+'. <br><small class="text-muted">'+moment(value.date).format('dddd h:mm a')+' - '+moment(value.date).format('MMMM Do YYYY')+'</small><div class="well">'+value.message+'</div></div></div>';
            }
          });
        }
        else{
          data += '<tr><td colspan="2" class="text-center">No records found.</td></tr>';
        }

       
        if (response.mainData[0].call_Status==='customer' || response.mainData[0].call_Status==='lead') {
          var mClass='text-navy';
          var mainData='<h4><strong>'+response.mainData[0].Added_Name+'</strong> Added '+response.contact_No+' as a '+response.mainData[0].call_Status+'</h4>';
            tot_received++;
        }
        else if (response.mainData[0].call_Status==='abort') {
          var mClass='text-danger';
           var mainData='<h4><strong>'+response.abortCntct[0].Added_Name+'</strong> Added '+response.contact_No+' as a Not Intrested</h4><div class="well">'+response.abortCntct[0].reasons+'</div>';
        }
        else
        {
           var mClass='';
           var mainData='';
        }
        $('#callrecs').html(data);

        $('#callrecsPP').html('<span class="text-center '+mClass+'">'+mainData+'</span><div class="feed-element ibox-content ibox-heading"><div class="media-body "><div class="col-xs-2"><h5 class="m-b-xs text-danger">Rejected</h5><h1 class="no-margins">'+tot_rej+'</h1></div><div class="col-xs-3"><h5 class="m-b-xs text-warning">No Response</h5><h1 class="no-margins">'+tot_no+'</h1></div><div class="col-xs-2"><h5 class="m-b-xs text-success">Recall</h5><h1 class="no-margins" >'+tot_recall+'</h1></div><div class="col-xs-2"><h5 class="m-b-xs text-primary">SMS</h5><h1 class="no-margins" >'+tot_sms+'</h1></div><div class="col-xs-3"><h4 class="m-b-xs">Total Calls</h4><h1 class="no-margins" ><strong>'+tot_received+'</strong></h1></div></div></div>');
      }
      else
      {
        toastr.error("Something went wrong!");
      }
    }
  });
}
</script>