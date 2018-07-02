

<?php
require_once APP.'view/modules/'.basename(__DIR__).'/lang/'.$this->model->lang.'_ref.php';


$NO_LINES =  $this->model->Query_value('FAC_DET_CONF','NO_LINES','where ID_compania="'.$this->model->id_compania .'"');
echo '<input type="hidden" id="FAC_NO_LINES" value="'.$NO_LINES .'" />'; 


$amnt_view_ck = $this->model->Query_value('SAX_USER','amountSO','where SAX_USER.onoff="1" and SAX_USER.id="'.$this->model->active_user_id.'"');
echo '<input type="hidden" id="ANMT_VIEW" value="'.$amnt_view_ck.'" />'; 
if ($amnt_view_ck==0){
  $display = "display:none;";
} else{
  $display = "";
}


$pice_mod_ck = $this->model->Query_value('SAX_USER','mod_price','where SAX_USER.onoff="1" and SAX_USER.id="'.$this->model->active_user_id.'"');
if ($pice_mod_ck == 1) {
  echo '<input type="hidden" id="editable" value="contenteditable" />'; 
}else{
  echo '<input type="hidden" id="editable" value="" />'; 
}

?>

<!--ADD JS FILE-->
<script  src="<?php echo URL; ?>js/operaciones/ventas/SalesOrder.js" ></script>



<!--ini authorization modal-->
<div id="AuthLogin" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
		<span class="modal-form-title"><?php echo $SO_Modal1_Tittle; ?></span>
	  </div>
	  <div class="separador col-lg-12"></div>
      <div class="col-lg-12 modal-body">
      <!--ini Modal  body-->  
            <div class="form-group col-lg-12">
				<div class="wrap-input100 validate-input m-b-16" data-validate="Please enter username">
					<input class="inputPage" type="text" id="user" name="user" placeholder="<?php echo $SO_Modal1_User; ?>" autocomplete="off" >
					<span class="focus-input100"></span>
				</div>
			</div>     
			<div class="form-group col-lg-12">
				<div class="wrap-input100 validate-input m-b-16" data-validate="Please enter username">
					<input class="inputPage" type="password"  name="pass" id="pass" placeholder="<?php echo $SO_Modal1_Pass; ?>" autocomplete="off" >
					<span class="focus-input100"></span>
				</div>
			</div>
      <!--fin Modal  body-->
      </div>
      <div class="modal-footer">
	  <div class="col-lg-6"></div>
	  <div class="col-lg-3">
        <button type="button" onclick="javascript:mod_price_auth();" data-dismiss="modal" class="accept-form-btn" ><?php echo $SO_Modal1_BTN1; ?></button>
	  </div>
	   <div class="col-lg-3">
		<button type="button" class="close-form-btn" data-dismiss="modal"><?php echo $SO_Modal1_BTN2; ?></button>
		</div>
	</div>
    </div>
  </div>
</div>
<!--fin authorization modal-->



<div class="limiter">
		<div class="container-page100">
			<div class="wrap-page100">
			
			<form method="POST"  action="" class="login100-form validate-form p-l-25 p-r-25 p-t-60" >
			<span class="page100-form-title">
						<?PHP echo $Title; ?>
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
				   <div  class="col-lg-6">
				   <fieldset class="fieldsetform">
					<table class='table_form'>
						<tbody>
						<tr>
							<th><strong><?PHP echo $SO_Cust; ?></strong></th>
								<td><select  id="customer" name="customer" class="select col-lg-12" onchange="set_listprice(this.value);" required>
								<option selected disabled></option>
								<?php  
								$CUST = $this->model-> get_ClientList(); 
								foreach ($CUST as $datos) {
									$CUST_INF = json_decode($datos);
									if ($CUST_INF->{'Custom_field3'}!=''){
									$field3 =  ' ('.$CUST_INF->{'Custom_field3'}.') ';
								}else{
									$field3 = '';
								}
								echo '<option value="'.$CUST_INF->{'ID'}.'" >'.$CUST_INF->{'CustomerID'}.' - '.$CUST_INF->{'Customer_Bill_Name'}.$field3."</option>";
								}

								?>
							</select></td></tr>
						</tbody>
					</table>
					</fieldset>
					</div>
					<div  class="col-lg-3"></div>

				    <div  class="col-lg-3">
					<fieldset class="fieldsetform">
					<table class='table_form'>
						<tbody>
							<tr>
								<th><strong><?PHP echo $SO_PO; ?></strong></th><td><input  class="inputPage col-lg-12" id="nopo" onkeyup="checkNOTA(this.id);" name="nopo"/></td>
							</tr>
						</tbody>
					</table>
					</fieldset>
					</div>

					<div  class="col-lg-12"></div>

					<div  class="col-lg-6">
					<fieldset class="fieldsetform">
						<table class='table_form' >
							<tbody>
					        	<tr><th><strong><?PHP echo $SO_PayTer; ?></strong></th><td><input  class="inputPage col-lg-12" id="termino_pago" onkeyup="checkNOTA(this.id);" name="termino_pago" readonly /></td></tr>
						    	<tr><th><strong><?PHP echo $SO_Lic; ?></strong></th><td><input class="inputPage col-lg-12" id="tipo_licitacion" onkeyup="checkNOTA(this.id);" name="tipo_licitacion"/></td></tr>
								<tr>
								<th><strong><?PHP echo $SO_Tax; ?></strong></th><td> 
									<select  id="taxid" name="taxid" class="select col-lg-12" onchange="set_taxid(this.value,2);" required>
										<?php  
										$tax = $this->model->Get_sales_conf_Info(); 
										foreach ($tax  as $datos) {
										$tax  = json_decode($datos);
										if($tax->{'taxid'}=='ITBMS'){
											$selected = 'selected';
										}else{   
											$selected = '';
										}
										echo '<option value="'.$tax ->{'rate'}.'" '.$selected.'>'.$tax->{'taxid'}.'</option>';
										}
										?>
									</select>
								</td>
								</tr>
							</tbody>
						</table>
					</fieldset>
					</div>
					
					<div  class="col-lg-6">
					<fieldset class="fieldsetform">
						<table class='table_form' >
							<tbody>
					        	<tr><th><strong><?PHP echo $SO_DeliDate; ?></strong></th><td><input  class="inputPage col-lg-12" id="fecha_entrega" onkeyup="checkNOTA(this.id);" name="fecha_entrega" /></td></tr>
						        <tr><th><strong><?PHP echo $SO_Delito; ?></strong></th><td><input class="inputPage  col-lg-12" id="entrega" onkeyup="checkNOTA(this.id);" name="entrega" /></td></tr>
								<tr><th><strong><?PHP echo $SO_DispFrom; ?></strong></th>
								<td>
									<select  id="lugar_despacho" name="lugar_despacho" class="select col-lg-12"  required>
										<option  selected disabled></option>
										<?php 
										$sql = 'SELECT * FROM SHIP_INFO WHERE id_compania="'.$this->model->id_compania.'"';
										$ship = $this->model->Query($sql); 
											foreach ($ship  as $datos) {
												$datos  = json_decode($datos);
												echo '<option value="'.$datos->{'ShipAddress'}.'">'.$datos->{'ShipAddress'}.'</option>';
											}
										?>
									</select>
								</td>
							  </tr>
							</tbody>
						</table>
					</fieldset>
					</div>

					<div  class="col-lg-12"></div>

					<div  class="col-lg-12">
					<fieldset class="fieldsetformb">
					<table class='table_form note'>
						<tbody>
						<tr><th><strong><?PHP echo $SO_Notes; ?></strong></th>
						<td><textarea class="textareaPage col-lg-12" onkeyup="checkArroba(this.id);"  rows="2" id="observaciones" name="observaciones"></textarea></td></tr>
						</tbody>
					</table>
					</fieldset>	
					</div>
					<!--ini btn authorization-->
					<?php 
					if($pice_mod_ck!=1){ ?>
					<div class="col-lg-1"> </div>
					<div  class="col-lg-3">
						<input data-toggle="modal" data-target="#AuthLogin" type='button' class="close-form-btn"  value="<?PHP echo $BTN_AuthChange; ?>" />
					</div>
					<?php }  ?>
					<!--fin btn authorization-->
					

				</div>
				<!--fin header-->
				<div class="separador col-lg-12"> </div>

				<!--ini detail-->
				<div class="col-lg-12"> 
				<fieldset class="table_req fieldsetform" >
				<table id="table_ord_tb" class="display table table-striped table-condensed table-bordered " cellspacing="0">
				<thead>
					<tr >
					<th width="10%" ><?php echo $TblItem;?></th>
					<th width="15%" class="text-center"><?php echo $TblDes;?></th>
					<th width="15%" class="text-center"><?php echo $TblNote;?></th>
					<th width="5%"  class="text-center"><?php echo $TblSmall?></th>
					<th width="5%"  class="text-center"><?php echo $TblBig;?></th>
					<th width="5%" class="text-center"><?php echo $TblQty;?></th>
					<th width="5%" class="text-center"><?php echo $TblUnitP;?></th>
					<th width="5%" style="<?php echo $display;?>" class="text-center"><?php echo $TblTotal;?></th>
					</tr>
				</thead>
					<tbody id="table_req" ></tbody>
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