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
require_once("../class/class.permissoes.php");
$per = new permissoes();
$con = $per->getPermissao("todos_depart",$_SESSION['usu_cod']);

?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
		<!-- Content Header (Page header) -->
        <section class="content-header">
			<h1>
				Nova lista de Tarefas
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li>Solicita&ccedil;&atilde;o</li>
				<li class="active">Metas</li>
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
							<h3 class="box-title">Nova Meta</h3>
						</div><!-- /.box-header -->
						<!-- form start -->
						<form role="form" id="cad_meta">
							<div class="box-body">
								<!-- radio Clientes -->
								<div id="clientes" class="row">
									
									<div class="form-group col-md-2">
										<label for="verif_data">Data In&iacute;cio:</label>
										<input type="text" class="form-control dtp" name="meta_ini" id="meta_ini" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask/>
									</div>
									<div class="form-group col-md-2">
										<label for="verif_data">Data Fim:</label>
										<input type="text" class="form-control dtp" name="meta_fim" id="meta_fim" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask/>
									</div>
									
																	
									<div class="form-group col-md-4">
										<label for="emp_cnpj">Usu&aacute;rio:</label>
										<select class="select2" name="meta_user" id="meta_user" multiple style="width:100%;">
											<option value="">Selecione:</option>
											<?php
											$whr="usu_ativo = '1' AND usu_empcod=".$_SESSION['sys_id'];
											if($con['C'] == 0){$whr.=" AND usu_dep=".$_SESSION['dep'];}
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
								<div id="formerrosmeta" class="clearfix" style="display:none;">
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
								<button class="btn btn-sm btn-success" type="button" id="bt_meta"><i class="fa fa-cog"></i> Iniciar</button>
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
<script src="<?=$hosted;?>/sistema/js/action_metas.js"></script>
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
			tags: true,
			theme: "classic"
		});

		setTimeout(function(){
			//$("#slc").load("meus_chamados.php");		
			$("#alms").load(location.href+" #almsg");
		 },10000);
	});

</script>

</body>
</html>	