<?php
/*---------|INDEX.PHP|---------------------*\
| @author:	Cleber Marrara Prado
| @contact:	cleber.marrara.prado@gmail.com
| @version:	1.0
| @date:	06-20-2016
\*-----------------------------------------*/
// Requires all main pages to make it works
require_once("config/main.php");
require_once("config/menu_top.php");
?>
<!-- CARROSSEL DE IMAGENS -->
<div class="container-fluid">
	<section id="content">
		<div class="row">
			<div class="col-md-7">
				<div id="carousel-example-generic" class="carousel slide carousel-fade" data-ride="carousel">
					<!-- Indicators -->
					<ol class="carousel-indicators">
						<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
						<li data-target="#carousel-example-generic" data-slide-to="1"></li>
					</ol>

					<!-- Wrapper for slides -->
					<div class="carousel-inner" role="listbox">
						<div class="item active">
							<img src="<?=$hosted;?>/str/images/desert.jpg" alt="...">
							<div class="carousel-caption">
							...
							</div>
						</div>
						<div class="item">
							<img src="<?=$hosted;?>/str/images/city.jpg" alt="...">
							<div class="carousel-caption">
							...
							</div>
						</div>

					</div>

					<!-- Controls -->
					<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
						<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
						<span class="sr-only">Previous</span>
					</a>
					<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
						<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
						<span class="sr-only">Next</span>
					</a>
				</div>
			</div>
			<div class="col-md-5">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">PQEC 2016</h3>
					</div><!-- /.box-header -->
					<div class="panel-body">
						<img src="<?=$hosted;?>/str/images/pqec.png" class="img-responsive thumbnail">
					    <p>O PQEC é um Programa das Empresas Contábeis desenvolvido pelo Sescon-DF e o Instituto SESCON comprometido com a ética e a qualidade dos serviços prestados pelos seus associados.
					    <a href="#" class="btn btn-xs btn-primary">Ler mais...</a>
					    </p>
					</div>
					
				</div>
			</div>
		</div>

	</section>
	<section id="quemsomos">

	</section>
</div>



<script type="text/javascript" src="<?=$hosted;?>/str/js/jquery-latest.min.js"></script>
<script type="text/javascript" src="<?=$hosted;?>/str/assets/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		//$(".carousel").carousel();
	});
</script>
