

<?php
require_once APP.'view/modules/'.basename(__DIR__).'/lang/'.$this->model->lang.'_ref.php';


$NO_LINES =  $this->model->Query_value('FAC_DET_CONF','NO_LINES','where ID_compania="'.$this->model->id_compania .'"');
echo '<input type="hidden" id="FAC_NO_LINES" value="'.$NO_LINES .'" />'; 

?>

<!--ADD JS FILE-->
<script  src="<?php echo URL; ?>js/operaciones/inventory/conTras.js" ></script>


<div class="limiter">
		<div class="container-page100">
			<div class="wrap-page100">
			
			<form method="POST"  action="" class="login100-form validate-form p-l-25 p-r-25 p-t-60" >
			<span class="page100-form-title">
						<?PHP echo $Title4; ?>
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

					<div class="separador col-lg-12"> </div>

					<div  class="col-lg-3">
					<fieldset class="fieldsetform">
					<table class='table_form'>
						<tbody>
							<tr>
								<th><strong><?PHP echo $invout_ref; ?></strong></th><td><input  class="inputPage col-lg-12 numb" id="referencia" onkeyup="checkInpChar(this.id);" name="referencia"/></td>
							</tr>
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
						<th width="5%"  class="text-center"><?php echo $TblStockOri;?></th>
						<th width="5%"  class="text-center"><?php echo $TblQtyCon;?></th>
						<th width="5%"  class="text-center"><?php echo $TblStockDes;?></th> 
						<th width="5%"  class="text-center"><?php echo $TblLocDes;?></th>

						</tr>
				</thead>
					<tbody id="items" ></tbody>
				</table>
				</fieldset>


               </div>
               <!--fin detail-->
			   
			   <!--Button Process-->
				<div class="separador col-lg-12"> </div>
				<div class='col-lg-10'></div>
				<div class='col-lg-2'>
					<div class="container-login100-form-btn">
								<button type="button" id="process" onclick="proceed();"  class="accept-form-btn">
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