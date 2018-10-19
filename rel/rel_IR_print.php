<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start("portal");
require_once("../config/main.php");
require_once("../class/class.functions.php");
$rs_rel = new recordset();
?>
	<body onload="window.print();">
		<div class="wrapper">
			<!-- Main content -->
			<section class="invoice">
				<!-- title row -->
				<div class="row">
				  <div class="col-xs-12">
					<h2 class="page-header">
						<i class="fa fa-globe"></i> <?=$rs_rel->pegar("emp_nome","empresas","emp_cnpj = '".$_SESSION['usu_empresa']."'");?>
						<small class="pull-right">Data: <?=date("d/m/Y");?></small>
					</h2>
				  </div><!-- /.col -->
				</div>
				<!-- info row -->
				<div class="row invoice-info">
					<div class="col-sm-4 invoice-col">
						Usu&aacute;rio
						<address>
							<strong><?=$_SESSION['nome_usu'];?></strong><br>
							<i class="fa fa-envelope"></i> <?=$_SESSION['usuario'];?>
						</address>
					</div><!-- /.col -->
				</div><!-- /.row -->

				<!-- Table row -->
				<div class="row">
					<div class="col-xs-12 table-responsive">
						<table class="table table-striped table-condensed">
							<thead>
								  <tr><th colspan=7><h2>Relat&oacute;rio de Declara&ccedil;&otilde;es IRPF</h2></th></tr>
								  <tr>
									<th>#</th>
									<th>Tipo</th>
									<th>Doc.</th>
									<th>Nome</th>
									<th>Periodo</th>
									<th>Valor</th>
									<th>Dt Ult Alt.</th>
									<th>Entrada</th>
									<th>Status</th>
									<th>&Uacute;lt. Altera&ccedil;&atilde;o</th>
								</tr>
							</thead>
							<tbody id="rls">
								<?php
									require_once("../view/irrf_conCli.php");
								?>
							</tbody>
						</table>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</section><!-- /.content -->
		</div><!-- ./wrapper -->

		<!-- AdminLTE App -->
   		<script src="<?=$hosted;?>/sistema/assets/dist/js/app.min.js"></script>
	</body>
</html>
