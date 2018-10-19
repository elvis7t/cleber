<!DOCTYPE html>
<html>
  <head>
  <?php
	date_default_timezone_set('America/Sao_Paulo'); 
	session_start("portal");
	$hosted = "http://www.triangulocontabil.com.br/web";
	?>
  
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Triângulo</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?=$hosted;?>/sistema/assets/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?=$hosted;?>/sistema/assets/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?=$hosted;?>/sistema/assets/dist/css/skins/_all-skins.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?=$hosted;?>/sistema/assets/plugins/iCheck/flat/blue.css">
    <link rel="stylesheet" href="<?=$hosted;?>/sistema/assets/plugins/iCheck/all.css">
    <!-- Morris chart -->
    <link rel="stylesheet" href="<?=$hosted;?>/sistema/assets/plugins/morris/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="<?=$hosted;?>/sistema/assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="<?=$hosted;?>/sistema/assets/plugins/datepicker/datepicker3.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="<?=$hosted;?>/sistema/assets/plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="<?=$hosted;?>/sistema/assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
	<!-- SELECT 2-->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

<?php

/*
* Criando e exportando planilhas do Excel
* Cleber Marrara - 06/01/2016
* Versão 1.0 - cleber.marrara.prado@gmail.com
*/
// Definimos o nome do arquivo que será exportado
$arquivo = 'recalculos.xls';
require_once("../../model/recordset.php");
require_once("../../sistema/class/class.functions.php");
require_once("../class/class.permissoes.php");
$rs_rel = new recordset();
$rs		= new recordset();
$fn = new functions();
$per = new permissoes();
$con = $per->getPermissao("recalc_vertodos", $_SESSION['usu_cod']);
$_hide = ($con['I']==0?"hide":"");


	$sql = "SELECT m.*, a.calc_desc, b.cod, b.apelido, c.usu_nome AS solic, d.usu_nome as efet, e.st_desc, e.st_icone
			FROM recalculos m
				JOIN tipos_calc a ON m.rec_doc = a.calc_id 
				JOIN tri_clientes b ON m.rec_cli = b.cod
				LEFT JOIN usuarios c ON m.rec_user = c.usu_cod
				LEFT JOIN usuarios d ON m.rec_usuSol = d.usu_cod
				JOIN codstatus e ON m.rec_status = e.st_codstatus
				WHERE 1";
				
	$sql.=" AND rec_status<>90";
	
	if($con['C']==0){
		$sql.=" AND rec_user = ".$_SESSION['usu_cod'];
	}
	else{
		$sql.=" AND rec_id<>0";
	}
	
	if(isset($_GET['emp']) && $_GET['emp']<>0 ){
		$sql.=" AND rec_cli = ".$_GET['emp'];
	}

	if(isset($_GET['di']) && $_GET['di']<>0 ){
		$sql.=" AND rec_data >= '".$fn->data_usa($_GET['di'])." 00:00:00'";
	}
	

	if(isset($_GET['df']) && $_GET['df']<>0 ){
		$sql.=" AND rec_data <='".$fn->data_usa($_GET['df'])." 23:59:59'";
	}

	if(isset($_GET['col']) && $_GET['col']<>0){
		$sql.=" AND rec_user =".$_GET['col'];
	}
	if(isset($_GET['status']) && $_GET['status']<>0){
		$sql.=" AND rec_status =".$_GET['status'];
	}

	$sql .=" ORDER BY rec_data DESC, rec_id ASC";



	//echo $sql;
	$rs->FreeSql($sql);
		$trtbl = "";

	if($rs->linhas==0):
	echo "<tr><td colspan=9> Nenhum calculo solicitado</td></tr>";
	else:
		$soma = 0;
		$valor = 0;
		while($rs->GeraDados()){ 
			$valor = $rs->fld("rec_qtd")*$rs->fld("rec_val");
			$soma += ($rs->fld("rec_status")==90?0:$valor);
			$trtbl .= '
			<tr>
				<td>'.$rs->fld("cod").'</td>
				<td>'.$rs->fld("apelido").'</td>
				<td>'.$fn->data_hbr($rs->fld("rec_data")).'</td>
				<td class="hidden-xs">'.$rs->fld("calc_desc").'</td>
				<td class="hidden-xs">'.$rs->fld("solic").'</td>
				<td class="hidden-xs">'.$rs->fld("rec_qtd").'</td>
				<td class="hidden-xs">'."R$".number_format($rs->fld("rec_val"),2,",",".").'</td>
				<td>'."R$".number_format($valor,2,",",".").'</td>
				<td class="hidden-xs">'.$rs->fld("efet").'</td>
				<td>'.$rs->fld("st_desc").'</td>
			</tr>
		';
		}
	$trtbl.= "<tr><td colspan=3 align='right'><strong>Total:</strong></td><td colspan=4><strong>R$".number_format($soma,2,",",".")."</strong></td></tr>";
	$trtbl.= "<tr><td colspan=12><strong>".$rs->linhas." calculos Solicitados</strong></td></tr>";
	
endif;
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
				<table class="table table-striped table-condensed">
					<thead>
						<tr>
							<th>#</th>
							<th>Empresa</th>
							<th>Data</th>
							<th class="hidden-xs">Tipo Calc</th>
							<th class="hidden-xs">Solicitado Por</th>
							<th class="hidden-xs">Qtd</th>
							<th class="hidden-xs>">Valor Un.</th>
							<th>Valor total</th>
							<th class="hidden-xs">Realizado Por</th>
							<th>Status</th>
							<th>A&ccedil;&otilde;es</th>
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