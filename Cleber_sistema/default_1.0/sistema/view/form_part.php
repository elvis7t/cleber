<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start();
$sec = "Dados";
$pag = "form_part.php";
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
				Clientes - Nova Particularidade
				
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
					<form id="cad_partic" role="form">
						<div class="box-header with-border">
							<h3 class="box-title">Particularidades</h3>
							<small>[<?=$cod ." - ".$rs2->pegar("empresa","tri_clientes","cod = ".$cod);?>]</small>
						</div><!-- /.box-header -->
						<?php
						//Caso haja o código e ação, consultar no banco de dados
						if(isset($_GET['part_id']) && $_GET['part_id'] <> "" ){
							$whr = "part_id = ".$_GET['part_id'];
							$rs->Seleciona("*","particularidades", $whr);
							$rs->GeraDados();
							$lin = $rs->linhas;
							
						}
						?>
						<!-- form start -->
						<div class="box-body">
							<div class="row">
								<div class="form-group col-md-3">
									<label for="part_titulo">T&iacute;tulo:</label>
									<input class="form-control" id="part_titulo" name="part_titulo" placeholder="T&iacute;tulo" value="<?=$rs->fld("part_titulo");?>">
									<input type="hidden" value="<?=$cod;?>" id="part_clicod">
									<input type="hidden" name="token" id="token" value="<?=$_SESSION['token']?>">
									<input type="hidden" name="cnpj" id="cnpj" value="<?=$_SESSION['usu_empresa']?>">
									<input type="hidden" name="acao" id="acao" value="<?=($rs->linhas==1?"cli_altPartic":"cli_cadPartic");?>">
									<input type="hidden" name="part_id" id="part_id" value="<?=$rs->fld("part_id");?>">

								</div>
								<div class="form-group col-md-3">
									<label for="emp_cnpj">Departamento:</label><br>
									<select class="select2" name="sel_dept" id="sel_dept" style="width:100%;">
										<option value="">Selecione:</option>
									
									<?php
									$whr=(($_SESSION['dep']==8 OR $_SESSION['lider']=="Y")?"dep_id < 10": "dep_id=".$_SESSION['dep']);
									$rs2->Seleciona("*","departamentos",$whr);
									while($rs2->GeraDados()):	
									?>
										<option <?=($rs2->fld("dep_id")==$_SESSION['dep']?"SELECTED":"");?> value="<?=$rs2->fld("dep_id");?>"><?=$rs2->fld("dep_nome");?></option>
									<?php
									endwhile;
									?>
									</select>
								</div>
								<div class="form-group col-md-3">
									<label for="part_tipo">Tipo:</label><br>
									<select class="select2" name="part_tipo" id="part_tipo" style="width:100%;">
										<option value="">Selecione:</option>
										<?php
											$whr= "tipobs_id<>0";
											$rs2->Seleciona("*","tipos_obs",$whr);
											while($rs2->GeraDados()):	
											?>
												<option <?=($rs2->fld("tipobs_id")==$rs->fld("part_tipo")?"SELECTED":"");?> value="<?=$rs2->fld("tipobs_id");?>"><?=$rs2->fld("tipobs_desc");?></option>
											<?php
											endwhile;
										?>
									</select>
								</div>
								<div class="form-group col-md-3">
									<label for="part_ativo">Status</label><br>
									<input type="radio" value=1  id="part_ativo" <?=($rs->fld("part_ativo")==1?"CHECKED":"");?> name="part_ativo"> Ativo 
									<input type="radio" value=0  id="part_ativo" <?=($rs->fld("part_ativo")==0?"CHECKED":"");?> name="part_ativo"> Inativo
								</div>
							</div>
							<div class="row <?=(($rs->fld("part_tipo")==5 OR $rs->fld("part_tipo")==6)?"":"hide");?> id="rowlei">
								<div class="form-group col-md-3">
									<label for="part_titulo">Lei:</label>
									<input class="form-control" id="part_lei" name="part_lei" placeholder="Lei" value="<?=$rs->fld("part_lei");?>">
								</div>
								<div class="form-group col-md-6">
									<label for="part_titulo">Link:</label>
									<input class="form-control" id="part_link" name="part_link" placeholder="Link" value="<?=$rs->fld("part_link");?>">
								</div>
							</div>
							<div class="row">
								<div class="form-group col-md-12">
								<?php
									/*--------|Alteração - Cleber Marrara - 28.04.2017|------*\
									\*	Permissão para alteração - em essa permissão, o usuário não pode alterar*/
									$con = $per->getPermissao($pag,$_SESSION['usu_cod']);
									$readonly = "";
									if($con["A"] == 0){
										$readonly = "disabled";
									}
								?>
									<label for="part_obs">Observa&ccedil;&otilde;es:</label><br>
									<textarea class="form-control" id="part_obs" <?=$readonly;?> placeholder="part_obs"><?=$rs->fld("part_obs");?></textarea>
								</div>
							</div>
							<div id="consulta"></div>
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
							
							//echo $con["A"];
							if($lin == 1){
								if($con["A"] == 1){ ?>
									<button type="button" id="bt_partic" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Atualizar </button>
								<?php }
							}
							else{
								if($con["I"] == 1){ ?>
									<button type="button" id="bt_partic" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Salvar </button>
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
    <script src="<?=$hosted;?>/js/action_triang.js"></script>

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
		// Replace the <textarea id="editor1"> with a CKEditor
		// instance, using default configuration.
		CKEDITOR.replace('part_obs');
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
	/* ALTERAÇÂO 15.maio.2017 - Chamado #625
		Cleber Marrara - informatica@triangulocontabil.com.br
		Caso o tipo da ocorrênca seja LEGISLAÇÃO, deve se abrir
		campos para o numero da Lei e o Link.
	*/
	$(document.body).on("change","#part_tipo",function(){
		if($(this).val()==5 || $(this).val()==6){//Legistação [tabela tipo_obs]
			$("#rowlei").removeClass("hide");
		}
		else{
			$("#rowlei").addClass("hide");
		}
	});

	
	</script>

</body>
</html>	