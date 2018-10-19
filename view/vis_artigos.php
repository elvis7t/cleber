<?php
	require_once("../model/recordset.php");
	date_default_timezone_set("America/Sao_Paulo");
	require_once("../class/class.functions.php");
	$rs_cloud = new recordset();
	$fn = new functions();
?>
	<table class="table table-striped">
		<tr>
			<th>#</th>
			<th>Titulo</th>
			<th>Categoria</th>
			<th>Publicado por</th>
			<th>Publicado em</th>
			<th>Link</th>
		</tr>	
		<?php
			$sql = "SELECT * FROM artigos a
					JOIN art_categorias b ON a.art_categ = b.cat_id";
			
			/*-------------------------|ALTERAÇÃO|-------------------------*\
			|	Criando a condição para aprimorar a pesquisa caso 			|
			|	os filtros estejam vazios (entrada da página) 				|
			|	27.10.2016 - Cleber Marrara Prado 							|
			\*-------------------------------------------------------------*/
			/* se os GETS forem setados, adiciona pesquisa por filtro
			if(isset($_GET['user']) && $_GET['user']<>""){ $sql.= " AND cham_solic = '".$_GET['user']."'";}
			if(isset($_GET['dtini']) && $_GET['dtini']<>""){ $sql.= " AND cham_abert >= '".$fn->data_usa($_GET['dtini'])." 00:00:00'";}
			if(isset($_GET['dtfim']) && $_GET['dtfim']<>""){ $sql.= " AND cham_abert <= '".$fn->data_usa($_GET['dtfim'])." 23:59:59'";}
			if(isset($_GET['tarefa']) && $_GET['tarefa']<>""){ $sql.= " AND cham_task like '%".$_GET['tarefa']."%'";}
			//if(isset($_GET['status']) && $_GET['status']<>""){ $sql.= "AND cham_status = 99";} else{ $sql.=" AND cham_status<>99";}
			
			//$sql.= " AND cham_status=99 ORDER BY cham_tratfim DESC, cham_status DESC, cham_percent ASC";
			/*
			echo "<pre>";
			print_r($_SESSION);
			echo "</pre>";
			*/

			$rs_cloud->FreeSql($sql);
			
			if($rs_cloud->linhas==0):
			echo "<tr><td colspan=7> Nenhuma solicita&ccedil;&atilde;o...</td></tr>";
			else:
				while($rs_cloud->GeraDados()){
					?>
					<tr>
						<td><?=$rs_cloud->fld('art_id');?></td>
						<td><?=$rs_cloud->fld("art_title");?></td>
						<td><?=$rs_cloud->fld('cat_desc');?></td>
						<td><?=$rs_cloud->fld("art_author");?></td>
						<td><?=$fn->data_hbr($rs_cloud->fld("art_release"));?></td>
						<td><?=$rs_cloud->fld("art_short");?></i></td>
						
					</tr>
				<?php  
				}
			endif;	
		?>
	</table>
