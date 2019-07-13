 <div class="page-content">

  <div class="wrap">

    <div class="ibox">

      <div class="ibox-title">

          <h5><?php echo ucfirst($this->lang_library->translate('T & C')); ?></h5>

          <div class="ibox-tools">

              <a class="collapse-link">

                  <i class="fa fa-chevron-up"></i>

              </a>

          </div>

      </div>

      <div class="ibox-content">  

        <div >

          <form>

                <div class="ibox float-e-margins">

                    <div class="ibox-content no-padding">

                        <div class="summernote">

                          <?php echo @$user[0]['T_C']?>

                        </div>



                    </div>

                </div>

                <button id="tc" class="btn btn-primary btn-block m-t" type="button"><i class="fa fa-arrow-down"></i> Apply</button>

          </form> 

        </div>

      </div>

    </div>

  </div>

</div>

<!-- SUMMERNOTE -->

  <script type="text/javascript" language="javascript" src="<?php echo base_url('js/plugins/summernote/summernote.min.js')?>"></script>

<!-- Sweet alert -->

<script src="<?php echo base_url('js/plugins/sweetalert/sweetalert.min.js'); ?>"></script>



<script type="text/javascript">



$(document).ready(function(){

var base="<?php echo base_url();?>";

    $('.summernote').summernote();



    $("#tc").on("click",function (e){

      var html = $('.summernote').code();

      $.ajax({

        data:{'text':html},

        type:'POST',

        url: '<?php echo base_url("TandC/add"); ?>',

        beforeSend:function(){

          $('.wrapper').prepend('<div id="Login_screen"><img src="'+base+'img/loader.gif"></div>');

          $("#Login_screen").fadeIn('fast');

        },

        success:function(response)

        {

          $("#Login_screen").fadeOut(2000);

          if (response)

          {

            toastr.success('Terms & conditions Applied.');

          }

          else

          {

             toastr.error("Something went wrong!");

          }

        }

      });

    })



});

var edit = function() {

    $('.click2edit').summernote({focus: true});

};

var save = function() {

    var aHTML = $('.click2edit').code(); //save HTML If you need(aHTML: array).

    $('.click2edit').destroy();

};





</script>