<?php

require_once('../../model/recordset.php');
require_once('../../sistema/class/class.historico.php');
require_once('../class/class.functions.php');
require_once("../../class/PHPMailer/class.phpmailer.php");
require_once("../../sistema/mpdf60/mpdf.php");

/*|PREPARANDO O CORPO DO E-MAIL COM OS DADOS DO DARF|*/
$fn = new functions();
$rs_selic = new recordset();
$rs_darf = new recordset();
$sql = "SELECT * FROM irpf_cotas a
			JOIN irrf b ON a.icot_ir_id = b.ir_Id
			JOIN empresas c ON b.ir_cli_id = c.emp_codigo
			LEFT JOIN contatos d ON c.emp_codigo = d.con_cli_cnpj 
			WHERE icot_id = ".$_GET['icotid'];
$rs_darf->FreeSql($sql);
$rs_darf->GeraDados();

list($mes,$ano) = explode("/", $rs_darf->fld("icot_ref"));
$mes--;
$ref_selic = str_pad($mes, 2,"0",STR_PAD_LEFT)."/".$ano;
$valor = $rs_darf->fld("icot_valor");
$sql = "SELECT isel_taxa FROM irpf_selic WHERE isel_ref BETWEEN '05/".$ano."' AND '".$ref_selic."'";
$rs_selic->FreeSql($sql);
//echo $rs_selic->sql."<br>";
$tselic = 0;
$ano--;
while($rs_selic->GeraDados()){
	$tselic += $rs_selic->fld("isel_taxa");
}

$nv = 0;
$jur = 0;
//echo $tselic."<br>";
if($rs_darf->fld("icot_parc")>1){
	$jur = ($valor*$tselic/100)+($valor*1/100);
	$nv = $valor +($valor*$tselic/100)+($valor*1/100);
}
else{
	$nv = $valor;
}

$html = file_get_contents("../view/layout_darf.html");

$html = str_replace("{pasta_ar}", "http://192.168.0.104:8080/web/triangulo/view/layout_darf_files", $html);
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


$mpdf=new mPDF();
$mpdf->WriteHTML($html,0);	
$mpdf->Output("carne.pdf", "D");

echo $html;