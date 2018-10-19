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
$con = $per->getPermissao($pag,$_SESSION['usu_cod']);

if($con['C']<>1){
	header("location:403.php?token=".$_SESSION['token']);
}

?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
		<!-- Content Header (Page header) -->
        <section class="content-header">
			<h1>
				Central de Tarefas
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li>Solicita&ccedil;&atilde;o</li>
				<li class="active">Tarefas</li>
			</ol>
        </section>

        <!-- Main content -->
        <section class="content">
			<div class="row">
				<div class="col-xs-12">
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title">Pesquisa de Tarefas</h3>
						</div>
						<div class="box-body">
							<div id="clientes" class="row">
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

								<div class="form-group col-md-4">
									<label for="metas_emp">Colaborador:</label><br>
									<select class="selectm" multiple="multiple" style="width:100%" name="metas_colab" id="metas_colab">
										<option value="">Selecione:</option>
									</select>
								</div>
													
								<div class="form-group col-md-2">
									<label for="metas_dtini">Data Inicio:</label>
									<input type="text" class="form-control dtp" name="metas_dtini" id="metas_dtini" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask/>
								</div>
								<div class="form-group col-md-2">
									<label for="metas_dtfim">Data Fim:</label>
									<input type="text" class="form-control dtp" name="metas_dtfim" id="metas_dtfim" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask/>
								</div>
								
							</div>
						</div>
						<div class="box-footer">
							<button class="btn btn-sm btn-primary" id="btn_pesqmetas"><i class="fa fa-search"></i> Pesquisar</button>
							<a href="metas_lista.php?token=<?=$_SESSION['token'];?>" class="btn btn-sm btn-success"><i class="fa fa-file"></i> Nova</a>
						</div>
					</div>
				</div>
				<div class="col-xs-12">
					<div class="box box-info">
						<div class="box-header with-border">
							<h3 class="box-title">Tarefas</h3>
						</div><!-- /.box-header -->
						<div id="vismetas" class="box-body">
							 
							<?php 
							//require_once('minhas_metas.php');
							?>
							
						</div>
						
					</div><!-- ./box -->
				</div><!-- ./col -->		
	</section>
</div>
<?php
	require_once("../config/footer.php");
?>
</div><!-- ./wrapper -->


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
<script src="<?=$hosted;?>/sistema/assets/bootstrap/js/star-rating.js"></script>

<script src="<?=$hosted;?>/sistema/assets/plugins/input-mask/jquery.inputmask.js"></script>
<script src="<?=$hosted;?>/sistema/assets/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="<?=$hosted;?>/sistema/assets/plugins/input-mask/jquery.inputmask.extensions.js"></script>

<script src="<?=$hosted;?>/sistema/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=$hosted;?>/sistema/assets/plugins/datatables/dataTables.bootstrap.min.js"></script> 


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

		$(".selectm").select2({
			tags: true,
			theme:"classic"
		});

		$(".dtp").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/aaaa"});			
		setTimeout(function(){
			$("#slc").load("meus_chamados.php");		
			$("#alms").load(location.href+" #almsg");
		 },10000);

		$("#metas_depart").on("change",function(){
			$("#metas_colab").html('...carregando');//alert("OK");
			$.post("../controller/TRIEmpresas.php", 
			{
				acao:"combo_dep",
				id_dep: $("#metas_depart").val()
			}, 
			function(data){
				$("#metas_colab").html(data);		
			}, 
			"html"
		);
		});
	});
</script>

</body>
</html>	