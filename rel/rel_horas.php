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
$arquivo = 'controle_horas.xls';
//require_once("../config/main.php");
require_once("../../model/recordset.php");
require_once("../../sistema/class/class.functions.php");
$rs_rel = new recordset();
$rs		= new recordset();
$func = new functions();

extract($_GET);

	$sql = "SELECT a.*, b.usu_nome nome_colab, c.usu_nome nome_cad, e.usu_nome nome_aprov, st_desc 
			FROM controle_horas a
				JOIN usuarios b ON a.ch_colab = b.usu_cod
				JOIN usuarios c ON a.ch_usucad = c.usu_cod
				LEFT JOIN usuarios e ON a.ch_aprovadopor = e.usu_cod
				JOIN codstatus d ON a.ch_status = d.st_codstatus";
	/*--|alteração - Cleber Marrara 25/02/2016|
		|adequação de variaveis para reutilização do programa em relatórios|
	*/
	$filtro = "";
	$rel = 0;
	//print_r($_GET);
	$rel = 1;
	if($_SESSION['classe']<=3){
		$sql.=" WHERE 1";
	}else{
		if($_SESSION['lider']=='Y'){$sql.=" WHERE b.usu_dep=".$_SESSION['dep'];}
		else{$sql.=" WHERE ch_colab=".$_SESSION['usu_cod'];}
	}
	if($func->is_set($_GET['chr_dep'])){$sql.=" AND b.usu_dep =".$_GET['chr_dep'];}
	if($func->is_set($_GET['chr_nome'])){$sql.=" AND b.usu_nome like '%".$_GET['chr_nome']."%'";}
	if($func->is_set($_GET['chr_data'])){$sql.=" AND ch_data >= '".$func->data_usa($_GET['chr_data'])."'";}
	if($func->is_set($_GET['chr_dataf'])){$sql.=" AND ch_data <= '".$func->data_usa($_GET['chr_dataf'])."'";}
	$sql.=" ORDER BY b.usu_dep ASC, ch_colab ASC, ch_data ASC";

	$rs_rel->FreeSql($sql);

	//echo $rs_rel->sql;
	$trtbl = "";
	while($rs_rel->GeraDados()):
	$dia = $func->DiaDaSemana($rs_rel->fld("ch_data"));
	$num = ($func->hora_decimal($rs_rel->fld("ch_hora_saida"))-($dia==6 ? 540 : 1020))/60;
	$trtbl .= '
	<tr>
		<td>'.$rs_rel->fld("nome_colab").'</td>
		<td>'.$func->data_br($rs_rel->fld("ch_data")).'</td>
		<td>'.$rs_rel->fld("ch_hora_entrada").'</td>
		<td>'.$rs_rel->fld("ch_hora_saida").'</td>
		<td>'.number_format($num,2,",",".").'</td>
		<td>'.$rs_rel->fld("st_desc").'</td>
		<td>'.$rs_rel->fld("nome_cad").'</td>
		<td>'.$func->data_hbr($rs_rel->fld("ch_horacad")).'</td>
		<td>'.$rs_rel->fld("nome_aprov").'</td
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
								<tr><th colspan=7><h2>Relat&oacute;rio de Horas</h2></th></tr>
								  <tr>
									<th>Colaborador</th>
									<th>Data</th>
									<th>Entrada</th>
									<th>Sa&iacute;da</th>
									<th>Banco</th>
									<th>Status</th>
									<th>Lanc.</th>
									<th>Dt Lanc.</th>
									<th>Aprov.</th>
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