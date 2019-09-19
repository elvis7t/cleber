
<?php
	session_start();
	require_once("../model/recordset.php");
	require_once("../class/class.functions.php");
	date_default_timezone_set("America/Sao_Paulo");
	require_once('../class/class.permissoes.php');
	$per = new permissoes();

	$fn = new functions();
	$rs = new recordset();
	$rs2 = new recordset();

	
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
	<table class="table table-striped">
		<tr>
			<th>Empresa</th>
			<th class="hidden-xs">Telefone</th>
			<th class="hidden-xs">Falar com</th>
			<th class="hidden-xs">Solicitado Por</th>
			<th class="hidden-xs">Ramal</th>
			<th class="hidden-xs">Realizado Por</th>
			<th>Status</th>
			<th>A&ccedil;&otilde;es</th>
		</tr>	
<?php

	$conp = $per->getPermissao("vertodassolic", $_SESSION['usu_cod']);
	$sql = "SELECT sol.*, a.usu_nome, a.usu_ramal, st_desc FROM tri_solic sol
		JOIN codstatus 
			ON sol_status = st_codstatus 
		JOIN usuarios a 
			ON a.usu_cod= sol.sol_por";
				
	if($conp['C'] == 0){
		$sql.=" WHERE sol_por=".$_SESSION['usu_cod']." AND sol_empcod = ".$_SESSION['usu_empcod'];
	}
	else{
		$sql.=" WHERE sol_cod<>0 AND sol_empcod = ".$_SESSION['usu_empcod'];
	}
		
	$sql.=" AND sol_data BETWEEN '".date("Y-m-d")."' AND '".date("Y-m-d")." 23:59:59' ORDER BY sol_status, sol_data DESC";
	$rs->FreeSql($sql);
	//echo $rs->sql;
	/*
	echo $sql;
	echo "<pre>";
	print_r($_SESSION);
	echo "</pre>";
	*/
	if($rs->linhas==0):
	echo "<tr><td colspan=7> Nenhuma solicita&ccedil;&atilde;o...</td></tr>";
	else:
		while($rs->GeraDados()){
			$nm_emp = explode(" ", $rs->fld("sol_emp"));?>
			<tr>
				<td><span data-toggle='tooltip' data-placement='bottom' title='<?=$rs->fld("sol_emp");?>'><?=(strlen($rs->fld("sol_emp"))>15 ? $nm_emp[0]:$rs->fld("sol_emp"));?></span></td>
				<td class="hidden-xs"><?=$rs->fld("sol_tel");?></td>
				<td class="hidden-xs"><span data-toggle='tooltip' data-placement='bottom' title='<?=$rs->fld("sol_fcom");?>'><?=(strlen($rs->fld("sol_fcom"))>15 ? substr($rs->fld("sol_fcom"),0,15)." ...":$rs->fld("sol_fcom"));?></span></td>
				<td class="hidden-xs"><?=$rs->fld("usu_nome");?></td>
				<td class="hidden-xs"><?=$rs->fld("usu_ramal");?></td>
				<td class="hidden-xs"><?=$rs2->pegar("usu_nome","usuarios","usu_cod=".$rs->fld("sol_real_por"));?></td>
				<td><?=$rs->fld("st_desc");?>
					<small>
						<?php
							if($rs->fld("sol_status") != 99){echo "(".$fn->calc_dh($rs->fld("sol_data")).")";}
							else{echo "(Em ".$fn->data_hbr($rs->fld("sol_datareal")).")";}
						?>
					</small>
				</td>
				<td class="">
				<?php if($rs->fld("sol_status")<>99):
					if($rs->fld("sol_status")<>97):?>
						<a class='btn btn-xs btn-primary' data-toggle='popover' data-trigger="hover" data-placement='auto bottom' data-content="<?=$rs->fld("sol_obs");?>" title='Solicitante: <?=$rs->fld("usu_nome");?>'><i class='fa fa-book'></i> </a>
						<?php 
							/*--------|ALTERAÇÃO - 27/10/2016|-----------------*\
							|	Incluído o SESSION['classe'] = 8 na condição 	|
							|	Cleber Marrara Prado 							|
							|	cleber.marrara.prado@gmailcom					|
							\*-------------------------------------------------*/
							if($conp['A']==1):?>
							<a class='btn btn-xs btn-success alink' 			data-action="OK" data-solic="<?=$rs->fld("sol_cod");?>" data-toggle='tooltip' data-placement='bottom' title='OK'><i class='fa fa-bell'></i> </a>
							<a class='btn btn-xs btn-info hidden-sm alink' 	 	data-action="RE" data-solic="<?=$rs->fld("sol_cod");?>" data-toggle='tooltip' data-placement='bottom' title='Reagendar'><i class='fa fa-calendar'></i> </a>
							<a class='btn btn-xs btn-warning hidden-sm alink' 	data-action="AG" data-solic="<?=$rs->fld("sol_cod");?>" data-toggle='tooltip' data-placement='bottom' title='Aguardar'><i class='fa fa-hourglass-half'></i> </a>
						<?php endif;?>
						<a class='btn btn-xs btn-danger hidden-sm alink'	data-action="CN" data-solic="<?=$rs->fld("sol_cod");?>" data-toggle='tooltip' data-placement='bottom' title='Cancelar'><i class='fa fa-calendar-times-o'></i> </a>
					<?php else: ?>
						<a class='btn btn-xs btn-primary hidden-sm alink'	 data-action="RT" data-solic="<?=$rs->fld("sol_cod");?>" data-toggle='tooltip' data-placement='bottom' title='Reativar'><i class='fa fa-hourglass'></i> </a>
						<?php endif; 
						else :?>
					<a class='btn btn-xs btn-primary' data-toggle='popover' data-trigger="hover" data-placement='auto right' data-content="<?=$rs->fld("sol_obs");?>" title='Solicitante: <?=$rs->fld("usu_nome");?>'><i class='fa fa-book'></i> </a>
					<a class='btn btn-xs btn-warning hidden-sm alink'	 data-action="RP" data-solic="<?=$rs->fld("sol_cod");?>" data-toggle='tooltip' data-placement='bottom' title='Refazer'><i class='fa fa-reply'></i> </a>
					<?php endif; ?>
				</td>
			</tr>
		<?php  
		}
		echo "<tr><td colspan=7><strong>".$rs->linhas." Liga&ccedil;&otilde;es Solicitadas</strong></td></tr>";
	endif;
	/* DEBUG	
	echo "<pre>";
	print_r($_SESSION);
	echo "</pre>";
	*/
	?>
</table>
<script src="<?=$hosted;?>/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="<?=$hosted;?>/js/functions.js"></script>
<script type="text/javascript">
// Atualizar a cada 10 segundos
	 
	

	 /*------------------------|INICIA TOOLTIPS E POPOVERS|---------------------------------------*/
		$(function () {
			$('[data-toggle="tooltip"]').tooltip();
			$('[data-toggle="popover"]').popover({
		        html:true
		    });
		});
		setTimeout(function(){
			$("#slc").load("vis_solic.php");		
		 },7500);

	

</script>


			