<!DOCTYPE html>
<html>
	<head>
		<?php
		/*----------|MAIN.PHP|------------------*\
		| @author:	Cleber Marrara Prado
		| @contact:	cleber.marrara.prado@gmail.com
		| @version:	1.0
		| @date:	06-20-2016
		\*--------------------------------------*/
		date_default_timezone_set('America/Sao_Paulo'); 
		session_start();
		ob_start();
		$hosted = "http://192.168.0.104:8080/web";
		?>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Triângulo</title>
		<!-- Tell the browser to be responsive to screen width -->
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<!-- Bootstrap 3.3.5 -->
		<link rel="stylesheet" href="<?=$hosted;?>/str/assets/bootstrap/css/bootstrap.min.css">
		<!-- Font Awesome -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.0/css/font-awesome.min.css">
	</head>
