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

        jQuery(document).ready(function($)
        
          {
        
           var table = $("#table_customer").dataTable({
           rowReorder: {
                    selector: "td:nth-child(2)"
                },
        
              responsive: false,
              pageLength: 100,
              dom: "Bfrtip",
              bSort: false,
              select:false,
              scrollY: "500px",
              scrollCollapse: true,
        
                buttons: [
        
                  {
        
                  extend: "excelHtml5",
                  text: "Exportar",
                  title: "Reporte_Lista_Precios",
        
                   
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

});

//VARIABLES GLOBALES

var lang = get_lang();


    function set_div(val){
    
    //OCULTA/MUESTRA EL DIV SEGUN SELECION DEL CHECKBOX PARA CREAR UN NUEVO CLIENTE
        if(val=='1'){
    
          $('#new_cus').show();
          $('#list_cus').hide();      
    
        }else{
    
          $('#new_cus').hide();
          $('#list_cus').show();
    
        }
    
    
    
    }

    function set_cus_info(cus_ID,cus_name,cus_tlf,cus_contact,cus_country,cus_state,cus_city,cus_zip,cus_email,cus_pl,cus_balance,cus_CL,cus_acct,cus_salesRep,cus_BA,cus_SA){

      //SETEA VALORES ACTUALES DEL CLIENTE EN EL MODAL

      document.getElementById('cus_modal_id').value = cus_ID;
      document.getElementById('cus_modal_name').value = cus_name;
      document.getElementById('cus_modal_telf').value = cus_tlf;
      document.getElementById('cus_modal_contact').value = cus_contact;
      document.getElementById('cus_modal_country').value = cus_country;
      document.getElementById('cus_modal_state').value = cus_state;
      document.getElementById('cus_modal_city').value = cus_city;
      document.getElementById('cus_modal_zip').value = cus_zip;
      document.getElementById('cus_modal_email').value = cus_email;
      document.getElementById('cus_modal_pl').value = cus_pl;
      document.getElementById('cus_modal_balance').value = cus_balance;
      document.getElementById('cus_modal_creditLimit').value = cus_CL;
      document.getElementById('cus_modal_AcctId').value = cus_acct;
      document.getElementById('cus_modal_SalesRep').value = cus_salesRep;
      document.getElementById('cus_modal_BillingAddr').value = cus_BA;
      document.getElementById('cus_modal_ShippingAddr').value = cus_SA;


    }

    function mod_cus(){


      //LEYENDO LOS VALORES MODIFICADOS

      var cus_ID = document.getElementById('cus_modal_id').value;
      var cus_name = document.getElementById('cus_modal_name').value;
      var cus_tlf = document.getElementById('cus_modal_telf').value;
      var cus_contact = document.getElementById('cus_modal_contact').value;
      var cus_country = document.getElementById('cus_modal_country').value;
      var cus_state = document.getElementById('cus_modal_state').value;
      var cus_city = document.getElementById('cus_modal_city').value;
      var cus_zip = document.getElementById('cus_modal_zip').value;
      var cus_email = document.getElementById('cus_modal_email').value;
      var cus_pl = document.getElementById('cus_modal_pl').value;
      var cus_balance = document.getElementById('cus_modal_balance').value;
      var cus_CL = document.getElementById('cus_modal_creditLimit').value;
      var cus_acct = document.getElementById('cus_modal_AcctId').value;
      var cus_salesRep = document.getElementById('cus_modal_SalesRep').value;
      var cus_BA = document.getElementById('cus_modal_BillingAddr').value;
      var cus_SA = document.getElementById('cus_modal_ShippingAddr').value;


    datos= [];
    datos[0] = '@'+cus_ID+'@'+cus_name+'@'+cus_tlf+'@'+cus_contact+'@'+cus_country+'@'+cus_state+'@'+cus_city+'@'+cus_zip+'@'+cus_email+'@'+cus_pl+'@'+cus_balance+'@'+cus_CL+'@'+cus_acct+'@'+cus_salesRep+'@'+cus_BA+'@'+cus_SA;
    console.log(datos);

 $.ajax({
      type: "GET",
      url: link,
      data: {url: 'ges_customers/mod_cus', Data : JSON.stringify(datos) },
      success: function(res){

        if (res == '1') {

          if (lang = 'es') {

             MSG_CORRECT('El cliente ha sido modificado exitosamente.',0); 

          }else{

             MSG_CORRECT('Customer is modified successfully!.',0); 
          }              
        }             
    }
  });

      //LIMPIANDO EL MODAL

      document.getElementById('cus_modal_id').value = '';
      document.getElementById('cus_modal_name').value = '';
      document.getElementById('cus_modal_telf').value = '';
      document.getElementById('cus_modal_contact').value = '';
      document.getElementById('cus_modal_country').value = '';
      document.getElementById('cus_modal_state').value = '';
      document.getElementById('cus_modal_city').value = '';
      document.getElementById('cus_modal_zip').value = '';
      document.getElementById('cus_modal_email').value = '';
      document.getElementById('cus_modal_pl').value = '';
      document.getElementById('cus_modal_balance').value = '';
      document.getElementById('cus_modal_creditLimit').value = '';
      document.getElementById('cus_modal_AcctId').value = '';
      document.getElementById('cus_modal_SalesRep').value = '';
      document.getElementById('cus_modal_BillingAddr').value = '';
      document.getElementById('cus_modal_ShippingAddr').value = '';

    }

    function del_cus(cus_ID){



         $.ajax({
              type: "GET",
              url: link,
              data: {url: 'ges_customers/del_cus', Data : JSON.stringify(datos) },
              success: function(res){

                if (res == '1') {

                  if (lang = 'es') {

                     MSG_CORRECT('El cliente ha sido borrado exitosamente.',0); 

                  }else{

                     MSG_CORRECT('Customer has been successfully deleted!.',0); 
                  }              
                }             
            }
          });

    }