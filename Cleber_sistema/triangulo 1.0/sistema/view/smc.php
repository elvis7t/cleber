<?php
/*---------------------------------------------------------*\
|	usuarios.php											|
	Exibe os dados de usuarios e cadastra novos usuarios	|
|															|
\*---------------------------------------------------------*/
$sessao="Smc";
require_once("../config/menu.php");
require_once("../config/smc_config.php");
require_once("../config/valida.php");
?>
<div class="container-fluid">
			<!-- Page Heading -->
			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">
						Desafio Vizir
						<small>Solu&ccedil;&atilde;o para o Show me the Code</small>
					</h1>
					<ol class="breadcrumb">
						<li>
							<i class="fa fa-home"></i>  <a href="<?=$hosted;?>"><?=$hosted;?></a>
						</li>
						<li class="active">
							<i class="fa fa-clock-o"></i> <?=$sessao;?>
						</li>
					</ol>
				</div>
			</div>
			<!-- /.row -->
			<div class="row">
				<div class="panel panel-default">
					 <div class="panel-heading">Simulação FaleMais</div>
					<div class="panel-body">
						<div class="col-lg-3">
							<div class="row">
								<form method="POST" id="form0">
									<div class="form-group input-group">
										<span class="input-group-addon"><i class="fa fa-tag fa-fw"></i></span>
										<select class="form-control"placeholder="origem" name="origem" id="origem">
											<option value="">Escolha a origem da ligação:</option>
											<?
												foreach($tarifas as $valor){?>
												<option value="<?=$valor['valor'];?>"><?="De: ".$valor['origem'] . " para: " . $valor['destino'];?></option>
												<?}
											?>
										</select>
									</div>
									<div class="form-group input-group">
										<span class="input-group-addon"><i class="fa fa-phone-square fa-fw"></i></span>
										<input type="text" class="form-control"placeholder="Minutos da Ligação" name="mins" id="mins">
									</div>
									<div class="form-group input-group">
										<span class="input-group-addon"><i class="fa fa-shopping-cart fa-fw"></i></span>
										<select class="form-control"placeholder="Plano" name="smc_plan" id="smc_plan">
											<option value="">Escolha o plano:</option>
											<?
												foreach($planos as $nome => $valor){?>
												<option value="<?=$valor;?>"><?=$nome;?></option>
												<?}
											?>
										</select>
									</div>
									<div class="form-group">
										<button type="reset" id="limpar" class="btn btn-danger"><i class="fa fa-eraser"></i> Limpar</button>
										<button type="button" id="bt_sim" class="btn btn-success"><i class="fa fa-calculator"></i> Calcular</button>
									</div>
								</form><!-- ./form -->
							</div>
						</div>
						<div class="col-lg-9">
							<h4>Simulações realizadas</h4>
							<div class="table-responsive">
								<table class="table table-hover table-striped small" id="sim0">
									<thead>
										<tr>
											<th>Origem / destino</th>
											<th>Minutos</th>
											<th>Plano escolhido</th>
											<th>Franquia (min)</th>
											<th>com FaleMais</th>
											<th>sem FaleMais</th>
										</tr>
									</thead>
									<tbody>
										
									</tbody>
								</table>
							</div>
						</div><!-- ./col-->
								
					</div><!-- ./row -->
				</div><!-- ./col -->
			</div><!-- ./panelbody -->
				</div><!-- ./panel -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div><!-- /#page-wrapper -->
</div><!-- /#wrapper -->

<!-- jQuery -->
<script src="../bootstrap/bs-admin/js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="../bootstrap/bs-admin/js/bootstrap.min.js"></script>

</body>

</html>