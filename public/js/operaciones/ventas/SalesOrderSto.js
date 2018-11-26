$(window).load(function(){

//RUN PROCESS EVENT HANDLER
$( "#process" ).click(function( event ) {

  send_order();
 /* try {
    send_order();
  } catch (e) {
  
   throw new Error(e.message);
   MSG_ERROR(e.message,0);
  }*/
});



$('#ERROR').hide();


//cuando la pagina ya cargo

var TaxID=$("#taxid option:selected").html();
var Taxval=$("#taxid option:selected").val();

set_taxid(Taxval,1);

init(2);

var table = $("#table_ord_tb").DataTable({

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
NO_LINES  = document.getElementById('FAC_NO_LINES').value;
ANMT_VIEW = document.getElementById('ANMT_VIEW').value;
STOCK_VIEW = document.getElementById('STOCK_VIEW').value;

link = URL+"index.php";
chk = '';
cantLineas = NO_LINES; //Setea la cantidad de lineas disponibles en la tabla de solicitud de items


function init(chk)
{
  var listitem = '';
  var i = 1;
  var datos= "url=bridge_query/getItems/";
  var reglon = '';
  var editable = document.getElementById('editable').value;

if(editable==''){ bg_color =' background-color:#D8D8D8;';   }else{  bg_color = '';  }

if(ANMT_VIEW == 0){ display ='display:none;';   }else{  display = '';  }
if(STOCK_VIEW == 0){ displayStock ='display:none;';   }else{  displayStock = '';  }


$.ajax({
      type: "GET",
      url: link,
      data: datos,
      success: function(res){
      listitem = res;

$('#table_req').html(''); //limpio la tabla 

while(i <= cantLineas){

      if(chk==1){ 

          reglon = '<td  width="10%" >'+i+'</td>';  

       }else{

          reglon = '<td width="10%" >'+
                    '<select class="selectItems col-lg-12" id="sel'+i+'" onchange="SetDesc(this.value,'+i+')" >'+
                        '<option selected></option>'
                        +listitem+
                    '</select>'+
                '</td>';  

       }        

      var line_table_req = '<tr>'+reglon+
      "<td width='15%' class='rowtable_req' onkeypress='MSG_ERROR_RELEASE();' onkeyup='checkTblChar(this.id); checkLong(this.id,"+'50'+");' contenteditable id='desc"+i+"'  ></td>"+
      "<td width='15%' class='rowtable_req' onkeypress='MSG_ERROR_RELEASE();' onkeyup='checkTblChar(this.id); checkLong(this.id,"+'50'+");' contenteditable id='nota"+i+"'  ></td>"+
      '<input type="hidden"   id="unit'+i+'" />'+
      '<td width="3%" style="'+displayStock+'"  class="rowtable_req numb" id="Tblote'+i+'"  ></td>'+
      '<input type="hidden"  id="taxable'+i+'" />'+
      '<td width="3%" style="'+displayStock+'"  class="rowtable_req numb" id="Tbloc'+i+'"   ></td>'+
      '<input type="hidden"  id="stock'+i+'" />'+
      '<td width="5%"  class="rowtable_req  numb" onfocusout="checkMax('+i+');" contenteditable id="qty'+i+'"></td>'+
      '<td width="5%"  style="'+bg_color+'"  class="rowtable_req  numb" '+editable+' onfocusout="calculate('+i+');" id="unitprice'+i+'" ></td>'+
      '<td width="5%"  style="'+display+'" class="rowtable_req  numb" id="total'+i+'" ></td></tr>' ;
       i++

       $('#table_req').append(line_table_req); //limpio la tabla 
      }

      set_selectItemStyle(); 
      }
     });

     

}



function SetDesc(itemId, line){

var datos= "bridge_query/get_ProductsInfo";

var id_desc_field = 'desc'+line;
var id_unit_field = 'unit'+line;
var id_price_field = 'unitprice'+line;
var id_taxable_field = 'taxable'+line;
var id_qty_field = 'qty'+line;
var id_stock_field = 'stock'+line;
var id_total_field = 'total'+line;
var id_lote = 'Tblote'+line;
var id_loc = 'Tbloc'+line;

var listID =  document.getElementById('listID').value;

document.getElementById(id_loc).innerHTML  = '';
document.getElementById(id_lote).innerHTML  = '';

$.ajax({

      type: "GET",
      url: link,
      data: {url: datos, item: itemId},
      success: function(res){

      console.log(res);
 


       json = JSON.parse(res);
       document.getElementById(id_desc_field).innerHTML  = json.Description;
       document.getElementById(id_unit_field).value  = json.UnitMeasure;
       document.getElementById(id_stock_field).value  = json.QtyOnHand;
       document.getElementById(id_price_field).innerHTML  = json.Price1;

       if(json.TaxType == 1){

        document.getElementById(id_taxable_field).value  = 'SI';

       }else{

        document.getElementById(id_taxable_field).value  = 'NO';

       }

     }

 });

setTimeout(function(){

 // set_Stockqty_default(itemId,id_stock_field);

    if(listID!=''){

     findprice(itemId, listID, id_price_field);

    }else{

    // document.getElementById(id_price_field).innerHTML  = '';

    }

    if(itemId==''){

         document.getElementById(id_price_field).innerHTML  = '';

         recalcular(line);

         document.getElementById(id_qty_field).innerHTML  = '';
         document.getElementById(id_total_field).innerHTML  = '';       
         document.getElementById(id_unit_field ).innerHTML = '';
         document.getElementById(id_desc_field).innerHTML  = '';
         document.getElementById(id_taxable_field).innerHTML  = '';
         document.getElementById(id_price_field).innerHTML  = '';
         document.getElementById(id_loc).innerHTML  = '';
         document.getElementById(id_lote).innerHTML  = '';

  }
 
  getLotes(itemId,line);

},500);

}



function getLotes(itemId,line){

var datos= "url=ges_inventario/getLotesByItem/"+itemId+"/"+line;
var id_lote = 'Tblote'+line;

$.ajax({
    
          type: "GET",
          url: link,
          data: datos,
          success: function(res){ 
        
            document.getElementById(id_lote).innerHTML  = res;

           
              set_selectLoteStyle(line);
            
            
          }
        });
  
}

function SetLocation(lote,line){

  var datos= "url=ges_inventario/getLocByItem/"+lote+"/"+line;
  
  var id_loc = 'Tbloc'+line;
  
  $.ajax({
      
            type: "GET",
            url: link,
            data: datos,
            success: function(res){ 
             console.log(res);
              document.getElementById(id_loc).innerHTML  = res;

            
              set_selectLocStyle(line);
            
            }
          });
  
}


function SetMaxQty(id,line){

    var datos= "url=ges_inventario/get_any_lote_qty/"+id;
    
    var id_qty= 'qty'+line;
    var id_stockMax= 'stock'+line;
    
    $.ajax({
        
              type: "GET",
              url: link,
              data: datos,
              success: function(res){ 
                                
                  document.getElementById(id_qty).innerHTML  = res;
                  document.getElementById(id_stockMax).value  = res;
                  recalcular(line);
              }
            });
  
}


function checkMax(line){

  $('#ERROR').hide();

  var id_stockMax = 'stock'+line;
  var id_qty = 'qty'+line;
  
  var max =  document.getElementById(id_stockMax).value ;
  var value =  document.getElementById(id_qty).innerHTML ;

  var curVal = Number(value);
  var maxVal = Number(max);
  
  console.log(curVal +'-'+maxVal);



  if(curVal <= maxVal){

    recalcular(line);

  }else{

    MSG_ERROR('La cantidad maxima ha sido excedida',0);
  }
  


}


function set_Stockqty_default(itemId,id_stock_field){

var datos= "url=bridge_query/get_items_defaultstock_qty/"+itemId;

$.ajax({

      type: "GET",
      url: link,
      data: datos,
      success: function(res){

       document.getElementById(id_stock_field).innerHTML = res;

     }

     });

}

function findprice(itemId, listID, id_price_field){

var datos= "url=bridge_query/get_ProductsPrice/"+itemId+"/"+listID;

console.log(datos);

$.ajax({

      type: "GET",
      url: link,
      data: datos,
      success: function(res){

        console.log(res);
        if(res.trim()!=''){

        document.getElementById( id_price_field ).innerHTML  = parseFloat(res).toFixed(4); ;

        }else{

        console.log('yes');
        document.getElementById(id_price_field).innerHTML  = '';
        document.getElementById(id_price_field).setAttribute("contenteditable","");

        }
     }

});

}

function valid_qty(line){

$('#ERROR').hide();

var id_qty_field = 'qty'+line;
var id_stock_field = 'stock'+line;

stockqty= Number(document.getElementById(id_stock_field).innerHTML);
qty= Number(document.getElementById(id_qty_field).innerHTML);

if(qty!=''){

    var compare = (parseInt(stockqty) >= parseInt(qty));

    if(!compare){

      MSG_ERROR('ERROR LINEA '+line+' : El valor de la cantidad no debe exceder la cantidad disponible en Stock',0);

      document.getElementById(id_qty_field).innerHTML = '';

      recalcular(line);

     }else{

      recalcular(line);

     }

}

}

function recalcular(line){

PriceID = 'unitprice'+line;

UnitPrice = document.getElementById(PriceID).innerHTML;

  if(UnitPrice!=''){

      calculate(line);

  }

}

function calculate(line){

qtyID = 'qty'+line;
PriceID = 'unitprice'+line;
totalID = 'total'+line;
qty = document.getElementById(qtyID).innerHTML;
UnitPrice = document.getElementById(PriceID).innerHTML;

if(qty=='' || UnitPrice == ''){

qty = 0;
UnitPrice = 0;

}

total = qty * UnitPrice;

document.getElementById(totalID).innerHTML = parseFloat(total).toString().match(/^-?\d+(?:\.\d{0,2})?/)[0]; 
document.getElementById(qtyID).innerHTML =   parseFloat(qty).toFixed(5);

sumar_total();

}

function sumar_total(){

var theTbl = document.getElementById('table_ord_tb'); //objeto de la tabla que contiene los datos de items
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

  ITEMid = 'sel'+i;
  taxableID = 'taxable'+i;
  ITEM_ID = '';

    for(var j=0;j<theTbl.rows[i].cells.length; j++) //BLUCLE PARA LEER CELDA POR CELDA DE CADA LINEA

        {       

            switch (j){

                   case 7:
                   
                    if(document.getElementById(taxableID).value=='SI'){

                    itbms_sum = ( Number(theTbl.rows[i].cells[j].innerHTML) * Number(theTbl.rows[i].cells[5].innerHTML) ) * Number(tax_value);
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

    console.log(itbms);

    //TAX = Number(subtotal)*Number(TAX);

    TOTAL = subtotal + TAX;

  subtotal_field.value = parseFloat(subtotal).toFixed(2);
  tax_field.value      = parseFloat(TAX).toFixed(2);
  total_field.value   =  parseFloat(TOTAL).toFixed(2);

}



function set_listprice(ID){

var datos= "bridge_query/get_Cust_info";

var link= URL+"index.php";

  $.ajax({

      type: "GET",
      url: link,
      data: {url: datos, id : ID},
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

  init(2);             

}



function mod_price_auth(){

 $('#ERROR').hide();

  //inicio variables de session

  user = $('#user').val();

  pass = $('#pass').val();

var datos= "url=bridge_query/login_to_auth/"+user+'/'+pass;

var link= URL+"index.php";

  $.ajax({

      type: "GET",

      url: link,

      data: datos,

      success: function(res){

         if(res==0){

          MSG_ERROR('El Usuario indicado no tiene aurotizacion para modificacion de precios unitarios.',0);

         }else{ 

          set_price_fields();

         }

        }

   });

}

function set_price_fields(){

    i = 1;

    while ( i <= cantLineas){

    id_unitprice = 'unitprice'+i;

    document.getElementById(id_unitprice).setAttribute("contenteditable", ""); 

    document.getElementById(id_unitprice).setAttribute("style", "background-color:#A9F5BC"); 

    i++;

    }

}

/////////////////////////////////////////////////////////////////////////////////////////////////
//VALIABLES GLOBALES
CHK_VALIDATION = false;
vendorID = '';
falta = 0;
LineArray = [];
FaltaArray = [];
//VALIABLES GLOBALES

function validacion(){

  CUSTOMER = document.getElementById('customer').value;
  if (CUSTOMER == ''){
   MSG_ERROR('Se debe seleccionar un cliente',0);
   CHK_VALIDATION = true;
  }
}

function send_order(){

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
HeaderInfo = [];  
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
    var tipo_licitacion = document.getElementById('tipo_licitacion').value;
    var observaciones = document.getElementById('observaciones').value;
    var entrega = document.getElementById('entrega').value;
    var user=document.getElementById('active_user_id').value;
    var nopo=document.getElementById('nopo').value;
    var fecha_entrega=document.getElementById('fecha_entrega').value;
    var Subtotal=$("#subtotal").val();
    var total=   $("#total").val();
    var Ordertax =$("#tax").val();
    var TaxID=$("#taxid option:selected").html();  //ultimo cambio
    var LugDesp = document.getElementById('lugar_despacho').value;
    //REGITRO DE CABECERA

    function set_header(){

    //INI REGISTRO DE CABECERA
    HeaderInfo[0] =  CustomerID+
                    '@'+Subtotal+
                    '@'+TaxID+
                    '@'+total+
                    '@'+nopo+
                    '@'+termino_pago+
                    '@'+tipo_licitacion+
                    '@'+observaciones+
                    '@'+entrega+
                    '@'+Ordertax+
                    '@'+fecha_entrega+
                    '@'+LugDesp;


      return  $.ajax({
            type: "GET",
            url: link,
            data: {url: 'ges_ventas/set_sales_order_header', Data : JSON.stringify(HeaderInfo)},
            success: function(res){
            console.log(res);
            OS_NO = res;
        }
      });

     }//FIN REGISTRO DE CABECERA

    $.when(set_header()).done(function(OS_NO){ //ESPERA QUE TERMINE LA INSERCION DE CABECERA

     console.log(OS_NO);

      //REGISTROS DE ITEMS 
        $.ajax({
         type: "GET",
         url:  link,
         data:  {url: 'ges_ventas/SetSOfromStock/'+OS_NO , Data : JSON.stringify(LineArray)}, 
         success: function(res){
         console.log(res);
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

/////////////////////////////////////////////////////////////////////////////////////
}

/////////////////////////////////////////////////////////////////////////////////////
//FUNCION PARA GUARDAR ITEMS EN ARRAY 
function set_items(){

LineArray.length=''; //limpio el array

var flag = ''; 
var theTbl = document.getElementById('table_ord_tb'); //objeto de la tabla que contiene los datos de items
var line = '';
var cantLineas = Number(document.getElementById('FAC_NO_LINES').value);

var i=1;

//BLUCLE PARA LEER LINEA POR LINEA LA TABLA 
while (i <= cantLineas){

  cell = '';
  for(var j=0;j<theTbl.rows[i].cells.length; j++) //BLUCLE PARA LEER CELDA POR CELDA DE CADA LINEA

        {

        var selid = "sel"+i;
        var unitid = 'unit'+i;

        var lote = 'lote'+i;
        var loc = 'loc'+i;

        if(document.getElementById(selid).value !=''){

              switch (j){

                       case 7:

                            
                            itemId      = document.getElementById(selid).value;
                            desc        = theTbl.rows[i].cells[1].innerHTML;
                            nota        = theTbl.rows[i].cells[2].innerHTML;
                            UnitMeasure = document.getElementById(unitid).value;

                            qty       = theTbl.rows[i].cells[5].innerHTML;
                            UnitPrice = theTbl.rows[i].cells[6].innerHTML;
                            total     = theTbl.rows[i].cells[7].innerHTML;
                           
                            if (STOCK_VIEW == 1){
                              lote  = document.getElementById(lote).value;
                              loc   = document.getElementById(loc).value;
                            }
                            
                            var line = desc+'@'+nota+'@'+UnitMeasure+'@'+itemId+'@'+UnitPrice+'@'+qty+'@'+total+'@'+lote+'@'+loc;
                            cell += replaceNbsps(line);
                           
                          break;

                       default: 
                      
                       if (STOCK_VIEW == 1){
                        lote  = document.getElementById(lote).value;
                        loc   = document.getElementById(loc).value;
                      }
                       val   = theTbl.rows[i].cells[0].innerHTML;

                          if(val==''){                              
                                    FaltaArray[j] = i ;
                                 }

                          if(lote==''){                              
                                    FaltaArray[j] = i ;
                                }
                          
                          if(loc==''){                              
                                  FaltaArray[j] = i ;
                              }
                             break;
                          
                          
                       }
            }      

       } //FIN BLUCLE PARA LEER CELDA POR CELDA DE CADA LINEA

       //INSERTA valor de CELL en el arreglo 
       if(document.getElementById(selid).value !=''){
        LineArray[i]=cell; 
       }
i++;       

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

//FIN ITEMS
function FIND_COLUMN_NAME(item){

switch (item){
  case 1: val ='Descripcion'; break;
  
  case 3: val ='Lote'; break;
  case 4: val ='Ubicacion'; break;
  
}



return val;
}

function msg(link,SalesOrderNumber){

          alert("La orden se ha enviado con exito");

          var R = confirm('Desea imprimir la orden de venta?');
          
          if(R==true){
                 window.open(link+'?url=ges_ventas/PrintSalesOrder/2/'+SalesOrderNumber,'_self');
          }else{

            location.reload();
          }
}


function checkSOIns(link_so,OS_NO){
      $.ajax({
            type: "GET",
            url:  link,
            data:  {url: 'bridge_query/checkSOIns/'+OS_NO},
            success: function(res){
               
            console.log('check:'+res);
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

function set_taxid(rate){
    
        var rate = rate/100;    
        document.getElementById('saletaxid').value =  rate;
        
        sumar_total();
}