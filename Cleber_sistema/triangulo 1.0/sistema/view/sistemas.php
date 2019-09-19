<?php
/*----------------------------------------------------------------------\
|	index.php															|
|	Armazena informações da página inicial								|
\----------------------------------------------------------------------*/
$sessao = "Sistemas";
$drops = "tecs";
require_once("../config/menu.php");
?>
<div class="container-fluid">
			<!-- Page Heading -->
			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">
						Sistemas
						<small>Plataformas WEB de Gerenciamento</small>
					</h1>
					<ol class="breadcrumb">
						<li>
							<i class="fa fa-home"></i>  <a href="<?=$hosted;?>"><?=$hosted;?></a>
						</li>
						<li class="active">
							<i class="fa fa-suitcase"></i> <?=$sessao;?>
						</li>
					</ol>
				</div>
			</div>
			<!-- /.row -->
			<div class="row">
									
			</div>
			<!-- /.row -->
		</div>
		<!-- /.container-fluid -->

	</div>
	<!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<!-- jQuery -->
<script src="js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

</body>

</html>
	