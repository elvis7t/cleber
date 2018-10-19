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
require_once("../../sistema/class/class.functions.php");
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
							$sql = "SELECT * FROM irrf a
									JOIN empresas b
										ON a.ir_cli_id = b.emp_codigo 
									WHERE ir_id = ".$_GET['ircod']." AND ir_cli_id =".$_GET['clicod'] ;
							$rs->FreeSql($sql);
							$rs->GeraDados();
						?>
						<form role="form" id="cad_ir">
							<div class="box-body">
								<div class="row">
									<div class="form-group col-xs-3">
										<label for="ir_doc">Doc.:</label>
										<input type="text" class="form-control" id="ir_doc" name="ir_doc" value="<?=$rs->fld("emp_cnpj");?>" READONLY >
										<input type="hidden" class="form-control" id="ir_cod" name="ir_cod" value="<?=$_GET['ircod'];?>">

									</div>
									<div class="form-group col-xs-6">
										<label for="ir_nome">Nome:</label>
										<input type="text" class="form-control" id="ir_nome" name="ir_nome" value="<?=$rs->fld("emp_razao");?>" READONLY >
									</div>
								</div>
														
								<div class="row">
									<div class="form-group col-xs-2">
										<label for="emp_rzs">Per&iacute;odo:</label>
										<input type="text" class="form-control" id="ir_ano" name="ir_ano" placeholder="Ano" maxlength=4 READONLY value="<?=$rs->fld('ir_ano');?>">
									</div>
									
									<div class="form-group col-xs-2">
										<label for="cep">Valor:</label>
										<input type="text" class="form-control" id="ir_valor" name="ir_valor" placeholder="Valor" value="<?=$rs->fld('ir_valor');?>">
									</div>
									<div class="form-group col-xs-4">
										<label for="cep">Tipo de Serv.:</label>
										<select class="form-control minimal" id="ir_tipo" name="ir_tipo">
											<option value="IRPF" <?=($rs->fld('ir_tipo')=="IRPF"?"SELECTED":"");?>> IRPF - Imposto Renda Pessoa F&iacute;sica </option>
											<option value="GC" <?=($rs->fld('ir_tipo')=="GC"?"SELECTED":"");?>> Ganho de Capital </option>
											<option value="AR" <?=($rs->fld('ir_tipo')=="AR"?"SELECTED":"");?>> Anexo Rural </option>

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
								<button class="btn btn-sm btn-primary" type="button" id="bt_altera_ir"><i class="fa fa-pencil"></i> Alterar</button>
								<a href="javascript:history.go(-1);" class="btn btn-sm btn-danger"><i class="fa fa-file-o"></i> Voltar</a>
								
								
							</div>
						</form>
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

	<script src="<?=$hosted;?>/sistema/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
	<script src="<?=$hosted;?>/triangulo/js/jquery.cookie.js"></script>
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
    <script src="<?=$hosted;?>/triangulo/js/controle.js"></script>
    <script src="<?=$hosted;?>/triangulo/js/action_irrf.js"></script>
    <script src="<?=$hosted;?>/triangulo/js/action_triang.js"></script>
    <script src="<?=$hosted;?>/triangulo/js/functions.js"></script>
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