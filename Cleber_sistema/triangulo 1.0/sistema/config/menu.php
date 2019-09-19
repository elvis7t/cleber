<?php
/*----------------------------------------------------------------------\
|	menu.php 															|
|	Armazena informações do menu principal(lateral)						|
\----------------------------------------------------------------------*/
require_once("main.php");
session_start();
$hosted = "http://" . $_SERVER['SERVER_NAME'];
$links = array(
	"home" 				=> "home",
	"priore"			=> "quemsomos",
	"servicos"			=> "service",
	"contato"			=> "contatos",
	"receita"			=> "http://receita.fazenda.gov.br",
	"previdencia"		=> "http://previdencia.gov.br",
	"nfe"				=> "http://nfe.gov.br",
	"sistema"			=> $hosted."/sistema"
);
require_once("model/recordset.php");
/*
if($sessao == "Home"){
	require_once("model/recordset.php");
}
else{
}
$rs_msg = new recordset;
require_once("contagens.php");
require_once("mensagens.php");
*/
?>
<body>
	<div id="wrapper">
		<div id="menu_top">
			<nav class="navbar navbar-priore">
				<div class="container-fluid">
					<!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header">
					  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					  </button>
					  <a class="navbar-brand" href="#"><img src="images/logo_Origem.png" width="115"/></a>
					</div>

					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					  <ul class="nav navbar-nav">
						<li class="active"><a href="#<?=$links['home'];?>"> Home<br><sub>P&aacute;gina Inicial</sub><span class="sr-only">(current)</span></a></li>
						<li><a href="#<?=$links['servicos'];?>">Servi&ccedil;os<br><sub>O que fazemos?</sub></a></li>  
						<li><a href="#<?=$links['priore'];?>">A Priore <br><sub>Quem Somos</sub></a></li>
						<li><a href="#<?=$links['contato'];?>">Contato<br><sub>Fale Conosco</sub></a></li>
						<li class="dropdown">
							<a class="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Links &Uacute;teis <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="<?=$links['receita'];?>" target="_blank">Previd&ecirc;ncia Social</a></li>
								<li><a href="<?=$links['previdencia'];?>" target="_blank">Receita Federal</a></li>
								<li><a href="<?=$links['nfe'];?>" target="_blank">Nota Fiscal Eletr&ocirc;nica</a></li>
							</ul>
						</li>
						<li><a href="<?=$links['sistema'];?>">Login<br><sub>Acesso ao Portal</sub></a></li>
						
					  </ul>
					</div><!-- /.navbar-collapse -->
				 </div><!-- /.container-fluid -->
			</nav>
		</div>
		<div id="page-wrapper"></div>
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<div class="row">
						<div class="container-fluid">
							<img src="images/logo_Origem.png" id="imgPri" width="200"/>
						</div>
						<div class="row">
							<nav class="navbar navbar-priore">
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
									<li><a href="#<?=$links['servicos'];?>">Servi&ccedil;os<br><sub>O que fazemos?</sub></a></li>  
									<li><a href="#<?=$links['priore'];?>">A Priore <br><sub>Quem Somos</sub></a></li>
									<li><a href="#<?=$links['contato'];?>">Contato<br><sub>Fale Conosco</sub></a></li>
									<li class="dropdown">
										<a class="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Links &Uacute;teis <b class="caret"></b></a>
										<ul class="dropdown-menu">
											<li><a href="#">Previd&ecirc;ncia Social</a></li>
											<li><a href="#">Receita Federal</a></li>
											<li><a href="#">Nota Fiscal Eletr&ocirc;nica</a></li>
										</ul>
									</li>
									<li><a href="<?=$links['sistema'];?>">Login<br><sub>Acesso ao Portal</sub></a></li>
						
								  </ul>
								</div><!-- /.navbar-collapse -->
							</div><!-- /.container-fluid -->
							</nav>
						</div>
					</div>
