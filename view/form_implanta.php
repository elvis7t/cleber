<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start();
$sec = "Mens";
$pag = "pes_implanta.php";
require_once("../config/main.php");
require_once("../config/valida.php");
require_once("../config/mnutop.php");
require_once("../config/menu.php");
require_once("../../sistema/config/modals.php");
require_once("../../sistema/class/class.functions.php");
require_once("../class/class.permissoes.php");

$per = new permissoes();
$con = $per->getPermissao("implantacao_docs",$_SESSION['usu_cod']);

?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
		<!-- Content Header (Page header) -->
        <section class="content-header">
			<h1>
				implanta&ccedil;&otilde;es
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li>Solicita&ccedil;&atilde;o</li>
				<li class="active">Implanta&ccedil;&otilde;es</li>
			</ol>
        </section>

        <!-- Main content -->
        <section class="content">
			<?php
 				$des="";
				if($con["C"]==0){
					$des="hide";
				}
			?>
			 <div class="row">
				<div class="col-md-12">
				<!-- general form elements -->
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title">Solicitar Implanta&ccedil;&atilde;o</h3>
						</div><!-- /.box-header -->
						<!-- form start -->
						<form role="form" id="cad_impla">
							<input type="hidden" id="emp_altera" value=0 />
							<div class="box-body">
								<!-- radio Clientes -->
								<div id="clientes" class="row">
									<div class="form-group col-md-3">
										<label for="hom_empresa">Empresa:</small></label><br>
										<select class="form-control select2" name="imp_emp" id="imp_emp" style="width:100%;">
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
										<label for="hom_data">Data in&iacute;cio:</label>
										<input type="text" title="In&iacute;cio da Implanta&ccedil;&atilde;o" class="form-control" name="impl_data" id="impl_data" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask>
									</div>
									<div class="form-group col-md-3">
										<label for="hom_data">Observa&ccedil;&atilde;o:</label>
										<input type="text" title="Observa&ccedil;&atilde;o" class="form-control" name="impl_obs" id="impl_obs">
									</div>
									<div class="form-group col-md-2">
										<label for="hom_data">Valor:</label>
										<input type="text" title="Valor" class="form-control" name="impl_valor" id="impl_valor">
									</div>

									<div class="form-group col-md-2">
										<label class="text-capitalize">
											Marcar todos os itens<br>	
											<input type="checkbox" name="checkAll" id="checkAll" > 
										</label>
									</div>
								</div>
								
								<div class="row">
									<div class="form-group col-md-6 <?=$des;?>">
										<label for="hom_valor">Check-List:</label><br>
										<div class="box box-warning">
											<div class="box-header with-border">
												<h3 class="box-title">Departamento Legal</h3>
											</div><!-- /.box-header -->
											<div class="box-body">
												<?php
												$whr = "chk_depref=5";
												$rs->Seleciona("*","checklists",$whr,"","chk_item ASC");
												$i=0;
												while($rs->GeraDados()):
												$i++	
												?>
													<div class="checkbox">
														<label class="text-capitalize">
															<input type="checkbox" name="imp_chk[]" id="imp_chk[]" value="<?=$rs->fld("chk_id");?>"> 
															<?=$rs->fld("chk_item")?>	
														</label>
													</div>
												<?php
													
												endwhile;
												?>
											</div>
										</div>
									</div>
									<div class="form-group col-md-6 <?=$des;?>">
										<label for="hom_valor">Check-List:</label><br>
										<div class="box box-primary">
											<div class="box-header with-border">
												<h3 class="box-title">Departamento Pessoal</h3>
											</div><!-- /.box-header -->
											<div class="box-body">
												<?php
												$whr = "chk_depref=4";
												$rs->Seleciona("*","checklists",$whr,"","chk_item ASC");
												$i=0;
												while($rs->GeraDados()):
												$i++	
												?>
													<div class="checkbox">
														<label class="text-capitalize">
															<input type="checkbox" name="imp_chk[]" id="imp_chk[]" value="<?=$rs->fld("chk_id");?>"> 
															<?=$rs->fld("chk_item")?>	
														</label>
													</div>
												<?php
													
												endwhile;
												?>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="form-group col-md-6 <?=$des;?>">
										<label for="hom_valor">Check-List:</label><br>
										<div class="box box-success">
											<div class="box-header with-border">
												<h3 class="box-title">Departamento Fiscal</h3>
											</div><!-- /.box-header -->
											<div class="box-body">
												<?php
												$whr = "chk_depref=2";
												$rs->Seleciona("*","checklists",$whr,"","chk_item ASC");
												$i=0;
												while($rs->GeraDados()):
												$i++	
												?>
													<div class="checkbox">
														<label class="text-capitalize">
															<input type="checkbox" name="imp_chk[]" id="imp_chk[]" value="<?=$rs->fld("chk_id");?>"> 
															<?=$rs->fld("chk_item")?>	
														</label>
													</div>
												<?php
													
												endwhile;
												?>
											</div>
										</div>
									</div>
									<div class="form-group col-md-6 <?=$des;?>">
										<label for="hom_valor">Check-List:</label><br>
										<div class="box box-danger">
											<div class="box-header with-border">
												<h3 class="box-title">Departamento Cont&aacute;bil</h3>
											</div><!-- /.box-header -->
											<div class="box-body">
												<?php
												$whr = "chk_depref=1";
												$rs->Seleciona("*","checklists",$whr,"","chk_item ASC");
												$i=0;
												while($rs->GeraDados()):
												$i++	
												?>
													<div class="checkbox">
														<label class="text-capitalize">
															<input type="checkbox" name="imp_chk[]" id="imp_chk[]" value="<?=$rs->fld("chk_id");?>"> 
															<?=$rs->fld("chk_item")?>	
														</label>
													</div>
												<?php
													
												endwhile;
												?>
											</div>
										</div>
									</div>
								</div>
									

								<div id="consulta"></div>
								<div id="formerros_impla" class="clearfix" style="display:none;">
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
								<button class="btn btn-sm btn-success" type="button" id="bt_impla"><i class="fa fa-handshake-o "></i> Iniciar</button>
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

<script src="<?=$hosted;?>/sistema/assets/plugins/input-mask/jquery.inputmask.js"></script>
<script src="<?=$hosted;?>/sistema/assets/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="<?=$hosted;?>/sistema/assets/plugins/input-mask/jquery.inputmask.extensions.js"></script>

<script src="<?=$hosted;?>/triangulo/js/action_empresas.js"></script>
<script src="<?=$hosted;?>/triangulo/js/controle.js"></script>
<script src="<?=$hosted;?>/triangulo/js/jquery.cookie.js"></script>
<script src="<?=$hosted;?>/triangulo/js/functions.js"></script>
<script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>


<!-- SELECT2 TO FORMS
-->

<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
<!-- Validation -->
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script>
	/*------------------------|INICIA TOOLTIPS E POPOVERS|---------------------------------------*/
	$(document).ready(function () {
		$("#checkAll").click(function(){
		    $('input:checkbox').not(this).prop('checked', this.checked);
		});
		$("#impl_data").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/aaaa"});
		
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