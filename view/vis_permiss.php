<?php
	session_start();
	require_once("../model/recordset.php");
	require_once("../class/class.functions.php");
	date_default_timezone_set("America/Sao_Paulo");
	$fn = new functions();
	$rs = new recordset();
	$rs2 = new recordset();
	$_classe = (isset($_GET['classe'])?$_GET['classe']:0);

	//echo $_classe;
?>
<!--
	<div class=" col-md-12">
		<form role="form" class="form form-inline" method="GET">
			<div class="form-group col-xs-3">
				Data Inicial:<br>
				<input type="text" name="di" class="form-control input-sm col-md-3" />
			</div>
			
			<div class="form-group col-xs-3">
				Data Final: <br>
				<input type="text" name="di" class="form-control input-sm col-md-3" />
			
			</div>
			<div class="form-group col-xs-3">
				<button type="submit" class="btn btn-info"><i class="fa fa-search"></i> Pesquisar</button>
			</div>					
		</form>
	</div>
-->
	<table class="table table-striped ">
		<tr>
			<th class="hidden-xs">#Id</th>
			<th>P&aacute;gina</th>
			<th>Acesso</th>
			<th>Inclus&atilde;o</th>
			<th>Exclus&atilde;o</th>
			<th>Altera&ccedil;&atilde;o</th>
			
		</tr>	
<?php
	
	$sql = "SELECT * FROM permissoes WHERE 1";
	if(!isset($_GET['classe']) OR $_GET['classe']==0){$sql.=" AND pem_id=0";}
	if(!isset($_GET['pag']) OR $_GET['pag']==0){$sql.=" AND pem_pag='".$_GET['pag']."'";}
	//else{$sql.=" WHERE pem_id=2";}
	$rs->FreeSql($sql);
	//echo $sql;
	if($rs->linhas==0):
	echo "<tr><td colspan=3> Nenhuma solicita&ccedil;&atilde;o...</td></tr>";
	else:
		while($rs->GeraDados()){
			$pers = array();
			if(isset($_GET['func']) AND $_GET['func']<>""){
				$pind = $rs2->pegar("pem_permissoes","permissoes_indiv","pem_pag='".$rs->fld("pem_pag")."' AND pem_user={$_GET['func']}");
				if($pind<>""){$pers = json_decode($pind,true);}
				else{$pers = json_decode($rs->fld("pem_permissoes"),true);}
			}
			else{
				$pers = json_decode($rs->fld("pem_permissoes"),true);
			}
			/*
			echo $pind."<br>";
			echo json_encode($pers);
			echo "<pre>";
			print_r($pers);
			echo "</pre>";
			*/
			?>
			<tr>
				<td><?=$rs->fld("pem_id");?></td>
				<td class="hidden-xs"><?=$rs->fld("pem_desc");?></td>
				<td>
					<input type="checkbox" onchange="mark_permiss('<?=$rs->fld("pem_id");?>',<?=$_classe;?>,'C',this.checked,'<?=$rs->fld("pem_pag");?>')" <?=($pers[$_classe]['C']==1?"CHECKED":"")?> class="check_perm" data-size="mini" data-onstyle="success" data-offstyle="danger" value="<?=$pers[$_classe]['C']?>">
				</td>
				<td>
					<input type="checkbox" onchange="mark_permiss('<?=$rs->fld("pem_id");?>',<?=$_classe;?>,'I',this.checked,'<?=$rs->fld("pem_pag");?>')" <?=($pers[$_classe]['I']==1?"CHECKED":"")?> class="check_perm" data-size="mini" data-onstyle="success" data-offstyle="danger" value="<?=$pers[$_classe]['I']?>">
				</td>
				<td>	
					<input type="checkbox" onchange="mark_permiss('<?=$rs->fld("pem_id");?>',<?=$_classe;?>,'E',this.checked,'<?=$rs->fld("pem_pag");?>')" <?=($pers[$_classe]['E']==1?"CHECKED":"")?> class="check_perm" data-size="mini" data-onstyle="success" data-offstyle="danger" value="<?=$pers[$_classe]['E']?>">
				</td>
				<td>
					<input type="checkbox" onchange="mark_permiss('<?=$rs->fld("pem_id");?>',<?=$_classe;?>,'A',this.checked,'<?=$rs->fld("pem_pag");?>')" <?=($pers[$_classe]['A']==1?"CHECKED":"")?> class="check_perm" data-size="mini" data-onstyle="success" data-offstyle="danger" value="<?=$pers[$_classe]['A']?>">
				</td>
				
			</tr>
		<?php  
		}
		echo "<tr><td colspan=7><strong>".$rs->linhas." P&aacute;ginas Permissionadas</strong></td></tr>";
	endif;	
	
	?>
</table>
<script src="<?=$hosted;?>/sistema/js/functions.js"></script>
<script src="<?=$hosted;?>/sistema/assets/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>
<script type="text/javascript">

$(document).ready(function(){
	$(function () {
		$('[data-toggle="tooltip"]').tooltip();
		$('[data-toggle="popover"]').popover({
	        html:true
	    });
	});

	$(".check_perm").bootstrapToggle({
	    on: "Sim",
	    off: "Não"
	});
});

</script>

			