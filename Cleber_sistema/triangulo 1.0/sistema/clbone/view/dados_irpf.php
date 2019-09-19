<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start();
$sec = "Solics";
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
				Hist&oacute;rico do Cliente
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li>IRPF</li>
				<li class="active">Hist&oacute;rico</li>
			</ol>
        </section>

        <!-- Main content -->
        <section class="content">
			<?php
				$rs_ir = new recordset();
				$fn = new functions();
				$sql = "SELECT * FROM irrf a
							JOIN codstatus b ON a.ir_status = b.st_codstatus
							JOIN empresas c ON a.ir_cli_id = c.emp_codigo
							LEFT JOIN irpf_recibo d ON a.ir_reciboId = d.irec_id
							
						WHERE irec_id = ".$_GET['irecid'];
				$rs_ir->FreeSql($sql);
				$rs_ir->GeraDados();
			?>
			 <div class="row">
				<div class="col-md-12">
				<!-- general form elements -->
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title">Dados do Recibo</h3>
						</div><!-- /.box-header -->
						<!-- form start -->
						<form role="form" id="cad_sol">
							<input type="hidden" id="emp_altera" value=0 />
							<div class="box-body">
								<!-- radio Clientes -->
								<div id="clientes" class="row">
									<div class="form-group col-xs-6">
										<label for="emp_cnpj">Cliente</label>
										<input type="text" class="form-control unput-sm" disabled value="<?=$rs_ir->fld("emp_codigo")." - ".$rs_ir->fld("emp_razao");?>">
									</div>	
								</div>
								<!-- radio Avulso -->
								<div id="avulsos" class="row">
									<div class="form-group col-xs-1">
										<label for="emp_cnpj"># Recibo</label>
										<input type="text" class="form-control input-sm" disabled value="<?=$rs_ir->fld("irec_id");?>"/>
									</div>
									<div class="form-group col-xs-1">
										<label for="emp_cnpj"># IRPF</label>
										<input type="text" class="form-control tel input-sm" disabled value="<?=$rs_ir->fld("ir_Id");?>"/>
									</div>
									<div class="form-group col-xs-2">
										<label for="emp_cnpj">Primeiro Atendimento</label>
										<input type="text" class="form-control input-sm" disabled value="<?=$fn->data_hbr($rs_ir->fld("ir_dataent"));?>"/>
									</div>
									<div class="form-group col-xs-2">
										<label for="emp_cnpj">&Uacute;ltimo Atendimento</label>
										<input type="text" class="form-control input-sm" disabled value="<?=($rs_ir->fld("ir_dataalt") <> NULL?$fn->data_hbr($rs_ir->fld("ir_dataalt")):"");?>"/>
									</div>
									<div class="form-group col-xs-2">
										<label for="emp_cnpj">Tempo de Processo</label>
										<input type="text" class="form-control input-sm" disabled value="<?=($rs_ir->fld("ir_dataalt") <> NULL?$fn->calc_dh($rs_ir->fld("ir_dataent"), $rs_ir->fld("ir_dataalt")):"");?>"/>
									</div>
									<div class="form-group col-xs-2">
										<label for="emp_cnpj">Status</label>
										<input type="text" class="form-control input-sm" disabled value="<?=$rs_ir->fld("st_desc") ;?>"/>
									</div>
								</div>
								<div class="row">
									<div class="form-group col-xs-2">
										<label for="emp_cnpj">Valor</label>
										<input type="text" class="form-control input-sm" disabled value="R$<?=number_format($rs_ir->fld("ir_valor"),2,",",".");?>"/>
									</div>
									<div class="form-group col-xs-2">
										<label for="emp_cnpj">Data Pgto</label>
										<input type="text" class="form-control input-sm" disabled value="<?=($rs_ir->fld("irec_pagodata") <> NULL?$fn->data_hbr($rs_ir->fld("irec_pagodata")):"");?>"/>
									</div>
									<div class="form-group col-xs-2">
										<label for="emp_cnpj">Forma Pgto</label>
										<input type="text" class="form-control input-sm" disabled value="<?=$rs_ir->fld("irec_forma");?>"/>
									</div>
									<div class="form-group col-xs-4 <?=($rs_ir->fld("irec_forma")<>"Cheque" ? "hide":"");?>">
										<label for="emp_cnpj">Complemento</label>
										<input type="text" class="form-control input-sm" disabled value="<?=$rs_ir->fld("irec_compl");?>"/>
									</div>

									<div class="form-group col-xs-2">
										<label for="emp_cnpj">Valor Pago</label>
										<input type="text" class="form-control input-sm" disabled value="R$<?=number_format($rs_ir->fld("irec_valor"),2,",",".");?>"/>
									</div>
									<div class="form-group col-xs-10">
										<label for="emp_cnpj">Observa&ccedil;&atilde;o <small>(ref. pagamento)</small></label>
										<textarea class="form-control input" disabled ><?=$rs_ir->fld("irec_obs");?></textarea>
									</div>


								</div>
							</div><!-- ./box -->
						</form>
					</div>
					<div class="row">
						<div class="col-xs-12">
							<div class="box box-success" id="irrf_cli_Oc">
								<div class="box-header with-border">
									<h3 class="box-title">Tr&acirc;mites j&aacute; realizados:</h3>
								</div><!-- /.box-header -->
								<div class="box-body">
									<!-- Conteúdo dinamico PHP-->
									<?php 
									$ir_id = $rs_ir->fld("ir_Id");
									require_once("irpf_conOcorr.php"); ?>
								</div>
							</div><!-- ./box -->
						</div><!-- ./col -->
					</div><!-- ./row -->
					
				
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
    <script src="<?=$hosted;?>/triangulo/js/controle.js"></script>
    <script src="<?=$hosted;?>/triangulo/js/action_triang.js"></script>
    <script src="<?=$hosted;?>/triangulo/js/jquery.cookie.js"></script>
    <script src="<?=$hosted;?>/triangulo/js/functions.js"></script>

	<!-- SELECT2 TO FORMS
	-->

	<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
	<!-- Validation -->
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

</body>
</html>	