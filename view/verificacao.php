<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start("portal");
$sec = "Mens";
$pag = "chamados.php";
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
				Novo CheckList de M&aacute;quinas
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li>Solicita&ccedil;&atilde;o</li>
				<li class="active">CheckList</li>
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
							<h3 class="box-title">Novo CheckList</h3>
						</div><!-- /.box-header -->
						<!-- form start -->
						<form role="form" id="cad_lista">
							<div class="box-body">
								<!-- radio Clientes -->
								<div id="clientes" class="row">
									<div class="form-group col-md-5">
										<label for="sel_emp">Empresa:</label><br>
										<select class="select2" style="width:100%" name="sel_emp" id="sel_emp">
											<option value="">Selecione:</option>
											<?php
											$whr="ativo = 1";
											$rs->Seleciona("*","tri_clientes",$whr);
											while($rs->GeraDados()):	
											?>
												<option value="<?=$rs->fld("cod");?>"><?=$rs->fld("empresa");?></option>
											<?php
											endwhile;
											?>
										</select>
									</div>
									<div class="form-group col-md-2">
										<label for="verif_data">Data </label>
										<input type="text" class="form-control dtp" name="verif_data" id="verif_data" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask/>
									</div>
									<div class="form-group col-md-2">
										<label for="verif_compet">Compet&ecirc;ncia:</label>
										<input type="text" class="form-control shortdate" name="verif_compet" id="verif_compet" />
									</div>	
																	
									<div class="form-group col-md-3">
										<label for="emp_cnpj">Usu&aacute;rio:</label>
										<select class="select2" name="sel_colab" id="sel_colab" style="width:100%;">
											<option value="">Selecione:</option>
											<?php
											$whr="usu_ativo = '1' AND usu_empcod=".$_SESSION['sys_id'];
											$rs->Seleciona("*","usuarios",$whr,'','usu_nome ASC');
											while($rs->GeraDados()):	
											?>
												<option <?=($_SESSION['usu_cod']==$rs->fld("usu_cod")?"SELECTED":"");?> value="<?=$rs->fld("usu_cod");?>"><?=$rs->fld("usu_nome");?></option>
											<?php
											endwhile;
											?>
										</select>									
									</div>
									
								</div>
								

								<div id="consulta"></div>
								<div id="formerroscheck" class="clearfix" style="display:none;">
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
								<button class="btn btn-sm btn-success" type="button" id="bt_verif"><i class="fa fa-cog"></i> Iniciar</button>
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
<script src="<?=$hosted;?>/sistema/js/action_chamados.js"></script>
<script src="<?=$hosted;?>/sistema/js/controle.js"></script>
<script src="<?=$hosted;?>/sistema/js/jquery.cookie.js"></script>
<script src="<?=$hosted;?>/sistema/js/functions.js"></script>
<script src="https://cdn.ckeditor.com/4.7.3/standard/ckeditor.js"></script>

<script src="<?=$hosted;?>/sistema/assets/plugins/input-mask/jquery.inputmask.js"></script>
<script src="<?=$hosted;?>/sistema/assets/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="<?=$hosted;?>/sistema/assets/plugins/input-mask/jquery.inputmask.extensions.js"></script>



<!-- SELECT2 TO FORMS
-->

<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
<!-- Validation -->
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script>
	/*------------------------|INICIA TOOLTIPS E POPOVERS|---------------------------------------*/
	$(document).ready(function () {
		$(".dtp").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/aaaa"});			
		
		$(".select2").select2({
			tags: true
		});

		setTimeout(function(){
			//$("#slc").load("meus_chamados.php");		
			$("#alms").load(location.href+" #almsg");
		 },10000);
	});

</script>

</body>
</html>	