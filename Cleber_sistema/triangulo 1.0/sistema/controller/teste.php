<?

echo md5($_GET['p']);
echo "<br><br>";

$data = date("Y-m-d h:m:s")."<br>";
$mais = 5*60;
$dtn = $data + $mais;
echo date("Y-m-d h:m:s", $dtn);
?>
