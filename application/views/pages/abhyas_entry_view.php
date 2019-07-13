<div class="ibox">
  <div class="ibox-content">
    <div class="page-content">
      <div class="wrap">
        <h4 id="success" style="text-align:center;"></h4>
        <form class="form-horizontal" role="form" action="<?php echo base_url('package/add'); ?>" method="post" id="package_add">
          <input type="hidden" name="ID" value="<?php echo @$View['ID']; ?>">
          <div class="form-group">
            <div class="col-sm-6">
              <div id="treeview12" class="">
                <i class="fa fa-spin fa-spinner fa-5x"></i><h2> Loading ... </h2>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script src="<?php echo base_url("js/formSerialize.js"); ?>"></script>
<script src="<?php echo base_url("js/plugins/validate/jquery.validate.min.js"); ?>"></script>

<link href="<?php echo base_url("css/bootstrap-treeview.css"); ?>" rel="stylesheet">
<script src="<?php echo base_url("js/bootstrap-treeview.js"); ?>"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $.ajax({
      method: 'POST',
      type: 'JSON',
      url: base_url+'abhyas_entry/get_menu_list',
      error:function(err){
        toastr.error("Something went wrong!");
      },
      success:function(res){
        res = JSON.parse(res);
        $('#treeview12').html('');
        $('#treeview12').treeview({
          enableLinks:true,
          data: res
        });
      }
    });
  });
</script>
