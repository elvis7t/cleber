<!--|INICIO DOS DOCUMENTOS|-->

<li class="dropdown notifications-menu">
	<?php
		error_reporting(E_ALL & E_NOTICE & E_WARNING);

		session_start("portal");
		$sql = "SELECT a.*, c.apelido, e.dep_tema, doc_tipo FROM entrada_docs a
				JOIN codstatus b 		ON b.st_codstatus = a.doc_status
				JOIN tri_clientes c 	ON c.cod = a.doc_cli
				LEFT JOIN usuarios d 	ON d.usu_cod = a.doc_resp
				JOIN departamentos e 	ON e.dep_id = a.doc_dep
				JOIN tipos_arquivos f	ON f.tarq_id =  a.doc_tipo
				JOIN clientes_arquivos g ON g.cliarq_arqId = a.doc_tipo AND g.cliarq_empresa=c.cod
			WHERE doc_dep = ".$_SESSION['dep']." AND doc_status=0 ORDER BY doc_id DESC";
			
		$rsa->FreeSql($sql);
		$nlin = $rsa->linhas;
		//echo $sql;
			
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
				$rsa->GeraDados();
				if( !(isset($_COOKIE['docant'])) OR ($_COOKIE['docant'] <> $rsa->fld("doc_id")) ){
					setcookie("docant", $rsa->fld("doc_id"));
					setcookie("doclido",0);
					$docmessages = "Novo Documento na portaria Empresa: ".$rsa->fld("apelido")." | Documento: ".$rsa->fld("doc_tipo");
					setcookie("docmensagem", $docmessages);
					setcookie("docdep", $rsa->fld("dep_nome"));
					$doc_page = "vew_entregadocs.php?token=".$_SESSION["token"];
					setcookie("docpag", $doc_page);
				} 
				$rsa->FreeSql($sql);
				while($rsa->GeraDados()):
					?>
						<li>
							<a href="view_entregadocs.php?token=<?=$_SESSION['token'];?>">
								<i class="fa fa-<?=$rsa->fld("dep_tema");?> text-info"></i> <?=$rsa->fld("doc_tipo")." - ".$rsa->fld("apelido")." (id: #".$rsa->fld("doc_id").")";?>
							</a>
						</li>
					<?php 
				endwhile;
			endif;?>
			</ul>

		</li>
		<li class="footer"><a href="view_entregadocs.php?token=<?=$_SESSION['token'];?>">Ver Todos</a></li>
	</ul>
</li>

<!--|FIM DOS DOCUMENTOS|-->
	