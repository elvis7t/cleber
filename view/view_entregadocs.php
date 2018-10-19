<?php
/*inclusão dos principais itens da página */
$sec = "Mens";
$pag = "view_entregadocs.php";
require_once("../config/main.php");
require_once("../config/valida.php");
require_once("../config/mnutop.php");
require_once("../config/menu.php");
require_once("../config/modals.php");
require_once("../class/class.functions.php");
require_once("../class/class.permissoes.php");
$per = new permissoes();
$con = $per->getPermissao("entrega_docs.php", $_SESSION['usu_cod']);

if($con['C']<>1){
  header("location:403.php?token=".$_SESSION['token']);
}

?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
		<!-- Content Header (Page header) -->
        <section class="content-header">
			<h1>
				Entrega de Documentos
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li>Documentos</li>
				<li class="active">Entrega de Docs</li>
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
					<div class="box box-primary  <?=($con['I']==0?"hide":"");?>">
						<div class="box-header with-border">
							<h3 class="box-title">Receber Documentos</h3>
						</div><!-- /.box-header -->
						<!-- form start -->
						<form role="form" id="doc_entrada">
							<div class="box-body">
								<!-- radio Clientes -->
								<div id="clientes" class="row">
									<div class="form-group col-xs-6">
										<label for="sel_emp">Cliente</label><br>
										<select class="form-control select2 input-sm" id="sel_emp" name="sel_emp">
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
								<!-- radio Avulso -->
								<div id="avulsos" class="row">
									<div class="form-group col-xs-3">
										<label for="sel_dep">Departamento</label><br>
										<select class="form-control select2 input-sm" name="sel_dep" id="sel_dep" style="width:100%;">
											<option value="">Selecione:</option>
											<?php
												$whr="dep_id <> ''";
												$rs->Seleciona("*","departamentos",$whr);
												while($rs->GeraDados()):	
												?>
												<option value="<?=$rs->fld("dep_id");?>"><?=$rs->fld("dep_nome");?></option>
											<?php
												endwhile;
											?>
											
										</select>
									</div>

									<div class="form-group col-xs-5">
										<label for="sel_docs">Documento:</label><br>
										<select class="form-control seldocs input-sm" name="sel_docs" id="sel_docs" multiple="multiple" style="width:100%;">
											<option value="">Selecione:</option>
																			
										</select>
									</div>
									
									<div class="form-group col-xs-2">
										<label for="dpc_ref">Refer&ecirc;ncia</label>
										<input type="text" class="form-control input-sm shortdate" name="doc_ref" id="doc_ref"/>
										<input type="hidden" value="Fisico" name="doc_origem" id="doc_origem"/>
										<input type="hidden" value="Recepcao" name="doc_local" id="doc_local"/>
									</div>
									<div class="form-group col-xs-2">
										<label for="sel_resp">Respons&aacute;vel <small>(Opcional)</small></label>
										<select class="form-control select2" name="sel_resp" id="sel_resp" style="width: 100%;">
											<option value=0 SELECTED>Selecione:</option>
										</select>
									</div>
									<div class="form-group col-xs-12">
										<label for="doc_obs">Observa&ccedil;&atilde;o <small>(Opcional)</small></label>
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
							
							
						</form>
					</div><!-- ./box -->
					<div class="box-footer">
						<button class="btn btn-sm btn-success" type="button" id="bt_entradocs"><i class="fa fa-folder-open"></i> Receber</button> 
						
					</div>
				</div><!-- ./row -->
				<div class="row">
					<div class="col-xs-12">
						<div class="box box-success" id="firms">
							<div class="box-header with-border">
								<h3 class="box-title">Documentos Dispon&iacute;veis</h3>
							</div><!-- /.box-header -->
							<div id="slc" class="box-body">
								<div id ="doc_report" class="col-md-12">
								</div>
						
							</div>
								
							
							
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
<script src="<?=$hosted;?>/sistema/js/controle.js"></script>
<script src="<?=$hosted;?>/sistema/js/action_documentos.js"></script>
<script src="<?=$hosted;?>/sistema/js/jquery.cookie.js"></script>
<script src="<?=$hosted;?>/sistema/js/functions.js"></script>	
<!--INPUT MASK -->
<script src="<?=$hosted;?>/sistema/assets/plugins/input-mask/jquery.inputmask.js"></script>
<script src="<?=$hosted;?>/sistema/assets/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="<?=$hosted;?>/sistema/assets/plugins/input-mask/jquery.inputmask.extensions.js"></script>


<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
<!-- Validation -->
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script>
	$(document).ready(function(){
	
		$("#doc_report").load("vis_entradadocs.php");

		$(".select2").select2({
			tags: true
		});
		$(".seldocs").select2({
			tags: true,
			theme: "classic"
		});
		$("#doc_dtfim, #doc_dtini").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/aaaa"});
	});
	
	$("#sel_dep, #sel_emp").change(function(){
		$("#sel_docs").select2("val",0);
		$.post("../controller/TRIDocumentos.php",
		{
			acao: 	"combo_arquivo",
			dept: 	$("#sel_dep").val(),
			codi: 	$("#sel_emp").val()
		},
		function(data){
			$("#sel_docs").html(data);
			console.log(data);
		},
		"html");
	});
	
</script>
adabody>
</html>	