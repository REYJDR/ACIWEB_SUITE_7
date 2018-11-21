jQuery(document).ready(function($)
{

$('#ERROR').hide();

var table = $("#productos").dataTable({
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
    
});

function getListItem(){
    
    $('#listItem').html('Loading, please wait...');
              
    var URL = $('#URL').val();
    var metodo= "ges_inventario/getListItem";
    var link= URL+"index.php";

      $.ajax({
          type: "GET",
          url: link,
          async: false,
          data: {url:metodo} ,
          success: function(res){
            $('#listItem').html(res);
            }
       });



}