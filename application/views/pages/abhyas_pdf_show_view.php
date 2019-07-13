<style type="text/css">
  .fit_canvas{
    border: solid 1px blue;
    width: 100%;
  }
</style>
<div class="page-content">
  <div class="wrap">
    <div class="ibox">
      <div class="ibox-title">
        <h5><?php echo ucfirst($this->lang_library->translate('Abhyas PDF')); ?></h5>
        <div class="ibox-tools">
          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>
        </div>
      </div>
      <div class="ibox-content table-responsive">
         <div class="text-center pdf-toolbar">
          <div class="btn-group">
              <button id="prev" class="btn btn-white"><i class="fa fa-long-arrow-left"></i> <span class="hidden-xs">Previous</span></button>
              <button id="next" class="btn btn-white"><i class="fa fa-long-arrow-right"></i> <span class="hidden-xs">Next</span></button>
              <button id="zoomin" class="btn btn-white"><i class="fa fa-search-plus"></i> <span class="hidden-xs">Zoom In</span></button>
              <button id="zoomout" class="btn btn-white"><i class="fa fa-search-minus"></i> <span class="hidden-xs">Zoom Out</span> </button>
              <button id="zoomfit" class="btn btn-white"> 100%</button>
              <span class="btn btn-white hidden-xs">Page: </span>

              <div class="input-group">
                  <input type="text" class="form-control" id="page_num">

                  <div class="input-group-btn">
                      <button type="button" class="btn btn-white" id="page_count">/ 22</button>
                  </div>
              </div>

          </div>
        </div>
        <div class="text-center m-t-md">
          <canvas id="the-canvas" class="pdfcanvas border-left-right border-top-bottom b-r-md fit_canvas"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Data Tables -->
<script src="<?php echo base_url("js/plugins/dataTables/jquery.dataTables.js"); ?>"></script>
<script src="<?php echo base_url("js/plugins/dataTables/dataTables.bootstrap.js"); ?>"></script>
<script src="<?php echo base_url("js/plugins/dataTables/dataTables.responsive.js"); ?>"></script>
<script src="<?php echo base_url("js/plugins/dataTables/dataTables.tableTools.min.js"); ?>"></script>
<script src="<?php echo base_url("js/plugins/datapicker/bootstrap-datepicker.js"); ?>"></script>
<script src="<?php echo base_url("js/plugins/fullcalendar/moment.min.js"); ?>"></script>
<script src="<?php echo base_url("js/plugins/daterangepicker/daterangepicker.js"); ?>"></script>
<!-- Datatable -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url('css/buttons.dataTables.min.css'); ?>">
<script type="text/javascript" language="javascript" src="<?php echo base_url('js/dataTables.buttons.min.js'); ?>">
</script>
<script type="text/javascript" language="javascript" src="<?php echo base_url('js/buttons.flash.min.js'); ?>">
</script>
<script type="text/javascript" language="javascript" src="<?php echo base_url('js/jszip.min.js'); ?>">
</script>
<script type="text/javascript" language="javascript" src="<?php echo base_url('js/pdfmake.min.js'); ?>">
</script>
<script type="text/javascript" language="javascript" src="<?php echo base_url('js/vfs_fonts.js'); ?>">
</script>
<script type="text/javascript" language="javascript" src="<?php echo base_url('js/buttons.html5.min.js'); ?>">
</script>
<script type="text/javascript" language="javascript" src="<?php echo base_url('js/buttons.print.min.js'); ?>">
</script>
<script type="text/javascript" language="javascript" src="<?php echo base_url('js/dataTables.responsive.min.js'); ?>">
</script>
<script src="<?php echo base_url("js/plugins/pdfjs/pdf.js"); ?>"></script>

<script type="text/javascript">
  var base_url = '<?php echo base_url(); ?>';
  $(document).ready(function() {
      $('#the-canvas').bind('contextmenu',function() {
          return false;
        });
        var url_pdf = base_url+'<?php echo $path; ?>';
        var pdfDoc = null,
                pageNum = 1,
                pageRendering = false,
                pageNumPending = null,
                scale = 1.5,
                zoomRange = 0.25,
                canvas = document.getElementById('the-canvas'),
                ctx = canvas.getContext('2d');

        /**
         * Get page info from document, resize canvas accordingly, and render page.
         * @param num Page number.
         */
        function renderPage(num, scale) {
            pageRendering = true;
            // Using promise to fetch the page
            pdfDoc.getPage(num).then(function(page) {
                var viewport = page.getViewport(scale);
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                // Render PDF page into canvas context
                var renderContext = {
                    canvasContext: ctx,
                    viewport: viewport
                };
                var renderTask = page.render(renderContext);

                // Wait for rendering to finish
                renderTask.promise.then(function () {
                    pageRendering = false;
                    if (pageNumPending !== null) {
                        // New page rendering is pending
                        renderPage(pageNumPending);
                        pageNumPending = null;
                    }
                });
            });

            // Update page counters
            document.getElementById('page_num').value = num;
        }

        /**
         * If another page rendering in progress, waits until the rendering is
         * finised. Otherwise, executes rendering immediately.
         */
        function queueRenderPage(num) {
            if (pageRendering) {
                pageNumPending = num;
            } else {
                renderPage(num,scale);
            }
        }

        /**
         * Displays previous page.
         */
        function onPrevPage() {
            if (pageNum <= 1) {
                return;
            }
            pageNum--;
            var scale = pdfDoc.scale;
            queueRenderPage(pageNum, scale);
        }
        document.getElementById('prev').addEventListener('click', onPrevPage);

        /**
         * Displays next page.
         */
        function onNextPage() {
            if (pageNum >= pdfDoc.numPages) {
                return;
            }
            pageNum++;
            var scale = pdfDoc.scale;
            queueRenderPage(pageNum, scale);
        }
        document.getElementById('next').addEventListener('click', onNextPage);

        /**
         * Zoom in page.
         */
        function onZoomIn() {
            $('#the-canvas').removeClass('fit_canvas');
            if (scale >= pdfDoc.scale) {
                return;
            }
            scale += zoomRange;
            var num = pageNum;
            renderPage(num, scale)
        }
        document.getElementById('zoomin').addEventListener('click', onZoomIn);

        /**
         * Zoom out page.
         */
        function onZoomOut() {
            $('#the-canvas').removeClass('fit_canvas');
            if (scale >= pdfDoc.scale) {
                return;
            }
            scale -= zoomRange;
            var num = pageNum;
            queueRenderPage(num, scale);
        }
        document.getElementById('zoomout').addEventListener('click', onZoomOut);

        /**
         * Zoom fit page.
         */
        function onZoomFit() {
            $('#the-canvas').addClass('fit_canvas');
            if (scale >= pdfDoc.scale) {
                return;
            }
            scale = 1;
            var num = pageNum;
            queueRenderPage(num, scale);
        }
        document.getElementById('zoomfit').addEventListener('click', onZoomFit);



        /**
         * Asynchronously downloads PDF.
         */
        PDFJS.getDocument(url_pdf).then(function (pdfDoc_) {
            pdfDoc = pdfDoc_;
            var documentPagesNumber = pdfDoc.numPages;
            document.getElementById('page_count').textContent = '/ ' + documentPagesNumber;

            $('#page_num').on('change', function() {
                var pageNumber = Number($(this).val());

                if(pageNumber > 0 && pageNumber <= documentPagesNumber) {
                    queueRenderPage(pageNumber, scale);
                }

            });

            // Initial/first page rendering
            renderPage(pageNum, scale);
        });
  });
  
  function deletef(id,href)
  {
    bootbox.confirm('Are you sure you want to delete?', function(result) {
      if(result == true)
      {
        $('body').prepend('<div id="Login_screen"><img src="'+base_url+'img/loader.gif"></div>');
        $("#Login_screen").fadeIn('fast');
        $.ajax({
          url:href,
          method:'POST',
          datatype:'JSON',
          error: function(jqXHR, exception) {
            $("#Login_screen").fadeOut(2000);
            if (jqXHR.status === 0) {
              alert('Not connect.\n Verify Network.');
            } else if (jqXHR.status == 404) {
              alert('Requested page not found. [404]');
            } else if (jqXHR.status == 500) {
              alert('Internal Server Error [500].');
            } else if (exception === 'parsererror') {
              alert('Requested JSON parse failed.');
            } else if (exception === 'timeout') {
              alert('Time out error.');
            } else if (exception === 'abort') {
              alert('Ajax request aborted.');
            } else {
              alert('Uncaught Error.\n' + jqXHR.responseText);
            }
          },
          success:function(response){
            $("#Login_screen").fadeOut(2000);
            response = JSON.parse(response);
            if(response === true)
            {
              toastr.success('Successfully deleted.');
              setTimeout(function(){
                oTable.ajax.reload();
              }, 3000);
            }
            else
            {
              toastr.error("Something went wrong!");
            }
          }
        });
      }
    });
  }

</script>