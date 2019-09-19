<?php
/*---------------------------------------------------------*\
|	TCCadUser.php											|
|	Responsável por cadastrar usuários no banco de dados	|
\*---------------------------------------------------------*/
sleep(2);
require_once("../model/recordset.php");
$rs = new recordset();
$dados	= array();
$status = array();


$dados['usu_user']		= $_POST['user'];
$dados['usu_senha']		= md5($_POST['senha']);
$dados['usu_classe']	= $_POST['classe'];
$dados['usu_ativo']		= 1;


if(empty($dados['usu_user'])){
	$status['st'] = "NOK";
	$status['ms'] = "Nome do usuário vazio!";
	$status['sql']	= '';
}
else{
	$rs->Seleciona("usu_user","usuarios","usu_user='".$dados['usu_user']."'");
	if($rs->linhas > 0){
		$status['st'] = "NOK";
		$status['ms'] = "Conta já existente! Faça login...";
		$status['sql']	= '';
	}
	else{
		if(!$rs->Insere($dados,"usuarios")){
			$status['st']	= "OK";
			$status['ms']	= "Usuário cadastrado!";
			//$status['sql']	= $rs->sql;
		}
		else{
			$status['st']	= "NOK";
			$status['ms']	= "Erro ao cadastrar!";
			$status['sql']	= $rs->sql;
		}
	}
}
echo json_encode($status);

?>