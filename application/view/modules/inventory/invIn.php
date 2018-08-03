<?php
require_once APP.'view/modules/'.basename(__DIR__).'/lang/'.$this->model->lang.'_ref.php';
?>


<!--ADD JS FILE-->
<script  src="<?php echo URL; ?>js/operaciones/invoice/BillGen.js" ></script>




<div class="limiter">
		<div class="container-page100">
			<div class="wrap-page100">
			<form method="POST"  action="" class="login100-form validate-form p-l-25 p-r-25 p-t-60" >

			<span class="page100-form-title">
						<?PHP echo $Title; ?>
			</span>
			<!--INI DIV ERRO-->
			<div id="ERROR" ></div>
			<!--INI DIV ERROR-->
			
			<!--ini contenido-->


			<!--fin contenido-->
			</form>	
			<div class="separador col-lg-12"> </div>
			</div>
		</div>
	</div>