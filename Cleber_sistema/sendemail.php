<?php

//echo "<meta HTTP-EQUIV='refresh' CONTENT='5;URL=URat_mailSender.php'>";

require_once("model/recordset.php");



date_default_timezone_set('America/Sao_Paulo');

//echo $hosted;

$rs=new recordset();


$name       = $_REQUEST['name']; 
$from       = $_REQUEST['email']; 
$subject    = $_REQUEST['subject']; 
$message    = $_REQUEST['message']; 

$assunto = $subject;



$headers = "From: {$name} <{$from}>\r\n";
$headers .= "Reply-To: elsilva@vilagalvao.com.br\r\n";
$headers .= "CC: adouglas@niff.com.br\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

echo$name;

echo $subject;

echo $headers;

$rs1=new recordset();

		$narqs=array();

		$arqs = explode("|",$rs->fld("ims_arquivo"));

		foreach ($arqs as $key => $value) {

			$narqs[$key] = substr($value,stripos($value, "files/")+6);

		}

$destinatarios = "elsilva@vilagalvao.com.br";

		$nomeDestinatario = "INFRA_PRIME";

		$usuario = "infraprimesystema@gmail.com";

		$senha = "c0rp.@dm!n"; 

		   

		//$usuario = "elvist@bol.com.br";

		//$senha = "silva777"; 

 

		//Arquivos (tá aqui a pegadinha...) 

		//Primeiro: Vamos fazer um array com o arquivos e seu respectivo nome

		

		$comp_arqs = array_combine($arqs, $narqs);



		/*abaixo as veriaveis principais, que devem conter em seu formulario*/



		/*********************************** A PARTIR DAQUI NAO ALTERAR ************************************/

    



		require_once("class/PHPMailer_5.2.0/class.phpmailer.php");

		$To = $destinatarios;

		$Subject = $assunto;

		$Message = $message;

 

		//$Host = "smtps.bol.com.br"; 

		$Host = 'smtp.gmail.com'; 

		//$Host = 'smtp.'.substr(strstr($usuario, '@'), 1);

		$Username = $usuario;

		$Password = $senha;

		$Port = "587"; 



		$mail = new PHPMailer(); 

		$body = $Message;

		$mail->IsSMTP(); // telling the class to use SMTP

		$mail->Host = $Host; // SMTP server

		$mail->SMTPDebug = 0; // enables SMTP debug information (for testing)

		$mail->SMTPSecure = 'tls';

		// 1 = errors and messages

		// 2 = messages only

		$mail->SMTPAuth = true; // enable SMTP authentication

		//$mail->SMTPSecure = 'ssl';

		$mail->Port = $Port; // set the SMTP port for the service server

		$mail->Username = $Username; // account username

		



		$mail->Password = $Password; // account password



		$mail->SetFrom($usuario, $nomeDestinatario);

		$mail->Subject = $Subject;

		$mail->MsgHTML($body);



		if(stripos($To, ";")==false){

			$mail->AddAddress($To, "");

		}

		else{

			$dest = explode(";", $To);

			foreach ($dest as $value) {

				$mail->AddAddress($value, "");

			}

		}

		//Manda uma copia pra Dona Encrenca

		$mail->AddAddress("adouglas@niff.com.br", "");



		foreach ($comp_arqs as $key => $value) {

			if(!empty($key)){

				$arquivo = str_replace($hosted."/triangulo", "..", $key);

				$mail->AddAttachment($arquivo,

				$value,

			    'base64',

			    'mime/type'); 		

			}

		}



		$msg = array();

		

		if(!$mail->Send()){

			$msg["status"] =  "NOK<br>";

			$msg["mensagem"] = "E-Mail n&atilde;o enviado!";

			$msg['erros'] = $mail->ErrorInfo;

		}

		else {

			$codims = $rs->fld("ims_id");

			

			echo "Registro {$codims} alterado com sucesso\n";

			unset($rs1);

		

			$msg['statu']  = "OK";

			$msg["mensagem"] =  "Mensagem enviada com sucesso!";

			$msg['erros'] = "Sem erros";

		}



		





?>



