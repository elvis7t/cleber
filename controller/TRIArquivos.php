<?php
date_default_timezone_set('America/Sao_Paulo');

session_start();
require_once('../model/recordset.php');
require_once('../class/class.historico.php');
require_once('../class/class.functions.php');
require_once('../class/class.permissoes.php');

$rs_eve = new recordset();
$rs1 = new recordset();
$rs2 = new recordset();
$hist = new historico();
$fn = new functions();
$per = new permissoes();
$resul = array();
extract($_POST);

if($acao == "cli_cadArquivo"){
	$cod = $rs_eve->autocod("tarq_id","tipos_arquivos");
	$dados['tarq_id']			= $cod;
	$dados['tarq_nome'] 		= addslashes($tarq_nome);
	$dados['tarq_desc']			= addslashes($tarq_desc);
	$dados['tarq_duplica']		= $tarq_duplica;
	$dados['tarq_formato']		= $tarq_formato;
	$dados['tarq_status']		= 1;
	$dados['tarq_depart'] 		= $tarq_depto;
	
	if(!$rs_eve->Insere($dados,"tipos_arquivos")){
		$resul['status']	= "OK";
		$resul['mensagem']	= "Arquivo cadastrado!";
		$resul['sql']		= $rs_eve->sql;
	}
	else{
		$resul['mensagem']	= "Ocorreu um erro...";
		$resul['sql']		= $rs_eve->sql;
	}
	echo json_encode($resul);
    exit;
}

if($acao == "cli_altArquivo"){
	$dados['tarq_nome'] 		= addslashes($tarq_nome);
	$dados['tarq_desc']			= addslashes($tarq_desc);
	$dados['tarq_duplica']		= $tarq_duplica;
	$dados['tarq_formato']		= $tarq_formato;
	$dados['tarq_status']		= 1;
	$dados['tarq_depart'] 		= $tarq_depto;
	$whr = "tarq_id=".$tarq_id;
	if(!$rs_eve->Altera($dados,"tipos_arquivos",$whr)){
		$resul['status']	= "OK";
		$resul['mensagem']	= "Arquivo alterado!";
		$resul['sql']		= $rs_eve->sql;
	}
	else{
		$resul['mensagem']	= "Ocorreu um erro...";
		$resul['sql']		= $rs_eve->sql;
	}
	echo json_encode($resul);
    exit;
}
