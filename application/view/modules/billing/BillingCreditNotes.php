<?php
require_once APP.'view/modules/'.basename(__DIR__).'/lang/'.$this->model->lang.'_ref.php';


$NO_LINES =  $this->model->Query_value('FAC_DET_CONF','NO_LINES','where ID_compania="'.$this->model->id_compania .'"');

echo '<input type="hidden" id="FAC_NO_LINES" value="'.$NO_LINES .'" />'; 

$pice_mod_ck = $this->model->Query_value('SAX_USER','mod_price','where SAX_USER.onoff="1" and SAX_USER.id="'.$this->model->active_user_id.'"');

if ($pice_mod_ck == 1) {

  echo '<input type="hidden" id="editable" value="contenteditable" />'; 

}else{

  echo '<input type="hidden" id="editable" value="" />'; 

}
?>


<!--ADD JS FILE-->
<script  src="<?php echo URL; ?>js/operaciones/notasdecredito/BillCreditNotes.js" ></script>


<!--modal-->

<div id="AuthLogin" class="modal fade" role="dialog">

  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 >Credenciales de autorización</h3>
      </div>

      <div class="col-lg-12 modal-body">

      <!--ini Modal  body-->  
            <div class="form-group col-lg-12">
              <label class="control-label" for="username">Usuario</label>
              <input type="text" class="inputPage form-control" id="user" name="user"  autocomplete="off" />
            </div>            
            <div class="form-group col-lg-12">
              <label class="control-label" for="passwd">Password</label>
              <input type="password" class="inputPage form-control" name="pass" id="pass" autocomplete="off" />
            </div>

      <!--fin Modal  body-->
      </div>
      <div class="modal-footer">
        <button type="button" onclick="javascript:mod_price_auth();" data-dismiss="modal" class="btn btn-primary" >Aceptar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!--modal-->
<input type="hidden" id="URL" value="">
<input type="hidden" id="saletaxid" value="">
<input type="hidden" id="listID" value="">

<div class="limiter">
		<div class="container-page100">
			<div class="wrap-page100">
			<form method="POST"  action="" class="login100-form validate-form p-l-25 p-r-25 p-t-60" >

			<span class="page100-form-title">
						<?PHP echo $TitleCrdNote; ?>
			</span>
			<!--INI DIV ERRO-->
			<div id="ERROR" class="alert"></div>
			<!--INI DIV ERROR-->
			
			<!--ini contenido-->
			    <!--ini  header-->
				<div class="col-lg-8"> 
				   <div  class="col-lg-6">
				   <fieldset class="fieldsetform">
					<table class='table_form'>
						<tbody>
						<tr>
							<th><strong><?PHP echo $CN_Cust; ?></strong></th>
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
								<th><strong><?PHP echo $CN_PO; ?></strong></th><td><input  class="inputPage col-lg-12" id="nopo" onkeyup="checkNOTA(this.id);" name="nopo"/></td>
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
					        	<tr><th><strong><?PHP echo $CN_PayTer; ?></strong></th><td><input  class="inputPage col-lg-12" id="termino_pago" onkeyup="checkNOTA(this.id);" name="termino_pago" readonly /></td></tr>
						    	<tr><th><strong><?PHP echo $CN_Lic; ?></strong></th><td><input class="inputPage col-lg-12" id="tipo_licitacion" onkeyup="checkNOTA(this.id);" name="tipo_licitacion"/></td></tr>
								<tr>
								<th><strong><?PHP echo $CN_Tax; ?></strong></th><td> 
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
					        	<tr><th><strong><?PHP echo $CN_DeliDate; ?></strong></th><td><input  class="inputPage col-lg-12" id="fecha_entrega" onkeyup="checkNOTA(this.id);" name="fecha_entrega" /></td></tr>
						        <tr><th><strong><?PHP echo $CN_Delito; ?></strong></th><td><input class="inputPage  col-lg-12" id="entrega" onkeyup="checkNOTA(this.id);" name="entrega" /></td></tr>
								<tr><th><strong><?PHP echo $CN_DispFrom; ?></strong></th>
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
						<tr><th><strong><?PHP echo $CN_Notes; ?></strong></th>
						<td><textarea class="textareaPage col-lg-12" onkeyup="checkArroba(this.id);"  rows="2" id="observaciones" name="observaciones"></textarea></td></tr>
						</tbody>
					</table>
					</fieldset>	
					</div>
					
					<div  class="col-lg-12">
					
					<div  class="col-lg-6">
					<fieldset class="fieldsetform">
						<table class='table_form' >
							<tbody>
								<tr><th><strong><?PHP echo $CN_PrinterSN; ?></strong></th>
								<td><select class='select col-lg-12' id='serial' name='serial' >
									<option value="" selected></option>
									<?PHP 
										$list = $this->getPrinterList();
										$Printers = '';
										foreach ($list as $key => $value) {
											$value = json_decode($value);
											$Printers .= '<option value="'.$value->{'SERIAL'}.'">'.$value->{'SERIAL'}.'</option>';
										}
										echo $Printers;
									?>
								</select>
								</td>
								</tr><tr><th><strong><?PHP echo $CN_InvNo; ?></strong></th><td><input type="text" id="nofact" name="nofact" class="inputPage col-lg-8" maxlength="10" /></td></tr>
								<tr><th><strong><?PHP echo $CN_Printer; ?></strong></th>
									<td>
									<select class='select col-lg-12' id='Printer' name='Printer' >
										<option value="" selected></option>
										<?PHP 
											$list = $this->getPrinterList();
											$DefPrint = $this->GetUserDefaultPrinter();
											$Printers = '';

											foreach ($list as $key => $value) {
												$value = json_decode($value);
												if($DefPrint == $value->{'SERIAL'}){ $selected = 'selected'; }else { $selected = ''; }
												$Printers .= '<option value="'.$value->{'SERIAL'}.'"  '.$selected.' >'.$value->{'DESCRIPCION'}.' ( '.$value->{'SERIAL'}.') </option>';
											}   
											echo $Printers;

										?>
									</select>
								   </td>
								</tr>
							</tbody>
							</table>
					</fieldset>
					</div>

					<div  class="col-lg-6">
					<fieldset class="fieldsetformb">
					<table class='table_form note'>
						<tbody>
						<tr><th><strong><?PHP echo $CN_Reason; ?></strong></th>
						<td><select class='select col-lg-12' id='motivo' name='motivo' >
							<option value="" selected></option>
							<?PHP 
								$list = $this->getMotivosList();

							foreach ($list as $value) {    
									$value = json_decode($value);
									$motivos .= '<option value="'.$value->{'DESCRIPTION'}.'" >'.$value->{'DESCRIPTION'}.'</option>';
								}
								echo $motivos;
							?>
				        	</select>
				         </td>
					   </tbody>
					</table>
					</fieldset>	
					</div>

					</div>
					</div>
				
                <!--end  header-->

			<div class="separador col-lg-12"> </div>
			
			<!--ini table-->
			<div class="separador col-lg-12"> </div>
			<?php 
			if($pice_mod_ck!=1){ ?>
			<div  class="col-lg-10"></div>
			<div  class="col-lg-2">
				<input data-toggle="modal" data-target="#AuthLogin" type="submit" class="btn btn-primary  btn-sm btn-icon icon-right" value="Aut. Cambio" />
			</div>
			<?php }  ?>

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
								<button onclick="SetNota();" type="button" id="process" class="accept-form-btn">
								<?PHP echo $BTN_Process2; ?>
								</button>
					</div>
				</div>
				<div  class="separador col-lg-12" ></div>				
				<!--fin Button Process-->

				</form>	
				<!--fin contenido-->
			</div>
		</div>
	</div>