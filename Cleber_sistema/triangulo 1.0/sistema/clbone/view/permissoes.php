<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start();
$sec = "Solics";
require_once("../config/main.php");
require_once("../config/valida.php");
require_once("../config/mnutop.php");
require_once("../config/menu.php");
require_once("../../sistema/config/modals.php");
require_once("../../sistema/class/class.functions.php");
require_once("../class/class.permissoes.php");

?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
		<!-- Content Header (Page header) -->
        <section class="content-header">
			<h1>
				Permissionamento
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li>Permiss&ccedil;&atilde;o</li>
				<li class="active">Uso de recursos</li>
			</ol>
        </section>

        <!-- Main content -->
        <section class="content">
			<?php
 
				if(isset($_SESSION['classe'])){$classe = $_SESSION['classe'];}
				else{$classe=0;}
			?>
			 <div class="row">
				<div class="col-md-12">
				<!-- general form elements -->
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title">Alterar Acessos</h3>
						</div><!-- /.box-header -->
						<!-- form start -->
						<form role="form" id="cad_sol">
							<input type="hidden" id="emp_altera" value=0 />
							<div class="box-body">
								<!-- radio Clientes -->
								<div id="clientes" class="row">
									<div class="form-group col-md-4">
										<label for="per_classe">Classe:</label><br>
										<select class="select2" name="per_classe" id="per_classe" style="width:100%;">
											<option value="">Selecione:</option>
										
											<?php
											$whr="classe_id<>0";
											$rs->Seleciona("*","classes",$whr);
											while($rs->GeraDados()):	
											?>
												<option value="<?=$rs->fld("classe_id");?>"><?=$rs->fld("classe_id")." - ".$rs->fld("classe_desc");?></option>
											<?php
											endwhile;
											?>
										</select>
									</div>	
								</div>
							</div>
						</form>	
					</div><!-- ./row -->
					<div class="row">
						<div class="col-xs-12">
							<div class="box box-success" id="firms">
								<div class="box-header with-border">
									<h3 class="box-title">Permiss&otilde;es</h3>
								</div><!-- /.box-header -->
								<div id="slc" class="box-body">
									 
									<?php require_once('vis_permiss.php');?>
									
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
<script src="<?=$hosted;?>/triangulo/js/action_triang.js"></script>
<script src="<?=$hosted;?>/triangulo/js/controle.js"></script>
<script src="<?=$hosted;?>/triangulo/js/jquery.cookie.js"></script>
<script src="<?=$hosted;?>/triangulo/js/functions.js"></script>


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
		 },7500);

		
	});
</script>

</body>
</html>	