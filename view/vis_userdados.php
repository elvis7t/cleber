				<div class="box box-primary">
					<div class="box-body">
						<div class="row">
						<div class="form-group col-md-4">
							<label for="emp_cnpj">Nome</label>
							<input class="form-control input-sm" readonly id="usu_nome" placeholder="Nome" value="<?=$rs_user->fld("usu_nome");?>">
						</div>
						<div class="form-group col-md-5">
							<label for="emp_cnpj">E-mail / Usu&aacute;rio</label>
							<input class="form-control input-sm" readonly id="usu_email" placeholder="email" value="<?=$rs_user->fld("usu_email");?>">
						</div>
						
						</div>
						<div class="row">
						
						
						<div class="form-group col-xs-3">
							<label for="emp_cep">CEP</label>
							<input class="form-control input-sm" id="cep" placeholder="CEP" value="<?=$rs_user->fld("dados_cep");?>" <?=$disable; ?>>
						</div>
						<div class="form-group col-xs-5">
							<label for="emp_log">Logradouro</label>
							<input class="form-control input-sm text-uppercase" id="log" placeholder="Logradouro" value="<?=$rs_user->fld("dados_rua");?>" <?=$disable; ?>>
						</div>
						<div class="form-group col-xs-2">
							<label for="emp_num">N&uacute;mero</label>
							<input class="form-control input-sm" id="num" placeholder="Num.:" value="<?=$rs_user->fld("dados_num");?>" <?=$disable; ?>>
						</div>
						<div class="form-group col-xs-2">
							<label for="emp_comp">Complemento</label>
							<input class="form-control input-sm text-uppercase" id="compl" placeholder="Compl.:" value="<?=$rs_user->fld("dados_compl");?>" <?=$disable; ?>>
						</div>
						<div class="form-group col-xs-5">
							<label for="emp_bai">Bairro</label>
							<input class="form-control input-sm text-uppercase" id="bai" placeholder="Bairro" value="<?=$rs_user->fld("dados_bairro");?>" <?=$disable; ?>>
						</div>
						<div class="form-group col-xs-5">
							<label for="emp_cid">Cidade</label>
							<input class="form-control input-sm text-uppercase" id="cid" placeholder="Cidade" value="<?=$rs_user->fld("dados_cidade");?>" <?=$disable; ?>>
						</div>
						<div class="form-group col-xs-2">
							<label for="emp_uf">UF</label>
							<input class="form-control input-sm text-uppercase" id="uf" placeholder="UF" value="<?=$rs_user->fld("dados_uf");?>" <?=$disable; ?>>
						</div>
						
						<div class="form-group col-xs-2">
							<label for="emp_uf">Nascimento</label>
							<input class="form-control input-sm text-uppercase date" id="data" placeholder="Data" value="<?=$fn->data_br($rs_user->fld("dados_nasc"));?>" <?=$disable; ?>>
						</div>
						 <div class="form-group col-xs-5">
							<label for="emp_bai">Forma&ccedil;&atilde;o</label>
							<input class="form-control input-sm text-uppercase" id="escol" placeholder="Forma&ccedil;&atilde;o" value="<?=$rs_user->fld("dados_escol");?>" <?=$disable; ?>>
						</div>
						<div class="form-group col-md-3">
							<label>Cor:</label>
							<div class="input-group my-colorpicker2">
								<input type="text" class="form-control input-sm" id="usu_cor" value="<?=$rs_user->fld("dados_usucor");?>">
								<div class="input-group-addon">
								<i></i>
								</div>
							</div><!-- /.input group -->
						</div>

						<div class="form-group col-xs-12">
							<label for="emp_cid">Observa&ccedil;&otilde;es <small>(Status)</small></label>
							<textarea class="form-control" id="notas" placeholder="status" <?=$disable; ?>><?=$rs_user->fld("dados_notas");?></textarea>
						</div>
					</div>
					<div id="consulta"></div>
					</div>
					<div class="box-footer">
						<button id="bt_altera_func" class="btn btn-sm btn-primary"><i class="fa fa-pencil"></i> Alterar Dados </button>
					</div>
				</div>