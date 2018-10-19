<!--|INICIO DOS CHAMADOS|-->
<li class="dropdown tasks-menu">
	<?php
		$sql = "SELECT UCASE(cham_task), cham_percent, cham_id 
					FROM chamados 
					WHERE cham_dept = ".$_SESSION['dep']." AND cham_status IN(0,92) ORDER BY cham_id DESC";
		$rsa->FreeSql($sql);
		//echo $rsa->sql;
		$rsa->GeraDados();
		// Cria cookies caso tenha eventos. Validade de 24hs.
		if($rsa->linhas > 0 ){
			if( !(isset($_COOKIE['chams'])) OR ($_COOKIE['chams'] <> $rsa->fld("cham_id")) ){
				setcookie("chams", $rsa->fld("cham_id"));
				setcookie("chamlido",0);
				$chammessages = "Novo Chamado: ".$rsa->fld("UCASE(cham_task)");
				setcookie("chammensagem", $chammessages);
			}
			/*
			if(!(isset($_COOKIE["chams"])) OR ){
				setcookie("chams",0,time()+86400);
				setcookie("vchams",0,time()+86400);
				setcookie("chammsg","TAREFA | ".$rsa->fld("UCASE(cham_task)"));
			}
			*/
		}
	?>

	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		<i class="fa fa-cogs"></i>
		<?php
			if($rsa->linhas > 0){?>
				<span class="label label-info">
				<?=$rsa->linhas;?>
				</span>
			<?php
			}
		?>
	</a>

	<?php 

	if(($rsa->linhas > 0)):
		
		?>
		<ul class="dropdown-menu">
			<li class="header">Existem <?=$rsa->linhas;?> tarefas para tratar</li>
			<li>
			<!-- inner menu: contains the actual data -->
				<ul class="menu">
					<?php
						$rsa->FreeSql($sql);
						//$rsa->GeraDados();
						while($rsa->GeraDados()){?>
						<li><!-- Task item -->
							<a href="<?=$hosted;?>/sistema/view/atendimento.php?token=<?=$_SESSION['token'];?> &acao=1&chamado=<?=$rsa->fld("cham_id");?>">
								<h3>
									<?=$rsa->fld("UCASE(cham_task)");?>                    				
								</h3>
								<div class="progress xs">
									<div class="progress-bar progress-bar-info" style="width: <?=$rsa->fld("cham_percent");?>%" role="progressbar" aria-valuenow="<?=$rsa->fld("cham_percent");?>" aria-valuemin="0" aria-valuemax="100">
										<span class="sr-only"><?=$rsa->fld("cham_percent");?>% Completo</span>
									</div>
								</div>
							</a>
						</li><!-- end task item -->
					<?php
						}
					?>
				</ul>
			</li>
			<li class="footer">
				<a href="<?=$hosted;?>/triangulo/view/vis_chamados.php?token=<?=$_SESSION['token'];?>">Ver todas as tarefas</a>
			</li>
		</ul>
	<?php else: ?>
		<ul class="dropdown-menu">
			<li class="header">N&aacute;o existem chamados abertos</li>
		</ul>
	<?php endif; ?>
</li>

<!--|FINAL DOS CHAMADOS|-->