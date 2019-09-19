	<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start();
$sec = "Fab";
$pag = "fabricante.php";
require_once("../config/main.php");
require_once("../config/valida.php");
require_once("../config/mnutop.php");
require_once("../config/menu.php");
require_once("../config/modals.php");
require_once("../../sistema/class/class.functions.php");
$rs = new recordset();

?>
<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
			<h1>
						Ativos
				<small>Cadastro</small>
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="active">Fabricante</li>
			</ol>
        </section>
        <!-- Main content -->
        <section class="content">
			<!-- Info boxes -->
			<div class="row">
				<!-- left column -->
				<div class="col-md-12">
				<!-- general form elements -->
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title">Cadastro de Fabricante</h3>
						</div><!-- /.box-header -->
						<!-- form start -->
						<form id="cadFab" role="form">
							<div class="box-body">
								<div class="row">
									<div class="form-group col-md-7">
										<label for="tp_nome">Descri&ccedil;&acirc;o</label> 
										<input type="text" class="form-control" id="fab_nome" name="fab_nome"  placeholder="Desc. do Fabricante">
									</div>
								</div>
								
								<div id="formerrosCadFab" class="clearfix" style="display:none;"> 
									<div class="callout callout-danger">
										<h4>Erros no preenchimento do formul&aacute;rio.</h4>
										<p>Verifique os erros no preenchimento acima:</p>
										<ol>
											<!-- Erros são colocados aqui pelo validade -->
										</ol>
									</div>
								</div>
							</div><!-- /.box-body -->
							<div class="box-footer">
								<button type="button" id="btn_cadFab" class="btn btn-primary" type="submit"><i class="fa fa-save"></i> Salvar</button>
							</div>
							<div id="mens"></div>
						</form>
					</div><!-- /.box -->
				<!-- general form elements --> 
				<div class="box box-success"> 
					<div class="box-header with-border">
						<h3 class="box-title">Fabricantes Cadastrados</h3> 
					</div><!-- /.box-header -->
					<!-- form start -->
					<div class="box-body">
						<table id="Fab" class="table table-bordered table-striped">
							<thead>
								  <tr>
										<th>C&oacute;d:</th>
										<th>Descri&ccedil;&atilde;o</th> 
										<th>A&ccedil;&otilde;es</th>
								  </tr>
							</thead>
							
								<tbody id="fab_cad">
								<?php
								$rs = new recordset();
								$sql ="SELECT * FROM fabricantes
								WHERE fab_id <> 0";
								$rs ->FreeSql($sql);
								if($rs->linhas==0):
								echo "<tr><td colspan=7> Nenhum Fabricante...</td></tr>";
								else:

								while($rs ->GeraDados()){ ?> 
								<tr>
								<td><?=$rs ->fld("fab_id");?></td>
								<td><?=$rs ->fld("fab_nome");?></td>
								<td>
								<div class="button-group">
									<!--<button type="button" class="btn btn-xs btn-primary" id="btn_alterar" data-toggle='tooltip' data-placement='bottom' title='Alterar'><i class="fa fa-pencil"></i> </button> -->
									<!--<button type="button" class="btn btn-xs btn-danger" id="btn_excluir" data-toggle='tooltip' data-placement='bottom' title='Excluir'><i class="fa fa-trash"></i> </button> -->
									<a 	class="btn btn-warning btn-xs" data-toggle='tooltip' data-placement='bottom' title='Alterar Tarefa' a href="fab_alt.php?token=<?=$_SESSION['token']?>&acao=N&serv=<?=$rs->fld('fab_id');?>"><i class="fa fa-pencil"></i></a>
									<a 	class="btn btn-danger btn-xs" data-toggle='tooltip'  data-placement='bottom' title='Excluir' a href='javascript:del(<?=$rs->fld("fab_id");?>,"exc_Fab","o item");'><i class="fa fa-trash"></i></a>
								</div>
								</td> 

								</tr>	
								<?php 

								}
								echo "<tr><td colspan=7><strong>".$rs->linhas." Cadastrados</strong></td></tr>";
								endif;
								?> 
							</tbody> 
							
							 
						</table>
						
					</div><!-- /.box-body -->
							
              </div><!-- /.box --> 
			
          </div>
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

      <?php 
        require_once("../config/footer.php");
        //require_once("../config/side.php");
      ?>
      <div class="control-sidebar-bg"></div>

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
<script src="<?=$hosted;?>/clbone/js/action_ativos.js"></script>
<script src="<?=$hosted;?>/clbone/js/controle.js"></script>
<script src="<?=$hosted;?>/clbone/js/jquery.cookie.js"></script>
<script src="<?=$hosted;?>/clbone/js/functions.js"></script>


<!-- SELECT2 TO FORMS
-->

<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
<!-- Validation -->
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

<script>
	/*------------------------|INICIA TOOLTIPS E POPOVERS|---------------------------------------*/
	
	setTimeout(function(){
	$("#alms").load(location.href+" #almsg");
},10500);

$(function () {
	$('[data-toggle="tooltip"]').tooltip();
	$('[data-toggle="popover"]').popover({
        html:true
     });
});
	
	
</script>

</body>
</html>	