<?php
/*----------------------------------------------------------------------\
|	index.php															|
|	Armazena informações da página inicial								|
\----------------------------------------------------------------------*/
$sessao = "Testes";
require_once("../config/menu.php");
require_once("../config/valida.php");
?>
<div class="container-fluid">
			<!-- Page Heading -->
			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">
						Testes
						<small>Por Liferrara<sup>TM</sup> - Gerenciamento</small>
					</h1>
					<ol class="breadcrumb">
						<li>
							<i class="fa fa-home"></i>  <a href="<?=$hosted;?>"><?=$hosted;?></a>
						</li>
						<li>
							<i class="fa fa-graduation-cap"></i> <a href="<?=$links['testes'];?>"><?=$sessao;?></a>
						</li>
						<li>
							<a href="<?=$links['ger_testes'];?>">Gerenciar Testes</a>
						</li>
						<li>
							Configurar testes
						</li>
						<li class="active">
							Configurar quest&otilde;es
						</li>
						
					</ol>
				</div>
			</div><!-- /.row -->
			<div class="row">
				<?
				$rs = new recordset;
				$percod = $_GET['percod'];
				$rs->Seleciona("*","Perguntas_testes","per_cod = ".$percod);
				$rs->GeraDados();
					if ($_SESSION['classe']=="admin"){?>
					<div class="panel panel-info">
						<div class="panel-heading"><h5>Nova Op&ccedil;&atilde;o: [<?=$rs->fld("per_desc");?>]</div>
						<div class="panel-body">
							<form id="form1" method="POST">
								<div class="input-group form-group col-lg-4">
									<span class="input-group-addon" id="addon0"><small>Op&ccedil;&atilde;o </small></span>
									<input type="text" class="form-control input-sm" name="opcDesc" id="opcDesc" placeholder="Op&ccedil;&atilde;o" aria-describedby="addon0">
									<input type="hidden" name="opcPerCod" id="opcPerCod" value="<?=$percod;?>">
								</div>
								<div class="input-group form-group col-lg-4">
									<span class="input-group-addon" id="addon0"><small>Pontua&ccedil;&atilde;o </small></span>
									<input type="text" class="form-control input-sm" name="opcPt" id="opcPt" placeholder="Quantos pontos vale essa op&ccedil;&atilde;o?" aria-describedby="addon0">
								</div>
								
								<div class="panel panel-default">
									<div id="pbody" class="panel-body">
									<?
										$rs->Seleciona("*","Opc_Perguntas","opc_per_cod = ".$percod);?>
										<div class="row" id="opcoes">
											<div class="col-lg-9 table-responsive">
												<table class="table table-hover table-stripe table-sm">
													<thead>
														<tr><th>Op&ccedil;&otilde;es</th><th>A&ccedil;&otilde;es</th>
													</thead>
													<tbody>
													<? while($rs->GeraDados()){?>
														<tr>
															<td><?=$rs->fld("opc_desc");?></td>
															<td><a href="<?=$links['cfg_quests'];?>?percod=<?=$per_cod;?>" class="btn btn-info btn-xs"><i class="fa fa-plus"></i> Inserir Op&ccedil;&otilde;es</a>
																<a href="<?=$links['cfg_quests'];?>?percod=<?=$per_cod;?>" class="btn btn-danger btn-xs"><i class="fa fa-remove"></i> Excluir</a></td>
														</tr>
													<?}?>											
													</tbody>
												</table>
											</div>
										</div>			
									</div>
								</div>
								<div class="input-group form-group col-lg-6">
									<button type="button" id="env_opc" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Gravar</button>
								</div>
								<div id="msn" class="hide"></div>
								<div id="loading" class="hide">
									<i class="fa fa-spinner fa-3x fa-spin"></i>
								</div>
								
							</form>
						</div>
						
					</div>
					
				<?}?>
				
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->

	</div><!-- /#page-wrapper -->

</div><!-- /#wrapper -->

<!-- jQuery -->
<script src="js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

</body>

</html>
	