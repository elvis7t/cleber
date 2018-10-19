				<div class="box box-default">
					<div class="box-body">
					<form role="form" id="alt_senha">
						<div class="input-group col-md-12">
						<div class="row">
							<div class="form-group col-md-5">
							<label from="lbl_senhaatual">Senha Atual</label>
							<input type="password" class="form-control" id="senhaatual" name="senhaatual"/>
							</div>
						</div>


						<div class="row">
							<div class="form-group col-md-5">
							<label from="lbl_senhaatual">Nova Senha</label>
							<input type="password" class="form-control" id="sen_nova" name="sen_nova"/>
							</div>

							<div class="form-group col-md-5">
							<label from="lbl_senhaatual">Redigite</label>
							<input type="password" class="form-control" id="rsen_nova" name="rsen_nova"/>
							</div>
						</div>
						
						
						<div id="formerros_senha" class="" style="display:none;">
							<div class="callout callout-danger">
							<h4>Erros no preenchimento do formul&aacute;rio.</h4>
							<p>Verifique os erros no preenchimento acima:</p>
							<ol>
								<!-- Erros são colocados aqui pelo validade -->
							</ol>
							</div>
						</div>	
						<div id="consulta2"></div>
					</form>
					</div><!-- /.box-body -->
					<div class="box-footer">
							<button id="bt_alt_senha" class="btn btn-sm btn-success"><i class="fa fa-pencil"></i> Alterar</button>
						</div>
				</div><!-- /.box -->