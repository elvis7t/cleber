<?php
	require_once("../class/class.functions.php");
	$rssen= new recordset();
	
	$empresa = (isset($_GET['emp'])?$_GET['emp']:0);
	$sql2 = "SELECT * FROM tri_clientes b
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
			<th>Empresa:</th>
			<th>Desc:</th>
			<th>Site / Sist:</th>
			<th>Usuário:</th>
			<th>Senha:</th>
		</tr>
	</thead>
	<tbody>
	<?php
		$tbl = "";
			$rssen->GeraDados();
			$rssen->FreeSql($sql2);
			$tbl.= "<tr>
						<th>".$rssen->fld('empresa')."</th>
						<th>".$rssen->fld('telefone')."</th>
						<th align='center'>".($rssen->fld('uda')==1?'<i class="fa fa-star"></i>':'')."</th>
					</tr>
					";
		if($lin > 0){
			while($rssen->GeraDados()){
				$tbl.="
					<tr>
						<td>".$rssen->fld("sen_cod"). " - ".$rssen->fld("apelido")."</td>
						<td>".$rssen->fld("sen_desc")."</td>
						<td><a href='".$rssen->fld("sen_acesso")."' target='_BLANK'>".$rssen->fld("sen_acesso")."</a></td>
						<td>".$rssen->fld("sen_user")."</td>
						<td>".$rssen->fld("sen_senha")."</td>
					</tr>
				";
			}
		echo $tbl;
		}
	?>
	</tbody>
</table>
