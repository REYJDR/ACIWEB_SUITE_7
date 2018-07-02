// ********************************************************
// * Aciones cuando la pagina ya esta cargada
// ********************************************************
$(window).load(function(){
    
    $('#ERROR').hide();

    
});


function eliminar_lote(lote,qty){
    
          var r = confirm('Esta seguro de quere eliminar el no de lote : '+lote);
    
          if(r==true){
    
              var re = confirm('El proseguir se eliminara el No de lote de la lista y las cantidades de items seran colocadas en el lote "Default", asi como las cantidades de cada ubicacion del lote a eliminar');
    
              if(re==true){
              
                var URL = $('#URL').val();
                var datos= "url=ges_inventario/erase_lote/"+lote+'/'+qty;
                var link= URL+"index.php";
    
                  $.ajax({
                      type: "GET",
                      url: link,
                      data: datos,
                      success: function(res){
                         location.reload(true); 
                        }
                   });
    
              }else{
                location.reload();
              }
    
          }else{
            location.reload();
          }
}

function addLote(item,maxqty){
    
    
    var lote = $('#no_lote').val();
    var fecha = $('#fecha_lote').val();
    var qty = $('#qty_lote').val();
    var URL = $('#URL').val();
    
    qty = Number(qty);
    maxqty = Number(maxqty);
    
    console.log(qty+' '+maxqty);
    
    if(qty <= maxqty || qty <= 0 ){
    
    var datos= "url=ges_inventario/SET_NO_LOTE/"+item+'/'+lote+'/'+qty+'/'+fecha;
    var link= URL+"index.php";
    
      $.ajax({
          type: "GET",
          url: link,
          data: datos,
          success: function(res){
    
            console.log('RES '+res);
    
               if(res.trim()!=''){
    
                   MSG_ERROR(res,0);
                
               }else{
                  
                  location.reload(true);
               }               
           
            }
       });
        
    }else{
    alert('Verifique que existen suficientes items en la ubicacion Default del lote "'+item+'0000" para poder crear la existencia de un nuevo lote','ok');
     location.reload(true);
    }
    
}


function update_location(STOCK_ROUTE_SRC,STOCK_NAME_SRC,URL,id_location,lote,ven,qty){
    
    dir = $('#URL').val();
    
    STOCK_ROUTE_SRC = "'"+STOCK_ROUTE_SRC+"'";
    STOCK_NAME_SRC = "'"+STOCK_NAME_SRC+"'";
    qty_scr = "'"+qty+"'";
    
    var header= '<input id="up_id" type="hidden" value="'+id_location+'" />'+
                '<legend>Reubicacion de Lote</legend>'+
                '<fieldset class="fieldsetform" >'+
                
                '<table id="ubicaciones" class="display table table-striped table-condensed table-bordered  dataTable no-footer">'+
                '<tr><th>No. Lote</th><th>Fecha Venc.</th><th>Cantidad</th><th>Almacen</th><th>Ubicacion</th><th></th><th></th></tr>';
    
    var line  = '<tr><td><input id="up_lote" class="form-control col-lg-2"  value="'+lote+'" readonly/></td>'+
                '<td><input id="up_venc" class="form-control col-lg-2"  value="'+ven+'" readonly/></td>'+
                '<td><input id="up_qty" type="number" class="form-control col-lg-2"  min="1" max="'+qty+'" /></td>'+
                '<td><select id="up_stock" class="form-control"  onchange="locat(this.value);"></select></td>'+
                '<td><select id="up_route" class="form-control" ></select></td>'+
                '<td><button onclick="javascript: location.reload();"  class="btn btn-warning  btn-block text-left" type="submit" >cancelar</button></td>';
    var line2= '<td><button onclick="set_update_location('+STOCK_ROUTE_SRC+','+STOCK_NAME_SRC+','+qty_scr+');" class="btn btn-primary  btn-block text-left"   >Ubicar</button></td></tr>';
    
    var footer = '</table></fieldset>';
    
     $('#update_loc').html(header+line+line2+footer);
    
    
    var datos= "url=ges_inventario/get_almacen_selectlist/";
    var link= URL+"index.php";
    
    
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
var link= dir+"index.php";

    $.ajax({
        type: "GET",
        url: link,
        data: datos,
        success: function(res){
        
        console.log(res);
    
        $("#routes").removeAttr("readonly");
        $("#routes").html(res);
        $("#up_route").html(res);
        }
    });
    
}
    
function add_location_route(){

var ruta_selected = $('#routes').val();
var almacen_selected = $('#almacen').val();
var item_id = $('#item_id').val();
var lote = $('#no_lote').val();
var qty = $('#qty_new').val();
    
if ( $('#routes').val() &&  
    $('#almacen').val() &&  
    $('#item_id').val() &&  
    $('#no_lote').val() &&  
    $('#qty_new').val() ){
    

var datos= "url=ges_inventario/set_lote_location/"+ruta_selected+'/'+almacen_selected+'/'+item_id+'/'+lote+'/'+qty;
var link= dir+"index.php";
    
$.ajax({
    type: "GET",
    url: link,
    data: datos,
    success: function(res){

    location.reload();
    }
});



}else{

alert('Debe definir todos los parametros de ubicacion');

}

}

function set_update_location(STOCK_ROUTE_SRC,STOCK_NAME_SRC,maxqty){
    
    
var ruta= $('#up_route').val();
var almacen = $('#up_stock').val();

var id_location = $('#up_id').val();
var lote =$('#up_lote').val();
var qty = $('#up_qty').val();


maxqty = Number(maxqty); 
qty = Number(qty);

console.log(maxqty+' '+qty);

if(qty <= maxqty){ 



    if ( $('#up_route').val() && $('#up_stock').val()  && $('#up_qty').val() ){

    var datos= "url=ges_inventario/update_lote_location/"+STOCK_ROUTE_SRC+'/'+STOCK_NAME_SRC+'/'+id_location+'/'+ruta+'/'+almacen+'/'+lote+'/'+qty;


    var link= dir+"index.php";


    $.ajax({
        type: "GET",
        url: link,
        data: datos,
        success: function(res){
        //   $("#prueba").html(res);
        
            location.reload();
            }
        });

    }else{

    alert('Debe definir todos los parametros de ubicacion');

    }

}else{


alert('La cantidad a reubicar no debe ser mayor a la cantidad de items en el almacen','ok');
    location.reload();
}
    
    
}   