<?php
require_once APP.'view/modules/'.basename(__DIR__).'/lang/'.$this->model->lang.'_ref.php';
?>

<!--ADD JS FILE-->
<script  src="<?php echo URL; ?>js/operaciones/inventory/invInRep.js" ></script>


<div class="limiter">
		<div class="container-page100">
			<div class="wrap-page100">
			<form method="POST"  action="" class="login100-form validate-form p-l-25 p-r-25 p-t-60" >

			<span class="page100-form-title">
						<?PHP echo $Inv_REP_title; ?>
			</span>
			<!--INI DIV ERRO-->
			<div id="ERROR" class="alert"></div>
      <!--INI DIV ERROR-->
      
      <!--ini contenido-->

      <!--INI BARRA BUSQUEDA REPORTES -->
      <div class="col-lg-12 searchBar">
   <!--     <div class="col-lg-3" >
          <div class="col-lg-5" ><label for='soId'><?php echo $Inv_REP_input1;?></label></div>
          <div class="col-lg-7" ><input class="inputPage" type="text" id='soId' name='soId' /></div> 
        </div> -->
        <div class="col-lg-6" >
          <div class="col-lg-3" ><label for='date1'><?php echo $Inv_REP_input2;?></label></div>
          <div class="col-lg-4" ><input class="inputPage" type="date" id='date1' name='date1'  /></div> 
          <div class="col-lg-1" ><label for='date2'><?php echo $Inv_REP_input3;?></label></div>
          <div class="col-lg-4" ><input class="inputPage" type="date" id='date2' name='date2'  /></div>       
        </div>

        <input type='hidden' value='1' name='flag' />

        <div class="col-lg-2">
         <button type="submit" class="btn-bar" name="search" ><?php echo $Inv_REP_REP_BTN1; ?></button>
        </div>
      </div>  
    
      <!--FIN BARRA BUSQUEDA REPORTES -->

      <div class="separador col-lg-12"> </div>
      <fieldset class="fieldsetform" >
            <table id="table_report" class="display table table-condensed table-striped table-bordered" >
              <thead>
                <tr>
				<tr>

                  <th width="10%"><?PHP echo $Inv_REP_TblHdr1; ?></th>
                  <th width="10%"><?PHP echo $Inv_REP_TblHdr2; ?></th>
                  <th width="25%"><?PHP echo $Inv_REP_TblHdr3; ?></th>
                  <th width="5%"><?PHP  echo $Inv_REP_TblHdr4; ?></th>
                  <th width="15%"><?PHP echo $Inv_REP_TblHdr5; ?></th>
                  <th width="10%"><?PHP echo $Inv_REP_TblHdr6; ?></th>
                  <th width="10%"><?PHP echo $Inv_REP_TblHdr7; ?></th>
                  <th width="10%"><?PHP echo $Inv_REP_TblHdr8; ?></th>
                  <th width="10%"><?PHP echo $Inv_REP_TblHdr9; ?></th>
                  <th width="10%"><?PHP echo $Inv_REP_TblHdr10; ?></th>
                  <th width="10%"><?PHP echo $Inv_REP_TblHdr11; ?></th>
				  <th width="10%"><?PHP echo $Inv_REP_TblHdr12; ?></th>
				  <th width="10%"><?PHP echo $Inv_REP_TblHdr13; ?></th>
                  <th width="10%"><?PHP echo $Inv_REP_TblHdr14; ?></th>
				  <th width="10%"><?PHP echo $Inv_REP_TblHdr15; ?></th>
                </tr>
              </thead>
              <tbody>
			  <?php 
			   if(isset($_REQUEST['flag'])){

			
				$date1 = $_REQUEST['date1'];
				$date2 =  $_REQUEST['date2'];

					$this->model->verify_session();

					$clause='';

					$clause.= 'where ID_compania="'.$this->model->id_compania.'" ';


					if($date1!=''){

					if($date2!=''){

						$clause.= ' and Date between "'.$date1.'%" and "'.$date2.'%" ';           
						}
					
					if($date2==''){ 

						$clause.= ' and Date like "'.$date1.'%"';
					}
						
					}


					$limit = '1000';
					$sort = 'DESC';
					$filter = $this->getInvInList($sort,$limit,$clause);

					$URL ="'".URL."'";
					
					foreach ($filter as $datos) {
					
			    	  $filter = json_decode($datos);
				
				      $user = $this->model->Get_User_Info($filter->{'User'}); 
					
					foreach ($user as $value) {
					$value = json_decode($value);
					$name= $value->{'name'};
					$lastname = $value->{'lastname'};
					}
					
					$stockOrigID = $this->getStocLockName($filter->{'stockOrigID'});

					$stockDestID =  $this->getStocLockName($filter->{'stockDestID'});

					echo $stockOrigID[0];

					$table.= '<tr>
						<td ><strong>'.$filter->{'ID'}.'</strong></td>
						<td ><strong>'.$filter->{'ProductID'}."</strong></a></td>
						<td class='numb' >".$filter->{'Date'}."</td>
						<td >".$name.' '.$lastname.'</td>
						<td class="numb">'.number_format($filter->{'Qty'},4,'.',',').'</td>
						<td class="numb">'.number_format($filter->{'unit_price'},4,'.',',').'</td>
						<td class="numb">'.number_format($filter->{'Total'},4,'.',',')."</td>					
						<td >".$filter->{'JobID'}.'</td>
						<td >'.$filter->{'JobPhaseID'}.'</td>
						<td >'.$filter->{'JobCostCodeID'}.'</td>
						<td >'.$filter->{'Type'}.'</td>
						<td >'.$filter->{'referencia'}.'</td>
						<td >'.$filter->{'aci_ref'}.'</td>
						<td >'.$stockOrigID['name'].'-('.$stockOrigID['location'].")</td>
						<td >".$stockDestID['name'].'-('.$stockDestID['location'].")</td>
						
					   </tr>";
					
					}
					
					$table.= '</table>';
					
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