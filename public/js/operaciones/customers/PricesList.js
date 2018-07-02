 // ********************************************************
// * Aciones cuando la pagina ya esta cargada
// ********************************************************
$(window).load(function(){
    
    $('#ERROR').hide();
    
    //setea por defaul el valor 1 para mostrar el div de crear nueva lista de precios
    set_div(1);
    
    
    });
    
// ********************************************************
// * Aciones cuando la pagina incia|
// ******************************************************** 
document.addEventListener('DOMContentLoaded', function() {

      //ALTERNA LA SELECCION DE LOS CHECKBOX, PARA NO TENER DOS CHECKBOE SELECCIONADOS AL MISMO TIEMPO
        
        $("input:checkbox").on('click', function() {
          
          var $box = $(this);
          if ($box.is(":checked")) { 
            var group = "input:checkbox[name='" + $box.attr("name") + "']";
            $(group).prop("checked", false);
            $box.prop("checked", true);
          } else {
            $box.prop("checked", false);
          }
    
        });

        jQuery(document).ready(function($)
        
          {
        
           var table = $("#table_PriceList").dataTable({
           rowReorder: {
                    selector: "td:nth-child(2)"
                },
        
              responsive: false,
              pageLength: 100,
              dom: "Bfrtip",
              bSort: false,
              select:false,
              scrollY: "500px",
              scrollCollapse: true,
        
                buttons: [
        
                  {
        
                  extend: "excelHtml5",
                  text: "Exportar",
                  title: "Reporte_Lista_Precios",
        
                   
                  exportOptions: {
        
                        columns: ":visible",
        
                         format: {
                            header: function ( data ) {
        
                              var StrPos = data.indexOf("<div");
        
                                if (StrPos<=0){
         
                                  var ExpDataHeader = data;
        
                                }else{
                               
                                  var ExpDataHeader = data.substr(0, StrPos); 
        
                                }
                              return ExpDataHeader;
                              }
                            }
                         
                          }
                      
                  }]
        
            });
        
        
        table.yadcf(
        [{column_number : 0,
         column_data_type: "html",
         html_data_type: "text" ,
         select_type: "select2",
         select_type_options: { width: "100%" }
        
        },
        {column_number : 1,
         select_type: "select2",
         select_type_options: { width: "100%" }
        
        }],
        {cumulative_filtering: true, 
        filter_reset_button_text: false}
        );
        
        });

});

    function set_div(val){
    
    //OCULTA/MUESTRA EL DIV SEGUN SELECION DEL CHECKBOX PARA CREAR UN NUEVO IDPRICE O UTILIZAR UN IDPRICE EXISTENTE
        if(val=='1'){
    
          $('#nvo_lp').show();
          $('#used_lp').hide();      
    
        }else{
    
          $('#nvo_lp').hide();
          $('#used_lp').show();
    
        }
    
    
    
    }


//agrega ITEMS
function add_item(){
  
  var priceID   = document.getElementById('PL_id_2').value;
  var itemID    = document.getElementById('item_id_modal_2').value ;
  var descPrice = document.getElementById('desc_id_modal_2').value ;
  var priceVal  = document.getElementById('price_id_modal_2').value ;
  var unitMes   = document.getElementById('unit_id_modal_2').value ;
  
  //////////////////////////////
  
  validacion();
  
  if(CHK_VALIDATION == true){ CHK_VALIDATION = false;  return;  }
  
  /////////////////////////////
  
  itemData = priceID+'@'+itemID+'@'+descPrice+'@'+priceVal+'@'+unitMes;
  
  var link= URL+"index.php";
  
    $.ajax({
        type: "GET",
        url: link,
        data:  {url: 'ges_reportes/add_item/', Data : itemData}, 
        success: function(res){
            
         if (res == '1') {
  
          MSG_CORRECT('El item ha agregado exitosamente.',0); 
  
          get_PL(priceID);
  
               
          }else{
  
          MSG_ERROR(res,0); 
  
          }
       
          }
     });
  
  }

  function get_PL(id_PL) {
    
    URL = document.getElementById('URL').value;
    
    var datos= "url=ges_reportes/get_PL_details/"+id_PL;  
    var link = URL+"index.php";
    
    
    
    
      $.ajax({
          type: "GET",
          url: link,
          data: datos,
          success: function(res){
            console.log(datos);
          
           $('#table3').html(res);
    
           // alert(res);
    
            }
       });
    
    
    
    }

    
function del_PL(id_PL) {
  
  /*var id=document.getElementById("user_2").value;
  var name = document.getElementById("name2").value;
  var lastname =  document.getElementById("lastname2").value;
  */
  
  var datos = 'url=ges_reportes/del_PL_detail/'+id_PL;
  var link = URL+"index.php";
  
  var r = confirm('Este seguro de eliminar definitivamente la Lista de Precio '+id_PL+' ?');
  
  if(r==true){
  
  $.ajax({
  type: 'GET',
  url: link,
  data: datos,
  success: function(dat){
  
   alert('La Lista de Precio se ha eliminado exitosamente.'); 
  
  location.reload(true);
  /*history.go(-1); 
  return true;*/
  
  }
  
  
  });
  
  
  }
  
  }
  
  //SETEA EL MODAL CON LOS VALORES ACTUALES
  
  function modal_PL_item(id_PL,id_item,unit,desc){
  
  
  document.getElementById('item_id_modal').value = id_item;
  document.getElementById('PL_id').value = id_PL;
  document.getElementById('unit_id_modal').value = unit;
  document.getElementById('desc_id_modal').value = desc;
  
  }
  
  //FUNCION JS PARA MODIFICAR EL ITEM
  
  function mod_item(){

  
  
    var id_PL = document.getElementById('PL_id').value;
    var iditem = document.getElementById('item_id_modal').value;
    var descitem = document.getElementById('desc_id_modal').value;
    var priceitem = document.getElementById('price_id_modal').value;
    var unit = document.getElementById('unit_id_modal').value;
  
  
  if(descitem=='' || priceitem=='' || unit==''){
  
    MSG_ERROR('Debe llenar al menos un campo a modificar',0);
  
  }else{
  
  var R = confirm('Desea modificar el item '+iditem+' ?');
  
    if (R==true) {
  
  var datos= "url=ges_reportes/modify_item/"+id_PL+"/"+iditem+"/"+descitem+"/"+priceitem+"/"+unit;
  var link= URL+"index.php";
  
    $.ajax({
        type: "GET",
        url: link,
        data: datos,
        success: function(res){
     
         console.log(res);
         if (res == '1') {
  
          MSG_CORRECT('El item ha sido modificado exitosamente.',0); 
  
          get_PL(id_PL);
  
               
          }
          }
     });
    
  }
  
  document.getElementById('PL_id').value = '';
  document.getElementById('item_id_modal').value = '';
  document.getElementById('desc_id_modal').value = '';
  document.getElementById('price_id_modal').value = '';
  document.getElementById('unit_id_modal').value = '';
  }
  }
  
CHK_VALIDATION = false;

function validacion(){

var itemID    = document.getElementById('item_id_modal_2').value ;
var descPrice = document.getElementById('desc_id_modal_2').value ;
var priceVal  = document.getElementById('price_id_modal_2').value ;

  if (itemID == ''){

   MSG_ERROR('Se debe seleccionar un item Id',0);

   CHK_VALIDATION = true;

  }

  if (descPrice == ''){

   MSG_ERROR('Se debe indicar una descripcion para el nuevo item',0);

   CHK_VALIDATION = true;

  }

  if (priceVal == ''){

   MSG_ERROR('Se debe indicar un valor para el precio del item',0);

   CHK_VALIDATION = true;

  }

}

function del_PL_item(id_PL,id_item){
  
  var R = confirm('Desea modificar el item '+id_item+' ?');
  
  if (R==true) {
  
  
  var datos= "url=ges_reportes/delete_item/"+id_PL+"/"+id_item;
  var link= URL+"index.php";
  
    $.ajax({
        type: "GET",
        url: link,
        data: datos,
        success: function(res){
     
         
         console.log(res);
         
         if (res == '1') {
  
          MSG_CORRECT('El item ha sido eliminado exitosamente.',0); 
  
          get_PL(id_PL);
  
               
          }
       
          }
     });
  
  
  }
  
  }

