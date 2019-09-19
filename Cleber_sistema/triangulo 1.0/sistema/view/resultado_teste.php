<?php
/*----------------------------------------------------------------------\
|	index.php															|
|	Armazena informações da página inicial								|
\----------------------------------------------------------------------*/
$sessao = "Testes";
require_once("../config/menu.php");
$ts = $_POST['testes'];
$us = $_SESSION['usuario'];
$pt = $_POST['pontos'];
$sql = "SELECT * FROM Result_users
		JOIN Testes_Pers ON rus_teste_cod = tes_cod
		WHERE rus_teste_cod = ".$ts." AND rus_user='".$us."'" ;
//echo $sql;
$rs_teste = new recordset;

$rs_teste->FreeSQL($sql);
$rs_teste->GeraDados();

?>
<div class="container-fluid">
			<!-- Page Heading -->
			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">
						Testes
						<small>Por Liferrara<sup>TM</sup></small>
					</h1>
					<ol class="breadcrumb">
						<li>
							<i class="fa fa-home"></i>  <a href="<?=$hosted;?>"><?=$hosted;?></a>
						</li>
						<li>
							<i class="fa fa-graduation-cap"></i> <?=$sessao;?>
						</li>
						<li class="active">
							Resultado do teste [<?=$rs_teste->fld("tes_nome");?>] para <?=$_SESSION['nome'];?>
						</li>
						
					</ol>
				</div>
			</div><!-- /.row -->
			<div class="row">
				<div class="panel panel-success">
					<div class="panel-heading"><h3>Teste: <?=$rs_teste->fld("tes_nome");?></h3></div>
						<div class="panel-body">
							<div class="row col-lg-6">
								<table class="table table-hover table-stripe table-sm">
									<thead>
										<tr><th>Resultado: (<?=$pt;?> pontos)</th>
									</thead>
									<tbody>
									<? 
									$rs = new recordset;
									$rs->Seleciona("*","Result_Testes","res_tes_cod=".$ts." AND ".$pt." <= res_valomax AND ".$pt.">= res_valormin");
									//echo $rs->sql;
									while($rs->GeraDados()){?>
										<tr>
											
											<td><?=$rs->fld("res_desc");?></td>
										</tr>
									<?}?>											
									</tbody>
								</table>
							</div>
						</div>
				</div><!-- /panel-->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->

	</div><!-- /#page-wrapper -->

</div><!-- /#wrapper -->

<!-- jQuery -->
<script src="js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

</body>

</html>
	