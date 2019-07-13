        <div class="page-content">
            <div class="wrap">

              <h1 class="text-center">Add Language</h1>
          <div class="container">
                <div class="row">
            <div class="row">
                      <div class="col-xs-12">
                        <div class="widget-box">
                            <div class="body_header">
                              <h4 class="lighter">Add New Language</h4>
                            </div>
                      <div class="body_text_text">
                          <div id="fuelux-wizard" class="" data-target="#step-container">
                            <ul class="panel-steps">
                              <li data-target="#step1" class="active">
                                <span class="step">1</span>
                                <span class="title">Step 1</span>
                              </li>

                              <li data-target="#step2" class="">
                                <span class="step">2</span>
                                <span class="title">Step 2</span>
                              </li>

                              <li data-target="#step3" class="">
                                <span class="step">3</span>
                                <span class="title">Step 3</span>
                              </li>

                             <!--  <li data-target="#step4" class="">
                                <span class="step">4</span>
                                <span class="title">Step 4</span>
                              </li> -->
                            </ul>
                          </div>

                          <hr>
                           <div class="step-container position-relative" id="step-container">
                            <div class="step-content active" id="step1">
                              <h3 class="text-center">Enter The Following Information</h3>
                                <form class="form-horizontal" role="form" id="form1">
                                 
                                  <div class="form-group">
                                      <label for="Title" class="col-sm-3 control-label">Title</label>
                                      <div class="col-sm-6">
                                        <input type="text" class="form-control" id="Title" name="Title" placeholder="Title">
                                      </div>
                                        <span id="Title"></span>
                                  </div> 

                                  <div class="form-group">
                                      <label for="Substitute_English" class="col-sm-3 control-label">Substitute English</label>
                                      <div class="col-sm-6">
                                        <div class="radio">
                                          <label>
                                            <input type="radio" name="Substitute_English" id="Substitute_English" value="1" checked> Yes &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="radio" name="Substitute_English" id="Substitute_English" value="0" checked> No
                                         </label>
                                        </div>
                                      </div>
                                      <span id="Substitute_English"></span>
                                  </div> 

                                  <div class="form-group">
                                      <label for="rtl" class="col-sm-3 control-label">Right To Left</label>
                                      <div class="col-sm-6">
                                        <div class="radio">
                                          <label>
                                            <input type="radio" name="rtl" id="rtl" value="1" checked> Yes &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                             <input type="radio" name="rtl" id="rtl" value="0" checked> No
                                         </label>
                                        </div>                                       
                                      </div>
                                      <span id="rtl"></span>
                                  </div>                                      
                                </form>
                            </div>

                            <div class="step-content" id="step2">
                              <h3 class="text-center">Enter The Translation Of Selected Language </h3>
                                <form class="form-horizontal" role="form" id="form2">                                
                                <?php if($word_array != FALSE) {
                                foreach($word_array as $words) { ?>
                                  <div class="form-group">
                                      <label for="" class="col-sm-3 control-label"><?php echo $words['Word']; ?></label>
                                      <div class="col-sm-6">
                                        <input type="text" class="form-control" id="Translation" name="Translation[]" placeholder="Translation For <?php echo $words['Word'];?>">
                                      </div>
                                        <span id="Translation"></span>
                                  </div>
                               <?php } }

                               ?>

                                </form> 

                            </div>

                            <div class="step-content" id="step3">                             
                                <form class="form-horizontal" role="form" id="form2">

                                  <div class="form-group">
                                      <label for="" class="col-sm-3 control-label"></label>
                                    <div class="col-sm-6">
                                      <div class="checkbox">
                                          <label>
                                           <h3> <input type="checkbox">Check Here If You Want To Add Language Permanently.</h3>
                                         </label>
                                      </div>
                                    </div>
                                  </div>

                                </form>
                            </div>

                     <!--   <div class="step-content" id="step4">
                              <div class="center">
                                <h3 class="final_step4 text-center">Congrats!</h3>                               
                              </div>
                            </div> -->
                          </div>

                          <hr>
                          <div class="wizard-actions">
                            <button class="btn btn-prev">
                              <i class="fa fa-arrow-left"></i>
                              Prev
                            </button>

                            <button type="button" class="btn btn-success btn-next" data-last="Finish">
                              Next 
                            <i class="fa fa-arrow-right fa fa-on-right"></i></button>
                          </div>
                      </div><!-- /widget-body -->
                    </div>
                  </div>
                </div>

              
              </div>
              
          </div>
             </div>
        </div>

<script src="<?php echo base_url(); ?>js/fuelux.wizard.min.js"></script>
<!-- <script src="js/ace-elements.min.js"></script>-->
<script src="<?php echo base_url(); ?>js/bootbox.min.js"></script>

<script type="text/javascript">
        /*jQuery(function($) {
            $('#fuelux-wizard').wizard().on('change' , function(e, data){
              alert('hiiiiii');
                  if(info.step == 1) {
                      //if(!$('#validation-form').valid()) return false;
                    }
                }).on('finished', function(e) {
                  bootbox.dialog({
                    message: "Thank you! Your information was successfully saved!", 
                    buttons: {
                      "success" : {
                        "label" : "OK",
                        "className" : "btn-sm btn-primary"
                      }
                    }
                  });
                }).on('stepclick', function(e){
                  return false;//prevent clicking on steps
                });

            /*$('#modal-wizard .modal-header').ace_wizard();
            $('#modal-wizard .wizard-actions .btn[data-dismiss=modal]').removeAttr('disabled');

      });*/
$(document).ready(function(){

            $('#fuelux-wizard').wizard().on('change', function(e, data) {
                console.log('change');
                if(data.step===3 && data.direction==='next') {
                    // return e.preventDefault();
                }
                console.log(data);
            }).on('finished', function(e) {
                  bootbox.dialog({
                    message: "Thank you! Your information was successfully saved!", 
                    buttons: {
                      "success" : {
                        "label" : "OK",
                        "className" : "btn-sm btn-primary"
                      }
                    }
                  });
                }).on('stepclick',function(e){
              return true;
            });

            $('#fuelux-wizard').on('changed', function(e, data) {
                console.log('changed');
            });

           /* $('#fuelux-wizard').on('finished', function(e, data) {
                console.log('finished');
            });*/

            $('.btn-prev').on('click', function() {
                console.log('prev');
                $('#fuelux-wizard').wizard('previous');
            });

            $('.btn-next').on('click', function() {
                console.log('next');
                $('#fuelux-wizard').wizard('next');
            });

        });

/*(function(a,b){a.fn.ace_wizard=function(c){
  this.each(function(){var e=a(this);
    e.wizard();
    var d=e.siblings(".wizard-actions").eq(0);
    var f=e.data("wizard");
    f.$prevBtn.remove();
    f.$nextBtn.remove();
    f.$prevBtn=d.find(".btn-prev").eq(0).on(ace.click_event,function(){
      e.wizard("previous")}).attr("disabled","disabled");
    f.$nextBtn=d.find(".btn-next").eq(0).on(ace.click_event,function(){e.wizard("next")}).removeAttr("disabled");
    f.nextText=f.$nextBtn.text()});return this}})
(window.jQuery);*/

</script>