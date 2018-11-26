jQuery(document).ready(function($)
{

$("#ERROR").hide();

var table = $("#table").dataTable({
    
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
        title: "Estado_de_requisiciones",
         
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

table.yadcf(
    [{column_number : 0,
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
    {column_number : 3,
    select_type: "select2",
    select_type_options: { width: "100%" }

    },
    {column_number : 4,
    select_type: "select2",
    select_type_options: { width: "100%" }

    }],
    {cumulative_filtering: true, 
    filter_reset_button_text: false}
    );
});


jQuery(document).ready(function($)
{

$("#ERROR").hide();

var table = $("#table_info").dataTable({
    
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
        title: "Estado_de_requisiciones",
         
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

table.yadcf(
    [{column_number : 0,
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
    {column_number : 3,
    select_type: "select2",
    select_type_options: { width: "100%" }

    },
    {column_number : 4,
    select_type: "select2",
    select_type_options: { width: "100%" }

    }],
    {cumulative_filtering: true, 
    filter_reset_button_text: false}
    );
});
// Variables globales
/////////////////////////////////////////////////////////////////////////////////////////////////
var lang = get_lang();


// Funciones
/////////////////////////////////////////////////////////////////////////////////////////////////
function show_req(URL,id){  


  $("#info").html('Buscando información...');

  var datos= "url=ges_requisiciones/get_req_info/"+id;

    $.ajax({
      type: "GET",
      url: URL+'index.php',
      data: datos,
      success: function(res){

        //$("historial").hide();

        $("#info").html(res);

              }
        });

}

function close_req(id){ 
  
  var reason = document.getElementById('req_reason_close').value;
  var URL    = document.getElementById('URL').value;
  var datos  = "url=ges_requisiciones/set_reason_close/"+id+"/"+reason;
  
  document.getElementById('info').value = 'Procesando cierre...';
  
  r = confirm ('Esta seguro de  procesar el cierre definitivo de la requisicion "'+id+'" ?');
  
  if(r==true){
  
     $.ajax({
           type: "GET",
           url: URL+'index.php',
           data: datos,
           success: function(res){
  
             alert('Se ha cerrado con exito la requisicion No. '+id);
  
             show_req(URL,id);
               
                   }
              });
  
    }
}

function show_rep(URL,id){  

  if (lang = 'es'){$("#info").html('Buscando información...');}
  else{$("#info").html('Searching...')}

  var datos= "url=ges_requisiciones/get_rep_info/"+id;

    $.ajax({
      type: "GET",
      url: URL+'index.php',
      data: datos,
      success: function(res){

        $("#info").html(res);

              }
        });

}

function close_rep(id){ 
  
  var reason = document.getElementById('req_reason_close').value;
  var URL    = document.getElementById('URL').value;
  var datos  = "url=ges_requisiciones/set_rep_close/"+id+"/"+reason;
  
  document.getElementById('info').value = 'Procesando cierre...';
  
  if (lang = 'es'){r = confirm ('Esta seguro de  procesar el cierre definitivo de la requisicion?: "'+id+'" ?');}
  else{r = confirm ('Are you sure to cancel this request?: "'+id+'" ?');}
  
  
  if(r==true){
  
     $.ajax({
           type: "GET",
           url: URL+'index.php',
           data: datos,
           success: function(res){
  
            if (lang = 'es'){MSG_CORRECT('Se ha cerrado con exito la requisicion No. '+id,'0');}
            else{MSG_CORRECT('Payment Request #: '+id+' has been successfully cancel','0');}
  
             show_rep(URL,id);
               
                   }
              });
  
    }
}


function get_OC(id){
  
    URL = document.getElementById('URL').value;
  
    var datos= "url=ges_reportes/get_PO_details/"+id;  
    var link = URL+"index.php";
  
    $.ajax({
        type: "GET",
        url: link,
        data: datos,
        success: function(res){
        
         $('#info').html(res);
  
         // alert(res);
  
          }
     });
     $('html, body').animate({
      scrollTop: $("#info").offset().top
      }, 2000);

    }