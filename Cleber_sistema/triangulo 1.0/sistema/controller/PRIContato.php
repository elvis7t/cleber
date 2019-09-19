<?php
/*---------------------------------------------------------*\
	@file PRIContato.php
	@version 1.0
	@author Cleber Marrara Prado <cleber.marrara.prado@gmail.com>
	@description 
		Envia e-mail de contato para endereço retorno do Banco de dados, tabela Sistema
\*---------------------------------------------------------*/
require_once("../model/recordset.php");
$arr = array();
$rs = new recordset();
$rs->Seleciona("*","sistema","sys_nome='priore'");
$rs->GeraDados();

$subject = 'Contato do site da Priore';

$headers = "From: " . $_POST['email'] . "\r\n";
$headers .= "Reply-To: ". $_POST['email'] . "\r\n";
$headers .= "CC: cleber.marrara.prado@gmail.com\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

$message = '<html><body>';
$message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
$message .= "<tr style='background: #eee;'><td><strong>Nome:</strong> </td><td>" . $_POST['nome'] . "</td></tr>";
$message .= "<tr><td><strong>E-mail:</strong> </td><td>" . $_POST['email'] . "</td></tr>";
$message .= "<tr><td><strong>Telefone:</strong> </td><td>" . $_POST['telefone'] . "</td></tr>";
$message .= "<tr><td><strong>Assunto:</strong> </td><td>" . $_POST['assunto'] . "</td></tr>";
$message .= "<tr><td><strong>Mensagem:</strong> </td><td>" . $_POST['mensagem'] . "</td></tr>";
$message .= "</table>";
$message .= "</body></html>";


$destinatarios = $rs->fld("sys_retorno");
$nomeDestinatario = $rs->fld("sys_nome");
$usuario = $rs->fld("sys_mail");
$senha = $rs->fld("sys_senha");


/*abaixo as veriaveis principais, que devem conter em seu formulario*/
$nomeRemetente = $_POST['nome'];
$assunto = $_POST['assunto'];
$_POST['mensagem'] = nl2br('E-mail: '. $_POST['email'] ."

". $_POST['mensagem']);
$ret = 1;

/*********************************** A PARTIR DAQUI NAO ALTERAR ************************************/

require_once("../Class/PHPMailer/class.phpmailer.php");

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
$mail->AddAddress($To, "");

if(!$mail->Send()){
	$arr['st'] = "NOK";
	$arr['ms'] = "E-Mail n&atilde;o enviado!";
}
else {
	$arr['st'] = "OK";
	$arr['ms'] = "Mensagem enviada com sucesso para a Priore!";
}

echo json_encode($arr);
?>
