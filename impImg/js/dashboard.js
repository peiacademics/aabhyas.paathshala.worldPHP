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

  $.ajax({
        // data:formdata,
        type:'POST',
        datatype:JSON,
        url:base_url+"report/getSell",
        success:function(response)
        {
          $("#revenue-chart").html("");
          console.log(response);
            var area = new Morris.Area({
            element: 'revenue-chart',
            // resize: true,
            data: response['map'],
            xkey: 'y',
            ykeys: ['item1'],
            labels: ['Sells'],
            lineColors: ['#54cdb4'],
            hideHover: 'auto'
          });

            sellTable = $('#exampleSell').DataTable({
              "data":response['dataset'],
              columns: [
                  { title: "Bill No" },
                  { title: "Date" },
                  { title: "Customer Name" },
                  { title: "Total" }
                  // { title: "Status" }
              ],
              drawCallback: function() {
           var api = this.api();
           var total = api.column(3).data().sum();
           var pageTotal = api.column(3, {page:'current'}).data().sum();
           console.log(pageTotal);
           $('#totlAmt').html("<h3 class='well'><i class='text-success'>"+pageTotal+"</i> &nbsp;&nbsp;<i class='fa fa-inr'></i></h3>");
           $('#Amt').html("<h3 class='well'> <i class='text-danger'><b>"+total +"</b></i> &nbsp;&nbsp;<i class='fa fa-inr'></i></h3>");
           // $(api.column(4).footer()).html('$' + pageTotal + ' ( $' + total + ' total)');
        }
          });
        }
      });

  $.ajax({
        // data:formdata,
        type:'POST',
        datatype:JSON,
        url:base_url+"report/getPurchase",
        success:function(response)
        {
          $("#line-chart").html("");
          console.log(response);
            var area = new Morris.Area({
            element: 'line-chart',
            // resize: true,
            data: response['map'],
            xkey: 'y',
            ykeys: ['item1'],
            labels: ['Purchase'],
            lineColors: ['#54cdb4','#1ab394'],
            hideHover: 'auto'
          });

            purchaseTable = $('#examplePurchase').DataTable({
              "data":response['dataset'],
              columns: [
                  { title: "Bill No" },
                  { title: "Date" },
                  // { title: "Tax" },
                  // { title: "Discount" },
                  { title: "Vender" },
                  // { title: "Detail" },
                  { title: "Total" }
              ]
          });
        }
      });


   /*$.ajax({
        // data:formdata,
        type:'POST',
        datatype:JSON,
        url:base_url+"report/getStock",
        success:function(response)
        {
          $("#morris-line-chart").html("");
          console.log(response);
           new Morris.Area({
            element: 'morris-line-chart',
            data: response['map'],
            xkey: 'y',
            ykeys: ['a'],
            labels: ['Stock'],
            hideHover: 'auto',
            resize: true,
            lineColors: ['#54cdb4','#1ab394'],
        });

           stockTable = $('#exampleStock').DataTable({
              "data":response['dataset'],
              columns: [
                  { title: "Date" },
                  { title: "Size" },
                  { title: "Product" },
                  { title: "Source" },
                  { title: "Total" }
              ]
          });
        }
      });*/
  /* Morris.js Charts */
  // Sales chart
$.ajax({
        // data:formdata,
        type:'POST',
        datatype:JSON,
        url:base_url+"report/getExpCat",
        success:function(response)
        {
          $("#line-chart1").html("");
          console.log(response);
           var area = new Morris.Area({
            element: 'line-chart1',
            // resize: true,
            data: response['map'],
            xkey: 'y',
            ykeys: ['item1'],
            labels: ['Transactions'],
            lineColors: ['#a0d0e0', '#3c8dbc'],
            hideHover: 'auto'
          });

           // datatable
          oTable = $('#example').DataTable({
              "data":response['dataset'],
              columns: [
                  { title: "Transaction Type" },
                  { title: "Date" },
                  { title: "Total Amount" },
                  { title: "Payment Mode" },
                  { title: "Account No." },
                  { title: "Detail" }
              ]
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
            var area = new Morris.Area({
            element: 'revenue-chart',
            // resize: true,
            data: response['map'],
            xkey: 'y',
            ykeys: ['item1'],
            labels: ['Sells'],
            lineColors: ['#54cdb4'],
            hideHover: 'auto'
          });

            sellTable.clear().draw();
            sellTable.rows.add(response['dataset']).draw(); // Add new data
             returnTable.clear().draw();
            returnTable.rows.add(response['dataReturn']).draw(); // Add new data
        }
      });
    });

 $("#getPurchase").on("click",function (){
      $("#line-chart").html("<div class='text-center text-danger'><h2>Loading........<h2><div>");
      var formdata=$("#purchaseData").serialize();
      $.ajax({
        data:formdata,
        type:'POST',
        datatype:JSON,
        url:base_url+"report/getPurchase",
        success:function(response)
        {
          $("#line-chart").html("");
          console.log(response);
            var area = new Morris.Area({
            element: 'line-chart',
            // resize: true,
            data: response['map'],
            xkey: 'y',
            ykeys: ['item1'],
            labels: ['Purchase'],
            lineColors: ['#54cdb4','#1ab394'],
            hideHover: 'auto'
          });

            purchaseTable.clear().draw();
            purchaseTable.rows.add(response['dataset']).draw(); // Add new data
        }
      });
    });


  /*$("#getStock").on("click",function (){
      $("#morris-line-chart").html("<div class='text-center text-danger'><h2>Loading........<h2><div>");
      var formdata=$("#stockData").serialize();
      $.ajax({
        data:formdata,
        type:'POST',
        datatype:JSON,
        url:base_url+"report/getStock",
        success:function(response)
        {
          $("#morris-line-chart").html("");
          console.log(response);
           new Morris.Area({
            element: 'morris-line-chart',
            data: response['map'],
            xkey: 'y',
            ykeys: ['a'],
            labels: ['Stock'],
            hideHover: 'auto',
            resize: true,
            lineColors: ['#54cdb4','#1ab394'],
        });

            stockTable.clear().draw();
            stockTable.rows.add(response['dataset']).draw(); // Add new data
        }
      });
    });*/



   $("#getExpCat").on("click",function (){
      $("#line-chart1").html("<div class='text-center text-danger'><h2>Loading........<h2><div>");
      var formdata=$("#expsCatData").serialize();
      $.ajax({
        data:formdata,
        type:'POST',
        datatype:JSON,
        url:base_url+"report/getExpCat",
        success:function(response)
        {
          $("#tabl").html("");
          $("#line-chart1").html("");
          console.log(response);
            var area = new Morris.Area({
            element: 'line-chart1',
            // resize: true,
            data: response['map'],
            xkey: 'y',
            ykeys: ['item1'],
            labels: ['Transactions'],
            lineColors: ['#a0d0e0', '#3c8dbc'],
            hideHover: 'auto'
          });
          oTable.clear().draw();
          oTable.rows.add(response['dataset']).draw(); // Add new data
          // oTable.columns.adjust().draw();
        // oTable.clear();
        // oTable.row.add(response['dataset']);
         // oTable.ajax.reload();
        }
      });
    });
});

