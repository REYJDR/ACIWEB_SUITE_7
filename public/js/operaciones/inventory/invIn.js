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
});

function set_div(val){
    
    //OCULTA/MUESTRA EL DIV SEGUN SELECION DEL CHECKBOX PARA CREAR UN NUEVO IDPRICE O UTILIZAR UN IDPRICE EXISTENTE
    if(val=='1'){

        $('#prod_ind').show();
        $('#prod_layout').hide();      

    }else{

        $('#prod_ind').hide();
        $('#prod_layout').show();

    }
    
}