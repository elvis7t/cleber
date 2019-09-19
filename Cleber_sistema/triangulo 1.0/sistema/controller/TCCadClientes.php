<?php
/*---------------------------------------------------------*\
|	TCCadUser.php											|
|	Responsável por cadastrar clientes no banco de dados	|
\*---------------------------------------------------------*/

require_once("../model/recordset.php");
$rs = new recordset();
$rs_cli = new recordset();
$dados	= array();
$clientes = array();
$status = array();


$dados['usu_user']		= $_POST['user'];
$dados['usu_senha']		= md5($_POST['senha']);
$dados['usu_classe']	= 'Cliente';
$dados['usu_ativo']		= 1;

$clientes['cli_nome']	= $_POST['nome'];
$clientes['cli_user']	= $_POST['user'];
$clientes['cli_cep']	= $_POST['cep'];
$clientes['cli_rua']	= $_POST['rua'];
$clientes['cli_num']	= $_POST['num'];
$clientes['cli_comp']	= $_POST['comp'];
$clientes['cli_bairro']	= $_POST['bairro'];
$clientes['cli_cidade']	= $_POST['cid'];
$clientes['cli_est']	= $_POST['est'];
$clientes['cli_tel']	= $_POST['tel'];
$clientes['cli_cel']	= $_POST['cel'];

if(empty($_POST['user'])){
	$status['st'] = "NOK";
	$status['ms'] = "Usu&aacute;rio n&atilde;o pode ser vazio!";
}
else{
	$rs->Seleciona("usu_user","usuarios","usu_user='".$dados['usu_user']."'");
	$lins = $rs->linhas;
	if($lins == 0){
		$status['st']	= "OK";
		$status['ms']	= "Cadastrando usu&aacute;rio...";
		sleep(1);
		$rs->Insere($dados,"usuarios");
		$status['ms']	= "Cadastrando dados do usu&aacute;rio...";
		sleep(1);
		$rs_cli->Insere($clientes,"clientes");
		$status['ms']	= "Cadastro conclu&iacute;do. Fa&ccedil;a login...";
	}
	else{
		$status['st'] = "NOK";
		$status['ms'] = "Usu&aacute;rio j&aacute; existente... Fa&ccedil;a login!";
	}
}
echo json_encode($status);
?>