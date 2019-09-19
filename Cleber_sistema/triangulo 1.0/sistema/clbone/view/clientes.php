<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start();
$sec = "Dados";
$pag = "clientes.php";
require_once("../config/main.php");
require_once("../config/valida.php");
require_once("../config/mnutop.php");
require_once("../config/menu.php");
require_once("../../sistema/config/modals.php");
require_once("../../sistema/class/class.functions.php");
require_once("../class/class.permissoes.php");

$per = new permissoes();
$rs = new recordset();
$cod = (isset($_GET['clicod']) ? $_GET['clicod'] : 477);
$tab = (isset($_GET['tab']) ? $_GET['tab'] : "clientes")
								
?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
		<!-- Content Header (Page header) -->
        <section class="content-header">
			<h1>
				Clientes - Detalhes
				
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li>Gerenciamento</li>
				<li>Clientes</li>
				<li class="active">Detalhes</li>
				
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
							<li class="<?=($tab=="clientes"?"active":"");?>"><a href="#tab_1" data-toggle="tab">Dados do Cliente</a></li>
							<li class="<?=($tab=="senhas"?"active":"");?>"><a href="#tab_2" data-toggle="tab">Senhas</a></li>
							<li class="<?=($tab=="partic"?"active":"");?>"><a href="#tab_3" data-toggle="tab">Particularidades</a></li>
							<li class="<?=($tab=="comunic"?"active":"");?>"><a href="#tab_4" data-toggle="tab">Comunicação</a></li>
							<li class="<?=($tab=="obrigac"?"active":"");?>"><a href="#tab_5" data-toggle="tab">Obrigações</a></li>
							<li class="<?=($tab=="tribut"?"active":"");?>"><a href="#tab_6" data-toggle="tab">Tributos</a></li>
							<li class="<?=($tab=="cart"?"active":"");?>"><a href="#tab_7" data-toggle="tab">Carteira</a></li>
							<!--<li><a href="#tab_8" data-toggle="tab">Observações</a></li>-->
							<li><a href="#tab_9" data-toggle="tab">Time Line</a></li>
							<li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane <?=($tab=="clientes"?"active":"");?>" id="tab_1">
								<?php require_once("form_clientes.php");?>
							</div>
							<div class="tab-pane <?=($tab=="senhas"?"active":"");?>" id="tab_2">
								<?php require_once("vis_senhas.php");?>
							</div>
							<div class="tab-pane <?=($tab=="partic"?"active":"");?>" id="tab_3">
								<?php require_once("vis_partic.php");?>
							</div>
							<div class="tab-pane <?=($tab=="comunic"?"active":"");?>" id="tab_4">
								<?php require_once("vis_comunic.php");?>
							</div>
							<div class="tab-pane <?=($tab=="obrigac"?"active":"");?>" id="tab_5">
								<?php require_once("vis_obrigac.php");?>
							</div>
							<div class="tab-pane <?=($tab=="tribut"?"active":"");?>" id="tab_6">
								<?php require_once("vis_tributos.php");?>
							</div>
							<div class="tab-pane" id="tab_7">
								<?php require_once("vis_carts.php");?>
							</div>
							
							<div class="tab-pane" id="tab_9">
								<?php //require_once("vis_comunic.php");?>
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

<script src="<?=$hosted;?>/sistema/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?=$hosted;?>/sistema/assets/bootstrap/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="<?=$hosted;?>/sistema/assets/plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?=$hosted;?>/sistema/assets/dist/js/app.min.js"></script>
   <!-- Slimscroll -->
    <script src="<?=$hosted;?>/sistema/assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="<?=$hosted;?>/sistema/assets/js/maskinput.js"></script>
    <script src="<?=$hosted;?>/sistema/assets/js/jmask.js"></script>
    <script src="<?=$hosted;?>/clbone/js/controle.js"></script>
    <script src="<?=$hosted;?>/clbone/js/action_empresas.js"></script>
     <!-- iCheck 1.0.1 -->
    <script src="<?=$hosted;?>/sistema/assets/plugins/iCheck/icheck.min.js"></script>
    

	<!-- SELECT2 TO FORMS-->
	<script src="<?=$hosted;?>/sistema/assets/plugins/select2/js/select2.full.min.js"></script>
	<!-- Validation -->
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
	<script src="<?=$hosted;?>/sistema/assets/plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="<?=$hosted;?>/sistema/assets/plugins/datatables/dataTables.bootstrap.min.js"></script> 
	<script src="<?=$hosted;?>/clbone/js/jquery.cookie.js"></script>
	<script src="<?=$hosted;?>/clbone/js/functions.js"></script>
	<script src="<?=$hosted;?>/sistema/assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
	<script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
	<!--CHOSEN-->
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.6.2/chosen.jquery.min.js"></script>


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
		
	$(".chosen").chosen({
		 	no_results_text: "Sem resultados!"
		 });


	$(document).ready(function(){
		$("#empr").DataTables({
				"columnDefs": [{
				"defaultContent": "-",
				"targets": "_all"
			}]
		});
	});
	$(document).ready(function(){
	  $('input[type="radio"].minimal').iCheck({
          checkboxClass: 'icheckbox_minimal-blue',
          radioClass: 'iradio_minimal-blue'
        });
	});
	
	
	</script>

</body>
</html>	