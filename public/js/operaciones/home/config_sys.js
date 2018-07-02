// ********************************************************
// * Aciones cuando la pagina ya esta cargada
// ********************************************************
$(window).load(function(){

$('#ERROR').hide();
// Get the element with id="defaultOpen" and click on it
document.getElementById("ConfigOpen").click();

});
	
$(document).ready(function() {
    if (location.hash) {
        $("a[href='" + location.hash + "']").tab("show");
    }
    $(document.body).on("click", "a[data-toggle]", function(event) {
        location.hash = this.getAttribute("href");
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

