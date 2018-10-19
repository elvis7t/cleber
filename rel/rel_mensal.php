<!DOCTYPE html>
<html>
  <head>
  <?php
	date_default_timezone_set('America/Sao_Paulo'); 
	session_start();
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
$arquivo = 'relatorio.xls';
//require_once("../config/main.php");
require_once("../../sistema/class/class.functions.php");
require_once("../class/class.permissoes.php");
if(!isset($_SESSION)){session_start();}
$rs_eve = new recordset();
$rs1 = new recordset();
$rs2 = new recordset();
$rs_rel = new recordset();

//$hist = new historico();
$fn = new functions();
$per = new permissoes();
//$resul = array();
extract($_GET);
$con = $per->getPermissao("ver_impostos", $_SESSION['usu_cod']);
	$sql = "SELECT cod, empresa, apelido, tribut FROM tri_clientes a
				LEFT JOIN obrigacoes b ON a.cod = b.ob_cod
			WHERE emp_vinculo = ".$_SESSION['usu_empcod']."
			AND a.ativo=1";
	if(isset($empre) AND $empre<>""){
		$sql.= " AND cod = ".$empre;
	}
	if(isset($usua) AND $usua<>""){
		$usr = explode(",", $usua);
		for($i=0; $i<sizeof($usr);$i++){
			$sql.= ($i==0?" AND (":" OR "). "carteira LIKE '%\"user\":\"".$usr[$i]."\"%'";
		}
		$sql.=")";
	}
	if(isset($impos) AND $impos<>""){
		$sql.= " AND ob_titulo = ".$impos." AND ob_ativo=1";
	}
	else{
		$sql.= " AND ob_titulo = 140 AND ob_ativo=1";	
	}


	$sql.=" GROUP BY a.cod ORDER BY cod ASC";
	$tbl = "";
	$rs_eve->FreeSql($sql);
	//echo $sql;
	$filter = '';
	
	if($rs_eve->linhas>0){
		$ano = date("Y");
		while($rs_eve->GeraDados()){
		$tbl .= "
			<tr>
				<td>".$rs_eve->fld("cod")." </td>
				<td>".$rs_eve->fld("apelido")."</td>
				<td>".$rs_eve->fld("tribut")."</td>";
			
			for($i=1; $i<=12; $i++){
				$sql2 = "SELECT env_data, env_enviado, env_user FROM impostos_enviados a
							JOIN usuarios b ON a.env_user = b.usu_cod
						WHERE env_codEmp = ".$rs_eve->fld("cod");

				
				if(isset($impos) AND $impos<>""){
					$sql2.= " AND env_codImp = ".$impos;
					$filter = "<tr><td>Imposto: ".$rs_rel->pegar("imp_nome","tipos_impostos","imp_id=".$impos)."</td></tr>";
				}
				else{
					$sql2.= " AND env_codImp = 140";
					$filter = "<tr><td>Imposto: BALANCETE</td></tr>";
				}

				if(isset($compet) AND $compet<>""){
					$sql2.= " AND env_compet = '".str_pad($i,2,"0",STR_PAD_LEFT)."/".$compet."'";
				}
				else{
					$sql2.= " AND env_compet = '".str_pad($i,2,"0",STR_PAD_LEFT)."/".$ano."'";
				}
				$sql2.=" AND env_enviado=1";
				$rs2->FreeSql($sql2);
				$rs2->GeraDados();
				
				$tbl.="
				<td align='center' class='".($rs2->linhas==1?"success":"danger")."'>
					<span data-toggle='tooltip'>".($rs2->linhas==1?"OK":"-")."</span>
				</td>";
			}
		}
	$tbl.="<tr>";
	}
	else{
	$tbl.="
		<tr>
			<td colspan=5>Tudo conferido!</td>
		</tr>";
	
	}
	if(isset($usua) AND $usua<>""){
		$usr = explode(",", $usua);
		for($i=0; $i<sizeof($usr);$i++){
			$filter .= "<tr><td>Colaborador: ".$rs_rel->pegar("usu_nome","usuarios","usu_cod=".$usr[$i])."</td></tr>";
		}
	}
	$tbl.=$filter;

// Criamos uma tabela HTML com o formato da planilha
$html = '
			<section class="invoice">
				<!-- title row -->
				<div class="row">
				  <div class="col-xs-12">
				  	<img src="'.$hosted.'/images/tri_Origem_FULL_H.png" width="10%">
					<h2 class="page-header">
						'.$rs_rel->pegar("emp_nome","empresas","emp_cnpj = '".$_SESSION['usu_empresa']."'").'
					</h2>
					<small class="pull-right">Data: '.date("d/m/Y").'</small>
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
								<tr><th colspan=7><h2>Produtividade Mensal</h2></th></tr>
								<tr>
									<th>#</th>
									<th>Empresa</th>
									<th>Trib.</th>
						    		<th>Jan</th>
						            <th>Fev</th>
						    		<th>Mar</th>
						    		<th>Abr</th>
						    		<th>Mai</th>
						    		<th>Jun</th>
						            <th>Jul</th>
						            <th>Ago</th>
						            <th>Set</th>
						            <th>Out</th>
						            <th>Nov</th>
						            <th>Dez</th>
								</tr>
							</thead>
							<tbody id="rls">
								'.$tbl.'
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