/*
 * Author: Abdullah A Almsaeed
 * Date: 4 Jan 2014
 * Description:
 *      This is a demo file used only for the main dashboard (index.html)
 **/

$(document).ready(function() {
  // $(".ibox").accordion({ header: "h5", collapsible: true, active: false });
var oTable;
var stockTable;
var purchaseTable;
var sellTable;
var returnTable;

  "use strict";

  $('.daterange').daterangepicker({
    ranges: {
      'Today': [moment(), moment()],
      'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
      'Last 7 Days': [moment().subtract(6, 'days'), moment()],
      'Last 30 Days': [moment().subtract(29, 'days'), moment()],
      'This Month': [moment().startOf('month'), moment().endOf('month')],
      'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    },
    startDate: moment().subtract(29, 'days'),
    endDate: moment()
  }, function (start, end) {
    // window.alert("You chose: " + start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
  });

  var branch_ID = $("#branch_ID").val();
  $.ajax({
        type:'POST',
        datatype:JSON,
        data:{'branch_ID':branch_ID},
        url:base_url+"report/getSell",
        success:function(response)
        {
          $("#revenue-chart").html("");
          console.log(response);
          // response=JSON.parse(response);

            var area = new Morris.Area({
            element: 'revenue-chart',
            // resize: true,
            data: response['map'],
            xkey: 'y',
            ykeys: ['item1'],
            labels: ['Calls'],
            lineColors: ['#54cdb4'],
            hideHover: 'auto'
          });

            sellTable = $('#exampleSell').DataTable({
              "data":response['dataset'],
              columns: [
                  { title: "List" },
                  { title: "Name" },
                  { title: "City" },
                  { title: "Country" }
              ],
               dom: 'Bfrtip',
               buttons: [
                    'print'
                ],
              responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.modal( {
                        header: function ( row ) {
                            var data = row.data();
                            return 'Details for '+data[0]+' '+data[1];
                        }
                    } ),
                    renderer: function ( api, rowIdx, columns ) {
                        var data = $.map( columns, function ( col, i ) {
                            return '<tr>'+
                                    '<td>'+col.title+':'+'</td> '+
                                    '<td>'+col.data+'</td>'+
                                '</tr>';
                        } ).join('');
     
                        return $('<table class="table"/>').append( data );
                    }
                }
            }
          });

        }
      });



  //Fix for charts under tabs
  $('.box ul.nav a').on('shown.bs.tab', function () {
    area.redraw();
    donut.redraw();
    line.redraw();
  });

    $("#getSell").on("click",function (){
      $("#revenue-chart").html("<div class='text-center text-danger'><h2>Loading........<h2><div>");
      var formdata=$("#sellData").serialize();
      $.ajax({
        data:formdata,
        type:'POST',
        datatype:JSON,
        url:base_url+"report/getSell",
        success:function(response)
        {
          $("#revenue-chart").html("");
          console.log(response);
          // response = JSON.parse(response);

            var area = new Morris.Area({
            element: 'revenue-chart',
            // resize: true,
            data: response['map'],
            xkey: 'y',
            ykeys: ['item1'],
            labels: ['Calls'],
            lineColors: ['#54cdb4'],
            hideHover: 'auto'
          });

            sellTable.clear().draw();
            sellTable.rows.add(response['dataset']).draw(); // Add new data
        }
      });
    });
});
