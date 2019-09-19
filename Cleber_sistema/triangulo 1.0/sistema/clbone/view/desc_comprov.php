<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start();
require_once("../config/main.php");
require_once("../../model/recordset.php");
require_once("../../sistema/class/class.functions.php");
$rs_rel = new recordset();
$fn = new functions();

?>
	<body onload="window.print();">
	
		<div class="wrapper">
			<!-- Main content -->
			<section class="invoice">
				<!-- title row -->
				<div class="row">
				  <div class="col-xs-12">
					<h3 class="page-header">
						<img src="<?=$hosted."/".$rs_rel->pegar("emp_logo","empresas","emp_cnpj = '".$_SESSION['usu_empresa']."'");?>" width="75" class="img-responsiive"/> <?=$rs_rel->pegar("emp_nome","empresas","emp_cnpj = '".$_SESSION['usu_empresa']."'");?>
						
						<small class="pull-right">Data: <?=date("d/m/Y");?></small>
							
					</h3>
				  </div><!-- /.col -->
				</div>
				<!-- info row -->
				<div class="row invoice-info">
					<?php

					$s_id = $_GET['colid'];
					
					//Início dos Dados
					$sql = "SELECT a.*, b.usu_nome as Colab, b.usu_email as Mail, c.usu_nome as aprov FROM desconto_horas a 
							JOIN usuarios b ON a.desc_colab = b.usu_cod
							JOIN usuarios c ON a.desc_usucad = c.usu_cod
						WHERE desc_colab=".$s_id;
						
						
						$rs_rel->FreeSql($sql);
						//echo $rs_rel->sql;
						$rs_rel->GeraDados();
						$_cliente 	= $rs_rel->fld("Colab");
						$_documen	= $rs_rel->fld("Mail");
					?>
					
					<div class="col-sm-4 invoice-col">
						<small>
							Usu&aacute;rio
							<address>
								<p class="text-uppercase"><strong><?=$_SESSION['nome_usu'];?></strong><br>
								<i class="fa fa-envelope"></i> <span class="text-lowercase"><small><?=$_SESSION['usuario'];?></small></span></p>
							</address>
						</small>
					</div><!-- /.col -->
					<div class="col-sm-4 invoice-col">
						<address>
							<i class="fa fa-tag"></i> <strong><?=$rs_rel->fld("desc_id");?></strong></p>
						</address>
					</div><!-- /.col -->
					
				</div><!-- /.row -->
				<div class="col-xl-12">
					
					<h2 class="page-header">
						Horas descontadas
					</h2>
					<div class="row">
					<div class="col-xs-12 table-responsive">
						<table class="table table-striped table-condensed">
							<thead>
								<tr>
									<th>#</th>
									<th>Colaborador</th>
									<th>Horas</th>
									<th>Data Desc.</th>
									<th>Descontado Por</th>
									<th>Observa&ccedil;&otilde;es</th>
								</tr>
							</thead>
							<tbody id="rls">
								<?php

								$rs_rel->FreeSql($sql);
								$total = 0;
								while($rs_rel->GeraDados()){
								?>
								<tr>
									<td><?=$rs_rel->fld("desc_id"); ?></td>
									<td><?=$rs_rel->fld("Colab"); ?></td>
									<td><?=number_format($rs_rel->fld("desc_horas"),2,",","."); ?></td>
									<td><?=$fn->data_hbr($rs_rel->fld("desc_data")); ?></td>
									<td><?=$rs_rel->fld("aprov"); ?></td>
									<td><?=$rs_rel->fld("desc_obs"); ?></td>
									
								</tr>
								<?php 
								
								} ?>
								
								</tr>
							</tbody>
						</table>
					</div><!-- /.col -->
				</div><!-- /.row -->
				
				
			</section><!-- /.content -->
		</div><!-- ./wrapper -->

		<!-- AdminLTE App -->
		<script src="../../dist/js/app.min.js"></script>
	</body>
</html>
