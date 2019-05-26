

<!--ini aqui va el menu de acceso rapido-->
<fieldset class="fieldsetDash">

<div class="tab">

<fieldset class="fieldsetform">
    <table class='table_form' >
        <tbody>

            <?php if( $home != 'home'){ ?>
             <tr><th><button class="tablinks" onclick="goHome();" ><i class="fas fa-tachometer-alt fa-2x icon-color-home" > </i> <?php echo $dash_menu_8; ?></button></th></tr>    
            <?php } 
            
            if($mod_cust_CK == 'checked'){ ?>
            <tr><th><button class="tablinks" onclick="openCity(event, 'menu1')" id="defaultOpen"><i class="fas fa-users fa-2x icon-color-dash" > </i> <?php echo $dash_menu_1; ?></button></th></tr> 
            <?php } 
            
            if($mod_sales_CK == 'checked'){?>
            <tr><th><button class="tablinks" onclick="openCity(event, 'menu2')"><i class="fas fa-chart-line fa-2x icon-color-dash" > </i><?php echo $dash_menu_2; ?></button></th></tr>
            <?php } 

            if($mod_req_CK == 'checked' ){ ?>
            <tr><th><button class="tablinks" onclick="openCity(event, 'menu3')"><i class="fas fa-shopping-cart  fa-2x icon-color-dash" > </i><?php echo $dash_menu_3; ?></button></th></tr>
            <?php } 
            
            if($mod_invt_CK == 'checked' ){ ?>
            <tr><th><button class="tablinks" onclick="openCity(event, 'menu4')"><i class="fas fa-boxes  fa-2x icon-color-dash" > </i><?php echo $dash_menu_4; ?></button></th></tr>
            <?php }  

            if($INF_REP==1){?>
            <tr><th><button class="tablinks" onclick="openCity(event, 'menu5')"><i class="fas fa-list-alt fa-2x icon-color-dash" > </i><?php echo $dash_menu_5; ?></button></th></tr>
            <?php } 

            if($this->model->active_user_role=='admin'){?>
            <tr><th><button class="tablinks" onclick="openCity(event, 'menu6')"><i class="fas fa-wrench fa-2x icon-color-dash" > </i><?php echo $dash_menu_6; ?></button></th></tr>
            <?php } ?>
          
            <tr><th><button class="tablinks" onclick="goOut();"><i class="fas fa-sign-out-alt fa-2x icon-color-out" > </i><?php echo $dash_menu_7; ?></button></th></tr>					

        </tbody>
    </table>
</fieldset>

</div>
            
<div id="menu1" class="tabcontent">
    <div class='col-lg-12'>

    <!--INI MENU CUSTOMERS-->
    <?php if($mod_cust_CK == 'checked'){?>
        <div class='col-lg-3'>
            <button  onclick="window.location='<?PHP ECHO URL; ?>index.php?url=ges_customers/PricesList'" class="dashBottom" >
            <?php echo $SUBMENU_cust1; ?>
            </button>
        </div>
        <div class='col-lg-3'>
            <button  onclick="window.location='<?PHP ECHO URL; ?>index.php?url=ges_customers/AddCustomer'" class="dashBottom" >
            <?php echo $SUBMENU_cust2; ?>
            </button>
        </div>
    <?php } ?>
    <!--END MENU CUSTOMERS-->

    </div>
</div>

<div id="menu2" class="tabcontent">	
    <!--INI MENU SALES-->
    <div class='col-lg-12'>
    <?php if($mod_sales_CK == 'checked'){?>
        <?php if($mod_invt_CK == 'checked' ){ ?>
            <div class='col-lg-3'>
            <button  onclick="window.location='<?PHP ECHO URL; ?>index.php?url=ges_ventas/SalesOrderSto'" class="dashBottom" >
             <?php echo $SUBMENU_sales1; ?>
            </button>
            </div>
        <?php }else{ ?>
            <div class='col-lg-3'>
            <button onclick="window.location='<?PHP ECHO URL; ?>index.php?url=ges_ventas/SalesOrder'" class="dashBottom" ><?php echo $SUBMENU_sales2; ?></button>
            </div>
        <?php } if($mod_invo_CK == 'checked'){ ?>
            <div class='col-lg-3'>
            <button onclick="window.location='<?PHP ECHO URL; ?>index.php?url=ges_invoice/Init'" class="dashBottom" ><?php echo $SUBMENU_sales3; ?></button>
            </div>
            <div class='col-lg-3'>
            <button onclick="window.location='<?PHP ECHO URL; ?>index.php?url=ges_notasdecredito/Init'" class="dashBottom" ><?php echo $SUBMENU_sales4; ?></button>				
            </div>
        <?php } ?>
    <?php } ?>
    </div>
    <!--END MENU SALES-->
</div>

<div id="menu3" class="tabcontent">		
    <!--INI MENU REQUISICIONES-->
    
    <div class='col-lg-12'>
    <?php  if($mod_req_CK == 'checked' ){

        if($this->model->rol_campo=='1'){ ?>  
            
            <div class='col-lg-3'>
            <button onclick="window.location='<?PHP ECHO URL; ?>index.php?url=ges_requisiciones/req_crear'" class="dashBottom" ><?php echo $SUBMENU_req1; ?></button>				
            </div>
            <div class='col-lg-3'>
            <button onclick="window.location='<?PHP ECHO URL; ?>index.php?url=ges_requisiciones/req_pago'" class="dashBottom" ><?php echo $SUBMENU_req2; ?></button>				
            </div>
            <div class='col-lg-3'>
            <button onclick="window.location='<?PHP ECHO URL; ?>index.php?url=ges_requisiciones/req_reception/0'" class="dashBottom" ><?php echo $SUBMENU_req3; ?></button>				
            </div>

        <?php }  } ?>
    </div>
    <!--END MENU REQUISICIONES-->
</div>

<div id="menu4" class="tabcontent">
    <!--INI MENU INVENTORY-->
    <div class='col-lg-12'>
    <?php   if($mod_invt_CK == 'checked' and $INF_INV==1 ){?>
        <div class='col-lg-3'>
        <button onclick="window.location='<?PHP ECHO URL; ?>index.php?url=ges_inventario/InvIn'" class="dashBottom" ><?php echo $SUBMENU_inv4; ?></button>				
        </div>
        <div class='col-lg-3'>
        <button onclick="window.location='<?PHP ECHO URL; ?>index.php?url=ges_inventario/inv_list'" class="dashBottom" ><?php echo $SUBMENU_inv1; ?></button>				
        </div>
        <div class='col-lg-3'>
        <button onclick="window.location='<?PHP ECHO URL; ?>index.php?url=ges_consignaciones/con_crear'" class="dashBottom" ><?php echo $SUBMENU_inv2; ?></button>				
        </div>
        <div class='col-lg-3'>
        <button onclick="window.location='<?PHP ECHO URL; ?>index.php?url=ges_inventario/InvOut'" class="dashBottom" ><?php echo $SUBMENU_inv3; ?></button>				
        </div>
        <?php if($mod_sales_CK != 'checked'){?>
        <div class='col-lg-3'>
            <button  onclick="window.location='<?PHP ECHO URL; ?>index.php?url=ges_ventas/SalesOrderSto'" class="dashBottom" >
             <?php echo $SUBMENU_sales5; ?>
            </button>
            </div>
        <?php } ?>
    <?php } ?>

    <?php if($mod_stoc_CK  == 'checked' and $INF_STO==1){?>
        <div class='col-lg-3'>
        <button onclick="window.location='<?PHP ECHO URL; ?>index.php?url=ges_inventario/location'" class="dashBottom" ><?php echo $SUBMENU_stock1; ?></button>				
        </div>
    <?php } ?>

    </div>	
    <!--END MENU INVENTORY-->	

</div>
<!--INI MENU REPORTES-->	
<div id="menu5" class="tabcontent">

   <div class='col-lg-12'>
   <?php  if($INF_REP==1){?>

    <?php if($mod_req_CK== 'checked' ){?>
        <div class='col-lg-3'>
        <button onclick="window.location='<?PHP ECHO URL; ?>index.php?url=ges_requisiciones/repReports/'" class="dashBottom" ><?php echo $SUBMENU_rep7; ?></button>              
        </div>
        <div class='col-lg-3'>
        <button onclick="window.location='<?PHP ECHO URL; ?>index.php?url=ges_requisiciones/reqReports/'" class="dashBottom" ><?php echo $SUBMENU_req4; ?></button>				
        </div>
    <?php } ?>

    <?php if($mod_sales_CK== 'checked' ){?>
        <div class='col-lg-3'>
        <button onclick="window.location='<?PHP ECHO URL; ?>index.php?url=ges_ventas/SalesOrderReport/'" class="dashBottom" ><?php echo $SUBMENU_rep1; ?></button>              
        </div>
        <div class='col-lg-3'>
        <button onclick="window.location='<?PHP ECHO URL; ?>index.php?url=ges_ventas/SalesReport/'" class="dashBottom" ><?php echo $SUBMENU_rep2; ?></button>              
        </div>

    <?php } ?>

    <?php if($mod_invt_CK == 'checked' and $INF_INV==1 ){?>
        <div class='col-lg-3'>
        <button onclick="window.location='<?PHP ECHO URL; ?>index.php?url=ges_inventario/InvInReport/'" class="dashBottom" ><?php echo $SUBMENU_rep8; ?></button>              
        </div>
        
        <div class='col-lg-3'>
        <button onclick="window.location='<?PHP ECHO URL; ?>index.php?url=ges_inventario/invStocklist/'" class="dashBottom" ><?php echo $SUBMENU_rep9; ?></button>              
        </div>

    <?php } ?>


    <?php } ?>
    </div>
    
</div>
<!--END MENU REPORTES-->	


<div id="menu6" class="tabcontent">
    <!--INI MENU CONFIG-->
    <div class='col-lg-12'>
    <?php if($this->model->active_user_role=='admin'){?>
        <div class='col-lg-3'>
        <button onclick="window.location='<?PHP ECHO URL; ?>index.php?url=home/config_sys'" class="dashBottom" ><?php echo $SUBMENU_conf3; ?></button>				
        </div>
    <?php } ?>
    </div>
   <!--END MENU CONFIG-->
</div>

</fieldset>

