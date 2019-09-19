<?php
require_once("../class/class.functions.php");
require_once("../model/recordset.php");

	$rs_rel = new recordset();
	$rs		= new recordset();
	$func 	= new functions();
	/*echo "<pre>";
	print_r($_GET);
	echo "</pre>";*/
	extract($_GET);
	
	//$link = "rel_print.php?tabela=".$tabela."&di=".$di."&df=".$df."&nome=".$atend;
	$sql = "SELECT  a.ob_cod,
					a.ob_titulo,
					b.imp_nome, 
					c.apelido
			FROM obrigacoes a 
				LEFT JOIN tipos_impostos b 		ON a.ob_titulo=b.imp_id
				LEFT JOIN tri_clientes c 		ON a.ob_cod = c.cod
			WHERE ob_ativo=1";
	$filtro = "";
	
	if(isset($dep) AND $dep<>""){
		$sql.=" AND imp_depto = ".$dep;
		$filtro.= "Departamento: ".$dep."<br>";
	}
	if(isset($colab) AND $colab<>""){
		$cond = '"user":"'.$colab.'"';
		$sql.= " AND carteira LIKE '%".$cond."%'";
		$filtro.= "Colaborador: ".$colab."<br>";
	}
	if(isset($emp) AND $emp<>""){

		$sql.=" AND ob_cod IN(".$emp.")";
		$filtro.= "Empresa: ".$emp."<br>";
	}

	
	
	if(isset($trib) AND $trib<>""){
		$sql.=" AND tribut = '".$trib."'";
		$filtro.= "Tributação: ".$trib."<br>";
	}

	if(isset($tipo) AND $tipo<>""){
		$sql.=" AND imp_id=".$tipo;
		$filtro.= "Tipo: ".$tipo."<br>";
	}
			
	
	$sql.=" GROUP BY ob_cod, imp_nome ORDER BY ob_cod, imp_nome";
	
	echo $sql;
	$rs_rel->FreeSql($sql);
	//echo "<!--".$rs_rel->sql."-->";
	$empresa = "";
	while($rs_rel->GeraDados()):

		if($empresa <> $rs_rel->fld("ob_cod")){ 
			$empresa =$rs_rel->fld("ob_cod");  
			?>
			<tr class="success">
				<th colspan=1><?=$rs_rel->fld("ob_cod");?></td>
				<th colspan=10><?=$rs_rel->fld("apelido");?>  </td>
			</tr>
		
		<?php }
		
		if(isset($comp) AND $comp<>""){
			$sql1="SELECT *, 
				e.usu_nome as NomeUsuMov, 
				f.usu_nome as GeradoUser, 
				g.usu_nome as ConfNome, 
				h.usu_nome as EnvNome
			 FROM impostos_enviados d 
				LEFT JOIN usuarios e 			ON d.env_movuser = e.usu_cod
				LEFT JOIN usuarios f 			ON d.env_geradouser = f.usu_cod
				LEFT JOIN usuarios g 			ON d.env_conferidouser = g.usu_cod
				LEFT JOIN usuarios h			ON d.env_user = h.usu_cod
			WHERE env_codImp = {$rs_rel->fld("ob_titulo")}  AND env_codEmp = {$rs_rel->fld("ob_cod")} AND env_compet = '".$comp."'";
			if(isset($mov) AND $mov<>""){
				
			}
			if(isset($ger) AND $ger<>""){

			}
			if(isset($conf) AND $conf<>""){

			}
			if(isset($env ) AND $env <>""){

			}
			echo $sql1.";<br>";
			$rs->FreeSql($sql1);
			if($rs->linhas==0){ ?>
				<tr>
					<td><?=$rs_rel->fld("imp_nome");?></td>
					<td><?=$comp;?></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>				
					<!--<td></td>-->				
				</tr>
	
			<?php }
			else{
				$rs->GeraDados();
				$d = new DateTime($rs->fld("env_movdata"));
				$f = new DateTime($rs->fld("env_data"));
				$diff = $func->horasUteis($d,$f);
				$mtempo = sprintf("%02d", $diff['h'])."h".sprintf("%02d", $diff['m'])."m";
				?>

				<tr>
					<td><?=$rs_rel->fld("imp_nome");?></td>
					<td><?=$rs->fld("env_compet");?></td>
					<td><?=($rs->fld("env_mov")==1?"Sim":"Não");?></td>
					<td><?=($rs->fld("NomeUsuMov")=="NULL"?"":$rs->fld("NomeUsuMov"));?></td>
					<td><?=($rs->fld("env_mov")=="NULL"?"":$func->data_mbr($rs->fld("env_movdata")));?></td>

					<td><?=(($rs->fld("GeradoUser")=="NULL" AND $rs->fld("env_gerado")==0)?"":$rs->fld("GeradoUser"));?></td>
					<td><?=(($rs->fld("env_gerado")=="" AND $rs->fld("env_gerado")==0)?"":$func->data_mbr($rs->fld("env_geradodata")));?></td>

					<td><?=(($rs->fld("ConfNome")=="NULL" AND $rs->fld("env_conferido")==0)?"":$rs->fld("ConfNome"));?></td>
					<td><?=(($rs->fld("env_conferido")=="" AND $rs->fld("env_conferido")==0)?"":$func->data_mbr($rs->fld("env_conferidodata")));?></td>

					<td><?=(($rs->fld("EnvNome")=="NULL" AND $rs->fld("env_enviado")==0)?"":$rs->fld("EnvNome"));?></td>
					<td><?=(($rs->fld("env_enviado")=="" AND $rs->fld("env_enviado")==0)?"":$func->data_mbr($rs->fld("env_data")));?></td>
					
					<!--<td><?=(($rs->fld("env_enviado")=="" AND $rs->fld("env_enviado")==0)?"":$mtempo);?></td>-->

					
					
				</tr>
			<?php
			}
		}
		endwhile;
	$filtro.= ($comp<>""?"Competência: ".$comp."<br>":"");
	echo "<tr><td colspan=4><strong>".$rs_rel->linhas." Registros</strong></td></tr>";
	echo "<tr><td colspan=4><address>".$filtro."</address></td></tr>";
	
	?>
<script>
	$(document).ready(function(){
		$('[data-toggle="popover"]').popover({html:true});
	});
</script>

