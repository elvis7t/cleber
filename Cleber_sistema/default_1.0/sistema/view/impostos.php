<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start();
$sec = "CART";
$pag = "impostos.php";
require_once("../config/main.php");
require_once("../config/valida.php");
require_once("../config/mnutop.php");
require_once("../config/menu.php");
require_once("../config/modals.php");
require_once("../class/class.functions.php");
require_once("../class/class.permissoes.php");

$per = new permissoes();
$rs = new recordset();
$cod = (isset($_GET['clicod']) ? $_GET['clicod'] : 477);
$tab = (isset($_GET['tab']) ? $_GET['tab'] : "escrita")
								
?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
		<!-- Content Header (Page header) -->
        <section class="content-header">
			<h1>
				Impostos - Detalhes
				
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li>Gerenciamento</li>
				<li>Gerenciadores</li>
				<li class="active">Impostos</li>
				
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
							<li class="<?=($tab=="escrita"?"active":"");?>"><a href="#tab_1" data-toggle="tab">Escrita Fiscal</a></li>
							
							<li class="<?=($tab=="contabil"?"active":"");?>"><a href="#tab_2" data-toggle="tab">Cont&aacute;bil</a></li>
							<li class="<?=($tab=="dp"?"active":"");?>"><a href="#tab_3" data-toggle="tab">Depto Pessoal</a></li>
							
							<!--<li><a href="#tab_8" data-toggle="tab">Observações</a></li>-->
							<li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane <?=($tab=="escrita"?"active":"");?>" id="tab_1">
								<?php require_once("vis_impfiscal.php");?>
							</div>
							<div class="tab-pane <?=($tab=="contabil"?"active":"");?>" id="tab_2">
								<?php require_once("vis_impcontabil.php");?>
							</div>
							<div class="tab-pane <?=($tab=="dp"?"active":"");?>" id="tab_3">
								<?php require_once("vis_impdp.php");?>
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
	?></div><!-- ./wrapper -->

<script src="<?=$hosted;?>/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?=$hosted;?>/assets/bootstrap/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="<?=$hosted;?>/assets/plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?=$hosted;?>/assets/dist/js/app.min.js"></script>
   <!-- Slimscroll -->
    <script src="<?=$hosted;?>/assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="<?=$hosted;?>/assets/js/maskinput.js"></script>
    <script src="<?=$hosted;?>/assets/js/jmask.js"></script>
    <script src="<?=$hosted;?>/js/controle.js"></script>
    <script src="<?=$hosted;?>/js/action_empresas.js"></script>
     <!-- iCheck 1.0.1 -->
    <script src="<?=$hosted;?>/assets/plugins/iCheck/icheck.min.js"></script>
    

	<!-- SELECT2 TO FORMS
	-->
	<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
	<!-- Validation -->
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
	<script src="<?=$hosted;?>/assets/plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="<?=$hosted;?>/assets/plugins/datatables/dataTables.bootstrap.min.js"></script> 
	<script src="<?=$hosted;?>/js/jquery.cookie.js"></script>
	<script src="<?=$hosted;?>/js/functions.js"></script>
	<script src="<?=$hosted;?>/assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
	<script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
	 

	<script type="text/javascript">
	setInterval(function(){

		if($.cookie('msg_lido')==0) {
			notify($.cookie("user"), $.cookie("mensagem"),$.cookie("pag"));
			$.cookie("msgant");
			$.cookie('msg_lido',1);
		}
	},3500);

	 $(function () {
		// Replace the <textarea id="editor1"> with a CKEditor
		// instance, using default configuration.
		CKEDITOR.replace('editor1');
		CKEDITOR.replace('editor2');
	});


	$(".select2").select2({
		tags: true
	});
	
	$(document).ready(function(){
	  $('input[type="radio"].minimal').iCheck({
          checkboxClass: 'icheckbox_minimal-blue',
          radioClass: 'iradio_minimal-blue'
        });
	
		$("#impfis").DataTables({
				"columnDefs": [{
				"defaultContent": "-",
				"targets": "_all"
			}]
		});
	
	});
	
	
	</script>

</body>
</html>	