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
        title: "Sales_Order",
         
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

function closeSo(url,id){
    
  var datos= "url=ges_ventas/CloseSelesOrder/"+id;
  
  r = confirm ('Esta seguro de  procesar el cierre definitivo de la orden "'+id+'" ?');
  
    if(r==true){
  
           $.ajax({
             type: "GET",
             url: url+'index.php',
             data: datos,
             success: function(res){
  
              console.log(res);
  
                  if(res==1){
                     
                     alert('Se ha cerrado con exito la orden No. '+id);
                     location.reload(true);
  
                    }
  
                 }
              });
     }
  }

