
<?php 
require_once('res/funciones.php');



 ?>
<div id="myCarousel" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="1"></li>
    <li data-target="#myCarousel" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner" role="listbox">
    <div class="item active">
      <img class="first-slide" src="img/ant.jpg" alt="web-dev">
      <div class="container">
        <div class="carousel-caption">
          <h1 style="font-weight:bold;text-shadow: 2px 2px 3px #000000;">My antivirus <span >Test</span></h1>
          <p style="text-align:justify;font-weight:bold;text-shadow: 2px 2px 3px #000000;">Es la mejor herramienta para saber que antivirus se adapta a la tu necesidades y a los requerimientos de tu computadora.</p>
          <p><a class="btn btn-lg btn-primary" href="?ac=test" role="button">Realizar Test</a></p>
        </div>
      </div>
    </div>
    <div class="item">
      <img class="second-slide" src="img/virus.jpg" alt="Virus Informatico">
      <div class="container">
        <div class="carousel-caption">
          <h1 style="font-weight:bold;text-shadow: 2px 2px 3px #000000;">¿Que es un virus?</h1>
          <p style="text-align:justify;font-weight:bold;text-shadow: 2px 2px 3px #000000;">Los virus informáticos tienen mas de 40 años viviendo entre nosotros y nuestros ordenadores. Estos programas maliciosos que buscan acceder a nuestros datos para dañarlos, robarlos, o simplemente molestarnos; han permanecido como una amenaza inamovible en el mundo de la computación, y se hacen cada vez más complejos..</p>
          <!-- <p><a class="btn btn-lg btn-primary" href="#" role="button">Ver mas</a></p> -->
        </div>
      </div>
    </div>
    <div class="item">
      <img class="third-slide" src="img/c-ant2.jpg" alt="Caracteristicas">
      <div class="container">
        <div class="carousel-caption">
          <h1 style="font-weight:bold;text-shadow: 2px 2px #000000;">Características de un buen antivirus</h1>
          <p style="text-align:justify;">
            <ul style="text-align:justify;">
              <li style="font-size:17px;font-weight:bold;text-shadow: 2px 2px 3px #000000;">Actualización sistemática.</li>
              <li style="font-size:17px;font-weight:bold;text-shadow: 2px 2px 3px #000000;">Gran capacidad de desinfección.</li>
              <li style="font-size:17px;font-weight:bold;text-shadow: 2px 2px 3px #000000;">Detección mínima de falsos positivos o falsos virus.</li>
              <li style="font-size:17px;font-weight:bold;text-shadow: 2px 2px 3px #000000;">Presencia de distintos métodos de detección y análisis.</li>
              <li style="font-size:17px;font-weight:bold;text-shadow: 2px 2px 3px #000000;">Integración perfecta con el programa de correo electrónico.</li>
              <li style="font-size:17px;font-weight:bold;text-shadow: 2px 2px 3px #000000;">Respeto por el rendimiento o desempeño normal de los equipos.</li>
              <li style="font-size:17px;font-weight:bold;text-shadow: 2px 2px 3px #000000;">Gran capacidad de detección y de reacción ante un nuevo virus.</li>
              <li style="font-size:17px;font-weight:bold;text-shadow: 2px 2px 3px #000000;">Chequeo del arranque y posibles cambios en el registro de las aplicaciones.</li>
              <li style="font-size:17px;font-weight:bold;text-shadow: 2px 2px 3px #000000;">Alerta sobre una posible infección por las distintas vías de entrada (Internet, correo electrónico, red o discos flexibles).</li> 
            </ul>
          </p>
          <!-- <p><a class="btn btn-lg btn-primary" href="#" role="button">Browse gallery</a></p> -->
        </div>
      </div>
    </div>
  </div>
  <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
<div class="container marketing">
  <div class="row featurette">
    <div class="col-md-7">
      <h2 class="featurette-heading" style="margin-top:0px;">¿Porqué instalar un antivirus? <small>La pregunta del millón.</small></h2>
      <p class="lead" style="text-align:justify;">Si su computadora no posee un antivirus, no tiene la capacidad de remover los virus que puedan llegar a ingresar al sistema y dejan la computadora completamente vulnerable a ataques tales como:</p>
        <ul style="text-align:justify;">
          <li class="lead" style="font-size:17px;">Emails infectados, con anexos ejecutables peligrosos cuando son ejecutados.</li>
          <li class="lead" style="font-size:17px;">Sitios webs en internet infectados que lo llevan a descargar un código malicioso en su computadora, denominado Worms.</li>
          <li class="lead" style="font-size:17px;">Documentos de oficina, como Word y Excel, con Macros que atacan al Sistema Operativo.</li>
          <li class="lead" style="font-size:17px;">Spyware introducido por los virus para espiar datos personales. Algunos antivirus también detectan Spyware.</li>
        </ul>
    </div>
    <div class="col-md-5">
      <img class="featurette-image img-responsive center-block" src="img/lp.jpg" alt="Porque instalar un antivirus">
    </div>
  </div>

  <hr class="featurette-divider">

  <div class="row featurette">
    <div class="col-md-7 col-md-push-5">
      <h2 class="featurette-heading" style="margin-top:10px;">¿Que antivirus utilizar? <br><small class="text-muted">Una decisión dificil.</small></h2>
      <p class="lead" style="text-align:justify;">En el mercado existen muchos antivirus, y la decisión de elegir uno puede ser confusa, ya que casi todos los antivirus realizan la misma función, pero no todos tienen las mismas funcionalidades y requesitos de sistema por lo que puede ser un buen punto a tener en cuenta, así como la disponibilidad o el precio.</p>
    </div>
    <div class="col-md-5 col-md-pull-7">
      <img class="featurette-image img-responsive center-block" src="img/all-ant.jpg" alt="Todos los antivirus">
    </div>
  </div>

  <hr class="featurette-divider">

  <div class="row featurette">
    <div class="col-md-7">
      <h2 class="featurette-heading" style="margin-top:10px;">My Antivirus <span style="color:#004366">Test</span> <br><small class="text-muted">La solución a tus problemas.</small></h2>
      <p class="lead" style="text-align:justify;">Nuestra herramienta con un par de preguntas te podra indicar el antivirus que mejor se ajusta a tus necesidades y a las prestaciones de tu computador, asi podras estar tranquilo sabiendo que tienes la mejor protección para ti.</p>
      <p><a class="btn btn-lg btn-primary" href="?ac=test" role="button">Realizar Test</a></p>
    </div>
    <div class="col-md-5" style="margin-top:-32px;">
      <!-- <span class="glyphicon glyphicon-tasks" aria-hidden="true" style="font-size: 23em;color: #4E78BC;"></span> -->
      <img class="featurette-image img-responsive center-block" src="img/ant-sof.png" alt="My antivirus">
    </div>
  </div>

  <hr class="featurette-divider">

  <!-- Three columns of text below the carousel -->
  <div class="row">
    <?php
      $antivirus = obtenerAntivirusr();
      foreach ($antivirus as $ant) {
          echo '<div class="col-lg-4">
                  <img class="img-circle" src="img/'.$ant->imagen.'" alt="'.$ant->nombre.'" width="140" height="140">
                  <h2>'.$ant->nombre.'</h2>
                  <p style="text-align:justify;">'.$ant->descripcion.'</p>
                  <p><a class="btn btn-default" href="?ac=antivirus&ant='.$ant->id.'" role="button">Ver detalles &raquo;</a></p>
                </div>'; 
      }
    ?> 
  </div>

  <footer>
    <p class="pull-right"><a href="#">Arriba</a></p>
    <p>&copy; 2015 Test Solution, Inc. &middot; <a href="#">Privacidad</a> &middot; <a href="#">Terminos</a></p>
  </footer>

</div>