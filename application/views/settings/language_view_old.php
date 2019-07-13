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
                              <h3 class="text-center"></h3>
                                <form class="form-horizontal" role="form" id="form1" method="post" action="<?php echo base_url('settings/add_language'); ?>">
                                 
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
                                        <input type="hidden" class="form-control" name="Word[]" value="<?php echo $words['Word'];?>">
                                        <input type="text" class="form-control" id="Translation" name="Translation[]" placeholder="Translation For <?php echo $words['Word'];?>">
                                      </div>
                                        <span id="Translation"></span>
                                  </div>
                               <?php } }

                               ?>

                                  <div class="form-group">
                                      <div class="col-sm-6">
                                        <input type="hidden" id="langID" name="Language_ID">
                                      </div>
                                      <span id="Language_ID"></span>
                                 </div>

                                </form>  

                            </div>

                            <div class="step-content" id="step3">                             
                                <form class="form-horizontal" role="form" id="form3">

                                  <div class="form-group">
                                      <label for="" class="col-sm-3 control-label"></label>
                                    <div class="col-sm-6">
                                      <div class="checkbox">
                                          <label>
                                           <h3> <input type="checkbox" name="chbx">Check Here If You Want To Add Language Permanently.</h3>
                                         </label>
                                      </div>
                                    </div>
                                  </div>

                                  <div class="form-group">
                                      <div class="col-sm-6">
                                        <input type="hidden" id="languageID" name="Lang_ID">
                                      </div>
                                      <span id="Lang_ID"></span>
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

$(document).ready(function(){

            $('#fuelux-wizard').wizard().on('change', function(e, data) {
                console.log('change');
                if(data.step===1 && data.direction==='next') {
                    // return e.preventDefault();
                }
                console.log(data);
            }).on('change',function(e, data){
            //Custom Filterations
            switch(data.step)
            {
                case 1:

                //console.log(formdata);
                //   $('#form'+data.step).postAjaxData(function(result){
                //   //alert(result);
                //   console.log(formdata);
                //   if(result === true)
                //   {
                //       alert(result);                     
                //   }
                //   else {
                //     if(typeof result === 'object')
                //     {
                //       // alert(result);
                //       console.log(result);
                //       $.each(result,function(dom,err){
                //         $("#"+dom).text(err);
                //       });
                //     }
                //     else
                //     {
                //       alert('something went wrong.');
                //     }
                //   }
                // });


              formdata = $('#form'+data.step).serialize();
              console.log(formdata);
                 $.ajax({
                    url: '<?php echo base_url(); ?>settings/add_language',
                    type: "POST",
                    data: formdata,
                    dataType:"json",
                    success: function(response) {
                      console.log(response);                     
                      $("#langID").val(response);
                       alert("Language Added Successfully.");
                    //    bootbox.dialog({
                    //   message: "Thank you! Your data added successfully!", 
                    //   buttons: {
                    //     "success" : {
                    //       "label" : "OK",
                    //       "className" : "btn-sm btn-primary",
                    //       callback: function() {
                    //                                   //  alert("You clicked Yes");
                    //         window.location.href = config.base+'settings';
                    //                                   }
                    //     }
                    //   }
                    // });
                      
                   }
                 });
               break; 

               case 2 :
                 formdata = $('#form'+data.step).serialize();
                 //console.log(formdata);
                 $.ajax({
                    url: '<?php echo base_url(); ?>settings/add_translations',
                    type: "POST",
                    data: formdata,
                    dataType:"json",
                    success: function(response) {
                      console.log(response);
                      alert("Translation Added Successfully.");
                      $("#languageID").val(response);           
                      
                   }
                 });
               break;                

               default :               
               formdata = $('#form'+data.step).serialize();
               break;


            } 
                 
               
            
        }).on('finished', function(e, data) {
            console.log(15);
            
                var isChecked_lang_field = $('input[name=chbx]:checked').val();
                 if(isChecked_lang_field)
                 {
                    formdata = $('#form3').serialize();
                     //console.log(formdata);
                     $.ajax({
                        url: '<?php echo base_url(); ?>settings/update_custom_lang_file',
                        type: "POST",
                        data: formdata,
                        dataType:"json",
                        success: function(response) {
                          console.log(response);
                          //alert(response);                          
                          bootbox.dialog({
                          message: "Thank you! Your data added successfully!", 
                          buttons: {
                            "success" : {
                              "label" : "OK",
                              "className" : "btn-sm btn-primary",
                              callback: function() {
                                                          //  alert("You clicked Yes");
                                window.location.href = '<?php echo base_url(); ?>settings';
                                                          }
                            }
                          }
                        });
                          
                       }
                     });
                  }
               
            // console.log(data);
            // var formdata = $('#form'+data.step).serialize();
            // var validate6 = checkErrors(formdata,data);
            // console.log("validate 6");
            // console.log(validate6);
            // if(validate6)
            // {  


            /*  var form_data1 = $('#form1').serialize();
              var form_data2 = $('#form2').serialize();
              var form_data3 = $('#form3').serialize();
              
               console.log(form_data2);
                var finalData = {
                       formdata : { 
                          "form1":form_data1,
                          "form2":form_data2,
                          "form3":form_data3
                        },
              url : '<?php echo base_url(); ?>org_competition/add_competition_data',
              successMsg : "Competition Added successfully",
              sucessLink : '<?php echo base_url(); ?>org_competition/add'
            }
            lastStepCheck = lastCheck(finalData);*/

           /* bootbox.dialog({
                    message: "Thank you! Your information was successfully saved!", 
                    buttons: {
                               "success" : {
                               "label" : "OK",
                               "className" : "btn-sm btn-primary",
                        callback: function() {
                        //window.location.href = formData.successLink;
                        window.location.href = '<?php echo base_url(); ?>settings';
                                              }
                                            }
                            }
                  });*/
          // }
          // else 
          // {
          //   alert("something went wrong!");
          // }
                            
         // console.log(formdata);
          
        
            }).on('stepclick',function(e){
              return true;
            });

         /* var checkErrors = function(formData,wizardData){
          var data = wizardData;
          console.log(formData);
          if(data.step == (data.wizardContext.numSteps)-1)
          {
            $('#btnWizardNext').val("Register");
          }
          var request = $.ajax({
            url: '<?php echo base_url(); ?>setting/add_language',
            type: "POST",
            data: formData,
            dataType:"json",
                  async: false,
            success: function(response) {
              console.log(response);
              if(typeof response !== 'object')
              {
                console.log(data.step);
                if(data.step < data.wizardContext.numSteps)
                {
                  if(data.direction == "next")
                  {               
                    data.wizardContext.currentStep=data.step+1;
                  }
                  else if(data.direction == "previous")
                  {               
                    data.wizardContext.currentStep=data.step-1;
                  }
                  data.wizardContext.setState();
                  finalReply = false;
                }
                else 
                {
                  finalReply = true;
                }
              }
              else
              {
                 $.each(response,function(key,value){
                
                  var n = key.indexOf("[]");
                   if(n > -1)
                   {
                      var newString = key.substr(0, key.length-2);
                      $("#"+newString+" > span").text(value);
                   }
                   else
                   {
                     $("#"+key+" > span").text(value);
                   }
                });
              }
             }
          });
          //console.log(finalReply);
          return finalReply;
        };*/
     
    /* var lastCheck = function(formData){
       console.log("last_check");
          console.log(formData);
          $.ajax({
            url: formData.url,
            type: "POST",
            data: formData.formdata,
            //dataType:"json",
            success: function(response) {
              console.log("Ajax Response");
              console.log(response);
              if(response == 1)
              {
                  bootbox.dialog({
                              message: formData.successMsg, 
                              buttons: {
                               "success" : {
                                 "label" : "OK",
                                 "className" : "btn-sm btn-primary",
                 callback: function() {
                            //window.location.href = formData.successLink;
                            window.location.href = '<?php echo base_url(); ?>settings';
                                                      }
                              }
                                            }
                                      });
              }
              else
              {
                alert("something went wrong!");
              }
             }
          });
        };*/
          
          

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