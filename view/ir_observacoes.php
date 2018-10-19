								<div class="box box-primary">
									<form id="alt_obs" role="form">
										
										<!-- form start -->
										<div class="box-body">
											<div class="row">
												<div class="form-group col-md-5">
													<div class="form-group col-md-12">
														<label for="emp_obs">Observa&ccedil;&otilde;es:</label><br>
														<textarea class="form-control" id="emp_obs" placeholder="emp_obs"><?=$observacao;?></textarea>
													</div>

													<div class="form-group col-md-12">
														<label for="emp_obs">Arquivos:</label><br>
														<table class="table table-striped">
															<tr>
																<th>#Cod</th>
																<th>Arquivo</th>
																<th>Visuzalizar</th>
															</tr>

																<?php
																$sql ="SELECT * FROM documentos WHERE doc_finalidade = 'IRP' AND doc_cli_cnpj='".$_GET['cnpj']."'";
																$rs->FreeSql($sql);
																if($rs->linhas==0){?>
																	<td colspan=3>Nenmhum arquivo...</td>
																<?php }
																else{
																	while($rs->GeraDados()){?>
																		<tr>
																			<td><?=$rs->fld("doc_cod");?></td>
																			<td><?=$rs->fld("doc_desc");?></td>
																			<td>
																				<a href="javascript:ver_docs('div_varq','<?=$rs->fld("doc_ender");?>')" class="btn btn-primary btn-sm">
																					<i class="fa fa-book"></i>
																				</a>
																			</td>
																		</tr>
																	<?php }
																}

															?>
														</table>
														
													</div>
												</div>
												<div class="form-group col-md-7">
													<div class="box box-success">
														<div id="file_pdf">
															<iframe id="div_varq" style="border:0; width:100%;height:700px;" src=""></iframe>
														</div>
													</div>
												</div>
											</div>
											<div id="consulta_OBS"></div>
											<div id="formerros_partic" class="clearfix" style="display:none;">
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
											<?php
							
											$con =$per->getPermissao("observacoes",$_SESSION['usu_cod']);
											//echo $con["A"];
											if($lin == 1){
												if($con["A"] == 1){ ?>
													<button type="button" id="dados_sal_Obs" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Atualizar </button>
												<?php }
											}
											else{
												if($con["I"] == 1){ ?>
													<button type="button" id="dados_sal_Obs" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Salvar </button>
												<?php }
											}
											?>

										</div>
									</form>
								</div>
			