<?php

/*inclusão dos principais itens da página */
$sec = "Eventos";
require_once("../config/main.php");
require_once("../config/valida.php");
require_once("../config/mnutop.php");

require_once("../config/menu.php");
require_once("../config/modals.php");
?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
		<!-- Content Header (Page header) -->
        <section class="content-header">
			<h1>
				Gerenciamento
				<small>Cadastro de Eventos</small>
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="active">Gerenciamento</li>
			</ol>
        </section>

        <!-- Main content -->
        <section class="content">
			 <div class="row">
				<!-- left column -->
				<div class="col-md-9">
				<!-- general form elements -->
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title">Eventos</h3>
						</div><!-- /.box-header -->
						<!-- form start -->
						<form role="form" id="cad_eve">
							<div class="box-body">
								
								<div class="row" id="cadastro">
									<div class="form-group col-xs-6">
										<label for="eve_local">Local do Evento:</label>
										<input class="form-control" id="eve_local" name="eve_local" placeholder="Local do Evento">
									</div>
									<div class="form-group col-xs-3">
										<label for="eve_data">Data</label>
										<input class="form-control date" id="eve_data" name="eve_data" placeholder="Data do Evento">
									</div>
									
									<div class="form-group col-xs-9">
										<label for="eve_det">Detalhes do Evento</label>
										<textarea class="form-control" id="eve_det" name="eve_det" placeholder="Detalhes"></textarea>
									</div>
									
								</div>
								<div class="row">
									<div class="form-group col-xs-4">
										<label for="eve_valor">Valor</label>
										<input class="form-control" id="eve_valor" name="eve_valor" placeholder="Valor do Envento">
										<span class="text-info" id="vtr"></span> <span class="text-info" id="vbk"></span>
									</div>
									
								</div>
								<div id="formerros" class="" style="display:none;">
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
								<button class="btn btn-sm btn-info" type="button" id="bt_cad_eve"><i class="fa fa-magic"></i> Adicionar</button>
							</div>
						</form>
					</div><!-- ./box -->
					
				</div><!-- ./col -->
				<div class="col-xs-12">
					<div class="box box-success hide" id="firms">
						<div class="box-header with-border">
							<h3 class="box-title">Empresas Encontradas</h3>
						</div><!-- /.box-header -->
						<div class="box-body">
							 <table class="table table-striped">
								<tr>
									<th><input type="checkbox"/>Selecionar</th>
									<th>Empresa</th>
									<th>Nome Fantasia</th>
									<th>Contato</th>
								</tr>
								<?php
									$sql = "SELECT cont.con_contato, empr.emp_razao, empr.emp_nome FROM contatos
											JOIN empresas ON con_cli_cnpj = emp_cnpj
											WHERE con_tipo='fa fa-envelope'";
									$rs->FreeSql($sql);
									while($rs->GeraDados()){
										?>
										<tr>
											<td><input type="checkbox" id="eve_mail[]" name="eve_mail[]" value="<?=$rs->fld("con_contato");?>"/></td>
											<td><?=$rs->fld("emp_razao");?></td>
											<td><?=$rs->fld("emp_nome");?></td>
											<td><?=$rs->fld("con_contato");?></td>
										</tr>
										<?php
									}
								?>
							<tr><td colspan="4"><button type="button" class="btm btn-success"><i class="fa fa-envelope"></i> Enviar E-Mail</button></td></tr>
							</table>
						</div>
					</div><!-- ./box -->
				</div><!-- ./col -->
			</div><!-- ./row -->
		</section>
	</div>

	<? 
		require_once("../config/footer.php");
		require_once("../config/sidebar.php");
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
    <script src="<?=$hosted;?>/sistema/assets/js/controle.js"></script>
    <script src="<?=$hosted;?>/sistema/assets/js/action_eventos.js"></script>
	<!-- Validation -->
    <!--<script src="<?=$hosted;?>/js/jquery-validation/dist/jquery.validate.min.js"></script>-->
	<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
	
</body>
</html>
			
					
						