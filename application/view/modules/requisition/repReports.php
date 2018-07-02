<?php
require_once APP.'view/modules/'.basename(__DIR__).'/lang/'.$this->model->lang.'_ref.php';



?>

<!--ADD JS FILE-->
<script  src="<?php echo URL; ?>js/operaciones/requisiciones/req_report.js" ></script>


<div class="limiter">
		<div class="container-page100">
			<div class="wrap-page100">
			<form method="POST"  action="" class="login100-form validate-form p-l-25 p-r-25 p-t-60" >

			<span class="page100-form-title">
						<?PHP echo $REP_report; ?>
			</span>
			<!--INI DIV ERRO-->
			<div id="ERROR" class="alert"></div>
      <!--INI DIV ERROR-->
      
      <!--ini contenido-->

      <!--INI BARRA BUSQUEDA REPORTES -->
      <div class="col-lg-12 searchBar">
        <div class="col-lg-3" >
          <div class="col-lg-5" ><label for='repId'><?php echo $REQ_input1;?></label></div>
          <div class="col-lg-7" ><input class="inputPage" type="text" id='repId' name='repId' /></div> 
        </div>
        <div class="col-lg-6" >
          <div class="col-lg-3" ><label for='date1'><?php echo $REQ_input2;?></label></div>
          <div class="col-lg-4" ><input class="inputPage" type="date" id='date1' name='date1'  /></div> 
          <div class="col-lg-1" ><label for='date2'><?php echo $REQ_input3;?></label></div>
          <div class="col-lg-4" ><input class="inputPage" type="date" id='date2' name='date2'  /></div>       
        </div>

        <input type='hidden' value='1' name='flag' />

        <div class="col-lg-2">
         <button type="submit" class="btn-bar" name="search" ><?php echo $REQ_REP_BTN1; ?></button>
        </div>
      </div>  
    
      <!--FIN BARRA BUSQUEDA REPORTES -->

      <div class="separador col-lg-12"> </div>
      <fieldset class="fieldsetform" >
            <table id="table" class="display table table-condensed table-striped table-bordered" >
              <thead>
                <tr>
                  
                  <th width="10%"><?PHP echo $REP_TblHdr1; ?></th>
                  <th width="10%"><?PHP echo $REP_TblHdr2; ?></th>
                  <th width="10%"><?PHP echo $REP_TblHdr3; ?></th>
                  <th width="25%"><?PHP echo $REP_TblHdr4; ?></th>
                  <th width="15%"><?PHP echo $REP_TblHdr5; ?></th>
                  <th width="10%"><?PHP echo $REP_TblHdr6; ?></th>
                  <th width="10%"><?PHP echo $REP_TblHdr7; ?></th>
                  <th width="10%"></th>
                  
                </tr>
              </thead>
              <tbody>

                <?php
                if(isset($_REQUEST['flag'])){

                $this->model->verify_session();
                $id_compania = $this->model->id_compania ;

               $reqNo = $_REQUEST['repId'];
               $date1 = $_REQUEST['date1'];
               $date2 =  $_REQUEST['date2'];

                $table = '';
                $clause='';

                $clause.= 'where A.ID_compania="'.$id_compania.'" and B.ID_compania="'.$id_compania.'" ';

                if($date1!=''){
                  if($date2!=''){
                      $clause.= ' and  A.DATE >= "'.$date1.'%" and A.DATE <= "'.$date2.'%" ';           
                    }
                  if($date2==''){ 
                    $clause.= ' and  A.DATE like "'.$date1.'%" ';
                  }
                }

                if($reqNo!=''){

                  $clause.= ' and A.NO_REP="'.$reqNo.'" ';
                }

                $limit = '1000';
                $sort = 'DESC';
                $Item = $this->get_rep_to_report($sort,$limit,$clause,0);
                

                foreach ($Item as $datos) {
                  
                    $Item = json_decode($datos);
                  
                  
                    $name     = $this->model->Query_value('SAX_USER','name','Where ID="'.$Item->{'USER'}.'"');
                    $lastname = $this->model->Query_value('SAX_USER','lastname','Where ID="'.$Item->{'USER'}.'"');
                  
                    $status='';
                  
                    $ID = '"'.$Item->{'NO_REP'}.'"';
                    $req = $Item->{'NO_REP'};
                  
                    $URL = '"'.URL.'"';
                  
                  //obtengo estatus de la requisicion
                  $status = $Item->{'ST_CLOSED'};
                  
                  
                  switch ($status) {

                    case 0:
                      $req_status = 'POR PAGAR';
                      $style = 'style="background-color:#F5A9A9;"';//NARANJA
                      break;                  
                    case 1:
                      $req_status = 'CANCELADA';
                      $style = 'style="background-color:#D8D8D8 ;"';//gris
                      break;
                    case 2:
                      $req_status = 'FINALIZADO';
                      $style = 'style="background-color:#BCF5A9;"';//verde
                      break;
                  
                  }
                  
                  
                  $table.="<tr >
                                
                                <td width='10%' ><a href='#' onclick='javascript: show_rep(".$URL.",".$ID.");'>".$Item->{'NO_REP'}."</a></td>
                                <td width='10%' >".$Item->{'JOB'}."</td>
                                <td width='10%' >".date('m/d/Y',strtotime($Item->{'DATE'}))."</td>
                                <td width='25%' >".$Item->{'NOTA'}.'</td>
                                <td width="15%" >'.$name.' '.$lastname.'</td>
                                <td width="10%" >'.number_format($Item->{'Total'},2).'</td>
                                <td width="10%" '.$style.' >'.$req_status.'</td>
                                <td width="10%"></td>
                            </tr>';
                  
                  
                  }
                }
                
                echo $table;
                ?>
                
              </tbody>
            </table>   
      </fieldset>  
     
			<!--fin contenido-->
      <div class="separador col-lg-12"> </div>
      <!--ini contenido info -->
       <div id="info" class="col-lg-12"> </div>
      <!--end contenidoinfo -->
      </form>   
			</div>
		</div>
	</div>