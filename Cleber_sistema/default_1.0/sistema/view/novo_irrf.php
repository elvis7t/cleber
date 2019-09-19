<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start();
$sec = "IRRF";
$pag = "irrf.php";
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
				<li class="active">Servi&ccedil;os</li>
			</ol>
        </section>

        <!-- Main content -->
        <section class="content">
			 <div class="row">
				<!-- left column -->
				<div class="col-md-12">
				<!-- general form elements -->
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title">Novo Imposto</h3>
						</div><!-- /.box-header -->
						<!-- form start -->
						<?php
							$cod = $_GET['clicod'];
							$rs = new recordset();
							$rs->Seleciona("*","empresas","emp_codigo = ".$cod);
							$rs->GeraDados();
						?>
						<form role="form" id="cad_ir">
							<div class="box-body">
								<div class="row">
									<div class="form-group col-xs-3">
										<label for="ir_doc">Doc.:</label>
										<input type="text" class="form-control" id="ir_doc" name="ir_doc" value="<?=$rs->fld("emp_cnpj");?>" READONLY >
										<input type="hidden" class="form-control" id="ir_cod" name="ir_cod" value="<?=$cod;?>">

									</div>
									<div class="form-group col-xs-6">
										<label for="ir_nome">Nome:</label>
										<input type="text" class="form-control" id="ir_nome" name="ir_nome" value="<?=$rs->fld("emp_razao");?>" READONLY >
									</div>
								</div>
														
								<div class="row">
									<div class="form-group col-xs-2">
										<label for="emp_rzs">Per&iacute;odo:</label>
										<input type="text" class="form-control" id="ir_ano" name="ir_ano" placeholder="Ano" maxlength=4>
									</div>
									
									<div class="form-group col-xs-2">
										<label for="cep">Valor:</label>
										<input type="text" class="form-control" id="ir_valor" name="ir_valor" placeholder="Valor">
									</div>
									<div class="form-group col-xs-4">
										<label for="cep">Tipo de Serv.:</label>
										<select class="form-control minimal" id="ir_tipo" name="ir_tipo">
											<option value="IRPF"> IRPF - Imposto Renda Pessoa F&iacute;sica </option>
											<option value="GC"> Ganho de Capital </option>
											<option value="AR"> Anexo Rural </option>
											<option value="ITR"> Imposto Territorial Rural </option>

										</select>
									</div>

									<div class="form-group col-xs-4">
										<label for="cep">Complemento:</label>
										<input type="text" class="form-control" id="ir_compl" name="ir_compl" placeholder="Complemento de Serv.">
									</div>
									
								</div>
								<div id="consulta"></div>
								<div id="formerros3" class="" style="display:none;">
									<div class="callout callout-danger">
										<h4>Erros no preenchimento do formul&aacute;rio.</h4>
										<p>Verifique os erros no preenchimento acima:</p>
										<ol>
											<!-- Erros são colocados aqui pelo validade -->
										</ol>
									</div>
								</div>	
							</div>
							<div class="box-footer">
								<button class="btn btn-sm btn-primary" type="button" id="bt_novo_ir"><i class="fa fa-plus"></i> Incluir</button>
								
								
							</div>
						</form>
					</div><!-- ./box -->
					
				</div><!-- ./col -->
				<div class="col-xs-12">
					<div class="box box-success" id="irrf_cli">
						<div class="box-header with-border">
							<h3 class="box-title">Impostos para esse Cliente:</h3>
						</div><!-- /.box-header -->
						<div class="box-body">
							 <table class="table table-striped">
							 	<thead>
									<tr>
										<th>Tipo</th>
										<!--<th>Doc.</th>
										<th>Nome</th>-->
										<th>Periodo</th>
										<th>Valor Anterior</th>
										<th>Valor Atual</th>
										<th>Entrada</th>
										<th>Status</th>
										<th>&Uacute;lt. Altera&ccedil;&atilde;o</th>
										<th>A&ccedil;&otilde;es</th>
									</tr>
								</thead>
								<tbody>
									<!-- Conteúdo dinamico PHP-->
									<?php require_once("irrf_conCli.php"); ?>
								</tbody>
							</table>
						</div>
					</div><!-- ./box -->
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
    <script src="<?=$hosted;?>/js/controle.js"></script>
    <script src="<?=$hosted;?>/js/action_irrf.js"></script>
    <script src="<?=$hosted;?>/js/action_triang.js"></script>
    <script src="<?=$hosted;?>/js/functions.js"></script>
	<!-- Validation -->
    <!--<script src="<?=$hosted;?>/js/jquery-validation/dist/jquery.validate.min.js"></script>-->
	<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
	<script>
	// Atualizar a cada 7 segundos
		 setTimeout(function(){
			$("#irrf_cli tbody").load("irrf_conCli.php?token=<?=$_SESSION['token'];?>&clicod=<?=$_GET['clicod'];?>");					 
			$("#alms").load(location.href+" #almsg");	
		 },10000);
		 // POPOVER
		$('[data-toggle="popover"]').popover();

	</script>
</body>
</html>