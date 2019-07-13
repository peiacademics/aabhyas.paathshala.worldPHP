 <div class="page-content">
            <div class="wrap">
        <div class="ibox">
          <div class="ibox-title">
              <h5><?php echo ucfirst($this->lang_library->translate('Searching for '.$searchTerm.'....')); ?></h5>
              <div class="ibox-tools">
                  <a class="collapse-link">
                      <i class="fa fa-chevron-up"></i>
                  </a>
              </div>
          </div>
          <div class="ibox-content">
            <?php 
          if (!empty($searchData)) {
            foreach ($searchData as $key => $value)
            {
              foreach ($value as $k => $v)
              {
                if (strpos($v['ID'],'CS') !== false){ ?>
                <div class="feed-element">
                    <a href="#" class="pull-left">
                        <img alt="image" class="img-circle" src="<?php echo base_url().$v['Image_ID'];?>"></a>
                        <div class="media-body ">
                            <strong><a href="<?php echo base_url('Customer/view/'.$v['ID']); ?>"><?php echo $v['name']?></a></strong><span class="label label-warning-light pull-right">Customer</span> <?php echo @$v['Business_Name']?> <br>
                              <small class="text-muted"><?php echo @$v['email']?></small>
                        </div>
                </div>
               <?php  }else if (strpos($v['ID'],'VS') !== false) { ?>
               <div class="feed-element">
                    <a href="#" class="pull-left">
                        <img alt="image" class="img-circle" src="<?php echo base_url().$v['Image_ID'];?>"></a>
                        <div class="media-body ">
                            <strong><a href="<?php echo base_url('Vendor/view/'.$v['ID']); ?>"><?php echo $v['name']?></a></strong><span class="label label-success pull-right">Vendor</span><?php echo @$v['business_name']?> <br>
                              <small class="text-muted"><?php echo @$v['email']?></small>
                        </div>
                </div>
               <?php }else if (strpos($v['ID'],'PS') !== false) { ?>
               <div class="feed-element">
                    <a href="#" class="pull-left">
                        <img alt="image" class="img-circle" src="<?php echo base_url('upload/prod1.jpg');?>"></a>
                        <div class="media-body ">
                            <strong><a href="<?php echo base_url('Product/view/'.$v['ID']); ?>"><?php echo $v['name']?></a></strong><span class="label label-primary pull-right">Product</span>  <br>
                              <small class="text-muted"><?php echo @$v['model_name']?></small>
                        </div>
                </div>
                <?php }
              }
            }
          }else
          {
           ?>
           <h7>No data found</h7>
           <?php } ?>
        </div>
      </div>
</div>
</div>