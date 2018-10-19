

<?php

require_once("../config/main.php");

$funcNum = $_GET['CKEditorFuncNum'] ;
// Optional: instance name (might be used to load a specific configuration file or anything else).
$CKEditor = $_GET['CKEditor'] ;
// Optional: might be used to provide localized messages.
$langCode = $_GET['langCode'] ;
// Optional: compare it with the value of `ckCsrfToken` sent in a cookie to protect your server side uploader against CSRF.
// Available since CKEditor 4.5.6.
$token = $_POST['ckCsrfToken'] ; 

$url = '../assets/jQueryFileUpload/server/php/images';
$url2 = 'assets/jQueryFileUpload/server/php/images';

$file = $hosted."/triangulo/".$url2."/". $_FILES["upload"]["name"];
if (file_exists($url."/". $_FILES["upload"]["name"]))
{
 echo $_FILES["upload"]["name"] . " already exists. ";
}
else
{
 move_uploaded_file($_FILES["upload"]["tmp_name"],
 $url."/".$_FILES["upload"]["name"]);
 $message =  "Arquivo Adicionado";
}

echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$file', '$message');</script>";


