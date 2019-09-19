<?php
session_start();
require_once("../model/recordset.php");
require_once("../class/class.functions.php");
date_default_timezone_set("America/Sao_Paulo");
$fn = new functions();
$rs = new recordset();
$rs2 = new recordset();
require_once("../class/class.permissoes.php");
$per = new permissoes();
?>
	

	<table class="table table-striped" id="tab_horas">
		<tr>
			
			<th>Colaborador</th>
			<th>Data</th>
			<th>Desconto</th>
			<th class="hidden-xs">Desc por</th>
			<th class="hidden-xs">Obs.</th>
			<th>A&ccedil;&otilde;es</th>
		</tr>	
<?php
	$sql = "SELECT a.*, b.usu_nome as Colab, c.usu_nome as aprov FROM desconto_horas a 
				JOIN usuarios b ON a.desc_colab = b.usu_cod
				JOIN usuarios c ON a.desc_usucad = c.usu_cod";
	/*
		| ALTERAÇÃO - CLEBER MARRARA - 29.05.2017					|
		| Verificação da permissão (33) de todos os departamentos	|
		| para mostrar todos os departamentos.						|

	*/
	$dep = $per->getPermissao("controle_depart",$_SESSION['usu_cod']);
	if($dep['C']==1){
		$sql.=" WHERE b.usu_empcod = ".$_SESSION['usu_empcod'];
	}else{
		/*
			| ALTERAÇÃO - CLEBER MARRARA - 29.05.2017					|
			| Verificação da permissão (34) de todos os funcionários	|
			| para mostrar todos os usuários. 							|

		*/
		$pus = $per->getPermissao("todos_func",$_SESSION['usu_cod']);
		if($pus['C']==1){$sql.=" WHERE b.usu_dep=".$_SESSION['dep'];}
		else{$sql.=" WHERE desc_colab=".$_SESSION['usu_cod'];}
	}
	if(isset($_GET['us'])){$sql.=" AND b.usu_cod =".$_GET['us'];}
	/* USAREMOS PARA FILTRO FUTURO
	if(isset($_GET['chr_nome'])){$sql.=" AND b.usu_nome like '%".$_GET['chr_nome']."%'";}
	if(isset($_GET['chr_data'])){$sql.=" AND ch_data >= '".$fn->data_usa($_GET['chr_data'])."'";}
	if(isset($_GET['chr_dataf'])){$sql.=" AND ch_data <= '".$fn->data_usa($_GET['chr_dataf'])."'";}
	$sql.=" ORDER BY b.usu_cod ASC";
	*/
	$rs->FreeSql($sql);
	//echo $rs->sql;
	//print_r($_GET);
	//echo $_SESSION['classe'];
	if($rs->linhas==0):
	echo "<tr><td colspan=6> Nenhuma solicita&ccedil;&atilde;o...</td></tr>";
	else:
		while($rs->GeraDados()){?>
			<tr>
				<td><?=$rs->fld("Colab");?></td>
				<td><?=$fn->data_hbr($rs->fld("desc_data"));?></td>
				<td><?=number_format($rs->fld("desc_horas"),2,",",".");?></td>
				<td class="hidden-xs"><?=$rs->fld("aprov");?></td>
				<td class="hidden-xs"><?=$rs->fld("desc_obs");?></td>
				<td>
					<a href="desc_comprov.php?colid=<?=$rs->fld("desc_colab");?>"
					class="btn btn-sm btn-info"
					data-toggle='tooltip' 
					data-placement='bottom' 
					title='Comprovante' ><i class="fa fa-print"
					target="_blank"></i></a>
				</td>
	
			</tr>
		<?php 
		}
		echo "<tr><td colspan=6><strong>".$rs->linhas." Apontamentos</strong></td></tr>";
	endif;		
	
	?>
</table>
<script>
 /*------------------------|INICIA TOOLTIPS E POPOVERS|---------------------------------------*/
	

	setTimeout(function(){
		//$("#slc").load("vis_controlehora.php");		
		$("#alms").load(location.href+" #almsg");
	 },10500);

	
</script>
<script src="<?=$hosted;?>/js/action_triang.js"></script>
<script src="<?=$hosted;?>/js/functions.js"></script>
