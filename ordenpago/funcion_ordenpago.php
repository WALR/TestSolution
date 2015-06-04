<?php 
ini_set('display_errors', 0);
require_once('../res/conexion.php'); 
require_once('../res/numLetras.php'); 
if(!isset($_SESSION)) 
{ 
    session_start(); 
}

switch ($_POST['fun']) {
	case '1':
		generarorden();
		break;
    case '2':
        buscarOrden();
        break;
    case '3':
        anularOrden();
        break;
    case '4':
        imprOrden();
        break;
    case '5':
        MultaOrden();
        break;
    case '6':
        ModOrden();
        break;
}

function generarorden()
{
    $nombreCompeto=$_POST['Pnombre'];
    $Pnombre = $_POST['Pnombre'];
    if(!empty($_POST['Snombre'])){
        $Snombre =$_POST['Snombre'];
        $nombreCompeto.=" ".$_POST['Snombre'];
    }else{
        $Snombre ="";
    }

    $Papellido = $_POST['Papellido'];
    $nombreCompeto.=" ".$_POST['Papellido'];
    if(!empty($_POST['Sapellido'])){
        $Sapellido = $_POST['Sapellido'];
        $nombreCompeto.=" ".$_POST['Sapellido'];
    }else{
        $Sapellido ="";
    }

    if(!empty($_POST['Capellido'])){
        $Capellido = $_POST['Capellido'];
        $nombreCompeto.=" ".$_POST['Capellido'];
    }else{
        $Capellido ="";
    }
    if(!empty($_POST['resolucion'])){
        $resolucion = $_POST['resolucion'];

    }else{
        $resolucion ="";
    }

    $nacionalidad = $_POST['cboNacionalidad'];
    $tipoDoc = $_POST['cboTipoDoc'];
    $NumDoc = $_POST['NumDoc'];
    $pais = $_POST['cboPais'];
    $LugarExtDoc = $_POST['LugarExtDoc'];
    $concepto = $_POST['cboConcepto'];
    $Nconcepto = $_POST['NConcepto'];

    if (!empty($_POST['Texonera'])) {
        $valorConcepto = $_POST['Texonera'];
    }else{
        $valorConcepto = $_POST['VConcepto'];
    }
    $valorConceptoLetras = numtoletras($valorConcepto);

    if (!empty($Pnombre)&&!empty($Papellido)&&!empty($nacionalidad)&&!empty($tipoDoc)&&!empty($NumDoc)&&!empty($pais)&&!empty($concepto)) {
        $hoy = date("Y-m-d H:i:s");
        // $user = 123;
        $IP = getIP();
        // $sql = "INSERT INTO datosgenerales (id_concepto, id_pais, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, 
        //         apellido_casada, nacionalidad, tipo_documento, numero_documento, lugar_documento, resolucion, numero_folio, tipo_solicitud, fecha_impresion, boleta_banco, valor_concepto, usuario_orden, ip_orden, estado) 
        //         VALUES (".$concepto.", '".$pais."', '".$Pnombre."', '".$Snombre."', '".$Papellido."', '".$Sapellido."', '".$Capellido."',
        //                 '".$nacionalidad."', '".$tipoDoc."', '".$NumDoc."', '".$LugarExtDoc."', '".$resolucion."', '', 1, '".$hoy."','' ,".$valorConcepto.", ".$user.", '".$IP."', 1)";
        $sql = 'INSERT INTO datosgenerales (id_concepto, id_pais, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, 
                apellido_casada, nacionalidad, tipo_documento, numero_documento, lugar_documento, resolucion, numero_folio, tipo_solicitud, fecha_impresion, boleta_banco, valor_concepto, ip_orden, anio, estado) 
                VALUES ('.$concepto.', "'.$pais.'", "'.$Pnombre.'", "'.$Snombre.'", "'.$Papellido.'", "'.$Sapellido.'", "'.$Capellido.'",
                        "'.$nacionalidad.'", "'.$tipoDoc.'", "'.$NumDoc.'", "'.$LugarExtDoc.'", "'.$resolucion.'", "", 1, "'.$hoy.'","" ,'.$valorConcepto.', "'.$IP.'", "'.date('Y').'",1)';
        
        $db = obtenerConexion();
        // echo $sql;
        $result = ejecutarQuery($db, $sql);
        $nuevo = datoNuevo($db);
        
        if ($result) {
            $db = obtenerConexion();
            $db->autocommit(FALSE);
            if (!empty($_POST['Finicio'])&&!empty($_POST['Ffinal'])) {
                $Finicio = date('Y-m-d', strtotime($_POST['Finicio']));
                $Ffinal = date('Y-m-d', strtotime($_POST['Ffinal']));

                $sqlMul = "INSERT INTO multa(datogeneral, fecha_inicio, fecha_final, dias, total, fecha, ip) 
                        VALUES (".$nuevo.", '".$Finicio."', '".$Ffinal."', ".$_POST['Dias'].", ".$_POST['total'].", 
                            '".$hoy."', '".$IP."')";
                if (!empty($_POST['Texonera'])) {
                    $sqlMul = "INSERT INTO multa(datogeneral, fecha_inicio, fecha_final, dias, total, fecha, expediente, 
                            exonera, descuento, total_orden, ip)  VALUES (".$nuevo.", '".$Finicio."', '".$Ffinal."', 
                            ".$_POST['Dias'].", ".$_POST['total'].", '".$hoy."', '".$_POST['expediente']."', 
                            ".$_POST['Pexonera'].", ".$_POST['Dexonera'].", ".$_POST['Texonera'].", '".$IP."')";
                }

                // echo $sqlMul;
                $resultMul = ejecutarQuery($db, $sqlMul);

                if ($resultMul) {
                        //cerrarConexion($db, $result);
                        $sql2 = "SELECT nacionalidad_pais FROM paises WHERE  id_pais='".$nacionalidad."'";
                        $db = obtenerConexion();
                        $Nac = ejecutarQuery($db, $sql2);
                        if ($Nac) {
                            $db->commit();
                            $db->close();
                            $resultNac = $Nac->fetch_assoc();

                            $dat = "NoOrden=".$nuevo."&nombre=".$nombreCompeto."&nacionalidad=".strtoupper($resultNac['nacionalidad_pais'])."&fecha=".date("d/m/Y")
								."&concepto=".$Nconcepto."&valorConcepto=".$valorConcepto."&valorConceptoLetras=".$valorConceptoLetras."&vigencia=1&MulDel=".$_POST['Finicio']."&MulAl=".$_POST['Ffinal'];

                            if (!empty($_POST['Texonera'])) {
                                $dat = "NoOrden=".$nuevo."&nombre=".$nombreCompeto."&nacionalidad=".strtoupper($resultNac['nacionalidad_pais'])
                                ."&fecha=".date("d/m/Y")."&concepto=".$Nconcepto."&valorConcepto=".$valorConcepto."&valorConceptoLetras="
                                .$valorConceptoLetras."&vigencia=1&MulDel=".$_POST['Finicio']."&MulAl=".$_POST['Ffinal']."&Expediente=".$_POST['expediente']."&Pexonera=".$_POST['Pexonera']."&TotalEx=".$_POST['total'];
                            }
                            // echo $data;
                            $data = array(
                            'message'=> $dat,
                            'case'=> 2);
                            echo json_encode($data); 
                        }else{
                            $db->rollback();
                            $data = array(
                            'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                  Erro al generar la orden de pago!',
                             'case'=> 1);
                            echo json_encode($data);
                        }
                    
                }else{
                    $db->rollback();
                    $db->close();
                    $data = array(
                    'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          Erro al generar la orden de pago11!',
                     'case'=> 1);
                    echo json_encode($data);

                }
            }else{
                    $sql2 = "SELECT nacionalidad_pais FROM paises WHERE  id_pais='".$nacionalidad."'";
                    $db = obtenerConexion();
                    $Nac = ejecutarQuery($db, $sql2);
                    if ($Nac) {
                        $db->commit();
                        $resultNac = $Nac->fetch_assoc();
                        $dat = "NoOrden=".$nuevo."&nombre=".$nombreCompeto."&nacionalidad=".strtoupper($resultNac['nacionalidad_pais'])."&fecha=".date("d/m/Y")."&concepto=".$Nconcepto."&valorConcepto=".$valorConcepto."&valorConceptoLetras=".$valorConceptoLetras;
                        // echo $data;
                        $data = array(
                        'message'=> $dat,
                        'case'=> 2);
                        echo json_encode($data); 
                    }else{
                        $db->rollback();
                        $db->close();
                        $data = array(
                        'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                              Erro al generar la orden de pago!',
                         'case'=> 1);
                        echo json_encode($data);
                    }
                
            }
        }else{
            $db->rollback();
            $db->close();
            $data = array(
            'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  Erro al generar la orden de pago!',
             'case'=> 1);
            echo json_encode($data);
        }
    }else{
        $data = array(
        'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              Erro al generar la orden de pago!',
         'case'=> 1);
        echo json_encode($data);
    }
    	
}

function buscarOrden()
{
    if(!empty($_POST['OrdenB'])){
        $sql = "SELECT dg.orden_pago, dg.id_concepto, cp.nombre_concepto, dg.primer_nombre, dg.segundo_nombre, dg.primer_apellido, 
                dg.segundo_apellido, dg.apellido_casada, dg.tipo_solicitud, dg.fecha_impresion, dg.estado 
                FROM datosgenerales dg, conceptos cp WHERE dg.id_concepto = cp.id_concepto  AND dg.orden_pago=".$_POST['OrdenB'];
        // $sql = "SELECT orden_pago, id_concepto, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, 
        // apellido_casada, nacionalidad, tipo_documento, numero_documento, tipo_solicitud, fecha_impresion, 
        // valor_concepto, estado FROM datosgenerales WHERE orden_pago=".$_POST['OrdenB'];
        $db = obtenerConexion();
        $orden = ejecutarQuery($db, $sql);
        $resp = $orden->fetch_assoc();
        
        if ($resp) {
            if ($resp['id_concepto']==8||$resp['tipo_solicitud']==0) {
                $data = array(
                 'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      La orden de pago No.: <strong>'.$_POST['OrdenB'].'</strong> no pertenece a esta area!.',
                 'case'=> 1);
                echo json_encode($data);
            }else{
                $datMulta="";
                if ($resp['id_concepto']==1) {
                    $sqlMulta = "SELECT fecha_inicio, fecha_final, dias, expediente, exonera FROM multa WHERE datogeneral=".$resp['orden_pago'];
                    $db = obtenerConexion();
                    $Mul = ejecutarQuery($db, $sqlMulta);
                    $respMulta = $Mul->fetch_assoc();

                    $datMulta='<div id="FechaInicioMod'.$resp['orden_pago'].'">'.date('d-m-Y',strtotime($respMulta['fecha_inicio'])).'</div>
                      <div id="FechaFinalMod'.$resp['orden_pago'].'">'.date('d-m-Y ',strtotime($respMulta['fecha_final'])).'</div>
                      <div id="DiasMod'.$resp['orden_pago'].'">'.$respMulta['dias'].'</div>';

                    if ($respMulta['expediente']!=NULL&&$respMulta['expediente']!="") {
                        $datMulta.='<div id="expedienteMod'.$resp['orden_pago'].'">'.$respMulta['expediente'].'</div>
                                    <div id="exoneraMod'.$resp['orden_pago'].'">'.$respMulta['exonera'].'</div>';
                    }
                }

                $fila = '
                    <tr class="cont">
                    <td class="col-xl-1 col-sm-1 col-md-1" >
                      <div class="text-center" id="orden'.$resp['orden_pago'].'">'.$resp['orden_pago'].'</div>
                    </td>
                    <td class="col-xl-1 col-sm-1 col-md-1" >
                      <div class="text-center" id="PnombreMod'.$resp['orden_pago'].'">'.$resp['primer_nombre'].'</div>
                    </td>
                    <td class="col-xl-1 col-sm-1 col-md-1" >
                      <div class="text-center" id="SnombreMod'.$resp['orden_pago'].'">'.$resp['segundo_nombre'].'</div>
                    </td>
                    <td class="col-xl-1 col-sm-1 col-md-1" >
                      <div class="text-center" id="PapellidoMod'.$resp['orden_pago'].'">'.$resp['primer_apellido'].'</div>
                    </td>
                    <td class="col-xl-1 col-sm-1 col-md-1" >
                      <div class="text-center" id="SapellidoMod'.$resp['orden_pago'].'">'.$resp['segundo_apellido'].'</div>
                    </td>
                    <td class="col-xl-1 col-sm-1 col-md-1" >
                      <div class="text-center" id="CapellidoMod'.$resp['orden_pago'].'">'.$resp['apellido_casada'].'</div>
                    </td>
                    <td class="col-xl-3 col-sm-3 col-md-3" >
                      <div class="text-center">'.$resp['nombre_concepto'].'</div>
                    </td>
                    <td class="col-xl-1 col-sm-1 col-md-1" >
                      <div class="text-center">'.date('d/m/Y H:i:s',strtotime($resp['fecha_impresion'])).'</div>
                    </td>
                    <td hidden>
                      '.$datMulta.'
                    </td>
                    <td class="col-xl-2 col-sm-2 col-md-2" style="padding-right: 0;padding-left: 0;">
                      <div class="btn-group text-center"  role="group" aria-label="accion" style="padding-left: 20%; padding-right: 20%;">
                        <button type="button" onclick="modificarOrden('.$resp['orden_pago'].');" class="btn btn-default" title="Modificar" >
                          <span class="glyphicon glyphicon-pencil"></span>
                        </button>
                        <button type="button" onclick="imprimirOrden('.$resp['orden_pago'].');" class="btn btn-default" title="Imprimir" >
                          <span class="glyphicon glyphicon-print"></span>
                        </button>
                      </div>
                    </td>
                  </tr>';

                  // <button type="button" onclick="anularOrden('.$resp['orden_pago'].');" class="btn btn-default" title="Anular" style="padding: 5px 8px;">
                  //         <span class="glyphicon glyphicon-ban-circle"></span>
                  //       </button>
                  
                $data = array(
                 'fila'=> $fila,
                 'case'=> 2);
                echo json_encode($data);

            }
        }else{
            $data = array(
             'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  La orden de pago No.: <strong>'.$_POST['OrdenB'].'</strong> no existe!.',
             'case'=> 1);
            echo json_encode($data);
        }

    }else{
        if (!empty($_POST['Pnombre'])||!empty($_POST['FechaBdel'])) {
            $sql = "SELECT dg.orden_pago, dg.id_concepto, cp.nombre_concepto, dg.primer_nombre, dg.segundo_nombre, dg.primer_apellido, 
                    dg.segundo_apellido, dg.apellido_casada, dg.fecha_impresion,  dg.variasPersonas, dg.estado 
                    FROM datosgenerales dg, conceptos cp WHERE dg.id_concepto = cp.id_concepto  AND ";
            // $sql = "SELECT orden_pago, id_concepto, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, 
            // apellido_casada, nacionalidad, tipo_documento, numero_documento, tipo_solicitud, fecha_impresion, 
            // valor_concepto, estado FROM datosgenerales WHERE ";
            
            $sqlDat = "";
            if (!empty($_POST['Pnombre'])) {
                $Pnombre = $_POST['Pnombre'];
                $sqlDat .= " dg.primer_nombre LIKE '%$Pnombre%'";
            }

            if (!empty($_POST['Snombre'])) {
                $Snombre = $_POST['Snombre'];
                $sqlDat .= " AND dg.segundo_nombre LIKE '%$Snombre%'";
            }

            if (!empty($_POST['Papellido'])) {
                $Papellido = $_POST['Papellido'];
                $sqlDat .= " AND dg.primer_apellido LIKE '%$Papellido%'";
            }

            if (!empty($_POST['Sapellido'])) {
                $Sapellido = $_POST['Sapellido'];
                $sqlDat .= " AND dg.segundo_apellido LIKE '%$Sapellido%'";
            }

            if (!empty($_POST['FechaBdel'])&&!empty($_POST['FechaBal'])) {
                $FechaDel = date("Y-m-d",strtotime($_POST['FechaBdel']));
                $FechaAl = strtotime('+1 day' ,strtotime($_POST['FechaBal']));
                $FechaAl = date ( 'Y-m-d' , $FechaAl );

                if ($sqlDat=="") {
                    $sqlDat .= " dg.fecha_impresion BETWEEN '".$FechaDel."' AND '".$FechaAl."'";
                }else{
                    $sqlDat .= " AND dg.fecha_impresion BETWEEN '".$FechaDel."' AND '".$FechaAl."'";
                }
            }
            $sqlDat .= " ORDER BY dg.fecha_impresion";
            $sql .= $sqlDat;
            // echo $sql;
            $db = obtenerConexion();
            $orden = ejecutarQuery($db, $sql);

            if ($orden) {
                // $resp = $orden->fetch_assoc();
                $fila="";

                while ($resp = $orden->fetch_assoc()) {
                    if ($resp['id_concepto']!=8&&$resp['variasPersonas']!=1) {
                                            
                        $datMulta="";
                        if ($resp['id_concepto']==1) {
                            $sqlMulta = "SELECT fecha_inicio, fecha_final, dias FROM multa WHERE datogeneral=".$resp['orden_pago'];
                            $db = obtenerConexion();
                            $Mul = ejecutarQuery($db, $sqlMulta);
                            $respMulta = $Mul->fetch_assoc();

                            $datMulta='<div id="FechaInicioMod'.$resp['orden_pago'].'">'.date('d-m-Y',strtotime($respMulta['fecha_inicio'])).'</div>
                              <div id="FechaFinalMod'.$resp['orden_pago'].'">'.date('d-m-Y ',strtotime($respMulta['fecha_final'])).'</div>
                              <div id="DiasMod'.$resp['orden_pago'].'">'.$respMulta['dias'].'</div>';
                        }

                        // $disa="";
                        // if ($resp['estado']==1) {
                        //     $estado='<div class="text-center"><span id="estado'.$resp['orden_pago'].'" class="label label-success">ACTIVO</span></div>';
                        // }else{
                        //     $estado='<div class="text-center"><span id="estado'.$resp['orden_pago'].'" class="label label-danger">ANULADO</span></div>';
                        //     $disa="disabled";
                        // }

                        $fila.= '
                        <tr class="cont">
                        <td class="col-xl-1 col-sm-1 col-md-1" >
                          <div class="text-center" id="orden'.$resp['orden_pago'].'">'.$resp['orden_pago'].'</div>
                        </td>
                        <td class="col-xl-1 col-sm-1 col-md-1" >
                          <div class="text-center" id="PnombreMod'.$resp['orden_pago'].'">'.$resp['primer_nombre'].'</div>
                        </td>
                        <td class="col-xl-1 col-sm-1 col-md-1" >
                          <div class="text-center" id="SnombreMod'.$resp['orden_pago'].'">'.$resp['segundo_nombre'].'</div>
                        </td>
                        <td class="col-xl-1 col-sm-1 col-md-1" >
                          <div class="text-center" id="PapellidoMod'.$resp['orden_pago'].'">'.$resp['primer_apellido'].'</div>
                        </td>
                        <td class="col-xl-1 col-sm-1 col-md-1" >
                          <div class="text-center" id="SapellidoMod'.$resp['orden_pago'].'">'.$resp['segundo_apellido'].'</div>
                        </td>
                        <td class="col-xl-1 col-sm-1 col-md-1" >
                          <div class="text-center" id="CapellidoMod'.$resp['orden_pago'].'">'.$resp['apellido_casada'].'</div>
                        </td>
                        <td class="col-xl-3 col-sm-3 col-md-3" >
                          <div class="text-center">'.$resp['nombre_concepto'].'</div>
                        </td>
                        <td class="col-xl-1 col-sm-1 col-md-1" >
                          <div class="text-center">'.date('d/m/Y H:i:s',strtotime($resp['fecha_impresion'])).'</div>
                        </td>
                        <td hidden>
                            '.$datMulta.'
                        </td>
                        <td class="col-xl-2 col-sm-2 col-md-2" style="padding-right: 0;padding-left: 0;">
                            <div class="btn-group text-center"  role="group" aria-label="accion" style="padding-left: 20%; padding-right: 20%;">
                                <button type="button" onclick="modificarOrden('.$resp['orden_pago'].');" class="btn btn-default" title="Modificar" >
                                  <span class="glyphicon glyphicon-pencil"></span>
                                </button>
                                <button type="button" onclick="imprimirOrden('.$resp['orden_pago'].');" class="btn btn-default" title="Imprimir" >
                                  <span class="glyphicon glyphicon-print"></span>
                                </button>
                            </div>
                        </td>
                      </tr>';
                    }
                }

                // <button id="anu'.$resp['orden_pago'].'" type="button" '.$disa.' onclick="anularOrden('.$resp['orden_pago'].');" class="btn btn-default" title="Anular" style="padding: 5px 8px;">
                //               <span class="glyphicon glyphicon-ban-circle"></span>
                //             </button>

                $data = array(
                 'fila'=> $fila,
                 'case'=> 2);
                echo json_encode($data);
                
            }else{
                $data = array(
                 'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      No se encontro ninguna orden con estos datos!',
                 'case'=> 1);
            echo json_encode($data);
            }

        }else{
            $data = array(
             'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  Error en los Datos!',
             'case'=> 1);
            echo json_encode($data);
        }
    }
}

function anularOrden()
{
    if(!empty($_POST['OrdenAnular'])){
        $sqlD = "SELECT boleta_banco FROM datosgenerales WHERE orden_pago=".$_POST['OrdenAnular'];
        $db = obtenerConexion();
        $bol = ejecutarQuery($db, $sqlD);
        $boleta = $bol->fetch_assoc();
        if ($boleta['boleta_banco']!=""||$boleta['boleta_banco']!=NULL) {
            $data = array(
            'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  La orden de pago No.<strong>'.$_POST['OrdenAnular'].'</strong> ya tiene registrada la boleta de banco No.<strong>'.$boleta['boleta_banco'].'</strong> por tal motivo <strong>no se puede anular!</strong>',
             'case'=> 1);
            echo json_encode($data);
            
        }else{
            $sql = "UPDATE datosgenerales SET estado=0 WHERE orden_pago=".$_POST['OrdenAnular'];
            $db = obtenerConexion();
            $db->autocommit(FALSE);
            $orden = ejecutarQuery($db, $sql);
            // echo $sql;
            if ($orden) {
                $hoy = date("Y-m-d H:i:s");
                $user = $_SESSION['id'];
                $IP = getIP();
                $sql2 = "INSERT INTO ordenanulada(datosgenerales, fecha, usuario, ip)
                        VALUES (".$_POST['OrdenAnular'].", '".$hoy."', ".$user.", '".$IP."')";

                // echo $sql2;
                $anul = ejecutarQuery($db, $sql2);

                if ($anul) {
                    $db->commit();
                    $data = array('case'=> 2);
                    echo json_encode($data);
                }else{
                    $db->rollback();
                    $data = array(
                    'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          Erro al anular la orden!',
                     'case'=> 1);
                    echo json_encode($data);
                }
                
            }else{
                $db->rollback();
                $data = array(
                'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      Erro al anular la orden!',
                 'case'=> 1);
                echo json_encode($data);  
            }
        }
    }else{
       $data = array(
            'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  Erro al anular la orden!',
             'case'=> 1);
        echo json_encode($data); 
    }
}

function imprOrden()
{
    if(!empty($_POST['OrdenImpr'])){
        
        $sql = "SELECT orden_pago, id_concepto, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, apellido_casada, 
                nacionalidad, fecha_impresion, valor_concepto  FROM datosgenerales WHERE orden_pago=".$_POST['OrdenImpr'];
        
        $db = obtenerConexion();
        $resu = ejecutarQuery($db, $sql);
        if ($resu) {
            $result = $resu->fetch_assoc();
            $sql2 = "SELECT nacionalidad_pais FROM paises WHERE id_pais='".$result['nacionalidad']."'";
        
            $db = obtenerConexion();
            $Nac = ejecutarQuery($db, $sql2);
            if ($Nac) {
                $resultNac = $Nac->fetch_assoc();
                $sql3 = "SELECT nombre_concepto, valor_concepto FROM conceptos WHERE id_concepto=".$result['id_concepto']."";
        
                $db = obtenerConexion();
                $Conp = ejecutarQuery($db, $sql3);

                if ($Conp) {
                    $resultConp = $Conp->fetch_assoc();
                    $fecha = date('d/m/Y', strtotime($result['fecha_impresion']));
                    $valorConceptoLetras = numtoletras($result['valor_concepto']);
                    if ($result['id_concepto']==1) {
                        $vigencia=1;
                    }else{
                        $vigencia=0;
                    }

                    if ($result['id_concepto']==1) {
                        $sqlMul ="SELECT fecha_inicio, fecha_final, total, expediente, exonera FROM multa WHERE datogeneral=".$result['orden_pago'];    
                        $db = obtenerConexion();
                        $resMul = ejecutarQuery($db, $sqlMul);
                        $resultMul = $resMul->fetch_assoc();
                        $Finicio = date("d-m-Y", strtotime($resultMul['fecha_inicio']));
                        $Ffinal = date("d-m-Y", strtotime($resultMul['fecha_final']));

                        if (!empty($resultMul['expediente'])) {
                            $expediente = $resultMul['expediente'];
                            $exonera = $resultMul['exonera'];
                        }

                    }else{
                        $Finicio = "";
                        $Ffinal = "";
                    }


                    $nombreCompeto = $result['primer_nombre'].' '.$result['segundo_nombre'].' '.$result['primer_apellido'].' '.$result['segundo_apellido'].' '.$result['apellido_casada'];
                    $datoOrden = "NoOrden=".$result['orden_pago']."&nombre=".$nombreCompeto."&nacionalidad="
                                .strtoupper($resultNac['nacionalidad_pais'])."&fecha=".$fecha."&concepto="
                                .$resultConp['nombre_concepto']."&valorConcepto=".number_format($result['valor_concepto'], 2)
                                ."&valorConceptoLetras=".$valorConceptoLetras."&vigencia=".$vigencia."&MulDel="
                                .$Finicio."&MulAl=".$Ffinal."&Expediente=".$expediente."&Pexonera=".$exonera."&TotalEx=".number_format($resultMul['total'], 2);

                    // echo $data;
                    $data = array(
                    'message'=> $datoOrden,
                     'case'=> 2);
                    echo json_encode($data); 
                }else{
                    $data = array(
                    'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          Erro al imprimir la orden!',
                     'case'=> 1);
                    echo json_encode($data);
                }
                
            }else{
                $data = array(
                'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      Erro al imprimir la orden!',
                 'case'=> 1);
                echo json_encode($data); 
            }
        }else{
            $data = array(
            'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  Erro al imprimir la orden!',
             'case'=> 1);
            echo json_encode($data); 
        }

    }else{
        $data = array(
            'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  Erro al imprimir la orden!',
             'case'=> 1);
        echo json_encode($data); 
    }
}

function MultaOrden()
{
    if(!empty($_POST['Orden'])&&!empty($_POST['Boleta'])){
        $sql = "SELECT orden_pago, id_concepto, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, apellido_casada, 
                estado, boleta_banco FROM datosgenerales WHERE orden_pago=".$_POST['Orden'];

        $db = obtenerConexion();
        $datoOrden = ejecutarQuery($db, $sql);
        $result = $datoOrden->fetch_assoc();
        if ($result['orden_pago']==$_POST['Orden']) {
            if ($result['estado']==0) {
                $data = array(
                 'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      La orden de pago No.<strong>'.$_POST['Orden'].'</strong> se encuentra <strong>anulada!</strong>',
                 'case'=> 1);
                echo json_encode($data);
            }else{
                if ($result['id_concepto']==2||$result['id_concepto']==8||$result['id_concepto']==9) {
                    $data = array(
                     'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          La orden de pago No.<strong>'.$_POST['Orden'].'</strong> No pertenece al concepto <strong>MULTA POR PERMANENCIA ILEGAL EN EL PAIS!</strong>',
                     'case'=> 1);
                    echo json_encode($data);

                }else if($result['boleta_banco']!=NULL||$result['boleta_banco']!=""){

                    $data = array(
                     'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          La orden de pago No.<strong>'.$_POST['Orden'].'</strong> ya tiene registrada la boleta de banco No.<strong>'.$result['boleta_banco'].'</strong>',
                     'case'=> 1);
                    echo json_encode($data);

                }else{

                    $sql1 = "SELECT orden_pago, id_concepto, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, apellido_casada, 
                        estado, boleta_banco FROM datosgenerales WHERE boleta_banco='".$_POST['Boleta']."'";

                    $db = obtenerConexion();
                    $datoBoleta = ejecutarQuery($db, $sql1);
                    $resultB = $datoBoleta->fetch_assoc();
                    if ($resultB['boleta_banco']==$_POST['Boleta']) {
                        $data = array(
                         'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                              La boleta de banco No.<strong>'.$resultB['boleta_banco'].'</strong> ya se encuentra registrada con la orden de pago No.<strong>'.$resultB['orden_pago'].'!</strong>',
                         'case'=> 1);
                        echo json_encode($data);

                    }else{
                        $sql2 = "UPDATE datosgenerales SET boleta_banco='".$_POST['Boleta']."' WHERE orden_pago=".$_POST['Orden'];
                        

                        $db = obtenerConexion();
                        $updaOrden = ejecutarQuery($db, $sql2);

                        if ($updaOrden) {
                            if ($result['id_concepto']==1) {
                                $sql3 = "UPDATE multa SET boleta_banco='".$_POST['Boleta']."' WHERE datogeneral=".$_POST['Orden'];
                                $updaMulta = ejecutarQuery($db, $sql3);
                                if ($updaMulta) {
                                    $data = array('case'=> 2);
                                    echo json_encode($data);
                                }else{
                                    $data = array(
                                     'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                          Error en los Datos!',
                                     'case'=> 1);
                                    echo json_encode($data);
                                }
                            }else{
                                $data = array('case'=> 2);
                                echo json_encode($data);
                            }
                        }else{
                            $data = array(
                             'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                  Error en los Datos!',
                             'case'=> 1);
                            echo json_encode($data);

                        }
                    }
                }
            }
        }else{
            $data = array(
             'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  La orden de pago No.<strong>'.$_POST['Orden'].'</strong> no <strong>existe!</strong>',
             'case'=> 1);
            echo json_encode($data);
        }

    }else{
        $data = array(
         'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              Error en los Datos!',
         'case'=> 1);
        echo json_encode($data);
    }
}

function ModOrden()
{
    if (!empty($_POST['OrdenMod'])) {

        $ordenModificar = $_POST['OrdenMod'];
        // $Pnombre = $_POST['Pnombre'];
        $sql = "UPDATE datosgenerales SET ";
        $sqlMod= "";
        if(!empty($_POST['Pnombre'])){
            $Pnombre =$_POST['Pnombre'];
            $sql .= " primer_nombre='".$Pnombre."', ";

        }else{
            $Snombre ="";
        }
        
        if(!empty($_POST['Snombre'])){
            $Snombre =$_POST['Snombre'];
            $sql .= " segundo_nombre='".$Snombre."', ";

        }else if (isset($_POST['Snombre'])) {
            $Snombre =$_POST['Snombre'];
            $sql .= " segundo_nombre='".$Snombre."', ";
        }else{
            $Snombre ="";
        }

        // $Papellido = $_POST['Papellido'];
        // $sql .= " primer_apellido='".$Papellido."', ";
        if(!empty($_POST['Papellido'])){
            $Papellido = $_POST['Papellido'];
            $sql .= " primer_apellido='".$Papellido."', ";

        }else{
            $Sapellido ="";
        }


        if(!empty($_POST['Sapellido'])){
            $Sapellido = $_POST['Sapellido'];
            $nombreCompeto.=" ".$_POST['Sapellido'];
            $sql .= " segundo_apellido='".$Sapellido."', ";

        }else if (isset($_POST['Sapellido'])) {
            $Sapellido =$_POST['Sapellido'];
            $sql .= " segundo_apellido='".$Sapellido."', ";
        }else{
            $Sapellido ="";
        }

        if(!empty($_POST['Capellido'])){
            $Capellido = $_POST['Capellido'];
            $sql .= " apellido_casada='".$Capellido."', ";
        }else if (isset($_POST['Capellido'])) {
            $Capellido =$_POST['Capellido'];
            $sql .= " apellido_casada='".$Capellido."', ";
        }else{
            $Capellido ="";
        }

        // if(!empty($_POST['resolucion'])){
        //     $resolucion = $_POST['resolucion'];

        // }else{
        //     $resolucion ="";
        // }

        // $nacionalidad = $_POST['cboNacionalidad'];
        // $tipoDoc = $_POST['cboTipoDoc'];
        // $NumDoc = $_POST['NumDoc'];
        // $pais = $_POST['cboPais'];
        // $LugarExtDoc = $_POST['LugarExtDoc'];
        // $concepto = $_POST['cboConcepto'];
        // $Nconcepto = $_POST['NConcepto'];
        if (!empty($_POST['Texonera'])) {
            $sql .= " valor_concepto=".$_POST['Texonera'].", ";
        }else if (!empty($_POST['total'])) {
            $sql .= " valor_concepto=".$_POST['total'].", ";
        }
        // $valorConcepto = $_POST['VConcepto'];
        

        $hoy = date("Y-m-d H:i:s");
        $user = $_SESSION['id'];
        $IP = getIP();

        // $sql .= " fecha_impresion='".$hoy."', usuario_orden=".$user.", ip_orden='".$IP."' WHERE orden_pago=".$ordenModificar;
        $sql .= " fecha_impresion='".$hoy."', ip_orden='".$IP."' WHERE orden_pago=".$ordenModificar;
        // echo $sql;
        $db = obtenerConexion();
        $result = ejecutarQuery($db, $sql);

        
        if ($result) {
            if (!empty($_POST['total'])&&!empty($_POST['Dias'])) {
            
                $sql2 = "UPDATE multa SET dias=".$_POST['Dias'].", total=".$_POST['total']." ";
                $fech="";
                if (!empty($_POST['Finicio'])) {
                    $Finicio = date('Y-m-d', strtotime($_POST['Finicio']));
                    $fech .= ", fecha_inicio='".$Finicio."' ";
                }
                if (!empty($_POST['Ffinal'])) {
                    $Ffinal = date('Y-m-d', strtotime($_POST['Ffinal']));
                    if ($fech=="") {
                        $fech .= ", fecha_final='".$Ffinal."' ";
                       
                    }else{
                        $fech .= ", fecha_final='".$Ffinal."' ";
                        
                    }
                }

                if (!empty($_POST['exon'])) {
                    $fech .= ", expediente='' ";
                    $fech .= ", exonera=NULL ";
                    $fech .= ", descuento=NULL ";
                    $fech .= ", total_orden=NULL ";

                }else{
                    if (!empty($_POST['Nexpediente'])) {
                        $Nexpediente = $_POST['Nexpediente'];
                        $fech .= ", expediente='".$Nexpediente."' ";
                    }
                    if (!empty($_POST['Pexonera'])) {
                        $Pexonera = $_POST['Pexonera'];
                        $fech .= ", exonera=".$Pexonera." ";
                    }
                    if (!empty($_POST['Dexonera'])) {
                        $Dexonera = $_POST['Dexonera'];
                        $fech .= ", descuento=".$Dexonera." ";
                    }
                    if (!empty($_POST['Texonera'])) {
                        $Texonera = $_POST['Texonera'];
                        $fech .= ", total_orden=".$Texonera." ";
                    }
                }

                
                $sql2 .= $fech." WHERE datogeneral=".$ordenModificar;
                
                // echo $sql2;
                $db = obtenerConexion();
                $result = ejecutarQuery($db, $sql2);

                if ($result) {
                     $sql = "SELECT dg.orden_pago, dg.id_concepto, cp.nombre_concepto, dg.primer_nombre, dg.segundo_nombre, dg.primer_apellido, 
                        dg.segundo_apellido, dg.apellido_casada, dg.tipo_solicitud, dg.fecha_impresion, dg.estado, dg.valor_concepto, dg.nacionalidad, ps.nacionalidad_pais 
                        FROM datosgenerales dg, conceptos cp, paises ps WHERE dg.nacionalidad=ps.id_pais AND dg.id_concepto = cp.id_concepto  AND dg.orden_pago=".$ordenModificar;

                    // $sqlMul ="SELECT fecha_inicio, fecha_final FROM multa WHERE datogeneral=".$ordenModificar;    
                    $sqlMul ="SELECT fecha_inicio, fecha_final, total, expediente, exonera FROM multa WHERE datogeneral=".$ordenModificar;    

                    $db = obtenerConexion();
                    $res = ejecutarQuery($db, $sql);
                    $resMul = ejecutarQuery($db, $sqlMul);
                    
                    $result = $res->fetch_assoc();
                    $resultMul = $resMul->fetch_assoc();

                    if (!empty($resultMul['expediente'])) {
                        $expediente = $resultMul['expediente'];
                        $exonera = $resultMul['exonera'];
                    }

                    $nombreCompeto = $result['primer_nombre'].' '.$result['segundo_nombre'].' '.$result['primer_apellido'].' '.$result['segundo_apellido'].' '.$result['apellido_casada'];
                    $valorConceptoLetras = numtoletras($result['valor_concepto']);

                    $dat = "NoOrden=".$result['orden_pago']."&nombre=".$nombreCompeto."&nacionalidad="
                    .strtoupper($result['nacionalidad_pais'])."&fecha=".date("d/m/Y", strtotime($result['fecha_impresion']))
                    ."&concepto=".$result['nombre_concepto']."&valorConcepto=".number_format($result['valor_concepto'], 2)
                    ."&valorConceptoLetras=".$valorConceptoLetras."&vigencia=1&MulDel=".date("d-m-Y", strtotime($resultMul['fecha_inicio']))
                    ."&MulAl=".date("d-m-Y", strtotime($resultMul['fecha_final']))."&Expediente=".$expediente."&Pexonera=".$exonera."&TotalEx=".number_format($resultMul['total'], 2);

                    // $datoOrden = "NoOrden=".$result['orden_pago']."&nombre=".$nombreCompeto."&nacionalidad="
                    // .strtoupper($resultNac['nacionalidad_pais'])."&fecha=".$fecha."&concepto="
                    // .$resultConp['nombre_concepto']."&valorConcepto=".number_format($result['valor_concepto'], 2)
                    // ."&valorConceptoLetras=".$valorConceptoLetras."&vigencia=".$vigencia."&MulDel="
                    // .$Finicio."&MulAl=".$Ffinal."&Expediente=".$expediente."&Pexonera=".$exonera."&TotalEx=".number_format($resultMul['total'], 2);

                    // echo $data;
                    $data = array(
                    'message'=> $dat,
                    'case'=> 2);
                    echo json_encode($data); 

                }else{
                    $data = array(
                    'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          Erro al modificar la orden de pago11!',
                     'case'=> 1);
                    echo json_encode($data);

                }
           
            }else{

                $sql = "SELECT dg.orden_pago, dg.id_concepto, cp.nombre_concepto, dg.primer_nombre, dg.segundo_nombre, dg.primer_apellido, 
                        dg.segundo_apellido, dg.apellido_casada, dg.tipo_solicitud, dg.fecha_impresion, dg.estado, dg.valor_concepto, dg.nacionalidad, ps.nacionalidad_pais 
                        FROM datosgenerales dg, conceptos cp, paises ps WHERE dg.nacionalidad=ps.id_pais AND dg.id_concepto = cp.id_concepto  AND dg.orden_pago=".$ordenModificar;

                $db = obtenerConexion();
                $res = ejecutarQuery($db, $sql);

                $result = $res->fetch_assoc();


                $nombreCompeto = $result['primer_nombre'].' '.$result['segundo_nombre'].' '.$result['primer_apellido'].' '.$result['segundo_apellido'].' '.$result['apellido_casada'];
                $valorConceptoLetras = numtoletras($result['valor_concepto']);


                $dat = "NoOrden=".$result['orden_pago']."&nombre=".$nombreCompeto."&nacionalidad=".strtoupper($result['nacionalidad_pais'])."&fecha=".date("d/m/Y", strtotime($result['fecha_impresion']))
                ."&concepto=".$result['nombre_concepto']."&valorConcepto=".$result['valor_concepto']."&valorConceptoLetras=".$valorConceptoLetras;
                // echo $data;
                $data = array(
                'message'=> $dat,
                'case'=> 2);
                echo json_encode($data); 

            }
        }else{
            $db->rollback();
            $db->close();
            $data = array(
            'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  Erro al modificar la orden de pago11!',
             'case'=> 1);
            echo json_encode($data);
        }
    }else{
        $data = array(
        'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              Erro al modificar la orden de pago11!',
         'case'=> 1);
        echo json_encode($data);
    }
}

function getIP()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))
      $ip = $_SERVER['HTTP_CLIENT_IP'];
    else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
      $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else $ip = $_SERVER['REMOTE_ADDR'];

    return $ip; 
}
?>