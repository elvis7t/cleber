				<div class="col-md-12">
					<div class="box box-info">
			            <div class="box-header with-border">
							<h3 class="box-title">
								Fila de Importa&ccedil;&atilde;o
								
							</h3>
							
					    </div>
				        <div class="box-body">
				        	<input type="hidden" id="token" value="<?=$_SESSION['token'];?>">
				        	<?php // Permissão para filtrar fila
				        		$fil = $per->getPermissao("filtrar_fila",$_SESSION['usu_cod']);
				        		if($fil['C']==0){
				        			$disabled="DISABLED";
				        		}
				        	?>
							<div class="row">
								<div class="form-group col-md-3">
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-building"></i>
										 </div>
										<select style="width:100%;" <?=$disabled;?> class="form-control select2" name="tar_emp" value="" id="tar_emp"/>
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
										<select style="width:100%;" <?=$disabled;?> class="form-control select2" name="tar_arq" value="" id="tar_arq"/>
											<option value="">Selecione:</option>
											<?php
												$rs2->Seleciona("*","tipos_arquivos","tarq_status=1","","tarq_nome ASC");
												while($rs2->GeraDados()){ ?>
													<option value="<?=$rs2->fld("tarq_id");?>"><?=$rs2->fld("tarq_nome");?></option>
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
										<select style="width:100%;" <?=$disabled;?> class="form-control select2" name="tar_usu" value="" id="tar_usu"/>
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
												<input type="text" <?=$disabled;?> class="form-control shortdate" id="tar_comp" name="tar_comp"/>
											</div>
										</div>
									<?php 
									} 
									?>
								
								<div class="col-md-1">
									<?php if($pag=="index.php"): ?>
										<button type="button" class="btn btn-success btn-sm" id="btn_mosfila"><i class="fa fa-search"></i></button>
									<?php else: ?>
										<button type="button" class="btn btn-success btn-sm" id="btn_pesfila"><i class="fa fa-search"></i></button>
									<?php endif; ?>									
								</div>
							</div>			
				        	<div id="imp_pesce">
								<?php 
									require_once("imp_trataarquivos.php");
								?>
							</div>
						</div>
					</div>
				</div><!--/col-->
				