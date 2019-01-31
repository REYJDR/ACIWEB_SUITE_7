
var table;

jQuery(document).ready(function($)
{

$('#ERROR').hide();

table = $("#productos").DataTable({
    aLengthMenu: [
        [10, 25,50,-1], [10, 25, 50,"All"]
    ] ,
    columns:[
        {data:"Codigo"},
        {data:"Descripcion"},
        {data:"Unidad"},
        {data:"Stock"},
        {data:"Costo_Uni"}]}    
    );
   
    $("#productos").dataTable().yadcf(
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

        
        console.log(items); 
      
        printTbl = $('#productos').DataTable();
           


        printTbl.clear();

        printTbl.rows.add(items.data).draw(); 

        MSG_ERROR_RELEASE();
        MSG_CORRECT("Done",0);

    }


}