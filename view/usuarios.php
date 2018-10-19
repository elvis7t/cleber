<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start("portal");
$sec = "Solics";
require_once("../config/main.php");
require_once("../config/valida.php");
require_once("../config/mnutop.php");
require_once("../config/menu.php");
require_once("../config/modals.php");
require_once("../class/class.functions.php");
require_once("../class/class.permissoes.php");

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
          <!-- Info boxes -->
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Cadastro de Usuarios</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form id="cadUsu" role="form"> 
                  <div class="box-body">
                    <div class="row"> 
						<div class="form-group col-md-4">
							<label for="usu_nome">Nome do Usuario</label>
							<input type="text" class="form-control" id="usu_nome" name="usu_nome"  placeholder="Nome Completo">
						</div>

						<div class="form-group col-xs-2">
                            <label for="emp_cnpj">CPF</label>
                            <input class="form-control cpf" name="usu_cpf" id="usu_cpf" placeholder="CPF">
                        </div>
					 
						<div class="form-group col-md-6">
							<label for="usu_email">E-mail</label>
							<input type="text" class="form-control" id="usu_email" name="usu_email"  placeholder="E-mail de Usuario">
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-3">
							<label for="usu_senha">Senha</label>
							<input type="password" class="form-control" id="usu_senha" name="usu_senha"  placeholder="Senha de Usuario">
						</div>
						<div class="form-group col-md-3">
							<label for="usu_csenha">Confirme Senha</label>
							<input type="password" class="form-control" id="usu_csenha" name="usu_csenha"  placeholder="Confirme senha">
						</div>
						<div class="form-group col-md-3">
							<label for="sel_class">Selecione a Classe</label>
							<select class="form-control select2" id="sel_class" name="sel_class">
								<option value="">Selecione:</option>
								<option value="1">Administrador</option>
								<option value="2">Diretoria</option>
								<option value="3">Gerencia</option>
								<option value="4">Coordena&ccedil;&atilde;o</option>
								<option value="5">Analista</option>
								<option value="6">Assistente</option>
								<option value="7">Auxiliar</option>
								<option value="8">Cliente</option>
							</select>
						</div>
						<div class="form-group col-md-3">
							<label for="sel_depto">Selecione o Departamento</label>
							<select class="form-control select2" id="sel_depto" name="sel_depto">
								<option value="">Selecione:</option>
								<?php
									$whr="dep_id <> 0";
									$rs->Seleciona("*","departamentos",$whr);
									while($rs->GeraDados()):	
									?>
										<option value="<?=$rs->fld("dep_id");?>"><?=$rs->fld("dep_nome");?></option>
									<?php
									endwhile;
									?>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-2">
							<label for="sel_lider">Usu&aacute;rio Lider</label>
							<select class="form-control select2" id="sel_lider" name="sel_lider">
								<option value="">Selecione:</option>
								<option value="Y">Sim</option>
								<option SELECTED value="N">Não</option>
							</select>
						</div>
						<div class="form-group col-md-2">
							<label for="usu_ramal">Ramal</label>
							<input type="text" class="form-control" id="usu_ramal" name="usu_ramal"  placeholder="Ramal de Usuario">
						</div> 
						<div class="form-group col-md-4">
							<label for="usu_pausa">Pausa</label>
							 	<div class="radio">
			                        <label>
			                          <input type="radio" name="usu_pausa" id="usu_pausa" value="1,4">
			                          1&deg; pausa 
			                        </label>
			                        <label>
			                          <input type="radio" name="usu_pausa" id="usu_pausa" value="2,5">
			                          2&deg; pausa 
			                        </label>
			                        <label>
			                          <input type="radio" name="usu_pausa" id="usu_pausa" value="3,6">
			                          3&deg; pausa 
			                        </label>
			                     </div>
						</div> 

					</div>
						<div id="consulta"></div>

						<div id="formerrosUsu" class="clearfix" style="display:none;">
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
						<button id="btn_cadUsu" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Salvar</button>
					</div>
					<div id="mens"></div>
                </form>
              </div><!-- /.box --> 
			  
			  
            </div>
          </div>
        </section><!-- /.content -->
	</div>
	<?php
		require_once("../config/footer.php");
	?>
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
<script src="<?=$hosted;?>/sistema/js/action_triang.js"></script>
<script src="<?=$hosted;?>/sistema/js/controle.js"></script>
<script src="<?=$hosted;?>/sistema/js/jquery.cookie.js"></script>
<script src="<?=$hosted;?>/sistema/js/functions.js"></script>


<!-- SELECT2 TO FORMS
-->

<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
<!-- Validation -->
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script>
	/*------------------------|INICIA TOOLTIPS E POPOVERS|---------------------------------------*/
	$(document).ready(function () {
		
		$("#bt_detalhe").click(function(){
			$("#emp_detalhe").modal({
				keyboard:true
			});
		});

		$(".select2").select2({
			tags: true
			
		});

		
	});
</script>

</body>
</html>	