<?php

error_reporting(1); 


class Model
{
    /**
     * @param object $db A PDO database connection
     */

     public  $active_user_id = null;
     public  $active_user_name  = null;
     public  $active_user_lastname  = null;
     public  $active_user_email  = null;
     public  $active_user_role  = null;
     public  $active_user_almacen  = null;
     public  $id_compania = null;
     public  $sage_connected = null;
     public  $role_compras = null;
     public  $role_campo = null;
     public  $can_close = null;
     public  $layout_lines= null;
      

    function __construct($db,$dbname)
    {
        try {
           
           $this->db = $db;
           $this->dbname = $dbname;

        } catch (mysqli_connect_errno $e) {
            exit('No se pude realizar la conexion a la base de datos');
        }

         $this->sage_connected =   $this->ConexionSage();

         
    }
    
////////////////////////////////////////////////////////////////////////////////////////
/**
* test connetion BD
*/ 
    public function TestConexion(){

            $Mysql =  $this->db; 


            if (mysqli_connect_errno()) {
             
                $status ="Error: (" . mysqli_connect_errno() . ") " . mysqli_connect_error();

            }else{  

                $status= "Conectado a Mysql";

            }

           
            return $status;

            }

    
////////////////////////////////////////////////////////////////////////////////////////
/**
* test connetion BD
*/ 
public function ConexionSage(){

        $connected = $this->Query_value('CompanySession','isConnected','order by LAST_CHANGE DESC limit 1');

return $connected;
}



////////////////////////////////////////////////////////////////////////////////////////
    /**
     * CONNECTION DB
     */
    public function connect($query){

      mysqli_set_charset($this->db, 'utf8' );
      
     
      $conn =  mysqli_query($this->db,$query);

      // Perform a query, check for error
        if (!$conn)
          {

           $conn = "0";

           return $conn;

          }else{

            return $conn;
          }

    
    }
////////////////////////////////////////////////////////////////////////////////////////
    /**
     * Query STATEMEN, DEVUELVE JSON
     */
  public function Query($query){
      //  $this->verify_session();
            
        $ERROR = [];
       
        $i=0;
        $res ='';

        //eliminar occurrencias invalidas de caracteres especiales
        //$query = str_replace("''","'",$query);


        $res = $this->connect($query);


        if(mysqli_error($this->db)){
        
           // $ERROR['ERROR'] = mysqli_error($this->db);
          $ERROR['ERROR'] = date("Y-m-d h:i:sa").'- Error inserting to DataBase, contact to system administrator.';

          file_put_contents("LOG_ERROR/TEMP_LOG.json",json_encode($ERROR),FILE_APPEND);
          file_put_contents("LOG_ERROR/ERROR_LOG.txt","\n".date("Y-m-d h:i:sa").'-(SAGE COMPANY '.$this->id_compania.') MYSQL ERROR '.mysqli_error($this->db)."\n/ Query ".$query,FILE_APPEND);

          
        }else{

             file_put_contents("LOG_ERROR/TEMP_LOG.json",''); //LIMPIO EL ARCHIVO

             $columns = mysqli_fetch_fields($res);
         
        
             while ($datos=  mysqli_fetch_assoc($res)) {
                 
                  foreach ($columns as $value) {
                    $currentField=$value->name;

                    $FIELD[$currentField]=$datos[$currentField];

                    $JSON[$i]=json_encode($FIELD);

                   
                 }
                 $i++;
               } 
               
      

        return  $JSON;

        }
  
//$this->close();
}
////////////////////////////////////////////////////////////////////////////////////////
/**
* UPDATE STATEMEN
*/
public function update($table,$columns,$clause){


    $whereSQL = '';
    if(!empty($clause))
    {
       
        if(substr(strtoupper(trim($clause)), 0, 5) != 'WHERE')
        {
           
            $whereSQL = " WHERE ".$clause;
        } else
        {
            $whereSQL = " ".trim($clause);
        }
    }
    
  $query = "UPDATE ".$table." SET ";

   
    $sets = array();
    foreach($columns as $column => $value)
    {
        if($value <> 'NULL'){
            $sets[] = "`".$column."` = '".$value."'";
        }else{
            $sets[] = "`".$column."` = ".$value;
        }
        
    }
    $query .= implode(', ', $sets);
    
    $query .= $whereSQL;


    $res = $this->Query($query);
}
////////////////////////////////////////////////////////////////////////////////////////
    /**
     * QUERY QUE DEVUELVE UN SOLO VALOR CONSULTADO
     */

function Query_value($table,$columns,$clause){

 $query = 'SELECT '.$columns.' FROM '.$table.' '.$clause.';';



 $res= $this->connect($query);
 $columns= mysqli_fetch_fields($res);



     while ($datos=mysqli_fetch_assoc($res)) {
         
          foreach ($columns as $value) {
           
            $currentField=$value->name;

            $column_value=$datos[$currentField];

 
         }

       } 

 //echo $column_value;
 return  $column_value;
}
////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////
/**
 * INSERT
 */

public function insert($table,$values){


    $fields = array_keys($values);

    $query= "INSERT INTO ".$table." (`".implode('`,`', $fields)."`) VALUES ('".implode("','", $values)."');";

    $insert = $this->Query($query);



}



////////////////////////////////////////////////////////////////////////////////////////
/**
 * query per columns
 */

public function queryColumns($table,$columns,$clause){
    

   $query = "SELECT  ".implode(',', $columns)." FROM ".$table." ".$clause." ;";

    return $this->Query($query);
        
}

////////////////////////////////////////////////////////////////////////////////////////
public function read_db_error(){

    $R_ERRORS = '';

    $string = file_get_contents("LOG_ERROR/TEMP_LOG.json");
    $json_a = json_decode($string);   
    
    $R_ERRORS = $json_a->{'ERROR'}; 

    file_put_contents("LOG_ERROR/TEMP_LOG.json",''); //LIMPIO EL ARCHIVO

    $R_ERRORS = str_replace(',', '  ', $R_ERRORS);

    if($R_ERRORS!=''){

        $ARRAY['E'] =  $R_ERRORS;
        $R_ERRORS = json_encode($ARRAY);

    }else{

        $R_ERRORS = '';
    }


   // echo $R_ERRORS ;
    return $R_ERRORS ;

}


/**
* delete
*/
public function delete($table,$clause){


$query= "DELETE FROM ".$table.' '.$clause.';';

$res = $this->Query($query);


}

////////////////////////////////////////////////////////////////////////////////////////
    /**
     * CIERRA LA CONEXION DE BD
     */
    public function close(){

    return mysqli_close($this->db);

    }
////////////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////////////
//METODOS PARA GESTION DE LOGIN
////////////////////////////////////////////////////////////////////////////////////////
public function login_in($user,$pass,$temp_url='',$company='0'){



$res = $this->Query("SELECT * FROM SAX_USER WHERE email='".$user."' AND pass='".$pass."' AND onoff='1';");

foreach ($res as $value) {

    $value = json_decode($value);

    $email= $value->{'email'};
    $id= $value->{'id'};
    $name= $value->{'name'};
    $lastname= $value->{'lastname'};
    $role=$value->{'role'};
    $pass=$value->{'pass'};
    $rol_compras=$value->{'role_purc'};
    $rol_campo  =$value->{'role_fiel'};
    $can_close  =$value->{'closeSO'};
    
}


if($email==''){

 echo "<script> alert('Usuario o Password no son correctos.');</script>";
 

}else{


$columns= array('last_login' => $timestamp = date('Y-m-d G:i:s'));

$this->update('SAX_USER',$columns,'id='.$id);

session_start();


$_SESSION['ID_USER'] = $id;
$_SESSION['NAME'] = $name;
$_SESSION['LASTNAME'] = $lastname;
$_SESSION['EMAIL'] = $email;
$_SESSION['ROLE'] = $role;
$_SESSION['PASS'] = $pass;
//$_SESSION['ALMACEN'] = $almacen;
$_SESSION['ROLE1'] = $rol_compras;
$_SESSION['ROLE2'] = $rol_campo;
$_SESSION['CANCLOSE'] = $can_close;
$_SESSION['COMPANY'] = $company;


if($temp_url!=''){

  $url = str_replace('@',  '/', $temp_url);

  echo '<script>self.location="'.URL.'index.php?url='.$url.'";</script>';

}else{

                $useragent=$_SERVER['HTTP_USER_AGENT'];
                if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|SM-T210R|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){


                    echo '<script>self.location="'.URL.'index.php?url=home/index";</script>';


                }else{

                            $res= $this->Get_company_Info();

                            foreach ($res as $Comp_Info) {

                                $Comp_Info = json_decode($Comp_Info);
                                $Sage_Conn = $Comp_Info->{'Sage_Conn'};
                                
                            }    
                            
                                if ($Sage_Conn == 0) {

                                    $conn = $this->sage_connected ;

                           
                                        if($conn==0){

                                            echo '<script>
                                                console.log("url'.$url.'");
                                                alert("Advertencia: El sistema se encuentra desconectado de SageConnect, Por favor verificar");
                                                self.location="'.URL.'index.php?url=home/index";
                                                </script>';

                                        }else{
                                       
                                            echo '<script>console.log('.$conn.'); self.location="'.URL.'index.php?url=home/index";</script>';
                                     
                                        }

                                }else{

                                    echo '<script>console.log('.$conn.'); self.location="'.URL.'index.php?url=home/index";</script>';

                                }
                }
    } 

}

}


public function verify_session(){

        $conexion = $this->TestConexion();

        list($error,$msg) = explode(':', $conexion);

        //echo $conexion.' '.$error;

        $msg = str_replace('/', '-', $msg);

        if($error=='Error'){
          

          $res = '1';

            echo '<script>self.location ="index.php?url=db_config/index/'.$msg.'";</script>';



        }else{

           session_start();
         // session_destroy();


            if(!$_SESSION){

                $useragent=$_SERVER['HTTP_USER_AGENT'];
                if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|SM-T210R|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od|ad)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){


                    $res = '1';


                }else{

                    // echo "<script>alert('Usuario no auntenticado');</script>";
              
                    $res = '1';
                    echo '<script>self.location ="index.php?url=login/index";</script>';

                    }

            }else{
       
            $res = '0';

            $this->set_login_parameters();
           }

        }

       
     return $res;
    }

private function set_login_parameters(){

        $this->active_user_id = $_SESSION['ID_USER'];
        $this->active_user_name = $_SESSION['NAME'];
        $this->active_user_lastname = $_SESSION['LASTNAME'];
        $this->active_user_email = $_SESSION['EMAIL'];
        $this->active_user_role = $_SESSION['ROLE'] ;
        $this->active_user_almacen = $_SESSION['ALMACEN'];
        $this->id_compania = $_SESSION['COMPANY'];
        $this->lang        = $this->Query_value('company_info','lang','');
        $this->rol_compras = $_SESSION['ROLE1'];
        $this->rol_campo   = $_SESSION['ROLE2'];
        $this->layout_lines = $this->Query_value('FAC_DET_CONF','NO_LINES','where ID_compania="'.$this->id_compania.'"');
        $this->can_close = $_SESSION['CANCLOSE'];
        //$active_user_pass = $_SESSION['PASS'] ;

        
    }


////////////////////////////////////////////////////////////////////////////////////////

public function GetLocalTime($dateIn){


$date  = strtotime($dateIn.' '.UTC);
$dateOut = date("Y-m-d H:i:s",  $date);

return $dateOut;
}


public function CheckStandalone(){


    $Sage_Conn = $this->Query_value('company_info','Sage_Conn',' limit 1');


    if ($Sage_Conn == 9) {

      return true;

    }else{


        return false;
    }


}

public function CompanyConnected(){
    
$this->verify_session();


$Sage_Conn = $this->Query_value('company_info','Sage_Conn',' limit 1');


if ($Sage_Conn == 0) {

    $conn = $this->sage_connected;

    if($conn==1){
        $status = $this->Query_value('CompanySession','CompanyNameSage50','where ID_compania="'.$this->id_compania.'"');
    }else{
        $status = $this->Query_value('CompanySession','CompanyNameSage50','where ID_compania="'.$this->id_compania.'"');
    }

}else{
    
    $status = $this->Query_value('CompanyLogSync','CompanyNameSage50','where ID_compania="'.$this->id_compania.'"');	
}

return $status;
}

public function get_CompanyList(){

$list='';

$res= $this->Get_company_Info();
    
    foreach ($res as $Comp_Info) {

        $Comp_Info = json_decode($Comp_Info);
        $Sage_Conn = $Comp_Info->{'Sage_Conn'};
    }	 
        
    if ($Sage_Conn == 0) {

       $compName = $this->Query('SELECT ID_compania, CompanyNameSage50 from CompanySession');

       foreach ($compName as $datos) {
        
        $Comp = json_decode($datos);

         $list.= '<option value="'.$Comp->{'ID_compania'}.'" >'.$Comp->{'ID_compania'}.'-'.$Comp->{'CompanyNameSage50'}."</option>";

        }
    
    }else{

        $compName = $this->Query('SELECT ID_compania, CompanyNameSage50 from CompanyLogSync');
    
            foreach ($compName as $datos) {
            
            $Comp = json_decode($datos);
    
                $list.= '<option value="'.$Comp->{'ID_compania'}.'" >'.$Comp->{'ID_compania'}.'-'.$Comp->{'CompanyNameSage50'}."</option>";
    
            }

    }

    return $list;
}


////////////////////////////////////////////////////////////////////////////////////////
//METODOS PARA GESTION DE OPERACIONES
////////////////////////////////////////////////////////////////////////////////////////
public function Get_lote_list($itemid){
$this->verify_session();
    
$query='SELECT
ITEMS_NO_LOTES.no_lote, 
ITEMS_NO_LOTES.fecha_ven, 
(select sum(qty) from STOCK_ITEMS_LOCATION 
where STOCK_ITEMS_LOCATION.lote = ITEMS_NO_LOTES.no_lote 
and ITEMS_NO_LOTES.ID_compania ="'.$this->id_compania.'" 
and STOCK_ITEMS_LOCATION.ID_compania ="'.$this->id_compania.'") as lote_qty
from ITEMS_NO_LOTES
where ITEMS_NO_LOTES.ProductID ="'.$itemid.'" ;';

$list = $this->Query($query);

return $list;


}


public function fact_compras_list(){

$query='SELECT
Purchase_Header_Exp.PurchaseID, 
Purchase_Header_Exp.PurchaseNumber, 
Purchase_Header_Exp.VendorName, 
Purchase_Header_Exp.Date as fecha
from Purchase_Header_Exp
INNER join  Purchase_Detail_Exp on Purchase_Detail_Exp.PurchaseID = Purchase_Header_Exp.PurchaseID
WHERE Purchase_Detail_Exp.Item_id <> " " GROUP BY Purchase_Header_Exp.PurchaseID ';

$list = $this->Query($query);

return $list;
}

public function Get_fact_header($sort,$limit,$clause){

$query='SELECT *
from Purchase_Header_Imp
'.$clause.' Order by Purchase_Header_Imp.TransactionID '.$sort.' limit '.$limit.';';;


$list = $this->Query($query);

return $list;
}


public function lote_loc_by_itemID($itemid){

$query ='SELECT * 
FROM STOCK_ITEMS_LOCATION
INNER JOIN ITEMS_NO_LOTES ON ITEMS_NO_LOTES.no_lote = STOCK_ITEMS_LOCATION.lote
WHERE ITEMS_NO_LOTES.ProductID="'.$itemid.'"  GROUP BY STOCK_ITEMS_LOCATION.ID';

$res = $this->Query($query);

return $res;
}

public function get_Purchaseitem($itemid){

$query ='SELECT * from Products_Exp
inner join ITEMS_NO_LOTES on ITEMS_NO_LOTES.ProductID=Products_Exp.ProductID
where  Products_Exp.ProductID="'.$itemid.'" ;';



$res = $this->Query($query);

return $res;
}

public function get_ProductsList(){

$query='SELECT 
Products_Exp.ProductID,
Products_Exp.Description,
Products_Exp.UnitMeasure,
SUM(STOCK_ITEMS_LOCATION.qty) AS QtyOnHand,
Products_Exp.Price1,
Products_Exp.Price2,
Products_Exp.Price3,
Products_Exp.Price4,
Products_Exp.Price5,
Products_Exp.Price6,
Products_Exp.Price7,
Products_Exp.Price8,
Products_Exp.Price9,
Products_Exp.Price10,
Products_Exp.LastUnitCost,
Products_Exp.IsActive
FROM Products_Exp 
inner join STOCK_ITEMS_LOCATION on STOCK_ITEMS_LOCATION.ItemID = Products_Exp.ProductID and STOCK_ITEMS_LOCATION.id_compania="'.$this->id_compania.'" 
WHERE Products_Exp.id_compania="'.$this->id_compania.'" 
group by Products_Exp.ProductID';

$res = $this->Query($query);

return $res;
}

public function get_ClientList(){

$query='SELECT * FROM Customers_Exp where  id_compania="'.$this->id_compania.'" and isActive="1" order by CustomerID ASC';

$res = $this->Query($query);

return $res;

}

public function get_SalesRepre(){

$query='SELECT * FROM Sales_Representative_Exp where  ID_compania="'.$this->id_compania.'" order by SalesRepID ASC';

$res = $this->Query($query);

return $res;

}

public function get_VendorList(){

$query='SELECT * FROM Vendors_Exp where  ID_compania="'.$this->id_compania.'"';

$res = $this->Query($query);

return $res;

}


public function get_PurOrdList(){

$query='SELECT * FROM PurOrdr_Header_Exp where  ID_compania="'.$this->id_compania.'" and PurchaseOrderNumber <> ""';

$res = $this->Query($query);

return $res;

}

public function GET_MAX_QTY($invoice){  


$clause ='INNER JOIN PurOrdr_Detail_Exp ON PurOrdr_Header_Exp.TransactionID = PurOrdr_Detail_Exp.TransactionID
WHERE PurOrdr_Header_Exp.ID_compania="'.$this->id_compania.'"
AND PurOrdr_Header_Exp.PurchaseOrderNumber ="'.$invoice.'"';
$QTY_IN_PO = $this->Query_value('PurOrdr_Header_Exp','SUM( Quantity )',$clause );


$clause ='WHERE ID_compania="'.$this->id_compania.'"
AND NO_PO ="'.$invoice.'"';
$QTY_INVOICED = $this->Query_value('PO_FACT_LOG','SUM( ITEM_QTY )',$clause );

$res =  $QTY_IN_PO - $QTY_INVOICED;

return $res;
}


public function GET_MAX_QTY_BY_ITEM($invoice,$ITEM){  


$clause ='INNER JOIN PurOrdr_Detail_Exp ON PurOrdr_Header_Exp.TransactionID = PurOrdr_Detail_Exp.TransactionID
WHERE PurOrdr_Header_Exp.ID_compania="'.$this->id_compania.'"
AND PurOrdr_Header_Exp.PurchaseOrderNumber ="'.$invoice.'" 
AND PurOrdr_Detail_Exp.Item_id="'.$ITEM.'"';

$QTY_IN_PO = $this->Query_value('PurOrdr_Header_Exp','SUM( Quantity )',$clause );


$clause ='WHERE ID_compania="'.$this->id_compania.'"
                AND NO_PO ="'.$invoice.'"
                AND ITEM_ID="'.$ITEM.'"';
$QTY_INVOICED = $this->Query_value('PO_FACT_LOG','SUM( ITEM_QTY )',$clause );

$res =  $QTY_IN_PO - $QTY_INVOICED;

return $res;
}

public function Get_CO_No(){

$order = $this->Query_value('Purchase_Header_Imp','TransactionID','where ID_compania="'.$this->id_compania.'" ORDER BY TransactionID DESC LIMIT 1');


//$NO_ORDER = str_pad($NO_ORDER, 7 ,"0",STR_PAD_LEFT);

$NO_ORDER = number_format($order, 0 , '', '');
$NO_ORDER = str_pad($NO_ORDER, 9 ,"0",STR_PAD_LEFT);


if($NO_ORDER< '1'){

    $NO_ORDER=0;
    $NO_ORDER = str_pad($NO_ORDER, 9 ,"0",STR_PAD_LEFT);

}

return $NO_ORDER; 
}

public function Get_SO_NoDes(){
    
    $order = $this->Query_value('SalesOrder_Header_Imp','SalesOrderNumber','where ID_compania="'.$this->id_compania.'" ORDER BY ID DESC LIMIT 1');
    

    $count = substr_count($order, '-');

    if($count == 2){
        list($ACI , $lugDespID ,$NO_ORDER) = explode('-', $order);
    }else{
        list($ACI , $NO_ORDER) = explode('-', $order);
    }
  

    $NO_ORDER = number_format($NO_ORDER , 0 , '', '')+1;

    
    $NO_ORDER = 'ACI-'.$NO_ORDER;
    
    if($NO_ORDER < '1'){
    
        $NO_ORDER=0;
        $NO_ORDER = 'ACI-'.$NO_ORDER;
      
    }

}



public function Get_SO_No(){

    $order = $this->Query_value('SalesOrder_Header_Imp','SalesOrderNumber','where ID_compania="'.$this->id_compania.'" ORDER BY ID DESC LIMIT 1');

    list($ACI , $NO_ORDER) = explode('-', $order);

    $NO_ORDER = number_format($NO_ORDER , 0 , '', '')+1;


    $NO_ORDER = 'ACI-'.$NO_ORDER;

    if($NO_ORDER < '1'){

        $NO_ORDER=0;
        $NO_ORDER = 'ACI-'.$NO_ORDER;

    }

return $NO_ORDER; 
}

public function Get_NC_No(){

$order = $this->Query_value('CREDITNOTE_HEADER','CreditNoteNumber','where ID_compania="'.$this->id_compania.'" ORDER BY ID DESC LIMIT 1');

list($ACI , $NO_ORDER) = explode('-', $order);


$NO_ORDER = number_format($NO_ORDER, 0 , '', '')+1;
//$NO_ORDER = str_pad($NO_ORDER, 7 ,"0",STR_PAD_LEFT);

$NO_ORDER = 'ACI-'.$NO_ORDER;

if($NO_ORDER< '1'){

    $NO_ORDER=0;
    $NO_ORDER = 'ACI-'.$NO_ORDER;
   // $NO_ORDER = str_pad($NO_ORDER, 7 ,"0",STR_PAD_LEFT);

}

return $NO_ORDER; 
}


public function Get_Order_No(){

$order = $this->Query_value('Sales_Header_Imp','InvoiceNumber','where ID_compania="'.$this->id_compania.'" order by InvoiceNumber DESC LIMIT 1');

$NO_ORDER = number_format((int)$order+1);
$NO_ORDER = str_pad($NO_ORDER, 9 ,"0",STR_PAD_LEFT);


if($NO_ORDER< '1'){

    $NO_ORDER=0;
    $NO_ORDER = str_pad($NO_ORDER, 9 ,"0",STR_PAD_LEFT);

}


return $NO_ORDER; 
}



public function Get_Ref_No(){


$order = $this->Query_value('InventoryAdjust_Imp','Reference','where ID_compania="'.$this->id_compania.'" order by Reference DESC LIMIT 1');

$NO_ORDER = number_format((int)$order+1);
$NO_REF = str_pad($NO_ORDER, 9 ,"0",STR_PAD_LEFT);


if($NO_REF < '1'){

    $NO_REF=0;
    $NO_REF = str_pad($NO_REF, 9 ,"0",STR_PAD_LEFT);

}


return $NO_REF; 
}


public function Get_con_No(){


$order = $this->Query_value('CON_HEADER','refAci','where ID_compania="'.$this->id_compania.'" order by lastChange DESC LIMIT 1');

if(strpos($order,'-')){

    list($ACI , $NO_ORDER) = explode('-', $order);
}else{

    $NO_ORDER = $order;
}


$NO_ORDER = number_format((int)$NO_ORDER+1);
//$NO_ORDER = str_pad($NO_ORDER, 7 ,"0",STR_PAD_LEFT);

$NO_ORDER = 'CON-'.$NO_ORDER;

if($NO_ORDER< '1'){

    $NO_ORDER=0;
    $NO_ORDER = 'CON-'.$NO_ORDER;
   

}



return $NO_ORDER; 
}

public function Get_Req_No(){

$order = $this->Query_value('REQ_HEADER','NO_REQ','where ID_compania="'.$this->id_compania.'" ORDER BY ID DESC LIMIT 1');

list($ACI , $NO_ORDER) = explode('-', $order);


$NO_ORDER = number_format((int)$NO_ORDER+1);
//$NO_ORDER = str_pad($NO_ORDER, 7 ,"0",STR_PAD_LEFT);

$NO_ORDER = 'REQ-'.$NO_ORDER;

if($NO_ORDER< '1'){

    $NO_ORDER=0;
    $NO_ORDER = 'REQ-'.$NO_ORDER;
   

}


return $NO_ORDER; 
}



public function get_JobList(){

$jobs = $this->Query('Select * from Jobs_Exp where ID_compania="'.$this->id_compania.'" and IsActive="1"'); 

if(!$jobs){
 return '0';

}else{
  return $jobs;  
}

}


public function getJobDesc($id){

  $clause = 'where JobID="'.$id.'" and  ID_compania="'.$this->id_compania.'" and IsActive="1"';
    
  return $this->Query_value('Jobs_Exp','Description',$clause);

  
}


public function get_phaseList(){

$jobs = $this->Query('Select * from Job_Phases_Exp where ID_compania="'.$this->id_compania.'" and IsActive="1"'); 

if(!$jobs){
 return '0';

}else{
  return $jobs;  
}

}

public function get_costList(){

$jobs = $this->Query('Select * from Job_Cost_Codes_Exp where ID_compania="'.$this->id_compania.'" and IsActive="1"'); 

if(!$jobs){
 return '0';

}else{
  return $jobs;  
}


}

public function Get_User_Info($id){

$user = $this->Query('Select * from SAX_USER where id="'.$id.'"'); 


return $user;

}

public function Get_company_Info(){

$Company= $this->Query('Select * from company_info where id="1";'); 

return $Company;

}

public function Get_order_to_invoice($id){

$id_compania = $this->id_compania;

$ORDER= $this->Query('SELECT * FROM `SalesOrder_Header_Imp`
inner JOIN `SalesOrder_Detail_Imp` ON SalesOrder_Header_Imp.SalesOrderNumber = SalesOrder_Detail_Imp.SalesOrderNumber
inner JOIN `Customers_Exp` ON SalesOrder_Header_Imp.CustomerID = Customers_Exp.CustomerID
inner JOIN `SAX_USER` ON `SAX_USER`.`id` = SalesOrder_Header_Imp.user where SalesOrder_Header_Imp.SalesOrderNumber="'.$id.'" and 
SalesOrder_Detail_Imp.ID_compania="'.$id_compania.'" and SalesOrder_Header_Imp.ID_compania="'.$id_compania.'"
group by SalesOrder_Detail_Imp.ID order by SalesOrder_Detail_Imp.ID;'); 

return $ORDER;

}

public function Get_sales_to_invoice($id){

$ORDER= $this->Query('SELECT * FROM `Sales_Header_Imp`
inner JOIN `Sales_Detail_Imp` ON Sales_Header_Imp.InvoiceNumber = Sales_Detail_Imp.InvoiceNumber
inner JOIN `Customers_Exp` ON Sales_Header_Imp.CustomerID = Customers_Exp.CustomerID
inner JOIN `SAX_USER` ON `SAX_USER`.`id` = Sales_Header_Imp.user where Sales_Header_Imp.InvoiceNumber="'.$id.'" 
and  SalesOrder_Detail_Imp.ID_compania="'.$id_compania.'" and SalesOrder_Header_Imp.ID_compania="'.$id_compania.'"
group by Sales_Detail_Imp.ID order by Sales_Detail_Imp.ID;'); 

return $ORDER;

}

public function Get_sal_merc_to_invoice($id){

$ORDER= $this->Query("SELECT * FROM InventoryAdjust_Imp where Reference='".$id."' and ID_compania='".$this->id_compania."';"); 

return $ORDER;

}

public function Get_sales_conf_Info(){

$saleinfo = $this->Query('SELECT * FROM sale_tax;');

return $saleinfo;

}

//ModifGPH
////////////////////////////////////////////////////
//QUERYS PARA REPORTES

public function get_InvXven($sort,$limit,$clause){

     $order = $this->Query('

         SELECT 
         a.name Almacen, 
         u.etiqueta Ubicacion, 
         l.no_lote Lote, 
         p.ProductID Producto, 
         p.Description Descripcion, 
         l.fecha_ven Vencimiento, 
         s.qty Cantidad
        from Products_Exp p
         inner join ITEMS_NO_LOTES l  on p.ProductID = l.ProductID 
         inner join STOCK_ITEMS_LOCATION s on p.ProductID = s.id_product and s.lote = l.no_lote
         inner join ubicaciones u  on s.route = u.id
         inner join almacenes a on u.id_almacen = a.id 

        '.$clause.' order by l.fecha_ven '.$sort.' limit '.$limit.';');



    return $order;

}


public function get_InvXStk($sort,$limit,$clause){

   $sql = 'SELECT 
         a.name Almacen, 
         u.etiqueta Ubicacion, 
         s.lote Lote, 
         p.ProductID Producto, 
         p.LastUnitCost,
         p.Description Descripcion, 
         s.qty Cantidad
        from Products_Exp p
         inner join STOCK_ITEMS_LOCATION s on p.ProductID = s.id_product 
         inner join ubicaciones u  on s.route = u.id
         inner join almacenes a on u.id_almacen = a.id '.$clause.' order by a.name '.$sort.' limit '.$limit.';';

     $order = $this->Query($sql);


    return $order;

}


public function get_req_to_report($sort,$limit,$clause){

$sql='SELECT * FROM `REQ_HEADER` 
inner join REQ_DETAIL ON REQ_HEADER.NO_REQ = REQ_DETAIL.NO_REQ
'.$clause.' group by REQ_HEADER.NO_REQ order by ID '.$sort.' limit '.$limit.';';

$get_req = $this->Query($sql);


return $get_req;
}



public function get_inv_qty_disp($sort,$limit,$clause){

$sql=' SELECT 
p.ProductID, 
p.Description, 
p.QtyOnHand, 
SUM( s.qty )  as LoteQty
FROM Products_Exp p
INNER JOIN STOCK_ITEMS_LOCATION s ON s.id_product = p.ProductID AND s.ID_compania = p.id_compania
'.$clause.' GROUP BY p.ProductID order by p.ProductID '.$sort.' limit '.$limit.';';

$get_inv_qty = $this->Query($sql);


return $get_inv_qty;

}

////////////////////////////////////////////////////



////////////////////////////////////////////////////
//Req to print
public function get_req_to_print($id,$comp){

$sql='SELECT * FROM `REQ_HEADER` 
inner join REQ_DETAIL ON REQ_HEADER.NO_REQ = REQ_DETAIL.NO_REQ
WHERE 
REQ_HEADER.ID_compania="'.$comp.'" AND  
REQ_DETAIL.ID_compania="'.$comp.'" and 
REQ_HEADER.NO_REQ="'.$id.'" and 
REQ_DETAIL.NO_REQ="'.$id.'"';

$req_info = $this->Query($sql);

return $req_info ;
}


////////////////////////////////////////////////////
//Orden de compras por id
public function get_items_by_OC($invoice){

$query ='SELECT * 
FROM PurOrdr_Header_Exp
INNER JOIN PurOrdr_Detail_Exp ON PurOrdr_Header_Exp.TransactionID = PurOrdr_Detail_Exp.TransactionID
WHERE PurOrdr_Header_Exp.ID_compania="'.$this->id_compania.'" 
AND PurOrdr_Detail_Exp.ID_compania="'.$this->id_compania.'"
AND PurOrdr_Header_Exp.PurchaseOrderNumber ="'.$invoice.'"';

$res = $this->Query($query);


return $res;
}


//Orden de compras por id
public function get_items_lines_OC($invoice){


$clause = 'INNER JOIN PurOrdr_Detail_Exp ON PurOrdr_Header_Exp.TransactionID = PurOrdr_Detail_Exp.TransactionID
                                                            WHERE PurOrdr_Header_Exp.ID_compania="'.$this->id_compania.'"
                                                            AND PurOrdr_Header_Exp.PurchaseOrderNumber ="'.$invoice.'"';

$res = $this->Query_value('PurOrdr_Header_Exp','count(*)', $clause);


return $res;
}

//Orden de compras total
public function get_OC($sort,$limit,$clause){

$query ='SELECT * 
        FROM PurOrdr_Header_Exp
        INNER JOIN PurOrdr_Detail_Exp ON PurOrdr_Header_Exp.TransactionID = PurOrdr_Detail_Exp.TransactionID
             '.$clause.' group by PurOrdr_Header_Exp.TransactionID 
             Order by PurOrdr_Header_Exp.Date '.$sort.' limit '.$limit.';';


$res = $this->Query($query);


return $res;
}


public function get_OC_ID($sort,$limit,$clause){
    
    $query ='SELECT * 
            FROM PurOrdr_Header_Exp  '.$clause.' 
                 Order by PurOrdr_Header_Exp.Date '.$sort.' limit '.$limit.';';
    
    
    $res = $this->Query($query);

return $res;
}

//Orden de compras asociadas a red
public function get_OC_req_asc($sort,$limit,$clause){
    
    $query ='SELECT * 
    FROM PurOrdr_Header_Exp
    INNER JOIN PurOrdr_Detail_Exp ON PurOrdr_Header_Exp.TransactionID = PurOrdr_Detail_Exp.TransactionID
    INNER JOIN REQ_HEADER ON PurOrdr_Header_Exp.CustomerSO = REQ_HEADER.NO_REQ
    '.$clause.' group by PurOrdr_Header_Exp.TransactionID Order by PurOrdr_Header_Exp.Date '.$sort.' limit '.$limit.';';
    
    
    $res = $this->Query($query);
    
    
    return $res;
    }
////////////////////////////////////////////////////



////////////////////////////////////////////////////
//Consignacion

public function con_reg($refReg,$cont,$ID_compania){

    $idReg = $this->Query_value('CON_HEADER','idReg','WHERE refReg = "'.$refReg.'" and ID_compania="'.$ID_compania.'";');

    $regTra = $this->Query('SELECT id from reg_traslado where ID_compania="'.$ID_compania.'" ORDER BY LAST_CHANGE desc limit '.$cont.';');

    foreach ($regTra as $value) {
    
    $value = json_decode($value);

    $ID_REG_TRAS = $value->{'id'};

        $this->Query('INSERT INTO CON_REG_TRAS (idReg,idRegTras,ID_compania) values ("'.$idReg.'","'.$ID_REG_TRAS.'","'.$ID_compania.'");');

    }

}



public function get_con_to_report($sort,$limit,$clause){

    $sql='SELECT  A.date,
                  A.refReg as REF,
                  A.nota as NOTA,
                  D.stock as id_almacen_ini,
                  D.location as route_ini,
                  E.stock as id_almacen_des,
                  E.location as route_des,
                  B.User,
                  E.lote,
                  B.ProductID ,
                  B.Qty as CANT
                  FROM CON_HEADER A
                    INNER JOIN INV_EVENT_LOG B ON B.aci_ref =  A.refReg
                    LEFT JOIN (SELECT id, stock , location   FROM STOCK_ITEMS_LOCATION  )   D  ON D.id = B.stockOrigID
                    LEFT JOIN (SELECT id, stock , location, lote   FROM STOCK_ITEMS_LOCATION  )   E  ON D.id = B.stockDestID
                  '.$clause.' order by A.idReg '.$sort.' limit '.$limit.';';

$get_con = $this->Query($sql);


return $get_con;
}
////////////////////////////////////////////////////   

//Metodo para traer la lista de precios

public function get_PriceList(){

echo $query='SELECT * FROM PRI_LIST_ID where  ID_compania="'.$this->id_compania.'"';

$res = $this->Query($query);

return $res;

}


//Metodo para traer lista de precios para reporte

public function get_Price_list($sort,$limit,$clause){

$query ='SELECT * FROM PRI_LIST_ID '.$clause.' order by PRI_LIST_ID.IDPRICE '.$sort.' limit '.$limit.';';


$res = $this->Query($query);


return $res;
}


////////////////////////////////////////////////////
//Trae Detalle de lista de precios

public function get_items_by_PL($PL_id){

$query ='SELECT * 
FROM PRI_LIST_ITEM
WHERE PRI_LIST_ITEM.IDPRICE ="'.$PL_id.'" AND ID_compania="'.$this->id_compania.'"';


$res = $this->Query($query);


return $res;
}


////////////////////////////////////////////////////
//Trae Detalle de clientes
public function get_Cust_info_int($custid){

$this->verify_session();    
$id_compania = $this->id_compania;

$query = 'SELECT * FROM Customers_Exp WHERE ID="'.$custid.'" AND id_compania="'.$id_compania.'" ;';

$res = $this->Query($query);

return $res[0];

}

public function Get_User_Name($id){

$USER = $this->Get_User_Info($id);
         
         foreach ($USER as $user ){

            $user = json_decode($user);

            $USERNAME = $user->{'name'}.' '.$user->{'lastname'};

         }

return $USERNAME;


}



////////////////////////////////////////////////////
//encriptadores de cadenas 

public static function urlsafeB64Encode($input)
{
  return str_replace('=', '', strtr(base64_encode($input), '+/', '-_'));   
}

public static function urlsafeB64Decode($input)
{
  return str_replace('=', '', strtr(base64_decode($input), '+/', '-_'));   
}


public function encriptar($cadena){

    $key='d@oute1';  // Una clave de codificacion, debe usarse la misma para encriptar y desencriptar
    $encrypted = static::urlsafeB64Encode($cadena.'|'.$key);
    return $encrypted; //Devuelve el string encriptado
}


public function desencriptar($cadena){
    
     $key='d@oute1';  // Una clave de codificacion, debe usarse la misma para encriptar y desencriptar
     
     $decrypted = static::urlsafeB64Decode($cadena);
     list($decrypted,$key) = explode('|',$decrypted );
     return $decrypted;  //Devuelve el string desencriptado
}


public function getGLReten(){
    
    $this->verify_session();


    $res = $this->Query_value( 'CTA_GL_CONF',
                            'GL_RETEN',
                            'WHERE  ID_compania="'.$this->id_compania.'" ');
        
    return $res;
}


////////////////////////////////////////////////////
//envia correo, metodo general
public function send_mail($address,$subject,$title,$body){
    
    $message_to_send ='<html>
                        <head>
                        <meta charset="UTF-8">
                        <title>'.$title.'</title>
                        </head>
                        <body>'.$body.'</body>
                        </html>';
    
    
    require 'PHP_mailer/PHPMailerAutoload.php';
          
        $mail = new PHPMailer;
    
        $mail->isSMTP(); // enable SMTP
        $mail->IsHTML(true);
        
    
    
    $sql = "SELECT * FROM CONF_SMTP WHERE ID='1'";
    
    $smtp= $this->Query($sql);
    
        foreach ($smtp as $smtp_val) {
            $smtp_val= json_decode($smtp_val);
    
            $mail->Host =     $smtp_val->{'HOSTNAME'};
            $mail->Port =     $smtp_val->{'PORT'};
            $mail->Username = $smtp_val->{'USERNAME'};
            $mail->Password = $smtp_val->{'PASSWORD'};
            $mail->SMTPAuth = $smtp_val->{'Auth'};
            $mail->SMTPSecure=$smtp_val->{'SMTPSecure'};
            $mail->SMTPDebug= $smtp_val->{'SMTPSDebug'};
    
            $mail->SetFrom($smtp_val->{'USERNAME'},$smtp_val->{'NAME'} );
            $mail->SingleTo = true;
    
        }

        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
          );
    
        $mail->Body = $message_to_send;
        $mail->Subject = utf8_decode($subject);
        //$mail->AddAddress($email,$name.' '.$lastname);
    
        foreach ($address as $value) {
    
    
            list($email,$name,$lastname) = explode(';', $value);
    
            $mail->AddAddress($email, $name.' '.$lastname);
    
        }
    
    
    if(!$mail->send()) {
     
    
       $alert .= 'Message could not be sent.';
       $alert .= 'Mailer Error: ' . $mail->ErrorInfo;
       
       return $alert;
    
    } else {
    
      return 1;

    }
    
}


//Estimar Costos de un proyecto, metodo general
public function getJob_avalaible_amnt($JobID,$PhaseID=0,$CCOID=0){


  $this->verify_session();

   $clause = 'WHERE  ID_compania="'.$this->id_compania.'" AND JobID="'.$JobID.'"  ';

    if ($PhaseID) {

      $clause .= 'AND PhaseID="'.$PhaseID.'" ';

        if ($CCOID) {

        $clause .= 'AND CostCodeID="'.$CCOID.'" ';
        
        }

    }

    $Budget = $this->Query_value('Job_Estimates_Exp','SUM(Expenses)',$clause);

    $clause2 = 'WHERE  ID_compania="'.$this->id_compania.'" AND JobID="'.$JobID.'"  ';
    
        if ($PhaseID) {
    
          $clause .= 'AND JobPhaseID="'.$PhaseID.'" ';
    
            if ($CCOID) {
    
            $clause .= 'AND JobCostCodeID="'.$CCOID.'" ';
            
            }
    
        }

    $Expenses = $this->Query_value('INV_EVENT_LOG','SUM(Total)',$clause2);


    $Total_available = $Budget - $Expenses;

    return $Total_available;
    // number_format($Total_available,2,',','.');

}

}
?>
