

<!--ini aqui va el menu de acceso rapido-->
<fieldset class="fieldsetDash">

<div class="tab">


<fieldset class="fieldsetform">
    <table class='table_form' >
        <tbody>
            <tr><th><button class="tablinks" onclick="openCity(event, 'Config1')" id="ConfigOpen"><i class="fas fa-building fa-2x icon-color-dash" > </i> &nbsp;&nbsp; <?php echo $config_menu_1; ?></button></th></tr>
            <tr><th><button class="tablinks" onclick="openCity(event, 'Config2')"><i class="fas fa-users fa-2x icon-color-dash" > </i> &nbsp;&nbsp;<?php echo $config_menu_2; ?></button></th></tr>
            <tr><th><button class="tablinks" onclick="openCity(event, 'Config3')"><i class="fas fa-file-alt fa-2x icon-color-dash" > </i> &nbsp;&nbsp;<?php echo $config_menu_3; ?></button></th></tr>			
            <tr><th><button class="tablinks" onclick="openCity(event, 'Config4')"><i class="fas fa-server fa-2x icon-color-dash" > </i> &nbsp;&nbsp;<?php echo $config_menu_4; ?></button></th></tr>
            <tr><th><button class="tablinks" onclick="openCity(event, 'Config5')"><i class="fas fa-cubes fa-2x icon-color-dash" > </i> &nbsp;&nbsp;<?php echo $config_menu_5; ?></button></th></tr>
            <tr><th><button class="tablinks" onclick="openCity(event, 'Config6')"><i class="fas fa-balance-scale fa-2x icon-color-dash" > </i> &nbsp;&nbsp;<?php echo $config_menu_6; ?></button></th></tr>
            <tr><th><button class="tablinks" onclick="openCity(event, 'Config8')"><i class="fas fa-desktop fa-2x icon-color-dash" > </i> &nbsp;&nbsp;<?php echo $config_menu_8; ?></button></th></tr>					
            <tr><th><button class="tablinks" onclick="openCity(event, 'Config9')"><i class="fas fa-database fa-2x icon-color-dash" > </i> &nbsp;&nbsp;<?php echo $config_menu_9; ?></button></th></tr>
            <tr><th><button class="tablinks" onclick="openCity(event, 'Config10')"><i class="fas fa-chart-line fa-2x icon-color-dash" > </i> &nbsp;&nbsp;<?php echo $config_menu_10; ?></button></th></tr>					  											  			
        </tbody>
    </table>
</fieldset>

</div>
            
<div id="Config1" class="tabcontent">
    <div class='col-lg-12'>
    <!--INI MENU COMPANIA-->
    <fieldset >
	  <legend><?php echo $config_1_title; ?></legend> 
		<form action="" role="form" class="form-horizontal" enctype="multipart/form-data" method="post" >
		<input type="hidden" id="comp" name="comp" value="1" />
		<div class='col-lg-8'>
			<fieldset class="fieldsetform">
			<table class="table_form">
				<tbody>
					<tr><th><strong><?php echo $config_1_val1; ?></strong></th><td><input type="text"  class="inputPage col-lg-12"  id="company" name="company"  value="<?php echo $name; ?>" /></td></tr>
					<tr><th><strong><?php echo $config_1_val2; ?></strong></th><td><input type="text"  class="inputPage col-lg-12" id="address" name="address" value="<?php echo $address; ?>"  /></td></tr>
					<tr><th><strong><?php echo $config_1_val3; ?></strong></th><td><input type="email" class="inputPage col-lg-12" id="email_contact" name="email_contact" value="<?php echo $email; ?>" /></td></tr>
					<tr><th><strong><?php echo $config_1_val4; ?></strong></th><td><input type="text"  class="inputPage col-lg-12" id="tel1" name="tel1" value="<?php echo $tel; ?>"></td></tr>
					<tr><th><strong><?php echo $config_1_val5; ?></strong></th><td><input type="text"  class="inputPage col-lg-12" id="tel2" name="tel2" value="<?php echo $fax; ?>"></td></tr>
					<tr><th><strong><?php echo $config_1_val6; ?></strong></th>
					<td>
					<select  id="lang" name="lang" class="select col-lg-12">
						<option <?php if ($lang == null){echo 'selected disable';} ?>></option>
						<option value="es" <?php if ($lang == 'es'){echo 'selected';} ?>><?php echo $config_1_val7; ?></option>
						<option value="en" <?php if ($lang == 'en'){echo 'selected';} ?>><?php echo $config_1_val8; ?></option>
					</select>
					</td></tr>		
				</tbody>
			</table>
			</fieldset>	
		</div>	
		<div class='separador col-lg-12'></div>					
		<div class='col-lg-8'></div>					
		<div class="form-group col-lg-3">
		<input type="submit" name="" class="accept-form-btn" value="Guardar">
		</div>
		</form>
										
		 </fieldset>
    <!--END MENU COMPANIA-->
    </div>
</div>

<div id="Config2" class="tabcontent">
    <div class='col-lg-12'>
	<!--INI MENU USERS-->
	<fieldset >	
		<legend><?php echo $config_2_title; ?></legend>
		
		<form action="" enctype="multipart/form-data" method="post" role="form" class="form-horizontal">
		<input type="hidden" id="Adduser" name="Adduser" value="1" />

	    <div class="col-lg-8" >
			<fieldset class="fieldsetform" >	
			<table class="table_form">
			<tbody>
				<tr><th><strong><?php echo $config_2_val1; ?></strong></th><td><input type="text"  class="inputPage col-lg-12"  id="name" name="name"  required /></td></tr>
				<tr><th><strong><?php echo $config_2_val2; ?></strong></th><td><input type="text" class="inputPage col-lg-12"  id="lastname" name="lastname"  required//></td></tr>
				<tr><th><strong><?php echo $config_2_val3; ?></strong></th><td><input type="email" class="inputPage col-lg-12" id="mail"   name="mail"  required /></td></tr>
				<tr><th><strong><?php echo $config_2_val4; ?></strong></th><td><input type="password" class="inputPage col-lg-12"  id="pass_1" name="pass_1" required></td></tr>
				<tr><th><strong><?php echo $config_2_val5; ?></strong></th><td><input type="password" class="inputPage col-lg-12"  id="pass_2" name="pass_2" required/></td></tr>
				<tr><th><strong><?php echo $config_2_val6; ?></strong></th><td>
					<select class="inputPage col-lg-12" id="role" name="role">
						<option value="admin" ><?php echo $config_2_val7; ?></option>
						<option value="user" ><?php echo $config_2_val8; ?></option>
					</select>
				</td></tr>  
				</tbody>
			</table>	

			<div class="separador col-lg-12"></div>
			<div class="col-lg-10"></div>
			<div class="col-lg-2">
			<input type="submit" name="" class="accept-form-btn" value="Guardar">
			</div>
			</fieldset>
		</div>	
	
		</form>
		<div class='separador col-lg-12'></div>
		
		<fieldset lass="fieldsetform">
		<table id="userList" width='100%' class="table table-striped table-bordered" cellspacing="0"  >
		<thead>
		<tr>
			<th width="10%"><?php echo $config_3_val1; ?></th>
			<th width="10%"><?php echo $config_3_val2; ?></th>
			<th width="30%"><?php echo $config_3_val3; ?></th>
			<th width="10%"><?php echo $config_3_val4; ?></th>
			<th width="20%"><?php echo $config_3_val5; ?></th>
			<th width="10%"></th>
		</tr>
		</thead>
		<tbody>
			<?php $this->getUserlist(); ?>
		</tbody>
		</table>
		</fieldset >
		<div class='separador col-lg-12'></div>

	</fieldset >
	<!--INI MENU USERS-->		
	</div>
</div>	





<div id="Config3" class="tabcontent">		
<!--CONFIGURACION DE DETALLES FACTURAS RECIBOS -->
<div class="col-lg-12" >
<fieldset>
	<legend><?php echo $config_23_title; ?></legend> 

	<!-- General -->
	<form action="" role="form" class="form-horizontal" enctype="multipart/form-data" method="POST">	
	<input type="hidden" id="fact_detail_set" name="fact_detail_set" value="1" />

	<div class="col-lg-12" >
		<fieldset class="fieldsetform"  >
		<h4><?php echo $config_24_title; ?></h4> 
		<div class='separador col-lg-12'></div>
				<table class="table_form">
				<tbody>
					<tr><th><strong><?php echo $config_14_val1; ?></strong></th><td><input type="text" class="inputPage col-lg-2 numb"  name="fact_no_line"  value="<?php echo $NO_LINES; ?>" /><p class='help-block'><?php echo $config_14_val4; ?></p></td></tr>
					<tr><th><strong><?php echo $config_14_val2; ?></strong></th><td><input type="text" class="inputPage col-lg-2"  name="customField" value="<?php echo $customField; ?>" /><p class='help-block'><?php echo $config_14_val5; ?></p></td></tr>
					<tr><th><strong><?php echo $config_14_val3; ?></strong></th><td><textarea  class="textareaPage col-lg-12"  row='3' type="text" name="filterField" /><?php echo $filterField; ?></textarea></td></tr>
					<tr><th></th><td><p class='help-block'><?php echo $config_14_val6; ?></p></td></tr>                        
				</tbody>
			</table> 

	<div class="separador col-lg-12" ></div>
	   

	<div class="col-lg-10"></div>
		<div class=" col-lg-2">
		<input type="submit" class="accept-form-btn"  value="Guardar"  />
	</div>

	</fieldset > 
	</div>
	</form>
	<!-- General -->
	
	<div class="separador col-lg-12"></div>

	<!-- TAX -->
	<div class="col-lg-6" >
		<form action="" role="form" class="form-horizontal" enctype="multipart/form-data" method="POST">
		<input type="hidden" id="addTax" name="addTax" value="1" />
			<fieldset class="fieldsetform"  >
			<h4><?php echo $config_25_title; ?></h4> 
			<div class='separador col-lg-12'></div>
				<table class="table_form">
					<tbody>
					    <tr>
					       <th><strong><?php echo $config_14_val7; ?></strong></th>
						   <th><strong><?php echo $config_14_val8; ?></strong></th>
						
						</tr>
						<tr>
							<td><input type="text" class="inputPage col-lg-4"  id="idtax" name="idtax" required/></td>
							<td><input type="text" class="inputPage col-lg-4"  id="porc" name="porc"  placeholder="0.00" required /></td>
						
						</tr>

					</tbody>
				</table> 
				 <div class="separador col-lg-12" ></div>  
                   
				<div class="col-lg-8"></div>
				<div class=" col-lg-4">
				<input type="submit" class="close-form-btn"  value="Agregar"  />
			   </div>
			
			
			<div class="separador col-lg-12"></div>
			<fieldset class="fieldsetform"  >
			<table class="table_form">
				<tbody>
				<?php echo $table; ?>
				</tbody>
			</table> 
			</fieldset > 

			</fieldset > 
		</form> 
	</div>
	<!-- TAX -->

	<!-- PAY TERM -->
	<div class="col-lg-6" >
		<form action="" role="form" class="form-horizontal" enctype="multipart/form-data" method="POST">
		<input type="hidden" id="addTerm" name="addTerm" value="1" />

			<fieldset class="fieldsetform"  >
			<h4><?php echo $config_26_title; ?></h4> 
			<div class='separador col-lg-12'></div>
				<table class="table_form">
					<tbody>

				        <tr>
					       <th><strong><?php echo $config_14_val11; ?></strong></th>
						   <th><strong><?php echo $config_14_val12; ?></strong></th>
						   <th><strong><?php echo $config_14_val13; ?></strong></th>
						</tr>
						<tr>
							<td><input type="text" class="inputPage col-lg-12 numb"  id="termId" name="termId" required/></td>
							<td>
								<select id="termType" name="termType" required="">
									<option value="1"><?php echo $config_14_val14; ?></option>
									<option value="2"><?php echo $config_14_val15; ?></option>
								</select>
						    </td>
							<td><input type="text" class="inputPage col-lg-12" id="termDesc" name="termDesc"  required /></td>
						</tr>
				  </tbody>
				</table> 
				<div class="separador col-lg-12" ></div>

				<div class="col-lg-8"></div>
				<div class=" col-lg-4">
				<input type="submit" class="close-form-btn"  value="Agregar"  />
			   </div>
			
			
			<div class="separador col-lg-12"></div>
			<fieldset class="fieldsetform"  >
			<table class="table_form">
				<tbody>
				 <?php echo $termTbl; ?>
				</tbody>
			</table> 
			</fieldset > 

			</fieldset > 
		</form> 
	</div>
	<!-- PAY TERM -->
	<div class="separador col-lg-12"></div>	
	<!-- PRINTER -->
	<div class="col-lg-6" >
		<form action="" role="form" class="form-horizontal" enctype="multipart/form-data" method="POST">
		<input type="hidden" id="addPrint" name="addPrint" value="1" />

			<fieldset class="fieldsetform"  >
			<h4><?php echo $config_27_title; ?></h4> 
			<div class='separador col-lg-12'></div>
				<table class="table_form">
					<tbody>
						<tr>
						<th><strong><?php echo $config_14_val16; ?></strong></th>
						<th><strong><?php echo $config_14_val17; ?></strong></th>
						<th></th>						
						<tr>
						<tr>
							<td><input type="text" class="inputPage col-lg-12"  id="serial" name="serial" required/></td>
							<td><input type="text" class="inputPage col-lg-12"  id="printdesc" name="printdesc" required/></td>
							<td><input type="submit"  value="Agregar" class="close-form-btn"  /></td>
					    </tr>
					 </tbody>
				</table> 
				<div class="separador col-lg-12" ></div>

				<fieldset class="fieldsetform"  >
				<table class="table_form">
					<tbody>
					<?php echo $table2; ?>
					</tbody>
				</table> 
				</fieldset > 

			</fieldset > 
		</form> 
	</div>
	<!-- PRINTER-->

 <div class="separador col-lg-12"></div>	
 </fieldset> 
</div>

<!--CONFIGURACION DE DETALLES FACTURAS RECIBOS -->
</div>

<div id="Config4" class="tabcontent">
<!--CONFIGURACION DE CORREO SMTP-->
    <div class="col-lg-12" >
        <fieldset  >
        <legend><?php echo $config_20_title; ?></legend> 

		<fieldset  >
        <form action="" role="form" class="form-horizontal" enctype="multipart/form-data" method="POST">	
        <input type="hidden" id="smtp" name="smtp" value="1" />

        <div class="col-lg-6" >
            <fieldset class="fieldsetform"  >
            <h4><?php echo $config_21_title; ?></h4> 
                    <table class="table_form">
                    <tbody>
                        <tr><th><strong><?php echo $config_13_val1; ?></strong></th><td><input type="text" class="inputPage col-lg-12"  id="emailhost"   name="emailhost"  value="<?php echo $hostname; ?>"  required /></td></tr>
                        <tr><th><strong><?php echo $config_13_val2; ?></strong></th><td><input type="text" class="inputPage col-lg-4 numb" id="emailport"   name="emailport"   value="<?php echo $emailport; ?>" required /></td></tr>
                        <tr><th><strong><?php echo $config_13_val3; ?></strong></th><td><input type="text" class="inputPage col-lg-12"  id="emailusername"   name="emailusername" value="<?php echo $emailusername; ?>"  required /></td></tr>
                        <tr><th><strong><?php echo $config_13_val4; ?></strong></th><td><input type="password" class="inputPage col-lg-12"  id="emailpass"   name="emailpass"   value="<?php echo $emailpass; ?>" required /></td></tr>           
                        <tr><th><strong><?php echo $config_13_val6; ?></strong></th><td><input type="text" class="inputPage col-lg-12"  id="Auth"   name="Auth"   value="<?php echo $Auth; ?>" required /></td></tr>           
                        <tr><th><strong><?php echo $config_13_val7; ?></strong></th><td><input type="text" class="inputPage col-lg-12"  id="Secure"   name="Secure"   value="<?php echo $Secure; ?>" required /></td></tr>           
                        <tr><th><strong><?php echo $config_13_val8; ?></strong></th><td><input type="text" class="inputPage col-lg-12"  id="Debug"   name="Debug"   value="<?php echo $Debug; ?>" required /></td></tr>           					
					</tbody>
                </table> 
            </fieldset > 
        </div>
    
        <div class="col-lg-8"></div>
            <div class=" col-lg-2">
            <input type="submit" class="accept-form-btn"  value="Guardar"  />
		</div>
		<div class="separador col-lg-12"></div>
		</form>
	
		</fieldset>

		<div class="separador col-lg-12"></div>
		

        <div class="col-lg-8" >
            <fieldset class="fieldsetform"  >
				<h4><?php echo $config_22_title; ?></h4>
                <table class="table_form">
                    <tbody>
                    <tr>
                    <td><input class="inputPage col-lg-12" name="emailtest" id="emailtest" type="email" value="<?php echo  $this->model->active_user_email;  ?>" required/></td>
					<th><input type="button" onclick="javascript: send_test(); return false;" class="close-form-btn"  id="testmail" name="testmail" value="<?php echo $config_13_val5; ?>"></th></tr>
				</tbody>
                </table> 
            </fieldset > 
        </div>
		<div class="separador col-lg-12"></div>
        <div class="col-sm-12" id='notificacion'></div>
		<div class="separador col-lg-12"></div>
    </fieldset > 
    </div>	
<!--CONFIGURACION DE CORREO SMTP-->
</div>

<div id="Config5" class="tabcontent">
    <!--INI MENU MODULOS-->
    <div class='col-lg-12'>
	<form action="" role="form" class="form-horizontal" enctype="multipart/form-data" method="POST">	
	<input type="hidden"  name="mod" value="1"  />

		<div class="col-lg-12" >
			<fieldset  >
			<legend><?php echo $config_18_title; ?></legend> 
			<div class="col-lg-6" >
			<fieldset class="fieldsetform"  >
			<h4><?php echo $config_19_title; ?></h4> 
			<div class="separador col-lg-12"></div>
			
					<table class="table_form">
					<tbody>
					<tr><th><strong><?php echo $config_12_val1; ?></strong></th><td><input type="CHECKBOX" name="mod_sales" <?php echo  $mod_sales_CK; ?> /></td></tr>
					<tr><th><strong><?php echo $config_12_val2; ?></strong></th><td><input type="CHECKBOX" name="mod_invo"  <?php echo  $mod_invo_CK; ?> /></td></tr>
					<tr><th><strong><?php echo $config_12_val3; ?></strong></th><td><input type="CHECKBOX" name="mod_fact"  <?php echo  $mod_fact_CK; ?> /></td></tr>
					<tr><th><strong><?php echo $config_12_val4; ?></strong></th><td><input type="CHECKBOX" name="mod_invt"  <?php echo  $mod_invt_CK; ?> /></td></tr>           
					<tr><th><strong><?php echo $config_12_val5; ?></strong></th><td><input type="CHECKBOX" name="mod_req"   <?php echo  $mod_req_CK;  ?> /></td></tr>        
					<tr><th><strong><?php echo $config_12_val6; ?></strong></th><td><input type="CHECKBOX" name="mod_rept"  <?php echo  $mod_rept_CK; ?> /></td></tr>                   
					<tr><th><strong><?php echo $config_12_val7; ?></strong></th><td><input type="CHECKBOX" name="mod_stock" <?php echo  $mod_stoc_CK; ?> /></td></tr>                   
					<tr><th><strong><?php echo $config_12_val8; ?></strong></th><td><input type="CHECKBOX" name="mod_cust"  <?php echo  $mod_cust_CK; ?> /></td></tr>                                              
				</tbody>
				</table> 
			</fieldset > 
		</div>
	
		<div class="col-lg-8"></div>
			<div class=" col-lg-2">
			<input type="submit" class="accept-form-btn"  value="Guardar"  />
		</div>
		<div class="separador col-lg-12"></div>
		
		</fieldset > 
		</div >
	</form>
    </div>
    <!--INI MENU MODULOS-->
</div>

<div id="Config6" class="tabcontent">
    <!--INI CTAS GL-->
    <div class='col-lg-12'>
		<form action="" role="form" class="form-horizontal" enctype="multipart/form-data" method="POST">	
		<input type="hidden"  name="CTAS_GL" value="1"  />

			<div class="col-lg-12" >
				<fieldset  >
					<legend><?php echo $config_16_title; ?></legend> 
					<div class="col-lg-6" >
					<fieldset class="fieldsetform"  >
					<h4><?php echo $config_17_title; ?></h4> 
							<table class="table_form">
							<tbody>
							<tr><th><strong><?php echo $config_11_val1; ?></strong></th><td><input type="text"  class="inputPage col-lg-12 numb"  name="cta_gl_cxp" id="cta_gl_cxp" onkeyup="check_num(this.value,'cta_gl_cxp');"  value="<?php echo $CTA_CXP; ?>" /></td></tr>
							<tr><th><strong><?php echo $config_11_val2; ?></strong></th><td><input type="text"  class="inputPage col-lg-12 numb"  name="cta_gl_pur" id="cta_gl_pur" onkeyup="check_num(this.value,'cta_gl_pur');"   value="<?php echo $CTA_PUR; ?>" /></td></tr>
							<tr><th><strong><?php echo $config_11_val3; ?></strong></th><td><input type="text"  class="inputPage col-lg-12 numb"  name="cta_gl_tax" id="cta_gl_tax" onkeyup="check_num(this.value,'cta_gl_tax');"  value="<?php echo $CTA_TAX; ?>"  /></td></tr>
							<tr><th><strong><?php echo $config_11_val4; ?></strong></th><td><input type="text"  class="inputPage col-lg-12 numb"  name="Glacct"  id="Glacct"   onkeyup="check_num(this.value,'Glacct');"  value="<?php echo $CTA_GLACCT; ?>" /></td></tr>           
							<tr><th><strong><?php echo $config_11_val5; ?></strong></th><td><input type="text"  class="inputPage col-lg-12 numb"  name="ARACNT"  id="ARACNT"  onkeyup="check_num(this.value,'ARACNT');"  value="<?php echo $CTA_ARACNT; ?>"/></td></tr>        
							<tr><th><strong><?php echo $config_11_val6; ?></strong></th><td><input type="text"  class="inputPage col-lg-12 numb"  name="ctadev"  id="ctadev"  onkeyup="check_num(this.value,'ctadev');"  value="<?php echo $CTA_DEV; ?>" /></td></tr>                   
							<tr><th><strong><?php echo $config_11_val7; ?></strong></th><td><input type="text"  class="inputPage col-lg-12 numb"  name="GL_RETEN"  id="GL_RETEN"  onkeyup="check_num(this.value,'GL_RETEN');"  value="<?php echo $GL_RETEN; ?>" /></td></tr>                   
									
						</tbody>
						</table> 
					</fieldset > 
				</div>
				

				<div class="col-lg-8"></div>
					<div class=" col-lg-2">
					<input type="submit" class="accept-form-btn"  value="Guardar"  />
				</div>
				<div class="separador col-lg-12"></div>

				</fieldset > 
			</div >
		</form>
		
    </div>
   <!--END CTAS GL-->
</div>



<div id="Config8" class="tabcontent">
	<!--INI LOGS-->
	
	<div class="col-lg-12" >
	<fieldset  >
	<legend><?php echo $config_15_title; ?></legend>

	    <div class="separador col-lg-12"></div>
		<div class="col-lg-12" >
		<fieldset class="fieldsetform"  >
		<h4><?php echo $config_13_title; ?></h4> 
				<table class="table_form">
				<tbody>
				<tr><th><strong><button class="tablinks" onclick="ShowLog();"><i class="fas fa-file-medical-alt fa-2x" ></i>&nbsp;&nbsp;<?php echo $config_10_val1; ?></button></strong></th>
				<td><div id ="logView" class="logWindow col-lg-12" ></div></td></tr>

				</tbody>
			</table> 
			</fieldset > 
		</div>
        <div class="separador col-lg-12"></div>
		<div class="col-lg-12" >
		<fieldset class="fieldsetform"  >
		<h4><?php echo $config_14_title; ?></h4> 
				<table class="table_form">
				<tbody>
				<tr><th><strong><button class="tablinks" onclick="ShowLogBD();"><i class="fas fa-file-medical-alt fa-2x"></i>&nbsp;&nbsp;<?php echo $config_10_val2; ?></button></strong></th>
				<td> <div id ="logViewBD" class="logWindow col-lg-12" ></div></td></tr>
				</tbody>
			</table> 
		</fieldset > 
		</div>
        <div class="separador col-lg-12"></div>

	</fieldset > 
    </div >
   <!--END MENU LOGS-->
</div>

<div id="Config9" class="tabcontent">
    <!--INI BD CONFIG-->
    <div class='col-lg-12'>
	<form action="" role="form" class="form-horizontal" enctype="multipart/form-data" method="POST">	
	<input type="hidden"  name="saveDB" value="1"  />

	<div class="col-lg-12" >
	<fieldset  >
	<legend><?php echo $config_11_title; ?></legend> 
	<div class="col-lg-6" >
		<fieldset class="fieldsetform"  >
		<h4><?php echo $config_12_title; ?></h4> 
			<table class="table_form">
			<tbody>
			<tr><th><strong><?php echo $config_9_val1; ?></strong></th><td><input type="text" class="inputPage col-lg-12" id="host" name="host" value="<?php echo DB_HOST; ?>" <?php echo $edit; ?>/></td></tr>
			<tr><th><strong><?php echo $config_9_val2; ?></strong></th><td><input type="text" class="inputPage col-lg-12"  id="dbname" name="dbname" value="<?php echo DB_NAME; ?>" <?php echo $edit; ?>></td></tr>
			<tr><th><strong><?php echo $config_9_val3; ?></strong></th><td><input type="text" class="inputPage col-lg-12"  id="user" name="user" value="<?php echo DB_USER; ?>"  <?php echo $edit; ?>/></td></tr>
			<tr><th><strong><?php echo $config_9_val4; ?></strong></th><td><input type="password" class="inputPage col-lg-12"  id="pass" name="pass" value="<?php echo DB_PASS; ?>"   <?php echo $edit; ?>/></td></tr>           
			<tr><th><strong><?php echo $config_9_val5; ?></strong></th><td><input type="text" class="numb inputPage col-lg-4"  id="UTC" name="UTC" value="<?php echo UTC; ?>"  <?php echo $edit; ?>/></td></tr>                   
		</tbody>
		</table> 
	</fieldset > 
	</div>


	<div class="col-lg-8"></div>
	<div class=" col-lg-2">
	<input type="submit" class="accept-form-btn"  value="Guardar"  />
	</div>
	<div class="separador col-lg-12"></div>
	
	</form>   
	
	</fieldset > 
	</div >
    </div>
   <!--END MENU BD CONFIG-->
</div>


<div id="Config10" class="tabcontent">
	<!--INI LOGS-->
    <form action="" role="form" class="form-horizontal" enctype="multipart/form-data" method="POST">	
	<input type="hidden"  name="sage50" value="1"  />
	
	<div class='col-lg-12'>
	<fieldset >
	<legend><?php echo $config_9_title; ?></legend> 
	
		<div class="col-lg-6" >
		<fieldset class="fieldsetform"  >
		<h4><?php echo $config_10_title; ?></h4> 
				<table class="table_form">
				<tbody>
					<tr><th><strong><?php echo $config_8_val1; ?></strong></th>
					<td>
					<select  id="conn_sage" name="conn_sage" class="select col-lg-12">
						<option <?php if ($Sage_Conn == null){echo 'selected disable';} ?>></option>
						<option value="0" <?php if ($Sage_Conn == 0){echo 'selected';} ?>><?php echo $config_8_val2; ?></option>
						<option value="1" <?php if ($Sage_Conn == 1){echo 'selected';} ?>><?php echo $config_8_val3; ?></option>
						<option value="9" <?php if ($Sage_Conn == 9){echo 'selected';} ?>><?php echo $config_8_val4; ?></option>
					</select>
					</td></tr>
				</tbody>
			</table> 
		</fieldset > 
	</div >
	<div class="separador col-lg-12"></div>

	<div class='col-lg-8'></div>					
		<div class="form-group col-lg-3">
		<input type="submit" name="" class="accept-form-btn" value="Guardar">
	</div>

    </fieldset > 
	</div>
	</form>
   <!--END MENU LOGS-->
</div>



</fieldset>