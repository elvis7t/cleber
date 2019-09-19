<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start();
require_once("../config/main.php");
require_once("../model/recordset.php");
require_once("../class/class.functions.php");
$rs_rel = new recordset();
?>
	<body onload="window.print();">
		<div class="wrapper">
			<!-- Main content -->
			<section class="invoice">
				<!-- title row -->
				<img class="img-responsive" src="<?=$hosted."/".$rs_rel->pegar("sys_logo","sistema","sys_id=2");?>" width="100px" align="left"/>
				<img class="img-responsive" src="<?=$hosted."/images/selo.jpg";?>" width="100px" align="right"/>
				<div class="row">
				  <div class="col-xs-12">
					<h2 class="page-header">
						<?=$rs_rel->pegar("emp_nome","empresas","emp_cnpj = '".$_SESSION['usu_empresa']."'");?>
						<small class="pull-right">Data: <?=date("d/m/Y");?></small>
					</h2>
				  </div><!-- /.col -->
				</div>
				<!-- info row -->
				<div class="row invoice-info">
					<div class="col-sm-4 invoice-col">
						Usu&aacute;rio
						<address>
							<strong><?=$_SESSION['nome_usu'];?></strong><br>
							<i class="fa fa-envelope"></i> <?=$_SESSION['usuario'];?>
						</address>
					</div><!-- /.col -->
				</div><!-- /.row -->

				<!-- Table row -->
				<div class="row">
					<div class="col-xs-12 table-responsive">
						<table class="table table-striped" id="empr">
							<tr>
								<th>#</th>
								<th>Empresa</th>
								<th class="hidden-xs">Regi&atilde;o</th>
								<th>Telefone</th>
								<th class="hidden-xs">Falar com</th>
								<th>Utiliza DA?</th>
								
							</tr>	
							<?php
							$hide="";
							$sql = "SELECT * FROM tri_clientes WHERE emp_vinculo={$_SESSION["sys_id"]}";
							//if(isset($_GET['cod']) AND $_GET['cod']<>""){$sql.=" AND cod=".$_GET['cod'];}
							if(isset($_GET['da']) AND $_GET['da']<>""){
								$sql.=" AND uda=".$_GET['da'];
								$hide="hide";
							}
							if($_SESSION['classe']<>1){$sql.=" AND carteira LIKE '%\"".$_SESSION['dep']."\":{\"user\":\"".$_SESSION['usu_cod']."\"%'";}

							$sql.= " ORDER BY apelido ASC, ativo DESC";
							$rs_rel->FreeSql($sql);
							//echo $rs_rel->sql;
							if($rs_rel->linhas==0):
							echo "<tr><td colspan=7> Nenhuma solicita&ccedil;&atilde;o...</td></tr>";
							else:
								while($rs_rel->GeraDados()){
								?>
									<tr>
										<td><?=$rs_rel->fld("cod");?></td>
										<td class="text-capitalize"><?=$rs_rel->fld("apelido");?></td>
										<td class="hidden-xs"><?=$rs_rel->fld("regiao");?></td>
										<td><?=$rs_rel->fld("telefone");?></td>
										<td class="hidden-xs"><?=$rs_rel->fld("responsavel");?></td>
										<td><?=($rs_rel->fld("uda")==1?"Sim":"Não");?></td>
										<td class="<?=$hide;?>">
											<a class='btn btn-xs btn-success' href="clientes.php?token=<?=$_SESSION['token']?>&clicod=<?=$rs_rel->fld('cod')?>">
											<i class='fa fa-magic'></i> Ativar</a>
											<a class="btn btn-xs btn-danger" data-toggle='tooltip' data-placement='bottom' title='Excluir' href="javascript:del(<?=$rs_rel->fld('cod');?>,'excEmpresa','a empresa');"><i class="fa fa-trash"></i></a>
										</td>
									</tr>
								<?php  
								}
								echo "<tr><td colspan=7><strong>".$rs_rel->linhas." Cliente(s) Encontrado(s)</strong></td></tr>";
							endif;		
							?>
						</table>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</section><!-- /.content -->
		</div><!-- ./wrapper -->

		<!-- AdminLTE App -->
   		<script src="<?=$hosted;?>/assets/dist/js/app.min.js"></script>
		<script src="<?=$hosted;?>/assets/plugins/datatables/jquery.dataTables.min.js"></script>
		<script src="<?=$hosted;?>/assets/plugins/datatables/dataTables.bootstrap.min.js"></script> 
	</body>
</html>
