<?php
/*----------------------------------------------------------------------\
|	index.php															|
|	Armazena informações da página inicial								|
\----------------------------------------------------------------------*/
$sessao = "Testes";
require_once("../config/menu.php");
$cod = $_GET['teste'];
?>
<!-- fix para o erro de SQL. Passando um valor para hidden sem form com o código do teste. -->
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
						<li class="active">
							Configurar testes
						</li>
						
					</ol>
				</div>
			</div><!-- /.row -->
			<div class="row">
				<?
				$rs = new recordset;
				$rs->Seleciona("*","Testes_Pers","tes_cod = ".$cod);
				//echo $rs->sql;
				$rs->GeraDados();
				$n_teste = $rs->fld("tes_nome");
					if ($_SESSION['classe']=="admin"){?>
					<div class="panel panel-primary">
						<div class="panel-heading"><h5>Nova Quest&atilde;o: [<?=$n_teste;?>]</div>
						<div class="panel-body">
							<form id="form1" method="POST">
								<div class="input-group form-group col-lg-4">
									<span class="input-group-addon" id="addon0"><small>Pergunta: </small></span>
									<input type="text" class="form-control input-sm" name="perDesc" id="perDesc" placeholder="Nome do Teste:" aria-describedby="addon0">
									<input type="hidden" name="perTesCod" id="perTesCod" value="<?=$cod;?>">
								</div>
								
								<div class="panel panel-default">
									<div class="panel-body">
									<?
										$rs->Seleciona("*","Perguntas_testes","per_tes_cod = ".$cod);?>
										<div class="row" id="questoes">
											<div class="col-lg-9 table-responsive">
												<table class="table table-hover table-stripe table-sm">
													<thead>
														<tr><th>Perguntas</th><th>A&ccedil;&otilde;es</th>
													</thead>
													<tbody>
													<? while($rs->GeraDados()){
														$per_cod = $rs->fld("per_cod");
														?>
														<tr>
															<td><?=$rs->fld("per_desc");?></td>
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
									<button type="button" id="env_quest" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Gravar</button>
								</div>
								<div id="msn" class="hide"></div>
								<div id="loading" class="hide">
									<i class="fa fa-spinner fa-3x fa-spin"></i>
								</div>
								
							</form>
						</div>
						
					</div>
					<div class="panel panel-primary">
						<div class="panel-heading"><h5>Novo Resultado: [<?=$n_teste;?>]</div>
						<div class="panel-body">
							<form id="form2" method="POST">
								<div class="input-group form-group col-lg-2">
									<span class="input-group-addon" id="addon0"><small>Valor m&iacute;nimo: </small></span>
									<input type="text" class="form-control input-sm" name="resVMin" id="resVMin" placeholder="Valor m&iacute;nimo:" aria-describedby="addon0">
								</div>
								<div class="input-group form-group col-lg-2">
									<span class="input-group-addon" id="addon0"><small>Valor m&aacute;ximo: </small></span>
									<input type="text" class="form-control input-sm" name="resVMax" id="resVMax" placeholder="Valor m&aacute;ximo:" aria-describedby="addon0">
								</div>
								
								<div class="input-group form-group col-lg-4">
									<span class="input-group-addon" id="addon0"><small>Resultado: </small></span>
									<textarea class="form-control input-sm" name="resDesc" id="resDesc" placeholder="Resultado:" aria-describedby="addon0"></textarea>
									<input type="hidden" name="resTesCod" id="resTesCod" value="<?=$cod;?>">
								</div>
								
								<div class="panel panel-default">
									<div class="panel-body">
									<?
										$rs->Seleciona("*","Result_Testes","res_tes_cod = ".$cod);
										//echo $rs->sql;
										?>
										<div class="row" id="resCad">
											<div class="col-lg-9 table-responsive">
												<table class="table table-hover table-stripe table-sm">
													<thead>
														<tr><th>Resultados</th><th>Min</th><th>Max</th><th>A&ccedil;&otilde;es</th>
													</thead>
													<tbody>
													<? while($rs->GeraDados()){
														$res_cod = $rs->fld("res_cod");
														?>
														<tr>
															<td><?=substr($rs->fld("res_desc"),0,100)."...";?></td>
															<td><?=$rs->fld("res_valormin");?></td>
															<td><?=$rs->fld("res_valomax");?></td>
															<td><a href="<?=$links['cfg_quests'];?>?percod=<?=$res_cod;?>" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Alterar</a>
																<a href="<?=$links['cfg_quests'];?>?percod=<?=$res_cod;?>" class="btn btn-danger btn-xs"><i class="fa fa-remove"></i> Excluir</a></td>
														</tr>
													<?}?>											
													</tbody>
												</table>
											</div>
										</div>			
									</div>
								</div>
								<div class="input-group form-group col-lg-6">
									<button type="button" id="env_resul" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Gravar</button>
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
	