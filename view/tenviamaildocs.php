<?php
require_once("../model/recordset.php");
//$hosted = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://".$_SERVER["HTTP_HOST"]."/sistema";
$hosted = "http://www.triangulocontabil.com.br/sistema";
date_default_timezone_set('America/Sao_Paulo');
//echo $hosted;
$rs=new recordset();

$sql = "SELECT * FROM maildocumento
WHERE mds_status = 0";

$rs->FreeSql($sql);
if($rs->linhas == 0 ){
	echo "---------------------------Nao ha email para enviar--------------------------";
	$fileLocation = "LOGS\MAILDOCS_LOG.txt";
	$tant = file_get_contents($fileLocation);
	$file = fopen($fileLocation,"w");
	$content = $tant."\r\n[".date("d/m/Y H:i:s")."]---------Nao ha email para enviar--------------------------\n";
	fwrite($file,$content);
	fclose($file);
}
else{

	while($rs->GeraDados()){
		$rs1=new recordset();
		/*$narqs=array();
		//$arqs = explode("|",$rs->fld("ims_arquivo"));
		foreach ($arqs as $key => $value) {
			$narqs[$key] = substr($value,stripos($value, "files/")+6);
		}
		*/
		//$narqs = substr($narqs,0,-1);
		
		$assunto = 'NOVO DOCUMENTO ENVIADO AO PORTAL';

		$headers = "From: documentos@triangulocontabil.com.br\r\n";
		$headers .= "Reply-To: documentos@triangulocontabil.com.br\r\n";
		$headers .= "CC: informatica@triangulocontabil.com.br\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

		$message = $rs->fld("mds_body");

		$dados['mds_status'] = 1;
		$dados['mds_hora'] = date("Y-m-d H:i:s");
		//$dados['ims_nomearquivo'] = $narqs;

		
	
		$destinatarios = ($rs->fld("mds_dest")<>""?$rs->fld("mds_dest"):"documentos@triangulocontabil.com.br");
		$nomeDestinatario = "DOCUMENTOS";
		$usuario = "documentos@triangulocontabil.com.br";
		$senha = "@1infomail99";

		// Arquivos (tá aqui a pegadinha...)
		//Primeiro: Vamos fazer um array com o arquivos e seu respectivo nome
		
		//$comp_arqs = array_combine($arqs, $narqs);

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
		//$mail->AddAddress("nilza@triangulocontabil.com.br", "");
		/*
		foreach ($comp_arqs as $key => $value) {
			if(!empty($key)){
				$arquivo = str_replace($hosted."/triangulo", "..", $key);
				$mail->AddAttachment($arquivo,
				$value,
			    'base64',
			    'mime/type'); 		
			}
		}
		*/

		$msg = array();
		
		if(!$mail->Send()){
			$msg["status"] =  "NOK<br>";
			$msg["mensagem"] = "E-Mail n&atilde;o enviado!";
			$msg['erros'] = $mail->ErrorInfo;
		}
		else {
			$codmds = $rs->fld("mds_id");
			$rs1->Altera($dados,"maildocumento","mds_id=".$codmds);
			echo "Registro {$codmds} alterado com sucesso\n";
			unset($rs1);
		
			$msg['status']  = "OK";
			$msg["mensagem"] =  "Mensagem enviada com sucesso!";
			$msg['erros'] = "Sem erros";
		}

		$fileLocation = "LOGS\MAILDOCS_LOG.txt";
		$tant = file_get_contents($fileLocation);
  		$file = fopen($fileLocation,"w");
  		$content = $tant."\r\n[".date("d/m/Y H:i:s")."] Enviado para {$rs->fld("mds_dest")} com sucesso!\n";
  		$content .= "Erros: ".$msg["erros"]."\r\n";
  		fwrite($file,$content);
  		fclose($file);

	}
}
?>
