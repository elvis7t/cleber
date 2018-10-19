<?php
/*inclusão dos principais itens da página */
error_reporting(E_ALL & E_NOTICE & E_WARNING);
//session_start("portal");
$sec = "Dados";
$pag = "form_senhas.php";
require_once("../config/main.php");
require_once("../config/valida.php");
require_once("../config/mnutop.php");
require_once("../config/menu.php");
require_once("../config/modals.php");
require_once("../class/class.functions.php");
require_once("../class/class.permissoes.php");

$per = new permissoes();
$rs = new recordset();
$cod = (isset($_GET['clicod']) ? $_GET['clicod'] : 477);
?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
		<!-- Content Header (Page header) -->
        <section class="content-header">
			<h1>
				Clientes - Nova Senha
				
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
				<div class="box-header with-border">
					<h3 class="box-title">Senhas</h3>
					<small>[<?=$cod ." - ".$rs->pegar("empresa","tri_clientes","cod = ".$cod);?>]</small>
				</div><!-- /.box-header -->
				<?php
				$cod = (isset($_GET['clicod']) ? $_GET['clicod'] : 477);
				$whr = (isset($_GET['clicod']) ? "cod =".$cod : "cnpj ='".$_GET['cnpj']."'");
				
				$rs->Seleciona("*","tri_clientes",$whr);
				$rs->GeraDados();
				$rom = ($rs->linhas==0 ? "" : "readonly");
				?>
				<!-- form start -->
				<form id="cad_senhas" role="form">
				<div class="box-body">
						<?php
							if(isset($_GET['sen_id']) && $_GET['sen_id'] <> "" ){
							$whr = "sen_id = ".$_GET['sen_id'];
							$rs->Seleciona("*","senhas", $whr);
							echo $rs->sql;
							$lin = $rs->linhas;
							$rs->GeraDados();

							
						}
						?>
					<div class="row">
						<div class="form-group col-md-3">
							<label for="sen_desc">Descri&ccedil;&atilde;o:</label>
							<input class="form-control" id="sen_desc" name="sen_desc" placeholder="Descri&ccedil;&atilde;o" value="<?=$rs->fld("sen_desc");?>">
							<input type="hidden" value="<?=$cod;?>" id="sen_clicod">
							<input type="hidden" value="<?=$_SESSION['token'];?>" id="token">
							<input type="hidden" value="<?=$_SESSION['usu_empresa'];?>" id="cnpj">
							<input type="hidden" name="acao" id="acao" value="<?=($lin==1?"cli_altSenha":"cli_cadSenha");?>">
							<input type="hidden" name="sen_id" id="sen_id" value="<?=$rs->fld("sen_id");?>">
						</div>
						<div class="form-group col-md-4">
							<label for="sen_acesso">Acesso:</label>
							<input class="form-control" id="sen_acesso" name="sen_acesso" placeholder="Site a acessar" value="<?=$rs->fld("sen_acesso");?>">
						</div>
						
						<div class="form-group col-md-3">
							<label for="sen_user">Usu&aacute;rio:</label>
							<input class="form-control" id="sen_user" name="sen_user" placeholder="Usu&aacute;rio" value="<?=$rs->fld("sen_user");?>">
						</div>
						<div class="form-group col-md-2">
							<label for="sen_senha">Senha:</label>
							<input class="form-control" id="sen_senha" name="sen_senha" placeholder="Senha" value="<?=$rs->fld("sen_senha");?>">
						</div>
						<div class="form-group col-md-12">
							<label for="emp_uf">Observa&ccedil;&otilde;es:</label><br>
							<textarea class="form-control" id="editor_senha" placeholder="editor_senha"><?=$rs->fld("sen_obs");?></textarea>
						</div>
					</div>
					
					<div id="consulta"></div>
					<div id="formerros_Senha" class="clearfix" style="display:none;">
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
					$con =$per->getPermissao($pag,$_SESSION['usu_cod']);
					if(isset($lin) AND $lin == 1){
								if($con["A"] == 1){ ?>
									<button type="button" id="bt_cadcliSenhas" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Atualizar </button>
								<?php }
							}
							else{
								if($con["I"] == 1){ ?>
									<button type="button" id="bt_cadcliSenhas" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Salvar </button>
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
		// Replace the <textarea id="editor1"> with a CKEditor
		// instance, using default configuration.
		CKEDITOR.replace('editor_senha');
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