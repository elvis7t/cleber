<?php
date_default_timezone_set('America/Sao_Paulo');

session_start("portal");
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

if($acao == "cad_certif"){
	$cod_cert = $rs_eve->autocod("cer_id","certificados");
	$dados["cer_id"] 		= $cod_cert;
	$dados["cer_cli"] 		= $cer_cli;
	$dados["cer_tipo"] 		= $cer_tipo;
	$dados["cer_entidade"] 	= $cer_enti;
	$dados["cer_validade"] 	= $fn->data_usa($cer_val);
	$dados["cer_pin"] 		= $cer_pin;
	$dados["cer_puk"] 		= $cer_puk;
	$dados["cer_local"] 	= $cer_local;
	$dados["cer_status"] 	= $cer_sta;
	$dados["cer_cadem"] 	= date("Y-m-d H:i:s");
	$dados["cer_cadpor"] 	= $_SESSION['usu_cod'];

	if(!$rs_eve->Insere($dados,"certificados")){
		$resul["status"] = "OK";
        $resul["mensagem"] = "Novo certificado cadastrado!";
        $resul["sql"] = $rs1->sql;
	}
	else{
		$resul["status"] = "ERRO";
        $resul["mensagem"] = "Falha na inclus&atilde;o";
        $resul["sql"] = $rs_eve->sql;
	}
	echo json_encode($resul);
	exit;
}


if($acao == "alt_certif"){
	$dados["cer_validade"] 	= $fn->data_usa($cer_val);
	$dados["cer_pin"] 		= $cer_pin;
	$dados["cer_puk"] 		= $cer_puk;
	$dados["cer_local"] 	= $cer_local;
	$dados["cer_status"] 	= $cer_sta;
	$whr = "cer_id = ".$cer_id;
	if(!$rs_eve->Altera($dados,"certificados",$whr)){
		$resul["status"] = "OK";
        $resul["mensagem"] = "Alterado com sucess!";
        $resul["sql"] = $rs1->sql;
	}
	else{
		$resul["status"] = "ERRO";
        $resul["mensagem"] = "Falha na altera&ccedil;&atilde;o";
        $resul["sql"] = $rs_eve->sql;
	}
	echo json_encode($resul);
	exit;
}

