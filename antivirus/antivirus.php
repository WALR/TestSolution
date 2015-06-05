<?php 
require_once('res/funciones.php');



 ?>

<div class="container marketing">
  <div class="row featurette" style="margin:80px 0;">
    <h2 class="featurette-heading" style="margin-top:10px;">Listado de Antivirus<br></h2>
    <hr>
    <div class="row">
      <?php
        $antivirus = obtenerAntivirus();
        foreach ($antivirus as $ant) { 
            echo '<div class="col-xl-4 col-sm-4 col-md-4 col-lg-4">
                  <div class="thumbnail" style="height: 34em;">
                    <img class="img-circle" src="img/'.$ant->imagen.'" alt="'.$ant->nombre.'" width="140" height="140" style="height: 140px;width: 140px;">
                    <div class="caption">
                      <h2>'.$ant->nombre.'</h2>
                      <p style="text-align:justify;">'.$ant->descripcion.'</p>
                      <hr>
                      <p>
                        <span class="pull-left label label-primary" style="font-size:18px;">
                          Q.'.$ant->precio.'
                        </span>
                        <a class="pull-right btn btn-default" onclick="detalleAntivirus('.$ant->id.');" role="button">Ver detalles &raquo;</a>
                      </p>
                    </div>
                  </div>
                </div>';        
        }
      ?>                            
    </div>
  </div>

  <hr class="featurette-divider">
  <footer>
    <p class="pull-right"><a href="#">Arriba</a></p>
    <p>&copy; 2015 Test Solution, Inc. &middot; <a href="#">Privacidad</a> &middot; <a href="#">Terminos</a></p>
  </footer>
</div>