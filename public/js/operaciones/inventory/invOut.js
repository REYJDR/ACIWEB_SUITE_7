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
   // init();
    jobs();
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
                '<td width="15%" class="rowtable_req" onkeyup="checkTblChar(this.id)" '+editable2+' '+color2+' id="unit'+i+'"  ></td>'+     
                '<td width="3%"  class="rowtable_req numb" id="lote'+i+'" ></td>'+
                '<td width="3%"  class="rowtable_req numb" id="loc'+i+'"  ></td>'+   
                '<input type="hidden"  id="stock'+i+'"/>'+
                '<td width="5%"  class="rowtable_req  numb" onkeyup="checkTblPositive(this.id);"  onfocusout="checkMax('+i+');"    contenteditable id="qty'+i+'"></td>'+
                '<td width="15%" class="rowtable_req" ><select class="selectItems col-lg-12" id="PHS'+i+'" ><option  value="" selected>-</option>'+PHASES+'</select></td>'+
                '<td width="15%" class="rowtable_req" ><select class="selectItems col-lg-12" id="COST'+i+'"><option  value="" selected>-</option>'+COST+'</select></td>'+
               
          
                //     '<td width="5%"  class="rowtable_req  numb" onkeyup="checkTblPositive(this.id)" onfocusout="recalcular('+i+');" contenteditable id="qty'+i+'"></td>'+
           //     '<td width="5%"  class="rowtable_req  numb" onkeyup="checkTblnum(this.id)" onfocusout="calculate( '+i+');" contenteditable   id="unitprice'+i+'" ></td>'+
           //'<td width="5%"  class="rowtable_req  numb" '+color+' id="total'+i+'" ></td></tr>' ;
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
    var id_qty_field = 'qty'+line;
    var id_lote = 'lote'+line;
    var id_loc = 'loc'+line;

    var listID =  document.getElementById('listID').value;

    document.getElementById(id_loc).innerHTML  = ''; 
    document.getElementById(id_lote).innerHTML  = '';

       if(itemId == ''){

        document.getElementById(id_desc_field).innerHTML  = '';
        document.getElementById(id_unit_field).innerHTML   = '';
        document.getElementById(id_qty_field).innerHTML  = '';
        document.getElementById(id_loc).innerHTML  = '';
        document.getElementById(id_lote).innerHTML  = '';

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
                        
                document.getElementById(id_desc_field).innerHTML  = json.Description;
                document.getElementById(id_unit_field).innerHTML   = json.UnitMeasure;

               getLotes(itemId,line);
    
        });
       }  
    
       
 
}

function getLotes(itemId,line){

    var datos= "url=ges_inventario/getLotesByItem/"+itemId+"/"+line;
    var id_lote = 'lote'+line;

    $.ajax({
        type: "GET",
        url: link,
        data: datos,
        success: function(res){ 
    
            document.getElementById(id_lote).innerHTML  = res;
            
            set_selectLoteStyle(line);
            
            SetLocation(id_lote,line);
        
        }
    });
    

    
        
    

}

function isOnlyOneLote(itemId){
    
    var datos= "url=ges_inventario/isOnlyOneLote/"+itemId;

    
    $.ajax({
        type: "GET",
        url: link,
        data: datos,
        success: function(res){ 
           // console.log('lote:'+res);
           return res;  
           
        }
    });
        
}

function SetLocation(lote='',line=''){
    
    var datos  = "url=ges_inventario/getLocByItem/"+lote+"/"+line;
    var id_loc = 'loc'+line;
    
    $.ajax({
        type: "GET",
        url: link,
        data: datos,
        success: function(res){ 


            document.getElementById(id_loc).innerHTML  = res;
          //document.getElementById(id_qty_field).innerHTML  = json.QtyOnHand;
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
                    //recalcular(line);
                }
            });
    
}


function checkMax(line){
        

    MSG_ERROR_RELEASE();

    var id_stockMax = 'stock'+line;
    var id_qty      = 'qty'+line;
    
    var max   =  document.getElementById(id_stockMax).value ;
    var value =  document.getElementById(id_qty).innerHTML ;

    var curVal = Number(value);
    var maxVal = Number(max);
    
    //console.log(curVal +'-'+maxVal);

    if(curVal != 0 && maxVal != 0  ){

        if(curVal > maxVal){
            
        
            MSG_ERROR('La cantidad maxima ha sido excedida. Max:'+maxVal,0);
        
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
 /*  subtotal_field = document.getElementById('subtotal');
    tax_field      = document.getElementById('tax'); 
    tax_value      = document.getElementById('saletaxid').value;*/

    
    for(var i=1; i<theTbl.rows.length ;i++) //BLUCLE PARA LEER LINEA POR LINEA LA TABLA theTbl
    {
       var  taxableID = 'tax'+i;
      for(var j=0;j<theTbl.rows[i].cells.length; j++) //BLUCLE PARA LEER CELDA POR CELDA DE CADA LINEA
    
            {       
    
                switch (j){
    
                       case 5:
                  
                    /*   if(document.getElementById(taxableID).innerHTML=='SI'){
                    
                        itbms_sum = Number(theTbl.rows[i].cells[7].innerHTML) * Number(tax_value);
                        itbms.push(itbms_sum);
    
                        }*/
                       
                        total.push(theTbl.rows[i].cells[j].innerHTML);
    
                        break;
    
                }
    
               }//FIN BLUCLE PARA LEER CELDA POR CELDA DE CADA LINEA
    
    }//FIN BLUCLE PARA LEER LINEA POR LINEA DE LA TABLA
    

 /*    var subtotal  = 0;
    var TAX  = 0;
    
    for(var i=0; i<total.length; i++){
    
        subtotal  += Number(total[i]);
    
    }
    
    for(var i=0; i<itbms.length; i++){
    
        TAX    += Number(itbms[i]);
    
    }*/
    
   for(var i=0; i<total.length; i++){
    
        TOTAL  += Number(total[i]);
    
    }

 /*   TOTAL =  subtotal+ TAX



    subtotal_field.value = parseFloat(subtotal).toFixed(2);;
    tax_field.value      = parseFloat(TAX).toFixed(2);; */
    total_field.value   =  parseFloat(TOTAL).toFixed(2);

   
    
    
}
// ******************************************************************************************
// *CALCULOS DE TOTALES
// ******************************************************************************************


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
            MSG_ERROR('No se han indicado registros para envio'); 
              return;
          }
          
        /////////////////////////////////////////////////////////////////////////////////////
        //SI HAY ITEMS EN LA LISTA
        if(flag==1){  
        
        var r = confirm('Desea procesar la salida de mercancia?');
        
            if (r == true) { 
            
                    //REGISTROS DE ITEMS 
                    $.ajax({
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
                var selid = "sel"+i;
                var phsid = "PHS"+i;
                var costid = "COST"+i;
                var idlote = "idlote"+i;
                var idloc  = "idloc"+i;
                
                

                if(document.getElementById(selid).value !=''){ 

                    var itemlote  = document.getElementById(idlote).value;
                    var location   = document.getElementById(idloc).value;
        
                        switch (j){
            
                                case 5:
                                    job       = document.getElementById('JOBID2').value;
                                    phase     = document.getElementById(phsid).value;
                                    cost      = document.getElementById(costid).value;

                       
                                    itemId    = document.getElementById(selid).value;
                                    ctamg     =  document.getElementById('ctamg').value;

                                    
                         
                                                                
                                    note      = document.getElementById('observaciones').value;
                                    ref       = document.getElementById('referencia').value;
                                    qty       = theTbl.rows[i].cells[5].innerHTML;

                                    UnitPrice = '0.00';
                                    total     = '0.00';

                 
                                    //agrego el registo de las demas columnas
                                    cell += '@'+itemId+
                                            '@'+UnitPrice+
                                            '@'+qty+
                                            '@'+total+
                                            '@'+note+
                                            '@'+ctamg+
                                            '@'+job+
                                            '@'+phase+
                                            '@'+cost+
                                            '@'+ref+
                                            '@'+itemlote+
                                            '@'+location; 

                                            
                              

                                    break;
    
                                    default: 

                                     val   = theTbl.rows[i].cells[0].innerHTML;
                                    
                                    if(val==''){                              
                                            FaltaArray[j] = i ;
                                            }
        
                                    if(itemlote==''){                              
                                            FaltaArray[j] = i ;
                                        }
                                    
                                    if(location==''){                              
                                            FaltaArray[j] = i ;
                                        }

                                    

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
        console.log('Line'+cell);
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
    if (document.getElementById('ctamg').value == ''){
        MSG_ERROR('Se debe indicar la cuenta de mayor',0);
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
    init();

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
     