<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start();
$sec = "CART";
$pag = "carteira.php";
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
				Empresas
				<small>Carteira de Clientes</small>
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li>Servi&ccedil;os</li>
				<li class="active">Itens cadastrados</li>
			</ol>
        </section>

        <!-- Main content -->
        <section class="content">
			 <div class="row">
				<!-- left column -->
				<div class="col-md-12">
					<!-- Custom Tabs -->
					<div class="nav-tabs-custom">
						<ul class="nav nav-tabs">
							<?php
							if($_SESSION['classe']==1 || $_SESSION['dep']==1): ?>
							<li><a href="#tab_1" data-toggle="tab">Cont&aacute;bil</a></li>
							<?php endif;
							if($_SESSION['classe']==1 || $_SESSION['dep']==4): ?>
							<li><a href="#tab_2" data-toggle="tab">Depto. Pessoal</a></li>
							<?php endif;
							if($_SESSION['classe']==1 || $_SESSION['dep']==2): ?>
							<li><a href="#tab_3" data-toggle="tab">Escr. Fiscal</a></li>
							<?php endif; ?>
							
							<li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane <?=(($_SESSION['classe']==1 || $_SESSION['dep']==1)?"active":"");?>" id="tab_1">
								<?php require_once("cart_contabil.php");?>
							</div>
							<div class="tab-pane <?=($_SESSION['dep']==4?"active":"");?>" id="tab_2">
								<?php require_once("cart_dp.php");?>
							</div>
							<div class="tab-pane <?=($_SESSION['dep']==2?"active":"");?>" id="tab_3">
								<?php require_once("cart_fiscal.php");?>
							</div>
							
						</div>
					</div>
				</div><!-- /.col -->
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
    <!-- SELECT2 TO FORMS-->
	<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
	

    <script src="<?=$hosted;?>/assets/plugins/input-mask/jquery.inputmask.js"></script>
    <script src="<?=$hosted;?>/assets/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src="<?=$hosted;?>/assets/plugins/input-mask/jquery.inputmask.extensions.js"></script>
    
    <script src="<?=$hosted;?>/js/action_empresas.js"></script>
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
		$('[data-toggle="popover"]').popover({html:true});
		//$("#ger_venc").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/aaaa"});
		$(".select2").select2({
			tags: true,
			theme: 'classic'
		});
	</script>
</body>
</html>