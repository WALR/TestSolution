<?php 
if(!isset($_SESSION)) 
{ 
    session_start(); 
}
	$html="
	<html>
	<head>
		<style>
		/*Area de Impresion*/
		.PrintArea{
		  background-color: white;
		  text-align: justify;
		  font-family: verdana;
		  font-weight: normal;
		  font-size: 12px !important;
		  margin-bottom: 2cm;
		  margin-top: 2cm;
		  margin-left: 3cm;
		  margin-right: 3cm;
		  width: 21.59cm;
		  height: 27.94cm;
		}
		@media print
	    {
	    	background-color: white;
		  	text-align: justify;
		  	font-family: verdana;
		  	font-weight: normal;
		  	font-size: 12px !important;
		  	margin-bottom: 2cm;
		  	margin-top: 2cm;
		  	margin-left: 3cm;
		 	margin-right: 3cm;
		  	width: 21.59cm;
		  	height: 27.94cm;
	    }
		</style>
	<meta charset='utf-8'>
	</head>
	<body>
	<div class='PrintArea PrintArea-deportado' id='printArea' style='margin-left: 1.2cm;margin-right: 1.2cm;'>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<div style='font-size: 14px !important;text-align: center !important;'>
			GUATEMALA ".$_POST['fecha']."<br><br>	
		</div>
		<br>
		<br>
		<br>
		<br>
		<div style='font-size: 14px !important;text-align: justify !important;'>
			A QUIEN INTERESE:
		</div>
		<br>
		<br>
		<div style='font-size: 14px !important;text-align: justify !important;'>
			QUE DE ACUERDO A LOS INFORMES DE MOVIMIENTOS MIGRATORIOS QUE
			SE ENCUENTRAN EN LOS ARCHIVOS ELECTRÓNICOS, QUE PARA EL EFECTO SE CUENTAN
			EN LA INSTITUCIÓN, SE PUDO ESTABLECER QUE A: <b><u>".$_POST['nombre'].";</u>
			 NO</b> LE APARECE MOVIMIENTO MIGRATORIO YA QUE APARECEN DIFERENTES
			PERSONAS CON MÚLTIPLES MOVIMIENTOS, POR LO QUE SE SOLICITA AL 
			INTERESADO PROPORCIONAR MAS DATOS QUE PUEDAN AYUDAR A LOCALIZAR
			LA BÚSQUEDA REQUERIDA. 
		</div>
		<br>
		<br>
		<br>
		<p style='font-size: 12px !important;'>
			<b>
				REALIZADO POR: <br>
				".$_SESSION['nombre']." <br>
				AUXILIAR CONTROL MIGRATORIO <br>
				DIRECCION GENERAL DE MIGRACION
			</b>	
		</p>

	</div>
		
	</body>
	</html>
	";

	echo $html;

 ?>