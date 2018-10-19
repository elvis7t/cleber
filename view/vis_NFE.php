<?php 

require_once("../../sistema/class/class.functions.php");

$fn = new functions();

echo $fn->sanitize($_GET['nf']);
