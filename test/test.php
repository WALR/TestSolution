<?php 
require_once('res/funciones.php');



 ?>

<div class="container marketing">
  <div id="testSet" class="row featurette" style="margin:80px 0;" >
    <div class="col-md-12">
        <h2 class="featurette-heading" style="margin-top:10px;">My Antivirus <span style="color:#004366">Test</span> <br></h2>
        <hr>
        <div class="form-group col-md-12">
          <label class="form-group col-lg-11 col-md-offset-1">Selecciona tu sistema operativo:</label>
          <div class="form-group col-lg-4">
            <img class="img-circle" src="img/logo-windows.jpg" alt="Windows" width="140" height="140">
            <div class="checkbox">
              <label><input type="radio" name="os" class="os" onchange="arqt('windows');" value="windows" data-toggle="tooltip" data-placement="top" title="Seleccione su Sistema Operativo" /> Windows</label>
            </div>
            <div class="form-group col-md-12" id="arwindows" hidden>
              <div class="form-group col-md-6">
                <label for="ram">Arquitectura <a tabindex="0" data-toggle="popover" data-trigger="focus" data-placement="top" title="Arquitectura" data-content="La arquitectura de computadoras es el diseño conceptual y la estructura operacional fundamental de un sistema de computadora.<br><a class='btn btn-primary' onclick='miArquitecutra();'>¿Cual es mi Arquitectura?</a>"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span></a></label>
                <div class="input-group">
                  <input type="text" onkeypress="return checkSoloNum(event)" class="form-control" id="arqwindows" placeholder="Arquitectura" data-toggle="tooltip" data-placement="top" title="Ingrese su Arquitectura">
                  <div class="input-group-addon">Bits</div>
                </div>
              </div>
              <div class="form-group col-md-6">
                <label for="ram">RAM <a tabindex="0" data-toggle="popover" data-trigger="focus" data-placement="top" title="Memoria RAM" data-content="En la RAM se cargan todas las instrucciones que ejecutan la unidad central de procesamiento (procesador) y otras unidades de cómputo.<br><a class='btn btn-primary' onclick='miRAM();'>¿Cuanto de RAM tengo?</a>"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span></a></label>
                <div class="input-group">
                  <input type="text" onkeypress="return checkSoloNum(event)" class="form-control" id="ramwindows" placeholder="RAM" tabindex="1" data-toggle="tooltip" data-placement="top" title="Ingrese su cantidad de memoria RAM">
                  <div class="input-group-addon">
                    <select name="ram" id="ram">
                      <option value="gb">GB</option>
                      <option value="mb">MB</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group col-lg-4">
            <img class="img-circle" src="img/logo-mac.jpg" alt="MacOs" width="140" height="140">
            <div class="checkbox">
              <label><input type="radio" name="os" class="os" onchange="arqt('mac');" value="mac" data-toggle="tooltip" data-placement="top" title="Seleccione su Sistema Operativo"/> Mac OS</label>
            </div>
            <div class="form-group col-md-12" id="armac" hidden>
              <div class="form-group col-md-6">
                <label for="ram">Arquitectura <a tabindex="0" data-toggle="popover" data-trigger="focus" data-placement="top" title="Arquitectura" data-content="La arquitectura de computadoras es el diseño conceptual y la estructura operacional fundamental de un sistema de computadora.<br><a class='btn btn-primary' onclick='miArquitecutra();'>¿Cual es mi Arquitectura?</a>"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span></a></label>
                <div class="input-group">
                  <input type="text" onkeypress="return checkSoloNum(event)" class="form-control" id="arqmac" placeholder="Arquitectura" data-toggle="tooltip" data-placement="top" title="Ingrese su Arquitectura">
                  <div class="input-group-addon">Bits</div>
                </div>
              </div>
              <div class="form-group col-md-6">
                <label for="ram">RAM <a tabindex="0" data-toggle="popover" data-trigger="focus" data-placement="top" title="Memoria RAM" data-content="En la RAM se cargan todas las instrucciones que ejecutan la unidad central de procesamiento (procesador) y otras unidades de cómputo.<br><a class='btn btn-primary' onclick='miRAM();'>¿Cuanto de RAM tengo?</a>"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span></a></label>
                <div class="input-group">
                  <input type="text" onkeypress="return checkSoloNum(event)" class="form-control" id="rammac" placeholder="RAM" data-toggle="tooltip" data-placement="top" title="Ingrese su cantidad de memoria RAM">
                  <div class="input-group-addon">
                    <select name="ram" id="ram">
                      <option value="gb">GB</option>
                      <option value="mb">MB</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group col-lg-4">
            <img class="img-circle" src="img/logo-linux.png" alt="Linux" width="140" height="140">
            <div class="checkbox">
              <label><input type="radio" name="os" class="os" onchange="arqt('linux');" value="linux" data-toggle="tooltip" data-placement="top" title="Seleccione su Sistema Operativo"/> Linux</label>
            </div>
            <div class="form-group col-md-12" id="arlinux" hidden>
              <div class="form-group col-md-6">
                <label for="ram">Arquitectura <a tabindex="0" data-toggle="popover" data-trigger="focus" data-placement="top" title="Arquitectura" data-content="La arquitectura de computadoras es el diseño conceptual y la estructura operacional fundamental de un sistema de computadora.<br><a class='btn btn-primary' onclick='miArquitecutra();'>¿Cual es mi Arquitectura?</a>"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span></a></label>
                <div class="input-group">
                  <input type="text" onkeypress="return checkSoloNum(event)" class="form-control" id="arqlinux" placeholder="Arquitectura" data-toggle="tooltip" data-placement="top" title="Ingrese su Arquitectura">
                  <div class="input-group-addon">Bits</div>
                </div>
              </div>
              <div class="form-group col-md-6">
                <label for="ram">RAM <a tabindex="0" data-toggle="popover" data-trigger="focus" data-placement="top" title="Memoria RAM" data-content="En la RAM se cargan todas las instrucciones que ejecutan la unidad central de procesamiento (procesador) y otras unidades de cómputo.<br><a class='btn btn-primary' onclick='miRAM();'>¿Cuanto de RAM tengo?</a>"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span></a></label>
                <div class="input-group">
                  <input type="text" onkeypress="return checkSoloNum(event)" class="form-control" id="ramlinux" placeholder="RAM" data-toggle="tooltip" data-placement="top" title="Ingrese su cantidad de memoria RAM">
                  <div class="input-group-addon">
                    <select name="ram" id="ram">
                      <option value="gb">GB</option>
                      <option value="mb">MB</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group col-md-12">
          <label id="usocot" class="form-group col-lg-11 col-md-offset-1" data-toggle="tooltip" data-placement="top" title="Seleccione al menos un uso cotidiano">Seleccione los usos cotidiano de su computadora:</label> 
          <div class="col-xl-8 col-sm-8 col-md-8 col-md-offset-2">
            <div data-toggle="buttons">
              <label class="sp btn btn-info">
                <input type="checkbox" name="uso"> Almacenamiento de Documentos/Fotos/Videos
              </label>
              <label class="sp btn btn-info">
                <input type="checkbox" name="uso"> Descargar Video y/o Peliculas
              </label>
              <label class="sp btn btn-info">
                <input type="checkbox" name="uso"> Descargar Musica
              </label>
              <label class="sp btn btn-info">
                <input type="checkbox" name="uso"> Redes Sociales
              </label>
              <label class="sp btn btn-info">
                <input type="checkbox" name="uso"> Entretenimiento
              </label>
              <label class="sp btn btn-info">
                <input type="checkbox" name="uso"> Navegar en Internet
              </label>
              <label class="sp btn btn-info">
                <input type="checkbox" name="uso"> Tareas de la Universidad
              </label>
              <label class="sp btn btn-info">
                <input type="checkbox" name="uso"> Profesional (Trabajo)
              </label>
              <label class="sp btn btn-info">
                <input type="checkbox" name="uso"> Manejo de Finanzas
              </label>
              <label class="sp btn btn-info">
                <input type="checkbox" name="uso"> Mi Empresa
              </label>
            </div>
          </div>
        </div>
        <div class="form-group col-md-12">
          <label id="prog" class="form-group col-lg-11 col-md-offset-1" data-toggle="tooltip" data-placement="top" title="Seleccione al menos un programa">Seleccione los programas que tiene instalados su computadora:</label> 
          <div class="col-xl-8 col-sm-8 col-md-8 col-md-offset-2">
            <div data-toggle="buttons">
              <label class="sp btn btn-info">
                <input type="checkbox" name="prog"> Ares
              </label>
              <label class="sp btn btn-info">
                <input type="checkbox" name="prog"> Softonic
              </label>
              <label class="sp btn btn-info">
                <input type="checkbox" name="prog"> Internet Explorer
              </label>
              <label class="sp btn btn-info">
                <input type="checkbox" name="prog"> uTorrent
              </label>
              <label class="sp btn btn-info">
                <input type="checkbox" name="prog"> eMule
              </label>
              <label class="sp btn btn-info">
                <input type="checkbox" name="prog"> aTube Catcher
              </label>
              <label class="sp btn btn-info">
                <input type="checkbox" name="prog"> Youtube Downloader
              </label>
              <label class="sp btn btn-info">
                <input type="checkbox" name="prog"> VideoTodo
              </label>
              <label class="sp btn btn-info">
                <input type="checkbox" name="prog"> 4Shared
              </label>
              <label class="sp btn btn-info">
                <input type="checkbox" name="prog"> Otros
              </label>
            </div>
          </div>
        </div>
        <hr>
        <div class="form-group col-md-6 col-md-offset-5">
          <button onclick="testRecom();" class="btn btn-success btn-lg">
            <span class="glyphicon glyphicon-send" aria-hidden="true"></span>
            Enviar Test
          </button>
        </div>
    </div>
  </div>
  
  <div id="recom" class="row featurette" style="margin:80px 0;" hidden>
    <div class="well">
        <span class="pull-left">
          <a class="btn btn-lg btn-default" href="?ac=test" role="button">
            <span class="glyphicon glyphicon-chevron-left"></span>
            Realizar Test
          </a>
        </span>
        <h1 class="text-center">Antivirus Recomendados para ti</h1>
        <div class="list-group">
          <?php
            $antivirus = obtenerAntivirusr();
            $i=1;
            foreach ($antivirus as $ant) {
                $ac = "active";
                if ($i>1) {
                  $ac = ""; 
                }
                echo '<a class="list-group-item '.$ac.'">
                        <div class="media col-md-3">
                            <figure class="pull-left">
                                <img class="media-object img-rounded img-responsive"  src="img/'.$ant->imagen.'" alt="'.$ant->nombre.'" width="350" height="200" style="height: 200px;width: 350px;">
                            </figure>
                        </div>
                        <div class="col-md-6">
                            <h4 class="list-group-item-heading"><b>'.$ant->nombre.'</b></h4>
                            <p class="list-group-item-text"> 
                            <b>'.$ant->descripcion.'</b>
                            </p>
                        </div>
                        <div class="col-md-3 text-center">
                            <h2> Q.'.$ant->precio.'</h2>
                            <button type="button" class="btn btn-success btn-lg btn-block"> Comprar ahora! </button>
                            <div class="stars">
                                <span class="glyphicon glyphicon-star"></span>
                                <span class="glyphicon glyphicon-star"></span>
                                <span class="glyphicon glyphicon-star"></span>
                                <span class="glyphicon glyphicon-star"></span>
                                <span class="glyphicon glyphicon-star-empty"></span>
                            </div>
                            <p> Licencia por 1 año</p>
                        </div>
                  </a>'; 
                  $i++;       
            }
          ?> 
        </div>
    </div>
  </div>
</div>

  <div id="ModalArquitectura" class="modal fade">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title Colet" style="font-weight: 700;">¿Cual es mi Arquitectura?</h4>
          </div>
          <div class="modal-body">
            <div class="well">
              <legend>Windows</legend>
              <p>
                &raquo; Se comienza buscando el icono de "<b>Mi PC"</b>
                <br>
                <img class="img-thumbnail center-block" src="img/mipc.jpg" alt="Windows Mi PC" width="150" height="150"> 
                <br>
                &raquo; Luego hacer click derecho sobre él y después en 
                "<b>Propiedades</b>" al final del menú contextual.
                <br>
                <img class="img-thumbnail center-block" src="img/opciones.png" alt="Windows Opciones" width="150" height="150"> 
                <br> 
                &raquo; Aparecerá una ventana nueva con información del sistema. 
                Hay que ubicar "<b>Tipo de Sistema</b>".
                <br>
                <img class="img-thumbnail center-block" src="img/sistemawin.png" alt="Windows Sistema" width="650" height="350"> 
                <br>
                &raquo; Ahi aparecera "Sistema operativo de <b>32 bits</b> ó <b>64 bits</b>" siendo esa tu arquitectura.
              </p>
            </div>
            <div class="well">
              <legend>Mac OS</legend>
              <p>
                &raquo; En la barra ubicada en la parte superior de la pantalla, hacer click sobre el icono de la manzana que se encuentra en el extremo izquierdo.
                <br>
                <img class="img-thumbnail center-block" src="img/iconmac.png" alt="Mac OS Icon" width="150" height="150" /> 
                <br>
                &raquo; Después hay que hacer click en "<b>Acerca de esta Mac</b>".
                <br>
                <img class="img-thumbnail center-block" src="img/menumac.jpg" alt="Mac OS Menu" width="150" height="150" /> 
                <br>
                &raquo; En la nueva ventana se podrá ver el nombre del procesador que usa el computador. 
                <br>
                <img class="img-thumbnail center-block" src="img/acercamac.png" alt="Mac OS Acerca" width="150" height="150" /> 
                <br>
                &raquo; Finalmente se debe comparar el nombre del procesador con la siguiente tabla para saber si su arquitectura es de 32 o 64 bits.
                <br>
                <img class="img-thumbnail center-block" src="img/tbmac.jpg" alt="Mac OS Menu" width="650" height="350" /> 
                <br>
              </p>
            </div>
            <div class="well">
              <legend>Linux</legend>
              <p>
                &raquo; Simplente entra a la terminar presionando <b>Ctrl+t</b>.
                <br>
                <img class="img-thumbnail center-block" src="img/terminal.png" alt="Linux Terminal" width="650" height="350" /> 
                <br>
                &raquo; Luego escribe el comando <b>uname -a </b>.
                <br>
                <img class="img-thumbnail center-block" src="img/teminal2.png" alt="Linux Terminal 2 OS Menu" width="650" height="350" /> 
                <br>
                &raquo; Tu arquitectura es de <b>32 bits</b> si el resultado muestra algo parecido a: <br>
                Linux discworld 2.6.38-8-generic #42-Ubuntu SMP Mon Apr 15 03:31:50 UTC 2015 <b>i686 i686 i386</b> GNU/Linux. 
                <br>
                <br>
                &raquo; Por el contratio tu arquitectura es de <b>64 bits</b> si el resultado muestra algo parecido a: <br>
                Linux ralv 3.13.0-53-generic #89-Ubuntu SMP Wed May 20 10:34:39 UTC 2015 <b>x86_64 x86_64 x86_64</b> GNU/Linux. 
                <br>
              </p>
            </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          </div>
      </div>
    </div>
  </div>

  <div id="ModalRAM" class="modal fade">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title Colet" style="font-weight: 700;">¿Cuanto de RAM tengo?</h4>
          </div>
          <div class="modal-body">
            <div class="well">
              <legend>Windows</legend>
              <p>
                &raquo; Se comienza buscando el icono de "<b>Mi PC"</b>
                <br>
                <img class="img-thumbnail center-block" src="img/mipc.jpg" alt="Windows Mi PC" width="150" height="150"> 
                <br>
                &raquo; Luego hacer click derecho sobre él y después en 
                "<b>Propiedades</b>" al final del menú contextual.
                <br>
                <img class="img-thumbnail center-block" src="img/opciones.png" alt="Windows Opciones" width="150" height="150"> 
                <br> 
                &raquo; Aparecerá una ventana nueva con información del sistema. 
                Hay que ubicar "<b>Tipo de Sistema</b>".
                <br>
                <img class="img-thumbnail center-block" src="img/sistemawin.png" alt="Windows Sistema" width="650" height="350"> 
                <br>
                &raquo; Ahi aparecera "Memoria Instalada (RAM) <b>4 GB</b>" siendo esa tu RAM.
              </p>
            </div>
            <div class="well">
              <legend>Mac OS</legend>
              <p>
                &raquo; En la barra ubicada en la parte superior de la pantalla, hacer click sobre el icono de la manzana que se encuentra en el extremo izquierdo.
                <br>
                <img class="img-thumbnail center-block" src="img/iconmac.png" alt="Mac OS Icon" width="150" height="150" /> 
                <br>
                &raquo; Después hay que hacer click en "<b>Acerca de esta Mac</b>".
                <br>
                <img class="img-thumbnail center-block" src="img/menumac.jpg" alt="Mac OS Menu" width="150" height="150" /> 
                <br>
                &raquo; En la nueva ventana en "Memoria <b>16 GB</b>" siendo esa tu RAM. 
                <br>
                <img class="img-thumbnail center-block" src="img/acercamac.png" alt="Mac OS Acerca" width="650" height="350" /> 
                <br>
              </p>
            </div>
            <div class="well">
              <legend>Linux</legend>
              <p>
                &raquo; Simplente entra a la terminar presionando <b>Ctrl+t</b>.
                <br>
                <img class="img-thumbnail center-block" src="img/terminal.png" alt="Linux Terminal" width="650" height="350" /> 
                <br>
                &raquo; Luego escribe el comando <b>sudo dmidecode --type memory</b>.
                <br>
                <img class="img-thumbnail center-block" src="img/terminalram.png" alt="Linux Terminal 2" width="650" height="350" /> 
                <br>
                &raquo; En la linea "Maximum Capacity: <b>4 GB</b>" siendo esa tu RAM.
                <br>
              </p>
            </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          </div>
      </div>
    </div>
  </div>







  <hr class="featurette-divider">
  <footer>
    <p class="pull-right"><a href="#">Arriba</a></p>
    <p>&copy; 2015 Test Solution, Inc. &middot; <a href="#">Privacidad</a> &middot; <a href="#">Terminos</a></p>
  </footer>
</div>


<script>
function testRecom(){
  // console.log($('input:radio[name="os"]').is(":checked"));
  if (!$('input:radio[name="os"]').is(":checked")) {
    $('input:radio[name="os"]').tooltip('show');
  }else{
    var sl = $('input:radio[name="os"]:checked').val();
    if ($('#arq'+sl).val()=="") {
      $('#arq'+sl).focus();
      $('#arq'+sl).tooltip('show');
    }else{
      if ($('#ram'+sl).val()=="") {
        $('#ram'+sl).focus();
        $('#ram'+sl).tooltip('show');
      }else{
        usocot
        if (!$('input:checkbox[name="uso"]').is(":checked")) {
          $('#usocot').tooltip('show');
        }else{
          if (!$('input:checkbox[name="prog"]').is(":checked")) {
            $('#prog').tooltip('show');
          }else{
            $("#testSet").slideUp('slow');
            $("#recom").slideDown('slow');
            $("html, body").animate({ scrollTop: 0 }, 1000);
          }
        }
      }
    }
  }

}


function arqt(tp) {
  switch(tp){
    case 'windows':
      $("#arwindows").slideDown('slow');
      $("#armac").slideUp('slow');
      $("#arlinux").slideUp('slow');
    break;
    case 'mac':
      $("#arwindows").slideUp('slow');
      $("#armac").slideDown('slow');
      $("#arlinux").slideUp('slow');
    break;
    case 'linux':
      $("#arwindows").slideUp('slow');
      $("#armac").slideUp('slow');
      $("#arlinux").slideDown('slow');
    break;
  }
}

function miArquitecutra(){
  $('#ModalArquitectura').modal('show');
}

function miRAM(){
  $('#ModalRAM').modal('show');
}

$(document).ready(function(){
    $('[data-toggle="popover"]').popover({ trigger: "manual" , html: true, container: 'body', animation:false})
      .on("mouseenter", function () {
          var _this = this;
          $(this).popover("show");
          $(".popover").on("mouseleave", function () {
              $(_this).popover('hide');
          });
      }).on("mouseleave", function () {
          var _this = this;
          setTimeout(function () {
              if (!$(".popover:hover").length) {
                  $(_this).popover("hide");
              }
          }, 300);
    });   

});
</script>