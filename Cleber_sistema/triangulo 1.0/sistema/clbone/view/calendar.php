<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start();
$sec = "CALEN";
require_once("../config/main.php");
require_once("../config/valida.php");
require_once("../config/mnutop.php");
require_once("../config/menu.php");
require_once("../../sistema/class/class.functions.php");
require_once("../../sistema/config/modals.php");

?>
       <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Calend&aacute;rio
            <small>Painel de Controle</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Calendario</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-md-3">
              <div class="box box-solid">
                <div class="box-header with-border">
                  <h4 class="box-title">Eventos</h4>
                </div>
                <div class="box-body">
                  <!-- the events -->
                  <div id="external-events">
                  <?php
                    // cookie vcal zera, para tirar o lembrete da quantidade
                    setcookie("vcal",1);
                    $rs_ev = new recordset();
                    $sql = "SELECT * FROM Eventos WHERE eve_dep IN('[".$_SESSION['usu_cod']."]','10','11') ORDER BY eve_tema ASC";
                    $rs_ev->FreeSql($sql);
                    while($rs_ev->GeraDados()){?>
                      <div data-evento="<?=$rs_ev->fld("eve_id");?>" data-titulo="<?=$rs_ev->fld("eve_desc");?>" class="external-event <?=$rs_ev->fld("eve_tema");?>"><?=$rs_ev->fld("eve_desc");?></div>
                    <?php 
                    }

                  ?>
                    <!--
                    <div class="external-event bg-yellow">Go home</div>
                    <div class="external-event bg-aqua">Do homework</div>
                    <div class="external-event bg-light-blue">Work on UI design</div>
                    <div class="external-event bg-red">Sleep tight</div>-->
                    <!--
                    <div class="checkbox">
                      <label for="drop-remove">
                        <input type="checkbox" id="drop-remove">
                        remove after drop
                      </label>
                    </div>
                    -->
                     <div class="checkbox">
                      <label for="drop-remove">
                        <input type="checkbox" id="drop-visivel">
                        vis&iacute;vel para todos
                      </label>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="box box-success collapsed-box">
                          <div class="box-header with-border">
                            <h4 class="box-title">Escolher quem pode ver</h4>
                            <div class="box-tools pull-right">
                              <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                            </div><!-- /.box-tools -->
                          </div><!-- /.box-header -->
                          <div class="box-body">
                           <div class="form-group">
                            <select id="funcs" class="select2 select2-black" multiple="multiple" style="width: 100%;">
                              <?php
                                $rs_fc = new recordset();
                                // Seleciona todos os departamentos cadastrados
                                $rs_ev->Seleciona("dep_id, dep_nome","departamentos","dep_id<>0");
                                while($rs_ev->GeraDados()){?>
                                  <option disabled="disabled"><?=$rs_ev->fld("dep_nome");?></option>
                                <?php
                                  // Entre cada Option de Departamentos, colocamos o funcionário dele
                                  $rs_fc->Seleciona("usu_cod, usu_nome","usuarios","usu_dep=".$rs_ev->fld("dep_id"));
                                  while($rs_fc->GeraDados()){?>
                                    <option value="<?=$rs_fc->fld("usu_cod");?>"><?=$rs_fc->fld("usu_nome");?></option>
                                  <?php
                                  }
                                }
                              ?>
                            </select>
                          </div><!-- /.form-group -->
                          </div><!-- /.box-body -->
                        </div><!-- /.box -->
                      </div><!-- /.col -->
                    </div>
                  </div>
                </div><!-- /.box-body -->
              </div><!-- /. box -->
              <div class="box box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">Criar Eventos</h3>
                </div>
                <div class="box-body">
                  <div class="btn-group" style="width: 100%; margin-bottom: 10px;">
                    <!--<button type="button" id="color-chooser-btn" class="btn btn-info btn-block dropdown-toggle" data-toggle="dropdown">Color <span class="caret"></span></button>-->
                    <ul class="fc-color-picker" id="color-chooser">
                      <li><a data-theme="bg-aqua" class="text-aqua" href="#"><i class="fa fa-square"></i></a></li>
                      <li><a data-theme="bg-blue" class="text-blue" href="#"><i class="fa fa-square"></i></a></li>
                      <li><a data-theme="bg-light-blue" class="text-light-blue" href="#"><i class="fa fa-square"></i></a></li>
                      <li><a data-theme="bg-teal" class="text-teal" href="#"><i class="fa fa-square"></i></a></li>
                      <li><a data-theme="bg-yellow" class="text-yellow" href="#"><i class="fa fa-square"></i></a></li>
                      <li><a data-theme="bg-orange" class="text-orange" href="#"><i class="fa fa-square"></i></a></li>
                      <li><a data-theme="bg-green" class="text-green" href="#"><i class="fa fa-square"></i></a></li>
                      <li><a data-theme="bg-lime" class="text-lime" href="#"><i class="fa fa-square"></i></a></li>
                      <li><a data-theme="bg-red" class="text-red" href="#"><i class="fa fa-square"></i></a></li>
                      <li><a data-theme="bg-purple" class="text-purple" href="#"><i class="fa fa-square"></i></a></li>
                      <li><a data-theme="bg-fuchsia" class="text-fuchsia" href="#"><i class="fa fa-square"></i></a></li>
                      <li><a data-theme="bg-muted" class="text-muted" href="#"><i class="fa fa-square"></i></a></li>
                      <li><a data-theme="bg-navy" class="text-navy" href="#"><i class="fa fa-square"></i></a></li>
                    </ul>
                  </div><!-- /btn-group -->
                  <div class="input-group">
                    <input id="new-event" type="text" class="form-control" maxlength="20" placeholder="titulo do Evento">
                    <div class="input-group-btn">
                      <button id="add-new-event" type="button" class="btn btn-primary btn-flat">Adicionar</button>
                    </div><!-- /btn-group -->
                  </div><!-- /input-group -->
                  <div id="lblChar"></div>
                </div>
              </div>
            </div><!-- /.col -->
            <div class="col-md-9">
              <div class="box box-primary">
                <div class="box-body no-padding">
                  <!-- THE CALENDAR -->
                  <div id="calendar"></div>
                </div><!-- /.box-body -->
              </div><!-- /. box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

      <?php
        //pesquisa de eventos para esse usuario
        $rs_cal = new recordset();
        $fn = new functions();
        $nc = $rs_cal->autocod("cal_id","calendario");
        $evts = "";
        $sq_cal = "SELECT * FROM calendario a
                    JOIN Eventos b ON a.cal_eveid = b.eve_id
                   WHERE (cal_eveusu like '%[".$_SESSION['usu_cod']."]%'
                          OR cal_eveusu like '%[9999]%')";
        $rs_cal->FreeSql($sq_cal);
        while($rs_cal->GeraDados()){
          //Tratar datas
          $sdi = explode("-",$rs_cal->fld("cal_dataini"));
          $mi = $sdi[1]-date("m");
          $ai = $sdi[0]-date("Y");
          $sdf = explode("-",$rs_cal->fld("cal_datafim"));
          $mf = $sdf[1]-date("m");
          $af = $sdf[0]-date("Y");
          echo "<!--".$fn->data_br($rs_cal->fld("cal_dataini"))."-->";
          $ehi = ($rs_cal->fld("cal_horaini") <> NULL ? explode(":", $rs_cal->fld("cal_horaini")):explode(":","00:00:00"));
          $ehf = ($rs_cal->fld("cal_horafim") <> NULL ? explode(":", $rs_cal->fld("cal_horafim")):explode(":","00:00:00"));
          $evts.= "{
              id:".$rs_cal->fld("cal_id").",
              title: '".$rs_cal->fld("eve_desc")."',
              start: new Date(y+".$ai.", m+".$mi.", ".$sdi[2]." , ".$ehi[0].", ".$ehi[1]."),
              end: new Date(y+".$af.", m+".$mf.", ".$sdf[2]." , ".$ehf[0].", ".$ehf[1]."),
              url: '".$rs_cal->fld("cal_url")."&token=".$_SESSION['token']."',
              allDay: false,
              backgroundColor: '".$rs_cal->fld("eve_cor")."', //Success (green)
              borderColor: '".$rs_cal->fld("eve_cor")."' //Success (green)
            },";
        }
        $evts = substr($evts,0,-1);
        
      ?>
      <input type="hidden" id="nc" value="<?=$nc;?>"/>
    

    <!-- jQuery 2.1.4 -->
  <script src="<?=$hosted;?>/sistema/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
  </div>
  <?php
    require_once("../config/footer.php");
  ?></div><!-- ./wrapper -->


<!-- Bootstrap 3.3.5 -->
<script src="<?=$hosted;?>/sistema/assets/bootstrap/js/bootstrap.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<!-- FastClick -->
<script src="<?=$hosted;?>/sistema/assets/plugins/fastclick/fastclick.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=$hosted;?>/sistema/assets/dist/js/app.min.js"></script>
<!-- Slimscroll -->
<script src="<?=$hosted;?>/sistema/assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- Select2 -->
<script src="<?=$hosted;?>/sistema/assets/plugins/select2/select2.full.min.js"></script>
<script src="<?=$hosted;?>/sistema/assets/js/maskinput.js"></script>
<script src="<?=$hosted;?>/sistema/assets/js/jmask.js"></script>
<script src="<?=$hosted;?>/triangulo/js/action_triang.js"></script>
<script src="<?=$hosted;?>/triangulo/js/controle.js"></script>
<script src="<?=$hosted;?>/triangulo/js/jquery.cookie.js"></script>
<script src="<?=$hosted;?>/triangulo/js/functions.js"></script>


<!-- SELECT2 TO FORMS
-->

<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
<!-- Validation -->
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<!-- fullCalendar 2.2.5 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
<script src="<?=$hosted;?>/sistema/assets/plugins/fullcalendar/fullcalendar.min.js"></script>

<!-- Page specific script -->
    <script>
      $(document.body).on("keyup","#new-event",function(){
        var n = 20 - $("#new-event").val().length;
       $("#lblChar").html("Restam "+n+" caracteres...");
      });

      $(function () {
        $(".select2").select2({
          tags: true,
          theme: "classic"
        });
        /* initialize the external events
         -----------------------------------------------------------------*/
        function ini_events(ele) {
          ele.each(function () {

            // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
            // it doesn't need to have a start or end
            var eventObject = {
              title: $.trim($(this).text()) // use the element's text as the event title
            };

            // store the Event Object in the DOM element so we can get to it later
            $(this).data('eventObject', eventObject);

            // make the event draggable using jQuery UI
            $(this).draggable({
              zIndex: 1070,
              revert: true, // will cause the event to go back to its
              revertDuration: 0  //  original position after the drag
            });

          });
        }
        ini_events($('#external-events div.external-event'));

        /* initialize the calendar
         -----------------------------------------------------------------*/
        //Date for the calendar events (dummy data)
        var date = new Date();
        var d = date.getDate(),
                m = date.getMonth(),
                y = date.getFullYear();
        $('#calendar').fullCalendar({
          monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
          monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
          dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sabado'],
          dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
          header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
          },
          buttonText: {
            today: 'hoje',
            month: 'mes',
            week: 'semana',
            day: 'dia'
          },
          //Random default events
          events: [
            
           /* {
              title: 'All Day Event',
              start: new Date(y, m, 29),
              backgroundColor: "#f56954", //red
              borderColor: "#f56954" //red
            },
            {
              title: 'Long Event',
              start: new Date(y, m, d - 5),
              end: new Date(y, m, d - 2),
              backgroundColor: "#f39c12", //yellow
              borderColor: "#f39c12" //yellow
            },
            {
              title: 'Meeting',
              start: new Date(y, m, d, 14, 30),
              allDay: false,
              backgroundColor: "#0073b7", //Blue
              borderColor: "#0073b7" //Blue
            },
            {
              title: 'Lunch',
              start: new Date(y, m, d, 12, 0),
              end: new Date(y, m, d, 14, 0),
              allDay: false,
              backgroundColor: "#00c0ef", //Info (aqua)
              borderColor: "#00c0ef" //Info (aqua)
            },
            {
              title: 'Birthday Party',
              start: new Date(y, m, d + 1, 19, 0),
              end: new Date(y, m, d + 1, 22, 30),
              allDay: false,
              backgroundColor: "#00a65a", //Success (green)
              borderColor: "#00a65a" //Success (green)
            },
            {
              title: 'Click for Google',
              start: new Date(y, m, 28),
              end: new Date(y, m, 29),
              url: 'http://google.com/',
              backgroundColor: "#3c8dbc", //Primary (light-blue)
              borderColor: "#3c8dbc" //Primary (light-blue)
            }*/
            <?=$evts;?>
          ],
          editable: true,
          droppable: true, // this allows things to be dropped onto the calendar !!!
          drop: function (date, allDay) { // this function is called when something is dropped

            // retrieve the dropped element's stored Event Object
            var originalEventObject = $(this).data('eventObject');

            // we need to copy it, so that multiple events don't have a reference to the same object
            var copiedEventObject = $.extend({}, originalEventObject);

            // assign it the date that was reported
            copiedEventObject.start = date;
            copiedEventObject.allDay = allDay;
            copiedEventObject.backgroundColor = $(this).css("background-color");
            copiedEventObject.borderColor = $(this).css("border-color");
            
            // render the event on the calendar
            // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)

            $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);
            var nd = copiedEventObject.start.toString();
            var todos = 0;
            
            // is the "remove after drop" checkbox checked?
            if ($('#drop-remove').is(':checked')) {
              // if so, remove the element from the "Draggable Events" list
              $(this).remove();
            }
            if ($('#drop-visivel').is(':checked')) {
              // if so, remove the element from the "Draggable Events" list
              todos = 1;
            }
              /*Guardando evento no calendário (banco de dados) */
            var _evt = $(this).data("evento");
            var _tit = $(this).data("titulo");
            $.post("../controller/TRIEmpresas.php",{acao:"calendario",evento: _evt, dt: nd, vpt: todos, nc:$("#nc").val(), users:$("#funcs").val()},function(data){
                obj = jQuery.parseJSON(data);
                var msg = "Novo evento: "+_tit + " em "+obj.mensagem;
                $.cookie("vcal",0); //nao visto
                $.cookie("ncal",0); // não notificado
                $.cookie("vmsg", msg);
                notify(msg,"#","CALENDARIO");
                location.reload();
            },"html");
           
            
          }
        });

        function rgb2hex(rgb) {
            if (/^#[0-9A-F]{6}$/i.test(rgb)) return rgb;

            rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
            function hex(x) {
                return ("0" + parseInt(x).toString(16)).slice(-2);
            }
            return "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
        }

        /* ADDING EVENTS */
        var currColor = "#3c8dbc"; //Red by default
        //Color chooser button
        var tema = "";
        var colorChooser = $("#color-chooser-btn");
        $("#color-chooser > li > a").click(function (e) {
          e.preventDefault();
          //Save color
          currColor = $(this).css("color");
          tema = $(this).data("theme");
          //Add color effect to button
          $('#add-new-event').css({"background-color": currColor, "border-color": currColor});
        });
        $("#add-new-event").click(function (e) {
          e.preventDefault();
          //Get value and make sure it is not null
          var val = $("#new-event").val();
          if (val.length == 0) {
            return;
          }

          //Create events
          var event = $("<div />");
          event.css({"background-color": currColor, "border-color": currColor, "color": "#fff"}).addClass("external-event");
          event.html(val);
          $('#external-events').prepend(event);

          //Add draggable funtionality
          ini_events(event);
          //add on database
          var cor_hex = rgb2hex(currColor);
         
          $.post("../controller/TRIEmpresas.php",{acao:"evento",desc: val, cor:cor_hex, tema: tema, dep:11},function(){location.reload();});

          //Remove event from text input
          $("#new-event").val("");
        });
        
      });
    </script>
