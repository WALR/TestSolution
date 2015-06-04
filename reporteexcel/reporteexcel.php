<?php
    $conexion = new mysqli('localhost','certificacionMov','*migra123**','bdcertificaciones',3306);
	if (mysqli_connect_errno()) {
    	printf("La conexión con el servidor de base de datos falló: %s\n", mysqli_connect_error());
    	exit();
	}
	$consulta = "SELECT orden_pago, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, apellido_casada,
				fecha_impresion, boleta_banco, estado FROM datosgenerales";

				
	$resultado = $conexion->query($consulta);
	if($resultado->num_rows > 0 ){
						
		date_default_timezone_set('America/Guatemala');

		if (PHP_SAPI == 'cli')
			die('Este archivo solo se puede ver desde un navegador web');

		/** Se agrega la libreria PHPExcel */
		require_once 'lib/PHPExcel/PHPExcel.php';

		// Se crea el objeto PHPExcel
		$objPHPExcel = new PHPExcel();

		// Se asignan las propiedades del libro
		$objPHPExcel->getProperties()->setCreator("OrdenesPago") //Autor
							 ->setLastModifiedBy("OrdenesPago") //Ultimo usuario que lo modificó
							 ->setTitle("Reporte de Ordenes de Pago")
							 ->setSubject("Reporte de Ordenes de Pago")
							 ->setDescription("Reporte de Ordenes de Pago")
							 ->setKeywords("reporte ordenes pago")
							 ->setCategory("Reporte excel");

		$tituloReporte = "Reporte de Ordenes de Pago";
		$titulosColumnas = array('Orden No.', 'Primer Nombre', 'Segundo Nombre', 'Primer Apellido', 'Segundo Apellido', 'Apellido de Casada', 'Fecha', 'Estado', 'Boleta de Banco');
		
		$objPHPExcel->setActiveSheetIndex(0)
        		    ->mergeCells('A1:I1');
						
		// Se agregan los titulos del reporte
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1',$tituloReporte)
        		    ->setCellValue('A2',  $titulosColumnas[0])
		            ->setCellValue('B2',  $titulosColumnas[1])
        		    ->setCellValue('C2',  $titulosColumnas[2])
            		->setCellValue('D2',  $titulosColumnas[3])
            		->setCellValue('E2',  $titulosColumnas[4])
            		->setCellValue('F2',  $titulosColumnas[5])
            		->setCellValue('G2',  $titulosColumnas[6])
            		->setCellValue('H2',  $titulosColumnas[7])
            		->setCellValue('I2',  $titulosColumnas[8]);
		
		//Se agregan los datos de los alumnos
		$i = 3;
		while ($fila = $resultado->fetch_array()) {
			if ($fila['estado']==1) {
				$estado="ACTIVO";
			}else if ($fila['estado']==0) {
				$estado="ANULADO";
			}

			$objPHPExcel->setActiveSheetIndex(0)
        		    ->setCellValue('A'.$i,  $fila['orden_pago'])
		            ->setCellValue('B'.$i,  $fila['primer_nombre'])
		            ->setCellValue('C'.$i,  $fila['segundo_nombre'])
		            ->setCellValue('D'.$i,  $fila['primer_apellido'])
		            ->setCellValue('E'.$i,  $fila['segundo_apellido'])
		            ->setCellValue('F'.$i,  $fila['apellido_casada'])
		            ->setCellValue('G'.$i,  $fila['fecha_impresion'])
		            ->setCellValue('H'.$i,  $estado)
		            ->setCellValue('I'.$i,  $fila['boleta_banco']);
					$i++;
		}
		
		$estiloTituloReporte = array(
        	'font' => array(
	        	'name'      => 'Verdana',
    	        'bold'      => true,
        	    'italic'    => false,
                'strike'    => false,
               	'size' =>16,
	            	'color'     => array(
    	            	'rgb' => 'FFFFFF'
        	       	)
            ),
	        'fill' => array(
				'type'	=> PHPExcel_Style_Fill::FILL_SOLID,
				'color'	=> array('argb' => '000000')
			),
            'borders' => array(
               	'allborders' => array(
                	'style' => PHPExcel_Style_Border::BORDER_NONE                    
               	)
            ), 
            'alignment' =>  array(
        			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        			'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        			'rotation'   => 0,
        			'wrap'          => TRUE
    		)
        );

		$estiloTituloColumnas = array(
            'font' => array(
                'name'      => 'Arial',
                'bold'      => true,                          
                'color'     => array(
                    'rgb' => 'FFFFFF'
                )
            ),
            'fill' 	=> array(
				'type'		=> PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
				'rotation'   => 90,
        		'startcolor' => array(
            		'rgb' => '000000'
        		),
        		'endcolor'   => array(
            		'argb' => '000000'
        		)
			),
            'borders' => array(
            	'top'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN ,
                    'color' => array(
                        'rgb' => '000000'
                    )
                ),
                'bottom'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN ,
                    'color' => array(
                        'rgb' => '000000'
                    )
                ),
                'left'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN ,
                    'color' => array(
                        'rgb' => '000000'
                    )
                ),
                'right'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN ,
                    'color' => array(
                        'rgb' => '000000'
                    )
                )
            ),
			'alignment' =>  array(
        			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        			'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        			'wrap'          => TRUE
    		));
			
		$estiloInformacion = new PHPExcel_Style();
		$estiloInformacion->applyFromArray(
			array(
           		'font' => array(
               	'name'      => 'Arial',               
               	'color'     => array(
                   	'rgb' => '000000'
               	)
           	),
           	'fill' 	=> array(
				'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
				'color'		=> array('argb' => 'FFFFFF')
			),
           	'borders' => array(
               	'left'     => array(
                   	'style' => PHPExcel_Style_Border::BORDER_THIN ,
	                'color' => array(
    	            	'rgb' => '000000'
                   	)
               	),
               	'right'     => array(
                   	'style' => PHPExcel_Style_Border::BORDER_THIN ,
	                'color' => array(
    	            	'rgb' => '000000'
                   	)
               	),
               	'top'     => array(
                   	'style' => PHPExcel_Style_Border::BORDER_THIN ,
	                'color' => array(
    	            	'rgb' => '000000'
                   	)
               	),
               	'bottom'     => array(
                   	'style' => PHPExcel_Style_Border::BORDER_THIN ,
	                'color' => array(
    	            	'rgb' => '000000'
                   	)
               	)               
           	)
        ));
		 
		$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->applyFromArray($estiloTituloReporte);
		$objPHPExcel->getActiveSheet()->getStyle('A2:I2')->applyFromArray($estiloTituloColumnas);		
		$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A3:I".($i-1));
		
		// $objPHPExcel->setActiveSheetIndex(0)->setAutoSize(TRUE);
		// $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);		
		// $objPHPExcel->getActiveSheet()->setAutoSize(true);		
		for($i = 'A'; $i <= 'J'; $i++){
			$objPHPExcel->getActiveSheet()			
				->getColumnDimension($i)->setAutoSize(TRUE);
		}
		// $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
		// Se asigna el nombre a la hoja
		$objPHPExcel->getActiveSheet()->setTitle('OrdenPago');

		// Se activa la hoja para que sea la que se muestre cuando el archivo se abre
		$objPHPExcel->setActiveSheetIndex(0);
		// Inmovilizar paneles 
		//$objPHPExcel->getActiveSheet(0)->freezePane('A4');
		$objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0,3);

		// Se manda el archivo al navegador web, con el nombre que se indica (Excel2007)
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="ReporteOrdenesPago.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
		exit;
		
	}
	else{
		print_r('No hay resultados para mostrar');
	}
?>