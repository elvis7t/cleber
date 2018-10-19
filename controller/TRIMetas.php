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

if($acao == "nova_meta"){
	/*Evitar ter metas iguais*/
	foreach ($meta_user as $key => $value) {
		$sql = "SELECT metas_id FROM metas 
			WHERE metas_colab = ".$value."
				AND metas_dataini = '".$fn->data_usa($meta_ini)."'
				AND metas_datafin = '".$fn->data_usa($meta_fim)."'";
		$rs2->FreeSql($sql);
		$resul['sql2']		= $rs2->sql;
		if($rs2->linhas > 0){
			$resul['mensagem']	= "Imposível. Já existe uma meta com esses parâmetros";
		}
		else{
			$cod = $rs_eve->autocod("metas_id","metas");
			$dados['metas_id']			= $cod;
			$dados['metas_dataini']		= $fn->data_usa($meta_ini);
			$dados['metas_datafin']		= $fn->data_usa($meta_fim);
			$dados['metas_colab']		= $value;
			$dados['metas_criadopor']	= $_SESSION['usu_cod'];

			if(!$rs_eve->Insere($dados, "metas")){
				$resul['status']	= "OK";
				$resul['mensagem']	= "Lista de metas criada!";
				$dados2 = array();
			}
			else{
				$resul['mensagem']	= "Ocorreu um erro...";
				$resul['sql']		= $rs->sql;
			}
		}
	}
	echo json_encode($resul);
    exit;	
}


if($acao == "listar_metas"){
	$cod = explode(",", $valor);
	foreach ($cod as $cods) {
		$data = explode(":", $cods);
		$dados['tarmetas_emp'] 	= $data[0];
		$dados['tarmetas_obri'] = $data[1];
		$dados['tarmetas_comp'] = $data[2];
		$dados['tarmetas_metasId'] = $lista;
		$rs_eve->Insere($dados,"tarmetas");
	}
    $resul["status"] = "OK";
    $resul["mensagem"] = "Tarefas incluídas com sucesso";
    $resul["sql"] = $rs_eve->sql;
	echo json_encode($resul);
    exit;
}

if($acao == "excluir_lote"){
	$whr = "tarmetas_id IN(".$valor.")";
	if(!$rs_eve->Exclui("tarmetas",$whr)){
		$resul["status"] = "OK";
    	$resul["mensagem"] = "Tarefas Excluídas com sucesso!";
    	$resul["sql"] = $rs_eve->sql;
	}
	echo json_encode($resul);
    exit;
}