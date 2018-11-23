
var table;

jQuery(document).ready(function($)
{

$('#ERROR').hide();

table = $("#productos").DataTable({
    aLengthMenu: [
        [10, 25,50,-1], [10, 25, 50,"All"]
    ]
    });
   
    $("#productos").dataTable().yadcf(
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
    
});

function getListItem(){
    
    $('#listItem').html('Loading, please wait...');
              
    var URL = $('#URL').val();
    var metodo= "ges_inventario/getListItems";
    var link= URL+"index.php";
   

      $.ajax({
          type: "GET",
          url: link,
          dataType: 'json',
          data: {url:metodo} ,
          success: function(res){

        // $('#listItem').html(''); 
        // $('#listItem').append(res);

        console.log(res);

       printTbl = $('#productos').DataTable();
        
      printTbl.rows.add(res);
      printTbl.draw();
         
      //   $('#productos').DataTable().draw();
        //  table.clear().draw();
   
         /*   for(var m=0;m<res.length;m++){
            

                printTbl.row.add( [
                    res[m]
                ] ).draw( false );



            } */
        }
       });



}