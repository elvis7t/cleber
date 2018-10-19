<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start("portal");
$sec = "Mens";
$pag = "dp_homologa.php";
require_once("../config/main.php");
require_once("../config/valida.php");
require_once("../config/mnutop.php");
require_once("../config/menu.php");
require_once("../config/modals.php");
require_once("../class/class.functions.php");

?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
		<!-- Content Header (Page header) -->
        <section class="content-header">
			<h1>
				Homologa&ccedil;&otilde;es <small>Departamento Pessoal</small>
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li>Solicita&ccedil;&atilde;o</li>
				<li class="active">Homologa&ccedil;&otilde;es</li>
			</ol>
        </section>

        <!-- Main content -->
        <section class="content">
			<?php
 
				if(isset($_SESSION['classe'])){$classe = $_SESSION['classe'];}
				else{$classe=0;}
			?>
			 	
				<div class="row">
					<div class="col-xs-12">
						<div class="box box-primary">
							<div class="box-header with-border">
								<h3 class="box-title">Pesquisa de Homologa&ccedil;&otilde;es</h3>
							</div>
							<div class="box-body">
								<div id="clientes" class="row">
									<div class="form-group col-md-3">
										<label for="emp_cnpj">Colaborador:</label><br>
										<select class="select2" style="width:100%" name="sel_user" id="sel_user">
											<option value="">Selecione:</option>
										
										<?php
										$cnpj = $_SESSION['usu_empresa'];
										$whr="usu_ativo = '1' AND usu_emp_cnpj = '".$cnpj."'";
										$rs->Seleciona("*","usuarios",$whr);
										while($rs->GeraDados()):	
										?>
											<option value="<?=$rs->fld("usu_cod");?>"><?=$rs->fld("usu_nome");?></option>
										<?php
										endwhile;
										?>
										</select>
									</div>
									<div class="form-group col-md-2">
										<label for="emp_cnpj">Data Inicio:</label>
										<input type="text" class="form-control" name="cham_dtini" id="cham_dtini"/>
									</div>
									<div class="form-group col-md-2">
										<label for="emp_cnpj">Data Fim:</label>
										<input type="text" class="form-control" name="cham_dtfim" id="cham_dtfim"/>
									</div>
									<div class="form-group col-md-2">
										<label for="emp_cnpj">Status:</label><br>
										<select class="select2" style="width:100%" name="sel_status" id="sel_status">
											<option value="">Selecione:</option>
											<option value=0>Aguardando</option>
											<option value=91>Aguardando Interação</option>
											<option value=92>Em Atendimento</option>
											<option value=99>Resolvido</option>
										
										</select>
									</div>
								</div>
							</div>
							<div class="box-footer">
								<button class="btn btn-sm btn-primary" id="btn_pes_cham"><i class="fa fa-search"></i> Pesquisar</button>
								<a href="form_homologa.php?token=<?=$_SESSION['token'];?>" class="btn btn-sm btn-success pull-right"><i class="fa fa-file"></i> Novo</a>
							</div>
						</div>
					</div>
					<div class="col-xs-12">
						<div class="box box-success" id="firms">
							<div class="box-header with-border">
								<h3 class="box-title">Homologa&ccedil;&otilde;es Agendadas</h3>
							</div><!-- /.box-header -->
							<div id="sl" class="box-body">
								 
							
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
<script src="<?=$hosted;?>/sistema/js/action_triang.js"></script>
<script src="<?=$hosted;?>/sistema/js/action_empresas.js"></script>
<script src="<?=$hosted;?>/sistema/js/controle.js"></script>
<script src="<?=$hosted;?>/sistema/js/jquery.cookie.js"></script>
<script src="<?=$hosted;?>/sistema/js/functions.js"></script>
<script src="<?=$hosted;?>/sistema/assets/bootstrap/js/star-rating.js"></script>


<!-- SELECT2 TO FORMS
-->

<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
<!-- Validation -->
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script>
	/*------------------------|INICIA TOOLTIPS E POPOVERS|---------------------------------------*/
	$(document).ready(function () {
		$("#sl").load("vis_dphomologa.php?token=<?=$_SESSION['token'];?>");	
		$(".select2").select2({
			tags: true
		});			
		setTimeout(function(){
			$("#slc").load("meus_chamados.php");		
			$("#alms").load(location.href+" #almsg");
		 },10000);
	});
</script>

</body>
</html>	