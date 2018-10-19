								<div class="row">
									<div class="form-group col-md-3">
										<div class="input-group">
											<div class="input-group-addon">
												<i class="fa fa-building"></i>
											 </div>
											<select class="form-control select2" name="prod_emp" value="" id="prod_emp"/>
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
											<select class="form-control select2" name="prod_dep" value="" id="prod_dep"/>
												<option value="">Selecione:</option>
												<?php
													$permiss = $per->getPermissao("todos_depart",$_SESSION['usu_cod']);
													$whr = "dep_id>0";
													if($permiss['C']==0){
														$whr.=" AND dep_id = ".$_SESSION['dep'];
													}
													$rs2->Seleciona("*","departamentos",$whr,"","dep_id ASC");
													while($rs2->GeraDados()){ ?>
														<option value="<?=$rs2->fld("dep_id");?>"><?=$rs2->fld("dep_nome");?></option>
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
											<select class="form-control select2" name="prod_usu" value="" id="prod_usu"/>
												<option value="">Selecione:</option>
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
													<input type="text" class="form-control shortdate" id="prod_comp" name="prod_comp"/>
												</div>
											</div>
										<?php } ?>
									
									<div class="col-md-1">
										<button type="button" class="btn btn-success btn-sm" id="btn_pesqprod"><i class="fa fa-search"></i></button>
									</div>
								</div>