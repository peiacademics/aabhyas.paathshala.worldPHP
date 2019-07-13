

            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox">
                        <div class="ibox-content">

                            <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="15">
                                <thead>
                                <tr>

                                    <th data-toggle="true">Page</th>
                                    <!-- <th data-hide="all">Description</th> -->
                                    <th data-hide="phone">Type</th>

                                </tr>
                                </thead>
                                <tbody>
                                <?php if (empty($errorLogs)) { ?>
                                    <tr>
                                    <td colspan="7">
                                    No data found
                                    </td>
                                   
                                </tr>
                              <?php  }
                                else
                                {
                                    foreach ($errorLogs as $key => $value) {
                                     ?>

                                    <tr>
                                        <td>
                                          <a onclick="redirect('<?php $d=explode('%-', $key); echo $d[0].'?GET='.$value[0]['token'];?>')"><?php 
                                          echo $d[0];?></a>
                                        </td>
                                        <td>
                                         <?php if ($value[0]['Type']==='Warning') {
                                            $cls='warning';
                                        }
                                        else if ($value[0]['Type']==='Error') {
                                             $cls='danger';
                                        }
                                        else
                                            {
                                                 $cls='success';
                                            }?>
                                            <span class="label label-<?php echo $cls;?>"><?php echo $value[0]['Type'];?></span>
                                        </td>
                                    </tr>

                                <?php
                                } }
                                ?>
                                
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="6">
                                        <ul class="pagination pull-right"></ul>
                                    </td>
                                </tr>
                                </tfoot>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
            <?php //var_dump($errorLogs[0]);?>
<!-- FooTable -->
<!--     <link href="<?php //echo base_url('css/plugins/footable/footable.core.css'); ?>" rel="stylesheet">
            <script src="<?php //echo base_url('js/plugins/footable/footable.all.min.js'); ?>"></script> -->

    <!-- Page-Level Scripts -->
    <script>
        // $(document).ready(function() {

        //     $('.footable').footable();

        // });

        function redirect(paths) {
            window.open(paths, '_blank');
        }
    </script>