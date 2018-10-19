<?php
	require_once("../../sistema/class/class.functions.php");
	$rssen= new recordset();
	
	$empresa = (isset($_GET['emp'])?$_GET['emp']:0);
	$sql2 = "SELECT b.cod, b.empresa, b.cnpj, b.tribut, b.uda, b.mail, b.malote, b.emp_cidade, b.apelido,
				a.sen_cod, a.sen_desc, a.sen_acesso, a.sen_user, a.sen_senha, b.emp_dificult FROM tri_clientes b
				LEFT JOIN senhas a ON a.sen_cod = b.cod
			 WHERE cod = ".$empresa;
	$rssen->FreeSql($sql2);
	//echo $sql2;
	$lin = $rssen->linhas;
	//echo $lin;

?>
<table class="table table-striped table-condensed <?=($lin==0?"hide":"");?>">
	<thead>
		<tr>
			<th>C&oacute;digo:</th>
			<th>Empresa:</th>
			<th>CNPJ:</th>
			<th>Tribut.:</th>
			<th>Dificuldade:</th>
			<th>Comunica&ccedil;&otilde;es:</th>
			<th>Munic&iacute;pio:</th>
		</tr>
	</thead>
	<?php
	if($lin > 0){
	$tbl = "";
		$rssen->GeraDados();
			$rssen->FreeSql($sql2);
			$rating = ($rssen->fld('emp_dificult')/3)*100;
			$dif = $rssen->fld('emp_dificult');
			switch ($dif) {
				case 1:
					$level = "success";
					break;
				case 2:
					$level = "warning";
					break;
				case 3:
					$level = "danger";
					break;
				default:
					$level ="";
					break;	
			}

			$tbl.= "<tr>
						<td>".str_pad($rssen->fld('cod'),3,"0",STR_PAD_LEFT)."</td>
						<td>".$rssen->fld('empresa')."</td>
						<td>".$rssen->fld('cnpj')."</td>
						<td>".$rssen->fld('tribut')."</td>
						<td>
							<div id='ratio' class='progress progress-sm'>
								<div class='progress-bar progress-bar-".$level."' role='progressbar' aria-valuemin='0' aria-valuemax='3' style='width:".$rating."%'>
									
								</div>
							</div>
						</td>
						<td>".($rssen->fld('uda')==1?'<i data-toggle="tooltip" title="Dominio Atendimento" class="fa fa-briefcase text-blue"></i>':'')
											." ".($rssen->fld('mail')==1?'<i data-toggle="tooltip" title="E-mail" class="fa fa-envelope text-green"></i>':'')
											." ".($rssen->fld('malote')==1?'<i data-toggle="tooltip" title="Malote" class="fa fa-motorcycle text-red"></i>':'')."</td>
						<td>".$rssen->fld('emp_cidade')."</td>
					</tr>
					";
			echo $tbl;
		}
		?>
</table>
<table class="table table-striped table-condensed <?=($lin==0?"hide":"");?>">
	
	
	<?php

			
		if($lin > 0){

			?>
			<thead>
				<tr>
					<th>Acesso</th>
					<th>Site / Sist:</th>
					<th>Usuário:</th>
					<th>Senha:</th>
				</tr>
			</thead>
			<tbody>
			<?php
			$tbl2='';
			while($rssen->GeraDados()){
				$tbl2.="
					<tr>
						<td>".$rssen->fld("sen_desc")."</td>
						<td><a href='".$rssen->fld("sen_acesso")."' target='_BLANK'>".(strlen($rssen->fld("sen_acesso"))<=15? $rssen->fld("sen_acesso"):"Ir ao Site")."</a></td>
						<td>".$rssen->fld("sen_user")."</td>
						<td>".$rssen->fld("sen_senha")."</td>
					</tr>
				";
			}
		echo $tbl2;
		}
	?>
	</tbody>
</table>
