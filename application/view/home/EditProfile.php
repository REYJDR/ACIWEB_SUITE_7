<?php
require_once APP.'view/'.basename(__DIR__).'/lang/'.$this->model->lang.'_ref.php';

//GET ACCOUNT INFO
if($id){
	
	$res = $this->model->Query('SELECT * FROM SAX_USER  where SAX_USER.onoff="1" and SAX_USER.id="'.$id.'";');
		
	foreach ($res as $value) {

		$value = json_decode($value);

		$id = $value->{'id'};
		$name = $value->{'name'};
		$lastname = $value->{'lastname'};
		$email = $value->{'email'};
		$pass = $value->{'pass'};
		$role= $value->{'role'};
		$INF_OC= $value->{'notif_oc'};
		$INF_FC= $value->{'notif_fc'};
		$INF_PRICE= $value->{'mod_price'};
		$INF_INV= $value->{'inv_view'};
		$INF_STO= $value->{'stoc_view'};
		$INF_REP= $value->{'rep_view'};
		$PHOTO  = $value->{'photo'};
		$INF_rol_1= $value->{'role_purc'};
		$INF_rol_2= $value->{'role_fiel'};
		$CLO_SO   = $value->{'closeSO'};
		$AMNT_SO  =  $value->{'amountSO'};
		$PRINTER = $this->getPrinterById($value->{'printer'});
		$prnterID = $value->{'printer'};
		
		if( $PRINTER == ''){ $PRINTER = 'Ninguna';  $prnterID = null; }

		if($PHOTO == 'x'){ $user_avatar = URL.'img/user_avatar/'.$id.'.jpg';}else{ $user_avatar = URL.'img/default-avatar.png'; }

		if($INF_OC==1){    $notif_oc = 'checked';        }else{ $notif_oc = ''; }
		if($INF_FC==1){    $notif_fc = 'checked';	     }else{	$notif_fc = '';  }
		if($INF_PRICE==1){ $price_mod = 'checked';       }else{ $price_mod = ''; }
		if($INF_INV==1){   $INV_CK = 'checked';          }else{ $INV_CK = '';    } 
		if($INF_STO==1){   $STO_CK = 'checked';          }else{ $STO_CK = '';    }
		if($INF_REP==1){   $REP_CK = 'checked';          }else{ $REP_CK = '';    }
		if($CLO_SO==1){    $closeSO = 'checked';         }else{ $closeSO = '';   }
		if($AMNT_SO==1){   $amountSO = 'checked';        }else{ $amountSO = '';  }
		if($INF_rol_1==1){ $rol_purc_value = 'checked';  }else{ $rol_purc_value= '';  } 
		if($INF_rol_2==1){ $rol_field_value = 'checked'; }else{ $rol_field_value = '';}
	}


	if($this->model->active_user_role!='admin'){ 
		
			$notif_oc  .= ' disabled'; 
			$notif_fc  .= ' disabled'; 
			$price_mod .= ' disabled'; 
			$REP_CK .= ' disabled';
			$STO_CK .= ' disabled';
			$INV_CK .= ' disabled';
			$closeSO .= ' disabled';
			$amountSO .= ' disabled';
		}  
		
	//UPDATE INFORMATION
	if($_POST['flag2']=='1'){
		
		if($_POST['oc_chk']==true){ $not_oc_value = '1'; }else{ $not_oc_value = '0'; }
		if($_POST['fc_chk']==true){ $not_fc_value = '1'; }else{ $not_fc_value = '0';}
		if($_POST['pri_chk']==true){ $mod_price_value = '1'; }else{ $mod_price_value = '0';	 }
		if($_POST['clo_chk']==true){ $close_so_value = '1'; }else{ $close_so_value = '0'; }
		if($_POST['amnt_chk']==true){ $amnt_so_value = '1'; }else{ $amnt_so_value = '0';	 }
		if($_POST['inv_chk']==true){ $set_inv_chk= '1'; }else{ $set_inv_chk= '0'; }
		if($_POST['sto_chk']==true){ $set_sto_chk = '1'; }else{ $set_sto_chk = '0';	 }
		if($_POST['rep_chk']==true){$set_rep_chk = '1'; }else{ $set_rep_chk = '0'; }
	    if($_POST['rpurch_chk']==true){ $rol_purc_value = '1'; }else{ $rol_purc_value= '0'; } 
		if($_POST['rfield_chk']==true){ $rol_field_value = '1'; }else{ $rol_field_value = '0'; }
				
		
		$pass_ck = $this->model->Query_value('SAX_USER','pass','where SAX_USER.onoff="1" and SAX_USER.id="'.$id.'"');
		
		
		if($pass_ck==$_POST['pass_22']){ $pass==$_POST['pass_22']; }else{ $pass = md5($_POST['pass_22']); }
		
		
		
		
		//sube foto de perfil
		if(basename($_FILES["image"]["name"])!=''){
		
		$target_dir = "img/user_avatar/";
		$target_file = $target_dir . basename($_FILES["image"]["name"]); 
	
	
		if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
							
				rename($target_dir.$_FILES["image"]["name"], $target_dir.$_POST['user_2'].".jpg");
		} 
		
		$foto_file = 'x'; }else{ $foto_file = ''; }
		
		//elimina foto de perfi
		if($_POST['trash_img']==1){
		
		  unlink('img/user_avatar/'.$_POST['user_2'].".jpg");
		  $foto_file = '';
		
		}
	
		if($_POST['DefaultPrint']!=''){ $printer = $_POST['DefaultPrint']; }else{ $printer = 0; }
		
		$columns  = array( 'name'      => $_POST['name2'],
						   'lastname'  => $_POST['lastname2'],
						   'pass'      => $pass,
						   'role'      => $_POST['priv'],
						   'notif_oc'  => $not_oc_value,
						   'notif_fc'  => $not_fc_value, 
						   'mod_price' => $mod_price_value,
						   'inv_view'  => $set_inv_chk,
						   'rep_view'  => $set_rep_chk,
						   'stoc_view' => $set_sto_chk,
						   'photo'     => $foto_file,
						   'printer'   => $printer,
						   'role_purc' => $rol_purc_value,
						   'role_fiel' => $rol_field_value,
						   'closeSO'   => $close_so_value,
						   'amountSO'  => $amnt_so_value);
		
		$clause = 'id="'.$_POST['user_2'].'"';
		
		
		$this->model->update('SAX_USER',$columns,$clause);
		
		$this->CheckError();
		
		echo '<script>alert("Se ha actualizado los datos con exito");
				self.location="'.URL.'index.php?url=home/edit_account/'.$id.'";
			  </script>';
		}
		
}	
?>


<!--ADD JS FILE-->
<script  src="<?php echo URL; ?>js/operaciones/home/editProfile.js" ></script>


<div class="limiter">
		<div class="container-page100">
			<div class="wrap-page100">
			<form method="POST"  action="" enctype="multipart/form-data"  class="login100-form validate-form p-l-25 p-r-25 p-t-60" >

			<span class="page100-form-title">
						<?PHP echo $config_4_title; ?>
			</span>
			<!--INI DIV ERRO-->
			<div id="ERROR" class="alert"></div>
			<!--INI DIV ERROR-->
			
			<!--ini contenido-->
			<input type="hidden" id="user_2" name="user_2" value="<?php echo $id; ?>" />
			<input type="hidden"  name="flag2" value="1" />

			<div class="col-lg-8">
			<!--<div class="col-lg-2">
				<fieldset class="fieldsetform" >
					<center>
						<div  class="col-lg-12"  >
							<img id="blah"  class="img-circle" src="<?php echo $user_avatar; ?>"  width="130px" height="130px"  alt="avatar" />
						</div>

						<div  class="col-lg-12" >
							<div class="col-lg-6"><i class="fas fa-edit">&nbsp;</i><input type="file" id="image" name="image"  onchange="readURL(this);"  style="display: none;" /></div>
							<div class="col-lg-6"><i style="color:red;" class="fas fa-trash-alt">&nbsp;</i><input  id="trash" name="trash"  onclick="avatar_trash('<?php echo URL.'img/default-avatar.png'; ?>');"  style="display: none;" /></div>
							<input type="hidden" name="trash_img"  id="trash_img" value="" />
						</div>
					</center>
				</fieldset>	
				</div>-->
				
				<div class="col-lg-8">
					<fieldset class="fieldsetform">
					<table class="table_form">
						<tbody>
							<tr><th><strong><?php echo $config_4_val1; ?></strong></th><td><input type="text"  class="inputPage col-lg-12"  id="name2" name="name2" value="<?php echo $name; ?>" required /></td></tr>
							<tr><th><strong><?php echo $config_4_val2; ?></strong></th><td><input type="text" class="inputPage col-lg-12"   id="lastname2" name="lastname2"  value="<?php echo $lastname; ?>"   required//></td></tr>
							<tr><th><strong><?php echo $config_4_val3; ?></strong></th><td><input type="email" class="inputPage col-lg-12" iname="email2" id="email2"  value="<?php echo $email; ?>" readonly/></td></tr>
							<tr><th><strong><?php echo $config_4_val4; ?></strong></th><td><input type="password" class="inputPage col-lg-12"  id="pass_12" name="pass_12"  value="<?php echo $pass; ?>" required></td></tr>
							<tr><th><strong><?php echo $config_4_val5; ?></strong></th><td><input type="password" class="inputPage col-lg-12"  id="pass_22" name="pass_22" value="<?php echo $pass; ?>" required/></td></tr>
							<tr><th><strong><?php echo $config_4_val6; ?></strong></th><td><input type="text" class="inputPage col-lg-12"  id="priv" name="priv" value="<?php echo $role; ?>" readonly/></td></tr>           
						</tbody>
					</table>
					</fieldset>
				</div>
			</div>

			<div class="separador col-lg-12"></div>
		
			<fieldset >
			<div class="separador col-lg-12"></div>
				
			<div class="col-lg-6">
				
			    <div class="col-lg-10">
				<fieldset class="fieldsetform">
				<h4><?php echo $config_5_title; ?></h4>
				<table class="table_form">
					<tbody>
						<?PHP if ($mod_sales_CK == 'checked') { ?>
						<tr><th><strong><?php echo $config_4_val7; ?></strong></th><td><input type="CHECKBOX" name="pri_chk"  <?php echo $price_mod;  ?> /></td></tr>
						<tr><th><strong><?php echo $config_4_val8; ?></strong></th><td><input type="CHECKBOX" name="clo_chk"  <?php echo $closeSO;  ?> /></td></tr>
						<tr><th><strong><?php echo $config_4_val9; ?></strong></th><td><input type="CHECKBOX" name="amnt_chk" <?php echo $amountSO;  ?> /></td></tr>
						<?php } ?>
						<?PHP if ($mod_invt_CK  == 'checked') { ?>    
						<tr><th><strong><?php echo $config_4_val10; ?></strong></th><td><input type="CHECKBOX" name="inv_chk" <?php echo $INV_CK;  ?> /></td></tr>
						<?php } ?>
						<?PHP if ($mod_stoc_CK  == 'checked') { ?>
						<tr><th><strong><?php echo $config_4_val11; ?></strong></th><td><input type="CHECKBOX" name="sto_chk" <?php echo $STO_CK;  ?> /></td></tr>
						<?php } ?>
						<?PHP if ($mod_rept_CK  == 'checked') { ?>
						<tr><th><strong><?php echo $config_4_val12; ?></strong></th><td><input type="CHECKBOX" name="rep_chk" <?php echo $REP_CK;  ?> /></td></tr>           
						<?php } ?>
					</tbody>
				</table>
				</fieldset>
				</div>

			</div>

			<div class="separador col-lg-12"></div>
		
			<div class="col-lg-6">
			
			<div class="col-lg-12">
			<?PHP if ($mod_sales_CK == 'checked') { ?>
							
				<fieldset class="fieldsetform">
				<h4><?php echo $config_7_title; ?></h4>	
				<table class="table_form">
					<tbody>
					<tr><th><strong><?php echo $config_4_val15; ?></strong></th>						
					<td>
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
					</td></tr>
					<tr><th><strong><?php echo $config_4_val16; ?></strong></th><td><input class='col-lg-12' type="text" name="printerAsigned"  value="<?php echo $PRINTER;  ?>" readonly/></td></tr>

					</tbody>
				</table>
				</fieldset>
			<?php } ?>
			</div>

			<div class="separador col-lg-12"></div>

			
			<div class="col-lg-6">
			<?PHP if ($mod_req_CK == 'checked') { ?>

			<fieldset class="fieldsetform">
			<h4><?php echo $config_8_title; ?></h4>
			<table class="table_form">
				<tbody>
					<tr><th><strong><?php echo $config_4_val17; ?></strong></th><td><input type="CHECKBOX" name="rpurch_chk" <?php echo $rol_purc_value; ?>  /></td></tr>
					<tr><th><strong><?php echo $config_4_val18; ?></strong></th><td><input type="CHECKBOX" name="rfield_chk" <?php echo $rol_field_value; ?> /></td></tr>    
				</tbody>
			</table>
			</fieldset>

			<?php } ?>
			</div>

			<div class="col-lg-6">
				<?PHP if ($mod_fact_CK == 'checked' || $mod_req_CK == 'checked' ) { ?>
				<fieldset class="fieldsetform">
				<h4><?php echo $config_6_title; ?></h4>
				<table class="table_form">
					<tbody>
						<?PHP if ($mod_fact_CK == 'checked') { ?>
							<tr><th><strong><?php echo $config_4_val13; ?></strong></th><td><input type="CHECKBOX" name="fc_chk" <?php echo $notif_fc; ?> /></td></tr>
						<?php } ?>
						<?PHP if ($mod_req_CK  == 'checked') { ?>  
						<tr><th><strong><?php echo $config_4_val14; ?></strong></th><td><input type="CHECKBOX" name="oc_chk" <?php echo $notif_oc; ?> /></td></tr>
						<?php } ?>
					</tbody>
				</table>
				</fieldset>
				<?php } ?>
			   </div>

			<div class="separador col-lg-12"> </div>

			



			</div>

			<div class="col-lg-8"></div>
			<div class="col-lg-2">
			<button   class="accept-form-btn" type="submit" >Actualizar</button>
			</div>
			
			</form>		
			<?PHP if($this->model->active_user_role='admin'){  ?>  
				<div class="col-lg-2">
				<button   class="close-form-btn" onclick='removerUser(<?php echo $id; ?>)' >Eliminar</button>
				</div>	
			<?php } ?>
			<div class="separador col-lg-12"> </div>			
			</fieldset >
			<!--fin contenido-->
			</form>	
			<div class="separador col-lg-12"> </div>
			</div>
		</div>
	</div>