				<div class="col-md-12">
					<div class="box box-info">
			            <div class="box-header with-border">
							<h3 class="box-title">Filtrar Tarefas</h3>
							<div class="box-tools pull-right">
								<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
			                </div><!--/box title-->
					    </div><!--/box header-->
				        <div class="box-body">
				        	<input type="hidden" id="token" value="<?=$_SESSION['token'];?>">
							<div class="row">
							<form id="_filttask" role="form">
								<div class="form-group col-md-3">
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-building"></i>
										</div><!--/addon-->
										<select class="form-control select2" name="sel_emp" value="" id="sel_emp"/>
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
									</div><!--/input-group-->
								</div><!--/col-->
								<div class="form-group col-md-2">
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-tag"></i>
										</div><!--/addon-->
										<select class="form-control select2" name="sel_imp" value="" id="sel_imp"/>
											<option value="">Selecione:</option>
											<?php
												$rs2->Seleciona("*","tipos_impostos","imp_ativo=1","","imp_tipo ASC");
												while($rs2->GeraDados()){ ?>
													<option value="<?=$rs2->fld("imp_id");?>"><?=$rs2->fld("imp_nome");?></option>
											<?php
												}
											?>
										</select>
									</div><!--/input-group-->
								</div><!--/col-->
								<div class="form-group col-md-2">
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-users"></i>
										</div><!--/addon-->
										<select class="form-control select2" name="sel_dep" value="" id="sel_dep"/>
											<option value="">Selecione:</option>
											<?php
												$sql = "SELECT * FROM departamentos WHERE 1";
												$cart = $per->getPermissao("todos_depart",$_SESSION['usu_cod']);
												if($cart['C']==0){
													$sql.=" AND dep_id=".$_SESSION['dep'];
												}
												
												$sql.=" ORDER BY dep_nome ASC";
												$rs2->FreeSql($sql);
												while($rs2->GeraDados()){ ?>
													<option value="<?=$rs2->fld("dep_id");?>"><?=$rs2->fld("dep_nome");?></option>
											<?php
												}
											?>
										</select>
									</div><!--/input-group-->
								</div><!--/col-->

								<div class="form-group col-md-2">
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-user"></i>
										</div><!--/addon-->
										<select class="form-control select2" name="sel_usu" value="" id="sel_usu"/>
											<option value="">Selecione:</option>
											
										</select>
									</div><!--/input-group-->
								</div><!--/col-->
								<?php
								$fora_comp = $per->getPermissao("fora_compet",$_SESSION['usu_cod']);
									if($fora_comp['C']==1){?>
										<div class="form-group col-md-2">
											<div class="input-group">
												<div class="input-group-addon">
													<i class="fa fa-calendar"></i>
												</div><!--/addon-->
												<input type="text" class="form-control shortdate" id="sel_comp" name="sel_comp"/>
											</div><!--/input-group-->
										</div><!--/col-->
									<?php } ?>
								
								<div class="col-md-1">
									<button type="button" class="btn btn-success btn-sm" id="btn_pesqImp"><i class="fa fa-search"></i></button>
								</div><!--/col-->
							</form>
							</div><!--/row-->
				        	
				        	<div id="emp_sen">
							
							</div>
				        	<div id="imp_pes">
			        			<?php require_once("imp_pesquisa.php"); ?>
							</div>
						</div>
					</div>
				</div><!--/col-->
				