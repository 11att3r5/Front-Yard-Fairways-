
               $(document).ready(function() {

                  var cb = function(start, end, label) {
                    //console.log(start.toISOString(), end.toISOString(), label);
                    //$('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                    //alert("Callback has fired: [" + start.format('MMMM D, YYYY') + " to " + end.format('MMMM D, YYYY') + ", label = " + label + "]");
                  }

                  var optionSet1 = {
                    //startDate: moment().subtract('days', 29),
                    //endDate: moment(),
                    minDate: '01/01/2010',
                    maxDate: '12/31/2015',
                    //dateLimit: { days: 60 },
                    showDropdowns: true,
                    showWeekNumbers: false,
                    timePicker: false,
                    timePickerIncrement: 1,
                    timePicker12Hour: true,
                    ranges: {
                       'Today': [moment(), moment()],
                       'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
                       'Last 7 Days': [moment().subtract('days', 6), moment()],
                       'Last 30 Days': [moment().subtract('days', 29), moment()],
                       'This Month': [moment().startOf('month'), moment().endOf('month')],
                       'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
                    },
                    opens: 'left',
                    buttonClasses: ['btn btn-default'],
                    applyClass: 'btn-small btn-default',
                    cancelClass: 'btn-small',
                    format: 'MM/DD/YYYY',
                    separator: ' - ',
                    locale: {
                        applyLabel: 'Submit',
                        cancelLabel: 'Clear',
                        fromLabel: 'From',
                        toLabel: 'To',
                        customRangeLabel: 'Custom',
                        daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr','Sa'],
                        monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                        firstDay: 1
                    }
                  };

                  $('#reportrange').daterangepicker(optionSet1, cb);
                  
                  //$('#reportrange').on('show.daterangepicker', function() { console.log("show event fired"); });
                  //$('#reportrange').on('hide.daterangepicker', function() { console.log("hide event fired"); });
                  
                  $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
                    $('#submit').submit(); 
                    /*console.log("apply event fired, start/end dates are " 
                      + picker.startDate.format('MMMM D, YYYY') 
                      + " to " 
                      + picker.endDate.format('MMMM D, YYYY')
                    );*/ 
                  });
                  
                  //$('#reportrange').on('cancel.daterangepicker', function(ev, picker) { console.log("cancel event fired"); });

               });
               