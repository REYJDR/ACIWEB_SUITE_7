<?php
require_once APP.'view/modules/'.basename(__DIR__).'/lang/'.$this->model->lang.'_ref.php';

$NO_LINES =  $this->model->Query_value('FAC_DET_CONF','NO_LINES','where ID_compania="'.$this->model->id_compania .'"');

echo '<input type="hidden" id="FAC_NO_LINES" value="'.$NO_LINES .'" />'; 


?>

<!--ADD JS FILE-->
<script  src="<?php echo URL; ?>js/operaciones/requisiciones/req_reception.js" ></script>


<div class="limiter">
		<div class="container-page100">
			<div class="wrap-page100">
			<form method="POST"  action="" class="login100-form validate-form p-l-55 p-r-55 p-t-60" >

			<span class="page100-form-title">
						<?PHP echo $TitleRec; ?>
			</span>
			<!--INI DIV ERRO-->
			<div id="ERROR" class="alert"></div>
			<!--INI DIV ERROR-->
			
			<!--ini contenido-->
			<div class="col-lg-4"> 
              <fieldset class="fieldsetform">
              <table class='table_form'>
                <tbody>
                <tr><th><?PHP echo $REC_Title1; ?></th>
				<td ><input class="inputPage col-lg-10" id="buscar" name="buscar"/>&nbsp; 
				<a title="Buscar ID" href="javascript:void(0)" onclick="get_reception();"><i class="fa fa-search"></i></a>

				</td></tr> </tbody>
              </table>
              </fieldset>
            </div>


            <div class="separador col-lg-12"></div>
            <div id="info" class="col-lg-12"></div>

                
			<!--fin contenido-->
			</form>	
			<div class="separador col-lg-12"> </div>
			</div>
		</div>
	</div>