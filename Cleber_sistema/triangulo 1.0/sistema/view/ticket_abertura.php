<?php
/*----------------------------------------------------------------------\
|	index.php															|
|	Armazena informações da página inicial								|
\----------------------------------------------------------------------*/
$sessao = "Ticket";
require_once("../config/menu.php");
require_once("../config/cfg_servicos.php");
require_once("../config/valida.php");

?>
<div class="container-fluid">
			<!-- Page Heading -->
			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">
						Perfil
						<small>do usu&aacute;rio</small>
					</h1>
					<ol class="breadcrumb">
						<li>
							<i class="fa fa-home"></i>  <a href="<?=$hosted;?>"><?=$hosted;?></a>
						</li>
						<li class="active">
							<i class="fa fa-wrench"></i> <?=$sessao;?>
						</li>
					</ol>
				</div>
			</div>
			<!-- /.row -->
			<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-primary">
							<div class="panel-heading"><h5>Solicitante: <?=$_SESSION['nome']." [".$_SESSION['usuario']."]";?></h5></div>
							<div class="panel-body">
							<div class="col-lg-12">
								<div class="row">
									<form class="form">
										<div class="form-group input-group">
											<span class="well well-sm"> 
												<label>Servi&ccedil;o escolhido:</label>
												<? echo $servs[$_POST['service']]['Desc'];?>
											</span>
										</div>
										<div class="form-inline">
											<div class="input-group col-lg-2">
												<span class="well well-sm">
													<label>Valor:</label>
													R$<? echo $servs[$_POST['service']]['Valor'];?>
												</span>
											</div>
											<div class="input-group col-lg-3">
												<span class="well well-sm">
													<label>Prazo:</label>
													<? echo $servs[$_POST['service']]['Prazo'];?>
												</span>
											</div>
										</div>
										<br>
										<div class="for-group input-group"">
											<span class="well well-sm">
												<label>Descri&ccedil;&atilde;o:</label>
												<? echo $servs[$_POST['service']]['Obs'];?>
											</span>
										</div>
										<br>
										<div class="form-group input-group">
											<span id="addon" class="input-group-addon"><label>Observa&ccedil;&otilde;es:</label></span>
											<textarea aria-describedby="addon" class="form-control input-sm"></textarea>
										</div>
										<div class="form-group">
											<a href="javascript:history.go(-1);" class="btn btn-danger"><i class="fa fa-arrow-circle-o-left"></i> Voltar</a>
											<button type="button" class="btn btn-success" id="btn_Open"><i class="fa fa-save"></i> Abrir Ticket</button>
										</div>
									</form>
                                </div>
									
								</div>
							</div>
							</div>
						</div><!-- /panel-->
					</div>
			
				
			</div>
			<!-- /.row -->
		</div>
		<!-- /.container-fluid -->

	</div>
	<!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

</body>

</html>
	