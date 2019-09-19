								<div class="row">
									<div class="form-group col-md-3">
										<div class="input-group">
											<div class="input-group-addon">
												<i class="fa fa-building"></i>
											 </div>
											<select class="form-control select2" name="mensal_emp" value="" id="mensal_emp"/>
												<option value="">Selecione:</option>
												<?php
													$whr = "ativo=1";
													if($con['A']<>1){
														$whr.= " AND carteira LIKE '%\"".$_SESSION['dep']."\":{\"user\":\"".$_SESSION['usu_cod']."\"%'";
													}
													$rs2->Seleciona("*","tri_clientes",$whr,"","apelido ASC");
													while($rs2->GeraDados()){ ?>
														<option value="<?=$rs2->fld("cod");?>"><?=$rs2->fld("cod")." - ".$rs2->fld("apelido");?></option>
												<?php
													}
												?>
											</select>
										</div>
									</div>
									<div class="form-group col-md-3">
										<div class="input-group">
											<div class="input-group-addon">
												<i class="fa fa-tag"></i>
											 </div>
											<select class="form-control select2" name="mensal_imp" value="" id="mensal_imp"/>
												<option value="">Selecione:</option>
												<?php
													$permiss = $per->getPermissao("todos_depart",$_SESSION['usu_cod']);
													$whr = "imp_id>0";
													if($permiss['C']==0){
														$whr.=" AND imp_depto = ".$_SESSION['dep'];
													}

													$rs2->Seleciona("*","tipos_impostos",$whr,"","imp_nome ASC");
													while($rs2->GeraDados()){ ?>
														<option value="<?=$rs2->fld("imp_id");?>"><?=$rs2->fld("imp_nome");?></option>
												<?php
													}
												?>
											</select>
											
										</div>
									</div>
									<div class="form-group col-md-3">
										<div class="input-group">
											<div class="input-group-addon">
												<i class="fa fa-user"></i>
											</div>
											<select class="form-control select2" name="mensal_usu" value="" id="mensal_usu"/>
												<?php
													if($permiss['C']==1){
														echo "<option value=''>Todos</option>";
													}
													$sql = "SELECT * FROM usuarios WHERE usu_ativo='1'";
													$cart = $per->getPermissao("ver_empresas",$_SESSION['usu_cod']);
													if($cart['C']==0){
														$sql.=" AND usu_cod=".$_SESSION['usu_cod'];
													}
													
													$sql.=" ORDER BY usu_nome ASC";
													$rs2->FreeSql($sql);
													while($rs2->GeraDados()){ ?>
														<option value="<?=$rs2->fld("usu_cod");?>"><?=$rs2->fld("usu_nome");?></option>
												<?php
													}
												?>
											</select>
										</div>
									</div>
									<?php
									$fora_comp = $per->getPermissao("fora_compet",$_SESSION['usu_cod']);
										if($fora_comp['C']==1){?>
											<div class="form-group col-md-2">
												<div class="input-group">
													<div class="input-group-addon">
														<i class="fa fa-calendar"></i>
													</div>
													<input type="text" class="form-control cpr" placeholder="Ano" id="mensal_comp" name="mensal_comp"/>
												</div>
											</div>
										<?php } ?>
									
									<div class="col-md-1">
										<button type="button" class="btn btn-success btn-sm" id="btn_pesqmensal"><i class="fa fa-search"></i></button>
									</div>
								</div>