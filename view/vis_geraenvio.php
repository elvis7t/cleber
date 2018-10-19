<?php
	session_start("portal");
	require_once("../../model/recordset.php");
	require_once("../../sistema/class/class.functions.php");
	require_once('../class/class.permissoes.php');
	date_default_timezone_set("America/Sao_Paulo");
	$fn = new functions();
	$rs = new recordset();
	$rs2 = new recordset();
	$per = new permissoes();
	extract($_GET);

	$con = $per->getPermissao("ver_all_docs", $_SESSION["usu_cod"]);
	
	$sql1 = "SELECT a.tarq_id, a.tarq_nome, a.tarq_formato FROM tipos_arquivos a
	JOIN clientes_arquivos b 	ON b.cliarq_arqId = a.tarq_id
	JOIN tri_clientes c			ON c.cod = b.cliarq_empresa
	-- LEFT JOIN tipos_impostos d 		ON d.imp_tdocId = a.tarq_id
	WHERE a.tarq_id NOT IN (SELECT doc_tipo FROM entrada_docs WHERE doc_cli = {$emp} AND doc_ref='{$ref}')
	AND c.cod = {$emp}
	";
	if($con['C']==0){ $sql1.=" AND a.tarq_depart = ".$_SESSION['dep'];}
	$sql1.=" GROUP BY tarq_id ORDER BY tarq_nome ASC";

	$rs->FreeSql($sql1);
	//echo $rs->sql;

	$items = "";
	if($rs->linhas==0):
	$items = "<tr><td colspan=7> Nenhum documento...</td></tr>";
	else:
		$regs = $rs->linhas;
		while($rs->GeraDados()){
			$items .= "<tr><td>".htmlentities($rs->fld('tarq_nome'))."</td><td>".$rs->fld('tarq_formato')."</td></tr>";
		}
	endif;

	$sql = "SELECT empresa, email FROM tri_clientes WHERE cod = ".$emp;
	$rs->FreeSql($sql);
	$rs->GeraDados();	
	$email = $rs->fld("email");
	$hora = date("H");
	switch (true) {
		case ($hora<12):
			$mensagem = "Bom dia!";
			break;
		case ($hora <18):
			$mensagem = "Boa tarde!";
			break;
		case ($hora<23):
			$mensagem = "Boa boite!";
			break;
		
	}
	$body= "
	<p> &Agrave; empresa ".htmlentities($rs->fld("empresa")) .",</p>

	<p>".$mensagem."</p>
	<p>Solicitamos o envio dos documentos listados abaixo, para o fechamento da compet&ecirc;ncia ".$ref."</p>
	<table>
		<tr><th width='40%'>Arquivo</th><th width='60%'>Formato</th></tr>
		".$items."
	</table>
	<p>Os arquivos deve ser encaminhados para o e-mail ".$_SESSION['usuario']."<br>
	</p>
	<p>No aguardo,</p>
	<img src='http://192.168.0.104:8080/web/".$_SESSION['sign']."'>";

	echo $body;
	echo "<pre>";
	print_r($_SESSION);
	echo "</pre>";
	?>
	
