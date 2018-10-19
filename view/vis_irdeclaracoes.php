								<div class="box box-primary">
									<div class="box-body">
										<!--IRRF-->
										<div>
											 <table class="table table-striped table-condensed">
											 	<thead>
													<tr>
														<th>#Id IRPF</th>
														<th>Tipo</th>
														<th>Periodo</th>
														<th>Valor Anterior</th>
														<th>Valor Atual</th>
														<th>Entrada</th>
														<th>Status</th>
														<th>&Uacute;lt. Altera&ccedil;&atilde;o</th>
														<th>A&ccedil;&otilde;es</th>
													</tr>
												</thead>
												<tbody>
													<!-- Conteúdo dinamico PHP-->
													<?php require_once("irrf_conCli.php"); ?>
												</tbody>
											</table>
										</div>
									</div>
									<div class="box-footer">
										<a href="novo_irrf.php?token=<?=$_SESSION['token'];?>&clicod=<?=$_GET['clicod'];?>" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Incluir</a>
									</div>
								</div>