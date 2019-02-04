<?php
require_once APP.'view/modules/'.basename(__DIR__).'/lang/'.$this->model->lang.'_ref.php';
?>


<!--ADD JS FILE-->
<script  src="<?php echo URL; ?>js/operaciones/inventory/location.js" ></script>

<div class="limiter">
		<div class="container-page100">
			<div class="wrap-page100 ">
             <div class="p-l-25 p-r-25 p-t-60">
				<span class="page100-form-title">
							<?PHP echo $TitleLoc; ?>
				</span>
				<!--INI DIV ERRO-->
				<div id="ERROR" class="alert"></div>
				<!--INI DIV ERROR-->
				
				<!--ini contenido-->
				<input   type='hidden' name='idStock'  id='idStock'  value="" />
				
				<!--STOCK LIST-->
				<fieldset >
				<div  class="col-lg-3" id="stocks">
			
				<table class='table' >
				            <thead><tr><th>stock</th></tr></thead>
							<tbody id='stockList'>
								

							</tbody>
				</table>	
				
				</div>	

				
				<div  class="col-lg-9">
			
                    <!--STOCK INFO-->
					<div  class="col-lg-6" id="info" ></div>
					
					<div  class="separador col-lg-12" ></div>
			
			        <!--LOCATION-->
					<div  class="col-lg-4"id="loc" >
					<fieldset class="fieldsetform">
						<table class='table' >
									<thead><tr><th>location</th></tr></thead>
									<tbody id="location">
									</tbody>
						</table>	
					</fieldset >
					</div>			

					<div class="separador col-lg-12"> </div>
				</div>
					<!--ITEMS-->
					<div  class="col-lg-12" >
					
					<fieldset class="fieldsetform">
					<table id="listItemByStock" class="table table-bordered"  >
						<thead>
						<tr>
							<th>ItemId</th>
							<th>Lote</th>
							<th>Cantidad</th>
							<th>Almacen</th>
							<th>Ubicación</th>
						</tr>
						</thead>
						<tbody></tbody>
					</table>	
					</fieldset>
							
					
					</div>
					
				
		
				
			</div>

			</fieldset>
			<!--fin contenido-->
		
			<div class="separador col-lg-12"> </div>
			</div>
		</div>
	</div>

<!-- Modal : VENTANA EMERGENTE QUE PERMITE AGREGAR NUEVO STOCK-->
<div id="AddStock" class="modal fade" role="dialog">
<div class="modal-dialog modal-lg">

  <!-- Modal content-->
  <div class="modal-content">
		<div class="page100-form-title">
			<span >Agregar Almacen</span>
		</div>
		<form method="POST" id="addStock" action="" class="login100-form validate-form p-l-25 p-r-25 p-t-60" enctype="multipart/form-data">
		<div class="col-lg-8 modal-body">


		<fieldset class="fieldsetform">
            <table class="table_form" >
                <tbody>
					<tr><th>Name</th><td><input class="inputPage col-lg-12"  type='text' name='name' /></td></tr>
					<tr><th>Description</th><td><textarea class="textareaPage col-lg-12" onkeyup="checkArroba(this.id);"  rows="2" id="desc" name="desc"></textarea></tr>
					<tr><th>Address</th><td><textarea class="textareaPage col-lg-12" onkeyup="checkArroba(this.id);"  rows="2" id="address" name="address"></textarea></tr>
					<tr><th>Capacity</th><td><input class="inputPage numb"   type='number' name='capa' />m2</td></tr>
               </tbody>
            </table>
        </fieldset>   
  
		</div>
		
		<div class="modal-footer">
		    <div class="col-lg-8" ></div>  
			<div class="col-lg-2" >
			<button type="button" onclick="addStock();" class="accept-form-btn" data-dismiss="modal">Agregar</button>
			</div>
			<div class="col-lg-2" >
			<button type="button" class="close-form-btn" data-dismiss="modal">Cerrar</button>
			</div>    
		</div> 

	   </form>
	</div>

  </div>
  
</div>
</div>
<!--modal-->


<!-- Modal : VENTANA EMERGENTE QUE PERMITE AGREGAR NUEVO LOCATION-->
<div id="AddLoc" class="modal fade" role="dialog">
<div class="modal-dialog modal-lg">

  <!-- Modal content-->
  <div class="modal-content">
		<div class="page100-form-title">
			<span >Agregar Ubicacion</span>
		</div>
		<form method="POST" id="Addlocation" action="" class="login100-form validate-form p-l-25 p-r-25 p-t-60" enctype="multipart/form-data">
		<div class="col-lg-8 modal-body">

		<fieldset class="fieldsetform">
            <table class="table_form" >
                <tbody>
					<tr><th>Name</th><td><input class="inputPage col-lg-12"  type='text' name='name' /></td></tr>
					<tr><th>Description</th><td><textarea class="textareaPage col-lg-12" onkeyup="checkArroba(this.id);"  rows="2" id="desc" name="desc"></textarea></tr>
               </tbody>
            </table>
        </fieldset>   
  
		</div>
		
		<div class="modal-footer">
		    <div class="col-lg-8" ></div>  
			<div class="col-lg-2" >
			<button type="button" onclick="addLoc();" class="accept-form-btn" data-dismiss="modal">Agregar</button>
			</div>
			<div class="col-lg-2" >
			<button type="button" class="close-form-btn" data-dismiss="modal">Cerrar</button>
			</div>    
		</div> 

		</form>
	</div>

  </div>
  
</div>
</div>
<!--modal-->