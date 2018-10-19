<?php
	session_start("portal");
	require_once("../class/class.functions.php");
	require_once("../class/class.dashboard.php");
	require_once("../class/class.permissoes.php");
	date_default_timezone_set("America/Sao_Paulo");
	$fn = new functions();
	$fn2 = new dashboard();
	$rs = new recordset();
	$rs2 = new recordset();
	$per = new permissoes();

	$con = $per->getPermissao("minhas_metas.php",$_SESSION['usu_cod']);
?>
	<table class="table table-striped table-condensed">
		<thead>
			<tr>
				<th><input type="checkbox" class="master"></th>
				<th>Empresa</th>
				<th>Tarefa</th>
				<th>Competência</th>
				<th>Departamento</th>
				<th>Vencimento</th>
				<th>Progresso</th>
			</tr>	
		</thead>
		<tbody>
	<?php
		// Pegando o vencimento da lista ativa
		if(isset($_GET['lista']) && $_GET['lista']<>""){
			$sql = "SELECT d.ob_cod, d.ob_titulo, d.ob_venc, b.imp_nome, b.imp_depto, c.empresa, c.cod, e.dep_nome FROM tarmetas a 
						JOIN tipos_impostos b 	ON a.tarmetas_obri = b.imp_id
						JOIN tri_clientes c 	ON a.tarmetas_emp = c.cod
						JOIN obrigacoes d 		ON a.tarmetas_obri = d.ob_titulo AND a.tarmetas_emp = d.ob_cod
						JOIN departamentos e 	ON b.imp_depto = e.dep_id
					WHERE a.tarmetas_metasId = ".$_GET['lista'];
			if(isset($_GET['compet']) && $_GET['compet']<>""){ 
				$compet = $_GET['compet'];
			}
			else{
				$compet = date("m/Y", strtotime("-1 month"));
			}
		}
		else{
			$sql = "
					SELECT a.ob_cod, a.ob_titulo, a.ob_venc, b.imp_nome, b.imp_depto, c.empresa, c.cod, d.dep_nome FROM obrigacoes a 
						JOIN tipos_impostos b ON a.ob_titulo = b.imp_id 
						JOIN tri_clientes c ON a.ob_cod=c.cod
						JOIN departamentos d ON d.dep_id = b.imp_depto
					WHERE 1 AND ob_ativo=1";
					
			$sqcom="";
			$compet = "";
			/*-------------------------|ALTERAÇÃO|-------------------------*\
			|	Criando a condição para aprimorar a pesquisa caso 			|
			|	os filtros estejam vazios (entrada da página) 				|
			|	26.04.2018 - Cleber Marrara Prado							|
			\*-------------------------------------------------------------*/
			/* se os GETS forem setados, adiciona pesquisa por filtro
			*/
			if(isset($_GET['dep']) && $_GET['dep']<>""){ 
				$sql.= " AND b.imp_depto = ".$_GET['dep'];
			}
			
			if(isset($_GET['tipo']) && $_GET['tipo']<>""){ 
				$sql.= " AND b.imp_tipo = '".$_GET['tipo']."'";
			}

			if(isset($_GET['emp']) && $_GET['emp']<>""){ 
				$sql.= " AND a.ob_cod = ".$_GET['emp'];
				$sqcom = " AND env_codEmp = ".$_GET['emp'];
			}
			
			
			if(isset($_GET['di']) && $_GET['di']<>""){ 
				$sql.= " AND a.ob_venc >= ".$_GET['di'];
			}
			
			if(isset($_GET['df']) && $_GET['df']<>""){ 
				$sql.= " AND a.ob_venc <= ".$_GET['df'];
			}
			
			if(isset($_GET['colab']) && $_GET['colab']<>""){ 
				$sql.= " AND ob_cod IN (SELECT cod FROM tri_clientes WHERE carteira LIKE '%\"".$_GET['dep']."\":{\"user\":\"".$_GET['colab']."\"%')";
			}
			/*
			*/
			
			if(isset($_GET['obriga']) && $_GET['obriga']<>""){ 
				$sql.= " AND ob_titulo IN (".$_GET['obriga'].")";
			}
		
			if(isset($_GET['compet']) && $_GET['compet']<>""){ 
				$compet = $_GET['compet'];
			}
			else{
				$compet = date("m/Y", strtotime("-1 month"));
			}

			$sql.= " AND a.ob_titulo NOT IN(
					SELECT env_codImp 
						FROM impostos_enviados 
						WHERE 1
						AND env_compet = '".$compet."'
						AND env_gerado=1
						AND env_conferido=1
						AND env_enviado=1
						AND env_codEmp IN(a.ob_cod)
						".$sqcom.")";
			$sql.= " AND ob_titulo NOT IN
						(
							SELECT tarmetas_obri FROM tarmetas
								WHERE tarmetas_comp ='".$compet."' 
								AND tarmetas_emp IN (a.ob_cod) 
								AND tarmetas_metasId IN
								(
									SELECT metas_id FROM metas
										WHERE '".date('Y-m-d')."' <= metas_datafin
								)
							)";
			
		}
		$sql.= " ORDER BY  ob_venc ASC , imp_nome ASC, ob_cod ASC";
		/*
		echo"<pre>". $sql."</pre>";
		echo $con['C'];
		echo "<pre>";
		print_r($_SESSION);
		echo "</pre>";
		*/
		$rs->FreeSql($sql);
		$tarmetas = array();
		if($rs->linhas==0):
		echo "<tr><td colspan=7> Nenhuma tarefa. Tarefa já concluída ou presente em outra lista.</td></tr>";
		else:
			$value="";
			while($rs->GeraDados()){
				$emp = $rs->fld("ob_cod");
				$imp = $rs->fld("ob_titulo");
				$com = $compet;
				$value = $emp.":".$imp.":".$compet;
				$sql1 = "SELECT a.env_gerado, a.env_conferido, a.env_enviado FROM  impostos_enviados a 
						 WHERE a.env_codImp = ".$imp." 
						 AND a.env_compet = '".$com."' 
						 AND a.env_codEmp = ".$emp;
				if(isset($_GET['sem']) AND $_GET['sem']==1){
					$sql1.=" AND a.env_geradodata BETWEEN '".$rs->fld("metas_dataini")." 00:00:00' AND '".$rs->fld("metas_datafin")." 23:59:59';";
				}
				//echo $sql1."<br>";		 
				$num = 0;
				$rs2->FreeSql($sql1);
				if($rs2->linhas > 0){
					$rs2->GeraDados();
					$num = $rs2->fld("env_gerado")+$rs2->fld("env_conferido")+$rs2->fld("env_enviado");
				}
				$res = ($num / 3)*100;
				$cor = $fn2->getColor($res);
				?>
				<tr>
					<td><input type="checkbox" name="lista_tasks[]" value="<?=$value;?>"></td>
					<td><?=$rs->fld("empresa");?></td>
					<td><?=$rs->fld("imp_nome");?></td>
					<td><?=$compet;?></td>
					<td><?=$rs->fld("dep_nome");?></td>
					<td><?=$rs->fld("ob_venc");?></td>
					<td>
						<div id="pgb_status" class="progress progress-md <?=($res==100?"":"progress-striped");?> active">
							<div class="progress-bar progress-bar-<?=$cor;?>" role="progressbar" aria-valuenow="<?=$res;?>" aria-valuemin="0" aria-valuemax="100" style="width:<?=$res;?>%;">
								<span class=""><?=number_format($res,2)."% (".($res==100?"Completo":"Em processo").")";?></span>
							</div>
						</div>
					</td>
				</tr>
			<?php  
			}
		endif;		
		?>
		</tbody>
	</table>
<script>
	$(document).ready(function () {
		
		$('.master').on('change', function() {
   			$('input[type="checkbox"]').prop('checked', this.checked);
		})
		
	});


	setTimeout(function(){
		//$("#slc").load("meus_chamados.php");		
		$("#alms").load(location.href+" #almsg");
	 },10500);
</script>