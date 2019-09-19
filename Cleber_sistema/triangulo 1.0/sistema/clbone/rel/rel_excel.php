<?php
/*
* Criando e exportando planilhas do Excel
* Cleber Marrara - 06/01/2016
* Versão 1.0 - cleber.marrara.prado@gmail.com
*/
// Definimos o nome do arquivo que será exportado
$arquivo = 'relatorio.xls';
require_once("../config/main.php");
require_once("../../model/recordset.php");
require_once("../../sistema/class/class.functions.php");
$rs_rel = new recordset();
$rs		= new recordset();
$func = new functions();

extract($_GET);
	if($tabela == "tri_solic"){
		$tblsel = "Solicita&ccedil;&otilde;es";
		$campo = "sol_data";
	}
	else{
		$tblsel = "Liga&ccedil;&otilde;es";
		$campo = "sol_datareal";
	}
	$link = "rel_print.php?tabela=".$tabela."&di=".$di."&df=".$df."&nome=".$atend;
	$sql = "SELECT * FROM ".$tabela." 
				LEFT JOIN usuarios a ON a.usu_cod = sol_real_por
				WHERE sol_cod<>0 AND sol_status IN(0,99)";
	$filtro = "Tabela: ".$tblsel."<br>";
	if(isset($di) AND $di<>""){
		$sql.=" AND ".$campo." >='".$func->data_usa($di)." 00:00:00'";
		$filtro.= "Data Inicial: ".$di."<br>";
	}
	if(isset($df) AND $df<>""){
		$sql.=" AND ".$campo." <='".$func->data_usa($df)." 23:59:59'";
		$filtro.= "Data Final: ".$df."<br>";
	}
	if(isset($atend) AND $atend<>""){
		$sql.=" AND sol_real_por =".$atend;
		$filtro.= "Atendente (Cód): ".$atend;
	}
	if(isset($solic) AND $solic<>""){
		$sql.=($tabela == "tri_solic" ? " AND sol_por =".$solic : " AND sol_fcom like '%".$solic."%'");
		$filtro.= "<br>Solicitante (Cód): ".$solic;
	}
	if(isset($pres) AND $pres<>"" AND $tabela=="tri_ligac"){
		$sql.=" AND sol_pres =".$pres;
		$filtro.= "<br>Presencial?: ".($pres==1?"Sim":"N&atildeo");
	}
	
	$sql.=" ORDER BY sol_data";
	
	
	
	
	$rs_rel->FreeSql($sql);
	/*echo $rs_rel->sql;*/
	$trtbl = "";
	while($rs_rel->GeraDados()):
	$trtbl .= '
	<tr>
		<td>'.$rs_rel->fld("sol_emp").'</td>
		<td>'.$rs_rel->fld("sol_tel").'</td>
		<td>'.($tabela == "tri_solic" ? $rs_rel->fld("sol_cont"): $rs_rel->fld("sol_fcom")).'</td>
		<td>'.$rs->pegar("usu_nome","usuarios","usu_cod=".$rs_rel->fld("sol_por")).'</td>
		<td>'.$rs_rel->fld("usu_nome").'</td>
		<td>'.$func->data_hbr($rs_rel->fld("sol_datareal")).'</td>
		<td>'.$rs_rel->fld("sol_obs").'</td>
	</tr>';
	endwhile;
	$trtbl.="<tr><td><strong>".$rs_rel->linhas." Registros</strong></td></tr>";
	$trtbl.="<tr><td><address>".$filtro."</address></td></tr>";

// Criamos uma tabela HTML com o formato da planilha
$html = '
			<section class="invoice">
				<!-- title row -->
				<div class="row">
				  <div class="col-xs-12">
					<h2 class="page-header">
						<i class="fa fa-globe"></i>'.$rs_rel->pegar("emp_nome","empresas","emp_cnpj = '".$_SESSION['usu_empresa']."'").'
						<small class="pull-right">Data: '.date("d/m/Y").'</small>
					</h2>
				  </div><!-- /.col -->
				</div>
				<!-- info row -->
				<div class="row invoice-info">
					<div class="col-sm-4 invoice-col">
						Usu&aacute;rio
						<address>
							<strong>'.$_SESSION['nome_usu'].'</strong><br>
							<i class="fa fa-envelope"></i> '.$_SESSION['usuario'].'
						</address>
					</div><!-- /.col -->
				</div><!-- /.row -->

				<!-- Table row -->
				<div class="row">
					<div class="col-xs-12 table-responsive">
						<table class="table table-striped">
							<thead>
								<tr><th colspan=7><h2>Relat&oacute;rio de Liga&ccedil;&otilde;es</h2></th></tr>
								<tr>
									<th>Empresa</th>
									<th>Telefone</th>
									<th>Falar com</th>
									<th>Solicitante</th>
									<th>Realizado por</th>
									<th>Hor&aacute;rio</th>
									<th>Obs.:</th>
								</tr>
							</thead>
							<tbody id="rls">
								'.$trtbl.'
							</tbody>
						</table>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</section><!-- /.content -->
';

// Configurações header para forçar o download
header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/x-msexcel");
header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
header ("Content-Description: PHP Generated Data" );
// Envia o conteúdo do arquivo
echo $html;
exit;