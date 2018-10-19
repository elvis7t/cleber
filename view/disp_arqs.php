<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start("portal");
$sec = "Mens";
$pag = "disp_arqs.php";
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
$cod = (isset($_GET['clicod']) ? $_GET['clicod'] : 477);
?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
		<!-- Content Header (Page header) -->
        <section class="content-header">
			<h1>
				Clientes - Arquivos para Importa&ccedil;&atilde;o
				
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li>Gerenciamento</li>
				<li>Clientes</li>
				<li>Arquivos</li>
				<li class="active">Disponibilizar</li>
				
			</ol>
        </section>

        <!-- Main content -->
        <section class="content">
			<div class="row">
				<div class="col-md-12" id="view_trata">		
					<div class="row">
						<?php
							require_once("view_trataarquivos.php");
							/*
							-| imp_conferefenv
						  	-| vis_confenviar 
							*/
						?>
					</div><!--/row	-->
				</div>
			</div><!--/row	-->
			
		</section>
	</div>
	
		<?php 
			require_once("../config/footer.php");
			//require_once("../config/sidebar.php");
		?>
	</div><!-- ./wrapper -->

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
    <script src="<?=$hosted;?>/sistema/js/controle.js"></script>
    <script src="<?=$hosted;?>/sistema/js/action_empresas.js"></script>

	<!-- SELECT2 TO FORMS
	-->
	<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
	<!-- Validation -->
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
	<script src="<?=$hosted;?>/sistema/assets/plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="<?=$hosted;?>/sistema/assets/plugins/datatables/dataTables.bootstrap.min.js"></script> 
	<script src="<?=$hosted;?>/sistema/js/jquery.cookie.js"></script>
	<script src="<?=$hosted;?>/sistema/js/functions.js"></script>
	<script src="<?=$hosted;?>/sistema/assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
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
		// Replace the <textarea id="com_obs"> with a CKEditor
		// instance, using default configuration.
		CKEDITOR.replace('com_obs');
	});


	$(".select2").select2({
		tags: true
	});
	$(document).ready(function(){
		$("#empr").DataTables({
				"columnDefs": [{
				"defaultContent": "-",
				"targets": "_all"
			}]
		});
	});

	$("#arq_depto").change(function(){
		$("#arq_titulo").select2("val",0);
		$.post("../controller/TRIEmpresas.php",
		{
			acao: 	"opt_arquivo",
			dept: 	$("#arq_depto").val(),
			codi: 	$("#arq_clicod").val(),
			caid: 	$("#arq_id").val()
		},
		function(data){
			$("#arq_titulo").html(data);
			console.log(data);
		},
		"html");
	});
	
	
	</script>

</body>
</html>	