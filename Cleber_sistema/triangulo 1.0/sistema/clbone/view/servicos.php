<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start();
$sec = "SERV";
$pag = "servicos.php";
require_once("../config/main.php");
require_once("../config/valida.php");
require_once("../config/mnutop.php");
require_once("../config/menu.php");
require_once("../config/modals.php");
require_once("../../sistema/class/class.functions.php");
$rs = new recordset();
?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
		<!-- Content Header (Page header) -->
        <section class="content-header">
			<h1>
				Servi&ccedil;os
				
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li>Gerenciamento</li>
				<li>Servi&ccedil;os</li>
				<li class="active">Itens</li>
				
			</ol>
        </section>

        <!-- Main content -->
        <section class="content">
			 <div class="row">
				<!-- left column -->
				<div class="col-md-12">
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title">Itens para Servi&ccedil;os</h3>
						</div><!-- /.box-header -->
						<!-- form start -->
						<form id="cad_servicos" role="form">
						<div class="box-body">
							<div class="row">
								<div class="form-group col-md-4">
									<label for="emp_cnpj">Escolha o Cliente:</label><br>
									<select class="select2 form-control" id="serv_cli" name="serv_cli" >
										<option value="">Selecione:</option>
										<?php
											$whr="ativo = 1";
											$rs->Seleciona("*","tri_clientes",$whr);
											while($rs->GeraDados()):	
											?>
											<option value="<?=$rs->fld("cod");?>"><?=$rs->fld("cod")." - ".$rs->fld("empresa");?></option>
										<?php
											endwhile;
										?>
									</select>
								</div>
								
							</div>

							<div class="row">
								<div class="form-group col-xs-12">
									 <div class="box box-info">
										<div class="box-header">
											<h3 class="box-title">Observa&ccedil;&otilde;es <small>Detalhes do Item</small></h3>
										<!-- tools box -->
										<div class="pull-right box-tools">
											
											<button class="btn btn-info btn-xs" data-widget="remove" data-toggle="tooltip" title="Fechar"><i class="fa fa-times"></i></button>
										</div><!-- /. tools -->
										</div><!-- /.box-header -->
											<div class="box-body pad">
											<textarea class="form-control text-uppercase" id="editor1" placeholder="editor1">
											<?=trim($rs->fld("obs"));?>
											</textarea>
										</div>
									</div><!-- /.box -->
									
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
							<button type="button" id="bt_addserv" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Incluir </button>
							
						</div>
						</form>
					</div>				
				</div><!-- /.col -->
			</div><!-- ./row -->
			<div class="row">
					<div class="col-xs-12">
						<div class="box box-success" id="firms">
							<div class="box-header with-border">
								<h3 class="box-title">Servi&ccedil;os Cadastrados</h3>
							</div><!-- /.box-header -->
							<div id="slc" class="box-body">
								 
								<?php require_once('vis_servs.php');?>
								
							</div>
						</div><!-- ./box -->
					</div><!-- ./col -->
				</div>
		</section>
	</div>

	<?php 
		require_once("../config/footer.php");
		//require_once("../config/sidebar.php");
	?></div><!-- ./wrapper -->

<script src="<?=$hosted;?>/sistema/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="<?=$hosted;?>/sistema/assets/js/maskinput.js"></script>
<script src="<?=$hosted;?>/sistema/assets/js/jmask.js"></script>
<script src="<?=$hosted;?>/clbone/js/action_triang.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="<?=$hosted;?>/sistema/assets/bootstrap/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="<?=$hosted;?>/sistema/assets/plugins/fastclick/fastclick.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=$hosted;?>/sistema/assets/dist/js/app.min.js"></script>
<!-- Slimscroll -->
<script src="<?=$hosted;?>/sistema/assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="<?=$hosted;?>/clbone/js/jquery.cookie.js"></script>
<script src="<?=$hosted;?>/clbone/js/functions.js"></script>



<!-- SELECT2 TO FORMS
-->
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
<!-- Validation -->
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script src="<?=$hosted;?>/sistema/assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
	 

	<script type="text/javascript">
	setInterval(function(){

		if($.cookie('msg_lido')==0) {
			notify($.cookie("user"), $.cookie("mensagem"),$.cookie("pag"));
			$.cookie("msgant");
			$.cookie('msg_lido',1);
		}
	},3500);

	 jQuery(function () {
		// Replace the <textarea id="editor1"> with a CKEditor
		// instance, using default configuration.
		CKEDITOR.replace('editor1');
	});


	$(".select2").select2({
		tags: true,
		theme: "classic"
	});
	
	
	
	</script>

</body>
</html>	