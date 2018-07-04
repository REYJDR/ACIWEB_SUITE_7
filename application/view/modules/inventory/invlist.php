<?php
echo $this->model->lang;
require_once APP.'view/modules/'.basename(__DIR__).'/lang/'.$this->model->lang.'_ref.php';
?>


<!--ADD JS FILE-->
<script  src="<?php echo URL; ?>js/operaciones/inventory/invList.js" ></script>


<div class="limiter">
		<div class="container-page100">
			<div class="wrap-page100">
			<form method="POST"  action="" class="login100-form validate-form p-l-25 p-r-25 p-t-60" >

			<span class="page100-form-title">
						<?PHP echo $Title1; ?>
			</span>
			<!--INI DIV ERRO-->
			<div id="ERROR" class="alert"></div>
			<!--INI DIV ERROR-->
			
			<!--ini contenido-->
			<div class="col-lg-12"> 
			<fieldset class="table_req fieldsetform" >
			<table  id="productos" class="display table table-striped table-condensed table-bordered " cellspacing="0">
			<thead>
				<tr >
				<th width="15%" class="text-center"><?php echo $Tblcol1;?></th>
				<th width="15%" class="text-center"><?php echo $Tblcol2;?></th>
				<th width="5%"  class="text-center"><?php echo $Tblcol3?></th>
				<th width="5%"  class="text-center"><?php echo $Tblcol4;?></th>
				<th width="5%" class="text-center"><?php echo $Tblcol8;?></th>
				</tr>
			</thead>
				<tbody>
				<?php
					$Item = $this->model->get_ProductsList();

					foreach ($Item as $datos) {


					$Item = json_decode($datos);


					echo	'<tr>
							<td><a href="'.URL.'index.php?url=ges_inventario/inv_info/'.$Item->{'ProductID'}.'" >'.$Item->{'ProductID'}.'</a></td>
							<td>'.$Item->{'Description'}.'</td>
							<td>'.$Item->{'UnitMeasure'}.'</td>
							<td class="numb">'.number_format($Item->{'QtyOnHand'},0, '.', ',').'</td>
							<td class="numb">'.number_format($Item->{'LastUnitCost'},4, '.', ',').'</td>';
							}

				?>
				</tbody>
			</table>
			</fieldset>
		</div>

			<!--fin contenido-->
			</form>	
			<div class="separador col-lg-12"> </div>
			</div>
		</div>
	</div>