<?php
require_once APP.'view/modules/'.basename(__DIR__).'/lang/'.$this->model->lang.'_ref.php';
?>

<!--ADD JS FILE-->
<script  src="<?php echo URL; ?>js/operaciones/requisiciones/req_pago.js" ></script>
<script  src="<?php echo URL; ?>js/operaciones/reporte/rep_reportes.js" ></script>


<div class="limiter">
		<div class="container-page100">
			<div class="wrap-page100">

			<span class="page100-form-title">
						<?PHP echo $TitlePag; ?>
			</span>

			<!--INI DIV ERRO-->
			<div id="ERROR" ></div>
			<!--INI DIV ERROR-->
     
     <!--ini contenido-->
      <form method="POST"  action="" class="login100-form validate-form p-l-25 p-r-25 p-t-60" >

     <input type="hidden" id='SelectJob'  value="" />

      <div class="separador col-lg-12"></div>
			    <!--ini  header-->
        <div class="col-lg-4"> 
          <fieldset class="fieldsetform" >
            <div class="col-lg-12"> 
              <fieldset class="fieldsetform">
              <table class='table_form'>
                <tbody>
                <tr><th><?php echo $Project; ?></th><td><select class="select col-lg-9" id="JOBID" name="JOBID" onchange="get_budget(this.value);">
                  <option value="-" selected>-</option>
                  </select>
                  <div class="col-lg-3 bottom-right">
                  <button type="button"  onclick='searchReq();' class="btn-bar"  name="search" ><?php echo $BTN1; ?></button>
                  </div>
                  </td>
                </tr>
                <tr><th><?php echo $Budget; ?></th><td ><input class="inputPage numb" type="text" id='budget' name='budget' readonly/></td></tr>
                <tr><th><?php echo $DateFrom;?></th><td><input class="inputPage" type="date" id='dateFrom' name='dateFrom'  /></td></tr>
                <tr><th><?php echo $DateTo;?></th><td><input class="inputPage" type="date" id='dateTo' name='dateTo'  /></td></tr>
                </tbody>
              </table>
              </fieldset>
            </div>

            <div class="col-lg-12"></div>

            <div class="col-lg-12"> 
              <fieldset class="fieldsetform">
              <table class='table_form note'>
                <tbody>
                <tr><th><strong><?PHP echo $Note; ?></strong></th>
                <td> <textarea class="textareaPage"  onkeyup="checkNOTA(this.id);" rows="3" cols="70" id="nota" name="nota"></textarea></td></tr>
                </tbody>
              </table>
              </fieldset>
            </div>
           </fieldset>
        </div>
  
   

	  <div class="separador col-lg-12"> </div>
	
  <!--top Table-->
  <fieldset class="fieldsetform" >
	<table id="table"  class="display table  table-condensed table-striped table-bordered" >
      <thead>
        <tr>
          <th width="5%"></th>
          <th width="10%"><?PHP echo $POnumb; ?></th>
          <th width="10%"><?PHP echo $POdate; ?></th>
          <th width="20%"><?PHP echo $POvendor; ?></th> 
          <th width="5%"><?PHP echo $POtotal; ?></th>
          <th width="5%"><?PHP echo $POreq_amt; ?></th>
          <th width="5%"><?PHP echo $POpaid; ?></th>
          <th width="5%"><?PHP echo $POdue; ?></th>
          <th width="5%"><?PHP echo $POret; ?></th>
          <th width="10%"><?PHP echo $POreq; ?></th>
        </tr>
      </thead>
      <tbody id='resTable' >
      </tbody>
      </table>

 </fieldset>                     
	<!--end Table-->
  

	  <div class="separador col-lg-12"></div>
	  
    <div class="col-lg-8"></div>
      <div class="col-lg-3">
       <button type="button" class="accept-form-btn"  onclick="set_rep();"  ><?php echo $BTN2; ?></button>
      </div>

      <!--top Detail Table-->
      <div class="separador col-lg-12"></div>
      <div class="col-lg-4" > 
        <div id="table2"></div>
      </div>
      <!--end Detail Table-->

      <!--top Bill Table-->
      <div class="separador col-lg-12"></div>
      <div class="col-lg-6" > 
        <fieldset class="fieldsetform" >
          <legend><?php echo $REP_TitleTbl3; ?></legend>
       
          <table id="table_cash" class="display table table-striped table-bordered" cellspacing="0" >
          <thead>
            <tr>
              <th width="5%"><?php echo  $REP_detail_Tbl4Hdr1; ?></th>
              <th width="10%"><?php echo $REP_detail_Tbl4Hdr2; ?></th>
              <th width="5%"><?php echo  $REP_detail_Tbl4Hdr3; ?></th>
              <th width="5%"><?php echo  $REP_detail_Tbl4Hdr4; ?></th>
              <th width="10%"><?php echo $REP_detail_Tbl4Hdr5; ?></th>
              <th width="5%"><?php echo  $REP_detail_Tbl4Hdr6; ?></th>
            </tr>
          </thead>
            <tbody id="tableAdv"> </tbody>  
           </table> 
        
        </fieldset>
      </div>
      <!--end Bill Table-->

      <!--top Cash Advance Table-->
      
      <div class="col-lg-6" >
        <fieldset class="fieldsetform" > 
          <legend><?php echo $REP_TitleTbl4; ?></legend>


        <table id="table_fact" class="display  table table-striped table-bordered" cellspacing="0" >
        <thead>
          <tr>
            <th width="5%"><?php echo $REP_detail_Tbl3Hdr1; ?></th>
            <th width="10%"><?php echo $REP_detail_Tbl3Hdr2;?></th>
            <th width="5%"><?php echo $REP_detail_Tbl3Hdr3; ?></th>
            <th width="5%"><?php echo $REP_detail_Tbl3Hdr4; ?></th>
          </tr>
        </thead>
        <tbody id="tableFact"></tbody>
        </table>
        </fieldset>
      </div>
      <!--end Cash Advance Table-->
      </form>

      
			<!--fin contenido-->
			<div class="separador col-lg-12"> </div>
      
			</div>
		</div>
    	</div>
  </div>
</div>