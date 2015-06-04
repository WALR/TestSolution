<?php
if(!isset($_SESSION)) 
{ 
    session_start(); 
}
require_once('../../res/conexion.php'); 
require_once('../../res/fecha_letras.php');

	$db = obtenerConexion();
	$sql = "SELECT primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, 
                apellido_casada, negativa, datosolicitar, duranteDel, duranteAl  FROM persona WHERE datogeneral=".$_POST['idDato'];

    $result = ejecutarQuery($db, $sql);
    $datonom = "";
    $cantidad=0;
    $DuranteM = "";
    $Durante = "";
    $FDelANT="";
    $FAlANT="";
    $primerDato="";
    $cantDif = 0;
    while($row = $result->fetch_assoc()){
		$nombre =$row['primer_nombre'].' '.$row['segundo_nombre'].' '.$row['primer_apellido'].' '.$row['segundo_apellido'].' '.$row['apellido_casada'];
		$cantidad++;

		if ($row['negativa']==0) {
			$datonom.= "<p><b>".$nombre."</b>: LE APARECE MOVIMIENTO MIGRATORIO.</p>";
		}
		else {
			$datonom.= "<p><b>".$nombre.": NO </b>LE APARECE MOVIMIENTO MIGRATORIO.</p>";
		}

		if ($row['duranteDel']!=NULL&&$row['duranteDel']!=0000-00-00) {
			$FLetrasDel = fechaALetras(date("d/m/Y",strtotime($row['duranteDel'])));
            $FLetrasAl = fechaALetras(date("d/m/Y",strtotime($row['duranteAl'])));
            if ($cantidad==1) {
				$primerDato .= "DURANTE EL ".$FLetrasDel." AL ".$FLetrasAl." A FAVOR DE <b>".$nombre."</b>";
            }else{
	            if ($FLetrasDel==$FDelANT&&$FLetrasAl==$FAlANT) {
	            	if ($DuranteM=="") {
						$DuranteM .= "DURANTE EL ".$FLetrasDel." AL ".$FLetrasAl;
					}
	            }else{
					if ($Durante=="") {
						$Durante .= $primerDato;
					}else{
						$Durante .= "Y DURANTE EL ".$FLetrasDel." AL ".$FLetrasAl." A FAVOR DE <b>".$nombre."</b>";
					}
					$cantDif++;
	            }
            }
		}
		$FDelANT = fechaALetras(date("d/m/Y",strtotime($row['duranteDel'])));
    	$FAlANT = fechaALetras(date("d/m/Y",strtotime($row['duranteAl'])));
	}	
	$Let = "12px";
	if ($cantidad>4) {
		$Let = "10px";
	}
	if ($Durante==""&&$DuranteM=="") {
		$Cant = "DE <b>".$cantidad." PERSONAS</b>";
	}else{
		$Cant ="";
		if ($Durante==""&&$DuranteM!="") {
			$Durante=$DuranteM." DE <b>".$cantidad." PERSONAS</b>";
		}else if($Durante!=""&&$DuranteM!=""){
			$Durante.=" Y ".$DuranteM." DE <b>".($cantidad-$cantDif)." PERSONAS</b>";
		}
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
		  font-size: ".$Let." !important;
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
		<div style='margin-top:-0.5em;font-size: ".$Let." !important;text-align: right !important;'>
			<b>No.".$_POST['folio']."</b>
		</div>
		<br>
		<div style='font-size: ".$Let." !important;text-align: justify !important;'>
			<b>
				LA SUBDIRECCIÓN DE CONTROL MIGRATORIO, DIRECCION GENERAL DE MIGRACION,
				GUATEMALA, ".$_POST['fecha'].".<br><br>
			</b>
		</div>

		<div style='font-size: ".$Let." !important;text-align: justify !important;'>
			<b>
				ASUNTO: ".$_POST['asunto'].".
			</b>
		</div>
		<br>
		<div style='font-size: ".$Let." !important;text-align: justify !important;'>
			<b>SOLICITA: </b>MOVIMIENTO MIGRATORIO ".$Durante.$Cant.".
		</div>
		<br>
		<div style='font-size: ".$Let." !important;text-align: justify !important;'>
			DE ACUERDO A LAS CONSULTAS REALIZADAS EN LOS ARCHIVOS ELECTRÓNICOS DE LA BASE DE
			DATOS DEL SISTEMA DE CÓMPUTO, SE PUDO ESTABLECER QUE A:----------------------------------------------
		</div>
		<br>
		<div style='font-size: ".$Let." !important;'>
			".$datonom."
		</div>

		<div style='font-size: ".$Let." !important;text-align: justify !important;'>
			ADJUNTANDO PARA EL EFECTO EL REPORTE RESPECTIVO EN EL CUAL CONSTA EN <b>".$_POST['Nfolio']."</b> FOLIO(S).
		</div>
		<br>
		<div style='font-size: ".$Let." !important;text-align: justify !important;'> 
			RECOMIENDA AL INTERESADO ADOPTAR LAS MEDIDAS NECESARIAS QUE GARANTICEN LA 
			SEGURIDAD Y EN SU CASO, CONFIDENCIA O RESERVA DE LOS DATOS PERSONALES SENSIBLES Y EVITE 
			SU DIFUSIÓN, ALTERACIÓN, COMERCIALIZACIÓN, TRANSMISIÓN Y ACCESO NO AUTORIZADO, Y QUE
			LA MISMA SEA UTILIZADA PARA EL EJERCICIO DE FACULTADES PROPIAS DEL SOLICITANTE. TENGASE
			LO DISPUESTO EN LOS ARTICULOS 6, 9, 15, 32 Y 64, DEL DECRETO NO.57-2008 DEL CONGRESO DE LA
			REPÚBLICA DE GUATEMALA, LEY DE ACCESO A LA INFORMACION PÚBLICA.	
		</div>
		<br>
		<div style='font-size: ".$Let." !important;text-align: justify !important;'>
			<b>
				LA ANTERIOR CONSTANCIA NO PREJUZGA SOBRE EL CONTENIDO, VALIDEZ DE LOS
				DOCUMENTOS UTILIZADOS PARA EL REGISTRO DE ESTA INFORMACIÓN Y NO CONVALIDA
				HECHOS O ACTOS ILÍCITOS.
			</b>
		</div>
		<br>
		<div style='font-size: ".$Let." !important;text-align: justify !important;'>
			<b>OBSERVACIONES:</b> LA BASE DE DATOS DE LA DIRECCION GENERAL DE MIGRACION CONTIENE 
			INFORMACION DE MOVIMIENTOS MIGRATORIOS DESDE EL DIA QUINCE DE AGOSTO DE MIL 
			NOVECIENTOS NOVENTA Y CINCO HASTA LA PRESENTE FECHA.<b> ASI MISMO SE HACE CONSTAR QUE
			LA INFORMACION CERTIFICADA ES LA QUE SE TIENE A LA VISTA EN LA PRESENTE FECHA EN EL
			SISTEMA DE COMPUTO, NO SIENDO RESPONSABLE EL CERTIFICADOR DEL CONTENIDO, LEGALIDAD O 
			VALIDEZ DE LA MISMA</b>		
		</div>
		<br>
		<p style='font-size: ".$Let." !important;'>
			<b>
				REALIZADO POR: <br>
				".$_SESSION['nombre']." <br>
				AUXILIAR CONTROL MIGRATORIO <br>
				DIRECCION GENERAL DE MIGRACION
			</b>	
		</p>
		<br>
		<p style='text-align:center;font-size: ".$Let." !important;'>
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