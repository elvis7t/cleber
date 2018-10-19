<?php 
session_start();
require_once("../../model/recordset.php");
require_once("../../sistema/class/class.functions.php");

$fna = new functions();
$rsa = new recordset();
$cua = $_SESSION["usu_cod"];
$sql = "SELECT * FROM chat WHERE chat_para = ". $cua ." AND chat_lido = 0";
$rsa->FreeSql($sql);

?>
<li class="dropdown messages-menu">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		<i class="fa fa-envelope-o"></i>
		<?php if ($rsa->linhas > 0): ?>
		<span class="label label-success"><?=$rsa->linhas;?></span>
		<?php endif;?>
	</a>
	<ul class="dropdown-menu">
		<li class="header">Voc&ecirc; tem <?=$rsa->linhas .($rsa->linhas>1?" mensagens":" mensagem");?></li>
		<li>
		<!-- inner menu: contains the actual data -->
			<ul class="menu">
				<li><!-- start message -->
					<a href="#">
						<div class="pull-left">
							<img src="<?=$hosted;?>/sistema/assets/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
						</div>
						<h4>
							Support Team
							<small><i class="fa fa-clock-o"></i> 5 mins</small>
						</h4>
						<p>Why not buy a new awesome theme?</p>
					</a>
				</li><!-- end message -->
				<li>
					<a href="#">
						<div class="pull-left">
							<img src="<?=$hosted;?>/sistema/assets/dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
						</div>
						<h4>
							AdminLTE Design Team
							<small><i class="fa fa-clock-o"></i> 2 hours</small>
						</h4>
						<p>Why not buy a new awesome theme?</p>
					</a>
				</li>
				<!-- Só repetir 
				<li>
				<a href="#">
				<div class="pull-left">
				<img src="<?=$hosted;?>/sistema/assets/dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">
				</div>
				<h4>
				Developers
				<small><i class="fa fa-clock-o"></i> Today</small>
				</h4>
				<p>Why not buy a new awesome theme?</p>
				</a>
				</li>
				<li>
				<a href="#">
				<div class="pull-left">
				<img src="<?=$hosted;?>/sistema/assets/dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
				</div>
				<h4>
				Sales Department
				<small><i class="fa fa-clock-o"></i> Yesterday</small>
				</h4>
				<p>Why not buy a new awesome theme?</p>
				</a>
				</li>
				<li>
				<a href="#">
				<div class="pull-left">
				<img src="<?=$hosted;?>/sistema/assets/dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">
				</div>
				<h4>
				Reviewers
				<small><i class="fa fa-clock-o"></i> 2 days</small>
				</h4>
				<p>Why not buy a new awesome theme?</p>
				</a>
				</li>
				FIM REPETICAO -->
			</ul>
		</li>
		<li class="footer"><a href="#">See All Messages</a></li>
	</ul>
</li>