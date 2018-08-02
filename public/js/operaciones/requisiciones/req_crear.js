// ********************************************************
// * Aciones cuando la pagina ya esta cargada
// ********************************************************
$(window).load(function(){
  

$('#ERROR').hide();

  //lista jobs
  jobs();


var table = $("#table_req_tb").dataTable({
     bSort: false,
     responsive: false,
     searching: false,
     paging:    false,
     info:      false,
     collapsed: false

});


  
});





// Variables globales
URL = document.getElementById('URL').value;
link = URL+"index.php";

chk = '';
cantLineas =  document.getElementById('FAC_NO_LINES').value; //Setea la cantidad de lineas disponibles en la tabla de solicitud de items


JOBS = '';
PHASES = '';
COST = '';
//Variables globales

//datatables
/////////////////////////////////////////////////////////////////



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

function phase(){

 jobID = $("#JOBID").select2("val");


/*PHASES*/
var datos= "url=ges_requisiciones/get_phaseList/"+jobID;

   $.ajax({
       type: "GET",
       url: link,
       data: datos,
       success: function(res){

       PHASES = res;
      
                           
       if(res){
         
         cost();
       
       }

      }
  });
/*PHASES*/

}
/////////////////////////////////////////////////////////////////////////////////////////////////

function cost(){

//  listID = '#COST'+i;
 
 
 /*cost*/
  var datos= "url=ges_requisiciones/get_costList/";
 
     $.ajax({
         type: "GET",
         url: link,
         data: datos,
         success: function(res){
 
         COST = res;

         if(res){
           
           init(1);
         
         }                   
          
        }
    });
 /*cost*/
 
 }
 
 /////////////////////////////////////////////////////////////////////////////////////////////////
 
function init(chk)

{

var listitem = '';
var i = 1;
var datos= "url=ges_requisiciones/get_ProductsCode/";
var reglon = '';


/*
$.ajax({
     type: "GET",
     url: link,
     data: datos,
     success: function(res){

     
     listitem = res;*/

$('#table_req').html(''); //limpio la tabla 

function n(n){

   return n > 9 ? "" + n: "0" + n;

}

while(i <= cantLineas){

      if(chk==1){ 

       reglon = '<td  width="10%" >'+n(i)+'</td>';  

     }else{

/*			reglon = '<td width="10%" >'+
            '<div class="select-editable">'+
               '<select id="sel'+i+'" >'+
                   '<option value=""></option>'
                    +listitem+
               '</select>'+
               '<input id="inp'+i+'" type="text" name="format" value="" />'+
           '</div>'+
           '</td>';*/

      }     

     var line_table_req = '<tr>'+reglon+
     '<td width="30%" class="rowtable_req"      id="DESC'+i+'" onkeyup="checkTblChar(this.id); checkLong(this.id,40);  " contenteditable></td>'+
     '<td width="15%" class="rowtable_req numb" id="QTY'+i+'"  onkeyup="check_num(this.id); checkLong(this.id,18);" contenteditable></td>'+
     '<td width="15%" class="rowtable_req"      id="UNI'+i+'"  onkeyup="checkLong(this.id,4);" contenteditable></td>'+
     '<td width="15%" class="rowtable_req"       ><select class="selectItems" id="PHS'+i+'" ><option  value="-" selected>-</option>'+PHASES+'</select></td>'+
     '<td width="15%" class="rowtable_req"       ><select class="selectItems" id="COST'+i+'"  ><option  value="-" selected>-</option>'+COST+'</select></td>'+
     '</tr>' ;

      i++
      $('#table_req').append(line_table_req); //limpio la tabla 
     }
     set_selectItemStyle();
/*      }
    });*/


}









/////////////////////////////////////////////////////////////////////////////////////////////////


var falta = 1;
LineArray = [];
FaltaArray  = [];
HeaderInfo = [];  
URL = document.getElementById('URL').value;



function set_job(jobid){

document.getElementById('jobID_db').value = jobid;


}



CHK_VALIDATION = false;

function validacion(){

$('#ERROR').hide();

MSG_ERROR_RELEASE();

   //VALIDAR JOB
 JOBID = document.getElementById('JOBID').value;

 if (JOBID == '-'){

  MSG_ERROR('Es obligatorio indicar el proyecto de referencia',1);
  
  CHK_VALIDATION = true;
 }

  //VALIDAR NOTA
 NOTA =  $("#nota").val();
 console.log('nota '+NOTA);

 if (!NOTA){

   MSG_ERROR('Es obligatorio completar el campo de Nota',1);
  
  CHK_VALIDATION = true;
 }


}

function send_req_order(){


var flag = '';
var count= 0;
var arrLen = '';

validacion();
if(CHK_VALIDATION == true){ CHK_VALIDATION = false;  return;  }


flag = set_items(); //GUARDO ITEM EN ARRAY 

if(flag==1){  //SI HAY ITEMS EN LA LISTA

var r = confirm('Desea enviar esta requisicion ahora?');
   
if (r == true) { 

       spin_show();

       var link = URL+"index.php";


       //REGITRO DE CABECERA
       function set_header(){

         
         var JOBID = document.getElementById('JOBID').value;
         var nota  = document.getElementById('nota').value;  

            //INI REGISTRO DE CABECERA
          HeaderInfo[0] =  JOBID+'@'+nota;

         var data= JSON.stringify(HeaderInfo);
         var url = "ges_requisiciones/set_req_header/";

         return   $.ajax({
                     type: "GET",
                     url: link,
                     data: {url:url,Data:data},
                     success: function(res){

                              console.log(res);
                           

                              if(isJson(res)){ //si es un objeto, que supone es JSON
                             
                                error = JSON.parse(res);
                                MSG_ERROR(error.E,0);
                                spin_hide();

                              }else{

                                  Req_NO = res;
                                
                                  $('#req_no_jobid').html(res);

                              }
                 
                        }
             });
  }//FIN REGISTRO DE CABECERA

   
 $.when(set_header()).done(function(Req_NO){ //ESPERA QUE TERMINE LA INSERCION DE CABECERA

       // REGISTROS DE ITEMS 
       $.ajax({
        type: "GET",
        url:  link,
        data:  {url: 'ges_requisiciones/set_req_items/'+Req_NO.trim() , Data : JSON.stringify(LineArray)}, 
        success: function(res){
              
            console.log('RES:'+res);

            if(isJson(res)){ //si es un objeto, que supone es JSON
            
                 error = JSON.parse(res);
                 spin_hide();
                 MSG_ERROR(error.E,0);
                 

            }else{
                      
                if(res==1){//TERMINA EL LLAMADO AL METODO set_req_items SI ESTE DEVUELV UN '1', indica que ya no hay items en el array que procesar.
                        
                  send_mail(link,Req_NO);
              
                }
            }
          }
       });       

    });//FIN REGISTROS DE ITEMS

  }

}

if(flag==0){ 

MSG_ERROR('Debe llenar la solicitud con almenos un item en la lista',0); 
}

//MANEJO DE ERRORES POR FAMPO FALTANTES EN LOS ITEMS
if(flag==2){ 

MSG_ERROR_RELEASE(); //LIMPIO DIV DE ERRORES

FaltaArray.forEach(ListFaltantes);


 function ListFaltantes(item,index){

     column = FIND_COLUMN_NAME(index);
     
     MSG_ERROR('No se indico valor en el Item: '+item+" / Campo :" +column, 1); 
     

 }

FaltaArray.length = ''; //LIMPIO ARRAY DE ERRORES

}

}
/////////////////////////////////////////////////////////////////////////////////////




function FIND_COLUMN_NAME(item){

 switch (item){

   case 1: val ='Descripcion'; break;
   case 2: val ='Cantidad'; break;
   case 3: val ='Unidad'; break;
   case 4: val ='Fase'; break;

    
 }

return val;
             
}
 
function send_mail(link,Req_NO){

      //ENVIO POR MAIL 
 var datos= "url=ges_requisiciones/req_mailing/"+Req_NO; //LINK A LA PAGINA DE MAILING
   

 $.ajax({
   type: "GET",
   url: link,
   data: datos,
   success: function(res){
                       
     if(res==0){

      alert('NO SE HA PODIDO ENVIAR LA NOTIFICACION DE ORDEN DE COMPRA.');
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
  alert("La orden se ha enviado con exito");

 var R = confirm('Desea imprimir la orden de venta?');

 if(R==true){
        
        count = 1;
        LineArray.length='';
        window.open(link+'?url=ges_requisiciones/req_print/'+Req_NO,'_self');
                
   }else{

     count = 1;
     LineArray.length='';
           location.reload();

 }



}



//FUNCION PARA GUARDAR ITEMS EN ARRAY 
function set_items(){

LineArray.length=''; //limpio el array
FaltaArray.length='';

var flag = ''; 
var theTbl = document.getElementById('table_req'); //objeto de la tabla que contiene los datos de items
var line = '';

for(var i=0; i<cantLineas ;i++) //BLUCLE PARA LEER LINEA POR LINEA LA TABLA theTbl
{
 cell = '';
 y='';

   for(var j=0;j<theTbl.rows[i].cells.length; j++) //BLUCLE PARA LEER CELDA POR CELDA DE CADA LINEA
       {

             y=i+1;
           var selid = "sel"+y;
           var phsid = "PHS"+y;
           var costid = "COST"+y;

               if(theTbl.rows[i].cells[1].innerHTML!=''){ //valido que la columna 1 (DESCRIPCION) sea diferente a vacio. 

                   //leer columnas de jobs
                 switch (j){

             
                      case 5:

                          cell += 
                          
                          '@'+theTbl.rows[i].cells[0].innerHTML+
                          '@'+theTbl.rows[i].cells[1].innerHTML+
                          '@'+theTbl.rows[i].cells[2].innerHTML+
                          '@'+theTbl.rows[i].cells[3].innerHTML+                          
                          '@'+document.getElementById('JOBID').value+
                          '@'+document.getElementById('JOBID').options[document.getElementById('JOBID').selectedIndex].text+
                          '@'+document.getElementById(phsid).value+
                          '@'+document.getElementById(phsid).options[document.getElementById(phsid).selectedIndex].text+
                          '@'+document.getElementById(costid).value+
                          '@'+document.getElementById(costid).options[document.getElementById(costid).selectedIndex].text;
                          
                          console.log(cell);
                          //SI LA CELDA NO CONTIENE VALOR 
                          /* if(document.getElementById(phsid).value == '-'){
                              
                              FaltaArray[j] = i+1;
                          }
                          */
                            break;            


                      default: 

                              //SI LA CELDA NO CONTIENE VALOR 
                              if(j!=4 || j!=5 ){

                                val= theTbl.rows[i].cells[j].innerHTML;

                                if(val==''){
                                    
                                   FaltaArray[j] = i+1 ;
                                }

                              }

                            
                            
                            break;
                           }
                    //fin leer columnas de jobs
                 
               }
           

       }//FIN BLUCLE PARA LEER CELDA POR CELDA DE CADA LINEA

       

       if (theTbl.rows[i].cells[1].innerHTML!=''){

      
          LineArray[i]=cell; 
          console.log(LineArray);

         
        }



}//FIN BLUCLE PARA LEER LINEA POR LINEA DE LA TABLA 


//SETEA RETURN DE LA FUNCION, FLAG 1 Ó 0, SI ES 1 LA TABLA ESTA LLENA SI ES 0 LA TABLA ESTA VACIA.
if(FaltaArray.length == 0){

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


return flag;
}

