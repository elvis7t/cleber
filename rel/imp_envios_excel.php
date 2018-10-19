<!DOCTYPE html>
<html>
  <head>
  <?php
	date_default_timezone_set('America/Sao_Paulo'); 
	session_start("portal");
	$hosted = "http://www.triangulocontabil.com.br";
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
$arquivo = 'relatorio_envios.xls';

require_once("../class/class.functions.php");

	$rs_rel = new recordset();
	$rs		= new recordset();
	$func 	= new functions();
	/*echo "<pre>";
	print_r($_GET);
	echo "</pre>";*/
	extract($_GET);
	$tbl ='';
	//$link = "rel_print.php?tabela=".$tabela."&di=".$di."&df=".$df."&nome=".$atend;
	$sql = "SELECT  a.ob_cod,
					a.ob_titulo,
					b.imp_nome, 
					c.apelido
			FROM obrigacoes a 
				LEFT JOIN tipos_impostos b 		ON a.ob_titulo=b.imp_id
				LEFT JOIN tri_clientes c 		ON a.ob_cod = c.cod
			WHERE ob_ativo=1";
	$filtro = "";
	
	if(isset($dep) AND $dep<>""){
		$sql.=" AND imp_depto = ".$dep;
		$filtro.= "Departamento: ".$dep."<br>";
	}
	if(isset($colab) AND $colab<>""){
		$cond = '"user":"'.$colab.'"';
		$sql.= " AND carteira LIKE '%".$cond."%'";
		$filtro.= "Colaborador: ".$colab."<br>";
	}
	if(isset($emp) AND $emp<>""){
		$sql.=" AND ob_cod = ".$emp;
		$filtro.= "Empresa: ".$emp."<br>";
	}

	if(isset($mov) AND $mov<>""){

	}
	if(isset($ger) AND $ger<>""){

	}
	if(isset($conf) AND $conf<>""){

	}
	if(isset($env ) AND $env <>""){

	}
	if(isset($tipo) AND $tipo<>""){

	}
	if(isset($trib) AND $trib<>""){
		$sql.=" AND tribut = '".$trib."'";
		$filtro.= "Tributação: ".$trib."<br>";
	}

	if(isset($tipo) AND $tipo<>""){
		$sql.=" AND imp_id=".$tipo;
		$filtro.= "Tipo: ".$tipo."<br>";
	}
	
	$sql.=" GROUP BY ob_cod, imp_nome ORDER BY ob_cod, imp_nome";
	
	//echo $sql;
	$rs_rel->FreeSql($sql);
	//echo "<!--".$rs_rel->sql."-->";
	$empresa = "";
	while($rs_rel->GeraDados()):

		if($empresa <> $rs_rel->fld("ob_cod")){ 
			$empresa =$rs_rel->fld("ob_cod");  
			$tbl.='
			<tr class="success">
				<th colspan=1>'.$rs_rel->fld("ob_cod").'</td>
				<th colspan=10>'.$rs_rel->fld("apelido").'</td>
			</tr>
			';
		
		}
		
		if(isset($comp) AND $comp<>""){
			$sql1="SELECT *, 
				e.usu_nome as NomeUsuMov, 
				f.usu_nome as GeradoUser, 
				g.usu_nome as ConfNome, 
				h.usu_nome as EnvNome
			 FROM impostos_enviados d 
				LEFT JOIN usuarios e 			ON d.env_movuser = e.usu_cod
				LEFT JOIN usuarios f 			ON d.env_geradouser = f.usu_cod
				LEFT JOIN usuarios g 			ON d.env_conferidouser = g.usu_cod
				LEFT JOIN usuarios h			ON d.env_user = h.usu_cod
			WHERE env_codImp = {$rs_rel->fld("ob_titulo")}  AND env_codEmp = {$rs_rel->fld("ob_cod")} AND env_compet = '".$comp."'";
			$rs->FreeSql($sql1);
			if($rs->linhas==0){ 
				$tbl.='
				<tr>
					<td>'.$rs_rel->fld("imp_nome").'</td>
					<td>'.$comp.'</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>				
				</tr>
				';
	
			}
			else{
				$rs->GeraDados();
				$d = new DateTime($rs->fld("env_movdata"));
				$f = new DateTime($rs->fld("env_data"));
				$diff = $func->horasUteis($d,$f);
				$mtempo = sprintf("%02d", $diff['h']).":".sprintf("%02d", $diff['m']);
				$tbl.='

				<tr>
					<td>'.$rs_rel->fld("imp_nome").'</td>
					<td>'.$rs->fld("env_compet").'</td>
					<td>'.($rs->fld("env_mov")==1?"Sim":"Não").'</td>
					<td>'.($rs->fld("NomeUsuMov")=="NULL"?"":$rs->fld("NomeUsuMov")).'</td>
					<td>'.($rs->fld("env_mov")=="NULL"?"":$func->data_mbr($rs->fld("env_movdata"))).'</td>

					<td>'.(($rs->fld("GeradoUser")=="NULL" AND $rs->fld("env_gerado")==0)?"":$rs->fld("GeradoUser")).'</td>
					<td>'.(($rs->fld("env_gerado")=="" AND $rs->fld("env_gerado")==0)?"":$func->data_mbr($rs->fld("env_geradodata"))).'</td>

					<td>'.(($rs->fld("ConfNome")=="NULL" AND $rs->fld("env_conferido")==0)?"":$rs->fld("ConfNome")).'</td>
					<td>'.(($rs->fld("env_conferido")=="" AND $rs->fld("env_conferido")==0)?"":$func->data_mbr($rs->fld("env_conferidodata"))).'</td>

					<td>'.(($rs->fld("EnvNome")=="NULL" AND $rs->fld("env_enviado")==0)?"":$rs->fld("EnvNome")).'</td>
					<td>'.(($rs->fld("env_enviado")=="" AND $rs->fld("env_enviado")==0)?"":$func->data_mbr($rs->fld("env_data"))).'</td>

					<td>'.(($rs->fld("env_enviado")=="" AND $rs->fld("env_enviado")==0)?"":$mtempo).'</td>
					
				</tr>
			';
			}
		}
		endwhile;
	$filtro.= ($comp<>""?"Competência: ".$comp."<br>":"");
	$tbl.="<tr><td colspan=4><strong>".$rs_rel->linhas." Registros</strong></td></tr>";
	$tbl.="<tr><td colspan=4><address>".$filtro."</address></td></tr>";
	


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
								 <tr><th colspan=4><h2>Relat&oacute;rio de Envio de Impostos</h2></th></tr>
								  <tr>
									<th>Imposto</th>
									<th>Compet.</th>
									<th>Mov</th>
									<th>Mov criado por</th>
									<th>Mov criado em</th>
									<th>Ger. por</th>
									<th>Ger. em</th>
									<th>Conf. por</th>
									<th>Conf. em</th>
									<th>Env. por</th>
									<th>Env. em</th>
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