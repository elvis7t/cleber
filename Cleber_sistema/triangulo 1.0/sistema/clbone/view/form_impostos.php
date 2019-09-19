<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start();
$sec = "CART";
$pag = "form_part.php";
require_once("../config/main.php");
require_once("../config/valida.php");
require_once("../config/mnutop.php");
require_once("../config/menu.php");
require_once("../config/modals.php");
require_once("../../sistema/class/class.functions.php");
require_once("../class/class.permissoes.php");

$per = new permissoes();
$rs = new recordset();
$rs2 = new recordset();
?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
		<!-- Content Header (Page header) -->
        <section class="content-header">
			<h1>
				Impostos e Obriga&ccedil;&otilde;es
				
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
				<div class="box box-primary">
					<form id="cad_imposto" role="form">
						<div class="box-header with-border">
							<h3 class="box-title">Impostos e Obriga&ccedil;&otilde;es</h3>
						</div><!-- /.box-header -->
						<!-- form start -->
						<?php
						//Caso haja o código e ação, consultar no banco de dados
						if(isset($_GET['impid']) && $_GET['impid'] <> "" ){
							$whr = "imp_id = ".$_GET['impid'];
							$rs->Seleciona("*","tipos_impostos", $whr);
							$rs->GeraDados();
							$lin = $rs->linhas;
							
						}
						?>
						<div class="box-body">
							<div class="row">
								<div class="form-group col-md-3">
									<label for="imp_nome">Nome:</label>
									<input class="form-control input-sm" id="imp_nome" name="imp_nome" placeholder="Nome" value="<?=$rs->fld("imp_nome");?>">
									<input type="hidden" name="token" id="token" value="<?=$_SESSION['token']?>">
									<input type="hidden" name="cnpj" id="cnpj" value="<?=$_SESSION['usu_empresa']?>">
									<input type="hidden" name="acao" id="acao" value="<?=($rs->linhas==1?"cli_altImposto":"cli_cadImposto");?>">
									<input type="hidden" name="imp_id" id="imp_id" value="<?=$rs->fld("imp_id");?>">
									
								</div>
								<div class="form-group col-md-2">
									<label for="emp_cnpj">Departamento:</label><br>
									<select class="select2 form-control input-sm" name="imp_depto" id="imp_depto" style="width:100%;">
										<option value="">Selecione:</option>
											<?php
											$whr=(($_SESSION['classe']<=3 OR $_SESSION['lider']=="Y")?"dep_id < 10": "dep_id=".$_SESSION['dep']);
											$rs2->Seleciona("*","departamentos",$whr);
											while($rs2->GeraDados()):	
											?>
												<option <?=($rs2->fld("dep_id")==$_SESSION['dep']?"SELECTED":"");?> value="<?=$rs2->fld("dep_id");?>"><?=$rs2->fld("dep_nome");?></option>
											<?php
											endwhile;
											?>
									</select>
								</div>

								<div class="form-group col-md-2">
									<label for="imp_trib">Tipo:</label><br>
									<select class="select2 form-control input-sm" name="imp_trib" id="imp_trib" style="width:100%;">
										<option value="">Selecione:</option>
										<option <?=($rs->fld("imp_tipo")=="T"?"SELECTED":"");?> value="T">Tributa&ccedil;&atilde;o</option>
										<option <?=($rs->fld("imp_tipo")=="O"?"SELECTED":"");?> value="O">Obriga&ccedil;&atilde;o</option>
										
									</select>
								</div>
								<div class="form-group col-md-2">
									<label for="imp_regra">Regra:</label><br>
									<select class="select2 form-control input-sm" name="imp_regra" id="imp_regra" style="width:100%;">
										<option value="">Selecione:</option>
										<option <?=($rs->fld("imp_regra")=="dia_util"?"SELECTED":"");?> value="dia_util">Antecipar</option>
										<option <?=($rs->fld("imp_regra")=="postpone"?"SELECTED":"");?> value="postpone">Prorrogar</option>
										<option <?=($rs->fld("imp_regra")=="mes_subs"?"SELECTED":"");?> value="mes_subs">M&ecirc;s Subsequente</option>

										
									</select>
								</div>

								<div class="form-group col-md-2">
									<label for="imp_venc">Vencimento:</label><br>
									<input class="form-control input-sm" id="imp_venc" name="imp_venc" placeholder="Venc" maxlength="2" value="<?=$rs->fld("imp_venc");?>">
								</div>
								<div class="form-group col-md-2">
									<label for="imp_venc">Pasta:</label><br>
									<input class="form-control input-sm" id="imp_pasta" name="imp_pasta" placeholder="Pasta" value="<?=$rs->fld("imp_pasta");?>">
								</div>
								<div class="form-group col-md-2">
									<label for="imp_venc">Nome do Arquivo:</label><br>
									<input class="form-control input-sm" id="imp_arquivo" name="imp_arquivo" placeholder="Nome do arquivo"  value="<?=$rs->fld("imp_arquivo");?>">
								</div>
								<div class="form-group col-md-12">
									<label for="imp_desc">Descri&ccedil;&atilde;o:</label><br>
									<textarea class="form-control input-sm" id="imp_desc" placeholder="imp_desc">
										<?=$rs->fld("imp_desc");?>
									</textarea>
								</div>
							</div>
							<div id="consulta"></div>
							<div id="formerros_impostos" class="clearfix" style="display:none;">
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
							
							$con =$per->getPermissao($pag);
							if($lin == 1){
								if($con["A"] == 1){ ?>
									<button type="button" id="bt_cadimpostos" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Atualizar </button>
								<?php }
							}
							else{
								if($con["I"] == 1){ ?>
									<button type="button" id="bt_cadimpostos" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Salvar </button>
								<?php }
							}
							?>
							<a href="javascript:history.go(-1);" class="btn btn-sm btn-danger"><i class="fa fa-hand-o-left"></i> Voltar </a>
						</div>
					</form>
				</div>
			
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
    <script src="<?=$hosted;?>/triangulo/js/controle.js"></script>
    <script src="<?=$hosted;?>/triangulo/js/action_empresas.js"></script>

	<!-- SELECT2 TO FORMS
	-->
	<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
	<!-- Validation -->
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
	<script src="<?=$hosted;?>/sistema/assets/plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="<?=$hosted;?>/sistema/assets/plugins/datatables/dataTables.bootstrap.min.js"></script> 
	<script src="<?=$hosted;?>/triangulo/js/jquery.cookie.js"></script>
	<script src="<?=$hosted;?>/triangulo/js/functions.js"></script>
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
		// Replace the <textarea id="editor1"> with a CKEditor
		// instance, using default configuration.
		CKEDITOR.replace('imp_desc');
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
	
	
	</script>

</body>
</html>	