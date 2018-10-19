<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start();
$sec = "VISITAS";
require_once("../config/main.php");
require_once("../config/valida.php");
require_once("../config/mnutop.php");
require_once("../config/menu.php");
require_once("../../sistema/config/modals.php");
require_once("../../sistema/class/class.functions.php");

?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
		<!-- Content Header (Page header) -->
        <section class="content-header">
			<h1>
				Solicita&ccedil;&atilde;o de Visitas
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li>Documentos</li>
				<li class="active">Visitas</li>
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
							<h3 class="box-title">Solicitar Visitas</h3>
						</div><!-- /.box-header -->
						<!-- form start -->
						<form role="form" id="doc_entrada">
							<div class="box-body">
								<!-- radio Clientes -->
								<div id="clientes" class="row">
									<div class="form-group col-xs-6">
										<label for="emp_cnpj">Cliente</label><br>
										<select class="select2 input-sm" name="sel_emp" id="sel_emp">
											<option value="">Selecione:</option>
											<?php
												$whr="cod <> ''";
												$rs->Seleciona("*","tri_clientes",$whr);
												while($rs->GeraDados()):	
												?>
												<option value="<?=$rs->fld("cod")." - ".$rs->fld("empresa");?>"><?=$rs->fld("cod")." - ".$rs->fld("empresa");?></option>
											<?php
												endwhile;
											?>
										</select>
									</div>	
									<div class="form-group col-xs-3">
										<label for="emp_cnpj">Respons&aacute;vel</label>
										<input type="text" class="form-control input-sm" name="vis_resp" id="vis_resp"/>
									</div>
									
								</div>
								<!-- radio Avulso -->
								<div id="avulsos" class="row">
									<div class="form-group col-xs-3">
										<label for="emp_cnpj">Doc</label><br>
										<select class="select2" multiple="multiple" name="sel_docs" id="sel_docs" style="width:100%;">
											<option value="">Selecione:</option>
											<?php
												$whr="tdoc_id <> ''";
												$rs->Seleciona("*","tipos_doc",$whr,"","tdoc_tipo ASC");
												while($rs->GeraDados()):	
												?>
												<option value="<?=$rs->fld("tdoc_id");?>"><?=$rs->fld("tdoc_tipo");?></option>
											<?php
												endwhile;
											?>											
										</select>
									</div>
									

									<div class="form-group col-xs-6">
										<label for="emp_cnpj">Observa&ccedil;&atilde;o <small>(Opcional)</small></label>
										<textarea class="form-control input-sm" name="doc_obs" id="doc_obs"></textarea>
									</div>
								</div>
							<div id="consulta"></div>
							<div id="formerros_docs" class="clearfix" style="display:none;">
								<div class="callout callout-danger">
									<h4>Erros no preenchimento do formul&aacute;rio.</h4>
									<p>Verifique os erros no preenchimento acima:</p>
									<ol>
										<!-- Erros são colocados aqui pelo validade -->
									</ol>
								</div>
							</div>
							
							<div class="box-footer">
								<button class="btn btn-sm btn-success" type="button" id="bt_in_vis"><i class="fa fa-folder-open"></i> Incluir</button>
							</div>
						</form>
					</div><!-- ./box -->
					
				</div><!-- ./row -->
				<div class="row">
					<div class="col-xs-12">
						<div class="box box-success" id="firms">
							<div class="box-header with-border">
								<h3 class="box-title">Visitas Confirmadas</h3>
							</div><!-- /.box-header -->
							<div id="slc" class="box-body">
								 
								<?php //require_once('vis_docs.php');?>
								
							</div>
						</div><!-- ./box -->
					</div><!-- ./col -->
				</div>
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
    <script src="<?=$hosted;?>/triangulo/js/controle.js"></script>
    <script src="<?=$hosted;?>/triangulo/js/action_triang.js"></script>
    <script src="<?=$hosted;?>/triangulo/js/jquery.cookie.js"></script>
    <script src="<?=$hosted;?>/triangulo/js/functions.js"></script>
    <!-- AdminLTE App -->
    <script src="<?=$hosted;?>/sistema/assets/dist/js/app.min.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="<?=$hosted;?>/sistema/assets/dist/js/pages/dashboard.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?=$hosted;?>/sistema/assets/dist/js/demo.js"></script>

	<!-- SELECT2 TO FORMS
	-->

	<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
	<!-- Validation -->
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
	<script>
		$(".select2").select2({
			tags: true,
			theme: "classic"
		});
	</script>

</body>
</html>	