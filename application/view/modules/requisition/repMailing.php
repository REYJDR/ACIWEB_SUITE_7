<?php 

$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

require_once APP.'view/modules/'.basename(__DIR__).'/lang/'.$this->model->lang.'_ref.php';


//valores de la requisicion segun ID. 
foreach ($ORDER as  $value) {

    $value = json_decode($value);

    $name     =  $this->model->Query_value('SAX_USER','name','Where ID="'.$value->{'USER'}.'"');
    $lastname =  $this->model->Query_value('SAX_USER','lastname','Where ID="'.$value->{'USER'}.'"');

              
    $ref = $value->{'NO_REP'};

    $rep = $name.' '.$lastname;

    $date = $value->{'DATE'};
    $desc = $value->{'NOTA'};
}

?>

<div  class="page-print col-xs-11">
<div  class="col-xs-12">

<?php

$message .='<h2 class="h_invoice_header" >'.$Rep_tittle.'</h2>
                 <table BORDER="1">
                    
                    <tr>
                      <th style="text-align:left;"><strong>'.$Reference.'</strong>'.$ref.'</th>
                      
                    </tr>
                    <tr>
                      <th style="text-align:left;"><strong>'.$Rep_date.'</strong>'.$meses[date('n',strtotime($date))-1].' '.date(' j, Y',strtotime($date)).'</th>
                      
                    </tr>
                    <tr>
                      <th style="text-align:left;"><strong>'.$Applicant.'</strong>'.$rep.'</th>
                      
                    </tr>
</table>
                  
<br>
                                             
                       
<TABLE   width="100%" border="1" >
   <TR >
    <TH width="100%">'.$Rep_description.'</TH>
   </TR>
   <TR >
   <TD width="100%">'.$desc.'</TD>
  </TR>
</TABLE>

<br>                   

<TABLE   width="100%" border="1" >
<TR >
   <TH width="15%">'.$Mail_po.'</TH>
   <TH width="35%">'.$Mail_job.'</TH>
   <TH width="10%">'.$Mail_phase.'</TH>
   <TH width="10%">'.$Mail_CCS.'</TH>
   <TH width="10%">'.$Mail_amount.'</TH>
    </TR>';

foreach ($ORDER as  $value) { 

$value = json_decode($value);  


$message .= '<tr>
   <td width="15%" style="padding-right:10px; text-align: left;">'.$value->{'PO_ID'}.'</td>
   <td width="35%">'.$value->{'JOB'}.'</td>
   <td width="10%">'.$value->{'PHASE'}.'</td>
   <td width="10%">'.$value->{'CCOST'}.'</td>
   <td width="10%" class="numb" style="text-align: right; padding-right">'.number_format($value->{'PAY_REQ'},2).'</td>   
            </tr>';

}


$message .= '</table><BR><BR>';


$message .= '<a href="'.URL.'index.php?url=ges_requisiciones/set_rep_pay/'.$ref.'/'.$this->model->id_compania.'" type="button" id="pay" >'.$Button_pay.'</a>';

$message_to_send ='<html>
<head>
<meta charset="UTF-8">
<title>'.$Mail_title.'</title>
</head>
<body>'.$message.'</body>
</html>';




$mail->IsMail(); // enable SMTP
$mail->IsHTML(true);

$mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
          );


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



$mail->Subject = utf8_decode($Mail_subject."-".$ref);
$mail->Body = $message_to_send;




//VERIFICA USUARIOS CON OPCION DE NOTIFICACION
$sql = 'SELECT name, lastname, email from SAX_USER WHERE notif_oc="1" and onoff="1"';
$address = $this->model->Query($sql);

foreach ($address as  $value) {
$value = json_decode($value);

$mail->AddAddress($value->{'email'}, $value->{'name'}.' '.$value->{'lastname'});

}


//Envia el Email
if(!$mail->send()) {
 

   $alert .= 'Message could not be sent.';
   $alert .= 'Mailer Error: ' . $mail->ErrorInfo;

   ECHO $alert ;
   
} else {

   ECHO '1';

}

?>

</div>
</div>