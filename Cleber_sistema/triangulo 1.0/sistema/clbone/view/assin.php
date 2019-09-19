<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start();
$sec = "Assin";
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
				Solicita&ccedil;&atilde;o de Contato Externo
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li>Solicita&ccedil;&atilde;o</li>
				<li class="active">Contato Externo</li>
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
							<h3 class="box-title">Solicitar Contato</h3>
						</div><!-- /.box-header -->
						<!-- form start -->
						<form role="form" id="cad_sol">
							<div class="box-body">
								<!-- radio Clientes -->
								<div id="clientes" class="row">
									<div class="form-group col-xs-6">
										<label for="emp_cnpj">Departamento: </label>
										<select class="select2 input-sm" name="sel" id="sel">
											<option value="">Selecione:</option>
											<option value="Escrita Fiscal">Escrita Fiscal</option>
											<option value="Departamento Pessoal">Departamento Pessoal</option>
											<option value="Departamento Cont&aacute;bil">Departamento Cont&aacute;bil</option>
											<option value="Departamento Legal">Departamento Legal</option>
											<option value="Diretoria">Diretoria</option>
											<option value="Financeiro">Financeiro</option>
											<option value="Recep&ccedil;&atilde;o">Recep&ccedil;&atilde;o</option>
											<option value="Inform&aacute;tica (T.I.)">Inform&aacute;tica (T.I.)</option>
											<option value="Gest&atilde;o de Processos">Gest&atilde;o de Processos</option>
										</select>
									</div>	
								</div>
								<!-- radio Avulso -->
								<div id="avulsos" class="row">
									<div class="form-group col-xs-3">
										<label for="emp_cnpj">Nome: </label>
										<input type="text" class="form-control input-sm" name="emp_nome" id="emp_nome" value="<?=$_SESSION['nome_usu'];?>"/>
									</div>
									
									<div class="form-group col-xs-3">
										<label for="emp_cnpj">Cargo: </label>
										<input type="text" class="form-control input-sm" name="emp_carg" id="emp_carg"/>
									</div>
									<div class="form-group col-xs-3">
										<label for="emp_cnpj">Skype: </label>
										<input type="text" class="form-control input-sm" name="emp_skp" id="emp_skp" value="<?=$_SESSION['usuario'];?>"/>
									</div>
									
								</div>
							<div id="consulta"></div>
							
							
							<div class="box-footer">
								<button class="btn btn-sm btn-success" type="button" id="bt_View"><i class="fa fa-photo"></i> Visualizar</button>
								<span id="spload" style="display:none;"><i id="load"></i></span>
							</div>
						</form>
					</div><!-- ./box -->
					
				</div><!-- ./row -->
				
				<div class="row">
					<div class="col-xs-9">
						<div class="box box-success" id="firms">
							<div class="box-header with-border">
								<h3 class="box-title">Visualizar</h3>
							</div><!-- /.box-header -->
							<div id="slc" style="background-color:#fff;" class="box-body">
								<table>
								<tr>
									<td width="130">
										<img align="top" src="<?=$hosted;?>/images/tri_Origem_Azul.png" align="left" class="img-responsive" />
									</td>
									<td>
										<address>
											<strong><span class="text-info" id="lblNome" style="font-size:12pt;"></span></strong><br>
											<i class="fa fa-check-square-o"></i> <span id="lblCargo"></span> | <span id="dpt"></span><br>
											<span><i class="fa fa-map-marker"></i> Rua Luiz Faccini, 363 - Centro - Guarulhos - SP</span><br>
											<span><i class="fa fa-skype"></i><span id="skp"> </span> | <span><i class="fa fa-phone"></i> (11)2087-4080</span><br><br>
											<span class="text-info"><i class="fa fa-internet-explorer"></i> www.triangulocontabil.com.br</span><br>
										</address>
									</td>
									<td>
										<img src="<?=$hosted;?>/images/SELO.png" width="200" class="img-responsive" />
									</td>
								</tr>
							</tr>
						</table>
								ANTES DE IMPRIMIR pense em sua responsabilidade e compromisso com o MEIO AMBIENTE	
								
							</div>
						</div><!-- ./box -->
					</div><!-- ./col -->
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
    <script src="<?=$hosted;?>/sistema/assets/js/jmask.js"></script>
     <script src="<?=$hosted;?>/triangulo/js/controle.js"></script>
 	<script src="<?=$hosted;?>/triangulo/js/jquery.cookie.js"></script>
    <script src="<?=$hosted;?>/triangulo/js/action_triang.js"></script>
    <script src="<?=$hosted;?>/triangulo/js/html2canvas.js"></script>
    <script src="<?=$hosted;?>/triangulo/js/html2canvas.svg.js"></script>
	<!-- SELECT2 TO FORMS
	-->
	<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
	<!-- Validation -->
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
	<script>
		$(".select2").select2({
			tags: true
		});
			
		
	</script>
	<script type="text/javascript">
		$("#bt_View").on("click",function() {
		$("#lblNome").html(" "+$("#emp_nome").val());
		$("#lblCargo").html(" "+$("#emp_carg").val());
		$("#dpt").html(" "+$("#sel").val());
		$("#skp").html(" "+$("#emp_skp").val());
		var target = $('#slc');
		html2canvas(target, {
			onrendered: function(canvas) {
				var img = canvas.toDataURL("image/jpeg");
				window.open(img);
			}
			});
		});
</script> 

</body>
</html>	