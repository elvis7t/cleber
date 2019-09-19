<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start();
$sec = "SERV";
$pag = "serv_lista_saidas.php";
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
				<small>Itens de Serviços</small>
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li>Servi&ccedil;os</li>
				<li class="active">Gerenciar Itens Registradas</li>
			</ol>
        </section>

        <!-- Main content -->
        <section class="content">
			 <div class="row">	
				<div class="col-xs-12">
					<div class="box box-success" id="irrf_cli">
						<div class="box-header with-border">
							<h3 class="box-title">Gerenciar Itens</h3>
						</div><!-- /.box-header -->
						<div class="box-body">
							 <table class="table table-striped" id="irp_recs">
							 	<thead>
									<tr>
										<th>#</th>
										<th>Cliente</th>
										<th>Regi&atilde;o</th>
										<th>Documentos</th>
										<th>Cadast. por</th>
										<th>Cadast. em</th>
										<th>Acts</th>
									</tr>
								</thead>
								<tbody>
									<!-- Conteúdo dinamico PHP-->
									<?php require_once("ger_itens_lista.php"); ?>
								</tbody>
							</table>
						</div>
						<div class="box-footer">
							<input type="hidden" value="<?=$_GET['token'];?>" id="token"/>
							<input type="hidden" value="<?=$_GET['lista'];?>" id="lista"/>
							<?php
							$rs = new recordset();
							$whr1 = "ser_lista = ".$_GET['lista'];
							$whr2 = "ser_lista = ".$_GET['lista']." AND ser_status = 99";
							$nsol = $rs->pegar("count(ser_id)", "servicos", $whr1);
							$nok = $rs->pegar("count(ser_id)", "servicos", $whr2);
							$number = $nsol-$nok;
							if($nok > 0 AND $number ==0){ ?>
								<button type="button" class="btn btn-sm btn-success" id="completa_Serv"><i class="fa fa-check"></i> Completar</button>
							<?php 
							}
							if($sol == 0 AND $nok < 1){ ?>
								<button type="button" class="btn btn-sm btn-danger" id="canc_Serv"><i class="fa fa-times"></i> Cancelar</button>
							<?php 
							}


							?>
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

	<script src="<?=$hosted;?>/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
	<script src="<?=$hosted;?>/js/jquery.cookie.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?=$hosted;?>/assets/bootstrap/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="<?=$hosted;?>/assets/plugins/fastclick/fastclick.min.js"></script>
	
    <!-- AdminLTE App -->
    <script src="<?=$hosted;?>/assets/dist/js/app.min.js"></script>
	<script src="<?=$hosted;?>/assets/dist/js/demo.js"></script>
  
   <!-- Slimscroll -->
    <script src="<?=$hosted;?>/assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
      <script src="<?=$hosted;?>/assets/js/maskinput.js"></script>
    <script src="<?=$hosted;?>/assets/js/jmask.js"></script>
    <script src="<?=$hosted;?>/js/controle.js"></script>
    <script src="<?=$hosted;?>/js/action_triang.js"></script>
    <script src="<?=$hosted;?>/js/functions.js"></script>
	<!-- Validation -->
    <!--<script src="<?=$hosted;?>/js/jquery-validation/dist/jquery.validate.min.js"></script>-->
	<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
	<!--datatables-->
    <script src="<?=$hosted;?>/assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?=$hosted;?>/assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
	
</body>
</html>