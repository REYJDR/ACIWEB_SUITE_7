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
    var JOBS = '';
    var PHASES = '';
    var COST = '';
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
    
   // cls = ['.selectJob','.selectOc']
    set_selectWidth('selectJob');
    set_selectWidth('selectOc');
 
    

    $('#prod_ind').hide();
    $('#prod_masive').hide();
    $('#prod_layout').hide(); 
    $('#invDetail').show();  
    

    MSG_ADVICE('LOADING...');

    var TaxID=$("#taxid option:selected").html();
    var Taxval=$("#taxid option:selected").val();
    
    set_taxid(Taxval,1);

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
                editable = 'contenteditable';
                color  = "";

                    $box2.prop("checked", false);
                    init(2);//construye tabla
                   // init(1);//construye tabla
                    $('#invDetail').show(); 
               }

            });
           
            $('#vendorID').on("change", function (e){
                
                    getOC($('#vendorID').val());
                                
            });

            $('#vendorOC').on("change", function (e){
                
                    getOCitem($('#vendorOC').val());
                                
            });


            $('#JOBID2').on("change", function (e){

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

                function getPhase(){

                    return phase();
                }
                $.when(getPhase()).done(function(){ //ESPERA QUE TERMINE el query de items
                    
                    function getCost(){
                        
                        return cost();
                    }
                    $.when(getCost()).done(function(){ //ESPERA QUE TERMINE el query de items
                        
                        
                        init(2);//construye tabla
                        
                    });
                   
                    
                });

                
               
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
                    async: false,
                    success: function(res){
                    
                    JOBS = res;
                    $('#JOBID').append(JOBS);
                    $('#JOBID2').append(JOBS);
  
                            
                }
            });
    
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
           async: false,
           success: function(res){
    
           PHASES = res;
          
    
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
             async: false,
             success: function(res){
     
             COST = res;                  
              
            }
        });
        
     /*cost*/
     
     }

// ******************************************************************************************
// * OBTIENE PRESUPUESTO ESTIMADO POR PROYECTO
// ******************************************************************************************
function getBudget(){

    var JOB  = $('#JOBID2').val();

    
   // var PHASE= $('#PHASEID2').val();
   // var COST = $('#COSTID2').val();
    
 //   //console.log(JOB,PHASE,COST);

/*    if (PHASE == '-' || PHASE  ==  null) { PHASE = 0}
    if (COST  == '-' || COST  ==  null) { COST = 0}

    var datos= "url=ges_inventario/getBudget/"+JOB+'/'+PHASE+'/'+COST;*/
    if(JOB != '-'){
      
        var datos= "url=ges_inventario/getBudget/"+JOB;
        
        var link= $('#URL').val()+"index.php";

        $.ajax({
                type: "GET",
                url: link,
                data: datos,
                async: false,
                success: function(res){
                    
                    $('#Budget').val(res);
                    budgetCompare();
            
            }
        });

    }else{

        $('#Budget').val('');

    }

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
    var display ='display:none;'; 

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
                '<td width="15%" class="rowtable_req" '+editable+' '+color+'   id="unit'+i+'"  ></td>'+             
             //   '<td width="15%" class="rowtable_req" onkeyup="checkTblChar(this.id)" '+editable+' '+color+' id="unit'+i+'"  ></td>'+
                '<td width="5%"  class="rowtable_req  numb" style="'+display+'" onkeyup="checkTblnum(this.id)"  id="tax'+i+'" '+editable2+' '+color2+'></td>'+
                '<td width="5%"  class="rowtable_req  numb" onkeyup="checkTblPositive(this.id)" onfocusout="recalcular('+i+');" '+editable2+' '+color2+' id="qtyord'+i+'"></td>'+ 
                '<td width="5%"  class="rowtable_req  numb" onkeyup="checkTblPositive(this.id)" onfocusout="recalcular('+i+');" contenteditable id="qty'+i+'"></td>'+
                '<td width="5%"  class="rowtable_req  numb" onkeyup="checkTblnum(this.id)" onfocusout="calculate( '+i+');" contenteditable id="unitprice'+i+'" ></td>'+
                '<td width="5%"  class="rowtable_req  numb" '+color+' id="total'+i+'" ></td>' +
                '<td width="15%" class="rowtable_req" ><select class="selectItems col-lg-12" id="phase'+i+'"  ><option  value="" selected>-</option>'+PHASES+'</select></td>'+
                '<td width="15%" class="rowtable_req" ><select class="selectItems col-lg-12" id="cost'+i+'" ><option  value="" selected>-</option>'+COST+'</select></td>'+
                '<td width="5%"  class="rowtable_req  numb" style="'+display+'" onkeyup="checkTblnum(this.id)"  id="gl'+i+'" '+editable2+' '+color2+'></td></tr>';
                ;

                     
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
  
    var qtyord = 'qtyord'+line;
    var id_qty_field = 'qty'+line;
    var id_total = 'total'+line;
    var phase = '#phase'+line;
    var cost = '#cost'+line;
    


       if(itemId == ''){

        document.getElementById(id_desc_field).innerHTML  = '';
        document.getElementById(id_unit_field).innerHTML   = '';
        document.getElementById(id_qty_field).innerHTML  = '';
        document.getElementById(id_price_field).innerHTML  = '';
        //document.getElementById(id_gl_field).innerHTML     = '';
        document.getElementById(qtyord).innerHTML  = '';
        document.getElementById(id_taxable_field).innerHTML  = '';
        document.getElementById(id_total).innerHTML  = '';
        
        $(phase).select2("val", '-'); //set the value
        $(cost).select2("val", '-'); //set the value



       }  else{


        document.getElementById(id_desc_field).innerHTML = 'Loading...';
        
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
                        
                document.getElementById(id_desc_field).innerHTML   = json.Description;
                document.getElementById(id_unit_field).innerHTML   = json.UnitMeasure;
                //document.getElementById(id_qty_field).innerHTML    = json.QtyOnHand;
                document.getElementById(id_price_field).innerHTML  = json.Price1;
                //document.getElementById(id_gl_field).innerHTML     = json.GL_Sales_Acct;
                document.getElementById(id_taxable_field).innerHTML  = json.TaxType;

    
        });
       }  
 
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
    
                       case 6:
                  
                       if(document.getElementById(taxableID).innerHTML==1){
                    
                        itbms_sum = Number(theTbl.rows[i].cells[6].innerHTML) * Number(tax_value);
                        itbms.push(itbms_sum);
    
                        }
                       
                        total.push(theTbl.rows[i].cells[6].innerHTML);
    
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
     
   ////console.log(Type);

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

        MSG_ERROR_RELEASE();
        $('#ERROR').hide();

       var data =  $("form").serialize()+'&url=ges_inventario/addItem';

       //console.log(data);
       $.ajax({
        type: "GET",
        url: link,
        async: false,
        data: data,
        success: function(res){

             if(res == 0){

                MSG_ERROR('Item already exist, please try another ID',0);

             }else{

                if(res.indexOf('ERROR') != -1){
                    
                    MSG_ERROR(res,0);
                    
                }else{
                   alert('Item added successfully');

                   location.reload(true);
            
                }

             }
        }
        });

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
                    var oc = document.getElementById('vendorOC').value;
            
                            //REGISTRO DE CABECERA
                    
                        function set_header(){
                        
                        //INI REGISTRO DE CABECERA
                        HeaderInfo[0] =  fact_id+
                                        '@'+fecha+
                                        '@'+vend_id+
                                        '@'+oc+
                                        '@'+total;
                        
            
                        return  $.ajax({
                                type: "GET",
                                url: link,
                                async: false,
                                data: {url: 'ges_inventario/set_Purchase_Header', Data : JSON.stringify(HeaderInfo)},
                                success: function(res){
                                //console.log(res);
                            
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
                            async: false,
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

                //*AJUSTE DE MATERIAL
                var selid   = "sel"+i;
                var phaseid = "phase"+i;
                var costid  = "cost"+i;
                
                if(document.getElementById('adjust').checked != true){
           
                  if(document.getElementById(selid).value !=''){ 
                    
                                switch (j){
                                        case 0:
                                            
                                            itemId    = document.getElementById(selid).value;
                                            desc      = theTbl.rows[i].cells[1].innerHTML;
                                            gl        = theTbl.rows[i].cells[9].innerHTML;
                                            tax       = theTbl.rows[i].cells[2].innerHTML;
                                            qty       = theTbl.rows[i].cells[4].innerHTML;
                                            UnitPrice = theTbl.rows[i].cells[5].innerHTML;
                                            total     = theTbl.rows[i].cells[6].innerHTML;
                                            
                                                                                       
                                            job       = document.getElementById('JOBID2').value;
                                            phase     = document.getElementById(phaseid).value;
                                            cco       = document.getElementById(costid).value;

                    
                    
                                            //agrego el registo de las demas columnas
                                            cell += '@'+itemId+
                                                    '@'+desc+
                                                    '@'+gl+
                                                    '@'+job+
                                                    '@'+phase+
                                                    '@'+cco+
                                                    '@'+qty+
                                                    '@'+UnitPrice+
                                                    '@'+total;
        
        
                                        //console.log(cell);
                
                                        /*if( stockId==0){
                                                FaltaArray[6] = i ;
                                            }   
        
                                            if(stockId==0) {   
                                                FaltaArray[7] = i ;
                                            }*/
        
                                            break;
            
                                            default: 
        
                                            if (j==5 || j==6 || j==7 ){
                                                
                                                
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
                                desc      = theTbl.rows[i].cells[1].innerHTML;
                                gl        = theTbl.rows[i].cells[9].innerHTML;
                                tax       = theTbl.rows[i].cells[2].innerHTML;
                                qty       = theTbl.rows[i].cells[4].innerHTML;
                                UnitPrice = theTbl.rows[i].cells[5].innerHTML;
                                total     = theTbl.rows[i].cells[6].innerHTML;
                                
                                                                           
                                job       = document.getElementById('JOBID2').value;
                                phase     = document.getElementById(phaseid).value;
                                cco       = document.getElementById(costid).value;

        
        
                                //agrego el registo de las demas columnas
                                cell += '@'+itemId+
                                        '@'+desc+
                                        '@'+gl+
                                        '@'+job+
                                        '@'+phase+
                                        '@'+cco+
                                        '@'+qty+
                                        '@'+UnitPrice+
                                        '@'+total;

                                //console.log(cell);
        
                                /*if( stockId==0){
                                        FaltaArray[6] = i ;
                                    }   

                                    if(stockId==0) {   
                                        FaltaArray[7] = i ;
                                    }*/

                                    break;
    
                                    default: 

                                        if (j==5 || j==6 || j==7 ){
                                            
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


        
                //INSERTA valor de CELL en el arreglo 
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
    return '('+item+') '+val;
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


//******************************************************************************************
//obtiene OC por vendor
//******************************************************************************************

function getOC(vendor){
    
    $('#vendorOC').html('Getting PO...');
    $('#vendorOC').prepend('<option value="-" selected>-</option>');
    $('#vendorOC').select2('val','-');

    $.ajax({
        type: "GET",
        url: link,
        data: {url: 'ges_compras/PO_filter_by_Vendor/'+vendor},
        success: function(res){
       // //console.log(res);
    
       $('#vendorOC').append(res);
       

    }
});

}
//******************************************************************************************
//obtiene OC por vendor
//******************************************************************************************

//******************************************************************************************
//obtiene detalles del OC
//******************************************************************************************

function getOCitem(oc){ 

    if(oc != '-' || oc != '')
    init(2);
    var theTbl = document.getElementById('table_ord_tb'); //objeto de la tabla que contiene los datos de items
    var jobSel   = '#JOBID2 option:selected';
    var job      = '#JOBID2';

    $(job).select2("val", '-');
    $('#Budget').val('');

    var datos= "bridge_query/get_ProductsInfo";
    var link= $('#URL').val()+"index.php";

    $.ajax({
        type: "GET",
        url: link,
        dataType: 'json',
        data: {url: 'ges_compras/PO_item/'+oc},
        success: function(res){

          
        for(var m=0;m<res.length;m++){

 
            JSON.parse(res[m]).AccountID

            i = m + 1 ;
            var  selid = '#sel'+i;
            var  phase = '#phase'+i;
            var  cost  = '#cost'+i;
            var  gl = 'gl'+i;
            

            
                if(JSON.parse(res[m]).JobID != ''){
                    //console.log($(jobSel).text());

                    if($(jobSel).text() == '-') {
                        $(job).select2("val", JSON.parse(res[m]).JobID); //set the value
                        getBudget();
                    }
                } 


                itemId = JSON.parse(res[m]).Item_id;

                $(selid).select2("val",  itemId); //set the value
                $(phase).select2("val", JSON.parse(res[m]).JobPhaseID); //set the value
                $(cost).select2("val", JSON.parse(res[m]).JobCostCodeID); //set the value
                
                function getDesc(){
            
                        return $.ajax({
                                type: "GET",
                                url: link,
                                async: false,
                                data: {url: datos, item: itemId},
                                success: function(x){
                        
                            }
                        
                        });
            
                }   
                $.when(getDesc()).done(function(x){ //ESPERA QUE TERMINE LA INSERCION DE CABECERA
                    
                    xjson = JSON.parse(x);
                    
                    theTbl.rows[i].cells[1].innerHTML =xjson.Description;
                    theTbl.rows[i].cells[2].innerHTML =xjson.TaxType;
    
                    theTbl.rows[i].cells[3].innerHTML = JSON.parse(res[m]).Quantity;
                    theTbl.rows[i].cells[4].innerHTML = JSON.parse(res[m]).Quantity;
                    theTbl.rows[i].cells[5].innerHTML = JSON.parse(res[m]).Unit_Price;
                    theTbl.rows[i].cells[9].innerHTML = JSON.parse(res[m]).AccountID;
                    recalcular(i);
                } );
                
        
        }

    }
    });
//set_selectWidth(cls=['.selectItems']);

}


//******************************************************************************************
//obtiene detalles del OC
//******************************************************************************************


