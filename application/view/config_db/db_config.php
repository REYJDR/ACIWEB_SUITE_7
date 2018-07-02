<?php 


if(isset($_POST['flag'])){


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

echo '<script>self.location ="index.php?url=home/index";</script>';

}

if($user_role=='admin'){

	$edit = '  ';

}else{
	$edit = ' readonly ';
}

?>

<div class="limiter" >
	<div class="container-login100">

		<div class="wrap-login100">
     		<form method="POST"  action="" class="login100-form validate-form p-l-55 p-r-55 p-t-178"  id='saveDB' >

			 <input type="hidden" name='flag' value="1"/>

					<span class="login100-form-title">
					   Configuracion de base de datos
					</span>

					<?php if($msg!='') {?>
						<div class="alert alert-danger">
						<strong>Error!</strong><?php echo $msg; ?>
						</div>
					<?php } ?>

					<div class="wrap-input100 validate-input m-b-16" data-validate="Please enter Hostname">
						<input class="input100" type="text" id="host" name="host" value="<?php echo DB_HOST; ?>" <?php echo $edit; ?> placeholder="Hostname">
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input m-b-16" data-validate="Please enter DB user">
						<input class="input100" type="text" id="dbname" name="dbname" value="<?php echo DB_NAME; ?>"  <?php echo $edit; ?>   placeholder="User">
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input m-b-16" data-validate="Please enter DB user">
						<input class="input100" type="text" id="user" name="user" value="<?php echo DB_USER; ?>"  <?php echo $edit; ?>   placeholder="User">
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input m-b-16" data-validate="Please enter password">
						<input class="input100" type="password" id="pass" name="pass"  value="<?php echo DB_PASS; ?>"  <?php echo $edit; ?>   placeholder="password">
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input m-b-16" data-validate="Please enter UTC">
						<input class="input100" type="text" id="UTC" name="UTC" value="<?php echo UTC; ?>"  <?php echo $edit; ?>   placeholder="UTC">
						<span class="focus-input100"></span>
					</div>
 
					
					<?php  if($user_role=='admin'){ ?>
						<div class="container-login100-form-btn">
						<button type="submit"  class="login100-form-btn">
							Guardar
						</button>
					   </div>
					<?php } ?>
					<div class='separador' ></div>

			 </form>
		</div>
	</div>
</div>