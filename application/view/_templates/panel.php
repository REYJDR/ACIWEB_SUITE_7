 

<?php
require_once APP.'view/'.basename(__DIR__).'/lang/'.$this->model->lang.'_ref.php';


//RECUPERO INFO DE DETALLES DE MODULOS ACTIVOS
$SQL = 'SELECT * FROM MOD_MENU_CONF';

$MOD_MENU = $this->model->Query($SQL);

foreach ($MOD_MENU as $value) {

$value = json_decode($value);

ECHO $value->{'closeSO'};

if($value->{'mod_sales'}=='1'){ $mod_sales_CK = 'checked';  }else{ $mod_sales_CK = '';   }
if($value->{'mod_invo'}=='1') { $mod_invo_CK  = 'checked';  }else{ $mod_invo_CK  = '';   }
if($value->{'mod_fact'}=='1') { $mod_fact_CK  = 'checked';  }else{ $mod_fact_CK  = '';   }
if($value->{'mod_invt'}=='1') { $mod_invt_CK  = 'checked';  }else{ $mod_invt_CK  = '';   }
if($value->{'mod_rept'}=='1') { $mod_rept_CK  = 'checked';  }else{ $mod_rept_CK  = '';   }
if($value->{'mod_stock'}=='1'){ $mod_stoc_CK  = 'checked';  }else{ $mod_stoc_CK  = '';   }
if($value->{'mod_pro'}=='1' )  { $mod_pro_CK   = 'checked';  }else{ $mod_pro_CK  = '';   }
if($value->{'mod_req'}=='1' )  { $mod_req_CK   = 'checked';  }else{ $mod_req_CK  = '';   }
if($value->{'mod_cust'}=='1' )  { $mod_cust_CK   = 'checked';  }else{ $mod_cust_CK  = '';   }


}


$res = $this->model->Query('SELECT * FROM SAX_USER  where SAX_USER.onoff="1" and SAX_USER.id="'.$this->model->active_user_id.'";');
 
foreach ($res as $value) {

  $value = json_decode($value);

  $INF_OC= $value->{'notif_oc'};
  $INF_FC= $value->{'notif_fc'};
  $INF_PRICE= $value->{'mod_price'};
  $INF_INV= $value->{'inv_view'};
  $INF_STO= $value->{'stoc_view'};
  $INF_REP= $value->{'rep_view'};
  $PHOTO  = $value->{'photo'};
  $close_sales_ck = $value->{'closeSO'};

  if($PHOTO == 'x'){
   $user_avatar = URL.'img/user_avatar/'.$this->model->active_user_id.'.jpg';
  }else{
   $user_avatar = URL.'img/default-avatar.png';
  }


  if($INF_OC==1){//notificaciones requisiciones
  $notif_oc = 'checked';
  }else{
  $notif_oc = ''; 
  }

  if($INF_FC==1){//notificaciones acturas
  $notif_fc = 'checked';
  }else{
  $notif_fc = ''; 
  }

  if($INF_PRICE==1){//modificar precio
  $price_mod = 'checked';
  }else{
  $price_mod = '';  
  }
  if($INF_INV==1){
  $INV_CK = 'checked';
  }else{
  $INV_CK = ''; 
  }
  if($INF_STO==1){
  $STO_CK = 'checked';
  }else{
  $STO_CK = ''; 
  }
  if($INF_REP==1){
   $REP_CK = 'checked';
  }else{
   $REP_CK = ''; 
  }
}
?>

<!-- MENU BAR -->
<div id='cssmenu'>
<ul>
  <!-- Icon Bar -->
  <div class="navbar-header">
  <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-collapse">
    <span class="sr-only"></span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
  </button>

  <a  class="navbar-brand" onClick="history.go(-1); return true;" ><i  class="fas fa-arrow-circle-left  fa-ms  icon-color-arrows" ></i></a>
  <a  class="navbar-brand" onClick="history.go(+1); return true;" ><i  class="fas fa-arrow-circle-right  fa-ms  icon-color-arrows" ></i></a>
  <a  class="navbar-brand" onClick="location.reload();" ><i  class="fas fa-sync  fa-ms   icon-color-arrows" ></i></a>
  <a  class="navbar-brand"  data-toggle="modal" data-target="#SlideMenu" ><i  class="fas fa-bars fa-ms  icon-color-dash" ></i></a>
 <!--href="<?PHP ECHO URL; ?>index.php?url=home/index"-->
</div>
<!-- Icon Bar -->
 


  <!--INI MENU CONFIG-->
  <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
        <a tabindex="0" data-toggle="dropdown" data-submenu="" aria-expanded="false">
            <img class='icon profile'  src="<?php echo  $user_avatar; ?>" /> <?php echo $this->model->active_user_name; ?><span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
        <li><a tabindex="0" title="Ir al perfil de usuario"  href="<?PHP ECHO URL; ?>index.php?url=home/edit_account/<?php echo $this->model->active_user_id; ?>"><img class='icon' src="img/Contact.png" /><?php echo $SUBMENU_conf1; ?></a></li>

        <?php if($this->model->active_user_role=='admin'){?>
        
        <li><a tabindex="0" title="Administrar Usuarios" href="<?PHP ECHO URL; ?>index.php?url=home/accounts" ><img class='icon' src="img/Users.png" /><?php echo $SUBMENU_conf2; ?></a></li>
        <li><a tabindex="0" title="Configuracion"  href="<?PHP ECHO URL; ?>index.php?url=home/config_sys" ><img  class='icon' src="img/Cog.png" /><?php echo $SUBMENU_conf3; ?></a></li>
        
        <?php } ?>
                 
        <li><a  title="Salir del sistema" href="<?PHP ECHO URL; ?>index.php?url=login/login_out/" ><img  class='icon' src="img/Shut.png" /><?php echo $SUBMENU_conf4; ?></a></li>
        </ul>
       </li>
  </ul>
  <!--END MENU CONFIG-->

</ul>
</div>
<!-- MENU BAR -->





	<!-- Modal -->
	<div class="modal left fade" id="SlideMenu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modalmenu-dialog" role="document">
			<div class="modalmenu-content">


				<div class="modalmenu-body">
        <div class='col-lg-12'>
        <?PHP require APP.'view/home/Tabmenu.php'; ?>
        </div>
				</div>

			</div><!-- modal-content -->
		</div><!-- modal-dialog -->
	</div><!-- modal -->