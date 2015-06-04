<div class="container marketing">
  <div class="row featurette" style="margin:80px 0;">
    <div class="col-md-12">
        <h2 class="featurette-heading" style="margin-top:10px;">My Antivirus <span style="color:#004366">Test</span> <br></h2>
        <hr>
        <form>
            <div class="form-group col-md-12">
              <label class="form-group col-lg-12">Selecciona tu sistema operativo:</label>
              <div class="form-group col-lg-4">
                <img class="img-circle" src="img/logo-windows.jpg" alt="Windows" width="140" height="140">
                <div class="checkbox">
                  <label><input type="radio" name="os" onchange="arqt('windows');" value="windows" /> Windows</label>
                </div>
                <div class="form-group col-md-12" id="arwindows" hidden>
                  <div class="form-group col-md-6">
                    <label for="ram">Arquitectura <a tabindex="0" data-toggle="popover" data-trigger="focus" data-placement="top" title="Arquitectura" data-content="La arquitectura de computadoras es el diseño conceptual y la estructura operacional fundamental de un sistema de computadora.<br><a class='btn btn-primary' onclick='miArquitecutra();'>¿Cual es mi Arquitectura?</a>"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span></a></label>
                    <div class="input-group">
                      <input type="text" class="form-control" id="arqwindows" placeholder="Arquitectura">
                      <div class="input-group-addon">Bits</div>
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="ram">RAM <a tabindex="0" data-toggle="popover" data-trigger="focus" data-placement="top" title="Memoria RAM" data-content="En la RAM se cargan todas las instrucciones que ejecutan la unidad central de procesamiento (procesador) y otras unidades de cómputo.<br><a class='btn btn-primary' onclick='miRAM();'>¿Cuanto de RAM tengo?</a>"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span></a></label>
                    <div class="input-group">
                      <input type="number" class="form-control" id="ram" placeholder="RAM">
                      <div class="input-group-addon">RAM</div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group col-lg-4">
                <img class="img-circle" src="img/logo-mac.jpg" alt="MacOs" width="140" height="140">
                <div class="checkbox">
                  <label><input type="radio" name="os" onchange="arqt('mac');" value="macos" /> Mac OS</label>
                </div>
                <div class="form-group col-md-12" id="armac" hidden>
                  <div class="form-group col-md-6">
                    <label for="ram">Arquitectura <a tabindex="0" data-toggle="popover" data-trigger="focus" data-placement="top" title="Arquitectura" data-content="La arquitectura de computadoras es el diseño conceptual y la estructura operacional fundamental de un sistema de computadora.<br><a class='btn btn-primary' onclick='miArquitecutra();'>¿Cual es mi Arquitectura?</a>"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span></a></label>
                    <div class="input-group">
                      <input type="text" class="form-control" id="arqwindows" placeholder="Arquitectura">
                      <div class="input-group-addon">Bits</div>
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="ram">RAM <a tabindex="0" data-toggle="popover" data-trigger="focus" data-placement="top" title="Memoria RAM" data-content="En la RAM se cargan todas las instrucciones que ejecutan la unidad central de procesamiento (procesador) y otras unidades de cómputo.<br><a class='btn btn-primary' onclick='miRAM();'>¿Cuanto de RAM tengo?</a>"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span></a></label>
                    <div class="input-group">
                      <input type="number" class="form-control" id="ram" placeholder="RAM">
                      <div class="input-group-addon">RAM</div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group col-lg-4">
                <img class="img-circle" src="img/logo-linux.png" alt="Linux" width="140" height="140">
                <div class="checkbox">
                  <label><input type="radio" name="os" onchange="arqt('linux');" value="linux" /> Linux</label>
                </div>
                <div class="form-group col-md-12" id="arlinux" hidden>
                  <div class="form-group col-md-6">
                    <label for="ram">Arquitectura <a tabindex="0" data-toggle="popover" data-trigger="focus" data-placement="top" title="Arquitectura" data-content="La arquitectura de computadoras es el diseño conceptual y la estructura operacional fundamental de un sistema de computadora.<br><a class='btn btn-primary' onclick='miArquitecutra();'>¿Cual es mi Arquitectura?</a>"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span></a></label>
                    <div class="input-group">
                      <input type="text" class="form-control" id="arqwindows" placeholder="Arquitectura">
                      <div class="input-group-addon">Bits</div>
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="ram">RAM <a tabindex="0" data-toggle="popover" data-trigger="focus" data-placement="top" title="Memoria RAM" data-content="En la RAM se cargan todas las instrucciones que ejecutan la unidad central de procesamiento (procesador) y otras unidades de cómputo.<br><a class='btn btn-primary' onclick='miRAM();'>¿Cuanto de RAM tengo?</a>"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span></a></label>
                    <div class="input-group">
                      <input type="number" class="form-control" id="ram" placeholder="RAM">
                      <div class="input-group-addon">RAM</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group col-md-12"> 
              <label for="usos">Seleccione los usos cotidiano de su computadora:</label>           
              <div data-toggle="buttons">
                <label class="sp btn btn-primary">
                  <input type="checkbox"> Tareas de la Universidad
                </label>
                <label class="sp btn btn-primary">
                  <input type="checkbox"> Profesional (Trabajo)
                </label>
                <label class="sp btn btn-primary">
                  <input type="checkbox"> Redes Sociales
                </label>
                <label class="sp btn btn-primary">
                  <input type="checkbox"> Descargar Musica
                </label>
                <label class="sp btn btn-primary">
                  <input type="checkbox"> Descargar Video y/o Peliculas
                </label>
                <label class="sp btn btn-primary">
                  <input type="checkbox"> Almacenamiento de Documentos/Fotos/Videos
                </label>
                <label class="sp btn btn-primary">
                  <input type="checkbox"> Almacenamiento de Documento
                </label>
                <label class="sp btn btn-primary">
                  <input type="checkbox"> Profesional (Trabajo)
                </label>
                <label class="sp btn btn-primary">
                  <input type="checkbox"> Redes Sociales
                </label>
              </div>
            </div>
            <hr>
            <div class="form-group col-md-6 col-md-offset-5">
              <button type="submit" class="btn btn-success btn-lg">
                <span class="glyphicon glyphicon-send" aria-hidden="true"></span>
                Enviar
              </button>
            </div>
        </form>
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
                <img class="img-thumbnail center-block" src="img/iconmac.png" alt="Mac OS Icon" width="150" height="150"> 
                <br>
                &raquo; Después hay que hacer click en "<b>Acerca de esta Mac</b>".
                <br>
                <img class="img-thumbnail center-block" src="img/menumac.png" alt="Mac OS Menu" width="150" height="150"> 
                <br>
                &raquo; En la nueva ventana se podrá ver el nombre del procesador que usa el computador. Finalmente se debe comparar el nombre que tiene con la tabla de arriba para saber si es un CPU de 32 o 64.
              </p>
            </div>
            <div class="well">
              <legend>Linux</legend>
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
  console.log("Mi arquitectura");
}

function miRAM(){
  console.log("RAM");
}

$(document).ready(function(){
    $('[data-toggle="popover"]').popover({html : true, container: 'body' });   
});
</script>