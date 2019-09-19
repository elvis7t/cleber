<?php
session_start();
/* incluir em todas as páginas que necessitarem de login para serem visualizadas */

require_once("../model/recordset.php");

$rsvld = new recordset();
$whr = "log_user = '".$_SESSION['usuario']."' AND log_token = '".addslashes($_GET['token'])."' AND log_status= '1'";
$rsvld->Seleciona("*","logado",$whr);

$arr = array();
if($rsvld->linhas <> 1){ // Se não houverem credenciais
	$arr["status"] 		= "NO";
	$arr["titulo"]		= "Priore - AVISO";
	$arr["mensagem"]	= "Faça Login para acessar esse Conteúdo";
	header("location:".$hosted."./view/login.php");
}
else{
	// atualizar data... senao a sessao cairá a cada 60min
	$expira = date("Y-m-d H:i:s", mktime(date("H"), date("i")+60, date("s"), date("m"), date("d"), date("Y)")));
	$rsvld->FreeSql("UPDATE logado SET log_expira='".$expira."' WHERE ".$whr);
}
unset($rsvld);
?>