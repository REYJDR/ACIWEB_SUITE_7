////////////////////////////////////////////////////////////////////////////////////////////////
//valiable globales
/////////////////////////////////////////////////////////////////////////////////////////////////
var editable = 'contenteditable';
var editable2 = '';
var stocks = '';
var Type = '';
var listitem = '';
var color = '';
var color2 = "style='background-color:#ECECEC;'";

var JOBS = '';
var PHASES = '';
var COST = '';

var OriStock= "";
var STOCKS = '';
var LOCATION = '';

var CHK_VALIDATION ='';
LineArray = [];
FaltaArray = [];
var link=  $('#URL').val()+"index.php";
/////////////////////////////////////////////////////////////////////////////////////////////////
//valiable globales
/////////////////////////////////////////////////////////////////////////////////////////////////




// ********************************************************
// * Aciones cuando la pagina ya esta cargada
// ********************************************************
$(window).load(function(){
    
    $('#ERROR').hide();
    getStocklist();
   
});


// * INICIALIZA TBL ENTRADA MASIVA  (CHK = 1-ENTRADA NUEVO ITEM / 2- AJUSTE DE ITEM EXISTENTE 
// ******************************************************************************************
function init(){
    
   
       $('#items').html('loading...');
   

      
           function getItems(){
   
               var datos= "url=bridge_query/get_ProductsCode/";
               var link= $('#URL').val()+"index.php";
              
                
             return   $.ajax({
                      type: "GET",
                      url: link,
                      data: datos,
                      success: function(res){
                     
                          listitem = res;
                          
                      }
                     });
   
               
               
           } //obtengo lista de items
   
           $.when(getItems()).done(function(){ //ESPERA QUE TERMINE el query de items
               
               builtTbl();
               
           });
      


}
   
function getStocklist(){
    

    function getStocks(){

        var datos= "url=ges_inventario/get_almacen_selectlist/";
        var link= $('#URL').val()+"index.php";
        
        
        return   $.ajax({
                type: "GET",
                url: link,
                data: datos,
                success: function(res){
                
                    STOCKS = res;
                    
                }
                });

        
        
    }
    $.when(getStocks()).done(function(){ //ESPERA QUE TERMINE el query de items
        
        init();
        
    });
    
}
    

// ******************************************************************************************
// * CREA TABLA 
// ******************************************************************************************
function builtTbl(chk){

    var i = 1;
    var reglon = '';
    var cantLineas = $('#FAC_NO_LINES').val();


    $('#items').html(''); //limpio la tabla 

    while(i <= cantLineas){
        

        reglon = '<td width="10%" >'+
                    '<select class="selectItems col-lg-12" id="sel'+i+'" onchange="SetDesc(this.value,'+i+')" >'+
                        '<option selected></option>'
                        +listitem+
                    '</select>'+
                '</td>';  

            var line_table_req = '<tr>'+reglon+
                '<td width="15%" class="rowtable_req" onkeyup="checkTblChar(this.id)"  id="desc'+i+'"  ></td>'+
                '<td width="15%" class="rowtable_req" ><select class="selectStocks col-lg-12" id="stockOri'+i+'" onchange="GetQtyInStock(this.value,'+i+')"  ><option  value="-" selected>-</option></select></td>'+
                '<td width="5%"  class="rowtable_req  numb" onkeyup="checkTblPositive(this.id)"  contenteditable id="qty'+i+'"></td>'+                
                '<td width="15%" class="rowtable_req" ><select class="selectStocks col-lg-12" onchange="GetLocList(this.value,'+i+')"  id="stockDes'+i+'"     ><option  value="-" selected>-</option>'+STOCKS+'</select></td>'+
                '<td width="15%" class="rowtable_req" ><select class="selectStocks col-lg-12" id="locationDes'+i+'"  ><option  value="-" selected>-</option></select></td>'+
                
          
                //     '<td width="5%"  class="rowtable_req  numb" onkeyup="checkTblPositive(this.id)" onfocusout="recalcular('+i+');" contenteditable id="qty'+i+'"></td>'+
           //     '<td width="5%"  class="rowtable_req  numb" onkeyup="checkTblnum(this.id)" onfocusout="calculate( '+i+');" contenteditable   id="unitprice'+i+'" ></td>'+
           //'<td width="5%"  class="rowtable_req  numb" '+color+' id="total'+i+'" ></td></tr>' ;
            i++
            
            $('#items').append(line_table_req); //limpio la tabla 
            }

           set_selectItemStyle(); 
           set_selectStockStyle();

}

// ******************************************************************************************
// * OBTIENE INFORMACION DE ITEM  
// ******************************************************************************************
function SetDesc(itemId, line){
    
    var id_desc_field = 'desc'+line;
    var id_unit_field = 'unit'+line;
    var id_price_field = 'unitprice'+line;
    var id_taxable_field = 'tax'+line;
    var id_qty_field = 'qty'+line;
    var id_stockOri = 'stockOri'+line;


       if(itemId == ''){

        document.getElementById(id_desc_field).innerHTML  = '';
        document.getElementById(id_qty_field).innerHTML  = '';

        $("#stockOri"+line).select2("destroy");
        $("#stockOri"+line).html('<option  value="-" selected>-</option>');
        $("#stockOri"+line).select2({
            
                placeholder: '',
                allowClear: true,
                maximumSelectionSize: 1,
                dropdownCssClass : 'bigdrop'
            
              }); 

        $("#stockDes"+line).val('-');
        $("#locationDes"+line).val('-');
        
       

       }else{

        document.getElementById(id_desc_field).innerHTML = 'Loading...';
        
            function GetStockbItem(){
    
                var url= "ges_inventario/getStockByItemID/";
                var link=  $('#URL').val()+"index.php";
            
            
                return $.ajax({
                        type: "GET",
                        url: link,
                        data: {url : url, itemID: itemId },
                        success: function(res){
    
                         //   console.log(res);
                           
                            $("#stockOri"+line).append(res);
                            
                            }
                    });
    
            }
        
            $.when(GetStockbItem()).done(function(res){ //ESPERA QUE TERMINE el query de items*/
                
            function getItems(){
                
                var datos= "bridge_query/get_ProductsInfo";
                var link= $('#URL').val()+"index.php";
    
               return $.ajax({
                        type: "GET",
                        url: link,
                        data: {url: datos, item: itemId},
                        success: function(res){
                
                       
                    }
                
                });
    
            }
            $.when(getItems()).done(function(res){ //ESPERA QUE TERMINE el query de items
                
                json = JSON.parse(res);
                        
                document.getElementById(id_desc_field).innerHTML  = json.Description;
               // document.getElementById(id_unit_field).innerHTML   = json.UnitMeasure;
               // document.getElementById(id_qty_field).innerHTML  = json.QtyOnHand;
               // document.getElementById(id_price_field).innerHTML  = json.Price1;
                
    
        });
       }  );
    
 
}
}



function proceed(){

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
     flag = setItems();

        /////////////////////////////////////////////////////////////////////////////////////
        //SI NO HAY ITEMS EN LA LISTA
        if(flag==0){ 
            MSG_ERROR('No se han indicado registros para el traspaso'); 
              return;
          }
          
        /////////////////////////////////////////////////////////////////////////////////////
        //SI HAY ITEMS EN LA LISTA
        if(flag==1){  
        
        var r = confirm('Está seguro de procesar el traspado de mercancia ?');
        
            if (r == true) { 
            
                console.log(LineArray);
                    //REGISTROS DE ITEMS 
                 /*   $.ajax({
                        type: "GET",
                        url:  link,
                        data:  {url: 'ges_inventario/setInventoryAdjustmentOUT/', Data : JSON.stringify(LineArray)}, 
                        success: function(res){
        
                            if(res.indexOf('ERROR') != -1){
                            
                                MSG_ERROR(res,0);
                            
                            }else{//TERMINA EL LLAMADO AL METODO set_req_items SI ESTE DEVUELV UN '1', indica que ya no hay items en el array que procesar.
                                //checkSOIns(link,OS_NO);
                                msg(link,res);
                            }

                        }
                
                    });*/

                
            }
        }


    /////////////////////////////////////////////////////////////////////////////////////
    //MANEJO DE ERRORES POR CAMPO FALTANTES EN LOS ITEMS
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

    // ******************************************************************************************
    // CONSTRUYE ARRAY CON ITEMS 
    // ******************************************************************************************
    function setItems(){

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
        
                //*AJUSTE DE MATERIAL
                var selid    = "sel"+i;
                var origen   = "stockOri"+i;
                var stockDes = "stockDes"+i;
                var locDes   = "locationDes"+i;
                
                if(document.getElementById(selid).value !=''){ 
        
                        switch (j){
            
                                case 0:
                                  
                                    itemId    = document.getElementById(selid).value;
                                    origenID  = document.getElementById(origen).value;
                                    stockId   = document.getElementById(stockDes).value;
                                    locId     = document.getElementById(locDes).value;
                                    note      = document.getElementById('observaciones').value;
                                    ref       = document.getElementById('referencia').value;
                                    qty       = theTbl.rows[i].cells[3].innerHTML;
                                   
                                  
                                    if( itemId == '-'  ) FaltaArray[0] = i ;
                                    if( origenID == '-') FaltaArray[2] = i ;
                                    if( qty == '' || 0 ) FaltaArray[3] = i ;
                                    if( stockId == '-' ) FaltaArray[4] = i ;
                                    if( locId == '-'   ) FaltaArray[5] = i ;


                                    //agrego el registo de las demas columnas
                                    cell += '@'+itemId+
                                            '@'+origenID+
                                            '@'+stockId+
                                            '@'+locId+
                                            '@'+qty+
                                            '@'+note+
                                            '@'+ref ;
                                 

                                    break;
    
                                   
                                }
                    }      
        
                } //FIN BLUCLE PARA LEER CELDA POR CELDA DE CADA LINEA
            

                 if(document.getElementById(selid).value !=''){
                   LineArray[i]=cell; 
                 }        
            
            i++;  
            }//FIN BLUCLE PARA LEER LINEA POR LINEA DE LA TABLA 

            
            

        
        //SETEA RETURN DE LA FUNCION, FLAG 1 Ó 0, SI ES 1 LA TABLA ESTA LLENA, SI ES 0 LA TABLA ESTA VACIA.
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
    // ******************************************************************************************
    // CONSTRUYE ARRAY CON ITEMS 
    // ******************************************************************************************


//******************************************************************************************
//VALIDACION DE CONTENIDO
//******************************************************************************************
function validacion(){

    if (document.getElementById('observaciones').value == ''){
        MSG_ERROR('Se debe agregar una nota en observaciones',0);
        CHK_VALIDATION = true;
    }
    if (document.getElementById('referencia').value == ''){
        MSG_ERROR('Se debe agregar una referencia',0);
        CHK_VALIDATION = true;
    }
}
//******************************************************************************************
//VALIDACION DE CONTENIDO
//******************************************************************************************

//******************************************************************************************
//busca nombre de columna
//******************************************************************************************
function FIND_COLUMN_NAME(item){
    
    var theTbl = document.getElementById('table_ord_tb');

    var val = theTbl.rows[0].cells[item].innerHTML;
    return val;
    }
//******************************************************************************************
//busca nombre de columna
//******************************************************************************************



//******************************************************************************************
//mensaje
//******************************************************************************************

function msg(link,id){

   // MSG_CORRECT("La informacion ha ingresado correctamente, No. de transaccion: "+id,1);
    alert("La informacion ha ingresado correctamente, No. de transaccion: "+id);
    location.reload();
    /*var R = confirm('Desea imprimir la orden de venta?');
   
    if(R==true){
           window.open(link+'?url=ges_ventas/PrintSalesOrder/1/'+SalesOrderNumber,'_self');
    }else{

      location.reload();
    }*/
}
//******************************************************************************************
//mensaje
//******************************************************************************************


// ******************************************************************************************
// * OBTIENE JOBS para estimacion de presupuesto
// ******************************************************************************************
function jobs(){   
    
    /*JOBS*/
    var datos= "url=ges_requisiciones/get_JobList";


    $.ajax({
    type: "GET",
    url: link,
    data: datos,
    success: function(res){

    JOBS = res;

    $('#JOBID2').append(JOBS);
                
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
               
               init();
             
             }                   
              
            }
        });
     /*cost*/
     
}



function GetQtyInStock(id,line){

   if(id != '-'){
    var url= "ges_inventario/get_any_lote_qty/"+id;
    var link=  $('#URL').val()+"index.php";


    $.ajax({
            type: "GET",
            url: link,
            data: {url : url},
            success: function(res){


                $("#qty"+line).html(res);
               
            }
        });
    
   }else{

    $("#qty"+line).html('');

   }
   

}

function GetLocList(id,line){

    if(id != '-'){
        var url= "ges_inventario/get_routes_by_almacenid/"+id;
        var link=  $('#URL').val()+"index.php";
    
    
        $.ajax({
                type: "GET",
                url: link,
                data: {url : url},
                success: function(res){
    
    
                    $("#locationDes"+line).append(res);
                   
                }
            });
        
       }else{
    
        $("#locationDes"+line).html('');
    
       }
       

}