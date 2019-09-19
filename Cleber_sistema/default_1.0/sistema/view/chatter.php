<div>
	<div class="box box-primary direct-chat direct-chat-primary">
		<div class="box-header with-border">
		<?php
			$func = new functions();
			$para = (isset($_GET["para"])?$_GET["para"] : 0);
			$rs2 = new recordset();
		?>
		<h4 class="box-title"> 
		<?php
			if($para <> 0){
				$nome = explode(" ", $rs2->pegar("usu_nome","usuarios","usu_cod=".$para));
				echo $nome[0];
			}
			else{
				echo "Nenhum usuario";
			}
		?>
		
		</h4>
			<div class="box-tools pull-right">
				<span class="badge bg-green" title="" data-toggle="tooltip"></span>
				<button class="btn btn-box-tool" data-widget="chat-pane-toggle" title="Contatos" data-toggle="tooltip" type="button">
				<i class="fa fa-comments"></i>
				</button>
				<button class="btn btn-box-tool" data-widget="remove" type="button">
				<i class="fa fa-times"></i>
				</button>
			</div>
			<div class="box-body">
				<div id="chatContent" class="direct-chat-messages">
					<div id="msgs">
					<?php 
						$cua = $_SESSION["usu_cod"];
						$sq_chat = "UPDATE chat SET chat_lido=1 WHERE chat_de = ".$para." AND chat_para = ".$cua;
						$rs2->FreeSql($sq_chat);
						$sq_chat = "SELECT * FROM chat a 
										JOIN usuarios b ON  b.usu_cod = a.chat_para
										JOIN usuarios c ON  c.usu_cod = a.chat_de
										WHERE (chat_de = ".$cua. " AND chat_para = ".$para.") OR (chat_de = ".$para. " AND chat_para = ".$cua.") 
										GROUP BY chat_id
										ORDER BY chat_hora ASC";						
						$rs2->FreeSql($sq_chat);
						
						while($rs2->GeraDados()){
							$ms=0;
							if($ant == $rs2->fld("chat_de"))	: $ms = 1;
							else							: $ms = 0;
							endif;
							
							if($rs2->fld("chat_de")==$cua):
							?>
								<div class="direct-chat-msg">
									
										<div class="direct-chat-info clearfix">
											<span class="direct-chat-name pull-left"><?=$rs2->fld("usu_nome");?></span>
											<span class="direct-chat-timestamp pull-right"><?=$func->data_hbr($rs2->fld("chat_hora"));?></span>
										</div>
										<img class="direct-chat-img" alt="Message User Image" src="..<?=$rs2->fld("usu_foto");?>">
										<div class="direct-chat-text"><small><i class="<?=($rs2->fld("chat_lido")==0?"fa fa-check-circle-o":"fa fa-check-circle text-primary");?>"></i></small> <?=$rs2->fld("chat_msg");?></div>
									
										
								</div>
							<?php 
							else:
							?>
								<div class="direct-chat-msg right">
								<?php if($ms==1): ?>
									<div class="direct-chat-info clearfix">
										<span class="direct-chat-timestamp pull-left"><?=$func->data_hbr($rs2->fld("chat_hora"));?></span>
									</div>
									<div class="clearfix direct-chat-text"> <?=$rs2->fld("chat_msg");?></div>
								<?php else :?>
									<div class="direct-chat-info clearfix">
										<span class="direct-chat-name pull-right"><?=$rs2->fld("usu_nome");?></span>
										<span class="direct-chat-timestamp pull-left"><?=$func->data_hbr($rs2->fld("chat_hora"));?></span>
									</div>
									<img class="direct-chat-img" alt="Message User Image" src="..<?=$rs2->fld("usu_foto");?>">
									<div class="direct-chat-text"> <?=$rs2->fld("chat_msg");?></div>
									<?php endif; ?>
									
								</div>
							<?php
							endif; 
							$ant = $rs2->fld("chat_de");
							$hora = $rs2->fld("chat_view");
						}
						
						?>
						
						</div>
				</div>
				<div id="vcont">
					<div class="direct-chat-contacts">
						<div class="form-control">
							Ver Online <input class="pull-right" type="checkbox" value="Online" id="view_on">
						</div>
						<ul class="contacts-list">
						<?php
							$rs_chat = new recordset();
							
							if($classe<>1 AND $classe<>4){
								$sql = "SELECT * FROM usuarios LEFT JOIN logado on usu_email = log_user WHERE usu_emp_cnpj='".$_SESSION['usu_empresa']."' AND usu_ativo='1'";
								if($_SESSION['lider']=='Y'){
									$sql.=" AND (usu_classe = 1 or usu_dep = '".$_SESSION['dep']."')";
								}
								else{
									$sql.=" AND usu_classe = 1 OR (usu_dep = '".$_SESSION['dep']."' AND usu_lider = 'Y')";
								}
								$sql.= " GROUP BY usu_email ORDER BY usu_nome ASC";
							}
							else{
								$sql = "SELECT * FROM usuarios LEFT JOIN logado on usu_email = log_user WHERE usu_emp_cnpj='".$_SESSION['usu_empresa']."' AND usu_Ativo='1' GROUP BY usu_email ORDER BY usu_nome ASC";
							}
							
							$rs_chat->FreeSql($sql);
							while($rs_chat->GeraDados()){
								?>
									<li>
										<a href="solic.php?para=<?=$rs_chat->fld("usu_cod");?>&token=<?=$_SESSION["token"];?>">
											<img class="contacts-list-img" src="..<?php echo $rs_chat->fld("usu_foto");?>">
											<div class="contacts-list-info">
												<span class="contacts-list-name">
													<?php echo $rs_chat->fld("usu_nome");?>
													<small class="contacts-list-date pull-right"><?php echo ($rs_chat->fld("log_horario")? "Online":"Offline");?></small>
												</span>
												<span class="contacts-list-msg"><?php echo $rs_chat->fld("usu_email");?></span>
											</div>
										</a>
									</li>
								<?php }
								?>
						</ul>
					</div>
				</div>
			</div>
			<div class="box-footer">
					<div class="input-group">
						<input class="form-control" type="text" placeholder="Escreva a mensagem" id="message" name="message">
						<input type="hidden" id="usu_cod" value="<?=$cua;?>">
						<input type="hidden" id="para" value="<?=$para;?>">
						<span class="input-group-btn">
							<button type="button" id="btChatEnvia" class="btn btn-primary btn-flat">Enviar</button>
						</span>
					</div>
				
			</div>
	</div>
</div>
