<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);
require_once("../model/recordset.php");

$rs = new recordset();
$tpa = array(
        "pdf"   => array("icone" =>"file-pdf-o", "cor" => "bg-aqua"),
        "xls"   => array("icone" =>"file-excel-o", "cor" => "bg-green"),
        "xlsx"  => array("icone" =>"file-excel-o", "cor" => "bg-green"),
        "png"   => array("icone" =>"picture-o", "cor" => "bg-yellow"),
        "jpg"   => array("icone" =>"picture-o", "cor" => "bg-yellow"),
    );

$tbl = "";
$atual = "";
$cpc = $_GET['clicod'];
$dir_ini = "../documentos/$cpc";
$dir = $dir_ini.(isset($_GET['pasta'])?"/".$_GET['pasta']:"");
$atual.=(isset($_GET['atual'])?$_GET['atual']:"")."/";
$pa = explode("/",$atual);
$pa[0] = '<i class="fa fa-file-text"></i> Documentos</li>';
?>
<ol class="breadcrumb">
    <?php
    foreach ($pa as $key => $value) {
        echo '<li>'.$value.'</li>';
    }
    ?>
</ol>
<?php
if ($handle = opendir($dir)) {

    // Esta é a forma correta de varrer o diretório 
    while (false !== ($file = readdir($handle))) {
        if($file!="." && $file !=".."){
    
            if(!strpos($file, ".")==true){
                $x=0;
                echo "
                    
                        <a 
                            class='btn btn-sm btn-primary' 
                            href='clientes.php?token=".$_SESSION["token"]."&clicod=".$cpc."&tab=docsrec&pasta=../$dir/$file&atual=".$atual.$file."'>
                            <i class='fa fa-folder-open'></i>
                            $file
                        </a>
                    ";
            }
            else{
                $x=1;
            }
        }
    }

    closedir($handle);
}
                //var_dump($fl);

/*
                
*/
if($x>0){
    $sql = "SELECT envcli_id, envcli_arqnome, envcli_arquivo, envcli_impnome, b.usu_nome FROM doc_envclientes a
                LEFT JOIN usuarios b ON b.usu_cod = a.envcli_envpor 
            WHERE envcli_arquivo LIKE '%".$atual."%' AND envcli_empresa =".$cpc;
    $rs->FreeSql($sql);
    while($rs->GeraDados()):
        $fl = explode(".", $rs->fld("envcli_arqnome"));
        //var_dump($fl);
        $tbl .= '
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon '.$tpa[$fl[1]]['cor'].'"><i class="fa fa-'.$tpa[$fl[1]]['icone'].'"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-number">Arquivo ['.$fl[1].']</span>
                        <span class="info-box-text">'.$rs->fld("envcli_arqnome").'</span>
                        <a class="btn btn-xs btn-primary pull-right" target="_blank" 
                        href="vis_docsenviados.php?id='.$rs->fld('envcli_id').'&via=Portal"><i class="fa fa-save"></i></a>
                        
                    </div><!-- /.info-box-content -->
                </div><!-- /.info-box -->
            </div><!-- /.col -->
            
        ';
    endwhile;
    
}

?>
<a class="btn btn-sm btn-danger" href="javascript:history.go(-1);"><i class="fa fa-level-up"></i> Voltar</a>
<br><br>
<div class="row">
    <?=$tbl;?>
</div>

