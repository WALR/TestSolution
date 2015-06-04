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
		<div style='margin-top:-0.5em;font-size: 12px !important;text-align: right !important;'>
			<b>No.".$_POST['NfolioEntrada']."</b>
		</div>
		<br>
		<br>
		<br>
		<br>
		<div style='font-size: 18px !important;text-align: justify !important;'>
			<b>
				LA SUBDIRECCION DE CONTROL MIGRATORIO DE LA DIRECCIÓN GENERAL DE MIGRACIÓN.<br><br>	
			</b>
		</div>

		<div style='font-size: 18px;text-align: center;'>
			<b>
			CERTIFICA
			</b>
		</div>
		<br>
		<br>
		<div style='font-size: 14px;text-align: justify;'>
			Que realizada la revisión correspondiente en el sistema de cómputo, el Sr. <b>".$_POST['nombre']."</b> quien se identifica 
			con ".$_POST['documento']." No.".$_POST['numeroDoc']." de nacionalidad ".$_POST['nacionalidad'].", ingresó por la frontera de
			Migración <b>".$_POST['lugar'].", con fecha ".$_POST['fechaIngreso']."</b> y a partir de esa fecha tiene
			<b>".$_POST['dias']." dias</b> para permanecer legalmente en el país; por lo cual su situación migratoria es
			de Turista.
		</div>
		<br>
		<div style='font-size: 14px;text-align: justify;'>
			Para los usos que al interesado convenga se extiende la presete en una hoja de 
			papel membretado, de la Dirección General de Migración tamaño carta, en la ciudad
			de Guatemala ".$_POST['fecha'].".
			<br>
			Honorarios de la Ley, de conformidad con el Art. 88 del reglamento de Ley de
			Migración, modificado por el Acuerdo Gubernativo 408-2006.
		</div>
		<br>
		<br>
		<br>
		<div style='margin-top:10em;'>
			<img src='QR/".$_POST['QR']."' alt='Codigo QR' height='105' width='105'/>	
		</div>

	</div>
		
	</body>
	</html>	";

	// <p style='font-size: 12px !important;'>
	// 		<b>
	// 			".$_SESSION['nombre']." <br>
	// 			AUXILIAR CONTROL MIGRATORIO <br>
	// 			DIRECCION GENERAL DE MIGRACION
	// 		</b>	
	// 	</p>
	// 	<br>
	// 	<p style='text-align:center;font-size: 12px !important;'>
	// 		<b>
	// 			Vo.Bo.
	// 		</b>
	// 	</p>

	echo $html;

 ?>