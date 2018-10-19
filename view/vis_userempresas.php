				<div class="box box-default">
					<div class="box-body">
						<input type="hidden" id="user_colab" value="<?=$_GET['usuario'];?>">
						<table id="user_empresas" class="table table-responsive table-striped table-condensed">
							<thead>
								<tr>
									<th>Ativo</th>
									<th>#</th>
									<th>Empresa</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$user_emps = $rs_user->fld("usu_empresas");
									$arr_emprs = explode(",", $user_emps);
									$sel = "";
									$sql = "SELECT * FROM tri_clientes WHERE ativo = 1";
									if($_SESSION['classe']==8){
										$sql.= " AND cod IN (".$user_emps.")";
									} 
									//echo $sql;
									$rs_user->FreeSql($sql);
									while($rs_user->GeraDados()){ 
										if(in_array($rs_user->fld("cod"), $arr_emprs)){$sel = "CHECKED";}
										else{$sel = "";}
										?>
										<tr>
											<td></td>
											<td><?=str_pad($rs_user->fld("cod"),3,"0",STR_PAD_LEFT);?></td>
											<td><?=$rs_user->fld("empresa");?></td>
										</tr>
									<?php }

								?>
							</tbody>
						</table>
					<div id="consulta_emp"></div>
					</div><!-- /.box-body -->
					<div class="box-footer">
						<button id="bt_atr_empresas" class="btn btn-sm btn-primary"><i class="fa fa-save"></i> Salvar</button>
					</div>
				</div><!-- /.box -->