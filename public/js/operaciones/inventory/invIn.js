/////////////////////////////////////////////////////////////////////////////////////////////////
//valiable globales
/////////////////////////////////////////////////////////////////////////////////////////////////
    var editable = 'contenteditable';
    var stocks = '';
    var Type = '';
    var listitem = '';
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
        set_div(1);

        

    });

   

});


// ********************************************************
// * Aciones cuando la pagina incia|
// ******************************************************** 
document.addEventListener('DOMContentLoaded', function() {

    
          //ALTERNA LA SELECCION DE LOS CHECKBOX, PARA NO TENER DOS CHECKBOX SELECCIONADOS AL MISMO TIEMPO
            $("input:checkbox").on('click', function() {
              
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
                var $box = $(this);
                if ($box.is(":checked")) {

                init(2);//construye tabla
                editable = '';
               }else{
                init(1);//construye tabla
               }

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
// * OBTIENE JOBS 
// ******************************************************************************************
function jobs(){   

    var datos= "url=ges_requisiciones/get_JobList";
    var link= $('#URL').val()+"index.php";

        $.ajax({
            type: "GET",
            url: link,
            data: datos,
            success: function(res){

            JOBS = res;

            $('#JOBID').append(JOBS);
                    
        }
    });
    
}

// ******************************************************************************************
// * INICIALIZA TBL ENTRADA MASIVA  (CHK = 1-ENTRADA NUEVO ITEM / 2- aJUSTE DE ITEM EXISTENTE 
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
                       console.log('done item list');
           
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
                '<td width="15%" class="rowtable_req" onkeyup="checkTblChar(this.id)" '+editable+' id="desc'+i+'"  ></td>'+
                '<td width="15%" class="rowtable_req" onkeyup="checkTblChar(this.id)" '+editable+' id="unit'+i+'"  ></td>'+
                '<td width="3%"  class="rowtable_req  numb" onkeyup="checkTblChar(this.id)"  '+editable+' id="upc'+i+'"   ></td>'+
                '<td width="5%"  class="rowtable_req  numb" onkeyup="checkTblChar(this.id)"  id="gl'+i+'" ></td>'+
                '<td width="5%"  class="rowtable_req  numb" onkeyup="checkQtyInput(this.id)"  id="tax'+i+'" ></td>'+
                '<td width="5%"  class="rowtable_req  numb" ><select id="SelStock'+i+'" class="form-control" onchange="locat(this.value,'+i+');">'+stocks+'</select></td>'+
                '<td width="3%"  class="rowtable_req  numb" ><select id="SelRoute'+i+'" class="form-control" ></select></td>'+
                '<td width="5%"  class="rowtable_req  numb" onkeyup="checkQtyInput(this.id)" onfocusout="recalcular('+i+');" contenteditable id="qty'+i+'"></td>'+
                '<td width="5%"  class="rowtable_req  numb" onkeyup="checkQtyInput(this.id)" onfocusout="calculate( '+i+');" contenteditable id="unitprice'+i+'" ></td>'+
                '<td width="5%"  class="rowtable_req  numb" id="total'+i+'" ></td></tr>' ;
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
    
        function GetStockbItem(){

            var url= "ges_inventario/getStockByItemID/";
            var link=  $('#URL').val()+"index.php";
        
        
            return $.ajax({
                    type: "GET",
                    url: link,
                    data: {url : url, itemID: itemId },
                    success: function(res){
            
                        $("#SelStock"+line).html(res);
                
                        }
                });

        }
    
        $.when(GetStockbItem()).done(function(res){ //ESPERA QUE TERMINE el query de items
            
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

            GetStockbItem(itemId,line);
    
            
        });
   
    });
}