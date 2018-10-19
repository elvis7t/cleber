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

if($acao == "novo_chamado"){
	$cod = $rs_eve->autocod("cleg_id","chamados_legal");
	$dados['cleg_id']		= $cod;
	$dados['cleg_depto']	= $cleg_depto;
	$dados['cleg_empvinc']	= $_SESSION['usu_empcod'];
	$dados['cleg_empresa']	= $cleg_cliente;
	$dados['cleg_via']		= $cleg_via;
	$dados['cleg_contato']	= $cleg_contato;
	$dados['cleg_solic']	= $_SESSION['usu_cod'];
	$dados['cleg_datafim']	= $fn->data_usa($cleg_datafim);
	$dados['cleg_para']		= ($cleg_colab == 0 ? $_SESSION['usu_cod'] : $cleg_colab);
	$dados['cleg_abert']	= date("Y-m-d H:i:s");
	
	
	if(!$rs_eve->Insere($dados, "chamados_legal")){
		// INSERINDO CHECKLIST
		$rs2 = new recordset();
		$dados2 = array();
		foreach ($cleg_items as $value) {
			$dados2['clegchk_clegId'] = $cod;
			$dados2['clegchk_ativo'] = 0;
			$dados2['clegchk_item'] = $value;
			$rs2->Insere($dados2, "chamlegal_checklist");
		}
		
		// INSERINDO OBSERVAÇÂO

		$rs2 = new recordset();
		$dados2 = array();
		$dados2['chlegobs_chamid']  = $cod;
		$dados2['chlegobs_obs'] 	= addslashes($cleg_obs);
		$dados2['chlegobs_user']	= $_SESSION['usu_cod'];
		$dados2['chlegobs_horario'] = date("Y-m-d H:i:s");
		
		if(!$rs2->Insere($dados2,"chamleg_obs")){
			//INSERINDO SUBTAREFA
			if(!empty($cleg_id)){
				$dados3 = array();
				$dados3['cleg_subtar'] = $cod;
				$rs2->Altera($dados3,"chamados_legal","cleg_id=".$cleg_id);
			}
			$resul['status']	= "OK";
			$resul['mensagem']	= "Chamado cadastrado com sucesso!";

			
		}
	}
	else{
		$resul['mensagem']	= "Ocorreu um erro...";
		$resul['sql']		= $rs->sql;
	}
	echo json_encode($resul);
    exit;
}

if($acao == "altera_chamado"){
	$dados['cleg_depto']	= $cleg_depto;
	$dados['cleg_contato']	= $cleg_contato;
	$dados['cleg_datafim']	= $fn->data_usa($cleg_datafim);
	$dados['cleg_empresa']	= $cleg_cliente;
	$dados['cleg_para']		= ($cleg_colab == 0 ? $_SESSION['usu_cod'] : $cleg_colab);
	$dados['cleg_para']		= ($cleg_colab == 0 ? $_SESSION['usu_cod'] : $cleg_colab);
	
	
	if(!$rs_eve->Altera($dados, "chamados_legal","cleg_id=".$cleg_id)){
		
		$rs2 = new recordset();
		$dados2 = array();
		$dados2['chlegobs_chamid']  = $cleg_id;
		$dados2['chlegobs_obs'] 	= "Chamado alterado por: ".$_SESSION['nome_usu']."<br>".addslashes($cleg_obs);
		$dados2['chlegobs_user']	= $_SESSION['usu_cod'];
		$dados2['chlegobs_horario'] = date("Y-m-d H:i:s");
		
		if(!$rs2->Insere($dados2,"chamleg_obs")){
			$resul['status']	= "OK";
			$resul['mensagem']	= "Chamado cadastrado com sucesso!";
		}
	}
	else{
		$resul['mensagem']	= "Ocorreu um erro...";
		$resul['sql']		= $rs->sql;
	}
	echo json_encode($resul);
    exit;
}

if($acao == "salva_chamado"){
	$dados['cleg_percent']	= $cleg_percent;
	$dados['cleg_status']	= ($cleg_percent<100?91:102);
	$dados['cleg_tratfim']	= date("Y-m-d H:i:s") ;
	
	$whr = "cleg_id = ".$cleg_id;
	
	if(!$rs_eve->Altera($dados, "chamados_legal",$whr)){
		$resul['status']	= "OK";
		$resul['mensagem']	= "Chamado salvo!";
		$resul['sql']		= $rs_eve->sql;
		// INSERINDO OBSERVAÇÂO
		if(!empty($cleg_obs)){
			$rs2 = new recordset();
			$dados2 = array();
			$dados2['chlegobs_chamid'] 	= $cleg_id;
			$dados2['chlegobs_obs'] 	= addslashes($cleg_obs);
			$dados2['chlegobs_user']	= $_SESSION['usu_cod'];
			$dados2['chlegobs_horario']	= date("Y-m-d H:i:s");
			$rs2->Insere($dados2,"chamleg_obs");
		}

	}
	else{
		$resul['mensagem']	= "Ocorreu um erro...";
		$resul['sql']		= $rs_eve->sql;
	}
	echo json_encode($resul);
    exit;
}


if($acao == "encerra_chamado"){
	//$dados['cham_sla']		= $cham_sla;
	$dados['cleg_percent']	= 100 ;
	$dados['cleg_status']	= 99 ;
	$dados['cleg_aval']		= $cleg_aval ;
	
	$whr = "cleg_id = ".$cleg_id;
	
	if(!$rs_eve->Altera($dados, "chamados_legal",$whr)){
		$resul['status']	= "OK";
		$resul['mensagem']	= "Chamado salvo!";
		$resul['sql']		= $rs_eve->sql;
	}
	else{
		$resul['mensagem']	= "Ocorreu um erro...";
		$resul['sql']		= $rs_eve->sql;
	}
	echo json_encode($resul);
    exit;
}

if($acao == "combo_check"){
	$whr = "chk_tarefaVinculo like '%".$lista_id."%'";
	$rs_eve->Seleciona("*", "checklists",$whr);
	while($rs_eve->GeraDados()){
		echo "<option value='".$rs_eve->fld("chk_id")."'>".$rs_eve->fld("chk_item")."</option>";
	}
	exit;
}

if($acao == "conf_cleg"){
	$sql = "SELECT * FROM chamlegal_checklist WHERE clegchk_clegId='".$chamado."' AND clegchk_item=".$doc;
	$rs1->FreeSql($sql);
	if($rs1->linhas>0){
		$rs1->GeraDados();
		//$codImp = $rs1->fld("env_id");
		$dados['clegchk_ativo'] =	$ativo;
		$dados['clegchk_dtsep'] =	date("Y-m-d H:i:s");
		$dados['clegchk_seppor'] =	$_SESSION['usu_cod'];
		$whr = "clegchk_clegId='".$chamado."' AND clegchk_item=".$doc;
		$fn->Audit("chamlegal_checklist", $whr, $dados, $empresa, $_SESSION['usu_cod'],6);
		if(!$rs_eve->Altera($dados,"chamlegal_checklist",$whr)){
			$result['status'] = "OK";
			$result['mensagem'] = "Documento ".$rs1->pegar("chk_item","checklists","chk_id=$doc")." marcado como CONFERIDO no chamado {$chamado}!";
		}
		else{
			$result['status'] = "NOK";
			$result['mensagem'] = "Ocorreu um erro!";
		}
	}
	else{
		$result['status'] = "NOK";
		$result['mensagem'] = "Nada alterado";
	}
	
echo json_encode($result);
exit;
}

if($acao == "desconf_cleg"){
	$sql = "SELECT * FROM chamlegal_checklist WHERE clegchk_clegId='".$chamado."' AND clegchk_item=".$doc;
	$rs1->FreeSql($sql);
	if($rs1->linhas>0){
		$rs1->GeraDados();
		//$codImp = $rs1->fld("env_id");
		$dados['clegchk_ativo'] =	$ativo;
		$dados['clegchk_dtsep'] =	'';
		$dados['clegchk_seppor'] =	'';
		$whr = "clegchk_clegId='".$chamado."' AND clegchk_item=".$doc;
		$fn->Audit("chamlegal_checklist", $whr, $dados, $empresa, $_SESSION['usu_cod'],6);
		if(!$rs_eve->Altera($dados,"chamlegal_checklist",$whr)){
			$result['status'] = "OK";
			$result['mensagem'] = "Documento ".$rs1->pegar("chk_item","checklists","chk_id=$doc")." marcado como DESFEITO no chamado {$chamado}!";
		}
		else{
			$result['status'] = "NOK";
			$result['mensagem'] = "Ocorreu um erro!";
		}
	}
	else{
		$result['status'] = "NOK";
		$result['mensagem'] = "Nada alterado";
	}
	
echo json_encode($result);
exit;
}

if($acao == "exclui_itemchecklist"){
	if(!$rs_eve->Exclui("chamlegal_checklist","clegchk_id=".$chk_id)){
		$resul['status']	= "OK";
		$resul['mensagem']	= "Item ".$chk_id." excluído!";
		}
	else{
		$resul['mensagem']	= "Ocorreu um erro...";
		$resul['sql']		= $rs->sql;
	}	
	echo json_encode($resul);
    exit;	
}