<?
/*--------------------------------------------------------------------------------*\
|	Plugin de Mensagens
|	Uso - Badge com quantidade de mensagens para o usuário e mensagens em preview
|
\*--------------------------------------------------------------------------------*/


$mens = 0;
//Quantidade de Mensagens para o Badge
if (isset($_SESSION['usuario'])){
	$rs_msg->Seleciona("*","mensagens","men_para like '%".$_SESSION['usuario']."%' AND men_lida = 0");
	$mens = $rs_msg->linhas;	
}

?>