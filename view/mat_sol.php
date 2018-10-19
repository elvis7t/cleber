<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start("portal");
$sec = "Mater";
$pag = "sol_mat.php";
require_once("../config/main.php");
require_once("../config/valida.php");
require_once("../config/mnutop.php");
require_once("../config/menu.php");
require_once("../config/modals.php");
require_once("../class/class.functions.php");
require_once("../class/class.permissoes.php");
$per = new permissoes();
$con =$per->getPermissao($pag, $_SESSION['usu_cod']);
$disabled = ($_SESSION['classe']<=4?"":"DISABLED");
?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
		<!-- Content Header (Page header) -->
        <section class="content-header">
			<h1>
				Solicita&ccedil;&atilde;o de Material
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li>Solicita&ccedil;&atilde;o</li>
				<li class="active">Material</li>
			</ol>
        </section>

        <!-- Main content -->
        <section class="content">
			 <div class="row">
				<div class="col-md-12">
				<!-- general form elements -->
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title">Solicitar Material</h3>
						</div><!-- /.box-header -->
						<!-- form start -->
						<form role="form" id="cad_solMat">
							<input type="hidden" id="emp_altera" value=0 />
							<div class="box-body">
								<!-- radio Clientes -->
								<div id="clientes" class="row">
									
									<div class="form-group col-md-3">
										<label for="mat_opera">Opera&ccedil;&atilde;o:</label><br>
										<select class="select2" name="mat_opera" id="mat_opera" style="width: 100%;"">
											<option value="I" <?=$disabled;?> >Comprar</option>
											<option value="O">Solicitar</option>
										
										</select>
									</div>

									<div class="form-group col-md-2">
										<label for="mat_categoria">Catergoria:</label><br>
										<select class="select2" name="mat_categoria" id="mat_categoria" style="width: 100%;"">
											<option value="0">Selecione:</option>
										
										<?php
										$whr="mcat_id<>0";
										$rs->Seleciona("*","mat_categorias",$whr);
										while($rs->GeraDados()):	
										?>
											<option value="<?=$rs->fld("mcat_id");?>"><?=$rs->fld("mcat_desc");?></option>
										<?php
										endwhile;
										?>
										</select>
									</div>
									<div class="form-group col-md-3">
										<label for="mat_cadastro">Material:</label><br>
										<select class="select2" name="mat_cadastro" id="mat_cadastro" style="width: 100%;"">
											<option value="">Selecione:</option>
										
										</select>
									</div>		

									<div class="form-group col-md-2">
										<label for="mat_qtdDis">Disp.:</label>
										<input Disabled type="text" class="form-control input-sm" name="mat_qtdDis" id="mat_qtdDis"/>
									</div>

									<div class="form-group col-md-2">
										<label for="mat_qtd">Qtd.:</label>
										<input type="text" class="form-control input-sm" name="mat_qtd" id="mat_qtd" maxlength=4 />
									</div>

									<div class="form-group col-md-12">
										<label for="mat_obs">Obs.:</label>
										<input type="text" class="form-control input-sm" name="mat_obs" id="mat_obs"/>
									</div>	
								
								</div>
							<div id="consulta"></div>
							<div id="formerrosMateriais" class="clearfix" style="display:none;">
								<div class="callout callout-danger">
									<h4>Erros no preenchimento do formul&aacute;rio.</h4>
									<p>Verifique os erros no preenchimento acima:</p>
									<ol>
										<!-- Erros são colocados aqui pelo validade -->
									</ol>
								</div>
							</div>
							
						</form>
					</div><!-- ./box -->
					<div class="box-footer">
						<button class="btn btn-sm btn-success" type="button" id="bt_solicMat"><i class="fa fa-plus"></i> Solicitar</button>
						<span id="spload" style="display:none;"><i id="load"></i></span>
					</div>
					
					
				</div><!-- ./row -->
				<div class="row">
					<div class="col-xs-12">
						<div class="box box-success" id="materiais">
							<div class="box-header with-border">
								<h3 class="box-title">Solicita&ccedil;&otilde;es</h3>
							</div><!-- /.box-header -->
							<div id="slc" class="box-body">
								 
								<?php
								require_once("vis_solmat.php");
								?>
								
							</div>
						</div><!-- ./box -->
					</div><!-- ./col -->
				</div>
			</div>
		</section>
	</div>
	<?php
		require_once("../config/footer.php");
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
<script src="<?=$hosted;?>/sistema/js/action_triang.js"></script>
<script src="<?=$hosted;?>/sistema/js/action_empresas.js"></script>
<script src="<?=$hosted;?>/sistema/js/controle.js"></script>
<script src="<?=$hosted;?>/sistema/js/jquery.cookie.js"></script>
<script src="<?=$hosted;?>/sistema/js/functions.js"></script>


<!-- SELECT2 TO FORMS-->
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
<!--CHOSEN-->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.6.2/chosen.jquery.min.js"></script>
<!-- Validation -->
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script type="text/javascript">
	/*------------------------|INICIA TOOLTIPS E POPOVERS|---------------------------------------*/
	$(document).ready(function () {
		$(".chosen").chosen({
		 	no_results_text: "Sem resultados!"
		 });

		$("#bt_detalhe").click(function(){
			$("#emp_detalhe").modal({
				keyboard:true
			});
		});

		$(".select2").select2({
			tags: true
		});
		setTimeout(function(){
			$("#alms").load(location.href+" #almsg");
			$("#slc").load("vis_solmat.php");		
		 },7500);

		
	});
</script>

</body>
</html>	