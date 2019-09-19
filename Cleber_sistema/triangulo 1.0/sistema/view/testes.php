<?php
/*----------------------------------------------------------------------\
|	index.php															|
|	Armazena informações da página inicial								|
\----------------------------------------------------------------------*/
session_start();
$sessao = "Testes";
require_once("../config/menu.php");
require_once("../config/valida.php");
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
						<li class="active">
							<i class="fa fa-graduation-cap"></i> <?=$sessao;?>
						</li>
					</ol>
				</div>
			</div><!-- /.row -->
			<div class="row">
				<?if ($_SESSION['classe']=="admin"){?>
					<div class="wrapper">
						<a href="<?=$links['ger_testes'];?>" class="btn btn-success btn-sm" id="novo"><i class="fa fa-wrench"></i> Configurar Testes</a>
					</div>
					<br>
				<?}?>
				<div class="panel panel-info">
					<div class="panel-heading"><h5>Testes Ativos</div>
					<div class="panel-body">
						<?
						$rs_teste = new recordset;
						$tr = array("0");
						$rs_teste->Seleciona("rus_teste_cod","Result_users","rus_user='".$_SESSION['usuario']."'");
						while($rs_teste->GeraDados()){
							$tr[] = $rs_teste->fld("rus_teste_cod");
						}
						foreach($tr as $vr){
							$testes.= $vr . ", ";
						}
						$testes = substr($testes,0,-2);
						//echo $testes;
						$rs_teste->Seleciona("*","Testes_Pers","tes_ativo=1 AND tes_cod NOT IN(".$testes.")");
						if($rs_teste->linhas >0){
						while($rs_teste->GeraDados()){?>
							<div class="col-lg-3 col-md-6">
								<div class="panel panel-primary">
									<div class="panel-heading">
										<div class="row">
											<div class="col-xs-3">
											<i class="<?=$rs_teste->fld("tes_icone")?> fa-5x"></i>
										</div>
										<div class="col-xs-9 text-right">
											<div class="huge"><h4><?=htmlentities($rs_teste->fld("tes_nome"));?></h4></div>
											<div><small>Por: </small><?=$rs_teste->fld("tes_cadpor");?></div>
										</div>
									</div>
								</div>
								<a href="<?=$links['maketest'];?>?teste=<?=$rs_teste->fld("tes_cod");?>">
									<div class="panel-footer">
										<span class="pull-left">Realizar Teste</span>
										<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
										<div class="clearfix"></div>
									</div>
								</a>
								</div>
							</div>
						<?
						}
						} else{//Teste ja foi feito
						?>
						<div class="alert alert-danger">N&atilde;o existem testes para serem feitos</div>
						<?}
						
						?>
					</div>
				</div><!-- /panel-->
			</div><!-- /.row -->
			<div class="row">
				<div class="panel panel-success">
					<div class="panel-heading"><h5>Testes Realizados</div>
					<div class="panel-body">
						<?
						$sql = "SELECT * FROM Testes_Pers
								JOIN Result_users ON Result_users.rus_teste_cod = Testes_Pers.tes_cod
								WHERE Testes_Pers.tes_ativo = 1 AND Result_users.rus_user = '".$_SESSION['usuario']."'";
						$rs_teste->FreeSQL($sql);
						
						if($rs_teste->linhas == 0){?>
						<div class="alert alert-danger">
							N&aacute;o h&aacute; testes realizados pelo seu usu&aacute;rio...
						</div>
						<?}
						else{
						while($rs_teste->GeraDados()){?>
							<div class="col-lg-3 col-md-6">
								<div class="panel panel-info">
									<div class="panel-heading">
										<div class="row">
											<div class="col-xs-3">
											<i class="<?=$rs_teste->fld("tes_icone")?> fa-5x"></i>
										</div>
										<div class="col-xs-9 text-right">
											<div class="huge"><h4><?=htmlentities($rs_teste->fld("tes_nome"));?></h4></div>
											<div><small>Por: </small><?=$rs_teste->fld("tes_cadpor");?></div>
										</div>
									</div>
								</div>
								<form id="form<?=$rs_teste->fld("rus_teste_cod");?>" method="POST" action="resultado_teste.php">
								<input type="hidden" name="testes" value="<?=$rs_teste->fld("rus_teste_cod");?>">
								<input type="hidden" name="pontos" value="<?=$rs_teste->fld("rus_valor");?>">
								<input type="hidden" name="usuario" value="<?=$rs_teste->fld("rus_user");?>">
								</form>
								<a href="javascript:form<?=$rs_teste->fld("rus_teste_cod");?>.submit();">
									<div class="panel-footer">
										<span class="pull-left">Ver Seu Resultado</span>
										<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
										<div class="clearfix"></div>
									</div>
								</a>
								</div>
							</div>
						<?}
						}?>
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
	