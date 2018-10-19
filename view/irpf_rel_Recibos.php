<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start("portal");
$sec = "IRRF";
$pag = "irpf_recibo.php";
require_once("../config/main.php");
require_once("../config/valida.php");
require_once("../config/mnutop.php");
require_once("../config/menu.php");
require_once("../config/modals.php");
require_once("../class/class.functions.php");
?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
		<!-- Content Header (Page header) -->
        <section class="content-header">
			<h1>
				Servi&ccedil;os
				<small>Declarações de Imposto de Renda</small>
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li>Servi&ccedil;os</li>
				<li class="active">Impostos Registrados</li>
			</ol>
        </section>

        <!-- Main content -->
        <section class="content">
			 <div class="row">	
				<div class="col-xs-12">
					<div class="box box-success" id="irrf_cli">
						<div class="box-header with-border">
							<h3 class="box-title">Cobran&ccedil;as em aberto:</h3>
						</div><!-- /.box-header -->
						<div class="box-body">
							 <table class="table table-striped" id="irp_recs">
							 	<thead>
									<tr>
										<th>#</th>
										<th>Cliente</th>
										<th>Valor Cobrado</th>
										<th>Valor Pago</th>
										<th>Status</th>
										<th>Pago</th>
										<th>Acts</th>
									</tr>
								</thead>
								<tbody>
									<!-- Conteúdo dinamico PHP-->
									<?php require_once("ir_Recibos.php"); ?>
								</tbody>
							</table>
						</div>
						
					</div><!-- ./box -->
					<div id="consulta"></div>
				</div><!-- ./col -->
			</div><!-- ./row -->
		</section>
	</div>

	<?php
		require_once("../config/footer.php");
		//require_once("../config/sidebar.php");
	?>
	</div><!-- ./wrapper -->

	<script src="<?=$hosted;?>/sistema/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
	<script src="<?=$hosted;?>/sistema/js/jquery.cookie.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?=$hosted;?>/sistema/assets/bootstrap/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="<?=$hosted;?>/sistema/assets/plugins/fastclick/fastclick.min.js"></script>
	
    <!-- AdminLTE App -->
    <script src="<?=$hosted;?>/sistema/assets/dist/js/app.min.js"></script>
	<script src="<?=$hosted;?>/sistema/assets/dist/js/demo.js"></script>
  
   <!-- Slimscroll -->
    <script src="<?=$hosted;?>/sistema/assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="<?=$hosted;?>/sistema/assets/js/maskinput.js"></script>
    <script src="<?=$hosted;?>/sistema/assets/js/jmask.js"></script>
    <script src="<?=$hosted;?>/sistema/js/controle.js"></script>
    <script src="<?=$hosted;?>/sistema/js/action_irrf.js"></script>
    <script src="<?=$hosted;?>/sistema/js/action_triang.js"></script>
    <script src="<?=$hosted;?>/sistema/js/functions.js"></script>
	<!-- Validation -->
    <!--<script src="<?=$hosted;?>/js/jquery-validation/dist/jquery.validate.min.js"></script>-->
	<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
	<!--datatables-->
    <script src="<?=$hosted;?>/sistema/assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?=$hosted;?>/sistema/assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
	<script type="text/javascript">
		$(function () {
			$('#irp_recs').DataTable({
				"columnDefs": [{
    			"defaultContent": "-",
    			"targets": "_all"
			}]
			});
		});
	</script>
</body>
</html>