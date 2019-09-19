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
										<select id="pes_ctEmpresa" class="select2" MULTIPLE style="width:100%">
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
											<i class="fa fa-user"></i>
										</div>
										<select id="pes_ctTipo" class="form-control" style="width:100%">
											<option value="">Selecione:</option>
											<?php
												$whr="usu_ativo = '1' AND usu_dep=1";
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
									<button id="ctPesq" class="btn btn-success"><i class="fa fa-search"></i> Pesquisar</button>
								</div>
							</div>
						<!--/ FIM FILTRO-->
							 <table class="table table-striped" id="ccon">
							 	<thead>
									<tr>
										<th><!--<button class="btn btn-xs btn-success checkAll" id="bt_ctSel"><i class="fa fa-check"></i> Todos</button>--></th>
										<th>#</th>
										<th>Empresa</th>
										<th>Tributa&ccedil;&atilde;o</th>
										<th>Respons&aacute;vel</th>
										<th>Desde</th>
										<th>Obs.</th>
									</tr>
								</thead>
								<tbody id="respct">
									<!-- Conteúdo dinamico PHP-->
									<?php require_once("vis_cartcontabil.php"); ?>
								</tbody>
							</table>
						</div>
						<div class="box-footer">
						
							<div class='col-sm-4'>
								<div class="input-group row">
									<input type="hidden" name="dc" id="dc" value="1">
									<select id="cc_colab" name="cc_colab" class="form-control" style="width:100%">
										<option value="">Selecione</option>
										<?php
											$whr="usu_dep=1 and usu_ativo='1'"; // Contábil
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
											id="gccart"
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
	