 <div class="row">	
				<div class="col-xs-12">
					<div class="box box-success" id="irrf_cli">
						<div class="box-header with-border">
							<h3 class="box-title">Itens:</h3>
						</div><!-- /.box-header -->
						<div class="box-body">
						<!-- OPÇÔES DO FILTRO -->
						<div class="row">
							<div class="form-group col-md-3">
								<div class="input-group">
									<div class="input-group-addon">
				                       	<i class="fa fa-suitcase"></i>
				                    </div>
									<select id="pes_fisEmpresa" class="select2" MULTIPLE style="width:100%">
										<option value="">Selecione:</option>
										<?php
											$whr="ativo = 1";
											$rs->Seleciona("*","tri_clientes",$whr);
											while($rs->GeraDados()):	
											?>
												<option value="<?=$rs->fld("cod");?>"><?=$rs->fld("cod")." - ".$rs->fld("apelido");?></option>
											<?php
											endwhile;
										?>
									</select>	
								</div>
							</div>
							<div class="form-group col-md-3">
								<div class="input-group">
									<div class="input-group-addon">
				                       	<i class="fa fa-flash"></i>
				                    </div>
									<select id="pes_fisTributacao" class="form-control" style="width:100%">
										<option value="">Selecione:</option>
										<option value="SN">Simples Nac</option>
										<option value="LP">L. Presumido</option>
										<option value="LR">L. Real</option>
										<option value="AU">AUutonomo</option>
										<option value="MEI">MEI</option>
									</select>	
								</div>
							</div>
							<div class="form-group col-md-3">
								<div class="input-group">
									<div class="input-group-addon">
				                       	<i class="fa fa-money"></i>
				                    </div>
									<select id="pes_fisTributo" class="form-control" style="width:100%">
										<option value="">Selecione:</option>
										<?php
											$sql = "SELECT * FROM tipos_impostos WHERE imp_depto=2";
											$rs->FreeSql($sql);
											while($rs->GeraDados()):	
											?>
												<option value="<?=$rs->fld("imp_id");?>"><?="(".$rs->fld("imp_tipo").") ".$rs->fld("imp_nome");?></option>
											<?php
											endwhile;
										?>
									</select>	
								</div>
							</div>
							<div class="form-group col-md-3">
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-user"></i>
										</div>
										<select id="pes_fisTipo" class="form-control" style="width:100%">
											<option value="">Selecione:</option>
											<?php
												$whr="usu_ativo = '1' AND usu_dep=2";
												$rs->Seleciona("*","usuarios",$whr);
												while($rs->GeraDados()):	
												?>
													<option value="<?=$rs->fld("usu_cod");?>"><?=$rs->fld("usu_nome");?></option>
												<?php
												endwhile;
											?>
											?>
										</select>	
									</div>
								</div>
							<div class="form-group col-md-3">
								<button id="fisPesq" class="btn btn-success"><i class="fa fa-search"></i> Pesquisar</button>
							</div>
						</div>
						<!--FIM DO FILTRO-->
							<table class="table table-striped" id="cfis">
							 	<thead>
									<tr>
										<th></th>
										<th>#</th>
										<th>Empresa</th>
										<th>Tributa&ccedil;&atilde;o</th>
										<th>Respons&aacute;vel</th>
										<th>Desde</th>
										<th>Obs.</th>
									</tr>
								</thead>
								<tbody id="rescfis">
									<!-- Conteúdo dinamico PHP-->
									<?php require_once("vis_cartfiscal.php"); ?>
								</tbody>
							</table>
						</div>
						<div class="box-footer">
						
							<div class='col-sm-4'>
								<div class="input-group row">
									<input type="hidden" name="ef" id="ef" value="2">
									<select id="cf_colab" name="cf_colab" class="form-control" style="width:100%">
										<option value="">Selecione</option>
										<?php
											$whr="usu_dep=2 and usu_ativo='1'"; // Escrita Fiscal
											$rs2->Seleciona("*","usuarios",$whr,'','usu_nome ASC');
											while($rs2->GeraDados()):	
											?>
												<option value="<?=$rs2->fld("usu_cod");?>"><?=$rs2->fld("usu_nome");?></option>
											<?php
											endwhile;
										?>
									</select>
									<span class="input-group-btn">
										<button
											id="gcart"
											class='btn btn-success' 
											data-toggle='tooltip' 
											data-placement='bottom'
											disabled
											title='Gerar Sa&iacute;da'><i class='fa fa-user'></i> Associar
										</button> 
									</span>
								</div>
							</div>
						
							

						</div>
					</div><!-- ./box -->
					<div id="consulta"></div>
				</div><!-- ./col -->
			</div><!-- ./row -->
			<script src="<?=$hosted;?>/triangulo/js/action_empresas.js"></script>
			<script>
			
			</script>