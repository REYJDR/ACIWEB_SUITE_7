/////////////////////////////////////////////////////////////////////////////////////////////////
//valiable globales
/////////////////////////////////////////////////////////////////////////////////////////////////
    var editable = 'contenteditable';
    var stocks = '';
    var Type = '';
    var listitem = '';
    var color = '';
    LineArray = [];
    FaltaArray = [];
/////////////////////////////////////////////////////////////////////////////////////////////////
//valiable globales
/////////////////////////////////////////////////////////////////////////////////////////////////

// ********************************************************
// * Aciones cuando la pagina ya esta cargada
// ********************************************************
$(window).load(function(){
    

    $('#prod_ind').hide();
    $('#prod_masive').hide();
    $('#prod_layout').hide();  

    MSG_ADVICE('LOADING...');

    
    function GetStockList(){


        var datos= "url=ges_inventario/get_almacen_selectlist/";
        var link=  $('#URL').val()+"index.php";
    
    
       return $.ajax({
                type: "GET",
                url: link,
                data: datos,
                success: function(res){
        
                    stocks = res;
        
                    $("#up_stock").html(res);
            
                    }
            });

    }
    $.when(GetStockList()).done(function(){ //ESPERA QUE TERMINE QUERY DE ALMACENES

        $('#ERROR').hide();

        //setea por defaul el valor 1 para mostrar el div de crear nueva lista de precios 
       
        function setDiv() {
            return set_div(1);
        } 
        $.when(setDiv()).done(function(){ 

            jobs();
        });
            

    });

   

});


// ********************************************************
// * Aciones cuando la pagina incia|
// ******************************************************** 
document.addEventListener('DOMContentLoaded', function() {

    
          //ALTERNA LA SELECCION DE LOS CHECKBOX, PARA NO TENER DOS CHECKBOX SELECCIONADOS AL MISMO TIEMPO
            $(".chkGrp").on('click', function() {
              
              var $box = $(this);
              if ($box.is(":checked")) {

                var group = "input:checkbox[name='" + $box.attr("name") + "']";
                    $(group).prop("checked", false);
                   
                    $box.prop("checked", true);
              
                } else {
              
                    $box.prop("checked", true);
                } 
        
            });

           $("#adjust").on('click', function() {
                var $box2 = $(this);
                
                if ($box2.is(":checked")) {
                
                    editable = '';
                    color = "style='background-color:#ECECEC;'";
                    init(2);//construye tabla

               }else{

                    color = "";
                    $box2.prop("checked", false);
                    init(1);//construye tabla
               }

             });



               $('#JOBID2').on("change", function (e) {

                $('#Budget').val('Calculando...');
              
                $('#PHASEID2').html('');
                $('#PHASEID2').prepend('<option value="-" selected>-</option>');
                $('#PHASEID2').select2('val','-');
                
                $('#COSTID2').html('');
                $('#COSTID2').prepend('<option value="-" selected>-</option>');
                $('#COSTID2').select2('val','-');

                getPhase();

               
                
                });
            
                $('#PHASEID2').on('change', function (e) {
                
                $('#Budget').val('Calculando...');
                getCost();


                                
                });
                $('#COSTID2').on('change', function (e) {
                $('#Budget').val('Calculando...');
                getBudget();


                                
                });

});



// ******************************************************************************************
// * HABILITA EL DIV REQUERIDO (1-ENTRADA INDIVIDUAL / 2-CARGA DE LISTA / 3-ENTRADA MASIVA)
// ******************************************************************************************
function set_div(val){
    

    //OCULTA/MUESTRA EL DIV SEGUN SELECION DEL CHECKBOX PARA CREAR UN NUEVO IDPRICE O UTILIZAR UN IDPRICE EXISTENTE
    if(val=='1'){
        
                $('#prod_ind').show();
                $('#prod_masive').hide();
                $('#prod_layout').hide();      
                Type = 1;
        
            }
            if(val=='2'){
        
                $('#prod_ind').hide();
                $('#prod_masive').hide();
                $('#prod_layout').show(); 
                Type = 2;
                
        
            }
            if(val=='3'){
                
                $('#prod_ind').hide();
                $('#prod_layout').hide();
                $('#prod_masive').show();
                init(1);//construye tabla
                Type = 3;
            }

}

// ******************************************************************************************
// * OBTIENE UBICACIONES SEGUN ALMACEN SELECCIONADO
// ******************************************************************************************
function locat(id,line=0){
     
    //LA VARIABLE DE URL PROVEIENE DE LA VARIABLO GLOBAL url SETEADA EN LA FUNCION add_location
    var datos= "url=ges_inventario/get_routes_by_almacenid/"+id;
    var link= $('#URL').val()+"index.php";
    
        $.ajax({
            type: "GET",
            url: link,
            data: datos,
            success: function(res){
            

           if(Type == 1){
            
            $("#up_route").html(res);

           }
           if(Type == 3){

            
            $("#SelRoute"+line).html(res);

           }
            
            }
        });
        
}

// ******************************************************************************************
// * OBTIENE JOBS para estimacion de presupuesto
// ******************************************************************************************
function jobs(){   


    var datos= "url=ges_inventario/getJobList";
    var link= $('#URL').val()+"index.php";

      return   $.ajax({
                    type: "GET",
                    url: link,
                    data: datos,
                    success: function(res){
                    
                    JOBS = res;
                    $('#JOBID').append(JOBS);
                    $('#JOBID2').append(JOBS);
  
                            
                }
            });
    
}

// ******************************************************************************************
// * OBTIENE PHASE
// ******************************************************************************************
function getPhase(){   

    $('#PHASEID2').html('');
    $('#PHASEID2').prepend('<option value="-" selected>-</option>');

    function get(){

        var JOB  = $('#JOBID2').val(); 
        var datos= "url=ges_inventario/getPhaseList/"+ $('#JOBID2').val();
        var link= $('#URL').val()+"index.php";
    
        $.ajax({
                type: "GET",
                url: link,
                data: datos,
                success: function(res){
                   
                $('#PHASEID2').append(res);
                        
            }
        });
    }
    $.when(get()).done(function(res){  
        
                getBudget();
        
            });

}


// ******************************************************************************************
// * OBTIENE COST
// ******************************************************************************************
function getCost(){   

    function get(){

        var job  = $('#JOBID2').val();
        var phase= $('#PHASEID2').val();
        
        var datos= "url=ges_inventario/getCostList/"+job+"/"+phase;
        var link= $('#URL').val()+"index.php";
    
        $.ajax({
                type: "GET",
                url: link,
                data: datos,
                success: function(res){
                   
                $('#COSTID2').html(res);
                        
            }
        });
    }
    $.when(get()).done(function(res){  
        
                getBudget();
        
     });

}

// ******************************************************************************************
// * OBTIENE PRESUPUESTO ESTIMADO POR PROYECTO
// ******************************************************************************************
function getBudget(){

    var JOB  = $('#JOBID2').val();
    var PHASE= $('#PHASEID2').val();
    var COST = $('#COSTID2').val();
    
    if (PHASE == '-') { PHASE = 0}
    if (COST  == '-') { COST = 0}

    var datos= "url=ges_inventario/getBudget/"+JOB+'/'+PHASE+'/'+COST;
    var link= $('#URL').val()+"index.php";

    $.ajax({
            type: "GET",
            url: link,
            data: datos,
            success: function(res){
        
                $('#Budget').val(res);
                budgetCompare();
           
        }
    });



}

// ******************************************************************************************
// * INICIALIZA TBL ENTRADA MASIVA  (CHK = 1-ENTRADA NUEVO ITEM / 2- AJUSTE DE ITEM EXISTENTE 
// ******************************************************************************************
function init(chk){
 

    $('#items').html('loading...');

    if(chk==2){
   
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
            
            builtTbl(chk);
            
        });
   
    }
    if(chk==1){

       builtTbl(chk);
        
    }

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
        
            if(chk==1){ 

                reglon = '<td  width="10%" onkeyup="" contenteditable ></td>';  
                

            }else{

                reglon = '<td width="10%" >'+
                            '<select class="selectItems col-lg-12" id="sel'+i+'" onchange="SetDesc(this.value,'+i+')" >'+
                                '<option selected></option>'
                                +listitem+
                            '</select>'+
                        '</td>';  

                
               
            }        

            var line_table_req = '<tr>'+reglon+
                '<td width="15%" class="rowtable_req" onkeyup="checkTblChar(this.id)" '+editable+' '+color+' id="desc'+i+'"  ></td>'+
                '<td width="15%" class="rowtable_req" onkeyup="checkTblChar(this.id)" '+editable+' '+color+' id="unit'+i+'"  ></td>'+
                '<td width="3%"  class="rowtable_req  numb" onkeyup="checkTblChar(this.id)"  '+editable+' '+color+' id="upc'+i+'"   ></td>'+
                '<td width="5%"  class="rowtable_req  numb" onkeyup="checkTblChar(this.id)"  id="gl'+i+'" '+editable+' '+color+' ></td>'+
                '<td width="5%"  class="rowtable_req  numb" onkeyup="checkTblnum(this.id)"  id="tax'+i+'" '+editable+' '+color+'></td>'+
                '<td width="5%"  class="rowtable_req  numb" ><select id="SelStock'+i+'" class="form-control" onchange="locat(this.value,'+i+');">'+stocks+'</select></td>'+
                '<td width="3%"  class="rowtable_req  numb" ><select id="SelRoute'+i+'" class="form-control" ></select></td>'+
                '<td width="3%"  class="rowtable_req  numb" id="lote'+i+'"   onkeyup="checkTblChar(this.id)" contenteditable></td>'+                
                '<td width="3%"  class="rowtable_req  numb" id="fecha'+i+'"  onkeyup="checkTblChar(this.id)" contenteditable></td>'+                
                '<td width="5%"  class="rowtable_req  numb" onkeyup="checkTblPositive(this.id)" onfocusout="recalcular('+i+');" contenteditable id="qty'+i+'"></td>'+
                '<td width="5%"  class="rowtable_req  numb" onkeyup="checkTblnum(this.id)" onfocusout="calculate( '+i+');" contenteditable id="unitprice'+i+'" ></td>'+
                '<td width="5%"  class="rowtable_req  numb" '+color+' id="total'+i+'" ></td></tr>' ;
            i++
            
            $('#items').append(line_table_req); //limpio la tabla 
            }

        set_selectItemStyle(); 


}

// ******************************************************************************************
// * OBTIENE INFORMACION DE ITEM  
// ******************************************************************************************
function SetDesc(itemId, line){
    
    var id_desc_field = 'desc'+line;
    var id_unit_field = 'unit'+line;
    var id_price_field = 'unitprice'+line;
    var id_taxable_field = 'tax'+line;
    var id_gl_field = 'gl'+line;
    var id_qty_field = 'qty'+line;

    document.getElementById(id_desc_field).innerHTML = 'Loading...';
    
      /*  function GetStockbItem(){

            var url= "ges_inventario/getStockByItemID/";
            var link=  $('#URL').val()+"index.php";
        
        
            return $.ajax({
                    type: "GET",
                    url: link,
                    data: {url : url, itemID: itemId },
                    success: function(res){

                        console.log(res);
            
                        $("#SelStock"+line).html(res);
                
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
            document.getElementById(id_unit_field).innerHTML   = json.UnitMeasure;
           // document.getElementById(id_qty_field).innerHTML  = json.QtyOnHand;
            document.getElementById(id_price_field).innerHTML  = json.Price1;
            document.getElementById(id_gl_field).innerHTML  = json.GL_Sales_Acct;
            

            if(json.TaxType == 1){
    
                document.getElementById(id_taxable_field).innerHTML  = 'SI';
    
            }else{
    
                document.getElementById(id_taxable_field).innerHTML  = 'NO';
    
            }

           
    
            
        //});
   
    });
}


// ******************************************************************************************
// *OCULTAR COLUMNA 
// ******************************************************************************************
function hideCol(col) {
    
    var tbl = document.getElementById("table_ord_tb");

    if (tbl != null) {

  

        for (var i = 0; i < tbl.rows.length-1; i++) {
            
            for (var j = 0; j < tbl.rows[i].cells.length; j++) {

            tbl.rows[i].cells[j].style.display = "";

            if (j == col)

                tbl.rows[i].cells[j].style.display = "none";

            }
           

    }

    }

}


// ******************************************************************************************
// *CALCULOS DE TOTALES
// ******************************************************************************************
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
    
    //document.getElementById(totalID).innerHTML = parseFloat(total).toString().match(/^-?\d+(?:\.\d{0,2})?/)[0]; 
    document.getElementById(totalID).innerHTML = parseFloat(total).toFixed(5); 
    document.getElementById( PriceID).innerHTML =   parseFloat(UnitPrice ).toFixed(5);
    document.getElementById(qtyID).innerHTML =   parseFloat(qty).toFixed(5);
    
    sumar_total();
    
}
    
function sumar_total(){
    
    var theTbl = document.getElementById('table_ord_tb'); //objeto de la tabla que contiene los datos de items
    var total = [];
    var TOTAL = 0;

    total_field =   document.getElementById('total');
    
    for(var i=1; i<theTbl.rows.length ;i++) //BLUCLE PARA LEER LINEA POR LINEA LA TABLA theTbl
    {
    
      for(var j=0;j<theTbl.rows[i].cells.length; j++) //BLUCLE PARA LEER CELDA POR CELDA DE CADA LINEA
    
            {       
    
                switch (j){
    
                       case 12:
                       
                        total.push(theTbl.rows[i].cells[12].innerHTML);
    
                        break;
    
                }
    
               }//FIN BLUCLE PARA LEER CELDA POR CELDA DE CADA LINEA
    
    }//FIN BLUCLE PARA LEER LINEA POR LINEA DE LA TABLA
    

    
   for(var i=0; i<total.length; i++){
    
        TOTAL  += Number(total[i]);
    
    }

    total_field.value   =  parseFloat(TOTAL).toFixed(5);

   
    budgetCompare();
    
   
    
}
// ******************************************************************************************
// *CALCULOS DE TOTALES
// ******************************************************************************************

// ******************************************************************************************
// *COMPARA PRESUPUESTO
// ******************************************************************************************
function budgetCompare() {

    MSG_ERROR_RELEASE();
   
    if($("#JOBID2").val() != '-'){

   total_field =   document.getElementById('total');
    
  
   
   var budget = $('#Budget').val();
   budget = Number(budget);
   
   var total  =  Number(total_field.value);

   var exceed = total - budget ;

   if (total > budget){

     MSG_ERROR('EL total del costo excede el presupuesto para este proyecto en '+exceed+' $');
     $('#proc_lote').attr("disabled", "disabled");
   
    }else{

    $('#proc_lote').removeAttr("disabled");
   }
   
}


}



// ******************************************************************************************
// *COMPARA PRESUPUESTO
// ******************************************************************************************


//******************************************************************************************
//SEND ENTRADA DE MATERIALES
//******************************************************************************************
function proceed(){

    switch (type) {

        case 1:
        
        individual();

            break;
        
        case 2:
        
        cargaLayout();

            break;
        
        case 3:
        
        masiva();

            break;
    
        default:
            break;
    }



 }
    // ******************************************************************************************
    // ENVIO INDIVIDUAL
    // ******************************************************************************************
    function individual(){ 

    }
    // ******************************************************************************************
    // ENVIO INDIVIDUAL
    // ******************************************************************************************

    // ******************************************************************************************
    // CARGA DE LAYOUT
    // ******************************************************************************************
    function cargaLayout(){ 
        
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
                 data:  {url: 'ges_ventas/set_sales_order_detail_new/'+OS_NO , Data : JSON.stringify(LineArray)}, 
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
    // CARGA DE LAYOUT
    // ******************************************************************************************

    // ******************************************************************************************
    // ENVIO MASIVO
    // ******************************************************************************************
    function masiva(){ 
        
    }
    // ******************************************************************************************
    // ENVIO MASIVO
    // ******************************************************************************************

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
        
                var selid = "sel"+i;
                var stockId = 'SelStock'+i;
                var locId = 'SelRoute'+i;
                
        
                if(document.getElementById(selid).value !=''){
        
                      switch (j){
        
                            case 0:
    
                                itemId    = document.getElementById(selid).value;
  
                                stockId   = document.getElementById(selid).value;
                                locId     = document.getElementById(selid).value;

                                qty       = theTbl.rows[i].cells[5].innerHTML;
                                UnitPrice = theTbl.rows[i].cells[6].innerHTML;
                                total     = theTbl.rows[i].cells[7].innerHTML;
                                lote      = theTbl.rows[i].cells[7].innerHTML;
                                fechaVen  = theTbl.rows[i].cells[7].innerHTML;
                               
                                                              
                                if( stockId==0 || stockId==0){
                                    
                                    
                                }
                                
                                
                                //agrego el registo de las demas columnas
                                cell += '@'+itemId+
                                        '@'+UnitPrice+
                                        '@'+qty+
                                        '@'+total+
                                        '@'+stockId+
                                        '@'+locId+
                                        '@'+lote+
                                        '@'+fechaVen;
    
                                if( stockId==0){
                                    FaltaArray[6] = i ;
                                }   

                                if(stockId==0) {   
                                    FaltaArray[7] = i ;
                                }

                            
                                break;
    
                            default: 

                            if (j!=6 || j!=7){
                                
                                val= theTbl.rows[i].cells[j].innerHTML;
                                
                                                            if(val==''){                              
                                                                FaltaArray[j] = i ;
                                                            }


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
    // ******************************************************************************************
    // CONSTRUYE ARRAY CON ITEMS 
    // ******************************************************************************************


//******************************************************************************************
//SEND ENTRADA DE MATERIALES
//******************************************************************************************

//******************************************************************************************
//VALIDACION DE CONTENIDO
//******************************************************************************************
function validacion(){
  
   /* CUSTOMER = document.getElementById('customer').value;
    if (CUSTOMER == ''){
        MSG_ERROR('Se debe seleccionar un cliente',0);
        CHK_VALIDATION = true;
    }*/
    
}
//******************************************************************************************
//VALIDACION DE CONTENIDO
//******************************************************************************************

//******************************************************************************************
//VALIDACION DE CONTENIDO
//******************************************************************************************
function FIND_COLUMN_NAME(item){
    
    var theTbl = document.getElementById('table_ord_tb');

    var val = theTbl.rows[0].cells[item].innerHTML;
    return val;
    }
//******************************************************************************************
//VALIDACION DE CONTENIDO
//******************************************************************************************