<?php
/*----------------------------------------------------------------------\
|	index.php															|
|	Armazena informações da página inicial								|
\----------------------------------------------------------------------*/
$sessao = "Perfil";
require_once("../config/menu.php");
require_once("../config/valida.php");
?>
<div class="container-fluid">
			<!-- Page Heading -->
			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">
						Perfil
						<small>do usu&aacute;rio</small>
					</h1>
					<ol class="breadcrumb">
						<li>
							<i class="fa fa-home"></i>  <a href="<?=$hosted;?>"><?=$hosted;?></a>
						</li>
						<li class="active">
							<i class="fa fa-wrench"></i> <?=$sessao;?>
						</li>
					</ol>
				</div>
			</div>
			<!-- /.row -->
			<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-primary">
							<div class="panel-heading"><h5>Perfil: <?=$_SESSION['nome']." [".$_SESSION['usuario']."]";?></h5></div>
							<div class="panel-body">
								<?
								$sql = "SELECT * FROM usuarios JOIN clientes ON cli_user = usu_user WHERE usu_user='".$_SESSION['usuario']."'";
								//echo $sql;
								$rs->FreeSQL($sql);
								$rs->GeraDados();
								?>
								<div class="col-lg-6">
									<div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/100x100" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading"><strong> <?=$rs->fld("cli_nome");?></strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-user"></i> <?=$rs->fld("usu_user");?></p>
                                        <p> 
											<?
												echo $rs->fld("cli_rua").", ".$rs->fld("cli_num")." ".$rs->fld("cli_comp")."<br>";
												echo $rs->fld("cli_bairro")." - ".$rs->fld("cli_cidade")." - ".$rs->fld("cli_est")." - ".$rs->fld("cli_cep")."<br>";
												echo "<i class='fa fa-phone'></i>" .$rs->fld("cli_tel")." | <i class='fa fa-whatsapp'></i>".$rs->fld("cli_cel");
												
											?>
										</p>
                                    </div>
                                </div>
									
								</div>
								
							</div>
						</div><!-- /panel-->
					</div>
			
				
			</div>
			<!-- /.row -->
		</div>
		<!-- /.container-fluid -->

	</div>
	<!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->


</body>

</html>
	