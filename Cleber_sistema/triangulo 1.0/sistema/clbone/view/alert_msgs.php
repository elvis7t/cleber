<!--|INICIO SAIDAS DO MOTORISTA|-->
<li class="dropdown notifications-menu <?=(($_SESSION['classe']>4 AND $_SESSION['classe']<8)? "hide" : "");?>">
	<!-- Messages: style can be found in dropdown.less-->
	<?php
	$nova = 0;
	$fna = new functions();
	$rsa = new recordset();
	$sql = "SELECT * FROM servicos a
				JOIN codstatus b
					ON b.st_codstatus = a.ser_status
				JOIN tri_clientes c
					ON c.cod = a.ser_cliente
				WHERE ser_status = 0 AND ser_lista=0";
		
		$rsa->FreeSql($sql);

		$nlin = $rsa->linhas;
		$rsa->GeraDados();
		
	?>
	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		<i class="fa fa-car"></i>
			<span class="label label-warning"><?=($nlin==0?"":$nlin);?></span>
			<!--<input type="hidden" id="nova" value=<?=$nova;?> />-->
			
	</a>
	<ul class="dropdown-menu">
		<li class="header">Voc&ecirc; tem <?=($nlin==0?"":$nlin);?> solicita&ccedil;&otilde;es</li>
		<li>
		<!-- inner menu: contains the actual data -->
			<ul class="menu">
				<?php
				$rsa->FreeSql($sql);
				while($rsa->GeraDados()){
				?>
				<li><!-- start message -->
					<a href="#">
						<div class="pull-left">
							<i class="fa fa-car text-aqua"></i> <?=$rsa->fld("apelido");?>
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
<!--|FIM SAIDAS DO MOTORISTA|-->

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
					JOIN usuarios b
					ON a.chat_de = b.usu_cod
					WHERE chat_para = ". $cua ." AND chat_lido = 0 ORDER BY chat_id DESC ";
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
				setcookie("pag", $link_page);
				
			}

			?>
			<span class="label label-danger"><?=$rsa->linhas;?></span>
			<!--<input type="hidden" id="nova" value=<?=$nova;?> />-->
		<?php else:
			
			endif;
			//print_r($_COOKIE);
			/*|	NOVA FUNCIONALIDADE - VERIFICAR DOCUMENTOS ENTREGUES PARA EXIBIR NOTIFICAÇÕES
				CLEBER MARRARA PRADO - 07/04/2016
				COLAB. BRUNO RIBEIRO
				AS NOTIFICAÇÕES SÃO FORMADAS NO ARQUIVO js/controle.js
				A CHAMADA DA FUNÇÃO OCORRE NO ARQUIVO config/footer.php
				FUNCIONA SOMENTE EM PÁGINAS COM O jcookie.js REFERENCIADO
			|*/
			$rsdocs = new recordset();  
			
			$docsql = "SELECT * FROM docs_entrada a
						JOIN tipos_doc b ON a.doc_tipo = b.tdoc_id
						JOIN departamentos c ON a.doc_dep = c.dep_id
						JOIN tri_clientes d ON a.doc_cli = d.cod
					WHERE doc_status = 0 AND dep_id=".$_SESSION['dep'];
			$rsdocs->FreeSql($docsql);
			if($rsdocs->linhas > 0){
				$rsdocs->GeraDados();
				if( !(isset($_COOKIE['docant'])) OR ($_COOKIE['docant'] <> $rsdocs->fld("doc_id")) ){
					setcookie("docant", $rsdocs->fld("doc_id"));
					setcookie("doclido",0);
					$docmessages = "Novo Documento na portaria Empresa: ".$rsdocs->fld("apelido")." | Documento: ".$rsdocs->fld("tdoc_tipo");
					setcookie("docmensagem", $docmessages);
					setcookie("docdep", $rsdocs->fld("dep_nome"));
					$doc_page = "entrega_docs.php?token=".$_SESSION["token"];
					setcookie("docpag", $doc_page);
				}
			}
			
			if(isset($_SESSION['pausa'])){
				$cafe = array(1=>'09:00',
							2=>'09:10',
							3=>'09:20',
							4=>'15:00',
							5=>'15:10',
							6=>'15:20');


				list($p1, $p2) = explode(",", $_SESSION['pausa']);

				
				if($cafe[$p1] == date('H:i')){
					echo $cafe[$p1];
					if( !(isset($_COOKIE['pausa'])) OR ($_COOKIE['pausa'] <> $cafe[$p1])){
						setcookie("pausa",$cafe[$p1]);
						setcookie("pausalido",0);
						$pausamsg = "Café...";
						setcookie("pausamsg", $pausamsg);
					}
					//exit;
				}
				//echo date("H:i");
				
				if($cafe[$p2] == date("H:i")){
					if( !(isset($_COOKIE['pausa'])) OR ($_COOKIE['pausa'] <> $cafe[$p2]) ){
						setcookie("pausa",$cafe[$p2]);
						setcookie("pausalido",0);
						$pausamsg = "Café...";
						setcookie("pausamsg", $pausamsg);
					}
					//exit;
				}
				
			
			}
			

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


<!--|INICIO DOS DOCUMENTOS|-->

<li class="dropdown notifications-menu">
	<?php

		$sql = "SELECT * FROM docs_entrada a
					JOIN codstatus b
						ON b.st_codstatus = a.doc_status
					JOIN tri_clientes c
						ON c.cod = a.doc_cli
					LEFT JOIN usuarios d 
						ON d.usu_cod = a.doc_resp
					JOIN departamentos e 
						ON e.dep_id = a.doc_dep
					JOIN tipos_doc f
						ON f.tdoc_id =  a.doc_tipo
				WHERE doc_dep = ".$_SESSION['dep']." AND doc_status=0";
			
			$rsa->FreeSql($sql);

			$nlin = $rsa->linhas;
			$rsa->GeraDados();
			
	?>
	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		<i class="fa fa-file-text"></i>
        <span class="label label-warning"><?=($nlin==0?"":$nlin);?></span>
	</a>
    <ul class="dropdown-menu">
		<li class="header">Voc&ecirc; tem <?=($nlin==1? $nlin." documento": $nlin." documentos");?></li>
		<li>
			<!-- inner menu: contains the actual data -->
			<ul class="menu">
			<?php
			if($nlin == 0):
			?>
				<li>
					<a href="#">
						<i class="fa fa-times text-danger"></i> Nenhum documento dispon&iacute;vel
					</a>
				</li>
			<?php else:
				$rsa->FreeSql($sql); 
				while($rsa->GeraDados()):
					?>
						<li>
							<a href="entrega_docs.php?token=<?=$_SESSION['token'];?>">
								<i class="fa fa-<?=$rsa->fld("dep_tema");?> text-info"></i> <?=$rsa->fld("tdoc_tipo")." - ".$rsa->fld("apelido");?>
							</a>
						</li>
					<?php 
				endwhile;
			endif;?>
			</ul>

		</li>
		<li class="footer"><a href="#">Ver Todos</a></li>
	</ul>
</li>
<!--|FIM DOS DOCUMENTOS|-->

	
<!--|INICIO DO CALENDARIO|-->
<li class="dropdown tasks-menu">
	<?php
		$sql = "SELECT eve_desc, cal_dataini, cal_url, usu_nome FROM calendario a
					JOIN eventos b ON a.cal_eveid = b.eve_id
					JOIN usuarios c on a.cal_criado = c.usu_cod
				WHERE cal_dataini >= '".date("Y-m-d", strtotime("-1 days"))."' AND cal_datafim <='".date("Y-m-d")."' 
				AND (cal_eveusu like '%[".$_SESSION['usu_cod']."]%'
				OR cal_eveusu like '%[9999]%')";
		$rsa->FreeSql($sql);
		$rsa->GeraDados();
		$linhas = $rsa->linhas;
		//echo $rsa->sql;
		// Cria cookies caso tenha eventos. Validade de 24hs.
		if($linhas > 0 ){
			if(!isset($_COOKIE["ncal"])){
				setcookie("ncal",0,time()+86400);
			}
		}
	?>
	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		<i class="fa fa-calendar"></i>
		
			<?php
				if($linhas > 0 AND (isset($_COOKIE["vcal"]) AND $_COOKIE["vcal"]==0)){
					setcookie("vcal",0,time()+86400);
					setcookie("calmsg",$rsa->fld("usu_nome")." | ".$rsa->fld("eve_desc"));
	
					?>
					<span class="label label-danger">
					<?=$rsa->linhas;?>
					</span>
				<?php
				}
			?>
		
	</a>

	<?php 
	if(($rsa->linhas > 0) /*AND (!isset($_COOKIE["vcal"]) OR $_COOKIE["vcal"]==0)*/):
		?>
		<ul class="dropdown-menu">
			<li class="header">Existem <?=$rsa->linhas;?> tarefas no calend&aacute;rio</li>
			<li>
			<!-- inner menu: contains the actual data -->
				<ul class="menu">
					<?php
						$rsa->FreeSql($sql);
						//$rsa->GeraDados();
						while($rsa->GeraDados()){?>
						<li><!-- Task item -->
							<a href="<?=$hosted;?>/clbone/view/<?=$rsa->fld("cal_url");?>&token=<?=$_SESSION['token'];?>">
								<h3>
									<?=$fna->data_br($rsa->fld("cal_dataini"))." - ". $rsa->fld("eve_desc");?>
								</h3>
							</a>
						</li><!-- end task item -->
					<?php
						}
					?>
				</ul>
			</li>
			<li class="footer">
				<a href="<?=$hosted;?>/clbone/view/calendar.php?token=<?=$_SESSION['token'];?>">Ver todas as tarefas</a>
			</li>
		</ul>
	<?php else: ?>
		<ul class="dropdown-menu">
			<li class="header">N&aacute;o existem tarefas para hoje</li>
		</ul>
	<?php endif; ?>
</li>
<!--|FIM DO CALENDARIO|-->



<!--|INICIO DOS CHAMADOS|-->
<li class="dropdown tasks-menu">
	<?php
		$sql = "SELECT UCASE(cham_task), cham_percent, cham_id FROM chamados WHERE cham_dept = ".$_SESSION['dep']." AND cham_status IN(0,92) ORDER BY cham_id";
		$rsa->FreeSql($sql);
		$rsa->GeraDados();
		// Cria cookies caso tenha eventos. Validade de 24hs.
		if($rsa->linhas > 0 ){
			if(!isset($_COOKIE["chams"])){
				setcookie("chams",0,time()+86400);
			}
		}
	?>

	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		<i class="fa fa-cogs"></i>
		
			<?php
				if($rsa->linhas > 0 AND (isset($_COOKIE["vchams"]) AND $_COOKIE["vchams"]==0)){?>
					<span class="label label-info">
					<?=$rsa->linhas;?>
					</span>
				<?php
				}
				
			?>
		
	</a>

	<?php 

	if(($rsa->linhas > 0) AND (!isset($_COOKIE["vchams"]) OR $_COOKIE["vchams"]==0)):
		setcookie("vchams",0,time()+86400);
		setcookie("chammsg","TAREFA | ".$rsa->fld("UCASE(cham_task)"));
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
							<a href="<?=$hosted;?>/clbone/view/atendimento.php?token=<?=$_SESSION['token'];?> &acao=1&chamado=<?=$rsa->fld("cham_id");?>">
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
				<a href="<?=$hosted;?>/clbone/view/vis_chamados.php?token=<?=$_SESSION['token'];?>">Ver todas as tarefas</a>
			</li>
		</ul>
	<?php else: ?>
		<ul class="dropdown-menu">
			<li class="header">N&aacute;o existem chamados abertos</li>
		</ul>
	<?php endif; ?>
</li>
<!--|FINAL DOS CHAMADOS|-->


<!-- User Account: style can be found in dropdown.less -->
<li class="dropdown user user-menu">
	<?php  if(!isset($_SESSION['nome_usu'])):?>
	<a href="<?=$hosted."/clbone/view/login.php";?>">
		<?php  else :?>
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		<img src="<?=$hosted.$_SESSION['usu_foto'];?>" class="user-image" alt="User Image">
		<?php  endif;?>
		<span class="hidden-xs"><?=(isset($_SESSION['nome_usu'])? $_SESSION['nome_usu'] :'Login');?></span>
	</a>
	<?php  if(isset($_SESSION["nome_usu"])):?>
	<ul class="dropdown-menu">
		<!-- User image -->
		<li class="user-header">
			<img src="<?=$hosted.$_SESSION["usu_foto"];?>" class="img-circle" alt="User Image">
			<p>
			<?=$_SESSION['nome_usu'];?>
				<small><?=$_SESSION['usuario'];?></small>
			</p>
		</li>
		<li class="user-footer">
			<div class="pull-left">
				<a href="<?=$hosted;?>/clbone/view/user_perfil.php?token=<?=$_SESSION['token'];?>&usuario=<?=$_SESSION['usu_cod'];?>" class="btn btn-default btn-flat">Perfil</a>
			</div>
			<div class="pull-right">
				<a href="<?=$hosted;?>/clbone/view/logout.php" class="btn btn-default btn-flat">Sair</a>
			</div>
		</li>
	</ul>
		
	<?php  endif;?>
</li>
<!-- END OF User Account: style can be found in dropdown.less -->

<script>
	setTimeout(function(){
		$("#alms").load(location.href+" #almsg");
	},7500);

</script>