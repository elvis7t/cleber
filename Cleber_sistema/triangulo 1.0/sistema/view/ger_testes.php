<?php
/*----------------------------------------------------------------------\
|	index.php															|
|	Armazena informações da página inicial								|
\----------------------------------------------------------------------*/
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
						<small>Por Liferrara<sup>TM</sup> - Gerenciamento</small>
					</h1>
					<ol class="breadcrumb">
						<li>
							<i class="fa fa-home"></i>  <a href="<?=$hosted;?>"><?=$hosted;?></a>
						</li>
						<li>
							<i class="fa fa-graduation-cap"></i> <a href="<?=$links['testes'];?>"><?=$sessao;?></a>
						</li>
						<li class="active">
							Gerenciar Testes
						</li>
					</ol>
				</div>
			</div><!-- /.row -->
			<div class="row">
				<?if ($_SESSION['classe']=="admin"){?>
					<div class="panel panel-info">
						<div class="panel-heading"><h5>Novo Teste:</div>
						<div class="panel-body">
							<form id="form1" method="POST">
								<div class="input-group form-group col-lg-4">
									<span class="input-group-addon" id="addon0"><small>Nome: </small></span>
									<input type="text" class="form-control input-sm" name="tesNome" id="tesNome" placeholder="Nome do Teste:" aria-describedby="addon0">
								</div>
								
								<div class="input-group form-group col-lg-6">
									<span class="input-group-addon" id="addon0"><small>Descri&ccedil;&atilde;o: </small></span>
									<input type="text" class="form-control input-sm" name="tesDesc" id="tesDesc" placeholder="Descri&ccedil;&atilde;o do Teste:" aria-describedby="addon0">
								</div>
								
								<div class="input-group form-group col-lg-6">
									<span class="input-group-addon" id="addon0"><small>Icone: </small></span>
									<div class="form-control" aria-describedby="addon0"> 
										<? require_once("../config/testecfg.php");
										foreach($icon as $ico){
										?>
										<label class="radio-inline">
											<input type="radio" name="optIcon" id="optIcon" value="<?=$ico;?>"><i class="<?=$ico;?>"></i>
										</label>
										<?}?>
									</div>
								</div>
								
								<div class="input-group form-group col-lg-6">
									<input type="hidden" name="tesAdm" id="tesAdm" value="<?=$_SESSION['nome'];?>">
									<button type="button" id="env_teste" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Gravar</button>
								</div>
								<div id="msn" class="hide"></div>
								<div id="loading" class="hide">
									<i class="fa fa-spinner fa-3x fa-spin"></i>
								</div>
								
							</form>
						</div>
						
					</div>
					
				<?}?>
				<div class="panel panel-info" id="testes">
					<div class="panel-heading"><h5>Incluir nos testes ativos:</div>
					<div class="panel-body">
						<?
						$rs_teste = new recordset;
						$rs_teste->Seleciona("*","Testes_Pers","tes_ativo IN(0,1)");
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
								<a href="<?=$links['cfg_testes'];?>?teste=<?=$rs_teste->fld("tes_cod");?>">
									<div class="panel-footer">
										<span class="pull-left">Configurar Teste</span>
										<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
										<div class="clearfix"></div>
									</div>
								</a>
								</div>
							</div>
						<?}?>
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
	