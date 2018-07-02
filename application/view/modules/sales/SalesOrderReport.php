<?php
require_once APP.'view/modules/'.basename(__DIR__).'/lang/'.$this->model->lang.'_ref.php';
?>

<!--ADD JS FILE-->
<script  src="<?php echo URL; ?>js/operaciones/ventas/SalesOrderReport.js" ></script>


<div class="limiter">
		<div class="container-page100">
			<div class="wrap-page100">
			<form method="POST"  action="" class="login100-form validate-form p-l-25 p-r-25 p-t-60" >

			<span class="page100-form-title">
						<?PHP echo $SO_REP_title; ?>
			</span>
			<!--INI DIV ERRO-->
			<div id="ERROR" class="alert"></div>
      <!--INI DIV ERROR-->
      
      <!--ini contenido-->

      <!--INI BARRA BUSQUEDA REPORTES -->
      <div class="col-lg-12 searchBar">
        <div class="col-lg-3" >
          <div class="col-lg-5" ><label for='soId'><?php echo $SO_REP_input1;?></label></div>
          <div class="col-lg-7" ><input class="inputPage" type="text" id='soId' name='soId' /></div> 
        </div>
        <div class="col-lg-6" >
          <div class="col-lg-3" ><label for='date1'><?php echo $SO_REP_input2;?></label></div>
          <div class="col-lg-4" ><input class="inputPage" type="date" id='date1' name='date1'  /></div> 
          <div class="col-lg-1" ><label for='date2'><?php echo $SO_REP_input3;?></label></div>
          <div class="col-lg-4" ><input class="inputPage" type="date" id='date2' name='date2'  /></div>       
        </div>

        <input type='hidden' value='1' name='flag' />

        <div class="col-lg-2">
         <button type="submit" class="btn-bar" name="search" ><?php echo $SO_REP_REP_BTN1; ?></button>
        </div>
      </div>  
    
      <!--FIN BARRA BUSQUEDA REPORTES -->

      <div class="separador col-lg-12"> </div>
      <fieldset class="fieldsetform" >
            <table id="table_report" class="display table table-condensed table-striped table-bordered" >
              <thead>
                <tr>
                  
                  <th width="10%"><?PHP echo $SO_REP_TblHdr1; ?></th>
                  <th width="10%"><?PHP echo $SO_REP_TblHdr2; ?></th>
                  <th width="25%"><?PHP echo $SO_REP_TblHdr3; ?></th>
                  <th width="5%"><?PHP echo $SO_REP_TblHdr4; ?></th>
                  <th width="15%"><?PHP echo $SO_REP_TblHdr5; ?></th>
                  <th width="10%"><?PHP echo $SO_REP_TblHdr6; ?></th>
                  <th width="10%"><?PHP echo $SO_REP_TblHdr7; ?></th>

                  
                </tr>
              </thead>
              <tbody>
			  <?php 
			   if(isset($_REQUEST['flag'])){

				$soNo = $_REQUEST['soId'];
				$date1 = $_REQUEST['date1'];
				$date2 =  $_REQUEST['date2'];

					$this->model->verify_session();

					$clause='';

					$clause.= 'where SalesOrder_Header_Imp.ID_compania="'.$this->model->id_compania.'" ';



					if($date1!=''){

						if($date2!=''){

						$clause.= 'and  date between "'.$date1.'" and "'.$date2.'" ';           
						}

						if($date2==''){ 

						$clause.= 'and date="'.$date1.'"';
						}

					}

					if($soNo!=''){
						
						$clause.= ' and SalesOrder_Header_Imp.SalesOrderNumber="'.$soNo.'" ';
					}

					$limit = '1000';
					$sort = 'DESC';
					$filter = $this->getSalesOrderRep($sort,$limit,$clause);

					$URL ='"'.URL.'"';
					
					foreach ($filter as $datos) {
					
					  $filter = json_decode($datos);
					
					
					  $ID ='"'.$filter->{'SalesOrderNumber'}.'"';
					
					   if($filter->{'Error'}==1) { 
					
						 $status= "Error : ".$filter->{'ErrorPT'}. '  Cancelado';
						 $style="style='color:red; font-style:bold;'"; 
					
					
					   } else{
					
						if($filter->{'Enviado'}==0){
					
						  $style="style='color:orange; font-style:bold;'"; 
						  $status='No sincronizado';
					
						   }else{ 
					
							 $status= "Enviado";
							 $style="style='color:green; font-style:bold;'";
					
						   }   
					
						}
					
					
					$Emitida = $this->model->Query_value('SalesOrder_Header_Imp','EMITIDA','Where SalesOrderNumber="'.$filter->{'SalesOrderNumber'}.'" and  ID_compania="'.$this->model->id_compania.'" ');
					
							
					if($Emitida=='0' || $Emitida==''){ $apro = 'NO';  $apro_style="style='color:orange; font-style:bold;'";  }
					
					if($Emitida=='1' ){ $apro = 'SI'; $apro_style="style='color:green; font-style:bold;'"; }
					
					
					
					$user = $this->model->Get_User_Info($filter->{'user'}); 
					
					foreach ($user as $value) {
					$value = json_decode($value);
					$name= $value->{'name'};
					$lastname = $value->{'lastname'};
					}
					
					
					if($filter->{'Error'}!=1){$apr = $apro;}
					
					$close_sales_ck = $this->model->Query_value('SAX_USER', 'closeSO','where id="'.$this->model->active_user_id.'";');
					
					$table.= "<tr>
					
						<td ><a href='#' onclick='javascript: show_sales(".$URL.",".$ID."); ' >".$filter->{'SalesOrderNumber'}."</a></td>
						<td class='numb' >".$filter->{'date'}."</td>
						<td >".$filter->{'CustomerID'}.'-'.$filter->{'CustomerName'}.'</td>
						<td class="numb" >'.$this->numberFormatPrecision($filter->{'Net_due'}).'</td>
						<td >'.$name.' '.$lastname.'</td>
						<td '.$apro_style.'>'.$apro."</td>";
					
					 if($close_sales_ck == 1 && $apro != 'SI'){
					
					 $table .= "<td ><a href='#' onclick='javascript: closeSo(".$URL.",".$ID."); ' >Cerrar orden</a></td>";
					
					 } else{
					
					 $table .= "<td ></td>";
					
					 }
					
					 $table .= "</tr>";
					
					
					$apr = '';
					}
					
				echo $table;
	
			  }
              ?>
              </tbody>
            </table>   
      </fieldset>  
     
			<!--fin contenido-->
      <div class="separador col-lg-12"> </div>
      <!--ini contenido info -->
       <div id="info" class="col-lg-12"> </div>
      <!--end contenidoinfo -->
      <div class="separador col-lg-12"> </div>
	  
      </form>   
			</div>
		</div>
	</div>