								<div class="box box-primary">
									<div class="box-body">
										<div class="row">
											
											<div class="form-group col-md-3">
												<label for="emp_cnpj">CPF</label>
												<input class="form-control" readonly id="emp_cnpj" placeholder="CNPJ" value="<?=$cpf;?>">
												<input type="hidden" id="emp_cod" value="<?=$rs->fld("emp_codigo");?>" />
												<input type="hidden" id="token" value="<?=$_SESSION["token"];?>" />
											</div>
											<div class="form-group col-md-2">
												<label for="emp_cod_ac">C&oacute;d de Acesso:</label>
												<input class="form-control"  id="emp_cod_ac" placeholder="Codigo de Acesso" value="<?=$cod_ac;?>">
											</div>
											<div class="form-group col-md-2">
												<label for="emp_senha_ac">Senha IR:</label>
												<input class="form-control" id="emp_senha_ac" placeholder="Senha IR" value="<?=$senha_ac;?>">
											</div>
											<div class="form-group col-md-2">
												<label for="emp_expsenha">Validade:</label>
												<input class="form-control dtp" id="emp_expsenha" placeholder="Validade da Senha" value="<?=$val_senha;?>">
											</div>
											
										</div>
										<div class="row">
											<div class="form-group col-xs-5">
												<label for="emp_rzs">Nome:</label>
												<input class="form-control text-uppercase" id="emp_rzs" placeholder="Raz&atilde;o Social" value="<?=$nome;?>">
											</div>
											<div class="form-group col-xs-3">
												<label for="emp_nasc">Nasc:</label>
												<input class="form-control dtp" id="emp_nasc" placeholder="Data de Nascimento" value="<?=$data;?>">
											</div>
											<div class="form-group col-xs-4">
												<label for="emp_benef">Benef&iacute;cio:</label>
												<input class="form-control text-uppercase" id="emp_benef" placeholder="Benef&iacute;cio" value="<?=$benef;?>">
											</div>
											

										</div>
											
										<div class="row">
											<div class="form-group col-xs-3">
												<label for="emp_cep">CEP</label>
												<input class="form-control" id="cep" placeholder="CEP" value="<?=$rs->fld("emp_cep");?>">
											</div>
											<div class="form-group col-xs-5">
												<label for="emp_log">Logradouro</label>
												<input class="form-control text-uppercase" id="log" placeholder="Logradouro" value="<?=$rs->fld("emp_logr");?>">
											</div>
											<div class="form-group col-xs-2">
												<label for="emp_num">N&uacute;mero</label>
												<input class="form-control" id="num" placeholder="Num.:" value="<?=$rs->fld("emp_num");?>">
											</div>
											<div class="form-group col-xs-2">
												<label for="emp_comp">Complemento</label>
												<input class="form-control text-uppercase" id="compl" placeholder="Compl.:" value="<?=$rs->fld("emp_compl");?>">
											</div>
											<div class="form-group col-xs-5">
												<label for="emp_bai">Bairro</label>
												<input class="form-control text-uppercase" id="bai" placeholder="Bairro" value="<?=$rs->fld("emp_bairro");?>">
											</div>
											<div class="form-group col-xs-5">
												<label for="emp_cid">Cidade</label>
												<input class="form-control text-uppercase" id="cid" placeholder="Cidade" value="<?=$rs->fld("emp_cidade");?>">
											</div>
											<div class="form-group col-xs-2">
												<label for="emp_uf">UF</label>
												<input class="form-control text-uppercase" id="uf" placeholder="UF" value="<?=$rs->fld("emp_uf");?>">
											</div>
										</div>
									</div>
									<div class="box-footer">
										<button id="bt_altera_end" class="btn btn-sm btn-primary"><i class="fa fa-pencil"></i> Alterar Dados </button>
									</div>
										<div id="consulta"></div>
									</div>