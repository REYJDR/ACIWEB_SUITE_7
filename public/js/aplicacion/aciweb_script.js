// ********************************************************
// * Aciones cuando la pagina ya esta cargada
// ********************************************************
$(window).load(function(){


  $('.loader').hide();
  document.getElementById("allDocument").style.visibility = "visible";

  
  
  //selectc con buscador 
  $(".select").select2({

  placeholder: 'Seleccione una opcion',
  allowClear: true,
  maximumSelectionSize: 1

  });  


  // Get the element with id="defaultOpen" and click on it
  document.getElementById("defaultOpen").click();


 

});




// ********************************************************
// * Aciones cuando la pagina incia|
// ********************************************************
document.addEventListener('DOMContentLoaded', function() {

  var LineArray = []; //array para los items de la cotizacion
    
  $('.loader').show();


  $("#pass_12").focus(function(){
  //Elimina el valor de pass2 si se situa el foco a pass1 en el model de Edit user
    var passField = "";

    $('#pass2').val(passField);

    });


  $('#pass_22').focusout(function(){
    var pass = $('#pass_12').val();
    var pass2 = $('#pass_22').val();
      if(pass != pass2){
        MSG_ERROR('Password no coninciden',0);
        }


      });


}, false);

$(document).keypress(function(e){
  return e.which != 13;
});  


//FUNCION DE ERROR 
function MSG_ERROR(MSG,VAL){

  $('#ERROR').show();
  $('#ERROR').addClass( "alert alert-danger" ); 

  if(VAL == 1){

    $('#ERROR').append(MSG+'<br>');

  }else{

    $('#ERROR').html(MSG+'<br>');
  }

  $("html, body").animate({ scrollTop: 0 }, "slow");

  //return false;
}

//FUNCION DE CORRECTO
function MSG_CORRECT(MSG,VAL){

  $('#ERROR').show();
  $('#ERROR').addClass( "alert alert-success" ); 

  if(VAL == 1){
    
    $('#ERROR').append(MSG+'<br>');

  }else{

    $('#ERROR').html(MSG+'<br>');
  }

  
  $("html, body").animate({ scrollTop: 0 }, "slow");
  

  //return false;
}

//FUNCION DE ADVERTENCIA
function MSG_ADVICE(MSG){
  
    $('#ERROR').show();
    $('#ERROR').addClass( "alert alert-warning" ); 
  

    $('#ERROR').html(MSG+'<br>');

    $("html, body").animate({ scrollTop: 0 }, "slow");
    
  
    //return false;
}

//LIMPIA CAMPO ERROR
function MSG_ERROR_RELEASE(){

 $('#ERROR').html('');
 $('#ERROR').removeClass('alert-success');
 $('#ERROR').removeClass('alert-warning');
 $('#ERROR').removeClass('alert-danger');
 
 $('#ERROR').hide();

}


//INI FUNCION DE SPIN MOSTRAR Y APAGAR
function spin_show(){

    //TERMINA SPIN/////////////////////////////////////////////////////
    $('html,body').scrollTop(0);
    document.getElementById("allDocument").style.visibility = "hidden";
    $('.loader').show();
    ////////////////////////////////////////////////////////////////////


}

function spin_hide(){

    //TERMINA SPIN/////////////////////////////////////////////////////
    $('.loader').hide();
    document.getElementById("allDocument").style.visibility = "visible";
    ////////////////////////////////////////////////////////////////////

  
}
//FIN FUNCION DE SPIN MOSTRAR Y APAGAR

//DA SALIDA DEL SISTEMA
function goOut(){

  var URL = $('#URL').val();

  r = confirm("Desea salir de sistema?");

  if(r==true){
    window.open(URL+"index.php?url=login/login_out/",'_self');
    
  }
}

//DEVUELVE AL DASHBOARD
function goHome(){
  
  var URL = $('#URL').val();

    window.open(URL+"index.php?url=home/index",'_self');
    
}

     
function show_sales(URL,id){


     var datos= "url=ges_ventas/get_salesorder_info/"+id;

      
       $.ajax({
         type: "GET",
         url: URL+'index.php',
         data: datos,
         success: function(res){

           //$("historial").hide();

           $("#info").html(res);

                 }
            });

       $('html, body').animate({
        scrollTop: $("#info").offset().top
        }, 2000);


}

function show_invadj(URL,id,resp){


     var datos= "url=bridge_query/get_invadj_info/"+id+'/'+resp;

      
       $.ajax({
         type: "GET",
         url: URL+'index.php',
         data: datos,
         success: function(res){

           //$("historial").hide();

           $("#info").html(res);

                 }
            });
 
        $('html, body').animate({
        scrollTop: $("#info").offset().top
        }, 2000);



}

function show_invoice(URL,id){


     var datos= "url=ges_ventas/get_sales_info/"+id;

      
       $.ajax({
         type: "GET",
         url: URL+'index.php',
         data: datos,
         success: function(res){

           //$("historial").hide();

           $("#info").html(res);

                 }
            });
  

         $('html, body').animate({
        scrollTop: $("#info").offset().top
        }, 2000);



}

function show_con(URL,id){


  var datos= "url=bridge_query/get_con_info/"+id;

  console.log(datos);
      
       $.ajax({
         type: "GET",
         url: URL+'index.php',
         data: datos,
         success: function(res){

           //$("historial").hide();

           $("#info").html(res);

                 }
            });

         $('html, body').animate({
        scrollTop: $("#info").offset().top
        }, 2000);

}

function show_fact(URL,id){


  var datos= "url=bridge_query/get_fact_by_id/"+id;

  console.log(datos);
      
       $.ajax({
         type: "GET",
         url: URL+'index.php',
         data: datos,
         success: function(res){

           //$("historial").hide();

           $("#info").html(res);

                 }
            });

       $('html, body').animate({
        scrollTop: $("#info").offset().top
        }, 2000);




}

function items(url,id){


     var datos= "url=bridge_query/get_items_by_invoice/"+id;

       
     var link= url+"index.php";

     
       $.ajax({
         type: "GET",
         url: link,
         data: datos,
         success: function(res){

          $("#tableInv").html(res);

                 }
            });


}


// ********************************************************
// * formato de fechas
// ********************************************************
function formatDate(date) {
        var d = new Date(date);
            month = '' + (d.getMonth() + 1);
            day = '' + d.getDate();
            year = d.getFullYear();

        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;

        return [year, month, day].join('-');
}

// ********************************************************
// * CHECA ERRORES DE BASE DE DATOS
// ********************************************************
function  CHECK_DB_ERROR(){

 $err = 0;
    //VERIFICA ERRORES DEL QUERY
     $.getJSON( "/public/LOG_ERROR/TEMP_LOG.json", function(data) {
        
      var ERROR = [];

      $.each( data, function( key, val ) {
        
            if(key=='ERROR' && val!=''){

             msg = '<div class="alert alert-danger">Se registro un error tratando de realizar la insersion de datos :'+val+'</div>';
                
                $('#ERROR_LOGS').html(msg);
                console.log(msg);
                //alert('Se registro un error tratando de realizar la insersion de datos :'+val);
                $err = 1;
                
            }

      });
  });

 return $err;
}

// ********************************************************
// * USER MANAGMENT function
// ********************************************************
function ValidateEmail(email) {

   var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
    return expr.test(email);

}

//Valido el match de los password
$(document).ready(function(){

    $('#pass_2').focusout(function(){
      var pass = $('#pass_1').val();
      var pass2 = $('#pass_2').val();
        if(pass != pass2){
        MSG_ERROR('Password no coninciden',0);
        }

  });

  //Valido si la sintaxis de la direccion de correo es valido
  $('#mail').focusout(function(){
      if (!ValidateEmail($("#mail").val())) {
        MSG_ERROR("La direccion de correo no es correcta.",0);
        }
    });
});


//ELIMINAR USUARIO 
function erase_user(URL){

  var id=document.getElementById("user_2").value;
  var name = document.getElementById("name2").value;
  var lastname =  document.getElementById("lastname2").value;

  var datos = 'url=bridge_query/erase_account/'+id;

  var r = confirm('Este seguro de eliminar definitivamente la cuenta del usuario '+name+' '+lastname+' ?');

    if(r==true){

    $.ajax({
      type: 'GET',
      url:  URL+'index.php',
      data: datos,
      success: function(dat){

        MSG_CORRECT('La cuenta se ha eliminado exitosamente.',0); 

          history.go(-1); 
          return true;

      }  });


    }
  
}


// ********************************************************
// * location management
// ********************************************************
function FILTER(URL){

  var stock = $('#item_by_stock').val();
  var data = 'url=bridge_query/get_item_filter_by_stock/'+stock;

  $('.loader').show();

  document.getElementById("allDocument").style.visibility = "hidden";

    $.ajax({
    type:"GET",
    url: URL+'index.php',
    data: data,
    success: function(dat){

      $('#items_by_stock').html(dat);
      $('.loader').hide();
      document.getElementById("allDocument").style.visibility = "visible";

     } 

   });


}
  
function view_items(URL,ruta){

  $('.loader').show();
  document.getElementById("allDocument").style.visibility = "hidden";

  var data = 'url=bridge_query/get_item_filter_by_route/'+ruta;

    $.ajax({
    type:"GET",
    url: URL+'index.php',
    data: data,
    success: function(dat){

    
      
      $('#items_by_stock').html(dat);

      $('.loader').hide();
      document.getElementById("allDocument").style.visibility = "visible";

       

     } 

   });


}
  
function crear_almacen(){

  $("#crear_alm_imp").show();
  $("#bodega").hide();

}

function save_alm(URL){

  var name = document.getElementById('almacen').value;

  url = URL;


  if(name!=''){

      var data = 'url=bridge_query/set_almacen/'+name.toUpperCase();

      $.ajax({
        type: 'GET',
        url: url+'index.php',
        data: data,
        success: function(res) {

      alert(res);

      location.reload(true); 

            }
      });

    }else{


    MSG_ERROR('El campo no debe estar vacio',0);

    }


  $("#crear_alm_imp").hide();
  $("#bodega").show();

}

function set_location(URL){


 if(document.getElementById("stock").value==''){


  MSG_ERROR('Debe seleccionar al menos el almacen',0);



  } else {  

    ALMACEN = document.getElementById("stock").value;

    if(document.getElementById("stock_estand").value=='') { MUEBLE = '0'; } else {MUEBLE = mueble_ID; }
    if(document.getElementById("stock_column").value=='') { COLUMNA = '0'; } else {COLUMNA=colum_ID; }
    if(document.getElementById("stock_row").value==''){ FILA = '0'; } else { FILA=ROW_ID; }

    var locationAL = 'A'+ALMACEN+'M'+MUEBLE+'C'+COLUMNA+'F'+FILA;

    var datos ='url=bridge_query/set_location/'+ALMACEN+'/'+locationAL;

    $.ajax({
          type: 'GET',
          url: URL+'index.php',
          data: datos,
          dataType: 'html',
          success: function(res) {

        alert(res);

        location.reload(true); 

              }
        });

    }

  }

  // ********************************************************
  // * INPUTS checa si el valor introducido es numerico , permite "-"
  // ********************************************************
  function check_num(value,id)
  {
  $('#ERROR').hide();


  var slice = value.slice(-1);

  var patt = new RegExp("-");
  var sing = patt.test(value );


  if (isNaN(value)) 
  {

    if(sing==false) {
      
          document.getElementById( id ).value  = slice;
          MSG_ERROR("La entrada debe ser valores numericos", 0 );
          
          return false;
        }

  }


}



// ********************************************************
// * validaciones de campos 
// ********************************************************
  //SOLO VALORES NUMERICOS EN CAMPOS DE TABLAS
  function checkTblnum(ID){

    var x=document.getElementById(ID).innerHTML;
    var patt = new RegExp("-");
    var sing = patt.test( x );


    if (isNaN(x)) 
    {

      if(sing==false) {
        
            document.getElementById(ID).innerHTML = x.slice(0,-1);
            MSG_ERROR("La entrada debe ser valores numericos", 0 );
            
            return false;
          }

    }


  }

  //SOLO VALORES NUMERICOS POSITIVOS EN CAMPOS DE TABLAS
  function checkTblPositive(ID){
    
    
        var x=document.getElementById(ID).innerHTML;
        var patt = new RegExp("-");
        var sing = patt.test( x );
    
    
        if (isNaN(x) && x >0) 
        {
    
          if(sing==false) {
            
                document.getElementById(ID).innerHTML = x.slice(0,-1);
                MSG_ERROR("La entrada debe ser valores numericos mayores a 0", 0 );
                
                return false;
              }
    
        }
    
    
  }

  //NO PERMITE @ EN CAMPOS DE TABLAS
  function checkTblChar(ID){
    
    
    var x=document.getElementById(ID).innerHTML;
    var patt = new RegExp("@");
    var val = patt.test( x );
    
      if (val== true) 
      {
        MSG_ERROR("No se permite el caracter especial '@' ",0);
        document.getElementById(ID).innerHTML = x.slice(0,-1);

        return false;
      }
  }

  //NO PERMITE @ EN CAMPOS INPUTS
  function checkInpChar(ID){
    
    var x=document.getElementById(ID).value;
    var patt = new RegExp("@");
    var val = patt.test( x );

    if (val== true) 
    {
     
      document.getElementById(ID).value = x.slice(0,-1);
      MSG_ERROR("No se permite el caracter especial '@' ",0);

      return false;
    }
  }

  //SOLO VALORES NUMERICOS EN CAMPOS INPUTS
  function checkInpnum(ID){


    var x=document.getElementById(ID).innerHTML;

    if (isNaN(x)) 
    {
      document.getElementById(ID).innerHTML = '';
      MSG_ERROR("La entrada en este campo debe ser numerico",0);
      
      return false;
    }else{

      return 0;
    }
  }

  //VALIDA LONGITUD EN CAMPOS DE TABLAS
  function checkLong(ID,long){
 
    var x=document.getElementById(ID).innerHTML;

    if (x.length > long) 
    {
      document.getElementById(ID).innerHTML = x.slice(0,-1);
      alert("La entrada no debe ser de longitud mayor a "+long+" caracteres");
      
      return false;
    }
  }

  //VALIDA LONGITUD EN CAMPOS DE inputs
  function checkLongInp(ID,long){
    
        var x=document.getElementById(ID).value;
    
        if (x.length > long) 
        {
          document.getElementById(ID).value = x.slice(0,-1);
          alert("La entrada no debe ser de longitud mayor a "+long+" caracteres");
          
          return false;
        }
      }
// ********************************************************
// * validaciones de campos 
// ********************************************************


// ********************************************************
// *PERMITE VER UNA FOTO ANTES DE CARGARLA AL SERVIDOR
// ********************************************************
function readURL(input) {
  
   document.getElementById('trash_img').value = 0;
  
      if (input.files && input.files[0] ) {
        
        var reader = new FileReader();
          reader.onload = function (e) {
              $('#blah').attr('src', e.target.result);
              $("#blah").css("display", "block");
  
          }
  
          reader.readAsDataURL(input.files[0]);
      } 
}

// ********************************************************
// *SETEA ESTILO PARA SELECTS 
// ********************************************************
function set_selectItemStyle(){

  //selectc con buscador 
  $(".selectItems").select2({

    placeholder: '',
    allowClear: true,
    maximumSelectionSize: 1,
    dropdownCssClass : 'bigdrop'

  }); 

}

function set_selectLoteStyle(line){
  

    //selectc con buscador 
    $(".selectLote"+line).select2({

      placeholder: '',
      allowClear: true,
      maximumSelectionSize: 1,
      dropdownCssClass : 'bigdrop'
    
    }); 
  
}

function set_selectLocStyle(line){
   
      //selectc con buscador 
      $(".selectLoc"+line).select2({
      placeholder: '',
      allowClear: true,
      maximumSelectionSize: 1,
      dropdownCssClass : 'bigdrop'
    
      }); 
    
}

// ********************************************************
// *OBTIENE LENGUAJE DEL SISTEMA
// ********************************************************
function get_lang(){

  //retorna el lenguaje de sistema para determinar las notificaciones

 var URL = document.getElementById('URL').value;
 var link = URL+"index.php";
 var datos= "url=bridge_query/get_lang/";


   return $.ajax({
              type: "GET",
              url: link,
              data: datos,
              success: function(res){


                  }
              });

}

// ********************************************************
// *LIMPIA UN DIV PR ID
// ********************************************************
function CLOSE_DIV(id){

   $('#'+id).html('');

}

// ********************************************************
// *TEST PARA MOVIL - PWA
// ********************************************************
function openCity(evt, cityName){
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
      tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
      tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}

// ********************************************************
// *VALIDA STRING JSON
// ********************************************************
function isJson(str){
  
  try {
      JSON.parse(str);
  }catch (e){
      return false;
  }
  return true;
}

// ********************************************************
// *REEMPLAZA ESPACION &NSBP; HTML EN JAVASCRIP
// ********************************************************
function replaceNbsps(str) {
  var nStr = str.replace(/&nbsp/g, " ")
  console.log(nStr);
  return nStr ;
}

