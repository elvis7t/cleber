<table class="table table-strip">
    <tr>
        <th>#Cod Envio</th>
        <th>Nome Arquivo</th>
        <th>Enviado Por</th>
        <th>Enviado em</th>
        <th>A&ccedil;&otilde;es</th>
    </tr>
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
require_once("../class/class.functions.php");
$rs = new recordset();
$rs1 = new recordset();
$rs2 = new recordset();
$fn = new functions();
if (filter_input(INPUT_POST,'doc_pes') ) :
    $doc = filter_input(INPUT_POST,'doc_pes');
else:
    if( filter_input(INPUT_GET,'cnpj')):
        $doc = filter_input(INPUT_GET,'cnpj');
    else:
        $doc = $_SESSION["usu_empresa"];
    endif;
endif;
// ALTERA TODOS OS DOCS COMO VISTO PARA O CPF DA SESSÃO
$dados = array('doc_visto'=>1);
$rs1->Altera($dados,"documentos","doc_cli_cnpj='".$doc."'");


$sql = "SELECT a.*, b.emp_razao as Nome, c.usu_nome as Env FROM documentos a 
            JOIN empresas b ON a.doc_cli_cnpj = b.emp_cnpj
            JOIN usuarios c ON a.doc_user_env = c.usu_email
        WHERE doc_cli_cnpj = '{$doc}' GROUP BY doc_cod";
$rs->FreeSql($sql);

while ($rs->GeraDados()) {
    ?>
    <tr>
        <td><?=$rs->fld("doc_cod");?></td>
        <td><?=$rs->fld("doc_desc");?></td>
        <td><?=$rs->fld("Env");?></td>
        <td><?=$fn->data_br($rs->fld("doc_dtenv"));?></td>
        
        <td>
            <a href="<?= $rs->fld("doc_ender"); ?>" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-file-pdf-o"></i></a>
            <a href='javascript:baixa(<?=$rs->fld("doc_cod");?>,"send_mail","Deseja enviar o arquivo")' class="btn btn-sm btn-primary"><i class="fa fa-envelope"></i></a>
            <a href="javascript:baixa('<?=$rs->fld("doc_cod");?>','exc_doc','Deseja excluir o documento')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
        </td>
    </tr>
    <?php
}
?>
</table>