<!--|INICIO DO CALENDARIO|-->
<li class="dropdown tasks-menu">
	<?php
		$sql = "SELECT b.eve_desc, cal_id, cal_dataini, cal_url, c.usu_nome FROM calendario a
					JOIN eventos b ON a.cal_eveid = b.eve_id
					JOIN usuarios c on a.cal_criado = c.usu_cod
				WHERE cal_dataini >= '".date("Y-m-d", strtotime("-2 days"))."' AND cal_datafim <='".date("Y-m-d",strtotime("2 days"))."' 
				AND (cal_eveusu like '%[".$_SESSION['usu_cod']."]%'
				OR cal_eveusu like '%[9999]%') ORDER BY cal_id DESC";
		$rsa->FreeSql($sql);
		$linhas = $rsa->linhas;

	?>
	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		<i class="fa fa-calendar"></i>
			<span class="label label-danger"><?=($linhas==0?"":$linhas);?></span>
	</a>
	<ul class="dropdown-menu">
		<li class="header">Existem <?=$linhas;?> tarefas no calend&aacute;rio</li>
		<li>
			<!-- inner menu: contains the actual data -->
			<ul class="menu">
				<?php
					if($linhas == 0):?>
						<li>
							<a>
								<i class="fa fa-times text-danger"></i> Nenhum evento dispon&iacute;vel
							</a>
						</li>
					<?php
					else:
					$rsa->FreeSql($sql);
					$rsa->GeraDados();
					if( !(isset($_COOKIE['eve_ant'])) OR ($_COOKIE['eve_ant'] <> $rsa->fld("cal_id")) ){
						setcookie("eve_ant", $rsa->fld("cal_id"));
						setcookie("eve_lido",0);
						$eve_messages = "Novo Evento Agendado: ".$rsa->fld("eve_desc")." | ".$rsa->fld("usu_nome");
						setcookie("eve_mensagem", $eve_messages);
						$eve_page = $rsa->fld("cal_url")."&token=".$_SESSION['token'];
						setcookie("eve_pag", $eve_page);
					}
					$rsa->FreeSql($sql);
					while($rsa->GeraDados()){?>
					<li><!-- Task item -->
						<a href="<?=$hosted;?>/sistema/view/<?=$rsa->fld("cal_url");?>&token=<?=$_SESSION['token'];?>">
							<h3>
								<?=$fna->data_br($rsa->fld("cal_dataini"))." - ". $rsa->fld("eve_desc");?>
							</h3>
						</a>
					</li><!-- end task item -->
				<?php
					}
				endif;
				?>
			</ul>
		</li>
		<li class="footer">
			<a href="<?=$hosted;?>/triangulo/view/calendar.php?token=<?=$_SESSION['token'];?>">Ver todas as tarefas</a>
		</li>
	</ul>
</li>
<!--|FIM DO CALENDARIO|-->