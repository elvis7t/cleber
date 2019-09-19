<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start();
$sec = "Mens";
$pag = "assin.php";
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
							<h3 class="box-title">Assinatura</h3>
						</div><!-- /.box-header -->
						<!-- form start -->
						<form role="form" id="cad_sol">
							<div class="box-body">
								<!-- radio Clientes -->
								<div id="clientes" class="row">
									<div class="form-group col-xs-3">
										<label for="emp_cnpj">Departamento: </label><br>
										<select class="select2 input-sm" name="sel" id="sel" style="width:100%;">
											<option value="">Selecione:</option>
											<?php
											$rs = new recordset();
												$sql="SELECT * FROM departamentos";
												$rs->FreeSql($sql);
												while($rs->GeraDados()){?>
													<option <?=($rs->fld("dep_id")==$_SESSION['dep']?"SELECTED":"");?> value="<?=$rs->fld("dep_nome");?>"><?=$rs->fld("dep_nome");?></option>
												<?php
												}
											?>
										</select>
									</div>	
								
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
							<div id="slc" style="background-color:#ffffff;" class="box-body">
								<?php
								/*if($_SESSION['dep']==3):?>	
								<p class="text-danger">
								<strong>*Aviso Importante*</strong><br>
									<cite>
									A Secretaria da Fazenda do Estado de S&atilde;o Paulo informa que a partir de janeiro de 2017 os aplicativos gratuitos para emiss&atilde;o da Nota Fiscal Eletr&ocirc;nica ( NF-e ) e do Conhecimento de Transporte Eletr&ocirc;nico ( CT-e ) ser&atilde;o descontinuados.
									<br>	
 									A partir de 1&deg; de janeiro de 2017 n&atilde;o ser&aacute; mais poss&iacute;vel fazer o download dos emissores.
									</cite>
								endif;
								</p>*/
								?>
								<table>
								<tr>
									<td width="150">
										<img align="top" width="150" src="<?=$hosted;?>/images/tri_Origem_FULL_H.png" align="left" class="img-responsive" />
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
									
									<td width="150">
										<img src="<?=$hosted;?>/images/SELO.jpg" class="img-responsive" width="150" />
									</td>
								</tr>
							</tr>
						</table>
								<p><i class="fa fa-print"></i> ANTES DE IMPRIMIR pense em sua responsabilidade e compromisso com o MEIO AMBIENTE</p>
							<!--	<p>
								A Organiza&ccedil;&atilde;o Cont&aacute;bil Tri&acirc;ngulo informa que n&atilde;o haver&aacute; expediente entre os dias <strong>22.12.2016</strong> e <strong>01.01.2017</strong><br>
								Retornaremos nossas atividades no dia <strong>02.01.2017</strong> em hor&aacute;rio normal, a partir das 7:30hrs.<br>
								<span class="text-danger">
									  <i class="fa fa-tree text-green"></i>
									  <strong> DESEJAMOS AOS NOSSOS CLIENTES E AMIGOS UM
								       FELIZ NATAL E UM ANO NOVO REPLETO DE REALIZA&Ccedil;&Otilde;ES </strong>
								      <i class="fa fa-tree text-green"></i>
								</span>
								</p>-->
								
								
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

	<script type="text/javascript" src="<?=$hosted;?>/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script type="text/javascript" src="<?=$hosted;?>/assets/bootstrap/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script type="text/javascript" src="<?=$hosted;?>/assets/plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script type="text/javascript" src="<?=$hosted;?>/assets/dist/js/app.min.js"></script>
   <!-- Slimscroll -->
    <script type="text/javascript" src="<?=$hosted;?>/assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script type="text/javascript" src="<?=$hosted;?>/assets/js/maskinput.js"></script>
    <script type="text/javascript" src="<?=$hosted;?>/assets/js/jmask.js"></script>
    <script type="text/javascript" src="<?=$hosted;?>/js/controle.js"></script>
 	<script type="text/javascript" src="<?=$hosted;?>/js/jquery.cookie.js"></script>
    <script type="text/javascript" src="<?=$hosted;?>/js/action_triang.js"></script>
    <script type="text/javascript" src="<?=$hosted;?>/js/html2canvas.js"></script>
    <script type="text/javascript" src="<?=$hosted;?>/js/html2canvas.svg.js"></script>
	<!-- SELECT2 TO FORMS
	-->
	<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
	<!-- Validation -->
    <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
	<script type="text/javascript">
		$(".select2").select2({
			tags: true
		});
			
		
		$("#bt_View").on("click",function() {
		$("#lblNome").html(" "+$("#emp_nome").val());
		$("#lblCargo").html(" "+$("#emp_carg").val());
		$("#dpt").html(" "+$("#sel").val());
		$("#skp").html(" "+$("#emp_skp").val());
		
		    var c = $('#slc');
            html2canvas(c, {
                onrendered: function (canvas) {
                    theCanvas = canvas;
                    var image = new Image();
                    image.id = "pic"
                    image.src = theCanvas.toDataURL("image/png",1.0);
                    image.height = c.clientHeight
                    image.width = c.clientWidth
                    //window.open(image.src, 'Chart')
                }
            });


		});
	</script> 

</body>
</html>	