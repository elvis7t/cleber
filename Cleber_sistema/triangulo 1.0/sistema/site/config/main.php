<!DOCTYPE html>
<html>
<?php
/*-------------------------------------*\
|	@File:		Main.php 				|
|	@Author:	Cleber Marrara Prado 	|
|	@Version:	1.0						|
|	@Created:	10/08/2016				|
\*-------------------------------------*/
date_default_timezone_set('America/Sao_Paulo'); 
session_start();
ob_start();
$host = "http://192.168.0.104:8080/web/site"; //It is the address: Replace when upload to production
$logotipo="";
?>
<head>
  	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Triângulo</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" href="<?=$host;?>/assets/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?=$host;?>/assets/bootstrap/css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="<?=$host;?>/assets/font-awesome-4.6.3/css/font-awesome.min.css">
	<!-- Bootstrap Core CSS -->
	<link href="<?=$host;?>/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">	
	<link href="<?=$host;?>/assets/bootstrap/css/personal.css" rel="stylesheet">	


</head>
<body>
