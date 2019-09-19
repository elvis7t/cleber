<?php
require_once("../model/recordset.php");
require_once("../config/aleat_cod.php");

//abre a instância recordset em $rs

$rs = new recordset;
// Resgata os Posts
$nome = $_POST["cnome"];
$senha = $_POST["csenha"];
$status = array('st'=>'','ms'=>'');

// monta a pesquisa de nome do usuário

$rs->FreeSQL("SELECT * FROM usuarios JOIN clientes ON usu_user = cli_user WHERE usu_user='".$nome."' AND usu_ativo=1");
$rs->GeraDados();
$lin = $rs->linhas;


if(!($lin == 1)){
	$status['st'] = "NOK";
	$status['ms'] = "Nenhum usu&aacute;rio encontrado!";
	echo json_encode($status);
}
else{
	if(!(md5($senha) == $rs->fld("usu_senha"))){
		$status['st'] = "NOK";
		$status['ms'] = "Senha incorreta...";
		echo json_encode($status);
	}
	else{
		$status['st']	= "OK";
		$status['ms']	= "Login OK! Processando...";
		echo json_encode($status);
		//exclui a ultima conexão do usuário (inclusive em outro computador)
		//$rs->Altera('lgi_ativo=0','login','lgi_user="'.$nome.'"');
		//inicia sessao
		session_start();
		$_SESSION['usuario'] 	= $rs->fld("usu_user");
		$_SESSION['senha']		= $rs->fld("usu_senha");
		$_SESSION['classe']		= $rs->fld("usu_classe");
		$_SESSION['nome']		= $rs->fld("cli_nome");
		$_SESSION['token']		= md5(aleat());
		//destruindo usuários logados
		//$rs->ExecutaSql("UPDATE login SET lgi_ativo=0 WHERE lgi_nome = '".$nome."'");
		//Inserindo novos dados
		$dados = array(
			"lgi_user" 	=>$_SESSION['usuario'],
			"lgi_token" =>$_SESSION['token'],
			"lgi_hora" 	=> date('Y/m/d h:m:s'),
			"lgi_ativo"	=> 1
		);
		$rs->Insere($dados,"login");		
	}
}
?>