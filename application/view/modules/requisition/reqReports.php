<?php
require_once APP.'view/modules/'.basename(__DIR__).'/lang/'.$this->model->lang.'_ref.php';



?>

<!--ADD JS FILE-->
<script  src="<?php echo URL; ?>js/operaciones/requisiciones/req_report.js" ></script>


<div class="limiter">
		<div class="container-page100">
			<div class="wrap-page100">
			<form method="POST"  action="" class="login100-form validate-form p-l-55 p-r-55 p-t-60" >

			<span class="page100-form-title">
						<?PHP echo $TitleRep; ?>
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
                  
                  <th width="10%"><?PHP echo $REQ_REP_TblHdr1; ?></th>
                  <th width="10%"><?PHP echo $REQ_REP_TblHdr2; ?></th>
                  <th width="45%"><?PHP echo $REQ_REP_TblHdr3; ?></th>
                  <th width="25%"><?PHP echo $REQ_REP_TblHdr6; ?></th>
                  <th width="25%"><?PHP echo $REQ_REP_TblHdr4; ?></th>
                  <th width="10%"><?PHP echo $REQ_REP_TblHdr5; ?></th>
                  
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

                $clause.= 'where REQ_HEADER.ID_compania="'.$id_compania.'" and REQ_DETAIL.ID_compania="'.$id_compania.'" ';

                if($date1!=''){
                  if($date2!=''){
                      $clause.= ' and  DATE >= "'.$date1.'%" and DATE <= "'.$date2.'%" ';           
                    }
                  if($date2==''){ 
                    $clause.= ' and  DATE like "'.$date1.'%" ';
                  }
                }

                if($reqNo!=''){

                  $clause.= ' and REQ_HEADER.NO_REQ="'.$reqNo.'" ';
                }

                $limit = '1000';
                $sort = 'DESC';
                $Item = $this->model->get_req_to_report($sort,$limit,$clause);
                

                foreach ($Item as $datos) {
                  
                    $Item = json_decode($datos);
                  
                  
                    $name     = $this->model->Query_value('SAX_USER','name','Where ID="'.$Item->{'USER'}.'"');
                    $lastname = $this->model->Query_value('SAX_USER','lastname','Where ID="'.$Item->{'USER'}.'"');
                  
                    $status='';
                  
                    $ID = '"'.$Item->{'NO_REQ'}.'"';
                    $req = $Item->{'NO_REQ'};
                  
                    $URL = '"'.URL.'"';
                  
                  //obtengo estatus de la requisicion
                  $status = $this->req_status($req,$id_compania);
                  
                  
                  switch ($status) {
                  
                    case 'CERRADA':
                      $style = 'style="background-color:#D8D8D8 ;"';//verder
                      break;
                    case 'FINALIZADO':
                      $style = 'style="background-color:#BCF5A9;"';//verder
                      break;
                    case 'ORDENADO':
                      $style = 'style="background-color:#F2F5A9;"';//AMARILLO
                      break;
                    case 'PARCIALMENTE ORDENADO':
                      $style = 'style="background-color:#F3E2A9;"';//NARANJA
                      break;
                    case 'COTIZANDO':
                      $style = 'style="background-color:#F7BE81;"';//NARANJA
                      break; 
                    case 'POR COTIZAR':
                      $style = 'style="background-color:#F5A9A9;"';//ROJO
                      break; 
                  
                  }
                  
                  
                  $table.="<tr >
                                
                                <td width='10%' ><a href='#' onclick='javascript: show_req(".$URL.",".$ID.");'>".$Item->{'NO_REQ'}."</a></td>
                                <td width='10%' >".date('m/d/Y',strtotime($Item->{'DATE'}))."</td>
                                <td width='45%' >".$Item->{'NOTA'}.'</td>
                                <td width="45%" >'.$Item->{'JOB'}.'</td>
                                <td width="25%" >'.$name.' '.$lastname.'</td>
                                <td width="10%" '.$style.' >'.$status.'</td>
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