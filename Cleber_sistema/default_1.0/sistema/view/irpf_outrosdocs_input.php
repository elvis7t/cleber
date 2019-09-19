<div class="box box-primary">
	<div class="box-body">
		<div id="tabela_outros">
			<?php require_once("irpf_outrosdocs.php"); ?>
		</div>
		<div class="box box-default">
			<form role="form" id="cad_outros">
				<div class="box-body">
					<div class="row">
						<div class="col-md-4">
							<label from="doc_tipo">Tipo:</label><br>
							<select class="select2 form-control" id="doc_tipo" name="doc_tipo" style="width:100%;">
								<option value="0">Selecione:</option>
								<option value="fa fa-credit-card">Benef&iacute;cio</option>
							</select>
						</div>
					
						<div class="col-md-4">
							<label from="doc_numero">Dados</label>
							<input type="text" id="doc_numero" name="doc_numero" class="form-control input-sm" />
							<input type="hidden" name="clicod" id="clicod" value="<?=$_GET['clicod'];?>" />
						</div>
					</div>
					<br>
					<div id="formerros_outros" class="" style="display:none;">
						<div class="callout callout-danger">
							<h4>Erros no preenchimento do formul&aacute;rio.</h4>
							<p>Verifique os erros no preenchimento acima:</p>
							<ol>
								<!-- Erros são colocados aqui pelo validade -->
							</ol>
						</div>
					</div>
					<br>
					<div id="consulta_outros"></div>										
				</div><!-- /.box-body -->
				<div class="box-footer">
					<button type="button" id="bt_add_outros" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Adicionar...</button>
				</div>
			</form>
		</div><!-- /.box -->
	</div>
</div>