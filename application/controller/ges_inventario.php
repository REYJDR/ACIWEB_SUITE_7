<?PHP

class ges_inventario extends Controller
{

public $ProductID;

public function inv_list(){
 


 $res = $this->model->verify_session();

        if($res=='0'){
        
            // load views
            require APP . 'view/_templates/header.php';
            require APP . 'view/_templates/panel.php';
            require APP . 'view/modules/inventory/invlist.php';
            require APP . 'view/_templates/footer.php';


        }
          


	
}

public function inv_info($itemid){
 
 $this->ProductID = $itemid;

 $res = $this->model->verify_session();

        if($res=='0'){
        

            // load views
            require APP . 'view/_templates/header.php';
            require APP . 'view/_templates/panel.php';
            require APP . 'view/modules/inventory/invInfo.php';
            require APP . 'view/_templates/footer.php';


        }
          


	
}

//******************************************************************************
//SALIDA DE INVENTARIO POR AJUSTES

public function InvOut(){
    
    
     $res = $this->model->verify_session();
    
            if($res=='0'){
            
                // load views
                require APP . 'view/_templates/header.php';
                require APP . 'view/_templates/panel.php';
                require APP . 'view/modules/inventory/InvOut.php';
                require APP . 'view/_templates/footer.php';
    
    
            }
               
    }

public function location(){
    
    
     $res = $this->model->verify_session();
    
            if($res=='0'){
            
    
                // load views
                require APP . 'view/_templates/header.php';
                require APP . 'view/_templates/panel.php';
                require APP . 'view/modules/inventory/location.php';
                require APP . 'view/_templates/footer.php';
    

            }  
        
}


////////////////////////////////////////////////////////////////////////////////////
//*
//* OPERATION METHODS

public function getStockList(){

    $this->model->verify_session();
    $table = '';


   echo  $query="select * from STOCKS where onoff='1' and 
    ID_compania='".$this->model->id_compania."' or
    ID_compania='0' ;";

        $res = $this->model->Query($query);

        foreach ($res as $datos) {	
        $datos = json_decode($datos);

        $id = '"'.$datos->{'id'}.'"';
        $table .= "<tr><td><a href='#' onclick='getLocation(".$id.");' >".$datos->{'name'}."&nbsp&nbsp<i style='float:right;' class='fas fa-angle-right'></i></a></td></tr>";
        }

    echo $table ;
}

public function getStockInfo($id){
  
    $this->model->verify_session();
    
   echo $query="select * from STOCKS where onoff='1' and id='".$id."';";
    $res = $this->model->Query($query); 

   $table = '<fieldset class="fieldsetform">
            <table class="table_form" >
                <tbody>';

    foreach ($res as $datos) {	
        $datos = json_decode($datos);
        
   $table .= '<tr><th>ID</th><td>'.$datos->{'id'}.'</td></tr>
            <tr><th>Name</th><td>'.$datos->{'name'}.'</td></tr>
            <tr><th>Description</th><td>'.$datos->{'description'}.'</td></tr>
            <tr><th>Address</th><td>'.$datos->{'address'}.'</td></tr>
            <tr><th>Capacity</th><td>'.$datos->{'capacity'}.'</td></tr>';  
    }

    $table .= '</tbody>
                </table>
            <div class="col-lg-6"><i style="color:red;" class="fas fa-trash-alt" >&nbsp</i><span><a href="#">Modificar</a></span></div> 
            <div class="col-lg-6"><i style="color:blue;" class="fas fas fa-edit" >&nbsp</i><span><a href="#">Eliminar</a></span></div> 
            </fieldset>';

    
    echo $table;


}

public function getLocationList($stock){
    $this->model->verify_session();

    echo $query="select * from STOCK_LOCATION where onoff='1' and stock='".$stock."'";

    $res = $this->model->Query($query); 

    foreach ($res as $datos) {	

        $datos = json_decode($datos);


        $id = '"'.$datos->{'id'}.'"';
        $IDstock = '"'.$stock.'"';
        echo "<tr><td><a  href='#' onclick='getItemList(".$id.",".$IDstock.");' >".$datos->{'location'}."&nbsp&nbsp<i style='float:right;' class='fas fa-angle-right'></i></a></td></tr>";
    }

}


public function getItemList($location,$stock){

    $this->model->verify_session();

    $query="select * from STOCK_ITEMS_LOCATION where location='".$location."' and stock='".$stock."' and ID_compania='".$this->model->id_compania."';";

    $res = $this->model->Query($query); 


   $table = '<fieldset class="fieldsetform">
             <table id="tblItem" class="table"  >
                <thead>
                <tr>
                    <th>items</th>
                    <th>Lote</th>
                    <th>Qty</th>
                </tr>
                </thead>
                <tbody id="item">';


    foreach ($res as $datos) {	
        $datos = json_decode($datos);
        $id = '"'.$datos->{'location'}.'"';
    
    $table .= '<tr> <td><a href="'.URL.'index.php?url=ges_inventario/inv_info/'.$datos->{'itemID'}.'" >'.$datos->{'itemID'}."</a></td>
                    <td>".$datos->{'lote'}."</td>
                    <td class='numb' >".$datos->{'qty'}."</td>
              </tr>";
    }

    $table .=  '<tbody>
                </table>	
                </fieldset>';

    echo $table;

}


public function getLotesByItem($itemid='',$line=''){

    $this->model->verify_session();
    
   $query = 'SELECT 
    no_lote 
    FROM ITEMS_NO_LOTES
    where ProductID="'.$itemid.'" and ID_compania ="'.$this->model->id_compania.'"';
    
    
    $res = $this->model->Query($query); 

    echo '<select class="selectLote'.$line.' col-lg-12" id="lote'.$line.'" onchange="SetLocation(this.value,'.$line.')" >
    <option selected></option>';

    foreach ( $res as $data){
    $value = json_decode($data);

    echo '<option value="'.$value->{'no_lote'}.'">'.$value->{'no_lote'}.'</option>';

    }
    echo '</select>';
}

public function getLocByItem($lote='',$line=''){
    
      $this->model->verify_session();
        
      $query = 'SELECT 
        A.id as ID,
        B.name AS Stock,
        C.location as Location,
        A.qty as Qty
        FROM STOCK_ITEMS_LOCATION as A
        INNER JOIN STOCKS B ON B.id = A.stock 
        INNER JOIN STOCK_LOCATION C ON C.id = A.location
        where  A.lote="'.$lote.'" and  A.Qty > 0 and A.ID_compania ="'.$this->model->id_compania.'"';
        
        
        $res = $this->model->Query($query); 
    
        echo '<select class="selectLoc'.$line.' col-lg-12" id="loc'.$line.'" onchange="SetMaxQty(this.value,'.$line.')"   >
        <option selected></option>';
    
        foreach ( $res as $data){
        $value = json_decode($data);
    
        echo '<option value="'.$value->{'ID'}.'">'.$value->{'Stock'}.' ( '.$value->{'Location'}.') - ( Qty:  '.$value->{'Qty'}.') </option>';
    
        }
        echo '</select>';
}

public function addStock(){

$this->model->verify_session();

$values = array('name'    => $_REQUEST['name'], 
                'address' => $_REQUEST['desc'], 
                'description' => $_REQUEST['address'], 
                'capacity' => $_REQUEST['capa'], 
                'ID_compania' => $this->model->id_compania );

$this->model->insert('STOCKS',$values );
$err = $this->CheckError();

    if($err){
    
    echo $err;

    }else{
     
    echo 0;

    }

}


public function addLoc($id){
    
$this->model->verify_session();

$values = array('location'    => $_REQUEST['name'], 
                'description' => $_REQUEST['desc'], 
                'stock' => $id,  
                'ID_compania' => $this->model->id_compania );
    
$this->model->insert('STOCK_LOCATION',$values);

$err = $this->CheckError();

    if($err){
        echo $err;
    }else{
        echo 0;    
    }
    
}




public function getItemLoteSt(){

    $loteProd = $this->model->Get_lote_list( $this->ProductID );
    $QtyOnHand = $this->model->Query_value('Products_Exp','QtyOnHand','Where ProductID="'. $this->ProductID.'" and id_compania="'.$this->model->id_compania.'"');
    
    $total_qty = 0;
    
      foreach ($loteProd  as $value) {
         $value = json_decode($value);
    
        $lote = "'".$value->{'no_lote'}."'";
        $lote_qty = "'".$value->{'lote_qty'}."'";
    
      //  <div class="col-lg-6"><i style="color:red;" class="fas fa-trash-alt" >&nbsp</i><span><a href="#">Modificar</a></span></div> 
       // <div class="col-lg-6"><i style="color:blue;" class="fas fas fa-edit" >&nbsp</i><span><a href="#">Eliminar</a></span></div> 
     
        if($value->{'no_lote'} == $this->ProductID.'0000' ){
        
        //$button = '<a href="#" disabled ><i style="color:red;" class="fas fa-trash-alt" ></i> Borrar </a>';
        
        }else{
    
        if($this->model->active_user_role=='admin'){ 
          
          $button = '<a href="#" onclick="eliminar_lote('.$lote.','.$lote_qty.');"  ><i style="color:red;" class="fas fa-trash-alt" ></i> Borrar </a>';
          
        }
    
      
    }
        
    $sumqty = $this->model->Query_value('STOCK_ITEMS_LOCATION','sum(qty)','where itemID="'.$this->ProductID.'" and lote="'.$value->{'no_lote'}.'" and ID_compania="'.$this->model->id_compania.'"');
    $qtypend = $this->model->Query_value('sale_pendding','sum(qty)','where ProductID="'.$this->ProductID.'" and no_lote="'.$value->{'no_lote'}.'" and status_pendding="1" and ID_compania="'.$this->model->id_compania.'"');
    
    $qty = $sumqty + $qtypend;
    $total_qty = $total_qty+$qty;
    
    //echo $value->{'fecha_ven'};
    
       if($value->{'fecha_ven'}!='0000-00-00 00:00:00' and $value->{'fecha_ven'}!=null){
    
                   $venc = date('Y-m-d',strtotime($value->{'fecha_ven'}));
    
                }else{
    
                  $venc = '';
                }
    
         $table_lote.= '<tr>     
              <td><input class="form-control col-lg-2"  value="'.$value->{'no_lote'}.'" readonly/></td>
              <td><input class="form-control col-lg-2"  value="'. $venc.'" readonly/></td>
              <td><input class="numb form-control col-lg-2"  value="'.number_format($qty,0, '.', ',').'" readonly/></td>
              <td>'.$button.'</td>
              </tr>';
    
       
    
       }
    
        /*$dif = $QtyOnHand - $total_qty;
    
        $table_lote .=  '<tr>     
              <td><strong><input class="form-control col-lg-2" style="text-align:right;"  value="Total Stock" readonly/></strong></td>
              <td><strong><input class="form-control col-lg-2" style="text-align:right;"  value="'.number_format($total_qty,0, '.', ',').'" readonly/></strong></td>
              <td><strong><input class="numb form-control col-lg-2"  style="text-align:right;" Value="Dif. "  readonly/><strong></td>
              <td><strong><input type="text" class="numb form-control col-lg-1" style="text-align:right; background-color:#F5A9A9;"    value="'.number_format($dif,0, '.', ',').'" readonly /><strong></td>
              </tr>';*/
        
    
        echo $table_lote;
}


public function SET_NO_LOTE($item,$no_lote,$qty,$fecha){
    
    
    $this->model->verify_session();
    
    
    //Verifico No_lote si existe
    $lote = $this->model->Query_value('ITEMS_NO_LOTES','no_lote','Where no_lote="'.$no_lote.'" and ID_compania="'.$this->model->id_compania.'"');
    
    if($lote==''){ 
    
    
    //Actualizo la cantidad en el lote default
    $now_qty = $this->model->Query_value('STOCK_ITEMS_LOCATION','sum(qty)','Where lote="'.$item.'0000" and ID_compania="'.$this->model->id_compania.'"');
    
    $qty_to_up = $now_qty - $qty;
    
    
    $query= 'UPDATE STOCK_ITEMS_LOCATION SET qty="'.$qty_to_up.'" where lote="'.$item.'0000" and location="1" and stock="1" and ID_compania="'.$this->model->id_compania.'"';
    $res = $this->model->Query($query);
    
    
    
    
    //Agrego nuevo lote
    $value  = array(
      'ProductID' => $item ,
      'no_lote' => $no_lote ,
      'fecha_ven' => $fecha,
      'REG_KEY' => uniqid(),
      'ID_compania' => $this->model->id_compania );
    
    
    $res = $this->model->insert('ITEMS_NO_LOTES',$value);
    if($this->CheckError()){

        echo $this->CheckError();
        die();

    } 
    
    //Agrego ubicacion de nuevo lote por default
    $value  = array(
      'itemID' => $item ,
      'lote' => $no_lote ,
      'qty' => $qty ,
      'stock' => '1',
      'location' => '1',
      'ID_compania' => $this->model->id_compania );
    
    $res = $this->model->insert('STOCK_ITEMS_LOCATION',$value);

    if($this->CheckError()){
        
        echo $this->CheckError();
        die();
        
     } 
    
    
}else{


echo 'El No de Lote ya existe, por favor elija otro nombre';


}

}
    
    
public function erase_lote($no_lote,$qty){


$this->model->verify_session();


$item = $this->model->Query_value('ITEMS_NO_LOTES','ProductID','Where no_lote="'.$no_lote.'" and ID_compania="'.$this->model->id_compania.'"');


//Actualizo la cantidad en el lote default
$now_qty = $this->model->Query_value('STOCK_ITEMS_LOCATION','qty','Where lote="'.$item.'0000" and stock="1" and location="1" and ID_compania="'.$this->model->id_compania.'";');

$qty_to_up = $now_qty + $qty;

$query= 'UPDATE STOCK_ITEMS_LOCATION SET qty="'.$qty_to_up.'" where lote="'.$item.'0000" and location="1" and stock="1" and ID_compania="'.$this->model->id_compania.'"';
$res = $this->model->Query($query);


$this->model->Query('DELETE FROM ITEMS_NO_LOTES WHERE no_lote="'.$no_lote.'" and ID_compania="'.$this->model->id_compania.'"');
$this->model->Query('DELETE FROM STOCK_ITEMS_LOCATION WHERE lote="'.$no_lote.'" and ID_compania="'.$this->model->id_compania.'"');

if($this->CheckError()){
    
    echo $this->CheckError();
    die();
    
 } 
}


public function getLocationByItem(){

$this->model->verify_session();

$STATUS_LOC = $this->model->lote_loc_by_itemID($this->ProductID);

            foreach ($STATUS_LOC as $STATUS_LOC) { 

            $STATUS_LOC= json_decode($STATUS_LOC); 



            $ID_STATUS = $STATUS_LOC->{'id'};
            $LOTE= $STATUS_LOC->{'no_lote'};
            $VENC= $STATUS_LOC->{'fecha_ven'};
            $STOCK_QTY= $STATUS_LOC->{'qty'};
            $STOCK_ROUTE= $this->model->Query_value('STOCK_LOCATION','LOCATION','where id="'.$STATUS_LOC->{'location'}.'"');
            $STOCK_NAME=  $this->model->Query_value('STOCKS','name',' where id="'.$STATUS_LOC->{'stock'}.'"');
            
            $STOCK_ROUTE_SRC =  "'".$STOCK_ROUTE."'";
            $STOCK_NAME_SRC =  "'".$STOCK_NAME."'";

            
            $id="'".$Prod_ID."'";
            $lote="'".$STATUS_LOC->{'no_lote'}."'";

            $status_location_id = "'".$STATUS_LOC->{'id'}."'";
            
            $qty="'".$STATUS_LOC->{'qty'}."'";
            $url="'".URL."'";

            
        
            //  if($pendding_sale>0 || $STOCK_QTY>0 ){



            if($STOCK_QTY==0){

                $disabled = 'disabled'; 

            }else{ 

                $disabled = ''; 

            }

        

            if($STATUS_LOC->{'fecha_ven'}!=NULL and $STATUS_LOC->{'fecha_ven'}!='0000-00-00 00:00:00' ){

            $venc = date('Y-m-d',strtotime($STATUS_LOC->{'fecha_ven'}));
            $venc2= "'".date('Y-m-d',strtotime($STATUS_LOC->{'fecha_ven'}))."'";

            }else{

            $venc = '';
            $venc2= "'-'";
            }

            echo '<tr><td><input class="form-control col-lg-2"    value="'.$LOTE.'" readonly/></td>
                <td><input class="form-control col-lg-2"  value="'.$venc.'" readonly/></td>
                <td><input class="numb form-control col-lg-2"  value="'.number_format($STOCK_QTY,0, '.', ',').'" readonly/></td>
                <td><input '.$color.' class="form-control col-lg-2"  value="'.$pendding_sale.'" readonly/></td>
                <td><input class="form-control col-lg-2"  value="'.$STOCK_NAME.'"  readonly/></td>
                <td><input class="form-control col-lg-2"  value="'.$STOCK_ROUTE.'"  readonly/></td>
                <td><button onclick="update_location('.$STOCK_ROUTE_SRC.','.$STOCK_NAME_SRC.','.$url.','.$status_location_id.','.$lote.','.$venc2.','.$qty.');"  class="btn btn-primary  btn-block text-left" type="submit" '.$disabled.' >Reubicar</button></td></tr>';

            
        //   }

    }
}

public function  get_almacen_selectlist(){
    
   $query_almacen= 'SELECT STOCKS.id, STOCKS.name  
    FROM STOCKS
    inner join STOCK_LOCATION on STOCK_LOCATION.stock = STOCKS.id
    where STOCKS.onoff="1" GROUP BY STOCKS.name ';
    
    $select = '<option selected disabled>Seleccionar Almacen</option>';
    $res = $this->model->Query($query_almacen);
    
    foreach ($res as $value) {
      $value = json_decode($value);
      $select.='<option value="'.$value->{'id'}.'">'.$value->{'name'}.'</option>';
      }
    
    $select.='</select>';
    echo $select;
    
    return $select;
    }

public function  get_routes_by_almacenid($almacen){
    
       $query= 'SELECT id , location 
                FROM STOCK_LOCATION 
                WHERE stock="'.$almacen.'" and onoff="1"';
    
        $res = $this->model->Query($query);
    
        echo '<option selected disabled>Seleccionar Ruta</option>';
        foreach ($res as $value) {
        $value = json_decode($value);
        echo '<option value="'.$value->{'id'}.'">'.$value->{'location'}.'</option>';
        }
}
        
public function get_lote_qty($lote,$itemid){

    $this->model->verify_session();

    $res = $this->model->Query_value('STOCK_ITEMS_LOCATION','Floor(qty)','where stock="1" and location="1" and lote="'.$lote.'" and itemID="'.$itemid.'" and ID_compania ="'.$this->model->id_compania.'";');

echo $res;
return $res;
}

public function getItemQtyOnHand($itemid){
    
    $this->model->verify_session();

    $res = $this->model->Query_value('STOCK_ITEMS_LOCATION','SUM(qty)','where  itemID="'.$itemid.'" and ID_compania ="'.$this->model->id_compania.'";');

echo $res;
return $res;
}

public function get_any_lote_qty($idLoc=''){

    $this->model->verify_session();

    $res = $this->model->Query_value('STOCK_ITEMS_LOCATION','Floor(qty)','where id="'.$idLoc.'" and ID_compania ="'.$this->model->id_compania.'";');

echo $res;
return $res;
}



public function set_lote_location($ruta_selected,$almacen_selected,$item_id,$lote,$qty){
$this->model->verify_session();

//UBICO LA CANTIDAD ACTUAL EN STATUS_LOCATION
$CURRENT_QTY = $this->get_lote_qty($lote,$item_id);

//ACTUALIZO LA CANTIDAD EN LA UBICCION DEFAULT
$QTY_TO_SET = $CURRENT_QTY - $qty;

$query= 'UPDATE STOCK_ITEMS_LOCATION  SET qty="'.$QTY_TO_SET.'" where itemID="'.$item_id.'" and stock="1" and location="1" and onoff="1" and ID_compania ="'.$this->model->id_compania.'"';

$res = $this->model->Query($query);



$id_verify = $this->model->Query_value('STOCK_ITEMS_LOCATION ','id','where lote="'.$lote.'" and stock="'.$almacen_selected.'" and location="'.$ruta_selected.'" and ID_compania ="'.$this->model->id_compania.'";');

if(!$id_verify){ 

//agregar nueva location
$val_to_insert = array(
    'lote' => $lote, 
    'stock' => $almacen_selected, 
    'qty' => $qty, 
    'location' => $ruta_selected,
    'itemID' => $item_id,
    'ID_compania' => $this->model->id_compania);

$res = $this->model->insert('STOCK_ITEMS_LOCATION',$val_to_insert);


//registro de traslado Default a una nueva ubicacion
$value_traslate = array(
    'id_almacen_ini' => '1',
    'route_ini' => '1' ,
    'id_almacen_des' => $almacen_selected,
    'route_des' => $ruta_selected,
    'lote' => $lote,
    'qty' => $qty ,
    'ProductID' => $item_id ,
    'id_user' => $this->model->active_user_id
    );

$this->model->insert('reg_traslado',$value_traslate);


}else{

$old_qty = $this->model->Query_value('STOCK_ITEMS_LOCATION','qty','where id="'.$id_verify.'";');

$qty_to_up = $old_qty  + $qty;

$query= 'UPDATE STOCK_ITEMS_LOCATION SET qty="'.$qty_to_up.'"  where id="'.$id_verify.'";';
$this->model->Query($query);


//registro de traslado Default a una nueva ubicacion
$id_route_reg = $this->model->Query_value('STOCK_LOCATION ','route','where id="'.$id_verify.'";');
$id_alma_reg = $this->model->Query_value('STOCK_LOCATION','id_almacen','where id="'.$id_route_reg.'";');


$value_traslate = array(
    'id_almacen_ini' => $id_alma_reg,
    'route_ini' => $id_route_reg,
    'id_almacen_des' => $almacen_selected,
    'route_des' => $ruta_selected,
    'lote' => $lote,
    'qty' => $qty ,
    'ProductID' => $item_id ,
    'id_user' => $this->model->active_user_id
    );

$this->model->insert('reg_traslado',$value_traslate);



}

//$this->clear_lotacion_register();

}



public function update_lote_location($OrigenROUTE,$OrigenALMACEN,$status_location_id,$ruta,$almacen,$lote,$qty){
    
$this->model->verify_session();

//ID DE UBICACIONES DE ORIGEN
$ruta_src = $this->model->Query_value('STOCK_LOCATION','id',' where location="'.$OrigenROUTE.'"');
$almacen_src = $this->model->Query_value('STOCK_LOCATION','stock',' where id="'.$ruta_src.'"');

//ID DEL USER QUE REALIZA EL TRASLADO
$id_user_active = $this->model->active_user_id;

//QTY ACTUAL
$CURRENT_QTY = $this->model->Query_value('STOCK_ITEMS_LOCATION','qty','where id="'.$status_location_id.'";');

$NEW_QTY = $CURRENT_QTY - $qty;

//ACTUALIZA LA CANTIDAD RESTANTE EN LA UBICACION ACTUAL
$query= 'UPDATE STOCK_ITEMS_LOCATION SET qty="'.$NEW_QTY.'" where id="'.$status_location_id.'";';
$this->model->Query($query);


//ID DEL PRODUCT
$ProductID = $this->model->Query_value('STOCK_ITEMS_LOCATION','itemID','where id="'.$status_location_id.'";');


    //VERIFICO SI EXISTE UN LOTE IGUAL EN LA UBICACION DESTINO
    $id_verify = $this->model->Query_value('STOCK_ITEMS_LOCATION','id','where lote="'.$lote.'" and stock="'.$almacen.'" and location="'.$ruta.'" and  ID_compania ="'.$this->model->id_compania.'"');

    if(!$id_verify){ //SI NO EXISTE CREO LA NUEVA UBICACION PARA EL LOTE 

    //agregar nueva location
    $val_to_insert = array(
    'lote' => $lote, 
    'stock' => $almacen, 
    'qty' => $qty, 
    'location' => $ruta,
    'itemID' => $ProductID,
    'ID_compania' => $this->model->id_compania);

    $res = $this->model->insert('STOCK_ITEMS_LOCATION',$val_to_insert);



    //registro de traslado Default a una nueva ubicacion
    $value_traslate = array(
    'id_almacen_ini' => $almacen_src,
    'route_ini' => $ruta_src,
    'id_almacen_des' => $almacen,
    'route_des' => $ruta,
    'lote' => $lote,
    'qty' => $qty ,
    'ProductID' => $ProductID,
    'id_user' => $this->model->active_user_id,
    'ID_compania' => $this->model->id_compania
        );

    $this->model->insert('reg_traslado',$value_traslate);


}else{//SI EXISTE LE SUMO LA NUEVA CANTIDAD

    //consulta qty actual en lla ubicacion destino apra ese lote
    $old_qty = $this->model->Query_value('STOCK_ITEMS_LOCATION','qty','where id="'.$id_verify.'";');

    $qty_to_up = $old_qty  + $qty; //se suma

    //se actualiza
    $query= 'UPDATE STOCK_ITEMS_LOCATION  SET qty="'.$qty_to_up.'"  where id="'.$id_verify.'";';
    $this->model->Query($query);


    //registro de traslado
    $value_traslate = array(
        'id_almacen_ini' => $almacen_src,
        'route_ini' => $ruta_src ,
        'id_almacen_des' => $almacen,
        'route_des' => $ruta,
        'lote' => $lote,
        'qty' => $qty ,
        'ProductID' => $ProductID,
        'id_user' => $this->model->active_user_id,
        'ID_compania' => $this->model->id_compania
        );


    $this->model->insert('reg_traslado',$value_traslate);

    }


}

//dejar de ultimo
public function CheckError(){
    
    
      $CHK_ERROR =  $this->model->read_db_error();
      
      if ($CHK_ERROR!=''){ 
    
       return $CHK_ERROR;
    
      }
    
}


}
?>