<?php
date_default_timezone_set('America/Sao_Paulo');

session_start("portal");
require_once('../model/cloud_recordset.php');
require_once('../class/class.functions.php');


$rs_eve = new recordset_cloud();
$fn = new functions();
$resul = array();
extract($_POST);

if($acao == "novo_artigo"){

	$cod = $rs_eve->c_autocod("art_id","artigos");
	$dados['art_id']			= $cod;
	$dados['art_categ']			= addslashes($art_dep);
	$dados['art_title']			= $art_title;
	$dados['art_title2']		= $art_title2;
	$dados['art_briefing']		= addslashes($art_brief);
	$dados['art_description']	= addslashes($art_descr);
	$dados['art_content'] 		= addslashes($art_cont);
	$dados['art_images'] 		= addslashes($art_img);
	$dados['art_author'] 		= $art_col;
	$dados['art_email'] 		= $art_email;
	$dados['art_release']		= date("Y-m-d H:i:s");
	$dados['art_references']	= "<strong>Fonte: </stong> <a href=".$art_fonte.">".$art_fonte."</a>";
	if(!$rs_eve->c_Insere($dados, "artigos")){
		$resul['status'] = "OK";
		$resul['mensagem']="Artigo Publicado. Contate o administrador para upload das imagens";
		$resul['sql']=$rs_eve->sql;
	}
	else{
		$resul['status']="NOK";
		$resul['mensagem']="Falha no SQL";
		$resul['sql']=$rs_eve->sql;
	}

	echo json_encode($resul);
    exit;
}
