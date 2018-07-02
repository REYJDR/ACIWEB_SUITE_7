<?php
require_once APP.'view/modules/'.basename(__DIR__).'/lang/'.$this->model->lang.'_ref.php';
?>
<!--ADD JS FILE-->
<script  src="<?php echo URL; ?>js/operaciones/invoice/BillingSales.js" ></script>


<div class="limiter">
		<div class="container-page100">
			<div class="wrap-page100">
			<form method="POST"  action="" class="login100-form validate-form p-l-55 p-r-55 p-t-60" >

			<span class="page100-form-title">
						<?PHP echo $TitleInv; ?>
			</span>
			<!--INI DIV ERRO-->
			<div id="ERROR" class="alert"></div>
			<!--INI DIV ERROR-->
			
			<!--ini contenido-->
		    <fieldset> 
				<table id='invoice' class="table table-bordered">
					<thead>
						<th>Referencia</th>
						<th>Cliente ID</th>
						<th>Nombre Cliente</th>
						<th>Fecha</th>
						<th>Lugar de despacho</th>
						<th>Enviado a despacho</th>
					</thead>
					<tbody>
					<?php 
					$table = '';

					$invoices = $this->GetOrdrToInvoice(); 

						foreach ($invoices as $key => $value) {
						
						$value = json_decode($value);

						$SalesID = '"'.$value->{'SalesOrderNumber'}.'"';
						$URL     = '"'.URL.'"';

						if($value->{'DispachPrinted'}==1){

							$despachado = 'Si';
							$style = 'style="background-color:#BCF5A9;"';
						
						}else{


							$despachado = 'No';
							$style = 'style="background-color:#D8D8D8;"';
						}



						$table .= "<tr>
										<td><a href='#' onclick='javascript: SaleToInvoice(".$URL.",".$SalesID."); ' >".$value->{'SalesOrderNumber'}."</a>   </td>
										<td>".$value->{'CustomerID'}.'</td>
										<td>'.$value->{'CustomerName'}.'</td>
										<td>'.$value->{'date'}.'</td>
										<td>'.$value->{'lugar_despacho'}.'</td>
										<td  '.$style.' >'.$despachado.'</td>
									</tr>';


						}

					echo $table;
					?>
					</tbody>
				</table>
			</fieldset> 
			<div class="separador col-lg-12"></div>
			<fieldset>
				<div id="info"></div>
			</fieldset>

			<!--fin contenido-->
			</form>	
			<div class="separador col-lg-12"> </div>
			</div>
		</div>
	</div>