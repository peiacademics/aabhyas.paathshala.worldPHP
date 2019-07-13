<div class="page-content">
  <div class="wrap">
<div class="ibox ">
    <div class="ibox-content">
              <h4 id="success" style="text-align:center;"></h4>
  	<div class="dd" id="nestable2">
  		<ol class="dd-list">
<?php 	$i = 0;
		foreach($menu['menu'] as $one){
       	$i++;
        if(array_key_exists('children', $one))
        {	
?>        
            <li class="dd-item" data-id="<?php echo $i; ?>" data-Title="<?php echo $one['title']; ?>" data-Icon="<?php echo $one['icon']?>" data-Link="<?php echo @$one['link']?>">
                <div class="dd-handle">
                    <span class="label label-warning"><i class="fa fa-<?php echo $one['icon']?>"></i></span><?php echo $this->lang_library->translate($one['title']); ?>                 
                </div>
                <ol class="dd-list">
                <?php
                	foreach($one['children'] as $two)
                    {
                    	$i++;
                ?>
                    <li class="dd-item" data-id="<?php echo $i; ?>" data-Title="<?php echo $two['title']; ?>" data-Icon="<?php echo $two['icon']?>" data-Link="<?php echo $two['link']?>">
                        <div class="dd-handle">
                            <span class="label label-info"><i class="fa fa-<?php echo $two['icon']; ?>"></i></span><?php echo $this->lang_library->translate($two['title']); ?>
                        </div>
                    </li>
            <?php   }
            ?>
                    <!--  <li class="dd-item" data-id="3">
                        <div class="dd-handle">
                            <span class="label label-info"><i class="fa fa-bolt"></i></span> Nunc dignissim risus id metus.
                        </div>
                    </li>
                    <li class="dd-item" data-id="4">
                        <div class="dd-handle">
                            <span class="label label-info"><i class="fa fa-laptop"></i></span> Vestibulum commodo
                        </div>
                    </li> -->
                </ol>
            </li>
<?php
        }
        else
        {
            if(@$one['modal']) { ?>
			<li class="dd-item" data-id="<?php echo $i; ?>" data-target="<?php echo $one['target']; ?>" data-modal="<?php echo $one['modal']; ?>" data-Title="<?php echo $one['title']; ?>" data-Icon="<?php echo $one['icon']?>" data-Link="<?php echo $one['link']?>">
            <?php }
            else{
            ?>
            <li class="dd-item" data-id="<?php echo $i; ?>" data-Title="<?php echo $one['title']; ?>" data-Icon="<?php echo $one['icon']?>" data-Link="<?php echo $one['link']?>">
            <?php
            }
            ?>    <div class="dd-handle">
                    <span class="label label-warning"><i class="fa fa-<?php echo $one['icon']; ?>"></i></span> <?php echo $this->lang_library->translate($one['title']); ?>
                </div>
<?php 	}
	}
?>
<!--             <li class="dd-item" data-id="5">
                <div class="dd-handle">
                    <span class="label label-warning"><i class="fa fa-users"></i></span> Integer vitae libero.
                </div>
                <ol class="dd-list">
                    <li class="dd-item" data-id="6">
                        <div class="dd-handle">
                            <span class="label label-warning"><i class="fa fa-users"></i></span> Nam convallis pellentesque nisl.
                        </div>
                    </li>
                    <li class="dd-item" data-id="7">
                        <div class="dd-handle">
                            <span class="label label-warning"><i class="fa fa-bomb"></i></span> Vivamus molestie gravida turpis
                        </div>
                    </li>
                    <li class="dd-item" data-id="8">
                        <div class="dd-handle">
                            <span class="label label-warning"><i class="fa fa-child"></i></span> Ut aliquam sollicitudin leo.
                        </div>
                    </li>
                </ol>
            </li> -->
        </ol>
    </div>
    <form id="menu_update" action="<?php echo base_url('settings/update_menu_orders'); ?>" method="post">
    	<input type="hidden" id="nestable2-output" class="form-control" name="menu_order">
    	<input type="submit" value="Update Order" class="btn btn-primary">
    </form>
  </div>
</div>
  </div>
</div>
<!-- Jquery Validate -->
<script src="<?php echo base_url("js/plugins/validate/jquery.validate.min.js"); ?>"></script>
<!-- Custom and plugin javascript -->
<script src="<?php echo base_url("js/formSerialize.js"); ?>"></script>
<!-- Gritter -->
<link href="<?php echo base_url("js/plugins/gritter/jquery.gritter.css"); ?>" rel="stylesheet">
<script src="<?php echo base_url("js/plugins/gritter/jquery.gritter.min.js"); ?>"></script>
<!-- Nestable List -->
<script type="text/javascript" src="<?php echo base_url('js/plugins/nestable/jquery.nestable.js'); ?>"></script>
<!-- Sweet alert -->
<script src="<?php echo base_url('js/plugins/sweetalert/sweetalert.min.js'); ?>"></script>
<!-- Custom and plugin javascript -->
<script src="<?php echo base_url("js/bootbox.min.js"); ?>"></script>
<script type="text/javascript">

var updateOutput = function (e) {
                 var list = e.length ? e : $(e.target),
                         output = list.data('output');
                 if (window.JSON) {
                 	console.log(list.nestable('serialize'));
                     output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
                 } else {
                     output.val('JSON browser support required for this demo.');
                 }
             };

$('#nestable2').nestable({
                 group: 1
             }).on('change', updateOutput);
 updateOutput($('#nestable2').data('output', $('#nestable2-output')));

$(document).ready(function() {

    $("#menu_update").postAjaxData(function(result){
        console.log(result);
        if(result == 1)
        {
            $("#success").html('<div class="alert alert-success alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>Menu order done successfully.</div>');
        }
        else
        {
            $("#success").html('<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>Something went wrong.</div>');
        }
    });
});    
</script>