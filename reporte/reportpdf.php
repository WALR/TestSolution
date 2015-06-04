<?php 
ini_set('display_errors', 'On');
ini_set('display_errors', 1); 
require_once('../res/conexion.php'); 
require_once('../res/fpdf/fpdf.php'); 
	
// if (!empty($_POST['FechaDel'])&&!empty($_POST['FechaAl'])) {
if (1) {

	// $FechaDel=date("Y-m-d",strtotime($_POST['FechaDel']));
	// $FechaAl=date("Y-m-d",strtotime($_POST['FechaAl']));
	$FechaDel="2015-03-15";
	$FechaAl="2015-03-20";
    $sql = "SELECT fecha_impresion, orden_pago, id_concepto, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, 
    		apellido_casada, nacionalidad, boleta_banco, valor_concepto, tipo_solicitud FROM datosgenerales WHERE id_concepto = 2 AND fecha_impresion 
    		BETWEEN '".$FechaDel."' AND '".$FechaAl."' AND tipo_solicitud = 1  ORDER BY fecha_impresion";


    $db = obtenerConexion();
    $reporte = ejecutarQuery($db, $sql);

    $i=1;
    while($row = $reporte->fetch_assoc()){
        echo $i." -".$row['fecha_impresion']." ".$row['orden_pago']." ".$row['primer_nombre']."<br>";
 		$i+=1;
    }
	// SELECT fecha_impresion, orden_pago, id_concepto, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido,
    // apellido_casada, nacionalidad, boleta_banco, valor_concepto FROM datosgenerales WHERE fecha_impresion 
    // BETWEEN '2015-03-15' AND '2015-03-15' ORDER BY fecha_impresion
	// if (!empty($_POST['particular'])) {
	// 	$particular = 1;
	// }else{
	// 	$particular = 0;
	// }



// function obtenerPaises() {
//     $paises = array();
//     $sql = "SELECT id_pais, nombre_pais, nacionalidad_pais from paises"; 
//     $db = obtenerConexion();
//     $db -> query("SET NAMES 'UTF8' ");
//     // obtenemos todos los países
//     $result = ejecutarQuery($db, $sql);
//     // creamos objetos de la clase país y los agregamos al arreglo
//     while($row = $result->fetch_assoc()){
//         $row['nombre_pais'] = mb_convert_encoding($row['nombre_pais'], 'UTF-8', mysqli_character_set_name($db));
//         $row['nacionalidad_pais'] = mb_convert_encoding($row['nacionalidad_pais'], 'UTF-8', mysqli_character_set_name($db));          
//         $pais = new pais($row['id_pais'], $row['nombre_pais'], $row['nacionalidad_pais']);
//         array_push($paises, $pais);
//     }

//     	cerrarConexion($db, $result);

//     	// devolvemos el arreglo
//     	return $paises;
// }

	// $pdf = new FPDF();
	// $pdf->AddPage();
	// $pdf->Cell(40,10,'¡Hola, Mundo!');
	// $pdf->Output();

	// $pdf = new FPDF();
	// $pdf->Open();
	// $pdf->SetMargins(0, 0);
	// $pdf->SetAutoPageBreak(false);
	// $pdf->AddPage();

	// $content = 'thisis a test';

	// $pdf->SetXY(20, 20);
	// $pdf->SetFont('Arial', 'B', 16);
	// $pdf->MultiCell(150, 5, $content, 0, 'L');

	// $pdf->Output();

	// exit;
}else{
	// class PDF extends FPDF
	// {
	// // Cabecera de página
	// 	function Header()
	// 	{
	// 	    // Logo
	// 	    $this->Image('../img/migraLogo.png',20,8,33);
	// 	    // Arial bold 15
	// 	    $this->SetFont('Arial','B',18);
	// 	    // Movernos a la derecha
	// 	    $this->Cell(80);
	// 	    // Título
	// 	    $this->SetTextColor(39,93,140);
	// 	    $this->Cell(120,15,utf8_decode('Reporte Certificación Movimiento Migratorio'),0,0,'C');
	// 	    // Salto de línea
	// 	    $this->Ln(20);
	// 	}

	// 	//Pie de página
	// 	function Footer()
	// 	{
	// 	    // Posición: a 1,5 cm del final
	// 	    $this->SetY(-15);
	// 	    // Arial italic 8
	// 	    $this->SetFont('Arial','',8);
	// 	    // Número de página
	// 	    $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
	// 	}

	// 	function Table($header, $data)
	// 	{
	// 	    // Colores, ancho de línea y fuente en negrita
	// 	    $this->SetFillColor(255,0,0);
	// 	    $this->SetTextColor(255);
	// 	    $this->SetDrawColor(39,93,140);
	// 	    $this->SetLineWidth(.3);
	// 	    $this->SetFont('','B');
	// 	    // Cabecera
	// 	    $w = array(40, 35, 45, 40);
	// 	    for($i=0;$i<count($header);$i++)
	// 	        $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
	// 	    $this->Ln();
	// 	    // Restauración de colores y fuentes
	// 	    $this->SetFillColor(224,235,255);
	// 	    $this->SetTextColor(0);
	// 	    $this->SetFont('');
	// 	    // Datos
	// 	    $fill = false;
	// 	    foreach($data as $row)
	// 	    {
	// 	        $this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
	// 	        $this->Cell($w[1],6,$row[1],'LR',0,'L',$fill);
	// 	        $this->Cell($w[2],6,number_format($row[2]),'LR',0,'R',$fill);
	// 	        $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R',$fill);
	// 	        $this->Ln();
	// 	        $fill = !$fill;
	// 	    }
	// 	    // Línea de cierre
	// 	    $this->Cell(array_sum($w),0,'','T');
	// 	}


	// }

	// // Creación del objeto de la clase heredada
	// $pdf = new PDF('L', 'mm');
	// // $pdf= new PDF('P', 'mm', '200, 300'); 
	// $pdf->AliasNbPages();
	// $pdf->AddPage();
	// $pdf->SetFont('Arial','B',12);
	

	// $pdf->Cell(0,10,$tabla,0,1);
	// for($i=1;$i<=40;$i++)
	//     $pdf->Cell(0,10,'Imprimiendo línea número '.$i,0,1);
	// $pdf->Output();

	// // $pdf = new FPDF();
	// // $pdf->Open();
	// // $pdf->SetMargins(0, 0);
	// // $pdf->SetAutoPageBreak(false);
	// // $pdf->AddPage();

	// // $content = 'thisis a test';

	// // $pdf->SetXY(20, 20);
	// // $pdf->SetFont('Arial', 'B', 16);
	// // $pdf->MultiCell(150, 5, $content, 0, 'L');

	// // $pdf->Output();

	// // exit;





// 	class PDF extends FPDF
// {
// //Cabecera de página
//    function Header()
//    {
//     //Logo
//     $this->Image('../img/migraLogo.png',20,8,33);
//     //Arial bold 15
//     $this->SetFont('Arial','B',18);
//     //Movernos a la derecha
//     $this->Cell(80);
//     //Título
//     $this->SetTextColor(39,93,140);
//     $this->Cell(120,15,utf8_decode('Reporte Certificación Movimiento Migratorio'),0,0,'C');
//     //Salto de línea
//     $this->Ln(20);
      
//    }
   
//   //Pie de página
// 	function Footer()
// 	{
// 	    // Posición: a 1,5 cm del final
// 	    $this->SetY(-15);
// 	    // Arial italic 8
// 	    $this->SetFont('Arial','',8);
// 	    // Número de página
// 	    $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
// 	}
   
//    //Tabla coloreada
// 	function Tabla()
// 	{
// 		//Colores, ancho de línea y fuente en negrita
// 		$this->SetFillColor(39,93,140);
// 		$this->SetTextColor(255);
// 		$this->SetDrawColor(39,93,140);
// 		$this->SetLineWidth(.3);
// 		$this->SetFont('Arial','', 12);
// 		//Cabecera
// 		//$header=array('Orden Pago No.','Concepto','Nombre','Fecha');
// 		// for($i=0;$i<count($header);$i++)
// 		// $this->Cell(60,7,$header[$i],1,0,'C',1);
// 		// $this->MultiCell(30,5,"Orden de Pago No.",1,'C', 1);
// 		$this->MultiCell(30,5,"Orden de Pago No.", 1 , 'C' , 1);
// 		$this->Ln();

// 		// MultiCell(float w, float h, string txt [, mixed border [, string align [, boolean fill]]])
// 		//$this->Cell(30,5,"",0,0,'C',1);
// 		$this->Cell(60,10,"Concepto",1,0,'C',1);
// 		$this->Cell(60,10,"Nombre",1,0,'C',1);
// 		$this->Cell(60,10,"Fecha",1,0,'C',1);

// 		$this->Ln();
// 		//Restauración de colores y fuentes
// 		$this->SetFillColor(224,235,255);
// 		$this->SetTextColor(0);
// 		$this->SetFont('Arial', '', 12);
// 		//Datos
// 		   $fill=false;
// 		$this->Cell(30,6,"hola",'LR',0,'L',$fill);
// 		$this->Cell(60,6,"hola2",'LR',0,'L',$fill);
// 		$this->Cell(60,6,"hola3",'LR',0,'R',$fill);
// 		$this->Cell(60,6,"hola4",'LR',0,'R',$fill);
// 		$this->Ln();

// 		    $fill=!$fill;
// 		$this->Cell(30,6,"col",'LR',0,'L',$fill);
// 		$this->Cell(60,6,"col2",'LR',0,'L',$fill);
// 		$this->Cell(60,6,"col3",'LR',0,'R',$fill);
// 		$this->Cell(60,6,"col4",'LR',0,'R',$fill);
			
// 		$fill=true;
// 		$this->Ln();
// 		$this->Cell(160,0,'','T');
// 	}

   
   
// }

// $pdf=new PDF('L', 'mm');
// //Títulos de las columnas

// $pdf->AliasNbPages();

// //Primera página
// $pdf->AddPage();
// $pdf->SetY(30);
// $pdf->Tabla();
// $pdf->Output();


// // // Creación del objeto de la clase heredada
// 	// $pdf = new PDF('L', 'mm');
// 	// // $pdf= new PDF('P', 'mm', '200, 300'); 
// 	// $pdf->AliasNbPages();
// 	// $pdf->AddPage();
// 	// $pdf->SetFont('Arial','B',12);
}


 ?>