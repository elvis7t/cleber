				<div class="col-md-12">
					<div class="box box-warning <?=(isset($_GET['box'])?"":"collapsed-box");?>">
			            <div class="box-header with-border">
							<h3 class="box-title">
								Pendentes de Envio
								<?php
								session_start();
								require_once('../model/recordset.php');
								require_once("../class/class.permissoes.php");
								$rspend = new recordset();
								$per = new permissoes();

								$sql = "SELECT * FROM impostos_enviados a
										LEFT JOIN tipos_impostos c ON a.env_codImp = c.imp_id
										LEFT JOIN tri_clientes e ON e.cod = a.env_codEmp
									WHERE 1 ";
									$con = $per->getPermissao("pend_env",$_SESSION["usu_cod"]);
										if($con['C']==0){
										$sql.= " AND e.carteira LIKE '%".$_SESSION['usu_cod']."%' AND imp_depto = ".$_SESSION['dep'];
									}
									
									$sql.=" AND imp_tipo <> 'A'
											AND env_mov=1 
											AND env_gerado=1 
											AND env_conferido=1
											AND (env_enviado IS NULL OR env_enviado=0)
											AND env_compet='".date("m/Y", strtotime("-1 month"))."'";


								$sql.=" ORDER BY e.cod ASC, imp_tipo ASC, cast(imp_venc as unsigned integer) ASC";
								$rspend->FreeSql($sql);
								echo " (".$rspend->linhas.")";
								unset($rspend);
								?>
							</h3>
							<div class="box-tools pull-right">
								<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
								<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
			                </div>
					    </div>
				        <div class="box-body">
				        	<input type="hidden" id="token" value="<?=$_SESSION['token'];?>">
							<div class="row">
									<div class="form-group col-md-3">
										<div class="input-group">
											<div class="input-group-addon">
												<i class="fa fa-building"></i>
											 </div>
											<select style="width:100%;" class="form-control select2" name="pe_emp" value="" id="pe_emp"/>
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
											<select style="width:100%;" class="form-control select2" name="pe_imp" value="" id="pe_imp"/>
												<option value="">Selecione:</option>
												<?php
													$rs2->Seleciona("*","tipos_impostos","imp_ativo=1","","imp_tipo ASC");
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
											<select style="width:100%;" class="form-control select2" name="pe_usu" value="" id="pe_usu"/>
												<option value="">Selecione:</option>
												<?php
													$sql = "SELECT * FROM usuarios WHERE usu_ativo='1'";
													$cart = $per->getPermissao("ver_empresas",$_SESSION['usu_cod']);
													if($cart['C']==0){
														$sql.=" AND usu_cod=".$_SESSION['usu_cod'];
													}
													if($_SESSION['classe']>=3){
														$sql.=" AND usu_dep=".$_SESSION['dep'];
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
													<input type="text" class="form-control shortdate" id="pe_comp" name="pe_comp"/>
												</div>
											</div>
										<?php } ?>
									
									<div class="col-md-1">
										<button type="button" class="btn btn-success btn-sm" id="btn_pespe"><i class="fa fa-search"></i></button>
									</div>
							</div>		
				        	<div id="imp_pesev">
								<?php 
									require_once("imp_pesquisaenv.php");
								?>
							</div>
						</div>
					</div>
				</div><!--/col-->
				