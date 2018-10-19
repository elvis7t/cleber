<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start("portal");
$sec = "CHAMA";
$pag = "artigos.php";
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
				Artigos
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li>Solicita&ccedil;&atilde;o</li>
				<li class="active">Artigos</li>
			</ol>
        </section>

        <!-- Main content -->
        <section class="content">
			 <div class="row">
				<div class="col-md-12">
				<!-- general form elements -->
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title">Novo Artigo</h3>
						</div><!-- /.box-header -->
						<!-- form start -->
						<form role="form" id="cad_art">
							<input type="hidden" id="emp_altera" value=0 />
							<div class="box-body">
								<!-- radio Clientes -->
								<div id="clientes" class="row">
									<div class="form-group col-md-2">
										<label for="art_dep">Departamento:</label><br>
										<select class="select2" name="art_dep" id="art_dep" style="width:100%;">
											<option value="">Selecione:</option>
											
											<?php
											$whr="dep_id < 10";
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
										<label for="art_col">Colaborador:</label>
										<select class="select2" name="art_col" <?=($_SESSION['classe']<>1?"DISABLED":"");?> id="art_col" style="width:100%;">
											<option value="">Selecione:</option>
											<?php
											$whr="usu_ativo = '1' AND usu_empcod=".$_SESSION['sys_id'];
											$rs->Seleciona("*","usuarios",$whr,'','usu_nome ASC');
											while($rs->GeraDados()):	
											?>
												<option <?=($_SESSION['usu_cod']==$rs->fld("usu_cod")?"SELECTED":"");?> value="<?=$rs->fld("usu_nome");?>"><?=$rs->fld("usu_nome");?></option>
											<?php
											endwhile;
											?>
										</select>									
									</div>
									<div class="form-group col-md-3">
										<label for="art_title">Titulo do Artigo:</label>
										<input type="text" class="form-control" name="art_title" id="art_title">
									</div>
									
									<div class="form-group col-md-4">
										<label for="art_title2">Subtitulo do Artigo:</label>
										<input type="text" class="form-control" name="art_title2" id="art_title2">
									</div>
								</div>

								<div class="row">
									<div class="form-group col-md-4">
										<label for="art_fonte">Fonte do Artigo:</label>
										<input type="text" class="form-control" name="art_fonte" id="art_fonte">
									</div>
									<div class="form-group col-md-4">
										<label for="art_email">E-mail resposta:</label>
										<input type="text" class="form-control" name="art_email" id="art_email">
									</div>
									<div class="form-group col-md-4">
										<label for="art_img">URL Imagem:</label>
										<input type="text" class="form-control" name="art_img" id="art_img">
									</div>
								</div>



								<div class="row">
									<div class="form-group col-md-6">
										<label for="art_descr">Descrição do Artigo:</label>
										<textarea class="form-control" name="art_descr" id="art_descr"></textarea>
									</div>
									
									<div class="form-group col-md-6">
										<label for="art_brief">Briefing do Artigo:</label>
										<textarea class="form-control" name="art_brief" id="art_brief"></textarea>
									</div>
								</div>

								<div class="row">
									<div class="form-group col-md-12">
										<label for="art_cont">Conteúdo do Artigo:</label>
										<textarea class="form-control" name="art_cont" id="art_cont"></textarea>
									</div>
								</div>

								<div id="consulta"></div>
								<div id="formerros_artigos" class="clearfix" style="display:none;">
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
								<button class="btn btn-sm btn-success" type="button" id="bt_art"><i class="fa fa-save"></i> Salvar</button>
							</div>
						</form>
					</div><!-- ./box -->
					</div>
				</div><!-- ./row -->
				
			</div>
		</section>
	</div>
	<?php
		require_once("../config/footer.php");
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
<script src="<?=$hosted;?>/sistema/js/action_artigos.js"></script>
<script src="<?=$hosted;?>/sistema/js/controle.js"></script>
<script src="<?=$hosted;?>/sistema/js/jquery.cookie.js"></script>
<script src="<?=$hosted;?>/sistema/js/functions.js"></script>
<script src="https://cdn.ckeditor.com/4.7.3/standard/ckeditor.js"></script>


<!-- SELECT2 TO FORMS
-->

<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
<!-- Validation -->
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script>
	/*------------------------|INICIA TOOLTIPS E POPOVERS|---------------------------------------*/
	$(document).ready(function () {
		
		$(".select2").select2({
			tags: true
		});
		
		setTimeout(function(){
			$("#slc").load("meus_chamados.php");		
			$("#alms").load(location.href+" #almsg");
		 },10000);
	});

	 $(function () {
			// Replace the <textarea id="editor1"> with a CKEditor
			// instance, using default configuration.
			CKEDITOR.replace( 'art_descr', {
			    filebrowserUploadUrl: "upload.php" 
			});
			CKEDITOR.replace( 'art_brief', {
			    filebrowserUploadUrl: "upload.php" 
			});
			CKEDITOR.replace( 'art_cont', {
			    filebrowserUploadUrl: "upload.php" 
			});
		});
</script>

</body>
</html>	