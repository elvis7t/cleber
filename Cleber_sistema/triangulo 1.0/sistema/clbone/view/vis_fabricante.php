<?php
$rs = new recordset();
$sql ="SELECT * FROM fabricantes
		WHERE fab_id <> 0";
$rs ->FreeSql($sql);
while($rs ->GeraDados()){ ?> 
	<tr>
		<td><?=$rs ->fld("fab_id");?></td>
		<td><?=$rs ->fld("fab_nome");?></td>
		<td>
			<div class="button-group">
				<button type="button" class="btn btn-xs btn-primary" id="btn_alterar" data-toggle='tooltip' data-placement='bottom' title='Alterar'><i class="fa fa-pencil"></i> </button> 
				<button type="button" class="btn btn-xs btn-danger" id="btn_excluir" data-toggle='tooltip' data-placement='bottom' title='Excluir'><i class="fa fa-trash"></i> </button> 
			</div>
		</td> 
		
	</tr>	
<?php }
?> 