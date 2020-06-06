// ********************************************************
// * Aciones cuando la pagina ya esta cargada
// ********************************************************
$(window).load(function(){

$('#ERROR').hide();



var api_url = $("#api_url").val();
var api_key = $("#api_key").val();
var api_store_route = $("#api_store_route").val();

store_oc_api( api_store_route,api_url, api_key );


});
	
$(document).ready(function() {
    if (location.hash) {
        $("a[href='" + location.hash + "']").tab("show");
    }
    $(document.body).on("click", "a[data-toggle]", function(event) {
        location.hash = this.getAttribute("href");
    });

    $(document.body).on("click", "#save_user", function(event) {
        if (!ValidateEmail($("#mail").val())) {
            MSG_ERROR("La direccion de correo no es correcta.",0);
        }
        
    });

   
});

$(window).on("myTab", function() {
    var anchor = location.hash || $("a[data-toggle='tab']").first().attr("href");
    $("a[href='" + anchor + "']").tab("show");
});

//TABLE OF ACCOUNT
jQuery(document).ready(function($)
{
 
 var table = $("#userList").dataTable({
    aLengthMenu: [
      [5,10, 25,50,-1], [5,10, 25, 50,"All"]
    ]
  });

table.yadcf([
  
{column_number : 0,
column_data_type: "html",
html_data_type: "text" ,
select_type: "select2",
select_type_options: { width: "100%" }

},
{column_number : 1,
select_type: "select2",
select_type_options: { width: "100%" }

},
{column_number : 2,
select_type: "select2",
select_type_options: { width: "100%" }

},
{column_number : 3,
select_type: "select2",
select_type_options: { width: "100%" }

}],
{cumulative_filtering: true, 
filter_reset_button_text: false}
);

});


	
function ShowLogBD(){

URL = document.getElementById('URL').value;
link = URL+"index.php";
DATOS = "url=home/GetBDLog";

$.ajax({
      type: "GET",
      url: link,
      data: DATOS,

      success: function(res){

      var button = '</br><button onclick="ClearLogBD();"><i class="fa fa-trash" ></i> Limpiar archivo</button></br>';

      $('#logViewBD').html(button+res);


     } 
 });

}

	
function ClearLogBD(){

URL = document.getElementById('URL').value;
link = URL+"index.php";
DATOS = "url=home/ClearBDLog";

$.ajax({
      type: "GET",
      url: link,
      data: DATOS,

      success: function(res){

      $('#logViewBD').html(res);


     } 
 });

}
	
function ShowLog(){

URL = document.getElementById('URL').value;
link = URL+"index.php";
DATOS = "url=home/GetSyncLog";

$.ajax({
      type: "GET",
      url: link,
      data: DATOS,

      success: function(res){
      
      var button = '</br><button onclick="ClearLog();"><i class="fa fa-trash" ></i> Limpiar archivo</button></br>';

      $('#logView').html(button+res);


     } 
 });

}

function ClearLog(){

URL = document.getElementById('URL').value;
link = URL+"index.php";
DATOS = "url=home/ClearSyncLog";

$.ajax({
      type: "GET",
      url: link,
      data: DATOS,

      success: function(res){

      $('#logView').html(res);


     } 
 });

}

function del_tax(id){
    
    URL = document.getElementById('URL').value;

    var datos= "url=home/del_tax/"+id;

    var link= URL+"index.php";

        $.ajax({
            type: "GET",
            url: link,
            data: datos,
            success: function(res){

                alert("Se ha eliminado el tax seleccionado","ok"); 
                window.open("index.php?url=home/config_sys","_self");

            }
        });


}


function del_term(id){
    
URL = document.getElementById('URL').value;

var datos= "url=home/del_term/"+id;

var link= URL+"index.php";

    $.ajax({
        type: "GET",
        url: link,
        data: datos,
        success: function(res){

            alert("Se ha eliminado el termino de pago","ok"); 
            window.open("index.php?url=home/config_sys","_self");

        }
    });


}

function del_print(id){
    
URL = document.getElementById('URL').value;

var datos= "url=home/del_print/"+id;
var link= URL+"index.php";

    $.ajax({
        type: "GET",
        url: link,
        data: datos,
        success: function(res){

            alert("Se ha eliminado la impresora seleccionado","ok"); 
            window.open("index.php?url=home/config_sys","_self");

        }
    });


}

function send_test(){

		URL       = document.getElementById('URL').value;
		var email = document.getElementById('emailtest').value;
		var datos= "url=home/send_test_mail/"+email;
        var link= +"index.php";

        

        $('#notificacion').html('<div class="miniSpiner"></div>');
        

		  $.ajax({
		      type: "GET",
		      url: link,
		      data: datos,
		      success: function(res){
		      
		       $('#notificacion').html(res);
		      
		        }
		   });

		 console.log = function(message) {$('#notificacion').append('<p>' + message + '</p>');};

}




// ********************************************************
// *API DE OPENCART
// ********************************************************
function exce_oc_api(name,route,oc_url,oc_key){

    function exce(){

        store_id = $("#stores option:selected").val();

        if(  store_id !=  "" || !store_id ){

            document.getElementById('api_res').innerHTML = "Ejecutando...";
            
            var URL = document.getElementById('URL').value;
            
            if(name == 'setItems') var url = "bridge_query/oc_setItems";
            if(name == 'getOrders') var url = "bridge_query/oc_getOrders";
            if(name == 'getStores') var url = "bridge_query/oc_getStores";
            if(name == 'getCustomers') var url = "bridge_query/oc_getCustomers";
            if(name == 'getTblCol') var url = "bridge_query/oc_getTblCol";
            if(name == 'getAttributes') var url = "bridge_query/oc_getAttributes";
            

            $.ajax({
            
                    type: "GET",
                    url: URL,
                    data: {url:url, api_url: oc_url , api_route:route, api_key:oc_key , store_id: store_id},
                    success: function(res){
                
            
                    
            
                    document.getElementById('api_res').innerHTML = res;
            
                
            
                }
            
            });


        }else{

            alert("Se debe seleccionar un ID de tienda");
        }
        
      }
      $.when(exce()).done(function(){
        set_selectItemStyle();
      });
    
    
}


function store_oc_api(route,oc_url,oc_key){
    
      var URL = document.getElementById('URL').value;
      document.getElementById('stores').innerHTML = '';
      var url = "bridge_query/oc_getStoresList";
 
      $.ajax({
        
              type: "GET",
              url: URL,
              data: {url:url, api_url: oc_url , api_route:route, api_key:oc_key },
              success: function(res){
             
        
               document.getElementById('stores').innerHTML = res;
        
             
        
             }
        
        });
       
}

function columnMapping(name,route,oc_url,oc_key){
  
  
    exce_oc_api(name,route,oc_url,oc_key);
  
  
      

}


function saveMapping(){
    
    var URL = document.getElementById('URL').value;
    var url = "bridge_query/saveMapping";
    var html_table_data = {};  

    $('#mappingTable tbody>tr').each(function () {  
        
        var col = $(this).children();
        
        if($(col[0]).html() != 'Ninguno'){
            html_table_data[ $(col[0]).html() ] = $(col[1]).children().val() ;  
        }
      

    });   
    $.ajax({
        type: "GET",
        url: URL,
        data: { url:url, filename:"itemsMappingOC",data: JSON.stringify(html_table_data) },
        success: function (res) { 

            if(res == 0) { MSG_CORRECT("Mapeo de columnas guardado con exito",'');  }else{  MSG_CORRECT("Error al guardar",'');  }
        }
    });

}

// ********************************************************
// *API DE OPENCART
// ********************************************************

  



