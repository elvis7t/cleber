<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start();
$sec = "CHORAS";
$pag = "controle_horas.php";
require_once("../config/main.php");
require_once("../config/valida.php");
require_once("../config/mnutop.php");
require_once("../config/menu.php");
require_once("../config/modals.php");
require_once("../class/class.functions.php");
require_once("../class/class.permissoes.php");

$per = new permissoes();
//$con = $per->getPermissao($pag, $_SESSION['usu_cod']);

?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
		<!-- Content Header (Page header) -->
        <section class="content-header">
			<h1>
				Controle de Horas
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li>Solicita&ccedil;&atilde;o</li>
				<li class="active">Controle de Horas</li>
			</ol>
        </section>
        
        <!-- Main content -->
        <section class="content">
			<div class="row">
				<div class="col-md-12">
				<!-- general form elements -->
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title">Controle de Horas</h3>
						</div><!-- /.box-header -->
						<!-- form start -->
						<form role="form" id="cad_hora">
							<input type="hidden" id="emp_altera" value=0 />
							<div class="box-body">
								<!-- radio Clientes -->
								<div id="clientes" class="row">
									<div class="form-group col-md-4">
										<label for="emp_cnpj">Selecione o Colaborador:</label><br>
										<select class="select2 form-control" name="ch_colab" id="ch_colab" style="width:100%;">
											<option value="">Selecione:</option>
										
											<?php
											$sql = "SELECT usu_cod, usu_nome FROM usuarios WHERE usu_ativo = '1' AND usu_empcod=".$_SESSION['usu_empcod'];
											/*
												| ALTERAÇÃO - CLEBER MARRARA - 29.05.2017					|
												| Verificação da permissão (36) de todos os departamentos	|
												| para mostrar todos os departamentos.						|

											*/
											$dep = $per->getPermissao("controle_depart",$_SESSION['usu_cod']);
											if($dep['C']==0){$sql.=" AND usu_dep=".$_SESSION['dep'];}
											/*
												| ALTERAÇÃO - CLEBER MARRARA - 29.05.2017					|
												| Verificação da permissão (34) de todos os funcionários	|
												| para mostrar todos os usuários. 							|

											*/
											$pus = $per->getPermissao("todos_func",$_SESSION['usu_cod']);
											if($pus['C']==0){$sql.=" AND usu_cod=".$_SESSION['usu_cod'];}
											$althora = $per->getPermissao("chora_alterasaida",$_SESSION['usu_cod']);
											$sql.=" ORDER BY usu_nome ASC";
											$rs->FreeSql($sql);
											while($rs->GeraDados()):	
											?>
												<option <?=($_SESSION['usu_cod']===$rs->fld("usu_cod")?"SELECTED":"");?> value="<?=$rs->fld("usu_cod");?>"><?=$rs->fld("usu_nome");?></option>
											<?php
											endwhile;
											?>
										</select>
										
									</div>	
								
									<div class="form-group col-md-2">
										<label for="emp_cnpj">Data:</label>
										<input type="text" class="form-control data_br" name="ch_data" id="ch_data" value="<?=date('d/m/Y');?>"/>
									</div>
									<div class="form-group col-md-2">
										<label for="emp_cnpj">Sa&iacute;da:</label>
										<input type="text" <?=($althora['C']==0 ? "DISABLED" : "" );?> class="form-control time" name="ch_hora_saida" id="ch_hora_saida" value="<?=date('H:i:s');?>"/>
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
								<button class="btn btn-sm btn-success" type="button" id="bt_horas"><i class="fa fa-save"></i> Salvar</button>
							</div>
						</form>
					</div><!-- ./box -->
				</div>	
			</div><!-- ./row -->
					
			<div class="row">
				<div class="col-md-12">
					<div class="box box-success" id="firms">
						<div class="box-header with-border">
							<h3 class="box-title">Controle de Horas - Lan&ccedil;amentos</h3>
						</div><!-- /.box-header -->
						<div class="box-body">
							<div id="pesquisa" class="row">
									<div class="form-group col-md-3">
										<input type="hidden" name="token" id="token" value="<?=$_GET['token']?>"/>
										<select class="select2 form-control" name="chr_dep" id="chr_dep" style="width:100%;">
											<option value="">Selecione:</option>
										
											<?php
											$sql = "SELECT * FROM departamentos WHERE 1";
											/*
												| ALTERAÇÃO - CLEBER MARRARA - 29.05.2017					|
												| Verificação da permissão (36) de todos os departamentos	|
												| para mostrar todos os departamentos.						|

											*/
											if($dep['C']==0){$sql.=" AND dep_id=".$_SESSION['dep'];}
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
									<div class="form-group col-md-3">
										<input type="text" class="form-control" name="chr_nome" id="chr_nome" placeholder="Colaborador" />
									</div>
									<div class="form-group col-md-2">
										<input type="text" class="form-control" name="chr_data" id="chr_data" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask />
									</div>
									<div class="form-group col-md-2">
										<input type="text" class="form-control" name="chr_dataf" id="chr_dataf" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask />
									</div>
									<div class="form-group col-md-2">
										<button class="btn btn-sm btn-info" id="pes_chora"><i class="fa fa-search"></i></button>
									</div>
									

								</div>
								<div id="slc">  
									<?php require_once('vis_controlehora.php');?>
								</div>
							</div>
							<div class="box-footer">
								<input type="hidden" id="dep" value="<?=(isset($_GET['chr_dep']) ? $_GET['chr_dep'] : "");?>"/>
								<input type="hidden" id="cola" value="<?=(isset($_GET['chr_nome']) ? $_GET['chr_nome'] : "");?>"/>
								<input type="hidden" id="data" value="<?=(isset($_GET['chr_data']) ? $_GET['chr_data'] : "");?>"/>
								<input type="hidden" id="dataf" value="<?=(isset($_GET['chr_dataf']) ? $_GET['chr_dataf'] : "");?>"/>
								<button type="button" class="btn btn-sm btn-success" id="btn_RelHora"><i class="fa fa-file-excel-o"></i> Gerar Excel</button>
							</div>
						</div>
					</div><!-- ./box -->
				</div><!-- ./col -->
			</div>
		</div>
	</section>
<script src="<?=$hosted;?>/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
	</div>
	<?php
		require_once("../config/footer.php");
	?></div><!-- ./wrapper -->


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
<script src="<?=$hosted;?>/assets/plugins/input-mask/jquery.inputmask.js"></script>
<script src="<?=$hosted;?>/assets/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="<?=$hosted;?>/assets/plugins/input-mask/jquery.inputmask.extensions.js"></script>

<script src="<?=$hosted;?>/js/action_triang.js"></script>
<script src="<?=$hosted;?>/js/controle.js"></script>
<script src="<?=$hosted;?>/js/jquery.cookie.js"></script>



<!-- SELECT2 TO FORMS
-->

<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
<!-- Validation -->
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script>
	/*------------------------|INICIA TOOLTIPS E POPOVERS|---------------------------------------*/
	$(document).ready(function () {
		

		$(".select2").select2({
			tags: true
		});

		$("#chatContent").scrollTop($("#msgs").height());					
		setTimeout(function(){
			//$("#slc").load("vis_controlehora.php");		
			$("#alms").load(location.href+" #almsg");
		 },10000);
		$("#chr_data, #chr_dataf").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/aaaa"});
	});
</script>

</body>
</html>	