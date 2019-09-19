<?php
/*----------------------------------------------------------------------\
|	index.php															|
|	Armazena informações da página inicial								|
\----------------------------------------------------------------------*/
session_start();
$sessao = "Testes";
require_once("../config/menu.php");
require_once("../config/valida.php");

$sql = "SELECT * FROM Testes_Pers
		WHERE tes_cod = ".$_GET['teste'];
//echo $sql;
$rs_teste = new recordset;

$rs_teste->FreeSQL($sql);
$rs_teste->GeraDados();
$tes_cod = $rs_teste->fld("tes_cod");
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
							Fazendo o teste [<?=$rs_teste->fld("tes_nome");?>]
						</li>
						
					</ol>
				</div>
			</div><!-- /.row -->
			<div class="row">
				<div class="panel panel-info">
					<div class="panel-heading"><h3>Teste: <?=$rs_teste->fld("tes_nome");?></h3></div>
					<form id="teste" action="resultado_teste.php" method="POST">
					<div class="panel-body" id="tst">
						<?
						$sql = "SELECT * FROM Perguntas_testes WHERE per_tes_cod = ".$_GET['teste'];
						$rs_teste->FreeSQL($sql);
						$qst = $rs_teste->linhas;
						while($rs_teste->GeraDados()){
							$per_cod = $rs_teste->fld("per_cod");?>
							<div class="col-sm-6 col-lg-6">
								<div class="panel panel-primary">
									<div class="panel-heading"><?=$rs_teste->fld("per_desc");?></div>
									<div class="panel-body">
									<select class="input-group" name="optQ<?=$per_cod;?>">
										<option value="0">Selecione...</option>
										<?
											$rs_msg->Seleciona("*","Opc_Perguntas","opc_per_cod =".$per_cod);
											while($rs_msg->GeraDados()){?>
													<option value="<?=$rs_msg->fld("opc_valor");?>">
														<?=$rs_msg->fld("opc_desc");?>
													</option>
											<?}
										?>
									</select>
									</div>
								</div>
							</div>
						<?}?>
                
						
						
						<div class="form-group">
							<input type="hidden" id="pontos" name="pontos" value=""/>
							<input type="hidden" id="testes" name="testes" value="<?=$tes_cod;?>"/>
							<input type="hidden" id="usuario" name="usuario" value="<?=$_SESSION['usuario'];?>"/>
							<button type="reset" class="btn btn-danger btn-sm"><i class='fa fa-eraser'></i> Zerar</button>
							<button id="calcula" disabled type="submit" class="btn btn-success btn-sm"><i class='fa fa-calculator'></i> Resultado</button>
						</div>
						<div class="progress">
							<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
								<span class="sr"></span>
							</div>
						</div>	
					</div>
					</form>
					
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
	