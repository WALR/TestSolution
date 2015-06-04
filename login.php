<?php 
require_once('res/funciones.php');
ini_set('display_errors', 'Off');
ini_set('display_errors', 0); 

if(!isset($_SESSION)) 
{ 
    session_start(); 
}


if (!empty($_POST['user'])&&!empty($_POST['pass'])) {		
  logeo($_POST['user'], $_POST['pass']);
  if(isset($_SESSION['id'])&&!empty($_SESSION['id'])){

     if (isset($_GET['ac'])) {
        switch ($_GET['ac']) {
          case 'inicio':
            echo '<script type="text/javascript">window.location="?ac=inicio";</script>';
            break;
          case 'ordenpago':
            echo '<script type="text/javascript">window.location="?ac=ordenpago";</script>';
            break;

          case 'certificacion':
            echo '<script type="text/javascript">window.location="?ac=certificacion";</script>';
            break;

          case 'oficial':
            echo '<script type="text/javascript">window.location="?ac=oficial";</script>';
            break;

          case 'reporte':
            echo '<script type="text/javascript">window.location="?ac=reporte";</script>';
            break;

          case 'cambio':
            echo '<script type="text/javascript">window.location="?ac=cambio";</script>';
            break;


          }

        }else{
          echo '<script type="text/javascript">window.location="?ac=inicio";</script>';

        }
  }else{
    echo "<script> $(document).on('ready',function(){ $.bootstrapGrowl('Usuario y/o contraseña <strong>Incorrecta!</strong>', {type: 'danger', width: '500', offset: {from: 'top', amount: 90}, delay: 4000, stackup_spacing: 10 }); });</script>";
  }
}

?>

<br><br><br>
<p><h1 class="text-center">
<span class="label label-info">Requiere inicio de sesión</span>
</h1></p><br>
<div class="col-xl-12 col-sm-12 col-md-12 col-md-offset-">
    <form action="?ac=<?php echo $_GET['ac']; ?>" method="post" class="form-signin">
      <h2 class="form-signin-heading Colet">Ingrese sus datos</h2>
      <label for="inputEmail" class="sr-only">Usuario</label>
      <input type="text" id="user" name="user" class="form-control" placeholder="Usuario" required autofocus><br>
      <label for="inputPassword" class="sr-only">Contraseña</label>
      <input type="password" id="pass" name="pass" class="form-control" placeholder="Contraseña" required>
      <button class="btn btn-lg btn-primary btn-block" type="submit">Ingresar</button>
    </form>
</div>
