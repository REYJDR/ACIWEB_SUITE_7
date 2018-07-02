//variables globales -->
var id_desc_field = 'desc';
var id_unit_field = 'unit';
var id_qty_field = 'qty';
var id_total_field = 'total';
var taxable_val = '';
var stock_val = '';
var id_price_field = 'unitprice';

//variable globales





function logout(URL){

    var datos= "url=login/login_out";

    $.ajax({
             type: "GET",
             url: URL+'index.php',
             data: datos,
             success: function(res){
    
               location.reload();
    
                     }
                });


}

function set_listprice(ID){

  URL = document.getElementById('URL').value;
  
  var datos= "url=bridge_query/get_Cust_info/"+ID;
  
  var link= URL+"index.php";
  
    $.ajax({
  
        type: "GET",
        url: link,
        data: datos,
        success: function(res){
          res = JSON.parse(res);
          document.getElementById('listID').value = res.Custom_field4;
          }
  
     });
  
  
  var datos= "url=ges_ventas/GetPayTerm/"+ID;
  
      $.ajax({
        type: "GET",
        url: link,
        data: datos,
        success: function(res){
  
          document.getElementById('termino_pago').value = res;
          }
  
     });
  
   // init(2); 
   
   addItemList();
  
}

function addItemList(){

  URL = document.getElementById('URL').value;
  link = URL+"index.php";


  var datos= "url=bridge_query/get_ProductsCode/";


  $.ajax({
    
          type: "GET",
          url: link,
          data: datos,
          success: function(res){
    
            
            
            var itemline =  '<select class="selectItems col-lg-12" id="selItem" onchange="SetDesc(this.value)" >'+
            
                                '<option  val="0" selected disabled>Seleccionar item</option>'
            
                                 +res+
            
                            '</select>';

            $('#listSelect').html(itemline); //limpio la tabla 
          }
        });


}


function SetDesc(itemId){

var listID =  document.getElementById('listID').value;
var datos= "url=bridge_query/get_ProductsInfo/"+itemId;

stock_val='';


$.ajax({

      type: "GET",
      url: link,
      data: datos,
      success: function(res){

       json = JSON.parse(res);
       document.getElementById(id_desc_field).value  = json.Description;
       document.getElementById(id_unit_field).value  = json.UnitMeasure;       
       stock_val = json.QtyOnHand;


       if(json.TaxType == 1){

        taxable_val =  'SI';

       }else{

        taxable_val =  'NO';

       }

     }

 });


setTimeout(function(){

    if(listID!=''){

     findprice(itemId, listID, id_price_field);

    }else{

     document.getElementById(id_price_field).value  = '';

    }

    if(itemId==''){

         document.getElementById(id_qty_field).value  = '';
         unit_val  = '';
         document.getElementById(id_desc_field).value  = '';
         taxable_val = '';
         document.getElementById(id_price_field).value  = '';
         stock_val = '';
  }

},500);

}

function findprice(itemId, listID, id_price_field){

  var datos= "url=bridge_query/get_ProductsPrice/"+itemId+"/"+listID;
  
  
  $.ajax({
  
        type: "GET",
        url: link,
        data: datos,
        success: function(res){
        console.log(res);
  
        if(res.trim()!=''){
  
         document.getElementById( id_price_field ).value  = parseFloat(res).toFixed(4); ;
  
        }else{
  
         console.log('yes');
         document.getElementById(id_price_field).value  = '';
         document.getElementById(id_price_field).setAttribute("contenteditable","");
  
        }
  
       }
  
  });
  
}

function addItem(){


  URL = document.getElementById('URL').value;

  IdItem = document.getElementById('selItem').value ;
  qty_field = document.getElementById(id_qty_field).value ;    
  price_field = document.getElementById(id_price_field).value * qty_field;
  desc_field = document.getElementById(id_desc_field).value;
  unit_val = document.getElementById(id_unit_field).value;

  nota= document.getElementById('nota').value ;
  chico = document.getElementById('chico').value ;
  grande = document.getElementById('grande').value ;


  if(qty_field > 0){


   itemLine =    '<tr class="table_row" >'+
                  '<td class="table_section_small" >'+IdItem+'</td>'+
                  '<td class="table_section">'+desc_field+'</td>'+
                  '<td class="table_section">'+nota+'</td>'+
                  '<td class="table_section_qty" >'+qty_field+'</td>'+
                  '<td class="table_section_qty" >'+price_field+'</td>'+
                  '<td class="table_section_qty dplynone" >'+chico+'</td>'+
                  '<td class="table_section_qty dplynone" >'+grande+'</td>'+
                  '<td class="table_section_qty dplynone" >'+unit_val+'</td>'+
                  '<td class="table_section_qty dplynone" >'+taxable_val+'</td>'+
                  '<td class="table_section_qty dplynone" >'+stock_val+'</td>'+
                  '</tr>';


  $('#ItemAdded').append(itemLine);
  
  document.getElementById(id_price_field).value  = '';
  document.getElementById(id_qty_field).value  = '';     
  document.getElementById(id_unit_field ).value = '';
  document.getElementById(id_desc_field).value  = '';
  $('#selItem').val(0);
  document.getElementById('nota').value  = '';
  document.getElementById('chico').value  = '';
  document.getElementById('grande').value  = '';
  
  sumar_total();
  alert('Item '+IdItem+' agregado');


  }else{

    alert('La cantidad debe ser mayor a 0');
    return;
  }
  
}

function sumar_total(){
  
  var theTbl = document.getElementById('ItemAdded'); //objeto de la tabla que contiene los datos de items
  var l = '';  
  var total = [];
  var itbms = [];
  
  subtotal_field = document.getElementById('subtotal');
  tax_field =      document.getElementById('tax');
  tax_value =      document.getElementById('saletaxid').value;
  total_field =    document.getElementById('total');
  
  for(var i=1; i<theTbl.rows.length ;i++) //BLUCLE PARA LEER LINEA POR LINEA LA TABLA theTbl
  
  {
  
    l = 1 + l; //contador de registros
  

    ITEM_ID = '';
  
      for(var j=0;j<theTbl.rows[i].cells.length; j++) //BLUCLE PARA LEER CELDA POR CELDA DE CADA LINEA
  
          {       
  
              switch (j){
  
                     case 4:

                     taxableID = theTbl.rows[i].cells[8].innerHTML;

                      if( taxableID =='SI'){
  
                      itbms_sum = Number(theTbl.rows[i].cells[j].innerHTML) * Number(tax_value);
                      itbms.push(itbms_sum);
  
                      }
  
                      total.push(theTbl.rows[i].cells[j].innerHTML);
  
                      break;
  
              }
  
             }//FIN BLUCLE PARA LEER CELDA POR CELDA DE CADA LINEA
  
  }//FIN BLUCLE PARA LEER LINEA POR LINEA DE LA TABLA
  
  var subtotal  = 0;
  var TAX  = 0;
  
  for(var i=0; i<total.length; i++){
  
      subtotal  += Number(total[i]);
  
  }
  
  for(var i=0; i<itbms.length; i++){
  
      TAX    += Number(itbms[i]);
  
  }

      TOTAL = subtotal + TAX;
  
    subtotal_field.value = parseFloat(subtotal).toFixed(2);
    tax_field.value      = parseFloat(TAX).toFixed(2);
    total_field.value   =  parseFloat(TOTAL).toFixed(2);
  
  }
  

  function Filtrar(){

    $('#SOtable').html();
    $('#SOtable').html('Consultando...');

    URL = document.getElementById('URL').value;

    var date1 =  $("input[name=FechaI]").val();
    var date2 = $("input[name=FechaF]").val();
    
    var datos= "url=ges_reportes/get_mob_report/"+date1+"/"+date2;
    
    $('#SOtable').html('Consultando...');

    var link= URL+"index.php";

        $.ajax({
            type: "GET",
            url: link,
            data: datos,
            success: function(res){
            
             $('#SOtable').html(res);

              }
         });


  }


///////////////////////////////////////////////////////////////
//ENVIO DE PEDIDOS
//////////////////////////////////////////////////////////////

//INI VALIABLES GLOBALES
CHK_VALIDATION = false;
vendorID = '';
falta = 0;
LineArray = [];
FaltaArray = [];
//END VALIABLES GLOBALES

function validacion(){

  CUSTOMER = document.getElementById('customer').value;
  if (CUSTOMER == ''){
   MSG_ERROR('Se debe seleccionar un cliente',0);
   CHK_VALIDATION = true;
  }

}


function send(){


//LIMPIO ERRORES
MSG_ERROR_RELEASE();
$('#ERROR').hide();
/////////////////////////////

//variables internas
var flag = '';
var count= 0;
var arrLen = '';
////////////////////////////


//////LIMPIO ARRAYS
LineArray = [];
FaltaArray = [];
//////////////////////////

//////////////////////////////
validacion();
if(CHK_VALIDATION == true){ CHK_VALIDATION = false;  return;  }
/////////////////////////////

//AGRUPO LAS LINEAS DE ITEMS EN ARRAY
flag = set_items();
/////////////////////////////////////////////////////////////////////////////////////


//SI NO HAY ITEMS EN LA LISTA
if(flag==0){ 
  MSG_ERROR('No se han indicado registros para envio'); 
  return;
}
/////////////////////////////////////////////////////////////////////////////////////


//SI HAY ITEMS EN LA LISTA
if(flag==1){  

var r = confirm('Desea procesar la orden?');

    if (r == true) { 

    var CustomerID= $("#customer").val();
    var termino_pago = document.getElementById('termino_pago').value;
    var tipo_licitacion = '';
    var observaciones = document.getElementById('observaciones').value;
    var entrega = '';
    var user=document.getElementById('active_user_id').value;
    var nopo='';
    var fecha_entrega=document.getElementById('fecha_entrega').value;
    var Subtotal=$("#subtotal").val();
    var total=   $("#total").val();
    var Ordertax =$("#tax").val();
    var TaxID=$("#taxid option:selected").html();  //ultimo cambio
    var LugDesp = document.getElementById('lugar_despacho').value;
    //REGITRO DE CABECERA

    function set_header(){

    //INI REGISTRO DE CABECERA

    //METODO EN BRIDGE_QUERY
    var datos= "url=bridge_query/set_sales_order_header/"+CustomerID+
                                                      '/'+Subtotal+
                                                      '/'+TaxID+
                                                      '/'+total+
                                                      '//'+nopo+
                                                      '/'+termino_pago+
                                                      '/'+tipo_licitacion+
                                                      '/'+observaciones+
                                                      '/'+entrega+
                                                      '/'+Ordertax+
                                                      '/'+fecha_entrega+
                                                      '/'+LugDesp+
                                                      '/';

      return  $.ajax({
            type: "GET",
            url: link,
            data: datos,
            success: function(res){
            console.log(res);
            OS_NO = res;
        }

      });

     }//FIN REGISTRO DE CABECERA

    $.when(set_header()).done(function(OS_NO){ //ESPERA QUE TERMINE LA INSERCION DE CABECERA

      //REGISTROS DE ITEMS 
        $.ajax({
         type: "GET",
         url:  link,
         data:  {url: 'bridge_query/set_sales_order_detail_new/'+OS_NO , Data : JSON.stringify(LineArray)}, 
         success: function(res){
         
              if(res==1){//TERMINA EL LLAMADO AL METODO set_req_items SI ESTE DEVUELV UN '1', indica que ya no hay items en el array que procesar.

                checkSOIns(link,OS_NO);
               
              }
          }
        });
        return false; 
      //FIN REGISTROS DE ITEMS     

     });

  }
}

/////////////////////////////////////////////////////////////////////////////////////
//MANEJO DE ERRORES POR cAMPO FALTANTES EN LOS ITEMS
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


/////////////////////////////////////////////////////////////////////////////////////
//FUNCION PARA GUARDAR ITEMS EN ARRAY 

function set_items(){
  
  LineArray.length=''; //limpio el array
  
  var flag = ''; 
  var theTbl = document.getElementById('ItemAdded'); //objeto de la tabla que contiene los datos de items
  var line = '';
  var cantLineas = theTbl.rows.length ;
  
  var i=1;
  
  //BLUCLE PARA LEER LINEA POR LINEA LA TABLA 
  
 if(cantLineas > 1){

  console.log(cantLineas);

  while (i <= cantLineas-1){
  
  //for(var i=1; i > cantLineas; i++) {
  
    cell = '';
  
    //i=i+1;
  
    for(var j=0;j<theTbl.rows[i].cells.length; j++) //BLUCLE PARA LEER CELDA POR CELDA DE CADA LINEA
  
          {
  
          var itemId = theTbl.rows[i].cells[0].innerHTML;
          var unitid = 'unit'+i;
  
          if(theTbl.rows[i].cells[0].innerHTML){
  
                switch (j){
  
                         case 9:


                              Id          = itemId ;
                              desc        = theTbl.rows[i].cells[1].innerHTML;
                              nota        = theTbl.rows[i].cells[2].innerHTML;
                              UnitMeasure = theTbl.rows[i].cells[7].innerHTML;;
  
                              qty       = theTbl.rows[i].cells[3].innerHTML;
                              UnitPrice = Number(theTbl.rows[i].cells[4].innerHTML) / Number(theTbl.rows[i].cells[3].innerHTML);
                              total     = theTbl.rows[i].cells[7].innerHTML;
  
                              chic  = theTbl.rows[i].cells[5].innerHTML;
                              gran  = theTbl.rows[i].cells[6].innerHTML;
  
                              cell += desc+'@'+nota+'@'+UnitMeasure+'@'+Id+'@'+UnitPrice+'@'+qty+'@'+total+'@'+chic+'@'+gran;//agrego el registo de las demas columnas
  
                            break;
  
                         default: 
  
                            val= theTbl.rows[i].cells[0].innerHTML;
  
                            if(val==''){                              
  
                                      FaltaArray[j] = i ;
  
                                   }
  
  
                               break;
  
                         }
  
              }      
  
         } //FIN BLUCLE PARA LEER CELDA POR CELDA DE CADA LINEA
  
         //INSERTA valor de CELL en el arreglo 
  
         if(itemId!=''){
  
          LineArray[i]=cell; 
          console.log(cell);
         }
  
  i++;       
  
  }//FIN BLUCLE PARA LEER LINEA POR LINEA DE LA TABLA 
  
}
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
  //FIN ITEMS
  
  function FIND_COLUMN_NAME(item){
  
   switch (item){
  
    case 1: val ='Descripcion'; break;
  
   }
  
  return val;
  }
  
  function msg(link,SalesOrderNumber){
  
            alert("La orden se ha enviado con exito");
            location.reload();
     //   console.log(link+'?url=ges_reportes/rep_so_detail/'+SalesOrderNumber);
     //   window.open(link+'?url=ges_reportes/rep_so_detail/'+SalesOrderNumber,'_self');
  
  }


  
  
  function checkSOIns(link_so,OS_NO){
  
  
        $.ajax({
  
              type: "GET",
              url:  link,
              data:  {url: 'bridge_query/checkSOIns/'+OS_NO}, 
              success: function(res){
  
              if (res == 1) {
                MSG_ERROR('Ocurrio un error al crear el pedido. Por favor valide los datos de cabecera!.', 0);
              }  
              if (res == 2) {
                MSG_ERROR('Ocurrio un error al crear el pedido. Por favor valide el detalle de la orden!.', 0); 
              }
              
              if (res == 0) {
               msg(link_so,OS_NO);
              }
             }
          });
  
  }


////////////////////////////////////////////////////////
//INI FUNCIONES PARA MANEJO DE ERRORES
////////////////////////////////////////////////////////
  //FUNCION DE ERROR 
  function MSG_ERROR(MSG,VAL){
    
      $('#ERROR').show();
      $('#ERROR').addClass( "alert alert-danger" ); 
    
      if(VAL == 1){
        
        $('#ERROR').append(MSG+'<br>');
    
      }else{
    
        $('#ERROR').html(MSG+'<br>');
      }
      
      $("html, body").animate({ scrollTop: 0 }, "slow");

    }
    
    //FUNCION DE CORRECTO
    function MSG_CORRECT(MSG,VAL){
    
      $('#ERROR').show();
      $('#ERROR').addClass( "alert alert-success" ); 
    
      if(VAL == 1){
        
        $('#ERROR').append(MSG+'<br>');
    
      }else{
    
        $('#ERROR').html(MSG+'<br>');
      }
    
      $("html, body").animate({ scrollTop: 0 }, "slow");
      
    }
    
    function MSG_ERROR_RELEASE(){
    
    $('#ERROR').html('');
    $('#ERROR').hide();
    
    }
////////////////////////////////////////////////////////
//END FUNCIONES PARA MANEJO DE ERRORES
////////////////////////////////////////////////////////



// ********************************************************
// * checa si el valor introducido no es /
// ********************************************************
function checkNOTA(id){

  MSG_ERROR_RELEASE();

  var x=document.getElementById(id).value;
  
  var patt_slash = new RegExp("/");
  var slash = patt_slash.test( x );
  
  if (slash == true){
  
      document.getElementById(id).value = x.slice(0,-1);
  

      MSG_ERROR("No se permite carecteres especiales en este campo",0);
 
      
      return false;

    }
  
  }
  
  // ********************************************************
  // * checa si el valor introducido no es @
  // ********************************************************
  function checkArroba(id){

 MSG_ERROR_RELEASE();
  
  var x=document.getElementById(id).innerHTML;
  
  var patt_slash = new RegExp("@");
  var slash = patt_slash.test( x );
  
  if (slash == true){
  
      document.getElementById(id).innerHTML = x.slice(0,-1);
  
      MSG_ERROR("No se permite carecteres especiales en este campo",0);
      
      
      return false;

    }
  
  }
  
  