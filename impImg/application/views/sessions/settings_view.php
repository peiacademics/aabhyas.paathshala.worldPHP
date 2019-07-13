<div class="page-content">

<div class="row" id="wrap">

    <div>

  <?php

    foreach($settings_menu as $key=>$val)

    {

  ?>  

      <div class="ibox">

          <div class="ibox-title">

              <h5><?php echo ucfirst($this->lang_library->translate($key)); ?></h5>

              <div class="ibox-tools">

                  <a class="collapse-link">

                      <i class="fa fa-chevron-up"></i>

                  </a>

              </div>

          </div>

          <div class="ibox-content">

            <div class="row">

            <div class="">

    <?php

      if(!is_null($val))

      {

        foreach($val as $row)

        {

            $title = $this->lang_library->translate($row['Title']);

    ?>
          <div class="form-group">
            <div class="col-sm-4 col-xs-12">
              <a class="form-group" href="<?php echo base_url($row['Link']); ?>">
                <button class="btn dim btn-primary btn-block btn-lg">
                  <i class="fa fa-<?php echo $row['Icon']; ?> fa-3x" ></i>
                  <br>
                  <h4><?php echo $title; ?></h4>
                </button>

                <!-- <div class="widget navy-bg text-center">

                  <div class="m-b-md">

                    <i class="fa fa-<?php echo $row['Icon']; ?> fa-4x"></i>

                    <h5 class="m-xs">- - - - - - - - - - - -</h5>

                    <h3 class="font-bold no-margins">

                      <?php echo $title; ?>

                    </h3>

                    <h5 class="m-xs">- - - - - - - - - - - -</h5>

                  </div>

                </div> -->

              </a>

            </div>
          </div>
    <?php

        }

      }

      else

      {

          echo '<li>No Settings Available.</li>';

      }

    ?>      </div>

            </div>

          </div>

      </div>

  <?php 

    }

  ?>

    </div>

  </div> 

</div>    

