<?php 

require_once("../class/class.functions.php");

$fn = new functions();

echo $fn->sanitize($_GET['nf']);
