<?php
//sujeira embaixo do tapete :(

/*inclusão dos principais itens da página */

$sec = "Mens";
$pag = "clientes.php";
require_once("../config/main.php");
require_once("../config/valida.php");
require_once("../config/mnutop.php");
require_once("../config/menu.php");
require_once("../config/modals.php");
require_once("../class/class.functions.php");
require_once("../class/class.permissoes.php");

$per = new permissoes();
$rs = new recordset();
$rs2 = new recordset();
$cod = (isset($_GET['clicod']) ? $_GET['clicod'] : 0);
$tab = (isset($_GET['tab']) ? $_GET['tab'] : "clientes");
$fn = new functions();
								
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
							<li class="<?=($tab=="clientes"?"active":"");?>"><a href="#tab_1" data-toggle="tab">Dados</a></li>
							<li class="<?=($tab=="senhas"?"active":"");?>"><a href="#tab_2" data-toggle="tab">Senhas</a></li>
							<li class="<?=($tab=="partic"?"active":"");?>"><a href="#tab_3" data-toggle="tab">Ocorr&ecirc;ncias</a></li>
							<li class="<?=($tab=="comunic"?"active":"");?>"><a href="#tab_4" data-toggle="tab">Comunicação</a></li>
							<li class="<?=($tab=="obrigac"?"active":"");?>"><a href="#tab_5" data-toggle="tab">Obrigações</a></li>
							<li class="<?=($tab=="tribut"?"active":"");?>"><a href="#tab_6" data-toggle="tab">Tributos</a></li>
							<li class="<?=($tab=="cart"?"active":"");?>"><a href="#tab_7" data-toggle="tab">Carteira</a></li>
							<li class="<?=($tab=="timl"?"active":"");?>"><a href="#tab_8" data-toggle="tab">Time Line</a></li>
							<li class="<?=($tab=="arquivos"?"active":"");?>"><a href="#tab_9" data-toggle="tab">Arquivos</a></li>
							<li class="<?=($tab=="certid"?"active":"");?>"><a href="#tab_10" data-toggle="tab">CLP</a></li>
							<li class="<?=($tab=="certif"?"active":"");?>"><a href="#tab_11" data-toggle="tab">Certificados</a></li>
							<li class="<?=($tab=="docsrec"?"active":"");?>"><a href="#tab_12" data-toggle="tab">Documentos</a></li>
							
							<!--<li><a href="#tab_9" data-toggle="tab">Observações</a></li>-->
							<li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane <?=($tab=="clientes"?"active":"");?>" id="tab_1">
								<?php require_once("form_clientes.php");?>
							</div>
							<div class="tab-pane <?=($tab=="senhas"?"active":"");?>" id="tab_2">
								<?php ($cod <> 0 ? require_once("vis_senhas.php"):"");?>
							</div>
							<div class="tab-pane <?=($tab=="partic"?"active":"");?>" id="tab_3">
								<?php ($cod <> 0 ? require_once("vis_partic.php"):"");?>
							</div>
							<div class="tab-pane <?=($tab=="comunic"?"active":"");?>" id="tab_4">
								<?php ($cod <> 0 ? require_once("vis_comunic.php"):"");?>
							</div>
							<div class="tab-pane <?=($tab=="obrigac"?"active":"");?>" id="tab_5">
								<?php ($cod <> 0 ? require_once("vis_obrigac.php"):"");?>
							</div>
							<div class="tab-pane <?=($tab=="tribut"?"active":"");?>" id="tab_6">
								<?php ($cod <> 0 ? require_once("vis_tributos.php"):"");?>
							</div>
							<div class="tab-pane" id="tab_7">
								<?php ($cod <> 0 ? require_once("vis_carts.php"):"");?>
							</div>
							<div class="tab-pane <?=($tab=="timl"?"active":"");?>" id="tab_8">
								<?php ($cod <> 0 ? require_once("vis_clitimeline.php"):"");?>
							</div>
							<div class="tab-pane <?=($tab=="arquivos"?"active":"");?>" id="tab_9">
								<?php ($cod <> 0 ? require_once("vis_emparquivos.php"):"");?>
							</div>
							<div class="tab-pane <?=($tab=="certid"?"active":"");?>" id="tab_10">
								<?php ($cod <> 0 ? require_once("vis_certidoes.php"):"");?>
							</div>
							<div class="tab-pane <?=($tab=="certif"?"active":"");?>" id="tab_11">
								<?php ($cod <> 0 ? require_once("vis_certifcados.php"):"");?>
							</div>
							<div class="tab-pane <?=($tab=="docsrec"?"active":"");?>" id="tab_12">
								<?php ($cod <> 0 ? require_once("vis_docsrecs.php"):"");?>
							</div>
							
							
							
						</div>
					</div>
				</div><!-- /.col -->
			</div><!-- ./row -->
			
		</section>
	</div>

	<script src="<?=$hosted;?>/sistema/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
	<!-- Bootstrap 3.3.5 -->
	<script src="<?=$hosted;?>/sistema/assets/bootstrap/js/bootstrap.min.js"></script>
	<?php 
		require_once("../config/footer.php");
		//require_once("../config/sidebar.php");
	?></div><!-- ./wrapper -->

<!-- FastClick -->
<script src="<?=$hosted;?>/sistema/assets/plugins/fastclick/fastclick.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=$hosted;?>/sistema/assets/dist/js/app.min.js"></script>
<!-- Slimscroll -->
<script src="<?=$hosted;?>/sistema/assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="<?=$hosted;?>/sistema/assets/js/maskinput.js"></script>
<script src="<?=$hosted;?>/sistema/assets/js/jmask.js"></script>
<script src="<?=$hosted;?>/sistema/js/controle.js"></script>
<script src="<?=$hosted;?>/sistema/js/action_empresas.js"></script>
<script src="<?=$hosted;?>/sistema/js/action_triang.js"></script>
 <!-- iCheck 1.0.1 -->
<script src="<?=$hosted;?>/sistema/assets/plugins/iCheck/icheck.min.js"></script>


<!-- SELECT2 TO FORMS-->
<script src="<?=$hosted;?>/sistema/assets/plugins/select2/js/select2.full.min.js"></script>
<!-- Validation -->
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script src="<?=$hosted;?>/sistema/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=$hosted;?>/sistema/assets/plugins/datatables/dataTables.bootstrap.js"></script>
<script src="<?=$hosted;?>/sistema/js/jquery.cookie.js"></script>
<script src="<?=$hosted;?>/sistema/js/functions.js"></script>
<script src="<?=$hosted;?>/sistema/assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>


<script type="text/javascript">
	$(document).ready(function(){
		$(".select2").select2({
			tags: true
		});
		
		$(function(){
			// Replace the <textarea id="editor1"> with a CKEditor
			// instance, using default configuration.
			CKEDITOR.replace('editor1');
			CKEDITOR.replace('editor2');

			
			$("#empr").DataTables({
					"columnDefs": [{
					"defaultContent": "-",
					"targets": "_all"
				}]
			});
			
			$('input[type="radio"].minimal').iCheck({
				checkboxClass: 'icheckbox_minimal-blue',
				radioClass: 'iradio_minimal-blue'
			});
		});
	});

	
	
	</script>

</body>
</html>	