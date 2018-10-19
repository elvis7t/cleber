<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start("portal");
$sec = "CART";
$pag = "metas.php";
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
				Tarefas
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li>Central de Tarefas</li>
				<li class="active">Ocorr&ecirc;ncias</li>
			</ol>
        </section>

        <!-- Main content -->
        <section class="content">
        <div class="row">
					<div class="col-md-12">
						<div class="box box-success" id="firms">
							<div class="box-header with-border">
								<h3 class="box-title">Tr&acirc;mites desta Tarefa</h3>
							</div><!-- /.box-header -->
							<div class="box-body">
								 
								<?php require_once("vis_metasOcorrencias.php"); ?>
								
							</div>
						</div><!-- ./box -->
					</div><!-- ./col -->
				</div>
			<?php
 				extract($_GET);
 				$rs2 = new recordset();
				$fn = new functions();
 				$sql = "SELECT a.*, b.metas_id, c.empresa FROM tarmetas a
 							JOIN metas b 		ON b.metas_id = a.tarmetas_metasId
 							JOIN tri_clientes c ON c.cod = a.tarmetas_emp
 						WHERE tarmetas_id = ".$tarefa;	
 				$rs->FreeSql($sql);
 				$rs->GeraDados();
			?>

			 <div class="row">
				<div class="col-md-12">
				<!-- general form elements -->
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title">Feedback de Tarefa</h3><div class="box-tools pull-right">
		                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		                  </div>
						</div><!-- /.box-header -->
						<!-- form start -->
						<form role="form" id="cad_ocmetas">
							
							<div class="box-body">
								<!-- radio Clientes -->
								<div id="clientes" class="row">
									<div class="form-group col-md-1">
										<label for="metas_id">#Lista:</label>
										<input type="text" DISABLED class="form-control" name="metas_id" id="metas_id" value="<?=$rs->fld("metas_id");?>"/>
									</div>
									<div class="form-group col-md-1">
										<label for="metas_task">#Tarefa:</label>
										<input type="text" DISABLED class="form-control" name="metas_task" id="metas_task" value="<?=$rs->fld("tarmetas_id");?>"/>
									</div>
									<div class="form-group col-md-5">
										<label for="metas_empresa">Empresa:</label>
										<input type="text" DISABLED class="form-control" name="metas_empresa" id="metas_empresa" value="<?=$rs->fld("empresa");?>"/>
									</div>
									<div class="form-group col-md-2">
										<label for="metas_compet">Compet&ecirc;ncia:</label>
										<input type="text" DISABLED class="form-control" name="metas_compet" id="metas_compet" value="<?=$rs->fld("tarmetas_comp");?>"/>
									</div>
								</div>
								<div class="row">
									<div class="form-group col-md-12">
										<label for="metas_obs">Observa&ccedil;&atilde;o:</label>
										<input type="hidden" name="mhidden" id="mhidden">
										<textarea class="form-control" name="metas_obs" id="metas_obs"></textarea>
									</div>
									<div class="form-group col-md-4">
										<label for="emp_cnpj">Avaliação</small>:</label>
										<input id="score" DISABLED name="score" class="rating rating-loading xs" value="<?=$rs->fld("cham_aval");?>" data-min="0" data-max="5" data-step="0.5" data-size="xs">
									</div>

								</div>

								<div id="consulta"></div>
								<div id="formerrosocmetas" class="clearfix" style="display:none;">
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
								<button  class="btn btn-sm btn-info" type="button" id="bt_save_ocmetas"><i class="fa fa-save"></i> Salvar</button>
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


<script type="text/javascript" src="<?=$hosted;?>/sistema/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script type="text/javascript" src="<?=$hosted;?>/sistema/assets/bootstrap/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script type="text/javascript" src="<?=$hosted;?>/sistema/assets/plugins/fastclick/fastclick.min.js"></script>
<!-- AdminLTE App -->
<script type="text/javascript" src="<?=$hosted;?>/sistema/assets/dist/js/app.min.js"></script>
<!-- Slimscroll -->
<script type="text/javascript" src="<?=$hosted;?>/sistema/assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script type="text/javascript" src="<?=$hosted;?>/sistema/assets/js/maskinput.js"></script>
<script type="text/javascript" src="<?=$hosted;?>/sistema/assets/js/jmask.js"></script>
<script type="text/javascript" src="<?=$hosted;?>/sistema/assets/bootstrap/js/star-rating.js"></script>
<script type="text/javascript" src="<?=$hosted;?>/sistema/js/action_metas.js"></script>
<script type="text/javascript" src="<?=$hosted;?>/sistema/js/controle.js"></script>
<script type="text/javascript" src="<?=$hosted;?>/sistema/js/jquery.cookie.js"></script>
<script type="text/javascript" src="<?=$hosted;?>/sistema/js/functions.js"></script>
<script type="text/javascript" src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
<!-- Ion Slider -->
<script type="text/javascript" src="<?=$hosted;?>/sistema/assets/plugins/ionslider/ion.rangeSlider.min.js"></script>
<!-- Bootstrap slider -->
<script type="text/javascript" src="<?=$hosted;?>/sistema/assets/plugins/bootstrap-slider/bootstrap-slider.js"></script>


<!-- SELECT2 TO FORMS
-->

<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
<!-- Validation -->
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script type="text/javascript">
	/*------------------------|INICIA TOOLTIPS E POPOVERS|---------------------------------------*/
	$(document).ready(function () {
		$(".select2").select2({
			tags: true
		});

		$("#chatContent").scrollTop($("#msgs").height());					
		setTimeout(function(){
			$("#slc").load("cham_Ocorr.php");		
			$("#alms").load(location.href+" #almsg");
		},10000);
    	$("#bt_save_ocmetas").on("click",function(){
    		$("#mhidden").val(CKEDITOR.instances.metas_obs.getData());
    	});    

	});
	$(function () {
		// Replace the <textarea id="editor1"> with a CKEditor
		// instance, using default configuration.
		CKEDITOR.replace( 'metas_obs', {
		    filebrowserUploadUrl: "upload.php" 
		});
		
	});

	
</script>

</body>
</html>	