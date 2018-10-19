<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start("portal");
$sec = "CHAMA";
$pag = "vis_verificacao.php";
require_once("../config/main.php");
require_once("../config/valida.php");
require_once("../config/mnutop.php");
require_once("../config/menu.php");
require_once("../config/modals.php");
require_once("../class/class.functions.php");
$rs = new recordset();
$fn = new functions();
?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
		<!-- Content Header (Page header) -->
        <section class="content-header">
			<h1>
				Fichas de Verifica&ccedil;&atilde;o
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li>Solicita&ccedil;&atilde;o</li>
				<li>Listas</li>
				<li class="active">Verificados</li>
			</ol>
        </section>

        <!-- Main content -->
        <section class="content">
			<?php
 
				if(isset($_SESSION['classe'])){$classe = $_SESSION['classe'];}
				else{$classe=0;}
				$sql = "SELECT a.*, b.*, c.empresa FROM listados a 
							JOIN lista_verificacao b ON a.lver_listaId = b.lista_id
							JOIN tri_clientes c ON b.lista_empresa = c.cod
						WHERE lver_listaId = ".$_GET['lista'];
				//echo $sql;
				$rs->FreeSql($sql);
				$rs->GeraDados();

			?>
			 	
				<div class="row">
					<div class="col-xs-12">
						<div class="box box-primary">
							<div class="box-header with-border">
								<h3 class="box-title">Verificados na Lista</h3>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="form-group col-md-1">
											<label for="lista_id">Lista #:</label>
											<input type="text" class="form-control" DISABLED value="<?=$rs->fld("lista_id");?>"/>
									</div>

									<div class="form-group col-md-4">
											<label for="lista_empresa">Empresa:</label>
											<input type="text" class="form-control" DISABLED value="<?=$rs->fld("empresa");?>"/>
									</div>
									<div class="form-group col-md-2">
											<label for="lista_compet">Compet&ecirc;ncia:</label>
											<input type="text" class="form-control" DISABLED value="<?=$rs->fld("lista_compet");?>"/>
									</div>

									<div class="form-group col-md-2">
											<label for="lista_stat">Status:</label>
											<input type="text" class="form-control" DISABLED value="<?=$rs->fld("lista_status");?>"/>
									</div>
									
								</div>
								
									<?php require_once("vis_maqverificados.php"); ?>
								
							</div>
							<div class="box-footer">
								<a href="../rel/rel_maqvist_excel.php?lista=<?=$_GET['lista'];?>" class="btn btn-md btn-success"><i class="fa fa-file-excel-o"></i> 
								Exportar para o Excel</a>
							</div>
						</div>
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
<script src="<?=$hosted;?>/sistema/js/action_chamados.js"></script>
<script src="<?=$hosted;?>/sistema/assets/js/jmask.js"></script>
<script src="<?=$hosted;?>/sistema/js/action_triang.js"></script>
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
		$(".dtp").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/aaaa"});			
		setTimeout(function(){
			$("#slc").load("meus_chamados.php");		
			$("#alms").load(location.href+" #almsg");
		 },10000);
	});
</script>

</body>
</html>	