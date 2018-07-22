<?php
require_once APP.'view/modules/'.basename(__DIR__).'/lang/'.$this->model->lang.'_ref.php';
?>


<!--ADD JS FILE-->
<script  src="<?php echo URL; ?>js/operaciones/customers/PricesList.js" ></script>


<div class="limiter">
		<div class="container-page100">
			<div class="wrap-page100">
			<form method="POST"  action="" class="login100-form validate-form p-l-25 p-r-25 p-t-60" enctype="multipart/form-data">

			<span class="page100-form-title">
				<?PHP echo $TitleCus; ?>
			</span>
			<!--INI DIV ERRO-->
			<div id="ERROR" class="alert"></div>
			<!--INI DIV ERROR-->

			<!--ini contenido-->
			<div  class="col-lg-8">
			<fieldset >
			<input type="hidden"  class="inputPage" id="control" name="control" value='1'/>
			<div class="separador col-lg-12"></div> <!--SEPERADOR-->

				<!--INPUT CUSTOMER-->
				<div  class="col-lg-12" id="nvo_lp">
				<fieldset class="fieldsetform">
				<table class='table_form'>
					<tbody>
						<tr>
							<th><strong><?PHP echo $InputCust_1; ?></strong></th>
							<td><input type="text"  class="inputPage" id="cus_id" name="cus_id" required /></td>		
							<th><strong><?PHP echo $InputCust_2; ?></strong></th>
							<td><input type="text"  class="inputPage" id="cus_name" name="cus_name" required /></td>				
						</tr>
						<tr>
							<th><strong><?PHP echo $InputCust_3; ?></strong></th>
							<td><input type="text"  class="inputPage" id="cus_cel" name="cus_cel" required /></td>		
							<th><strong><?PHP echo $InputCust_4; ?></strong></th>
							<td><input type="text"  class="inputPage" id="cus_contact" name="cus_contact" required /></td>				
						</tr>
						<tr>
							<th><strong><?PHP echo $InputCust_5; ?></strong></th>
							<td><input type="text"  class="inputPage" id="cus_country" name="cus_country" required /></td>		
							<th><strong><?PHP echo $InputCust_6; ?></strong></th>
							<td><input type="text"  class="inputPage" id="cus_state" name="cus_state" /></td>				
						</tr>
						<tr>
							<th><strong><?PHP echo $InputCust_7; ?></strong></th>
							<td><input type="text"  class="inputPage" id="cus_city" name="cus_city" /></td>		
							<th><strong><?PHP echo $InputCust_8; ?></strong></th>
							<td><input type="text"  class="inputPage" id="cus_zip" name="cus_zip" /></td>				
						</tr>
						<tr>
							<th><strong><?PHP echo $InputCust_9; ?></strong></th>
							<td><input type="email"  class="inputPage" id="cus_email" name="cus_email" required /></td>		
							<th><strong><?PHP echo $InputCust_10; ?></strong></th>
							<td><input type="text"  class="inputPage" id="cus_pl" name="cus_pl" /></td>				
						</tr>
						<tr>
							<th><strong><?PHP echo $InputCust_11; ?></strong></th>
							<td><input type="number" class="form-control numb" id="cus_bal" name="cus_bal" /></td>		
							<th><strong><?PHP echo $InputCust_12; ?></strong></th>
							<td><input type="number" class="form-control numb" id="cus_creditlimit" name="cus_creditlimit" /></td>				
						</tr>
						<tr>
							<th><strong><?PHP echo $InputCust_13; ?></strong></th>
							<td><input type="text"  class="inputPage" id="cus_salesId" name="cus_salesId" required /></td>		
							<th><strong><?PHP echo $InputCust_14; ?></strong></th>
							<td><input type="text"  class="inputPage" id="cus_SalesName" name="cus_SalesName" required /></td>				
						</tr>
						<tr>
							<th><strong><?PHP echo $InputCust_15; ?></strong></th>
							<td><input type="text"  class="inputPage" id="cus_addres1" name="cus_addres1" required /></td>		
							<th><strong><?PHP echo $InputCust_16; ?></strong></th>
							<td><input type="text"  class="inputPage" id="cus_addres2" name="cus_addres2" /></td>				
						</tr>
					</tbody>
				</table>
				</fieldset>
				</div>
				<!--INPUT CUSTOMER-->

				
			    <div class="separador col-lg-12"></div> <!--SEPERADOR-->
				
				
				<!--Button Process-->
				<div class='col-lg-2'></div>
				<div class='col-lg-2'>
					<div class="container-login100-form-btn">
					<input type="submit" class="accept-form-btn" name="submit"  value="<?PHP echo $BTN_add; ?>" />			
					</div>
				</div>
				<div class="separador col-lg-12"> </div>
				<!--fin Button Process-->

			
            
			</fieldset>
			</div>

			<div class="separador col-lg-12"> </div>


			<div class='col-lg-9'>
			<fieldset class="fieldsetform">
				<!--Table-->
				<table id="table_customer" class="table table-striped responsive table-bordered" cellspacing="0" >
				<thead>
				<tr>
					<th width="5%"><?PHP echo $TableCust_th1; ?></th>
					<th width="10%"><?PHP echo $TableCust_th2; ?></th>
					<th width="20%"><?PHP echo $TableCust_th3; ?></th> 
					<th width="5%"><?PHP echo $TableCust_th4; ?></th>
					<th width="5%"><?PHP echo $TableCust_th5; ?></th>
					<th width="5%"><?PHP echo $TableCust_th6; ?></th>
					<th width="20%"></th>
				</tr>
				</thead>
			<tbody>

			<?php
				
				//ADD CUSTOMER

				if ($isset($_POST['submit'])) {
					
					
					/*if ($_POST['submit'] == '') {
						# code...
					}elseif ($_POST['submit'] == '') {
						# code...
					}elseif ($_POST['submit'] == '') {
						# code...
					}elseif ($_POST['submit'] == '') {
						# code...
					}elseif ($_POST['submit'] == '') {
						# code...
					}elseif ($_POST['submit'] == '') {
						# code...
					}elseif ($_POST['submit'] == '') {
						# code...
					}elseif ($_POST['submit'] == '') {
						# code...
					}*/

						
						$Values = array( 
									    'CustomerID' => $_POST['cus_id'],
									    'Customer_Bill_Name'  => $_POST['cus_name'],
									    'Phone_Number'=> $_POST['cus_cel'],
									    'Contact'  => $_POST['cus_contact'],
									    'Country'=> $_POST['cus_country'],
									    'State'=> $_POST['cus_state'],
									    'City'=> $_POST['submit'],
									    'Zip'=> $_POST['submit'],
									    'Email'=> $_POST['submit'],
									    'PriceLevel'=> $_POST['submit'],
									    'Balance'=> $_POST['submit'],
									    'CreditLimit'=> $_POST['submit'],
									    'SalesRepID'=> $_POST['submit'],
									    'SalesRepName'=> $_POST['submit'],
									    'AddressLine1'=> $_POST['submit'],
									    'AddressLine2'=> $_POST['submit'],
									    'IsActive'=> 1,
									    'ID_compania' => $this->model->id_compania);

				}


				$clause.= 'WHERE ID_compania="'.$this->model->id_compania.'" '; 


				$cus = $this->getCustomerList('asc','10000',$clause);

				foreach ($cus as $value) {

				$value = json_decode($value);

				$cus_ID = $value->{'ID'};
				$cus_ID = "'".$cus_ID."'";


				$table .= ' <tr>
								<td><a href="javascript:void(0)" onclick="get_cus('.$cus_ID.')"><strong>'.$value->{'CustomerID'}.'</strong></a></td>
								<td>'.$value->{'Customer_Bill_Name'}.'</td>
								<td>'.$value->{'Phone_Number'}.'</td>
								<td>'.$value->{'Contact'}.'</td>
								<td>'.$value->{'Country'}.'</td>
								<td>'.$value->{'Email'}.'</td>
								<td><a  href="javascript:void(0)" onclick="del_cus('.$cus_ID.')"><input type="button" id="modal_del" name="modal_del" class="btn btn-danger btn-sm btn-icon icon-left" value="'.$BTN_del.'" /></a><a  href="javascript:void(0)" onclick="set_cus_info('.$cus_ID.')"><input id="modal_del" name="modal_del" data-toggle="modal" data-target="#cust_mod" type="button" class="btn btn-danger btn-sm btn-icon icon-left"  value="'.$BTN_mod.'" /></a></td>
							</tr>';

				}
			
				echo $table;
			?>
            </tbody></table>

            <div class="separador col-lg-12"></div>
            <div class="col-lg-12" > 
            <div id="table3"></div>
            </div>
			<!--Table-->

			</form>
			
			</fieldset>
			</div>
			<!--fin contenido-->
            

			<div class="separador col-lg-12"> </div>
			</div>
		</div>
	</div>

<!-- Modal : VENTANA EMERGENTE QUE PERMITE MODIFICAR UN ITEM ESPECIFICO-->
<div id="cust_mod" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <span class="modal-header" >Modificar Item</span>
	  </div>
	  <form method="POST"  action="" class="login100-form validate-form p-l-25 p-r-25 p-t-60" enctype="multipart/form-data">


      <div class="col-lg-12 modal-body">
        
      <div id='prod'></div>

        <div class="col-lg-3" > 
             <label class="control-label">ID Item: </label>
             <input  class="form-control" id="item_id_modal" name="item_id_modal"  readonly/>
             <input type="hidden" class="form-control" id="PL_id" name="PL_id"/>
        </div>
        
        <div class="col-lg-2" > 
             <label class="control-label">Precio: </label>
             <input type="number" class="form-control numb" id="price_id_modal" name="price_id_modal"/>
        </div>
        <div class="col-lg-2" > 
             <label class="control-label">Unidad: </label>
             <input  class="form-control" id="unit_id_modal" name="unit_id_modal" readonly/>
        </div>

        <div class="form-group col-lg-5" > 
              <label class="control-label" >Descripcion:</label>
              <input class="form-control col-lg-10" id="desc_id_modal" name="desc_id_modal"/>
        </div> 
        

    <div class="col-lg-12" ></div>    
      </div>
      <div class="modal-footer">
	  <div class="col-lg-4" ></div>  
		<div class="col-lg-4" >
		<button type="button" onclick="mod_item();" class="btn btn-primary" data-dismiss="modal">Modificar</button>
		</div>
		<div class="col-lg-4" >
		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		</div>    
      </div>
    </div>
	</form>
  </div>
</div>

<div class="separador col-lg-12"></div>


<!-- Modal : VENTANA EMERGENTE QUE PERMITE MODIFICAR UN ITEM ESPECIFICO-->
<div id="modal_additem" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <span >Agregar Item</span>
      </div>

	  <form method="POST"  action="" class="login100-form validate-form p-l-25 p-r-25 p-t-60" enctype="multipart/form-data">
	  
      <div class="col-lg-12 modal-body">
        
      <div id='prod'></div>

        <div class="col-lg-3" > 
             <label class="control-label">ID Item: </label>
             <input  class="form-control" id="item_id_modal_2" name="item_id_modal_2"  type="text" />
             <input type="hidden" class="form-control" id="PL_id_2" name="PL_id_2"/>
        </div>
        
        <div class="col-lg-2" > 
             <label class="control-label">Precio: </label>
             <input type="number" class="form-control numb" id="price_id_modal_2" name="price_id_modal_2"/>
        </div>
        <div class="col-lg-2" > 
             <label class="control-label">Unidad: </label>
             <input class="form-control" id="unit_id_modal_2" name="unit_id_modal_2" />
        </div>

        <div class="form-group col-lg-5" > 
              <label class="control-label" >Descripcion:</label>
              <input class="form-control col-lg-10" id="desc_id_modal_2" name="desc_id_modal_2"/>
        </div> 
        

     <div class="col-lg-12" ></div>    
      </div>
	  
	  <div class="modal-footer">
		<div class="col-lg-4" ></div>  
			<div class="col-lg-4" >
			<button type="button" onclick="add_item();" class="btn btn-primary" data-dismiss="modal">Agregar</button>
			</div>
			<div class="col-lg-4" >
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			</div>    
		</div> 
		</form>
	</div>
 
    </div>
	
 </div>
</div>