<?php

/*----|CALCULO DO DARF UTILIZANDO TAXA SELIC|----*/
date_default_timezone_set('America/Sao_Paulo');
session_start();
require_once("../model/recordset.php");
require_once("../class/class.functions.php");

$rs_selic = new recordset();
$rs_darf = new recordset();
$fn = new functions();
$sql = "SELECT * FROM irpf_cotas a
			JOIN irrf b ON a.icot_ir_id = b.ir_Id
			JOIN empresas c ON b.ir_cli_id = c.emp_codigo
			LEFT JOIN contatos d ON c.emp_codigo = d.con_cli_cnpj 
			WHERE icot_id = ".$_GET['irret'];
$rs_darf->FreeSql($sql);
$rs_darf->GeraDados();
/*
echo $rs_darf->sql;
echo $rs_darf->fld("icot_id")."<br>";
echo $rs_darf->fld("icot_parc")."<br>";
echo $rs_darf->fld("icot_ref")."<br>";
echo $rs_darf->fld("icot_valor")."<br>";
*/
list($mes,$ano) = explode("/", $rs_darf->fld("icot_ref"));
//$mes--;
$ref_selic = $ano."-".str_pad($mes, 2,"0",STR_PAD_LEFT);
$valor = $rs_darf->fld("icot_valor");
$sql = "SELECT isel_taxa FROM irpf_selic WHERE isel_ref BETWEEN '".$ano."-05' AND '".$ref_selic."'";
//echo $sql;
$rs_selic->FreeSql($sql);
//echo $rs_selic->sql."<br>";
$tselic = 0;
$ano--;
while($rs_selic->GeraDados()){
	$tselic += $rs_selic->fld("isel_taxa");
}

$nv = 0;
$jur = 0;
echo $tselic."<br>";
if($rs_darf->fld("icot_parc")>1){
	$jur = ($valor*$tselic/100);
	$nv = $valor +($valor*$tselic/100);
}
else{
	$nv = $valor;
}
/*
echo $ref_selic;
*/
$html = file_get_contents("layout_darf.html");
$html = str_replace("{pasta_ar}", "http://localhost/www/sistema/view/layout_darf_files", $html);

$html = str_replace("{NOME}", $rs_darf->fld("emp_razao"), $html);
$html = str_replace("{TELEFONE}", $rs_darf->fld("con_contato"), $html);
$html = str_replace("{CPF}", $rs_darf->fld("emp_cnpj"), $html);
$html = str_replace("{REFERENCIA}", "", $html);
$html = str_replace("{QUOTA_PARCELA}", "Parcela ".$rs_darf->fld("icot_parc"), $html);
$html = str_replace("{PERIODO_APURA}", "31/12/".$ano, $html);
$html = str_replace("{CODIGO_REC}", "0211", $html);
$html = str_replace("{VENCIMENTO}", $fn->ultimo_dia_mes($rs_darf->fld("icot_ref")), $html);
$html = str_replace("{VALOR_PARCELA}", "R$".number_format($rs_darf->fld("icot_valor"),2,",","."), $html);
$html = str_replace("{VALOR_MULTA}", "R$0,00", $html);
$html = str_replace("{VALOR_SELIC}", "R$".number_format($jur,2,",","."), $html);
$html = str_replace("{VALOR_TOTAL}", "R$".number_format($nv,2,",","."), $html);

echo $html;

$rs_darf->FreeSql("UPDATE irpf_cotas SET icot_print='Y', icot_quem='".$_SESSION['usu_cod']."', icot_datas='".date("Y-m-d H:i:s")."' WHERE icot_id=".$_GET['irret']);

?>