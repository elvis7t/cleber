<!--|HOMOLOGAÇÕES|-->
	<li class="dropdown notifications-menu">
		<!-- Messages: style can be found in dropdown.less-->
		<?php
		$nova = 0;
		
		$sql = "SELECT a.*, c.usu_nome as solic, b.empresa, b.cod
				FROM homologacoes a
					JOIN tri_clientes b ON a.hom_empresa = b.cod
					LEFT JOIN usuarios c ON a.hom_cadpor = c.usu_cod
					LEFT JOIN usuarios d ON a.hom_realpor = d.usu_cod
					JOIN codstatus e ON a.hom_status = e.st_codstatus
					WHERE hom_empvinculo = ".$_SESSION['usu_empcod'];
					
				$sql.=" AND hom_datahom BETWEEN adddate(now(),-10) and adddate(now(),30) AND hom_status NOT IN(90,99) ";
				$sql .=" Order BY hom_status ASC, hom_id DESC";
			
			$rsa->FreeSql($sql);

			$nlin = $rsa->linhas;
			$rsa->GeraDados();
			if($rsa->linhas >0 AND $_SESSION['classe']<=3){
				if( !(isset($_COOKIE['hom_ant'])) OR ($_COOKIE['hom_ant'] <> $rsa->fld("hom_id")) ){
					setcookie("hom_lido",0);
					setcookie("hom_ant", $rsa->fld("hom_id"));
					$hom_messages = "Homologação cadastrada: ".$rsa->fld("solic")." \nEmpresa ".$rsa->fld("empresa");
					setcookie("hom_mensagem", $hom_messages);
					$hom_page = "#";//"recalc_sol.php?token=".$_SESSION["token"];
					setcookie("hompag", $hom_page);
				}
			}

		?>
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">
			<i class="fa fa-hand-scissors-o"></i>
				<span class="label label-warning"><?=($nlin==0?"":$nlin);?></span>
				<!--<input type="hidden" id="nova" value=<?=$nova;?> />-->
				
		</a>
		<ul class="dropdown-menu">
			<li class="header">Voc&ecirc; <?=($nlin==0?"não":"");?> tem <?=($nlin==0?"":$nlin);?> homologa&ccedil;&otilde;es</li>
			<li>
			<!-- inner menu: contains the actual data -->
				<ul class="menu">
					<?php
					$rsa->FreeSql($sql);
					while($rsa->GeraDados()){
					?>
					<li><!-- start message -->
						<a href="atende_homol.php?token=<?=$_SESSION['token'];?>&homol=<?=$rsa->fld("hom_id");?>">
							<div class="pull-left">
								<i class="fa fa-hand-scissors-o text-orange"></i> <?=$rsa->fld("cod")." - ".$rsa->fld("hom_empregado");?>
							</div>
						</a>
					</li><!-- end message -->
					<?php 
					}
					?>
					<!--<li class="footer"><a href="#">Veja todas as Mensagens</a></li>-->
				</ul>
			</li>
		</ul>	
	</li>
<!--|FIM HOMOLOGAÇÕES-->