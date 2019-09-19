								<div class="row">
									
									<div class="form-group col-md-3">
										<div class="input-group">
											<div class="input-group-addon">
												<i class="fa fa-tag"></i>
											 </div>
											<select class="form-control select2" name="progr_dep" value="" id="progr_dep"/>
												<option value=''>Todos</option>
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
											<select class="form-control select2" name="progr_usu" value="" id="progr_usu"/>
												
											</select>
										</div>

																				
									</div>
									
									<div class="form-group col-md-3">
									<div class="input-group">
											<div class="input-group-addon">
												<i class="fa fa-money"></i>
											</div>
											<select class="form-control select2" name="progr_timp" value="" id="progr_timp"/>
												<option value="">Todos</option>
												<option value="A">Apura&ccedil;&atilde;o</option>
												<option value="O">Obriga&ccedil;&atilde;o</option>
												<option value="T">Tributo</option>
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
												<input type="text" class="form-control shortdate" id="progr_comp" name="progr_comp"/>
											</div>
										</div>
									<?php } ?>
								
									
									<div class="col-md-1">
										<button type="button" class="btn btn-success btn-sm" id="btn_pesqprogress"><i class="fa fa-search"></i></button>
									</div>
								</div>