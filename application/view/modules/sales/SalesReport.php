<?php
require_once APP.'view/modules/'.basename(__DIR__).'/lang/'.$this->model->lang.'_ref.php';
?>

<!--ADD JS FILE-->
<script  src="<?php echo URL; ?>js/operaciones/ventas/SalesReport.js" ></script>


<div class="limiter">
		<div class="container-page100">
			<div class="wrap-page100">
			<form method="POST"  action="" class="login100-form validate-form p-l-25 p-r-25 p-t-60" >

			<span class="page100-form-title">
						<?PHP echo $S_REP_title; ?>
			</span>
			<!--INI DIV ERRO-->
			<div id="ERROR" class="alert"></div>
      <!--INI DIV ERROR-->
      
      <!--ini contenido-->

      <!--INI BARRA BUSQUEDA REPORTES -->
      <div class="col-lg-12 searchBar">
        <div class="col-lg-3" >
          <div class="col-lg-5" ><label for='soId'><?php echo $S_REP_input1;?></label></div>
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
				<tr>

                  <th width="10%"><?PHP echo $S_REP_TblHdr1; ?></th>
                  <th width="10%"><?PHP echo $S_REP_TblHdr2; ?></th>
                  <th width="25%"><?PHP echo $S_REP_TblHdr3; ?></th>
                  <th width="5%"><?PHP echo $S_REP_TblHdr4; ?></th>
                  <th width="15%"><?PHP echo $S_REP_TblHdr5; ?></th>
                  <th width="10%"><?PHP echo $S_REP_TblHdr6; ?></th>
                  <th width="10%"><?PHP echo $S_REP_TblHdr7; ?></th>
                  <th width="10%"><?PHP echo $S_REP_TblHdr8; ?></th>
                  <th width="10%"><?PHP echo $S_REP_TblHdr9; ?></th>
				  

                  
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

					$clause.= 'where Sales_Header_Imp.ID_compania="'.$this->model->id_compania.'" ';



					if($date1!=''){

					if($date2!=''){

						$clause.= ' and Sales_Header_Imp.date between "'.$date1.'%" and "'.$date2.'%" ';           
						}
					
					if($date2==''){ 

						$clause.= ' and Sales_Header_Imp.date like "'.$date1.'%"';
					}
						
					}

					if($soNo!=''){ 
						
							$clause.= ' and Sales_Header_Imp.InvoiceNumber like "%'.$soNo.'%" ';
					}
											



					$limit = '1000';
					$sort = 'DESC';
					$filter = $this->getSalesRep($sort,$limit,$clause);

					$URL ="'".URL."'";
					
					foreach ($filter as $datos) {
					
					  $filter = json_decode($datos);
					
					
					  $ID ="'".$filter->{'InvoiceNumber'}."'";
					
					   if($filter->{'Error'}==1) { 
					
						 $status= "Error : ".$filter->{'ErrorPT'}. 'Cancelado';
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
					
					
					
					$user = $this->model->Get_User_Info($filter->{'user'}); 
					
					foreach ($user as $value) {
					$value = json_decode($value);
					$name= $value->{'name'};
					$lastname = $value->{'lastname'};
					}
					
					
					 $OrdPedi = $this->model->Query_value('INVOICE_GEN_HEADER','SalesOrderNumber','WHERE InvoiceNumber="'.$filter->{'InvoiceNumber'}.'"');
					 $OrdPediID ="'".$OrdPedi."'"; 
					
					 $NOTA = $this->model->Query_value('INVOICE_GEN_HEADER','NOTAS','WHERE InvoiceNumber="'.$filter->{'InvoiceNumber'}.'"');
					
					 list($nota,$typago) = explode('-',$NOTA);

					 $SO_USER = $this->model->Query_value('SalesOrder_Header_Imp','user','WHERE SalesOrderNumber="'.$soNo.'" and ID_compania="'.$this->model->id_compania.'" ');	 
					 $SO_USER = $this->model->Get_User_Info($SO_USER); 
					 
					 foreach ($SO_USER as $value) {
					 $value = json_decode($value);
					 $SOname= $value->{'name'};
					 $SOlastname = $value->{'lastname'};
					 }
					 
					$table.= '<tr>
						<td ><a href="#"  onclick="javascript: show_invoice('.$URL.','.$ID.');"  ><strong>'.$filter->{'InvoiceNumber'}.'</strong></a></td>
						<td ><a href="#"  onclick="javascript: show_sales('.$URL.','.$OrdPediID.');"  ><strong>'.$OrdPedi."</strong></a></td>
						<td class='numb' >".$filter->{'date'}."</td>
						<td >".$filter->{'CustomerName'}.'</td>
						<td >'.$SOname.'-'.$SOlastname.'</td>
						<td >'.$typago.'</td>
						<td width="15%" class="numb" >'.number_format($filter->{'Net_due'},2,'.',',').'</td>
						<td >'.$name.' '.$lastname.'</td>
						<td '.$style.'>'.$status."</td>
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