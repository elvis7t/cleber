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
								</tr>
							</thead>
							<tbody id="rls">
								<?php
									require_once("corpo_rel.php");
								?>
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
