<?php
require_once APP.'view/modules/'.basename(__DIR__).'/lang/'.$this->model->lang.'_ref.php';
?>


<!--ADD JS FILE-->
<script  src="<?php echo URL; ?>js/operaciones/inventory/invList.js" ></script>


<div class="limiter">
		<div class="container-page100">
			<div class="wrap-page100">
		
			<div class="separador col-lg-12"> </div>

			<!--	<form method="POST" action="" class="login100-form validate-form p-l-25 p-r-25 p-t-60" > -->
			<div class="login100-form validate-form p-l-25 p-r-25 p-t-60" > 
				<!--INI DIV ERRO-->
				<div id="ERROR" class="alert"></div>
				<div class="separador col-lg-12"> </div>
			<!--INI DIV ERROR-->
			<div class="col-lg-2">
			<button  class="btn-bar" name="searchItem" id="searchItem"  onclick="getListItemByStock()"><?php echo $InvListButtom; ?></button>
			</div>
			<span class="page100-form-title">
						<?PHP echo $Title1; ?>
			</span>
			
			
			<!--ini contenido-->
			<div class="col-lg-12"> 
			<fieldset class="table_req fieldsetform" >
			<div class="separador col-lg-12"> </div>
			<table  id="itemXStock" class="display table table-striped table-condensed table-bordered " cellspacing="0">
			<thead>
				<tr >
				<th width="15%" class="text-center"><?php echo $STblcol1;?></th>
				<th width="15%" class="text-center"><?php echo $STblcol2;?></th>
				<th width="5%"  class="text-center"><?php echo $STblcol3?></th>
				<th width="5%"  class="text-center"><?php echo $STblcol4;?></th>
				<th width="5%" class="text-center"><?php echo $STblcol5;?></th>
                <th width="5%" class="text-center"><?php echo $STblcol6;?></th>
                <th width="5%" class="text-center"><?php echo $STblcol7;?></th>
                <th width="5%" class="text-center"><?php echo $STblcol8;?></th>
                <th width="5%" class="text-center"><?php echo $STblcol9;?></th>
                
				</tr>
			</thead>
				<tbody id='listItem'>
				
				</tbody>
			</table>
			</fieldset>
		</div>

			<!--fin contenido-->
			<!--	</form>	-->
			<div>
			<div class="separador col-lg-12"> </div>
			</div>
		</div>
	</div>