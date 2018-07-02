 // ********************************************************
// * Aciones cuando la pagina ya esta cargada
// ********************************************************
$(window).load(function(){
    
    $('#ERROR').hide();
    
});
    

jQuery(document).ready(function($)
{
var table = $("#invoice").dataTable({
    bSort: false,
    select:true,
    aLengthMenu: [
    [25, 50, 100, 500 , -1], [25, 50, 100 , 500 , "All"]
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

},
{column_number : 2,
 select_type: "select2",
 select_type_options: { width: "100%" }

},
{column_number : 3,
 select_type: "select2",
 select_type_options: { width: "100%" }

},
{column_number : 4,
 select_type: "select2",
 select_type_options: { width: "100%" }

},
{column_number : 5,
 select_type: "select2",
 select_type_options: { width: "100%" }

}],
{cumulative_filtering: true, 
filter_reset_button_text: false}
);

});
	   

function SaleToInvoice(URL,id){
    
    
var datos= "url=ges_invoice/GetOrdrDetail/"+id;


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