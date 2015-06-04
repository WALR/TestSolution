<?php 
require_once('../res/conexion.php');

      $consulta = "SELECT dg.orden_pago, dg.primer_nombre, dg.segundo_nombre, dg.primer_apellido, dg.segundo_apellido, dg.apellido_casada,
                  dg.fecha_impresion, dg.boleta_banco, dg.estado, ml.fecha_inicio, ml.fecha_final, ml.dias, ml.total 
                  FROM datosgenerales dg, multa ml WHERE dg.orden_pago=ml.datogeneral AND id_concepto = 1";

      if (!empty($_GET['Rdia'])) {
            $Dia = date("Y-m-d",strtotime($_GET['Rdia']));
            $consulta.=" AND fecha_impresion LIKE '$Dia%'";
      
      }else if (!empty($_GET['Rdel'])&&!empty($_GET['Ral'])) {
          
          $FechaDel = date("Y-m-d",strtotime($_GET['Rdel']));
          $FechaAl = strtotime('+1 day' ,strtotime($_GET['Ral']));
          $FechaAl = date ( 'Y-m-d' , $FechaAl );

          $consulta.=" AND fecha_impresion BETWEEN '".$FechaDel."' AND '".$FechaAl."'";

      }
      $consulta .= " ORDER BY fecha_impresion";

      // echo $consulta;
      $db = obtenerConexion();
      $resultado = ejecutarQuery($db, $consulta);    
      if($resultado->num_rows > 0 ){
                                    
            date_default_timezone_set('America/Guatemala');

            if (PHP_SAPI == 'cli')
                  die('Este archivo solo se puede ver desde un navegador web');

            /** Se agrega la libreria PHPExcel */
            require_once dirname(__FILE__) . '/../res/PHPExcel/Classes/PHPExcel.php';

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

            $tituloReporte = "REPORTE DE ORDENES DE PAGO - MULTA POR PERMANENCIA ILEGAL EN EL PAIS";
            $hoy = date("d/m/Y H:i:s");
            $titulosColumnas = array('No.', 'Orden No.', 'Primer Nombre', 'Segundo Nombre', 'Primer Apellido', 
                                    'Segundo Apellido', 'Apellido de Casada', 'Fecha Inicio', 'Fecha Fin', 'Dias', 
                                    'Total', 'Boleta de Banco', 'Fecha Elaboración');
            
            $objPHPExcel->setActiveSheetIndex(0)
                      ->mergeCells('A1:K1');
            $objPHPExcel->setActiveSheetIndex(0)
                      ->mergeCells('L1:M1');
                                    
            // Se agregan los titulos del reporte
            $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A1',$tituloReporte)
                        ->setCellValue('L1',$hoy)
                        ->setCellValue('A2',  $titulosColumnas[0])
                        ->setCellValue('B2',  $titulosColumnas[1])
                        ->setCellValue('C2',  $titulosColumnas[2])
                        ->setCellValue('D2',  $titulosColumnas[3])
                        ->setCellValue('E2',  $titulosColumnas[4])
                        ->setCellValue('F2',  $titulosColumnas[5])
                        ->setCellValue('G2',  $titulosColumnas[6])
                        ->setCellValue('H2',  $titulosColumnas[7])
                        ->setCellValue('I2',  $titulosColumnas[8])
                        ->setCellValue('J2',  $titulosColumnas[9])
                        ->setCellValue('K2',  $titulosColumnas[10])
                        ->setCellValue('L2',  $titulosColumnas[11])
                        ->setCellValue('M2',  $titulosColumnas[12]);
                        // ->setCellValue('N2',  $titulosColumnas[13]);

            
            //Se agregan los datos de los alumnos
            $i = 3;
            $n = 1;
            $total = 0;
            while ($fila = $resultado->fetch_assoc()) {
                  // if ($fila['estado']==1) {
                  //       $estado="ACTIVO";
                  // }else if ($fila['estado']==0) {
                  //       $estado="ANULADO";
                  // }
                  $Fecha=date("d/m/Y H:i:s",strtotime($fila['fecha_impresion']));
                  $total+=$fila['total'];
                  $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A'.$i,  $n)
                        ->setCellValue('B'.$i,  $fila['orden_pago'])
                        ->setCellValue('C'.$i,  $fila['primer_nombre'])
                        ->setCellValue('D'.$i,  $fila['segundo_nombre'])
                        ->setCellValue('E'.$i,  $fila['primer_apellido'])
                        ->setCellValue('F'.$i,  $fila['segundo_apellido'])
                        ->setCellValue('G'.$i,  $fila['apellido_casada'])
                        ->setCellValue('H'.$i,  $fila['fecha_inicio'])
                        ->setCellValue('I'.$i,  $fila['fecha_final'])
                        ->setCellValue('J'.$i,  $fila['dias'])
                        ->setCellValue('K'.$i,  'Q.'.$fila['total'])
                        ->setCellValue('L'.$i,  $fila['boleta_banco'])
                        ->setCellValue('M'.$i,  $Fecha);
                        // ->setCellValue('N'.$i,  $Fecha);
                  $i++;
                  $n++;
            }
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$i.':J'.$i);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$i,  '------ TOTAL GENERAL ------');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$i,  'Q.'.$total);
            

            $estiloTituloReporte = array(
                  'font' => array(
                              'name'      => 'Verdana',
                              'bold'      => true,
                              'italic'    => false,
                              'strike'    => false,
                              'size' =>14,
                              'color'     => array(
                              'rgb' => 'FFFFFF'
                        )
                  ),
                    'fill' => array(
                              'type'      => PHPExcel_Style_Fill::FILL_SOLID,
                              'color'     => array('argb' => '000000')
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
            $estiloFecha = array(
                  'font' => array(
                        'name'      => 'Verdana',
                    'bold'      => true,
                      'italic'    => false,
                      'strike'    => false,
                        'size' =>8,
                              'color'     => array(
                              'rgb' => 'FFFFFF'
                              )
                  ),
                    'fill' => array(
                              'type'      => PHPExcel_Style_Fill::FILL_SOLID,
                              'color'     => array('argb' => '000000')
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
            'fill'      => array(
                        'type'            => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
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
            'fill'      => array(
                        'type'            => PHPExcel_Style_Fill::FILL_SOLID,
                        'color'           => array('argb' => 'FFFFFF')
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

            $estiloTotal = new PHPExcel_Style();
            $estiloTotal->applyFromArray(
                  array(
                        'font' => array(
                              'name'      => 'Arial', 
                              'bold'      => true,              
                              'color'     => array(
                                    'rgb' => '000000'
                              )
                        ),
                  'fill' => array(
                        'type'  => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('argb' => 'D8D8D8')
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
                  ), 
                  'alignment' =>  array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                        'rotation'   => 0,
                        'wrap'       => TRUE
                  )
            ));
            
            $objPHPExcel->getActiveSheet()->getStyle('A1:K1')->applyFromArray($estiloTituloReporte);
            $objPHPExcel->getActiveSheet()->getStyle('L1:M1')->applyFromArray($estiloFecha);
            $objPHPExcel->getActiveSheet()->getStyle('A2:M2')->applyFromArray($estiloTituloColumnas);
            $objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A3:M".($i-1));
            $objPHPExcel->getActiveSheet()->setSharedStyle($estiloTotal, 'A'.$i.':K'.$i);
            
            // $objPHPExcel->setActiveSheetIndex(0)->setAutoSize(TRUE);
            // $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);            
            // $objPHPExcel->getActiveSheet()->setAutoSize(true);       
            for($i = 'A'; $i <= 'O'; $i++){
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
            $h = date("d-m-Y");
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="ReporteOrdenesPago'.$h.'.xlsx"');
            header('Cache-Control: max-age=0');

            // $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            // $objWriter->save('php://output');
            // exit;
            // $data = array('case'=> 2);
            // echo json_encode($data);
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save('php://output');
            exit;
            
      }
      else{
            // $data = array('case'=> 1);
            // echo json_encode($data);
            print_r('No hay resultados para mostrar');
      }
 ?>