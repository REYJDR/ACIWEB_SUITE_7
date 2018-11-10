<?php
require_once APP.'view/modules/'.basename(__DIR__).'/lang/'.$this->model->lang.'_ref.php';


?>

<input type="hidden" id="FAC_NO_LINES" value="<?php echo $this->model->layout_lines; ?>" /> 
<input type="hidden"  id="saletaxid"  value="" />
<!--ADD JS FILE-->
<script  src="<?php echo URL; ?>js/operaciones/inventory/invIn.js" ></script>




<div class="limiter">
		<div class="container-page100">
			<div class="wrap-page100">
			<form method="POST"  action="" class="login100-form validate-form p-l-25 p-r-25 p-t-60" >

			<span class="page100-form-title">
						<?PHP echo $Title_invIn; ?>
			</span>
			<!--INI DIV ERRO-->
			<div id="ERROR" ></div>
			<!--INI DIV ERROR-->
			
				<!--ini contenido-->



					<!--CHECKBOXES-->
					<div  class="col-lg-4">
					<fieldset class="fieldsetform">	
					<h4><?PHP echo $invIn13; ?></h4>
					<div class="separador col-lg-12"> </div>
						<fieldset>
						<table class='table_form'>
							<tbody>
								<tr>
									<td><input type="checkbox" class='chkGrp' id="chk_lp" name="chk_lp" value="1" onclick="set_div(this.value)" /></td>					
									<th><strong><?PHP echo $invIn1; ?></strong></th>
								</tr>
								</tr>
								<td><input type="checkbox" class='chkGrp' id="chk_lp" name="chk_lp" value="3" onclick="set_div(this.value)"  checked /></td>					
									<th><strong><?PHP echo $invIn10; ?></strong></th>
								</tr>
								<tr>
					<!--			<td><input type="checkbox" class='chkGrp' id="chk_lp" name="chk_lp" value="2" onclick="set_div(this.value)" /></td>					
									<th><strong><?PHP echo $invIn2; ?></strong></th> -->

							</tbody>
						</table>
						</fieldset>
						</fieldset>
					</div>
					<!--CHECKBOXES-->


					<div class="separador col-lg-12"> </div>

						<!--ENTRADA INDIVIDUAL-->
						<div  class="col-lg-12" id="prod_ind">
						<!--ini  header-->
						<div class="col-lg-8">
						 <fieldset  class="fieldsetform"> 		
							<h4><?PHP echo $invIn3; ?></h4>
							<div class="separador col-lg-12"> </div>
								<div  class="col-lg-8">
								<fieldset class="fieldsetform">
									<table class='table_form'>
										<tbody>
										<tr><th><strong><?PHP echo $invInfo1; ?></strong></th><td><input  class="inputPage col-lg-12"  value=""/></td>		</tr>
										<tr><th><strong><?PHP echo $invInfo2; ?></strong></th><td><input  class="inputPage col-lg-12"  value=""/></td> 	</tr>
										<tr><td><strong><?PHP echo $invIn8; ?></strong></td>					
										    <th><input type="checkbox" id="isActive" name="isActive" checked  /></th></tr>
										 </tbody>
									</table>
									</fieldset>
								</div>
						<div class="separador col-lg-12"></div>
							<div  class="col-lg-6">
								<fieldset class="fieldsetform">
									<table class='table_form'>
										<tbody>
										<tr><th><strong><?PHP echo $invInfo4; ?></strong></th><td><input  class="inputPage col-lg-12  numb"  value=""/></td>		</tr>
										<tr><th><strong><?PHP echo $invInfo5; ?></strong></th><td><input  class="inputPage col-lg-12  numb"  value=""/></td>		</tr>
										<tr><th><strong><?PHP echo $invInfo6; ?></strong></th><td><input  class="inputPage col-lg-12  numb"  value=""/></td>		</tr>	
										</tbody>
									</table>
									</fieldset>
								</div>

							<div  class="col-lg-6">
								<fieldset class="fieldsetform">
									<table class='table_form'>
										<tbody>
										<tr><th><strong><?PHP echo $invIn7; ?></strong></th><td><input  class="inputPage col-lg-12  numb"  value=""/></td></tr> 
										<tr><th><strong><?PHP echo $invInfo8; ?></strong></th><td><input  class="inputPage col-lg-12  numb"  value=""/></td></tr>
										<tr><th><strong><?PHP echo $invInfo9; ?></strong></th><td><input  class="inputPage col-lg-12  numb"  value=""/></td></tr>	
										</tbody>
									</table>
									</fieldset>
								</div>
							<div class="separador col-lg-12"></div>
							<div  class="col-lg-6">
								<fieldset class="fieldsetform">
								<h4><?PHP echo $invIn6; ?></h4>
									<div class="separador col-lg-12"> </div>
									<table class='table_form'>
										<tbody>
										<tr><th><strong><?PHP echo $invIn4; ?></strong></th><td><select id="up_stock" class="form-control"  onchange="locat(this.value,0);"></select></td></tr>
										<tr><th><strong><?PHP echo $invIn5; ?></strong></th><td><select id="up_route" class="form-control" ></select></td></tr>
										</tbody>
									</table>
									</fieldset>
								</div>
								<div  class="col-lg-6">
								<fieldset class="fieldsetform">
								<h4><?PHP echo $invIn11; ?></h4>
									<div class="separador col-lg-12"> </div>
									<table class='table_form'>
										<tbody>										
										<select class="select col-lg-12"  id="JOBID" >
										<option value="-" selected>-</option>

										</select>		
										</td></tr>
										</tbody>
									</table>
									</fieldset>
								</div>

								<!--Button Process-->
								<div class='col-lg-10'></div>
								<div class='col-lg-2'>
									<div class="container-login100-form-btn">
									<input name="proc_indv" type="submit"  value="<?PHP echo $BTN_InvIN_Proc; ?>"  class="accept-form-btn" name="submit"  value="<?PHP echo $BTN_Process; ?>" />			
									</div>
								</div>
								<div class="separador col-lg-12"> </div>
								<!--fin Button Process-->

							</fieldset>
							</div>
							<!--fin  header-->			
						</div>
						<!--ENTRADA INDIVIDUAL-->

						<!--ENTRADA MASIVA-->
						<div  class="col-lg-12" id="prod_masive">
						<fieldset class="fieldsetform">				
							
							<!--INI HEADER ENTRADA MASIVA-->			
							<div class="col-lg-10"> 
								<div  class="col-lg-4">
								<fieldset class="fieldsetformb">
								<h4><?PHP echo $invIn16; ?></h4>
					
								<table class='table_form note'>
									<tbody>
									<tr>
									    <th><strong><?PHP echo $invIn11; ?></strong></th>
									    <td>
								        <select class="select col-lg-12"  id="JOBID2" >
										<option value="-" selected>-</option>
										</select>
										</td>
									</tr>
					<!--				<tr>
									    <th><strong><?PHP echo $invIn14; ?></strong></th>
									    <td>
								        <select class="select col-lg-12"  id="PHASEID2"  >
										<option value="-" selected>-</option>
										</select>
										</td>
									</tr>
									<tr>
									    <th><strong><?PHP echo $invIn15; ?></strong></th>
									    <td>
								        <select class="select col-lg-12"  id="COSTID2"  >
										<option value="-" selected>-</option>
										</select>
										</td>
									</tr> -->
									<tr>
									    <th><strong><?PHP echo $invIn17; ?></strong></th>
										<td><input id="Budget" name="Budget" class="inputPage col-lg-12  numb"  value=""/></td>
									</tr>	
										
									</tbody>
								</table>
								</fieldset>	
								<fieldset class="fieldsetformb">
								<table class='table_form note'>
									<tbody>
									   <th><strong><?PHP echo $invIn12; ?></strong></th>
									   <th><input type="checkbox" id="adjust" name="adjust" /></th></tr>
									   
									</tr>
									</tbody>
								</table>
								</fieldset>	
								</div>
								<div  id='invDetail' class="col-lg-8">
								<div class="col-lg-6">
									<fieldset class="fieldsetformb">	
									<h4><?PHP echo $invIn21; ?></h4>				
									<table class='table_form note'>
										<tbody>
										<tr>
											<th><strong><?PHP echo $invIn20; ?></strong></th>
											<td>
											<input id="invoice" name="invoice" class="inputPage col-lg-12  numb"  value=""/>																				
											</td>
										</tr>	
										<tr>
											<th><strong><?PHP echo $invIn18; ?></strong></th>
											<td>
											<input type="date" id="fecha" name="fecha" class="inputPage col-lg-12  numb"  value=""/>
											</td>
										</tr>
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
									<div class="col-lg-6">
										<fieldset class="fieldsetformb">	
										<table class='table_form note'>
										<tbody>
										<tr>
											<th><strong><?PHP echo $invIn19; ?></strong></th>
											<td>
											<?PHP 
											
											$res= $this->model->Get_company_Info();
											
												foreach ($res as $Comp_Info) {
											
													$Comp_Info = json_decode($Comp_Info);
													$Sage_Conn = $Comp_Info->{'Sage_Conn'};
												}	 
												
											if ($Sage_Conn == 9) {//standalone ?>
										
											<input id="vendorID" name="vendorID" class="inputPage col-lg-12  numb"  value=""/>										

											<?PHP }else{ ?>

											<select class="selectJob col-lg-12"  id="vendorID" >
											<option value="-" selected>-</option>
											</select>

											<?php } ?>
											</td>
										</tr>
										<tr>	
											<th><strong><?PHP echo $invIn22; ?></strong></th>
											<td>
										
											<select class="selectOc col-lg-12"  id="vendorOC" >
											<option value="-" selected>-</option>
											</select>

											</td>
											
										</tr>

										
										</tbody>
									</table>
									</fieldset>	
								</div>
								
								</div>


								</div>
								<!-- FIN HEADER ENTRADA MASIVA --> 


								<!--ini detail-->
								<div class="col-lg-12"> 
								<fieldset class="table_req fieldsetform" >
								<table id="table_ord_tb" class="display table table-striped table-condensed table-bordered " cellspacing="0">
								<thead>
									<tr>
										<th width="10%" ><?php echo $TblItem;?></th>
										<th width="15%" class="text-center"><?php echo $TblDes;?></th>
							<!--		<th width="5%"  class="text-center"><?php echo $TblUnitMeasure;?></th> -->		
							<!--	    <th width="15%" class="text-center"><?php echo $TblUPCSKU;?></th>	 -->	
							<!--	    <th width="5%"  class="text-center"><?php echo $TblGlAcct;?></th>-->
										<th width="5%"  style='display:none;' class="text-center"><?php echo $TblTaxTyp;?></th>		
							<!--		<th width="5%"  class="text-center"><?php echo $Tblstock?></th>										
										<th width="5%"  class="text-center"><?php echo $Tblloc;?></th>
										<th width="5%"  class="text-center"><?php echo $TblLote?></th>
										<th width="5%"  class="text-center"><?php echo $Tblfecha?></th> -->
										
										<th width="5%"  class="text-center"><?php echo $TblQtyOrd;?></th>
										<th width="5%"  class="text-center"><?php echo $TblQty;?></th>
										<th width="5%"  class="text-center"><?php echo $TblUnitP;?></th>
										<th width="5%"  class="text-center"><?php echo $TblTotal;?></th>
										<th width="5%"  class="text-center"><?php echo $Inv_REP_TblHdr9;?></th>
					                	<th width="5%"  class="text-center"><?php echo $Inv_REP_TblHdr10;?></th>
										</tr>
								</thead>
									<tbody id="items" ></tbody>
								</table>
								</fieldset>

								<!--totales-->
								<div  class="separador col-lg-12" ></div>
								<div  class="col-lg-10" ></div>
								<div  class="col-lg-2" style="<?php echo $display;?>">
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
							<div  class="separador col-lg-12" ></div>
							
							<div class='col-lg-10'></div>
							<div class='col-lg-2'>
								<div class="container-login100-form-btn">
								<input type='Button' name="proc_lote" id="proc_lote"  onclick="proceed();"  value="<?PHP echo $BTN_InvIN_Proc; ?>"  class="accept-form-btn" />			
								</div>
							</div>
							<div class="separador col-lg-12"> </div>
							<!--fin Button Process-->
						</fieldset>									
						</div>
						<!--ENTRADA MASIVA-->


						<!--ENTRADA POR LAYOUT-->
						<div  class="col-lg-8" id="prod_layout">
						<fieldset class="fieldsetform">				
							<table class='table_form'>
								<tbody>
									<tr>
										<th><strong><?PHP echo $invIn9; ?></strong></th>
										<!--INPUT FILE-->
										<td><input type="file" class="form-control" id="product_file" name="product_file" required />	
											<p class="help-block"><?PHP echo $Advice1; ?></p>
										</td>			
									</tr>
								</tbody>
							</table>
							

							<!--Button Process-->
							<div class='col-lg-10'></div>
							<div class='col-lg-2'>
								<div class="container-login100-form-btn">
								<input name="proc_layout" id="proc_layout"  value="<?PHP echo $BTN_InvIN_Proc; ?>"  class="accept-form-btn" />	
								</div>
							</div>
							<div class="separador col-lg-12"> </div>
							<!--fin Button Process-->
						</fieldset>									
						</div>
						<!--ENTRADA POR LAYOUT-->


				<!--fin contenido-->
		
		    </form>	
			<div class="separador col-lg-12"> </div>
			</div>
		</div>
	</div>