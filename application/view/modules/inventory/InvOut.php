

<?php
require_once APP.'view/modules/'.basename(__DIR__).'/lang/'.$this->model->lang.'_ref.php';


$NO_LINES =  $this->model->Query_value('FAC_DET_CONF','NO_LINES','where ID_compania="'.$this->model->id_compania .'"');
echo '<input type="hidden" id="FAC_NO_LINES" value="'.$NO_LINES .'" />'; 


?>

<!--ADD JS FILE-->
<script  src="<?php echo URL; ?>js/operaciones/inventory/invOut.js" ></script>


<div class="limiter">
		<div class="container-page100">
			<div class="wrap-page100">
			
			<form method="POST"  action="" class="login100-form validate-form p-l-25 p-r-25 p-t-60" >
			<span class="page100-form-title">
						<?PHP echo $Title3; ?>
			</span>
			
			<!--INI DIV ERRO-->
			<div id="ERROR" class="alert"></div>
			<!--INI DIV ERROR-->
			
			<!--ini contenido-->
			<input type="hidden"  id='URL' value="<?php ECHO URL; ?>" />
			<input type="hidden"  id="saletaxid"  value="" />
			<input type="hidden"  id="listID"  value="" />

				<!--ini  header-->
				<div class="col-lg-8"> 

				    <div  class="col-lg-3">
					<fieldset class="fieldsetform">
					<table class='table_form'>
						<tbody>
							<tr>
								<th><strong><?PHP echo $invout_ref; ?></strong></th><td><input  class="inputPage col-lg-12 numb" id="nopo" onkeyup="checkNOTA(this.id);" name="nopo"/></td>
							</tr>
						</tbody>
					</table>
					</fieldset>
					</div>

					<div  class="col-lg-12"></div>


					<div  class="col-lg-8">
					<fieldset class="fieldsetformb">
					<table class='table_form note'>
						<tbody>
						<tr><th><strong><?PHP echo $SO_Notes; ?></strong></th>
						<td><textarea class="textareaPage col-lg-12" onkeyup="checkInpChar(this.id);"  rows="2" id="observaciones" name="observaciones"></textarea></td></tr>
						</tbody>
					</table>
					</fieldset>	
					</div>

					

				</div>
				<!--fin header-->
				<div class="separador col-lg-12"> </div>

				<!--ini detail-->
				<div class="col-lg-12"> 
				<fieldset class="table_req fieldsetform" >
				<table id="table_ord_tb" class="display table table-striped table-condensed table-bordered " cellspacing="0">
				<thead>
					<tr>
						<th width="10%" ><?php echo $TblItem;?></th>
						<th width="15%" class="text-center"><?php echo $TblDes;?></th>
						<th width="15%" class="text-center"><?php echo $TblNote;?></th>
				<!--		<th width="5%"  class="text-center"><?php echo $TblLote?></th> -->
				<!--		<th width="5%"  class="text-center"><?php echo $TblLoc;?></th> -->
			        	<th width="5%"  class="text-center"><?php echo $TblUnitMeasure;?></th>
						<th width="5%"  class="text-center"><?php echo $TblTaxTyp;?></th>
						<th width="5%"  class="text-center"><?php echo $TblQty;?></th>
						<th width="5%"  class="text-center"><?php echo $TblUnitP;?></th>
						<th width="5%"  style="<?php echo $display;?>" class="text-center"><?php echo $TblTotal;?></th>
						</tr>
				</thead>
					<tbody id="items" ></tbody>
				</table>
				</fieldset>
				

				<!--totales-->
				<div  class="separador col-lg-12" ></div>
				<div  class="col-lg-8" ></div>
				<div  class="col-lg-4" style="<?php echo $display;?>">
					<fieldset class="fieldsetform">
						<table class='table_form' >
							<tbody>
					        	<tr><th><strong><?php echo $SubTotal;?></strong></th><td><input class="col-lg-12"  style="text-align:right;" type="number"  step="0.01" id="subtotal" name="subtotal"  value="0.00" readonly /></td></tr>
						        <tr><th><strong><?php echo $Tax;?></strong></th><td><input class="col-lg-12"  style="text-align:right;" type="number"  step="0.01" id="tax" name="tax" value="0.00" readonly/> </td></tr>
								<tr><th><strong><?PHP echo $Total; ?></strong></th><td><input class="col-lg-12"  style="text-align:right;" type="number"  step="0.01" id="total" name="total" value="0.00" readonly /></td>
							  </tr>
							</tbody>
						</table>
					</fieldset>
					</div>
				<!--totales-->

               </div>
               <!--fin detail-->
			   
			   <!--Button Process-->
				<div class="separador col-lg-12"> </div>
				<div class='col-lg-10'></div>
				<div class='col-lg-2'>
					<div class="container-login100-form-btn">
								<button type="button" id="process" class="accept-form-btn">
								<?PHP echo $BTN_Process; ?>
								</button>
					</div>
				</div>
				<!--fin Button Process-->

			<!--fin contenido-->
			</form>	
			<div class="separador col-lg-12"> </div>
		   </div>
		</div>
	</div>