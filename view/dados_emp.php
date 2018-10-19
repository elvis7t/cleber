<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start("portal");
$sec = "IRRF";
$pag = "irrf.php";
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


$rs = new recordset();
$fn = new functions();
?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
		<!-- Content Header (Page header) -->
        <section class="content-header">
			<h1>
				Clientes - Detalhes
				<small>Contatos e Dados Adicionais [<strong><?=(isset($_GET['clicod']) ? $rs->pegar("emp_razao","empresas","emp_codigo='".$_GET['clicod']."'") : ""); ?></strong>]</small>
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
							<li class="active"><a href="#tab_1" data-toggle="tab">Dados do Cliente</a></li>
							<li><a href="#tab_2" data-toggle="tab">Contatos</a></li>
							<?php
							$sql = "SELECT * FROM empresas
										LEFT JOIN contatos ON emp_cnpj = con_cli_cnpj
									WHERE emp_codigo = '".addslashes(trim($_GET['clicod']))."'";
							$rs->FreeSql($sql);
							$rs->GeraDados();
							$observacao = $rs->fld("emp_obs");
							$cpf = $rs->fld("emp_cnpj");
							$nome = $rs->fld("emp_razao") ;
							$data = $fn->data_br($rs->fld("emp_nasc"));
							$benef = $rs->fld("emp_benef");
							$cod_ac = $rs->fld("emp_cod_ac");
							$senha_ac = $rs->fld("emp_senha_ac");
							$val_senha = $fn->data_br($rs->fld("emp_validadesen"));
							?>
							<li><a href="#tab_4" data-toggle="tab">IRPF</a></li>
							<li><a href="#tab_6" data-toggle="tab">Documentos</a></li>
							<li><a href="#tab_5" data-toggle="tab">Demonstrativo</a></li>
							<li><a href="#tab_3" data-toggle="tab">Observa&ccedil;&otilde;es</a></li>
							<li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane active" id="tab_1">
								<?php
									require_once("vis_irclientes.php");
								?>
							</div><!-- /.tab-pane -->

							<div class="tab-pane" id="tab_2">
								<?php
									require_once("vis_ircontatos.php");
								?>
							</div><!-- /.tab-pane -->

							<div class="tab-pane" id="tab_4">
								<?php
									require_once("vis_irdeclaracoes.php");
								?>	
							</div><!-- /.tab-pane -->

							<div class="tab-pane" id="tab_5">
								<?php
									require_once("irpf_consulta_extrato.php");
								?>
							</div><!-- /.tab-pane -->

							<div class="tab-pane" id="tab_6">
								<!--DOCUMENTOS-->
								<?php
									require_once("ir_documentos.php");
								?>
							</div><!-- /.tab-pane -->
							<div class="tab-pane" id="tab_3">
								<!--OBSERVAÇÔES-->
								<?php
									require_once("ir_observacoes.php");
								?>
								
							</div><!-- /.tab-pane -->
							
							
						</div><!-- /.tab-content -->
					</div><!-- nav-tabs-custom -->
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
    <script src="<?=$hosted;?>/sistema/js/controle.js"></script>
    <script src="<?=$hosted;?>/sistema/js/action_empresas.js"></script>
    <script src="<?=$hosted;?>/sistema/js/action_irrf.js"></script>
    <script src="<?=$hosted;?>/sistema/js/functions.js"></script>
	<!-- SELECT2 TO FORMS-->
		<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
	<!--INPUT-->
	<script src="<?=$hosted;?>/sistema/assets/plugins/input-mask/jquery.inputmask.js"></script>
    <script src="<?=$hosted;?>/sistema/assets/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src="<?=$hosted;?>/sistema/assets/plugins/input-mask/jquery.inputmask.extensions.js"></script>
	<!-- Validation -->
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
	<script src="<?=$hosted;?>/sistema/js/jquery.cookie.js"></script>
	<script src="<?=$hosted;?>/sistema/assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
	<script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
	 

	<script type="text/javascript">
		
		$(".select2").select2({
			tags: true
		});
		 $(function () {
			// Replace the <textarea id="editor1"> with a CKEditor
			// instance, using default configuration.
			CKEDITOR.replace('emp_obs');
			$(".dtp").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/aaaa"});
			
		});

	</script>

</body>
</html>	