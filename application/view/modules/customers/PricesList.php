<?php
require_once APP.'view/modules/'.basename(__DIR__).'/lang/'.$this->model->lang.'_ref.php';
?>


<!--ADD JS FILE-->
<script  src="<?php echo URL; ?>js/operaciones/customers/PricesList.js" ></script>


<div class="limiter">
		<div class="container-page100">
			<div class="wrap-page100">
			<form method="POST"  action="" class="login100-form validate-form p-l-25 p-r-25 p-t-60" enctype="multipart/form-data">

			<span class="page100-form-title">
				<?PHP echo $TitlePL; ?>
			</span>
			<!--INI DIV ERRO-->
			<div id="ERROR" class="alert"></div>
			<!--INI DIV ERROR-->

			<!--ini contenido-->
			<div  class="col-lg-8">
			<fieldset >
			

			<!--CHECKBOXES-->
			<div  class="col-lg-4">
			<fieldset class="fieldsetform">
			<table class='table_form'>
				<tbody>
				    <tr>
				    	<td><input type="checkbox" id="chk_lp" name="chk_lp" value="1" onclick="set_div(this.value)" checked /></td>					
						<th><strong><?PHP echo $CHKBOX_1; ?></strong></th>
					</tr>
					<tr>
					   <td><input type="checkbox" id="chk_lp" name="chk_lp" value="2" onclick="set_div(this.value)" /></td>					
						<th><strong><?PHP echo $CHKBOX_2; ?></strong></th>
					</tr>

				</tbody>
			</table>
			</fieldset>
			</div>
			<!--CHECKBOXES-->

			<div class="separador col-lg-12"></div> <!--SEPERADOR-->

				<!--INPUT NUEVO PRICE ID-->
				<div  class="col-lg-8" id="nvo_lp">
				<fieldset class="fieldsetform">
				<table class='table_form'>
					<tbody>
						<tr>
							<th><strong><?PHP echo $InputPL_1; ?></strong></th>
							<td><input type="text"  class="inputPage" id="price_id" name="price_id" /></td>		
							<th><strong><?PHP echo $InputPL_2; ?></strong></th>
							<td><input type="text"  class="inputPage" id="price_desc" name="price_desc" /></td>				
						</tr>
					</tbody>
				</table>
				</fieldset>
				</div>
				<!--INPUT NUEVO PRICE ID-->

				

				<!--DROPDOWN-->
				<div  class="col-lg-12" id="used_lp">
				<div class="col-lg-12"></div> <!--SEPERADOR-->
				<fieldset class="fieldsetform">
				<table class='table_form'>
					<tbody>
						<tr>
							<th><strong><?PHP echo $InputPL_3; ?></strong></th>
							<td>
								<select  id="price_list" name="price_list" class="select col-lg-12" >

									<option selected disabled></option>

									<?php  
									$CUST = $this->model-> get_PriceList(); 

									foreach ($CUST as $datos) {
																						
									$CUST_INF = json_decode($datos);
									echo '<option value="'.$CUST_INF->{'IDPRICE'}.'" >'.$CUST_INF->{'IDPRICE'}."</option>";

									}
									?>
															
								</select>
							</td>				
						</tr>
					</tbody>
				</table>
				</fieldset>				
				</div>
				<!--DROPDOWN-->

				
			    <div class="separador col-lg-12"></div> <!--SEPERADOR-->
				

				<!--INPUT FILE-->
				<div  class="col-lg-8" id="nvo_lp">
				<fieldset class="fieldsetform">				
					<table class='table_form'>
						<tbody>
							<tr>
								<th><strong><?PHP echo $InputPL_5; ?></strong></th>
								<td><input type="file" class="form-control" id="price_file" name="price_file" required="<?PHP echo $InputPL_4; ?>" />	
						            <p class="help-block"><?PHP echo $Advice1; ?></p>
								</td>			
							</tr>
						</tbody>
					</table>
				</fieldset>									
				</div>
				<!--INPUT FILE-->
				
				<!--Button Process-->
				<div class='col-lg-2'></div>
				<div class='col-lg-2'>
					<div class="container-login100-form-btn">
					<input type="submit"  value="Cargar"  class="accept-form-btn" name="submit"  value="<?PHP echo $BTN_Process; ?>" />			
					</div>
				</div>
				<div class="separador col-lg-12"> </div>
				<!--fin Button Process-->

			
            
			</fieldset>
			</div>

			<div class="separador col-lg-12"> </div>


			<div class='col-lg-9'>
			<fieldset class="fieldsetform">
				<!--Table-->
				<table id="table_PriceList" class="table table-striped responsive table-bordered" cellspacing="0" >
				<thead>
				<tr>
					<th width="20%">Id. Lista de Precios</th>
					<th width="10%">Fecha</th>
					<th width="30%">Descripcion</th> 
					<th width="5%"></th>
				</tr>
				</thead>
			<tbody>

			<?php
				$clause.= 'WHERE PRI_LIST_ID.ID_compania="'.$this->model->id_compania.'" '; 


				$PL = $this->model->get_Price_list('asc','10000',$clause);

				foreach ($PL as $value) {

				$value = json_decode($value);

				$date1 = strtotime($value->{'LAST_CHANGE'});
				//$date1 = $date;
				$date = date('m/d/Y',$date1);
				//$date1 = date('mdY',$date1);

				$PL_ID = trim ($value->{'IDPRICE'});
				$PL_ID = "'".$PL_ID."'";
				$PL_Desc = "'".$value->{'DESCRIPTION'}."'";
				$date1 = "'".$date1."'";

				$table .= ' <tr>
					<td><a href="javascript:void(0)" onclick="get_PL('.$PL_ID.')"><strong>'.$value->{'IDPRICE'}.'</strong></a></td>
					<td class="numb">'.$date.'</td>
					<td>'.$value->{'DESCRIPTION'}.'</td>
					<td><a  href="javascript:void(0)" onclick="del_PL('.$PL_ID.')"><input type="button" id="modal_button" name="modal_button"  class="btn btn-danger btn-sm btn-icon icon-left" value="Eliminar" /></td>
					</tr>';

				}
			echo $table;
			?>
            </tbody></table>

            <div class="separador col-lg-12"></div>
            <div class="col-lg-12" > 
            <div id="table3"></div>
            </div>
			<!--Table-->

			</form>
			
			</fieldset>
			</div>
			<!--fin contenido-->
            

			<div class="separador col-lg-12"> </div>
			</div>
		</div>
	</div>

<!-- Modal : VENTANA EMERGENTE QUE PERMITE MODIFICAR UN ITEM ESPECIFICO-->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <span class="modal-header" >Modificar Item</span>
	  </div>
	  <form method="POST"  action="" class="login100-form validate-form p-l-25 p-r-25 p-t-60" enctype="multipart/form-data">


      <div class="col-lg-12 modal-body">
        
      <div id='prod'></div>

        <div class="col-lg-3" > 
             <label class="control-label">ID Item: </label>
             <input  class="form-control" id="item_id_modal" name="item_id_modal"  readonly/>
             <input type="hidden" class="form-control" id="PL_id" name="PL_id"/>
        </div>
        
        <div class="col-lg-2" > 
             <label class="control-label">Precio: </label>
             <input type="number" class="form-control numb" id="price_id_modal" name="price_id_modal"/>
        </div>
        <div class="col-lg-2" > 
             <label class="control-label">Unidad: </label>
             <input  class="form-control" id="unit_id_modal" name="unit_id_modal" readonly/>
        </div>

        <div class="form-group col-lg-5" > 
              <label class="control-label" >Descripcion:</label>
              <input class="form-control col-lg-10" id="desc_id_modal" name="desc_id_modal"/>
        </div> 
        

    <div class="col-lg-12" ></div>    
      </div>
      <div class="modal-footer">
	  <div class="col-lg-4" ></div>  
		<div class="col-lg-4" >
		<button type="button" onclick="mod_item();" class="btn btn-primary" data-dismiss="modal">Modificar</button>
		</div>
		<div class="col-lg-4" >
		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		</div>    
      </div>
    </div>
	</form>
  </div>
</div>

<div class="separador col-lg-12"></div>


<!-- Modal : VENTANA EMERGENTE QUE PERMITE MODIFICAR UN ITEM ESPECIFICO-->
<div id="modal_additem" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <span >Agregar Item</span>
      </div>

	  <form method="POST"  action="" class="login100-form validate-form p-l-25 p-r-25 p-t-60" enctype="multipart/form-data">
	  
      <div class="col-lg-12 modal-body">
        
      <div id='prod'></div>

        <div class="col-lg-3" > 
             <label class="control-label">ID Item: </label>
             <input  class="form-control" id="item_id_modal_2" name="item_id_modal_2"  type="text" />
             <input type="hidden" class="form-control" id="PL_id_2" name="PL_id_2"/>
        </div>
        
        <div class="col-lg-2" > 
             <label class="control-label">Precio: </label>
             <input type="number" class="form-control numb" id="price_id_modal_2" name="price_id_modal_2"/>
        </div>
        <div class="col-lg-2" > 
             <label class="control-label">Unidad: </label>
             <input class="form-control" id="unit_id_modal_2" name="unit_id_modal_2" />
        </div>

        <div class="form-group col-lg-5" > 
              <label class="control-label" >Descripcion:</label>
              <input class="form-control col-lg-10" id="desc_id_modal_2" name="desc_id_modal_2"/>
        </div> 
        

     <div class="col-lg-12" ></div>    
      </div>
	  
	  <div class="modal-footer">
		<div class="col-lg-4" ></div>  
			<div class="col-lg-4" >
			<button type="button" onclick="add_item();" class="btn btn-primary" data-dismiss="modal">Agregar</button>
			</div>
			<div class="col-lg-4" >
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			</div>    
		</div> 
		</form>
	</div>
 
    </div>
	
 </div>
</div>



<?php

//SE EJECUTA SCRIPT PHP SI SE DÁ SUBMIT AL BOTON "SUBIR"
if (isset($_POST['submit'])){

	try {
		
		$TABLE = 'PRI_LIST_ITEM';


		//INFORMACION  LISTA DE PRECIO
				if ($_POST['price_list'] != '') {
								
							$priceid = trim($_POST['price_list']);

							//elimino la lista de items para ese idprice
							$DEL_STATEMENT = 'DELETE FROM '.$TABLE.' WHERE IDPRICE = "'.$priceid.'" AND ID_compania="'.$this->model->id_compania.'"';
			                $res = $this->model->Query($DEL_STATEMENT);

			               $this->CheckError();

				}else{

				    		$priceid = trim($_POST['price_id']);

		                    //CHECA SI YA EXISTE EL ID PROPUESTO
							$check_id = $this->model->Query('SELECT IDPRICE FROM PRI_LIST_ID WHERE IDPRICE ="'.$priceid.'"');

							if($check_id!=''){//SI EXISTE INDICA ERROR y mata el proceso php

			                
				            die("<script>$(window).load(function(){ MSG_ERROR('EL ID DE LA LISTA DE PRECIO PROPUESTA YA EXISTE',0); });</script>");

			                 }else{

			                //elimino la lista de items para ese idprice
							$DEL_STATEMENT = 'DELETE FROM '.$TABLE.' WHERE IDPRICE = "'.$priceid.'" AND ID_compania="'.$this->model->id_compania.'"';
			                $res = $this->model->Query($DEL_STATEMENT);

			                $this->CheckError();

			                 }

		        }

				//INI LECTURA DE ARCHIVO EXCEL
					$reader=new Spreadsheet_Excel_Reader();

					$filename=$_FILES["price_file"]["tmp_name"]; 

				//	echo 'file:'.$filename;  var_dump($_FILES); die();

					if($_FILES["price_file"]["size"] > 0)
					{

							$reader->setUTFEncoder('iconv');
							$reader->setOutputEncoding('UTF-8');
							$reader->read($filename);


							 foreach($reader->sheets as $k=>$data)
							 {
					        

								$i=1;
								$values = array();
								$STATEMENT = '';

								 while ($i<=$data['numRows']){


                                 if(sizeof($data['cells'][$i]) > 0){

								     $values['1'] = $priceid;

									foreach($data['cells'][$i] as $KEY=>$cell) 
									{
										   
					                        if($cell !=''){
					                   	
											if ($KEY=='1')   	$values['2'] = utf8_encode($cell) ;
											if ($KEY=='2')   	$values['3'] = utf8_encode($cell) ;
											if ($KEY=='3')   	$values['4'] = utf8_encode($cell) ;
											if ($KEY=='4')   	$values['5'] = utf8_encode($cell) ;      	

					                        }
									
								    }

								   $values['6'] = $this->model->id_compania;

                           

						             //INSERTA EN BD LA LINEA ACTUAL
					 				$STATEMENT= "INSERT INTO ".$TABLE." (
											`IDPRICE`,
											`IDITEM` ,
											`DESCRIPTION` , 
											`PRICE` ,
											`UNIT`,
											`ID_compania`)  
											VALUES 
											('".implode("','", $values)."');";
								
							
					 		        $res = $this->model->Query($STATEMENT);

				                  $this->CheckError();



                                }

								$i=$i+1;
					          }
				              
				              
							}//termina el proceso de insercion

					

		        //SI IDPRICE EXISTE
		    	if ($_POST['price_id'] != '') {
							

				    $values  = array(  'IDPRICE' => $priceid ,
						               'DESCRIPTION' => $_POST['price_desc'] ,
						               'ID_compania' =>  $this->model->id_compania );

			    	$res = $this->model->insert('PRI_LIST_ID',$values);
		           
		            $this->CheckError();

		            echo "<script>$(window).load(function(){ MSG_CORRECT('1 LA LISTA  SE HA CARGADO CON EXITO ',0); });</script>"; 
			            

				}else{

		            echo "<script>$(window).load(function(){ MSG_CORRECT('2 LA LISTA  SE HA CARGADO CON EXITO ',0); });</script>"; 
		     
		      	}

			}else{

				echo "<script>$(window).load(function(){ MSG_ERROR('NO SE HA PODIDO LEER EL ARCHIVO',0); });</script>"; 
				
			}
	} catch (Exception $e) {

		 die("<script>$(window).load(function(){ MSG_ERROR('".$e->getMessage()."',0); });</script>"); 
	}

$_POST = array(); //limpia las variables de $_post
$_FILES = array();

}
?>