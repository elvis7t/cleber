<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start();
$sec = "Dados";
$pag = "dados_emp.php";
require_once("../config/main.php");
require_once("../config/valida.php");
require_once("../config/mnutop.php");
require_once("../config/menu.php");
require_once("../../sistema/config/modals.php");
require_once("../../sistema/class/class.functions.php");
$rs = new recordset();
?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
		<!-- Content Header (Page header) -->
        <section class="content-header">
			<h1>
				Clientes - Detalhes
				<small>Contatos e Dados Adicionais <b class="fa fa-caret-right"></b> <?=(isset($_GET['cnpj']) ? $rs->pegar("emp_nome","empresas","emp_cnpj='".$_GET['cnpj']."'") : ""); ?></small>
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
							?>
							<li><a href="#tab_4" data-toggle="tab">IRPF</a></li>
							<li><a href="#tab_6" data-toggle="tab">Documentos</a></li>
							<li><a href="#tab_5" data-toggle="tab">Outros Docs</a></li>
							<li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane active" id="tab_1">
								<div class="box box-primary">
									<div class="box-body">
										<div class="row">
											<div class="form-group col-md-5">
												<label for="emp_cnpj">CPF</label>
												<input class="form-control" readonly id="emp_cnpj" placeholder="CNPJ" value="<?=$rs->fld("emp_cnpj");?>">
												<input type="hidden" id="emp_cod" value="<?=$rs->fld("emp_codigo");?>" />
											</div>
										</div>
										<div class="row">
											<div class="form-group col-xs-6">
												<label for="emp_rzs">Nome:</label>
												<input class="form-control text-uppercase" id="emp_rzs" placeholder="Raz&atilde;o Social" value="<?=$rs->fld("emp_razao");?>">
											</div>
											
											<div class="form-group col-xs-3">
												<label for="emp_cep">CEP</label>
												<input class="form-control" id="cep" placeholder="CEP" value="<?=$rs->fld("emp_cep");?>">
											</div>
											<div class="form-group col-xs-5">
												<label for="emp_log">Logradouro</label>
												<input class="form-control text-uppercase" id="log" placeholder="Logradouro" value="<?=$rs->fld("emp_logr");?>">
											</div>
											<div class="form-group col-xs-2">
												<label for="emp_num">N&uacute;mero</label>
												<input class="form-control" id="num" placeholder="Num.:" value="<?=$rs->fld("emp_num");?>">
											</div>
											<div class="form-group col-xs-2">
												<label for="emp_comp">Complemento</label>
												<input class="form-control text-uppercase" id="compl" placeholder="Compl.:" value="<?=$rs->fld("emp_compl");?>">
											</div>
											<div class="form-group col-xs-5">
												<label for="emp_bai">Bairro</label>
												<input class="form-control text-uppercase" id="bai" placeholder="Bairro" value="<?=$rs->fld("emp_bairro");?>">
											</div>
											<div class="form-group col-xs-5">
												<label for="emp_cid">Cidade</label>
												<input class="form-control text-uppercase" id="cid" placeholder="Cidade" value="<?=$rs->fld("emp_cidade");?>">
											</div>
											<div class="form-group col-xs-2">
												<label for="emp_uf">UF</label>
												<input class="form-control text-uppercase" id="uf" placeholder="UF" value="<?=$rs->fld("emp_uf");?>">
											</div>
										</div>
										<div class="box-footer">
										<button id="bt_altera_end" class="btn btn-sm btn-primary"><i class="fa fa-pencil"></i> Alterar Dados </button>
										</div>
										<div id="consulta"></div>
									</div>
								</div>
								
								
							</div><!-- /.tab-pane -->
							<div class="tab-pane" id="tab_2">
								<div id="tabela_ctt">
									<?php require_once("contatos.php"); ?>
								</div>
								<div class="box box-default">
									<div class="box-body">
										<form role="form" id="cad_dados">
											
												<div class="input-group col-md-8">
													<div class="input-group-btn">
														<button type="button" class="btn btn-default btn-sm dropdown-toggle" id="add1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-phone" id="tpcon"></i> <span class="caret"></span></button>
														<ul class="dropdown-menu">
														  <li><a href="#" data-type="tel"><i class="fa fa-phone"></i> Telefone</a></li>
														  <li><a href="#" data-type="cel"><i class="fa fa-mobile"></i> Celular</a></li>
														  <li><a href="#" data-type="wts"><i class="fa fa-whatsapp"></i> WhatsApp</a></li>
														  <li role="separator" class="divider"></li>
														  <li><a href="#" data-type="mail"><i class="fa fa-envelope"></i> E-Mail</a></li>
														  <li><a href="#" data-type="site"><i class="fa fa-file-code-o"></i> Site:</a></li>
														</ul>
													</div><!-- /btn-group -->
													<input type="text" id="con_tipo" name="con_tipo" class="form-control tel" aria-labeledby="add1"/>
													<input type="hidden" name="clicod" id="clicod" value="<?=$_GET['clicod'];?>" />
												</div>
												<br>
												<div id="formerros1" class="" style="display:none;">
													<div class="callout callout-danger">
														<h4>Erros no preenchimento do formul&aacute;rio.</h4>
														<p>Verifique os erros no preenchimento acima:</p>
														<ol>
															<!-- Erros são colocados aqui pelo validade -->
														</ol>
													</div>
												</div>
												<br>	
												<button type="button" id="bt_add_cont" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Adicionar...</button>
												
											
										</form>
									</div><!-- /.box-body -->
								</div><!-- /.box -->
								
							</div><!-- /.tab-pane -->
				
							
							<div class="tab-pane" id="tab_4">
								<!--IRRF-->
								<div>
									 <table class="table table-striped">
									 	<thead>
											<tr>
												<th>Tipo</th>
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
							</div><!-- /.tab-pane -->

							<div class="tab-pane" id="tab_5">
								<div id="tabela_outros">
									<?php require_once("irpf_outrosdocs.php"); ?>
								</div>
								<div class="box box-default">
									<form role="form" id="cad_outros">
										<div class="box-body">
											<div class="row">
												<div class="col-md-4">
													<label from="doc_tipo">Tipo:</label><br>
													<select class="select2 form-control" id="doc_tipo" name="doc_tipo" style="width:100%;">
														<option value="0">Selecione:</option>
														<option value="fa fa-credit-card">Benef&iacute;cio</option>
													</select>
												</div>
											</div>
											<div class="row">
												<div class="col-md-4">
													<label from="doc_numero">Dados</label>
													<input type="text" id="doc_numero" name="doc_numero" class="form-control input-sm" />
													<input type="hidden" name="clicod" id="clicod" value="<?=$_GET['clicod'];?>" />
												</div>
											</div>
											<br>
											<div id="formerros_outros" class="" style="display:none;">
												<div class="callout callout-danger">
													<h4>Erros no preenchimento do formul&aacute;rio.</h4>
													<p>Verifique os erros no preenchimento acima:</p>
													<ol>
														<!-- Erros são colocados aqui pelo validade -->
													</ol>
												</div>
											</div>
											<br>
											<div id="consulta_outros"></div>										
										</div><!-- /.box-body -->
										<div class="box-footer">
											<button type="button" id="bt_add_outros" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Adicionar...</button>
										</div>
									</form>
								</div><!-- /.box -->
								
							</div><!-- /.tab-pane -->
							<div class="tab-pane" id="tab_6">
								<!--DOCUMENTOS-->
								<div>
									<?php 
									require_once("tabl_arqs.php");
									?>
								</div>
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
    <script src="<?=$hosted;?>/triangulo/js/controle.js"></script>
    <script src="<?=$hosted;?>/triangulo/js/action_empresas.js"></script>
    <script src="<?=$hosted;?>/triangulo/js/functions.js"></script>
	<!-- SELECT2 TO FORMS
	-->
	<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
	<!-- Validation -->
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
	<script src="<?=$hosted;?>/triangulo/js/jquery.cookie.js"></script>

	<script type="text/javascript">
		setInterval(function(){

			$("#chatContent").load(location.href+" #msgs");	
			$("#chatContent").scrollTop($("#msgs").height());
			
			
			if($.cookie('msg_lido')==0) {
				notify($.cookie("user"), $.cookie("mensagem"),$.cookie("pag"));
				$.cookie("msgant");
				$.cookie('msg_lido',1);
			}
		},3500);

	$(".select2").select2({
		tags: true,
		theme: "classic"
	});
	
	</script>

</body>
</html>	