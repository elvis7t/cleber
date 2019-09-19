<?php
/*----------------------------------------------------------------------\
|	index.php															|
|	Armazena informações da página inicial								|
\----------------------------------------------------------------------*/
$sessao = "Tickets";
require_once("../config/menu.php");
require_once("../config/valida.php");
require_once("../config/cfg_servicos.php");
?>
<div class="container-fluid">
			<!-- Page Heading -->
			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">
						Tickets
						<small>Faça sua solicitação</small>
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
								<div class="alert alert-info">
									Abaixo, alguns serviços oferecidos pela TCWeb. Abrindo um Ticket, realizaremos sua solicitação...
								</div>
								<?
								foreach($servs as $ind => $val){?>
									<div class="col-lg-3">
									 <div class="panel panel-primary">
										<div class="panel-heading">
											<div class="row">
												<div class="col-xs-2">
													<i class="<?=$val['icone'];?> fa-3x"></i>
												</div>
												<div class="col-xs-9 text-right">
													<div class=""><h4><?=$val['Desc'];?></h4></div>
													<div>Valor: R$<?=$val['Valor'];?></div>
												</div>
											</div>
										</div>
										<a href="javascript:form<?=$ind;?>.submit();">
										<form id="form<?=$ind;?>" action="ticket_abertura.php" method="POST" class="hide">
											<input type="hidden" name="service" value="<?=$ind;?>">
										</form>
											<div class="panel-footer">
												<span class="pull-left">Abrir Ticket</span>
												<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
												<div class="clearfix"></div>
											</div>
										</a>
									</div>
								</div>
								<?}
								?>
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
	