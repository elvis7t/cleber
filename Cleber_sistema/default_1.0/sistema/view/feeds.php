<?php
require_once("../class/class.functions.php");
$fn = new functions();

echo $fn->getFeed("http://www.contabeis.com.br/rss/noticias/");
?>