<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start();
$sec = "Ramal";
require_once("../config/main.php");
require_once("../config/valida.php");
require_once("../config/mnutop.php");
require_once("../config/menu.php");
require_once("../../sistema/config/modals.php");
require_once("../../sistema/class/class.functions.php");
?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
		<!-- Content Header (Page header) -->
        <section class="content-header">
			<h1>
				Listagem de Ramais Internos
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li>Listagens</li>
				<li class="active">Ramal Interno</li>
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
							<h3 class="box-title">Lista de Ramais</h3>
						</div><!-- /.box-header -->
						<div class="box-body">
							<table id="ramais" class="table table-bordered table-striped">
								<thead>
									  <tr>
											<th>C&oacute;d:</th>
											<th>Nome</th>
											<th>E-mail</th>
											<th>Depto</th>
											<th>Ramal</th>
									  </tr>
								</thead>
								<tbody>
									<?php 
										$rs_ramal = new recordset();
										$sql = "SELECT * FROM usuarios a
													JOIN departamentos b ON a.usu_dep = b.dep_id
													WHERE usu_empcod = ".$_SESSION['usu_empcod']." AND usu_ativo='1' ORDER BY usu_nome";
										$rs_ramal->FreeSql($sql);
										
										while($rs_ramal->GeraDados()):?>
											<tr>
												<td><?=$rs_ramal->fld("usu_cod");?></td>
												<td>
													<a href="user_perfil.php?token=<?=$_SESSION['token'];?>&usuario=<?=$rs_ramal->fld("usu_cod");?>">
														<?=$rs_ramal->fld("usu_nome");?>
													</a>
													
												</td>
												<td><?=$rs_ramal->fld("usu_email");?></td>
												<td><?=$rs_ramal->fld("dep_nome");?></td>
												<td><?=$rs_ramal->fld("usu_ramal");?></td>
											</tr>
										<?php
										endwhile;
									?>

								</tbody>
								 <tfoot>
									<tr>
										<th>Nome</th>
										<th>E-mail</th>
										<th>Depto</th>
										<th>Ramal</th>
									</tr>
								</tfoot>
							</table>								 
						</div><!-- ./box -->
					</div><!-- ./row -->
				</div>
			</div>
		</section>
	</div><!-- ./wrapper -->
	<?php
		require_once("../config/footer.php");
	?>

<script src="<?=$hosted;?>/sistema/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?=$hosted;?>/sistema/assets/bootstrap/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="<?=$hosted;?>/sistema/assets/plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?=$hosted;?>/sistema/assets/dist/js/app.min.js"></script>
	<!--datatables-->
    <script src="<?=$hosted;?>/sistema/assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?=$hosted;?>/sistema/assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
   <!-- Slimscroll -->
    <script src="<?=$hosted;?>/sistema/assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
	<script src="<?=$hosted;?>/sistema/assets/fastclick/fastclick.min.js"></script>
    <script src="<?=$hosted;?>/sistema/assets/js/maskinput.js"></script>
    <script src="<?=$hosted;?>/sistema/assets/js/jmask.js"></script>
    <script src="<?=$hosted;?>/triangulo/js/controle.js"></script>
    <script src="<?=$hosted;?>/triangulo/js/action_triang.js"></script>
    <script src="<?=$hosted;?>/triangulo/js/functions.js"></script>
	<!-- SELECT2 TO FORMS
	-->
	<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
	<!-- Validation -->
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
	<script>
		$(".select2").select2({
			tags: true,
			theme: "classic"
		});

		$(function () {
			$('#ramais').DataTable({
				"paging": true,
				"lengthChange": true,
				"searching": true,
				"ordering": true,
				"info": true,
				"autoWidth": true
			});
		});
	
		
	</script>

</body>
</html>	