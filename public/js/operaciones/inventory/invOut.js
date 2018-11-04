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
               
               builtTbl();
               
           });
      
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
        

        reglon = '<td width="10%" >'+
                    '<select class="selectItems col-lg-12" id="sel'+i+'" onchange="SetDesc(this.value,'+i+')" >'+
                        '<option selected></option>'
                        +listitem+
                    '</select>'+
                '</td>';  

            var line_table_req = '<tr>'+reglon+
                '<td width="15%" class="rowtable_req" onkeyup="checkTblChar(this.id)" '+editable+' '+color+' id="desc'+i+'"  ></td>'+
                '<td width="15%" class="rowtable_req" onkeyup="checkTblChar(this.id)" '+editable+' '+color+' id="unit'+i+'"  ></td>'+
                '<td width="5%"  class="rowtable_req  numb" onkeyup="checkTblChar(this.id)"  id="gl'+i+'" '+editable2+' '+color2+' ></td>'+
                '<td width="5%"  class="rowtable_req  numb" onkeyup="checkTblnum(this.id)"  id="tax'+i+'" '+editable2+' '+color2+'></td>'+           
                '<td width="5%"  class="rowtable_req  numb" onkeyup="checkTblPositive(this.id)" onfocusout="recalcular('+i+');" contenteditable id="qty'+i+'"></td>'+
                '<td width="5%"  class="rowtable_req  numb" onkeyup="checkTblnum(this.id)" onfocusout="calculate( '+i+');" contenteditable id="unitprice'+i+'" ></td>'+
                '<td width="5%"  class="rowtable_req  numb" '+color+' id="total'+i+'" ></td></tr>' ;
            i++
            
            $('#items').append(line_table_req); //limpio la tabla 
            }

        set_selectItemStyle(); 


}