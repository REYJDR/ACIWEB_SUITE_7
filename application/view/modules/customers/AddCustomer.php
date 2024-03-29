<?php
require_once APP.'view/modules/'.basename(__DIR__).'/lang/'.$this->model->lang.'_ref.php';
?>


<!--ADD JS FILE-->
<script  src="<?php echo URL; ?>js/operaciones/customers/AddCustomer.js" ></script>


<div class="limiter">
		<div class="container-page100">
			<div class="wrap-page100">
			<form method="POST"  action="" class="login100-form validate-form p-l-25 p-r-25 p-t-60" enctype="multipart/form-data">

			<span class="page100-form-title">
				<?PHP echo $TitleCus; ?>
			</span>
			<!--INI DIV ERRO-->
			<div id="ERROR" class="alert"></div>
			<!--INI DIV ERROR-->

			<!--ini contenido-->
			<div  class="col-lg-8">
			<fieldset >
			<!--<input type="hidden"  class="inputPage" id="control" name="control" value='1'/>-->


			<!--CHECKBOXES-->
			<div  class="col-lg-4">
			<fieldset class="fieldsetform">
			<table class='table_form'>
				<tbody>
				    <tr>
				    	<td><input type="checkbox" id="chk_cus" name="chk_cus" value="1" onclick="set_div(this.value)" checked /></td>					
						<th><strong><?PHP echo $Cus_CHKBOX_1; ?></strong></th>
					</tr>
					<tr>
					   <td><input type="checkbox" id="chk_cus" name="chk_cus" value="2" onclick="set_div(this.value)" /></td>					
						<th><strong><?PHP echo $Cus_CHKBOX_2; ?></strong></th>
					</tr>

				</tbody>
			</table>
			</fieldset>
			</div>
			<!--CHECKBOXES-->

			<div class="separador col-lg-12"></div> <!--SEPERADOR-->


				<!--INPUT CUSTOMER-->
				<div  class="col-lg-12" id="new_cus">
				<fieldset class="fieldsetform">
				<table class='table_form'>
					<tbody>
						<tr>
							<th><strong><?PHP echo $InputCust_1; ?></strong></th>
							<td><input type="text"  class="inputPage" id="cus_id" name="cus_id" required /></td>		
							<th><strong><?PHP echo $InputCust_2; ?></strong></th>
							<td><input type="text"  class="inputPage" id="cus_name" name="cus_name" required /></td>				
						</tr>
						<tr>
							<th><strong><?PHP echo $InputCust_3; ?></strong></th>
							<td><input type="text"  class="inputPage" id="cus_cel" name="cus_cel" required /></td>		
							<th><strong><?PHP echo $InputCust_4; ?></strong></th>
							<td><input type="text"  class="inputPage" id="cus_contact" name="cus_contact" required /></td>				
						</tr>
						<tr>
							<th><strong><?PHP echo $InputCust_5; ?></strong></th>
							<td><input type="text"  class="inputPage" id="cus_country" name="cus_country" required /></td>		
							<th><strong><?PHP echo $InputCust_6; ?></strong></th>
							<td><input type="text"  class="inputPage" id="cus_state" name="cus_state" /></td>				
						</tr>
						<tr>
							<th><strong><?PHP echo $InputCust_7; ?></strong></th>
							<td><input type="text"  class="inputPage" id="cus_city" name="cus_city" /></td>		
							<th><strong><?PHP echo $InputCust_8; ?></strong></th>
							<td><input type="text"  class="inputPage" id="cus_zip" name="cus_zip" /></td>				
						</tr>
						<tr>
							<th><strong><?PHP echo $InputCust_9; ?></strong></th>
							<td><input type="email"  class="inputPage" id="cus_email" name="cus_email" required /></td>		
							<th><strong><?PHP echo $InputCust_10; ?></strong></th>
							<td>
								<select  id="cus_PL" name="cus_PL" class="select col-lg-2" >
									<option value="0" selected>0</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
								</select>
							</td>				
						</tr>
						<tr>
							<th><strong><?PHP echo $InputCust_11; ?></strong></th>
							<td><input type="number" class="inputPage" id="cus_bal" name="cus_bal" value="0" /></td>		
							<th><strong><?PHP echo $InputCust_12; ?></strong></th>
							<td><input type="number" class="inputPage" id="cus_creditlimit" name="cus_creditlimit"  value="0"/></td>				
						</tr>
						<tr>
							<th><strong><?PHP echo $InputCust_13; ?></strong></th>
							<td><input type="text"  class="inputPage" id="cus_salesId" name="cus_salesId" required /></td>		
							<th><strong><?PHP echo $InputCust_14; ?></strong></th>
							<td><input type="text"  class="inputPage" id="cus_SalesName" name="cus_SalesName" required /></td>				
						</tr>
						<tr>
							<th><strong><?PHP echo $InputCust_15; ?></strong></th>
							<td><input type="text"  class="inputPage" id="cus_addres1" name="cus_addres1" required /></td>		
							<th><strong><?PHP echo $InputCust_16; ?></strong></th>
							<td><input type="text"  class="inputPage" id="cus_addres2" name="cus_addres2" /></td>				
						</tr>
					</tbody>
				</table>
				</fieldset>
				</div>
				<!--INPUT CUSTOMER-->

				
			    <div class="separador col-lg-12"></div> <!--SEPERADOR-->
				
					<!--INPUT FILE-->
				<div  class="col-lg-8" id="list_cus">
				<fieldset class="fieldsetform">				
					<table class='table_form'>
						<tbody>
							<tr>
								<th><strong><?PHP echo $InputCust_17; ?></strong></th>
								<td><input type="file" class="form-control" id="cus_file" name="cus_file" placeholder="<?PHP echo $InputCust_18; ?>" />	
						            <p class="help-block"><?PHP echo $Advice1; ?></p>
								</td>			
							</tr>
						</tbody>
					</table>
				</fieldset>									
				</div>
				<!--INPUT FILE-->


				<!--Button Process-->
				<div class='col-lg-8'></div>
				<div class='col-lg-2'>
					<div class="container-login100-form-btn">
					<input type="submit" class="accept-form-btn" name="submit"  value="<?PHP echo $BTN_add; ?>" />			
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
				<table id="table_customer" class="table table-striped responsive table-bordered" cellspacing="0" >
				<thead>
				<tr>
					<th width="5%"><?PHP echo $TableCust_th1; ?></th>
					<th width="20%"><?PHP echo $TableCust_th2; ?></th>
					<th width="10%"><?PHP echo $TableCust_th3; ?></th> 
					<th width="10%"><?PHP echo $TableCust_th4; ?></th>
					<th width="10%"><?PHP echo $TableCust_th5; ?></th>
					<th width="10%"><?PHP echo $TableCust_th6; ?></th>
					<th width="20%"></th>
				</tr>
				</thead>
			<tbody>

			<?php
				
				//ADD CUSTOMER

				if (isset($_POST['submit'])) {
					
					if ($_POST['chk_cus'] == 1) {
					
						
						$Values = array( 
									    'CustomerID' => $_POST['cus_id'],
									    'Customer_Bill_Name'  => $_POST['cus_name'],
									    'Phone_Number'=> $_POST['cus_cel'],
									    'Contact'  => $_POST['cus_contact'],
									    'Country'=> $_POST['cus_country'],
									    'State'=> $_POST['cus_state'],
									    'City'=> $_POST['cus_city'],
									    'Zip'=> $_POST['cus_zip'],
									    'Email'=> $_POST['cus_email'],
									    'PriceLevel'=> $_POST['cus_PL'],
									    'Balance'=> $_POST['cus_bal'],
									    'CreditLimit'=> $_POST['cus_creditlimit'],
									    'SalesRepID'=> $_POST['cus_salesId'],
									    'SalesRepName'=> $_POST['cus_SalesName'],
									    'AddressLine1'=> $_POST['cus_addres1'],
									    'AddressLine2'=> $_POST['cus_addres2'],
									    'ID_compania' => $this->model->id_compania);


						$Valid = $this->model->Query_value('Customers_Exp','CustomerID','where ID_compania="'.$this->model->id_compania.'" AND CustomerID ="'.$_POST['cus_id'].'" ORDER BY CustomerID DESC LIMIT 1');

						//VERIFICANDO QUE EL ID NO EXISTE PREVIAMENTE
						if (!$Valid) {
							
							$res = $this->model->insert('Customers_Exp',$Values);
							$this->CheckError();
							

							if ($this->model->lang == 'es') {
								
								
								echo "<script>$(window).load(function(){ MSG_CORRECT('El cliente ha sido creado con exito!',0); });</script>"; 

							}else{

								
								echo "<script>$(window).load(function(){ MSG_CORRECT('Customer has been successfuly created!',0); });</script>"; 

							}

						}else{

							if ($this->model->lang == 'es') {
								
								
								echo "<script>$(window).load(function(){ MSG_ERROR('El Id del cliente ya existe, por favor ingrese otro',0); });</script>"; 

							}else{

								
								echo "<script>$(window).load(function(){ MSG_ERROR('Customer Id already exist, please input a different value',0); });</script>"; 

							}

							

						}
					}else{


							try {
		

									//INI LECTURA DE ARCHIVO EXCEL
									$reader=new Spreadsheet_Excel_Reader();

									$filename=$_FILES["cus_file"]["tmp_name"]; 

									//	echo 'file:'.$filename;  var_dump($_FILES); die();

									if($_FILES["cus_file"]["size"] > 0)
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

												    

													foreach($data['cells'][$i] as $KEY=>$cell) 
													{
														   
									                        if($cell !=''){

									                   		if ($KEY=='1') { //CUSTOMER ID	

									                   			$values['1'] = utf8_encode($cell);
									                   			$cust_chk = $this->model->Query_value('Customers_Exp','CustomerID','where ID_compania="'.$this->model->id_compania.'" AND CustomerID ="'.$values['1'].'" ORDER BY CustomerID DESC LIMIT 1');

									                   			if (!$cust_chk) {
									                   				
									                   				$set_flag = 0; //CREATE BRAND NEW CUSTOMER

									                   			}else{

									                   				$set_flag = 1; //CUSTOMER ID EXIST. THIS FLAG SET UPDATE THAT ROW
									                   			}

									                   		} 


															if ($KEY=='2')   	$values['2'] = utf8_encode($cell) ; //CUSTOMER NAME
															if ($KEY=='3')   	$values['3'] = utf8_encode($cell) ; //CUSTOMER PHONE
															if ($KEY=='4')   	$values['4'] = utf8_encode($cell) ; //CUSTOMER CONTACT
															if ($KEY=='5')   	$values['5'] = utf8_encode($cell) ; //CUSTOMER COUNTRY
															if ($KEY=='6')   	$values['6'] = utf8_encode($cell) ; //CUSTOMER STATE
															if ($KEY=='7')   	$values['7'] = utf8_encode($cell) ; //CUSTOMER CITY
															if ($KEY=='8')   	$values['8'] = utf8_encode($cell) ; //CUSTOMER ZIP
															if ($KEY=='9')   	$values['9'] = utf8_encode($cell) ; //CUSTOMER EMAIL
															if ($KEY=='10')   	$values['10'] = utf8_encode($cell) ; //CUSTOMER PL
															if ($KEY=='11')   	$values['11'] = utf8_encode($cell) ; //CUSTOMER BALANCE
															if ($KEY=='12')   	$values['12'] = utf8_encode($cell) ; //CUSTOMER CREDIT LIMIT
															if ($KEY=='13')   	$values['13'] = utf8_encode($cell) ; //CUSTOMER SALES ID
															if ($KEY=='14')   	$values['14'] = utf8_encode($cell) ; //CUSTOMER SALES NAME
															if ($KEY=='15')   	$values['15'] = utf8_encode($cell) ; //CUSTOMER ADDRESS 1
															if ($KEY=='16')   	$values['16'] = utf8_encode($cell) ; //CUSTOMER ADDRESS 2    	

									                        }
													
												    }

												   $values['17'] = 1; //SET TO ACTIVE
												   $values['18'] = $this->model->id_compania;
												   $TABLE = 'Customers_Exp';

				                           
												   	if ($set_flag == 0) {
												   		
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

									                  	echo "<script>$(window).load(function(){ MSG_CORRECT('2 LA LISTA  SE HA CARGADO CON EXITO ',0); });</script>"; 

												   	}else{


												   		$clause = 'WHERE CustomerID ="'.$values['1'].'" AND  ID_compania="'.$this->model->id_compania.'";';

  														$update = $this->model->update($TABLE,$values,$clause);

												   	}

				                                }

												$i=$i+1;
									          }
								              
								              
											}//termina el proceso de insercion


										}else{

											echo "<script>$(window).load(function(){ MSG_ERROR('NO SE HA PODIDO LEER EL  ARCHIVO',0); });</script>"; 
											
										}


				} catch (Exception $e) {

					 die("<script>$(window).load(function(){ MSG_ERROR('".$e->getMessage()."',0); });</script>"); 
				}

					$_POST = array(); //limpia las variables de $_post
					$_FILES = array();


								}
							}


				//LIST EXISTING CUSTOMERS

				$clause.= 'WHERE ID_compania="'.$this->model->id_compania.'" AND IsActive =1'; 


				$cus = $this->getCustomerList('asc','10000',$clause);

				foreach ($cus as $value) {

				$value = json_decode($value);

				$cus_secID = "'".$value->{'ID'}."'";
				$cus_ID = "'".$value->{'CustomerID'}."'";
				$cus_name = "'".$value->{'Customer_Bill_Name'}."'";
				$cus_tlf = "'".$value->{'Phone_Number'}."'";
				$cus_contact = "'".$value->{'Contact'}."'";
				$cus_country = "'".$value->{'Country'}."'";
				$cus_state = "'".$value->{'State'}."'";
				$cus_city = "'".$value->{'City'}."'";
				$cus_zip = "'".$value->{'Zip'}."'";
				$cus_email = "'".$value->{'Email'}."'";
				$cus_pl = "'".$value->{'PriceLevel'}."'";
				$cus_balance = "'".$value->{'Balance'}."'";
				$cus_CL = "'".$value->{'CreditLimit'}."'";
				$cus_acct = "'".$value->{'SalesRepID'}."'";
				$cus_salesRep = "'".$value->{'SalesRepName'}."'";
				$cus_BA = "'".$value->{'AddressLine1'}."'";
				$cus_SA = "'".$value->{'AddressLine2'}."'";


				$table .= ' <tr>
								<td><a href="javascript:void(0)" onclick="get_cus_detail('.$cus_secID.')"><strong>'.$value->{'CustomerID'}.'</strong></a></td>
								<td>'.$value->{'Customer_Bill_Name'}.'</td>
								<td>'.$value->{'Phone_Number'}.'</td>
								<td>'.$value->{'Contact'}.'</td>
								<td>'.$value->{'Country'}.'</td>
								<td>'.$value->{'Email'}.'</td>
								<td><a  href="javascript:void(0)" onclick="del_cus('.$cus_ID.')"><input type="button" id="modal_del" name="modal_del" class="btn btn-danger btn-sm btn-icon icon-left" value="'.$BTN_del.'" /></a><a  href="javascript:void(0)" onclick="set_cus_info('.$cus_ID.','.$cus_name.','.$cus_tlf.','.$cus_contact.','.$cus_country.','.$cus_state.','.$cus_city.','.$cus_zip.','.$cus_email.','.$cus_pl.','.$cus_balance.','.$cus_CL.','.$cus_acct.','.$cus_salesRep.','.$cus_BA.','.$cus_SA.')"><input id="modal_mod" name="modal_mod" data-toggle="modal" data-target="#cust_mod" type="button" class="btn btn-warning btn-sm btn-icon icon-left"  value="'.$BTN_mod.'" /></a></td>
							</tr>';

				}
			
				echo $table;



//SE EJECUTA SCRIPT PHP SI SE DÁ SUBMIT AL BOTON "SUBIR"
if (isset($_POST['submit'])){



}

			?>
            </tbody></table>

            <div class="separador col-lg-12"></div>
            <div class="col-lg-6" > 
            <div id="table_det"></div>
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
<div id="cust_mod" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <span class="modal-header" ><?PHP echo $MODAL_head; ?></span>
	  </div>
	  <form method="POST"  action="" class="login100-form validate-form p-l-25 p-r-25 p-t-60" enctype="multipart/form-data">


      <div class="col-lg-12 modal-body">
        
      <div id='prod'></div>

        <div class="col-lg-8" > 
             <label class="control-label"><?PHP echo $ModalInput_1; ?></label>
             <input  class="form-control" id="cus_modal_id" name="cus_modal_id"  readonly/>
 			 <label class="control-label"><?PHP echo $ModalInput_2; ?></label>
             <input  class="form-control" id="cus_modal_name" name="cus_modal_name"/>
        </div>
        
        <div class="col-lg-8" > 
             <label class="control-label"><?PHP echo $ModalInput_3; ?></label>
             <input  class="form-control" id="cus_modal_telf" name="cus_modal_telf" />
 			 <label class="control-label"><?PHP echo $ModalInput_4; ?></label>
             <input  class="form-control" id="cus_modal_contact" name="cus_modal_contact"/>
        </div>
         <div class="col-lg-8" > 
             <label class="control-label"><?PHP echo $ModalInput_5; ?></label>
             <input  class="form-control" id="cus_modal_country" name="cus_modal_country" />
 			 <label class="control-label"><?PHP echo $ModalInput_6; ?></label>
             <input  class="form-control" id="cus_modal_state" name="cus_modal_state"/>
        </div>
         <div class="col-lg-8" > 
             <label class="control-label"><?PHP echo $ModalInput_7; ?></label>
             <input  class="form-control" id="cus_modal_city" name="cus_modal_city" />
 			 <label class="control-label"><?PHP echo $ModalInput_8; ?></label>
             <input  class="form-control" id="cus_modal_zip" name="cus_modal_zip"/>
        </div>
         <div class="col-lg-8" > 
             <label class="control-label"><?PHP echo $ModalInput_9; ?></label>
             <input  class="form-control" id="cus_modal_email" name="cus_modal_email" />
 			 <label class="control-label"><?PHP echo $ModalInput_10; ?></label>
             <select  id="cus_modal_pl" name="cus_modal_pl" class="select col-lg-12" >
									<option value="0">0</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
			 </select>
        </div>
         <div class="col-lg-8" > 
             <label class="control-label"><?PHP echo $ModalInput_11; ?></label>
             <input  class="form-control" id="cus_modal_balance" name="cus_modal_balance" />
 			 <label class="control-label"><?PHP echo $ModalInput_12; ?></label>
             <input  class="form-control" id="cus_modal_creditLimit" name="cus_modal_creditLimit"/>
        </div>
         <div class="col-lg-8" > 
             <label class="control-label"><?PHP echo $ModalInput_13; ?></label>
             <input  class="form-control" id="cus_modal_AcctId" name="cus_modal_AcctId" />
 			 <label class="control-label"><?PHP echo $ModalInput_14; ?></label>
             <input  class="form-control" id="cus_modal_SalesRep" name="cus_modal_SalesRep"/>
        </div>

        <div class="col-lg-8" > 
             <label class="control-label"><?PHP echo $ModalInput_15; ?></label>
             <input  class="form-control" id="cus_modal_BillingAddr" name="cus_modal_BillingAddr" />
 			 <label class="control-label"><?PHP echo $ModalInput_16; ?></label>
             <input  class="form-control" id="cus_modal_ShippingAddr" name="cus_modal_ShippingAddr"/>
        </div>
        

    <div class="col-lg-12" ></div>    
      </div>
      <div class="modal-footer">
	  <div class="col-lg-4" ></div>  
		<div class="col-lg-4" >
		<button type="button" onclick="mod_cus();" class="btn btn-primary" data-dismiss="modal"><?PHP echo $BTN_mod; ?></button>
		</div>
		<div class="col-lg-4" >
		<button type="button" class="btn btn-default" data-dismiss="modal"><?PHP echo $BTN_close; ?></button>
		</div>    
      </div>
    </div>
	</form>
  </div>
</div>

<div class="separador col-lg-12"></div>


</div>