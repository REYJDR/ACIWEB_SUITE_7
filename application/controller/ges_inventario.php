<?PHP

class ges_inventario extends Controller
{

public $ProductID;

//******************************************************************************
//LISTA DE PRODUCTOS
public function inv_list(){
 


 $res = $this->model->verify_session();

        if($res=='0'){
        
            // load views
            require APP . 'view/_templates/header.php';
            require APP . 'view/_templates/panel.php';
            require APP . 'view/modules/inventory/invList.php';
            require APP . 'view/_templates/footer.php';


        }
          


	
}

//******************************************************************************
//LISTA DE PRODUCTOS X STOCK
public function invStocklist(){
    
   
   
    $res = $this->model->verify_session();
   
           if($res=='0'){
           
               // load views
               require APP . 'view/_templates/header.php';
               require APP . 'view/_templates/panel.php';
               require APP . 'view/modules/inventory/invStock.php';
               require APP . 'view/_templates/footer.php';
   
   
           }
             
   
   
       
   }

//******************************************************************************
//DETALLES DE PRODUCTO
public function inv_info(){
 
 $this->ProductID = $_GET['item'];

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

//******************************************************************************
//ENTRADA DE INVENTARIO
public function invIn(){
       
$res = $this->model->verify_session();

        if($res=='0'){

            // load views
            require APP . 'view/_templates/header.php';
            require APP . 'view/_templates/panel.php';
            require APP . 'view/modules/inventory/invIn.php';
            require APP . 'view/_templates/footer.php';

        }
           
}

//******************************************************************************
//REPORTE DE SALIDA DE IVENTARIO
public function InvInReport(){
    
     $res = $this->model->verify_session();
    
            if($res=='0'){
    
                // load views
                require APP . 'view/_templates/header.php';
                require APP . 'view/_templates/panel.php';
                require APP . 'view/modules/inventory/InvInReport.php';
                require APP . 'view/_templates/footer.php';
    
            }
        
}

//******************************************************************************
//UBICACIONES 
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
//* OPERATION METHODS
////////////////////////////////////////////////////////////////////////////////////
public function getStockListToSelect(){
    
        $this->model->verify_session();
        $table = '';
    
    
        $query="select * from STOCKS where  
        ID_compania='".$this->model->id_compania."' or
        ID_compania='0' ;";
    
        $select .="<option value='#'>-</option>";

            $res = $this->model->Query($query);
    
            foreach ($res as $datos) {	

            $datos = json_decode($datos);
    
            $id = '"'.$datos->{'id'}.'"';
            $select .="<option value='".$datos->{'id'}."'>".$datos->{'name'}."</option>";

        }
    
        echo $select ;
}

public function getStockList(){

    $this->model->verify_session();
    $table = '';


    $query="select * from STOCKS where onoff='1' and 
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
    
    $query="select * from STOCKS where onoff='1' and id='".$id."';";
    $res = $this->model->Query($query); 

   $table = '<fieldset class="fieldsetform">
            <table class="table_form" >
                <tbody>';

    foreach ($res as $datos) {	
        $datos = json_decode($datos);
        
   $table .=    '<tr><th>ID</th><td>'.$datos->{'id'}.'</td></tr>
                <tr><th>Name</th><td>'.$datos->{'name'}.'</td></tr>
                <tr><th>Description</th><td>'.$datos->{'description'}.'</td></tr>
                <tr><th>Address</th><td>'.$datos->{'address'}.'</td></tr>
                <tr><th>Capacity</th><td>'.$datos->{'capacity'}.'</td></tr>';  
        }

    $id = '"'.$datos->{'id'}.'"';
    $table .= '</tbody>
                </table>
            <div class="col-lg-6"><i style="color:red;"  onclick="removeStock('.$id.')"  class="fas fa-trash-alt" >&nbsp</i><span><a href="#">Eliminar</a></span></div> 
           <!-- <div class="col-lg-6"><i style="color:blue;" onclick=""  class="fas fas fa-edit"  >&nbsp</i><span><a href="#">Modificar</a></span></div> -->
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
        $locName = '"'.$datos->{'location'}.'"';
        echo "<tr><td><a  href='#' onclick='getItemList(".$id.",".$IDstock.",".$locName.");' >".$datos->{'location'}."&nbsp&nbsp<i style='float:right;' class='fas fa-angle-right'></i></a></td></tr>";
    }

}


public function getItemList($location,$stock){

    $this->model->verify_session();

    require_once APP.'view/modules/inventory/lang/'.$this->model->lang.'_ref.php';

        $columns =  array( 
                    '`ProductID`',
                    '`QtyOnHand`',
                    '`lote`');

        $clause = "INNER JOIN Products_Exp as B ON B.ProductID = A.itemID and A.ID_compania='".$this->model->id_compania."'
                    WHERE A.location='".$location."' and 
                        A.stock='".$stock."' and 
                        A.ID_compania='".$this->model->id_compania."' and 
                        B.isActive = '1' and 
                        B.QtyOnHand >= 0;";

        $Item= $this->model->queryColumns('STOCK_ITEMS_LOCATION as A', $columns,$clause);

        if($Item != '' ){
        
        
            $itemarray = [];
            $i = 0;
            
            foreach ($Item as $value) {
                $value =  json_decode($value);
                $itemarray['data'][$i] =  $value;  
                $i += 1;
            }

            echo json_encode($itemarray);

        }else{

        echo 0;
        }

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

public function getStockByItemID(){

    $itemid = $_GET['itemID'];
    $list = '';
    $this->model->verify_session();
        
      $query = 'SELECT 
        A.id as ID,
        B.name AS Stock,
        A.lote,
        C.location as Location
        FROM STOCK_ITEMS_LOCATION as A
        INNER JOIN STOCKS B ON B.id = A.stock 
        INNER JOIN STOCK_LOCATION C ON C.id = A.location
        where  A.itemID="'.$itemid.'" and A.ID_compania ="'.$this->model->id_compania.'"';
        
        
        $res = $this->model->Query($query); 

        foreach ( $res as $data){
        $value = json_decode($data);
    
        $list .= '<option value="'.$value->{'ID'}.'">'.$value->{'Stock'}.' ( '.$value->{'Location'}.' - '.$value->{'lote'}.')</option>';
    
        }
   echo $list ;
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
    
        if($value->{'fecha_fab'}!='0000-00-00 00:00:00' and $value->{'fecha_fab'}!=null){
            
            $fab = date('Y-m-d',strtotime($value->{'fecha_fab'}));

        }else{

            $fab = '';
        }
    
        $table_lote.= '<tr>     
              <td><input class="form-control col-lg-2"  value="'.$value->{'no_lote'}.'" readonly/></td>
              <td><input class="form-control col-lg-2"  value="'. $fab.'" readonly/></td>
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

public function SET_NO_LOTE($item,$no_lote,$qty,$fecha,$fechaFab){
    
    
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
        'fecha_fab' => $fechaFab,
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
        

            //registro de traslado
            $id_user_active = $this->model->active_user_id;


            $values = array (
                'ItemID' => $item , 
                'Reference' => 'LOT-'.date('dmyhms'), 
                'Qty'  => $qty, 
                'aci_ref' => 'LOT-'.date('dmyhms'), 
                'stockOrigID' =>  0,
                'stockDestID' =>  $this->model->Query_value('STOCK_ITEMS_LOCATION', 'id', 'where lote="'.$no_lote.'" and location="1" and stock="1" ') );

            $this->set_Budget_Log($values,'6');



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
            $FAB= $STATUS_LOC->{'fecha_fab'};
            
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

            if($STATUS_LOC->{'fecha_fab'}!=NULL and $STATUS_LOC->{'fecha_fab'}!='0000-00-00 00:00:00' ){
                
            $fab= date('Y-m-d',strtotime($STATUS_LOC->{'fecha_fab'}));
            $fab2= "'".date('Y-m-d',strtotime($STATUS_LOC->{'fecha_fab'}))."'";

            }else{

            $fab = '';
            $fab2= "'-'";

            }

            echo '<tr><td><input class="form-control col-lg-2"    value="'.$LOTE.'" readonly/></td>
                <td><input class="form-control col-lg-2"  value="'.$fab.'" readonly/></td>
                <td><input class="form-control col-lg-2"  value="'.$venc.'" readonly/></td>
                <td><input class="numb form-control col-lg-2"  value="'.number_format($STOCK_QTY,0, '.', ',').'" readonly/></td>
                <td><input '.$color.' class="form-control col-lg-2"  value="'.$pendding_sale.'" readonly/></td>
                <td><input class="form-control col-lg-2"  value="'.$STOCK_NAME.'"  readonly/></td>
                <td><input class="form-control col-lg-2"  value="'.$STOCK_ROUTE.'"  readonly/></td>
                <td><button onclick="update_location('.$STOCK_ROUTE_SRC.','.$STOCK_NAME_SRC.','.$url.','.$status_location_id.','.$lote.','.$venc2.','.$qty.');"  class="btn btn-primary  btn-block text-left" type="submit" '.$disabled.' >Reubicar</button></td></tr>';

            
        //   }

    }
}

public function get_almacen_selectlist(){
    
   $query_almacen= 'SELECT STOCKS.id, STOCKS.name  
                        FROM STOCKS
                        inner join STOCK_LOCATION on STOCK_LOCATION.stock = STOCKS.id
                        where STOCKS.onoff="1" GROUP BY STOCKS.name ';
    
    $select = '';
    $res = $this->model->Query($query_almacen);
    
    $select.='<option value="">-</option>';

    foreach ($res as $value) {
      $value = json_decode($value);
      $select.='<option value="'.$value->{'id'}.'">'.$value->{'name'}.'</option>';
      }
    
    $select.='</select>';
    echo $select;
    
    return $select;
}

public function get_routes_by_almacenid($almacen){
    
       $query= 'SELECT id , location 
                FROM STOCK_LOCATION 
                WHERE stock="'.$almacen.'" and onoff="1"';
    
        $res = $this->model->Query($query);
        $option = '<option value="#">-</option>';
        $select = '';
        foreach ($res as $value) {
        $value = json_decode($value);
        $option .= '<option value="'.$value->{'id'}.'">'.$value->{'location'}.'</option>';
        }
        echo $option;
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

    $res = $this->model->Query_value('STOCK_ITEMS_LOCATION','Floor(qty)','where id="'.$idLoc.'" and ID_compania="'.$this->model->id_compania.'";');


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
  /*  $value_traslate = array(
        'id_almacen_ini' => '1',
        'route_ini' => '1' ,
        'id_almacen_des' => $almacen_selected,
        'route_des' => $ruta_selected,
        'lote' => $lote,
        'qty' => $qty ,
        'ProductID' => $item_id ,
        'id_user' => $this->model->active_user_id
        );

    $this->model->insert('reg_traslado',$value_traslate); */


    }else{

    $old_qty = $this->model->Query_value('STOCK_ITEMS_LOCATION','qty','where id="'.$id_verify.'";');

    $qty_to_up = $old_qty  + $qty;

    $query= 'UPDATE STOCK_ITEMS_LOCATION SET qty="'.$qty_to_up.'"  where id="'.$id_verify.'";';
    $this->model->Query($query);


    //registro de traslado Default a una nueva ubicacion
    $id_route_reg = $this->model->Query_value('STOCK_LOCATION ','route','where id="'.$id_verify.'";');
    $id_alma_reg = $this->model->Query_value('STOCK_LOCATION','id_almacen','where id="'.$id_route_reg.'";');


   /* $value_traslate = array(
        'id_almacen_ini' => $id_alma_reg,
        'route_ini' => $id_route_reg,
        'id_almacen_des' => $almacen_selected,
        'route_des' => $ruta_selected,
        'lote' => $lote,
        'qty' => $qty ,
        'ProductID' => $item_id ,
        'id_user' => $this->model->active_user_id
        );

    $this->model->insert('reg_traslado',$value_traslate); */



 }

    //registro de traslado
    $ConNo = $this->model->Get_con_No();
    
    $values = array ( 'refReg' => 'MOV-'.date('dmyhms'), 
                    'refAci' => $ConNo , 
                    'idUser' => $id_user_active  , 
                    'nota' => 'Generada automaticamente por reubicación de material' , 
                    'ID_compania' =>  $this->model->id_compania );

                    
    $this->model->insert('CON_HEADER',$values);


    $values = array (
        'ItemID' => $ProductID, 
        'Reference' => 'LOT-'.date('dmyhms'), 
        'Qty'  => $qty, 
        'aci_ref' => $ConNo,
        'stockOrigID' => $status_location_id,
        'stockDestID' => $this->model->Query_value('STOCK_ITEMS_LOCATION', 'id', 'where lote="'.$lote.'" and location="'.$ruta_selected.'" and stock="'.$almacen_selected.'" ') );

    $this->set_Budget_Log($values,'6');
 

 //$this->clear_lotacion_register();

}


public function update_lote_location($OrigenROUTE,$OrigenALMACEN,$status_location_id,$ruta,$almacen,$lote,$qty, $mov = 0){
    
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



        }else{//SI EXISTE LE SUMO LA NUEVA CANTIDAD

            //consulta qty actual en lla ubicacion destino apra ese lote
            $old_qty = $this->model->Query_value('STOCK_ITEMS_LOCATION','qty','where id="'.$id_verify.'";');

            $qty_to_up = $old_qty  + $qty; //se suma

            //se actualiza
            $query= 'UPDATE STOCK_ITEMS_LOCATION  SET qty="'.$qty_to_up.'"  where id="'.$id_verify.'";';
            $this->model->Query($query);


        }

        usleep(1000);
        $error = $this->CheckError();
        if($error){
            $error= json_decode($error) ;
                echo 'ERROR: '.$error->{'E'}.' UPDATE STOCK LOCATION - itemID:'.$ProductID;
            die();
            
        }

        if($mov == 1 ){

            //registro de traslado
            $ConNo = $this->model->Get_con_No();
            
            $values = array ( 'refReg' => 'MOV-'.date('dmyhms'), 
                              'refAci' => $ConNo , 
                              'idUser' => $id_user_active  , 
                              'nota' => 'Generada automaticamente por reubicación de material' , 
                              'ID_compania' =>  $this->model->id_compania );

                              
            $this->model->insert('CON_HEADER',$values);


            $values = array (
                'ItemID' => $ProductID, 
                'Reference' => 'MOV-'.date('dmyhms'), 
                'Qty'  => $qty, 
                'aci_ref' => $ConNo,
                'stockOrigID' => $status_location_id,
                'stockDestID' => $this->model->Query_value('STOCK_ITEMS_LOCATION', 'id', 'where lote="'.$lote.'" and location="'.$ruta.'" and stock="'.$almacen.'" ') );

            $this->set_Budget_Log($values,'5');

        }
       






}

public function getJobList(){

    $this->model->verify_session();

    $res = $this->model->Query('SELECT A.JobID, B.Description 
                                FROM Job_Estimates_Exp A
                                INNER JOIN  Jobs_Exp B on A.JobID = B.JobID
                                where A.ID_compania ="'.$this->model->id_compania.'" and 
                                    B.ID_compania ="'.$this->model->id_compania.'" Group by JobID');

        foreach ($res as $value) {
        $value = json_decode($value);
        echo '<option value="'.$value->{'JobID'}.'">('.$value->{'JobID'}.') -'.$value->{'Description'}.'</option>';
        }

}

public function getPhaseList($jobid=0){
    
        $this->model->verify_session();
    
        $res = $this->model->Query('SELECT A.PhaseID, B.Description 
                                    FROM Job_Estimates_Exp A
                                    INNER JOIN  Job_Phases_Exp B on A.PhaseID = B.PhaseID
                                    where A.ID_compania ="'.$this->model->id_compania.'" and 
                                          B.ID_compania ="'.$this->model->id_compania.'" and 
                                          A.JobID ="'.$jobid.'" Group by A.PhaseID');

            foreach ($res as $value) {
            $value = json_decode($value);
            echo '<option value="'.$value->{'PhaseID'}.'">('.$value->{'PhaseID'}.') -'.$value->{'Description'}.'</option>';
            }
    
}

public function getCostList($jobid=0,$phaseID=0){
    
        $this->model->verify_session();
    
        $res = $this->model->Query('SELECT A.CostCodeID, B.Description 
                                    FROM Job_Estimates_Exp A
                                    INNER JOIN  Job_Cost_Codes_Exp B on A.CostCodeID = B.CostCodeID
                                    where A.ID_compania ="'.$this->model->id_compania.'" and 
                                          B.ID_compania ="'.$this->model->id_compania.'" and 
                                          A.JobID ="'.$jobid.'" and A.phaseID ="'.$phaseID.'" Group by A.CostCodeID');
    
            foreach ($res as $value) {
            $value = json_decode($value);
            echo '<option value="'.$value->{'CostCodeID'}.'">('.$value->{'CostCodeID'}.') -'.$value->{'Description'}.'</option>';
            }
    
}

public function getBudget($jobid=0,$phaseid=0,$costid=0){

    echo  $this->model->getJob_avalaible_amnt($jobid,$phaseid,$costid);

}


public function setProduct_In($Product_values){
    
        $this->model->verify_session();
    
        $this->model->insert('Products_Imp',$Product_values); //set Product line
    
}


public function if_ProductExist_chk($ProductID){

 $Product_chk = $this->Query_value('Products_Imp','ProductID','where ID_compania="'.$this->model->id_compania.'" and ProductID="'.$ProductID.'"');


    if ($Product_chk) {

        return true;

    }else{

        return false;
    }

}


public function getVendorList(){

 $this->model->verify_session();

 $sql = 'SELECT * FROM Vendors_Exp WHERE ID_compania = "'.$this->model->id_compania.'" AND IsActive ="1"';

 $res = $this->model->Query($sql);

 foreach ($res as  $value) {
     $value = json_decode($value);
     echo '<option value="'.$value->{'VendorID'}.'">('.$value->{'VendorID'}.')-'.$value->{'Name'}.'</option>';
     

 }

}
//dejar de ultimo
public function CheckError(){
    
    
      $CHK_ERROR =  $this->model->read_db_error();
      
      if ($CHK_ERROR!=''){ 
    
       return $CHK_ERROR;
    
      }
    
}



///////////////////////////////Purchase!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
public function set_Purchase_Header(){
    
    $this->model->verify_session();
        
    $data = json_decode($_GET['Data']);
    $value = $data[0];
    
    
    list($PurchaseNumber,$date,$VendorID,$OC,$total) = explode('@', $value );

    if($OC != '' || $OC != '-' ){
        $ApplyToPurOrderNumber = $OC;
        $ApplyToPurchaseOrder  = true;
        
    }else{
        $ApplyToPurOrderNumber = '';
        $ApplyToPurchaseOrder  = false;

    }

    
    $date = strtotime($this->model->GetLocalTime(date("Y-m-d")));
    $date = date("Y-m-d",$date);
    
    $values = array(
    'ID_compania'=>$this->model->id_compania,
    'PurchaseNumber'=> $PurchaseNumber,
    'VendorID'=>   $VendorID,
    'AP_Account'=> $this->model->Query_value('CTA_GL_CONF','CTA_CXP','WHERE ID_compania="'.$this->model->id_compania.'"'),
    'Date'=>$date,
    'USER' => $this->model->active_user_id,
    'Subtotal' => $total,
    'Net_due' => $total);
    
    $this->model->insert('Purchase_Header_Imp',$values);
    
    usleep(1000);
    $error = $this->CheckError();
    if($error){
        $error= json_decode($error) ;
            echo 'ERROR: '.$error->{'E'}.' Purchase_Header_Imp';
        die();
        
    }else{
        $PurchaseID = $this->model->Get_CO_No();
        echo $PurchaseID;
    }
    
   
    
}

public function set_Purchase_Detail($PurchaseID){
    
        $this->model->verify_session();
        
        $id_compania= $this->model->id_compania;
        
        $data = json_decode($_GET['Data']);
        
        foreach ($data as $key => $value) {
        
        if($value){
    
        list($empty,$Item_id,$Description,$GL_Acct,$JobID,$JobPhaseID,$JobCostCodeID,$Quantity,$Unit_Price,$Net_line) = explode('@', $value );
  
    
          //EN CASO QUE NO SE HAGA CONVERSION DE UNIDDES ESCRIBE EN LA TABLA DE SALES ORDER DETAIL SIN INDICAR EL ITEMID. 
          $Purchase_values = array(
              'ID_compania' => $id_compania,
              'TransactionID'=>$PurchaseID,
              'Item_id'=>$Item_id,
              'Description'=> $Description,
              'GL_Acct'=>$GL_Acct,
              'JobID'=>$JobID,
              'JobPhaseID'=>$JobPhaseID,
              'JobCostCodeID'=>$JobCostCodeID,
              'Quantity'=>$Quantity,
              'Unit_Price'=>$Unit_Price,
              'Net_line'=>$Net_line);
    
          $this->model->insert('Purchase_Detail_Imp',$Purchase_values); //set item line
          
          usleep(1000);
          $error = $this->CheckError();
          if($error){
            $error= json_decode($error) ;
            echo 'ERROR: '.$error->{'E'}.' Purchase_Detail_Imp ';

            $this->model->delete('Purchase_Header_Imp',' Where TransactionID="'.$PurchaseID.'" and ID_Compania="'.$id_compania.'";');
            die(); 

          }else{

               $this->set_Budget_Log($Purchase_values,1);

          }
     }
    }
    echo '1';
    
}

public function exeConsig(){
    
        $this->model->verify_session();
  
        $id_compania= $this->model->id_compania;
        $user = $this->model->active_user_id;
        $ConNo = '';
    
        $data = json_decode($_GET['Data']);

        //Header consignacion
        list($null,$itemid,$origenID,$stockId,$locId,$qty,$note,$ref) = explode('@', $data[1]);

        $ConNo = $this->model->Get_con_No();
        
        $values = array ( 'refReg' => $ref, 
                          'refAci' => $ConNo , 
                          'idUser' => $user , 
                          'nota' => $note , 
                          'ID_compania' =>  $id_compania );

        $this->model->insert('CON_HEADER',$values);
       
        usleep(1000);
        $error = $this->CheckError();
        if($error){
            $error= json_decode($error) ;
                echo 'ERROR: '.$error->{'E'}.' CON_HEADER - Ref:'.$ConNo;
            die();
            
        }

    
        foreach ($data as $key => $value) {
    
        list($null,$itemid,$origenID,$stockId,$locId,$qty,$note,$ref) = explode('@', $value );
    
            
            if($value){
                
                $ConNo = $this->model->Get_con_No();


                    $stockValues = $this->model->Query('select location, stock, lote from STOCK_ITEMS_LOCATION where id="'.$origenID.'"');

                    $stockValues = json_decode($stockValues[0]);


                    $OrigenROUTE   =  $stockValues->{'location'};
                    $OrigenALMACEN =  $stockValues->{'sotck'};
                    $lote          =  $stockValues->{'lote'};



                    $status_location_id = $origenID;
                

                  
                   $this->update_lote_location($OrigenROUTE,$OrigenALMACEN,$status_location_id,$locId,$stockId,$lote,$qty,0);
              
                
                   usleep(1000);
                   $error = $this->CheckError();
                   if($error){
                       $error= json_decode($error) ;
                           echo 'ERROR: '.$error->{'E'}.' Traspaso - Ref:'.$ConNo;
                       die();
                       
                   }else{


                     $values = array (
                    'ItemID' => $itemid, 
                    'Reference' => $ref, 
                    'origen' => $origenID , 
                    'stockId' => $stockId , 
                    'locId' => $locId , 
                    'Qty'  => $qty, 
                    'aci_ref' => $ConNo,
                    'stockOrigID' => $origenID,
                    'stockDestID' => $this->model->Query_value('STOCK_ITEMS_LOCATION', 'id', 'where lote="'.$lote.'" and location="'.$locId.'" and stock="'.$stockId.'" ') );

                  

                    $this->set_Budget_Log($values,'4');
                    $ref .= 'Item:'.$itemid.'Ref: '.$ref."\n";

                   }

                 
                
            }
        }
        if(!$error){
    
            echo $ref;
        }

}
  

public function set_Budget_Log($values,$type){

    $this->model->verify_session();

    switch ($type) {

        case '1':

                $PurchaseNumber = $values['TransactionID']; 
                $Item  = $values['Item_id'];
                $phase = $values['JobPhaseID']; 
                $job   = $values['JobID']; 
                $cost  = $values['JobCostCodeID']; 
                $total = $values['Net_line']; 
                $Qty   = $values['Quantity'];
                $UnitPrice = $values['Unit_Price'];
                $aciref = $values['aci_ref'];
            
                $id_compania= $this->model->id_compania;
                $user = $this->model->active_user_id;
            
                $event_values = array(  'ProductID' => $Item,
                                        'JobID' => $job,
                                        'JobPhaseID' => $phase,
                                        'JobCostCodeID' => $cost,
                                        'PurchaseNumber' => $PurchaseNumber,
                                        'Qty'=> $Qty,
                                        'unit_price' => $UnitPrice ,
                                        'Total' => $total,
                                        'User' => $user,
                                        'Type' => 'Entrada - Fact. de compra',
                                        'Referencia' => $PurchaseNumber,
                                        'ID_compania' => $id_compania ,
                                        'aci_ref' => $aciref ,
                                        'stockDestID' => $this->model->Query_value('STOCK_ITEMS_LOCATION', 'id', 'where lote="'.$Item.'0000" and location="1" and stock="1" ') );
                          
                $this->model->insert('INV_EVENT_LOG',$event_values); //set event Line
                
                usleep(1000);
                $error = $this->CheckError();
                if($error){
                $error= json_decode($error) ;
                echo 'ERROR: '.$error->{'E'}.' INV_EVENT_LOG ';
            
                  $this->model->delete('Purchase_Header_Imp',' Where TransactionID="'.$PurchaseNumber.'" and ID_Compania="'.$id_compania.'";');
                  $this->model->delete('Purchase_Detail_Imp',' Where TransactionID="'.$PurchaseNumber.'" and ID_Compania="'.$id_compania.'";');
                
                die(); 
            
                }
            break;


        case '2':
        
           
                $PurchaseNumber = $values['Reference']; 
                $Item  = $values['ItemID'];
                $phase = $values['JobPhaseID']; 
                $job   = $values['JobID']; 
                $cost  = $values['JobCostCodeID']; 
                $total = $values['Quantity']*$values['UnitCost']; 
                $Qty   = $values['Quantity'];
                $UnitPrice = $values['UnitCost'];
            
                $id_compania= $this->model->id_compania;
                $user = $this->model->active_user_id;
            
                $stockDestID = $this->model->Query_value('STOCK_ITEMS_LOCATION', 'id', 'where lote="'.$Item.'0000" and location="1" and stock="1" and ID_compania ="'.$id_compania.'" ') ;

                if($stockDestID == '' ){
                   
                    $stockDestID = $this->model->Query_value('STOCK_ITEMS_LOCATION', 'id', 'where lote="'.$Item.'0000" and ID_compania ="'.$id_compania.'" limit 1  ') ;

                }

                
                $event_values = array(  'ProductID' => $Item,
                                        'JobID' => $job,
                                        'JobPhaseID' => $phase,
                                        'JobCostCodeID' => $cost,
                                        'PurchaseNumber' => '',
                                        'Qty'=> $Qty,
                                        'unit_price' => $UnitPrice ,
                                        'Total' => $total,
                                        'User' => $user,
                                        'Type' => 'Entrada por Adjuste',
                                        'Referencia' => $PurchaseNumber,
                                        'ID_compania' => $id_compania ,
                                        'stockDestID' => $stockDestID );
            
                $this->model->insert('INV_EVENT_LOG',$event_values); //set event Line
                
                usleep(1000);
                $error = $this->CheckError();
                if($error){
                $error= json_decode($error) ;
                echo 'ERROR: '.$error->{'E'}.' INV_EVENT_LOG ';
            
                $this->model->delete('InventoryAdjust_Imp',' Where Reference="'.$PurchaseNumber.'" and ID_Compania="'.$id_compania.'";');
               
                die(); 
            
                }
            break;

        case '3':
        
           
                $PurchaseNumber = $values['Reference']; 
                $Item  = $values['ItemID'];
                $phase = $values['JobPhaseID']; 
                $job   = $values['JobID']; 
                $cost  = $values['JobCostCodeID']; 
                $total = $values['Quantity']*$values['UnitCost']; 
                $Qty   = $values['Quantity'];
                $UnitPrice = $values['UnitCost'];
                $aciref = $values['aci_ref'];
            
                $id_compania= $this->model->id_compania;
                $user = $this->model->active_user_id;
            
                $event_values = array(  'ProductID' => $Item,
                                        'JobID' => $job,
                                        'JobPhaseID' => $phase,
                                        'JobCostCodeID' => $cost,
                                        'PurchaseNumber' => '',
                                        'Qty'=> $Qty,
                                        'unit_price' => $UnitPrice ,
                                        'Total' => (-1)*$total,
                                        'User' => $user,
                                        'Type' => 'Salida por Ajuste',
                                        'Referencia' => $PurchaseNumber,
                                        'ID_compania' => $id_compania ,
                                        'aci_ref' => $aciref ,
                                        'stockOrigID' => $this->model->Query_value('STOCK_ITEMS_LOCATION', 'id', 'where lote="'.$Item.'0000" and location="1" and stock="1" ') );
                             
            
                $this->model->insert('INV_EVENT_LOG',$event_values); //set event Line
                
                usleep(1000);
                $error = $this->CheckError();
                if($error){
                $error= json_decode($error) ;
                echo 'ERROR: '.$error->{'E'}.' INV_EVENT_LOG ';
            
                $this->model->delete('InventoryAdjust_Imp',' Where Reference="'.$PurchaseNumber.'" and ID_Compania="'.$id_compania.'";');
               
                die(); 
            
                }
                break;

        case '4':
            

            $ref = $values['Reference']; 
            $Item  = $values['ItemID'];
            $Qty   = $values['Qty'];
            $aciref = $values['aci_ref'];
            $stockOrigID =  $values['stockOrigID'];
            $stockDestID =  $values['stockDestID'];
        
            $id_compania= $this->model->id_compania;
            $user = $this->model->active_user_id;
        
            $event_values = array(  'ProductID' => $Item,
                                    'Qty'=> $Qty,
                                    'User' => $user,
                                    'Type' => 'Traspaso',
                                    'referencia' => $ref,
                                    'ID_compania' => $id_compania ,
                                    'aci_ref' => $aciref,
                                    'stockOrigID'  => $stockOrigID ,
                                    'stockDestID'  => $stockDestID );
        
            $this->model->insert('INV_EVENT_LOG',$event_values); //set event Line
            
            usleep(1000);
            $error = $this->CheckError();
            if($error){
            $error= json_decode($error) ;
            echo 'ERROR: '.$error->{'E'}.' INV_EVENT_LOG ';
        
               $this->model->delete('CON_HEADER',' Where Reference="'.$ref.'" and ID_Compania="'.$id_compania.'";');
            
            die(); 
        
            }
         break;


        case '5':
         
         $ref = $values['Reference']; 
         $Item  = $values['ItemID'];
         $Qty   = $values['Qty'];
         $aciref = $values['aci_ref'];
         $stockOrigID =  $values['stockOrigID'];
         $stockDestID =  $values['stockDestID'];
     
         $id_compania= $this->model->id_compania;
         $user = $this->model->active_user_id;
     
         $event_values = array(  'ProductID' => $Item,
                                 'Qty'=> $Qty,
                                 'User' => $user,
                                 'Type' => 'Reubicación',
                                 'referencia' => $ref,
                                 'ID_compania' => $id_compania ,
                                 'aci_ref' => $aciref,
                                 'stockOrigID'  => $stockOrigID ,
                                 'stockDestID'  => $stockDestID );
     
         $this->model->insert('INV_EVENT_LOG',$event_values); //set event Line
         
         usleep(1000);
         $error = $this->CheckError();
         if($error){
         $error= json_decode($error) ;
         echo 'ERROR: '.$error->{'E'}.' INV_EVENT_LOG ';
     
            $this->model->delete('CON_HEADER',' Where Reference="'.$ref.'" and ID_Compania="'.$id_compania.'";');
         
         die(); 
     
         }
         break;
   
        case '6':
         

                $ref = $values['Reference']; 
                $Item  = $values['ItemID'];
                $Qty   = $values['Qty'];
                $aciref = $values['aci_ref'];
                $stockOrigID =  $values['stockOrigID'];
                $stockDestID =  $values['stockDestID'];
            
                $id_compania= $this->model->id_compania;
                $user = $this->model->active_user_id;
            
                $event_values = array(  'ProductID' => $Item,
                                        'Qty'=> $Qty,
                                        'User' => $user,
                                        'Type' => 'Nuevo Lote',
                                        'referencia' => $ref,
                                        'ID_compania' => $id_compania ,
                                        'aci_ref' => $aciref,
                                        'stockOrigID'  => $stockOrigID ,
                                        'stockDestID'  => $stockDestID );
            
                $this->model->insert('INV_EVENT_LOG',$event_values); //set event Line
                
                usleep(1000);
                $error = $this->CheckError();
                if($error){
                $error= json_decode($error) ;
                echo 'ERROR: '.$error->{'E'}.' Nuevo Lote - INV_EVENT_LOG ';
            
                
                
                die(); 
            
            }
          break;

        case '7':

                $ref = $values['Reference']; 
                $Item  = $values['ItemID'];
                $Qty   = $values['Qty'];
                $aciref = $values['aci_ref'];
                $stockOrigID =  $values['stockOrigID'];
                $stockDestID =  $values['stockDestID'];
            
                $id_compania= $this->model->id_compania;
                $user = $this->model->active_user_id;
            
                $event_values = array(  'ProductID' => $Item,
                                        'Qty'=> $Qty,
                                        'User' => $user,
                                        'Type' => 'Reversa Orden de Venta',
                                        'referencia' => $ref,
                                        'ID_compania' => $id_compania ,
                                        'aci_ref' => $aciref,
                                        'stockOrigID'  => $stockOrigID ,
                                        'stockDestID'  => $stockDestID );
            
                $this->model->insert('INV_EVENT_LOG',$event_values); //set event Line
                
                usleep(1000);
                $error = $this->CheckError();
                if($error){
                $error= json_decode($error) ;
                echo 'ERROR: '.$error->{'E'}.' Reversa Orden de Venta - INV_EVENT_LOG ';
            
                }

          break;

        } 


}

public function getInvInList($sort,$limit,$clause){

    
     $sql = 'SELECT * FROM INV_EVENT_LOG '.$clause.' Order by Date '.$sort.' limit '.$limit;
    
     $res = $this->model->Query($sql);

     return $res;
}


public function setInventoryAdjustment(){
    
    $this->model->verify_session();
    $id_compania= $this->model->id_compania;
    $user = $this->model->active_user_id;
    $ref = '';

    $data = json_decode($_GET['Data']);
 
    foreach ($data as $key => $value) {

        list($null,$Item_id,$Description,$GL_Acct,$JobID,$JobPhaseID,$JobCostCodeID,$Quantity,$Unit_Price,$Net_line) = explode('@', $value );
        

        if($value){
            
            $date = strtotime($this->model->GetLocalTime(date("Y-m-d")));
            $date = date("Y-m-d",$date);
            $reference = $this->model->Get_Ref_No();
            
            $values = array (
                'ItemID' => $Item_id, 
                'JobID' => $JobID, 
                'JobPhaseID' => $JobPhaseID, 
                'JobCostCodeID' => $JobCostCodeID , 
                'Reference' => $reference , 
                'ReasonToAdjust' => 'Aciweb - Entrada de mercancia' , 
                'Account' => $GL_Acct , 
                'UnitCost' => $Unit_Price , 
                'Quantity' => $Quantity, 
                'Date' => $date , 
                'USER' => $user , 
                'ID_compania' =>  $id_compania );

            $this->model->insert('InventoryAdjust_Imp',$values);
            
            usleep(1000);
            $error = $this->CheckError();
            if($error){
                $error= json_decode($error) ;
                    echo 'ERROR: '.$error->{'E'}.' InventoryAdjust_Imp - itemID '.$itemid.' Ref:'.$reference;
                die();
                
            }else{
               
                $this->set_Budget_Log($values,'2');
                $ref .= 'Item:'.$itemid.'Ref: '.$reference."\n";
            }
        }
    }
    if(!$error){

        echo $ref;
    }
    
}

public function setInventoryAdjustmentOUT(){

    $this->model->verify_session();
    $id_compania= $this->model->id_compania;
    $user = $this->model->active_user_id;
    $ref = '';

    $data = json_decode($_GET['Data']);

    foreach ($data as $key => $value) {

        list($null,$itemid,$unitprice,$qty,$total,$note,$ctamg,$job,$phs,$cost,$ref) = explode('@', $value );

        
        if($value){
            
            $date = strtotime($this->model->GetLocalTime(date("Y-m-d")));
            $date = date("Y-m-d",$date);
            $reference = $this->model->Get_Ref_No();
            
            $values = array (
                'ItemID' => $itemid, 
                'Reference' => $reference , 
                'ReasonToAdjust' => $note , 
                'Account' => $ctamg , 
                'UnitCost' => $unitprice , 
                'Quantity' => $qty*(-1), 
                'Date' => $date , 
                'USER' => $user , 
                'JobPhaseID' => $phs,
                'JobCostCodeID' => $cost, 
                'JobID' => $job,
                'ID_compania' =>  $id_compania,
                'aci_ref' => $ref);

            $this->model->insert('InventoryAdjust_Imp',$values);
            
            usleep(1000);
            $error = $this->CheckError();
            if($error){
                $error= json_decode($error) ;
                    echo 'ERROR: '.$error->{'E'}.' InventoryAdjust_Imp - itemID '.$itemid.' Ref:'.$reference;
                die();
                
            }else{
            
                $this->set_Budget_Log($values,'3');
                $ref .= 'Item:'.$itemid.'Ref: '.$reference."\n";
            }
        }
    }
    if(!$error){

        echo $ref;
    }
}


public function getListItems(){

     
    $this->model->verify_session();

    $id_compania= $this->model->id_compania;

    require_once APP.'view/modules/inventory/lang/'.$this->model->lang.'_ref.php';

    $columns =  array( 
                '`ProductID` as `'.$Tblcol1.'`',
                '`Description` as `'.$Tblcol2.'`',
                '`UnitMeasure` as `'.$Tblcol3.'`',
                '`stockQTY` as `'.$Tblcol4.'`',
                '`LastUnitCost` as `'.$Tblcol8.'`');

   $clause = ' INNER JOIN ( SELECT SUM(qty) as stockQTY , 
                             itemID FROM STOCK_ITEMS_LOCATION  WHERE ID_compania="'.$id_compania.'"  GROUP BY  itemID ) AS STK ON STK.itemID = Products_Exp.ProductID
                WHERE Products_Exp.id_compania="'.$id_compania.'" GROUP BY Products_Exp.ProductID';

   $Item= $this->model->queryColumns('Products_Exp', $columns,$clause);

   if($Item != '' ){
    
  
        $itemarray = [];
        $i = 0;
        
        foreach ($Item as $value) {
            $value =  json_decode($value);
            $itemarray['data'][$i] =  $value;  
            $i += 1;
        }

        echo json_encode($itemarray);

 

   }else{

    echo 0;
   }
  


}


public function getItemsStocksList(){
    
 
        $this->model->verify_session();
    
        require_once APP.'view/modules/inventory/lang/'.$this->model->lang.'_ref.php';
    
        $columns =  array( 
                    'D.ProductID as '.$STblcol1,
                    'D.Description as '.$STblcol2,
                    'E.no_lote as '.$STblcol3,
                    'E.fecha_ven as '.$STblcol4,
                    'A.qty as '.$STblcol5,
                    'C.name as '.$STblcol6,
                    'C.description as '.$STblcol7,
                    'B.location as '.$STblcol8,
                    'A.last_change as '.$STblcol9 );
    
        $clause = ' INNER JOIN STOCK_ITEMS_LOCATION AS A  ON D.ProductID = A.itemID
                    LEFT JOIN ITEMS_NO_LOTES AS E ON E.no_lote = A.lote
                    LEFT JOIN STOCK_LOCATION  AS B ON  B.id = A.Location
                    LEFT JOIN STOCKS AS C on C.ID = A.stock
                    
                WHERE D.id_compania="'.$this->model->id_compania.'"';

       $Item= $this->model->queryColumns('Products_Exp as D', $columns,$clause);
    
       if($Item != '' ){
        
      
            $itemarray = [];
            $i = 0;
            
            foreach ($Item as $value) {
                $value =  json_decode($value);
                $itemarray['data'][$i] =  $value;  
                $i += 1;
            }
    
            echo json_encode($itemarray);
    
     
    
       }else{
    
        echo 0;
       }
      
    
    
}

public function getStocLockName($id){
    
        $this->model->verify_session();
    
        
       $SQL =  'SELECT B.location,
                      C.name 
                FROM STOCK_ITEMS_LOCATION as A
                LEFT JOIN STOCK_LOCATION AS B ON  B.id = A.Location
                LEFT JOIN STOCKS AS C on C.ID = A.stock 
                WHERE A.id="'.$id.'"';
    

    
        $Item= $this->model->Query($SQL);

        if($Item){
            $Item = json_decode($Item[0]);

            if($Item->{'name'} != null || $Item->{'location'} != null )
            return $Item->{'name'}.'-('.$Item->{'location'}.')';
        }

        

      
}



public function addItem(){

    $this->model->verify_session();
    $id_compania= $this->model->id_compania;
    $user = $this->model->active_user_id;


    $itemId   = $_GET['itemId'];
    $itemDesc = $_GET['itemDesc'];


    $itemUnitPrice   = $_GET['itemUnitPrice'];
    $itemUnitMeasure =  $_GET['itemUnitMeasure'];
    $itemQty     =  $_GET['itemQty'];
    $itemTaxType = $_GET['itemTaxType']; 
    $itemGlAccnt = $_GET['itemGlAccnt']; 
    $itemUpc     = $_GET['itemUpc']; 
    $itemStock   = $_GET['itemStock']; 
    $itemRoute   = $_GET['itemRoute']; 

   $exist =  $this->model->Query_value('Products_Exp','ProductID',' where ProductID="'.$itemId.'" and ID_compania="'.$id_compania.'" ');

   if( $exist != ''){

     echo 0;

   }else{

        $columns = array('ProductID' =>  $itemId,
                        'Description' => $itemDesc,
                        'QtyOnHand' => $itemQty ,
                        'Price1' =>  $itemUnitPrice,
                        'TaxType' => $itemTaxType,
                        'UnitMeasure' => $itemUnitMeasure,
                        'id_compania' => $id_compania,
                        'UPC_SKU' => $itemUpc ,
                        'GL_Sales_Acct' => $itemGlAccnt ,
                        'LastUnitCost' =>  $itemUnitPrice );

        $this->model->insert('Products_Exp',$columns); 

        $error = $this->CheckError();
        if($error){
            $error= json_decode($error) ;
                echo 'ERROR: '.$error->{'E'}.' Products';
            die();
            
        }else{

            $columns = array( 'stock'    =>  $itemStock , 
                              'location' =>  $itemRoute  );

            $this->model->update('STOCK_ITEMS_LOCATION', $columns, ' lote = "'.$itemId.'0000"  and ID_compania="'.$id_compania.'" ');

            $stockID = $this->model->Query_value('STOCK_ITEMS_LOCATION','id',' where lote = "'.$itemId.'0000"  and ID_company="'.$id_compania.'"');
            

            $user        = $this->model->active_user_id;
            
            $event_values = array(  'ProductID' => $itemId,
                                    'JobID' => '',
                                    'JobPhaseID' => '',
                                    'JobCostCodeID' => '',
                                    'PurchaseNumber' => '',
                                    'Qty'=> $itemQty,
                                    'unit_price' => $itemUnitPrice ,
                                    'Total' => $itemQty * $itemUnitPrice,
                                    'User' => $user,
                                    'Type' => 'Entrada de mercancia',
                                    'Referencia'  => 'IN_'.$itemId,
                                    'ID_compania' => $id_compania,
                                    'stockOrigID' => $stockID);
            //set event Line              
            $this->model->insert('INV_EVENT_LOG',$event_values); 


            echo 1;

        }

          


   }
   

}

}//CIERRE DE CLASE





?>