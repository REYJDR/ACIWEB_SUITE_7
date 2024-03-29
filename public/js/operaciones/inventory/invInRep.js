$(window).load(function(){
    
    $('#ERROR').hide();
    
});

jQuery(document).ready(function($)
{

  var table = $("#table_report").dataTable({
    
    "footerCallback": function ( row, data, start, end, display ) {
      var api = this.api(), data;

      // Remove the formatting to get integer data for summation
      var intVal = function ( i ) {
          return typeof i === 'string' ?
              i.replace(/[\$,]/g, '')*1 :
              typeof i === 'number' ?
                  i : 0;
      };

      // Total over all pages
      total = api
          .column( 5 )
          .data()
          .reduce( function (a, b) {
              return intVal(a) + intVal(b);
          }, 0 );

      // Total over this page
      pageTotal = api
          .column( 5, { page: 'current'} )
          .data()
          .reduce( function (a, b) {
              return intVal(a) + intVal(b);
          }, 0 );

      // Update footer
      $( api.column( 5 ).footer() ).html(
        pageTotal.toLocaleString() +' ('+ total.toLocaleString() +' total)'
      );
    },
    buttons: [ {
              extend: "excelHtml5",
              text: "Exportar a Excel",
              title: "movimientos_mercancia",
               
              exportOptions: {
                    columns: ":visible",
                     format: {
                        header: function ( data ) {
                          var StrPos = data.indexOf("<div");
                            if (StrPos<=0){
                              
                              var ExpDataHeader = data;
                            }else{
                           
                              var ExpDataHeader = data.substr(0, StrPos); 
                            }
                           
                          return ExpDataHeader;
                          }
                        }
                     
                      }
                    
              }]


  });

table.yadcf([
{column_number : 0,
column_data_type: "html",
html_data_type: "text" ,
select_type: "select2",
select_type_options: { width: "100%" }

},
{column_number : 1,
column_data_type: "html",
html_data_type: "text" ,
select_type: "select2",
select_type_options: { width: "100%" }

},
{column_number : 2,
select_type: "select2",
select_type_options: { width: "100%" }

},
{column_number : 3,
select_type: "select2",
select_type_options: { width: "100%" }

},
{column_number : 4,
    select_type: "select2",
    select_type_options: { width: "100%" }
    
},
{column_number : 5,
select_type: "select2",
select_type_options: { width: "100%" }
},

{column_number : 6,
select_type: "select2",
select_type_options: { width: "100%" }
},

{column_number : 7,
select_type: "select2",
select_type_options: { width: "100%" }
},
{column_number : 8,
    select_type: "select2",
    select_type_options: { width: "100%" }
    },
{column_number : 9,
    select_type: "select2",
    select_type_options: { width: "100%" }
    },
{column_number : 19,
      select_type: "select2",
      select_type_options: { width: "100%" }
      }
],
{cumulative_filtering: true, 
filter_reset_button_text: false});

    
});


