<!--|INICIO DOS CHAMADOS|-->
<li class="dropdown tasks-menu">
	<?php
		$sql = "SELECT UCASE(b.apelido), b.cod, cleg_percent, cleg_id 
					FROM chamados_legal a
					LEFT JOIN tri_clientes b ON a.cleg_empresa = b.cod
					WHERE cleg_status IN(0,91,92,102)
					AND yearweek(a.cleg_datafim) = yearweek(curdate())";
		$ltd = $perm->getPermissao("cleg_vertodos",$_SESSION['usu_cod']);
		if($ltd['A']<>1){
			$sql.= " AND cleg_depto = ".$_SESSION['dep'];
		}
		$sql.= " ORDER BY cleg_datafim ASC, cleg_id ASC";
		$rsa->FreeSql($sql);
		//echo $rsa->sql;
		$rsa->GeraDados();
		// Cria cookies caso tenha eventos. Validade de 24hs.
		if($rsa->linhas > 0 ){
			if( !(isset($_COOKIE['cleg_ant'])) OR ($_COOKIE['cleg_ant'] <> $rsa->fld("cleg_id")) ){
					setcookie("cleg_lido",0);
					setcookie("cleg_ant", $rsa->fld("cleg_id"));
					$cleg_mensagem = "Chamado Legalização: ".$rsa->fld("cod");
					setcookie("cleg_mensagem", $cleg_mensagem);
					$cleg_page = "vis_tarefaslegal.php?token=".$_SESSION["token"];
					setcookie("cleg_page", $cleg_page);
				}
		}
	?>

	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		<i class="fa fa-tasks"></i>
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
							<a href="<?=$hosted;?>/triangulo/view/atendimento_legal.php?token=<?=$_SESSION['token'];?>&chamado=<?=$rsa->fld("cleg_id");?>&acao=1">
								<h3>
									<?="[".str_pad($rsa->fld("cod"), 3,"000",STR_PAD_LEFT)."] ".$rsa->fld("UCASE(b.apelido)");?>                    				
								</h3>
								<div class="progress xs">
									<div class="progress-bar progress-bar-info" style="width: <?=$rsa->fld("cleg_percent");?>%" role="progressbar" aria-valuenow="<?=$rsa->fld("cleg_percent");?>" aria-valuemin="0" aria-valuemax="100">
										<span class="sr-only"><?=$rsa->fld("cleg_percent");?>% Completo</span>
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
				<a href="<?=$hosted;?>/triangulo/view/vis_tarefaslegal.php?token=<?=$_SESSION['token'];?>">Ver todas as tarefas</a>
			</li>
		</ul>
	<?php else: ?>
		<ul class="dropdown-menu">
			<li class="header">N&aacute;o existem chamados abertos</li>
		</ul>
	<?php endif; ?>
</li>

<!--|FINAL DOS CHAMADOS|-->