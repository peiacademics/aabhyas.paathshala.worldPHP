
  function attendance(id,date) {
    $.ajax({
        type:'POST',
        dataType:'json',
        url: base_url+'team/attendance/'+id,
        success:function(response)
        {
            // $('#calendar').fullCalendar('destroy');
            // $('#calendar').fullCalendar('rerenderEvents');
            $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                // right: 'month,agendaWeek,agendaDay'
                right:''
            },
            editable: true,
            droppable: true,
            drop: function() {
                if ($('#drop-remove').is(':checked')) {
                    $(this).remove();
                }
            },
            events:response
        });

            $('.fc-button').click(function() {
                var moment = $('#calendar').fullCalendar('getDate');
                getAtData(id,moment.format('YYYY-MM'));
            });
        }
    });
  }


  function getAtData(id,date) {
    $(".dataTable1").html('');
    $(".dataTable1").append("<span class='fa fa-spinner fa-spin'></span>");
      $.ajax({
        type:'POST',
        data:{'id':id,'date':date},
        dataType:'json',
        url: base_url+'team/getAttenceData',
        success:function(response)
        {
          $.each(response, function(key,value){
            $("#"+key).text(value);
          });
          if (response.percent===100) {
            $(".progress-bar").removeClass('progress-bar-danger');
            $(".progress-bar").attr('style','width:'+response.percent+'%');
          }
          else
          {
            $(".progress-bar").addClass('progress-bar-danger');
            $(".progress-bar").attr('style','width:'+response.percent+'%');
          }
          var x=1;
          $(".dataTable1").html('');
          $.each(response.dataTable, function(k,v){
            $(".dataTable1").append("<tr><td>"+x+"</td><td>"+v.date+"</td><td>"+v.Status+"</td><td>"+v.isLate+"</td></tr>");
            x++;
          });
   // progress-bar-danger
        }
      });
  }