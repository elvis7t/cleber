<?php

session_start();
require_once('../class/class.eventos.php');
require_once("../class/class.functions.php");
$func = new functions();
$rs_eve = new eventos();
$result = array();
extract($_POST);

if($acao == "inclusao"){
	list($dt_ini, $dt_fin) = split("-",$eve_data);
	$dados = array(
		"eve_local" => $eve_local,
		"eve_data"	=> $func->data_usa(trim($dt_ini)),
		"eve_dataate"=> $func->data_usa(trim($dt_fin)),
		"eve_desc"	=> $eve_det,
		"eve_cep"	=> $eve_cep,
		"eve_log"	=> $eve_log,
		"eve_num"	=> $eve_num,
		"eve_compl"	=> $eve_compl,
		"eve_bai"	=> $eve_bai,
		"eve_cid"	=> $eve_cid,
		"eve_uf"	=> $eve_uf,
		"eve_valor"	=> $eve_valor,
		"eve_empresa"=> $eve_emp,
		"eve_ativo" => $eve_ativo
	);
	 if (!$rs_eve->novo_evento($dados)) {
        $resul["status"] = "ERRO";
        $resul["mensagem"] = "Falha na inclus&atilde;o";
    } else {
        $rs_eve->add_hist(9);
        $resul["status"] = "OK";
        $resul["mensagem"] = "Novo Usu&aacute;rio cadastrado!";
    }
	echo json_encode($result);
    exit;
}

if($acao == "Participar"){
	$contrato = file_get_contents("../view/contrato.html");
	$contrato = str_replace("{local_evento}",$local, $contrato);
	$contrato = str_replace("{endereco_evento}",htmlentities($endere), $contrato);
	$contrato = str_replace("{valor}",number_format($valor,2,",","."), $contrato);
	$contrato = str_replace("{valor_por_extenso}",$valorpext, $contrato);
	$contrato = str_replace("{valor_parcela}",number_format($valor/2,2,",","."), $contrato);
	$contrato = str_replace("{data_pg_1}",$eve_data1, $contrato);
	$contrato = str_replace("{data_pg_2}",$eve_data2, $contrato);
	$contrato = str_replace("{data_por_extenso}",$func->mes_extenso(date("d/m/Y")), $contrato);
	$contrato = str_replace("{data_do_evento}",$func->data_br($dataeve)." e ".$func->data_br($dataate), $contrato);
	$contrato = str_replace("{Nome_Fantasia}",$nome, $contrato);
	$contrato = str_replace("{CNPJ}",$cnpj, $contrato);
	$contrato = str_replace("{Responsavel}",$resp, $contrato);
	
	echo $contrato;
	
	
	//echo json_encode($result);
    exit;
}

if ($acao == "consulta") {
    if(!empty($eve_data)){
		list($dt_ini, $dt_fin) = split("-",$eve_data);
        $sql = "SELECT * FROM eventos WHERE eve_data BETWEEN '" . $func->data_usa(trim($dt_ini)) . " 'AND '" .$func->data_usa(trim($dt_fin)). "'";
		$sql.= "ORDER BY eve_data ASC";
    }
    $rs_eve->FreeSQL($sql);
    $tbl = "";
    if ($rs_eve->linhas == 0) {
        $result['status'] = 0;
        $result['query'] = $sql;
        $result['mensagem'] = $dt_fin;
		
    } else {
		$result['query'] = $sql;
        /* Insere o evento na linha do tempo */
        //$rs_eve->add_hist(10); // pesquisa de evento
        /* Fim Linha do Tempo */
        $result['status'] = 1;
        while ($rs_eve->GeraDados()) {
            $tbl.= "
			<tr>
				<td>" . $func->data_br($rs_eve->fld("eve_data")) . "</td>
				<td>" . $rs_eve->fld("eve_local") . "</td>
				<td>R$" . number_format($rs_eve->fld("eve_valor"),2,",",".") . "</td>
				<td>R$" . number_format(( $rs_eve->fld("eve_valor")/2 ),2,",",".") . "</td>
				<td>
					<div class='btn-group'>
						<a href='../view/visual_eve.php?evento=" . $rs_eve->fld("eve_id") . "&cnpj=" . $rs_eve->fld("eve_empresa") . "&token=" . $_SESSION['token'] . "' class='btn btn-xs btn-info' data-toggle='tooltip' data-placement='bottom' title='Visualizar'><i class='fa fa-eye'></i> </a>
					</div>
				</td>
			</tr>";
        }
        $tbl = str_replace("\t", "", $tbl);
        $tbl = str_replace("\r", "", $tbl);
        $tbl = str_replace("\n", "", $tbl);
        $tbl = stripslashes($tbl);
        $result['mensagem'] = ltrim(rtrim(trim($tbl)));
    }
    echo json_encode($result);
    exit;
}