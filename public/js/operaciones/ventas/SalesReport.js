$(window).load(function(){
    
    $('#ERROR').hide();
    
});

jQuery(document).ready(function($)
{
 var table = $("#table_report").dataTable({
    responsive: false,
    pageLength: 10,
    dom: "Brtip",
    bSort: false,
    select: false,

    info: false,
      buttons: [
        {
        extend: "excelHtml5",
        text: "Exportar a Excel",
        title: "Sales",
         
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
select_type: "select2",
select_type_options: { width: "100%" }

},
{column_number : 2,
select_type: "select2",
select_type_options: { width: "100%" }

},
{column_number : 4,
select_type: "select2",
select_type_options: { width: "100%" }

},
{column_number : 5,
select_type: "select2",
select_type_options: { width: "100%" }}
],
{cumulative_filtering: true, 
filter_reset_button_text: false});

    
});


