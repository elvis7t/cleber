								<div class="box box-primary">
									<div class="box-body">
										<div id="tabela_ctt">
											<?php require_once("contatos.php"); ?>
										</div>
										<div class="box box-default">
											<div class="box-body">
												<form role="form" id="cad_dados">
													
														<div class="input-group col-md-8">
															<div class="input-group-btn">
																<button type="button" class="btn btn-default btn-sm dropdown-toggle" id="add1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-envelope" id="tpcon"></i> <span class="caret"></span></button>
																<ul class="dropdown-menu">
																  <li><a href="#" data-type="mail"><i class="fa fa-envelope"></i> E-Mail</a></li>
																  <li><a href="#" data-type="site"><i class="fa fa-file-code-o"></i> Site:</a></li>
																  <li role="separator" class="divider"></li>
																  <li><a href="#" data-type="tel"><i class="fa fa-phone"></i> Telefone</a></li>
																  <li><a href="#" data-type="cel"><i class="fa fa-mobile"></i> Celular</a></li>
																  <li><a href="#" data-type="wts"><i class="fa fa-whatsapp"></i> WhatsApp</a></li>
																</ul>
															</div><!-- /btn-group -->
															<input type="text" id="con_tipo" name="con_tipo" class="form-control input-sm" aria-labeledby="add1"/>
															<input type="hidden" name="clicod" id="clicod" value="<?=$_GET['clicod'];?>" />
														</div>
														<br>
														<div id="formerros_dados" class="" style="display:none;">
															<div class="callout callout-danger">
																<h4>Erros no preenchimento do formul&aacute;rio.</h4>
																<p>Verifique os erros no preenchimento acima:</p>
																<ol>
																	<!-- Erros são colocados aqui pelo validade -->
																</ol>
															</div>
														</div>
														<br>	
														<button type="button" id="bt_add_cont" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Adicionar...</button>
														
													
												</form>
											</div><!-- /.box-body -->
										</div><!-- /.box -->
									</div>
								</div>