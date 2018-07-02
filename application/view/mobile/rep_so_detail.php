
     
     <div id="pages_maincontent">
     
              <!--<h2 class="page_title">Order: <?php echo $so_number; ?></h2>-->
     
     <div class="page_single layout_fullwidth_padding">
              
              <h3>Detalle de la Orden</h3>

<?php



      foreach ($ORDER_detail as $datos) {

        $ORDER_detail = json_decode($datos);


          if($ORDER_detail->{'Error'}=='1') { 

           $status= "Error : ".$ORDER_detail->{'ErrorPT'}. 'Se ha cancelado la Orden';
           

         } else{

            if($ORDER_detail->{'Enviado'}!="1"){

              $status='Por Procesar'; }else{ 

                $status= "Sincronizado el: ".$ORDER_detail->{'Export_date'};

               }   

            }


            echo '<ul class="responsive_table">
                     <li class="table_row">
                        <div class="table_section"><strong>SO #.</strong></div>
                        <div class="table_section">'.$ORDER_detail->{'SalesOrderNumber'}.'</div>
                     </li>
                     <li class="table_row">
                        <div class="table_section"><strong>Fecha</strong></div>
                        <div class="table_section">'.$ORDER_detail->{'date'}.'</div>
                     </li>
                     <li class="table_row">
                        <div class="table_section"><strong>Cliente</strong></div>
                        <div class="table_section">'.$ORDER_detail->{'CustomerName'}.'</div> 
                     </li>
                     <li class="table_row">
                        <div class="table_section"><strong>Total Venta</strong></div>
                        <div class="table_section">'.$this->numberFormatPrecision($ORDER_detail->{'Net_due'}).'</div>
                     </li>
                     <li class="table_row">
                        <div class="table_section"><strong>Vendedor</strong></div>
                        <div class="table_section">'.$ORDER_detail->{'name'}.' '.$ORDER_detail->{'lastname'}.'</div>
                     </li>
                     <li class="table_row">
                        <div class="table_section"><strong>Estado</strong></div>
                        <div class="table_section">'.$status.'</div>
                     </li>
                </ul><br><br>';

       }

       $i=1;

       foreach ($ORDER as $datos) {

            $ORDER = json_decode($datos);

            echo '<ul class="responsive_table">
                     <li class="table_row">
                        <div class="table_section"><strong>Item #'.$i.'</strong></div>
                        <div class="table_section"></div>
                        <div class="table_section"></div>
                     </li>
                     <li class="table_row">
                        <div class="table_section"><strong>Codigo</strong></div>
                        <div class="table_section"></div>
                        <div class="table_section">'.$ORDER->{'Item_id'}.'</div>
                     </li>
                     <li class="table_row">
                        <div class="table_section"><strong>Descripcion</strong></div>
                        <div class="table_section"></div>
                        <div class="table_section">'.$ORDER->{'Description'}.'</div>
                     </li>
                     <li class="table_row">
                        <div class="table_section"><strong>Cantidad</strong></div>
                        <div class="table_section"></div>
                        <div class="table_section">'.number_format($ORDER->{'Quantity'},4,'.',',').'</div> 
                     </li>
                     <li class="table_row">
                        <div class="table_section"><strong>Precio Unit.</strong></div>
                        <div class="table_section"></div>
                        <div class="table_section">'.$this->numberFormatPrecision($ORDER->{'Unit_Price'}).'</div>
                     </li>
                 </ul><br>';

                 $i++;

        }

?>
    
              </div>
              <a  class="navbar-brand back" onClick="history.go(-1); return true;" ></a>
      </div>
      

    
    </div>
  </div>
</div>