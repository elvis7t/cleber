<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start();
$sec = "CHAM";
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
				Chamados
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li>Solicita&ccedil;&atilde;o</li>
				<li>Chamados</li>
				<li class="active">Atendimento</li>
			</ol>
        </section>

        <!-- Main content -->
        <section class="content">
        <div class="row">
					<div class="col-md-12">
						<div class="box box-success" id="firms">
							<div class="box-header with-border">
								<h3 class="box-title">Tr&acirc;mites deste Chamado</h3>
							</div><!-- /.box-header -->
							<div class="box-body">
								 
								<?php require_once("cham_Ocorr.php"); ?>
								
							</div>
						</div><!-- ./box -->
					</div><!-- ./col -->
				</div>
			<?php
 				extract($_GET);
 				$rs2 = new recordset();
				$fn = new functions();
 				$sql = "SELECT * FROM chamados a WHERE cham_id = ".$chamado;
 				$rs->FreeSql($sql);
 				$rs->GeraDados();

 				if($rs->fld('cham_trat')==0 && $acao==1){
 					$data = date("Y-m-d H:i:s");
 					$d = array("cham_trat" => $_SESSION['usu_cod'], "cham_tratini"=>$data, "cham_status"=>92);
 					$w = "cham_id = ".$chamado;
 					$rs2->Altera($d, "chamados",$w);
 				}
			?>

			 <div class="row">
				<div class="col-md-12">
				<!-- general form elements -->
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title">Feedback de Servi&ccedil;o</h3><div class="box-tools pull-right">
		                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		                  </div>
						</div><!-- /.box-header -->
						<!-- form start -->
						<form role="form" id="cad_atend">
							
							<div class="box-body">
								<!-- radio Clientes -->
								<div id="clientes" class="row">
									<div class="form-group col-md-1">
										<label for="emp_cnpj">#ID:</label>
										<input type="text" DISABLED class="form-control" name="chm_id" id="chm_id" value="<?=$rs->fld("cham_id");?>"/>
									</div>
									<div class="form-group col-md-3">
										<label for="emp_cnpj">Tarefa:</label>
										<input type="text" DISABLED class="form-control" name="chm_task" id="chm_task" value="<?=$rs->fld("cham_task");?>"/>
									</div>
									<div class="form-group col-md-3">
										<label for="emp_cnpj">SLA <small>(até tratamento)</small>:</label>
										<input type="text" DISABLED class="form-control" name="chm_sla" id="chm_sla" value="<?=$fn->calc_dh($rs->fld("cham_abert"), $rs->fld("cham_tratini"));?>"/>
									</div>
									<div class="form-group col-md-3">
										<label for="emp_cnpj">SLA <small>(de solução)</small>:</label>
										<input type="text" DISABLED class="form-control" name="chm_slaII" id="chm_slaII" value="<?=($rs->fld("cham_tratfim")==0?"-":$fn->calc_dh($rs->fld("cham_tratini"), $rs->fld("cham_tratfim")));?>"/>
									</div>
									<div class="col-sm-2">
										<label for="emp_cnpj">Concluído:</label>
                      					<input id="cham_percent" type="text" name="cham_percent" value="">
                    				</div>
									
									
								</div>
								<div class="row">
									<div class="form-group col-md-12">
										<label for="emp_cnpj">Observa&ccedil;&atilde;o:</label>
										<textarea class="form-control" name="chm_obs" id="editor1"></textarea>
									</div>
									<div class="form-group col-md-4">
										<label for="emp_cnpj">Avaliação</small>:</label>
										<input id="score" DISABLED name="score" class="rating rating-loading xs" value="<?=$rs->fld("cham_aval");?>" data-min="0" data-max="5" data-step="0.5" data-size="xs">
									</div>

								</div>

								<div id="consulta"></div>
								<div id="formerros1" class="clearfix" style="display:none;">
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
								<button <?=($rs->fld("cham_status")==99 ? "DISABLED" :"");?>  class="btn btn-sm btn-info" type="button" id="bt_save_cham"><i class="fa fa-save"></i> Salvar</button>
								<?php if(!($rs->fld("cham_status")==91 AND $rs->fld("cham_solic") == $_SESSION['usu_cod'] OR $_SESSION['classe']==1)){
									$cond = "DISABLED";
									} 
								;?>
								<button <?=$cond;?> class="btn btn-sm btn-success" type="button" id="bt_encerra_cham"><i class="fa fa-exclamation"></i> Encerrar</button>
								
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


<script type="text/javascript" src="<?=$hosted;?>/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script type="text/javascript" src="<?=$hosted;?>/assets/bootstrap/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script type="text/javascript" src="<?=$hosted;?>/assets/plugins/fastclick/fastclick.min.js"></script>
<!-- AdminLTE App -->
<script type="text/javascript" src="<?=$hosted;?>/assets/dist/js/app.min.js"></script>
<!-- Slimscroll -->
<script type="text/javascript" src="<?=$hosted;?>/assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script type="text/javascript" src="<?=$hosted;?>/assets/js/maskinput.js"></script>
<script type="text/javascript" src="<?=$hosted;?>/assets/js/jmask.js"></script>
<script type="text/javascript" src="<?=$hosted;?>/assets/bootstrap/js/star-rating.js"></script>
<script type="text/javascript" src="<?=$hosted;?>/js/action_chamados.js"></script>
<script type="text/javascript" src="<?=$hosted;?>/js/controle.js"></script>
<script type="text/javascript" src="<?=$hosted;?>/js/jquery.cookie.js"></script>
<script type="text/javascript" src="<?=$hosted;?>/js/functions.js"></script>
<script type="text/javascript" src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
<!-- Ion Slider -->
<script type="text/javascript" src="<?=$hosted;?>/assets/plugins/ionslider/ion.rangeSlider.min.js"></script>
<!-- Bootstrap slider -->
<script type="text/javascript" src="<?=$hosted;?>/assets/plugins/bootstrap-slider/bootstrap-slider.js"></script>


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
	

        

	});
	$(function () {
		// Replace the <textarea id="editor1"> with a CKEditor
		// instance, using default configuration.
		CKEDITOR.replace('editor1');


        $("#cham_percent").ionRangeSlider({
          min: 0,
          max: 100,
          type: 'single',
          step: 1,
          postfix: " %",
          prettify: false,
          hasGrid: true
        });
	});

	
</script>

</body>
</html>	