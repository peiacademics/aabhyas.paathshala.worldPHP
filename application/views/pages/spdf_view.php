<style type="text/css">
  .fit_canvas{
    /*border: solid 1px blue;*/
    width: 100%;
  }
</style>
<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-10">
    <h2><?php echo $data['package']; ?> - PDF Tutorial</h2>
    <ol class="breadcrumb">
      <li>
        <?php echo $data['subject']; ?>
      </li>
      <li>
        <?php echo $data['lesson']; ?>
      </li>
      <li class="font-bold">
        <a href="<?php echo base_url('dashboard/topic/'.@$data['link']); ?>"><?php echo $data['topic']; ?></a>
      </li>
      <li class="active">
        <?php echo $data['list']; ?>
      </li>
    </ol>
  </div>
  <div class="col-lg-2">

  </div>
</div>
<div class="row">
  <div class="text-center" style="width:100% !important;">
      <div class="btn-group">
          <button id="prev" class="btn btn-white"><i class="fa fa-long-arrow-left"></i> <!-- <span class="hidden-xs">Previous</span> --></button>
          <button id="next" class="btn btn-white"><i class="fa fa-long-arrow-right"></i><!--  <span class="hidden-xs">Next</span> --></button>
          <button id="zoomin" class="btn btn-white"><i class="fa fa-search-plus"></i><!--  <span class="hidden-xs">Zoom In</span> --></button>
          <button id="zoomout" class="btn btn-white"><i class="fa fa-search-minus"></i><!--  <span class="hidden-xs">Zoom Out</span>  --></button>
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
  <div class="text-center table-responsive"><!-- m-t-md -->
      <canvas id="the-canvas" class="responsive pdfcanvas border-left-right border-top-bottom b-r-md fit_canvas"></canvas>
  </div>
</div>
<script src="<?php echo base_url('js/plugins/pdfjs/pdf.js');?>"></script>

<script type="text/javascript">
  $(document).ready(function() {
    $('#the-canvas').bind('contextmenu',function() {
          return false;
        });
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


            $.ajax({
              method:'POST',
              data:{'url_data':'<?php echo $this->uri->segment(3); ?>'},
              url:base_url+'spdf/get_pdf',
              error:function(err){
                bootbox.alert('Something Went Wrong');
              },
              success:function(res)
              {
                res = JSON.parse(res);
                if(res != '0')
                {
                  var url_l = base_url+res;
                  //alert(url_l);
                  /**
                   * Asynchronously downloads PDF.
                  */
                  PDFJS.getDocument(url_l).then(function (pdfDoc_) {
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
                }
                else{
                  bootbox.alert('No PDF Available');
                }
              }
            });
  });
</script>