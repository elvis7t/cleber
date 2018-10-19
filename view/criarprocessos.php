<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start("portal");
$sec = "SERV";
$pag = "criarprocessos.php";
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
				CheckLists de Processos
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li>Tarefas</li>
				<li>CheckLists</li>
				<li class="active">Cria&ccedil;&atilde;o de Checklist</li>
			</ol>
        </section>

        <!-- Main content -->
        <section class="content">
			<div class="row">
				<div class="col-md-12">
				<!-- general form elements -->
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title">Novo Processo</h3>
						</div><!-- /.box-header -->
						<!-- form start -->
						<form role="form" id="proc_entrada">
							<div class="box-body">
								<!-- radio Clientes -->
								<div class="row">
									<div class="form-group col-xs-4">
										<label for="proc_nome">Nome do Processo</label><br>
										<input type="text" class="form-control input-sm" id="proc_nome" name="proc_nome"/>
									</div>

									<div class="form-group col-md-4">
										<label for="metas_dep">Departamento:</label><br>
										<select class="select2" style="width:100%" name="metas_depart" id="metas_depart">
											<option value="">Selecione:</option>
										
											<?php
												$pdep = $per->getPermissao("todos_depart",$_SESSION['usu_cod']);
												$whr = "dep_id<>0";
												if($pdep['C']<>1){$whr.= " AND dep_id=".$_SESSION['dep'];}
												$rs->Seleciona("*","departamentos",$whr,"","dep_nome ASC");
												while($rs->GeraDados()):	
											?>
												<option value="<?=$rs->fld("dep_id");?>"><?=$rs->fld("dep_nome");?></option>
											<?php
											endwhile;
											?>
										</select>
									</div>

								</div>
								
								<div id="consulta"></div>
								<div id="formerros_procs" class="clearfix" style="display:none;">
									<div class="callout callout-danger">
										<h4>Erros no preenchimento do formul&aacute;rio.</h4>
										<p>Verifique os erros no preenchimento acima:</p>
										<ol>
											<!-- Erros são colocados aqui pelo validade -->
										</ol>
									</div>
								</div>
							</div><!-- ./box -->
						</form>
						<div class="box-footer">
							<button class="btn btn-sm btn-success" type="button" id="bt_criaProcs"><i class="fa fa-save"></i> Criar</button> 
							
						</div>
					</div>
				
					<div class="row">
						<div class="col-xs-12">
							<div class="box box-success">
								<div class="box-header with-border">
									<h3 class="box-title">Processos Criados</h3>
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
		
		$(".select2").select2({
			tags: true
		});
		$("#doc_report").load("vis_procs.php");

		
	});
	
	
	
</script>
</body>
</html>	