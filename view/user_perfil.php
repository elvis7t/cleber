<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start("portal");
$sec = "Perfil";
require_once("../config/main.php");
require_once("../config/valida.php");
require_once("../config/mnutop.php");
require_once("../config/menu.php");
require_once("../config/modals.php");
require_once("../class/class.functions.php");

$rs_user = new recordset();
$fn = new functions();
$sql = "SELECT * FROM usuarios a
		  LEFT JOIN dados_user b ON a.usu_email = b.dados_usu_email
		  LEFT JOIN departamentos c ON a.usu_dep = c.dep_id
		  WHERE usu_cod = ".$_GET['usuario'];
$rs_user->FreeSql($sql);
$disable="disabled";
$rs_user->GeraDados();
if(($rs_user->fld("usu_cod") == $_SESSION['usu_cod']) OR ($_SESSION['classe'])==1){
  $disable = "";
}
?>
 <!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
			Perfil
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li><a href="#">Usu&aacute;rios</a></li>
			<li class="active">Perfil</li>
			</ol>
		</section>

		<!-- Main content -->
		<section class="content">
			<div class="row">
			<div class="col-md-3">
				<!-- Profile Image -->
				<div class="box box-primary">
				<div class="box-body box-profile">
					<img class="profile-user-img img-responsive img-circle" src="<?=$hosted."/".$rs_user->fld('usu_foto');?>" alt="User profile picture">
					<h3 class="profile-username text-center"><?=$rs_user->fld('usu_nome');?></h3>
					<p class="text-muted text-center"><?=$rs_user->fld('dep_nome');?></p>
					
				</div><!-- /.box-body -->
			</div><!-- /.box -->

			  <!-- About Me Box -->
			<div class="box box-primary">
				<div class="box-header with-border">
				 	<h3 class="box-title">Sobre mim</h3>
				</div><!-- /.box-header -->
				<div class="box-body">
					<strong><i class="fa fa-birthday-cake margin-r-5"></i>	Nascimento</strong>
					<p class="text-muted">
					<?=$fn->data_br($rs_user->fld('dados_nasc'));?>
					</p>

					<hr>
					<strong><i class="fa fa-book margin-r-5"></i>	Forma&ccedil;&atilde;o</strong>
					<p class="text-muted">
						<?=$rs_user->fld('dados_escol');?>
					</p>

					<hr>

					<strong><i class="fa fa-map-marker margin-r-5"></i> Endere&ccedil;o</strong>
					<p class="text-muted">
						<adress>
							<?php
							 echo $rs_user->fld('dados_rua').", ".$rs_user->fld('dados_num')." ".$rs_user->fld('dados_compl')."<br>";
							 echo $rs_user->fld('dados_bairro')." - ".$rs_user->fld('dados_cidade')." - ".$rs_user->fld('dados_uf')."<br> CEP: ".$rs_user->fld('dados_cep');
							?>
						</adress>	
					</p>
					<hr>
					<strong><i class="fa fa-file-text-o margin-r-5"></i> Notas</strong>
					<p><?=$rs_user->fld('dados_notas');?></p>
				</div><!-- /.box-body -->
				</div><!-- /.box -->
			</div><!-- /.col -->
			<div class="col-md-9">
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#tab_1" data-toggle="tab">Dados do Usu&aacute;rio</a></li>
						<li><a href="#tab_2" data-toggle="tab">Alterar Senha</a></li>
						<li><a href="#tab_3" data-toggle="tab">Empresas</i></a></li>
					</ul>
				

					<div class="tab-content">
						<div class="tab-pane active" id="tab_1">
							<?php require_once("vis_userdados.php"); ?>
						</div><!-- /.tab-pane -->
						
						<div class="tab-pane" id="tab_3">
							<?php require_once("vis_userempresas.php"); ?>	
						</div><!-- /.tab-pane -->

						<div class="tab-pane" id="tab_2">
							<?php require_once("vis_usersenha.php"); ?>	
						</div><!-- /.tab-pane -->
					
					</div><!-- /.tab-content -->
				</div><!-- nav-tabs-custom -->
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
<!-- bootstrap color picker -->
<script src="<?=$hosted;?>/sistema/assets/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>

<script src="<?=$hosted;?>/sistema/assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="<?=$hosted;?>/sistema/assets/js/maskinput.js"></script>
<script src="<?=$hosted;?>/sistema/assets/js/jmask.js"></script>
<script src="<?=$hosted;?>/sistema/js/controle.js"></script>
<script src="<?=$hosted;?>/sistema/js/action_triang.js"></script>
<script src="<?=$hosted;?>/sistema/js/jquery.cookie.js"></script>
<script src="<?=$hosted;?>/sistema/js/functions.js"></script>

<script src="<?=$hosted;?>/sistema/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=$hosted;?>/sistema/assets/plugins/datatables/dataTables.bootstrap.min.js"></script> 

  <!-- SELECT2 TO FORMS  -->

<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
<!-- Validation -->
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
 <script>
 	
	$(document).ready(function(){
		$('#user_empresas').DataTable({
			"order": [[ 2, "asc" ],[1,"asc"]],
			"columnDefs": [{
			"data":   "Ativos",
                render: function ( data, type, row ) {
                    if ( type === 'display' ) {
                        return '<input type="checkbox" name="chk_empresas[]" value="'+row[1]+'">';
                    }
                    return data;
                },
			"defaultContent": "-",
			"width": "10%",
			"targets": 0,
			'checkboxes': {
            'selectRow': true}
			}]
		});
	});
				
	$(".select2").select2({
		tags: true,
	});

	$(".select2").on('click', 'option', function() {
	if ($(".select2 option:selected").length > 5) {
		$(this).removeAttr("selected");
		// alert('You can select upto 3 options only');
	}
});
  setTimeout(function(){
	$("#slc").load("vis_solic.php");	
	$("#alms").load(location.href+" #almsg");
   },10000);
   $(".my-colorpicker2").colorpicker();
   
  </script>

</body>
</html> 