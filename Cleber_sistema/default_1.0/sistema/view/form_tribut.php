<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start();
$sec = "Dados";
$pag = "form_tribut.php";
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
$cod = (isset($_GET['clicod']) ? $_GET['clicod'] : 477);
?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
		<!-- Content Header (Page header) -->
        <section class="content-header">
			<h1>
				Clientes - Nova Tributa&ccedil;&atilde;o
				
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
					<form id="cad_trib" role="form">
						<div class="box-header with-border">
							<h3 class="box-title">Tributa&ccedil;&otilde;es</h3>
							<small>[<?=$cod ." - ".$rs->pegar("empresa","tri_clientes","cod = ".$cod);?>]</small>
						</div><!-- /.box-header -->
						<?php
						//Caso haja o código e ação, consultar no banco de dados
						if(isset($_GET['tr_id']) && $_GET['tr_id'] <> "" ){
							$whr = "ob_id = ".$_GET['tr_id'];
							$rs2->Seleciona("*","obrigacoes", $whr);
							$rs2->GeraDados();
							$lin = $rs2->linhas;
						}

						?>

						<!-- form start -->
						<div class="box-body">
							<div class="row">
								<div class="form-group col-md-4">
									<label for="tr_depto">Departamento:</label><br>
									<select class="select2" name="tr_depto" id="tr_depto" style="width:100%;">
										<option value="">Selecione:</option>
									
									<?php
									$whr=($_SESSION['dep']==8?"dep_id < 10": "dep_id=".$_SESSION['dep']);
									$rs->Seleciona("*","departamentos",$whr);
									while($rs->GeraDados()):	
									?>
										<option value="<?=$rs->fld("dep_id");?>"><?=$rs->fld("dep_nome");?></option>
									<?php
									endwhile;
									?>
									</select>
								</div>


								<div class="form-group col-md-3">
									<label for="tr_titulo">Titulo:</label>
									<select id="tr_titulo" name="tr_titulo" class="form-control select2" style="width:100%">
										<option value="">Selecione:</option>
										
									</select>	
									<input type="hidden" value="<?=$cod;?>" id="tr_clicod">
									<input type="hidden" name="token" id="token" value="<?=$_SESSION['token']?>">
									<input type="hidden" name="cnpj" id="cnpj" value="<?=$_SESSION['usu_empresa']?>">
									<input type="hidden" name="acao" id="acao" value="<?=($rs2->linhas==1?"cli_Alttrib":"cli_Cadtrib");?>">
									<input type="hidden" name="tr_id" id="tr_id" value="<?=$rs2->fld("ob_id");?>">
								</div>
								
								
								<div class="form-group col-md-3">
									<label for="emp_uf">Status</label><br>
									<input type="radio" value=1  id="tr_ativo" <?=($rs2->fld("tr_ativo")==1?"CHECKED":"");?> name="tr_ativo"> Ativo 
									<input type="radio" value=0  id="tr_ativo" <?=($rs2->fld("tr_ativo")==0?"CHECKED":"");?> name="tr_ativo"> Inativo
								</div>
							</div>
							<div id="consulta"></div>
							<div id="formerros_trib" class="clearfix" style="display:none;">
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
							$con =$per->getPermissao($pag, $_SESSION['usu_cod']);
							//echo $con["I"];
							if($lin == 1){
								if($con["A"] == 1){ ?>
									<button type="button" id="bt_cadTrib" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Atualizar </button>
								<?php }
							}
							else{
								if($con["I"] == 1){ ?>
									<button type="button" id="bt_cadTrib" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Salvar </button>
								<?php }
							}
							?>
							<a href="javascript:history.go(-1);" class="btn btn-sm btn-danger"><i class="fa fa-hand-o-left"></i> Voltar </a>

						</div>
					</form>
					<div id="consulta"></div>
				</div>
			
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
   <!-- Slimscroll -->
    <script src="<?=$hosted;?>/assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="<?=$hosted;?>/assets/js/maskinput.js"></script>
    <script src="<?=$hosted;?>/assets/js/jmask.js"></script>
    <script src="<?=$hosted;?>/js/controle.js"></script>
    <script src="<?=$hosted;?>/js/action_empresas.js"></script>

	<!-- SELECT2 TO FORMS
	-->
	<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
	<!-- Validation -->
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
	<script src="<?=$hosted;?>/assets/plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="<?=$hosted;?>/assets/plugins/datatables/dataTables.bootstrap.min.js"></script> 
	<script src="<?=$hosted;?>/js/jquery.cookie.js"></script>
	<script src="<?=$hosted;?>/js/functions.js"></script>
	<script src="<?=$hosted;?>/assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
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
		// Replace the <textarea id="com_obs"> with a CKEditor
		// instance, using default configuration.
		CKEDITOR.replace('com_obs');
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

	$("#tr_depto").change(function(){
		$("#tr_titulo").select2("val",0);
		$.post("../controller/TRIEmpresas.php",
		{
			acao: 	"opt_obtitulo",
			dept: 	$("#tr_depto").val(),
			tipo: 	"'T'",
			codi: 	$("#tr_clicod").val(),
			obid: 	$("#tr_id").val()
		},
		function(data){
			$("#tr_titulo").html(data);
			console.log(data);
		},
		"html");
	});
	
	
	</script>

</body>
</html>	