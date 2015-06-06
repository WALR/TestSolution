<?php 
require_once('res/funciones.php');



 ?>

<div class="container marketing">
    <?php 
    if (isset($_GET['ant'])) {

        $anti = obtenerAntivirusDetalle($_GET['ant']);
        echo '<div class="row featurette" style="margin:80px 0;">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="well well-sm">
                            <div class="row">
                                <div class="col-sm-6 col-md-4">
                                    <img src="img/'.$anti->imagen.'" alt="'.$anti->nombre.'" class="img-rounded img-responsive" />
                                </div>
                                <div class="col-sm-6 col-md-8">
                                    <div class="pull-left col-md-6">
                                      <h2>'.$anti->nombre.'</h2>
                                    </div>
                                    <div class="text-right pull-right col-md-6">
                                        Precio: <br/> 
                                        <span class="h3 text-muted"><strong> Q.'.$anti->precio.' </strong></span></span> 
                                    </div>
                                    <p class="col-md-12">

                                         '.$anti->descripcion.'
                                        <br/>
                                        <br>
                                        <i class="glyphicon glyphicon-time"></i> Licencia por <strong>1 año</strong>
                                        <span class="pull-right" style="font-size:1.5em;color:#f1c40f;">
                                          <span class="glyphicon glyphicon-star"></span>
                                          <span class="glyphicon glyphicon-star"></span>
                                          <span class="glyphicon glyphicon-star"></span>
                                          <span class="glyphicon glyphicon-star"></span>
                                          <span class="glyphicon glyphicon-star-empty"></span>
                                        </span>
                                    </p>
                                    <div class="col-md-12 btn-group">
                                      <hr>
                                      <a href="?ac=antivirus" class="btn btn-default btn-lg pull-left"> 
                                        <span class="glyphicon glyphicon-chevron-left"></span> 
                                        Ver Listado 
                                      </a>
                                      <button type="button" class="btn btn-success btn-lg pull-right"> Comprar ahora! </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
              </div>'; 
        

      }else{
  ?>
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
                        <a class="pull-right btn btn-default" href="?ac=antivirus&ant='.$ant->id.'" role="button">Ver detalles &raquo;</a>
                      </p>
                    </div>
                  </div>
                </div>';        
        }
      ?>                            
    </div>
  </div>
  <?php 
    }
  ?>

  <hr class="featurette-divider">
  <footer>
    <p class="pull-right"><a href="#">Arriba</a></p>
    <p>&copy; 2015 Test Solution, Inc. &middot; <a href="#">Privacidad</a> &middot; <a href="#">Terminos</a></p>
  </footer>
</div>