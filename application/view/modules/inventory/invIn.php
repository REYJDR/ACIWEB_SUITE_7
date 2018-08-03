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

					<div  class="col-lg-8">
					<fieldset >
					

					<!--CHECKBOXES-->
					<div  class="col-lg-4">
					<fieldset class="fieldsetform">
					<table class='table_form'>
						<tbody>
							<tr>
								<td><input type="checkbox" id="chk_lp" name="chk_lp" value="1" onclick="set_div(this.value)" checked /></td>					
								<th><strong><?PHP echo $CHKBOX_1; ?></strong></th>
							</tr>
							<tr>
							<td><input type="checkbox" id="chk_lp" name="chk_lp" value="2" onclick="set_div(this.value)" /></td>					
								<th><strong><?PHP echo $CHKBOX_2; ?></strong></th>
							</tr>

						</tbody>
					</table>
					</fieldset>
					</div>
					<!--CHECKBOXES-->

					<div class="separador col-lg-12"></div> <!--SEPERADOR-->

						<!--INPUT NUEVO PRICE ID-->
						<div  class="col-lg-8" id="nvo_lp">
						<fieldset class="fieldsetform">
						<table class='table_form'>
							<tbody>
								<tr>
									<th><strong><?PHP echo $InputPL_1; ?></strong></th>
									<td><input type="text"  class="inputPage" id="price_id" name="price_id" /></td>		
									<th><strong><?PHP echo $InputPL_2; ?></strong></th>
									<td><input type="text"  class="inputPage" id="price_desc" name="price_desc" /></td>				
								</tr>
							</tbody>
						</table>
						</fieldset>
						</div>
						<!--INPUT NUEVO PRICE ID-->

						
						<div class="separador col-lg-12"></div> <!--SEPERADOR-->
						


						
						<!--Button Process-->
						<div class='col-lg-2'></div>
						<div class='col-lg-2'>
							<div class="container-login100-form-btn">
							<input type="submit"  value="<?PHP echo $BTN_InvIN_Proc; ?>"  class="accept-form-btn" name="submit"  value="<?PHP echo $BTN_Process; ?>" />			
							</div>
						</div>
						<div class="separador col-lg-12"> </div>
						<!--fin Button Process-->

					
					</fieldset>
					</div>

					<div class="separador col-lg-12"> </div>

						<!--ENTRADA INDIVIDUAL-->
						<div  class="col-lg-12" id="prod_ind">
						<fieldset class="fieldsetform">

						</fieldset>				
						</div>
						<!--ENTRADA INDIVIDUAL-->

						<!--ENTRADA POR LAYOUT-->
						<div  class="col-lg-8" id="prod_layout">
						<fieldset class="fieldsetform">				
							<table class='table_form'>
								<tbody>
									<tr>
										<th><strong><?PHP echo $InputPL_5; ?></strong></th>
										<!--INPUT FILE-->
										<td><input type="file" class="form-control" id="price_file" name="price_file" required="<?PHP echo $InputPL_4; ?>" />	
											<p class="help-block"><?PHP echo $Advice1; ?></p>
										</td>			
									</tr>
								</tbody>
							</table>
						</fieldset>									
						</div>
						<!--ENTRADA POR LAYOUT-->


				<!--fin contenido-->
		
		    </form>	
			<div class="separador col-lg-12"> </div>
			</div>
		</div>
	</div>