<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start();
$sec = "Mater";
$pag = "lista_materiais.php";
require_once("../config/main.php");
require_once("../config/valida.php");
require_once("../config/mnutop.php");
require_once("../config/menu.php");
require_once("../config/modals.php");
require_once("../class/class.functions.php");
require_once("../class/class.permissoes.php");

$per = new permissoes();
$con = $per->getPermissao($pag);

if($con['C']<>1){
  header("location:403.php?token=".$_SESSION['token']);
}
?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
		<!-- Content Header (Page header) -->
        <section class="content-header">
			<h1>
				Materiais
				<small>Produtos para Compra</small>
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li>Materiais</li>
				<li class="active">Itens para Compra</li>
			</ol>
        </section>

        <!-- Main content -->
        <section class="content">
			 <div class="row">	
				<div class="col-xs-12">
					<div class="box box-success" id="irrf_cli">
						<div class="box-header with-border">
							<h3 class="box-title">Itens:</h3>
						</div><!-- /.box-header -->
						<div class="box-body">
							 <table class="table table-striped" id="lista_mat">
							 	<thead>
									<tr>
										<th></th>
										<th>#</th>
										<th>Material</th>
										<th>Estoque Atual</th>
										<th>Estoque M&iacute;nimo</th>
										<th>Qtd Compra M&iacute;n</th>
									</tr>
								</thead>
								<tbody>
									<!-- Conteúdo dinamico PHP-->
									<?php require_once("vis_matlista.php"); ?>
								</tbody>
							</table>
						</div>
						<div class="box-footer">
						
							<div class='col-sm-2 pull-right'>
								<div class="input-group row pull-right">
									<a href="mat_listacmp.php?token=<?=$_SESSION['token'];?>"
										id="ver_listaslistas"
										class='btn btn-primary' 
										data-toggle='tooltip' 
										data-placement='bottom' 
										title='Ver Listas'><i class='fa fa-tasks'></i> Ver Listas
									</a> 
								</div>
							</div>

							
							
								
							<div class='col-sm-3'>
								<div class="input-group row">
									<input type="text" class="form-control" name="lismat_venc" id="lismat_venc" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask>
									<span class="input-group-btn">
										<button
											id="gerar_lista"
											class='btn btn-success' 
											data-toggle='tooltip' 
											data-placement='bottom'
											disabled
											title='Gerar Lista'><i class='fa fa-print'></i> Gerar Lista
										</button> 
									</span>
								</div>
							</div>
						
							

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

    <script src="<?=$hosted;?>/assets/plugins/input-mask/jquery.inputmask.js"></script>
    <script src="<?=$hosted;?>/assets/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src="<?=$hosted;?>/assets/plugins/input-mask/jquery.inputmask.extensions.js"></script>
    
    <script src="<?=$hosted;?>/js/action_irrf.js"></script>
    <script src="<?=$hosted;?>/js/action_triang.js"></script>
	<!-- Validation -->
    <!--<script src="<?=$hosted;?>/js/jquery-validation/dist/jquery.validate.min.js"></script>-->
	<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
	<!--datatables-->
    <script src="<?=$hosted;?>/assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?=$hosted;?>/assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
    <script src="<?=$hosted;?>/js/jquery.cookie.js"></script>
        <script src="<?=$hosted;?>/js/controle.js"></script>
        <script src="<?=$hosted;?>/js/functions.js"></script>

	<script type="text/javascript">
		$(function () {
			$('#lista_mat').DataTable({
				"columnDefs": [{
    			"defaultContent": "-",
    			"targets": "_all"
			}]
			});
		});
		$('[data-toggle="popover"]').popover({html:true});
		$("#lismat_venc").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/aaaa"});
	</script>
</body>
</html>