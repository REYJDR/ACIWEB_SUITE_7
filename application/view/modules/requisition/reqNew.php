<?php
require_once APP.'view/modules/'.basename(__DIR__).'/lang/'.$this->model->lang.'_ref.php';


$NO_LINES =  $this->model->Query_value('FAC_DET_CONF','NO_LINES','where ID_compania="'.$this->model->id_compania .'"');

echo '<input type="hidden" id="FAC_NO_LINES" value="'.$NO_LINES .'" />'; 


?>

<!--INI DIV ERRO-->
<div id="ErrorModal" class="modal fade" role="dialog">

  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">

        <button type="button" onclick="javascript:history.go(-1);" class="close-form-btn"  data-dismiss="modal">&times;</button>
        <h3 >Error</h3>
      </div>

      <div class="col-lg-12 modal-body">

      <!--ini Modal  body-->  

            <div id='ErrorMsg'></div>

      <!--fin Modal  body-->

      </div>

      <div class="modal-footer">

        <button type="button" onclick="javascript:history.go(-1); return true;" data-dismiss="modal" class="accept-form-btn"  >OK</button>

      </div>

    </div>

  </div>

</div>

<!--modal-->
<!--END DIV ERROR-->


<!--ADD JS FILE-->
<script  src="<?php echo URL; ?>js/operaciones/requisiciones/req_crear.js" ></script>


<div class="limiter">
		<div class="container-page100">
			<div class="wrap-page100">
			<form method="POST"  action="" class="login100-form validate-form p-l-55 p-r-55 p-t-60" >

			<span class="page100-form-title">
						<?PHP echo $Title; ?>
			</span>
			<!--INI DIV ERRO-->
			<div id="ERROR" class="alert"></div>
			<!--INI DIV ERROR-->
			
			<!--ini contenido-->
      <input type="hidden" id='user' value="<?php echo $active_user_id; ?>" />

      <div class="col-lg-4"> 
          <fieldset>
           
            <div class="col-lg-12"> 
              <fieldset class="fieldsetform">
              <table class='table_form'>
                <tbody>
                <tr><th><?php echo $REQ_Detail1; ?></th><td>
                  <select class="select col-lg-12" onchange="phase(this.value);" id="JOBID" >
                   <option value="-" selected>-</option>
                  </select>
                  </td>
                </tr>
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
                <td> <textarea class="textareaPage"  onkeyup="checkInpChar(this.id);" rows="3" cols="70" id="nota" name="nota"></textarea></td></tr>
                </tbody>
              </table>
              </fieldset>
            </div>

        </fieldset>
      </div>
      

      <div class="separador col-lg-12"></div>		

      <div class=" col-lg-12"> 

      <fieldset class="fieldsetform" >
      <table id="table_req_tb" class="table table-striped  table-bordered " cellspacing="0">
        <thead>
          <tr >
            <th width="10%" ><?php echo $REQ_TblHdr1; ?></th>
            <th width="35%" class="text-center"><?php echo $REQ_TblHdr2; ?></th>
            <th width="5%"  class="text-center"><?php echo $REQ_TblHdr3; ?></th>
            <th width="5%"  class="text-center"><?php echo $REQ_TblHdr4; ?></th>
            <th width="15%" class="text-center"><?php echo $REQ_TblHdr5; ?></th>			
            <th width="15%" class="text-center"><?php echo $REQ_TblHdr6; ?></th> 
          </tr>
        </thead>
        <tbody id="table_req" >	</tbody>
      </table>
      </fieldset>
      <div class="separador col-lg-12"></div>		
    
      <div class="col-lg-8"></div>
      <div class="col-lg-3">
       <button type="button" class="accept-form-btn"  onclick="send_req_order();"  ><?php echo $REQ_BTN1; ?></button>
      </div>

      <div class="separador col-lg-12"></div>		
    
      </div>
      </div>
      </div>
      <input type="hidden" id="req_no_jobid" value="" />

			<!--fin contenido-->
			</form>	
			<div class="separador col-lg-12"> </div>
			</div>
		</div>
	</div>