/////////////////////////////////////////////////////////////////////////////////////////////////
//valiable globales
/////////////////////////////////////////////////////////////////////////////////////////////////
    var editable = 'contenteditable';
    var editable2 = '';
    var stocks = '';
    var Type = '';
    var listitem = '';
    var color = '';
    var color2 = "style='background-color:#ECECEC;'";
    
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
    

    $('#prod_ind').hide();
    $('#prod_masive').hide();
    $('#prod_layout').hide(); 
    $('#invDetail').show();  
    

    MSG_ADVICE('LOADING...');

    var TaxID=$("#taxid option:selected").html();
    var Taxval=$("#taxid option:selected").val();
    
    set_taxid(Taxval,1);

    
 /*   function GetStockList(){


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
            return set_div(3);
        } 
        $.when(setDiv()).done(function(){ 

            jobs();
            
        });
            

    });*/

    function getJobs(){

      return  jobs();
    }
    $.when(getJobs()).done(function(){ 

        $('#ERROR').hide();
        
        //setea por defaul el valor 1 para mostrar el div de crear nueva lista de precios 
        
        function setDiv() {
            return set_div(3);
        } 
        $.when(setDiv()).done(function(){ 

           vendors();
            
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
                    color  = "style='background-color:#ECECEC;'";
                    
                    init(2);//construye tabla
                   
                    $('#invDetail').hide(); 

               }else{
                

                    $box2.prop("checked", false);
                    init(2);//construye tabla
                   // init(1);//construye tabla
                    $('#invDetail').show(); 
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
               // init(1);//construye tabla
                init(2);//construye tabla
               
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
// * OBTIENE VENDOR LIST
// ******************************************************************************************
function vendors(){   
    
    
        var datos= "url=ges_inventario/getVendorList";
        var link= $('#URL').val()+"index.php";
    
          return   $.ajax({
                        type: "GET",
                        url: link,
                        data: datos,
                        success: function(res){
                        
                        $('#vendorID').append(res);
      
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
    
    console.log(JOB,PHASE,COST);

    if (PHASE == '-' || PHASE  ==  null) { PHASE = 0}
    if (COST  == '-' || COST  ==  null) { COST = 0}

    var datos= "url=ges_inventario/getBudget/"+JOB+'/'+PHASE+'/'+COST;
    var link= $('#URL').val()+"index.php";

    $.ajax({
            type: "GET",
            url: link,
            data: datos,
            success: function(res){
                console.log('budget:'+res);
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
               // '<td width="3%"  class="rowtable_req  numb" onkeyup="checkTblChar(this.id)"  '+editable+' '+color+' id="upc'+i+'"   ></td>'+
                '<td width="5%"  class="rowtable_req  numb" onkeyup="checkTblChar(this.id)"  id="gl'+i+'" '+editable2+' '+color2+' ></td>'+
                '<td width="5%"  class="rowtable_req  numb" onkeyup="checkTblnum(this.id)"  id="tax'+i+'" '+editable2+' '+color2+'></td>'+
               /* '<td width="5%"  class="rowtable_req  numb" ><select id="SelStock'+i+'" class="form-control" onchange="locat(this.value,'+i+');">'+stocks+'</select></td>'+
                '<td width="3%"  class="rowtable_req  numb" ><select id="SelRoute'+i+'" class="form-control" ></select></td>'+
                '<td width="3%"  class="rowtable_req  numb" id="lote'+i+'"   onkeyup="checkTblChar(this.id)" contenteditable></td>'+                
                '<td width="3%"  class="rowtable_req  numb" id="fecha'+i+'"  onkeyup="checkTblChar(this.id)" contenteditable></td>'+    */            
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


       if(itemId == ''){

        document.getElementById(id_desc_field).innerHTML  = '';
        document.getElementById(id_unit_field).innerHTML   = '';
        document.getElementById(id_qty_field).innerHTML  = '';
        document.getElementById(id_price_field).innerHTML  = '';
        document.getElementById(id_gl_field).innerHTML     = '';
        document.getElementById(id_taxable_field).innerHTML  = '';



       }  else{


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
                document.getElementById(id_gl_field).innerHTML     = json.GL_Sales_Acct;
                
    
                if(json.TaxType == 1){
        
                    document.getElementById(id_taxable_field).innerHTML  = 'SI';
        
                }else{
        
                    document.getElementById(id_taxable_field).innerHTML  = 'NO';
        
            }
    
        });
       }  
    
        
        //});   
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
    var itbms = [];

    total_field    = document.getElementById('total');
    subtotal_field = document.getElementById('subtotal');
    tax_field      = document.getElementById('tax'); 
    tax_value      = document.getElementById('saletaxid').value;

    
    for(var i=1; i<theTbl.rows.length ;i++) //BLUCLE PARA LEER LINEA POR LINEA LA TABLA theTbl
    {
       var  taxableID = 'tax'+i;
      for(var j=0;j<theTbl.rows[i].cells.length; j++) //BLUCLE PARA LEER CELDA POR CELDA DE CADA LINEA
    
            {       
    
                switch (j){
    
                       case 7:
                    
                       if(document.getElementById(taxableID).value=='SI'){
                    
                        itbms_sum = ( Number(theTbl.rows[i].cells[j].innerHTML) * Number(theTbl.rows[i].cells[5].innerHTML) ) * Number(tax_value);
                        itbms.push(itbms_sum);
    
                        }
                       
                        total.push(theTbl.rows[i].cells[7].innerHTML);
    
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
    
 /*  for(var i=0; i<total.length; i++){
    
        TOTAL  += Number(total[i]);
    
    }*/

    TOTAL =  subtotal+ TAX;

    subtotal_field.value = parseFloat(subtotal).toFixed(2);;
    tax_field.value      = parseFloat(TAX).toFixed(2);; 
    total_field.value   =  parseFloat(TOTAL).toFixed(2);

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
     
    console.log(Type);

    switch (Type) {

        case 1:
        
        individual();

            break;
        
        case 2:
        
        

            break;
        
        case 3:
        
         entradaLote(); 

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
    // ENTRADA POR LOTE
    // ******************************************************************************************
    function entradaLote(){ 
        
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
              
                if(document.getElementById('adjust').checked != true){

                    var fact_id= document.getElementById('invoice').value;
                    var fecha = document.getElementById('fecha').value;
                    var vend_id = document.getElementById('vendorID').value;
                    var total = document.getElementById('total').value;
                    
            
                            //REGISTRO DE CABECERA
                    
                        function set_header(){
                        
                        //INI REGISTRO DE CABECERA
                        HeaderInfo[0] =  fact_id+
                                        '@'+fecha+
                                        '@'+vend_id+
                                        '@'+total;
                        
            
                        return  $.ajax({
                                type: "GET",
                                url: link,
                                data: {url: 'ges_inventario/set_Purchase_Header', Data : JSON.stringify(HeaderInfo)},
                                success: function(res){
                                console.log(res);
                            
                                if(res.indexOf('ERROR') != -1){
            
                                    MSG_ERROR(res);
                                    
                                }else{
            
                                    OS_NO = res;
                                
                                 }
            
                            }
                        });
                    
                        }//FIN REGISTRO DE CABECERA
                    
                        $.when(set_header()).done(function(OS_NO){ //ESPERA QUE TERMINE LA INSERCION DE CABECERA
                    
                        if(OS_NO!=''){
                            
                        //REGISTROS DE ITEMS 
                            $.ajax({
                            type: "GET",
                            url:  link,
                            data:  {url: 'ges_inventario/set_Purchase_Detail/'+OS_NO , Data : JSON.stringify(LineArray)}, 
                            success: function(res){
            
                            
                            if(res==1){//TERMINA EL LLAMADO AL METODO set_req_items SI ESTE DEVUELV UN '1', indica que ya no hay items en el array que procesar.
                                //checkSOIns(link,OS_NO);
                                msg(link,OS_NO);
                            }else{
            
                                MSG_ERROR(res,0);
                            }
                            }
                    
                            });
                            return false; 
                        }
                        //FIN REGISTROS DE ITEMS     
                        });
                



                }else{

                    //REGISTROS DE ITEMS 
                    $.ajax({
                        type: "GET",
                        url:  link,
                        data:  {url: 'ges_inventario/setInventoryAdjustment/', Data : JSON.stringify(LineArray)}, 
                        success: function(res){
        
                        if(res.indexOf('ERROR') != -1){
                        
                            MSG_ERROR(res,0);
                        
                        }else{//TERMINA EL LLAMADO AL METODO set_req_items SI ESTE DEVUELV UN '1', indica que ya no hay items en el array que procesar.
                            //checkSOIns(link,OS_NO);
                            msg(link,res);
                        }

                        }
                
                        });

                    
                }
                
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
    // ENTRADA POR LOTE
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
        
                /*
                var stockId = 'SelStock'+i;
                var locId = 'SelRoute'+i; */
                
                if(document.getElementById('adjust').checked != true){
           
                  if(theTbl.rows[i].cells[0].innerHTML !=''){ 
                    
                                switch (j){
                    
                                        case 0:
                                            
                                            itemId    = theTbl.rows[i].cells[0].innerHTML;
                                            desc      = theTbl.rows[i].cells[1].innerHTML;
                                            unit      = theTbl.rows[i].cells[2].innerHTML;
                                            gl        = theTbl.rows[i].cells[3].innerHTML;
                                            tax       = theTbl.rows[i].cells[4].innerHTML;
   
                                        /*  stockId   = document.getElementById(selid).value;
                                            locId     = document.getElementById(selid).value;*/ 
                                  
                                        /*  lote      = theTbl.rows[i].cells[7].innerHTML;
                                            fechaVen  = theTbl.rows[i].cells[7].innerHTML;*/
                                                        
                                            qty       = theTbl.rows[i].cells[5].innerHTML;
                                            UnitPrice = theTbl.rows[i].cells[6].innerHTML;
                                            total     = theTbl.rows[i].cells[7].innerHTML;
                                            
                                                                                       
                                            job       = document.getElementById('JOBID2').value;;
                                            phase     = document.getElementById('PHASEID2').value;;
                                            cco       = document.getElementById('COSTID2').value;;

                                            //agrego el registo de las demas columnas
                                            cell += '@'+itemId+
                                                    '@'+desc+
                                                    '@'+unit+
                                                    '@'+gl+
                                                    '@'+job+
                                                    '@'+phase+
                                                    '@'+cco+
                                                    '@'+tax+
                                                    '@'+qty+
                                                    '@'+UnitPrice+
                                                    '@'+total;
        
        
                                        console.log(cell);
                
                                        /*if( stockId==0){
                                                FaltaArray[6] = i ;
                                            }   
        
                                            if(stockId==0) {   
                                                FaltaArray[7] = i ;
                                            }*/
        
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
                
        


                }else{

                //*AJUSTE DE MATERIAL
                var selid = "sel"+i;
                
                if(document.getElementById(selid).value !=''){ 
        
                        switch (j){
            
                                case 0:
        
                                    itemId    = document.getElementById(selid).value;
    
                               /*   stockId   = document.getElementById(selid).value;
                                    locId     = document.getElementById(selid).value;*/ 
                                                                
                                    gl_acc    = theTbl.rows[i].cells[3].innerHTML;                                    
                                    qty       = theTbl.rows[i].cells[5].innerHTML;
                                    UnitPrice = theTbl.rows[i].cells[6].innerHTML;
                                    total     = theTbl.rows[i].cells[7].innerHTML;
                                    jobId       = document.getElementById('JOBID2').value;;
                                    phaseid     = document.getElementById('PHASEID2').value;;
                                    costcodeID       = document.getElementById('COSTID2').value;;
                                
                               /*   lote      = theTbl.rows[i].cells[7].innerHTML;
                                    fechaVen  = theTbl.rows[i].cells[7].innerHTML;*/
                                    
                                    
                                    //agrego el registo de las demas columnas
                                    cell += '@'+itemId+
                                            '@'+UnitPrice+
                                            '@'+qty+
                                            '@'+total+
                                            '@'+jobId+
                                            '@'+phaseid+
                                            '@'+costcodeID+
                                            '@'+gl_acc;

                                            
                                console.log(cell);
        
                                /*if( stockId==0){
                                        FaltaArray[6] = i ;
                                    }   

                                    if(stockId==0) {   
                                        FaltaArray[7] = i ;
                                    }*/

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
        
            }
            if(document.getElementById('adjust').checked != true){
                //INSERTA valor de CELL en el arreglo 
            if(theTbl.rows[i].cells[0].innerHTML != '' ){
                LineArray[i]=cell; 
                }        
        
            }else{
            //INSERTA valor de CELL en el arreglo 
            if(document.getElementById(selid).value !=''){
                LineArray[i]=cell; 
                }

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
//SEND ENTRADA DE MATERIALES
//******************************************************************************************

//******************************************************************************************
//VALIDACION DE CONTENIDO
//******************************************************************************************
function validacion(){
  
    if(Type == 3){
       
        if(document.getElementById('adjust').checked != true){

            if (document.getElementById('invoice').value == ''){
                MSG_ERROR('Se debe indicar un número de factura',0);
                CHK_VALIDATION = true;
            }

            if (document.getElementById('fecha').value == ''){

                MSG_ERROR('Se debe indicar la fecha de factura',0);
                CHK_VALIDATION = true;
            }

            if (document.getElementById('vendorID').value == '-'){

                MSG_ERROR('Se debe indicare el proveedor',0);
                CHK_VALIDATION = true;
            }
        }
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
//busca nombre de columna
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
//busca nombre de columna
//******************************************************************************************

//******************************************************************************************
//setea el rate del tax seleccionado
//******************************************************************************************

function set_taxid(rate){
    
        var rate = rate/100;    
        document.getElementById('saletaxid').value =  rate;
        
        sumar_total();
}
//******************************************************************************************
//setea el rate del tax seleccionado
//******************************************************************************************
