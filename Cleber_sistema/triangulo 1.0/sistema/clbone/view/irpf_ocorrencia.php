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
				<li>Servi&ccedil;os</li>
				<li class="active">Ocorr&ecirc;ncias</li>
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
							<h3 class="box-title">Ocorr&ecirc;ncias de IRPF</h3>
						</div><!-- /.box-header -->
						<!-- form start -->
						<?php
							extract($_GET);
							$rs = new recordset();
							$rs->Seleciona("*","empresas","emp_codigo = ".$clicod);
							$rs->GeraDados();
						?>
						<form role="form" id="ir_ocorr">
							<div class="box-body">
								<div class="row">
									<div class="form-group col-xs-3">
										<label for="ir_doc">Doc.:</label>
										<input type="text" class="form-control" id="ir_doc" name="ir_doc" value="<?=$rs->fld("emp_cnpj");?>" READONLY >
									</div>
									<div class="form-group col-xs-6">
										<label for="ir_nome">Nome:</label>
										<input type="text" class="form-control" id="ir_nome" name="ir_nome" value="<?=$rs->fld("emp_razao");?>" READONLY >
									</div>
									<div class="form-group col-xs-1">
										<label for="ir_doc">IRPF #:</label>
										<input type="text" class="form-control" id="ir_cod" name="ir_cod" value="<?=$ircod;?>" READONLY>

									</div>
								</div>

								<div class="row">
									<div class="form-group col-xs-3">
										<label for="ir_acao">Status:</label><br>
										<select class="select2" style="width:100%;" id="ir_acao" name="ir_acao">
											<option value="">Selecione...</option>
											<?php
											$rs2 = new recordset();
											$rs2->Seleciona("st_codstatus, st_desc","codstatus","st_opcaode like '%[IRPF]%'");
											while($rs2->GeraDados()){?>
												<option value=<?=$rs2->fld("st_codstatus");?>><?=$rs2->fld("st_desc");?></option>
											<?php }
											?>
										</select>
									</div>
								
									<div class="form-group col-xs-7">
										<label for="emp_rzs">Observa&ccedil;&otilde;es:</label>
										<textarea class="form-control" name="ir_obs" id="ir_obs"></textarea>
									</div>
								</div>

								<div id="consulta"></div>
								<div id="formerros_ocorr" class="" style="display:none;">
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
								<button class="btn btn-sm btn-primary btn-app irpflink" 
										type="button"
										id="bt_salvar_ocorr"
										data-codigo="<?=$_GET['ircod']; ?>"
										data-solic="<?=$_GET['acao']; ?>" ><i class="fa fa-save"></i> Salvar</button>
								<a id="cancel_IR" class="btn btn-sm btn-primary btn-app" href="javascript:history.go(-1);"><i class="fa fa-times-circle"></i> Cancelar</a>
								<a id="voltar_IR" class="btn btn-sm btn-primary btn-app" href="javascript:history.go(-1);"><i class="fa fa-folder-open"></i> Voltar p/ IRPFs</a>
								
								
							</div>
						</form>
					</div><!-- ./box -->
					
				</div><!-- ./col -->
				<div class="col-xs-12">
					<div class="box box-success" id="irrf_cli_Oc">
						<div class="box-header with-border">
							<h3 class="box-title">Tr&acirc;mites j&aacute; realizados:</h3>
						</div><!-- /.box-header -->
						<div class="box-body">
							<!-- Conteúdo dinamico PHP-->
							<?php require_once("irpf_conOcorr.php"); ?>
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

	<script src="<?=$hosted;?>/sistema/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
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
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
	<script>
	// Atualizar a cada 7 segundos
		 setTimeout(function(){
			$("#irrf_cli tbody").load("irpf_conOcorr.php?clicod=<?=$_GET['clicod'];?>&ircod=<?=$_GET['ircod'];?>");					 
			$("#alms").load(location.href+" #almsg");	
		 },10000);
		 // POPOVER
		$('[data-toggle="popover"]').popover();

		$(".select2").select2({
			tags: true,
			theme: "classic"
		});

	</script>
</body>
</html>