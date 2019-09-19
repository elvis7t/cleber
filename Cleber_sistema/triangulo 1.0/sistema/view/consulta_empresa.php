<table class="table table-hover">
    <tr>
        <th>CNPJ</th>
        <th>Empresa</th>
        <th>Nome de Fantasia</th>
        <th>Respons&aacute;vel</th>
        <th>Plano</th>
        <th>A&ccedil;&otilde;es</th>
    </tr>

    <?php
    $sq = $_POST['sql'];
    require_once("../class/class.empresas.php");
    $rs_empresas = new empresas();
    $rs_empresas->FreeSql($sq);
    echo $rs_empresas->sql;
    while ($rs_empresas->GeraDados()) {
        ?>
        <tr>
            <td><?= $rs_empresas->fld("emp_cnpj"); ?></td>
            <td><?= $rs_empresas->fld("emp_razao"); ?></td>
            <td><?= $rs_empresas->fld("emp_nome"); ?></td>
            <td><?= $rs_empresas->fld("emp_resp"); ?></td>
        <td>Priore Slim</td>
        <td>
            <button class="btn btn-xs btn-primary" id="btr"><i class="fa fa-file-pdf-o"></i></button>
            <button class="btn btn-xs btn-info"><i class="fa fa-database"></i></button>
            <button class="btn btn-xs btn-warning"><i class="fa fa-edit"></i></button>
            <button class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
        </td>
    </tr>	
    <?}
    ?>
</table>