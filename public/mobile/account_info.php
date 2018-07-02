<!--header -->
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
       <a href="#" data-panel="right" class="open-panel"><img src="assets/images/icons/white/user.png" alt="" title="" /></a>
      </div>
      
  </div>
<!--header -->
     
     
     <div id="pages_maincontent">
      
      <h2 class="page_title">Perfil de usuario</h2>
	  
     <div class="page_single layout_fullwidth_padding">	  

            <h2 id="Note"></h2>
            <div class="contactform">

            <form class="" id="ContactForm" method="post" action="">
              <label>Name</label>
              <input type="text" name="UserName" id="UserName" value="<?php echo $this->model->active_user_name.' '.$this->model->active_user_lastname; ?>" class="form_input"  readonly/>
              <label>Email</label>
              <input type="text" name="UserEmail" id="UserEmail" value="<?php echo $this->model->active_user_email; ?>" class="form_input " readonly />
              <label>Role</label>
              <input type="text" name="UserRole" id="UserRole" value="<?php echo $this->model->active_user_role; ?>" class="form_input" readonly />
              

<!-- 
              <fieldset>
                <div class="col-lg-12" > 
                <label >Password</label>						         
                <input type="password" class="form_input" id="pass_12" name="pass_12"  value="<?php echo $pass; ?>" required/>
                </div>
                <div class="col-lg-12" > 
                  <label >Repetir Password</label>					
                  <input type="password" class="form_input" id="pass_22" name="pass_22" value="<?php echo $pass; ?>" required/>
                </div>
              </fieldset>         

            <fieldset>
               <legend><h5>Autorizaciones</h5></legend>
              <?PHP //autorizaciones  
                    if ($mod_sales_CK == 'checked') { ?>
              <input type="CHECKBOX" name="pri_chk" <?php echo $price_mod;  ?> />&nbsp<label>Modificar de Precios</label><p class="help-block">(Autoriza modificacion de precios en Pedidos/Ordenes con venta directas)</p> 
              <input type="CHECKBOX" name="clo_chk" <?php echo $closeSO;  ?> />&nbsp<label>Cerrar Ordenes de ventas/Pedidos</label><p class="help-block">(Autoriza cerrar Pedidos/Ordenes de ventas)</p>
              <input type="CHECKBOX" name="amnt_chk" <?php echo $amountSO;  ?> />&nbsp<label>Visualizar Montos Ordenes de ventas/Pedidos</label><p class="help-block">(Autoriza a visualizar montos al crear Pedidos/Ordenes de ventas)</p>
              <?php } ?>
              <?PHP if ($mod_invt_CK  == 'checked') { ?>
              <input type="CHECKBOX" name="inv_chk" <?php echo $INV_CK;  ?> />&nbsp<label>Gestionar Inventario</label><br><p class="help-block">(Configuraciones y gestion de inventario)</p>
              <?php } ?>
              <?PHP if ($mod_stoc_CK  == 'checked') { ?>
              <input type="CHECKBOX" name="sto_chk" <?php echo $STO_CK;  ?> />&nbsp<label>Gestionar Ubicaciones</label><br><p class="help-block">(Reportes y gestion de ubicaciones de inventario)</p>
              <?php } ?>
              <?PHP if ($mod_rept_CK  == 'checked') { ?>
              <input type="CHECKBOX" name="rep_chk" <?php echo $REP_CK;  ?> />&nbsp<label>Gestionar Reportes</label><br><p class="help-block">(Generar reportes)</p>
              <?php } ?>
            </fieldset>

            <fieldset>
            <legend><h5>Notificaciones por correo</h5></legend>
            <?PHP //Notificaciones  
                 if ($mod_fact_CK == 'checked') { ?>
                <input type="CHECKBOX" name="fc_chk" <?php echo $notif_fc; ?> />&nbsp<label>Facturas de Compra</label>
            <?php } ?>
            <br>
            <?PHP if ($mod_req_CK  == 'checked') { ?>
              <input type="CHECKBOX" name="oc_chk" <?php echo $notif_oc; ?> />&nbsp<label>Requisiciones</label><br>
            <?php } ?>
            </fieldset>
            
            
            <?PHP //impresora 
                 if ($mod_sales_CK == 'checked') { ?>
            <div class="col-lg-6">
            <fieldset>
            <legend><h5>Impresora fiscal predeterminada</h5></legend>
              <select class='select col-lg-12' id='DefaultPrint' name='DefaultPrint' >
              <option value="" selected></option>
                <?PHP 

                    $list = $this->getPrinterList();
                    $Printers = '';
                    foreach ($list as $key => $value) {
                      $value = json_decode($value);

                        $Printers .= '<option value="'.$value->{'ID'}.'">'.$value->{'DESCRIPCION'}.' ( '.$value->{'SERIAL'}.') </option>';

                    }
                    
                    echo $Printers;

                ?>
              </select>
              <br>
              <label>Seleccionada: </label><input class='col-lg-12' type="text" name="printerAsigned"  value="<?php echo $PRINTER;  ?>" readonly/>

            </fieldset>
            </div>
            <?php } ?>

           
            <?PHP //rol de requisiciones  
                 if ($mod_req_CK == 'checked') { ?>
            <div class="col-lg-6">
            <fieldset>
            <legend><h5>Rol de usuario</h5></legend>
            <input type="CHECKBOX" name="rpurch_chk" <?php echo $rol_purc_value; ?> />&nbsp<label>Oficina</label> <p class="help-block">(Crea órdenes de compra y actualiza fechas de inicio de cotización. Mod. Requisiciones)</p>
            <input type="CHECKBOX" name="rfield_chk" <?php echo $rol_field_value; ?> />&nbsp<label>Campo</label><p class="help-block">(Crea requisiciones y reporta cantidades/fechas recibidas en órdenes de compra.  Mod. Requisiciones)</p>
            </fieldset>
            </div>
            <?php } ?>
            </fieldset>


            <div class="col-lg-4">
            <button   class="btn btn-primary  btn-block text-left" type="submit" >Actualizar</button>
            </div>
 -->
            </form>
            </div>
            

      <div class="clear"></div>
      </div>
      
      </div>
    </div>
  </div>
</div>