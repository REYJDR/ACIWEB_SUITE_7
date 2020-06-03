<?php



class bridge_query extends Controller
{



public function SESSION(){

  $this->model->verify_session();


}

public function get_items_by_invoice($invoice){

  $query = 'SELECT
  Purchase_Header_Exp.PurchaseID, 
  Purchase_Header_Exp.PurchaseNumber,
  Purchase_Header_Exp.VendorID,
  Products_Exp.ProductID,
  Products_Exp.Description,
  Products_Exp.UnitMeasure,
  Purchase_Detail_Exp.Quantity
  from Purchase_Header_Exp
  inner join  Purchase_Detail_Exp on Purchase_Header_Exp.PurchaseID = Purchase_Detail_Exp.PurchaseID
  inner join  Products_Exp on Products_Exp.ProductID = Purchase_Detail_Exp.Item_id
  where isActive="1" and Purchase_Header_Exp.PurchaseID="'.$invoice.'"';


$lote_ven = $this->model->Query($query);

foreach ($lote_ven as $value) {

  $PROD_FACT= json_decode($value);
  
                      
  echo '<tr>
          <td >'.$PROD_FACT->{'ProductID'}.'</td>
          <td >'.$PROD_FACT->{'Description'}.'</td>
          <td class="numb" >'.number_format($PROD_FACT->{'Quantity'},0, ',', '.').'</td>
          <td ><a href="'.URL.'index.php?url=ges_inventario/inv_info/'.$PROD_FACT->{'ProductID'}.'" >Ver <i class="fa  fa-search"></i></a></td>
        </tr>';

  }


}


public function get_ProductsInfoMob(){
$this->SESSION();

$ITEM = $_REQUEST['item'];

$sql= 'SELECT 
A.ProductID,
A.SalesDescription as Description,
A.UnitMeasure,
(SELECT SUM(qty) FROM STOCK_ITEMS_LOCATION WHERE itemID = ProductID and ID_compania="'.$this->model->id_compania.'") AS QtyOnHand,
A.Price1,
A.LastUnitCost,
A.TaxType,
A.UPC_SKU,
A.GL_Sales_Acct
FROM Products_Exp as A
WHERE 
A.IsActive="1"
AND  A.id_compania="'.$this->model->id_compania.'" 
AND  A.ProductID ="'.$ITEM.'"';


$res = $this->model->Query($sql);


  foreach ($res as  $value) {
      echo str_replace("'","",$value);
  }



}


public function get_ProductsList(){
  $this->SESSION();
  
  //$ITEM = $_REQUEST['item'];
  

  $sql= 'SELECT 
  A.ProductID,
  A.Description,
  A.SalesDescription,
  A.UnitMeasure,
  (SELECT SUM(qty) FROM STOCK_ITEMS_LOCATION WHERE itemID = ProductID and ID_compania="'.$this->model->id_compania.'") AS QtyOnHand,
  A.Price1,
  A.LastUnitCost,
  A.TaxType,
  A.UPC_SKU,
  A.GL_Sales_Acct
  FROM Products_Exp as A
  WHERE 
  A.IsActive="1"
  AND  A.id_compania="'.$this->model->id_compania.'" ';
 // AND  A.ProductID ="'.$ITEM.'"';
  
  
  $res = $this->model->Query($sql);
  

  return $res;
  }

public function get_ProductsInfo(){
$this->SESSION();

$ITEM = $_REQUEST['item'];

$sql= 'SELECT 
A.ProductID,
A.Description,
A.UnitMeasure,
(SELECT SUM(qty) FROM STOCK_ITEMS_LOCATION WHERE itemID = ProductID and ID_compania="'.$this->model->id_compania.'") AS QtyOnHand,
A.Price1,
A.LastUnitCost,
A.TaxType,
A.UPC_SKU,
A.GL_Sales_Acct
FROM Products_Exp as A
WHERE 
A.IsActive="1"
AND  A.id_compania="'.$this->model->id_compania.'" 
AND  A.ProductID ="'.$ITEM.'"';


$res = $this->model->Query($sql);


  foreach ($res as  $value) {
      echo str_replace("'","",$value);
  }



}


public function get_items_defaultstock_qty($item){
$this->SESSION();
$lote = $item.'0000';

$prod = $this->model->Query_value('status_location','qty','inner join Products_Exp on status_location.id_product = Products_Exp.ProductID
where stock="1" and route="1" and  lote="'.$lote.'" and Products_Exp.ID_compania ="'.$this->model->id_compania.'"');

echo $prod;
}

public function get_ProductsPrice($itemid,$listid){
$this->SESSION();


$price = $this->model->Query_value('PRI_LIST_ITEM','PRICE','WHERE IDPRICE="'.$listid.'" AND IDITEM="'.$itemid.'" AND ID_compania ="'.$this->model->id_compania.'"');

echo $price;
 

}

public function get_lote_selectlist($itemid){
$this->SESSION();


$query_lotes = 'SELECT lote 
FROM status_location 
where id_product="'.$itemid.'" and stock="1" and route="1" and onoff="1" and qty > 0 and ID_compania ="'.$this->model->id_compania.'"';

$query_almacen= 'SELECT almacenes.id, almacenes.name  
FROM almacenes 
inner join ubicaciones on ubicaciones.id_almacen = almacenes.id
where almacenes.onoff="1" GROUP BY almacenes.name ';

$url = "'".URL."'";
$itemid =  "'".$itemid."'";

$table='<fieldset><legend><h4>Agregar lote a nueva ubicacion</h4></legend>
<table class="dataTable">
<tr>
<th>No. Lote</th>
<th>Cantidad</th>
<th>Almacen</th>
<th>Ruta</th></tr>
<tr><td><select id="no_lote" class="form-control col-xs-4" onchange="set_qty('.$url.','.$itemid.',this.value);" >
<option selected disabled>Seleccionar lote</option>';
$res = $this->model->Query($query_lotes);

foreach ($res as $value) {
  $value = json_decode($value);
  $table.='<option value="'.$value->{'lote'}.'">'.$value->{'lote'}.'</option>';
  }

$table.='</select></td>
<td><input class="form-control col-xs-4" type="number" id="qty_new" name="qty_new" min="1" max="" required readonly="true"/></td>
<td><select onchange="routes(this.value);" class="form-control col-xs-4" id="almacen" name="almacen" readonly="true">
<option selected disabled>Seleccionar Almacen</option>';
$res = $this->model->Query($query_almacen);

foreach ($res as $value) {
  $value = json_decode($value);
  $table.='<option value="'.$value->{'id'}.'">'.$value->{'name'}.'</option>';
  }

$table.='</select></td>
<td><select class="form-control col-xs-4" id="routes" name="routes" readonly="true"></select></td>
<td><button onclick="add_location_route();"  class="btn btn-primary  btn-block text-left" type="submit" >Ubicar</button></td>
<td><button class="btn btn-warning btn-block text-left" onclick="javascript: location.reload();" >cancelar</button></td></tr>
</table>
</fieldset>';

echo $table;
}



/*

public function clear_lotacion_register(){

$query= 'select status_location.id from status_location 
inner join sale_pendding on sale_pendding.status_location_id = status_location.id 
where sale_pendding.status_pendding ="0"';

$id = $this->model->Query($query);

foreach ($id as  $value) {
  $value  = json_decode($value);
 $id =  $value ->{'id'};
}

$query = 'delete from status_location where id="'.$id.'";';
$this->model->Query($query);

}*/

//modificacion rey 23/11
public function get_items_location_by_lote($itemid){


$this->SESSION();


$query = 'SELECT 
lote ,
id as id_location,
(select name from almacenes where almacenes.id=status_location.stock) as stock,
(select etiqueta from ubicaciones where ubicaciones.id=status_location.route) as route,
(select qty from Prod_Lotes where Prod_Lotes.no_lote=status_location.lote) as qty,
(select fecha_ven from Prod_Lotes where Prod_Lotes.no_lote=status_location.lote) as venc,
(select Price1 from Products_Exp where Products_Exp.ProductID=status_location.id_product) as Price,
(select Description from Products_Exp where Products_Exp.ProductID=status_location.id_product) as Descr,
(select UnitMeasure from Products_Exp where Products_Exp.ProductID=status_location.id_product) as UnitMeasure
FROM status_location 
where id_product="'.$itemid.'" and status_location.ID_compania ="'.$this->model->id_compania.'"';

$res = $this->model->Query($query);


echo '<script type="text/javascript">
    $("#modal_table").dataTable({
      
      pageLength: 5
              
            });
</script>

<table id="modal_table" widht="100%" class="table table-striped"  cellspacing="0">
            <thead>
              <tr>  
                
                <th width="20%" >Almacen</th>
                <th width="20%" >Ruta</th>
                <th width="25%" >Lote</th>
                <th width="5%"  >Stock</th>
                <th width="10%" >Cant.</th>
                <th width="15%" >Venc.</th>
                <th width="5%" >Taxable</th>
              </tr>
            </thead><tbody>';


foreach ($res as $key => $value) {

$value = json_decode($value);

$PRICE =  $value->{'Price'};
$UNI =  $value->{'UnitMeasure'};
$NAME =  $value->{'Descr'};
$Lote =  $value->{'lote'};
$FECHA_VEN =  $value->{'venc'};
$STOCK =  $value->{'stock'};
$TAG_LOCATION =  $value->{'route'};
$ID_LOCATION = $value->{'id_location'};
$QTY = number_format($value->{'qty'},5, '.',',');



$ID_PRO="'".$itemid."'";
$PRICE="'".$PRICE."'";
$UNI_PRO="'".$UNI."'";
$NAME_PRO="'".$NAME."'";
$LOTE= "'".$Lote."'" ;
$VENC=  "'".str_replace('/','-', $FECHA_VEN)."'";
$RUTA= "'".$TAG_LOCATION."'";         
$QTYMAX =    "'".$value->{'qty'}."'"; 

$chk_val = $this->model->Query_value('Products_Exp','TaxType','WHERE ProductID="'.$itemid.'"');

if($chk_val=='1'){

$checked='checked disabled';
$chk_val='checked';

}else{

 $checked='disable'; 
 $chk_val='';
}

if($FECHA_VEN!='0000-00-00 00:00:00' and $FECHA_VEN!=null){
       $FECHA_VEN = date('Y-m-d',strtotime($FECHA_VEN));
     }else{
       $FECHA_VEN = '';
  }


if($QTY>=1){

  //<a href="javascript:void(0)" onclick="javascript: agregar_pro_sale_sale('.$ID_PRO.','.$NAME_PRO.','.$PRICE.','.$LOTE.','.$VENC.','.$RUTA.','.$QTYMAX.','.$UNI_PRO.');" ><i style="color:green" class="fa fa-plus"></i></a>

  $id_validar = "'".$Lote.$TAG_LOCATION."qty'";

//<td width="5%"><input type="checkbox" id="'.$Lote.$TAG_LOCATION.'" /></td>
  
 echo '<tr>
                  <td width="20%">'.$STOCK.'</td>
                  <td width="20%">'.$TAG_LOCATION.'</td>
                  <td width="25%">'.$Lote.'</td>
                  <td width="5%" class="numb" >'.$QTY.'</td>
                  <td width="10%"><input type="number" id="'.$Lote.$TAG_LOCATION.'qty" min="0.00001" max="'.$QTY.'" value=""  /></td>
                  <td width="15%" >'.$FECHA_VEN.'</td>
                  <td width="5%" ><input type="checkbox"  id="'.$Lote.$TAG_LOCATION.'taxable"  value="'.$chk_val.'" '.$checked.' />
                  </td>
                 </tr>';

}           


}

echo '</tbody></table>';

}
//modificacion rey 23/11
public function get_Cust_info(){

$custid= $_REQUEST['id'];

$query = 'SELECT * FROM Customers_Exp WHERE ID="'.$custid.'";';

$res = $this->model->Query($query);

echo $res[0];

}

public function get_Cust_info_int($custid){

$query = 'SELECT * FROM Customers_Exp WHERE ID="'.$custid.'";';

$res = $this->model->Query($query);

return $res[0];

}





public function set_sales_order_detail($SalesOrderNumber){

$this->SESSION();

$id_compania= $this->model->id_compania;


$data = json_decode($_GET['Data']);

foreach ($data as $index => $value) {


if($value){



list($itemid,$unit_price,$qty,$Price,$lote,$ruta,$venc) = explode('@', $value );


$chk_cur_val =  $this->model->Query_value('FAC_DET_CONF','DIV_LINE','where ID_compania="'.$this->model->id_compania .'"');

if (!$chk_cur_val){

    if($venc!=''){
           $venc = date('Y-m-d',strtotime($venc));
         }else{
           $venc = '';
      }


    //IF ITEMS EXIST
    $clause='where Item_id="'.$itemid.'" and SalesOrderNumber="'.$SalesOrderNumber.'" and ID_compania="'.$id_compania.'";';
    $ID = $this->model->Query_value('SalesOrder_Detail_Imp','ID',$clause);



    if ($ID==''){

          $values1 = array(
          'ItemOrd' => $index,
          'ID_compania'=>$id_compania,
          'SalesOrderNumber'=>$SalesOrderNumber,
          'Item_id'=>$itemid,
          'Description'=>$this->model->Query_value('Products_Exp','Description','Where ProductID="'.$itemid.'";'),
          'Quantity'=>$qty,
          'Unit_Price'=>$unit_price,
          'Net_line'=>$Price,
          'Taxable'=>'1');

           $this->model->insert('SalesOrder_Detail_Imp',$values1); //set item line

            //SI TIENE MODULO DE UBICACIONES
          if($mod_stoc_CK == 'checked' ){ 

                if ($venc!=''){

                  $caduc =   'Vence :'.$venc.' ';

                }else{

                  $caduc = '';

                }


              $Description = 'Lote :'.$lote.' '.$caduc.' Cant.:'.$qty;

            

              $values2 = array(
              'ItemOrd' => $index,
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

    }else{

          $QUERY='SELECT Quantity, Unit_Price FROM SalesOrder_Detail_Imp where ID="'.$ID.'"';

          $QTY_PRI = $this->model->Query($QUERY);

                foreach ($QTY_PRI  AS $QTY_PRI) {

                $QTY_PRI = json_decode($QTY_PRI);

                $now_qty = $QTY_PRI->{'Quantity'}+$qty;
                $net_line= $QTY_PRI->{'Unit_Price'} * $now_qty;

                }


          $query= 'UPDATE SalesOrder_Detail_Imp SET Quantity="'.$now_qty.'" , Net_line="'.$net_line.'" where ID="'.$ID.'";';
          $this->model->Query($query);

       //SI TIENE MODULO DE UBICACIONES
       if($mod_stoc_CK == 'checked' ){ 

          if ($venc!=''){

              $caduc =   'Vence :'.$venc.' ';
              
            }else{

              $caduc = '';

            }

          $Description = 'Lote :'.$lote.' '.$caduc.' Cant.:'.$qty;

          $values2 = array(
          'ItemOrd' => $index,
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

      $values1 = array(
      'ItemOrd' => $index,
      'ID_compania'=>$id_compania,
      'SalesOrderNumber'=>$SalesOrderNumber,
      'Item_id'=>$itemid,
      'Description'=>$this->model->Query_value('Products_Exp','Description','Where ProductID="'.$itemid.'";'),
      'Quantity'=>$qty,
      'Unit_Price'=>$unit_price,
      'Net_line'=>$Price,
      'Taxable'=>'1');

       $this->model->insert('SalesOrder_Detail_Imp',$values1); //set item line


       //SI TIENE MODULO DE UBICACIONES
       if($mod_stoc_CK == 'checked' ){ 

              if ($venc!=''){

                $caduc =   'Vence :'.$venc.' ';

              }else{

                $caduc = '';

              }


            $Description = 'Lote :'.$lote.' '.$caduc.' Cant.:'.$qty;


            $values2 = array(
            'ItemOrd' => $index,
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





$ruta = $this->model->Query_value('ubicaciones','id','Where etiqueta="'.$ruta.'";');

$values3 = array(
'SaleOrderId'=>$SalesOrderNumber,
'no_lote'=>$lote,
'ProductID'=>$itemid,
'qty'=>$qty,
'status_pendding' => '1',
'status_location_id' => $this->model->Query_value('status_location','id','Where id_product="'.$itemid.'" and lote="'.$lote.'" and route="'.$ruta.'" and ID_compania="'.$id_compania.'";'),
'ID_compania' => $id_compania
);


$this->model->insert('sale_pendding',$values3);

//UBICO LA CANTIDAD ACTUAL EN STATUS_LOCATION
$CURRENT_QTY = $this->get_any_lote_qty($lote,$itemid,$ruta);

//ACTUALIZO LA CANTIDAD EN LA UBICCION DEFAULT
$QTY_TO_SET = $CURRENT_QTY - $qty;

$query= 'UPDATE status_location SET qty="'.$QTY_TO_SET.'" where lote="'.$lote.'" and id_product="'.$itemid.'" and route="'.$ruta.'" and ID_compania="'.$id_compania.'"';


$res = $this->model->Query($query);


 

}


}

echo '1';
}





public function set_sal_merc(){

$this->SESSION();
$id_compania= $this->model->id_compania;
$id_user_active = $this->model->active_user_id;

$reasonToAd = $_REQUEST['REASON'];

$Jobinfo = $_REQUEST['JOB'];
list($JobDesc,$JobPhase,$JobCost) = explode(';', $Jobinfo);

$orderID = $this->model->Get_Ref_No(); 

$data = json_decode($_REQUEST['Data']);

foreach ($data as $index => $value) {


if($value){


list($itemID,$qty,$lote,$ruta,$fecha_ven) = explode('@', $value);



$id_GLacct = $this->model->Query_value('CTA_GL_CONF','GLACCT','where ID_compania="'.$this->model->id_compania .'";');
$ruta = $this->model->Query_value('ubicaciones','id','Where etiqueta="'.$ruta.'";');
$LastUnitCost = $this->model->Query_value('Products_Exp','LastUnitCost','Where ProductID="'.$itemID.'" and id_compania="'.$id_compania.'";');

//echo 'LUC'.$LastUnitCost;

$UnitCost = $qty*$LastUnitCost;

$qty = (-1)*$qty;



$values = array(
'ItemID' => $itemID,
'ID_compania' => $this->model->id_compania,
'Reference' => $orderID,
'ReasonToAdjust' => $reasonToAd,
'Account' => $id_GLacct,
'Quantity' => $qty,
'Job_id_int' => $JobID,
'USER' => $id_user_active,
'JobID' => $JobDesc,
'JobPhaseID' =>  $JobPhase,
'JobCostCodeID' => $JobCost,
'UnitCost' => $UnitCost ,
'Date' => date('Y-m-d'),
'location_id' => $this->model->Query_value('status_location','id','where lote="'.$lote.'" and id_product="'.$itemID.'" and route="'.$ruta.'" and ID_compania="'.$this->model->id_compania.'"')
);


$this->model->insert('InventoryAdjust_Imp',$values);

// ******************************************************************************************************************


//UBICO LA CANTIDAD ACTUAL EN STATUS_LOCATION
$CURRENT_QTY = $this->get_any_lote_qty($lote,$itemID,$ruta);

//ACTUALIZO LA CANTIDAD EN LA UBICCION DEFAULT
$QTY_TO_SET = $CURRENT_QTY + $qty; //(qty viene con signo negativo)

$query= 'UPDATE status_location SET qty="'.$QTY_TO_SET.'" where lote="'.$lote.'" and id_product="'.$itemID.'" and route="'.$ruta.'" and ID_compania="'.$this->model->id_compania.'"';


$res = $this->model->Query($query);

}

}
echo $orderID;
}

public function get_invadj_info($id,$resp){


$this->SESSION();


$query ='SELECT * FROM `InventoryAdjust_Imp` 
inner JOIN `status_location` ON status_location.id = InventoryAdjust_Imp.location_id
inner JOIN `SAX_USER` ON `SAX_USER`.`id` = InventoryAdjust_Imp.USER where InventoryAdjust_Imp.Reference ="'.$id.'" and  
status_location.ID_compania="'.$this->model->id_compania.'" GROUP BY InventoryAdjust_Imp.Reference';



$ORDER_detail= $this->model->Query($query);


echo '<br/><br/><fieldset><legend>Detalle de Salida de Mercancia</legend><table class="table table-striped table-bordered" cellspacing="0"  ><tr>';

  foreach ($ORDER_detail as $datos) {
    $ORDER_detail = json_decode($datos);

$Proyecto= $this->model->Query_value('Jobs_Exp','JobID','where ID="'.$ORDER_detail->{'JobID'}.'"');

    echo "<th><strong>No. Referencia</strong></th><td class='InfsalesTd order'>".str_pad($ORDER_detail->{'Reference'}, 7 ,"0",STR_PAD_LEFT)."</td>
          <th><strong>Fecha</strong></th><td class='InfsalesTd'>".$ORDER_detail->{'Date'}."</td>
          <th><strong>Proyecto</strong></th><td class='InfsalesTd'>".$ORDER_detail->{'JobID'}.' / '.$ORDER_detail->{'JobPhaseID'}.' / '.$ORDER_detail->{'JobCostCodeID'}."</td>
          <th><strong>Descripcion</strong></th><td class='InfsalesTd'>".$ORDER_detail->{'ReasonToAdjust'}."</td>
          <th><strong>Responsable</strong></th><td class='InfsalesTd'>".$resp."</td>";

}



echo "</tr></table>";

$query ='SELECT * FROM `InventoryAdjust_Imp` 
inner JOIN `status_location` ON status_location.id = InventoryAdjust_Imp.location_id
inner JOIN `SAX_USER` ON `SAX_USER`.`id` = InventoryAdjust_Imp.USER where InventoryAdjust_Imp.Reference ="'.$id.'" and  
status_location.ID_compania="'.$this->model->id_compania.'"';


$ORDER= $this->model->Query($query);

echo '<table id="example-12" class="table table-striped table-bordered" cellspacing="0"  >
      <thead>
        <tr>
          <th>Codigo</th>
          <th>Descripcion</th>
          <th>Cantidad</th>
          <th>Unidad</th>
          <th>Estado Sinc.</th>
        </tr>
      </thead><tbody>';


foreach ($ORDER as $datos) {

    $ORDER = json_decode($datos);

    $id= "'".$ORDER_detail->{'SalesOrderNumber'}."'";

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

$quantity = number_format($ORDER->{'Quantity'},2,'.',',')*(-1);

$prod_desc = $this->model->Query_value('Products_Exp','Description','where ProductID="'.$ORDER->{'ItemID'}.'"');

$prod_measure= $this->model->Query_value('Products_Exp','UnitMeasure','where ProductID="'.$ORDER->{'ItemID'}.'"');

echo  "<tr>
          <td>".$ORDER->{'ItemID'}."</td>
          <td>".$prod_desc."</td>
          <td>".$quantity."</td>
          <td>".$prod_measure.'</td>
          <td '.$style.' >'.$status.'</td>
      </tr>';

  }

echo '</tbody></table><div style="float:right;" class="col-md-2">
<a href="'.URL.'index.php?url=ges_ventas/ges_print_SalMerc/'.$ORDER_detail->{'Reference'}.'"  class="btn btn-block btn-secondary btn-icon btn-icon-standalone btn-icon-standalone-right btn-single text-left">
   <img  class="icon" src="img/Printer.png" />
  <span>Imprimir</span>
</a>
</div></fieldset>';





}




public function set_almacen($name){


$id = $this->model->Query('SELECT id from almacenes where name="'.$name.'" and onoff="1";');

foreach ($id as $value) {

$value = json_decode($value);

 $id = $value->{'id'};

}

if($id==''){ 

 $value = array('name' => $name);

 $this->model->insert('almacenes',$value);

 echo 'Se ha agregado el nuevo almacen';

}else{

    echo 'El nombre de almacen ya existe';

 }

}


public function set_location($id_almacen,$ruta){

$check= $this->model->Query('select * from ubicaciones where etiqueta="'.$ruta.'";');

foreach ($check as $value) {

 $value = json_decode($value);

 $id=$value->{'id'};
}

if($id==''){

$value = array(
  'id_almacen' => $id_almacen,
  'etiqueta' => $ruta
  );



$this->model->insert('ubicaciones',$value);


Echo 'La ubicacion '.$ruta.' se ha creado con exito';

}else{ 

Echo 'La ubicacion '.$ruta.' ya existe ';
}

}


public function get_item_filter_by_stock($id_stock){


$this->SESSION();

$query = '
SELECT *
FROM status_location 
inner join Products_Exp on status_location.id_product = Products_Exp.ProductID
where  stock="'.$id_stock.'" and Products_Exp.ID_compania ="'.$this->model->id_compania.'" ';



$prod = $this->model->Query($query);




$table.= '<script>
var table = $("#items_ubicaciones").dataTable({
      aLengthMenu: [
        [10, 25,50,-1], [10, 25, 50,"All"]
      ]
    });

table.yadcf([
{column_number : 0},
{column_number : 1},
{column_number : 2}
]); 
</script>

<table id="items_ubicaciones" class="table table-striped responsive">
            <thead>
              <tr>
                <th width="20%">Id</th>
                <th width="30%">Descripcion</th>
                <th width="20%">Lote</th>
                <th width="10%">Cant. Disp.</th>
                <th width="10%">Cant. Pend.</th>
                <th width="10%">Almacen</th>
                <th width="10%">Ruta</th></tr>
            </thead>
            <tbody> ';

foreach ($prod as $value) {

$prod = json_decode($value);


$Descr = $this->model->Query_value('Products_Exp','Description',' where ProductID="'.$prod->{'id_product'}.'" ');

$stock = $this->model->Query_value('almacenes','name',' where id="'.$prod->{'stock'}.'"');

$route = $this->model->Query_value('ubicaciones','etiqueta',' where id="'.$prod->{'route'}.'"');

$sale_pendding = $this->model->Query_value('sale_pendding','qty',' where status_pendding="1" and status_location_id="'.$prod->{'id'}.'" and no_lote="'.$prod->{'lote'}.'" and ID_compania="'.$this->model->id_compania.'" ');

if($sale_pendding>=1 || $prod->{'qty'}>=1){

$table.= '<tr><td>'.$prod->{'id_product'}.'</td><td>'.$Descr.'</td><td>'.$prod->{'lote'}.'</td><td>'.$prod->{'qty'}.'</td><td style="background-color:#F5A9A9;" >'.$sale_pendding.'</td><td>'.$stock.'</td><td>'.$route.'</td></tr>';

}



  }          


$table.='</tbody>
            </table>';



echo $table;
  

}


public function  get_item_filter_by_route($id_route){


$this->SESSION();


$query = '
SELECT *
FROM status_location 
inner join Products_Exp on status_location.id_product = Products_Exp.ProductID
where route="'.$id_route.'" and  Products_Exp.ID_compania ="'.$this->model->id_compania.'" ';


$prod = $this->model->Query($query);




$table.= '<script>
var table = $("#items_ubicaciones").dataTable({
      aLengthMenu: [
        [10, 25,50,-1], [10, 25, 50,"All"]
      ]
    });

table.yadcf([
{column_number : 0},
{column_number : 1},
{column_number : 2}
]); 
</script>

<table id="items_ubicaciones" class="table table-striped responsive">
            <thead>
              <tr>
                <th width="20%">Id</th>
                <th width="30%">Descripcion</th>
                <th width="20%">Lote</th>
                <th width="10%">Cant. Disp.</th>
                <th width="10%">Cant. Pend.</th>
                <th width="10%">Almacen</th>
                <th width="10%">Ruta</th></tr>
            </thead>
            <tbody> ';

foreach ($prod as $value) {

$prod = json_decode($value);


$Descr = $this->model->Query_value('Products_Exp','Description',' where ProductID="'.$prod->{'id_product'}.'" ');

$stock = $this->model->Query_value('almacenes','name',' where id="'.$prod->{'stock'}.'"');

$route = $this->model->Query_value('ubicaciones','etiqueta',' where id="'.$prod->{'route'}.'"');

$sale_pendding = $this->model->Query_value('sale_pendding','qty',' where status_pendding="1" and status_location_id="'.$prod->{'id'}.'" and no_lote="'.$prod->{'lote'}.'" and ID_compania="'.$this->model->id_compania.'"');

if($sale_pendding>=1 || $prod->{'qty'}>=1){

$table.= '<tr><td>'.$prod->{'id_product'}.'</td><td>'.$Descr.'</td><td>'.$prod->{'lote'}.'</td><td>'.$prod->{'qty'}.'</td><td style="background-color:#F5A9A9;" >'.$sale_pendding.'</td><td>'.$stock.'</td><td>'.$route.'</td></tr>';

}



  }          


$table.='</tbody>
            </table>';



echo $table;

  

}

public function erase_account($id){

$query='UPDATE SAX_USER SET onoff="0" where id="'.$id.'"';

$this->model->Query($query);


}




/////////////////////////////////////////////////////////////////////////////////////////////////////////////
// SALIDA DE MERCANCIA

public function Get_SalMerc($sort,$limit,$date1,$date2){

$this->SESSION();



$clause='';

$clause.= 'where InventoryAdjust_Imp.ID_compania="'.$this->model->id_compania.'" ';



if($date1!=''){

   if($date2!=''){

      $clause.= ' and Date between "'.$date1.'" and "'.$date2.'" ';           
    }
   
   if($date2==''){ 

     $clause.= ' and Date ="'.$date1.'"';
   }
     
}



if($this->model->active_user_role=='admin'){

$query ='SELECT * FROM `InventoryAdjust_Imp` 
inner JOIN `status_location` ON status_location.id = InventoryAdjust_Imp.location_id
inner JOIN `SAX_USER` ON `SAX_USER`.`id` = InventoryAdjust_Imp.USER '.$clause.' 
and   status_location.ID_compania="'.$this->model->id_compania.'"
GROUP BY InventoryAdjust_Imp.Reference order by InventoryAdjust_Imp.Reference '.$sort.' limit '.$limit ;

 }

if($this->active_user_role=='user'){

  if($clause!=''){ $clause.= 'and `SAX_USER`.`id`="'.$this->active_user_id.'"'; } else{ $clause.= ' Where `SAX_USER`.`id`="'.$this->active_user_role_id.'"'; }

$query ='SELECT * FROM `InventoryAdjust_Imp` 
inner JOIN `status_location` ON status_location.id = InventoryAdjust_Imp.location_id
inner JOIN `SAX_USER` ON `SAX_USER`.`id` = InventoryAdjust_Imp.USER '.$clause.' 
and   status_location.ID_compania="'.$this->model->id_compania.'"
GROUP BY InventoryAdjust_Imp.Reference order by Date '.$sort.' limit '.$limit ;

}

       
$table.= '<script type="text/javascript">

  jQuery(document).ready(function($)
  {
     var table = $("#table_report").dataTable({

      responsive: true,
      dom: "Blfrtip",
      bSort: true,
      bPaginate: true,
      select:true,

        buttons: [

          {

          extend: "excelHtml5",
          text: "Exportar",
          title: "Reporte_ventas",
           
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

          },

          {

          extend:  "colvis",

          text: "Seleccionar",

          columns: ":gt(0)"           

         },

         {

          extend: "colvisGroup",
          text: "Ninguno",
          show: [0],
          hide: [":gt(0)"]

          },

          {

            extend: "colvisGroup",
            text: "Todo",
            show: ["*"]

          }

          ]

   

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
 select_type: "select2",
 select_type_options: { width: "100%" }},

{column_number : 3 ,
 select_type: "select2",
 select_type_options: { width: "100%" }},

{column_number : 4,
 select_type: "select2",
 select_type_options: { width: "100%" }},

{column_number : 5,
 select_type: "select2",
 select_type_options: { width: "100%" }}

],
{cumulative_filtering: true, 
filter_reset_button_text: false});
   
});
  </script>
  <table id="table_report" class="tableReport table table-bordered table-striped" cellspacing="0"  >
    <thead>
      <tr>
        <th>No. Referencia</th>
        <th>Fecha</th>
        <th>Descripcion</th>
        <th>Proyecto</th>
        <th>Procesado por:</th>
        <th>Estado</th>
        
      </tr>
    </thead>
    <tfoot>
      <tr>
        <th>No. Referencia</th>
        <th>Fecha</th>
        <th>Descripcion</th>
        <th>Proyecto</th>
        <th>Procesado por:</th>
        <th>Estado</th>
      </tr>
    </tfoot>';



$filter =  $this->model->Query($query);

$URL ='"'.URL.'"';

foreach ($filter as $datos) {

  $filter = json_decode($datos);


  $ID ='"'.$filter->{'Reference'}.'"';

   if($filter->{'Error'}==1) { 

     $status= "Error : ".$filter->{'ErrorPT'}. 'Cancelado';
     $style="style='color:red; font-style:bold;'"; 


   } else{

    if($filter->{'Enviado'}==0){

      $style="style='color:orange; font-style:bold;'"; 
      $status='No sincronizado';

       }else{ 

         $status= "Enviado";
         $style="style='color:green; font-style:bold;'";

       }   

    }



$user = $this->model->Get_User_Info($filter->{'USER'}); 

foreach ($user as $value) {
$value = json_decode($value);
$name= $value->{'name'};
$lastname = $value->{'lastname'};
}

$resp = '"'.$name.' '.$lastname.'"';

$table.= "<tr>
    <td ><a href='#' onclick='javascript: show_invadj(".$URL.",".$ID.",".$resp."); ' >".$filter->{'Reference'}."</a></td>
    <td class='numb' >".$filter->{'Date'}."</td>
    <td >".$filter->{'ReasonToAdjust'}.'</td>
    <td >'.$filter->{'JobID'}.'</td>
    <td >'.$name.' '.$lastname.'</td>
    <td '.$style.'>'.$status."</td>
   </tr>";

}

$table.= '</table>';

echo $table;


}





public function set_sales_header($ID_compania,$SalesOrderNumber,$CustomerID,$Subtotal,$TaxID,$Net_due,$user){


$this->SESSION();


$SalesOrderNumber = trim(preg_replace('/000+/','',$SalesOrderNumber));



$values = array(
'ID_compania'=>$ID_compania,
'InvoiceNumber'=>$SalesOrderNumber,
'CustomerID'=>$this->model->Query_value('Customers_Exp','CustomerID','Where ID="'.$CustomerID.'";'),
'CustomerName'=>$this->model->Query_value('Customers_Exp','Customer_Bill_Name','Where ID="'.$CustomerID.'";'),
'Subtotal'=>$Subtotal,
'TaxID'=>$TaxID,
'Net_due'=>$Net_due,
'user'=>$user,
'date'=>date("Y-m-d"),
'saletax'=>$this->model->Query_value('sale_tax','rate','Where taxid="'.$TaxID.'";')
);


//echo var_dump($values);

$this->model->insert('Sales_Header_Imp',$values);

}

public function set_sales_detail($ID_compania,$itemid,$unit_price,$SalesOrderNumber,$qty,$Price,$lote,$ruta,$venc,$arrLen,$count){


$SalesOrderNumber = trim(preg_replace('/000+/','',$SalesOrderNumber));

//IF ITEMS EXIST
$clause='where Item_id="'.$itemid.'" and InvoiceNumber="'.$SalesOrderNumber.'";';

$ID = $this->model->Query_value('Sales_Detail_Imp','ID',$clause);



if ($ID==''){


      $values1 = array(
      'ID_compania'=>$ID_compania,
      'invoiceNumber'=>$SalesOrderNumber,
      'Item_id'=>$itemid,
      'Description'=>$this->model->Query_value('Products_Exp','Description','Where ProductID="'.$itemid.'";'),
      'Quantity'=>$qty,
      'Unit_Price'=>$unit_price,
      'Net_line'=>$Price,
      'Taxable'=>'1');

      //echo  'insert';

      $this->model->insert('Sales_Detail_Imp',$values1); //set item line



}else{

$QUERY='SELECT Quantity, Unit_Price FROM Sales_Detail_Imp where ID="'.$ID.'";';

$QTY_PRI = $this->model->Query($QUERY);

foreach ($QTY_PRI  AS $QTY_PRI) {

$QTY_PRI = json_decode($QTY_PRI);

$now_qty = $QTY_PRI->{'Quantity'}+$qty;
$net_line= $QTY_PRI->{'Unit_Price'} * $now_qty;

}



 //echo  'qty: '.$now_qty;
 //echo  'netline: '.$net_line;

      $query= 'UPDATE Sales_Detail_Imp SET Quantity="'.$now_qty.'" , Net_line="'.$net_line.'" where ID="'.$ID.'";';

    //  echo  'query: '.$query;
      

      $this->model->Query($query);


}



$values2 = array(
'ID_compania'=>$ID_compania,
'InvoiceNumber'=>$SalesOrderNumber,
'Item_id'=>'',
'Description'=>'Lote : '.$lote.' / Venc. :'.$venc. '/ Ubicacion: '.$ruta,
'Quantity'=>'0',
'Unit_Price'=>'0',
'Net_line'=>'0',
'Taxable'=>'1');



$this->model->insert('Sales_Detail_Imp',$values2);//set lote line


$ruta = $this->model->Query_value('ubicaciones','id','Where etiqueta="'.$ruta.'";');


$values3 = array(
'SaleOrderId'=>$SalesOrderNumber,
'no_lote'=>$lote,
'ProductID'=>$itemid,
'qty'=>$qty,
'status_pendding' => '1',
'status_location_id' => $this->model->Query_value('status_location','id','Where id_product="'.$itemid.'" and lote="'.$lote.'" and route="'.$ruta.'" and ID_compania="'.$this->model->id_compania.'";')
);



$this->model->insert('sale_fact_pendding',$values3);



//UBICO LA CANTIDAD ACTUAL EN STATUS_LOCATION
$CURRENT_QTY = $this->get_any_lote_qty($lote,$itemid,$ruta);

//ACTUALIZO LA CANTIDAD EN LA UBICCION DEFAULT
$QTY_TO_SET = $CURRENT_QTY - $qty;

$query= 'UPDATE status_location SET qty="'.$QTY_TO_SET.'" where lote="'.$lote.'" and id_product="'.$itemid.'" and route="'.$ruta.'" and ID_compania="'.$this->model->id_compania.'"';

$res = $this->model->Query($query);

//$this->clear_lotacion_register();
if($count==$arrLen){ echo '1';}else{ echo '0';}
}







public function get_ProductsCode(){

$this->SESSION();

$itemFilter = $this->model->Query_value('FAC_DET_CONF','ITEMS_FILTER','WHERE ID_compania="'.$this->model->id_compania.'"');

if($itemFilter){

  $clause= ' and '.$itemFilter;

}else{

  $clause= '';
}

/*$sql = 'SELECT ProductID , 
               Description ,
              (SELECT SUM(qty) FROM STOCK_ITEMS_LOCATION WHERE itemID = ProductID and ID_compania="'.$this->id_compania.'") AS QtyOnHand,
          FROM Products_Exp 
          WHERE   id_compania="'.$this->model->id_compania.'" '.$clause;*/

    $sql =  'SELECT ProductID , 
                    Description ,
                    QtyOnHand
                    
              FROM  Products_Exp 
      
              WHERE id_compania="'.$this->model->id_compania.'" '.$clause;    



$Codigos = $this->model->Query($sql);

foreach ($Codigos as $value) {

  $value = json_decode($value);
   
  $codes .= '<option value="'.$value->{'ProductID'}.'">'.$value->{'ProductID'}.'-'.$value->{'Description'}.'</option>';

 } 

echo $codes;

}

public function get_ProductsCodeMobile(){
  
  $this->SESSION();
  
  $itemFilter = $this->model->Query_value('FAC_DET_CONF','ITEMS_FILTER','WHERE ID_compania="'.$this->model->id_compania.'"');
  
  if($itemFilter){
  
    $clause= ' and '.$itemFilter;
  
  }else{
  
    $clause= '';
  }
  
  
  
      $sql =  'SELECT ProductID , 
                      SalesDescription ,
                      QtyOnHand, 
                      (SELECT SUM(QTY) from STOCK_ITEMS_LOCATION WHERE itemId = ProductID ) as QtyStock
                FROM  Products_Exp 
                
                WHERE id_compania="'.$this->model->id_compania.'" '.$clause;    
  
  
  
  $Codigos = $this->model->Query($sql);
  
  foreach ($Codigos as $value) {
  
    $value = json_decode($value);
     
    $codes .= '<option value="'.$value->{'ProductID'}.'">('.$value->{'ProductID'}.') - '.$value->{'SalesDescription'}.' / Inv: '.number_format($value->{'QtyStock'}, 2, '.', '').'</option>';
  
   } 
  
  echo $codes;
  
  }

///////////////////////////////////////////////////////////////////////////////////////////////
// PARA PROCESO DE SO CON ITEMS EN INVENTARIO Y UBICACIONES

public function getItems(){
  
  $this->SESSION();
  
  $itemFilter = $this->model->Query_value('FAC_DET_CONF','ITEMS_FILTER','WHERE ID_compania="'.$this->model->id_compania.'"');
  
  if($itemFilter){
  
    $clause= ' and '.$itemFilter;
  
  }else{
  
    $clause= '';
  }
  
 $sql = 'SELECT Products_Exp.ProductID as ProductID , 
                 Products_Exp.Description  as Description 
            FROM Products_Exp 
            INNER JOIN STOCK_ITEMS_LOCATION ON STOCK_ITEMS_LOCATION.itemID = Products_Exp.ProductID 
            WHERE Products_Exp.id_compania="'.$this->model->id_compania.'"  
             and  STOCK_ITEMS_LOCATION.qty > 0
             and  STOCK_ITEMS_LOCATION.ID_compania="'.$this->model->id_compania.'"  '.$clause.' group by ProductID';
  
  
 

  $Codigos = $this->model->Query($sql);
  
  foreach ($Codigos as $value) {
  
    $value = json_decode($value);
     
    $codes .= '<option value="'.$value->{'ProductID'}.'">'.$value->{'ProductID'}.' - '.$value->{'Description'}.'</option>';
  
   } 
  
  echo $codes;
  
  }



///////////////////////////////////////////////////////////////////////////////////////////////
//PROCESOD DE CONSIGNACION

public function set_consignacion_header($JobDesc,$PhaseDesc,$CostDesc,$reasonToAdj,$no_order){

$this->SESSION();

  $val_to_insert = array(
  'date'   => date('Y-m-d'),
  'idJob'  => $JobDesc, 
  'idPha'  => $PhaseDesc, 
  'idCost' => $CostDesc, 
  'nota'   => $reasonToAdj,
  'refReg' => $no_order,
  'ID_compania' => $this->model->id_compania);

  $this->model->insert('CON_HEADER',$val_to_insert);

}

public function set_con_reg_tras($idItem,$orderNum,$qty,$lote,$ruta,$caduc,$ruta_dest,$almacen_dest,$count,$arrLen){

$this->SESSION();


//RUTA ORIGEN
$route_src = $this->model->Query_value('ubicaciones','id',' where etiqueta="'.$ruta.'"');
$stock_src = $this->model->Query_value('ubicaciones','id_almacen',' where etiqueta="'.$ruta.'"');


//VERIFICO STATUS_LOCATION_ID ACTUAL
$clause = 'WHERE ID_compania="'.$this->model->id_compania.'"  and id_product="'.$idItem.'" and lote="'.$lote.'" and stock="'.$stock_src.'" and route="'.$route_src.'"';

$id_status_loc = $this->model->Query_value('status_location','id',$clause);


//ACTUALIZO LOCACION Y RREGISTRA EL MOVIMIENTO
$this->update_lote_location($ruta,'',$id_status_loc,$ruta_dest,$almacen_dest,$lote,$qty);


  if($count==$arrLen){

    $this->model->con_reg($orderNum,$arrLen,$this->model->id_compania);

    echo '0';

  }else{

    echo '1';

  }

}


public function get_con_info($id){
$this->SESSION();

$clause= 'WHERE CON_HEADER.ID_compania="'.$this->model->id_compania.'"
                 and CON_REG_TRAS.ID_compania="'.$this->model->id_compania.'"  
                 and reg_traslado.ID_compania="'.$this->model->id_compania.'"
                 and CON_HEADER.refReg="'.$id.'"';

$ORDER_detail = $this->model->get_con_to_report('DESC','1',$clause);

echo '<br/><br/><fieldset><legend>Detalle de consignación</legend><table class="table table-striped table-bordered" cellspacing="0"  ><tr>';

foreach ($ORDER_detail as $datos) {
    $ORDER_detail = json_decode($datos);


$user = $this->model->Get_User_Info($ORDER_detail->{'USER'}); 

foreach ($user as $value) {
$value = json_decode($value);
$name= $value->{'name'};
$lastname = $value->{'lastname'};
}



echo     "<th><strong>No. Req</strong></th><td class='InfsalesTd order'>".$ORDER_detail->{'REF'}."</td>
          <th><strong>Fecha</strong></th><td class='InfsalesTd'>".$ORDER_detail->{'date'}."</td>
          <th><strong>Responsable</strong></th><td class='InfsalesTd'>".$name.' '.$lastname."</td>
          <th><strong>Description</strong></th><td class='InfsalesTd'>".$ORDER_detail->{'NOTA'}."</td>";

}

echo "</tr></table>";


//$ORDER= $this->model->get_req_to_print($id);

echo '<table id="example-12" class="table table-striped table-bordered" cellspacing="0"  >
      <thead>
        <tr>
          <th width="10%">Producto</th>
          <th width="10%">Lote</th>
          <th width="10%">Almacen Origen</th>
          <th width="5%">Ruta</th>
          <th width="10%">Almacen Destino</th>
          <th width="5%">Ruta</th>
          <th width="5%">Cantidad</th>
        </tr>
      </thead><tbody>';


$ORDER = $this->model->get_con_to_report('DESC','100',$clause);

foreach ($ORDER as $datos) {

$ORDER = json_decode($datos);


//RUTA ORIGEN
$route_src = $this->model->Query_value('ubicaciones','etiqueta',' where id="'.$ORDER->{'route_ini'}.'"');
$stock_src = $this->model->Query_value('almacenes','name',' where id="'.$ORDER->{'id_almacen_ini'}.'"');

//RUTA DESTINO
$route_des = $this->model->Query_value('ubicaciones','etiqueta',' where id="'.$ORDER->{'route_des'}.'"');
$stock_des = $this->model->Query_value('almacenes','name',' where id="'.$ORDER->{'id_almacen_des'}.'"');

echo  '<tr  >
              <td  >'.$ORDER->{'ProductID'}.'</td>
              <td  >'.$ORDER->{'LOTE'}.'</td>
              <td style="background-color:#F3F781;" >'.$stock_src.'</td>
              <td style="background-color:#F3F781;" >'.$route_src.'</td>
              <td style="background-color:#BCDFA8;" >'.$stock_des.'</td>
              <td style="background-color:#BCDFA8;" >'.$route_des.'</td>
              <td  >'.$ORDER->{'CANT'}.'</td>

          </tr>';
 
  

  }

echo '</tbody></table><div style="float:right;" class="col-md-2">
<a href="'.URL.'index.php?url=ges_consignaciones/con_print/'.$ORDER->{'REF'}.'"  class="btn btn-block btn-secondary btn-icon btn-icon-standalone btn-icon-standalone-right btn-single text-left">
   <img  class="icon" src="img/Printer.png" />
  <span>Imprimir</span>
</a>
</div></fieldset>';



}


///////////////////////////////////////////////////////////////////////////////////////////////
//LISTA DE JOBS, FASES Y CENTRO DE COSTOS

public function get_JobList(){
$this->SESSION();

$jobs = $this->model->get_JobList(); 


if($jobs!='0'){
  
foreach ($jobs as $value) {

 $value = json_decode($value);

  $list.= '<option value="'.$value->{'JobID'}.'" >'.$value->{'Description'}.'</option>';

}

echo $list;


}else{



echo '0';


}
}

public function get_phaseList(){
$this->SESSION();

$phase = $this->model->get_phaseList();

if($phase!='0'){

foreach ($phase as $value) {

$value = json_decode($value);

  $list.= '<option value="'.$value->{'PhaseID'}.'" >'.$value->{'Description'}.'</option>';

}


echo $list;

}else{

echo '0';

}



}

public function get_costList(){
$this->SESSION();

$cost = $this->model->get_costList();


if($cost!='0'){

foreach ($cost as $value) {

$value = json_decode($value);

  $list.= '<option value="'.$value->{'CostCodeID'}.'" >'.$value->{'Description'}.'</option>';

}


echo $list;


}else{

echo '0';

}


}


////////////////////////////////////////////////////////////////////////////////////////////////////////7
//PROCESO COMPRAS/RECIBO DE MERCANCIAS
public function set_fact_header($FACT_NO,$vendorID,$PO_ID,$nota,$total,$date){

$this->SESSION();

$date = date("Y-m-d", strtotime($date));

$VendorName = $this->model->Query_value('Vendors_Exp','Name', 'where VendorID="'.$vendorID.'" AND ID_compania="'.$this->model->id_compania.'"');
$CTA_CXP    = $this->model->Query_value('CTA_GL_CONF','CTA_CXP','WHERE ID_compania="'.$this->model->id_compania.'"');

$value_to_set  = array( 
  'TransactionID' => $FACT_NO,  
  'PurchaseNumber' => $PO_ID, 
  'ID_compania' => $this->model->id_compania,
  'VendorID' => $vendorID,
  'VendorName' => $VendorName,
  'AP_Account' => $CTA_CXP,
  'Net_due' => $total,
  'Subtotal' => $total,
  'nota' => $nota, 
  'USER' => $this->model->active_user_id, 
  'Date' => $date
  );

$res = $this->model->insert('Purchase_Header_Imp',$value_to_set);

echo $res;
}



public function set_fact_items($PO_NO,$ITEM_ID,$DESC,$UnitMeasure,$QTY,$Unit_Price,$Net_line,$JOB_ID,$JOB_DESC,$PHASE_ID,$PHASE_DESC,$COST_ID,$COST_DESC,$FACT_NO,$COUNT,$ARRLENG,$lineType){
$this->SESSION();



//$gl_acnt = $this->model->Query_value('Products_Exp','GL_Sales_Acct','WHERE ProductID="'.$ITEM_ID.'" and ID_compania="'.$this->model->id_compania.'"');

if($JOB_ID == '-' ){
  $JOB_ID = '';
}

if ($PHASE_ID == '-' ) {
  $PHASE_ID = '';
}

if ($COST_ID == '-') {
 $COST_ID = '';
}


if($lineType=='1'){

  if($ITEM_ID=='ITBMS'){

  $gl_acnt = $this->model->Query_value('CTA_GL_CONF','CTA_TAX','WHERE ID_compania="'.$this->model->id_compania.'"');


  }else{

  $gl_acnt = $this->model->Query_value('CTA_GL_CONF','CTA_PUR','WHERE ID_compania="'.$this->model->id_compania.'"');

  $ITEM_ID = '';
  }

  

}else{

 $gl_acnt = $this->model->Query_value('Products_Exp','GL_Sales_Acct','WHERE ProductID="'.$ITEM_ID.'" and ID_compania="'.$this->model->id_compania.'"');


}


$value_to_set  = array( 
  'TransactionID' => $FACT_NO, 
  'Item_id' => $ITEM_ID,
  'Description' => $DESC,
  'Quantity' => $QTY,  
  'Unit_Price' => $Unit_Price,
  'Net_line'  => $Net_line,
  'GL_Acct' => $gl_acnt,
  'JobID' => $JOB_ID,  
  'JobPhaseID' => $PHASE_ID,  
  'JobCostCodeID' => $COST_ID, 
  'ID_compania' => $this->model->id_compania
  );



$res = $this->model->insert('Purchase_Detail_Imp',$value_to_set);



if($COUNT==$ARRLENG){ //SI LOS ITEMS PROCESADOS CONTABILIZADOS CON count ES IGUAL EL NUMERO DE LINEAS EN EL ARRAY (ARRLENG) entonces devuelve 0 para terminar el proceso de insesion de registros
  echo '1'; 
}else{ 
  echo '0';
} 

}



public function get_fact_by_id($id){

$this->SESSION();

$query ="SELECT * FROM `Purchase_Header_Imp`
inner JOIN `Purchase_Detail_Imp` ON Purchase_Detail_Imp.TransactionID = Purchase_Header_Imp.TransactionID
inner JOIN `SAX_USER` ON `SAX_USER`.`id` = Purchase_Header_Imp.USER
inner JOIN Products_Exp ON Products_Exp.ProductID =Purchase_Detail_Imp.item_id
WHERE Purchase_Header_Imp.TransactionID='".$id."' and 
      Purchase_Header_Imp.ID_compania='".$this->model->id_compania."'
GROUP BY Purchase_Header_Imp.TransactionID limit 1";



$fact_detail= $this->model->Query($query);

  
  

echo '<br/><br/><fieldset><div class="col-lg-6"><legend>Detalle de factura</legend><table class="table table-striped table-bordered" cellspacing="0"  >';


foreach ($fact_detail as $datos) {

   $fact_detail = json_decode($datos);

   if($fact_detail->{'Error'}=='1') { 

   $status= "Error : ".$fact_detail->{'ErrorPT'}. 'Se ha cancelado la Orden';
   $style="style='color:red;'"; 


 } else{

    if($fact_detail->{'Enviado'}!="1"){

      $style="style='color:orange;'"; 
      $status='Por Procesar'; 

     }else{ 

        $status= "Sincronizado el: ".$fact_detail->{'Export_date'};
        $style="style='color:green;'";

       }   

    }



echo "<tr><th style='text-align:left;'><strong>Ref.</strong></th><td class='InfsalesTd order'>".str_pad($fact_detail->{'TransactionID'}, 9 ,"0",STR_PAD_LEFT)."</td></tr>
      <tr><th style='text-align:left;'><strong>No. Factura</strong></th><td class='InfsalesTd'>".$fact_detail->{'PurchaseNumber'}."</td></tr>
      <tr><th style='text-align:left;'><strong>Fecha</strong></th><td class='InfsalesTd'>".$fact_detail->{'Date'}."</td></tr>
      <tr><th style='text-align:left;'><strong>Proveedor</strong></th><td class='InfsalesTd'>".$fact_detail->{'VendorName'}."</td></tr>
      <tr><th style='text-align:left;'><strong>Total Factura</strong></th><td class='InfsalesTd'>".number_format($fact_detail->{'Net_due'},2,'.',',')."</td></tr>
      <tr><th style='text-align:left;'><strong>Creado por:</strong></th><td class='InfsalesTd'>".$fact_detail->{'name'}.' '.$fact_detail->{'lastname'}."</td></tr>
      <tr><th style='text-align:left;'><strong>Estado:</strong></th><td class='InfsalesTd'  ".$style." >".$status."</td></tr>";

}
echo "</table></div>";




$query ="SELECT * FROM `Purchase_Header_Imp`
inner JOIN `Purchase_Detail_Imp` ON Purchase_Detail_Imp.TransactionID = Purchase_Header_Imp.TransactionID
WHERE Purchase_Header_Imp.TransactionID='".$id."'  and 
      Purchase_Header_Imp.ID_compania='".$this->model->id_compania."' and
      Purchase_Detail_Imp.ID_compania='".$this->model->id_compania."'
 order BY Purchase_Detail_Imp.ID ASC";





$fact_items= $this->model->Query($query);

echo '<table id="example-12" class="table table-striped table-bordered" cellspacing="0"  >
      <thead>
        <tr>
          <th>Cant.</th>
          <th>Item</th>
          <th>Unidad</th>
          <th>Descripcion</th>
          <th>Cta. GL</th>
          <th>Precio Unit.</th>
          <th>Total</th>
          <th>Job</th>
        </tr>
      </thead><tbody>';


foreach ($fact_items as $datos) {

   $fact_items = json_decode($datos);

    $id= "'".$fact_items->{'InvoiceNumber'}."'";


echo  "<tr>
          <td class='numb'>".number_format($fact_items->{'Quantity'},5,'.',',')."</td>
          <td>".$fact_items->{'Item_id'}."</td>
          <td>".$fact_items->{'UnitMeasure'}.'</td>
          <td>'.$fact_items->{'Description'}.'</td>
          <td class="numb">'.$fact_items->{'GL_Acct'}."</td>
          <td class='numb'>".number_format($fact_items->{'Unit_Price'},4,'.',',')."</td>
          <td class='numb'>".number_format($fact_items->{'Net_line'},4,'.',',').'</td>
          <td>'.$fact_items->{'JobID'}.'</td>
      </tr>';

  }

echo '</tbody></table><div style="float:right;" class="col-md-2">
<a href="'.URL.'index.php?url=ges_compras/print_fact/'.$fact_items->{'TransactionID'}.'"  class="btn btn-block btn-secondary btn-icon btn-icon-standalone btn-icon-standalone-right btn-single text-left">
   <img  class="icon" src="img/Printer.png" />
  <span>Imprimir</span>
</a>
</div></fieldset>';





}




//AGREGADO POR ALEX PROYECTO DELIFISH BORRAR DESPUES DE PRUEBAS ESTE COMENTARIO.
//LISTA LOS CLIENTES EN BASE DE DATOS

public function List_customers(){

$this->SESSION();

$CUST_LIST = $this->model-> get_ClientList(); 

$table = '<script type="text/javascript">

 jQuery(document).ready(function($)

  {

   var table = $("#table_CustomerList").dataTable({
   rowReorder: {
            selector: "td:nth-child(2)"
        },

      responsive: true,
      pageLength: 100,
      dom: "Bfrtip",
      bSort: false,
      select:true,
      scrollY: "200px",
      scrollCollapse: true,

        buttons: [

          {

          extend: "excelHtml5",

          text: "Exportar",

          title: "Reporte_Ordenes_de_Compras",

           
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
                

          },

          {

          extend:  "colvis",

          text: "Seleccionar",

          columns: ":gt(0)"           

         },

         {

          extend: "colvisGroup",

          text: "Ninguno",

          show: [0],

          hide: [":gt(0)"]

          },

          {

            extend: "colvisGroup",

            text: "Todo",

            show: ["*"]

          }

          ]

   

    });


table.yadcf(
[
{column_number : 0,
 column_data_type: "html",
 html_data_type: "text" 
},
{column_number : 1},
{column_number : 2},
{column_number : 3},
{column_number : 4}
],
{cumulative_filtering: true}); 

});


  </script>



  <table id="table_CustomerList" class="table table-striped responsive table-bordered" cellspacing="0" >

    <thead>
      <tr>
        <th width="10%">ID. Cliente</th>
        <th width="20%">Nombre del Cliente</th> 
        <th width="30%">Direccion de Facturacion</th>
      </tr>
    </thead>
   <tbody>';

  
  foreach ($CUST_LIST as $datos) {
                                
      $CUST_INF = json_decode($datos);

      if ($CUST_INF->{'IsActive'} == 1) {
           
      $table.= '<tr>
            <td ><a href="'.URL.'index.php?url=ges_niveles_prec/agregar_precios/'.$CUST_INF->{'CustomerID'}.'/'.$CUST_INF->{'Customer_Bill_Name'}.'">'.$CUST_INF->{'CustomerID'}.'</a></td>
            <td >'.$CUST_INF->{'Customer_Bill_Name'}.'</td>
            <td >'.$CUST_INF->{'AddressLine1'}.'</td>
              </tr>';
      }
      }


    $table.='</tbody></table>';

    echo $table;

}





public function login_to_auth($user,$pass){


$pass = md5($pass);


if($ID==''){ echo "0"; }else{ echo "1"; }


}

public function get_product_byLevel($ID_cust){



$this->SESSION();

$Item =  $this->model->get_ProductsList(); 

echo '<script>var table =  $("#products").dataTable({
        aLengthMenu: [
        [10,20, 25,50,-1], [10,20, 25, 50,"All"]
              ]
            });

 table.yadcf([
{column_number : 1},
{column_number : 2},
]);</script>

<table id="products" class="table table-striped table-bordered" cellspacing="0"  >
            <thead>
              <tr>
                <th width="5%"></th>
                <th width="30%">Codigo</th>
                <th width="40%">Descripcion</th>
                <th width="30%">Precio</th>
                <th width="10%">Cant. Dip</th>

              </tr>
            </thead>
          
          
            <tbody> ';



   foreach ($Item as $datos) {

         $Item = json_decode($datos);
        
         if($Item->{'QtyOnHand'}>=1){
          
          $ID ='"'.$Item->{'ProductID'}.'"';
          $NAME='"'.$Item->{'Description'}.'"';

          


          for ($i=1; $i<=9 ; $i++) {   

           $control = 'false';
           

            switch ($i) {
              case '1':

                if ($ID_cust == 1) {
                    $control = 'true';
                }
                $price_item = $Item->{'Price1'};
                break;

              case '2':

                if ($ID_cust == 2) {
                    $control = 'true';
                }
                $price_item = $Item->{'Price2'};
                
                break;
              case '3':

                if ($ID_cust == 3) {
                    $control = 'true';
                }
                $price_item = $Item->{'Price3'};
               // echo 'entro3';
                break;

              case '4':
                if ($ID_cust == 4) {
                    $control = 'true';
                }
                $price_item = $Item->{'Price4'};
                break;

              case '5':
                if ($ID_cust == 5) {
                    $control = 'true';
                }
                $price_item = $Item->{'Price5'};
                break;
              case '6':
                if ($ID_cust == 6) {
                    $control = 'true';
                }
                $price_item = $Item->{'Price6'};
                break;
              case '7':
                if ($ID_cust == 7) {
                    $control = 'true';
                }
                $price_item = $Item->{'Price7'};
                break;
              case '8':
                if ($ID_cust == 8) {
                    $control = 'true';
                }
                $price_item = $Item->{'Price8'};
                break; 
              case '9':
                if ($ID_cust == 9) {
                    $control = 'true';
                }
                $price_item = $Item->{'Price9'};
                break;
              
              
            }

           

             if ($control == 'true') {
                
                $options.= '<option value="'.number_format($price_item, 2, '.', ',').'" SELECTED >NP '.$ID_cust.' - '.number_format($price_item, 2, '.', ',').'</option>';

                $PRICE ='"'.number_format($price_item, 2, '.', ',').'"';
                $control = 'false';

              }else{

                 $options.= '<option value="'.number_format($price_item, 2, '.', ',').'" >NP '.$i.' - '.number_format($price_item, 2, '.', ',').'</option>';

              }   

              }

          //$PRICE ='"'.number_format($Item->{'Price1'}, 4, '.', ',').'"';
                          
        echo  "<tr>
             <td >
        <a title='Agregar a la orden' data-toggle='modal' data-target='#myModal' href='javascript:void(0)' onclick='javascript: modal(".$ID.",".$NAME.",".$PRICE."); ' ><i style='color:green' class='fa fa-plus'></i></a></td>

            <td  id=".$Item->{'ProductID'}."><strong> ".$Item->{'ProductID'}."</strong></td>

            <td  id=".$Item->{'ProductID'}.$Item->{'Description'}."><strong>".$Item->{'Description'}.'</strong></td> 

            <td class="numb" >
            

            <select  id="'.$Item->{'ProductID'}.'price" name="customer" class="select col-lg-12 numb" required>'.$options.'</select>  
            </td>

            <td  class="numb" id="'.$Item->{'ProductID'}.'qty'.'" >'.number_format($Item->{'QtyOnHand'},5, '.', ',').'</td>
            </tr>';

          }


              $Price_array = array();
              $options = '';

          
  }

  echo '  </tbody>
          </table>';

}

public function checkSOIns($SO_num){

  $this->SESSION();

  $header = $this->model->Query_value('SalesOrder_Header_Imp','SalesOrderNumber','WHERE SalesOrderNumber = "'.$SO_num.'"  and ID_compania = "'.$this->model->id_compania.'" order by SalesOrderNumber asc limit 1');

  $detail = $this->model->Query_value('SalesOrder_Detail_Imp','SalesOrderNumber','WHERE SalesOrderNumber = "'.$SO_num.'" and ID_compania = "'.$this->model->id_compania.'" order by SalesOrderNumber asc limit 1');


    if ($header == '') {
      
      $this->model->delete('SalesOrder_Detail_Imp',' WHERE SalesOrderNumber = "'.$SO_num.'"  and ID_compania = "'.$this->model->id_compania.'"');
      $res = 1;


    }else{


        if ($detail == '' ) {
          

          $this->model->delete('SalesOrder_Header_Imp',' WHERE SalesOrderNumber = "'.$SO_num.'"  and ID_compania = "'.$this->model->id_compania.'"');
          $res = 2;

        }else {

          $res = 0;

        }

    }


    echo $res;

}

public function get_lang(){

    $this->SESSION();

    $language = $this->model->lang;


    echo $language;

}


//INI  INTERFAZ CON OPENCART 
public function checkSalesOrderExist($order_id){

  $this->SESSION();

  $where = " where SalesOrderNumber='{$order_id}' and ID_compania='{$this->model->id_compania}' ;";
 
  $res = $this->model->query_value('SalesOrder_Header_Imp','SalesOrderNumber',$where);
  
  if($res != '' ){ $res = true ; } else{ $res = false ; }
  
  return $res;
}

public function oc_getStoresList(){
  
 //  die(var_dump([$_GET['api_url'],$_GET['api_key'],$_GET['api_route']]);
  $response = $this->do_curl_request('Default',$_GET['api_url'] ,$_GET['api_key'] ,$_GET['api_route'],null);
 
  echo '<option value="" >Selecciona tienda</option>';
 
  foreach($response as $key => $value){
    
    if(is_array($value)){
    
    foreach($value as $store){

        echo '<option value="'.$store->store_id.'" >['.$store->store_id.']-'.$store->value.'</option>';
    }

    }

  }
  
  die();
}

public function oc_getStores(){


  $response = $this->do_curl_request('Default',$_GET['api_url'] ,$_GET['api_key'] ,$_GET['api_route'],json_encode($json, JSON_PRETTY_PRINT));

  
  foreach($response as $key => $value){
    
    if(is_array($value)){
   
    foreach($value as $store){

        echo '['.$store->store_id.']['.$store->value.']<br>';
    }

    }else{
        echo '['.$key.']['.$value.']<br>';
    }

  }
  die();
}

public function oc_getOrders(){

  $json['filter_order_id']= "";
  $json['filter_status']= '5'; //estatus completado
  $json['filter_has_invoices']= "1"; //factura asignada
  $json['filter_store_id']= $_GET['store_id']; //tienda
  $json['start']= "0";
  $json['limit']= "0";


  $response = $this->do_curl_request('Default',$_GET['api_url'] ,$_GET['api_key'] ,$_GET['api_route'],json_encode($json, JSON_PRETTY_PRINT), 'GET');
  

  
  foreach ((array)$response->message as $key => $value) {
    
     $order_id = 'OC-'.$value->header->order_id; 
     $store_id = $value->header->store_id;
     $store_name = $value->header->store_name;

    ////CHECK IF NOT EXIST
    if(!$this->checkSalesOrderExist($order_id)){


      $this->SESSION();

      $res[$order_id] = "Sales Order {$order_id} not  exist on aciweb.";

      //GRAB HEADER

      $values = array(

        'ID_compania'=>$this->model->id_compania,
        'SalesOrderNumber'=> $order_id,
        'CustomerID'=>   $value->header->customer_id,
        'CustomerName'=> $value->header->firstname.' '.$value->header->lastname,
        'Subtotal'=> $value->header->subtotal ,
        'TaxID'=> '',
        'OrderTax' => $value->header->tax,
        'Net_due'  =>$value->header->total,
        'user'     => $this->model->active_user_id,
        'date'     =>date('Y-m-d',strtotime($value->header->date_added)),
        'saletax'=>'0', //validar que dato va a ir aqui 
        'CustomerPO' => '',
        'tipo_licitacion' => '',
        'entrega' => '',
        'termino_pago' => $value->header->payment_method,
        'observaciones' => '',
        'ShipToName' =>  $value->header->shipping_firstname.' '.$value->header->shipping_lastname,
        'ShipToAddressLine1' => $value->header->shipping_address_1,
        'ShipToAddressLine2' => $value->header->shipping_address_2,
        'ShipToCity' => $value->header->shipping_city,
        'ShipToState' => '',
        'ShipToZip' =>  $value->header->shipping_postcode,
        'ShipToCountry' =>  $value->header->shipping_country,
        'fecha_entrega' => '',
        'lugar_despacho' =>'',
        'SalesRepID' =>  '');
        
     $this->model->insert('SalesOrder_Header_Imp',$values);

    
     foreach ((array) $value->detail as $key => $detailRow) {


      $row = array(
          'ItemOrd' => $detailRow->order_product_id ,
          'ID_compania'=>$this->model->id_compania,
          'SalesOrderNumber'=>$order_id,
          'Item_id'=> $detailRow->model,
          'Description'=> $detailRow->name,
          'REMARK'=>'',
          'Quantity'=>$detailRow->quantity,
          'Unit_Price'=>$detailRow->price,
          'Net_line'=>$detailRow->total,
          'Taxable'=> $detailRow->tax == 0 ? 1 : 0);
        
        
          $this->model->insert('SalesOrder_Detail_Imp',$row);


     }
    
  
      switch ($this->checkSOIns($order_id)) {
        case 1:
          $res[$order_id] = "[Error insertando informacion de cabecera]";
          die();
          break;
        case 2:
          $res[$order_id] = "[Error insertando informacion de detalle]";
          die();
          break;
          
      }
   
      $res[$order_id] = "[Orden importada correctamente]";


    }else{

      $res[$order_id] = "Sales Order {$order_id} already exist on aciweb.";


    }

  }
 

  foreach($res as $key => $value){
    
    if( is_array($value)){

      
      echo '[order: '.$key.']'.var_dump($value);


    }else{
      echo '[order: '.$key.']['.$value.']<br>';
    }
     
   

  }


 die();


}

public function oc_setItems() {

  //get info 
  $products = $this->get_ProductsList();
  
  if(count($products) < 1) exit(json_encode(array('Warning' => '[No se encontraron productos que exportar]')));
 
  $i = 1;

  foreach ($products as $key => $value) {
    
    $item =  json_decode($value);
    
      //el key [2] denota el idioma español configurado en opencart, mantener como estandar

    $json[$i]['product_description'][2]['name'] =  $item->{'Description'}.'('.$item->{'ProductID'}.')';
    $json[$i]['product_description'][2]['description'] = $item->{'SalesDescription'};
    $json[$i]['product_description'][2]['meta_title'] = $item->{'Description'}.'('.$item->{'ProductID'}.')';
    $json[$i]['product_description'][2]['meta_description'] = "";
    $json[$i]['product_description'][2]['meta_keyword'] = "";
    $json[$i]['product_description'][2]['tag'] = "";
    $json[$i]['master_id'] = "0";
    $json[$i]['model'] = $item->{'ProductID'};
    $json[$i]['sku'] = $item->{'UPC_SKU'};
    $json[$i]['upc'] = "";
    $json[$i]['ean'] = "";
    $json[$i]['jan'] = "";
    $json[$i]['isbn'] = "";
    $json[$i]['mpn'] = "";
    $json[$i]['location'] = "";
    $json[$i]['tax_class_id'] = "0";
    $json[$i]['stock_status_id'] = "0";
    $json[$i]['date_available'] = date('Y-m-d');
    $json[$i]['shipping'] = "0";
    $json[$i]['price'] = $item->{'Price1'}; 
    $json[$i]['quantity'] = $item->{'QtyOnHand'};
    $json[$i]['minimum'] = "1";
    $json[$i]['subtract'] = "1";
    $json[$i]['length'] = "0";
    $json[$i]['width'] = "0";
    $json[$i]['height'] = "0";
    $json[$i]['weight'] = "0";
    $json[$i]['weight_class_id'] = "1";
    $json[$i]['length_class_id'] = "1";
    $json[$i]['image'] = "";
    $json[$i]['sort_order'] = $i; 
    $json[$i]['status'] = "0";//not enable
    $json[$i]['points'] = "";
    $json[$i]['store_id'] = $_GET['store_id']; //tienda;
    $json[$i]['product_reward'] = [];//not enable
    $json[$i]['product_layout'] = [];//not enable
    $json[$i]['manufacturer_id'] = "0";//not enable

    $i = $i + 1;

  }
 
  
  //Execute curl
  $response = $this->do_curl_request('Default',$_GET['api_url'] ,$_GET['api_key'] ,$_GET['api_route'],json_encode($json, JSON_PRETTY_PRINT),'POST');


    foreach($response as $key => $value){
      
      if(is_object($value)){
      
      foreach($value as $keymsg => $msg){

          echo '['.$keymsg.']['.$msg.']<br>';
      }

      }else{
          echo '['.$key.']['.$value.']<br>';
      }

    }

    die();

}

public function oc_getCustomers(){
  
    $json['filter_email']= "";
    $json['filter_store_id']= $_GET['store_id']; //tienda
    
    $json['start']= "0";
    $json['limit']= "0";

    $response = $this->do_curl_request('Default',$_GET['api_url'] ,$_GET['api_key'] ,$_GET['api_route'],json_encode($json, JSON_PRETTY_PRINT), 'GET');
    
    
    foreach ((array)$response->message as $key => $value) {
      
       $customer_id = 'OC-'.$value->customer_id; 
       $customer_email = $value->email;

   
 
      ////CHECK IF NOT EXIST
      if(!$this->checkCustomerExist($customer_id,$customer_email)){
        $this->SESSION(); 
  

        $Values = array( 
          'CustomerID' =>  $customer_id,
          'Customer_Bill_Name'  =>  $value->firstname.' '.$value->lastname,
          'Telephone1'=> $value->telephone,
          'Country'=> '',
          'State'=> '',
          'City'=> '',
          'Zip'=> '',
          'Email'=> $customer_email,
          'AddressLine1'=> '',
          'AddressLine2'=> '',
          'ID_compania' => $this->model->id_compania);


  
        $this->model->insert('Customers_Imp',$Values);
        if($this->CheckError()){


           $res[$key] = '[customer: '.$customer_id.'-'.$customer_email.'][DB error was ocurred]';
          
        }else{

           $res[$key] = '[customer: '.$customer_id.'-'.$customer_email.'][Successfully imported]';
          // echo $key.'[customer: '.$customer_id.'-'.$customer_email.'][Successfully imported]';
        }
      

      }else{

        $res[$key] = '[customer: '.$customer_id.'-'.$customer_email.'][Is already imported]';
        

      }
      

  
    }
   
   
    foreach($res as $key => $value){
      
      // if( is_array($value)){
  
        
      //   echo var_dump($value);
  
  
      // }else{
        echo $value.'<br>';
      // }
       
     
  
    }
  
  
   die();

  
}

public function oc_getTblCol(){

   
  $json['tables'] = array('product','product_description');
    
  $response = $this->do_curl_request('Default',$_GET['api_url'] ,$_GET['api_key'] ,$_GET['api_route'],json_encode($json, JSON_PRETTY_PRINT),"POST");


  $options = '';

  foreach($response->message as $key => $value){
    
    
    if(is_array($value)){
      
      foreach($value as $col){

           $options .= "<option value='{$key}.{$col}'>{$key}.{$col}</option>"; 
      }

    
   }

  }




  $sql = "SHOW COLUMNS FROM Products_Imp";
  $columns = $this->model->Query($sql);


  $tblProducts = '<table class="table table-striped responsive table-bordered dataTable" cellspacing="0" role="grid" style="margin-left: 0px; width: 1699px;"><tr><th>ACIWEB</th><th>Opencart</th></tr>';
  
    foreach ($columns as $key => $value) {

      $value = json_decode($value);
      $tblProducts .= "<tr><td>{$value->Field}</td><td><select name='{$value->Field}' id='{$value->Field}'>{$options}</select></td></tr>";

    }
    
  $tblProducts .=  '</table>';
  
  echo  $tblProducts ;


  die();
}


public function get_token($api_url,$api_token){

  $url = $api_url.'/index.php?route=api/login';

  $params = array("key" => $api_token);

  $ch = curl_init();
  curl_setopt($ch,CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_COOKIEJAR, '/tmp/apicookie.txt');
  curl_setopt($ch, CURLOPT_COOKIEFILE, '/tmp/apicookie.txt');
 
  $params_string = '';
  if (is_array($params) && count($params)) {
    foreach($params as $key=>$value) {
      $params_string .= $key.'='.$value.'&';
    }
    rtrim($params_string, '&');
 
    curl_setopt($ch,CURLOPT_POST, count($params));
    curl_setopt($ch,CURLOPT_POSTFIELDS, $params_string);
  }
 
  //execute post
  $response = curl_exec($ch);
 
  //close connection
  curl_close($ch);
  $response = json_decode($response);
  
         if($response->{'error'}){
       
           foreach($response->{'error'} as $key => $value){
       
             echo '['.$key.']['.$value.']<br>';
       
           }
       
           die();
         }
    return $response->{'api_token'} ;

}

public function checkCustomerExist($customer_id,$customer_email){
  
    $where = " WHERE CustomerID='{$customer_id}' or Email='{$customer_email}' ;";
  
    $exist = $this->model->query_value('Customers_Imp','CustomerID',$where);
  
    if($exist != ''){ return true ; }
   
    $exist = $this->model->query_value('Customers_Exp','CustomerID',$where);
    if($exist != ''){ return true ; }
  
    return false;
  
}

public function do_curl_request($api_user,$api_url,$api_token,$api_route,$data, $method = 'GET'  ) {

  //get token
  $token = $this->get_token($api_url, $api_token ,$api_user);

  $url = $api_url.'/index.php?route='.$api_route.'&api_token='.$token;

  if($method == 'GET' && $data != ""){

    $data =  json_decode($data);
    $params = '';
    foreach ($data as $key => $value) {
      $params .= "&".$key."=".$value;
    }
    $url = $url.$params;
  }

  $curl = curl_init();

  $options =  array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => $method,
    CURLOPT_HTTPHEADER => array(
      "Content-Type: application/json",
      "Content-Type: text/xml"
    ),
   CURLOPT_COOKIEJAR  => '/tmp/oc_api_cookie.txt',
   CURLOPT_COOKIEFILE => '/tmp/oc_api_cookie.txt',
  );

  
  if($method == 'POST'){  $options[CURLOPT_POSTFIELDS] = $data;  }

  curl_setopt_array($curl, $options);
  $response = curl_exec($curl);
  $info = curl_getinfo($curl);
  curl_close($curl);

 
  $response = json_decode($response);
  
  if($response == '' || $response->code >= '400'){

   
    if($response == ''){
      $code = $info['http_code'];   
      exit("[{$code}][{$url}]");
    }
    
    exit("[{$response->code}][{$response->message}]");

  }

    
  return $response;


}
//INI  INTERFAZ CON OPENCART 




public function oc_itemColumnMapping(){







}



public function CheckError(){
  
  
    $CHK_ERROR =  $this->model->read_db_error();
    
  
    if ($CHK_ERROR!=''){ 
  
     return true; 
  
    }
  
  }

  
  

// -WARNING- la llave debajo de este comentario es la que cierra la clase. NO BORRAR NI MODIFICAR.
}





?>