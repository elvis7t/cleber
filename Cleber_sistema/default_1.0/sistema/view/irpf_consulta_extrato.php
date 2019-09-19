<div class="box box-primary">
	<div class="box-body">
		<div class="box box-default">
			<div class="col-md-5">
				<form role="form" id="cad_outros">
					<div class="box-body">
						<div class="row">
							<div class="form-group col-xs-6">
								<label for="emp_benef">Benef&iacute;cio:</label>
								<input class="form-control text-uppercase" id="emp_benef" placeholder="Benef&iacute;cio" value="<?=$benef?>">
							</div>
							<div class="form-group col-xs-6">
								<label for="emp_nasc">Nasc:</label>
								<input class="form-control text-uppercase" id="emp_nasc" placeholder="Data de Nascimento" value="<?=$data;?>">
							</div>
							
							<div class="form-group col-xs-12">
								<label for="emp_rzs">Nome:</label>
								<input class="form-control text-uppercase" id="emp_rzs" placeholder="Raz&atilde;o Social" value="<?=$nome;?>">
							</div>
							<div class="form-group col-md-12">
								<label for="emp_cnpj">CPF</label>
								<input class="form-control" readonly id="emp_cnpj" placeholder="CNPJ" value="<?=$fn->sanitize($cpf);?>">
							</div>
						

						</div>
					</div><!-- /.box-body -->
				</form>
			</div><!-- /.box -->
			<div id="demonst" class="col-md-7">
				<iframe style="border:0; width:100%; height:700px;" src="https://extratoir.inss.gov.br/irpf01/pages/consultarExtratoIR.xhtml" width="100%" height="100%"></iframe>
			</div>
		</div>
	</div>
</div>
