// ********************************************************
// * Aciones cuando la pagina ya esta cargada
// ********************************************************
$(window).load(function(){
  

$('#ERROR').hide();

  //lista jobs
  jobs();

});


//Jquery tabla

jQuery(document).ready(function($)
{



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
        text:   "Exportar a Excel",
        title:  "Estado_de_requisiciones",
         
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
    [{column_number : 1,
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
    }],
    {cumulative_filtering: true, 
      filter_reset_button_text: false}
    );

});






// Variables globales
/////////////////////////////////////////////////////////////////////////////////////////////////
URL = document.getElementById('URL').value;
link = URL+"index.php";

var falta = 1;
var total_rep =0;
var lang = get_lang();
LineArray = [];
FaltaArray  = [];
ItemExceeded  = [];
var JOBID = '';

/////////////////////////////////////////////////////////////////////////////////////////////////



/////////////////////////////////////////////////////////////////////////////////////////////////
function jobs(){


/*JOBS*/
 var datos= "url=ges_requisiciones/get_JobList";


    $.ajax({
      type: "GET",
      url: link,
      data: datos,
      success: function(res){

        JOBS = res;


        $('#JOBID').append(JOBS);
                    

    }
});
/*JOBS*/

}
/////////////////////////////////////////////////////////////////////////////////////////////////


/////////////////////////////////////////////////////////////////////////////////////////////////

function set_writable(line_id){

var attr = 'total'+line_id;
var box = 'box'+line_id;

if (document.getElementById(box).checked) {

document.getElementById(attr).removeAttribute('readonly');

}else{

document.getElementById(attr).value = '';
document.getElementById(attr).readOnly = true;

}

}

////////////////////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////////////////////

function check_pay(line_id){

//MSG_ERROR_RELEASE();

var totalid = 'total'+line_id;
var PONO = 'PO'+line_id;
var total_POid = 'totalPO'+line_id;
var total_purid = 'totalPur'+line_id; 

var PO = document.getElementById(PONO).innerHTML;
var totalPO = Number(document.getElementById(total_POid).innerHTML);
var total_pur = Number(document.getElementById(total_purid).innerHTML);
var total_line = document.getElementById(totalid).value;
var PO90 = totalPO * 0.9;

console.log(totalPO+total_line);

              if (total_line >= PO90 && total_line <= totalPO) {

                MSG_CORRECT('La PO# '+PO+' ha excedido el 90% de su monto total. Linea: '+line_id,'0');
                
              }
              if (total_line > totalPO) {
                MSG_ERROR('El monto a pagar no puede exceder el monto de la PO# '+PO+'. Linea: '+line_id,'0');

              }
              if (totalPO-total_pur < total_line) {
                MSG_ERROR('El monto a pagar no puede exceder el monto pendiente de la PO# '+PO+'. Linea: '+line_id,'0');

              }

}

/////////////////////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////////////////////////////////

function get_budget(jobid){


$('#SelectJob').val(jobid);

var datos= "url=ges_requisiciones/get_budget/"+jobid;


    $.ajax({
      type: "GET",
      url: link,
      data: datos,
      success: function(res){

          document.getElementById('budget').value = res;                 

    }
});

}

////////////////////////////////////////////////////////////////////////////////////////////////

function searchReq(){

  $('#ERROR').hide();
  $('#resTable').html('Buscando...');   

  JOBID = $("#JOBID").select2('val');
  dateFrom = $('#dateFrom').val();
  dateTo = $('#dateTo').val();
  
  if( JOBID == '-'){

    if (lang = 'es'){MSG_ERROR('Debe seleccionar el proyecto','1');}
    else {MSG_ERROR('You must select a Job!','1');}
    
    }else{
  
    datos= [];
    datos[0] = '@'+JOBID+'@'+dateFrom+'@'+dateTo;
    console.log(datos);
    
    $.ajax({
      type: "GET",
      url: link,
      data: {url: 'ges_requisiciones/PmntReq', Data : JSON.stringify(datos) },
      success: function(res){

        if(res==''){
          
          if (lang = 'es') {
            MSG_ERROR('No existen valores para la opcion seleccionada','0');
          }else{
            MSG_ERROR('No Project has been selected','0');
          }
          
          $('#resTable').html('');
          
        }else {
          $('#resTable').html(res);  

          $.ajax({
                type: "GET",
                url: link,
                data: {url: 'ges_requisiciones/get_bill_notRelated/'+JOBID},
                success: function(res){
             
                $('#tableFact').html(res);
                $("#table_fact").dataTable();

                          
            }
          });

          $.ajax({
                type: "GET",
                url: link,
                data: {url: 'ges_requisiciones/get_cash_adv/'+JOBID},
                success: function(res){

                $('#tableAdv').html(res); 
                $("#table_cash").dataTable();
                
 
                          
            }
          });

        }
                    
    }
  });


    

  }
}

/////////////////////////////////////////////////////////////////////////////////////////////////
function set_rep(){

$('#ERROR').hide();


var flag = '';
var count= 0;
var arrLen = '';

JOBID = $('#SelectJob').val();


flag = set_items(); //GUARDO ITEM EN ARRAY 

if(flag==1){  //SI HAY ITEMS EN LA LISTA

    if (lang = 'es') {

    var r = confirm('Desea enviar esta requisicion ahora?');
       
    }else{

      var r = confirm('You want to submit this application now?');
    }

if (r == true) { 

       spin_show();

       var link = URL+"index.php";


       //REGITRO DE CABECERA
       function set_header(){

         
         var nota  = document.getElementById('nota').value;  

         var datos= "url=ges_requisiciones/set_rep_header/"+JOBID+"/"+nota; //LINK DEL METODO EN BRIDGE_QUERY

         return   $.ajax({
                     type: "GET",
                     url: link,
                     data: datos,
                     success: function(res){
                                  
                                  Req_NO = res;

                                  console.log(res);

                        }
             });
  }//FIN REGISTRO DE CABECERA

   
 $.when(set_header()).done(function(Req_NO){ //ESPERA QUE TERMINE LA INSERCION DE CABECERA


       // REGISTROS DE ITEMS 
       $.ajax({
        type: "GET",
        url:  link,
        data:  {url: 'ges_requisiciones/set_rep_items/'+Req_NO.trim()+'/'+JOBID , Data : JSON.stringify(LineArray)}, 
        success: function(res){
              
               console.log('REP:'+res);
               
         if(res==1){//TERMINA EL LLAMADO AL METODO set_rep_items SI ESTE DEVUELV UN '1', indica que ya no hay items en el array que procesar.
                 
           send_mail_rep(link,Req_NO);
       
         }

          }
       });       

    });//FIN REGISTROS DE ITEMS

  }

}

if(flag==0){ 

    if (lang = 'es') {

        MSG_ERROR('Debe llenar la solicitud con almenos un item en la lista',0); 
       
    }else{

        MSG_ERROR('You must fill at least one of the fields',0); 
    }


}

//MANEJO DE ERRORES POR FAMPO FALTANTES EN LOS ITEMS
if(flag==2){ 

MSG_ERROR_RELEASE(); //LIMPIO DIV DE ERRORES

  if (FaltaArray.length !=0) {
          FaltaArray.forEach(ListFaltantes);


           function ListFaltantes(item,index){

               column = FIND_COLUMN_NAME(index);

                if (lang = 'es') {

                    MSG_ERROR('No se indico valor en el Item: '+item+" o el monto ingresado es superior al monto de la PO / Campo :" +column, 0); 
                 
                }else{

                    MSG_ERROR('Missing value on row: '+item+" or the input value is higher than PO total amount / column :" +column, 0); 
                }
                  

           }

          FaltaArray.length = ''; //LIMPIO ARRAY DE ERRORES
  }
  if (ItemExceeded.length !=0) {

          ItemExceeded.forEach(ListExceeded);


                 function ListExceeded(item,index){


                      if (lang = 'es') {

                          MSG_ERROR('El Monto ingresado en la linea: '+item+' supera el monto de contrato', 0); 
                       
                      }else{

                          MSG_ERROR('The amount on row: '+item+' exceed the pending for payment amount', 0); 
                      }
                        

                 }

                 ItemExceeded.length ='';
  }

}

if (flag == 3) {

    if (lang = 'es') {

        MSG_ERROR('El monto a pagar es superior al Presupuesto del Proyecto. Por favor verifique su solicitud!.',0); 
       
    }else{

        MSG_ERROR('The requested amount exceed the budget amount. Please verify your request!.',0); 
    }

}


}
/////////////////////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////////////////////
//FUNCION PARA GUARDAR ITEMS EN ARRAY 
function set_items(){

//ARREGLOS DE CONTROL

LineArray.length=''; //limpio el array
FaltaArray.length='';
ItemExceeded.length ='';

//VARIABLES
var flag = ''; 
var theTbl = document.getElementById('table'); //objeto de la tabla que contiene los datos de items
var PO = '';
var total_line ='';
var totalPO = '';
var boxid = '';
var totalid = '';
var PONO = '';
var total_POid = '';
var total_purid ='';
var total_pur ='';
var j = 0;
var budget = document.getElementById('budget').value;

for(var i=1; i<theTbl.rows.length;i++) //BLUCLE PARA LEER LINEA POR LINEA LA TABLA theTbl
{

boxid = 'box'+i;
totalid = 'total'+i;
PONO = 'PO'+i;
total_POid = 'totalPO'+i;
total_purid = 'totalPur'+i;
 cell = '';
console.log(boxid+' '+totalid+' '+PONO+' '+total_POid);

 
  if(document.getElementById(boxid).checked){ //chequeo si la  linea esta seleccionada
   

      PO = Number(document.getElementById(PONO).innerHTML); 
      total_line = document.getElementById(totalid).value;
      totalPO = Number(document.getElementById(total_POid).innerHTML); 
      total_pur = Number(document.getElementById(total_purid).innerHTML);


          if(total_line=='' || PO ==''){
                                    
                FaltaArray[j] = i;

          }

          if (total_line > totalPO || total_line > totalPO-total_pur) {

                ItemExceeded[j] = i;

          }else{


            cell += '@'+PO+'@'+total_line;

            total_rep += total_line;

               }

      
      LineArray[j]=cell; 
      console.log(LineArray);
      j++;
      

}


}//FIN BLUCLE PARA LEER LINEA POR LINEA DE LA TABLA 
console.log(total_rep);

//SETEA RETURN DE LA FUNCION, FLAG 1 Ó 0, SI ES 1 LA TABLA ESTA LLENA SI ES 0 LA TABLA ESTA VACIA y 3 si el monto a pagar es superior al presupuesto.

if (total_rep > budget) {

  flag = 3;

}else{

if(FaltaArray.length == 0 && ItemExceeded.length ==0){

   if(LineArray.length >= 1){ 
     flag = 1; 
    }else{  
     flag = 0; 
    }

}else{
   
   LineArray.length = '';
   cell = '';
   flag = 2; //Alguna linea no tiene descripcion

}
}

return flag;
}



function send_mail_rep(link,Req_NO){

      //ENVIO POR MAIL 
 var datos= "url=ges_requisiciones/rep_mailing/"+Req_NO; //LINK A LA PAGINA DE MAILING
  
console.log('rep_mailing:'+Req_NO);

 $.ajax({
   type: "GET",
   url: link,
   data: datos,
   success: function(res){
                       
     if(res==0){

          if (lang = 'es') {

              MSG_ERROR('NO SE HA PODIDO ENVIAR LA NOTIFICACION DE ORDEN DE COMPRA.', 0); 
       
          }else{

              MSG_ERROR('Sorry! Payment request notitication could not be send due system error.', 0); 
          }

      
      msg(link,Req_NO);
      
     }else{  
     
      msg(link,Req_NO);
     }

   }
 }); 
 //FIN ENVIO POR MAIL 

}         


//FUNCION PARA SOLICITAR IMPRESION DEL REPORTE
function msg(link,Req_NO){

spin_hide();

          if (lang = 'es') {

              MSG_CORRECT('La orden se ha enviado con exito!', 0); 
       
          }else{

              MSG_CORRECT('Your payment request has been processed successfully!', 0); 
          }
  
          if (lang = 'es') {

               var R = confirm('Desea imprimir la orden de pago?');
       
          }else{

               var R = confirm('Do you want to print your payment request?');
          }



 if(R==true){
        
        count = 1;
        LineArray.length='';
        window.open(link+'?url=ges_requisiciones/rep_print/'+Req_NO,'_self');
                
   }else{

     count = 1;
     LineArray.length='';
           location.reload();

 }



}

function get_PurInfo(id){
  
URL = document.getElementById('URL').value;
  
  var datos= "url=ges_requisiciones/get_Pur/"+id;  
  var link = URL+"index.php";
  
  
    $.ajax({
        type: "GET",
        url: link,
        data: datos,
        success: function(res){
        
          $('#table2').html(res);

          if(res !=''){

            $('html, body').animate({
              scrollTop: $("#table2").offset().top
            }, 2000);

          }
    
    
        }
     });
    
    
  
  
  }

////////////////////////////////////////////////////////////////////////////////////////////////