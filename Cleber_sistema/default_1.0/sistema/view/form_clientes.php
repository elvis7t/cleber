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

											<div class="form-group col-md-2">
												<label for="emp_cnpj">CNPJ</label>
												<input class="form-control input-sm cnpj" <?=$rom;?> id="cli_cnpj" name="cli_cnpj" placeholder="CNPJ" value="<?=$rs->fld("cnpj");?>">
											</div>

											<div class="form-group col-md-5">
												<label for="emp_rzs">Nome:</label>
												<input class="form-control input-sm" id="cli_nome" name="cli_nome" placeholder="Nome da Empresa" value="<?=$rs->fld("empresa");?>">
											</div>

											<div class="form-group col-md-3">
												<label for="emp_rzs">Apelido:</label>
												<input class="form-control input-sm" id="cli_apelido" name="cli_apelido" placeholder="Apelido" value="<?=$rs->fld("apelido");?>">
											</div>
											
											<div class="form-group col-md-1">
												<label for="cli_cpr" title="C&eacute;dula do Produto Rural">CPR</label>
												<input class="form-control input-sm cpr" id="cli_cpr" name="cli_cpr" placeholder="CPR" value="<?=$rs->fld("cpr");?>">
											</div>


										</div>
										<div class="row">
											<div class="form-group col-md-2">
												<label for="cli_cnae" title="Cadastro nacional de Atividade Ecoonomica">CNAE</label>
												<input class="form-control input-sm cnae" id="cli_cnae" name="cli_cnae" placeholder="CNAE" value="<?=$rs->fld("cnae");?>">
											</div>

											<div class="form-group col-md-2">
												<label for="cli_cnae" title="NIRE - Registro Cartório">NIRE</label>
												<input class="form-control input-sm" id="cli_nire" name="cli_nire" placeholder="NIRE" value="<?=$rs->fld("emp_nire");?>">
											</div>

											<div class="form-group col-md-2">
												<label for="cli_ie">Inscri&ccedil;&atilde;o Municipal</label>
												<input class="form-control input-sm" id="cli_imun" name="cli_imun" placeholder="IM" value="<?=$rs->fld("emp_inscmun");?>">
											</div>
											
											<div class="form-group col-md-2">
												<label for="cli_ie">Inscri&ccedil;&atilde;o Estadual</label>
												<input class="form-control input-sm iest" id="cli_insc" name="cli_insc" placeholder="IE" value="<?=$rs->fld("inscr");?>">
											</div>


											<div class="form-group col-md-2">
												<label for="cli_ie">Data Jucesp</label>
												<input class="form-control input-sm data_br" id="cli_juce" name="cli_juce" placeholder="Data Jucesp" value="<?=$fn->data_br($rs->fld("emp_datajucesp"));?>">
											</div>

											<div class="form-group col-md-2">
												<label for="cli_ie">Inicio das Atividades</label>
												<input class="form-control input-sm data_br" id="cli_inicio" name="cli_inicio" placeholder="Data Inicio" value="<?=$fn->data_br($rs->fld("emp_inicio"));?>">
											</div>
										</div>

										<div class="row">
											<div class="form-group col-md-3">
												<label for="cli_ie">Data I.E.</label>
												<input class="form-control input-sm data_br" id="cli_dataie" name="cli_dataie" placeholder="Data I.E." value="<?=($rs->fld("emp_dataie")<>""?$fn->data_br($rs->fld("emp_dataie")):"00/00/0000");?>">
											</div>
											<div class="form-group col-md-3">
												<label for="cli_ie">Data I.M.</label>
												<input class="form-control input-sm data_br" id="cli_dataim" name="cli_dataim" placeholder="Data I.M." value="<?=($rs->fld("emp_dataim")<>""?$fn->data_br($rs->fld("emp_dataim")):"00/00/0000");?>">
											</div>
											<div class="form-group col-md-3">
												<label for="cli_ie">Data CNPJ</label>
												<input class="form-control input-sm data_br" id="cli_datacnpj" name="cli_datacnpj" placeholder="Data CNPJ" value="<?=($rs->fld("emp_datacnpj")<>""?$fn->data_br($rs->fld("emp_datacnpj")):"00/00/0000");?>">
											</div>
											<div class="form-group col-md-3">
												<label for="cli_ie">Data Tributa&ccedil;&atilde;o</label>
												<input class="form-control input-sm data_br" id="cli_datatrib" name="cli_datatrib" placeholder="Data Trib." value="<?=($rs->fld("emp_datatrib")<>""?$fn->data_br($rs->fld("emp_datatrib")):"00/00/0000");?>">
											</div>
										</div>

										<div class="row">
										                        
									        <div class="form-group col-xs-3">
					                          <label for="emp_cep">CEP</label>
					                          <input class="form-control input-sm" id="cep" name="cep" placeholder="CEP" value="<?=$rs->fld("emp_cep");?>">
					                        </div>
					                        <div class="form-group col-xs-5">
					                          <label for="emp_log">Logradouro</label>
					                          <input class="form-control input-sm text-uppercase" id="log" name="log" placeholder="Logradouro" value="<?=$rs->fld("emp_logradouro");?>">
					                        </div>
					                        <div class="form-group col-xs-2">
					                          <label for="emp_num">N&uacute;mero</label>
					                          <input class="form-control input-sm" id="num" name="num" placeholder="Num.:" value="<?=$rs->fld("emp_numero");?>">
					                        </div>
					                        <div class="form-group col-xs-2">
					                          <label for="emp_comp">Complemento</label>
					                          <input class="form-control input-sm text-uppercase" id="compl" name="compl" placeholder="Compl.:" value="<?=$rs->fld("emp_complemento");?>">
					                        </div>
					                        <div class="form-group col-xs-5">
					                          <label for="emp_bai">Bairro</label>
					                          <input class="form-control input-sm text-uppercase" id="bai" name="bai" placeholder="Bairro" value="<?=$rs->fld("emp_bairro");?>">
					                        </div>
					                        <div class="form-group col-xs-5">
					                          <label for="emp_cid">Cidade</label>
					                          <input class="form-control input-sm text-uppercase" id="cid" name="cid" placeholder="Cidade" value="<?=$rs->fld("emp_cidade");?>">
					                        </div>
					                        <div class="form-group col-xs-2">
					                          <label for="emp_uf">UF</label>
					                          <input class="form-control input-sm text-uppercase" id="uf" name="uf" placeholder="UF" value="<?=$rs->fld("emp_uf");?>">
					                        </div>
										</div>

										<div class="row">
											<div class="form-group col-xs-2">
					                        	<label for="emp_uf">Capital Social</label>
					                          	<input class="form-control input-sm" id="cli_capital" placeholder="Capital Social" value="<?=number_format($rs->fld("emp_capital"),2,",",".");?>">
					                        </div>
					                        <div class="form-group col-xs-4">
					                         	<label for="emp_uf">Forma Integraliza&ccedil;&atilde;o</label>
					                        	<input class="form-control input-sm" id="cli_integra" placeholder="Integraliza&ccedil;&atilde;o" value="<?=$rs->fld("emp_integraliza");?>">
					                        </div>
					                        <div class="form-group col-xs-6">
					                        	<label for="emp_uf">Atividades da Empresa</label>
					                        	<input class="form-control input-sm " id="cli_atividade" placeholder="Atividades" value="<?=$rs->fld("emp_atividades");?>">
					                        </div>
										</div>


										<div class="row">

											<div class="form-group col-md-4">
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
											<div class="form-group col-md-2">
												<label for="emp_cid">Email:</label>
												<input class="form-control input-sm text-lowercase" id="cli_mail" name="cli_mail" placeholder="E-Mail" value="<?=$rs->fld("email");?>">
											</div>
											<div class="form-group col-md-2">
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
												<input type="radio" class="minimal" value=1 <?=($rs->fld("ativo")==1?"CHECKED":"");?> id="cli_ativo" name="cli_ativo"> Ativo
												<br>
												<input type="radio" class="minimal" value=0 <?=($rs->fld("ativo")==0?"CHECKED":"");?> id="cli_ativo" name="cli_ativo"> Inativo
											</div>
											<div class="form-group col-md-2">
													<label for="emp_uf">Utiliza DA?</label><br>
													<input type="radio" class="minimal" value=1 <?=($rs->fld("uda")==1?"CHECKED":"");?> id="cli_uda" name="cli_uda"> Sim
													<br>
													<input type="radio" class="minimal" value=0 <?=($rs->fld("uda")==0?"CHECKED":"");?> id="cli_uda" name="cli_uda"> N&atilde;o
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
										<a href="../rel/rel_cpc.php?cod=<?=$rs->fld("cod");?>" target="_blank" class="btn btn-sm btn-primary pull-right"><i class="fa fa-print"></i> CPC </a>
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
																		$con = $per->getPermissao("ver_empresas",$_SESSION['usu_cod']);
																		if($con["C"]==1){
																			$whr = "cod <> 0";
																		}
																		else{
																			$whr = "carteira LIKE '%".$_SESSION['usu_cod']."%'";
																		}

																		$rs2->Seleciona("*","tri_clientes",$whr,"","cod ASC");
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
														$con =$per->getPermissao($pag, $_SESSION['usu_cod']);
														if($con["I"] == 1){ ?>
															<a href="clientes.php?token=<?=$_SESSION['token'];?>&clicod=1" class="btn btn-sm btn-primary pull-right"><i class="fa fa-plus"></i> Add Cliente </a>
														<?php }
														?>
													</div>
													
												</div>
												
												<div id="slc">
													
												</div>
											</div>
										</div><!-- ./box -->
									</div><!-- ./col -->
								</div>