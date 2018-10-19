	
	<div class="modal" id="aguarde" data-keyboard="false" data-backdrop="static">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Aguarde um momento...</h4>
				</div>
				<div class="modal-body">
					<i class="fa fa-spinner fa-spin"></i>
					<p class="pmsg"></p>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	
	<div class="modal" id="cadastrar">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Aguarde um momento...</h4>
				</div>
				<div class="modal-body">
					<i class="fa fa-cog fa-spin"></i>
					<p>Processando...</p>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	
	
	<div class="modal" id="confirma">
		<div class="modal-dialog">
			<div class="modal-content">
			  	<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Confirma&ccedil;&atilde;o</h4>
			  	</div>
			  	<div class="modal-body">
					<p class="msg_conf" id="msg_conf"></p>
			  	</div>
			  	<div class="modal-footer">
					<button type="button" id="confNao" class="btn btn-danger pull-left" data-dismiss="modal">N&atilde;o</button>
					<button id="confSim" type="button" class="btn btn-success" data-reg=""><i class="fa fa-save"></i> Sim</button>
			  	</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->


	<div class="modal" id="response">
		<div class="modal-dialog">
			<div class="modal-content">
			  	<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Confirma&ccedil;&atilde;o</h4>
			  	</div>
			  	<div class="modal-body">
					<p class="msg_conf" id="msgresp"></p>
			  	</div>
			  	<div class="modal-footer">
					<button type="button" class="btn btn-success pull-right" data-dismiss="modal"><i class="fa fa-thumbs-up"></i> OK</button>
					
			  	</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	 
	<div class="example-modal" id="OK">
		<div class="modal modal-info">
		  	<div class="modal-dialog">
				<div class="modal-content">
			  		<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">Confirma&ccedil;&atilde;o</h4>
			 		</div>
			  		<div class="modal-body">
			  			<input type="hidden" value="" id="cod"/>
						<p class="msg_conf"></p>
			  		</div>
				  	<div class="modal-footer">
						<button type="button" class="btn btn-success btn-outline"><i class="fa fa-save"></i> OK</button>
				  	</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
	</div><!-- /.example-modal -->

	<!--MÓDULO PARA FORMA DE PAGAMENTO DO IRPF-->
	<div class="modal" id="pagar">
		<div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Dados do Pagamento</h4>
			  </div>
			  <div class="modal-body">
				<div class="box box-success">
					
					<div class="box-body">
						<div class="row">
							<div class="form-group col-md-5">
								<label for="forma">Forma de Pagamento</label>
								<select id="irec_forma" class="form-control">
									<option value="">Selecione...</option>
									<option value="Debito">D&eacute;bito</option>
									<option value="Credito">Cr&eacute;dito</option>
									<option value="Dinheiro">Dinheiro</option>
									<option value="Cheque">Cheque</option>
									<option value="Boleto">Boleto</option>
									<option value="Transf.">Transferencia</option>
								</select>
							</div>
							<div class="form-group col-md-7 hide" id="dv_compl">
								<input type="hidden" name="id_recibo" id="id_recibo">
								<label for="forma">Complemento</label>
								<input type="text" class="form-control" id="irec_compl" placeholder="Chq nº: 0000 Banco: Itau"/>
							</div>
							<div class="form-group col-md-12">
								<label for="forma">Valor Pago</label>
								<input type="text" class="form-control" id="irec_valor" placeholder="Valor"/>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-md-12">
								<label for="forma">Observa&ccedil;&otilde;es</label>
								<textarea class="form-control" id="irec_obs"></textarea>
							</div>
						</div>
						
					</div>
					<div class="box-footer">

						<button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Cancelar</button> 
						<button id="bt_pagar_rec" type="button" class="btn btn-success"><i class="fa fa-save"></i> Confirmar</button> 
			  
					</div>
				</div>
			  </div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	<div class="modal" id="close_chamado">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Encerrar Chamado</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="form-group col-md-12">
							<label>Avalia&ccedil;&atilde;o:</label>
							<input id="aval_score" name="aval_score" class="rating rating-loading" data-min="0" data-max="5" data-step="0.5">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" id="bt_closescore" class="btn btn-success"><i class="fa fa-save"></i> OK</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<div class="modal fade" id="fake_dash">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Detalhes do Processo</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="form-group col-md-12">
							<table class="table table-striped table-condensed" id="fdash">
								<thead>
							    	<tr>
							    		<th>Empresa</th>
							    		<th>Imposto/ Obriga&ccedil;&atilde;o</th>
							            <th>Vencimento <small>(esse m&ecirc;s)</small></th>
							    		<th>Carteira</th>
							    		<th>c/ Movimento?</th>
							    		<th>Gerado?</th>
							    		<th>Conferido?</th>
							    		<th>Enviado?</th>
							    	</tr>
							    </thead>
								<tbody id="tbl_fakedash">
										
								</tbody>

							</table>	
						</div>
					</div>
				</div>
				<div class="modal-footer">
				
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->