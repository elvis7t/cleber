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
				<small>Contatos e Dados Adicionais [<strong><?=(isset($_GET['cnpj']) ? $rs->pegar("emp_razao","empresas","emp_cnpj='".$_GET['cnpj']."'") : ""); ?></strong>]</small>
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
							?>
							<li><a href="#tab_4" data-toggle="tab">IRPF</a></li>
							<li><a href="#tab_6" data-toggle="tab">Documentos</a></li>
							<li><a href="#tab_5" data-toggle="tab">Demonstrativo</a></li>
							<li><a href="#tab_3" data-toggle="tab">Observa&ccedil;&otilde;es</a></li>
							<li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane active" id="tab_1">
								<div class="box box-primary">
									<div class="box-body">
										<div class="row">
											
											<div class="form-group col-md-3">
												<label for="emp_cnpj">CPF</label>
												<input class="form-control" readonly id="emp_cnpj" placeholder="CNPJ" value="<?=$cpf;?>">
												<input type="hidden" id="emp_cod" value="<?=$rs->fld("emp_codigo");?>" />
												<input type="hidden" id="token" value="<?=$_SESSION["token"];?>" />
											</div>
											<div class="form-group col-md-3">
												<label for="emp_cod_ac">C&oacute;d de Acesso:</label>
												<input class="form-control"  id="emp_cod_ac" placeholder="Codigo de Acesso" value="<?=$cod_ac;?>">
												
											</div>
											<div class="form-group col-md-3">
												<label for="emp_senha_ac">Senha IR:</label>
												<input class="form-control" id="emp_senha_ac" placeholder="Senha IR" value="<?=$senha_ac;?>">
												
											</div>
										</div>
										<div class="row">
											<div class="form-group col-xs-5">
												<label for="emp_rzs">Nome:</label>
												<input class="form-control text-uppercase" id="emp_rzs" placeholder="Raz&atilde;o Social" value="<?=$nome;?>">
											</div>
											<div class="form-group col-xs-3">
												<label for="emp_nasc">Nasc:</label>
												<input class="form-control" id="emp_nasc" placeholder="Data de Nascimento" value="<?=$data;?>">
											</div>
											<div class="form-group col-xs-4">
												<label for="emp_benef">Benef&iacute;cio:</label>
												<input class="form-control text-uppercase" id="emp_benef" placeholder="Benef&iacute;cio" value="<?=$benef;?>">
											</div>
											

										</div>
											
										<div class="row">
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
									</div>
									<div class="box-footer">
										<button id="bt_altera_end" class="btn btn-sm btn-primary"><i class="fa fa-pencil"></i> Alterar Dados </button>
									</div>
										<div id="consulta"></div>
									</div>
								
								
								
							</div><!-- /.tab-pane -->
							<div class="tab-pane" id="tab_2">
								<div class="box box-primary">
									<div class="box-body">
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
														<div id="formerros_dados" class="" style="display:none;">
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
									</div>
								</div>
							</div><!-- /.tab-pane -->
				
							
							<div class="tab-pane" id="tab_4">
								<div class="box box-primary">
									<div class="box-body">
								<!--IRRF-->
										<div>
											 <table class="table table-striped table-condensed">
											 	<thead>
													<tr>
														<th>#Id IRPF</th>
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
									</div>
									<div class="box-footer">
										<a href="novo_irrf.php?token=<?=$_SESSION['token'];?>&clicod=<?=$_GET['clicod'];?>" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Incluir</a>
									</div>
								</div>
							</div><!-- /.tab-pane -->

							<div class="tab-pane" id="tab_5">
								<?php
									require_once("irpf_consulta_extrato.php");
								?>
							</div><!-- /.tab-pane -->

							<div class="tab-pane" id="tab_6">
								<!--DOCUMENTOS-->
								<div class="box box-primary">
									<div class="box-body">
										<?php 
											require_once("tabl_arqs.php");
										?>
									
									</div>
									<div class="box-footer">
										<a href="empresas_docs.php?token=<?=$_SESSION['token'];?>&clicod=<?=$_GET['clicod']; ?>&doc_pes=<?=$doc;?>"
											class='btn btn-sm btn-success' 
											data-toggle='tooltip' 
											data-placement='bottom' 
											title='Novo DOC'><i class='fa fa-save'></i> Enviar Documento
										</a>
									</div>
								</div>
							</div><!-- /.tab-pane -->
							<div class="tab-pane" id="tab_3">
								<!--OBSERVAÇÔES-->
						
								<div class="box box-primary">
									<form id="alt_obs" role="form">
										
										<!-- form start -->
										<div class="box-body">
											<div class="row">
												<div class="form-group col-md-5">
													<div class="form-group col-md-12">
														<label for="emp_obs">Observa&ccedil;&otilde;es:</label><br>
														<textarea class="form-control" id="emp_obs" placeholder="emp_obs"><?=$observacao;?></textarea>
													</div>

													<div class="form-group col-md-12">
														<label for="emp_obs">Arquivos:</label><br>
														<table class="table table-striped">
															<tr>
																<th>#Cod</th>
																<th>Arquivo</th>
																<th>Visuzalizar</th>
															</tr>

																<?php
																$sql ="SELECT * FROM documentos WHERE doc_cli_cnpj='".$_GET['cnpj']."'";
																$rs->FreeSql($sql);
																if($rs->linhas==0){?>
																	<td colspan=3>Nenmhum arquivo...</td>
																<?php }
																else{
																	while($rs->GeraDados()){?>
																		<tr>
																			<td><?=$rs->fld("doc_cod");?></td>
																			<td><?=$rs->fld("doc_desc");?></td>
																			<td>
																				<a href="javascript:ver_docs('div_varq','<?=$rs->fld("doc_ender");?>')" class="btn btn-primary btn-sm">
																					<i class="fa fa-book"></i>
																				</a>
																			</td>
																		</tr>
																	<?php }
																}

															?>
														</table>
														
													</div>
												</div>
												<div class="form-group col-md-7">
													<div class="box box-success">
														<div id="file_pdf">
															<iframe id="div_varq" style="border:0; width:100%;height:700px;" src=""></iframe>
														</div>
													</div>
												</div>
											</div>
											<div id="consulta_OBS"></div>
											<div id="formerros_partic" class="clearfix" style="display:none;">
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
							
											$con =$per->getPermissao("observacoes",$_SESSION['usu_cod']);
											//echo $con["A"];
											if($lin == 1){
												if($con["A"] == 1){ ?>
													<button type="button" id="dados_sal_Obs" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Atualizar </button>
												<?php }
											}
											else{
												if($con["I"] == 1){ ?>
													<button type="button" id="dados_sal_Obs" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Salvar </button>
												<?php }
											}
											?>

										</div>
									</form>
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

<script src="<?=$hosted;?>/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?=$hosted;?>/assets/bootstrap/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="<?=$hosted;?>/assets/plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?=$hosted;?>/assets/dist/js/app.min.js"></script>
   <!-- Slimscroll -->
    <script src="<?=$hosted;?>/assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="<?=$hosted;?>/assets/js/maskinput.js"></script>
    <script src="<?=$hosted;?>/assets/js/jmask.js"></script>
    <script src="<?=$hosted;?>/js/controle.js"></script>
    <script src="<?=$hosted;?>/js/action_empresas.js"></script>
    <script src="<?=$hosted;?>/js/action_irrf.js"></script>
    <script src="<?=$hosted;?>/js/functions.js"></script>
	<!-- SELECT2 TO FORMS-->
		<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
	<!--INPUT-->
	<script src="<?=$hosted;?>/assets/plugins/input-mask/jquery.inputmask.js"></script>
    <script src="<?=$hosted;?>/assets/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src="<?=$hosted;?>/assets/plugins/input-mask/jquery.inputmask.extensions.js"></script>
	<!-- Validation -->
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
	<script src="<?=$hosted;?>/js/jquery.cookie.js"></script>
	<script src="<?=$hosted;?>/assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
	<script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
	 

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
		tags: true
	});
	 $(function () {
		// Replace the <textarea id="editor1"> with a CKEditor
		// instance, using default configuration.
		CKEDITOR.replace('emp_obs');
		$("#emp_nasc").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/aaaa"});
		
	});

	</script>

</body>
</html>	