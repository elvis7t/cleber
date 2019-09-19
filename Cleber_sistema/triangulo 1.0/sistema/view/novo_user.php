<?php
session_start();
/* inclusão dos principais itens da página */
require_once("../config/main.php");
require_once("../config/valida.php");
require_once("../config/mnutop.php");
$sec = "User";

require_once("../config/menu.php");
require_once("../config/modals.php");
require_once("../class/class.functions.php");
$fc = new functions();
if ($fc->is_set($_GET['cnpj'])) {
    $doc = $_GET['cnpj'];
} else {
    $doc = $_SESSION['usu_empresa'];
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Gerenciamento
            <small>Cadastro e Consulta de Usu&aacute;rios</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Gerenciamento</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-9">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Usu&aacute;rios</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" id="cad_usu">
                        <input type="hidden" name="documento" id="documento" value="<?= $doc; ?>" />
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group col-xs-4">
                                    <label for="usu_cpf">E-Mail:</label>
                                    <input class="form-control" id="usu_mail" name="usu_mail" placeholder="E-mail">
                                </div>

                                <div class="form-group col-xs-12" id="consulta">
                                </div>	
                            </div>
                            <div class="row hide" id="cadastro">
                                <div class="form-group col-xs-8">
                                    <label for="usu_ncp">Nome Completo</label>
                                    <input class="form-control" id="usu_ncp" name="usu_ncp" placeholder="Nome Completo">
                                </div>
                                <div class="form-group col-xs-4">
                                    <label>Sexo:</label>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="usu_sexo" id="usu_sexo" value="1">
                                            Masculino
                                        </label>
                                        <label>
                                            <input type="radio" name="usu_sexo" id="usu_sexo" value="0">
                                            Feminino
                                        </label>
                                    </div>
                                </div>
                                <div>
                                    <div class="form-group col-xs-3">
                                        <label for="cep">CEP</label>
                                        <input class="form-control cep" id="cep" name="cep" placeholder="CEP">
                                    </div>
                                    <div class="form-group col-xs-5">
                                        <label for="log">Logradouro</label>
                                        <input class="form-control" id="log" name="log" placeholder="Logradouro">
                                    </div>
                                    <div class="form-group col-xs-2">
                                        <label for="num">N&uacute;mero</label>
                                        <input class="form-control" id="num" name="num" placeholder="Num.:">
                                    </div>
                                    <div class="form-group col-xs-2">
                                        <label for="compl">Compl.:</label>
                                        <input class="form-control" id="compl" name="compl" placeholder="Compl.:">
                                    </div>
                                </div>
                                <div>
                                    <div class="form-group col-xs-5">
                                        <label for="bai">Bairro</label>
                                        <input class="form-control" id="bai" name="bai" placeholder="Bairro">
                                    </div>
                                    <div class="form-group col-xs-5">
                                        <label for="cid">Cidade</label>
                                        <input class="form-control" id="cid" name="cid" placeholder="Cidade">
                                    </div>
                                    <div class="form-group col-xs-2">
                                        <label for="uf">UF</label>
                                        <input class="form-control" id="uf" name="uf" placeholder="UF">
                                    </div>
                                </div>
                                <div>
                                    <div class="form-group col-xs-5">
                                        <label for="usu_resp">RG</label>
                                        <input class="form-control" id="usu_rg" name="usu_rg" placeholder="RG">
                                    </div>
                                </div>
                                <div>
                                    <div class="form-group col-xs-5">
                                        <label for="usu_user">Usu&aacute;rio (E-mail)</label>
                                        <input class="form-control" id="usu_user" name="usu_user" placeholder="Usu&aacute;rio (E-mail)">
                                    </div>
                                    <div class="form-group col-xs-5">
                                        <label for="usu_senha">Senha</label>
                                        <input type="password" class="form-control" id="usu_senha" name="usu_senha" placeholder="Senha">
                                    </div>
                                </div>
                                <div class="form-group col-xs-5">
                                    <label for="usu_csenha">Confirmar Senha</label>
                                    <input type="password" class="form-control" id="usu_csenha" name="usu_csenha" placeholder="Confirme a Senha">
                                </div>

                            </div>
                            <div id="formerros2" class="" style="display:none;">
                                <div class="callout callout-danger-disabled">
                                    <h4>Erros no preenchimento do formul&aacute;rio.</h4>
                                    <p>Verifique os erros no preenchimento acima:</p>
                                    <ol>
                                        <!-- Erros são colocados aqui pelo validade -->
                                    </ol>
                                </div>
                            </div>

                        </div>
                        <div class="box-footer">
                            <button class="btn btn-sm btn-primary" type="button" id="bt_pes_usu"><i class="fa fa-search"></i> Pesquisar</button>
                            <button class="btn btn-sm btn-info hide" type="button" id="bt_cad_usu"><i class="fa fa-magic"></i> Adicionar</button>
                            <button class="btn btn-sm btn-warning hide" type="button" id="bt_nova_usu"><i class="fa fa-search-plus"></i> Nova Pesquisa</button>


                        </div>
                    </form>
                </div><!-- ./box -->

            </div><!-- ./col -->
            <div class="col-xs-12">
                <div class="box box-success hide" id="firms">
                    <div class="box-header with-border">
                        <h3 class="box-title">Usu&aacute;rios encontrados:</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table class="table table-striped">
                            <tr>
                                <th>Nome</th>
                                <th>E-Mail</th>
                                <th>Classe</th>
                                <th>Status</th>
                                <th>A&ccedil;&otilde;es</th>
                            </tr>
                        </table>
                    </div>
                </div><!-- ./box -->
            </div><!-- ./col -->
        </div><!-- ./row -->
    </section>
</div>

<? 
require_once("../config/footer.php");
require_once("../config/sidebar.php");
?></div><!-- ./wrapper -->

<script src="<?= $hosted; ?>/sistema/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="<?= $hosted; ?>/sistema/assets/bootstrap/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="<?= $hosted; ?>/sistema/assets/plugins/fastclick/fastclick.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= $hosted; ?>/sistema/assets/dist/js/app.min.js"></script>
<!-- Slimscroll -->
<script src="<?= $hosted; ?>/sistema/assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="<?= $hosted; ?>/sistema/assets/js/maskinput.js"></script>
<script src="<?= $hosted; ?>/sistema/assets/js/jmask.js"></script>
<script src="<?= $hosted; ?>/sistema/assets/js/controle.js"></script>
<script src="<?= $hosted; ?>/sistema/assets/js/action_usuarios.js"></script>
<!-- Validation -->
<!--<script src="<?= $hosted; ?>/js/jquery-validation/dist/jquery.validate.min.js"></script>-->
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
</body>
</html>
