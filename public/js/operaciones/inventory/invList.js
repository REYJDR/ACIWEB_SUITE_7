
var table;

jQuery(document).ready(function($)
{

$('#ERROR').hide();

table = $("#productos").DataTable({
    aLengthMenu: [
        [10, 25,50,-1], [10, 25, 50,"All"]
    ]
    });
   
   /* $("#productos").dataTable().yadcf(
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
    );*/
    
});

function getListItem(){
    
    //$('#listItem').html('Searching, please wait...');
    MSG_ADVICE('Searching, please wait...',0);
              
    var URL = $('#URL').val();
    var metodo= "ges_inventario/getListItems";
    var link= URL+"index.php";
   

      $.ajax({
          type: "GET",
          url: link,
          dataType: 'json',
         // async:  false,
          data: {url:metodo} ,
          success: function(res){
          
            if(res == 0){
                MSG_ERROR("There's no Items to List",0);
                $('#listItem').html("There's no Items to List");
            }else{
              
                addRows(res);
            }
            
        
        }
       });

       function addRows(items) {
         
          MSG_ADVICE("Filling table...",0);
        
          printTbl = $('#productos').DataTable();
    
          printTbl.clear().draw();
   
           for(var m=0;m<items.length;m++){
               
                    
                data = JSON.parse(items[m]);
            
                printTbl.row.add( [
                    data.Codigo,
                    data.Descripcion,
                    data.Unidad,
                    data.Stock,
                    data.Costo_Uni

                ] ).draw( false );

                

            } 

            MSG_CORRECT("Done",0);

       }


}