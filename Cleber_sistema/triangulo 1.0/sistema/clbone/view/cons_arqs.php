<?php
//session_start();
require_once("../config/main.php");
/*
  Array com os tipos de documentos que são inseridos no banco
  Escolhe pelo indice, o icone e a cor da caixa para apresentação dos docs.
 */
$_tipoArq = array(
    "application/pdf" => array("icone" => "fa fa-file-pdf-o", "cor" => "bg-teal"),
    "image/png" => array("icone" => "fa fa-file-picture-o", "cor" => "bg-aqua"),
    "image/jpeg" => array("icone" => "fa fa-file-picture-o", "cor" => "bg-teal"),
    "application/vnd.openxmlformats-officedocument.wordprocessingml.document" => array("icone" => "fa fa-file-word-o", "cor" => "bg-blue"),
    "application/vnd.ms-excel" => array("icone" => "fa fa-file-excel-o", "cor" => "bg-green"),

    "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" => array("icone" => "fa fa-file-excel-o", "cor" => "bg-green")
);

require_once("../class/class.empresas.php");
$rs = new recordset();
if (filter_input(INPUT_POST,'doc_pes') ) :
    $doc = filter_input(INPUT_POST,'doc_pes');
else:
    if( filter_input(INPUT_GET,'doc_pes')):
        $doc = filter_input(INPUT_GET,'doc_pes');
    else:
        $doc = $_SESSION["usu_empresa"];
    endif;
endif;

$whr = "doc_cli_cnpj = '" . $doc . "'";
$rs->Seleciona("*", "documentos", $whr);
while ($rs->GeraDados()) {
    ?>
    <div class="col-lg-2 col-xs-2">
        <ul class="timeline">
            <li><i class="<?= $_tipoArq[$rs->fld("doc_tipo")]['icone'] . " " . $_tipoArq[$rs->fld("doc_tipo")]['cor']; ?>"></i></li>
        </ul>
        <a href="<?= $rs->fld("doc_ender"); ?>" class="small-box-footer" data-toggle='tooltip' data-placement='bottom' title='<?= $rs->fld("doc_desc"); ?>'>
            <i class="fa fa-download"></i> Download
        </a>
    </div><!-- ./col -->
    <?php
}
?>