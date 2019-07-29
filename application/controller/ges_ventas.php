<?PHP

class ges_ventas extends Controller
{

//******************************************************************************
//ORDEN DE VENTAS
public function SalesOrder(){

 $res = $this->model->verify_session();

        if($res=='0'){
        
            // load views
            require APP . 'view/_templates/header.php';
            require APP . 'view/_templates/panel.php';
            require APP . 'view/modules/sales/SalesOrder.php';
            require APP . 'view/_templates/footer.php';


        }
          	
}



//ORDEN DE VENTAS
public function SalesOrderSto(){

 $res = $this->model->verify_session();

        if($res=='0'){
        
            // load views
            require APP . 'view/_templates/header.php';
            require APP . 'view/_templates/panel.php';
            require APP . 'view/modules/sales/SalesOrderSto.php';
            require APP . 'view/_templates/footer.php';

        }
  
}


//ORDEN DE VENTAS MOBILE
public function mob_orden_ventas(){
  
  
   $res = $this->model->verify_session();
  
          if($res=='0'){
              // load views
            require APP . 'view/_templates/mob_header.php';  
            require APP . 'view/mobile/mob_so.php';  
          }else{

            require APP . 'view/mobile/index.php';  
          }
            
   }


public function SalesOrderReport(){

 $res = $this->model->verify_session();

  if($res=='0'){
  
      // load views
      require APP . 'view/_templates/header.php';
      require APP . 'view/_templates/panel.php';
      require APP . 'view/modules/sales/SalesOrderReport.php';
      require APP . 'view/_templates/footer.php';

  }
        	
}


public function SalesReport(){
  
  $res = $this->model->verify_session();
  
  if($res=='0'){
  

      // load views
      require APP . 'view/_templates/header.php';
      require APP . 'view/_templates/panel.php';
      require APP . 'view/modules/sales/SalesReport.php';
      require APP . 'view/_templates/footer.php';

  }
            
}

public function ges_hist_sales(){


 $res = $this->model->verify_session();

        if($res=='0'){
        

            // load views
            require APP . 'view/_templates/header.php';
            require APP . 'view/_templates/panel.php';
            require APP . 'view/operaciones/ges_hist_sales.php';
            require APP . 'view/_templates/footer.php';


        }
          


  
}

//ORDEN DE VENTAS
public function ges_reporte_diario(){


 $res = $this->model->verify_session();

        if($res=='0'){
        

            // load views
            require APP . 'view/_templates/header.php';
            require APP . 'view/_templates/panel.php';
       //    echo '<script> alert("Sistema en mantenimiento por favor espere"); </script>';
            require APP . 'view/operaciones/ges_reporte_diario.php';
            require APP . 'view/_templates/footer.php';


        }
          
 
}


public function PrintSalesOrder($Type,$id){

  //$tax= $this->model->Query_value('sale_tax','rate','where id="1";');
  //$tax_sale = $tax/100;

  
  //$id = trim(preg_replace('/000+/','',$id));

  $res = $this->model->verify_session();
  $id_compania = $this->model->id_compania;

        if($res=='0'){

        $ORDER = $this->model->Get_order_to_invoice($id);
 
 
            foreach ($ORDER as  $value) {

               $value = json_decode($value);
               $custid = $value->{'Customer_Bill_Name'};
               $custname = $value->{'Customer_Bill_Name'}.'/ Dir:'.$value->{'AddressLine1'}.' '.$value->{'AddressLine2'};
               $saleorder = $value->{'SalesOrderNumber'};

               $salesRep = $value->{'name'}.' '.$value->{'lastname'} ;

               $saledate = $value->{'date'};

               $PO =  $value->{'CustomerPO'};

               $subtotal= number_format($value->{'Subtotal'},4);        
               $tax = number_format($value->{'OrderTax'},4);
               $total=number_format($value->{'Net_due'},4);


               $contact = $value->{'email'}.' / '.$value->{'Phone_Number'};

               $tipo_lic = $value->{'tipo_licitacion'};
               $termino_pago =  $value->{'termino_pago'};
               $obser =  $value->{'observaciones'} ;
               $entrega =   $value->{'entrega'};
               $fecha_entrega =   $value->{'fecha_entrega'};

               

            }
        
          if($Type==1){
            // load views
            require APP . 'view/_templates/header.php';
            require APP . 'view/_templates/panel.php';
            require APP . 'view/modules/sales/PrintSalesOrder.php';
            require APP . 'view/_templates/footer.php';
          
          }else{
              // load views
              require APP . 'view/_templates/header.php';
              require APP . 'view/_templates/panel.php';
              require APP . 'view/modules/sales/PrintSalesOrderSto.php';
              require APP . 'view/_templates/footer.php';
            }
        }
           
}

public function ges_print_OrdEmpaque($id){

 //$id = trim(preg_replace('/000+/','',$id));

 $res = $this->model->verify_session();
 $id_compania = $this->model->id_compania;

        if($res=='0'){

        $ORDER = $this->model->Get_order_to_invoice($id);
 
 
            foreach ($ORDER as  $value) {
               $value = json_decode($value);

                $custid = $value->{'Customer_Bill_Name'};

                $razonSocial = $this->model->Query_value('Customers_Exp','Custom_field3','where 
                                                                                        CustomerID="'.$value->{'CustomerID'}.'" and 
                                                                                        id_compania="'.$id_compania.'"');
              
               $custname = '<font style="font-weight:bold;">'.$value->{'ShipToName'}.'</font> <br>'.$razonSocial.'<br>'.$value->{'AddressLine1'};
     
               $saleorder = $value->{'SalesOrderNumber'};

               $salesRep = $value->{'name'}.' '.$value->{'lastname'} ;

               $saledate = $value->{'date'};

               $fecha_entrega = $value->{'fecha_entrega'};

               $clause = 'WHERE SalesOrderNumber="'.$id.'" and ID_compania="'.$id_compania.'"';  
               $created  = $this->model->Query_value('SalesOrder_Header_Imp','LAST_CHANGE',$clause);


               $PO =  $value->{'CustomerPO'};

               $contact = $value->{'email'}.' / '.$value->{'Phone_Number'};

               $tipo_lic = $value->{'tipo_licitacion'};
               $termino_pago =  $value->{'termino_pago'};
               $obser =  $value->{'observaciones'} ;
               $entrega =   $value->{'entrega'};

               $lugar_despacho =  $value->{'lugar_despacho'} ;
              

            }

            //UPDATE INDICATOR
            $value = array('DispachPrinted' => '1' );

            $this->model->update('SalesOrder_Header_Imp',$value, ' SalesOrderNumber="'.$id.'" and ID_compania="'.$id_compania.'"');
        

            // load views
            require APP . 'view/_templates/header.php';
            require APP . 'view/_templates/panel.php';
            require APP . 'view/modules/sales/SalesOrderEmpaque.php';
            require APP . 'view/_templates/footer.php';


        }
          


    
}

public function despachar($id){
  
   //$id = trim(preg_replace('/000+/','',$id));
  
   $res = $this->model->verify_session();
   $id_compania = $this->model->id_compania;
  
          if($res=='0'){
  
          $ORDER = $this->model->Get_order_to_invoice($id);
   
   
              foreach ($ORDER as  $value) {
                 $value = json_decode($value);
  
                  $custid = $value->{'Customer_Bill_Name'};
  
                  $razonSocial = $this->model->Query_value('Customers_Exp','Custom_field3','where 
                                                                                          CustomerID="'.$value->{'CustomerID'}.'" and 
                                                                                          id_compania="'.$id_compania.'"');
                
                 $custname = '<font style="font-weight:bold;">'.$value->{'ShipToName'}.'</font> <br>'.$razonSocial.'<br>'.$value->{'AddressLine1'};
       
                 $saleorder = $value->{'SalesOrderNumber'};
  
                 $salesRep = $value->{'name'}.' '.$value->{'lastname'} ;
  
                 $saledate = $value->{'date'};
  
                 $fecha_entrega = $value->{'fecha_entrega'};
  
                 $clause = 'WHERE SalesOrderNumber="'.$id.'" and ID_compania="'.$id_compania.'"';  
                 $created  = $this->model->Query_value('SalesOrder_Header_Imp','LAST_CHANGE',$clause);
  
  
                 $PO =  $value->{'CustomerPO'};
  
                 $contact = $value->{'email'}.' / '.$value->{'Phone_Number'};
  
                 $tipo_lic = $value->{'tipo_licitacion'};
                 $termino_pago =  $value->{'termino_pago'};
                 $obser =  $value->{'observaciones'} ;
                 $entrega =   $value->{'entrega'};
  
                 $lugar_despacho =  $value->{'lugar_despacho'} ;
                
  
              }
  
              //UPDATE INDICATOR
              $value = array('DispachPrinted' => '1' );
  
              $this->model->update('SalesOrder_Header_Imp',$value, ' SalesOrderNumber="'.$id.'" and ID_compania="'.$id_compania.'"');
          

              //descontar existencias
              $this->setDispach($id);
  
              // load views
              require APP . 'view/_templates/header.php';
              require APP . 'view/_templates/panel.php';
              require APP . 'view/modules/sales/SalesOrderEmpaque.php';
              require APP . 'view/_templates/footer.php';
  
  
          }
            
  
  
      
  }

  function setDispach($ID){

    $res = $this->model->verify_session();
    $id_compania = $this->model->id_compania;

  //**LAST CHANGE 9/06/2019 */
  require_once APP.'controller/ges_ventas.php';
  
  $ventas = new ges_ventas(); 

  $reserv = $this->model->queryColumns('sale_pendding',['ProductID','status_location_id','qty'],' WHERE SaleOrderId="'.$ID.'" and ID_compania="'.$id_compania.'"');

  foreach ($reserv as  $value) {

     $value = json_decode($value);
     $itemid =  $value->{'ProductID'};
     $value->{'status_location_id'};
     $qty = $value->{'qty'};
   
     $ventas->UpdateItemsLocation($value->{'status_location_id'},$value->{'qty'});

     $id_compania= $this->model->id_compania;
     $user = $this->model->active_user_id;
     
     $event_values = array(  'ProductID' => $itemid,
                             'JobID' => '',
                             'JobPhaseID' => '',
                             'JobCostCodeID' => '',
                             'PurchaseNumber' => '',
                             'Qty'=> (-1)*$qty,
                             'unit_price' => 0,
                             'Total' => 0,
                             'User' => $user,
                             'Type' => 'Despacho por Orden de venta',
                             'Referencia' => $ID,
                             'ID_compania' => $id_compania ,
                             'stockOrigID' => $value->{'status_location_id'} );
     //set event Line              
     $this->model->insert('INV_EVENT_LOG',$event_values); 

     $this->model->update('SalesOrder_Header_Imp', ['EMITIDA' => "1" ] , ' where ID_compania = "'.$id_compania.'" and  SalesOrderNumber="'.$ID.'"' ); 
 

    //**LAST CHANGE 9/06/2019 */

  }

}

//******************************************************************************
//FACTURAS DE VENTAS


public function ges_pro_ventas(){


 $res = $this->model->verify_session();

        if($res=='0'){
        

            // load views
            require APP . 'view/_templates/header.php';
            require APP . 'view/_templates/panel.php';
            require APP . 'view/operaciones/ges_pro_ventas.php';
            require APP . 'view/_templates/footer.php';

        }

}

public function ges_pro_hist_ventas(){


 $res = $this->model->verify_session();

        if($res=='0'){
        

            // load views
            require APP . 'view/_templates/header.php';
            require APP . 'view/_templates/panel.php';
            require APP . 'view/operaciones/ges_pro_hist_ventas.php';
            require APP . 'view/_templates/footer.php';


        }
          


  
}

public function ges_print_sales($id){

  $tax= $this->model->Query_value('sale_tax','rate','where id="1";');
  $tax_sale = $tax/100;

  
  $id = trim(preg_replace('/000+/','',$id));

 $res = $this->model->verify_session();

        if($res=='0'){

        $ORDER = $this->model->Get_sales_to_invoice($id);
 
 
            foreach ($ORDER as  $value) {
               $value = json_decode($value);
              
               $custid = $value->{'CustomerID'};
               
               $custname = $value->{'Customer_Bill_Name'};

               $saleorder = $value->{'InvoiceNumber'};

               $salesRep = $value->{'name'}.' '.$value->{'lastname'} ;

               $saledate = $value->{'date'};

               $subtotal= number_format($value->{'Subtotal'},2);

               $tax = $value->{'saletax'};

               $tax_sale = $tax/100;

               $tax =  number_format(($subtotal * $tax_sale),2);

              

               $total=number_format($value->{'Net_due'},2);

               $contact = $value->{'email'}.' / '.$value->{'Phone_Number'};
               

            }
        

            // load views
            require APP . 'view/_templates/header.php';
            require APP . 'view/_templates/panel.php';
            require APP . 'view/operaciones/ges_print_sales.php';
            require APP . 'view/_templates/footer.php';


        }
          


    
}

public function ges_hist_sal_merc(){


 $res = $this->model->verify_session();

        if($res=='0'){
        

            // load views
            require APP . 'view/_templates/header.php';
            require APP . 'view/_templates/panel.php';
            require APP . 'view/operaciones/ges_hist_sal_merc.php';
            require APP . 'view/_templates/footer.php';


        }
          


  
}

public function ges_print_SalMerc($id){

 $id = trim(preg_replace('/000+/','',$id));

 $res = $this->model->verify_session();

        if($res=='0'){

        $ORDER = $this->model->Get_sal_merc_to_invoice($id);
 
        

 
            foreach ($ORDER as  $value) {

              $value = json_decode($value);

             $name = $this->model->Query_value('SAX_USER','name','Where ID="'.$value->{'USER'}.'"');
             $lastname =  $this->model->Query_value('SAX_USER','lastname','Where ID="'.$value->{'USER'}.'"');

             $Job= $value->{'JobID'};      
             $fase= $value->{'JobPhaseID'};
             $ccost= $value->{'JobCostCodeID'};
              
              $ref = $value->{'Reference'};

              $rep = $name.' '.$lastname;

              $date = $value->{'Date'};

              $desc = $value->{'ReasonToAdjust'};

              $accnt =  $value->{'Account'};


            }
        

            // load views
            require APP . 'view/_templates/header.php';
            require APP . 'view/_templates/panel.php';
            require APP . 'view/operaciones/ges_print_SalMerc.php';
            require APP . 'view/_templates/footer.php';


        }
          
}

public function GetPayTerm($ID=0){

  if($ID!=0){
    $this->model->verify_session();
    $id_compania = $this->model->id_compania;

    $customField = $this->model->Query_value('FAC_DET_CONF','CUSTOM_FIELD','WHERE ID_compania="'.$this->model->id_compania.'"');

    $TermID = $this->model->Query_value('Customers_Exp',$customField,'WHERE  ID= "'.$ID.'" AND ID_compania="'.$id_compania.'"'); 

    $DaysToPay = $this->model->Query_value('CUST_PAY_TERM','DaysToPay','WHERE TermID = "'.$TermID.'" AND ID_compania="'.$id_compania.'"'); 
 
   echo $DaysToPay;
  }
}

public function getSalesOrderRep($sort,$limit,$clause){


  $this->model->verify_session();



  if($this->model->active_user_role=='admin'){

  $query ='SELECT * FROM `SalesOrder_Header_Imp` 
  inner JOIN `SalesOrder_Detail_Imp` ON SalesOrder_Header_Imp.SalesOrderNumber = SalesOrder_Detail_Imp.SalesOrderNumber
  inner JOIN `SAX_USER` ON `SAX_USER`.`id` = SalesOrder_Header_Imp.user '.$clause.' GROUP BY SalesOrder_Header_Imp.SalesOrderNumber order by SalesOrder_Header_Imp.LAST_CHANGE '.$sort.' limit '.$limit ; }

  if($this->model->active_user_role=='user'){

    if($clause!=''){ $clause.= 'and `SAX_USER`.`id`="'.$this->model->active_user_id.'"'; } else{ $clause.= ' Where `SAX_USER`.`id`="'.$this->model->active_user_id.'"'; }

  $query='SELECT * FROM `SalesOrder_Header_Imp`
          inner JOIN `SalesOrder_Detail_Imp` ON SalesOrder_Header_Imp.SalesOrderNumber = SalesOrder_Detail_Imp.SalesOrderNumber
          inner JOIN `SAX_USER` ON `SAX_USER`.`id` = SalesOrder_Header_Imp.user '.$clause.' GROUP BY SalesOrder_Header_Imp.SalesOrderNumber  order by SalesOrder_Header_Imp.LAST_CHANGE '.$sort.' limit '.$limit;

  }



  return $filter =  $this->model->Query($query);


}






public function get_salesorder_info($id){

$this->model->verify_session();

$id_compania= $this->model->id_compania;

$query ="SELECT * FROM `SalesOrder_Header_Imp`
inner JOIN `SalesOrder_Detail_Imp` ON SalesOrder_Header_Imp.SalesOrderNumber = SalesOrder_Detail_Imp.SalesOrderNumber
inner JOIN `SAX_USER` ON `SAX_USER`.`id` = SalesOrder_Header_Imp.user
WHERE SalesOrder_Header_Imp.SalesOrderNumber='".$id."' and SalesOrder_Header_Imp.ID_compania='".$id_compania."'  GROUP BY SalesOrder_Detail_Imp.SalesOrderNumber ";

//inner JOIN Products_Exp ON Products_Exp.ProductID = SalesOrder_Detail_Imp.item_id


$ORDER_detail= $this->model->Query($query);


echo '<br/><br/><fieldset><legend>Detalle de Orden de venta/Pedido</legend><table class="table table-striped table-bordered" cellspacing="0"  ><tr>';

  foreach ($ORDER_detail as $datos) {
    $ORDER_detail = json_decode($datos);


      if($ORDER_detail->{'Error'}=='1') { 

       $status= "Error : ".$ORDER_detail->{'ErrorPT'}. 'Se ha cancelado la Orden';
       $style="style='color:red;'"; 


     } else{

        if($ORDER_detail->{'Enviado'}!="1"){

          $style="style='color:orange;'"; 
          $status='Por Procesar'; }else{ 

            $status= "Sincronizado el: ".$ORDER_detail->{'Export_date'};
            $style="style='color:green;'";

           }   

        }

$aprobacion = $this->model->Query_value('SalesOrder_Header_Exp','Close_SO','Where SalesOrderNumber="'.$ORDER_detail->{'SalesOrderNumber'}.'" and  ID_compania="'.$this->model->id_compania.'" ');

    //if($aprobacion==''){ $apro = 'En espera de envio'; $apro_style="style='color:orange; font-style:bold;'"; }
    //if($aprobacion=='0' || $aprobacion==''){ $apro = 'En espera de aprobacion';  $apro_style="style='color:orange; font-style:bold;'";  }
    //if($aprobacion=='1' ){ $apro = 'Aprobado'; $apro_style="style='color:green; font-style:bold;'"; }

    echo "<tr  ><th class='columnHdr'><strong>No. Orden</strong></th><td class='columnHdr InfsalesTd order'>".$ORDER_detail->{'SalesOrderNumber'}."</td></tr>
          <tr ><th class='columnHdr'><strong>Fecha</strong></th><td class='columnHdr InfsalesTd '>".$ORDER_detail->{'date'}."</td></tr>
          <tr ' ><th class='columnHdr'><strong>Cliente</strong></th><td class='columnHdr InfsalesTd'>".$ORDER_detail->{'CustomerName'}."</td></tr>
          <tr ><th class='columnHdr' ><strong>Total venta</strong></th><td class='columnHdr InfsalesTd '>".$this->numberFormatPrecision($ORDER_detail->{'Net_due'})."</td></tr>
          <tr><th class='columnHdr'><strong>Vendedor</strong></th><td class='columnHdr InfsalesTd'>".$ORDER_detail->{'name'}.' '.$ORDER_detail->{'lastname'}."</td></tr>
          <tr ><th class='columnHdr'><strong>Estado</strong></th><td '.$style.' class='columnHdr InfsalesTd'>".$status."</td></tr>";

}


if($ORDER_detail->{'Error'}=='1') { 
$apro ='';

 }

echo "</tr></table>";



$query ="SELECT * FROM `SalesOrder_Detail_Imp`
WHERE SalesOrder_Detail_Imp.SalesOrderNumber='".$id."' and  SalesOrder_Detail_Imp.ID_compania='".$id_compania."' ORDER BY SalesOrder_Detail_Imp.ItemOrd ASC ;";


$ORDER= $this->model->Query($query);

echo '<table id="example-12" class="table table-striped table-bordered" cellspacing="0"  >
      <thead>
        <tr>
          <th>Codigo</th>
          <th>Descripcion</th>
          <th>Cantidad</th>
          <th>Precio Unit.</th>
        </tr>
      </thead><tbody>';


foreach ($ORDER as $datos) {

    $ORDER = json_decode($datos);

    $id= "'".$ORDER_detail->{'SalesOrderNumber'}."'";


echo  "<tr>
          <td>".$ORDER->{'Item_id'}."</td>
          <td>".$ORDER->{'Description'}."</td>
          <td class='numb' >".number_format($ORDER->{'Quantity'},4,'.',',')."</td>
          <td class='numb' >".$this->numberFormatPrecision($ORDER->{'Unit_Price'})."</td>

      </tr>";

  }

echo '</tbody></table><div style="float:right;" class="col-md-2">
<a href="'.URL.'index.php?url=ges_ventas/PrintSalesOrder/2/'.$ORDER_detail->{'SalesOrderNumber'}.'"  class="btn-bar">
   <img  class="icon" src="img/Printer.png" />
  <span>Imprimir</span>
</a>
</div>
<div class="separador col-lg-12"></div>
</fieldset>';


}




//EXTRAE STRING ENTRE DOS CARACTERES
private function get_string_between($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}



//PRECISION 2 DECIMALES SIN REDONDEO 
private function numberFormatPrecision($number, $precision = 2, $separator = '.')
{
    $numberParts = explode($separator, $number);
    $response = $numberParts[0];
    if(count($numberParts)>1){
        $response .= $separator;
        $response .= substr($numberParts[1], 0, $precision);
    }
    return $response;
}

public function CheckError(){


  $CHK_ERROR =  $this->model->read_db_error();
  

  if ($CHK_ERROR!=''){ 

   die("<script>$(window).load(  
        function(){   
          MSG_ERROR('".$CHK_ERROR."',0);
         }
       );</script>"); 

  }

}

public function test(){
  $this->model->verify_session();
 echo  $this->model->Get_SO_NoDes();

}

  


///////////////////////////////SALESS!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
public function set_sales_order_header(){
  
  $this->model->verify_session();
  
  $id_compania = $this->model->id_compania;
  $SalesOrderNumber = $this->model->Get_SO_NoDes();
  
  $data = json_decode($_GET['Data']);
  $value = $data[0];
  
  
  list($CustomerID,$Subtotal,$TaxID,$Net_due,$nopo,$pago,$licitacion,$observaciones,$entrega,$ordertax,$fecha_entrega,$lugDesp) = explode('@', $value );
  
  
  $custinfo = $this->model->get_Cust_info_int($CustomerID);
  $custinfo = json_decode($custinfo);
  
  $date = strtotime($this->model->GetLocalTime(date("Y-m-d")));
  $date = date("Y-m-d",$date);
  
  if($lugDesp !=""){

    $lugDespID = substr($lugDesp,0,1);

  list($ACI , $NO_ORDER) = explode('-', $SalesOrderNumber);
        
    $SalesOrderNumber = $ACI.'-'.$lugDespID.'-'.$NO_ORDER;

  }
  
  $values = array(
  'ID_compania'=>$this->model->id_compania,
  'SalesOrderNumber'=> $SalesOrderNumber,
  'CustomerID'=>   $custinfo->{'CustomerID'},
  'CustomerName'=> $custinfo->{'Customer_Bill_Name'},
  'Subtotal'=>$Subtotal,
  'TaxID'=>$TaxID,
  'OrderTax' => $ordertax,
  'Net_due'=>$Net_due,
  'user'=>$this->model->active_user_id,
  'date'=>$date,
  'saletax'=>'0',
  'CustomerPO' => $nopo,
  'tipo_licitacion' => $licitacion,
  'entrega' => $entrega,
  'termino_pago' => $pago,
  'observaciones' => $observaciones,
  'ShipToName' =>  $custinfo->{'CustomerID'}.'-'.$custinfo->{'Customer_Bill_Name'},
  'ShipToAddressLine1' => $custinfo->{'AddressLine1'},
  'ShipToAddressLine2' => $custinfo->{'AddressLine2'},
  'ShipToCity' => $custinfo->{'City'},
  'ShipToState' => $custinfo->{'State'},
  'ShipToZip' => $custinfo->{'Zip'},
  'ShipToCountry' => $custinfo->{'Country'},
  'fecha_entrega' => $fecha_entrega,
  'lugar_despacho' => $lugDesp);
  
  $this->model->insert('SalesOrder_Header_Imp',$values);
  
  
  echo $SalesOrderNumber ;
  
  }
  
  
  
  public function set_sales_order_detail_new($SalesOrderNumber){
  
  $this->model->verify_session();
  
  $id_compania= $this->model->id_compania;
  $id_user_active= $this->model->active_user_id ;
  
  $data = json_decode($_GET['Data']);
  
  foreach ($data as $key => $value) {
  
  if($value){
  
  list($desc,$remarks,$UnitMeasure,$itemid,$unit_price,$qty,$Price,$chi,$gra) = explode('@', $value );
  
  $no_cover_qty = $qty;
  $no_cover_uni = $UnitMeasure;
  $no_cover_pri = $unit_price;
  
  $custid  = $this->model->Query_value('SalesOrder_Header_Imp','CustomerID','WHERE SalesOrderNumber="'.$SalesOrderNumber.'" and ID_compania="'.$id_compania.'"');
  $UNIT_TO_CONVERT = $this->model->Query_value('Customers_Exp','Custom_field5','WHERE CustomerID="'.$custid.'" and id_compania="'.$id_compania.'"');
  $factor  = $this->model->Query_value('UNIT_MES_CONVRT','FACTOR','WHERE UNIT="'.$UnitMeasure.'" and UNIT_TO_CONVERT="'.$UNIT_TO_CONVERT.'" and ID_compania="'.$id_compania.'"');
  
  
    if($factor!=''){
     
      $unit_price =   $unit_price / $factor;
      $qty = $qty * $factor;
      $Price =  $unit_price * $qty;
  
      $UnitMeasure     = $this->model->Query_value('UNIT_MES_CONVRT','UNIT_NAME','WHERE UNIT="'.$UnitMeasure.'" AND UNIT_TO_CONVERT="'.$UNIT_TO_CONVERT.'" and ID_compania="'.$id_compania.'"');
  
  
        //EN CASO QUE NO SE HAGA CONVERSION DE UNIDDES ESCRIBE EN LA TABLA DE SALES ORDER DETAIL SIN INDICAR EL ITEMID. 
        $values1 = array(
            'ItemOrd' => $key ,
            'ID_compania'=>$id_compania,
            'SalesOrderNumber'=>$SalesOrderNumber,
            'Item_id'=> $itemid,
            'Description'=> '('.$UnitMeasure.') '.$desc.' '.$remarks,
            'REMARK'=>$remarks,
            'Quantity'=>$qty,
            'Unit_Price'=>$unit_price,
            'Net_line'=>$Price,
            'PK_CHICO'=>$chi,
            'PK_GRANDE'=>$gra,
            'Taxable'=>$this->model->Query_value('Products_Exp','TaxType','Where ProductID="'.$itemid.'" and ID_compania="'.$id_compania.'";') );
  
        $this->model->insert('SalesOrder_Detail_Imp',$values1); //set item line
  
        $factor = '';
     }else{
  
        //EN CASO QUE NO SE HAGA CONVERSION DE UNIDDES ESCRIBE EN LA TABLA DE SALES ORDER DETAIL INDICANDO EL ITEMID. 
        $values1 = array(
            'ItemOrd' => $key ,
            'ID_compania'=>$id_compania,
            'SalesOrderNumber'=>$SalesOrderNumber,
            'Item_id'=>$itemid,
            'Description'=> '('.$UnitMeasure.') '.$desc.' '.$remarks,
            'REMARK'=>$remarks,
            'Quantity'=>$qty,
            'Unit_Price'=>$unit_price,
            'Net_line'=>$Price,
            'PK_CHICO'=>$chi,
            'PK_GRANDE'=>$gra,
            'Taxable'=>$this->model->Query_value('Products_Exp','TaxType','Where ProductID="'.$itemid.'" and ID_compania="'.$id_compania.'";') );
  
  
        $this->model->insert('SalesOrder_Detail_Imp',$values1); //set item line
  
     }
  
  
   }
  }
  echo '1';
  
}

  
public function SetSOfromStock($SalesOrderNumber){
  
  $this->model->verify_session();
  
  $id_compania= $this->model->id_compania;
  $id_user_active= $this->model->active_user_id;
  
  $data = json_decode($_GET['Data']);
  
  foreach ($data as $key => $value) {
  
  if($value){
  
  list($desc,$remarks,$UnitMeasure,$itemid,$unit_price,$qty,$Price,$lote,$loc) = explode('@', $value );
  
  $OriQty = $qty;


  $no_cover_qty = $qty;
  $no_cover_uni = $UnitMeasure;
  $no_cover_pri = $unit_price;
  
  $custid  = $this->model->Query_value('SalesOrder_Header_Imp','CustomerID','WHERE SalesOrderNumber="'.$SalesOrderNumber.'" and ID_compania="'.$id_compania.'"');
  $UNIT_TO_CONVERT = $this->model->Query_value('Customers_Exp','Custom_field5','WHERE CustomerID="'.$custid.'" and id_compania="'.$id_compania.'"');
  $factor  = $this->model->Query_value('UNIT_MES_CONVRT','FACTOR','WHERE UNIT="'.$UnitMeasure.'" and UNIT_TO_CONVERT="'.$UNIT_TO_CONVERT.'" and ID_compania="'.$id_compania.'"');
  
  
  if($factor!=''){
     
      $unit_price =   $unit_price / $factor;
      $qty = $qty * $factor;
      $Price =  $unit_price * $qty;
  
      $UnitMeasure = $this->model->Query_value('UNIT_MES_CONVRT','UNIT_NAME','WHERE UNIT="'.$UnitMeasure.'" AND UNIT_TO_CONVERT="'.$UNIT_TO_CONVERT.'" and ID_compania="'.$id_compania.'"');
  
      //IF ITEMS EXIST
      $clause='where Item_id="'.$itemid.'" and SalesOrderNumber="'.$SalesOrderNumber.'" and ID_compania="'.$id_compania.'";';
      $ID = $this->model->Query_value('SalesOrder_Detail_Imp','ID',$clause);
  
  
      if ($ID==''){

  
  
        //EN CASO QUE NO SE HAGA CONVERSION DE UNIDDES ESCRIBE EN LA TABLA DE SALES ORDER DETAIL SIN INDICAR EL ITEMID. 
        $values1 = array(
            'ItemOrd' => $key ,
            'ID_compania'=>$id_compania,
            'SalesOrderNumber'=>$SalesOrderNumber,
            'Item_id'=> $itemid,
            'Description'=> '('.$UnitMeasure.') '.$desc.' '.$remarks,
            'REMARK'=>$remarks,
            'Quantity'=>$qty,
            'Unit_Price'=>$unit_price,
            'Net_line'=>$Price,
            'Taxable'=>$this->model->Query_value('Products_Exp','TaxType','Where ProductID="'.$itemid.'" and ID_compania="'.$id_compania.'";') );
  
        $this->model->insert('SalesOrder_Detail_Imp',$values1); //set item line
  
        $factor = '';

          //SI TIENE MODULO DE UBICACIONES
          if($mod_stoc_CK == 'checked' ){ 

                  //INIT SET LOTE 
                    $values2 = array(
                      'ItemOrd' => $key+1,
                      'ID_compania'=>$id_compania,
                      'SalesOrderNumber'=>$SalesOrderNumber,
                      'Item_id'=>'',
                      'Description'=>$Description,
                      'Quantity'=>'0',
                      'Unit_Price'=>'0',
                      'Net_line'=>'0',
                      'Taxable'=>'1');
                    
                  $this->model->insert('SalesOrder_Detail_Imp',$values2);//set lote line
                  //END SET LOTE /////////////
                } 
        }else{
           
          //SI EL ITEM YA EXISTE EN LA ORDEN DE DEBE AGRUPAR 
          $QUERY='SELECT Quantity, Unit_Price FROM SalesOrder_Detail_Imp where ID="'.$ID.'"';
          $QTY_PRI = $this->model->Query($QUERY);


          $unit_price =   $unit_price / $factor;
          $qty = $qty * $factor;
          $Price =  $unit_price * $qty;
          $UnitMeasure = $this->model->Query_value('UNIT_MES_CONVRT','UNIT_NAME','WHERE UNIT="'.$UnitMeasure.'" AND UNIT_TO_CONVERT="'.$UNIT_TO_CONVERT.'" and ID_compania="'.$id_compania.'"');
      
          
                foreach ($QTY_PRI  AS $QTY_PRI) {

                $QTY_PRI = json_decode($QTY_PRI);

                $now_qty = $QTY_PRI->{'Quantity'}+$qty;
                $net_line= $QTY_PRI->{'Unit_Price'} * $now_qty;

                }
          
          
          $query= 'UPDATE SalesOrder_Detail_Imp SET 
                          Quantity="'.$now_qty.'" , 
                          Net_line="'.$net_line.'" 
                          where ID="'.$ID.'";';

          $this->model->Query($query);

            //SI TIENE MODULO DE UBICACIONES
            if($mod_stoc_CK == 'checked' ){ 
                
                  $values2 = array(
                  'ItemOrd' => $key,
                  'ID_compania'=>$id_compania,
                  'SalesOrderNumber'=>$SalesOrderNumber,
                  'Item_id'=>'',
                  'Description'=>$Description,
                  'Quantity'=>'0',
                  'Unit_Price'=>'0',
                  'Net_line'=>'0',
                  'Taxable'=>'1');


                  $this->model->insert('SalesOrder_Detail_Imp',$values2);//set lote line
            }
        }

     }else{

      
      
      //IF ITEMS EXIST
      $clause='where Item_id="'.$itemid.'" and SalesOrderNumber="'.$SalesOrderNumber.'" and ID_compania="'.$id_compania.'";';

      $ID = $this->model->Query_value('SalesOrder_Detail_Imp','ID',$clause);
  
  
      if ($ID==''){

        $col = array( 'fecha_ven' , 'fecha_fab' );
        
            $loteVenFab = $this->model->queryColumns('ITEMS_NO_LOTE',$col, 'where no_lote="'.$lote.'" and ID_compania="'.$this->model->id_compania .'"');
            
            foreach ($loteVenFab as $value) {
            
              $value = json_decode($value);
        
        
              $venc =  $value->{'fecha_ven'};
              $fab =  $value->{'fecha_fab'};
              
        
                if ($venc!=''){
                  $venc = date('d/m/Y',strtotime($venc));
                  $caduc =   ' Venc: '.$venc.' ';
                }else{
                  $caduc = '';
                }
        
                if ($fab!=''){
                  $fab = date('d/m/Y',strtotime($fab));
                  $fabDate =   ' Fab: '.$fab.' ';
                }else{
                  $fabDate = '';
                }
        
            }
        
        
          //$Description = 'Lote :'.$lote.' '.$caduc.' Cant.:'.$qty;
          $Description = 'test'.substr($desc,0,136).$fabDate.$venc;
  
        //EN CASO QUE NO SE HAGA CONVERSION DE UNIDDES ESCRIBE EN LA TABLA DE SALES ORDER DETAIL INDICANDO EL ITEMID. 
        $values1 = array(
            'ItemOrd' => $key ,
            'ID_compania'=>$id_compania,
            'SalesOrderNumber'=>$SalesOrderNumber,
            'Item_id'=>$itemid,
            'Description'=> $Description,
            'REMARK'=>$remarks,
            'Quantity'=>$qty,
            'Unit_Price'=>$unit_price,
            'Net_line'=>$Price,
            'Taxable'=>$this->model->Query_value('Products_Exp','TaxType','Where ProductID="'.$itemid.'" and ID_compania="'.$id_compania.'";') );
  
  
           $this->model->insert('SalesOrder_Detail_Imp',$values1); //set item line
  
          // //SI TIENE MODULO DE UBICACIONES
          // if($mod_stoc_CK == 'checked' ){ 

          //     //INIT SET LOTE 
          //     $values2 = array( 'ItemOrd' => $key+1,
          //                       'ID_compania'=>$id_compania,
          //                       'SalesOrderNumber'=>$SalesOrderNumber,
          //                       'Item_id'=>'',
          //                       'Description'=>$Description,
          //                       'Quantity'=>'0',
          //                       'Unit_Price'=>'0',
          //                       'Net_line'=>'0',
          //                       'Taxable'=>'1');
                
          //     $this->model->insert('SalesOrder_Detail_Imp',$values2);//set lote line



          //     //END SET LOTE /////////////
          //   }

        }else{

                //SI EL ITEM YA EXISTE EN LA ORDEN DE DEBE AGRUPAR 
                $QUERY='SELECT Quantity, Unit_Price FROM SalesOrder_Detail_Imp where ID="'.$ID.'"';
                $QTY_PRI = $this->model->Query($QUERY);

                      foreach ($QTY_PRI  AS $QTY_PRI) {

                      $QTY_PRI = json_decode($QTY_PRI);

                      $now_qty = $QTY_PRI->{'Quantity'}+$qty;
                      $net_line= $QTY_PRI->{'Unit_Price'} * $now_qty;

                      }


                $query= 'UPDATE SalesOrder_Detail_Imp SET 
                                Quantity="'.$now_qty.'" , 
                                Net_line="'.$net_line.'" 
                                where ID="'.$ID.'";';

                $this->model->Query($query);

              //SI TIENE MODULO DE UBICACIONES
              if($mod_stoc_CK == 'checked' ){ 

                  $values2 = array(
                  'ItemOrd' => $key,
                  'ID_compania'=>$id_compania,
                  'SalesOrderNumber'=>$SalesOrderNumber,
                  'Item_id'=>'',
                  'Description'=>$Description,
                  'Quantity'=>'0',
                  'Unit_Price'=>'0',
                  'Net_line'=>'0',
                  'Taxable'=>'1');


                  $this->model->insert('SalesOrder_Detail_Imp',$values2);//set lote line
                  }
            }
        }

   }


   //**  reserva de items  */
    $reserv = array(  'ProductID'           => $itemid,
                      'SaleOrderId'         => $SalesOrderNumber,
                      'qty'                 => $qty,
                      'status_location_id'  => $loc ,
                      'ID_compania'         => $id_compania );

    $this->model->insert('sale_pendding',$reserv); 
    // $this->UpdateItemsLocation($loc,$OriQty);

    // //set event item 
    $id_compania = $this->model->id_compania;
    $user        = $this->model->active_user_id;
    
    $event_values = array(  'ProductID' => $itemid,
                            'JobID' => '',
                            'JobPhaseID' => '',
                            'JobCostCodeID' => '',
                            'PurchaseNumber' => '',
                            'Qty'=> $qty,
                            'unit_price' => $unit_price ,
                            'Total' => $Price,
                            'User' => $user,
                            'Type' => 'Reserva a Orden de venta',
                            'Referencia'  => $SalesOrderNumber,
                            'ID_compania' => $id_compania ,
                            'stockOrigID' => $loc );
    //set event Line              
    $this->model->insert('INV_EVENT_LOG',$event_values); 

   //**  reserva de items  */
   
  }

  echo '1';
}

public function UpdateItemsLocation($Idruta,$qty){

  $this->model->verify_session();

  //UBICO LA CANTIDAD ACTUAL EN STATUS_LOCATION
  $CURRENT_QTY = $this->getLoteQty($Idruta);
  
  //ACTUALIZO LA CANTIDAD EN LA UBICCION DEFAULT
  $QTY_TO_SET = $CURRENT_QTY - $qty;
  

  $query= 'UPDATE STOCK_ITEMS_LOCATION SET qty="'.$QTY_TO_SET.'" WHERE id="'.$Idruta.'" and ID_compania="'.$this->model->id_compania.'"';
  $res = $this->model->Query($query);
  
  $this->CheckError();


}

public function get_any_lote_qty($idLoc=''){
  
      $this->model->verify_session();
  
      $res = $this->model->Query_value('STOCK_ITEMS_LOCATION','Floor(qty)','where id="'.$idLoc.'" and ID_compania ="'.$this->model->id_compania.'";');
  
  echo $res;
  return $res;
  }

public function getLoteQty($idLoc=''){
  
      $this->model->verify_session();
  
      $res = $this->model->Query_value('STOCK_ITEMS_LOCATION','Floor(qty)','where id="'.$idLoc.'" and ID_compania ="'.$this->model->id_compania.'";');
  

  return $res;
  }

public function getSalesRep($sort,$limit,$clause){


$this->model->verify_session();

  if($this->model->active_user_role=='admin'){
    
    $query ='SELECT * FROM `Sales_Header_Imp` 
            inner JOIN `Sales_Detail_Imp` ON Sales_Header_Imp.InvoiceNumber = Sales_Detail_Imp.InvoiceNumber
            inner JOIN `SAX_USER` ON `SAX_USER`.`id` = Sales_Header_Imp.user '.$clause.' GROUP BY Sales_Header_Imp.InvoiceNumber 
            order by LAST_CHANGE '.$sort.' limit '.$limit ; 
   }

   if($this->model->active_user_role=='user'){
    
      if($clause!=''){ $clause.= 'and `SAX_USER`.`id`="'.$this->model->active_user_role_id.'"'; } else{ $clause.= ' Where `SAX_USER`.`id`="'.$this->active_user_role_id.'"'; }
    
      $query ='SELECT * FROM `Sales_Header_Imp` 
      inner JOIN `Sales_Detail_Imp` ON Sales_Header_Imp.InvoiceNumber = Sales_Detail_Imp.InvoiceNumber
      inner JOIN `SAX_USER` ON `SAX_USER`.`id` = Sales_Header_Imp.user '.$clause.' GROUP BY Sales_Header_Imp.InvoiceNumber 
      order by LAST_CHANGE '.$sort.' limit '.$limit ; 
    }
    
    //echo $query; die();
    
    return $filter =  $this->model->Query($query);

}



public function get_sales_info($id){


$this->model->verify_session();


$query ="SELECT * FROM `Sales_Header_Imp`
inner JOIN `Sales_Detail_Imp` ON Sales_Header_Imp.InvoiceNumber = Sales_Detail_Imp.InvoiceNumber
inner JOIN `SAX_USER` ON `SAX_USER`.`id` = Sales_Header_Imp.user
WHERE Sales_Header_Imp.InvoiceNumber='".$id."' GROUP BY Sales_Detail_Imp.InvoiceNumber";

//inner JOIN Products_Exp ON Products_Exp.ProductID = Sales_Detail_Imp.item_id

$ORDER_detail= $this->model->Query($query);


echo '<br/><br/><fieldset><legend>Detalle de factura</legend><table class="table table-striped table-bordered" cellspacing="0"  ><tr>';

  foreach ($ORDER_detail as $datos) {
    $ORDER_detail = json_decode($datos);
   
    $OrdPedi = $this->model->Query_value('INVOICE_GEN_HEADER','SalesOrderNumber','WHERE InvoiceNumber="'.$ORDER_detail->{'InvoiceNumber'}.'"');

    echo "<tr><th class='columnHdr'><strong>No. Factura fiscal</strong></th><td class='columnHdr InfsalesTd order'>".$ORDER_detail->{'InvoiceNumber'}."</td></tr>
          <tr><th class='columnHdr'><strong>No. Orden/Pedido</strong></th><td class='columnHdr InfsalesTd order'>".$OrdPedi."</td></tr>
          <tr><th class='columnHdr'><strong>Fecha</strong></th><td class='columnHdr InfsalesTd'>".$ORDER_detail->{'date'}."</td></tr>
          <tr><th class='columnHdr'><strong>Cliente</strong></th><td class='columnHdr InfsalesTd'>".$ORDER_detail->{'CustomerName'}."</td></tr>
          <tr><th class='columnHdr'><strong>Total venta</strong></th><td class='columnHdr InfsalesTd'>".number_format($ORDER_detail->{'Net_due'},2,'.',',')."</td></tr>
          <tr><th class='columnHdr'><strong>Procesado por: </strong></th><td class='columnHdr InfsalesTd'>".$ORDER_detail->{'name'}.' '.$ORDER_detail->{'lastname'}."</td></tr>";

}




echo "</tr></table>";

$query ="SELECT * FROM `Sales_Header_Imp`
inner JOIN `Sales_Detail_Imp` ON Sales_Header_Imp.InvoiceNumber = Sales_Detail_Imp.InvoiceNumber
inner JOIN `SAX_USER` ON `SAX_USER`.`id` = Sales_Header_Imp.user
WHERE Sales_Header_Imp.InvoiceNumber='".$id."';";


$ORDER= $this->model->Query($query);

echo '<table id="example-12" class="table table-striped table-bordered" cellspacing="0"  >
      <thead>
        <tr>
          <th>Codigo</th>
          <th>Descripcion</th>
          <th>Cantidad</th>
          <th>Precio Unit.</th>
          <th>Total linea</th>
          <th>Estado Sinc.</th>
        </tr>
      </thead><tbody>';


foreach ($ORDER as $datos) {

    $ORDER = json_decode($datos);

    $id= "'".$ORDER_detail->{'InvoiceNumber'}."'";

  if($ORDER->{'Error'}=='1') { 

   $status= "Error : ".$ORDER->{'ErrorPT'}. 'Se ha cancelado la Orden';
   $style="style='color:red;'"; 


 } else{

    if($ORDER->{'Enviado'}!="1"){

      $style="style='color:orange;'"; 
      $status='Por Procesar'; }else{ 

        $status= "Sincronizado el: ".$ORDER->{'Export_date'};
         $style="style='color:green;'";

       }   

    }

$net_line = number_format($ORDER->{'Quantity'},2,'.',',') * number_format($ORDER->{'Unit_Price'},2,'.',',');

$PRICE = $this->numberFormatPrecision($ORDER->{'Unit_Price'});
$QTY =  $this->numberFormatPrecision($ORDER->{'Quantity'});
$NET_LINE =  $PRICE * $QTY;

$NET_LINE = $this->numberFormatPrecision($NET_LINE);

echo  "<tr>
          <td>".$ORDER->{'Item_id'}."</td>
          <td>".$ORDER->{'Description'}."</td>
          <td class='numb' >".$QTY."</td>
          <td class='numb' >".$PRICE ."</td>
          <td class='numb' >".$NET_LINE.'</td>
          <td '.$style.' >'.$status.'</td>
      </tr>';

  }

echo '</tbody></table></fieldset>';


}


public function CloseSelesOrder($id){

  $this->model->verify_session();

  $this->reverseItems($id);
  $this->CheckError();

  $table  = 'SalesOrder_Header_Imp';

  $columns = array('canceled' => 1 );

  $clause =  ' WHERE SalesOrderNumber = "'.$id.'" AND ID_compania =  "'.$this->model->id_compania.'"';

  $this->model->update($table,$columns,$clause);
  $this->CheckError();

    // $table  = 'SalesOrder_Header_Imp';

    // $clause = ' WHERE SalesOrderNumber = "'.$id.'" AND ID_compania =  "'.$this->model->id_compania.'"';

    //   $this->model->delete($table,$clause);

    //   $this->CheckError();

    // $table  = 'SalesOrder_Detail_Imp';

    // $clause = ' WHERE SalesOrderNumber = "'.$id.'" AND ID_compania =  "'.$this->model->id_compania.'"';


    //   $this->model->delete($table,$clause);

    //   $this->CheckError();

  echo 1;
}


public function reverseItems($aciId){

  $this->model->verify_session();

  $columns = array('ProductID',
                   'stockOrigID', 
                   'Qty');

  $items = $this->model->queryColumns('INV_EVENT_LOG',$columns, 'WHERE referencia="'.$aciId.'" and ID_compania="'.$this->model->id_compania.'"');
 
  foreach ($items as $key => $value) {
   
      $value =  json_decode($value);

      $qty = (- 1) * $value->{'Qty'};
      $this->reverseItemTransaction($value->{'ProductID'},$value->{'stockOrigID'},$aciId,$qty );

  }

}

public function reverseItemTransaction($item, $dest,$desc,$qty){  

    require_once APP.'controller/ges_inventario.php';

    $inv = new ges_inventario();


    
    $CURRENT_QTY = $this->model->Query_value('STOCK_ITEMS_LOCATION','qty','where id="'.$dest.'";');

    $NEWQTY = $CURRENT_QTY + $qty;
  
    //ACTUALIZA LA CANTIDAD RESTANTE EN LA UBICACION ACTUAL
    $query= 'UPDATE STOCK_ITEMS_LOCATION SET qty="'.$NEWQTY.'" where id="'.$dest.'";';
    $this->model->Query($query);

    usleep(1000);
    $error = $this->CheckError();
    if($error){
        $error= json_decode($error) ;
            echo 'ERROR: '.$error->{'E'}.' STOCK_ITEMS_LOCATION';
        die();
        
    }else{

        $values = array (
            'ItemID' => $item, 
            'Reference' => 'REV-'.$desc, 
            'Qty'  => $qty, 
            'aci_ref' => 'REV-'.$desc, 
            'stockOrigID' => 0,
            'stockDestID' => $dest);
    
            $inv->set_Budget_Log($values,'7');

        $error = $this->CheckError();
        if($error){
            $error= json_decode($error) ;
                echo 'ERROR: '.$error->{'E'}.' INV_EVENT_LOG';
            die();
        }


    }
      
}

public function GetDaylySales($date1,$date2,$pinter){


 $this->model->verify_session();


  $clause='';

  $clause.= 'where Sales_Header_Imp.ID_compania="'.$this->model->id_compania.'" and Sales_Header_Imp.InvoiceNumber <> ""';



  if($date1!=''){

    
    if($date2!=''){

        $clause.= ' and Sales_Header_Imp.date between "'.$date1.'%" and "'.$date2.'%" ';           
      }
    
    if($date2==''){ 

      $clause.= ' and Sales_Header_Imp.date like "'.$date1.'%"';
    }
      
  }else{

    $clause.= ' and date like "'.date('Y-m-d').'%"';

  }



  if($pinter!=''){ 

    $clause.= ' and Sales_Header_Imp.InvoiceNumber like "'.$pinter.'-%" ';

  }



  $query ='SELECT * FROM `Sales_Header_Imp` 
  inner JOIN `Sales_Detail_Imp` ON Sales_Header_Imp.InvoiceNumber = Sales_Detail_Imp.InvoiceNumber
  '.$clause.' 
  GROUP BY Sales_Header_Imp.InvoiceNumber order by LAST_CHANGE'; 

        
  $table.= '<script type="text/javascript">
  jQuery(document).ready(function($)

    {

    var table = $("#table_report").dataTable({

        paging: false,
        responsive: false,
        dom: "Blfrtip",
        bSort: true,
        bPaginate: true,
        select:true,

          buttons: [

            {

            extend: "excelHtml5",
            footer: true ,
            text: "Exportar",
            title: "Reporte_Diario_ventas",
            
            exportOptions: {

                  columns: ":visible",

                

                  format: {
  
                      header: function ( data ) {

                        var StrPos = data.indexOf("<div");

                          if (StrPos<=0){
                            
                            var ExpDataHeader = data;

                          }else{
                        
                            var ExpDataHeader = data.substr(0, StrPos); 

                          }
                        
                        return ExpDataHeader;
                        }
                      }
                  
                    }               

            }

          ],

          drawCallback: function () {
            var api = this.api();
            var numFormat = $.fn.dataTable.render.number( "\,", ".", 2, "$" ).display;


            $( api.column(5).footer() ).html(
              numFormat(api.column( 5, {page:"current"} ).data().sum())
            );
            $( api.column(6).footer() ).html(
              numFormat(api.column( 6, {page:"current"} ).data().sum())
            );
            $( api.column(7).footer() ).html(
              numFormat(api.column( 7, {page:"current"} ).data().sum())
            );
            $( api.column(8).footer() ).html(
              numFormat(api.column( 8, {page:"current"} ).data().sum())
            );

          }
    

      });



  table.yadcf([
  {column_number : 0,
  column_data_type: "html",
  html_data_type: "text" ,
  select_type: "select2",
  select_type_options: { width: "100%" }},
  {column_number : 1,
  select_type: "select2",
  select_type_options: { width: "100%" }},
  {column_number : 2,
  column_data_type: "html",
  html_data_type: "text" ,
  select_type: "select2",
  select_type_options: { width: "100%" }},
  {column_number : 3 ,
  select_type: "select2",
  select_type_options: { width: "100%" }},
  {column_number : 4,
  select_type: "select2",
  select_type_options: { width: "100%" }}
  ],
  {cumulative_filtering: true, 
  filter_reset_button_text: false});
        
    });
  </script>
    <table id="table_report" class="display  table table-condensed table-striped table-bordered"  >
      <thead>
        <tr>
          <th>DOCUMENTO FISCAL</th>
          <th>PEDIDO</th>        
          <th>CLIENTE</th>
          <th>FECHA</th>
          <th>NOMBRE</th>
          <th>CREDITO</th>
          <th>CONTADO</th>
          <th>DEVOLUCION</th>
          <th>ITBMS</th>
        </tr>
      </thead>';



  $filter =  $this->model->Query($query);


  foreach ($filter as $datos) {

  $filter = json_decode($datos);

  

  $OrdPedi = $this->model->Query_value('INVOICE_GEN_HEADER','SalesOrderNumber','WHERE InvoiceNumber="'.$filter->{'InvoiceNumber'}.'"');
  $OrdPediID ="'".$OrdPedi."'"; 

  $NOTA = $this->model->Query_value('INVOICE_GEN_HEADER','NOTAS','WHERE InvoiceNumber="'.$filter->{'InvoiceNumber'}.'"');

  list($nota,$typago) = explode('-',$NOTA);


  $contado = '0.00';
  $credito = '0.00';
  $devolucion = '0.00';

    if(trim($typago)=='CONTADO'){

      $contado = number_format($filter->{'Net_due'},2,'.',',');

    }else{
    
      if(trim($typago)==''){

      $credito = number_format( $filter->{'Net_due'},2,'.',',');

      }else{
      $credito= number_format( $filter->{'Net_due'},2,'.',',');
      }

    }




    if ($filter->{'OrderTax'}!=''){

    $tax = number_format( $filter->{'OrderTax'},2,'.',',');

    }else{

    $tax = '0.00';

    }



  $table.= '<tr>
      <td ><strong>'.$filter->{'InvoiceNumber'}.'</strong></td>
      <td ><strong>'.$OrdPedi."</strong></td>
      <td class='numb' >".$filter->{'CustomerID'}."</td>
      <td class='numb' >".date('d-m-Y',strtotime($filter->{'date'}))."</td>
      <td >".$filter->{'CustomerName'}.'</td>
      <td class="numb">'.$credito.'</td>
      <td class="numb">'.$contado.'</td>
      <td class="numb">'.$devolucion.'</td>
      <td class="numb">'.$tax."</td>
    </tr>";

  }



  $clause='';

  $clause.= 'where Customer_Credit_Memo_Header_Imp.ID_compania="'.$this->model->id_compania.'" and Customer_Credit_Memo_Header_Imp.CreditNumber <> ""';



  if($date1!=''){

    
    if($date2!=''){

        $clause.= ' and Customer_Credit_Memo_Header_Imp.Date between "'.$date1.'%" and "'.$date2.'%" ';           
      }
    
    if($date2==''){ 

      $clause.= ' and Customer_Credit_Memo_Header_Imp.Date like "'.$date1.'%"';
    }
      
  }else{

    $clause.= ' and Customer_Credit_Memo_Header_Imp.Date like "'.date('Y-m-d').'%"';

  }


  if($pinter!=''){ 

    $clause.= ' and Customer_Credit_Memo_Header_Imp.CreditNumber  like "'.$pinter.'-%" ';

  }


  $query ='SELECT * FROM `Customer_Credit_Memo_Header_Imp` 
  inner JOIN `Customer_Credit_Memo_Detail_Imp` ON Customer_Credit_Memo_Detail_Imp.TransactionID = Customer_Credit_Memo_Header_Imp.TransactionID
  '.$clause.' 
  GROUP BY Customer_Credit_Memo_Header_Imp.CreditNumber order by Customer_Credit_Memo_Header_Imp.TransactionID'; 


  $filter =  $this->model->Query($query);

  foreach ($filter as $datos) {

  $filter = json_decode($datos);

  $table.= '<tr>
      <td ><strong>'.$filter->{'CreditNumber'}.'</strong></td>
      <td ><strong>'.$filter->{'CreditNoteNumber'}."</strong></td>
      <td class='numb' >".$filter->{'CustomerID'}."</td>
      <td class='numb' >".date('d-m-Y',strtotime($filter->{'Date'}))."</td>
      <td >".$filter->{'CustomerName'}.'</td>
      <td class="numb">0.00</td>
      <td class="numb">0.00</td>
      <td class="numb">'.$filter->{'Net_Credit_due'}."</td>
      <td class='numb'>0.00</td>
    </tr>";



  }


  $table.= '<tfoot><tr>
          <td class="numb" ></td>
          <td class="numb" ></td>
          <td class="numb" ></td>
          <td class="numb" ></td>
          <td ><strong>TOTAL</strong></td>
          <td class="numb" ></td>
          <td class="numb" ></td>
          <td class="numb" ></td>
          <td class="numb" ></td>
          </tr>
          </tfoot>
          </table> ';



  echo $table;

}

//LISTA DE IMPRESORA FISCAL 
public function getPrinterList(){

  return $this->model->Query('SELECT * FROM INV_PRINT_CONF');

}


}
?>
