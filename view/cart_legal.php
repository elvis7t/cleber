 <div class="row">	
				<div class="col-xs-12">
					<div class="box box-success" id="irrf_cli">
						<div class="box-header with-border">
							<h3 class="box-title">Itens:</h3>
						</div><!-- /.box-header -->
						<div class="box-body">
						<!-- OPÇÔES DO FILTRO -->
							<div class="row">
								<div class="form-group col-md-6">
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-suitcase"></i>
										</div>
										<select id="pes_legEmpresa" class="select2" MULTIPLE style="width:100%">
											<option value="">Selecione:</option>
											<?php
												$whr="cod <> 0";
												$rs->Seleciona("*","tri_clientes",$whr,"","cod ASC");
												while($rs->GeraDados()):	
												?>
													<option <?=($rs->fld("ativo")==0?"disabled":"");?> value="<?=$rs->fld("cod");?>"><?=str_pad($rs->fld("cod"),3,"000",STR_PAD_LEFT)." - ".$rs->fld("apelido");?></option>
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
										<select id="pes_legTipo" class="form-control" style="width:100%">
											<option value="">Selecione:</option>
											<?php
												$whr="usu_dep=5";
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
								
								<div class="form-group col-md-2">
									<button id="legPesq" class="btn btn-sm btn-success"><i class="fa fa-search"></i> Pesquisar</button>
								</div>
							</div>
							<!--FIM DO FILTRO-->
							<table class="table table-striped table-responsive table-condensed" id="dcon">
							 	<thead>
									<tr>
										<th></th>
										<th>#</th>
										<th>Empresa</th>
										<th>Respons&aacute;vel</th>
										<th>Desde</th>
									</tr>
								</thead>
								<tbody id="respleg">
									
								</tbody>
							</table>
						</div>
						<div class="box-footer">
						
							<div class='col-sm-4'>
								<div class="input-group row">
									<input type="hidden" name="dl" id="dl" value="5">
									<select id="cl_colab" name="cl_colab" class="form-control" style="width:100%">
										<option value="">Sem colaborador</option>
										<?php
											$whr="usu_dep=5 and usu_ativo='1'"; // LEGAL
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
											id="gcart5"
											class='btn btn-success' 
											data-toggle='tooltip' 
											data-placement='bottom'
											title='Associar'><i class='fa fa-user'></i> Associar
										</button> 
									</span>
								</div>
							</div>
						
							<div class="pull-right">
								<a id="bt_cartleg_rel" href="#" target="_blank" class="btn btn-sm btn-default"><i class="fa fa-print"></i> Imprimir</a>
								<a id="bt_cartleg_excel" href="#" target="_blank" class="btn btn-sm btn-success"><i class="fa fa-file-excel-o"></i> Excel</a>
							</div>
						</div>
					</div><!-- ./box -->
					<div id="consulta_l"></div>
				</div><!-- ./col -->
			</div><!-- ./row -->
<script src="<?=$hosted;?>/sistema/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>	
<script src="<?=$hosted;?>/sistema/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=$hosted;?>/sistema/assets/plugins/datatables/dataTables.bootstrap.min.js"></script> 
<script src="<?=$hosted;?>/sistema/js/action_empresas.js"></script>

