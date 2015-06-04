<?php 
if(!isset($_SESSION)) 
{ 
    session_start(); 
}

if (!empty($_POST['duranteDel'])&&$_POST['duranteDel']!=""){
	$Durante = "DURANTE EL ".$_POST['duranteDel']." AL ".$_POST['duranteAl']." ";
}else{
	$Durante = "";
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
			<b>No.".$_POST['folio']."</b>
		</div>
		<br>
		<div style='font-size: 12px !important;text-align: justify !important;'>
			<b>
				LA SUBDIRECCIÓN DE CONTROL MIGRATORIO, DIRECCION GENERAL DE MIGRACION,
				GUATEMALA, ".$_POST['fecha'].".<br>
			</b>
		</div>
		<br>
		<div style='font-size: 12px !important;text-align: justify !important;'>
			<b>
				ASUNTO: ".$_POST['asunto'].".
			</b>
		</div>
		<br>
		<p style='font-size: 12px !important;text-align: justify !important;'>
			<b>SOLICITA: </b>MOVIMIENTO MIGRATORIO ".$Durante."DE <b>".$_POST['nombre']."</b>.
		</p>
		<p style='font-size: 12px !important;text-align: justify !important;'>
			DE ACUERDO A LAS CONSULTAS REALIZADAS EN LOS ARCHIVOS ELECTRÓNICOS DE LA BASE DE
			DATOS DEL SISTEMA DE CÓMPUTO, SE PUDO ESTABLECER QUE A:----------------------------------------------
		</p>
		<p style='font-size: 12px !important;'>
			<b>".$_POST['nombre']."</b>: <b>".$_POST['Movimiento']."</b> LE APARECE MOVIMIENTO MIGRATORIO.
		</p>
		<p style='font-size: 12px !important;text-align: justify !important;'>
			ADJUNTANDO PARA EL EFECTO EL REPORTE RESPECTIVO EN EL CUAL CONSTA EN <b>".$_POST['Nfolio']."</b> FOLIO(S).
		</p>
		<p style='font-size: 12px !important;text-align: justify !important;'> 
			SE RECOMIENDA AL SOLICITANTE ADOPTAR LAS MEDIDAS NECESARIAS QUE GARANTICEN LA 
			SEGURIDAD Y EN SU CASO, CONFIDENCIA O RESERVA DE LOS DATOS PERSONALES SENSIBLES, EVITANDO 
			SU DIFUSIÓN, ALTERACIÓN, COMERCIALIZACIÓN, TRANSMISIÓN Y ACCESO NO AUTORIZADO. ESTA INFORMACION 
			DEBE SER UTILIZADA PARA EL EJERCICIO DE FACULTADES PROPIAS DEL CARGO DEL SOLICITANTE. TENGASE EN
			LO DISPUESTO LOS ARTICULOS 6, 9, 15, 32 Y 64, DEL DECRETO NO.57-2008 DEL CONGRESO DE LA
			REPÚBLICA DE GUATEMALA, LEY DE ACCESO A LA INFORMACION PÚBLICA.	
		</p>
		<p style='font-size: 12px !important;text-align: justify !important;'>
			<b>
				LA PRESENTE CERTIFICACIÓN NO PREJUZGA SOBRE EL CONTENIDO, LEGALIDAD O VALIDEZ DE LOS
				DOCUMENTOS UTILIZADOS PARA EL REGISTRO DE ESTA INFORMACIÓN Y NO CONVALIDA
				HECHOS O ACTOS ILÍCITOS.
			</b>
		</p>
		<p style='font-size: 12px !important;text-align: justify !important;'>
			<b>OBSERVACIONES:</b> LA BASE DE DATOS DE LA DIRECCION GENERAL DE MIGRACION CONTIENE 
			INFORMACION DE MOVIMIENTOS MIGRATORIOS DESDE EL DIA QUINCE DE AGOSTO DE MIL 
			NOVECIENTOS NOVENTA Y CINCO HASTA LA PRESENTE FECHA.<b> ASI MISMO SE HACE CONSTAR QUE
			LA INFORMACION CERTIFICADA ES LA QUE SE TIENE A LA VISTA EN LA PRESENTE FECHA EN EL
			SISTEMA DE COMPUTO, NO SIENDO RESPONSABLE EL CERTIFICADOR DEL CONTENIDO, LEGALIDAD O 
			VALIDEZ DE LA MISMA.</b>		
		</p>
		<p style='font-size: 12px !important;'>
			<b>
				REALIZADO POR: <br>
				".$_SESSION['nombre']." <br>
				AUXILIAR CONTROL MIGRATORIO <br>
				DIRECCION GENERAL DE MIGRACION
			</b>	
		</p>
		<br>
		<p style='text-align:center;font-size: 12px !important;'>
			<b>
				Vo.Bo.
			</b>
		</p>
		<div style='margin-top:-4em;'>
			<img src='QR/".$_POST['QR']."' alt='Codigo QR' height='105' width='105'/>	
		</div>
	</div>
		
	</body>
	</html>
	";

	echo $html;

 ?>