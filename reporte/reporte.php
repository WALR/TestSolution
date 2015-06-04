<?php 
ini_set('display_errors', 'On');
ini_set('display_errors', 0); 
require_once('res/funciones.php');
//if(isset($_SESSION['id'])&&!empty($_SESSION['id'])){ 
if(1){ 
	// if(11011>=$_SESSION['permiso']){   

?>

<p>
<h1 class="text-center">
<span class="label label-info">Reportes Estadisticos</span>
</h1></p><br>
<?php 
	include 'reporte/reporteCertificacion.php';
	include 'reporte/reporteOrden.php';

	// }else{
 //        echo '
 //          <br><br><br>
 //          <p>
 //            <h3 class="text-center">
 //              <span style="font-size: 87px;color:#D9534F;" class="glyphicon glyphicon-warning-sign"></span><br>
 //              <span class="label label-danger">Usted no tiene permisos para esta area.</span>
 //            </h3>
 //          </p>
 //        ';
 //      }

}else{
  include 'login.php';
}
 ?>