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
		
			<div class="separador col-lg-12"></div> <!--SEPERADOR-->

				<!--INPUT NUEVO PRICE ID-->
				<div  class="col-lg-8" id="nvo_lp">
				<fieldset class="fieldsetform">
				<table class='table_form'>
					<tbody>
						<tr>
							<th><strong><?PHP echo $InputCust_1; ?></strong></th>
							<td><input type="text"  class="inputPage" id="cus_name" name="cus_name" /></td>		
							<th><strong><?PHP echo $InputCust_2; ?></strong></th>
							<td><input type="text"  class="inputPage" id="cus_desc" name="cus_desc" /></td>				
						</tr>
						<tr>
							<th><strong><?PHP echo $InputCust_3; ?></strong></th>
							<td><input type="text"  class="inputPage" id="cus_cel" name="cus_cel" /></td>		
							<th><strong><?PHP echo $InputCust_4; ?></strong></th>
							<td><input type="text"  class="inputPage" id="cus_contact" name="cus_contact" /></td>				
						</tr>
						<tr>
							<th><strong><?PHP echo $InputCust_5; ?></strong></th>
							<td><input type="text"  class="inputPage" id="cus_country" name="cus_country" /></td>		
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
							<td><input type="text"  class="inputPage" id="cus_email" name="cus_email" /></td>		
							<th><strong><?PHP echo $InputCust_10; ?></strong></th>
							<td><input type="text"  class="inputPage" id="cus_pl" name="cus_pl" /></td>				
						</tr>
						<tr>
							<th><strong><?PHP echo $InputCust_11; ?></strong></th>
							<td><input type="text"  class="inputPage" id="cus_bal" name="cus_bal" /></td>		
							<th><strong><?PHP echo $InputCust_12; ?></strong></th>
							<td><input type="text"  class="inputPage" id="cus_creditlimit" name="cus_creditlimit" /></td>				
						</tr>
						<tr>
							<th><strong><?PHP echo $InputCust_12; ?></strong></th>
							<td><input type="text"  class="inputPage" id="cus_salesId" name="cus_salesId" /></td>		
							<th><strong><?PHP echo $InputCust_13; ?></strong></th>
							<td><input type="text"  class="inputPage" id="cus_SalesName" name="cus_SalesName" /></td>				
						</tr>
						<tr>
							<th><strong><?PHP echo $InputCust_14; ?></strong></th>
							<td><input type="text"  class="inputPage" id="cus_addres1" name="cus_addres1" /></td>		
							<th><strong><?PHP echo $InputCust_15; ?></strong></th>
							<td><input type="text"  class="inputPage" id="cus_addres2" name="cus_addres2" /></td>				
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
					<input type="submit"  value="Cargar"  class="accept-form-btn" name="submit"  value="<?PHP echo $BTN_add; ?>" />			
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
				<table id="table_PriceList" class="table table-striped responsive table-bordered" cellspacing="0" >
				<thead>
				<tr>
					<th width="20%">Id. Lista de Precios</th>
					<th width="10%">Fecha</th>
					<th width="30%">Descripcion</th> 
					<th width="5%"></th>
				</tr>
				</thead>
			<tbody>

			<?php
				$clause.= 'WHERE PRI_LIST_ID.ID_compania="'.$this->model->id_compania.'" '; 


				$PL = $this->model->get_Price_list('asc','10000',$clause);

				foreach ($PL as $value) {

				$value = json_decode($value);

				$date1 = strtotime($value->{'LAST_CHANGE'});
				//$date1 = $date;
				$date = date('m/d/Y',$date1);
				//$date1 = date('mdY',$date1);

				$PL_ID = trim ($value->{'IDPRICE'});
				$PL_ID = "'".$PL_ID."'";
				$PL_Desc = "'".$value->{'DESCRIPTION'}."'";
				$date1 = "'".$date1."'";

				$table .= ' <tr>
					<td><a href="javascript:void(0)" onclick="get_PL('.$PL_ID.')"><strong>'.$value->{'IDPRICE'}.'</strong></a></td>
					<td class="numb">'.$date.'</td>
					<td>'.$value->{'DESCRIPTION'}.'</td>
					<td><a  href="javascript:void(0)" onclick="del_PL('.$PL_ID.')"><input type="button" id="modal_button" name="modal_button"  class="btn btn-danger btn-sm btn-icon icon-left" value="Eliminar" /></td>
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
<div id="myModal" class="modal fade" role="dialog">
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