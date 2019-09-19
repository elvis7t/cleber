<?php

/*-------------------------------------------------------------*\
| Menu Principal												|
| @autor: Cleber Marrara Prado <cleber.marrara.prado@gmail.com> |
| @version: 1.0 												|
| @date: 09.19.2016												|
\*-------------------------------------------------------------*/
require_once("../config/main.php");
// Links in array: It can be updated once, here.
$links = array(
	"home" 				=> "home",
	"triangulo"			=> "quemsomos",
	"servicos"			=> "service",
	"parceiros"			=> "Parceiros",
	"news"				=> "Notícias (RSS)",
	"sistema"			=> "Domínio Atendimento",
	"contato"			=> "contatos",
	"phone"				=> "(11)2087-4080",
	"email"				=> "triangulo@triangulocontabil.com.br"
);
?>
	<div id="wrapper">
		<div class="row tri_top">
			<div class="col-sm-3 col-md-3 col-lg-3">
				<a href="#"><img src="../images/logo_triangulo2016.png" width="115"/></a>
			</div>
			<div class="col-sm-2 col-md-2 col-lg-2">
				<i class="fa fa-phone"></i> <?=$links['phone'];?>
			</div>
			<div class="col-sm-3 col-md-3 col-lg-3">
				<i class="fa fa-envelope"></i> <?=$links['email'];?>
			</div>
			<div class="col-sm-4 col-md-4 col-lg-4">
				<i class="fa fa-facebook fa-2x"></i>
				<i class="fa fa-twitter fa-2x"></i>
				<i class="fa fa-google fa-2x"></i>
			</div>
			
		</div>
		<div id="menu_top">
			<nav class="navbar">
				<div class="container-fluid">
					<!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header">
					  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					  </button>
					</div>

					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					  <ul class="nav navbar-nav">
						<li class="active"><a href="#<?=$links['home'];?>"> Home<br><sub>P&aacute;gina Inicial</sub><span class="sr-only">(current)</span></a></li>
						<li><a href="#<?=$links['triangulo'];?>">A Triângulo <br><sub>Quem Somos</sub></a></li>
						<li><a href="#<?=$links['servicos'];?>">Servi&ccedil;os<br><sub>O que fazemos?</sub></a></li>  
						<li class="dropdown">
							<a class="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Links &Uacute;teis <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="<?=$links['news'];?>" target="_blank">Notícias RSS</a></li>
								<li><a href="<?=$links['parceiros'];?>" target="_blank">Parceiros</a></li>
							</ul>
						</li>
						<li><a href="<?=$links['sistema'];?>">Login<br><sub>Acesso ao Portal</sub></a></li>
						<li><a href="#<?=$links['contato'];?>">Contato<br><sub>Fale Conosco</sub></a></li>
						
					  </ul>
					</div><!-- /.navbar-collapse -->
				 </div><!-- /.container-fluid -->
			</nav>
		</div>
	</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>
<script src="<?=$hosted;?>/assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

