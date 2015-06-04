<?php 
ini_set('display_errors', 'On');
ini_set('display_errors', 1); 
require_once('../res/conexion.php'); 
require_once('../res/tcpdf/tcpdf.php');

if (!empty($_GET['FechaDel'])&&!empty($_GET['FechaAl'])) {
	$FechaDel = date("Y-m-d",strtotime($_GET['FechaDel']));
	$FechaAl = date("Y-m-d",strtotime($_GET['FechaAl']));
	// $FechaDeport=date("Y-m-d",strtotime($_POST['FechaDepor']));
	// echo $FechaDel."---".$FechaAl;
	// $FechaDel = "2015-02-15";
	// $FechaAl = "2015-03-23";
	$Fal = strtotime ( '+1 day' , strtotime ($_GET['FechaAl']));
	$Fal = date ( 'Y-m-d' , $Fal );
	// create new PDF document
	$pdf = new TCPDF('L', 'mm', 'LETTER', true, 'UTF-8', false);

	// set document information
	$pdf->SetCreator(PDF_CREATOR);

	$pdf->SetMargins(10, 10, 10);

	$pdf->SetHeaderMargin(5);
	$pdf->SetFooterMargin(10);

	//set auto page breaks
	$pdf->SetAutoPageBreak(TRUE, 10);

	$pdf->SetDisplayMode(48.6);//es el % de zoom 24-02-2011

	$pdf->SetFont('helvetica', '', 6);

	$pdf->SetProtection($permissions=array( 'modify','copy','annot-forms'), $user_pass='', $owner_pass=null, $mode=0, $pubkeys=null);
	
	$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', '12'));


	$fecha_hoy = date("d/m/Y H:i:s");
	$part = ""; $dep = ""; $of = "";
	if (!empty($_GET['particular'])) {
		$part = "PARTICULAR ";
	}
	if (!empty($_GET['deportado'])) {
		$dep = "- DEPORTADO -";
	}
	if (!empty($_GET['oficial'])) {
		$of = " OFICIAL";
	}

	$fechas = '<tr><td colspan="9" align="center"><h2>Periodo del reporte ' . date("d/m/Y",strtotime($FechaDel)).  ' al ' .  date("d/m/Y",strtotime($FechaAl)) .'<br>Tipo: '.$part.$dep.$of.'</h2></td></tr>';
	

	$style = array(
	    'border' => false,
	    'vpadding' => 'auto',
	    'hpadding' => 'auto',
	    'fgcolor' => array(0,0,0),
	    'bgcolor' => false, //array(255,255,255)
	    'module_width' => 1, // width of a single module in points
	    'module_height' => 1 // height of a single module in points
	);
		
	$back = ' style="background-color:rgb(240,240,240); font-size:8px;" ';
		
	$header = '<table style="width:100%" cellspacing="0" cellpadding="1" border="0" >
	<thead >
		<tr>
			<td colspan="3" rowspan="2"><img src="../img/migraLogo.png" border="0" width="100px"></td>
			<td colspan="9" align="center"><font size="14" face="arial" color="navy">REPORTE DE CERTIFICACIÓN DE CONTROL MIGRATORIO</font></td>
			<td colspan="3" rowspan="2" align="right"><b>' . $fecha_hoy . '</b></td>
		</tr>
		'.$fechas.'
		<tr>
			<td colspan="1" align="center"' . $back . '><b>No.</b></td>
			<td colspan="1" align="center"' . $back . '> <b>FECHA</b></td>
			<td colspan="2" align="center"' . $back . '><b>PRIMER<br>NOMBRE</b></td>
			<td colspan="1" align="center"' . $back . '><b>SEGUNDO<br>NOMBRE</b></td>
			<td colspan="2" align="center"' . $back . '><b>PRIMER<br>APELLIDO</b></td>
			<td colspan="1" align="center"' . $back . '><b>SEGUNDO<br>APELLIDO</b></td>
			<td colspan="1" align="center"' . $back . '><b>APELLIDO<br>CASADA</b></td>
			<td colspan="2" align="center"' . $back . '><b>CONCEPTO</b></td>
			<td colspan="1" align="center"' . $back . '><b>VALOR<br>CONCEPTO</b></td>
			<td colspan="2" align="center"' . $back . '><b>TIPO<br>SOLICITUD</b></td>
			<td colspan="1" align="center"' . $back . '><b>BOLETA<br>BANCO</b></td>
		</tr>		
	</thead>	
	<tbody>';
	
	$texto = $header;

	//Solo particular
	if (!empty($_GET['particular'])) {
		$tipo = "AND tipo_solicitud=1 AND vuelo_proveniente IS NULL ";
	}
	//Solo deportado
	if (!empty($_GET['deportado'])) {
		$tipo = "AND vuelo_proveniente!='' ";
	}
	//Solo oficial
	if (!empty($_GET['oficial'])) {
		$tipo = "AND tipo_solicitud=0 ";
	}
	//Solo particular y deportado
	if (!empty($_GET['particular'])&&!empty($_GET['deportado'])) {
		$tipo = "AND tipo_solicitud=1 ";
	}
	// //Solo particular y oficial
	// if (!empty($_GET['particular'])&&!empty($_GET['oficial'])) {
	// 	$tipo = "AND vuelo_proveniente IS NULL ";
	// }
	//particular, oficial, deportado
	if (!empty($_GET['particular'])&&!empty($_GET['oficial'])&&!empty($_GET['deportado'])) {
		$tipo = "";
	}

	$sql = "SELECT fecha_impresion, orden_pago, id_concepto, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, 
	    		apellido_casada, nacionalidad, boleta_banco, valor_concepto, tipo_solicitud, vuelo_proveniente, folio_entrada, variasPersonas 
	    		FROM datosgenerales WHERE id_concepto = 2 ".$tipo." AND fecha_impresion BETWEEN '".$FechaDel."' AND '".$Fal."' ORDER BY fecha_impresion"; 

	// echo $sql;
	//$texto .=$sql;
	$db = obtenerConexion();
	$reporte = ejecutarQuery($db, $sql);

	// $rs1 = $conec1->Execute($query); 		
	if ($reporte) 
    {	
            $c = 0;
            $d = 0;		
            $TotalConcepto = 0;
		    while($row = $reporte->fetch_assoc()){
		    	if ($row['variasPersonas']==1) {
	            	$fecha = $row['fecha_impresion'];
	            	$Concepto = $row['id_concepto'];
			        $ValorConcepto = $row['valor_concepto'];
			        $boleta = $row['boleta_banco'];
			        $TotalConcepto+=$row['valor_concepto'];
	            	if ($row['tipo_solicitud']==1) {
			        	if ($row['vuelo_proveniente']!=null|$row['vuelo_proveniente']!="") {
			        		$TipoSolicitud = "PARTICULAR DEPORTADO";
			        	}else{
			        		$TipoSolicitud = "PARTICULAR";
			        	}
			        }
			        elseif ($row['tipo_solicitud']==0) {
			        	$TipoSolicitud = "OFICIAL<br>FOLIO No.".$row['folio_entrada'];
			        }

		    		$sql1 = "SELECT primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, 
                    		apellido_casada, negativa, datosolicitar FROM persona WHERE datogeneral=".$row['orden_pago'];
                    $db = obtenerConexion();
					$persona = ejecutarQuery($db, $sql1);
            		while($prs = $persona->fetch_assoc()){
				        $Pnombre = $prs['primer_nombre'];
				        $Snombre = $prs['segundo_nombre'];
				        $Papellido = $prs['primer_apellido'];
				        $Sapellido = $prs['segundo_apellido'];
				        $Capellido = $prs['apellido_casada'];
				        
		                $c++;						
		                $d++;
								
		                if (intval($c	/ 2) == $c / 2)
		                    $back = ' style="background-color:rgb(230,230,230)" ';
		                else
		                    $back = '';
								
		                $texto .= '<tr style="font-size:8px;">
		                <td colspan="1" align="center"' . $back . '>'.$d.'</td>
		                <td colspan="1" align="center"' . $back . '>'.$fecha.'</td>
		                <td colspan="2" align="center"' . $back . '>'.$Pnombre.'</td>
		                <td colspan="1" align="center"' . $back . '>'.$Snombre.'</td>
		                <td colspan="2" align="center"' . $back . '>'.$Papellido.'</td>
		                <td colspan="1" align="center"' . $back . '>'.$Sapellido.'</td>
		                <td colspan="1" align="center"' . $back . '>'.$Capellido.'</td>
		                <td colspan="2" align="center"' . $back . '>CERTIFICACIÓN DE CONTROL MIGRATORIO</td>
		                <td colspan="1" align="center"' . $back . '>Q.'.$ValorConcepto.'</td>
		                <td colspan="2" align="center"' . $back . '>'.$TipoSolicitud.'</td>
		                <td colspan="1" align="center"' . $back . '>'.$boleta.'</td>
		                </tr>';
								
		                if ($c > 20) 
		                {						
			                $texto .= '</tbody></table>';						
			                $pdf->AddPage();		
			                $pdf->writeHTML($texto, false, false, false, false, '');												
				 		    $c=0;			
			                $texto = $header;
						}
            		}
            	}else{

			        $fecha = $row['fecha_impresion'];
			        $Pnombre = $row['primer_nombre'];
			        $Snombre = $row['segundo_nombre'];
			        $Papellido = $row['primer_apellido'];
			        $Sapellido = $row['segundo_apellido'];
			        $Capellido = $row['apellido_casada'];
			        $Concepto = $row['id_concepto'];
			        $ValorConcepto = $row['valor_concepto'];
			        $boleta = $row['boleta_banco'];

			        if ($row['tipo_solicitud']==1) {
			        	if ($row['vuelo_proveniente']!=null|$row['vuelo_proveniente']!="") {
			        		$TipoSolicitud = "PARTICULAR DEPORTADO";
			        	}else{
			        		$TipoSolicitud = "PARTICULAR";
			        	}
			        }
			        elseif ($row['tipo_solicitud']==0) {
			        	$TipoSolicitud = "OFICIAL<br>FOLIO No.".$row['folio_entrada'];
			        }

	                $c++;						
	                $d++;
					$TotalConcepto+=$row['valor_concepto'];		
	                if (intval($c	/ 2) == $c / 2)
	                    $back = ' style="background-color:rgb(230,230,230)" ';
	                else
	                    $back = '';
							
	                $texto .= '<tr style="font-size:8px;">
	                <td colspan="1" align="center"' . $back . '>'.$d.'</td>
	                <td colspan="1" align="center"' . $back . '>'.$fecha.'</td>
	                <td colspan="2" align="center"' . $back . '>'.$Pnombre.'</td>
	                <td colspan="1" align="center"' . $back . '>'.$Snombre.'</td>
	                <td colspan="2" align="center"' . $back . '>'.$Papellido.'</td>
	                <td colspan="1" align="center"' . $back . '>'.$Sapellido.'</td>
	                <td colspan="1" align="center"' . $back . '>'.$Capellido.'</td>
	                <td colspan="2" align="center"' . $back . '>CERTIFICACIÓN DE CONTROL MIGRATORIO</td>
	                <td colspan="1" align="center"' . $back . '>Q.'.$ValorConcepto.'</td>
	                <td colspan="2" align="center"' . $back . '>'.$TipoSolicitud.'</td>
	                <td colspan="1" align="center"' . $back . '>'.$boleta.'</td>
	                </tr>';
							
	                if ($c > 20) 
	                {						
		                $texto .= '</tbody></table>';						
		                $pdf->AddPage();		
		                $pdf->writeHTML($texto, false, false, false, false, '');												
			 		    $c=0;			
		                $texto = $header;
					}						
            	}
                
		    }
		$texto .= '<tr style="margin-top:10px;"><td colspan="2" style="font-size:12px;" rowspan="5" align="center"><b>Total: Q.' . $TotalConcepto . '</b></td></tr></tbody></table>';
		$pdf->AddPage();		
		$pdf->writeHTML($texto, false, false, false, false, '');
		$pdf->lastPage();
		
		$pdf->Output('reporte.pdf','I');

	}				
}
 ?>