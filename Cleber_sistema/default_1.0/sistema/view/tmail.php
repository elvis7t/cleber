<?php
require_once("../model/recordset.php");
$hosted = "http://localhost/www/sistema";
date_default_timezone_set('America/Sao_Paulo');
//echo $hosted;
$rs=new recordset();

$sql = "SELECT * FROM irpf_mailsender 
WHERE ims_enviado = 0";

$rs->FreeSql($sql);
if($rs->linhas == 0 ){
	echo "---------------------------Nao ha email para enviar--------------------------";
	$fileLocation = "LOGS\MAIL_LOG.txt";
	$tant = file_get_contents($fileLocation);
	$file = fopen($fileLocation,"w");
	$content = $tant."\r\n[".date("d/m/Y H:i:s")."]---------Nao ha email para enviar--------------------------\n";
	fwrite($file,$content);
	fclose($file);
}
else{

	while($rs->GeraDados()){
		$rs1=new recordset();
		$narqs=array();
		$arqs = explode("|",$rs->fld("ims_arquivo"));
		foreach ($arqs as $key => $value) {
			$narqs[$key] = substr($value,stripos($value, "files/")+6);
		}
		//$narqs = substr($narqs,0,-1);
		
		$assunto = 'ARQUIVOS IRPF - ORG. CONT. TRIÂNGULO';

		$headers = "From: clebermarrara@bol.com.br\r\n";
		$headers .= "Reply-To: clebermarrara@bol.com.br\r\n";
		$headers .= "CC: informatica@triangulocontabil.com.br\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

		$message = $rs->fld("ims_message");

		$dados['ims_enviado'] = 1;
		$dados['ims_hora'] = date("Y-m-d H:i:s");
		//$dados['ims_nomearquivo'] = $narqs;

		
	
		$destinatarios = ($rs->fld("ims_dest")<>""?$rs->fld("ims_dest"):"nilza@triangulocontabil.com.br");
		$nomeDestinatario = "IRPF";
		$usuario = "nilza@triangulocontabil.com.br";
		$senha = "Triangulo@2016";

		// Arquivos (tá aqui a pegadinha...)
		//Primeiro: Vamos fazer um array com o arquivos e seu respectivo nome
		
		$comp_arqs = array_combine($arqs, $narqs);

		/*abaixo as veriaveis principais, que devem conter em seu formulario*/

		/*********************************** A PARTIR DAQUI NAO ALTERAR ************************************/


		require_once("../../Class/PHPMailer/class.phpmailer.php");
		$To = $destinatarios;
		$Subject = $assunto;
		$Message = $message;

		$Host = 'smtp.'.substr(strstr($usuario, '@'), 1);
		$Username = $usuario;
		$Password = $senha;
		$Port = "587";

		$mail = new PHPMailer();
		$body = $Message;
		$mail->IsSMTP(); // telling the class to use SMTP
		$mail->Host = $Host; // SMTP server
		$mail->SMTPDebug = 0; // enables SMTP debug information (for testing)
		// 1 = errors and messages
		// 2 = messages only
		$mail->SMTPAuth = true; // enable SMTP authentication
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
		$mail->AddAddress("nilza@triangulocontabil.com.br", "");

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
			$rs1->Altera($dados,"irpf_mailsender","ims_id=".$codims);
			echo "Registro {$codims} alterado com sucesso\n";
			unset($rs1);
		
			$msg['statu']  = "OK";
			$msg["mensagem"] =  "Mensagem enviada com sucesso!";
			$msg['erros'] = "Sem erros";
		}

		$fileLocation = "LOGS\MAIL_LOG.txt";
		$tant = file_get_contents($fileLocation);
  		$file = fopen($fileLocation,"w");
  		$content = $tant."\r\n[".date("d/m/Y H:i:s")."] Enviado para {$rs->fld("ims_dest")} com sucesso!\n";
  		$content .= "Erros: ".$msg["erros"]."\r\n";
  		fwrite($file,$content);
  		fclose($file);

	}
}
?>
