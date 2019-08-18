<?php
require_once APP.'view/modules/'.basename(__DIR__).'/lang/'.$this->model->lang.'_ref.php';
 

$detail = $this->model->get_Purchaseitem($this->ProductID);

foreach ($detail as $value) {

  $value = json_decode($value);

 $Prod_ID = $value->{'ProductID'};
 $desc = $value->{'Description'};
 $QTY =  $this->getItemQtyOnHand($value->{'ProductID'});
 $MEASURE = $value->{'UnitMeasure'};
 $PRICE =  $value->{'Price1'};
 $COMP =  $value->{'id_compania'};
 $UPCSKU=  $value->{'UPC_SKU'};
 $LastUnitCost=  $value->{'LastUnitCost'};
 $GL_SALES_ACCT=  $value->{'GL_Sales_Acct'};

}

?>


<!--ADD JS FILE-->
<script  src="<?php echo URL; ?>js/operaciones/inventory/invInfo.js" ></script>


<div class="limiter">
		<div class="container-page100">
			<div class="wrap-page100">
			<form method="POST"  action="" class="login100-form validate-form p-l-25 p-r-25 p-t-60" >

			<span class="page100-form-title">
						<?PHP echo $Prod_ID; ?>
			</span>
			<!--INI DIV ERRO-->
			<div id="ERROR" class="alert"></div>
			<!--INI DIV ERROR-->
			
			<!--ini contenido-->
			
				<!--ini  header-->
				<div class="col-lg-8">
				<fieldset> 
					<div  class="col-lg-8">
					<fieldset class="fieldsetform">
						<table class='table_form'>
							<tbody>
							<tr><th><strong><?PHP echo $invInfo1; ?></strong></th><td><input  class="inputPage col-lg-12"  value="<?php echo  $Prod_ID;  ?>" readonly/></td>		</tr>
							<tr><th><strong><?PHP echo $invInfo2; ?></strong></th><td><input  class="inputPage col-lg-12"  value="<?php echo  $desc;     ?>" readonly/></td>		</tr></tbody>
						</table>
						</fieldset>
					</div>
			   <div class="separador col-lg-12"></div>
				<div  class="col-lg-6">
					<fieldset class="fieldsetform">
						<table class='table_form'>
							<tbody>
							<tr><th><strong><?PHP echo $invInfo4; ?></strong></th><td><input  class="inputPage col-lg-12  numb"  value="<?php echo  $PRICE; ?>" readonly/></td>		</tr>
							<tr><th><strong><?PHP echo $invInfo5; ?></strong></th><td><input  class="inputPage col-lg-12  numb"  value="<?php echo  $MEASURE; ?>" readonly/></td>		</tr>
							<tr><th><strong><?PHP echo $invInfo6; ?></strong></th><td><input  class="inputPage col-lg-12  numb"  value="<?php echo  number_format($QTY,0, '.', ','); ?>" readonly/></td>		</tr>	
							</tbody>
						</table>
						</fieldset>
					</div>

				<div  class="col-lg-6">
					<fieldset class="fieldsetform">
						<table class='table_form'>
							<tbody>
							<tr><th><strong><?PHP echo $invInfo7; ?></strong></th><td><input  class="inputPage col-lg-12  numb"  value="<?php echo  $LastUnitCost; ?>" readonly/></td></tr>
							<tr><th><strong><?PHP echo $invInfo8; ?></strong></th><td><input  class="inputPage col-lg-12  numb"  value="<?php echo  $GL_SALES_ACCT; ?>" readonly/></td>		</tr>
							<tr><th><strong><?PHP echo $invInfo9; ?></strong></th><td><input  class="inputPage col-lg-12  numb"  value="<?php echo  $UPCSKU; ?>" readonly/></td>		</tr>	
							</tbody>
						</table>
						</fieldset>
					</div>
				<div class="separador col-lg-12"></div>
				</fieldset>
				</div>
				
				<!--fin  header-->
 
				<div class="separador col-lg-12"></div>
				
				<!-- GENERAR LOTE  -->
				<div  class="col-lg-3" >
				<input type="button" name="" data-toggle='modal' data-target='#myModal' class="accept-form-btn" value="Agregar No. de Lote" />
				</div>

				<div class="separador col-lg-12"></div>

				<div id="list" class="col-lg-10"> 
				
				<legend>Clasificacion por No. de Lote</legend>
				<fieldset class="fieldsetform" >
					
					<table id="lotes" class="display table table-striped table-condensed table-bordered  dataTable no-footer" cellspacing="0"  >
							<thead>
							<tr>
								<th>Lote</th>
								<th>Fecha Fabr.</th>
								<th>Fecha Venc.</th>
								<th>Cant. Stock</th>
								<th></th>
							</tr>
							</thead>
							<tbody>
							<?php $this->getItemLoteSt(); ?>
							</tbody>
							</table>
					</fieldset>

				</div>
				<!--GENERAR LOTE -->
				<div class="separador col-lg-12"></div>
				<!--UBICACIONES DE ITEM -->
				
				<div id="update_loc" class="col-lg-10">

				<legend>Distribucion en almacenes</legend>
				<fieldset class="fieldsetform" >
				
				<table id="ubicaciones" class="display table table-striped table-condensed table-bordered  dataTable no-footer"  >
							<thead>
							<tr>
								<th>Lote</th>
								<th>Fecha Fabr.</th>
								<th>Fecha Venc.</th>
								<th>Cant. Stock</th>
								<th>Reservados</th>
								<th>Almacen</th>
								<th>Ubicacion</th>
								<th></th>
								
							</tr>
							</thead>
							<tbody>
							<?php $this->getLocationByItem(); ?>  
							</tbody>
				</table> 
				</fieldset >
				</div>
				<!--UBICACIONES DE ITEM-->

			<!--fin contenido-->
			</form>	
			<div class="separador col-lg-12"> </div>
			</div>
		</div>
	</div>


<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog  modal-lg">

    <!-- Modal content-->

 <!-- Modal content-->
 <div class="modal-content">
		<div class="page100-form-title">
			<span >Informacion de Lote</span>
		</div>
		<form method="POST" id="addLote" action="" class="login100-form validate-form p-l-25 p-r-25 p-t-60" enctype="multipart/form-data">
		<div class="col-lg-8 modal-body">

		<?php $maxLote = $this->model->Query_value('STOCK_ITEMS_LOCATION','sum(qty)', 'where lote="'.$this->ProductID.'0000" and location="1" and stock="1" and ID_compania="'.$this->model->id_compania.'";'); ?>

		<div id='prod'></div>

		<fieldset class="fieldsetform">
            <table class="table_form" >
                <tbody>
					<tr><th>No Lote</th><td><input class="inputPage col-lg-12"  type='text' id="no_lote" name="no_lote" /></td></tr>
					<tr><th>Fecha Fabricación</th><td><input type="date" class="inputPage col-lg-12"   id="fecha_fab" name="fecha_fab" /></tr>				
					<tr><th>Fecha Venc</th><td><input type="date" class="inputPage col-lg-12"   id="fecha_lote" name="fecha_lote" /></tr>
					<tr><th>cant.</th><td><input type="number" min='1' max="<?php echo $maxLote; ?>" value='<?php echo $maxLote; ?>' class="form-control col-lg-10" id="qty_lote" name="qty_lote"   /></tr>
				</tbody>
            </table>
        </fieldset>   
  
		</div>
		<div class="modal-footer">
		    <div class="col-lg-8" ></div>  
			<div class="col-lg-2" >
			<button type="button" onclick="addLote('<?php echo $this->ProductID; ?>','<?php echo $maxLote; ?>');" class="accept-form-btn" data-dismiss="modal">Agregar</button>
			</div>
			<div class="col-lg-2" >
			<button type="button" class="close-form-btn" data-dismiss="modal">Cerrar</button>
			</div>    
		</div> 
      </form>

  </div>
</div>

