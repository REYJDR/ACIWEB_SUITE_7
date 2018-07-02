<script>


// ********************************************************
// * Aciones cuando la pagina ya esta cargada
// ********************************************************
$(window).load(function(){

var TaxID=$("#taxid option:selected").html();
var Taxval=$("#taxid option:selected").val();
set_taxid(Taxval,1);


});


function set_taxid(rate,opt){
    
    var rate = rate/100;
    
    if(opt==1){
    
        document.getElementById('saletaxid').value =  rate;
    
      }else{
    
         r = confirm('Esta seleccion implica cambios en el calculo del total, desea proceder con este cambio?');
    
         if(r==true){
    
          document.getElementById('saletaxid').value =  rate;
    
          sumar_total();
    
         }
      }
    }
  </script>




<?php $amnt_view_ck = $this->model->Query_value('SAX_USER','amountSO','where SAX_USER.onoff="1" and SAX_USER.id="'.$this->model->active_user_id.'"');

echo '<input type="hidden" id="ANMT_VIEW" value="'.$amnt_view_ck.'" />'; 

if ($amnt_view_ck==0){

  $display = "display:none;";

} else{

  $display = "";

}

?>

<!--header-->
<div class="pages">
<div data-page="form" class="page no-toolbar no-navbar">
  <div class="page-content">
  
  <div class="navbarpages navbarpagesbg"> 
  <div class="navbar_left">
     <div class="logo_text">
     <a  class="navbar-brand" onClick="history.go(-1); return true;" ><i  class="fas fa-chevron-circle-left" >   </i></a> 
     <!-- <a href="<?php echo URL; ?>index.php?url=home/index">ACIWEB</a> -->
      </div>    
   </div>
     <!--<div class="navbar_right navbar_right_menu">
                <a href="#" data-panel="left" class="open-panel"><img src="i<?php echo URL; ?>assets/mages/icons/white/menu.png" alt="" title="" /></a>
          </div>	-->		
      <div class="navbar_right">
       <a href="#" data-panel="right" class="open-panel"><img src="<?php echo URL; ?>assets/images/icons/white/user.png" alt="" title="" /></a>
      </div>
      
  </div>
<!--header-->

<!-- contenido -->	

<input type="hidden" id='URL' value="<?php ECHO URL; ?>" />
<input type="hidden"  id="saletaxid"  value="" />
<input type="hidden"  id="listID"  value="" />

<div id="pages_maincontent">
     
    <h2 class="page_title">Pedido/Orden de venta</h2> 
     
     <div class="page_single layout_fullwidth_padding">
    

    
     <!--INI DIV ERRO-->

      <div id="ERROR" ></div>

      <!--INI DIV ERROR-->


     <div class="buttons-row">
                    <a href="#tab1" class="tab-link active button">Datos generales</a>
                    <a href="#tab2" class="tab-link button">Items</a>
                    <a href="#tab3" class="tab-link button">Resumen</a>
              </div>
              
              <div class="tabs-animated-wrap">
                    <div class="tabs">
                          <div id="tab1" class="tab active">
                                <!-- datos generales header -->

                                <div class="contactform">
         
                                  <!--cliente-->
                                  <div class="form_row custom_select">
                                  <a href="#" class="item-link smart-select" data-searchbar="true" data-searchbar-placeholder="Search">
                                  <div class="item-content">
                                    <div class="item-inner">
                                    <label>Cliente</label>
                                    <div class="item-after">Seleccionar cliente</div>
                                    </div>
                                  </div>
                                    <select  id="customer" name="selectors" class="select col-lg-8" onchange="set_listprice(this.value);" required>
                                    <option selected disabled>Seleccionar cliente</option>
                                      <?php  
                                          $CUST = $this->model->get_ClientList(); 
                                  
                                              foreach ($CUST as $datos) {
                                  
                                              $CUST_INF = json_decode($datos);
                                  
                                              if ($CUST_INF->{'Custom_field3'}!=''){
                                  
                                              $field3 =  ' ('.$CUST_INF->{'Custom_field3'}.') ';
                                  
                                              }else{
                                  
                                                $field3 = '';
                                              }
                                  
                                              echo '<option value="'.$CUST_INF->{'ID'}.'" >'.$CUST_INF->{'CustomerID'}.' - '.$CUST_INF->{'Customer_Bill_Name'}.$field3."</option>";
                                  
                                              }
                                      ?>
                                  </select>  
                                  </a>
                                </div>
                              <!--cliente-->

                              
                              <!--Lugar de despacho-->
                                  <div class="form_row custom_select">
                                  <a href="#" class="item-link smart-select" data-searchbar="true" data-searchbar-placeholder="Search">
                                  <div class="item-content">
                                    <div class="item-inner">
                                    <label>Lugar de despacho</label>
                                    <div class="item-after">Seleccionar lugar de despacho</div>
                                    </div>
                                  </div>
                                  <select  id="lugar_despacho" name="lugar_despacho" class="select col-lg-12"  required>
                                                  <?php 
                                  
                                                    $sql = 'SELECT * FROM SHIP_INFO WHERE id_compania="'.$this->model->id_compania.'"';
                                  
                                                    $ship = $this->model->Query($sql); 
                                  
                                                      foreach ($ship  as $datos) {
                                  
                                                          $datos  = json_decode($datos);
                                  
                                                          
                                                            echo '<option value="'.$datos->{'ShipAddress'}.'">'.$datos->{'ShipAddress'}.'</option>';
                                  
                                                      }
                                  
                                                  ?>
                                  </select>
                                  </a>
                                </div>
                              <!--Lugar de despacho-->

                              <!--TAX ID-->
                              <div class="form_row custom_select">
                                  <a href="#" class="item-link smart-select" data-searchbar="true" data-searchbar-placeholder="Search">
                                  <div class="item-content">
                                    <div class="item-inner">
                                    <label>TAX ID</label>
                                    <div class="item-after">Seleccionar tax id</div>
                                    </div>
                                  </div>
                                  <select  id="taxid" name="taxid" class="select col-lg-12" onchange="set_taxid(this.value,2);" required>

                                  <?php  

                                  $tax = $this->model->Get_sales_conf_Info(); 

                                  foreach ($tax  as $datos) {

                                    $tax  = json_decode($datos);

                                    if($tax->{'taxid'}=='ITBMS'){

                                      $selected = 'selected';

                                    }else{   

                                      $selected = '';

                                    }

                                  echo '<option value="'.$tax ->{'rate'}.'" '.$selected.'>'.$tax->{'taxid'}.'</option>';

                                  }

                                  ?>

                                </select>
                                  </a>
                                </div>
                              <!--TAX ID-->

                              <!--Termino de pago -->
                              <div class="form_row">
                                      <label>Termino de pago</label>
                                      <input type="text" class="form_input"  id="termino_pago" name="termino_pago" readonly />

                                      </div>
                              <!--Termino de pago -->

                              <!--Fecha de entrega<-->
                              <div class="form_row">
                                      <label>Fecha de entrega</label>
                                      <input type="text" class="form_input" id="fecha_entrega" onkeyup="checkNOTA(this.id);" name="fecha_entrega"/>

                                      </div>
                              <!--Fecha de entrega<-->

                              <!--observaciones<-->
                              <div class="form_row">
                              <label>Observaciones</label>
                                    <textarea onkeyup="checkNOTA(this.id);" id="observaciones" name="observaciones" class="form_textarea textarea required" rows="" cols=""></textarea>
                                </div> 
                              <!--observaciones<-->
                             
                              </div>
                                    

                         <!-- fin header-->
                          </div>
    
                         <!--items-->
                          <div id="tab2" class="tab">
                         
                            <!-- FORM  ADD ITEM -->
                             <div class="contactform">
         
                                <!--list items-->
                                  <div class="form_row custom_select">
                                  <a href="#" class="item-link smart-select" data-searchbar="true" data-searchbar-placeholder="Buscar">
                                  <div class="item-content">
                                    <div class="item-inner">
                                    <label>Item ID</label>
                                    <div class="item-after">Seleccionar item</div>
                                    </div>
                                  </div>
                                     <div id="listSelect" ></div>
                                  </a>
                                </div>
                                <!--fin list items-->

                                <!--desc items-->
                                <div class="form_row">
                                      <label>Descripción</label>
                                      <input type="text" onkeyup="checkArroba(this.id);"  class="form_input" id="desc" name="desc" />
                                </div>
                                <!--desc items-->

                                <!--UnitMeassure items-->
                                 <div class="form_row">
                                      <label>Unidad</label>
                                      <input type="text"  class="form_input" id="unit"  name="unit" readonly/>
                                </div>

                                <!--UnitPrice item-->
                                <div class="form_row">
                                      <label>Precio Unitario</label>
                                      <input type="text" class="form_input" id="unitprice"  name="unitprice" readonly/>
                                </div>
                                 <!--UnitPrice item-->

                                <!--nota items-->
                                <div class="form_row">
                                      <label>Nota</label>
                                      <input type="text" onkeyup="checkArroba(this.id);"  class="form_input" id="nota" name="nota" />
                                </div>
                                <!--nota items-->
                                
                                <!--Chico-->
                                <div class="form_row">
                                      <label>Chico</label>
                                      <input type="number"  min='0' class="form_input" id="chico"  name="chico" />
                                </div>
                                <!--Chico-->

                                <!--Grande-->
                                <div class="form_row">
                                      <label>Grande</label>
                                      <input type="number" min='0' class="form_input" id="grande"  name="grande" />
                                </div>
                                <!--fin Grande-->

                                <!--Cantidad-->
                                 <div class="form_row">
                                      <label>Cantidad</label>
                                      <input type="number" min='0' class="form_input" id="qty"  name="qty" />
                                </div>
                                <!--fin Cantidad-->

                                <div class="form_row">
                                  <input onclick='addItem();' type="submit" name="submit" class="form_submit" id="submit" value="Agregar item" />
                                </div>

                            </div>
                             <!--FIN  FORM  ADD ITEM -->

                         <!-- fin items-->
                          </div> 

                         <!-- resumen-->
                          <div id="tab3" class="tab">
                                <!--item agregados -->

                                  <!--init list item -->
                                  <div class="cartcontainer" >            

                                    
                                    <table  class="responsive_table" id="ItemAdded" >
                                      <tr class="table_row" >
                                      <td class="table_section_small" >Item ID</td>
                                      <td class="table_section">Descripción</td>
                                      <td class="table_section">Nota</td>
                                      <td class="table_section_qty" >Cant.</td>
                                      <td class="table_section_qty" >Precio</td>
                                      <td class="table_section_qty dplynone" >Chico</td>
                                      <td class="table_section_qty dplynone" >Grande</td>
                                      <td class="table_section_qty dplynone" >Unidad</td>
                                      <td class="table_section_qty dplynone" >Taxable</td>
                                      <td class="table_section_qty dplynone" >stock</td>
                                     </tr>
                                    </table>


                                     <div class="carttotal">
                                        <div class="carttotal_row">
                                        <div class="carttotal_left">Sub total</div><div class="carttotal_right"><input style="text-align:right; width:100%;" type="number"  step="0.01" id="subtotal" name="subtotal"  value="0.00" readonly /></div>
                                        </div>
                                        <div class="carttotal_row">
                                        <div class="carttotal_left">Tax</div><div class="carttotal_right"><input style="text-align:right; width:100%;" type="number"  step="0.01" id="tax" name="tax" value="0.00" readonly/></div>
                                        </div>
                                        <div class="carttotal_row_last">
                                        <div class="carttotal_left">Total</div><div class="carttotal_right"><input style="text-align:right; width:100%;" type="number"  step="0.01" id="total" name="total" value="0.00" readonly /></div>
                                        </div>
                                    </div>
                                    <a onclick="send();" href="#" class="button_full btyellow">Procesar</a>                                       
                                 </div>
  
                                <!--fin item agregador -->
                          </div> 
                          
                         <!--resumen-->
                  </div>
              </div>
            
<!-- contenido -->
    </div>
  </div>
</div>