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
    init();
    
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
                '<td width="15%" class="rowtable_req" onkeyup="checkTblChar(this.id)"  id="note'+i+'"  ></td>'+  
                '<td width="15%" class="rowtable_req" onkeyup="checkTblChar(this.id)" '+editable2+' '+color2+' id="unit'+i+'"  ></td>'+
                '<td width="5%"  class="rowtable_req  numb" onkeyup="checkTblnum(this.id)"  id="tax'+i+'" '+editable2+' '+color2+'></td>'+           
                '<td width="5%"  class="rowtable_req  numb" onkeyup="checkTblPositive(this.id)" onfocusout="recalcular('+i+');" contenteditable id="qty'+i+'"></td>'+
                '<td width="5%"  class="rowtable_req  numb" onkeyup="checkTblnum(this.id)" onfocusout="calculate( '+i+');"  id="unitprice'+i+'" ></td>'+
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
    var id_qty_field = 'qty'+line;


       if(itemId == ''){

        document.getElementById(id_desc_field).innerHTML  = '';
        document.getElementById(id_unit_field).innerHTML   = '';
        document.getElementById(id_qty_field).innerHTML  = '';
        document.getElementById(id_price_field).innerHTML  = '';
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
                
    
                if(json.TaxType == 1){
        
                    document.getElementById(id_taxable_field).innerHTML  = 'SI';
        
                }else{
        
                    document.getElementById(id_taxable_field).innerHTML  = 'NO';
        
            }
    
        });
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
                  
                       if(document.getElementById(taxableID).innerHTML=='SI'){
                    
                        itbms_sum = Number(theTbl.rows[i].cells[7].innerHTML) * Number(tax_value);
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
