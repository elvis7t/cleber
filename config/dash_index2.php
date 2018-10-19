<?php
error_reporting(E_ALL & E_NOTICE & E_WARNING);
session_start("portal");
require_once("../class/class.dashboard.php");

$count = new dashboard();
$classe = $_SESSION['classe'];
/*
echo $classe;
if($classe <=2 OR $classe >=8){$n = 7;}
else {$n = 6;}
*/
$n =  sizeof($count->niveis[$classe]);// Conta os elementos dentro do contador para a classe
?>
<!-- Main content -->
		<!-- Small boxes (Stat box) 
			<div class="col-md-3 col-sm-6 col-xs-12">
              	<div class="info-box bg-aqua">
                	<span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>
                	<div class="info-box-content">
                  		<span class="info-box-text">Bookmarks</span>
                  		<span class="info-box-number">41,410</span>
                  		<div class="progress">
                    		<div class="progress-bar" style="width: 70%"></div>
                  		</div>
                  		<span class="progress-description">
                    		70% Increase in 30 Days
                  		</span>
                	</div>
              	</div>
            </div>
		-->
        <div class="row">
        <?php
        	for($i=1; $i<=$n; $i++):?>
				<div class="col-lg-<?=$count->niveis[$classe][$i]["tam"];?> col-xs-6">
					<div class="info-box <?=$count->niveis[$classe][$i]["cor"];?>">
						<span class="info-box-icon"><i class="<?=$count->niveis[$classe][$i]["ico"];?>"></i></span>
						<div class="info-box-content">
							<span class="info-box-text"><?=$count->niveis[$classe][$i]["sub"];?></span>
							<span class="info-box-number"><?=$count->quadro($classe,$i);?></span>
							<div class="progress">
	                    		<div class="progress-bar" style="width: 100%"></div>
	                  		</div>
	                  		<span class="progress-description">
	                    		
	                  		</span>
						</div>
					</div>
				</div>
				
	    <?php endfor; ?>
<script>
setTimeout(function(){
	$("#alms").load(location.href+" #almsg");
	$("#counters").load("../config/dash_index2.php");		
 },7500);


</script>
            