<!--header -->
<div class="pages">
<div data-page="form" class="page no-toolbar no-navbar">
  <div class="page-content">
  
  <div class="navbarpages navbarpagesbg"> 
  <div class="navbar_left">
     <div class="logo_text">
     <a  class="navbar-brand" onClick="history.go(-1); return true;" ><i  class="fas fa-chevron-circle-left" >   </i></a> 
     <!-- <a href="<?php echo URL; ?>index.php?url=home/index">ACIWEB</a> -->
      </div>    
   </div>
     <!--<div class="navbar_right navbar_right_menu">
                <a href="#" data-panel="left" class="open-panel"><img src="i<?php echo URL; ?>assets/mages/icons/white/menu.png" alt="" title="" /></a>
          </div>	-->		
      <div class="navbar_right">
       <a href="#" data-panel="right" class="open-panel"><img src="<?php echo URL; ?>assets/images/icons/white/user.png" alt="" title="" /></a>
      </div>
      
  </div>
<!--header -->

<div id="pages_maincontent">
    
  <h2 class="page_title">Historial de pedidos</h2> 
     
    <div class="page_single layout_fullwidth_padding">
              
              <div class="contactform">

              <div class="form_row">
                <label>Fecha Inicio:</label>
                <input type="text" name="FechaI" value="" class="form_input required" id="date1" />
                <label>Fecha Fin:</label>
                <input type="text" name="FechaF" value="" class="form_input required" id="date2" />
                </div>
              
               
               <div class="form_row">
                 <input onclick='Filtrar();' type="submit" name="submit" class="form_submit" id="submit" value="Consultar" />
               </div>
               </div>

               <p></p>
               
               <!--INI PRINT TABLE-->
                  <div id="SOtable" ></div>
               <!--END PRINT TABLE-->


    </div>
</div>
              


