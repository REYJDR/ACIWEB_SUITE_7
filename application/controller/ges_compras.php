<?PHP

class ges_compras extends Controller
{


public function crear_fact(){


 $res = $this->model->verify_session();

        if($res=='0'){
        

            // load views
            require APP . 'view/_templates/header.php';
            require APP . 'view/_templates/panel.php';
            require APP . 'view/operaciones/ges_fact_compras.php';
            require APP . 'view/_templates/footer.php';


        }
          


    
}


public function fact_compras(){


 $res = $this->model->verify_session();

        if($res=='0'){
        

            // load views
            require APP . 'view/_templates/header.php';
            require APP . 'view/_templates/panel.php';
            require APP . 'view/operaciones/ges_compras.php';
            require APP . 'view/_templates/footer.php';


        }
          


	
}


public function orden_compras($id){


 $res = $this->model->verify_session();

        if($res=='0'){
        

$oc = $this->model->get_items_by_OC($id);


            // load views
            require APP . 'view/_templates/header.php';
            require APP . 'view/_templates/panel.php';
            require APP . 'view/operaciones/ges_orden_compras.php';
            require APP . 'view/_templates/footer.php';


        }
          
}

public function print_fact($id){


 $res = $this->model->verify_session();

        if($res=='0'){

             // load views
            require APP . 'view/_templates/header.php';
            require APP . 'view/_templates/panel.php';
            require APP . 'view/operaciones/ges_print_FactCompras.php';
            require APP . 'view/_templates/footer.php';


        }





}

public function fact_mailing($id){

 $res = $this->model->verify_session();

      if($res=='0'){


      require 'PHP_mailer/PHPMailerAutoload.php';
      $mail = new PHPMailer;


     // $ORDER = $this->model->get_req_to_print($id);

            // load views
            require APP . 'view/_templates/header.php';
            require APP . 'view/_templates/panel.php';
            require APP . 'view/operaciones/fact_mailing.php';
            require APP . 'view/_templates/footer.php';


        }


}
          

public function PO_filter_by_Vendor($vendor){

    $this->model->verify_session();
    $list = '';
    
    $clause = ' WHERE VendorID="'.$vendor.'" and ID_compania="'.$this->model->id_compania.'"';
    
    $res = $this->model->get_OC_ID('desc','1000',$clause);

    foreach($res as $value){
        
        $value = json_decode($value);

        $list.= '<option value="'.$value->{'PurchaseOrderNumber'}.'" >'.$value->{'PurchaseOrderNumber'}."</option>";
        

    }

    echo  $list;
    
}
    
public function PO_item($PurchaseOrderNumber){
 
 $this->model->verify_session();
   
 $res = $this->model->get_items_by_OC($PurchaseOrderNumber);


 $i = 0;
 foreach ($res as  $value) {
    $array[$i] = $value;
    $i = $i + 1;
 }
 $items['items'] = json_encode($array);
 echo json_encode($items);
}


}

?>