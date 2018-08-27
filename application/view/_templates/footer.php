
<div id="footer" class="footer  col-xs-12">

<div    class="crop col-xs-6">
<?php   

$res= $this->model->Get_company_Info();

	foreach ($res as $Comp_Info) {

		$Comp_Info = json_decode($Comp_Info);
		$Sage_Conn = $Comp_Info->{'Sage_Conn'};
	}	 
	
if ($Sage_Conn == 0) {
	

$conn = $this->model->sage_connected;

	if($conn==1){

	  $status ="<i class='fas fa-check-circle' style='color:green;' ></i> SageConnect -> Conectado a: ".$this->model->Query_value('CompanySession','CompanyNameSage50','where ID_compania="'.$this->model->id_compania.'"');

	}else{

	  $status = "<i class='fas fa-ban' style='color:red;' ></i> SageConnect -> No conectado a: ".$this->model->Query_value('CompanySession','CompanyNameSage50','where ID_compania="'.$this->model->id_compania.'"');

	}


}

if ($Sage_Conn == 1) {

     $status ="<i class='fas fa-check-circle' style='color:green;' ></i> p3Top3 -> ".$this->model->Query_value('CompanyLogSync','CompanyNameSage50','where ID_compania="'.$this->model->id_compania.'"');		
}

if ($Sage_Conn == 9) {
	
	 $metodo = "Standalone";

     $status = "<i class='fas fa-check-circle'  ></i>Standalone";
		
}

echo $status;
?>
</div>



<div style="float: right; text-align:right;" class="crop col-xs-6">
&nbsp&nbspV_<?php echo date('d.m.y').'_'.date('h'); ?>
</div>

</div>
</div>



<!--===============================================================================================-->
    <script src="page_assets/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="page_assets/vendor/bootstrap/js/popper.js"></script>
<!--===============================================================================================-->
	<script src="page_assets/vendor/daterangepicker/moment.min.js"></script>
	<script src="page_assets/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="page_assets/vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="page_assets/js/main.js"></script>

</body>
</html>