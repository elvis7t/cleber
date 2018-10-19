<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start("portal");
$sec = "IRRF";
$pag = "irrf.php";
require_once("../config/main.php");
require_once("../config/valida.php");
require_once("../config/mnutop.php");
require_once("../config/menu.php");
require_once("../config/modals.php");
require_once("../class/class.functions.php");
require_once("../class/class.permissoes.php");

$per = new permissoes();
$con = $per->getPermissao($pag, $_SESSION['usu_cod']);

if($con['C']<>1){
	header("location:403.php?token=".$_SESSION['token']);
}

?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
		<!-- Content Header (Page header) -->
        <section class="content-header">
			<h1>
				Gerenciamento
				<small>Cadastro e Consulta de Clientes</small>
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
				<div class="col-md-12">
				<!-- general form elements -->
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title">Clientes</h3>
						</div><!-- /.box-header -->
						<!-- form start -->
						<form role="form" id="cad_emp">
							<div class="box-body">
								<div class="row">
									<div class="form-group col-xs-4">
										<label for="emp_cnpj">CPF:</label>
										<input class="form-control cpf" id="emp_cnpj" name="emp_cnpj" placeholder="CPF">
									</div>
									<div class="form-group col-xs-1">
									<b class="text-blue middle"><br>-OU-</b>
									</div>
									<div class="form-group col-xs-7">
										<label for="emp_nfts">Nome :</label>
										<input class="form-control text-uppercase" id="emp_nfts" name="emp_nfts" placeholder="Nome">
									</div>
									
									<div class="form-group col-xs-12" id="consulta">
									</div>	
								</div>
								<div class="row hide" id="cadastro">
									<div class="form-group col-xs-6">
										<label for="emp_rzs">Nome do Cliente:</label>
										<input class="form-control text-uppercase" id="emp_rzs" name="emp_rzs" placeholder="Nome Completo">
									</div>
									
									<div class="form-group col-xs-3">
										<label for="cep">CEP</label>
										<input class="form-control cep" id="cep" name="cep" placeholder="CEP">
									</div>
									<div class="form-group col-xs-5">
										<label for="log">Logradouro</label>
										<input class="form-control text-uppercase" id="log" name="log" placeholder="Logradouro">
									</div>
									<div class="form-group col-xs-2">
										<label for="num">N&uacute;mero</label>
										<input class="form-control" id="num" name="num" placeholder="Num.:">
									</div>
									<div class="form-group col-xs-2">
										<label for="compl">Complemento</label>
										<input class="form-control text-uppercase" id="compl" name="compl" placeholder="Compl.:">
									</div>
									<div class="form-group col-xs-5">
										<label for="bai">Bairro</label>
										<input class="form-control" id="bai" name="bai" placeholder="Bairro">
									</div>
									<div class="form-group col-xs-5">
										<label for="cid">Cidade</label>
										<input class="form-control text-uppercase" id="cid" name="cid" placeholder="Cidade">
									</div>
									<div class="form-group col-xs-2">
										<label for="uf">UF</label>
										<input class="form-control text-uppercase" id="uf" name="uf" placeholder="UF">
									</div>
									
								</div>
								<div id="formerros3" class="" style="display:none;">
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
								<button class="btn btn-sm btn-primary" type="button" id="bt_pes_emp"><i class="fa fa-search"></i> Pesquisar</button>
								<button class="btn btn-sm btn-info hide" type="button" id="bt_cad_emp"><i class="fa fa-magic"></i> Adicionar</button>
								<button class="btn btn-sm btn-warning hide" type="button" id="bt_nova_pes"><i class="fa fa-search-plus"></i> Nova Pesquisa</button>
								
								
							</div>
						</form>
					</div><!-- ./box -->
					
				</div><!-- ./col -->
				<div class="col-xs-12">
					<div class="box box-success hide" id="firms">
						<div class="box-header with-border">
							<h3 class="box-title">Clientes Encontrados:</h3>
						</div><!-- /.box-header -->
						<div class="box-body">
							 <table class="table table-striped">
								<tr>
									<th>Doc.</th>
									<th>Nome</th>
									<th>A&ccedil;&otilde;es</th>
								</tr>
							</table>
						</div>
					</div><!-- ./box -->
				</div><!-- ./col -->
			</div><!-- ./row -->
		</section>
	</div>

	<?php 
		require_once("../config/footer.php");
		//require_once("../config/sidebar.php");
	?></div><!-- ./wrapper -->

	<script src="<?=$hosted;?>/sistema/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?=$hosted;?>/sistema/assets/bootstrap/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="<?=$hosted;?>/sistema/assets/plugins/fastclick/fastclick.min.js"></script>
	
    <!-- AdminLTE App -->
    <script src="<?=$hosted;?>/sistema/assets/dist/js/app.min.js"></script>
	<script src="<?=$hosted;?>/sistema/assets/dist/js/demo.js"></script>
  
   <!-- Slimscroll -->
    <script src="<?=$hosted;?>/sistema/assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="<?=$hosted;?>/sistema/assets/js/maskinput.js"></script>
    <script src="<?=$hosted;?>/sistema/assets/js/jmask.js"></script>
    <script src="<?=$hosted;?>/sistema/js/controle.js"></script>
    <script src="<?=$hosted;?>/sistema/js/action_empresas.js"></script>
    <script src="<?=$hosted;?>/sistema/js/functions.js"></script>
	<!-- Validation -->
    <!--<script src="<?=$hosted;?>/js/jquery-validation/dist/jquery.validate.min.js"></script>-->
	<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
</body>
</html>
			
					
						