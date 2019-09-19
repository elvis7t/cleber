<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start();
$sec = "Perfil";
require_once("../config/main.php");
require_once("../config/valida.php");
require_once("../config/mnutop.php");
require_once("../config/menu.php");
require_once("../../sistema/config/modals.php");
require_once("../../sistema/class/class.functions.php");

$rs_user = new recordset();
$fn = new functions();
$sql = "SELECT * FROM usuarios a
          LEFT JOIN dados_user b ON a.usu_email = b.dados_usu_email
          LEFT JOIN departamentos c ON a.usu_dep = c.dep_id
          WHERE usu_cod = ".$_GET['usuario'];
$rs_user->FreeSql($sql);
$disable="disabled";
$rs_user->GeraDados();
if(($rs_user->fld("usu_cod") == $_SESSION['usu_cod']) OR ($_SESSION['classe'])==1){
  $disable = "";
}
?>
 <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Perfil
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Usu&aacute;rios</a></li>
            <li class="active">Perfil</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-md-3">
              <!-- Profile Image -->
              <div class="box box-primary">
                <div class="box-body box-profile">
                  <img class="profile-user-img img-responsive img-circle" src="<?=$hosted."/".$rs_user->fld('usu_foto');?>" alt="User profile picture">
                  <h3 class="profile-username text-center"><?=$rs_user->fld('usu_nome');?></h3>
                  <p class="text-muted text-center"><?=$rs_user->fld('dep_nome');?></p>
                   
                </div><!-- /.box-body -->
              </div><!-- /.box -->

              <!-- About Me Box -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Sobre mim</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <strong><i class="fa fa-birthday-cake margin-r-5"></i>  Nascimento</strong>
                  <p class="text-muted">
                    <?=$fn->data_br($rs_user->fld('dados_nasc'));?>
                  </p>

                  <hr>
                  <strong><i class="fa fa-book margin-r-5"></i>  Forma&ccedil;&atilde;o</strong>
                    <p class="text-muted">
                      <?=$rs_user->fld('dados_escol');?>
                    </p>

                    <hr>

                  <strong><i class="fa fa-map-marker margin-r-5"></i> Endere&ccedil;o</strong>
                  <p class="text-muted">
                    <adress>
                      <?php
                         echo $rs_user->fld('dados_rua').", ".$rs_user->fld('dados_num')." ".$rs_user->fld('dados_compl')."<br>";
                         echo $rs_user->fld('dados_bairro')." - ".$rs_user->fld('dados_cidade')." - ".$rs_user->fld('dados_uf')."<br> CEP: ".$rs_user->fld('dados_cep');
                      ?>
                    </adress>  
                  </p>

                  <hr>

                  <strong><i class="fa fa-pencil margin-r-5"></i> Habilidades</strong>
                  <p>
                    <?php 
                    $estilos = array("danger","success","info","warning","primary");
                    $skills = explode(";",$rs_user->fld('dados_habil'));
                    foreach($skills as $ch => $vl){ ?>
                      <span class="label label-<?=$estilos[$ch];?>"><?=$vl;?></span>
                    <?php  
                    }
                    ?>
                    
                  </p>

                  <hr>

                  <strong><i class="fa fa-file-text-o margin-r-5"></i> Notas</strong>
                  <p><?=$rs_user->fld('dados_notas');?></p>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
            <div class="col-md-9">
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#tab_1" data-toggle="tab">Dados do Usu&aacute;rio</a></li>
                  <li><a href="#tab_2" data-toggle="tab">Alterar Senha</a></li>
                  <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
                </ul>
              </div>
              <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                  <div class="box box-primary">
                    <div class="box-body">
                      <div class="row">
                        <div class="form-group col-md-6">
                          <label for="emp_cnpj">Nome</label>
                          <input class="form-control input-sm" readonly id="usu_nome" placeholder="Nome" value="<?=$rs_user->fld("usu_nome");?>">
                        </div>
                        <div class="form-group col-md-6">
                          <label for="emp_cnpj">E-mail / Usu&aacute;rio</label>
                          <input class="form-control input-sm" readonly id="usu_email" placeholder="email" value="<?=$rs_user->fld("usu_email");?>">
                        </div>
                      </div>
                      <div class="row">
                        
                        
                        <div class="form-group col-xs-3">
                          <label for="emp_cep">CEP</label>
                          <input class="form-control input-sm" id="cep" placeholder="CEP" value="<?=$rs_user->fld("dados_cep");?>" <?=$disable; ?>>
                        </div>
                        <div class="form-group col-xs-5">
                          <label for="emp_log">Logradouro</label>
                          <input class="form-control input-sm text-uppercase" id="log" placeholder="Logradouro" value="<?=$rs_user->fld("dados_rua");?>" <?=$disable; ?>>
                        </div>
                        <div class="form-group col-xs-2">
                          <label for="emp_num">N&uacute;mero</label>
                          <input class="form-control input-sm" id="num" placeholder="Num.:" value="<?=$rs_user->fld("dados_num");?>" <?=$disable; ?>>
                        </div>
                        <div class="form-group col-xs-2">
                          <label for="emp_comp">Complemento</label>
                          <input class="form-control input-sm text-uppercase" id="compl" placeholder="Compl.:" value="<?=$rs_user->fld("dados_compl");?>" <?=$disable; ?>>
                        </div>
                        <div class="form-group col-xs-5">
                          <label for="emp_bai">Bairro</label>
                          <input class="form-control input-sm text-uppercase" id="bai" placeholder="Bairro" value="<?=$rs_user->fld("dados_bairro");?>" <?=$disable; ?>>
                        </div>
                        <div class="form-group col-xs-5">
                          <label for="emp_cid">Cidade</label>
                          <input class="form-control input-sm text-uppercase" id="cid" placeholder="Cidade" value="<?=$rs_user->fld("dados_cidade");?>" <?=$disable; ?>>
                        </div>
                        <div class="form-group col-xs-2">
                          <label for="emp_uf">UF</label>
                          <input class="form-control input-sm text-uppercase" id="uf" placeholder="UF" value="<?=$rs_user->fld("dados_uf");?>" <?=$disable; ?>>
                        </div>
                        
                        <div class="form-group col-xs-2">
                          <label for="emp_uf">Nascimento</label>
                          <input class="form-control input-sm text-uppercase date" id="data" placeholder="Data" value="<?=$fn->data_br($rs_user->fld("dados_nasc"));?>" <?=$disable; ?>>
                        </div>
                         <div class="form-group col-xs-5">
                          <label for="emp_bai">Forma&ccedil;&atilde;o</label>
                          <input class="form-control input-sm text-uppercase" id="escol" placeholder="Forma&ccedil;&atilde;o" value="<?=$rs_user->fld("dados_escol");?>" <?=$disable; ?>>
                        </div>
                        <div class="form-group col-xs-5">
                          <label for="emp_cid">Habilidades <small>(M&aacute;x 5 Separadas por ";")</small></label>
                          <select class="select2 form-control input-sm" multiple="multiple" name="habil" id="habil" <?=$disable; ?> style="width: 100%;">
                            <option value=""></option>
                            <option value="Intelig&ecirc;ncia">Intelig&ecirc;ncia</option>
                            <option value="Perspic&aacute;cia">Perspic&aacute;cia</option>
                            <option value="Lideran&ccedil;a">Lideran&ccedil;a</option>
                            <option value="Motiva&ccedil;&atilde;o">Motiva&ccedil;&atilde;o</option>
                            <option value="Auto-Estima">Auto-Estima</option>
                            <option value="Perseveran&ccedil;a">Perseveran&ccedil;a</option>
                            <option value="Reflexividade">Reflexividade</option>
                            <option value="Concentra&ccedil;&atildeo;">Concentra&ccedil;&atilde;o</option>
                            <option value="Dilig&ecirc;ncia">Dilig&ecirc;ncia</option>

                          </select>
                          
                        </div>
                        <div class="form-group col-xs-12">
                          <label for="emp_cid">Observa&ccedil;&otilde;es <small>(Status)</small></label>
                          <textarea class="form-control" id="notas" placeholder="status" <?=$disable; ?>><?=$rs_user->fld("dados_notas");?></textarea>
                        </div>
                      </div>
                      <div id="consulta"></div>
                    </div>
                    <div class="box-footer">
                    <button id="bt_altera_func" class="btn btn-sm btn-primary"><i class="fa fa-pencil"></i> Alterar Dados </button>
                    </div>
                  </div>
                </div><!-- /.tab-pane -->

              <div class="tab-pane" id="tab_2">
                <div class="box box-default">
                  <div class="box-body">
                    <form role="form" id="alt_senha">
                      <div class="input-group col-md-12">
                        <div class="row">
                          <div class="form-group col-md-5">
                            <label from="lbl_senhaatual">Senha Atual</label>
                            <input type="password" class="form-control" id="senhaatual" name="senhaatual"/>
                          </div>
                        </div>


                        <div class="row">  
                          <div class="form-group col-md-5">
                            <label from="lbl_senhaatual">Nova Senha</label>
                            <input type="password" class="form-control" id="sen_nova" name="sen_nova"/>
                          </div>

                          <div class="form-group col-md-5">
                            <label from="lbl_senhaatual">Redigite</label>
                            <input type="password" class="form-control" id="rsen_nova" name="rsen_nova"/>
                          </div>
                        </div>
                        
                      
                        <div id="formerros_senha" class="" style="display:none;">
                          <div class="callout callout-danger">
                            <h4>Erros no preenchimento do formul&aacute;rio.</h4>
                            <p>Verifique os erros no preenchimento acima:</p>
                            <ol>
                              <!-- Erros são colocados aqui pelo validade -->
                            </ol>
                          </div>
                        </div>  
                      <div id="consulta2"></div>
                    </form>
                  </div><!-- /.box-body -->
                  <div class="box-footer">
                          <button id="bt_alt_senha" class="btn btn-sm btn-success"><i class="fa fa-pencil"></i> Alterar</button>
                        </div>
                </div><!-- /.box -->
                
              </div><!-- /.tab-pane -->
              
            </div><!-- /.tab-content -->
          </div><!-- nav-tabs-custom -->
            </div>
    </section>
  </div>
  <?php
    require_once("../config/footer.php");
  ?></div><!-- ./wrapper -->

<script src="<?=$hosted;?>/sistema/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?=$hosted;?>/sistema/assets/bootstrap/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="<?=$hosted;?>/sistema/assets/plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?=$hosted;?>/sistema/assets/dist/js/app.min.js"></script>
   <!-- Slimscroll -->
    <script src="<?=$hosted;?>/sistema/assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="<?=$hosted;?>/sistema/assets/js/maskinput.js"></script>
    <script src="<?=$hosted;?>/sistema/assets/js/jmask.js"></script>
    <script src="<?=$hosted;?>/triangulo/js/controle.js"></script>
    <script src="<?=$hosted;?>/triangulo/js/action_triang.js"></script>
    <script src="<?=$hosted;?>/triangulo/js/jquery.cookie.js"></script>
    <script src="<?=$hosted;?>/triangulo/js/functions.js"></script>

  <!-- SELECT2 TO FORMS
  -->

  <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
  <!-- Validation -->
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
  <script>
    $(".select2").select2({
      tags: true,
      theme: "classic"
    });

    $(".select2").on('click', 'option', function() {
    if ($(".select2 option:selected").length > 5) {
        $(this).removeAttr("selected");
        // alert('You can select upto 3 options only');
    }
});
  $("#chatContent").scrollTop($("#msgs").height());   
  setTimeout(function(){
    $("#slc").load("vis_solic.php");    
    $("#alms").load(location.href+" #almsg");
   },10000);
   
  </script>

</body>
</html> 