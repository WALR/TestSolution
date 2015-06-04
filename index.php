<?php  
require_once('res/conexion.php');
require_once('res/funciones.php');
if(!isset($_SESSION)) 
{ 
    session_start();
}

sessionExp();
//require_once('funciones.php');
?>
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Test Solution</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" href="img/ant-sof.png">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/bootstrap-checkbox.css">
        <link href="css/carousel.css" rel="stylesheet">
        <link href="css/main.css" rel="stylesheet">

        <!-- <link rel="stylesheet" href="css/bootstrap-theme.min.css"> -->
        <script src="js/vendor/modernizr-2.8.3.min.js"></script>
        <script src="js/vendor/jquery-1.11.2.min.js"></script>
        <script src="js/vendor/alert.js"></script>
        <script src="js/vendor/bootstrap.min.js"></script>
        <script src="js/bootstrap-checkbox.js"></script>
        <script src="js/vendor/jquery.PrintArea.js"></script>
        <link rel="stylesheet" href="lib/bootstrap-datepicker/css/bootstrap-datepicker.min.css"></link>
        <link rel="stylesheet" href="lib/bootstrap-datepicker/css/bootstrap-datepicker3.min.css"></link>
        <script src="lib/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
        <script src="lib/bootstrap-datepicker/locales/bootstrap-datepicker.es.min.js"></script>

    </head>
    <body>
    <?php  
      
      include 'templates/nav.php';

      if (isset($_GET['ac'])) {
        switch ($_GET['ac']) {
          case 'inicio':
            include 'templates/principal.php';
            break;
          case 'test':
            include 'test/test.php';
            break;
          case 'antivirus':
            include 'antivirus/antivirus.php';
            break;
          case 'acerca':
            include 'acerca/acerca.php';
            break;
          case 'contacto':
            include 'contacto/contacto.php';
            break;
          case 'login':
            include 'templates/login.php';
            break;
        }

      }else{
        include 'templates/principal.php';
      }
    ?>
      
      </div>
  
      
    </div>
    <script src="js/plugins.js"></script>
    <script src="js/main.js"></script>
    </body>
</html>
