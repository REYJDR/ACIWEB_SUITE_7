<?php
if(isset($_POST['flag']))
{
	//inicio variables de session
	$user = $_POST['user'];
	$pass = md5($_POST['pass']);

	$isStandalone = $this->model->CheckStandalone();
	
	if(!$isStandalone){ 

	  $company = $_POST['company']; 

    }else{

	  $company = '0'; 
	  
	}
	
	$login = $this->model->login_in($user,$pass,'',$company); 
}
?>

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
		
				<form method="POST"  action="" class="login100-form validate-form p-l-55 p-r-55 p-t-178" id="login" autocomplete="on" >

				<input type="hidden" name='flag' value="1"/>
				
				
			       <span class="login100-form-title"> 
				   <img width="50%" height="50%"  src="page_assets/images/ACIWEB-LOGO.png" />
					</span> 
					<div class="wrap-input100 validate-input m-b-16" data-validate="Please enter username">
						<input class="input100" type="text" id="user" name="user" placeholder="Username">
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Please enter password">
						<input class="input100" type="password" name="pass" id="pass" placeholder="Password" >
						<span class="focus-input100"></span>
					</div>

				<?php 

				$isStandalone = $this->model->CheckStandalone();

				if(!$isStandalone){ ?>

					<div class="separador col-lg-12" ></div>
					<fieldset>
					<legend>Sage Company</legend>
						<select  id="company" name="company" class="select col-lg-12"  required>
						<option selected disabled></option>
						<?php  

						echo $Comp = $this->model->get_CompanyList(); 
					

						?>
					</select>  
					<div class="separador col-lg-12" ></div>
					</fieldset>

				<?php } ?>


					<div class="text-right p-t-13 p-b-23">
						<span class="txt1">
							Olvido su contraseña?
						</span>
						<a href="<?php echo URL; ?>index.php?url=login/forgot_pass" class="txt2">
							Recuperar
						</a>
					</div>

					<div class="container-login100-form-btn">
						<button type="submit"  class="accept-form-btn">
							Entrar
						</button>
					</div>

				</form>
				<div class="separador col-lg-12"> </div>
					<div class="col-lg-6">
				    <div class="col-lg-1"></div>
					<span id="siteseal"><script async type="text/javascript" src="https://seal.godaddy.com/getSeal?sealID=zB3xB13v2RV55GbgMLeYTlZOfhe0M5wMGtv2IKpi6SMS8b03XF39KAqppsrq"></script></span>
					</div> 

					<div class="col-lg-4">
						<span ><?php echo VER; ?></span>
					</div>
					</div>
			 </div>
			 <div class="separador col-lg-12"> </div>
		</div>
	</div>