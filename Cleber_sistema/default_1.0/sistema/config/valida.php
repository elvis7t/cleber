<?php
session_start();
/* incluir em todas as p�ginas que necessitarem de login para serem visualizadas */

require_once("../model/recordset.php");

$rsvld = new recordset();
$whr = "log_user = '".$_SESSION['usuario']."' AND log_token = '".addslashes($_GET['token'])."' AND log_status= '1'";
$rsvld->Seleciona("*","logado",$whr);

$arr = array();
if($rsvld->linhas <> 1){ // Se n�o houverem credenciais
	$arr["status"] 		= "NO";
	$arr["titulo"]		= "Priore - AVISO";
	$arr["mensagem"]	= "Fa�a Login para acessar esse Conte�do";
	header("location:".$hosted."./view/login.php");
}
else{
	// atualizar data... senao a sessao cair� a cada 60min
	$expira = date("Y-m-d H:i:s", mktime(date("H"), date("i")+60, date("s"), date("m"), date("d"), date("Y)")));
	$rsvld->FreeSql("UPDATE logado SET log_expira='".$expira."' WHERE ".$whr);
}
unset($rsvld);
?>