
var table;

jQuery(document).ready(function($)
{

$('#ERROR').hide();

table = $("#productos").DataTable({

    "createdRow": function( row, data, dataIndex){
      
        if( data['Stock ACIWEB'] != data['Stock PT']){
            $(row).addClass('redClass');
        }
    },
    
    "footerCallback": function ( row, data, start, end, display ) {
        var api = this.api(), data;
  
        // Remove the formatting to get integer data for summation
        var intVal = function ( i ) {
            return typeof i === 'string' ?
                i.replace(/[\$,]/g, '')*1 :
                typeof i === 'number' ?
                    i : 0;
        };
  
        // Total over all pages
        total = api
            .column( 3 )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
  
        // Total over this page
        pageTotal = api
            .column( 3, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
  
        // Update footer
        $( api.column( 3 ).footer() ).html(
          pageTotal.toLocaleString() +' ('+ total.toLocaleString() +' total)'
        );


    // Total over all pages
            totalPT = api
            .column( 4 )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );

            // Total over this page
            pageTotalPT = api
            .column( 4, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );

            // Update footer
            $( api.column( 4 ).footer() ).html(
            pageTotalPT.toLocaleString() +' ('+ totalPT.toLocaleString() +' total)'
            );




      },
      buttons: [ {
                extend: "excelHtml5",
                text: "Exportar a Excel",
                title: "Lista_productos",
                 
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
                      
                }],
    columns:[

        {data:"Codigo"},
        {data:"Descripcion"},
        {data:"Unidad",className: "numb"},
        {data:"Stock ACIWEB",className: "numb"},
        {data:"Stock PT",className: "numb"},
        {data:"Costo_Uni",className: "numb"}],

    
    
    });



   table2 = $("#itemXStock").DataTable({
        aLengthMenu: [
            [10, 25,50,-1], [10, 25, 50,"All"]
        ] ,
        columns:[
    
            {data:"Codigo"},
            {data:"Descripcion"},
            {data:"No_Lote"},
            {data:"Fecha_Venc"},
            {data:"Cantidad",className: "numb"},
            {data:"Almacen"},
            {data:"Descripcion_Almacen"},
            {data:"Ubicacion"},
            {data:"Modificado_el"}
        
            ],
            responsive: false,
            pageLength: 20,
            dom: "Brtip",
            bSort: false,
            select: false,
        
            info: false,
              buttons: [
                {
                extend: "excelHtml5",
                text: "Exportar a Excel",
                title: "Inventario_por_ubicacion",
                 
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

    $('#itemXStock tbody').on('click', 'tr', function () {
            
                    var data = table2.row( this ).data();
            
                    var URL = $('#URL').val();
                    var metodo= "url=ges_inventario/inv_info&item="+data['Codigo'];
                    var link= URL+"index.php?"+metodo;
            
                    window.location.replace(link); 
                });


    $('#productos tbody').on('click', 'tr', function () {

        var data = table.row( this ).data();

        var URL = $('#URL').val();
        var metodo= "url=ges_inventario/inv_info&item="+data['Codigo'];
        var link= URL+"index.php?"+metodo;

        window.location.replace(link); 
    });
    
    
   
    $("#productos").dataTable().yadcf(
    [
    {column_number : 0,
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
       
       }],

    {cumulative_filtering: true, 
    filter_reset_button_text: false}
    );

    $("#itemXStock").dataTable().yadcf(
        [
        {column_number : 0,
            select_type: "select2",
            select_type_options: { width: "100%" }
           
        },
        {column_number : 1,
         select_type: "select2",
         select_type_options: { width: "100%" }
        
        },
        {column_number : 5,
            select_type: "select2",
            select_type_options: { width: "100%" }
           
        },
        {column_number : 7,
            select_type: "select2",
            select_type_options: { width: "100%" }
           
        },
    
    
    
    ],
    
        {cumulative_filtering: true, 
        filter_reset_button_text: false}
        );
    
});

/*{column_number : 0,
     column_data_type: "html",
     html_data_type: "text" ,
     select_type: "select2",
     select_type_options: { width: "100%" }
    
    },*/

function getListItem(){
    
    //$('#listItem').html('Searching, please wait...');
    MSG_ERROR_RELEASE();
    
    MSG_ADVICE('Searching, please wait...',0);
              

    function getItems(){

        var URL = $('#URL').val();
        var metodo= "ges_inventario/getListItems";
        var link= URL+"index.php";
       
    
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
            $('#listItem').html("There's no Items to List");
        }else{
            MSG_ERROR_RELEASE();
            MSG_ADVICE("Loading items...",0);
            addRows(res);
        }

    });


    

    function addRows(items) {

        

        printTbl = $('#productos').DataTable();
           

        printTbl.clear();

        printTbl.rows.add(items.data).draw(); 

        MSG_ERROR_RELEASE();
        MSG_CORRECT("Done",0);

    }


}

function getListItemByStock(){
    
    //$('#listItem').html('Searching, please wait...');
    MSG_ERROR_RELEASE();
    
    MSG_ADVICE('Searching, please wait...',0);
              

    function getItems(){

        var URL = $('#URL').val();
        var metodo= "ges_inventario/getItemsStocksList";
        var link= URL+"index.php";
       
    
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
            $('#listItem').html("There's no Items to List");
        }else{
            MSG_ERROR_RELEASE();
            MSG_ADVICE("Loading items...",0);
            addRowsStock(res);
        }

    });

    function addRowsStock(items) {
        
                
        
                printTbl = $('#itemXStock').DataTable();
                   
        
                printTbl.clear();
        
                printTbl.rows.add(items.data).draw(); 
        
                MSG_ERROR_RELEASE();
                MSG_CORRECT("Done",0);
        
            }
    

    function addRows(items) {

        

        printTbl = $('#productos').DataTable();
           

        printTbl.clear();

        printTbl.rows.add(items.data).draw(); 

        MSG_ERROR_RELEASE();
        MSG_CORRECT("Done",0);

    }


}