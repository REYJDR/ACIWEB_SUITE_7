// ********************************************************
// * Aciones cuando la pagina ya esta cargada
// ********************************************************
$(window).load(function(){
    
    $('#ERROR').hide();
    $('#loc').hide();
    $('#item').hide();
    getStocks();

    
});


var table;

jQuery(document).ready(function($)
{

$('#ERROR').hide();

table = $("#listItemByStock").DataTable({
    aLengthMenu: [
        [10, 25,50,-1], [10, 25, 50,"All"]
    ] ,
    columns:[

        {data:"ProductID"},
        {data:"lote"},
        {data:"QtyOnHand",className: "numb"}    ]}    
    );


         
    $('#listItemByStock tbody').on('click', 'tr', function () {

        var data = table.row( this ).data();

        var URL = $('#URL').val();
        var metodo= "url=ges_inventario/inv_info&item="+data['ProductID'];
        var link= URL+"index.php?"+metodo;

        window.location.replace(link); 
    });
    
    
   
    $("#listItemByStock").dataTable().yadcf(
    [
    {column_number : 0,
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



function getStocks(){

URL = document.getElementById('URL').value;
link = URL+"index.php";
data = 'url=ges_inventario/getStockList/';

$('#stockList').html('Searching...');


$.ajax({
    type: "GET",
    url: link,
    data: data ,
    success: function(res){
        
        if(res != ''){

            $('#stockList').html(res);


        }else{
            $('#stockList').html('There´s no stocks information');
        }

        $('#stockList').append('<tr>'+
        '<td>Agregar <a data-toggle="modal" data-target="#AddStock"   href="#"><i  style="color: green;" class="fa fa-plus"></i></a></td>'+
        '</tr>');
    } 
});



}

function getLocation(stock){

URL = document.getElementById('URL').value;
link = URL+"index.php";
data = 'url=ges_inventario/getLocationList/'+stock;

document.getElementById('idStock').value = stock;

$('#location').html('Searching...');
$('#item').html('');
$('#loc').show();



$.ajax({
        type: "GET",
        url: link,
        data: data ,
        success: function(res){
            

            if(res != ''){

                var add = '<tr><td>Agregar <a data-toggle="modal" data-target="#AddLoc"  href="#"><i onclick="crear_almacen();" style="color: green;" class="fa fa-plus"></i></a></td></tr>';
                
                $('#location').html(res+add);

            }else{
                $('#location').html('There´s no information');
            }
        } 
    });


data = 'url=ges_inventario/getStockInfo/'+stock;
$('#info').html('Searching...');

$.ajax({
        type: "GET",
        url: link,
        data: data ,
        success: function(res){
            
            if(res != ''){
                $('#info').html(res);
            }
        } 
    });


}

function  getItemList(location,stock,locName){

    $('#locLegend').html('<p>Location: '+locName+'</p>');
    
    var URL = $('#URL').val();
    var metodo= 'ges_inventario/getItemList/'+location+'/'+stock;
    var link= URL+"index.php";
       
    function  getItems(){
         return $.ajax({
              type: "GET",
              url: link,
              dataType: 'json',
             // async:  false,
              data: {url:metodo} ,
              success: function(res){
                
            }
           });

    }
    $.when(getItems()).done(function(res){ 

        if(res == 0){
            MSG_ERROR_RELEASE();
            MSG_ERROR("There's no Items to List",0);
           
        }else{
            MSG_ERROR_RELEASE();
            MSG_ADVICE("Loading items...",0);
            addRows(res);
            
        }

    });



}

function addRows(items) {
    

    printTbl = $('#listItemByStock').DataTable();
        
    printTbl.clear();

    printTbl.rows.add(items.data).draw(); 

    MSG_ERROR_RELEASE();
    MSG_CORRECT("Done",0);
    $('#item').show();

}

function addStock(){

URL = document.getElementById('URL').value;
link = URL+"index.php";
method = 'url=ges_inventario/addStock/';
data   = $("#addStock").serialize();

$.ajax({
    type: "GET",
    url: link,
    data: method+'&'+data,
    success: function(res){

     if(res == 0){

        MSG_CORRECT('Se ha creado correctamente',0);
        getStocks();
     }else{

        MSG_ERROR(res,0);

     }
    
    } 
});

}

function addLoc(){

    idStock = document.getElementById('idStock').value ;

    URL = document.getElementById('URL').value;
    link = URL+"index.php";
    method = 'url=ges_inventario/addLoc/'+idStock;
    data   = $("#Addlocation").serialize();
    
    $.ajax({
        type: "GET",
        url: link,
        data: method+'&'+data,
        success: function(res){
    
         if(res == 0){
    
            MSG_CORRECT('Se ha creado correctamente',0);
            getLocation(idStock);
         }else{
    
            MSG_ERROR(res,0);
            
         }
        
        } 
    });
    
}

function setTableStyle(){

    var table = $("#tblItem").dataTable({
        aLengthMenu: [
            [10, 25,50,-1], [10, 25, 50,"All"]
        ]
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

}

function removeStock(id) {

    alert('remove'+id);
}

function removeLoc(id) {
    
    alert('remove'+id);
}

/* jQuery(document).ready(function($)
{
$("#crear_alm_imp").hide();
    
    document.getElementById("stock").addEventListener("change", setalamacen);

    function setalamacen(){

        ALAMCEN_ID = document.getElementById("stock").value;

        $("#alm_id").html('A'+ALAMCEN_ID);
    }

document.getElementById("stock_estand").addEventListener("change", setmueble);

    function setmueble(){

        mueble_ID = document.getElementById("stock_estand").value;

        $("#stand_id").html('M'+mueble_ID);
    }

document.getElementById("stock_column").addEventListener("change", setcolum);

function setcolum(){

        colum_ID = document.getElementById("stock_column").value;

        $("#colum_id").html('C'+colum_ID);
    }

document.getElementById("stock_row").addEventListener("change", setrow);

function setrow(){

        ROW_ID = document.getElementById("stock_row").value;

        $("#row_id").html('F'+ROW_ID);
    }



});  */


