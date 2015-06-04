<?php
if(!isset($_SESSION)) 
{ 
    session_start();
}

if(isset($_SESSION['id'])&&!empty($_SESSION['id'])){ 
// if(1){ 

 ?>


<p><h1 class="text-center">
<span class="label label-info">Certificación</span>
</h1></p><br>
<div role="tabpanel">
  <!-- Nav tabs -->
  <ul id="myTab" class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#generar" aria-controls="generar" role="tab" data-toggle="tab"><b>Generar Certificación</b></a></li>
    <li role="presentation" ><a href="#modificar" aria-controls="modificar" role="tab" data-toggle="tab"><b>Modificar Certificación</b></a></li>
    <li role="presentation"><a href="#reimpresion" aria-controls="reimpresion" role="tab" data-toggle="tab"><b>Reimpresión de Certificación</b></a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="generar">
	    <?php   
          if (isset($_GET['tipo'])) {
	        switch ($_GET['tipo']) {
	          case 'particular':
              sessionExp();
	            include 'certificacion/particular.php';
	            break;
	          case 'oficial':
              sessionExp();
              include 'certificacion/oficial.php';
	            break;
	        }

	        }else{
            sessionExp();
	          include 'certificacion/tipo.php';
	        }
	    ?>
     
    </div> <!-- FIN PESTAÑA GENERAR -->
    <div role="tabpanel" class="tab-pane" id="modificar">
    <?php 
      // if($_SESSION['permiso']>=1101){
      if(1111>=1101){ 
        include 'modificacion/tipo-modificacion.php';
      }else{
        echo '
          <br><br><br>
          <p>
            <h3 class="text-center">
              <span style="font-size: 87px;color:#D9534F;" class="glyphicon glyphicon-warning-sign"></span><br>
              <span class="label label-danger">Usted no tiene permisos para esta area.</span>
            </h3>
          </p>
        ';
      }
    ?>

    </div><!-- FIN PESTAÑA MODIFICAR -->

    <div role="tabpanel" class="tab-pane" id="reimpresion">	
      <?php
      // if($_SESSION['permiso']>=1101){ 
        if(1111>=1101){ 
          include 'reimpresion/tipo-reimpresion.php';
        }else{
          echo '
            <br><br><br>
            <p>
              <h3 class="text-center">
                <span style="font-size: 87px;color:#D9534F;" class="glyphicon glyphicon-warning-sign"></span><br>
                <span class="label label-danger">Usted no tiene permisos para esta area.</span>
              </h3>
            </p>
          ';
        }

       ?>
    </div><!-- FIN PESTAÑA REIMPRESION -->
  </div>
</div>


<script>
// var myApp;


function tipomod() {
    $("#modificar").load('certificacion/modificacion/tipo-modificacion.php');
    $("html, body").animate({ scrollTop: 0 }, 1000);
}
function tiporeimp() {
    $("#reimpresion").load('certificacion/reimpresion/tipo-reimpresion.php');
    $("html, body").animate({ scrollTop: 0 }, 1000);
}
</script>




<?php 
}else{
  include 'login.php';
}

?>