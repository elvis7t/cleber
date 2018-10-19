<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start("portal");
$sec = "Mens";
$pag = "solicita_docs.php";
require_once("../config/main.php");
require_once("../config/valida.php");
require_once("../config/mnutop.php");
require_once("../config/menu.php");
require_once("../config/modals.php");
require_once("../class/class.functions.php");
require_once("../class/class.permissoes.php");
$per = new permissoes();
$con = $per->getPermissao($pag, $_SESSION['usu_cod']);
$deptos = $per->getPermissao("todos_depart", $_SESSION['usu_cod']);

if($con['C']<>1){
  header("location:403.php?token=".$_SESSION['token']);
}

?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
		<!-- Content Header (Page header) -->
        <section class="content-header">
			<h1>
				Solicita&ccedil;&atilde;o de Documentos
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li>Documentos</li>
				<li class="active">Solicita&ccedil;&atilde;o de Documentos</li>
			</ol>
        </section>

        <!-- Main content -->
        <section class="content">
			<div class="row">
				<div class="col-md-12">
				<!-- general form elements -->
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title">Solicitar Documentos</h3>
						</div><!-- /.box-header -->
						<!-- form start -->
						<form role="form" id="doc_entrada">
							<div class="box-body">
								<!-- radio Clientes -->
								<div id="clientes" class="row">
									
									<div class="form-group col-xs-3">
										<label for="sel_emp">Departamento</label><br>
										<select class="form-control select2 input-sm" id="sel_dep" name="sel_dep">
											<option value="">Selecione:</option>
											<?php
												$whr="dep_id<>0";
												if($deptos['C']==0){ $whr.=" AND dep_id = ".$_SESSION['dep'];}
	
												$rs->Seleciona("*","departamentos",$whr);
												while($rs->GeraDados()):	
												?>
												<option value="<?=$rs->fld("dep_id");?>"><?=$rs->fld("dep_nome");?></option>
											<?php
												endwhile;
											?>
										</select>
									</div>

									<div class="form-group col-xs-6">
										<label for="sel_emp">Cliente</label><br>
										<select class="form-control select2 input-sm" id="sel_emp" name="sel_emp">
											<option value="">Selecione:</option>
											<?php
												$whr="ativo = 1";
												$rs->Seleciona("*","tri_clientes",$whr);
												while($rs->GeraDados()):	
												?>
												<option value="<?=$rs->fld("cod");?>"><?=str_pad($rs->fld("cod"),3,"000",STR_PAD_LEFT)." - ".$rs->fld("empresa");?></option>
											<?php
												endwhile;
											?>
										</select>
									</div>	
									<div class="form-group col-xs-2">
										<label for="dpc_ref">Refer&ecirc;ncia</label>
										<input type="text" class="form-control input-sm shortdate" name="doc_ref" id="doc_ref"/>
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
							
							
						</form>
					</div><!-- ./box -->
					<div class="box-footer">
						<button class="btn btn-sm btn-success" type="button" id="bt_doc_pesq"><i class="fa fa-search"></i> Pesquisar</button> 
						
					</div>
				</div><!-- ./row -->
				<div class="row">
					<div class="col-xs-12">
						<div class="box box-success" id="docs_rec">
							<div class="box-header with-border">
								<h3 class="box-title">Documentos Recebidos</h3>
							</div><!-- /.box-header -->
							<div id="slc" class="box-body">
								<div class="row">
									<div id ="doc_report" class="col-md-12">
									 	<?php 
									 		//require_once('vis_solicitadocs.php');
									 	?>
									</div>
								</div>
								
							</div>
						</div><!-- ./box -->
					</div><!-- ./col -->
				</div>
				<div class="row">
					<div class="col-xs-12">
						<div class="box box-danger" id="docs_falt">
							<div class="box-header with-border">
								<h3 class="box-title">Documentos Faltando</h3>
							</div><!-- /.box-header -->
							<div id="slc" class="box-body">
								<div class="row">
									<div id ="doc_reportf" class="col-md-12">
									 	<?php 
									 		//require_once('vis_solicitadocsf.php');
									 	?>
									</div>
								</div>
							</div>
						</div><!-- ./box -->
					</div><!-- ./col -->
							
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
<script src="<?=$hosted;?>/sistema/js/controle.js"></script>
<script src="<?=$hosted;?>/sistema/js/action_documentos.js"></script>
<script src="<?=$hosted;?>/sistema/js/jquery.cookie.js"></script>
<script src="<?=$hosted;?>/sistema/js/functions.js"></script>	
<!--INPUT MASK -->
<script src="<?=$hosted;?>/sistema/assets/plugins/input-mask/jquery.inputmask.js"></script>
<script src="<?=$hosted;?>/sistema/assets/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="<?=$hosted;?>/sistema/assets/plugins/input-mask/jquery.inputmask.extensions.js"></script>
	<!-- SELECT2 TO FORMS
	-->

	<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
	<!-- Validation -->
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
	<script>
		$(function(){
			$(".select2").select2({
				tags: true
			});
			$(".seldocs").select2({
				tags: true,
				theme: "classic"
			});
			$("#doc_dtfim, #doc_dtini").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/aaaa"});
		});
	</script>

</body>
</html>	