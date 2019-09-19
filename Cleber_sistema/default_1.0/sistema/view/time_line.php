<?php
require_once("../class/class.dashboard.php");
require_once("../class/class.functions.php");
$dash = new dashboard();
$datas = new dashboard();
$func = new functions();

if($func->is_set($_SESSION['usu_cod'])){
	$user = $_SESSION['usu_cod'];
}
else {$user=0;}
/* Faz uma pesquisa de DATAS, para separar o conteudo da linha do tempo */
$arr = array();
$datas->Seleciona("tem_data","ltempo","tem_id > 0",""," tem_data DESC");
/* Se houverem datas, as coloca num array para pesquisar futuramente */
if($datas->linhas >0){
	while($datas->GeraDados()){
		if(!(in_array($datas->fld("tem_data"), $arr))){
			$arr[] = $datas->fld("tem_data");
		}
	}
}
/* Verifica o tamanho do Array e, se tiverem objetos, escreve-os na linha do tempo */
if(sizeof($arr)> 0) {
	for($i=0; $i<sizeof($arr); $i++){
		$sql = "SELECT * FROM ltempo
				JOIN usuarios ON tem_usu_id = usu_cod
				WHERE tem_data = '".$arr[$i]."' AND tem_usu_id=".$user." ORDER BY tem_hora DESC LIMIT 8";
		$dash->FreeSql($sql);
		if($dash->linhas > 0){
			$dash->GeraDados();?>
				<ul class="timeline">
				<!-- timeline time label -->
		    		<li class="time-label">
		        		<span class="bg-red">
		            		<?= $func->data_br($dash->fld("tem_data"));?>
		        		</span>
		    		</li>
		    		<!-- /.timeline-label -->
		
		    		<!-- timeline item -->
		    		<?
						$dash->FreeSql($sql);
		    			while ($dash->GeraDados()){?>
		    				<li>
				        		<!-- timeline icon -->
				        		<i class="<?=$dash->fld("tem_icone")." ".$dash->fld("tem_cor");?>"></i>
				        		<div class="timeline-item">
				            		<span class="time"><i class="fa fa-clock-o"></i> <?=$func->calc_dh($dash->fld("tem_hora"));?></span>
				            		<h3 class="timeline-header"><a href="#"><?=$dash->fld("usu_nome");?></a> <?=$dash->fld("usu_email");?></h3>
						            <div class="timeline-body">
										<?=$dash->fld("tem_desc");?>
				            		</div>
									<!-- IF WILL BE NEEDED
									<div class="timeline-footer">
				                		<a class="btn btn-primary btn-xs">...</a>
				            		</div>
									-->
				        		</div>
				    		</li>
				    		<!-- END timeline item -->		
		    			<?}
		    		?>		
				</ul>
		<?php }
	}
}
?>