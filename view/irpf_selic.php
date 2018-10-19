<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start();
$sec = "IRRF";
$pag = "irpf_selic.php";
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
							<h3 class="box-title">Taxa Selic</h3>
						</div><!-- /.box-header -->
						<!-- form start -->
						
						<form role="form" id="cad_ir">
							<div class="box-body">
								<div class="alert alert-info alert-dismissable">
				                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				                    <h4><i class="icon fa fa-info"></i> Aten&ccedil;&atilde;o:</h4>
				                    Antes de cadastrar uma taxa Selic, verifique o site da Receita Federal
				                </div>
								<div class="row">
									<div class="form-group col-xs-2">
										<label for="ir_doc">Refer&ecirc;ncia:</label>
										<input type="text" class="form-control shortdate" id="isel_ref" name="isel_ref" placeholder="Refer&ecirc;ncia" >
									</div>
									<div class="form-group col-xs-2">
										<label for="ir_nome">Taxa (%):</label>
										<input type="text" class="form-control" id="isel_taxa" name="isel_taxa" placeholder="Taxa (%)" >
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
							
								<button class="btn btn-sm btn-primary" type="button" id="bt_novo_selic"><i class="fa fa-plus"></i> Incluir</button>
								
							</div>
						</form>
					</div><!-- ./box -->
					
				</div><!-- ./col -->
				<div class="col-xs-12">
					<div class="box box-success" id="irrf_cli">
						<div class="box-header with-border">
							<h3 class="box-title">Taxas Selic</h3>
						</div><!-- /.box-header -->
						<div class="box-body">
							 <table class="table table-hover table-condensed">
							 	<thead>
									<tr>
										<th class="col-md-1">#</th>
										<th>Refer&ecirc;ncia</th>
										<th>Taxa (%)</th>
										<th>A&ccedil;&otilde;es</th>
									</tr>
								</thead>
								<tbody>
									<!-- Conteúdo dinamico PHP-->
									<?php require_once("irpf_conSelic.php"); ?>
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
        <script src="<?=$hosted;?>/triangulo/js/jquery.cookie.js"></script>
        <script src="<?=$hosted;?>/triangulo/js/functions.js"></script>
	<!-- Validation -->
    <!--<script src="<?=$hosted;?>/js/jquery-validation/dist/jquery.validate.min.js"></script>-->
	<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
	<script>
	// Atualizar a cada 7 segundos
		 setTimeout(function(){
			$("#irrf_cli tbody").load("irrf_conRet.php?token=<?=$_SESSION['token'];?>&clicod=<?=$_GET['clicod'];?>");					 
			$("#alms").load(location.href+" #almsg");	
		 },10000);
		 // POPOVER
	</script>
</body>
</html>