<?php

/**
 * Class Home
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */

class home extends Controller
{

  //borrar despues de pruebas
  public function newver()
  {
 
    
        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/_templates/panel.php';
        require APP . 'view/modules/sample_page.php';
        require APP . 'view/_templates/footer.php';


  }





    /**
     * PAGE: index
     * This method handles what happens when you move to http://yourproject/home/index (which is the default page btw)
     */
  
public function index()
{

  die(session_start());
    $res = $this->model->verify_session();
  
    $useragent=$_SERVER['HTTP_USER_AGENT'];  

    if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|SM-T210R|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od|ad)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){
      

            //IF USER LOGIN FROM MOBILE DEVICE AND SESSION EXIST LOAD MOBILE VIEW             
            require APP . 'view/mobile/index.php';

    }else{

      
   
          if($res=='0'){
          
              // load views
              require APP . 'view/_templates/header.php';
            //  require APP . 'view/_templates/panel.php';
              require APP . 'view/home/dashboard.php';
              // require APP . 'view/_templates/footer.php';


          }
    }
    
}

public function accounts()
{    
        $res = $this->model->verify_session();

        if($res=='0'){
        
        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/_templates/panel.php';
        require APP . 'view/home/account.php';
        require APP . 'view/_templates/footer.php';
        
        }

}

public function store(){ //tienda opencart

  $res = $this->model->verify_session();
  
    if($res=='0'){
          
                  // do stuff here
        $url = URL.'/ACIWEB-opencart/upload/admin/'; // this can be set based on whatever

        // no redirect
        header( "Location: $url" );
   }

}


public function edit_account($id){


        $res = $this->model->verify_session();

          if($res=='0'){


          // load views
          require APP . 'view/_templates/header.php';
          require APP . 'view/_templates/panel.php';
          require APP . 'view/home/EditProfile.php';
          require APP . 'view/_templates/footer.php';
        }

}

public function mob_account($id){
  
  
  $res = $this->model->verify_session();
  
          if($res=='0'){
              // load views
            require APP . 'view/_templates/mob_header.php';  
            require APP . 'view/mobile/account_info.php';  
            
          }else{

            require APP . 'view/mobile/index.php';  
          }
  
}

public function config_sys(){


       $res = $this->model->verify_session();

        if($res=='0'){


        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/_templates/panel.php';
        require APP . 'view/home/ConfigSys.php';
        require APP . 'view/_templates/footer.php';


       }

}


public function GetPrintInfo(){

  $RES = $this->model->Query('Select * from  INV_PRINT_CONF');


  return $RES;
}

public function GetTerminoPago(){
  
  $RES = $this->model->Query('Select * from CUST_PAY_TERM where ID_compania="'.$this->model->id_compania.'";');

  return $RES;
}

public function del_tax($id){

    $this->model->Query('delete from sale_tax Where id="'.$id.'";');

}

public function del_print($id){


$this->model->Query('delete from INV_PRINT_CONF Where SERIAL="'.$id.'";');


}

public function del_term($id){
  
  $this->model->verify_session();
  
  $this->model->Query('delete from CUST_PAY_TERM  Where TermID="'.$id.'" and ID_compania="'.$this->model->id_compania.'";');
  
}

public function removerUser($id){

  $this->model->Query('delete from SAX_USER  Where id="'.$id.'"; ');
  

}

public function GetBDLog(){

 echo nl2br( file_get_contents('LOG_ERROR/ERROR_LOG.txt'));

  
}


public function GetSyncLog(){

echo file_get_contents('webhook_log.txt');


}



public function ClearBDLog(){

 file_put_contents("LOG_ERROR/ERROR_LOG.txt",'');

}


public function ClearSyncLog(){

 file_put_contents('webhook_log.txt','');


}

public function getPrinterList(){


return $this->model->Query('SELECT * FROM INV_PRINT_CONF');

}

public function getPrinterById($id){
  
$RES = '';

$printer = $this->model->Query('SELECT * FROM INV_PRINT_CONF where ID ="'.$id.'"');


if($printer){
  $printer = json_decode($printer[0]);
  $RES = $printer->{'SERIAL'}.' - '.$printer->{'DESCRIPCION'};
}


return $RES;
}

public function getUserlist(){

	$user = $this->model->Query('SELECT * FROM SAX_USER WHERE onoff="1" ORDER BY "name" asc;');

		foreach ($user as $datos) {

	     $user = json_decode($datos);

	     

	     $id="'".$user->{'id'}."'";
       
       if ($user->{'id'}=='1'){
         $disable = 'disabled';
       }else{
        $disable = '';

       }

       echo '<tr>
       <td>'.$user->{'name'}.'</td>
       <td>'.$user->{'lastname'}.'</td>
       <td>'.$user->{'email'}.'</td>
       <td>'.$user->{'role'}.'</td>
       <td>'.$user->{'last_login'}.'</ttdh>
       <td><a  href="'.URL.'index.php?url=home/edit_account/'.$user->{'id'}.'" ><input type="button" id="modal_button" name="modal_button"  class="btn btn-danger btn-sm btn-icon icon-left" value="Editar" '.$disable.'></td>
       </tr>';
	 // data-toggle="modal" data-target="#myModal";



}

}

public function CheckError(){


  $CHK_ERROR =  $this->model->read_db_error();


  if ($CHK_ERROR!=''){ 

   
    die( "<script>  $(window).on('load', function () {   
                           $('#ErrorModal').modal('show');
                           $('#ErrorMsg').html('".$CHK_ERROR."');
                         }); 
          </script>");

  }

}

////////////////////////////////////////////////////////////////////////////////////
//PROCESO DE ENVIO DE EMAIL (TEST)
public function send_test_mail($emailtest){

//require_once 'mailer/Exception.php';
require_once 'mailer/PHPMailer.php';
require 'mailer/SMTP.php';

try {

$mail = new PHPMailer(true);

$mail->isSMTP(true); // enable MAIL
$mail->IsHTML(true);


$sql = "SELECT * FROM CONF_SMTP WHERE ID='1'";

$smtp= $this->model->Query($sql);

foreach ($smtp as $smtp_val) {
  $smtp_val= json_decode($smtp_val);

  
  $mail->Host =     $smtp_val->{'HOSTNAME'};
  $mail->Port =     $smtp_val->{'PORT'};
  $mail->Username = $smtp_val->{'USERNAME'};
  $mail->Password = $smtp_val->{'PASSWORD'};
  $mail->SMTPAuth = $smtp_val->{'Auth'};
  $mail->SMTPSecure=$smtp_val->{'SMTPSecure'};
  $mail->SMTPDebug= $smtp_val->{'SMTPSDebug'};
  
  $mail->SetFrom($smtp_val->{'USERNAME'});

}

$mail->SMTPOptions = array(
  'ssl' => array(
      'verify_peer' => false,
      'verify_peer_name' => false,
      'allow_self_signed' => true
  )
);


$mail->Subject = utf8_decode('Prueba de configurarión SMTP (ACI-WEB)');

$message_to_send ='<html>
                  <head>
                  <meta charset="UTF-8">
                  <title>Prueba de configurarión SMTP (ACI-WEB)</title>
                  </head>
                  <body>Este es un correo de prueba del sistema ACI-WEB de APCON Consulting, 
                  para certificar el funcionamiento de su configuracion SMTP.</body>
                  </html>';

$mail->Body = $message_to_send;

$mail->AddAddress($emailtest);

$mail->Send();

$alert = 'El correo de verificacion ha sido enviado';



} catch (Exception $e) {

   $alert = 'El correo no puede ser enviado. Mailer Error: '.$mail->ErrorInfo;

}

echo $alert;

}




}