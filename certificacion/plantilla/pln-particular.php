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
		<div style='font-size: 11px !important;text-align: justify !important;'>
			<b>
				POR ESTE MEDIO LA SUB DIRECCION DE CONTROL MIGRATORIO DE LA DIRECCION GENERAL DE
			 	MIGRACION DEL MINISTERIO DE GOBERNACION.<br><br>	
			</b>
		</div>

		<div style='font-size: 11px !important;text-align: justify !important;'>
			<b>
			--------------------------------------------------------------------CERTIFICA--------------------------------------------------------------
			</b>
		</div>
		<br>
		<div style='font-size: 11px !important;text-align: justify !important;'>
			DE ACUERDO A LAS CONSULTAS REALIZADAS EN LOS ARCHIVOS ELECTRÓNICOS DE LA BASE DE
			DATOS DEL SISTEMA DE CÓMPUTO, SE PUDO ESTABLECER QUE A:-----------------------------------------------------------------------
		</div>
		<br>
		<div style='font-size: 11px !important;'>
		<b>".$_POST['nombre']."</b>: <b>".$_POST['Movimiento']."</b> LE APARECE MOVIMIENTO MIGRATORIO.
		</div>
		<br>
		<div style='font-size: 11px !important;text-align: justify !important;'>
			Y PARA LOS USOS LEGALES QUE AL INTERESADO CONVENGA, SE EXTIENDE, FIRMA Y SELLA LA 
			PRESENTE, EN UNA HOJA DE PAPEL MEMBRETADO DE LA DIRECCION GENERAL DE MIGRACION 
			TAMAÑO CARTA.
		</div>
		<br>
		<div style='font-size: 11px !important;text-align: justify !important;'>
			ADJUNTANDO PARA EL EFECTO EL REPORTE RESPECTIVO EN EL CUAL CONSTA EN <b>".$_POST['Nfolio']."</b> FOLIO(S).
		</div>
		<br>
		<div style='font-size: 11px !important;text-align: justify !important;'> 
			SE RECOMIENDA AL SOLICITANTE ADOPTAR LAS MEDIDAS NECESARIAS QUE GARANTICEN LA 
			SEGURIDAD Y EN SU CASO, CONFIDENCIA O RESERVA DE LOS DATOS PERSONALES SENSIBLES,
			EVITANDO SU DIFUSIÓN, ALTERACIÓN, COMERCIALIZACIÓN, TRANSMISIÓN Y ACCESO NO 
			AUTORIZADO. ESTA INFOMACION DEBE DE SER UTILIZADA PARA EL EJERCICIO DE FACULTADES 
			PROPIAS DEL CARGO DEL SOLICITANTE. TENGASE PRESENTE EN LO DISPUESTO EN LOS ARTICULOS 6, 
			9, 15, 32 Y 64, DEL DECRETO NO.57-2008 DEL CONGRESO DE LA REPÚBLICA DE GUATEMALA, LEY DE 
			ACCESO A LA INFORMACION PÚBLICA.	
		</div>
		<br>
		<div style='font-size: 11px !important;text-align: justify !important;'>
			<b>
				LA PRESENTE CERTIFICACIÓN NO PREJUZGA SOBRE EL CONTENIDO, LEGALIDAD O VALIDEZ DE 
				LOS DOCUMENTOS UTILIZADOS PARA EL REGISTRO DE ESTA INFORMACIÓN Y NO CONVALIDA 
				HECHOS O ACTOS ILÍCITOS. 
			</b>
		</div>
		<br>
		<div style='font-size: 11px !important;text-align: justify !important;'>
			<b>OBSERVACIONES:</b> LA BASE DE DATOS DE LA DIRECCION GENERAL DE MIGRACION CONTIENE 
			INFORMACION DE MOVIMIENTOS MIGRATORIOS DESDE EL DIA QUINCE DE AGOSTO DE MIL 
			NOVECIENTOS NOVENTA Y CINCO HASTA LA PRESENTE FECHA. <b>ASI MISMO SE HACE CONSTAR QUE
			LA INFORMACION CERTIFICADA ES LA QUE SE TIENE A LA VISTA EN LA PRESENTE FECHA EN EL
			SISTEMA DE COMPUTO, NO SIENDO RESPONSABLE EL CERTIFICADOR DEL CONTENIDO,
			LEGALIDAD O VALIDEZ DE LA MISMA. GUATEMALA, ".$_POST['fecha'].".</b>		
		</div>
		<br>
		<div style='font-size: 11px !important;'>
			(HNOS. DE LEY $5.00 ART.1 DEL ACUERDO GUBERNATIVO No.408-2006).	
		</div>
		<br>
		<p style='font-size: 11px !important;'>
			<b>
				REALIZADO POR: <br>
				".$_SESSION['nombre']." <br>
				AUXILIAR CONTROL MIGRATORIO <br>
				DIRECCION GENERAL DE MIGRACION
			</b>	
		</p>
		<br>
		<br>
		<br>
		<p style='text-align:center;font-size: 11px !important;'>
			<b>
				Vo.Bo.
			</b>
		</p>
		<div style='margin-top:-6.9em;'>
			<img src='QR/".$_POST['QR']."' alt='Codigo QR' height='115' width='115'/>	
		</div>
	</div>
		
	</body>
	</html>
	";

	echo $html;

 ?>