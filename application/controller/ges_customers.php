<?php

class ges_customers extends Controller
{

//Declaracion de Variables Publicas

public $id_cus;
public $cus_name;

//******************************************************************************
//Gestion de niveles de Precios. Carga vista de gestion de precios.
public function PricesList(){


 $res = $this->model->verify_session();

        if($res=='0'){
            
          require  'Excel/reader.php';
          require  'Excel/simple_html_dom.php';

            // load views
            require APP . 'view/_templates/header.php';
            require APP . 'view/_templates/panel.php';
            require APP . 'view/modules/customers/PricesList.php';
            require APP . 'view/_templates/footer.php';


        }
          


	
}



//******************************************************************************
//Pagina que mostrara los precios de un cliente especifico y permitira modificar y anadirlos.


public function agregar_precios($id_customer,$customer_name){

$this->id_cus = $id_customer;
$this->cus_name = $customer_name;

 $res = $this->model->verify_session();

        if($res=='0'){
        

            // load views
            require APP . 'view/_templates/header.php';
            require APP . 'view/_templates/panel.php';
            require APP . 'view/operaciones/agregar_nivel_precio.php';
            require APP . 'view/_templates/footer.php';


        }
          


	
}

//******************************************************************************
//Pagina que mostrara los clientes, permitira crear uno especifico or por lista, asi como modificar, eliminar y activar/desactivar.


public function AddCustomer(){

 $res = $this->model->verify_session();

        if($res=='0'){
        

            // load views
            require APP . 'view/_templates/header.php';
            require APP . 'view/_templates/panel.php';
            require APP . 'view/modules/customers/AddCustomer.php';
            require APP . 'view/_templates/footer.php';


        }
          


  
}

public function del_PL_detail($id_PL){
  
  $this->model->verify_session();
  
  
  $clause = 'WHERE IDPRICE = "'.$id_PL.'" and ID_compania="'.$this->model->id_compania.'"';
  $table_PL_ITEM = 'PRI_LIST_ITEM';
  $table_PL_ID = 'PRI_LIST_ID';
  
  $this->model->delete($table_PL_ITEM,$clause);
  $this->model->delete($table_PL_ID,$clause);
  
  
  }


public function add_item(){
  
  $this->model->verify_session();
  
  list($priceId,$itemId,$descItem,$priceItem,$unitMes) = explode('@', $_REQUEST['Data']);
  
  $priceId = str_replace(' ', '_', $priceId);
  
  $Values = array( 
    'IDPRICE' => $priceId ,
    'IDITEM'  => $itemId ,
    'PRICE'=> $priceItem ,
    'DESCRIPTION'  => $descItem,
    'UNIT'=> $unitMes,
    'ID_compania' => $this->model->id_compania);
  
  $this->model->insert('PRI_LIST_ITEM',$Values);
  
  $this->CheckError();
  
  echo '1';
  
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

public function getCustomerList($sort,$limit,$clause){

    $query ='SELECT * FROM Customers_Exp '.$clause.' Order by CustomerID '.$sort.' limit '.$limit.';';


    $res = $this->model->Query($query);


    return $res;

}


public function mod_cus(){

$this->model->verify_session();


$data = json_decode($_REQUEST['Data']);

  list($none,$cus_ID,$cus_name,$cus_tlf,$cus_contact,$cus_country,$cus_state,$cus_city,$cus_zip,$cus_email,$cus_pl,$cus_balance,$cus_CL,$cus_acct,$cus_salesRep,$cus_BA,$cus_SA) = explode('@',$data[0]);


  $Values = array(
                      'Customer_Bill_Name'  => $cus_name,
                      'Phone_Number'=> $cus_tlf,
                      'Contact'  => $cus_country,
                      'Country'=> $cus_contact,
                      'State'=> $cus_state,
                      'City'=> $cus_city,
                      'Zip'=> $cus_zip,
                      'Email'=> $cus_email,
                      'PriceLevel'=> $cus_pl,
                      'Balance'=> $cus_balance,
                      'CreditLimit'=> $cus_CL,
                      'SalesRepID'=> $cus_acct,
                      'SalesRepName'=> $cus_salesRep,
                      'AddressLine1'=> $cus_BA,
                      'AddressLine2'=> $cus_SA);

  $clause = 'WHERE CustomerID ="'.$cus_ID.'" AND  ID_compania="'.$this->model->id_compania.'";';

  $update = $this->model->update('Customers_Exp',$Values,$clause);

  echo '1';
}


public function del_cus($cus_ID){

  $this->model->verify_session();

  echo $clause = ' WHERE CustomerID="'.$cus_ID.'" AND  ID_compania="'.$this->model->id_compania.'";';

  $this->model->delete('Customers_Exp',$clause);

  echo '1';

}

public function get_cus_detail($cus_ID){

  $this->model->verify_session();
  require_once APP.'view/modules/customers/lang/'.$this->model->lang.'_ref.php';


  $oc = $this->get_cus($cus_ID);

  $table.= '<button type="button" class="close" aria-label="Close" onclick="CLOSE_DIV('."'table_det'".');" >
            <span STYLE="color:red" aria-hidden="true">&times; </span>'.$DIV_close.'
            </button>

            <fieldset>
            
            <legend>'.$TableDetail_title.'</legend>



            <table   class="table table-striped table-bordered" cellspacing="0"  >
      <tbody>';
  
    $value = json_decode($oc[0]);

    if ($value->{'IsActive'} =1) {
      
      $style = 'style="background-color:#BCF5A9;"';//Verde

      if ($this->model->lang = 'es') {
        
        $status = 'Activo';

      }else{

        $status = 'Active';

      }
      

    }else{

      $style = 'style="background-color:#D8D8D8 ;"';//gris

        if ($this->model->lang = 'es') {
        
          $status = 'Inactivo';

        }else{

          $status = 'Inactive';

        }

        }


    $table.= " <tr><th style='text-align:left;' width='25%'>".$TableDet_th1."</th><td >".$value->{'CustomerID'}.'</td></tr>
               <tr><th style="text-align:left;" width="25%">'.$TableDet_th2.'</th><td >'.$value->{'Customer_Bill_Name'}.'</td></tr>
               <tr><th style="text-align:left;" width="25%">'.$TableDet_th3.'</th><td >'.$value->{'Phone_Number'}.'</td></tr>
               <tr><th style="text-align:left;" width="25%">'.$TableDet_th4.'</th><td >'.$value->{'Contact'}.'</td></tr>
               <tr><th style="text-align:left;" width="10%">'.$TableDet_th5.'</th> <td >'.$value->{'Country'}.'</td></tr>
               <tr><th style="text-align:left;" width="10%">'.$TableDet_th6.'</th> <td >'.$value->{'State'}.'</td></tr>
               <tr><th style="text-align:left;" width="30%">'.$TableDet_th7.'</th><td >'.$value->{'City'}.'</td></tr>
               <tr><th style="text-align:left;" width="25%">'.$TableDet_th8.'</th><td >'.$value->{'Zip'}.'</td></tr>
               <tr><th style="text-align:left;" width="25%">'.$TableDet_th9.'</th><td >'.$value->{'Email'}.'</td></tr>
               <tr><th style="text-align:left;" width="25%">'.$TableDet_th10.'</th><td >'.$value->{'PriceLevel'}.'</td></tr>
               <tr><th style="text-align:left;" width="25%">'.$TableDet_th11.'</th><td >'.$value->{'Balance'}.'</td></tr>
               <tr><th style="text-align:left;" width="10%">'.$TableDet_th12.'</th> <td >'.$value->{'CreditLimit'}.'</td></tr>
               <tr><th style="text-align:left;" width="10%">'.$TableDet_th13.'</th> <td >'.$value->{'SalesRepID'}.'</td></tr>
               <tr><th style="text-align:left;" width="30%">'.$TableDet_th14.'</th><td >'.$value->{'SalesRepName'}.'</td></tr>
               <tr><th style="text-align:left;" width="30%">'.$TableDet_th15.'</th><td >'.$value->{'AddressLine1'}.'</td></tr>
               <tr><th style="text-align:left;" width="30%">'.$TableDet_th16.'</th><td >'.$value->{'AddressLine2'}.'</td></tr>
               <tr><th '.$style.' width="30%">'.$TableDet_th17.'</th><td >'.$status.'</td></tr>';
  
    $table.= '</tbody></table></fieldset>';
    echo $table;
}

public function get_cus($cus_ID){

  $this->model->verify_session();

  $query ='SELECT * 
          FROM Customers_Exp
          WHERE ID="'.$cus_ID.'" AND  ID_compania="'.$this->model->id_compania.'"
          ORDER BY CustomerID DESC LIMIT 1;';

$res = $this->model->Query($query);

return $res;
}

//END
}

?>