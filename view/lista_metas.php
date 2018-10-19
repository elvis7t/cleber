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
$fn = new functions();
$rs = new recordset();
$per = new permissoes();
$con =$per->getPermissao($pag, $_SESSION['usu_cod']);
$sql = "SELECT b.usu_nome, a.metas_dataini, a.metas_datafin FROM metas a 
			JOIN usuarios b ON a.metas_colab = b.usu_cod
		WHERE metas_id = ".$_GET['lista'];
$rs->FreeSql($sql);
$rs->GeraDados();


?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
		<!-- Content Header (Page header) -->
        <section class="content-header">
			<h1>
				Central de Tarefas
				<small>[ Lista: <?=$_GET['lista'];?> - <?=$rs->fld("usu_nome");?> | de <?=$fn->data_br($rs->fld("metas_dataini"));?> at&eacute; <?=$fn->data_br($rs->fld("metas_datafin"));?> ]</small>
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li>Solicita&ccedil;&atilde;o</li>
				<li class="active">Listar Tarefas</li>
			</ol>
        </section>

        <!-- Main content -->
        <section class="content">
			
				<div class="row">
					<div class="col-xs-12 <?=($con['I']==1?'':'hide');?>">
						<div class="box box-primary">
							<div class="box-header with-border">
								<h3 class="box-title">
									Listagem de Tarefas
									
								</h3>
							</div>
							<form id="cadmetas">
								<div class="box-body">
									<div id="listametas" class="row">
										<div class="form-group col-md-4">
											<label for="lismetas_emp">Empresa:</label><br>
											<select class="select2" style="width:100%" name="lismetas_emp" id="lismetas_emp">
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
											<!--|Dados da lista ativa|-->
											<input type="hidden" id="lismetas_dep" name="lismetas_dep" value="<?=$_SESSION['dep'];?>"/>
											<input type="hidden" id="lismetas_listaat" name="lismetas_listaat" value="<?=$_GET['lista'];?>"/>

										</div>
										
										<div class="form-group col-md-3">
											<label for="lismetas_depart">Departamento:</label><br>
											<select class="select2" style="width:100%" name="lismetas_depart" id="lismetas_depart">
												<option value="">Selecione:</option>
											
												<?php
													$whr="dep_id<>0";
													$rs->Seleciona("*","departamentos",$whr);
													while($rs->GeraDados()):	
													?>
														<option value="<?=$rs->fld("dep_id");?>"><?=$rs->fld("dep_nome");?></option>
													<?php
													endwhile;
												?>
											</select>
										</div>

										<div class="form-group col-md-3">
											<label for="lismetas_colab">Colaborador:</label><br>
											<select class="select2" style="width:100%" name="lismetas_colab" id="lismetas_colab">
												<option value="">Selecione:</option>
											
											</select>
										</div>

										<div class="form-group col-md-2">
											<label for="lismetas_tipo">Tipo (O/T/A/L):</label><br>
											<select class="select2" style="width:100%" name="lismetas_tipo" id="lismetas_tipo">
												<option value="">Selecione:</option>
												<option value="O">Obriga&ccedil;&atilde;o</option>
												<option value="T">Tributa&ccedil;&atilde;o</option>
												<option value="A">Apura&ccedil;&atilde;o</option>
												<option value="L">Lançamento</option>
											
											</select>
										</div>
									</div>

									<div class="row">
										<div class="form-group col-md-2">
											<label for="lismetas_inicial">Dia Inicial:</label>
											<input type="text" class="form-control" id="lismetas_inicial" name="lismetas_inicial">
										</div>

										<div class="form-group col-md-2">
											<label for="lismetas_final">Dia Final:</label>
											<input type="text" class="form-control" id="lismetas_final" name="lismetas_final">
										</div>

										<div class="form-group col-md-4">
											<label for="lismetas_obriga">Obriga&ccedil;&atilde;o:</label><br>
											<select class="multiple" multiple="multiple" style="width:100%" name="lismetas_obriga" id="lismetas_obriga">
												<option value="">Todas</option>
												<?php
													$whr="imp_id<>0";
													$rs->Seleciona("*","tipos_impostos",$whr);
													while($rs->GeraDados()):	
													?>
														<option value="<?=$rs->fld("imp_id");?>"><?=$rs->fld("imp_nome");?></option>
													<?php
													endwhile;
												?>
											</select>
										</div>

										<div class="form-group col-md-2">
											<label for="lismetas_compet">Compet&ecirc;ncia:</label>
											<input type="text" class="form-control shortdate" id="lismetas_compet" name="lismetas_compet">
										</div>

										<div class="form-group col-md-2">
											<label for="lismetas_lista">Da Lista:</label>
											<input type="text" class="form-control" id="lismetas_lista" name="lismetas_lista">
										</div>
										
									</div>
									<div id="consulta"></div>
									<div id="formerrosmetas" class="clearfix" style="display:none;">
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
									<button type="button" class="btn btn-sm btn-primary" id="btn_pesq_tarefa"><i class="fa fa-search"></i> Pesquisar</button>
								</div>
							</form>
						</div>
					</div>

					<div class="col-xs-12  <?=($con['I']==1?'':'hide');?>">
						<div class="box box-success">
							<div class="box-header with-border">
								<h3 class="box-title">Tarefas Pendentes</h3>
							</div><!-- /.box-header -->
							<div id="metas_obr" class="box-body">
								<?php 
									///require_once('vis_metas_aberto.php');
								?> 
							</div>
							
							<div class="box-footer">
								<?php
									$dfinal = $rs->pegar("metas_datafin", "metas","metas_id=".$_GET['lista']);
									if($dfinal<date("Y-m-d")):											
								?>
								<a href="javascript:history.go(-1);" class="btn btn-sm btn-danger" <?=$dis;?> id=""><i class="fa fa-times"></i> Meta expirada</a>
							<?php else: ?>
								<button class="btn btn-sm btn-success" <?=$dis;?> id="btn_nova_tarefa"><i class="fa fa-plus"></i> Tarefa</button>
							<?php endif;?>
							</div>
						</div><!-- ./box -->
					</div><!-- ./col -->

					<div class="col-xs-12">
						<div class="box box-danger" id="firms">
							<div class="box-header with-border">
								<h2 class="box-title pull-left">Tarefas Listadas</h2>
								<div class="btn-group pull-right" data-toggle="buttons">
								  <label class="btn btn-info btn-xs" id="semanal">
								    <input type="checkbox" checked id="meta_sem"> Somente no prazo
								  </label>
								</div>
								<span class="col-md-6">
								<?php if($con["E"]==1){ ?>	
									<div class="btn-group pull-left">
										<button type="button" class="btn btn-danger btn-xs">A&ccedil;&otilde;es em lote</button>
										<button type="button" class="btn btn-danger btn-xs dropdown-toggle" data-toggle="dropdown">
											<span class="caret"></span>
											<span class="sr-only">Toggle Dropdown</span>
										</button>
										 <ul class="dropdown-menu" role="menu">
					                        <li><a id="exclote"><i class="fa fa-trash"></i> Excluir </a></li>
					                    </ul>
									</div>
								<?php } ?>
							</span>
								
							</div><!-- /.box-header -->
							<div id="vis_metas" class="box-body">
								 
								<?php 
									require_once('vis_metaslistadas.php');
								?>
								
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
<script src="<?=$hosted;?>/sistema/js/action_chamados.js"></script>
<script src="<?=$hosted;?>/sistema/assets/js/jmask.js"></script>
<script src="<?=$hosted;?>/sistema/js/action_metas.js"></script>
<script src="<?=$hosted;?>/sistema/js/controle.js"></script>
<script src="<?=$hosted;?>/sistema/js/jquery.cookie.js"></script>
<script src="<?=$hosted;?>/sistema/js/functions.js"></script>
<script src="<?=$hosted;?>/sistema/assets/bootstrap/js/star-rating.js"></script>

<script src="<?=$hosted;?>/sistema/assets/plugins/input-mask/jquery.inputmask.js"></script>
<script src="<?=$hosted;?>/sistema/assets/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="<?=$hosted;?>/sistema/assets/plugins/input-mask/jquery.inputmask.extensions.js"></script>

<script src="<?=$hosted;?>/sistema/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=$hosted;?>/sistema/assets/plugins/datatables/dataTables.bootstrap.min.js"></script> 


<!-- SELECT2 TO FORMS-->

<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
<!-- Validation -->
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

<script>
	/*------------------------|INICIA TOOLTIPS E POPOVERS|---------------------------------------*/
	$(document).ready(function () {
		
		$(".select2").select2({
			tags: true
		});
		
		$(".multiple").select2({
			theme:"classic"
		});


		$(".dtp").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/aaaa"});

		setTimeout(function(){
			$("#alms").load(location.href+" #almsg");
		},10000);


		$(document.body).on("click","#semanal", function(){
			//alert($('#metas_sem').is(':checked'));
			if(!($('#meta_sem').is(':checked'))) {
				$("#vis_metas").load("vis_metaslistadas.php?lista=<?=$_GET['lista'];?>");
				$(this).removeClass("btn-danger").addClass("btn-info");
			}
			else{
				$("#vis_metas").load("vis_metaslistadas.php?sem=1&lista=<?=$_GET['lista'];?>");
				$(this).removeClass("btn-info").addClass("btn-danger");
			}
		});

		$("#lismetas_depart").on("change",function(){
			$("#lismetas_colab").html('<option SELECTED value="">SEM FILTRO</option>');//alert("OK");
			$("#lismetas_colab").select2("val", "");
			$.post("../controller/TRIEmpresas.php", 
			{
				acao:"combo_dep",
				id_dep: $("#lismetas_depart").val()
			}, 
			function(data){
				$("#lismetas_colab").html(data);		
			}, 
			"html"
		);
		});
	});
</script>

</body>
</html>	