<?PHP

class ges_consignaciones extends Controller
{

public $ProductID;

public function con_crear(){
 

 $res = $this->model->verify_session();

        if($res=='0'){

          // load views
          require APP . 'view/_templates/header.php';
          require APP . 'view/_templates/panel.php';
          require APP . 'view/modules/inventory/ConTras.php';
          require APP . 'view/_templates/footer.php';


        }

	
}

public function con_print($id){


 $res = $this->model->verify_session();

        if($res=='0'){
        	
 $id = trim($id);

 $clause= 'WHERE A.ID_compania="'.$this->model->id_compania.'"
                 and A.refAci="'.$id.'"';

 $ORDER = $this->model->get_con_to_report('DESC','1',$clause);

  
            foreach ($ORDER as  $value) {

             $value = json_decode($value);

             $name = $this->model->Query_value('SAX_USER','name','Where ID="'.$value->{'USER'}.'"');
             $lastname =  $this->model->Query_value('SAX_USER','lastname','Where ID="'.$value->{'USER'}.'"');

              
              $ref = $value->{'REF'};

              $rep = $name.' '.$lastname;

              $date = $value->{'date'};

              $desc = $value->{'NOTA'};



            }
        

            // load views
            require APP . 'view/_templates/header.php';
            require APP . 'view/_templates/panel.php';
            require APP . 'view/modules/con_print.php';
            require APP . 'view/_templates/footer.php';


        }


}



  

}

?>