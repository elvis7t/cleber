<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start();
$sec = "Mens";
$pag = "entrega_docs.php";
require_once("../config/main.php");
require_once("../config/valida.php");
require_once("../config/mnutop.php");
require_once("../config/menu.php");
require_once("../config/modals.php");
require_once("../class/class.functions.php");
require_once("../class/class.permissoes.php");
$per = new permissoes();
$con = $per->getPermissao($pag);

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
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title">Receber Documentos</h3>
						</div><!-- /.box-header -->
						<!-- form start -->
						<form role="form" id="doc_entrada">
							<div class="box-body">
								<!-- radio Clientes -->
								<div id="clientes" class="row">
									<div class="form-group col-xs-6">
										<label for="emp_cnpj">Cliente</label><br>
										<select class="select2 input-sm" name="sel_emp" id="sel_emp">
											<option value=0>Selecione:</option>
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
										<label for="emp_cnpj">Doc</label><br>
										<select class="select2 input-sm" name="sel_docs" id="sel_docs" style="width:100%;">
											<option value=0>Selecione:</option>
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
									<div class="form-group col-xs-3">
										<label for="emp_cnpj">Departamento</label><br>
										<select class="select2 input-sm" name="sel_dep" id="sel_dep" style="width:100%;">
											<option value=0>Selecione:</option>
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
									<div class="form-group col-xs-2">
										<label for="emp_cnpj">Refer&ecirc;ncia</label>
										<input type="text" class="form-control input-sm shortdate" name="doc_ref" id="doc_ref"/>
									</div>
									<div class="form-group col-xs-4">
										<label for="emp_cnpj">Respons&aacute;vel <small>(Opcional)</small></label>
										<select class="form-control select2" name="sel_resp" id="sel_resp" style="width: 100%;">
											<option value=0 SELECTED>Selecione:</option>
										</select>
									</div>
									<div class="form-group col-xs-12">
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
							
							
						</form>
					</div><!-- ./box -->
					<div class="box-footer">
						<button class="btn btn-sm btn-success" type="button" id="bt_doc_ent"><i class="fa fa-folder-open"></i> Receber</button> 
						
					</div>
				</div><!-- ./row -->
				<div class="row">
					<div class="col-xs-12">
						<div class="box box-success" id="firms">
							<div class="box-header with-border">
								<h3 class="box-title">Documentos Dispon&iacute;veis</h3>
							</div><!-- /.box-header -->
							<div id="slc" class="box-body">
								 <div class="row">
								 	<div class="form-group col-md-2">
										<input class="form-control input-sm" id="doc_dtini" name="doc_dtini" placeholder="Data Inicial">
										<input type="hidden" id="token" value="<?=$_SESSION['token'];?>"/>
									</div>
									<div class="form-group col-md-2">
										<input class="form-control input-sm" id="doc_dtfim" name="doc_dtfim" placeholder="Data Final">
									</div>
									<div class="form-group col-md-3">
										<select id="doc_stat" name="doc_stat" class="select2 input-sm" style="width:100%;">
											<option value="">Status:</option>
											<?php
											$sql = "SELECT * FROM codstatus WHERE st_opcaode='[SOLIC]'";
											$rs->FreeSql($sql);
											while($rs->GeraDados()){
											?>
												<option value="<?=$rs->fld("st_codstatus");?>"><?=$rs->fld("st_desc");?></option>
											<?php
											}
											?>										
										</select>
									</div>
									<div class="form-group col-md-3">
										<select id="doc_depar" name="doc_depar" class="select2 input-sm" style="width:100%;">
											<option value="">Departamento:</option>
											<?php
											$sql = "SELECT * FROM departamentos WHERE 1";
											if($_SESSION['classe']>2){
												$sql.=" AND dep_id = ".$_SESSION['dep'];
											}
											$sql.=" ORDER BY dep_id ASC";
											$rs->FreeSql($sql);
											while($rs->GeraDados()):	
											?>
												<option value="<?=$rs->fld("dep_id");?>"><?=$rs->fld("dep_nome");?></option>
											<?php
											endwhile;
											?>
										</select>
									</div>
									<div class="form-group col-md-2">
										<button class="btn btn-sm btn-info pull-right" id="pes_docs"><i class="fa fa-search"></i></button>
									</div>

								</div>
								<div class="row">
									
									<div id ="doc_report" class="col-md-12">
									 	<?php require_once('vis_docs.php');?>
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
<script src="<?=$hosted;?>/js/controle.js"></script>
<script src="<?=$hosted;?>/js/action_triang.js"></script>
<script src="<?=$hosted;?>/js/jquery.cookie.js"></script>
<script src="<?=$hosted;?>/js/functions.js"></script>	
<!--INPUT MASK -->
<script src="<?=$hosted;?>/assets/plugins/input-mask/jquery.inputmask.js"></script>
<script src="<?=$hosted;?>/assets/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="<?=$hosted;?>/assets/plugins/input-mask/jquery.inputmask.extensions.js"></script>
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
			$("#doc_dtfim, #doc_dtini").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/aaaa"});
		});
	</script>

</body>
</html>	