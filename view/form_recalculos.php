<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start();
$sec = "CART";
$pag = "form_recalculos";
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
				Gerenciador de Tipos de Recalculos
				
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li>Gerenciamento</li>
				<li>Recalculos</li>
				<li class="active">Detalhes</li>
				
			</ol>
        </section>

        <!-- Main content -->
        <section class="content">
				<div class="box box-primary">
					<form id="cad_arquivo" role="form">
						<div class="box-header with-border">
							<h3 class="box-title">Tipos de Recalculos</h3>
						</div><!-- /.box-header -->
						<!-- form start -->
						<?php
						//Caso haja o código e ação, consultar no banco de dados
						if(isset($_GET['tarqid']) && $_GET['tarqid'] <> "" ){
							$whr = "tarq_id = ".$_GET['tarqid'];
							$rs->Seleciona("*","tipos_arquivos", $whr);
							$rs->GeraDados();
							$lin = $rs->linhas;
							
						}
						?>
						<div class="box-body">
							<div class="row">
								<div class="form-group col-md-3">
									<label for="tarq_nome">Nome:</label>
									<input class="form-control" id="tarq_nome" name="tarq_nome" placeholder="Nome" value="<?=$rs->fld("tarq_nome");?>">
									<input type="hidden" name="token" id="token" value="<?=$_SESSION['token']?>">
									<input type="hidden" name="cnpj" id="cnpj" value="<?=$_SESSION['usu_empresa']?>">
									<input type="hidden" name="acao" id="acao" value="<?=($rs->linhas==1?"cli_altArquivo":"cli_cadArquivo");?>">
									<input type="hidden" name="arq_id" id="arq_id" value="<?=$rs->fld("tarq_id");?>">
									
								</div>
								<div class="form-group col-md-3">
									<label for="tarq_depto">Departamento:</label><br>
									<select class="select2 form-control input-sm" name="tarq_depto" id="tarq_depto" style="width:100%;">
										<option value="">Selecione:</option>
											<?php
											$con = $per->getPermissao("todos_depart",$_SESSION['usu_cod']);
											$whr = "dep_id <>0";
											if($con["C"]==0){$whr .=" AND dep_id = ".$_SESSION['dep']; } //Permissão todos os departamentos
											$rs2->Seleciona("*","departamentos",$whr);
											while($rs2->GeraDados()):	
											?>
												<option value="<?=$rs2->fld("dep_id");?>" <?=($rs->fld("tarq_depart")==$rs2->fld("dep_id")?"SELECTED":"");?>><?=$rs2->fld("dep_nome");?></option>
											<?php
											endwhile;
											?>
									</select>
								</div>

								<div class="form-group col-md-6">
									<label for="tarq_formato">Formato:</label>
									<input class="form-control" id="tarq_formato" name="tarq_formato" placeholder="Formato" value="<?=$rs->fld("tarq_formato");?>">
								</div>
								
								<div class="form-group col-md-3">
									<label for="tarq_duplica">M&uacute;ltiplos:</label><br>
									<select class="select2 form-control input-sm" name="tarq_duplica" id="tarq_duplica" style="width:100%;">
										<option value="">Selecione:</option>
										<option value="Y" <?=($rs->fld("tarq_duplica")=="Y"?"SELECTED":"");?> >Sim</option>
										<option value="N" <?=($rs->fld("tarq_duplica")=="N"?"SELECTED":"");?> >N&atilde;o</option>
											
									</select>
								</div>

								<div class="form-group col-md-3">
									<label for="tarq_status">Status:</label><br>
									<select class="select2 form-control input-sm" name="tarq_status" id="tarq_status" style="width:100%;">
										<option value="">Selecione:</option>
										<option value="1" <?=($rs->fld("tarq_status")=="1"?"SELECTED":"");?> >Ativo</option>
										<option value="0" <?=($rs->fld("tarq_status")=="0"?"SELECTED":"");?> >Inativo</option>
											
									</select>
								</div>
							</div>

							<div class="row">
								<div class="form-group col-md-12">
									<label for="tarq_desc">Descri&ccedil;&atilde;o:</label><br>
									<textarea class="form-control input-sm" id="tarq_desc" placeholder="tarq_desc">
										<?=$rs->fld("imp_desc");?>
									</textarea>
								</div>
							</div>
							<div id="consulta"></div>
							<div id="formerros_arquivos" class="clearfix" style="display:none;">
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
							
							$con =$per->getPermissao($pag, $_SESSION["usu_cod"]);
							if($lin == 1){
								if($con["A"] == 1){ ?>
									<button type="button" id="bt_cadarquivos" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Atualizar </button>
								<?php }
							}
							else{
								if($con["I"] == 1){ ?>
									<button type="button" id="bt_cadarquivos" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Salvar </button>
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
    <script src="<?=$hosted;?>/triangulo/js/action_arquivos.js"></script>

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
		CKEDITOR.replace('tarq_desc');
	});


	$(".select2").select2({
		tags: true
	});
	
	</script>

</body>
</html>	