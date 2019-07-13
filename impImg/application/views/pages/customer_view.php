<div class="page-content">
            <div class="row">
        <div class="ibox-content">
          <!-- <div class="ibox-title">
              <h5><?php echo ucfirst($this->lang_library->translate('Calling Lists')); ?></h5>
              <div class="ibox-tools">
                  <a class="collapse-link">
                      <i class="fa fa-chevron-up"></i>
                  </a>
              </div>
          </div> -->
          <div class="row">
            <div class="table-responsive">
                <div class="col-sm-4 col-sm-offset-8">
                <div class="input-group">
                  <input type="text" class="form-control" placeholder="Search " onkeyup="doSearch()" id="searchTerm">
                  <span class="input-group-addon" >
                    <i class="fa fa-search fa2"></i>
                  </span>
                </div>
                </div>
              </div>
          <div class="table-responsive">
            <table id='dataTable' class="table">
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
                <td>
                  <?php if (!empty($value['uploadedFileName'])) { ?>
                   <span class="label label-warning">Imported</span>
                  <?php }else{?>
                  <span class="label label-primary">Inserted</span>
                  <?php } ?>
                </td>
                <td class="issue-info">
                    <a href="<?php echo base_url('lists/show/'.$branch_ID.'/'.$value['list_ID'].'');?>">
                        <?php echo $value['list_Name']; ?>
                    </a>
                    <small>
                       
                    </small>
                </td>
                <td>
                     <?php echo $value['Added_on']; ?>
                </td>
                <td class="text-right">
                   <!-- <button class="btn btn-white btn-xs"> Mag</button>
                    <button class="btn btn-white btn-xs"> Dag</button> -->
                </td>
              </tr>
              <?php }
              }else{ ?>
              <tr>
                <td colspan="4">
                  No list Found
                </td>
              </tr>
              <?php }?>
            </table>
           </div>
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
</script>