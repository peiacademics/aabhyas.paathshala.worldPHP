<div class="page-content">
  <div class="wrap" id="wrap">
    <!--<ol class="back_menu">
        <li><a href="#">Dashboard </a> / </li>
          <li><a href="#">Dashboard </a> / </li>
          <li><a href="#">Panel </a> </li>
      </ol>-->
    <h1 class="text-center">FAQ</h1>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div id="panel_body_id">
            <div class="tabs">
              <ul class="nav nav-tabs padding-18 tab-size-bigger" id="mytab">
                <?php
                  $cnt = count($questionAnswers);
                  $i = 1;
                  if(!is_null($questionAnswers))
                  {
                    foreach($questionAnswers as $row){
                      if($i<=3)
                      {
                      //echo '1';
                        if($i === 1)
                        {
                            echo '<li class="active">';
                            echo '<a data-toggle="tab" href="#faq-tab-'.$i.'"><i class="blue fa fa-'.$row['properties'][2].' bigger-120"></i>'.$row['properties'][1].'</a>';
                             echo '</li>'; 
                        }
                        else
                        {
                            echo '<li>';
                            echo '<a data-toggle="tab" href="#faq-tab-'.$i.'"><i class="blue fa fa-'.$row['properties'][2].' bigger-120"></i>'.$row['properties'][1].'</a>';
                            echo '</li>'; 
                        }
                        
                    }
                   if($i == 4)
                    {
                        echo '<li class="dropdown">';
                        echo '<a data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="purple fa fa-magic bigger-120"></i>More<i class="fa fa-caret-down padding-left5"></i></a>';
                        echo ' <ul class="dropdown-menu dropdown-lighter dropdown-125">';
                    }
                    if($i > 3)
                    {
                        echo '<li class=""><a data-toggle="tab" href="#faq-tab-'.$i.'">'.$row['properties'][1].'</a></li>';
                    }
                    if($i > 3 && $cnt == $i)
                    {
                        echo '</ul></li>';
                    } 
                $i++; 
              } 

              ?>
              </ul>
              <div class="tab-content no-border padding-24">
              <?php 
                  $j=1;
                   $x = 1;
                  foreach($questionAnswers as $row)
                  {
                      if($j==1)
                      {
                          echo '<div id="faq-tab-'.$j.'" class="tab-pane fade active in">';
                      }
                      else
                      {
                          echo '<div id="faq-tab-'.$j.'" class="tab-pane fade">';
                      }
                      
              ?>  
               <h4 class="blue">
              <i class="fa fa-check bigger-110 padding-right5"></i>
              <?php echo $row['properties'][1]; ?> Questions
            </h4>

            <div class="space-8"></div>

            <div id="faq-list-<?php echo $j; ?>" class="panel-group accordion-style1 accordion-style2">
              <?php 
                  
                 if(array_key_exists('data', $row))
                 {
                  foreach($row['data'] as $one)
                  {
                     
              ?>
              <div class="panel panel-default">
                <div class="panel-heading">
                  <a href="#faq-<?php echo $j.'-'.$x; ?>" data-parent="#faq-list-<?php echo $j; ?>" data-toggle="collapse" class="accordion-toggle collapsed">
                    <i class="fa fa-user bigger-130"></i>
                    &nbsp;<?php echo $one['Question']; ?>
                  </a>
                </div>

                <div class="panel-collapse collapse" id="faq-<?php echo $j.'-'.$x; ?>">
                  <div class="panel-body">
                      <?php
                        $y =1;
                        if(!array_key_exists('childs', $row))
                        {
                           echo $one['Answer'];
                         }
                        else if(!array_key_exists($one['ID'], $row['childs']))
                        {
                           echo $one['Answer'];
                        }
                        else
                        {
                          echo '<div id="faq-list-nested-'.$x.'" class="panel-group accordion-style1 accordion-style2">';
                            foreach($row['childs'][$one['ID']] as $childs)
                            {
                                echo '<div class="panel panel-default">
                        <div class="panel-heading">
                          <a href="#faq-list-'.$x.'-sub-'.$y.'" data-parent="#faq-list-nested-'.$x.'" data-toggle="collapse" class="sub-data accordion-toggle collapsed">
                            &nbsp;'.$childs['Question'].'
                          </a>
                        </div>

                        <div class="panel-collapse collapse" id="faq-list-'.$x.'-sub-'.$y.'">
                          <div class="panel-body">
                           '.$childs['Answer'].' 
                        </div>
                      </div>
                    </div>';
                            $y++;
                            }
                            echo '</div>';
                        }
                     ?>
                  </div>
                </div>
              </div>
              <?php 
                $x++;
                }
              }
              else
              {
                  echo 'No data';
              }
             ?>
              
            </div>
         
          <?php 
            echo ' </div>';
            $j++;
          }
        }
        else
        {
            echo 'no data';
        }

   ?>

          
        </div>
          </div>
          </div>
          
        </div>
      </div>
    </div>               
  </div>
</div>
<!-- Custom and plugin javascript -->
<script src="<?php echo base_url("js/bootbox.min.js"); ?>"></script>
<script src="<?php echo base_url("js/formSerialize.js"); ?>"></script>
<!-- Jquery Validate -->
<script src="<?php echo base_url("js/plugins/validate/jquery.validate.min.js"); ?>"></script>
<!-- <script type="text/javascript" src="js/applications.js"></script>
 --><!-- Nestable List -->
<script type="text/javascript" src="<?php echo base_url('js/plugins/nestable/jquery.nestable.js'); ?>"></script>
<script type="text/javascript">
jQuery(function($) {
  $('.accordion').on('hide', function (e) 
    $(e.target).prev().children(0).addClass('collapsed');
  })
  $('.accordion').on('show', function (e) {
    $(e.target).prev().children(0).removeClass('collapsed');
  })
});
</script>