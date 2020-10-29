
<?php



require_once APP.'view/'.basename(__DIR__).'/lang/'.$this->model->lang.'_ref.php';


?>



<!--ERROR -->
<div id="ErrorModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">

        <button type="button" onclick="javascript:history.go(-1);" class="close" data-dismiss="modal">&times;</button>
        <h3 >Error</h3>
      </div>
      <div class="col-lg-12 modal-body">
      <!--ini Modal  body-->  
            <div id='ErrorMsg'></div>
      <!--fin Modal  body-->
      </div>
      <div class="modal-footer">
        <button type="button" onclick="javascript:history.go(-1); return true;" data-dismiss="modal" class="btn btn-primary" >OK</button>
      </div>
    </div>
  </div>
</div>
<!--modal-->
<!--INI DIV ERROR-->




<?php

if (isset($_REQUEST['smtp'])) {

	
$value  = array(
'ID' => '1',
'HOSTNAME' => $_REQUEST['emailhost'],
'PORT'     => $_REQUEST['emailport'],
'USERNAME' => $_REQUEST['emailusername'],
'PASSWORD' => $_REQUEST['emailpass'],
'Auth' => $_REQUEST['Auth'],
'SMTPSecure' => $_REQUEST['Secure'],
'SMTPDebug'  => $_REQUEST['Debug']);

$this->model->Query('DELETE from CONF_SMTP;');

$this->model->insert('CONF_SMTP',$value);
$this->CheckError();

unset($_REQUEST);

echo '<script> alert("Se ha actualizado con exito"); window.open("'.URL.'index.php?url=home/config_sys","_self");</script>';


}

 if(isset($_REQUEST['logo'])){

	$target_dir = "img/";

	$target_file = $target_dir . basename($_FILES["imageFile"]["name"]);
 
	$target_file;
	$uploadOk = 1;

	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	// Check if image file is a actual image or fake image

   if ($imageFileType=='jpg'){ 

	      
	       $uploadOk = 1;


	 	   if (move_uploaded_file($_FILES["imageFile"]["tmp_name"], $target_file)) {
	 			

	 		rename("img/".$_FILES["imageFile"]["name"], "img/logo.jpg");
	        

	        echo '<script> alert("Se ha actualizado el logo con exito","ok"); 
	             window.open("'.URL.'index.php?url=home/config_sys","_self");</script>';

            } 


	    } else {

	    	
	        $uploadOk = 0;

	    }

    if ($uploadOk==0){   echo '<script>
	         alert("Se produjo un error al subir la imagen","ok"); window.open("'.URL.'index.php?url=home/config_sys","_self");</script>'; }

}

//ACTUALIZA DATOS DE COMPAÑIA 
if (isset($_REQUEST['sage50'])) {
	
	$value  = array('Sage_Conn' => $_POST['conn_sage'] );

	$this->model->update('company_info',$value,' id="1" ');
	$this->CheckError();

	unset($_REQUEST);

	echo '<script> alert("Se ha actualizado con exito"); window.open("'.URL.'index.php?url=home/config_sys","_self");</script>';

}

//ACTUALIZA DATOS DE INVENTARIO
if (isset($_REQUEST['inventory'])) {
	
	//$exist = $this->model->Query_value('INV_CONF', 'ID' ,'where ID_compania="'.$this->model->id_compania.'"');
	$exist = $this->model->Query_value('INV_CONF', 'ID' ,'where ID_compania="0"');

	if($exist != ''){

		if($_POST['inv_discount'] == 'on') { $inv_discount = 1 ;}else{ $inv_discount = 0 ;};

		$value  = array('inv_discount' => $inv_discount );
		$this->model->update('INV_CONF',$value,' ID_compania="'.$this->model->id_compania.'"');

	}else{
		$value  = array('inv_discount' => $inv_discount ,
						'ID_compania' => $this->model->id_compania);
						
		$this->model->insert('INV_CONF',$value);
		
	}

	$reqConse = $this->model->Query_value('INV_CONF', 'req_conse' ," Where ID='{$exist}'");

	if($reqConse != 0){ 
		$value  = array('req_conse' => $_POST['req_conse']);
		$this->model->update('INV_CONF',$value," ID='{$exist}'");
	}


	$this->CheckError();

	unset($_REQUEST);

	echo '<script> alert("Se ha actualizado con exito"); window.open("'.URL.'index.php?url=home/config_sys","_self");</script>';

}

//ACTUALIZA DATOS DE COMPAÑIA 
if (isset($_REQUEST['comp'])) {

	$this->model->delete('company_info','');

	$value  = array(
	'id' => "1",
	'company_name' => $_POST['company'],
	'email' => $_POST['email_contact'],
	'address' => $_POST['address'],
	'Tel' => $_POST['tel1'],
	'Fax' => $_POST['tel2'],
	'lang' => $_POST['lang']);


	$this->model->insert('company_info',$value);
	$this->CheckError();

	unset($_REQUEST);

	echo '<script> alert("Se ha actualizado con exito"); window.open("'.URL.'index.php?url=home/config_sys","_self");</script>';


}

//ACTUALIZA DATOS DE TAX 
if (isset($_REQUEST['addTax'])) {
	
	$value  = array(
	'taxid' => $_POST['idtax'],
	'rate' => $_POST['porc'],
	);


	$this->model->INSERT('sale_tax',$value,'Where id="1";');
	$this->CheckError();

	echo '<script> alert("El nuevo Tax se ha agregado con exito","ok"); window.open("'.URL.'index.php?url=home/config_sys","_self");</script>';


}

//ACTUALIZA terminos de pago 
if (isset($_REQUEST['addTerm'])) {
	
	$value  = array(
	'TermID' => $_POST['termId'],
	'DaysToPay' => $_POST['termDesc'],
	'TIPO' => $_POST['termType'],
	'ID_compania' => $this->model->id_compania 
	);


	$this->model->INSERT('CUST_PAY_TERM',$value);
	$this->CheckError();

	echo '<script> alert("El nuevo termino de pago de agrego con exito","ok"); window.open("'.URL.'index.php?url=home/config_sys","_self");</script>';


}

//AGREGA DATOS DE IMPRESORA FISCAL
if (isset($_REQUEST['addPrint'])) {

	$PRINTER = $_POST['serial'];

	$value  = array(
		'SERIAL' => $_POST['serial'],
		'DESCRIPCION' => $_POST['printdesc']
	);

	$DIR = "FISCAL/".$PRINTER."/IN/";
	$DIROUT = "FISCAL/".$PRINTER."/OUT/";
	$DIRERROR = "FISCAL/".$PRINTER."/ERROR/";
	
	if (!file_exists($DIR)) {
	
		mkdir($DIR, 0777, true);
		mkdir($DIROUT, 0777, true);
		mkdir($DIRERROR, 0777, true);
		
	}
	
	$this->model->INSERT('INV_PRINT_CONF',$value);
	$this->CheckError();

	echo '<script> alert("Se ha agredo con exito","ok"); window.open("'.URL.'index.php?url=home/config_sys","_self");</script>';



}

//actualizo info de modulos
if(isset($_REQUEST['mod'])){

	if($_POST['mod_cust']==true){
		
				$mod_cust = '1';
		
				}else{
		
				$mod_cust = '0';	
		
				}

	if($_POST['mod_invo']==true){

		$mod_invo = '1';

		}else{

		$mod_invo = '0';	

		}


	if($_POST['mod_sales']==true){

		$mod_sales = '1';

		}else{

		$mod_sales = '0';	

		}
	if($_POST['mod_fact']==true){

		$mod_fact = '1';

		}else{

		$mod_fact  = '0';	

		}
	if($_POST['mod_invt']==true){

		$mod_invt= '1';

		}else{

		$mod_invt  = '0';	

		}
	if($_POST['mod_rept']==true){

		$mod_rept= '1';

		}else{

		$mod_rept  = '0';	

		}
	if($_POST['mod_stock']==true){

		$mod_stock= '1';

		}else{

		$mod_stock = '0';	

		}
	if($_POST['mod_pro']==true){

		$mod_pro = '1';

		}else{

		$mod_pro = '0';	

		}
   
   	if($_POST['mod_req']==true){

		$mod_req = '1';

		}else{

		$mod_req = '0';	

		}


	$value = array(
		'mod_sales' => $mod_sales,
		'mod_invo'  => $mod_invo,
		'mod_fact'  => $mod_fact,
		'mod_invt'  => $mod_invt,
		'mod_rept'  => $mod_rept,
		'mod_stock' => $mod_stock,
		'mod_pro'   => $mod_pro,
		'mod_req'   => $mod_req,
		'mod_cust'  => $mod_cust);


	$this->model->delete('MOD_MENU_CONF','');
	$this->model->insert('MOD_MENU_CONF',$value);
	$this->CheckError();


	echo '<script> alert("Se ha actualizado los detalles con exito","ok"); window.open("'.URL.'index.php?url=home/config_sys","_self");</script>';

}



//ACTUALIZO DATOS DE DETALLES DE FACTURACION
if(isset($_POST['fact_detail_set'])){

	$fact_no_line = $_POST['fact_no_line'];
	$customField = $_POST['customField'];
	$ItemFilter= $_POST['filterField'];


	$chk_cur_val =  $this->model->Query_value('FAC_DET_CONF','COUNT(*)','where ID_compania="'.$this->model->id_compania.'"');

	$values =  array( 
	'ID_compania' => $this->model->id_compania ,
	'CUSTOM_FIELD' => $customField, 
	'NO_LINES' => $fact_no_line ,
	'ITEMS_FILTER'  => $ItemFilter );



	if($chk_cur_val==1){
		
		
	$this->model->update('FAC_DET_CONF',$values, ' ID_compania="'.$this->model->id_compania .'"');

	}else{
	$this->model->insert('FAC_DET_CONF',$values);

	}
	$this->CheckError();


	echo '<script> alert("Se ha actualizado los detalles con exito","ok"); window.open("'.URL.'index.php?url=home/config_sys","_self");</script>';



}

//ACTUALIZO DATOS DE DETALLES DE CUENTAS GL
if(isset($_POST['CTAS_GL'])){

	$cta_gl_cxp = $_POST['cta_gl_cxp'];
	$cta_gl_pur = $_POST['cta_gl_pur'];
	$cta_gl_tax = $_POST['cta_gl_tax'];
	$cta_gl_acct = $_POST['Glacct'];
	$cta_gl_aract = $_POST['ARACNT'];
	$cta_gl_devnc = $_POST['ctadev'];
	$cta_gl_reten = $_POST['GL_RETEN'];

	$chk_cur_val =  $this->model->Query_value('CTA_GL_CONF','ID','where ID_compania="'.$this->model->id_compania .'"');

	$values =  array( 'ID_compania' => $this->model->id_compania , 
					'CTA_CXP' => $cta_gl_cxp,
					'CTA_PUR' => $cta_gl_pur,
					'CTA_TAX' => $cta_gl_tax,
					'GLACCT' => $cta_gl_acct,
					'CTA_CXC' => $cta_gl_aract,
					'CTA_DEV' => $cta_gl_devnc,
					'GL_RETEN' => $cta_gl_reten
					);

	if($chk_cur_val!=''){
	$this->model->update('CTA_GL_CONF',$values, 'where ID_compania="'.$this->model->id_compania .'"');
	}else{
	$this->model->insert('CTA_GL_CONF',$values);
	}

	$this->CheckError();


	echo '<script> alert("Se ha actualizado los detalles con exito","ok"); window.open("'.URL.'index.php?url=home/config_sys","_self");</script>';


}



if(isset($_POST['saveDB'])){
	
	
	$file = '';
	$filename = 'db_val/db_variables.php';
	
	$valuesfile = fopen($filename, 'w') or die('fopen failed '.var_dump(error_get_last()));
	$open = $valuesfile;
	
	$file .= "<?php define('DB_TYPE', 'mysql');\n
	define('DB_HOST', '".$_POST['host']."');\n
	define('DB_NAME', '".$_POST['dbname']."');\n
	define('DB_USER', '".$_POST['user']."');\n
	define('DB_PASS', '".$_POST['pass']."');\n
	define('UTC', '".$_POST['UTC']."');\n
	define('DB_CHARSET', 'utf8');\n ?>";
	
	fwrite ($valuesfile, $file) or die('fwrite failed '.var_dump(error_get_last()));
	fclose ($valuesfile);
	
	
	echo '<script> alert("Se ha actualizado con exito","ok"); window.open("'.URL.'index.php?url=home/config_sys","_self");</script>';
	
}

if (isset($_POST['Adduser'])){

	$mail=$_POST['mail'];
	$name=$_POST['name'];
	$lastname=$_POST['lastname'];
	$pass=$_POST['pass_1'];
	$role=$_POST['role'];
	//$cliente_name = $_POST['cliente_id'];

	$mail_verify = $this->model->Query_value('SAX_USER','email',"where email='".$mail."' and onoff='1'");

	//echo $mail_verify;

	if (!$mail_verify){

	$pass = md5($pass);

	$this->model->Query("INSERT INTO SAX_USER (name,lastname,email,pass,role) values ('".$name."','".$lastname."','".$mail."','".$pass."','".$role."')");

	$this->CheckError();


	echo '<script> alert("Se ha agregado el usuario con exito","ok"); window.open("'.URL.'index.php?url=home/config_sys","_self");</script>';


	}else{ 
		
	echo '<script> MSG_ERROR("El correo indicado ya existe","0"); </script>';
		
	}

	} 

	if(isset($_POST['oc_info'])){
		$this->model->delete('API_OPENCART_KEYS','where id=1');

		$this->model->Query("INSERT INTO API_OPENCART_KEYS (id,url,apikey) values ('1','{$_POST['url']}','{$_POST['key']}')");

		$this->CheckError();

		echo '<script> alert("Se ha agregado la configuración con exito","ok"); window.open("'.URL.'index.php?url=home/config_sys","_self");</script>';


	}


	//////LLAMADAS DE DATOS
	//RECUPERO INFO DE CUENTAS GL
	$CTA_CXP = $this->model->Query_value('CTA_GL_CONF','CTA_CXP','WHERE ID_compania="'.$this->model->id_compania.'"');
	$CTA_PUR = $this->model->Query_value('CTA_GL_CONF','CTA_PUR','WHERE ID_compania="'.$this->model->id_compania.'"');
	$CTA_TAX = $this->model->Query_value('CTA_GL_CONF','CTA_TAX','WHERE ID_compania="'.$this->model->id_compania.'"');
	$CTA_GLACCT = $this->model->Query_value('CTA_GL_CONF','GLACCT','WHERE ID_compania="'.$this->model->id_compania.'"');
	$CTA_ARACNT = $this->model->Query_value('CTA_GL_CONF','CTA_CXC','WHERE ID_compania="'.$this->model->id_compania.'"');
	$CTA_DEV = $this->model->Query_value('CTA_GL_CONF','CTA_DEV','WHERE ID_compania="'.$this->model->id_compania.'"');
	$GL_RETEN = $this->model->Query_value('CTA_GL_CONF','GL_RETEN','WHERE ID_compania="'.$this->model->id_compania.'"');

	//RECUPERO INFO DE MODULOS
	$SQL = 'SELECT * FROM MOD_MENU_CONF';

	$MOD_MENU = $this->model->Query($SQL);

	foreach ($MOD_MENU as $value) {

	$value = json_decode($value);

	if($value->{'mod_sales'}=='1'){ $mod_sales_CK = 'checked'; }else{ $mod_sales_CK = '';  }
	if($value->{'mod_invo'}=='1'){  $mod_invo_CK  = 'checked'; }else{ $mod_invo_CK = '';  } 
	if($value->{'mod_fact'}=='1'){ $mod_fact_CK  = 'checked'; }else{ $mod_fact_CK = '';  }
	if($value->{'mod_invt'}=='1'){ $mod_invt_CK = 'checked'; }else{ $mod_invt_CK  = '';  }
	if($value->{'mod_req'}=='1'){ $mod_req_CK = 'checked'; }else{ $mod_req_CK  = '';  }
	if($value->{'mod_rept'}=='1'){ $mod_rept_CK = 'checked'; }else{ $mod_rept_CK = '';  }
	if($value->{'mod_stock'}=='1'){$mod_stoc_CK = 'checked'; }else{ $mod_stoc_CK = '';  }
	if($value->{'mod_cust'}=='1'){  $mod_cust_CK  = 'checked'; }else{ $mod_cust_CK = '';  } 

}



//LLAMO LOS VALORES ACTUALES DE LOS DATOS DE LA COMPAÑIA
$res= $this->model->Get_company_Info();
foreach ($res as $Comp_Info) {
	$Comp_Info = json_decode($Comp_Info);

	$name = $Comp_Info->{'company_name'};
	$email = $Comp_Info->{'email'};
	$address = $Comp_Info->{'address'};
	$tel= $Comp_Info->{'Tel'};
	$fax = $Comp_Info->{'Fax'};
	$lang = $Comp_Info->{'lang'};
	$Sage_Conn = $Comp_Info->{'Sage_Conn'};
}	 

//LLAMO LOS VALORES ACTUALES DE LOS DATOS DE VENTA
$saleRes= $this->model->Get_sales_conf_Info();

foreach ($saleRes as $sale) {
	$sale = json_decode($sale);

	$tax =  $sale->{'taxid'};
	$porc = $sale->{'rate'};
	
		$table .= '<tr>
					<th><strong>'.$config_14_val7.'</strong></th><td><input type="text" class="form-control"  value="'.$tax.'" disabled/></td>
					<th><strong>'.$config_14_val8.'</strong></th><td><input type="text" class="form-control"  value="'.$porc.'" disabled/></td>
					<td> <input type="button" onclick="del_tax('.$sale->{'id'}.');" value="Borrar" class="btn btn-danger btn-sm btn-icon icon-left"  /></td>
					</tr>';


}



//LLAMO LOS VALORES de termino de pado 
$TerminoPago= $this->GetTerminoPago();

foreach ($TerminoPago as $dato) {
	$dato = json_decode($dato);

	$TermId =  $dato->{'TermID'};
	$desc =    $dato->{'DaysToPay'};

	$Type =    $dato->{'TIPO'};
   
	if($Type == 1){
		$TypName = 'Contado';
	}else{
		$TypName = 'Credito';
	}

	$ID = "'".$TermId."'";

	$termTbl .= '<tr>
	<th><td><input type="text" class="form-control"  value="'.$TermId.'" disabled/></td>
	<th><td><input type="text" class="form-control"  value="'.$TypName.'" disabled/></td>
	<th><td><input type="text" class="form-control"  value="'.$desc.'" disabled/></td>	
	<td><input type="button" onclick="del_term('.$ID.');"  value="Borrar" class="btn btn-danger btn-sm btn-icon icon-left"  /></td>
	</tr>';

}


//LLAMO LOS VALORES
$PrintInfo= $this->GetPrintInfo();

foreach ($PrintInfo as $dato) {
	$dato = json_decode($dato);

	$serial =  $dato->{'SERIAL'};
	$desc =    $dato->{'DESCRIPCION'};
	$ID = "'".$serial."'";

	$table2  .= '<tr>
	<th><td><input type="text" class="form-control"  value="'.$serial.'" disabled/></td>
	<th><td><input type="text" class="form-control"  value="'.$desc.'" disabled/></td>
	<td><input type="button" onclick="del_print('.$ID.');"  value="Borrar" class="btn btn-danger btn-sm btn-icon icon-left"  /></td>
	</tr>';

}

//RECUPERO INFO DE DETALLES DE FACTURACION

$NO_LINES = $this->model->Query_value('FAC_DET_CONF','NO_LINES','WHERE ID_compania="'.$this->model->id_compania.'"');

$customField = $this->model->Query_value('FAC_DET_CONF','CUSTOM_FIELD','WHERE ID_compania="'.$this->model->id_compania.'"');

$filterField= $this->model->Query_value('FAC_DET_CONF','ITEMS_FILTER','WHERE ID_compania="'.$this->model->id_compania.'"');



//Recupero datos smtp
$sql = "SELECT * FROM CONF_SMTP WHERE ID='1'";

$smtp= $this->model->Query($sql);

foreach ($smtp as $smtp_val) {
  $smtp_val= json_decode($smtp_val);

  $hostname       = $smtp_val->{'HOSTNAME'};
  $emailport      = $smtp_val->{'PORT'};
  $emailusername  = $smtp_val->{'USERNAME'};
  $emailpass      = $smtp_val->{'PASSWORD'};
  $Auth       = $smtp_val->{'Auth'};
  $Secure     = $smtp_val->{'SMTPSecure'};
  $Debug      = $smtp_val->{'SMTPDebug'};


}

unset($_POST);
$this->CheckError();




//recupero info de opencart
$sql = 'SELECT * FROM API_OPENCART_KEYS WHERE id="1"';

$oc = $this->model->Query($sql);



foreach ($oc as $oc_val) {
	$oc_val= json_decode($oc_val);

	$oc_url = $oc_val->{'url'} ;
	$oc_key = $oc_val->{'apikey'} ;
  }


if( $oc_url != '' && $oc_key != ''){

	$sql = 'SELECT * FROM API_OPENCART_ENDPOINT where flag=1 order by id desc';
	
	$oc_end = $this->model->Query($sql);
	$endpoints = '';
	
	foreach ($oc_end as $api) {
		$api_endp = json_decode($api);
		
		$button = '';


		$id =  $api_endp->{'id'};
		$name_api =  $api_endp->{'name'};
		$route =  $api_endp->{'route'};
		$description = $api_endp->{'description'};
		$name_f = "'".$name_api."'";
		$route_f = "'".$route."'";
		$oc_url_f = "'".$oc_url."'";
		$oc_key_f = "'".$oc_key."'";
		

		if($name_api=='getStores'){
            echo  '<input type="hidden" id="api_store_route" value="'.$route.'" />';
		}
		
		

		if($name_api=='setItems'){
			$getColroute = "'".$this->model->Query_value('API_OPENCART_ENDPOINT', 'route' , 'where name="getTblCol"')."'";
			$getColName = "'getTblCol'";
            $button =  '<input type="button" onclick="columnMapping('.$getColName.','.$getColroute.','.$oc_url_f.','.$oc_key_f.');"  value="Mapear" class="btn btn-success btn-sm btn-icon "  />';
		}


		$endpoints .= '<tr>
						<th><strong>'.$name_api.'</strong></th><td>'.$description.'</td><td>'.$button.'</td><td><input type="button" onclick="exce_oc_api('.$name_f.','.$route_f.','.$oc_url_f.','.$oc_key_f.');"  value="Ejecutar" class="btn btn-primary btn-sm btn-icon icon-left"  /></td>
					   </tr>';
	
	
	}

}

echo     '<input type="hidden" id="api_url" value="'.$oc_url.'" />';
echo     '<input type="hidden" id="api_key" value="'.$oc_key.'" />';


//recupero datos de inventario
$sql = 'SELECT * FROM INV_CONF WHERE  ID_compania="'.$this->model->id_compania.'"';

$inv= $this->model->Query($sql);

foreach ($inv as $inv_val) {
  $inv_val= json_decode($inv_val);

  $inv_discount = $inv_val->{'inv_discount'};
  $req_conse= $inv_val->{'req_conse'};

}

if($inv_discount == 1 ){$inv_discount ='checked';}else{$inv_discount ='';}

unset($_POST);
$this->CheckError();


?>	

<!--ADD JS FILE-->
<script  src="<?php echo URL; ?>js/operaciones/home/config_sys.js" ></script>


<div class="limiter">
		<div class="container-page100">
			<div class="wrap-page100">
			<div class="login100-form validate-form p-l-25 p-r-25 p-t-60" >
		<!--	<form method="POST"  action="" class="login100-form validate-form p-l-25 p-r-25 p-t-60" >-->

			<span class="page100-form-title">
						<?PHP echo $TitleConfig; ?>
			</span>
			<!--INI DIV ERRO-->
			<div id="ERROR" class="alert"></div>
			<!--INI DIV ERROR-->
			
			<!--ini contenido-->
			<!--ini aqui va el menu de acceso rapido-->
			<div class='col-lg-12'>
			<?PHP require APP.'view/home/ConfigTab.php'; ?>
			</div>	
		    <!--end aqui va el menu de acceso rapido-->

			<!--fin contenido-->
	<!--		</form>	-->
	        </div>
			<div class="separador col-lg-12"> </div>
			</div>
		</div>
	</div>