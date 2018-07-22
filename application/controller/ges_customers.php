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

    $query ='SELECT * FROM Customers_Exp '.$clause.' '.$sort.' limit '.$limit.';';


    $res = $this->Query($query);


    return $res;

}


//END
}

?>