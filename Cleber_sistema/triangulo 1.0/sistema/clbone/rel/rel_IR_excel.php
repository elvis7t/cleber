<!DOCTYPE html>
<html>
  <head>
  <?php
	date_default_timezone_set('America/Sao_Paulo'); 
	session_start();
	$hosted = "http://192.168.0.104:8080/web";
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
$arquivo = 'relatorio.xls';
//require_once("../config/main.php");
require_once("../../model/recordset.php");
require_once("../../sistema/class/class.functions.php");
$rs_rel = new recordset();
$rs		= new recordset();
$func = new functions();

extract($_GET);

	$sql = "SELECT * FROM irrf a
				JOIN empresas b 
					ON a.ir_cli_id = b.emp_codigo
				LEFT JOIN contatos c 
					ON b.emp_cnpj = c.con_cli_cnpj
				LEFT JOIN codstatus d 
					ON a.ir_status = d.st_codstatus
				JOIN usuarios e
					ON a.ir_ult_user = e.usu_cod
				LEFT JOIN irpf_recibo f
					ON a.ir_reciboId = f.irec_id
				LEFT JOIN irrf_historico g
					ON a.ir_Id = g.irh_ir_id
				";
	/*--|alteração - Cleber Marrara 25/02/2016|
		|adequação de variaveis para reutilização do programa em relatórios|
	*/
	$filtro = "";
	$rel = 0;
	//print_r($_GET);
	$rel = 1;
	$sql.= "WHERE ir_status<>90";
	if($di !=""){ 
		$sql.=" AND ir_dataent >= '".$func->data_usa($di)."'"; 
		$filtro .= "Data Inicial = ".$di."<br>";
	}
	if($df !=""){ 
		$sql.=" AND ir_dataent <= '".$func->data_usa($df)." 23:59:59'"; 
		$filtro .= "Data final = ".$df."<br>";
	}
	if($status !=""){ 
		$sql.=" AND ir_status = '".$status."'"; 
		$filtro .= "Status = ".$status."<br>";
		}
	if($periodo !=""){ 
		$sql.=" AND ir_ano = '".$periodo."'"; 
		$filtro .= "Periodo = ".$periodo."<br>";
		}
	if($vlde !=""){ 
		$sql.=" AND ir_valor >= '".$vlde."'"; 
		$filtro .= "Valor Min. = ".$vlde."<br>";
		}
	if($vate !=""){ 
		$sql.=" AND ir_valor <= '".$ate."'"; 
		$filtro .= "Valor Max. = ".$vate."<br>";
		}
	if($pago !=""){ 
		$sql.=" AND irec_pago = ".$pago; 
		$filtro .= "Valor Max. = ".$vate."<br>";
		}
	if($altera !=""){ 
		$sql.=" AND ir_ult_user = '".$altera."'"; 
		$filtro .= "Ult Alt. por = ".$altera."<br>";
		}


	$sql.=" GROUP BY ir_Id ORDER BY emp_razao ASC";
	$rs_rel->FreeSql($sql);
	/*echo $rs_rel->sql;*/
	$trtbl = "";
	while($rs_rel->GeraDados()):
	$sql2 = "SELECT ir_valor FROM irrf 
				WHERE ir_cli_id = ".$rs_rel->fld('ir_cli_id')." 
				AND ir_tipo = '".$rs_rel->fld("ir_tipo")."' 
				AND ir_ano = ".($rs_rel->fld("ir_ano")-1);
	$rs1 = new recordset();
	$rs1->FreeSql($sql2);
	$rs1->GeraDados();
	$trtbl .= '
	<tr>
		<td>'.$rs_rel->fld("ir_tipo").'</td>
		<td>'.$rs_rel->fld("emp_cnpj").'</td>
		<td><p class="text-uppercase">'.$rs_rel->fld("emp_razao").'</p></td>
		<td>'.$rs_rel->fld("ir_ano").'</td>
		<td>'.($rs1->linhas <> 0 ? number_format($rs1->fld("ir_valor"),2,",","."):"").'</td>
		<td>'.number_format($rs_rel->fld("ir_valor"),2,",",".").'</td>
		<td>'.number_format($rs_rel->fld("irec_valor"),2,",",".").'</td>
		<td></td>
		<td>'.$func->data_hbr($rs_rel->fld("ir_dataent")).'</td>
		<td>'.$rs_rel->fld("st_desc").'</td>
		<td>'.$rs_rel->fld("usu_nome").'</td>
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
								<tr><th colspan=7><h2>Relat&oacute;rio de Declara&ccedil;&otilde;es IRPF</h2></th></tr>
								  <tr>
									<th>Tipo</th>
									<th>Doc.</th>
									<th>Nome</th>
									<th>Periodo</th>
									<th>Valor Anterior</th>
									<th>Valor Atual</th>
									<th>Valor Pago</th>
									<th>% Desc</th>
									<th>Entrada</th>
									<th>Status</th>
									<th>&Uacute;lt. Altera&ccedil;&atilde;o</th>
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