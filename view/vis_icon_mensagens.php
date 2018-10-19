<!--|INICIO DAS MENSAGENS|-->
<li class="dropdown messages-menu">
	<!-- Messages: style can be found in dropdown.less-->
	<?php
		//ob_start();
		
		$cua = $_SESSION["usu_cod"];

		//marcando mensagens como lidas com o ID do PARA
		$para = (isset($_GET["para"])?$_GET["para"] : 0);
		$msg = (isset($_COOKIE["msgant"])?$_COOKIE["msgant"] : 0);
		//setcookie("msg_lido",1);

		//Verificando novas mensagens não lidas
		$sql = "SELECT * FROM chat a
					LEFT JOIN usuarios b
					ON a.chat_de = b.usu_cod
					WHERE chat_para = ". $cua ." AND chat_lido = 0 ORDER BY chat_id DESC ";
					//echo $sql;
		$rsa->FreeSql($sql);
	?>
	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		<i class="fa fa-comments-o"></i>
		<?php
		/*|VERIFICAR MENSAGENS PARA EXIBIR NOTIFICAÇÕES|*/
		if($rsa->linhas > 0): 
			$nova = $rsa->linhas;
			$rsa->GeraDados();
			
			if( !(isset($_COOKIE['msgant'])) OR ($_COOKIE['msgant'] <> $rsa->fld("chat_id")) ){
				setcookie("msg_lido",0);
				setcookie("msgant", $rsa->fld("chat_id"));
				$messages = $rsa->fld('chat_msg');
				setcookie("mensagem", $messages);
				//$nm = explode(" ",$rsa->fld("usu_nome"));
				setcookie("user",$rsa->fld("usu_nome"));
				$link_page = "solic.php?token=".$_SESSION["token"]."&para=".$rsa->fld("chat_de");
				setcookie("foto",$rsa->fld("usu_foto"));
				setcookie("pag", $link_page);
				
			}

			?>
			<span class="label label-danger"><?=$rsa->linhas;?></span>
			<!--<input type="hidden" id="nova" value=<?=$nova;?> />-->
		<?php
			endif;
			
			

		?>
		<input type="hidden" id="nova" value=<?=$_COOKIE['msg_lido'];?> />
	</a>
	<ul class="dropdown-menu">
		<li class="header">Voc&ecirc; tem <?=$rsa->linhas .($rsa->linhas>1?" mensagens":" mensagem");?></li>
		<li>
		<!-- inner menu: contains the actual data -->
			<ul class="menu">
				<?php 
				
					$rsa->FreeSql($sql);
					while($rsa->GeraDados()):
					$link_page = "solic.php?token=".$_SESSION["token"]."&para=".$rsa->fld("chat_de");
				?>
				<li><!-- start message -->

					<a href="<?=$link_page;?>">
						<div class="pull-left">
						<img src="<?=$hosted.$rsa->fld("usu_foto");?>" class="img-circle" alt="User Image">
						</div>
						<h4>
						<?php
							list($nome, $sobre) = explode(" ",$rsa->fld("usu_nome"));
							echo $nome." ".$sobre;
						?>
						<small><i class="fa fa-clock-o"></i> <?=$fna->calc_dh($rsa->fld("chat_hora"));?></small>
						</h4>
						<p><?=$rsa->fld("chat_msg");?></p>
					</a>
				</li><!-- end message -->
				<?php endwhile; 
				// Setando mensagens como lida
				$sq_chat = "UPDATE chat SET chat_lido=1 WHERE chat_de = ".$para." AND chat_para = ".$cua;
				$rsa->FreeSql($sq_chat);
				echo "<!--".$rsa->sql."-->";
		
				?>
				
				<!--<li class="footer"><a href="#">Veja todas as Mensagens</a></li>-->
			</ul>
		</li>
	</ul>	
</li>

<!--|FIM DAS MENSAGENS|-->
