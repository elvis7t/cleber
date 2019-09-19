								<div class="box box-primary <?=($_GET['clicod']==0?'hide':'');?>">
									<div class="box-header with-border">
										<h3 class="box-title">Dados do Cliente </h3>
										
									</div><!-- /.box-header -->
									<?php
									if(!($_GET['clicod']==0)){
										$whr = (isset($_GET['clicod']) ? "cod =".$_GET['clicod'] : "cnpj ='".$_GET['cnpj']."'");
										
										$rs->Seleciona("*","tri_clientes",$whr);
										$rs->GeraDados();
										$rom = ($rs->linhas==0 ? "" : "readonly");
									}
									?>
									<!-- form start -->
									<form id="cad_clientes" role="form" >
									<div class="box-body">
										<div class="row">
											<div class="form-group col-md-1">
												<label for="emp_cnpj">#</label>
												<input class="form-control input-sm" <?=$rom;?> id="cli_cod" name="cli_cod" placeholder="C&oacute;digo" value="<?=$rs->fld("cod");?>">
												<input type="hidden" class="form-control" id="token" name="token" value="<?=$_SESSION['token'];?>">
											</div>
											<div class="form-group col-md-3">
												<label for="emp_cnpj">CNPJ</label>
												<input class="form-control input-sm cnpj" <?=$rom;?> id="cli_cnpj" name="cli_cnpj" placeholder="CNPJ" value="<?=$rs->fld("cnpj");?>">
											</div>
											<div class="form-group col-md-8">
												<label for="emp_rzs">Nome:</label>
												<input class="form-control input-sm" id="cli_nome" name="cli_nome" placeholder="Nome da Empresa" value="<?=$rs->fld("empresa");?>">
											</div>
											
										</div>
										<div class="row">
											<div class="form-group col-md-2">
												<label for="emp_rzs">Apelido:</label>
												<input class="form-control input-sm" id="cli_apelido" name="cli_apelido" placeholder="Apelido" value="<?=$rs->fld("apelido");?>">
											</div>
											<div class="form-group col-md-2">
												<label for="emp_cep">Respons&aacute;vel:</label>
												<input class="form-control input-sm" id="cli_resp" name="cli_resp" placeholder="Responsavel" value="<?=$rs->fld("responsavel");?>">
											</div>

											<div class="form-group col-md-2">
												<label for="emp_cep">Regi&atilde;o:</label>
												<input class="form-control input-sm" id="cli_reg" name="cli_reg" placeholder="Regiao" value="<?=$rs->fld("regiao");?>">
											</div>
											<div class="form-group col-md-3">
												<label for="emp_tipo">Tipo:</label>
												<select class="form-control input-sm" name="emp_tipo" id="emp_tipo" style="width:100%;">
													<option value="0">Sem Especificar</option>
													<?php
														$whr= "tipemp_Id<>0";
														$rs2->Seleciona("*","tipos_empresas",$whr);
														while($rs2->GeraDados()):	
														?>
															<option <?=($rs2->fld("tipemp_cod")==$rs->fld("tipo_emp")?"SELECTED":"");?> value="<?=$rs2->fld("tipemp_cod");?>"><?=$rs2->fld("tipemp_desc");?></option>
														<?php
														endwhile;
													?>
												</select>
											</div>
											<div class="form-group col-md-3">
												<label for="emp_funcs">Funcion&aacute;rios:</label>
												<select class="form-control input-sm" name="emp_funcs" id="emp_funcs" style="width:100%;">
													<option value="">Selecione:</option>
													<?php
													if(!($_GET['clicod']<=1)){?>
													<option SELECTED value="<?=(empty($rs->fld("num_emp"))?9:$rs->fld("num_emp"));?>"><?=$rs2->pegar("port_func","porte_empresa","port_id=".$rs->fld("num_emp"));?></option>
													<?php
													}
													?>
												</select>
											</div>
											
											
										</div>
										<div class="row">
											
											<div class="form-group col-md-2">
												<label for="emp_log">Telefone:</label>
												<input class="form-control input-sm text-uppercase tel" id="cli_tel" name="cli_tel" placeholder="Telefone" value="<?=$rs->fld("telefone");?>">
											</div>
											<div class="form-group col-md-3">
												<label for="emp_cid">Email:</label>
												<input class="form-control input-sm text-lowercase" id="cli_mail" name="cli_mail" placeholder="E-Mail" value="<?=$rs->fld("email");?>">
											</div>
											<div class="form-group col-md-3">
												<label for="emp_uf">Site:</label>
												<input class="form-control input-sm text-lowercase" id="cli_site" name="cli_site" placeholder="Site" value="<?=$rs->fld("site");?>">
											</div>
											<div class="form-group col-md-2">
												<label for="emp_uf">Tributa&ccedil;&atilde;o:</label>
												<select name="cli_tribut" id="cli_tribut" class="form-control input-sm">
													<option value="">Selecione:</option>
													<option value="SN" <?=($rs->fld("tribut")=="SN"?"SELECTED":"");?>>Simples Nacional</option>
													<option value="LP" <?=($rs->fld("tribut")=="LP"?"SELECTED":"");?>>Lucro Presumido</option>
													<option value="LR" <?=($rs->fld("tribut")=="LR"?"SELECTED":"");?>>Lucro Real</option>
													<option value="AU" <?=($rs->fld("tribut")=="AU"?"SELECTED":"");?>>Autonomo</option>
													<option value="ME" <?=($rs->fld("tribut")=="ME"?"SELECTED":"");?>>MEI</option>
												</select>
											</div>
											<div class="form-group col-md-2">
												<label for="emp_uf">Status</label><br>
												<input type="radio" class="minimal" value=1 <?=($rs->fld("ativo")==1?"CHECKED":"");?> id="cli_ativo" name="cli_ativo"> Ativo<br>
												<input type="radio" class="minimal" value=0 <?=($rs->fld("ativo")==0?"CHECKED":"");?> id="cli_ativo" name="cli_ativo"> Inativo
											</div>
										</div>
										<div class="row">
											<div class="form-group col-md-12">
												 <div class="box box-info collapsed-box">
													<div class="box-header">
														<h3 class="box-title">Observa&ccedil;&otilde;es <small>Clique ao lado para expandir</small></h3>
													<!-- tools box -->
													<div class="pull-right box-tools">
														<button class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-plus"></i></button>
														<button class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
													</div><!-- /. tools -->
													</div><!-- /.box-header -->
														<div class="box-body pad">
														<textarea class="form-control" id="editor1" placeholder="editor1">
														<?=trim($rs->fld("obs"));?>
														</textarea>
													</div>
												</div><!-- /.box -->
												
											</div>
											

										</div>
										<div id="consulta"></div>
										<div id="formerros3" class="clearfix" style="display:none;">
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
										

										<button type="button" id="bt_altcli" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Salvar Dados </button>
										<input type="hidden" id="acao" value="<?=($rs->linhas == 0 ? "incluir_cli" :"alterar_cli");?>">
									</div>
									</form>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="box box-success" id="firms">
											<div class="box-header with-border">
												<h3 class="box-title">Pesquisa de Clientes</h3>
											</div><!-- /.box-header -->
											<div class="box-body">
												<div class="row">
													<div class="form-group col-md-4">
														<div class="input-group">
															<div class="input-group-addon">
																<i class="fa fa-user"></i>
															 </div>
																<select name="pes_empresas" id="pes_empresas" class="select2 form-control">
																	<option value="">Selecione...</option>
																	<?php
																		$rs2->Seleciona("*","tri_clientes","cod<>0","","cod ASC");
																		while($rs2->GeraDados()){ ?>
																			<option value="<?=$rs2->fld("cod");?>"><?=$rs2->fld("cod")." - ".$rs2->fld("apelido");?></option>
																	<?php
																		}
																	?>
																</select>
															<span class="input-group-btn">
																<button class="btn btn-success" id="bt_empsearch"><i class="fa fa-search"></i></button>
															</span>
														</div>
													</div>
													<div class="form-group col-md-8">
														<?php
														$con =$per->getPermissao($pag);
														if($con["I"] == 1){ ?>
															<a href="clientes.php?token=<?=$_SESSION['token'];?>&clicod=1" class="btn btn-sm btn-primary pull-right"><i class="fa fa-plus"></i> Add Cliente </a>
														<?php }
														?>
													</div>
													
												</div>
												
												<div id="slc">
													<?php //require_once('vis_clientes.php');?>
												</div>
											</div>
										</div><!-- ./box -->
									</div><!-- ./col -->
								</div>