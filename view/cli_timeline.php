<?php
require_once("../model/recordset.php");
require_once("../class/class.dashboard.php");
$dash = new recordset();
$datas = new recordset();
$func = new functions();

if($func->is_set($_SESSION['usu_cod'])){
	$user = $_SESSION['usu_cod'];
}
else {$user=0;}
/* Faz uma pesquisa de DATAS, para separar o conteudo da linha do tempo */
$arr = array();
//$cod = 477;
$datas->Seleciona("log_data","logs_altera","log_id > 0 AND log_cod = ".$cod,""," log_data DESC",2);
/* Se houverem datas, as coloca num array para pesquisar futuramente */
if($datas->linhas >0){
	while($datas->GeraDados()){
		if(!(in_array($datas->fld("log_data"), $arr))){
			$arr[] = $datas->fld("log_data");
		}
	}
}
/* Verifica o tamanho do Array e, se tiverem objetos, escreve-os na linha do tempo */
if(sizeof($arr)> 0) {
	for($i=0; $i<sizeof($arr); $i++){
		$sql = "SELECT * FROM logs_altera
				JOIN usuarios ON log_user = usu_cod
				WHERE log_data = '".$arr[$i]."' AND log_cod=".$cod." ORDER BY log_data DESC, log_datahora DESC";
		$dash->FreeSql($sql);

		if($dash->linhas > 0){
			$dash->GeraDados();?>
				<ul class="timeline">
				<!-- timeline time label -->
		    		<li class="time-label">
		        		<span class="bg-red">
		            		<?= $func->data_br($dash->fld("log_data"));?>
		        		</span>
		    		</li>
		    		<!-- /.timeline-label -->
		
		    		<!-- timeline item -->
		    		<?php
						$dash->FreeSql($sql);
		    			while ($dash->GeraDados()){
		    				$dth = ($dash->fld("log_datahora") ==0?$dash->fld("log_data"):$dash->fld("log_datahora"));
		    				?>
		    				<li>
				        		<!-- timeline icon -->
				        		<i class="<?=$dash->fld("log_icon")." ".$dash->fld("log_cor");?>"></i>
				        		<div class="timeline-item">
				            		<span class="time"><i class="fa fa-clock-o"></i> <?=$func->calc_dh($dth);?></span>
				            		<h3 class="timeline-header"><a href="#"><?=$dash->fld("usu_nome");?></a> <?=$dash->fld("usu_email");?></h3>
						            <div class="timeline-body">
						            	<p class="text-muted">
											<?=$dash->fld("log_acao");?>
						            	</p>
										<?=$dash->fld("log_altera");?>
				            		</div>
									<!-- IF WILL BE NEEDED
									<div class="timeline-footer">
				                		<a class="btn btn-primary btn-xs">...</a>
				            		</div>
									-->
				        		</div>
				    		</li>
				    		<!-- END timeline item -->		
		    			<?php }
		    		?>		
				</ul>
		<?php }
	}
}
?>