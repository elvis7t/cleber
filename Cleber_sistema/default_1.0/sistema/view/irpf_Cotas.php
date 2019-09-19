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
							$ircod = $_GET['ircod'];
							$rs = new recordset();
							$sql_ir = "SELECT * FROM irrf a 
											JOIN empresas b ON a.ir_cli_id = b.emp_codigo
										WHERE ir_id=".$ircod;
							$rs->FreeSql($sql_ir);
							$rs->GeraDados();
						?>
						<form role="form" id="cad_ir">
							<div class="box-body">
								<div class="row">
									<div class="form-group col-xs-2">
										<label for="ir_doc">Doc.:</label>
										<input type="text" class="form-control" id="iret_doc" name="iret_doc" value="<?=$rs->fld("emp_cnpj");?>" READONLY >
									</div>
									<div class="form-group col-xs-5">
										<label for="ir_nome">Nome:</label>
										<input type="text" class="form-control" id="iret_nome" name="iret_nome" value="<?=$rs->fld("emp_razao");?>" READONLY >
									</div>
								</div>
								<div class="row">
									<div class="form-group col-xs-2">
										<label for="ir_nome">#IRPF</label>
										<input type="text" class="form-control" id="iret_irid" name="iret_irid" value="<?=$rs->fld("ir_Id");?>" READONLY >
									</div>
									<?php
										$rs2 = new recordset();
										$rs2->Seleciona("iret_id","irpf_retorno","iret_ir_id=".$ircod);
										if($rs2->linhas<>0):?>
											</div>
												<div class="row callout callout-success col-xs-7">
	                    							<h4>J&aacute; existe um retorno para essa declara&ccedil;&atilde;o</h4>
		                  						</div>
	                  						
										<?php else:
									?>
									<div class="form-group col-xs-3">
										<label for="cep">Tipo:</label>
										<select class="form-control" id="iret_tipo" name="iret_tipo">
											<option value="SSI">Sem Saldo de Imposto</option>
											<option value="IAP">Imposto &agrave; Pagar</option>
											<option value="IAR">Imposto &agrave; Restituir</option>
										</select>
									</div>
									<div class="hide" id="IAP">
										<div class="form-group col-xs-2">
											<label for="emp_rzs">Valor:</label>
											<input type="text" class="form-control" id="iret_valor" name="iret_valor" placeholder="Valor">
										</div>
										
										<div class="form-group col-xs-3">
											<label for="cep">Cotas:</label>
											<select class="form-control" id="iret_cotas" name="iret_cotas">
												<option value="0">Selecione:</option>
												<option value="1">&Uacute;nica</option>
												<option value="2">2</option>
												<option value="3">3</option>
												<option value="4">4</option>
												<option value="5">5</option>
												<option value="6">6</option>
												<option value="7">7</option>
												<option value="8">8</option>
											</select>
										</div>
									</div>
									<div class="hide" id="IAR">
										<div class="form-group col-xs-2">
											<label for="cep">Dt Rest:</label>
											<input type="text" class="form-control date" id="iret_data" name="iret_data" placeholder="Data">
										</div>
										
									</div>
								</div>
								<?php 
									endif;
								?>
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
							<?php
								if($rs2->linhas==0){
							?>
								<button class="btn btn-sm btn-primary" type="button" id="bt_novo_irec"><i class="fa fa-plus"></i> Incluir</button>
							<?php }
							?>
								
							</div>
						</form>
					</div><!-- ./box -->
					
				</div><!-- ./col -->
				<div class="col-xs-12">
					<div class="box box-success" id="irrf_cli">
						<div class="box-header with-border">
							<h3 class="box-title">Retornos encontrados:</h3>
						</div><!-- /.box-header -->
						<div class="box-body">
							 <table class="table table-striped">
							 	<thead>
									<tr>
										<th>Retorno</th>
										<!--<th>Doc.</th>
										<th>Nome</th>-->
										<th>Dt Lib.</th>
										<th>Valor</th>
										<th>Parcelas</th>
										<th>Vencimento</th>
										<th>A&ccedil;&otilde;es</th>
									</tr>
								</thead>
								<tbody>
									<!-- Conteúdo dinamico PHP-->
									<?php require_once("irpf_conDarf.php"); ?>
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
			$("#irrf_cli tbody").load("irrf_conRet.php?token=<?=$_SESSION['token'];?>&clicod=<?=$_GET['clicod'];?>");					 
			$("#alms").load(location.href+" #almsg");	
		 },10000);
		 // POPOVER
		$('[data-toggle="popover"]').popover();
		$("#iret_tipo").on("change", function(){
			var tipo =$(this).val();
			//console.log(tipo);
			$("#IAR, #IAP").addClass("hide");
			$("#"+tipo).removeClass("hide");
		});

	</script>
</body>
</html>