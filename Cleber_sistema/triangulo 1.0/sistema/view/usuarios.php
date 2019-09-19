<?php
/*---------------------------------------------------------*\
|	usuarios.php											|
	Exibe os dados de usuarios e cadastra novos usuarios	|
|															|
\*---------------------------------------------------------*/
$sessao="Usuarios";
require_once("../config/menu.php");
?>
<div class="container-fluid">
	<!-- Page Heading -->
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">
				Usu&aacute;rios
				<small>Cadastro e gerenciamento de usu&aacute;rios</small>
			</h1>
			<ol class="breadcrumb">
				<li>
					<i class="fa fa-home"></i>  <a href="<?=$hosted;?>"><?=$hosted;?></a>
				</li>
				<li class="active">
					<i class="fa fa-user"></i> <?=$sessao;?>
				</li>
			</ol>
		</div>
	</div>
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-4">
			<div class="panel panel-default">
				<div class="panel-heading">Login</div>
				<div class="panel-body">
					<div class="col-lg-12">
						<div class="row">
							<form method="POST" id="form0">
								<div class="form-group input-group">
									<span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
									<input type="text" class="form-control"placeholder="Username" name="pnome" id="pnome">
								</div>
									
								<div class="form-group input-group">
									<span class="input-group-addon"><i class="fa fa-key"></i></span>
									<input type="password" class="form-control" placeholder="Senha" name="psenha" id="psenha">
								</div>
									
								<div class="form-group">
									<button type="reset" id="limpar" class="btn btn-danger"><i class="fa fa-eraser"></i> Limpar</button>
									<button type="button" id="btn_login" class="btn btn-success"><i class="fa fa-plane"></i> Entrar</button>
								</div>
							</form>
								
						</div>
					</div>		
				</div><!--/panel-body-->
			</div><!--/panel-->
		</div><!-- /col-->
		<div class="col-lg-1">
		</div><!-- /col-->
		
		<div class="col-lg-8">
			<div class="panel panel-default">
				<div class="panel-heading">Novos Usu&aacute;rios</div>
					<div class="panel-body">
						<form method="POST" class="form">
							<div class="input-group form-group">
								<span class="input-group-addon" id="basic-addon1"><i class="fa fa-user"></i></span>
								<input type="text" id="nome" name="nome" class="form-control input-sm" placeholder="Seu Nome" aria-describedby="basic-addon1">
							</div>
							<div class="form-inline">
								<div class="input-group form-group col-xs-3">
									<span class="input-group-addon" id="basic-addon2"><i class="fa fa-building"></i></span>
									<input id="cep" name="cep" type="text" class="form-control input-sm" placeholder="Cep" aria-describedby="basic-addon2">
								</div>	
								<div class="input-group form-group col-xs-5">
									<input id="rua" name="rua" type="text" class="form-control input-sm" placeholder="Rua/Av" aria-describedby="basic-addon2">
								</div>	
								<div class="input-group form-group col-xs-1">
									<input id="num" name="num" type="text" class="form-control input-sm" placeholder="Nº" aria-describedby="basic-addon2">
								</div>
								<div class="input-group form-group col-xs-2">
									<input id="cpl" name="cpl" type="text" class="form-control input-sm" placeholder="Compl" aria-describedby="basic-addon2">
								</div>
							</div>
							<br>
							<div class="form-inline">
								<div class="input-group form-group col-xs-5">
									<input id="bairro" name="bairro" type="text" class="form-control input-sm" placeholder="Bairro" aria-describedby="basic-addon2">
								</div>	
								<div class="input-group form-group col-xs-4">
									<input id="cid" name="cid" type="text" class="form-control input-sm" placeholder="Cidade" aria-describedby="basic-addon2">
								</div>	
								<div class="input-group form-group col-xs-2">
									<input id="est" name="est" type="text" class="form-control input-sm" placeholder="Estado" aria-describedby="basic-addon2">
								</div>
							</div>
							<br>
							<div class="form-inline">
								<div class="input-group form-group col-xs-5">
									<span class="input-group-addon" id="basic-addon2"><i class="fa fa-phone"></i></span>
									<input id="tel" name="tel"  type="text" class="form-control input-sm tel" placeholder="telefone" aria-describedby="basic-addon2">
								</div>
								<div class="input-group form-group col-xs-1"></div>
								<div class="input-group form-group col-xs-5">
									<span class="input-group-addon" id="basic-addon2"><i class="fa fa-whatsapp"></i></span>
									<input id="cel" name="cel" type="text" class="form-control input-sm cel" placeholder="celular" aria-describedby="basic-addon2">
								</div>
							</div>
							<br>
							<div class="form-inline">
								<div class="input-group form-group col-xs-5">
									<span class="input-group-addon" id="basic-addon3"><i class="fa fa-user-plus"></i></span>
									<input id="user" name="user"  type="text" class="form-control input-sm" placeholder="usuário" aria-describedby="basic-addon3">
								</div>
								<div class="input-group form-group col-xs-1"></div>
								<div class="input-group form-group col-xs-5">
									<span class="input-group-addon" id="basic-addon4"><i class="fa fa-user-secret"></i></span>
									<input id="senha" name="senha" type="password" class="form-control input-sm" placeholder="senha" aria-describedby="basic-addon4">
								</div>
								<br>
								<br>
								<div class="form-group">
									<button type="reset" class="btn btn-danger btn-sm"><i class="fa fa-eraser"></i> Limpar</button>
									<button type="button" id="envia_modal" class="btn btn-success btn-sm"><i class="fa fa-send"></i> Enviar</button>
								</div>									
							</div>
						</form>
				
					<div id='confirm' class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
						<div class="modal-dialog modal-sm">
							<div class="modal-content">
								<div class="modal-header">
									<h4 class="modal-title" id="exampleModalLabel">Deseja incluir este usuário?</h4>
								</div>
								<div class="modal-body">
									<button type="reset" id="limpar" data-dismiss="confirm" class="btn btn-danger"><i class="fa fa-eraser"></i> Cancelar</button>
									<button type="button" id="envia" class="btn btn-success"><i class="fa fa-plane"></i> Sim</button>
								</div>
							</div>
						</div>
					</div>
				</div><!--/panel-body-->
			</div><!--/panel-->
		</div><!--/col-->
	</div><!-- /row-->
	<div class="row">
		<div id="loading" class='hide'>
			<i class="fa fa-spinner fa-3x fa-spin"></i>
		</div>
		<div class="hide" id="msn">
		</div>
	</div><!--/row-->
	</div><!--/row-->
</div><!-- /.container-fluid -->
	</div><!-- /#page-wrapper -->
</div><!-- /#wrapper -->


</body>

</html>
	