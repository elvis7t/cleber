<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start();
$sec = "Mens";
$pag = "dp_homologa.php";
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
				Homologa&ccedil;&otilde;es
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li>Solicita&ccedil;&atilde;o</li>
				<li class="active">Homologa&ccedil;&otilde;es</li>
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
							<h3 class="box-title">Solicitar Homologa&ccedil;&atilde;o</h3>
						</div><!-- /.box-header -->
						<!-- form start -->
						<form role="form" id="cad_homol">
							<input type="hidden" id="emp_altera" value=0 />
							<div class="box-body">
								<!-- radio Clientes -->
								<div id="clientes" class="row">
									<div class="form-group col-md-3">
										<label for="hom_empresa">Empresa:</small></label><br>
										<select class="select2" name="hom_emp" id="hom_emp" style="width:100%;">
											<option value="">Selecione:</option>
										
										<?php
										$whr="ativo=1 AND emp_vinculo=".$_SESSION['usu_empcod'];
										$rs->Seleciona("*","tri_clientes",$whr);
										while($rs->GeraDados()):	
										?>
											<option value="<?=$rs->fld("cod");?>"><?=$rs->fld("cod")." - ".$rs->fld("apelido");?></option>
										<?php
										endwhile;
										?>
										</select>
									</div>	
									<div class="form-group col-md-2">
										<label for="hom_data">Data:</label>
										<input type="text" title="Data da Homologa&ccedil;&atilde;o" class="form-control" name="hom_data" id="hom_data" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask>
									</div>
									
									<div class="form-group col-md-5">
										<label for="hom_nome">Nome do homologado:</label>
										<input type="text" class="form-control" name="hom_nome" id="hom_nome"/>	
									</div>
									<div class="form-group col-md-2">
										<label for="">Indenizado?</label>
										<div class="radio">
											<label>
												<input type="radio" value="1" name="hom_inden" id="hom_inden"/>	
												Sim
											</label> &nbsp;
											<label>
												<input type="radio" value="0" name="hom_inden" id="hom_inden"/>	
												Não
											</label>
										</div>
									</div>
									
								</div>
								<div class="row">
									<div class="form-group col-md-3">
										<label for="hom_local">Sindicato:</label>
										<input type="text" class="form-control" name="hom_sind" id="hom_sind"/>	
									</div>
									<div class="form-group col-md-5">
										<label for="hom_local">Local:</label>
										<input type="text" class="form-control" name="hom_local" id="hom_local"/>	
									</div>
									<div class="form-group col-md-2">
										<label for="hom_horario">Hor&aacute;rio:</label>
										<input type="text" class="form-control time" name="hom_hora" id="hom_hora"/>	
									</div>
									<div class="form-group col-md-2">
										<label for="hom_valor">Valor:</label>
										<input type="text" class="form-control" name="hom_valor" id="hom_valor"/>	
									</div>
								</div>
								<div class="row">
									<div class="form-group col-md-12">
										<label for="hom_valor">Check-List:</label><br>
										<div class="col-md-6">
										<?php
										$whr = "chk_dep=4";
										$rs->Seleciona("*","checklists",$whr,"","chk_item ASC");
										$i=0;
										while($rs->GeraDados()):
										$i++	
										?>
											<div class="checkbox">
												<label>
													<input type="checkbox" name="hom_chk[]" id="hom_chk[]" value="<?=$rs->fld("chk_id");?>"> 
													<?=$rs->fld("chk_item")?>	
												</label>
											</div>
										<?php
											if($i%10==0){
												
												echo "</div><div class='col-md-6'>";
											}
										endwhile;
										?>
										</div>
										
									</div>
								</div>

								<div id="consulta"></div>
								<div id="formerros_homo" class="clearfix" style="display:none;">
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
								<button class="btn btn-sm btn-success" type="button" id="bt_homol"><i class="fa fa-hand-scissors-o"></i> Solicitar</button>
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

<script src="<?=$hosted;?>/assets/plugins/input-mask/jquery.inputmask.js"></script>
<script src="<?=$hosted;?>/assets/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="<?=$hosted;?>/assets/plugins/input-mask/jquery.inputmask.extensions.js"></script>

<script src="<?=$hosted;?>/js/action_empresas.js"></script>
<script src="<?=$hosted;?>/js/controle.js"></script>
<script src="<?=$hosted;?>/js/jquery.cookie.js"></script>
<script src="<?=$hosted;?>/js/functions.js"></script>
<script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>


<!-- SELECT2 TO FORMS
-->

<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
<!-- Validation -->
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script>
	/*------------------------|INICIA TOOLTIPS E POPOVERS|---------------------------------------*/
	$(document).ready(function () {
		$("#hom_data").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/aaaa"});
		
		$(".select2").select2({
			tags: true
		});
		setTimeout(function(){
			$("#slc").load("meus_chamados.php");		
			$("#alms").load(location.href+" #almsg");
		 },10000);
	});

</script>

</body>
</html>	