<?php
$home = basename(__DIR__);
require_once APP.'view/'.basename(__DIR__).'/lang/'.$this->model->lang.'_ref.php';

//RECUPERO INFO DE DETALLES DE MODULOS ACTIVOS
$SQL = 'SELECT * FROM MOD_MENU_CONF';

$MOD_MENU = $this->model->Query($SQL);

foreach ($MOD_MENU as $value) {

$value = json_decode($value);

ECHO $value->{'closeSO'};

if($value->{'mod_sales'}=='1'){ $mod_sales_CK = 'checked';  }else{ $mod_sales_CK = '';   }
if($value->{'mod_invo'}=='1') { $mod_invo_CK  = 'checked';  }else{ $mod_invo_CK  = '';   }
if($value->{'mod_fact'}=='1') { $mod_fact_CK  = 'checked';  }else{ $mod_fact_CK  = '';   }
if($value->{'mod_invt'}=='1') { $mod_invt_CK  = 'checked';  }else{ $mod_invt_CK  = '';   }
if($value->{'mod_rept'}=='1') { $mod_rept_CK  = 'checked';  }else{ $mod_rept_CK  = '';   }
if($value->{'mod_stock'}=='1'){ $mod_stoc_CK  = 'checked';  }else{ $mod_stoc_CK  = '';   }
if($value->{'mod_pro'}=='1' )  { $mod_pro_CK   = 'checked';  }else{ $mod_pro_CK  = '';   }
if($value->{'mod_req'}=='1' )  { $mod_req_CK   = 'checked';  }else{ $mod_req_CK  = '';   }
if($value->{'mod_cust'}=='1' )  { $mod_cust_CK   = 'checked';  }else{ $mod_cust_CK  = '';   }


}

$res = $this->model->Query('SELECT * FROM SAX_USER  where SAX_USER.onoff="1" and SAX_USER.id="'.$this->model->active_user_id.'";');

foreach ($res as $value) {
	$value = json_decode($value);
	
	  $INF_OC= $value->{'notif_oc'};
	  $INF_FC= $value->{'notif_fc'};
	  $INF_PRICE= $value->{'mod_price'};
	  $INF_INV= $value->{'inv_view'};
	  $INF_STO= $value->{'stoc_view'};
	  $INF_REP= $value->{'rep_view'};
	  $PHOTO  = $value->{'photo'};
	  $close_sales_ck = $value->{'closeSO'};
	
	  if($PHOTO == 'x'){
	   $user_avatar = URL.'img/user_avatar/'.$this->model->active_user_id.'.jpg';
	  }else{
	   $user_avatar = URL.'img/default-avatar.png';
	  }
	
	
	  if($INF_OC==1){//notificaciones requisiciones
	  $notif_oc = 'checked';
	  }else{
	  $notif_oc = ''; 
	  }
	
	  if($INF_FC==1){//notificaciones acturas
	  $notif_fc = 'checked';
	  }else{
	  $notif_fc = ''; 
	  }
	
	  if($INF_PRICE==1){//modificar precio
	  $price_mod = 'checked';
	  }else{
	  $price_mod = '';  
	  }
	  if($INF_INV==1){
	  $INV_CK = 'checked';
	  }else{
	  $INV_CK = ''; 
	  }
	  if($INF_STO==1){
	  $STO_CK = 'checked';
	  }else{
	  $STO_CK = ''; 
	  }
	  if($INF_REP==1){
	   $REP_CK = 'checked';
	  }else{
	   $REP_CK = ''; 
	  }

}


$res= $this->model->Get_company_Info();

	foreach ($res as $Comp_Info) {

		$Comp_Info = json_decode($Comp_Info);
		$Sage_Conn = $Comp_Info->{'Sage_Conn'};
	}	 
	
if ($Sage_Conn == 0) {

$metodo = "SageConnect";

$conn = $this->model->sage_connected;

	if($conn==1){

	  $status ="<i class='fas fa-check-circle' style='color:green;' ></i> ".$this->model->Query_value('CompanySession','CompanyNameSage50','where ID_compania="'.$this->model->id_compania.'"');

	}else{

	  $status = "<i class='fas fa-ban'  style='color:red;'></i> ".$this->model->Query_value('CompanySession','CompanyNameSage50','where ID_compania="'.$this->model->id_compania.'"');

	}
}

if ($Sage_Conn == 1) {
	
	 $metodo = "p3Top3";

     $status = "<i class='fas fa-check-circle'  ></i>  ".$this->model->Query_value('CompanyLogSync','CompanyNameSage50','where ID_compania="'.$this->model->id_compania.'"');
		
}

if ($Sage_Conn == 9) {
	
	 $metodo = "Standalone";

     $status = "<i class='fas fa-check-circle'  ></i>Standalone";
		
}


?>

<!--ADD JS FILE-->
<script  src="<?php echo URL; ?>js/operaciones/home/dashboard.js" ></script>

<script type="text/javascript" > window.ZohoHCAsap=window.ZohoHCAsap||function(a,b){ZohoHCAsap[a]=b;};(function(){var d=document; var s=d.createElement("script");s.type="text/javascript";s.defer=true; s.src="https://desk.zoho.com/portal/api/web/inapp/457361000000145033?orgId=701297469"; d.getElementsByTagName("head")[0].appendChild(s); })(); </script>
<div class="limiter">
		<div class="container-dashboard100">
			<div class="wrap-dashboard100">
			<!--ini contenido-->
			<div class="col-lg-8"> 
				<img height='150px' src='page_assets/images/ACIWEB-LOGO.jpg' />
			</div>	

			<div class="col-lg-4"> 	
			<fieldset class="fieldsetform">
			<div class='col-lg-12'>
				<div class='col-lg-4'><span class="welcome"><?php echo $welcome;  ?></span></div>
				<div class='col-lg-4'><a tabindex="0" title="Ir al perfil de usuario" class="welcome"  href="<?PHP ECHO URL; ?>index.php?url=home/edit_account/<?php echo $this->model->active_user_id; ?>" ><?php echo $this->model->active_user_name; ?></a></div>
			</div>

			<fieldset class="fieldsetform">
				<table class='table_form' >
					<tbody>
						<tr><th><strong><?php echo $metodoCon; ?></strong></th><td><?php echo $metodo;  ?></td></tr>
						<tr><th><strong><?php echo $compania;?></strong></th><td><?php echo  $status; ?></td></tr>
						<tr><th><strong><?php echo $AciwebComp;?></strong></th><td><?php echo DB_NAME; ?></td></tr>
						<tr><th><strong><?php echo $timezone;?></strong></th><td><?php echo date_default_timezone_get() ;  ?></td></tr>
						<tr><th><strong><?php echo $version;?></strong></th><td><?php echo VER;  ?></td></tr>					
					</tbody>
				</table>
			</fieldset>
			</fieldset>
			</div>
			<!--ini aqui va el menu de acceso rapido-->
			<div class='col-lg-8'>
			<?PHP require APP.'view/home/Tabmenu.php'; ?>
			</div>	
		    <!--end aqui va el menu de acceso rapido-->

			<!--Graficas-->
			<div class="col-lg-4 " style="display:none;" > 
			<fieldset class="fieldsetform">
				<div class="graphcont  col-lg-12">
				<fieldset>
					<legend>Facturación Mensual<p class="help-block">(Por Periodo, año corriente)</p></legend>
					<div id="graph"></div>
				</fieldset>
				</div>

				<div class="separador col-lg-12" ></div>
				
				<div class="graphcont  col-lg-12">
				<fieldset>
					<legend>Porcentage de ventas por cliente <p class="help-block">(Periodo actual - primeros 10)</p></legend>
					
					<canvas id="cvs"  width="800px" height="360px">[No canvas support]</canvas>
					
				<!--   <div id="graph3"></div> -->            
						<?PHP
						$this->model->verify_session();
						$idCompania = $this->model->id_compania;
						
						$currentMoth = date('n');
						$currentYear = date('Y');
						$currentdate = date('m-d-Y');

						$query1 = 'SELECT  date, SUM(Net_due) as Total, month(date) as  mes, year(date) as  year
									FROM `Sales_Header_Imp`
									INNER JOIN `Sales_Detail_Imp` ON Sales_Header_Imp.InvoiceNumber = Sales_Detail_Imp.InvoiceNumber and Sales_Header_Imp.ID_compania = Sales_Detail_Imp.ID_compania
									WHERE Sales_Header_Imp.Enviado = "1" and Sales_Header_Imp.Error = "0"  and month(date)="'.$currentMoth.'" and Sales_Header_Imp.ID_compania="'.$idCompania .'"';


						$totalSales = $this->model->Query($query1);
						$totalSales = json_decode($totalSales[0]);

						$query = 'SELECT SUM(Net_due) as Total, month(date) as  mes , CustomerName FROM `Sales_Header_Imp`
							inner JOIN `Sales_Detail_Imp` ON Sales_Header_Imp.InvoiceNumber = Sales_Detail_Imp.InvoiceNumber
							and Sales_Header_Imp.ID_compania = Sales_Detail_Imp.ID_compania
							where month(date)="'.$currentMoth.'" and Sales_Header_Imp.ID_compania="'.$idCompania .'" 
							GROUP BY mes, CustomerName order by Total DESC limit 10';

							$totalSold = $this->model->Query($query);

							foreach ($totalSold  as $value) {

								$totalSold = json_decode($value);

								$total = $totalSold->{'Total'};

								$perc = ($total*100)/$totalSales->{'Total'};

								$perc = number_format($perc,2);

								$data .= $perc.',';
								$labels .= "'".$totalSold->{'CustomerName'}."',";

							}
							
						if($data!=''){  
						?>
						

						<script>
							new RGraph.HBar({
								id: "cvs",
								data: [<?php echo trim($data); ?>],
								options: {
									gutterLeftAutosize: true,
									vmargin: 5,
									backgroundGridHlines: false,
									backgroundGridBorder: false,
									labelsAboveDecimals: 2,
									labelsAbove: true,
									noaxes: true,
									colors: ['#FDB515','#164366'],
									unitsPost: '%',
									xmax: 100,
									textAccessible: true,
									labels:[<?php echo $labels; ?>],
									textSize: 10
								}
							}).wave();
						</script>
						
						<?php } ?>
				</fieldset>
				</div>



				<div class="separador col-lg-12" ></div>


				<div class="graphcont  col-lg-12">
				<fieldset>
					<legend>Ordenes de ventas Abiertas vs facturadas <p class="help-block">(Por Periodo, año corriente)</p></legend>
					
					<div id="container" style="display: inline-block; position: relative">
						<canvas id="cvs2" width="550" height="350"> [No canvas support] </canvas>        
					</div>     
				    <?PHP
						$query = 'SELECT COUNT(*) AS CUENTA, date, month(date)  FROM `SalesOrder_Header_Imp` where month(date)="'.$currentMoth.'" and ID_compania="'.$idCompania .'"';
						$totalSO = $this->model->Query($query);
						$totalSO = json_decode($totalSO[0]);

						$total100 = $totalSO->{'CUENTA'};

						$query = 'SELECT COUNT(*) AS CUENTA, date, month(date)  FROM `Sales_Header_Imp` where month(date)="'.$currentMoth.'" and ID_compania="'.$idCompania .'"';
						$totalInv = $this->model->Query($query);
						$totalInv =json_decode($totalInv[0]);

						$totaInv = $totalInv->{'CUENTA'};

						$totalSO =  $total100 -  $totaInv;

						$totaInv = ($totaInv*100)/$total100;

						$totalSO = ($totalSO*100)/$total100;
				?>
				<script>

						var colors = ['yellow','green'];
						var data   =  [<?PHP echo number_format($totalSO,2); ?>,<?PHP echo number_format($totaInv,2); ?>];
						var labels = ['Abiertas','Facturadas'];
						
						for (var i=0; i<data.length; i++) {
							labels[i] = '{1}: {2}%'.format(labels[i], data[i]);
						}

						var key = RGraph.HTML.Key('container',
						{
							colors: colors,
							labels: labels,
							tableCss: {
								position: 'absolute',
								top: '50%',
								right: '-40px',
								transform: 'translateY(-50%)'
							}
						});



						new RGraph.Pie({
							id: 'cvs2',
							data: data,
							options: {
								strokestyle: '#e8e8e8',
								variant: 'pie3d',
								linewidth: 2,
								shadowOffsetx: 0,
								shadowOffsety: 7,
								shadowColor: '#ddd',
								shadowBlur: 15,
								radius: 80,
								exploded: [,20],
								colors: colors,

							}
						}).draw();

				</script>

				</fieldset>
				
			    </fieldset>
				</div>

			</div>
			<!--end Graficas-->

				<?php

				$query = 'SELECT  date, SUM(Net_due) as Total, month(date) as  mes, year(date) as  year
						FROM `Sales_Header_Imp`
						INNER JOIN `Sales_Detail_Imp` ON Sales_Header_Imp.InvoiceNumber = Sales_Detail_Imp.InvoiceNumber
						and Sales_Header_Imp.ID_compania = Sales_Detail_Imp.ID_compania
						WHERE Sales_Header_Imp.Enviado = "1" and Sales_Header_Imp.Error = "0" 
						and Sales_Header_Imp.ID_compania="'.$idCompania .'"  GROUP BY mes';


				$GetOrder=$this->model->Query($query);


				if (!$GetOrder) {

					$table =  "{x: '".$currentdate."', z: '0' , y: '0' },";

				} 

				$y= '';
				$z= '';
				$meses = array();

				foreach ($GetOrder as $value) { 
					
				$value =json_decode($value);

					if($value->{'year'}==$currentYear) {
					
					$table .=  "{ y: '".$value->{'year'}.'-'.$value->{'mes'}."' , a: '".$value->{'Total'}."'},";
					$lastMonth = $value->{'mes'};

					$meses[$lastMonth] = 'x';

					} 

				
				}

				for ($a=1; $a <= $lastMonth ; $a++) { 
					
					if(!$meses[$a]){

					$table .=  "{ y: '".$currentYear.'-'.$a."' , a: '0'},";

					}
				
				$y = $y + 1;
				}

				if($y >= '1'){

					echo "<pre  id='code' class='prettyprint linenums'>
							// Use Morris.Bar
							Morris.Line({
								element: 'graph',
								data: [ ".$table."],
								xkey: 'y',
								ykeys: ['a'],
								labels: ['Total Facturado']
							});
						</pre>";

				} 

			?>

			<!--fin contenido-->
			</div>
		</div>
	</div>