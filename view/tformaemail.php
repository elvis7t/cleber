<?php
require_once("../model/recordset.php");
//$hosted = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://".$_SERVER["HTTP_HOST"]."/sistema";
$hosted = "http://www.triangulocontabil.com.br/sistema";
date_default_timezone_set('America/Sao_Paulo');
//echo $hosted;
$rs = new recordset();
$rs1 = new recordset();
$rs2 = new recordset();
// Firstly, we check if there is any message to be sent
$sq = "SELECT * FROM doc_envclientes WHERE envcli_emailed = 0";
	
$rs->FreeSql($sq);
//echo $sq;
if($rs->linhas==0){
	echo "Não encontramos destinatário para a mensagem!";
}
else{
	// Lets group emails by companies
	$sq1 = "SELECT a.envcli_id, a.envcli_empresa, b.empresa, b.email, b.responsavel, c.usu_cod, c.usu_nome, c.usu_sign FROM doc_envclientes a
				JOIN tri_clientes b ON b.cod = a.envcli_empresa
				JOIN usuarios c ON c.usu_cod = a.envcli_envpor
			WHERE envcli_emailed = 0 GROUP BY envcli_empresa";
	$rs1->FreeSql($sq1);
	//echo $rs1->sql;
	while($rs1->GeraDados()){
		
		$sq2 = $sq." AND envcli_empresa=".$rs1->fld("envcli_empresa");
		//echo $sq2;
		$rs2->FreeSql($sq2);
		// Lets group the mails to be sent
		$tax = "";
		while($rs2->GeraDados()){
			$tax .= "<tr>
						<td>".htmlentities($rs2->fld("envcli_impnome"))."</td>
						<td>".$rs2->fld("envcli_arqnome")."</td>
						<td>
							<a href=\"http://www.triangulocontabil.com.br/sistema/view/vis_docsenviados.php?id=".$rs2->fld("envcli_id")."&via=Email\">Visualizar</a>
						</td>
					</tr>";
		}
		$cod_mds = $rs->autocod("mds_id","maildocumento");
		$dados2 = array();
		$dados2["mds_id"] = $cod_mds;
		$dados2['mds_dest'] = $rs1->fld("email");
		$message = file_get_contents("../view/template_senddocs.html");
		$message = str_replace("{RESP}", $rs1->fld("responsavel"), $message);
		$message = str_replace("{CLIENTE}", htmlentities($rs1->fld("empresa")), $message);
		$message = str_replace("{IMPOSTO}", $tax, $message);
		$message = str_replace("{SIGN}", $rs1->fld("usu_sign"), $message);
		$message = str_replace("{LINK}", $rs1->fld("envcli_id"), $message);
		//$message = str_replace("{VENCTO}", $fn->data_br($rs1->fld("envcli_vencto")),$message);
		//$message = str_replace("{OBSERVACOES}", $rs1->fld("apelido"),$message);
		$dados2['mds_body'] = stripslashes($message);
		$dados2['mds_sender'] = $rs1->fld("usu_cod");
		$dados2['mds_status'] = 0;
		
		echo $message;
		
		if(!$rs->Insere($dados2,"maildocumento")){
			$rs2->FreeSql("UPDATE doc_envclientes SET envcli_emailed=1 WHERE envcli_empresa=".$rs1->fld("envcli_empresa"));
			$fileLocation = "LOGS\MAIL_LOG.txt";
			$tant = file_get_contents($fileLocation);
			$file = fopen($fileLocation,"w");
			$content = $tant."\r\n[".date("d/m/Y H:i:s")."]Email para o cliente ".$rs1->fld("envcli_empresa")." na fila para envio\n";
			fwrite($file,$content);
			fclose($file);
			
		}

	}
}