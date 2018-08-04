// ********************************************************
// * Aciones cuando la pagina ya esta cargada
// ********************************************************
$(window).load(function(){
    
    $('#ERROR').hide();

    //setea por defaul el valor 1 para mostrar el div de crear nueva lista de precios
    set_div(1);
    GetStockList();

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
              
                    $box.prop("checked", false);
                } 
        
            });
});

function set_div(val){
    
    //OCULTA/MUESTRA EL DIV SEGUN SELECION DEL CHECKBOX PARA CREAR UN NUEVO IDPRICE O UTILIZAR UN IDPRICE EXISTENTE
    if(val=='1'){

        $('#prod_ind').show();
        $('#prod_masive').hide();
        $('#prod_layout').hide();      

    }
    if(val=='2'){

        $('#prod_ind').hide();
        $('#prod_masive').hide();
        $('#prod_layout').show(); 

    }
    if(val=='3'){
        
        $('#prod_ind').hide();
        $('#prod_layout').hide();
        $('#prod_masive').show();
    }
    
}

function GetStockList(){

    var datos= "url=ges_inventario/get_almacen_selectlist/";
    var link=  $('#URL').val()+"index.php";


    $.ajax({
        type: "GET",
        url: link,
        data: datos,
        success: function(res){
            
            $('#up_stock').html(res);
            }
    });
}

function locat(id){
     
    //LA VARIABLE DE URL PROVEIENE DE LA VARIABLO GLOBAL url SETEADA EN LA FUNCION add_location
    var datos= "url=ges_inventario/get_routes_by_almacenid/"+id;
    var link= $('#URL').val()+"index.php";
    
        $.ajax({
            type: "GET",
            url: link,
            data: datos,
            success: function(res){
            
            console.log(res);
        
           // $("#routes").removeAttr("readonly");
           // $("#routes").html(res);
            $("#up_route").html(res);
            }
        });
        
}


/////////////////////////////////////////////////////////////////////////////////////////////////
function jobs(){
        
/*JOBS*/
    var datos= "url=ges_requisiciones/get_JobList";

    $.ajax({
        type: "GET",
        url: link,
        data: datos,
        success: function(res){

        JOBS = res;


        $('#JOBID').append(JOBS);
                    

    }
});
/*JOBS*/
    
}
/////////////////////////////////////////////////////////////////////////////////////////////////