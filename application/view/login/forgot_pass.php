<!-- CODIGO PHP para enviar correo de recuperacion de contrasena-->
<?php



if(isset($_POST['flag']))
{

	//inicio variables de session
	$mail = $_POST['mail'];


	$mail_verify = $this->model->Query_value('SAX_USER','email',"where email='".$mail."' and onoff='1'");

	


if ($mail_verify){

	
		$control_key = rand(10,10000);

		$control_query = "UPDATE SAX_USER SET Recover_key = '".$control_key."' WHERE email = '".$mail."';";

		$this->model->Query($control_query);

		$control_key = $this->model->encriptar($control_key);
		
		$mail = $this->model->encriptar($mail);
		

$title    = utf8_encode('Sistema de Recuperacion de Password:');

$subject = utf8_encode('Recuperacion de Contraseña');

$message_to_send ='<br><br>
                    Estimado usuario por favor haga click en el boton "Recuperar Password" y defina un nuevo password.<br><br>
					<a href="'.URL.'index.php?url=login/pass_recovery/'.$mail.'/'.$control_key.'" type="button" id="pass_recover" >Recuperar Password</a>';


    $address[0] = $mail_verify.';;';

	$res = $this->model->send_mail($address,$subject,$title,$message_to_send);


	if($res==1){

		$alertType= 'alert-success';
		$msg = 'Se ha enviado el correo con exito!';

		echo '<script type="text/javascript">
					
				setTimeout(function(){

					self.location= "'.URL.'index.php?url=login/index";

				}, 5000);
		
			</script>';

	}else{

		$alertType= 'alert-error';
		$msg = "El mensaje no ha podido enviarse por el siguiente error: ".$res;
		
	}

}else{ 

	$alertType= 'alert-error';
	$msg = "El email de usuario no existe en el sistema de ACIWEB";
	
  } 


} ?>
 

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
		
				<form method="POST"  action="" class="login100-form validate-form p-l-55 p-r-55 p-t-178" id="login" >

				<input type="hidden" name='flag' value="1"/>
					<span class="login100-form-title">
					    Recuperar contraseña
					</span>

					<?php if($msg!='') {?>
						<div class="alert <?php echo $alertType; ?>">
						   <?php echo $msg; ?>
						</div>
					<?php } ?>

					<div class="wrap-input100 validate-input m-b-16" data-validate="Please enter username">
						<input class="input100" type="text" id="mail" name="mail" placeholder="Username">
						<span class="focus-input100"></span>
					</div>


					<div class="container-login100-form-btn">
						<button type="submit"  class="login100-form-btn">
							Enviar
						</button>
					</div>
					<div class="separador col-lg-12"> </div>
				</form>
			</div>
		</div>
	</div>