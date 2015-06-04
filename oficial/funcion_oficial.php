<?php 
ini_set('display_errors', 'On');
ini_set('display_errors', 0); 
require_once('../res/conexion.php'); 
require_once('../res/numLetras.php');
require_once('../res/fecha_letras.php');
require_once('../res/phpqrcode/phpqrcode.php');
require_once('../res/funciones.php');  

if(!isset($_SESSION)) 
{ 
    session_start(); 
}


switch ($_POST['fun']) {
	case '1':
		datosOficial();
		break;
  case '2':
    buscarOficial();
    break;
  case '3':
    modOficial();
    break;

	case '50':
		comprobarOrden();
		break;
    case '22':
        comprobarDato();
        break;
    case '33':
        impresionCertificacion();
        break;
    case '4':
        certificacionOficial();
        break;
    case '5':
        modPaticularDatos();
        break;
    case '6':
        guardarModParticular();
        break;
    case '7':
        modOficialDatos();
        break;
    case '8':
        guardarModOficial();
        break;
    case '9':
        reimprisionParticular();
        break;
    case '10':
        impreParticular();
        break;
    case '11':
        reimprisionOficial();
        break;
    case '12':
        impreOficial();
        break;
    case '13':
	      addAsunto();
	      break;
    case '14':
	      modAsunto();
	      break;
}

function datosOficial()
{
  $data = json_decode(stripslashes($_POST['datos']));
  $i=1;
  foreach($data as $dato=>$valor)
  {
    $i++;  

  }
  // echo $i;
  // $NfolioEntrada = $data->{NfolioEntrada};

  
  $NfolioEntrada = getFolio();
  $Asunto = $data->{Asunto};
  $user = $_SESSION['id'];
  $IP = getIP();
  $anio = date("Y");
  $hoy = date("Y-m-d H:i:s");
  // echo "Folio--".$NfolioEntrada;

  if ($i>=4) {
      # Varios nombres
      $db = obtenerConexion();
      $db->autocommit(FALSE);

      $sql = "INSERT INTO datosgenerales (id_concepto, primer_nombre, primer_apellido, tipo_solicitud, fecha_impresion, usuario_orden, ip_orden, asunto, folio_entrada, anio, variasPersonas) 
              VALUES (2, 'VARIASPERSONAS', 'VARIASPERSONAS', 0, '".$hoy."','".$user."', '".$IP."', ".$Asunto.", '".$NfolioEntrada."', ".$anio.", 1)";
      $result = ejecutarQuery($db, $sql);
      if ($result) {
        $nuevo = datoNuevo($db);
        foreach($data as $dato=>$valor)
        { 
          $dt = array();
          foreach((array) $valor as $name=>$val)
          {
            if ($name!="0") {
              $dt[] = $val;
            }
          }
          if (!empty($dt)) {
            $sql2 = "INSERT INTO persona (datogeneral, primer_nombre, segundo_nombre, primer_apellido, 
                    segundo_apellido, apellido_casada) VALUES (".$nuevo.", '".$dt[0]."', '".$dt[1]."', 
                    '".$dt[2]."', '".$dt[3]."', '".$dt[4]."')";
            
            $resultPersona = ejecutarQuery($db, $sql2);
            $error=True;
            if ($resultPersona) {
              $error=False;
              // GUARDAR PERIODOS DURANTE
              $itDate = 1;
              $nuevoPersona = datoNuevo($db);
              $db->commit();
              $dt2 = array();
              foreach((array) $dt[5] as $name2=>$val2)
              { 
                if ($name2!="0") {
                  $dt2[] = $val2;
                }
                if ($itDate==2) {
                  if ($dt2[0]!=""&&$dt2[1]!="") {
                    // $db->autocommit(FALSE);
                    $sql3 = "INSERT INTO periododurante (ordenpago, persona, periodoDel, periodoAl) 
                            VALUES (".$nuevo.", ".$nuevoPersona.", '".date("Y-m-d", strtotime($dt2[0]))."', '".date("Y-m-d", strtotime($dt2[1]))."')";
                    $resultPeriodo = ejecutarQuery($db, $sql3);
                    if ($resultPeriodo) {
                      $error=False;
                    }

                    $dt2 = array();
                    $itDate = 1;
                  }
                }else{
                  $itDate++;
                }
                
              }

              // GUARDAR PERSONAS Y/O
              foreach((array) $dt[6] as $name3=>$val3)
              { 
                $dt3 = array();
                if ($name3!="0") {
                  $dt3[] = $val3;
                }
                $dt4 = array();
                foreach((array) $val3 as $name4=>$val4)
                {
                  if ($name4!="0") {
                    $dt4[] = $val4;
                  }
                }
                // print_r($dt4);

                $db->autocommit(FALSE);
                $sqlYO = "INSERT INTO persona (datogeneral, primer_nombre, segundo_nombre, primer_apellido, 
                        segundo_apellido, apellido_casada, YO) VALUES (".$nuevo.", '".$dt4[0]."', '".$dt4[1]."', 
                        '".$dt4[2]."', '".$dt4[3]."', '".$dt4[4]."', ".$nuevoPersona.")";
                
                $resultPersonaYO = ejecutarQuery($db, $sqlYO);

                if ($resultPersonaYO) {
                  $error=False;
                }

                $itDateYO = 1;
                $nuevoPersonaYO = datoNuevo($db);
                $db->commit();
                $dt5 = array();
                foreach((array) $dt4[5] as $name5=>$val5)
                { 
                  if ($name5!="0") {
                    $dt5[] = $val5;
                  }

                  if ($itDateYO==2) {
                    if ($dt5[0]!=""&&$dt5[1]!="") {
                    // $db->autocommit(FALSE);
                      $db = obtenerConexion();
                      $sql3 = "INSERT INTO periododurante (ordenpago, persona, periodoDel, periodoAl) 
                              VALUES (".$nuevo.", ".$nuevoPersonaYO.", '".date("Y-m-d", strtotime($dt5[0]))."', '".date("Y-m-d", strtotime($dt5[1]))."')";
                      $resultPeriodoYO = ejecutarQuery($db, $sql3);
                      if ($resultPeriodoYO) {
                        $error=False;
                        // echo "Correcto";
                        // $db->commit();
                      }
                      $dt5 = array();
                      $itDateYO = 1;
                    }
                  }else{
                    $itDateYO++;
                  }
                }
              }
            }
          }
        }

        if ($error) {
          $db->rollback();
          $Resp = array(
           'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Error en la transaccion</strong>
                          </div>',
           'case'=> 3);
          echo json_encode($Resp);
        }else{
          $db->commit();
          $Norden=$nuevo;
              //$numeroBoleta = $_POST['Nboleta'];
          $sql = "SELECT dg.orden_pago, dg.primer_nombre, dg.segundo_nombre, dg.primer_apellido, dg.segundo_apellido, 
                  dg.apellido_casada, dg.tipo_solicitud, dg.numero_folio , dg.anio,  dg.asunto, dg.folio_entrada, dg.negativa, 
                  dg.variasPersonas, at.nombre, at.cargo, at.asunto, at.dependencia FROM datosgenerales dg, asunto at WHERE dg.asunto=at.id AND orden_pago=".$Norden;
          $db = obtenerConexion();
          $orden = ejecutarQuery($db, $sql);
          $resp = $orden->fetch_assoc();

          if ($resp) {

            if ($resp['variasPersonas']!=0||$resp['variasPersonas']!=NULL) {
                $db = obtenerConexion();
                $sql = "SELECT id, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, 
                            apellido_casada FROM persona WHERE YO IS NULL AND datogeneral=".$resp['orden_pago'];

                $resultDat = ejecutarQuery($db, $sql);
                $cantidad=1;
                $fila="";
                while($row = $resultDat->fetch_assoc()){
                  $fila.='
                        <tr id="fila1" name="fila" class="cont">
                          <td class="col-xl-1 col-sm-1 col-md-1" >
                            <span  class="close" id="1" style="font-size:28px;float: left;padding: 0;" >'.$cantidad.'</span>
                          </td>
                          <td class="col-xl-2 col-sm-2 col-md-2" >
                            <p class="form-control-static text-center" >'.$row['primer_nombre'].'</p>
                          </td>
                          <td class="col-xl-2 col-sm-2 col-md-2" >
                            <p class="form-control-static text-center" >'.$row['segundo_nombre'].'</p>
                          </td>
                          <td class="col-xl-2 col-sm-2 col-md-2" >
                            <p class="form-control-static text-center" >'.$row['primer_apellido'].'</p>
                          </td>
                          <td class="col-xl-2 col-sm-2 col-md-2" >
                            <p class="form-control-static text-center" >'.$row['segundo_apellido'].'</p>
                          </td>
                          <td class="col-xl-2 col-sm-2 col-md-2" >
                            <p class="form-control-static text-center" >'.$row['apellido_casada'].'</p>
                          </td>
                        </tr>';
                  $cantidad++;

                  $db = obtenerConexion();
                  $sqlPer = "SELECT periodoDel, periodoAl FROM periododurante WHERE persona=".$row['id']." AND ordenpago=".$resp['orden_pago'];
                  $resultPeriodo = ejecutarQuery($db, $sqlPer);
                  $filab="";
                  $datPeriodo="";

                  while($rowPeriodo = $resultPeriodo->fetch_assoc()){
                    $datPeriodo.= '
                          <div  class="cant" style="padding-bottom: 2.7em;">
                            <div class="col-xl-11 col-sm-11 col-md-11">
                              <div class="input-group ">
                                <input type="text" readonly value="'.date("d-m-Y", strtotime($rowPeriodo['periodoDel'])).'" class="input-group date form-control text-center">
                                  <span class="input-group-addon">AL</span>
                                <input type="text" readonly value="'.date("d-m-Y", strtotime($rowPeriodo['periodoAl'])).'" class="input-group date form-control text-center">
                              </div>
                            </div>
                            <div class="col-xl-1 col-sm-1 col-md-1">
                            </div>
                          </div>';
                  }

                  if ($datPeriodo!="") {
                    $filab.='
                        <tr class="op" id="filb1">
                          <td class="op" colspan="7">
                            <div id="Periodo1" class="col-xl-12 col-sm-12 col-md-12 well" >
                              <legend><span class="Colet">Periodo</span></legend>
                              <div class=" col-xl-12 col-sm-12 col-md-12">
                                <div class="col-xl-12 col-sm-12 col-md-12">
                                  <label for="Durante" class="Colet" style="margin-left: 23em;">Durante el Periodo</label><br>
                                  <label for="Del" class="Colet" style="padding-right: 26.5em; padding-left: 2em;">Del:</label>
                                  <label for="Al"  class="Colet">Al:</label>
                                </div>
                                '.$datPeriodo.'
                              </div>
                            </div>
                          </td>
                        </tr>';
                    $fila.=$filab;
                  }


                  $db = obtenerConexion();
                  $sql2 = "SELECT id, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, 
                            apellido_casada FROM persona WHERE YO=".$row['id']." AND datogeneral=".$resp['orden_pago'];

                  $resultDat2 = ejecutarQuery($db, $sql2);
                  $filaYO="";
                  $filabYO="";
                  $datPeriodoYO="";
                  while($row2 = $resultDat2->fetch_assoc()){
                    $filaYO.='
                        <tr id="fila1" name="fila" class="cont">
                          <td class="col-xl-1 col-sm-1 col-md-1">
                            <span  class="close" id="1" style="font-size:28px;float: left;padding: 0;" >Y/O</span>
                          </td>
                          <td class="col-xl-2 col-sm-2 col-md-2" >
                            <p class="form-control-static text-center" >'.$row2['primer_nombre'].'</p>
                          </td>
                          <td class="col-xl-2 col-sm-2 col-md-2" >
                            <p class="form-control-static text-center" >'.$row2['segundo_nombre'].'</p>
                          </td>
                          <td class="col-xl-2 col-sm-2 col-md-2" >
                            <p class="form-control-static text-center" >'.$row2['primer_apellido'].'</p>
                          </td>
                          <td class="col-xl-2 col-sm-2 col-md-2" >
                            <p class="form-control-static text-center" >'.$row2['segundo_apellido'].'</p>
                          </td>
                          <td class="col-xl-2 col-sm-2 col-md-2" >
                            <p class="form-control-static text-center" >'.$row2['apellido_casada'].'</p>
                          </td>
                        </tr>';


                      $db = obtenerConexion();
                      $sqlPerYO = "SELECT periodoDel, periodoAl FROM periododurante WHERE persona=".$row2['id']." AND ordenpago=".$resp['orden_pago'];
                      $resultPeriodoYO = ejecutarQuery($db, $sqlPerYO);

                      while($rowPeriodoYO = $resultPeriodoYO->fetch_assoc()){
                        $datPeriodoYO.= '<div  class="cant" style="padding-bottom: 2.7em;">
                                <div class="col-xl-11 col-sm-11 col-md-11">
                                  <div class="input-group ">
                                    <input type="text" readonly value="'.date("d-m-Y", strtotime($rowPeriodoYO['periodoDel'])).'" class="input-group date form-control text-center">
                                      <span class="input-group-addon">AL</span>
                                    <input type="text" readonly value="'.date("d-m-Y", strtotime($rowPeriodoYO['periodoAl'])).'" class="input-group date form-control text-center">
                                  </div>
                                  </div>
                                  <div class="col-xl-1 col-sm-1 col-md-1">
                                  </div>
                                </div>';
                      }  
                      if ($datPeriodoYO!="") {
                          $filabYO.='
                              <tr class="op" id="filb1">
                                <td class="op" colspan="7">
                                  <div id="Periodo1" class="col-xl-12 col-sm-12 col-md-12 well" >
                                    <legend><span class="Colet">Periodo</span></legend>
                                    <div class=" col-xl-12 col-sm-12 col-md-12">
                                      <div class="col-xl-12 col-sm-12 col-md-12">
                                        <label for="Durante" class="Colet" style="margin-left: 23em;">Durante el Periodo</label><br>
                                        <label for="Del" class="Colet" style="padding-right: 26.5em; padding-left: 2em;">Del:</label>
                                        <label for="Al"  class="Colet">Al:</label>
                                      </div>
                                      '.$datPeriodoYO.'
                                    </div>
                                  </div>
                                </td>
                              </tr>';
                          $filaYO.=$filabYO;
                        }
                  }

                  $fila.=$filaYO;
                }

                $data = array(
                    'message' => '
                          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 toppad" >
                            <div class="panel panel-info">
                              <div class="panel-heading">
                                <h3 class="panel-title">Datos Oficial Folio No. <span id="NfolioEntradaReim"><strong>'.$resp['folio_entrada'].'-'.$resp['anio'].'</strong></span></h3>
                              </div>
                              <div class="panel-body">
                                <div class="row">             
                                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                                    <div class="form-horizontal">
                                      <div class="form-horizontal form-group col-xl-12 col-sm-12 col-md-12">
                                        <div for="Asunto" class="col-xl-2 col-sm-2 col-md-2 Colet text-center" style="padding-right:0;"><p style="font-weight: bold;">Asunto:</p></div>
                                        <div class="col-xl-10 col-sm-10 col-md-10 Colet" style="padding-left:0;padding-top:0;">
                                            <p class="form-control-static text-left" style="padding-top:0;">'.$resp['nombre'].', '.$resp['cargo'].', '.$resp['dependencia'].', '.$resp['asunto'].'</p>
                                        </div>
                                      </div>

                                      <table id="tabla" class="table table-hover col-xl-12 col-sm-12 col-md-12 Colet">
                                        <thead>
                                          <tr>
                                            <th class="col-xl-1 col-sm-1 col-md-1">
                                              <span style="">#</span>
                                            </th>
                                            <th class="col-xl-3 col-sm-3 col-md-3 text-center">Primer Nombre</th>
                                            <th class="col-xl-2 col-sm-2 col-md-2 text-center">Segundo Nombre</th>
                                            <th class="col-xl-2 col-sm-2 col-md-2 text-center">Primer Apellido</th>
                                            <th class="col-xl-2 col-sm-2 col-md-2 text-center">Segundo Apellido</th>
                                            <th class="col-xl-2 col-sm-2 col-md-2 text-center">Apellido de Casada</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          '.$fila.'
                                        </tbody>
                                        </table>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>      
                          </div>
                              <div class="col-xl-3 col-sm-3 col-md-3 col-md-offset-4 pull-right">
                                <button type="button" id="btn_reimprimir"  class="btn btn-primary btn-lg btn-shadow" onclick="contiOficial();" tabindex=0 >
                                  Continuar
                                  <span class="glyphicon glyphicon-chevron-right"></span>
                                </button> 
                              </div>
                          </div>',
                    'case' => 3 );
                  
                echo json_encode($data);

            }else{
               $data = array(
               'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                Ocurrio un error al almacenar los datos!
                              </div>',
               'case'=> 1);
          
                echo json_encode($data);
              
            }   
            
          }else{
            $data = array(
           'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            Ocurrio un error al almacenar los datos!
                          </div>',
           'case'=> 1);
      
            echo json_encode($data);
          }
        }

      }else{
        $db->rollback();
        $Resp = array(
               'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong>Error en la transacción</strong>
                              </div>',
               'case'=> 3);
              
        echo json_encode($Resp);
      }
  }else{
    // UNA PERSONA
    $error = true;
    foreach($data as $dato=>$valor)
    { 
      $dt = array();
      foreach((array) $valor as $name=>$val)
      {
        if ($name!="0") {
          $dt[] = $val;
        }
      }

      if (!empty($dt)) {
          foreach((array) $dt[6] as $name3=>$val3)
          {
            $dtYO[] =$val3;
          }
        if (!empty($dtYO)) {
          $db = obtenerConexion();
          $db->autocommit(FALSE);

          $sql = "INSERT INTO datosgenerales (id_concepto, primer_nombre, primer_apellido, tipo_solicitud, fecha_impresion, usuario_orden, ip_orden, asunto, folio_entrada, anio, variasPersonas) 
                  VALUES (2, 'VARIASPERSONAS', 'VARIASPERSONAS', 0, '".$hoy."','".$user."', '".$IP."', ".$Asunto.", '".$NfolioEntrada."', ".$anio.", 1)";

          $result = ejecutarQuery($db, $sql);

          if ($result) {
            $nuevo = datoNuevo($db);
            foreach($data as $dato=>$valor)
            { 
              $dt = array();
              foreach((array) $valor as $name=>$val)
              {
                if ($name!="0") {
                  $dt[] = $val;
                }
              }
              // print_r($dt);
              if (!empty($dt)) {
                $db->commit();
                $sql2 = 'INSERT INTO persona (datogeneral, primer_nombre, segundo_nombre, primer_apellido, 
                        segundo_apellido, apellido_casada) VALUES ('.$nuevo.', "'.$dt[0].'", "'.$dt[1].'", 
                        "'.$dt[2].'", "'.$dt[3].'", "'.$dt[4].'")';
                
                
                $db = obtenerConexion();
                $db->autocommit(FALSE);
                // $db->autocommit(FALSE);
                $resultPersona = ejecutarQuery($db, $sql2);
                // $error=True;
                if ($resultPersona) {
                  // $db->commit();
                  $error=False;

                  // GUARDAR PERIODOS DURANTE
                  $itDate = 1;
                  $nuevoPersona = datoNuevo($db);
                  $db->commit();
                  $dt2 = array();
                  foreach((array) $dt[5] as $name2=>$val2)
                  { 
                    if ($name2!="0") {
                      $dt2[] = $val2;
                    }

                    if (!empty($dt2)) {
                      if ($itDate==2) {
                        if ($dt2[0]!=""&&$dt2[1]!="") {
                          $sql3 = "INSERT INTO periododurante (ordenpago, persona, periodoDel, periodoAl) 
                                  VALUES (".$nuevo.", ".$nuevoPersona.", '".date("Y-m-d", strtotime($dt2[0]))."', '".date("Y-m-d", strtotime($dt2[1]))."')";
                          $resultPeriodo = ejecutarQuery($db, $sql3);
                          if ($resultPeriodo) {
                            $error=False;
                          }else{
                            $error=true;
                          }
                          $dt2 = array();
                          $itDate = 1;
                        }
                      }else{
                        $itDate++;
                      }
                    }
                  }

                  // GUARDAR PERSONAS Y/O
                  foreach((array) $dt[6] as $name3=>$val3)
                  { 
                    $dt3 = array();
                    if ($name3!="0") {
                      $dt3[] = $val3;
                    }
                    $dt4 = array();
                    foreach((array) $val3 as $name4=>$val4)
                    {
                      if ($name4!="0") {
                        $dt4[] = $val4;
                      }
                    }
                    $sqlYO = 'INSERT INTO persona (datogeneral, primer_nombre, segundo_nombre, primer_apellido, 
                            segundo_apellido, apellido_casada, YO) VALUES ('.$nuevo.', "'.$dt4[0].'", "'.$dt4[1].'", 
                            "'.$dt4[2].'", "'.$dt4[3].'", "'.$dt4[4].'", '.$nuevoPersona.')';
                    
                    $db = obtenerConexion();
                    $resultPersonaYO = ejecutarQuery($db, $sqlYO);

                    if ($resultPersonaYO) {
                      $error=False;
                    }

                    // PERIODO Y/O
                    $itDateYO = 1;
                    $nuevoPersonaYO = datoNuevo($db);
                    $dt5 = array();
                    foreach((array) $dt4[5] as $name5=>$val5)
                    { 
                      if ($name5!="0") {
                        $dt5[] = $val5;
                      }
                      if ($itDateYO==2) {
                        if ($dt5[0]!=""&&$dt5[1]!="") {
                          $sql3 = "INSERT INTO periododurante (ordenpago, persona, periodoDel, periodoAl) 
                                  VALUES (".$nuevo.", ".$nuevoPersonaYO.", '".date("Y-m-d", strtotime($dt5[0]))."', '".date("Y-m-d", strtotime($dt5[1]))."')";
                          $resultPeriodoYO = ejecutarQuery($db, $sql3);
                          if ($resultPeriodoYO) {
                            $error=False;
                            // echo "Correcto";
                            $db->commit();
                          }
                          $dt5 = array();
                          $itDateYO = 1;
                        }
                      }else{
                        $itDateYO++;
                      }                      
                    }
                  }

                }else{
                  $error = True;
                }
              }
            }

          }else{
            $db->rollback();
            $error = true;
            $Resp = array(
                   'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <strong>Error en la transacción22</strong>
                                  </div>',
                   'case'=> 3);
                  
            echo json_encode($Resp);
          }

        }else{
          // SIN Y/O
          $sql = 'INSERT INTO datosgenerales (id_concepto, primer_nombre, segundo_nombre, primer_apellido, 
              segundo_apellido, apellido_casada, tipo_solicitud, fecha_impresion, usuario_orden, ip_orden, asunto, 
              folio_entrada, anio, variasPersonas) VALUES 
              (2, "'.$dt[0].'", "'.$dt[1].'", "'.$dt[2].'", "'.$dt[3].'", "'.$dt[4].'", 0, "'.$hoy.'","'.$user.'", "'.$IP.'", '.$Asunto.', 
                "'.$NfolioEntrada.'", '.$anio.', 0)';

          $db = obtenerConexion();
          // $db->autocommit(FALSE);
          $result = ejecutarQuery($db, $sql);
          $error=False;

          if ($result) {
            $nuevo = datoNuevo($db);
            // GUARDAR PERIODOS DURANTE
            $itDate = 1;
            $dt2 = array();
            foreach((array) $dt[5] as $name2=>$val2)
            { 
              if ($name2!="0") {
                $dt2[] = $val2;
              }
              if ($itDate==2) {
                if ($dt2[0]!=""&&$dt2[1]!="") {
                  // $db->autocommist(FALSE);
                  $sql3 = "INSERT INTO periododurante (ordenpago, periodoDel, periodoAl) 
                          VALUES (".$nuevo.", '".date("Y-m-d", strtotime($dt2[0]))."', '".date("Y-m-d", strtotime($dt2[1]))."')";
                  $resultPeriodo = ejecutarQuery($db, $sql3);
                  if ($resultPeriodo) {
                    $error=False;
                  }

                  $dt2 = array();
                  $itDate = 1;
                }
              }else{
                $itDate++;
              }
            }
          }
        }
      }
    }

    if ($error) {
      $db->rollback();
      $Resp = array(
       'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Error en la transacción33</strong>
                      </div>',
       'case'=> 3);
      echo json_encode($Resp);
    }else{
      $db->commit();
      $Norden=$nuevo;
          //$numeroBoleta = $_POST['Nboleta'];
      $sql = "SELECT dg.orden_pago, dg.primer_nombre, dg.segundo_nombre, dg.primer_apellido, dg.segundo_apellido, 
              dg.apellido_casada, dg.tipo_solicitud, dg.numero_folio , dg.anio,  dg.asunto, dg.folio_entrada, dg.negativa, 
              dg.variasPersonas, at.nombre, at.cargo, at.asunto, at.dependencia FROM datosgenerales dg, asunto at WHERE dg.asunto=at.id AND orden_pago=".$Norden;
      $db = obtenerConexion();
      $orden = ejecutarQuery($db, $sql);
      $resp = $orden->fetch_assoc();

      if ($resp) {

        if ($resp['variasPersonas']!=1) {
          $fila='
                <tr id="fila1" name="fila" class="cont">
                  <td class="col-xl-1 col-sm-1 col-md-1" >
                    <span  class="close" id="1" style="font-size:28px;float: left;padding: 0;" >1</span>
                  </td>
                  <td class="col-xl-2 col-sm-2 col-md-2" >
                    <p class="form-control-static text-center" >'.$resp['primer_nombre'].'</p>
                  </td>
                  <td class="col-xl-2 col-sm-2 col-md-2" >
                    <p class="form-control-static text-center" >'.$resp['segundo_nombre'].'</p>
                  </td>
                  <td class="col-xl-2 col-sm-2 col-md-2" >
                    <p class="form-control-static text-center" >'.$resp['primer_apellido'].'</p>
                  </td>
                  <td class="col-xl-2 col-sm-2 col-md-2" >
                    <p class="form-control-static text-center" >'.$resp['segundo_apellido'].'</p>
                  </td>
                  <td class="col-xl-2 col-sm-2 col-md-2" >
                    <p class="form-control-static text-center" >'.$resp['apellido_casada'].'</p>
                  </td>
                </tr>';

            $db = obtenerConexion();
            $sqlPer = "SELECT periodoDel, periodoAl FROM periododurante WHERE ordenpago=".$resp['orden_pago'];
            $resultPeriodo = ejecutarQuery($db, $sqlPer);
            $filab="";
            $datPeriodo="";

            while($rowPeriodo = $resultPeriodo->fetch_assoc()){
              $datPeriodo.= '
                    <div  class="cant" style="padding-bottom: 2.7em;">
                      <div class="col-xl-11 col-sm-11 col-md-11">
                        <div class="input-group ">
                          <input type="text" readonly value="'.date("d-m-Y", strtotime($rowPeriodo['periodoDel'])).'" class="input-group date form-control text-center">
                            <span class="input-group-addon">AL</span>
                          <input type="text" readonly value="'.date("d-m-Y", strtotime($rowPeriodo['periodoAl'])).'" class="input-group date form-control text-center">
                        </div>
                      </div>
                      <div class="col-xl-1 col-sm-1 col-md-1">
                      </div>
                    </div>';
            }
            if ($datPeriodo!="") {
              $filab.='
                  <tr class="op" id="filb1">
                    <td class="op" colspan="7">
                      <div id="Periodo1" class="col-xl-12 col-sm-12 col-md-12 well" >
                        <legend><span class="Colet">Periodo</span></legend>
                        <div class=" col-xl-12 col-sm-12 col-md-12">
                          <div class="col-xl-12 col-sm-12 col-md-12">
                            <label for="Durante" class="Colet" style="margin-left: 23em;">Durante el Periodo</label><br>
                            <label for="Del" class="Colet" style="padding-right: 26.5em; padding-left: 2em;">Del:</label>
                            <label for="Al"  class="Colet">Al:</label>
                          </div>
                          '.$datPeriodo.'
                        </div>
                      </div>
                    </td>
                  </tr>';
              $fila.=$filab;
            }

            $data = array(
                'message' => '
                      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 toppad" >
                        <div class="panel panel-info">
                          <div class="panel-heading">
                            <h3 class="panel-title">Datos Oficial Folio No. <span id="NfolioEntradaReim"><strong>'.$resp['folio_entrada'].'-'.$resp['anio'].'</strong></span></h3>
                          </div>
                          <div class="panel-body">
                            <div class="row">             
                              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                                <div class="form-horizontal">
                                  <div class="form-horizontal form-group col-xl-12 col-sm-12 col-md-12">
                                    <div for="Asunto" class="col-xl-2 col-sm-2 col-md-2 Colet text-center" style="padding-right:0;"><p style="font-weight: bold;">Asunto:</p></div>
                                    <div class="col-xl-10 col-sm-10 col-md-10 Colet" style="padding-left:0;padding-top:0;">
                                        <p class="form-control-static text-left" style="padding-top:0;">'.$resp['nombre'].', '.$resp['cargo'].', '.$resp['dependencia'].', '.$resp['asunto'].'</p>
                                    </div>
                                  </div>

                                  <table id="tabla" class="table table-hover col-xl-12 col-sm-12 col-md-12 Colet">
                                    <thead>
                                      <tr>
                                        <th class="col-xl-1 col-sm-1 col-md-1">
                                          <span style="">#</span>
                                        </th>
                                        <th class="col-xl-3 col-sm-3 col-md-3 text-center">Primer Nombre</th>
                                        <th class="col-xl-2 col-sm-2 col-md-2 text-center">Segundo Nombre</th>
                                        <th class="col-xl-2 col-sm-2 col-md-2 text-center">Primer Apellido</th>
                                        <th class="col-xl-2 col-sm-2 col-md-2 text-center">Segundo Apellido</th>
                                        <th class="col-xl-2 col-sm-2 col-md-2 text-center">Apellido de Casada</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      '.$fila.'
                                    </tbody>
                                    </table>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>      
                      </div>
                          <div class="col-xl-3 col-sm-3 col-md-3 col-md-offset-4 pull-right">
                            <button type="button" id="btn_reimprimir"  class="btn btn-primary btn-lg btn-shadow" onclick="contiOficial();" tabindex=0 >
                              Continuar
                              <span class="glyphicon glyphicon-chevron-right"> </span>
                            </button> 
                          </div>
                      </div>',
                'case' => 3 );
              
            echo json_encode($data);

        }else{
           $data = array(
           'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            Ocurrio un error al almacenar los datos!
                          </div>',
           'case'=> 1);
      
            echo json_encode($data);
          
        }   
        
      }else{
        $data = array(
       'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        Ocurrio un error al almacenar los datos!
                      </div>',
       'case'=> 1);
  
        echo json_encode($data);
      }
    }


  }
}


function buscarOficial()
{
    if(!empty($_POST['FolioB'])){
      $fol =  explode( '-', $_POST['FolioB']);
        $sql = "SELECT dg.orden_pago, dg.folio_entrada, dg.primer_nombre, 
                dg.segundo_nombre, dg.primer_apellido, dg.segundo_apellido, dg.apellido_casada, 
                dg.tipo_solicitud, dg.fecha_impresion, dg.estado, dg.estatus, dg.anio, dg.asunto, 
                dg.variasPersonas, at.nombre, at.cargo, at.asunto, at.dependencia FROM datosgenerales dg, asunto at
                WHERE tipo_solicitud = 0 AND dg.asunto=at.id AND folio_entrada=".$fol[0]." AND anio=".$fol[1];
        $db = obtenerConexion();
        $orden = ejecutarQuery($db, $sql);
        $resp = $orden->fetch_assoc();
        
        if ($resp) {
            if ($resp['id_concepto']==8) {
                if ($resp['estado']==0) {
                    $data = array(
                     'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          El folio No.: <strong>'.$fol[0].'-'.$fol[1].'</strong> esta anulado!',
                     'case'=> 1);
                    echo json_encode($data);
                }else{
                    $data = array(
                     'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          El Folio No.: <strong>'.$fol[0].'-'.$fol[1].'</strong> no pertenece a esta area!.',
                     'case'=> 1);
                    echo json_encode($data);
                }
            }else{
                $status="";
                switch ($resp['estatus']) {
                  case '0':
                    $status="<span class='label label-default'>INGRESADO</span>";
                    break;
                  case '1':
                    $status="<span class='label label-info'>GENERADO</span>";
                    break;
                  case '2':
                    $status="<span class='label label-primary'>FIRMADO</span>";
                    break;
                  case '3':
                    $status="<span class='label label-success'>ENTREGADO</span>";
                    break;
                }

                if ($resp['variasPersonas']==1) {
                    $db = obtenerConexion();
                    $sql = "SELECT id, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, 
                                apellido_casada FROM persona WHERE YO IS NULL AND datogeneral=".$resp['orden_pago'];

                    $resultDat = ejecutarQuery($db, $sql);
                    $cantidad=1;
                    $fila="";
                    while($row = $resultDat->fetch_assoc()){
                      $fila.='
                            <tr id="fila1" name="fila" class="cont">
                              <td class="col-xl-1 col-sm-1 col-md-1" >
                                <span  class="close" id="1" style="font-size:28px;float: left;padding: 0;" >'.$cantidad.'</span>
                              </td>
                              <td class="col-xl-2 col-sm-2 col-md-2" >
                                <p class="form-control-static text-center" >'.$row['primer_nombre'].'</p>
                              </td>
                              <td class="col-xl-2 col-sm-2 col-md-2" >
                                <p class="form-control-static text-center" >'.$row['segundo_nombre'].'</p>
                              </td>
                              <td class="col-xl-2 col-sm-2 col-md-2" >
                                <p class="form-control-static text-center" >'.$row['primer_apellido'].'</p>
                              </td>
                              <td class="col-xl-2 col-sm-2 col-md-2" >
                                <p class="form-control-static text-center" >'.$row['segundo_apellido'].'</p>
                              </td>
                              <td class="col-xl-2 col-sm-2 col-md-2" >
                                <p class="form-control-static text-center" >'.$row['apellido_casada'].'</p>
                              </td>
                            </tr>';
                      $cantidad++;

                      $db = obtenerConexion();
                      $sqlPer = "SELECT periodoDel, periodoAl FROM periododurante WHERE persona=".$row['id']." AND ordenpago=".$resp['orden_pago'];
                      $resultPeriodo = ejecutarQuery($db, $sqlPer);
                      $filab="";
                      $datPeriodo="";

                      while($rowPeriodo = $resultPeriodo->fetch_assoc()){
                        $datPeriodo.= '
                              <div  class="cant" style="padding-bottom: 2.7em;">
                                <div class="col-xl-11 col-sm-11 col-md-11">
                                  <div class="input-group ">
                                    <input type="text" readonly value="'.date("d-m-Y", strtotime($rowPeriodo['periodoDel'])).'" class="input-group date form-control text-center">
                                      <span class="input-group-addon">AL</span>
                                    <input type="text" readonly value="'.date("d-m-Y", strtotime($rowPeriodo['periodoAl'])).'" class="input-group date form-control text-center">
                                  </div>
                                </div>
                                <div class="col-xl-1 col-sm-1 col-md-1">
                                </div>
                              </div>';
                      }

                      if ($datPeriodo!="") {
                        $filab.='
                            <tr class="op" id="filb1">
                              <td class="op" colspan="7">
                                <div id="Periodo1" class="col-xl-12 col-sm-12 col-md-12 well" >
                                  <legend><span class="Colet">Periodo</span></legend>
                                  <div class=" col-xl-12 col-sm-12 col-md-12">
                                    <div class="col-xl-12 col-sm-12 col-md-12">
                                      <label for="Durante" class="Colet" style="margin-left: 23em;">Durante el Periodo</label><br>
                                      <label for="Del" class="Colet" style="padding-right: 26.5em; padding-left: 2em;">Del:</label>
                                      <label for="Al"  class="Colet">Al:</label>
                                    </div>
                                    '.$datPeriodo.'
                                  </div>
                                </div>
                              </td>
                            </tr>';
                        $fila.=$filab;
                      }


                      $db = obtenerConexion();
                      $sql2 = "SELECT id, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, 
                                apellido_casada FROM persona WHERE YO=".$row['id']." AND datogeneral=".$resp['orden_pago'];

                      $resultDat2 = ejecutarQuery($db, $sql2);
                      $filaYO="";
                      $filabYO="";
                      $datPeriodoYO="";
                      while($row2 = $resultDat2->fetch_assoc()){
                        $filaYO.='
                            <tr id="fila1" name="fila" class="cont">
                              <td class="col-xl-1 col-sm-1 col-md-1">
                                <span  class="close" id="1" style="font-size:28px;float: left;padding: 0;" >Y/O</span>
                              </td>
                              <td class="col-xl-2 col-sm-2 col-md-2" >
                                <p class="form-control-static text-center" >'.$row2['primer_nombre'].'</p>
                              </td>
                              <td class="col-xl-2 col-sm-2 col-md-2" >
                                <p class="form-control-static text-center" >'.$row2['segundo_nombre'].'</p>
                              </td>
                              <td class="col-xl-2 col-sm-2 col-md-2" >
                                <p class="form-control-static text-center" >'.$row2['primer_apellido'].'</p>
                              </td>
                              <td class="col-xl-2 col-sm-2 col-md-2" >
                                <p class="form-control-static text-center" >'.$row2['segundo_apellido'].'</p>
                              </td>
                              <td class="col-xl-2 col-sm-2 col-md-2" >
                                <p class="form-control-static text-center" >'.$row2['apellido_casada'].'</p>
                              </td>
                            </tr>';


                          $db = obtenerConexion();
                          $sqlPerYO = "SELECT periodoDel, periodoAl FROM periododurante WHERE persona=".$row2['id']." AND ordenpago=".$resp['orden_pago'];
                          $resultPeriodoYO = ejecutarQuery($db, $sqlPerYO);

                          while($rowPeriodoYO = $resultPeriodoYO->fetch_assoc()){
                            $datPeriodoYO.= '<div  class="cant" style="padding-bottom: 2.7em;">
                                    <div class="col-xl-11 col-sm-11 col-md-11">
                                      <div class="input-group ">
                                        <input type="text" readonly value="'.date("d-m-Y", strtotime($rowPeriodoYO['periodoDel'])).'" class="input-group date form-control text-center">
                                          <span class="input-group-addon">AL</span>
                                        <input type="text" readonly value="'.date("d-m-Y", strtotime($rowPeriodoYO['periodoAl'])).'" class="input-group date form-control text-center">
                                      </div>
                                      </div>
                                      <div class="col-xl-1 col-sm-1 col-md-1">
                                      </div>
                                    </div>';
                          }  
                          if ($datPeriodoYO!="") {
                              $filabYO.='
                                  <tr class="op" id="filb1">
                                    <td class="op" colspan="7">
                                      <div id="Periodo1" class="col-xl-12 col-sm-12 col-md-12 well" >
                                        <legend><span class="Colet">Periodo</span></legend>
                                        <div class=" col-xl-12 col-sm-12 col-md-12">
                                          <div class="col-xl-12 col-sm-12 col-md-12">
                                            <label for="Durante" class="Colet" style="margin-left: 23em;">Durante el Periodo</label><br>
                                            <label for="Del" class="Colet" style="padding-right: 26.5em; padding-left: 2em;">Del:</label>
                                            <label for="Al"  class="Colet">Al:</label>
                                          </div>
                                          '.$datPeriodoYO.'
                                        </div>
                                      </div>
                                    </td>
                                  </tr>';
                              $filaYO.=$filabYO;
                            }
                      }

                      $fila.=$filaYO;
                    }
                    $filas = '
                    <table id="tabla" class="table table-hover col-xl-12 col-sm-12 col-md-12">
                        <thead>
                          <tr>
                            <th class="col-xl-1 col-sm-1 col-md-1 Colet" >Folio No.</th>
                            <th class="col-xl-2 col-sm-2 col-md-2 Colet" >Primer Nombre</th>
                            <th class="col-xl-1 col-sm-1 col-md-1 Colet" >Segundo Nombre</th>
                            <th class="col-xl-2 col-sm-2 col-md-2 Colet" >Primer Apellido</th>
                            <th class="col-xl-1 col-sm-1 col-md-1 Colet" >Segundo Apellido</th>
                            <th class="col-xl-1 col-sm-1 col-md-1 Colet" >Apellido de Casada</th>
                            <th class="col-xl-1 col-sm-1 col-md-1 Colet" >Estado</th>
                            <th class="col-xl-1 col-sm-1 col-md-1 Colet" >Fecha</th>
                            <th class="col-xl-2 col-sm-2 col-md-2 Colet" >Acción</th>
                          </tr>
                        </thead>
                        <tbody >
                        <tr class="cont">
                          <td class="col-xl-1 col-sm-1 col-md-1" >
                            <div class="text-center" id="folio'.$resp['folio_entrada'].'">'.$resp['folio_entrada'].'-'.$resp['anio'].'</div>
                          </td>
                          <td class="col-xl-2 col-sm-2 col-md-2" >
                            <div class="text-center" id="PnombreModOf'.$resp['folio_entrada'].'">'.$resp['primer_nombre'].'</div>
                          </td>
                          <td class="col-xl-1 col-sm-1 col-md-1" >
                            <div class="text-center" id="SnombreModOf'.$resp['folio_entrada'].'">'.$resp['segundo_nombre'].'</div>
                          </td>
                          <td class="col-xl-2 col-sm-2 col-md-2" >
                            <div class="text-center" id="PapellidoModOf'.$resp['folio_entrada'].'">'.$resp['primer_apellido'].'</div>
                          </td>
                          <td class="col-xl-1 col-sm-1 col-md-1" >
                            <div class="text-center" id="SapellidoModOf'.$resp['folio_entrada'].'">'.$resp['segundo_apellido'].'</div>
                          </td>
                          <td class="col-xl-1 col-sm-1 col-md-1" >
                            <div class="text-center" id="CapellidoModOf'.$resp['folio_entrada'].'">'.$resp['apellido_casada'].'</div>
                          </td>
                          <td class="col-xl-1 col-sm-1 col-md-1" >
                            <div class="text-center">'.$status.'</div>
                          </td>
                          <td class="col-xl-1 col-sm-1 col-md-1" >
                            <div class="text-center">'.date('d/m/Y H:i:s',strtotime($resp['fecha_impresion'])).'</div>
                          </td>
                          <td class="col-xl-2 col-sm-2 col-md-2" style="padding-right: 0;padding-left: 0;">
                            <div class="btn-group text-center"  role="group" aria-label="accion" style="padding-left: 10%;">
                              <button type="button" onclick="modificarOficial('.$resp['folio_entrada'].','.$resp['anio'].');" class="btn btn-default " title="Modificar" >
                                <span class="glyphicon glyphicon-pencil"></span>
                              </button>
                              <button type="button" onclick="verOficial('.$resp['folio_entrada'].');" class="btn btn-default " title="Ver Detalles" >
                                <span class="glyphicon glyphicon-zoom-in"></span>
                              </button>
                            </div>
                          </td>
                        </tr>
                        </tbody>
                        <tbody style="display:none;" id="datosOf'.$resp['folio_entrada'].'">
                          <div id="datosAsuntoOf'.$resp['folio_entrada'].'" class="form-horizontal" hidden>
                            <div class="form-horizontal form-group col-xl-12 col-sm-12 col-md-12">
                              <div for="Asunto" class="col-xl-2 col-sm-2 col-md-2 Colet text-center" style="padding-right:0;"><p style="font-weight: bold;">Asunto:</p></div>
                              <div class="col-xl-10 col-sm-10 col-md-10 Colet" style="padding-left:0;padding-top:0;">
                                  <p class="form-control-static text-left" style="padding-top:0;">'.$resp['nombre'].', '.$resp['cargo'].', '.$resp['dependencia'].', '.$resp['asunto'].'</p>
                              </div>
                            </div>
                          </div>
                          '.$fila.'
                        </tbody>
                    </table>';

                    $data = array(
                     'fila'=> $filas,
                     'case'=> 2);
                    echo json_encode($data);

                }else{
                  
                  $fila='<tr id="fila1" name="fila" class="cont">
                          <td class="col-xl-1 col-sm-1 col-md-1" >
                            <span  class="close" id="1" style="font-size:28px;float: left;padding: 0;" >1</span>
                          </td>
                          <td class="col-xl-2 col-sm-2 col-md-2" >
                            <p class="form-control-static text-center" >'.$resp['primer_nombre'].'</p>
                          </td>
                          <td class="col-xl-2 col-sm-2 col-md-2" >
                            <p class="form-control-static text-center" >'.$resp['segundo_nombre'].'</p>
                          </td>
                          <td class="col-xl-2 col-sm-2 col-md-2" >
                            <p class="form-control-static text-center" >'.$resp['primer_apellido'].'</p>
                          </td>
                          <td class="col-xl-2 col-sm-2 col-md-2" >
                            <p class="form-control-static text-center" >'.$resp['segundo_apellido'].'</p>
                          </td>
                          <td class="col-xl-2 col-sm-2 col-md-2" >
                            <p class="form-control-static text-center" >'.$resp['apellido_casada'].'</p>
                          </td>
                        </tr>';


                  $db = obtenerConexion();
                  $sqlPer = "SELECT periodoDel, periodoAl FROM periododurante WHERE ordenpago=".$resp['orden_pago'];
                  $resultPeriodo = ejecutarQuery($db, $sqlPer);
                  $filab="";
                  $datPeriodo="";

                  while($rowPeriodo = $resultPeriodo->fetch_assoc()){
                    $datPeriodo.= '
                          <div  class="cant" style="padding-bottom: 2.7em;">
                            <div class="col-xl-11 col-sm-11 col-md-11">
                              <div class="input-group ">
                                <input type="text" readonly value="'.date("d-m-Y", strtotime($rowPeriodo['periodoDel'])).'" class="input-group date form-control text-center">
                                  <span class="input-group-addon">AL</span>
                                <input type="text" readonly value="'.date("d-m-Y", strtotime($rowPeriodo['periodoAl'])).'" class="input-group date form-control text-center">
                              </div>
                            </div>
                            <div class="col-xl-1 col-sm-1 col-md-1">
                            </div>
                          </div>';
                  }

                  if ($datPeriodo!="") {
                    $filab.='
                        <tr class="op" id="filb1">
                          <td class="op" colspan="7">
                            <div id="Periodo1" class="col-xl-12 col-sm-12 col-md-12 well" >
                              <legend><span class="Colet">Periodo</span></legend>
                              <div class=" col-xl-12 col-sm-12 col-md-12">
                                <div class="col-xl-12 col-sm-12 col-md-12">
                                  <label for="Durante" class="Colet" style="margin-left: 23em;">Durante el Periodo</label><br>
                                  <label for="Del" class="Colet" style="padding-right: 26.5em; padding-left: 2em;">Del:</label>
                                  <label for="Al"  class="Colet">Al:</label>
                                </div>
                                '.$datPeriodo.'
                              </div>
                            </div>
                          </td>
                        </tr>';
                    $fila.=$filab;
                  }

                  $filas = '
                    <table id="tabla" class="table table-hover col-xl-12 col-sm-12 col-md-12">
                        <thead>
                          <tr>
                            <th class="col-xl-1 col-sm-1 col-md-1 Colet" >Folio No.</th>
                            <th class="col-xl-2 col-sm-2 col-md-2 Colet" >Primer Nombre</th>
                            <th class="col-xl-1 col-sm-1 col-md-1 Colet" >Segundo Nombre</th>
                            <th class="col-xl-2 col-sm-2 col-md-2 Colet" >Primer Apellido</th>
                            <th class="col-xl-1 col-sm-1 col-md-1 Colet" >Segundo Apellido</th>
                            <th class="col-xl-1 col-sm-1 col-md-1 Colet" >Apellido de Casada</th>
                            <th class="col-xl-1 col-sm-1 col-md-1 Colet" >Estado</th>
                            <th class="col-xl-1 col-sm-1 col-md-1 Colet" >Fecha</th>
                            <th class="col-xl-2 col-sm-2 col-md-2 Colet" >Acción</th>
                          </tr>
                        </thead>
                        <tbody >
                        <tr class="cont">
                          <td class="col-xl-1 col-sm-1 col-md-1" >
                            <div class="text-center" id="folio'.$resp['folio_entrada'].'">'.$resp['folio_entrada'].'-'.$resp['anio'].'</div>
                          </td>
                          <td class="col-xl-2 col-sm-2 col-md-2" >
                            <div class="text-center" id="PnombreModOf'.$resp['folio_entrada'].'">'.$resp['primer_nombre'].'</div>
                          </td>
                          <td class="col-xl-1 col-sm-1 col-md-1" >
                            <div class="text-center" id="SnombreModOf'.$resp['folio_entrada'].'">'.$resp['segundo_nombre'].'</div>
                          </td>
                          <td class="col-xl-2 col-sm-2 col-md-2" >
                            <div class="text-center" id="PapellidoModOf'.$resp['folio_entrada'].'">'.$resp['primer_apellido'].'</div>
                          </td>
                          <td class="col-xl-1 col-sm-1 col-md-1" >
                            <div class="text-center" id="SapellidoModOf'.$resp['folio_entrada'].'">'.$resp['segundo_apellido'].'</div>
                          </td>
                          <td class="col-xl-1 col-sm-1 col-md-1" >
                            <div class="text-center" id="CapellidoModOf'.$resp['folio_entrada'].'">'.$resp['apellido_casada'].'</div>
                          </td>
                          <td class="col-xl-1 col-sm-1 col-md-1" >
                            <div class="text-center">'.$status.'</div>
                          </td>
                          <td class="col-xl-1 col-sm-1 col-md-1" >
                            <div class="text-center">'.date('d/m/Y H:i:s',strtotime($resp['fecha_impresion'])).'</div>
                          </td>
                          <td class="col-xl-2 col-sm-2 col-md-2" style="padding-right: 0;padding-left: 0;">
                            <div class="btn-group text-center"  role="group" aria-label="accion" style="padding-left: 10%;">
                              <button type="button" onclick="modificarOficial('.$resp['folio_entrada'].','.$resp['anio'].');" class="btn btn-default " title="Modificar" >
                                <span class="glyphicon glyphicon-pencil"></span>
                              </button>
                              <button type="button" onclick="verOficial('.$resp['folio_entrada'].');" class="btn btn-default " title="Ver Detalles" >
                                <span class="glyphicon glyphicon-zoom-in"></span>
                              </button>
                            </div>
                          </td>
                        </tr>
                        </tbody>
                        <tbody style="display:none;" id="datosOf'.$resp['folio_entrada'].'">
                          <div id="datosAsuntoOf'.$resp['folio_entrada'].'" class="form-horizontal" hidden>
                            <div class="form-horizontal form-group col-xl-12 col-sm-12 col-md-12">
                              <div for="Asunto" class="col-xl-2 col-sm-2 col-md-2 Colet text-center" style="padding-right:0;"><p style="font-weight: bold;">Asunto:</p></div>
                              <div class="col-xl-10 col-sm-10 col-md-10 Colet" style="padding-left:0;padding-top:0;">
                                  <p class="form-control-static text-left" style="padding-top:0;">'.$resp['nombre'].', '.$resp['cargo'].', '.$resp['dependencia'].', '.$resp['asunto'].'</p>
                              </div>
                            </div>
                          </div>
                          '.$fila.'
                        </tbody>
                    </table>';

                  $data = array(
                   'fila'=> $filas,
                   'case'=> 2);
                  echo json_encode($data);

                }
            }
        }else{
            $data = array(
             'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  El folio No.: <strong>'.$fol[0].'-'.$fol[1].'</strong> no existe!',
             'case'=> 1);
            echo json_encode($data);
        }

    }else{
        if (!empty($_POST['Pnombre'])||!empty($_POST['FechaOdel'])) {
            // $sql = "SELECT dg.orden_pago, cp.nombre_concepto, dg.primer_nombre, dg.segundo_nombre, dg.primer_apellido, 
            //         dg.segundo_apellido, dg.apellido_casada, dg.fecha_impresion,  dg.variasPersonas, dg.estado, dg.estatus, 
            //         FROM datosgenerales dg WHERE dg.estado<>0 AND dg.id_concepto = cp.id_concepto  AND ";
            $sql = "SELECT dg.orden_pago, dg.folio_entrada, dg.primer_nombre, 
                dg.segundo_nombre, dg.primer_apellido, dg.segundo_apellido, dg.apellido_casada, 
                dg.tipo_solicitud, dg.fecha_impresion, dg.estado, dg.estatus, dg.anio, dg.asunto, 
                dg.variasPersonas, at.nombre, at.cargo, at.asunto, at.dependencia FROM datosgenerales dg, asunto at
                WHERE tipo_solicitud = 0 AND dg.asunto=at.id AND ";

            
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

            if (!empty($_POST['FechaOdel'])&&!empty($_POST['FechaOal'])) {
                $FechaDel = date("Y-m-d",strtotime($_POST['FechaOdel']));
                $FechaAl = strtotime('+1 day' ,strtotime($_POST['FechaOal']));
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
              $filaTodo='<table id="tabla" class="table table-hover col-xl-12 col-sm-12 col-md-12">
                    <thead>
                      <tr>
                        <th class="col-xl-1 col-sm-1 col-md-1 Colet" >Folio No.</th>
                        <th class="col-xl-2 col-sm-2 col-md-2 Colet" >Primer Nombre</th>
                        <th class="col-xl-1 col-sm-1 col-md-1 Colet" >Segundo Nombre</th>
                        <th class="col-xl-2 col-sm-2 col-md-2 Colet" >Primer Apellido</th>
                        <th class="col-xl-1 col-sm-1 col-md-1 Colet" >Segundo Apellido</th>
                        <th class="col-xl-1 col-sm-1 col-md-1 Colet" >Apellido de Casada</th>
                        <th class="col-xl-1 col-sm-1 col-md-1 Colet" >Estado</th>
                        <th class="col-xl-1 col-sm-1 col-md-1 Colet" >Fecha</th>
                        <th class="col-xl-2 col-sm-2 col-md-2 Colet" >Acción</th>
                      </tr>
                    </thead>
                    <tbody>';
                      // </table>
              $filas = "";
              while ($resp = $orden->fetch_assoc()) {
                $status="";
                switch ($resp['estatus']) {
                  case '0':
                    $status="<span class='label label-default'>INGRESADO</span>";
                    break;
                  case '1':
                    $status="<span class='label label-info'>GENERADO</span>";
                    break;
                  case '2':
                    $status="<span class='label label-primary'>FIRMADO</span>";
                    break;
                  case '3':
                    $status="<span class='label label-success'>ENTREGADO</span>";
                    break;
                }
                if ($resp['variasPersonas']==1) {
                    $db = obtenerConexion();
                    $sql = "SELECT id, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, 
                                apellido_casada FROM persona WHERE YO IS NULL AND datogeneral=".$resp['orden_pago'];

                    $resultDat = ejecutarQuery($db, $sql);
                    $cantidad=1;
                    $fila="";
                    if ($resultDat) {                    
                      while($row = $resultDat->fetch_assoc()){
                        $fila.='
                              <tr id="fila1" name="fila" class="cont">
                                <td class="col-xl-1 col-sm-1 col-md-1" >
                                  <span  class="close" id="1" style="font-size:28px;float: left;padding: 0;" >'.$cantidad.'</span>
                                </td>
                                <td class="col-xl-2 col-sm-2 col-md-2" >
                                  <p class="form-control-static text-center" >'.$row['primer_nombre'].'</p>
                                </td>
                                <td class="col-xl-2 col-sm-2 col-md-2" >
                                  <p class="form-control-static text-center" >'.$row['segundo_nombre'].'</p>
                                </td>
                                <td class="col-xl-2 col-sm-2 col-md-2" >
                                  <p class="form-control-static text-center" >'.$row['primer_apellido'].'</p>
                                </td>
                                <td class="col-xl-2 col-sm-2 col-md-2" >
                                  <p class="form-control-static text-center" >'.$row['segundo_apellido'].'</p>
                                </td>
                                <td class="col-xl-2 col-sm-2 col-md-2" >
                                  <p class="form-control-static text-center" >'.$row['apellido_casada'].'</p>
                                </td>
                              </tr>';
                        $cantidad++;

                        $db = obtenerConexion();
                        $sqlPer = "SELECT periodoDel, periodoAl FROM periododurante WHERE persona=".$row['id']." AND ordenpago=".$resp['orden_pago'];
                        $resultPeriodo = ejecutarQuery($db, $sqlPer);
                        $filab="";
                        $datPeriodo="";

                        if ($resultPeriodo) {
                          while($rowPeriodo = $resultPeriodo->fetch_assoc()){
                            $datPeriodo.= '
                                  <div  class="cant" style="padding-bottom: 2.7em;">
                                    <div class="col-xl-11 col-sm-11 col-md-11">
                                      <div class="input-group ">
                                        <input type="text" readonly value="'.date("d-m-Y", strtotime($rowPeriodo['periodoDel'])).'" class="input-group date form-control text-center">
                                          <span class="input-group-addon">AL</span>
                                        <input type="text" readonly value="'.date("d-m-Y", strtotime($rowPeriodo['periodoAl'])).'" class="input-group date form-control text-center">
                                      </div>
                                    </div>
                                    <div class="col-xl-1 col-sm-1 col-md-1">
                                    </div>
                                  </div>';
                          }
                          if ($datPeriodo!="") {
                            $filab.='
                                <tr class="op" id="filb1">
                                  <td class="op" colspan="7">
                                    <div id="Periodo1" class="col-xl-12 col-sm-12 col-md-12 well" >
                                      <legend><span class="Colet">Periodo</span></legend>
                                      <div class=" col-xl-12 col-sm-12 col-md-12">
                                        <div class="col-xl-12 col-sm-12 col-md-12">
                                          <label for="Durante" class="Colet" style="margin-left: 23em;">Durante el Periodo</label><br>
                                          <label for="Del" class="Colet" style="padding-right: 26.5em; padding-left: 2em;">Del:</label>
                                          <label for="Al"  class="Colet">Al:</label>
                                        </div>
                                        '.$datPeriodo.'
                                      </div>
                                    </div>
                                  </td>
                                </tr>';
                            $fila.=$filab;
                          }
                        }


                        $db = obtenerConexion();
                        $sql2 = "SELECT id, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, 
                                  apellido_casada FROM persona WHERE YO=".$row['id']." AND datogeneral=".$resp['orden_pago'];

                        $resultDat2 = ejecutarQuery($db, $sql2);
                        $filaYO="";
                        $filabYO="";
                        $datPeriodoYO="";
                        while($row2 = $resultDat2->fetch_assoc()){
                          $filaYO.='
                              <tr id="fila1" name="fila" class="cont">
                                <td class="col-xl-1 col-sm-1 col-md-1">
                                  <span  class="close" id="1" style="font-size:28px;float: left;padding: 0;" >Y/O</span>
                                </td>
                                <td class="col-xl-2 col-sm-2 col-md-2" >
                                  <p class="form-control-static text-center" >'.$row2['primer_nombre'].'</p>
                                </td>
                                <td class="col-xl-2 col-sm-2 col-md-2" >
                                  <p class="form-control-static text-center" >'.$row2['segundo_nombre'].'</p>
                                </td>
                                <td class="col-xl-2 col-sm-2 col-md-2" >
                                  <p class="form-control-static text-center" >'.$row2['primer_apellido'].'</p>
                                </td>
                                <td class="col-xl-2 col-sm-2 col-md-2" >
                                  <p class="form-control-static text-center" >'.$row2['segundo_apellido'].'</p>
                                </td>
                                <td class="col-xl-2 col-sm-2 col-md-2" >
                                  <p class="form-control-static text-center" >'.$row2['apellido_casada'].'</p>
                                </td>
                              </tr>';


                            $db = obtenerConexion();
                            $sqlPerYO = "SELECT periodoDel, periodoAl FROM periododurante WHERE persona=".$row2['id']." AND ordenpago=".$resp['orden_pago'];
                            $resultPeriodoYO = ejecutarQuery($db, $sqlPerYO);

                            while($rowPeriodoYO = $resultPeriodoYO->fetch_assoc()){
                              $datPeriodoYO.= '<div  class="cant" style="padding-bottom: 2.7em;">
                                      <div class="col-xl-11 col-sm-11 col-md-11">
                                        <div class="input-group ">
                                          <input type="text" readonly value="'.date("d-m-Y", strtotime($rowPeriodoYO['periodoDel'])).'" class="input-group date form-control text-center">
                                            <span class="input-group-addon">AL</span>
                                          <input type="text" readonly value="'.date("d-m-Y", strtotime($rowPeriodoYO['periodoAl'])).'" class="input-group date form-control text-center">
                                        </div>
                                        </div>
                                        <div class="col-xl-1 col-sm-1 col-md-1">
                                        </div>
                                      </div>';
                            }  
                            if ($datPeriodoYO!="") {
                                $filabYO.='
                                    <tr class="op" id="filb1">
                                      <td class="op" colspan="7">
                                        <div id="Periodo1" class="col-xl-12 col-sm-12 col-md-12 well" >
                                          <legend><span class="Colet">Periodo</span></legend>
                                          <div class=" col-xl-12 col-sm-12 col-md-12">
                                            <div class="col-xl-12 col-sm-12 col-md-12">
                                              <label for="Durante" class="Colet" style="margin-left: 23em;">Durante el Periodo</label><br>
                                              <label for="Del" class="Colet" style="padding-right: 26.5em; padding-left: 2em;">Del:</label>
                                              <label for="Al"  class="Colet">Al:</label>
                                            </div>
                                            '.$datPeriodoYO.'
                                          </div>
                                        </div>
                                      </td>
                                    </tr>';
                                $filaYO.=$filabYO;
                              }
                        }

                        $fila.=$filaYO;
                      
                      }
                      $filas .= '
                          <tr class="cont">
                            <td class="col-xl-1 col-sm-1 col-md-1" >
                              <div class="text-center" id="folio'.$resp['folio_entrada'].'">'.$resp['folio_entrada'].'-'.$resp['anio'].'</div>
                            </td>
                            <td class="col-xl-2 col-sm-2 col-md-2" >
                              <div class="text-center" id="PnombreModOf'.$resp['folio_entrada'].'">'.$resp['primer_nombre'].'</div>
                            </td>
                            <td class="col-xl-1 col-sm-1 col-md-1" >
                              <div class="text-center" id="SnombreModOf'.$resp['folio_entrada'].'">'.$resp['segundo_nombre'].'</div>
                            </td>
                            <td class="col-xl-2 col-sm-2 col-md-2" >
                              <div class="text-center" id="PapellidoModOf'.$resp['folio_entrada'].'">'.$resp['primer_apellido'].'</div>
                            </td>
                            <td class="col-xl-1 col-sm-1 col-md-1" >
                              <div class="text-center" id="SapellidoModOf'.$resp['folio_entrada'].'">'.$resp['segundo_apellido'].'</div>
                            </td>
                            <td class="col-xl-1 col-sm-1 col-md-1" >
                              <div class="text-center" id="CapellidoModOf'.$resp['folio_entrada'].'">'.$resp['apellido_casada'].'</div>
                            </td>
                            <td class="col-xl-1 col-sm-1 col-md-1" >
                              <div class="text-center">'.$status.'</div>
                            </td>
                            <td class="col-xl-1 col-sm-1 col-md-1" >
                              <div class="text-center">'.date('d/m/Y H:i:s',strtotime($resp['fecha_impresion'])).'</div>
                            </td>
                            <td class="col-xl-2 col-sm-2 col-md-2" style="padding-right: 0;padding-left: 0;">
                              <div class="btn-group text-center"  role="group" aria-label="accion" style="padding-left: 10%;">
                                <button type="button" onclick="modificarOficial('.$resp['folio_entrada'].','.$resp['anio'].');" class="btn btn-default " title="Modificar" >
                                  <span class="glyphicon glyphicon-pencil"></span>
                                </button>
                                <button type="button" onclick="verOficial('.$resp['folio_entrada'].');" class="btn btn-default " title="Ver Detalles" >
                                  <span class="glyphicon glyphicon-zoom-in"></span>
                                </button>
                              </div>
                            </td>
                          </tr>
                          </tbody>
                          <tbody style="display:none;" id="datosOf'.$resp['folio_entrada'].'">
                            <div id="datosAsuntoOf'.$resp['folio_entrada'].'" class="form-horizontal" hidden>
                              <div class="form-horizontal form-group col-xl-12 col-sm-12 col-md-12">
                                <div for="Asunto" class="col-xl-2 col-sm-2 col-md-2 Colet text-center" style="padding-right:0;"><p style="font-weight: bold;">Asunto:</p></div>
                                <div class="col-xl-10 col-sm-10 col-md-10 Colet" style="padding-left:0;padding-top:0;">
                                    <p class="form-control-static text-left" style="padding-top:0;">'.$resp['nombre'].', '.$resp['cargo'].', '.$resp['dependencia'].', '.$resp['asunto'].'</p>
                                </div>
                              </div>
                            </div>
                            '.$fila.'
                          </tbody>';
                    }
                    // $data = array(
                    //  'fila'=> $filas,
                    //  'case'=> 2);
                    // echo json_encode($data);

                }
                else{
                  
                  $fila='<tr id="fila1" name="fila" class="cont">
                          <td class="col-xl-1 col-sm-1 col-md-1" >
                            <span  class="close" id="1" style="font-size:28px;float: left;padding: 0;" >1</span>
                          </td>
                          <td class="col-xl-2 col-sm-2 col-md-2" >
                            <p class="form-control-static text-center" >'.$resp['primer_nombre'].'</p>
                          </td>
                          <td class="col-xl-2 col-sm-2 col-md-2" >
                            <p class="form-control-static text-center" >'.$resp['segundo_nombre'].'</p>
                          </td>
                          <td class="col-xl-2 col-sm-2 col-md-2" >
                            <p class="form-control-static text-center" >'.$resp['primer_apellido'].'</p>
                          </td>
                          <td class="col-xl-2 col-sm-2 col-md-2" >
                            <p class="form-control-static text-center" >'.$resp['segundo_apellido'].'</p>
                          </td>
                          <td class="col-xl-2 col-sm-2 col-md-2" >
                            <p class="form-control-static text-center" >'.$resp['apellido_casada'].'</p>
                          </td>
                        </tr>';


                  $db = obtenerConexion();
                  $sqlPer = "SELECT periodoDel, periodoAl FROM periododurante WHERE ordenpago=".$resp['orden_pago'];
                  $resultPeriodo = ejecutarQuery($db, $sqlPer);
                  $filab="";
                  $datPeriodo="";

                  while($rowPeriodo = $resultPeriodo->fetch_assoc()){
                    $datPeriodo.= '
                          <div  class="cant" style="padding-bottom: 2.7em;">
                            <div class="col-xl-11 col-sm-11 col-md-11">
                              <div class="input-group ">
                                <input type="text" readonly value="'.date("d-m-Y", strtotime($rowPeriodo['periodoDel'])).'" class="input-group date form-control text-center">
                                  <span class="input-group-addon">AL</span>
                                <input type="text" readonly value="'.date("d-m-Y", strtotime($rowPeriodo['periodoAl'])).'" class="input-group date form-control text-center">
                              </div>
                            </div>
                            <div class="col-xl-1 col-sm-1 col-md-1">
                            </div>
                          </div>';
                  }

                  if ($datPeriodo!="") {
                    $filab.='
                        <tr class="op" id="filb1">
                          <td class="op" colspan="7">
                            <div id="Periodo1" class="col-xl-12 col-sm-12 col-md-12 well" >
                              <legend><span class="Colet">Periodo</span></legend>
                              <div class=" col-xl-12 col-sm-12 col-md-12">
                                <div class="col-xl-12 col-sm-12 col-md-12">
                                  <label for="Durante" class="Colet" style="margin-left: 23em;">Durante el Periodo</label><br>
                                  <label for="Del" class="Colet" style="padding-right: 26.5em; padding-left: 2em;">Del:</label>
                                  <label for="Al"  class="Colet">Al:</label>
                                </div>
                                '.$datPeriodo.'
                              </div>
                            </div>
                          </td>
                        </tr>';
                    $fila.=$filab;
                  }

                  $filas .= '
                        <tbody >
                        <tr class="cont">
                          <td class="col-xl-1 col-sm-1 col-md-1" >
                            <div class="text-center" id="folio'.$resp['folio_entrada'].'">'.$resp['folio_entrada'].'-'.$resp['anio'].'</div>
                          </td>
                          <td class="col-xl-2 col-sm-2 col-md-2" >
                            <div class="text-center" id="PnombreModOf'.$resp['folio_entrada'].'">'.$resp['primer_nombre'].'</div>
                          </td>
                          <td class="col-xl-1 col-sm-1 col-md-1" >
                            <div class="text-center" id="SnombreModOf'.$resp['folio_entrada'].'">'.$resp['segundo_nombre'].'</div>
                          </td>
                          <td class="col-xl-2 col-sm-2 col-md-2" >
                            <div class="text-center" id="PapellidoModOf'.$resp['folio_entrada'].'">'.$resp['primer_apellido'].'</div>
                          </td>
                          <td class="col-xl-1 col-sm-1 col-md-1" >
                            <div class="text-center" id="SapellidoModOf'.$resp['folio_entrada'].'">'.$resp['segundo_apellido'].'</div>
                          </td>
                          <td class="col-xl-1 col-sm-1 col-md-1" >
                            <div class="text-center" id="CapellidoModOf'.$resp['folio_entrada'].'">'.$resp['apellido_casada'].'</div>
                          </td>
                          <td class="col-xl-1 col-sm-1 col-md-1" >
                            <div class="text-center">'.$status.'</div>
                          </td>
                          <td class="col-xl-1 col-sm-1 col-md-1" >
                            <div class="text-center">'.date('d/m/Y H:i:s',strtotime($resp['fecha_impresion'])).'</div>
                          </td>
                          <td class="col-xl-2 col-sm-2 col-md-2" style="padding-right: 0;padding-left: 0;">
                            <div class="btn-group text-center"  role="group" aria-label="accion" style="padding-left: 10%;">
                              <button type="button" onclick="modificarOficial('.$resp['folio_entrada'].','.$resp['anio'].');" class="btn btn-default " title="Modificar" >
                                <span class="glyphicon glyphicon-pencil"></span>
                              </button>
                              <button type="button" onclick="verOficial('.$resp['folio_entrada'].');" class="btn btn-default " title="Ver Detalles" >
                                <span class="glyphicon glyphicon-zoom-in"></span>
                              </button>
                            </div>
                          </td>
                        </tr>
                        </tbody>
                        <tbody style="display:none;" id="datosOf'.$resp['folio_entrada'].'">
                          <div id="datosAsuntoOf'.$resp['folio_entrada'].'" class="form-horizontal" hidden>
                            <div class="form-horizontal form-group col-xl-12 col-sm-12 col-md-12">
                              <div for="Asunto" class="col-xl-2 col-sm-2 col-md-2 Colet text-center" style="padding-right:0;"><p style="font-weight: bold;">Asunto:</p></div>
                              <div class="col-xl-10 col-sm-10 col-md-10 Colet" style="padding-left:0;padding-top:0;">
                                  <p class="form-control-static text-left" style="padding-top:0;">'.$resp['nombre'].', '.$resp['cargo'].', '.$resp['dependencia'].', '.$resp['asunto'].'</p>
                              </div>
                            </div>
                          </div>
                          '.$fila.'
                        </tbody>';

                  // $data = array(
                  //  'fila'=> $filas,
                  //  'case'=> 2);
                  // echo json_encode($data);

                }
              }
                // echo $filas;
                $filaTodo.=$filas."</table>";
                $data = array(
                 'fila'=> $filaTodo,
                 'case'=> 2);
                echo json_encode($data);
                
            }else{
                $data = array(
                 'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      No se encontro datos!',
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


function modOficial()
{
  if(!empty($_POST['FolioB'])&&!empty($_POST['anio'])){
    $folio = $_POST['FolioB'];
    $anio = $_POST['anio'];

    $sql = "SELECT dg.orden_pago, dg.folio_entrada, dg.primer_nombre, 
                dg.segundo_nombre, dg.primer_apellido, dg.segundo_apellido, dg.apellido_casada, 
                dg.tipo_solicitud, dg.fecha_impresion, dg.estado, dg.estatus, dg.anio, dg.asunto as id_as, 
                dg.variasPersonas, at.nombre, at.cargo, at.asunto, at.dependencia FROM datosgenerales dg, asunto at
                WHERE tipo_solicitud = 0 AND dg.asunto=at.id AND folio_entrada=".$folio." AND anio=".$anio;

    $db = obtenerConexion();
    $orden = ejecutarQuery($db, $sql);
    $resp = $orden->fetch_assoc();
        
    if ($resp) {
      $asuntos = obtenerAsunto();
      $datAsunto = "";
      foreach ($asuntos as $asunto) { 
        if ($resp['id_as']==$asunto->id) {
          $datAsunto.='<option selected value="'.$asunto->id.'" title="Cargo:'.$asunto->cargo.'||Asunto:'.$asunto->asunto.'||Dependencia:'.$asunto->dependencia.'">'.$asunto->nombre.'</option>';        
        }else{
          $datAsunto.='<option value="'.$asunto->id.'" title="Cargo:'.$asunto->cargo.'||Asunto:'.$asunto->asunto.'||Dependencia:'.$asunto->dependencia.'">'.$asunto->nombre.'</option>';        
        }
      }

      if ($resp['variasPersonas']==1) {
        $db = obtenerConexion();
        $sql = "SELECT id, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, 
                    apellido_casada FROM persona WHERE YO IS NULL AND datogeneral=".$resp['orden_pago'];
        $resultDat = ejecutarQuery($db, $sql);
        $cantidad=1;
        $fila="";
        while($row = $resultDat->fetch_assoc()){
          $fila.='
                <tr id="filaMod'.$cantidad.'" name="fila" num="'.$cantidad.'" class="cont">
                  <td class="col-xl-1 col-sm-1 col-md-1" >
                    <span  class="close" id="1" style="font-size:28px;padding-left: 50%;padding-right: 50%;" >'.$cantidad.'</span>
                  </td>
                  <td class="col-xl-2 col-sm-2 col-md-2" >
                    <input type="text" value="'.$row['primer_nombre'].'" name="PnombreMod" class="form-control Pnombre" style="text-transform:uppercase;" id="Pnombre" data-toggle="tooltip" data-placement="left" title="Ingresar Primer Nombre" data-campo="Pnombre" placeholder="Primer Nombre"  onkeypress="return validarLetras(event)" required autofocus>
                  </td>
                  <td class="col-xl-2 col-sm-2 col-md-2" >
                    <input type="text" value="'.$row['segundo_nombre'].'" name="SnombreMod" class="form-control" id="Snombre" placeholder="Segundo Nombre" style="text-transform:uppercase;" onkeypress="return validarLetras(event)">
                  </td>
                  <td class="col-xl-2 col-sm-2 col-md-2" >
                    <input type="text" value="'.$row['primer_apellido'].'" name="Papellido" class="form-control Papellido" id="Papellido" data-toggle="tooltip" data-placement="left" title="Ingresar Primer Apellido" placeholder="Primer Apellido" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" required>
                  </td>
                  <td class="col-xl-2 col-sm-2 col-md-2" >
                    <input type="text" value="'.$row['segundo_apellido'].'" name="SapellidoMod" class="form-control" id="Sapellido" placeholder="Segundo Apellido" style="text-transform:uppercase;" onkeypress="return validarLetras(event)">
                  </td>
                  <td class="col-xl-2 col-sm-2 col-md-2" >
                    <input type="text" value="'.$row['apellido_casada'].'" name="CapellidoMod" class="form-control" id="Capellido" placeholder="Apellido de Casada" style="text-transform:uppercase;" onkeypress="return validarLetras(event)">
                  </td>
                  <td class="col-xl-1 col-sm-1 col-md-1" style="padding-left: 0px;padding-right: 0px;">
                    <div style="padding-left: 0;" class="col-xl-4 col-sm-4 col-md-4">
                      <button type="button" class="btn btn-primary btn-xs" onclick="addYOMod('.$cantidad.')" title="Agregar Y/O">
                        <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                      </button>
                    </div>
                    <div style="padding-left: 0;float:left;" class="col-xl-4 col-sm-4 col-md-4">
                      <button type="button" class="btn btn-primary btn-xs" num="'.$cantidad.'" onclick="periodocheckMod(this)" >
                        <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
                      </button>
                    </div>
                    <div style="padding-right: 0px; margin-top: -0.2em;" class="col-xl-4 col-sm-4 col-md-4">
                      <button type="button" class="close" aria-hidden="true" style="font-size:30px;" title="Eliminar" onclick="eliminarFilaMod('.$cantidad.')">&times;</button>
                    </div>
                  </td>
                </tr>';
          $db = obtenerConexion();
          $sqlPer = "SELECT periodoDel, periodoAl FROM periododurante WHERE persona=".$row['id']." AND ordenpago=".$resp['orden_pago'];
          $resultPeriodo = ejecutarQuery($db, $sqlPer);
          $filab="";
          $datPeriodo="";

          while($rowPeriodo = $resultPeriodo->fetch_assoc()){
            $datPeriodo.= '
                  <div id="P" class="cant" style="padding-bottom: 2.7em;">
                    <div class="col-xl-11 col-sm-11 col-md-11">
                      <div class="input-group ">
                        <input type="text" readonly value="'.date("d-m-Y", strtotime($rowPeriodo['periodoDel'])).'" class="input-group date form-control text-center" id="DuranteDel" name="DuranteDel" data-toggle="tooltip" data-placement="right" title="Fecha Del" data-campo="Del">
                          <span class="input-group-addon">AL</span>
                        <input type="text" readonly value="'.date("d-m-Y", strtotime($rowPeriodo['periodoAl'])).'" class="input-group date form-control text-center" id="DuranteAl" name="DuranteAl" data-toggle="tooltip" data-placement="right" title="Fecha Al" data-campo="Del">
                      </div>
                    </div>
                    <div class="col-xl-1 col-sm-1 col-md-1">
                      <button type="button" class="close" aria-hidden="true" style="font-size:30px;" title="Eliminar" onclick="eliminarDurante('.$itPer.',1)">&times;</button>
                    </div>
                  </div>';
          }

          if ($datPeriodo!="") {
            $filab.='
                <tr class="op" id="filbMod'.$cantidad.'">
                  <td class="op" colspan="7">
                    <div id="PeriodoMod'.$cantidad.'" class="col-xl-12 col-sm-12 col-md-12 well">
                      <legend><span class="Colet">Periodo</span></legend>
                      <div class=" col-xl-12 col-sm-12 col-md-12">
                        <div class="col-xl-12 col-sm-12 col-md-12">
                          <label for="Durante" class="Colet" style="margin-left: 23em;">Durante el Periodo</label><br>
                          <label for="Del" class="Colet" style="padding-right: 26.5em; padding-left: 2em;">Del:</label>
                          <label for="Al"  class="Colet">Al:</label>
                          <span class="pull-right">
                            <button type="button" class="btn btn-default" onclick="addDuranteMod('.$cantidad.')" style="margin-top: -2em;">
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Agregar Periodo
                            </button>
                          </span>
                        </div>
                        <div id="inpDurante'.$cantidad.'" num="1" class="form-group col-xl-12 col-sm-12 col-md-12">
                          '.$datPeriodo.'
                        </div>
                      </div>
                    </div>
                  </td>
                </tr>';
            $fila.=$filab;
          }else{
            $filab = '
                  <tr class="op" id="filbMod'.$cantidad.'">
                    <td class="op" colspan="7">
                      <div id="PeriodoMod'.$cantidad.'" class="col-xl-12 col-sm-12 col-md-12 well" hidden>
                        <legend><span class="Colet">Periodo</span></legend>
                        <div class=" col-xl-12 col-sm-12 col-md-12">
                          <div class="col-xl-12 col-sm-12 col-md-12">
                            <label for="Durante" class="Colet" style="margin-left: 23em;">Durante el Periodo</label><br>
                            <label for="Del" class="Colet" style="padding-right: 26.5em; padding-left: 2em;">Del:</label>
                            <label for="Al"  class="Colet">Al:</label>
                            <span class="pull-right">
                              <button type="button" class="btn btn-default" onclick="addDuranteMod('.$cantidad.')" style="margin-top: -2em;">
                                  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Agregar Periodo
                              </button>
                            </span>
                          </div>
                          <div id="inpDuranteMod'.$cantidad.'" num="1" class="form-group col-xl-12 col-sm-12 col-md-12">
                            <div id="P1" class="cant" style="padding-bottom: 2.7em;">
                              <div class="col-xl-11 col-sm-11 col-md-11">
                                <div class="input-group ">
                                  <input type="text" readonly class="input-group date form-control text-center" id="DuranteDel" data-toggle="tooltip" data-placement="right" title="Fecha Del" data-campo="Del" placeholder="" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" required>
                                    <span class="input-group-addon">AL</span>
                                  <input type="text" readonly class="input-group date form-control text-center" id="DuranteAl" data-toggle="tooltip" data-placement="right" title="Fecha Al" data-campo="Del" placeholder="" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" required>
                                </div>
                              </div>
                              <div class="col-xl-1 col-sm-1 col-md-1">
                                <button type="button" class="close" aria-hidden="true" style="font-size:30px;" title="Eliminar" onclick="eliminarDurante(1,1)">&times;</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </td>
                  </tr>';
            $fila.=$filab;
          }
          

          $db = obtenerConexion();
          $sql2 = "SELECT id, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, 
                    apellido_casada FROM persona WHERE YO=".$row['id']." AND datogeneral=".$resp['orden_pago'];

          $resultDat2 = ejecutarQuery($db, $sql2);
          $filaYO="";
          $filabYO="";
          $datPeriodoYO="";
          $n=1;
          while($row2 = $resultDat2->fetch_assoc()){
            $filaYO = '<tr id="filaYOMod'.$n.'" num="'.$n.'" class="YO filaYOMod'.$cantidad.'">
              <td class="col-xl-1 col-sm-1 col-md-1">
                <span  class="close" id="YO" style="font-size:28px;padding-left: 50%;padding-right: 30%;" >Y/O</span>
              </td>
              <td class="col-xl-2 col-sm-2 col-md-2">
                <input type="text" name="Pnombre" value="'.$row2['primer_nombre'].'" class="form-control Pnombre datoYO'.$cantidad.'" style="text-transform:uppercase;" id="PnombreMod'.$n.'" data-toggle="tooltip" data-placement="left" title="Ingresar Primer Nombre" data-campo="Pnombre" placeholder="Primer Nombre"  onkeypress="return validarLetras(event)" required autofocus>
              </td>
              <td class="col-xl-2 col-sm-2 col-md-2">
                <input type="text" name="Snombre" value="'.$row2['segundo_nombre'].'" class="form-control datoYO'.$cantidad.'" id="SnombreMod'.$n.'" placeholder="Segundo Nombre" style="text-transform:uppercase;" onkeypress="return validarLetras(event)">
              </td>
              <td class="col-xl-2 col-sm-2 col-md-2 ">
                <input type="text" name="Papellido" value="'.$row2['primer_apellido'].'" class="form-control Papellido datoYO'.$cantidad.'" id="PapellidoMod'.$n.'" data-toggle="tooltip" data-placement="left" title="Ingresar Primer Apellido" placeholder="Primer Apellido" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" required>
              </td>
              <td class="col-xl-2 col-sm-2 col-md-2 ">
                <input type="text" name="Sapellido" value="'.$row2['segundo_apellido'].'" class="form-control datoYO'.$cantidad.'" id="SapellidoMod'.$n.'" placeholder="Segundo Apellido" style="text-transform:uppercase;" onkeypress="return validarLetras(event)">
              </td>
              <td class="col-xl-2 col-sm-2 col-md-2 ">
                <input type="text" name="Capellido" value="'.$row2['apellido_casada'].'" class="form-control datoYO'.$cantidad.'" id="CapellidoMod'.$n.'" placeholder="Apellido de Casada" style="text-transform:uppercase;" onkeypress="return validarLetras(event)">
              </td>
              <td class="col-xl-1 col-sm-1 col-md-1" style="padding-left: 0px;padding-right: 0px;">
                <div style="padding-left: 35%;">
                  <button type="button" class="btn btn-primary btn-xs" num="'.$n.'" onclick="periodocheckYO('.$cantidad.','.$n.')">
                    <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
                  </button>
                </div>
                <div style="padding-left: 25%; padding-right: 0px; margin-top: -2em;">
                  <button type="button" class="close" aria-hidden="true" style="font-size:30px;" title="Eliminar" onclick="eliminarYOMod('.$cantidad.','.$n.')">&times;</button>
                </div>
              </td>
            </tr>';
              
              $db = obtenerConexion();
              $sqlPerYO = "SELECT periodoDel, periodoAl FROM periododurante WHERE persona=".$row2['id']." AND ordenpago=".$resp['orden_pago'];
              $resultPeriodoYO = ejecutarQuery($db, $sqlPerYO);
              $fl=1;
              while($rowPeriodoYO = $resultPeriodoYO->fetch_assoc()){
                $datPeriodoYO.= '
                        <div id="P'.$cantidad.'" class="INDMod'.$fl.' canti" style="padding-bottom: 2.7em;">
                          <div class="col-xl-11 col-sm-11 col-md-11">
                            <div class="input-group ">
                              <input type="text" readonly value="'.date("d-m-Y", strtotime($rowPeriodoYO['periodoDel'])).'" class="input-group date form-control text-center" id="DuranteDel" name="DuranteDel" data-toggle="tooltip" data-placement="right" title="Fecha Del" data-campo="Del">
                                <span class="input-group-addon">AL</span>
                              <input type="text" readonly value="'.date("d-m-Y", strtotime($rowPeriodoYO['periodoAl'])).'" class="input-group date form-control text-center" id="DuranteAl" name="DuranteAl" data-toggle="tooltip" data-placement="right" title="Fecha Al" data-campo="Del">
                            </div>
                          </div>
                          <div class="col-xl-1 col-sm-1 col-md-1">
                            <button type="button" class="close" aria-hidden="true" style="font-size:30px;" title="Eliminar" onclick="eliminarDuranteYOMod(this)">&times;</button>
                          </div>
                        </div>';
                $fl++;
              }  
              if ($datPeriodoYO!="") {
                  $filabYO.='
                      <tr id="filbYOMod'.$n.'" class="filbYOMod'.$cantidad.' YO">
                        <td class="op" colspan="7">
                          <div id="PeriodoYO'.$n.'" class="fYO'.$cantidad.' col-xl-12 col-sm-12 col-md-12 well">
                            <legend><span class="Colet">Periodo</span></legend>
                            <div class=" col-xl-12 col-sm-12 col-md-12">
                              <div class="col-xl-12 col-sm-12 col-md-12">
                                <label for="Durante" class="Colet" style="margin-left: 23em;">Durante el Periodo</label><br>
                                <label for="Del" class="Colet" style="padding-right: 26.5em; padding-left: 2em;">Del:</label>
                                <label for="Al"  class="Colet">Al:</label>
                                <span class="pull-right">
                                  <button type="button" class="btn btn-default" onclick="addDurante(1)" style="margin-top: -2em;">
                                      <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Agregar Periodo
                                  </button>
                                </span>
                              </div>
                              <div id="inpDurante1" num="1" class="form-group col-xl-12 col-sm-12 col-md-12">
                                '.$datPeriodoYO.'
                              </div>
                            </div>
                          </div>
                        </td>
                      </tr>';
                  $filaYO.=$filabYO;
              }else{
                $filabYO.='
                    <tr id="filbYOMod'.$n.'" class="filbYOMod'.$cantidad.' YO">
                      <td class="op" colspan="7">
                        <div id="PeriodoYO'.$n.'" class="fYO'.$cantidad.' col-xl-12 col-sm-12 col-md-12 well" hidden>
                          <legend><span class="Colet">Periodo</span></legend>
                          <div class=" col-xl-12 col-sm-12 col-md-12">
                            <div class="col-xl-12 col-sm-12 col-md-12">
                              <label for="Durante" class="Colet" style="margin-left: 23em;">Durante el Periodo</label><br>
                              <label for="Del" class="Colet" style="padding-right: 26.5em; padding-left: 2em;">Del:</label>
                              <label for="Al"  class="Colet">Al:</label>
                              <span class="pull-right">
                                <button type="button" class="btn btn-default" onclick="addDurante(1)" style="margin-top: -2em;">
                                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Agregar Periodo
                                </button>
                              </span>
                            </div>
                            <div id="inpDurante1" num="1" class="form-group col-xl-12 col-sm-12 col-md-12">
                              <div id="P1" class="cant" style="padding-bottom: 2.7em;">
                                <div class="col-xl-11 col-sm-11 col-md-11">
                                  <div class="input-group ">
                                    <input type="text" readonly class="input-group date form-control text-center" id="DuranteDel" data-toggle="tooltip" data-placement="right" title="Fecha Del" data-campo="Del" placeholder="" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" required>
                                      <span class="input-group-addon">AL</span>
                                    <input type="text" readonly class="input-group date form-control text-center" id="DuranteAl" data-toggle="tooltip" data-placement="right" title="Fecha Al" data-campo="Del" placeholder="" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" required>
                                  </div>
                                </div>
                                <div class="col-xl-1 col-sm-1 col-md-1">
                                  <button type="button" class="close" aria-hidden="true" style="font-size:30px;" title="Eliminar" onclick="eliminarDuranteYOMod(this)">&times;</button>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </td>
                    </tr>';
                $filaYO.=$filabYO;

              }
            $n++;
          }
          $cantidad++;
          $fila.=$filaYO;
        }

        $form = '
              <div class="col-xl-12 col-sm-12 col-md-12 well" style="padding-right: 1em; padding-left: 1em;">
                <div class="form-group col-xl-12 col-sm-12 col-md-12">
                  <legend class="Colet">Folio No.<span id="folOficialMod">'.$folio.'-'.$anio.'</span></legend>
                  <label for="Asunto" class="Colet">Asunto: <span class="sm">(Campo Obligatorio)</span></label>
                  <div class="input-group">
                    <select id="cboAsuntoMod"  num="" class="form-control" data-toggle="tooltip" data-placement="top" title="Seleccione Asunto" data-campo="Asunto" >
                      '.$datAsunto.'
                    </select>
                    <a style="cursor:pointer" id="addAsunto" class="input-group-addon" onclick="agregarAsunto();" title="Agregar Asunto">
                      <span >
                        <i class="glyphicon glyphicon-plus"></i>
                      </span>
                    </a>
                  </div>
                </div>
                <div class="col-xl-12 col-sm-12 col-md-12" style="height:auto;overflow:scroll;max-height:600px;">
                  <table id="tablaMod" class="table table-hover col-xl-12 col-sm-12 col-md-12 Colet">
                    <thead>
                      <tr>
                        <th class="col-xl-1 col-sm-1 col-md-1">#</th>
                        <th class="col-xl-2 col-sm-2 col-md-2">Primer Nombre*</th>
                        <th class="col-xl-2 col-sm-2 col-md-2" >Segundo Nombre</th>
                        <th class="col-xl-2 col-sm-2 col-md-2">Primer Apellido*</th>
                        <th class="col-xl-2 col-sm-2 col-md-2" >Segundo Apellido</th>
                        <th class="col-xl-2 col-sm-2 col-md-2" >Apellido de Casada</th>
                        <th class="col-xl-1 col-sm-1 col-md-1" style="padding-left: 0px;padding-right: 0px;">
                          <span style="margin-left: -0.8em;">Y/O Periodo</span>
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      '.$fila.'
                    </tbody>
                  </table>
                </div>
                <span class="pull-left sm">( * Campos Obligatorios)</span>
                <div class="dropup" style="float:left;position:relative;left:29%;">
                  <a class="btn btn-default dropdown-toggle" onclick="minim()" style="padding: 0px 5em; font-size: 11px;">
                    <span class="caret"></span>
                  </a>
                </div>
                <span class="pull-right">
                  <button type="button" class="btn btn-default" onclick="addFilaMod()">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Agregar
                  </button>
                </span>
                <div class="col-xl-12 col-sm-12 col-md-12">
                  <div class="col-xl-3 col-sm-3 col-md-3" style="top:5em;">
                    <span class="pull-left">
                      <button type="button" id="btn_atras"  class="btn btn-default btn-lg btn-shadow" onclick="atrasModOfical()" tabindex=1 >
                        <span class="glyphicon glyphicon-chevron-left"> </span>
                        Atras
                      </button>
                    </span>
                  </div>
                  <div id="btn_guardarP" class="col-xl-6 col-sm-6 col-md-6 col-md-offset-5" style="top:1em;">
                    <button style="padding:0.5em 1.5em;" type="button" id="btn_oficial" onclick="modDatoOficial();" class="btn btn-primary btn-lg btn-shadow" >
                      <span class="glyphicon glyphicon-pencil"></span><br>
                      Modificar
                    </button> 
                  </div>
                </div>
              </div>';

        $data = array(
         'fila'=> $form,
         'case'=> 2);
        echo json_encode($data);

      }else{
                      
        $db = obtenerConexion();
        $sqlPer = "SELECT periodoDel, periodoAl FROM periododurante WHERE ordenpago=".$resp['orden_pago'];
        $resultPeriodo = ejecutarQuery($db, $sqlPer);
        $filab="";
        $datPeriodo="";
        $itPer=1;
        while($rowPeriodo = $resultPeriodo->fetch_assoc()){
          $datPeriodo.= '
                    <div id="P'.$itPer.'" class="cant" style="padding-bottom: 2.7em;">
                      <div class="col-xl-11 col-sm-11 col-md-11">
                        <div class="input-group ">
                          <input type="text" readonly value="'.date("d-m-Y", strtotime($rowPeriodo['periodoDel'])).'" class="input-group date form-control text-center" id="DuranteDel" data-toggle="tooltip" data-placement="right" title="Fecha Del" data-campo="Del" placeholder="" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" required>
                            <span class="input-group-addon">AL</span>
                          <input type="text" readonly value="'.date("d-m-Y", strtotime($rowPeriodo['periodoAl'])).'" class="input-group date form-control text-center" id="DuranteAl" data-toggle="tooltip" data-placement="right" title="Fecha Al" data-campo="Del" placeholder="" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" required>
                        </div>
                      </div>
                      <div class="col-xl-1 col-sm-1 col-md-1">
                        <button type="button" class="close" aria-hidden="true" style="font-size:30px;" title="Eliminar" onclick="eliminarDurante('.$itPer.',1)">&times;</button>
                      </div>
                    </div>';
          $itPer++;
        }

        if ($datPeriodo!="") {
          $fila = '
                <tr id="filaMod1" name="fila" num="1" class="cont">
                  <td class="col-xl-1 col-sm-1 col-md-1" >
                    <span  class="close" id="1" style="font-size:28px;padding-left: 50%;padding-right: 50%;" >1</span>
                  </td>
                  <td class="col-xl-2 col-sm-2 col-md-2" >
                    <input type="text" value="'.$resp['primer_nombre'].'" name="PnombreMod" class="form-control Pnombre" style="text-transform:uppercase;" id="Pnombre" data-toggle="tooltip" data-placement="left" title="Ingresar Primer Nombre" data-campo="Pnombre" placeholder="Primer Nombre"  onkeypress="return validarLetras(event)" required autofocus>
                  </td>
                  <td class="col-xl-2 col-sm-2 col-md-2" >
                    <input type="text" value="'.$resp['segundo_nombre'].'" name="SnombreMod" class="form-control" id="Snombre" placeholder="Segundo Nombre" style="text-transform:uppercase;" onkeypress="return validarLetras(event)">
                  </td>
                  <td class="col-xl-2 col-sm-2 col-md-2" >
                    <input type="text" value="'.$resp['primer_apellido'].'" name="Papellido" class="form-control Papellido" id="Papellido" data-toggle="tooltip" data-placement="left" title="Ingresar Primer Apellido" placeholder="Primer Apellido" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" required>
                  </td>
                  <td class="col-xl-2 col-sm-2 col-md-2" >
                    <input type="text" value="'.$resp['segundo_apellido'].'" name="SapellidoMod" class="form-control" id="Sapellido" placeholder="Segundo Apellido" style="text-transform:uppercase;" onkeypress="return validarLetras(event)">
                  </td>
                  <td class="col-xl-2 col-sm-2 col-md-2" >
                    <input type="text" value="'.$resp['apellido_casada'].'" name="CapellidoMod" class="form-control" id="Capellido" placeholder="Apellido de Casada" style="text-transform:uppercase;" onkeypress="return validarLetras(event)">
                  </td>
                  <td class="col-xl-1 col-sm-1 col-md-1" style="padding-left: 0px;padding-right: 0px;">
                    <div style="padding-left: 0;" class="col-xl-4 col-sm-4 col-md-4">
                      <button type="button" class="btn btn-primary btn-xs" onclick="addYOMod(1)" title="Agregar Y/O">
                        <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                      </button>
                    </div>
                    <div style="padding-left: 0;float:left;" class="col-xl-4 col-sm-4 col-md-4">
                      <button type="button" class="btn btn-primary btn-xs" num="1" onclick="periodocheckMod(this)" >
                        <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
                      </button>
                    </div>
                    <div style="padding-right: 0px; margin-top: -0.2em;" class="col-xl-4 col-sm-4 col-md-4">
                      <button type="button" class="close" aria-hidden="true" style="font-size:30px;" title="Eliminar" onclick="eliminarFilaMod(1)">&times;</button>
                    </div>
                  </td>
                </tr>
                <tr class="op" id="filbMod1">
                  <td class="op" colspan="7">
                    <div id="PeriodoMod1" class="col-xl-12 col-sm-12 col-md-12 well">
                      <legend><span class="Colet">Periodo</span></legend>
                      <div class=" col-xl-12 col-sm-12 col-md-12">
                        <div class="col-xl-12 col-sm-12 col-md-12">
                          <label for="Durante" class="Colet" style="margin-left: 23em;">Durante el Periodo</label><br>
                          <label for="Del" class="Colet" style="padding-right: 26.5em; padding-left: 2em;">Del:</label>
                          <label for="Al"  class="Colet">Al:</label>
                          <span class="pull-right">
                            <button type="button" class="btn btn-default" onclick="addDuranteMod(1)" style="margin-top: -2em;">
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Agregar Periodo
                            </button>
                          </span>
                        </div>
                        <div id="inpDuranteMod1" num="1" class="form-group col-xl-12 col-sm-12 col-md-12">
                          '.$datPeriodo.'
                        </div>
                      </div>
                    </div>
                  </td>
                </tr>';
        }else{
          $fila = '
                <tr id="filaMod1" name="fila" num="1" class="cont">
                  <td class="col-xl-1 col-sm-1 col-md-1" >
                    <span  class="close" id="1" style="font-size:28px;padding-left: 50%;padding-right: 50%;" >1</span>
                  </td>
                  <td class="col-xl-2 col-sm-2 col-md-2" >
                    <input type="text" value="'.$resp['primer_nombre'].'" name="PnombreMod" class="form-control Pnombre" style="text-transform:uppercase;" id="Pnombre" data-toggle="tooltip" data-placement="left" title="Ingresar Primer Nombre" data-campo="Pnombre" placeholder="Primer Nombre"  onkeypress="return validarLetras(event)" required autofocus>
                  </td>
                  <td class="col-xl-2 col-sm-2 col-md-2" >
                    <input type="text" value="'.$resp['segundo_nombre'].'" name="SnombreMod" class="form-control" id="Snombre" placeholder="Segundo Nombre" style="text-transform:uppercase;" onkeypress="return validarLetras(event)">
                  </td>
                  <td class="col-xl-2 col-sm-2 col-md-2" >
                    <input type="text" value="'.$resp['primer_apellido'].'" name="Papellido" class="form-control Papellido" id="Papellido" data-toggle="tooltip" data-placement="left" title="Ingresar Primer Apellido" placeholder="Primer Apellido" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" required>
                  </td>
                  <td class="col-xl-2 col-sm-2 col-md-2" >
                    <input type="text" value="'.$resp['segundo_apellido'].'" name="SapellidoMod" class="form-control" id="Sapellido" placeholder="Segundo Apellido" style="text-transform:uppercase;" onkeypress="return validarLetras(event)">
                  </td>
                  <td class="col-xl-2 col-sm-2 col-md-2" >
                    <input type="text" value="'.$resp['apellido_casada'].'" name="CapellidoMod" class="form-control" id="Capellido" placeholder="Apellido de Casada" style="text-transform:uppercase;" onkeypress="return validarLetras(event)">
                  </td>
                  <td class="col-xl-1 col-sm-1 col-md-1" style="padding-left: 0px;padding-right: 0px;">
                    <div style="padding-left: 0;" class="col-xl-4 col-sm-4 col-md-4">
                      <button type="button" class="btn btn-primary btn-xs" onclick="addYOMod(1)" title="Agregar Y/O">
                        <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                      </button>
                    </div>
                    <div style="padding-left: 0;float:left;" class="col-xl-4 col-sm-4 col-md-4">
                      <button type="button" class="btn btn-primary btn-xs" num="1" onclick="periodocheckMod(this)" >
                        <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
                      </button>
                    </div>
                    <div style="padding-right: 0px; margin-top: -0.2em;" class="col-xl-4 col-sm-4 col-md-4">
                      <button type="button" class="close" aria-hidden="true" style="font-size:30px;" title="Eliminar" onclick="eliminarFilaMod(1)">&times;</button>
                    </div>
                  </td>
                </tr>
                <tr class="op" id="filbMod1">
                  <td class="op" colspan="7">
                    <div id="PeriodoMod1" class="col-xl-12 col-sm-12 col-md-12 well" hidden>
                      <legend><span class="Colet">Periodo</span></legend>
                      <div class=" col-xl-12 col-sm-12 col-md-12">
                        <div class="col-xl-12 col-sm-12 col-md-12">
                          <label for="Durante" class="Colet" style="margin-left: 23em;">Durante el Periodo</label><br>
                          <label for="Del" class="Colet" style="padding-right: 26.5em; padding-left: 2em;">Del:</label>
                          <label for="Al"  class="Colet">Al:</label>
                          <span class="pull-right">
                            <button type="button" class="btn btn-default" onclick="addDuranteMod(1)" style="margin-top: -2em;">
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Agregar Periodo
                            </button>
                          </span>
                        </div>
                        <div id="inpDuranteMod1" num="1" class="form-group col-xl-12 col-sm-12 col-md-12">
                          <div id="P1" class="cant" style="padding-bottom: 2.7em;">
                            <div class="col-xl-11 col-sm-11 col-md-11">
                              <div class="input-group ">
                                <input type="text" readonly class="input-group date form-control text-center" id="DuranteDel" data-toggle="tooltip" data-placement="right" title="Fecha Del" data-campo="Del" placeholder="" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" required>
                                  <span class="input-group-addon">AL</span>
                                <input type="text" readonly class="input-group date form-control text-center" id="DuranteAl" data-toggle="tooltip" data-placement="right" title="Fecha Al" data-campo="Del" placeholder="" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" required>
                              </div>
                            </div>
                            <div class="col-xl-1 col-sm-1 col-md-1">
                              <button type="button" class="close" aria-hidden="true" style="font-size:30px;" title="Eliminar" onclick="eliminarDurante(1,1)">&times;</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </td>
                </tr>';
        }
        

        $form = '
              <div class="col-xl-12 col-sm-12 col-md-12 well" style="padding-right: 1em; padding-left: 1em;">
                <div class="form-group col-xl-12 col-sm-12 col-md-12">
                  <legend class="Colet">Folio No.<span id="folOficialMod">'.$folio.'-'.$anio.'</span></legend>
                  <label for="Asunto" class="Colet">Asunto: <span class="sm">(Campo Obligatorio)</span></label>
                  <div class="input-group">
                    <select id="cboAsuntoMod"  num="" class="form-control" data-toggle="tooltip" data-placement="top" title="Seleccione Asunto" data-campo="Asunto" >
                      '.$datAsunto.'
                    </select>
                    <a style="cursor:pointer" id="addAsunto" class="input-group-addon" onclick="agregarAsunto();" title="Agregar Asunto">
                      <span >
                        <i class="glyphicon glyphicon-plus"></i>
                      </span>
                    </a>
                  </div>
                </div>
                <div class="col-xl-12 col-sm-12 col-md-12" style="height:auto;overflow:scroll;max-height:600px;">
                  <table id="tablaMod" class="table table-hover col-xl-12 col-sm-12 col-md-12 Colet">
                    <thead>
                      <tr>
                        <th class="col-xl-1 col-sm-1 col-md-1">#</th>
                        <th class="col-xl-2 col-sm-2 col-md-2">Primer Nombre*</th>
                        <th class="col-xl-2 col-sm-2 col-md-2" >Segundo Nombre</th>
                        <th class="col-xl-2 col-sm-2 col-md-2">Primer Apellido*</th>
                        <th class="col-xl-2 col-sm-2 col-md-2" >Segundo Apellido</th>
                        <th class="col-xl-2 col-sm-2 col-md-2" >Apellido de Casada</th>
                        <th class="col-xl-1 col-sm-1 col-md-1" style="padding-left: 0px;padding-right: 0px;">
                          <span style="margin-left: -0.8em;">Y/O Periodo</span>
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      '.$fila.'
                    </tbody>
                  </table>
                </div>
                <span class="pull-left sm">( * Campos Obligatorios)</span>
                <div class="dropup" style="float:left;position:relative;left:29%;">
                  <a class="btn btn-default dropdown-toggle" onclick="minim()" style="padding: 0px 5em; font-size: 11px;">
                    <span class="caret"></span>
                  </a>
                </div>
                <span class="pull-right">
                  <button type="button" class="btn btn-default" onclick="addFilaMod()">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Agregar
                  </button>
                </span>
                <div class="col-xl-12 col-sm-12 col-md-12">
                  <div class="col-xl-3 col-sm-3 col-md-3 pull-left" style="top:5em;">
                    <span class="pull-left">
                      <button type="button" id="btn_atras"  class="btn btn-default btn-lg btn-shadow" onclick="atrasModOfical()" tabindex=1 >
                        <span class="glyphicon glyphicon-chevron-left"> </span>
                        Atras
                      </button>
                    </span>
                  </div>
                  <div id="btn_guardarP" class="col-xl-6 col-sm-6 col-md-6 col-md-offset-5" style="top:1em;">
                    <button style="padding:0.5em 1.5em;" type="button" id="btnModoficial" onclick="modDatoOficial();" class="btn btn-primary btn-lg btn-shadow" >
                      <span class="glyphicon glyphicon-pencil"></span><br>
                      Modificar
                    </button> 
                  </div>
                </div>
              </div>';

        $data = array(
         'fila'=> $form,
         'case'=> 2);
        echo json_encode($data);

      }
    }else{
        $data = array(
         'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              El folio No.: <strong>'.$folio.'-'.$anio.'</strong> no existe!',
         'case'=> 1);
        echo json_encode($data);
    }


  }else{
    $data = array(
       'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            Error en los datos!',
       'case'=> 1);
      echo json_encode($data);
  }
}


function getFolio()
{
  $anio = date('Y');
  $sql = "SELECT folio_entrada, anio FROM datosgenerales WHERE anio =".$anio." ORDER BY folio_entrada DESC LIMIT 1";
  $db = obtenerConexion();
  $orden = ejecutarQuery($db, $sql);
  if ($orden) {
    $resp = $orden->fetch_assoc();
    if ($resp['anio']==$anio) {
      $folio = $resp['folio_entrada'];
      $folio++;
      return $folio;
    }else{
      return 1;
    }
  }
}























// function comprobarOrden()
// {
    
//     if (!empty($_POST['Norden'])) {
//     	$numeroOrden=$_POST['Norden'];
//     	//$numeroBoleta = $_POST['Nboleta'];
    	
//     	  $sql = "SELECT dg.orden_pago, dg.id_concepto, cp.nombre_concepto, dg.primer_nombre, dg.segundo_nombre, dg.primer_apellido, 
//                 dg.segundo_apellido, dg.apellido_casada, ps.nacionalidad_pais, ps.nombre_pais , dg.nacionalidad, dg.tipo_documento, dg.numero_documento, 
//                 dg.tipo_solicitud, dg.lugar_documento, dg.boleta_banco, dg.valor_concepto, dg.estado 
//                 FROM datosgenerales dg, conceptos cp, paises ps WHERE dg.id_concepto = cp.id_concepto AND dg.nacionalidad= ps.id_pais AND dg.orden_pago=".$numeroOrden;
//         $db = obtenerConexion();
//         $orden = ejecutarQuery($db, $sql);
//         $resp = $orden->fetch_assoc();
        
//         if ($resp['orden_pago']==$numeroOrden) {
//           if ($resp['estado']==0) {
//             $data = array(
//                'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
//                   <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
//                     La orden de pago No.: <strong>'.$resp['orden_pago'].'</strong> se encuentra <strong>Anulada!</strong>',
//                'case'=> 2);
//               // 
//               echo json_encode($data);
//           }else{
//               if ($resp['id_concepto']==9) {
//                 if ($resp['tipo_solicitud']==0) {
//                   $data = array(
//                    'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
//                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
//                         La orden de pago No.: <strong>'.$resp['orden_pago'].'</strong> pertenece a una Certificación <strong>Oficial</strong>.',
//                    'case'=> 2);
                   
//                   echo json_encode($data);

//                 }else{
//                   if ($resp['boleta_banco']!=0||$resp['boleta_banco']!=null) {
//                         $data = array(
//                          'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
//                             <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
//                               La orden de pago No.: <strong>'.$resp['orden_pago'].'</strong> correspondiente a <strong>'.$resp['primer_nombre'].' '.$resp['primer_apellido'].'</strong>, ya tiene registrada la boleta de banco <strong>No.: '.$resp['boleta_banco'].'</strong>',
//                          'case'=> 2);
//                         // 
//                         echo json_encode($data);
                    

//                   }else{

//                       $data = array(
//                           'message' => '
//                                   <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xs-offset-0 col-sm-offset-0 col-md-offset-0 col-lg-offset-0 toppad" >
//                                     <div class="panel panel-info">
//                                       <div class="panel-heading">
//                                         <h3 class="panel-title">Datos de la Orden de Pago No. <span id="nOrden"><strong>'.$resp['orden_pago'].'</strong></span></h3>
//                                       </div>
//                                       <div class="panel-body">
//                                         <div class="row">             
//                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 "> 
//                                             <table class="table table-user-information">
//                                               <tbody>
//                                                 <tr>
//                                                   <td>Primer Nombre:</td>
//                                                   <td style="font-weight: 700;">'.$resp['primer_nombre'].'</td>
//                                                 </tr>
//                                                 <tr>
//                                                   <td style="width:14em;">Segundo Nombre:</td>
//                                                   <td style="font-weight: 700;">'.$resp['segundo_nombre'].'</td>
//                                                 </tr>
//                                                 <tr>
//                                                   <td style="width:14em;">Primer Apellido:</td>
//                                                   <td style="font-weight: 700;">'.$resp['primer_apellido'].'</td>
//                                                 </tr>
//                                                 <tr>
//                                                   <td style="width:14em;">Segundo Apellido:</td>
//                                                   <td style="font-weight: 700;">'.$resp['segundo_apellido'].'</td>
//                                                 </tr>
//                                                 <tr>
//                                                   <td style="width:14em;">Apellido de Casada:</td>
//                                                   <td style="font-weight: 700;">'.$resp['apellido_casada'].'</td>
//                                                 </tr>
//                                                 <tr>
//                                                   <td style="width:14em;">Nacionalidad:</td>
//                                                   <td style="font-weight: 700;">'.strtoupper($resp['nacionalidad_pais']).'</td>
//                                                 </tr>
//                                               </tbody>
//                                             </table>
//                                           </div>

//                                           <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 "> 
//                                             <table class="table table-user-information">
//                                               <tbody>
//                                                 <tr>
//                                                   <td style="width:14em;">Tipo de Documento:</td>
//                                                   <td style="font-weight: 700;">'.$resp['tipo_documento'].'</td>
//                                                 </tr>
//                                                 <tr>
//                                                   <td style="width:14em;">Numero de Documento:</td>
//                                                   <td style="font-weight: 700;">'.$resp['numero_documento'].'</td>
//                                                 </tr>
//                                                 <tr>
//                                                   <td style="width:14em;">Pais extendio Documento:</td>
//                                                   <td style="font-weight: 700;">'.strtoupper($resp['nombre_pais']).'</td>
//                                                 </tr>
//                                                 <tr>
//                                                   <td style="width:14em;">Lugar extendio Documento:</td>
//                                                   <td style="font-weight: 700;">'.$resp['lugar_documento'].'</td>
//                                                 </tr>
//                                                 <tr>
//                                                   <td style="width:14em;">Concepto:</td>
//                                                   <td style="font-weight: 700;">'.$resp['nombre_concepto'].'</td>
//                                                 </tr>
//                                                 <tr hidden>
//                                                   <td id="idConcepto">'.$resp['id_concepto'].'</td>
//                                                 </tr>
//                                                 <tr>
//                                                   <td style="width:14em;">Valor Concepto:</td>
//                                                   <td style="font-weight: 700;">Q.'.$resp['valor_concepto'].'</td>
//                                                 </tr>             
//                                               </tbody>
//                                             </table>
//                                           </div>
//                                         </div>
//                                       </div>
//                                     </div>      
//                                   </div>
//                                     <div class="col-xl-12 col-sm-12 col-md-12 col-md-offset-0"> 
//                                         <h3>
//                                           <span class="label label-default">Datos Generales:</span>
//                                         </h3>
//                                     </div>
//                                     <br><br>
//                                     <div class="col-xl-12 col-sm-12 col-md-12 col-md-offset-0 well">
//                                         <row class="col-xl-12 col-sm-12 col-md-12">
//                                           <div class="form-group col-xl-6 col-sm-6 col-md-6">
//                                             <label for="Nboleta">Boleta del banco No.: <span class="sm">(Campo Obligatorio)</span></label>
//                                             <input type="text" class="form-control" id="Nboleta" data-toggle="tooltip" data-placement="right" title="Ingresar Numero de Boleta del Banco" data-campo="Nboleta" placeholder="Numero de Boleta del Banco" style="text-transform:uppercase;" autofocus required>
//                                           </div>
//                                           <div class="form-group col-xl-6 col-sm-6 col-md-6">
//                                             <label for="InFrontera">Ingreso por la Frontera: <span class="sm">(Campo Obligatorio)</span></label>
//                                             <input type="text" class="form-control" id="InFrontera" data-toggle="tooltip" data-placement="right" title="Ingreso por la Frontera" data-campo="Nboleta" placeholder="Ingreso por la Frontera" style="text-transform:uppercase;" autofocus required>
//                                           </div>
//                                           <div class="form-group col-xl-6 col-sm-6 col-md-6">
//                                             <label for="Fingreso">Fecha: <span class="sm">(Campo Obligatorio)</span></label>
//                                             <div class="input-group date">
//                                               <input type="text" class="form-control" id="Fingreso" data-toggle="tooltip" data-placement="right" title="FECHA EN QUE INGRESO" placeholder="FECHA EN QUE INGRESO" data-campo="Fingreso" required readonly>
//                                               <span class="input-group-addon">
//                                                 <i class="glyphicon glyphicon-calendar"></i>
//                                               </span>
//                                             </div>
//                                           </div>
//                                           <div class="form-group col-xl-6 col-sm-6 col-md-6">
//                                             <label for="Sdias">Dias para salir: <span class="sm">(Campo Obligatorio)</span></label>
//                                             <input type="number" class="form-control" id="Sdias" data-toggle="tooltip" data-placement="right" title="DIAS QUE TIENE PARA SALIR" data-campo="Nboleta" placeholder="DIAS QUE TIENE PARA SALIR" onkeypress="return checkSoloNum(event)" autofocus required>
//                                           </div>
//                                         </row>
//                                     </div>                                       
//                                         <br>              
//                                         <br>
//                                         <div class="col-xl-3 col-sm-3 col-md-3 col-md-offset-0">
//                                         <span class="pull-left">
//                                         <button type="button" id="btn_atras"  class="btn btn-default btn-lg btn-shadow" onclick="atras()" tabindex=1 >
//                                           <span class="glyphicon glyphicon-chevron-left"></span>
//                                           Atras
//                                         </button>
//                                         </span>
//                                         </div>
//                                       <div class="col-xl-3 col-sm-3 col-md-3 col-md-offset-2">
//                                         <button type="button" id="btn_conprobarDatos"  class="btn btn-primary btn-lg btn-shadow " onclick="comprobar_datos()" tabindex=0 >
//                                           <span class="glyphicon glyphicon-floppy-disk"> </span>
//                                           Guardar
//                                         </button> 
//                                       </div>
//                                   </div>
//                                   <script>
//                                       $(".input-group.date").datepicker({
//                                           format: "dd-mm-yyyy",
//                                           language: "es",
//                                           autoclose: true,
//                                           endDate: "1d",
//                                           orientation: "top auto"
//                                       });
//                                   </script>
//                           ',
//                           'case' => 3 );
                      
//                       echo json_encode($data);
//                   }
//                 }
//               }else if ($resp['id_concepto']!=2) {
//                 $sqlcon = "SELECT id_concepto, nombre_concepto FROM conceptos WHERE id_concepto=".$resp['id_concepto'];
//                 $concep = ejecutarQuery($db, $sqlcon);
//                 $Rconcep = $concep->fetch_assoc();
//                 $data = array(
//                    'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
//                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
//                         La orden de pago No.: <strong>'.$resp['orden_pago'].'</strong> pertenece al concepto  <strong>'.$Rconcep['nombre_concepto'].'</strong>',
//                    'case'=> 2);
                   
//                   echo json_encode($data);
//               }else{
//                 if ($resp['tipo_solicitud']==0) {
//                   $data = array(
//                    'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
//                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
//                         La orden de pago No.: <strong>'.$resp['orden_pago'].'</strong> pertenece a una Certificación <strong>Oficial</strong>.',
//                    'case'=> 2);
                   
//                   echo json_encode($data);

//                 }else{
//                   if ($resp['boleta_banco']!=0||$resp['boleta_banco']!=null) {
//                         $data = array(
//                          'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
//                             <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
//                               La orden de pago No.: <strong>'.$resp['orden_pago'].'</strong> correspondiente a <strong>'.$resp['primer_nombre'].' '.$resp['primer_apellido'].'</strong>, ya tiene registrada la boleta de banco <strong>No.: '.$resp['boleta_banco'].'</strong>',
//                          'case'=> 2);
//                         // 
//                         echo json_encode($data);
                    

//                   }else{

//                       $data = array(
//                           'message' => '
//                                   <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xs-offset-0 col-sm-offset-0 col-md-offset-0 col-lg-offset-0 toppad" >
//                                     <div class="panel panel-info">
//                                       <div class="panel-heading">
//                                         <h3 class="panel-title">Datos de la Orden de Pago No. <span id="nOrden"><strong>'.$resp['orden_pago'].'</strong></span></h3>
//                                       </div>
//                                       <div class="panel-body">
//                                         <div class="row">             
//                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 "> 
//                                             <table class="table table-user-information">
//                                               <tbody>
//                                                 <tr>
//                                                   <td>Primer Nombre:</td>
//                                                   <td style="font-weight: 700;">'.$resp['primer_nombre'].'</td>
//                                                 </tr>
//                                                 <tr>
//                                                   <td style="width:14em;">Segundo Nombre:</td>
//                                                   <td style="font-weight: 700;">'.$resp['segundo_nombre'].'</td>
//                                                 </tr>
//                                                 <tr>
//                                                   <td style="width:14em;">Primer Apellido:</td>
//                                                   <td style="font-weight: 700;">'.$resp['primer_apellido'].'</td>
//                                                 </tr>
//                                                 <tr>
//                                                   <td style="width:14em;">Segundo Apellido:</td>
//                                                   <td style="font-weight: 700;">'.$resp['segundo_apellido'].'</td>
//                                                 </tr>
//                                                 <tr>
//                                                   <td style="width:14em;">Apellido de Casada:</td>
//                                                   <td style="font-weight: 700;">'.$resp['apellido_casada'].'</td>
//                                                 </tr>
//                                                 <tr>
//                                                   <td style="width:14em;">Nacionalidad:</td>
//                                                   <td style="font-weight: 700;">'.strtoupper($resp['nacionalidad_pais']).'</td>
//                                                 </tr>
//                                               </tbody>
//                                             </table>
//                                           </div>

//                                           <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 "> 
//                                             <table class="table table-user-information">
//                                               <tbody>
//                                                 <tr>
//                                                   <td style="width:14em;">Tipo de Documento:</td>
//                                                   <td style="font-weight: 700;">'.$resp['tipo_documento'].'</td>
//                                                 </tr>
//                                                 <tr>
//                                                   <td style="width:14em;">Numero de Documento:</td>
//                                                   <td style="font-weight: 700;">'.$resp['numero_documento'].'</td>
//                                                 </tr>
//                                                 <tr>
//                                                   <td style="width:14em;">Pais extendio Documento:</td>
//                                                   <td style="font-weight: 700;">'.strtoupper($resp['nombre_pais']).'</td>
//                                                 </tr>
//                                                 <tr>
//                                                   <td style="width:14em;">Lugar extendio Documento:</td>
//                                                   <td style="font-weight: 700;">'.$resp['lugar_documento'].'</td>
//                                                 </tr>
//                                                 <tr>
//                                                   <td style="width:14em;">Concepto:</td>
//                                                   <td style="font-weight: 700;">'.$resp['nombre_concepto'].'</td>
//                                                 </tr>
//                                                 <tr>
//                                                   <td style="width:14em;">Valor Concepto:</td>
//                                                   <td style="font-weight: 700;">Q.'.$resp['valor_concepto'].'</td>
//                                                 </tr>             
//                                               </tbody>
//                                             </table>
//                                           </div>
//                                         </div>
//                                       </div>
//                                     </div>      
//                                   </div>
//                                     <div class="col-xl-12 col-sm-12 col-md-12 col-md-offset-0"> 
//                                         <h3>
//                                           <span class="label label-default">Datos Generales:</span>
//                                         </h3>
//                                     </div>
//                                     <br><br>
//                                     <div class="col-xl-12 col-sm-12 col-md-12 col-md-offset-0 well">
//                                         <row class="col-xl-12 col-sm-12 col-md-12">
//                                           <div class="form-group col-xl-6 col-sm-6 col-md-6 col-md-offset-">
//                                             <label for="Nboleta">Boleta del banco No.: <span class="sm">(Campo Obligatorio)</span></label>
//                                             <input type="text" class="form-control" id="Nboleta" data-toggle="tooltip" data-placement="right" title="Ingresar Numero de Boleta del Banco" data-campo="Nboleta" placeholder="Numero de Boleta del Banco" style="text-transform:uppercase;" autofocus required>
//                                           </div>
//                                         </row>


//                                           <div class="form-group col-xl-6 col-sm-6 col-md-6" style="border-right: 1px solid rgb(173, 173, 173);">
//                                             <label for="Movimiento" class="control-label input-group">Tiene Movimiento Migratorio? </label>
//                                             <div id="chekMovimiento" class="btn-group" data-toggle="buttons" style="margin-left:2em;margin-bottom:1em;" data-toggle="tooltip" data-placement="bottom" title="Seleccione una opcion" data-campo="chekMovimiento">
//                                                 <label class="btn btn-primary" style="padding-left: 2em;padding-right: 2em;font-weight: bold;">
//                                                     <input id="checkSI" type="radio" name="chekMovimiento" value="SI" >SI
//                                                 </label>
//                                                 <label class="btn btn-primary" style="padding-left: 2em;padding-right: 2em;font-weight: bold;">
//                                                     <input id="checkNO" type="radio" name="chekMovimiento" value="NO">NO
//                                                 </label>
//                                             </div>

//                                             <div id="Mtrue" class="col-xl-12 col-sm-12 col-md-12 well" hidden>
//                                               <div class="form-group col-xl-12 col-sm-12 col-md-12 col-md-offset-">
//                                                 <label for="Nfolio">Numero de Folio(s): <span class="sm">(Campo Obligatorio)</span></label>
//                                                 <input type="number" class="form-control" id="Nfolio" data-toggle="tooltip" data-placement="right" title="Ingresar Numero de Folio(s) del Reporte" data-campo="Nfolio" placeholder="Numero de Folio(s) del Reporte" onkeypress="return checkSoloNum(event)" required>
//                                               </div>
//                                             </div>


//                                             <div id="Mfalse" class="col-xl-12 col-sm-12 col-md-12 well" hidden>
//                                               <legend><span class="Colet">Negativa</span></legend>
//                                               <div class="form-group col-xl-12 col-sm-12 col-md-12">
//                                                 <label for="Negativa" >Tipo de Negativa: <span class="sm">(Campo Obligatorio)</span></label>
//                                                 <select id="cboNegativa" class="form-control" data-toggle="tooltip" data-placement="right" title="Seleccione Tipo de Negativa">
//                                                   <option value="0">SELECCIONAR...</option>
//                                                   <option value="1">NEGATIVA</option>
//                                                   <option value="2">NEGATIVA COMÚN</option>
//                                                   <option value="3">NEGATIVA SOLICITUD DE DATOS</option>
//                                                 </select>
//                                               </div>
//                                               <div id="Dsolicitud" class="form-group col-xl-12 col-sm-12 col-md-12" hidden>
//                                                 <label for="Dsolicitud">Datos a solicitar: <span class="sm">(Campo Obligatorio)</span></label>
//                                                 <input type="text" class="form-control" id="txtsolicitud" placeholder="Ej. FAVOR ENVIAR FECHA DE NACIMIENTO..." data-toggle="tooltip" data-placement="right" title="Datos a solicitar" data-campo="Dsolicitud" style="text-transform:uppercase;" required>
//                                               </div>
//                                             </div>

//                                           </div>

//                                           <div class="form-group col-xl-6 col-sm-6 col-md-6">
//                                             <label for="deportado" class="control-label input-group">Es deportado? </label>
//                                             <div id="checkDep" class="btn-group" data-toggle="buttons" style="margin-left:2em;" data-toggle="tooltip" data-placement="bottom" title="Seleccione una opcion" data-campo="chekMovimiento">
//                                                 <label class="btn btn-primary" style="padding-left: 2em;padding-right: 2em;font-weight: bold;">
//                                                     <input id="checkSiDeportado" type="radio" name="checkDeportado" value="SI" >SI
//                                                 </label>
//                                                 <label class="btn btn-primary" style="padding-left: 2em;padding-right: 2em;font-weight: bold;">
//                                                     <input id="checkNoDeportado" type="radio" name="checkDeportado" value="NO">NO
//                                                 </label>
//                                             </div>

//                                             <row>                                    
//                                             <div class="deportado col-xl-12 col-sm-12 col-md-12 well" id="deportado" style="margin-top:1em;" hidden>
//                                                 <div class="form-group col-xl-12 col-sm-12 col-md-12 col-md-offset-">
//                                                   <label for="Fdeportacion">Fecha de Deportacion: <span class="sm">(Campo Obligatorio)</span></label>
//                                                   <div class="input-group date">
//                                                     <input type="text" class="form-control" id="FechaDepor" data-toggle="tooltip" data-placement="right" title="Fecha de Deportacion" data-campo="Fdeportacion" required readonly>
//                                                     <span class="input-group-addon">
//                                                       <i class="glyphicon glyphicon-calendar"></i>
//                                                     </span>
//                                                   </div>
//                                                 </div>
//                                                 <div class="form-group col-xl-12 col-sm-12 col-md-12">
//                                                   <label for="Vproveniente">Vuelo Proveniente: <span class="sm">(Campo Obligatorio)</span></label>
//                                                   <input type="text" class="form-control" id="Vproveniente" placeholder="Ej. MESA, ARIZONA DE LOS ESTADOS UNIDOS DE NORTEAMERICA" data-toggle="tooltip" data-placement="right" title="Vuelo Proveniente" data-campo="Fdeportacion" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" required>
//                                                 </div>
//                                             </div>
//                                           </row>
//                                           </div> 
//                                     </div>                                       
//                                         <br>              
//                                         <br>
//                                         <div class="col-xl-3 col-sm-3 col-md-3 col-md-offset-0">
//                                         <span class="pull-left">
//                                         <button type="button" id="btn_atras"  class="btn btn-default btn-lg btn-shadow" onclick="atras()" tabindex=1 >
//                                           <span class="glyphicon glyphicon-chevron-left"></span>
//                                           Atras
//                                         </button>
//                                         </span>
//                                         </div>
//                                       <div class="col-xl-3 col-sm-3 col-md-3 col-md-offset-2">
//                                         <button type="button" id="btn_conprobarDatos"  class="btn btn-primary btn-lg btn-shadow " onclick="comprobar_datos()" tabindex=0 >
//                                           <span class="glyphicon glyphicon-floppy-disk"> </span>
//                                           Guardar
//                                         </button> 
//                                       </div>
//                                   </div>
//                                   <script>
//                                       $("#chekMovimiento input:radio").change(function() { 
//                                         if($("#checkSI").prop("checked")){
//                                           $( "#Mtrue" ).fadeIn("slow");
//                                           $( "#Mfalse" ).hide();
//                                         } else if($("#checkNO").prop("checked")) {
//                                           $( "#Mfalse" ).fadeIn("slow");
//                                           $( "#Mtrue" ).hide();
//                                         }
//                                       });


//                                       $("#checkDep input:radio").change(function() { 
//                                         if($("#checkSiDeportado").prop("checked")){
//                                           $( "#deportado" ).fadeIn("slow");
//                                         } else if($("#checkNoDeportado").prop("checked")) {
//                                           $( "#deportado" ).fadeOut("slow");
//                                         }
//                                       });

//                                       $(".input-group.date").datepicker({
//                                           format: "dd-mm-yyyy",
//                                           language: "es",
//                                           autoclose: true,
//                                           endDate: "1d",
//                                           orientation: "top auto"
//                                       });
//                                       $("#cboNegativa").change(function() {
//                                         var negativa = $(this).val();
//                                         if(negativa == 3)
//                                         {
//                                           $( "#Dsolicitud" ).fadeIn("slow");
//                                           $( "#txtsolicitud" ).focus();
//                                           $("html, body").animate({ scrollTop: 400 }, "slow");
//                                         }else{
//                                           $( "#Dsolicitud" ).fadeOut("slow");
//                                           $("html, body").animate({ scrollTop: 250 }, "slow");
//                                         }
                                 
//                                       });

//                                   </script>
//                           ',
//                           'case' => 3 );
//                       //
//                       echo json_encode($data);
//                   }
//                 }
//               }
//           }
//         }else{
//           $data = array(
//          'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
//                         <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
//                           La orden de pago No.<strong>'.$_POST['Norden'].'</strong> no <strong>existe!</strong></div>',
//          'case'=> 1);
                
//       echo json_encode($data);
//         }
//     }else{
//       $data = array(
//          'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
//                         <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
//                           <strong>Error en los datos</strong></div>',
//          'case'=> 1);
                
//       echo json_encode($data);
//       //echo "Error en los datos";
//     }
      
// }


// function comprobarDato()
// {
    
//     if (!empty($_POST['Nboleta'])&&!empty($_POST['Norden'])) {
//         $numeroOrden=$_POST['Norden'];
//         $numeroBoleta = $_POST['Nboleta'];
        
//         $sql = "SELECT orden_pago, primer_nombre, primer_apellido,  boleta_banco FROM datosgenerales WHERE boleta_banco='".$numeroBoleta."'";
//         $db = obtenerConexion();

//         $boleta = ejecutarQuery($db, $sql);
//         $resp = $boleta->fetch_assoc();
//         if ($resp['boleta_banco']==$numeroBoleta) {
//             // NUMERO DE BOLETA DE BANCO YA FUE UTILIZADA
//             $data = array(
//              'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
//                 <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
//                   La boleta de banco No.: <strong>'.$resp['boleta_banco'].'</strong> fue registrada con la orden de pago No.<strong>'.$resp['orden_pago'].'</strong> correspondiente a <strong>'.$resp['primer_nombre'].' '.$resp['primer_apellido'].'</strong>',
//              'case'=> 2);
//             // 
//             echo json_encode($data);

//         }else{
//             // SOLICITUD DE CONFIRMACION DE LA CERTIFICACION
//               $sql = "SELECT dg.orden_pago, dg.id_concepto, cp.nombre_concepto, dg.primer_nombre, dg.segundo_nombre, dg.primer_apellido, dg.segundo_apellido,
//                      dg.apellido_casada, dg.nacionalidad, dg.tipo_documento, dg.numero_documento, dg.lugar_documento, dg.boleta_banco, 
//                      dg.valor_concepto FROM datosgenerales dg, conceptos cp WHERE dg.id_concepto = cp.id_concepto AND orden_pago=".$numeroOrden;
//               $orden = ejecutarQuery($db, $sql);
//               $resp = $orden->fetch_assoc();
              
//               $datoDeportado="";
//               $dep="";

//               if (!empty($_POST['negativa'])) {
                
//                 switch ($_POST['negativa']) {
//                   case 1:
//                     $txtNegativa = 'NEGATIVA';
//                     break;
//                   case 2:
//                     $txtNegativa = 'NEGATIVA COMÚN';
//                     break;
//                   case 3:
//                     $txtNegativa = 'NEGATIVA SOLICITUD DE DATOS';
//                     break;
//                 }

//                 $Movimiento = '<tr>
//                   <td style="width:14em;">Tipo de Negativa:</td>
//                   <td id="tb-negativa" style="font-weight: 700;">'.$txtNegativa.'</td>
//                   <td id="tb-Nnegativa" style="font-weight: 700;" hidden>'.$_POST['negativa'].'</td>
//                 </tr>';
//                 if ($_POST['negativa']==3) {
//                   $Movimiento .= '<tr>
//                   <td style="width:14em;">Datos a Solicitar:</td>
//                   <td id="tb-txtsolicitud" style="font-weight: 700;">'.$_POST['txtsolicitud'].'</td>
//                 </tr>';
//                 }

//               }else if(!empty($_POST['Nfolio'])){
//                 $Movimiento='<tr>
//                   <td style="width:14em;">Numero de Folio(s):</td>
//                   <td id="tb-Nfolio" style="font-weight: 700;">'.$_POST['Nfolio'].'</td>
//                 </tr>';
//               }else if(!empty($_POST['Sdias'])){
//                 $Movimiento='
//                 <tr>
//                   <td style="width:14em;">Frontera:</td>
//                   <td id="tb-Infrontera" style="font-weight: 700;">'.$_POST['InFrontera'].'</td>
//                 </tr>
//                 <tr>
//                   <td style="width:14em;">Fecha Ingreso:</td>
//                   <td id="tb-Fingreso" style="font-weight: 700;">'.$_POST['Fingreso'].'</td>
//                 </tr>
//                 <tr>
//                   <td style="width:14em;">Dias para Permanecer:</td>
//                   <td id="tb-Sdias" style="font-weight: 700;">'.$_POST['Sdias'].'</td>
//                 </tr>';
//               }

//               if (!empty($_POST['FechaDepor'])&&!empty($_POST['Vproveniente'])) {
//                 $datoDeportado='
//                   <tr>
//                     <td style="width:14em;">Fecha Deportacion:</td>
//                     <td id="tb-FechaDepor" style="font-weight: 700;">'.$_POST['FechaDepor'].'</td>
//                   </tr>
//                   <tr>
//                     <td style="width:14em;">Vuelo Proveniente:</td>
//                     <td id="tb-Vproveniente" style="font-weight: 700;">'.$_POST['Vproveniente'].'</td>
//                   </tr>
//                 ';
//                 $dep="de DEPORTADO";
//                 }  

//                 $data = array(
//                      'message'=>' 
//                           <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xs-offset-0 col-sm-offset-0 col-md-offset-0 col-lg-offset-0 toppad" >
//                             <div class="panel panel-danger">
//                               <div class="panel-heading">
//                                 <h3 class="panel-title">Confirmacion de los Datos de la <strong>Certificación '.$dep.'</strong></span></h3>
//                               </div>
//                               <div class="panel-body">
//                                 <div class="row">             
//                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 "> 
//                                     <table class="table table-user-information">
//                                       <tbody>
//                                         <tr>
//                                           <td>Orden de Pago:</td>
//                                           <td id="tb-ordenpago" style="font-weight: 700;"><span id="nOrden">'.$resp['orden_pago'].'</span></td>
//                                         </tr>
//                                         <tr>
//                                           <td>Primer Nombre:</td>
//                                           <td id="tb-Pnombre" style="font-weight: 700;">'.$resp['primer_nombre'].'</td>
//                                         </tr>
//                                         <tr>
//                                           <td style="width:14em;">Segundo Nombre:</td>
//                                           <td id="tb-Snombre" style="font-weight: 700;">'.$resp['segundo_nombre'].'</td>
//                                         </tr>
//                                         <tr>
//                                           <td style="width:14em;">Primer Apellido:</td>
//                                           <td id="tb-Papellido" style="font-weight: 700;">'.$resp['primer_apellido'].'</td>
//                                         </tr>
//                                         <tr>
//                                           <td style="width:14em;">Segundo Apellido:</td>
//                                           <td id="tb-Sapellido" style="font-weight: 700;">'.$resp['segundo_apellido'].'</td>
//                                         </tr>
//                                         <tr>
//                                           <td style="width:14em;">Apellido de Casada:</td>
//                                           <td id="tb-Capellido" style="font-weight: 700;">'.$resp['apellido_casada'].'</td>
//                                         </tr>
//                                         <tr>
//                                           <td style="width:14em;">Nacionalidad:</td>
//                                           <td id="tb-nacionalidad" style="font-weight: 700;">'.$resp['nacionalidad'].'</td>
//                                         </tr>
//                                         <tr>
//                                           <td style="width:14em;">Tipo de Documento:</td>
//                                           <td id="tb-Tdoc" style="font-weight: 700;">'.$resp['tipo_documento'].'</td>
//                                         </tr>
//                                       </tbody>
//                                     </table>
//                                   </div>

//                                   <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 "> 
//                                     <table class="table table-user-information">
//                                       <tbody>
//                                         <tr>
//                                           <td style="width:14em;">Numero de Documento:</td>
//                                           <td id="tb-Ndoc" style="font-weight: 700;">'.$resp['numero_documento'].'</td>
//                                         </tr>
//                                         <tr>
//                                           <td style="width:14em;">Pais extendio Documento:</td>
//                                           <td id="tb-Pextendio" style="font-weight: 700;">'.$resp['nacionalidad'].'</td>
//                                         </tr>
//                                         <tr>
//                                           <td style="width:14em;">Lugar extendio Documento:</td>
//                                           <td id="tb-Lextendio" style="font-weight: 700;">'.$resp['lugar_documento'].'</td>
//                                         </tr>
//                                         <tr>
//                                           <td style="width:14em;">Concepto:</td>
//                                           <td id="tb-concepto" style="font-weight: 700;">'.$resp['nombre_concepto'].'</td>
//                                         </tr>
//                                         <tr hidden>
//                                           <td id="idConceptoP">'.$resp['id_concepto'].'</td>
//                                         </tr>
//                                         <tr>
//                                           <td style="width:14em;">Valor Concepto:</td>
//                                           <td id="tb-Vconcepto" style="font-weight: 700;">'.$resp['valor_concepto'].'</td>
//                                         </tr>
//                                         <tr>
//                                           <td style="width:14em;">Boleta de Banco No.:</td>
//                                           <td id="tb-Nboleta" style="font-weight: 700;">'.$_POST['Nboleta'].'</td>
//                                         </tr>
                                        
//                                         '.$Movimiento.$datoDeportado.'
//                                       </tbody>
//                                     </table>
//                                   </div>
//                                 </div>
//                               </div>
//                             </div>      
//                           </div>
//                           <br>
//                           <div class="col-xl-3 col-sm-3 col-md-3 col-md-offset-0">
//                             <span class="pull-left">
//                             <button type="button" id="btn_atras"  class="btn btn-default btn-lg btn-shadow" onclick="atras()" tabindex=1>
//                               <span class="glyphicon glyphicon-chevron-left"> </span>
//                               Atras
//                             </button>
//                             </span>
//                             </div>
//                           <div class="col-xl-3 col-sm-3 col-md-3 col-md-offset-2">
//                             <button type="button" id="btn_imprimirCertificacion"  class="btn btn-success btn-shadow" onclick="imprimirCertificacion()" tabindex=0>
//                               <span style="font-size:1.5em;margin:0; padding:0;" class="glyphicon glyphicon-print"></span><br>
//                               Imprimir Certificación
//                             </button> 
//                           </div>
//                       ',
//                      'case'=> 3);
                 
//                 echo json_encode($data);
//         }

//     }
//     else{
//       $data = array(
//        'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
//                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
//                         <strong>Error en los datos, comuniquese con Informatica!</strong></div>',
//        'case'=> 1);
                
//       echo json_encode($data);
//     }
        
// }


// function impresionCertificacion()
// {
//   if (!empty($_POST['Norden'])&&!empty($_POST['Nboleta'])) {
//     $numeroOrden=$_POST['Norden'];
//     $numeroBoleta = $_POST['Nboleta'];
//     // $numeroFolio = $_POST['Nfolio'];
//     $hoy = date("Y-m-d H:i:s");
//     $user = $_SESSION['id'];
//     $IP = getIP();

//     if (!empty($_POST['Sdias'])) {
//       $numeroFolio = $_POST['Nfolio'];
//       $Fingreso=date("Y-m-d",strtotime($_POST['Fingreso']));
//       $sql = "UPDATE datosgenerales SET lugar_ingreso='".$_POST['Infrontera']."', fecha_ingreso='".$Fingreso."', dias_permacer=".$_POST['Sdias'].", fecha_certificacion='".$hoy."', boleta_banco='".$numeroBoleta."', usuario_genera=".$user.", 
//             ip_local='".$IP."' WHERE orden_pago=".$numeroOrden;

//       // $sql.= " WHERE orden_pago=".$numeroOrden;
//       $db = obtenerConexion();
//       $impresion = ejecutarQuery($db, $sql);
//       $fechaLetras = fechaALetras(date('d/m/Y'));
//       $fechaL = fechaL($Fingreso);
//       // $F=date("d/m/Y",strtotime($Fredaccion));
//       // $fechaLetras = fechaALetras(date($F));

//       if ($impresion) {
//             $sql2 = "INSERT INTO impresiones (orden_pago, id_firma, fecha_reimpresion, motivo_reimpresion, boleta_banco, id_concepto, 
//               tipo_solicitud, usuario_genera, ip_local) 
//               VALUES (".$numeroOrden.", 1, '".$hoy."', '', '".$numeroBoleta."', 2, 1, '".$user."', '".$IP."')";
//             $db = obtenerConexion();
//             $result = ejecutarQuery($db, $sql2);
//             $tipo = "ESTATUS";
//             $QR = getQR($numeroOrden, $user, $IP, $tipo);
//             $sql = "SELECT dg.orden_pago, dg.id_concepto, dg.id_pais, ps.nacionalidad_pais, dg.primer_nombre, dg.segundo_nombre, dg.primer_apellido, dg.segundo_apellido, 
//                     dg.apellido_casada, dg.tipo_documento, dg.numero_documento, dg.lugar_ingreso, dg.fecha_ingreso, dg.dias_permacer
//                      FROM datosgenerales dg, paises ps WHERE dg.id_pais=ps.id_pais AND orden_pago=".$numeroOrden;
//             $orden = ejecutarQuery($db, $sql);
//             $resp = $orden->fetch_assoc();

//             $printEstatus="nombre=".$resp["primer_nombre"]." ".$resp["segundo_nombre"]." ".$resp["primer_apellido"]
//                             ." ".$resp["segundo_apellido"]." ".$resp["apellido_casada"]."&documento="
//                             .$resp["tipo_documento"]."&numeroDoc=".$resp["numero_documento"]."&nacionalidad="
//                             .$resp["nacionalidad_pais"]."&lugar=".$resp["lugar_ingreso"]."&fechaIngreso=".$fechaL
//                             ."&dias=".$resp["dias_permacer"]."&fecha=".$fechaLetras."&QR=".$QR;
            
//             $data = array(
//            'message'=> $printEstatus,
//            'case'=> 5);
//             echo json_encode($data);

//         }
//         else{
//           $data = array(
//          'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
//                         <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
//                           Error al relacionar la boleta de banco No.<strong>'.$numeroBoleta.'</strong> con la orden de pago No.: <strong>'.$numeroOrden.'</strong>
//                         </div>',
//          'case'=> 3);
//           //     
//           echo json_encode($data);
//         }  


//     }else{
//       if (!empty($_POST['Nnegativa'])) {
//         $numeroFolio = 1;
//         $Nnegativa = $_POST['Nnegativa'];
//         $sql = "UPDATE datosgenerales SET numero_folio=".$numeroFolio.", tipo_solicitud=1, fecha_certificacion='"
//               .$hoy."', boleta_banco='".$numeroBoleta."', usuario_genera=".$user.", ip_local='".$IP."', negativa="
//               .$Nnegativa;
        
//         if (!empty($_POST['txtsolicitud'])) {
//             $sql.=", datosolicitar='".$_POST['txtsolicitud']."'";
//         }

//         if (!empty($_POST['Vproveniente'])&&!empty($_POST['FechaDepor'])) {
//             //Negativa Deportado
//             $Vproveniente = $_POST['Vproveniente'];
//             $FechaDeport=date("Y-m-d",strtotime($_POST['FechaDepor']));
//             $sql.=", fecha_deportado='".$FechaDeport."', vuelo_proveniente='".$Vproveniente."' WHERE orden_pago=".$numeroOrden;
//             $db = obtenerConexion();
//             $impresion = ejecutarQuery($db, $sql);
//             $fechaLetras = fechaALetras(date('d/m/Y'));
//             $fechaL = fechaL(date('Y-m-d'));
             
//             if ($impresion) {
//                 $sql2 = "INSERT INTO impresiones (orden_pago, id_firma, fecha_reimpresion, motivo_reimpresion, boleta_banco, id_concepto, 
//                   tipo_solicitud, usuario_genera, ip_local) 
//                   VALUES (".$numeroOrden.", 1, '".$hoy."', '', '".$numeroBoleta."', 2, 1, '".$user."', '".$IP."')";
//                 $db = obtenerConexion();
//                 $result = ejecutarQuery($db, $sql2);
//                 $tipo = "PARTICULAR DEPORTADO";
//                 $QR = getQR($numeroOrden, $user, $IP, $tipo);
//                 $sql = "SELECT primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, apellido_casada, 
//                         fecha_deportado, vuelo_proveniente, negativa, datosolicitar, numero_folio FROM datosgenerales 
//                         WHERE orden_pago=".$numeroOrden;
//                 $orden = ejecutarQuery($db, $sql);

//                 $resp = $orden->fetch_assoc();

//                 $printDeportado="nombre=".$resp["primer_nombre"]." ".$resp["segundo_nombre"]." ".$resp["primer_apellido"]." ".$resp["segundo_apellido"]." ".$resp["apellido_casada"]."&fechaDeportado=".FechaL($resp["fecha_deportado"])."&Vproveniente=".$resp["vuelo_proveniente"]."&Nfolio=".$resp["numero_folio"]."&fecha=".$fechaLetras."&QR=".$QR."&Movimiento=NO";
//                 $printNegativa = "nombre=".$resp["primer_nombre"]." ".$resp["segundo_nombre"]." ".$resp["primer_apellido"]." ".$resp["segundo_apellido"]." ".$resp["apellido_casada"]."&fecha=".$fechaL;
//                 if ($resp["negativa"]==3) {
//                  $printNegativa .= "&datosolicitar=".$resp["datosolicitar"];
//                 }

//                 $data = array(
//                  'message'=> ''.$printDeportado.'',
//                  'tipoCertificacion'=> 1,
//                  'tipoNegativa'=> ''.$resp["negativa"].'',
//                  'negativaDatos'=> ''.$printNegativa.'',
//                  'case'=> 4);
                
//                 echo json_encode($data);

//             }
//             else{
//               $data = array(
//              'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
//                             <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
//                               Error al relacionar la boleta de banco No.<strong>'.$numeroBoleta.'</strong> con la orden de pago No.: <strong>'.$numeroOrden.'</strong>
//                             </div>',
//              'case'=> 3);
//               // 
//               echo json_encode($data);
//             }  
//         }
//         else{
//           //Negativa Particular
//           $sql.= " WHERE orden_pago=".$numeroOrden;
//           $db = obtenerConexion();
//           $impresion = ejecutarQuery($db, $sql);
//           $fechaLetras = fechaALetras(date('d/m/Y'));

//           if ($impresion) {
//           $sql2 = "INSERT INTO impresiones (orden_pago, id_firma, fecha_reimpresion, motivo_reimpresion, boleta_banco, id_concepto, 
//                   tipo_solicitud, usuario_genera, ip_local) 
//                   VALUES (".$numeroOrden.", 1, '".$hoy."', '', '".$numeroBoleta."', 2, 1, '".$user."', '".$IP."')";
//           $db = obtenerConexion();
//           $result = ejecutarQuery($db, $sql2);
//           $tipo = "PARTICULAR";
//           $QR = getQR($numeroOrden, $user, $IP, $tipo);
//           $fechaLetras = fechaALetras(date('d/m/Y'));
//           $fechaL = fechaL(date('Y-m-d'));

//           $sql = "SELECT primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, apellido_casada, negativa, 
//                   datosolicitar, numero_folio FROM datosgenerales WHERE orden_pago=".$numeroOrden;
//           $orden = ejecutarQuery($db, $sql);
//           $resp = $orden->fetch_assoc();

//           $printParticular="nombre=".$resp["primer_nombre"]." ".$resp["segundo_nombre"]." ".$resp["primer_apellido"]." ".$resp["segundo_apellido"]." ".$resp["apellido_casada"]."&Nfolio=".$resp["numero_folio"]."&fecha=".$fechaLetras."&QR=".$QR."&Movimiento=NO";
//           $printNegativa = "nombre=".$resp["primer_nombre"]." ".$resp["segundo_nombre"]." ".$resp["primer_apellido"]." ".$resp["segundo_apellido"]." ".$resp["apellido_casada"]."&fecha=".$fechaL;
//           if ($resp["negativa"]==3) {
//            $printNegativa .= "&datosolicitar=".$resp["datosolicitar"];
//           }

//             $data = array(
//              'message'=> ''.$printParticular.'',
//              'tipoCertificacion'=> 0,
//              'tipoNegativa'=> ''.$resp["negativa"].'',
//              'negativaDatos'=> ''.$printNegativa.'',
//              'case'=> 4);
             
//             echo json_encode($data);
            
//           }else{
//             $data = array(
//                'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
//                               <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
//                                 Error al relacionar la boleta de banco No.<strong>'.$numeroBoleta.'</strong> con la orden de pago No.: <strong>'.$numeroOrden.'</strong>
//                               </div>',
//                'case'=> 3);
//                 // 
//                 echo json_encode($data);
//           }
               
//         }

//       }
//       else{
//         $numeroFolio = $_POST['Nfolio'];
//         $sql = "UPDATE datosgenerales SET numero_folio=".$numeroFolio.", tipo_solicitud=1, fecha_certificacion='".$hoy."', boleta_banco='".$numeroBoleta."', usuario_genera=".$user.", ip_local='".$IP."'";  
//         if (!empty($_POST['Vproveniente'])&&!empty($_POST['FechaDepor'])) {
//             //Deportado
//             $Vproveniente = $_POST['Vproveniente'];
//             $FechaDeport=date("Y-m-d",strtotime($_POST['FechaDepor']));
//             $sql.=", fecha_deportado='".$FechaDeport."', vuelo_proveniente='".$Vproveniente."' WHERE orden_pago=".$numeroOrden;
//             $db = obtenerConexion();
//             $impresion = ejecutarQuery($db, $sql);
//             $fechaLetras = fechaALetras(date('d/m/Y'));
             
//             if ($impresion) {
//                 $sql2 = "INSERT INTO impresiones (orden_pago, id_firma, fecha_reimpresion, motivo_reimpresion, boleta_banco, id_concepto, 
//                   tipo_solicitud, usuario_genera, ip_local) 
//                   VALUES (".$numeroOrden.", 1, '".$hoy."', '', '".$numeroBoleta."', 2, 1, '".$user."', '".$IP."')";
//                 $db = obtenerConexion();
//                 $result = ejecutarQuery($db, $sql2);
//                 $tipo = "PARTICULAR DEPORTADO";
//                 $QR = getQR($numeroOrden, $user, $IP, $tipo);
//                 $sql = "SELECT orden_pago, id_concepto, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, apellido_casada, fecha_deportado, vuelo_proveniente, numero_folio FROM datosgenerales WHERE orden_pago=".$numeroOrden;
//                 $orden = ejecutarQuery($db, $sql);

//                 $resp = $orden->fetch_assoc();

//                 $printDeportado="nombre=".$resp["primer_nombre"]." ".$resp["segundo_nombre"]." ".$resp["primer_apellido"]." ".$resp["segundo_apellido"]." ".$resp["apellido_casada"]."&fechaDeportado=".FechaL($resp["fecha_deportado"])."&Vproveniente=".$resp["vuelo_proveniente"]."&Nfolio=".$resp["numero_folio"]."&fecha=".$fechaLetras."&QR=".$QR;
                
//                 $data = array(
//                'message'=> ''.$printDeportado.'',
//                'case'=> 1);
//                 // 
//                 echo json_encode($data);

//             }
//             else{
//               $data = array(
//              'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
//                             <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
//                               Error al relacionar la boleta de banco No.<strong>'.$numeroBoleta.'</strong> con la orden de pago No.: <strong>'.$numeroOrden.'</strong>
//                             </div>',
//              'case'=> 3);
//               // 
//               echo json_encode($data);
//             }  
//         }
//         else{
//           //Particular
//           $sql.= " WHERE orden_pago=".$numeroOrden;
//           $db = obtenerConexion();
//           $impresion = ejecutarQuery($db, $sql);
//           $fechaLetras = fechaALetras(date('d/m/Y'));


//           if ($impresion) {
//                 $sql2 = "INSERT INTO impresiones (orden_pago, id_firma, fecha_reimpresion, motivo_reimpresion, boleta_banco, id_concepto, 
//                   tipo_solicitud, usuario_genera, ip_local) 
//                   VALUES (".$numeroOrden.", 1, '".$hoy."', '', '".$numeroBoleta."', 2, 1, '".$user."', '".$IP."')";
//                 $db = obtenerConexion();
//                 $result = ejecutarQuery($db, $sql2);
//                 $tipo = "PARTICULAR";
//                 $QR = getQR($numeroOrden, $user, $IP, $tipo);
//                 $sql = "SELECT orden_pago, id_concepto, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, apellido_casada, numero_folio FROM datosgenerales WHERE orden_pago=".$numeroOrden;
//                 $orden = ejecutarQuery($db, $sql);
//                 $resp = $orden->fetch_assoc();

//                 $printParticular="nombre=".$resp["primer_nombre"]." ".$resp["segundo_nombre"]." ".$resp["primer_apellido"]." ".$resp["segundo_apellido"]." ".$resp["apellido_casada"]."&Nfolio=".$resp["numero_folio"]."&fecha=".$fechaLetras."&QR=".$QR;
                
//                 $data = array(
//                'message'=> ''.$printParticular.'',
//                'case'=> 2);
//                 // 
//                 echo json_encode($data);

//             }
//             else{
//               $data = array(
//              'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
//                             <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
//                               Error al relacionar la boleta de banco No.<strong>'.$numeroBoleta.'</strong> con la orden de pago No.: <strong>'.$numeroOrden.'</strong>
//                             </div>',
//              'case'=> 3);
//               //     
//               echo json_encode($data);
//             }     
//         }
//       }
//     }
//   }
// }


// function certificacionOficial()
// {
//   $data = json_decode(stripslashes($_POST['datos']));
//   $i=1;
//   foreach($data as $dato=>$valor)
//   {
//     $i++;  

//   }
//   // echo $i;
//   $NfolioEntrada = $data->{NfolioEntrada};
//   $sql = "SELECT primer_nombre, primer_apellido, folio_entrada, variasPersonas FROM datosgenerales WHERE folio_entrada='".$NfolioEntrada."'";
//   $db = obtenerConexion();
//   $orden = ejecutarQuery($db, $sql);
//   $resp = $orden->fetch_assoc();

//   if ($resp['folio_entrada']!=NULL||$resp['folio_entrada']!="") {
//     if ($resp['variasPersonas']==1) {
//       $data = array(
//              'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
//                 <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
//                   El folio de entrada No.: <strong>'.$NfolioEntrada.'</strong> ya esta registrado!',
//              'case'=> 1);
//       echo json_encode($data);
//     }else{

//       $data = array(
//              'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
//                 <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
//                   El folio de entrada No.: <strong>'.$NfolioEntrada.'</strong> ya esta registrado con el/la señor(a) <strong>'.$resp['primer_nombre'].' '.$resp['primer_apellido'].'</strong>',
//              'case'=> 1);
//       echo json_encode($data);
//     }
    
//   }
//   else{

//     if ($i>=7) {
//       # Varios nombres
//       // echo "Varios Nombres";
//       $Asunto = $data->{Asunto};
//       $Nfolio = $data->{folio};
//       $Fredaccion = $data->{Fredaccion};
//       $Fredaccion=date("Y-m-d",strtotime($Fredaccion));
//       $user = $_SESSION['id'];
//       $IP = getIP();
//       $hoy = date("Y-m-d H:i:s");

//       $db = obtenerConexion();
//       $db->autocommit(FALSE);

//       $sql = "INSERT INTO datosgenerales (id_concepto, id_pais, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, 
//               apellido_casada, nacionalidad, tipo_documento, numero_documento, lugar_documento, jefe_arraigo, resolucion, numero_folio, 
//               tipo_solicitud, fecha_certificacion, fecha_redaccion, boleta_banco, valor_concepto, fecha_deportado, vuelo_proveniente, usuario_genera, ip_local, 
//               asunto, folio_entrada, variasPersonas) 
//               VALUES (2, '', 'VARIASPERSONAS', '', 'VARIASPERSONAS', '', '',
//                   '', '', '', '', '', '', '".$Nfolio."', 0, '".$hoy."', '".$Fredaccion."','', '', '', '', '".$user."', '".$IP."', '".$Asunto."', '".$NfolioEntrada."', 1)";

//       // echo $sql;
//       $result = ejecutarQuery($db, $sql);
//       $error=False;
//       if ($result) {
//         $nuevo = datoNuevo($db);
//         foreach($data as $dato=>$valor)
//         { 
//           $dt = array();
//           foreach((array) $valor as $name=>$val)
//           {
//             if ($name!="0") {
//               // echo ($name."->".$val."<-");
//               $dt[] = $val;
//               // array_push($data, $val);

//             }
//           }
//           if (!empty($dt)) {
//             // print_r($dt);


//             if ($dt[5]=='1'||$dt[5]=='2'||$dt[5]=='3') {
//               if ($dt[5]=='3') {
//                 if(!empty($dt[7])){
//                     // $DuranteDel = $dt[7];
//                     $DuranteDel=date("Y-m-d",strtotime($dt[7]));
//                   }else{
//                       $DuranteDel ='';
//                   }

//                   if(!empty($dt[8])){
//                       // $DuranteAl = $dt[8];
//                       $DuranteAl=date("Y-m-d",strtotime($dt[8]));
//                   }else{
//                       $DuranteAl ='';
//                   }
//                 $sql2 = "INSERT INTO persona (datogeneral, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, 
//                   apellido_casada, negativa, datosolicitar, duranteDel, duranteAl) 
//                  VALUES (".$nuevo.", '".$dt[0]."', '".$dt[1]."', '".$dt[2]."', '".$dt[3]."', '".$dt[4]."', '".$dt[5]."', 
//                   '".$dt[6]."', '".$DuranteDel."', '".$DuranteAl."')";
//               }else{
//                 if(!empty($dt[6])){
//                   // $DuranteDel = $dt[7];
//                   $DuranteDel=date("Y-m-d",strtotime($dt[6]));
//                 }else{
//                   $DuranteDel ='';
//                 }

//                 if(!empty($dt[7])){
//                     // $DuranteAl = $dt[8];
//                     $DuranteAl=date("Y-m-d",strtotime($dt[7]));
//                 }else{
//                     $DuranteAl ='';
//                 }

//                 $sql2 = "INSERT INTO persona (datogeneral, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, 
//                   apellido_casada, negativa, duranteDel, duranteAl) 
//                  VALUES (".$nuevo.", '".$dt[0]."', '".$dt[1]."', '".$dt[2]."', '".$dt[3]."', '".$dt[4]."', 
//                   '".$dt[5]."', '".$DuranteDel."', '".$DuranteAl."')";
//               }
//             }else{
//               if(!empty($dt[5])){
//                 // $DuranteDel = $dt[7];
//                 $DuranteDel=date("Y-m-d",strtotime($dt[5]));
//               }else{
//                 $DuranteDel ='';
//               }

//               if(!empty($dt[6])){
//                   // $DuranteAl = $dt[8];
//                   $DuranteAl=date("Y-m-d",strtotime($dt[6]));
//               }else{
//                   $DuranteAl ='';
//               }
//               $sql2 = "INSERT INTO persona (datogeneral, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, 
//                   apellido_casada, duranteDel, duranteAl) 
//                  VALUES (".$nuevo.", '".$dt[0]."', '".$dt[1]."', '".$dt[2]."', '".$dt[3]."', '".$dt[4]."', 
//                   '".$DuranteDel."', '".$DuranteAl."')";
//             }

            

//             // echo $sql2;

//             $resultPersona = ejecutarQuery($db, $sql2);
//             // $error=True;
//             if ($resultPersona) {
//               $error=False;
//             }
            
//           }
//         }

//         if ($error) {
//           $db->rollback();
//           $Resp = array(
//                'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
//                               <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
//                                 <strong>Error en la transaccion</strong>
//                               </div>',
//                'case'=> 3);
            
//           echo json_encode($Resp);
//         }else{
          
//           $sql2 = "INSERT INTO impresiones (orden_pago, id_firma, fecha_reimpresion, motivo_reimpresion, boleta_banco, id_concepto, 
//                        tipo_solicitud, usuario_genera, ip_local) 
//                        VALUES (".$nuevo.", 1, '".$hoy."', '', '', 2, 0, '".$user."', '".$IP."')";
//           $impre = ejecutarQuery($db, $sql2);
          
//           if ($impre) {
//               $db->commit();
//               $sql3 = "SELECT primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, 
//                     apellido_casada, negativa, datosolicitar FROM persona WHERE datogeneral=".$nuevo;
              
//               // echo $sql3;
//               $resultInf = ejecutarQuery($db, $sql3);

//               $sqlAsunto = "SELECT nombre, cargo, asunto, dependencia FROM asunto WHERE id=".$Asunto;

//               $Asun = ejecutarQuery($db, $sqlAsunto);
//               $respAsunto = $Asun->fetch_assoc();
//               $DatoAsunto = $respAsunto['nombre'].", ".$respAsunto['cargo'].", ".$respAsunto['asunto'].", ".$respAsunto['dependencia'];
              
//               $tipo = "OFICIAL";
//               $QR = getQR($nuevo, $user, $IP, $tipo);
//               $fechaL = fechaL(date($Fredaccion));
//               $F=date("d/m/Y",strtotime($Fredaccion));
//               $fechaLetras = fechaALetras(date($F));

//               $dataCertificacion = "fecha=".$fechaLetras."&folio=".$NfolioEntrada."&asunto=".$DatoAsunto."&Nfolio=".$Nfolio."&QR=".$QR."&idDato=".$nuevo;
//               $Infos = array(
//               'case'=> 5,
//               'dataCertificacion' => $dataCertificacion
//               );
//               while($row = $resultInf->fetch_assoc()){
//                   $inf = array(
//                     'nombre' => $row['primer_nombre'].' '.$row['segundo_nombre'].' '.$row['primer_apellido'].' '.$row['segundo_apellido'].' '.$row['apellido_casada'],
//                     'fecha' => $fechaL,
//                     'tipoNegativa' => $row['negativa'],
//                     'negativaDatos' => $row['datosolicitar'],
//                   );
//                   array_push($Infos, $inf);
//               }

//               echo json_encode($Infos);
            

//           }else{
//             $db->rollback();
//             $Resp = array(
//                    'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
//                                   <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
//                                     <strong>Error en la transaccion</strong>
//                                   </div>',
//                    'case'=> 3);
                  
//             echo json_encode($Resp);

//           }
//         }

//       }else{
//         $db->rollback();
//         $Resp = array(
//                'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
//                               <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
//                                 <strong>Error en la transaccion</strong>
//                               </div>',
//                'case'=> 3);
              
//         echo json_encode($Resp);
//       }
//     }else{
//       # Solo un nombre
//           $Pnombre = $data->{fila1}->{Pnombre};
//           $nombreCompeto=$Pnombre;
//           if(!empty($data->{fila1}->{Snombre})){
//               $Snombre =$data->{fila1}->{Snombre};
//               $nombreCompeto.=" ".$Snombre;
//           }else{
//               $Snombre ="";
//           }

//           $Papellido = $data->{fila1}->{Papellido};
//           $nombreCompeto.=" ".$Papellido;
//           if(!empty($data->{fila1}->{Sapellido})){
//               $Sapellido = $data->{fila1}->{Sapellido};
//               $nombreCompeto.=" ".$Sapellido;
//           }else{
//               $Sapellido ="";
//           }

//           if(!empty($data->{fila1}->{Capellido})){
//               $Capellido = $data->{fila1}->{Capellido};
//               $nombreCompeto.=" ".$Capellido;
//           }else{
//               $Capellido ="";
//           }

//           if(!empty($data->{fila1}->{negativa})){
//               $Negativa = $data->{fila1}->{negativa};
//           }else{
//               $Negativa =0;
//           }

//           if(!empty($data->{fila1}->{DuranteDel})){
//               $DuranteDel = $data->{fila1}->{DuranteDel};
//               $DuranteDel=date("Y-m-d",strtotime($DuranteDel));

//           }else{
//               $DuranteDel ='';
//           }

//           if(!empty($data->{fila1}->{DuranteAl})){
//               $DuranteAl = $data->{fila1}->{DuranteAl};
//               $DuranteAl=date("Y-m-d",strtotime($DuranteAl));
//           }else{
//               $DuranteAl ='';
//           }

//           $Asunto = $data->{Asunto};
//           $Nfolio = $data->{folio};
//           $Fredaccion = $data->{Fredaccion};
//           $Fredaccion=date("Y-m-d",strtotime($Fredaccion));
//           $user = $_SESSION['id'];
//           $IP = getIP();
//           $hoy = date("Y-m-d H:i:s");

//           // echo "Datos: ".$nombreCompeto." asunto: ".$Asunto." Folio=".$Nfolio." Negativa==".$Negativa;
//           $db = obtenerConexion();
//           $db->autocommit(FALSE);


//           if ($Negativa!=0) {
//             # NEGATIVA

//             $sql = "INSERT INTO datosgenerales (id_concepto, id_pais, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, 
//             apellido_casada, nacionalidad, tipo_documento, numero_documento, lugar_documento, jefe_arraigo, resolucion, numero_folio, 
//             tipo_solicitud, fecha_certificacion, fecha_redaccion, boleta_banco, valor_concepto, fecha_deportado, vuelo_proveniente, usuario_genera, ip_local, 
//             asunto, folio_entrada, negativa, duranteDel, duranteAl) 
//             VALUES (2, '', '".$Pnombre."', '".$Snombre."', '".$Papellido."', '".$Sapellido."', '".$Capellido."',
//                 '', '', '', '', '', '', '".$Nfolio."', 0, '".$hoy."', '".$Fredaccion."','', '', '', '', '".$user."', '".$IP."', '".$Asunto."', '".$NfolioEntrada."', ".$Negativa.", '".$DuranteDel."', '".$DuranteAl."')";

//             if ($Negativa==3) {
//               $txtsolicitud = $data->{fila1}->{txtsolicitud};

//               $sql = "INSERT INTO datosgenerales (id_concepto, id_pais, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, 
//               apellido_casada, nacionalidad, tipo_documento, numero_documento, lugar_documento, jefe_arraigo, resolucion, numero_folio, 
//               tipo_solicitud, fecha_certificacion, boleta_banco, valor_concepto, fecha_deportado, vuelo_proveniente, usuario_genera, ip_local, 
//               asunto, folio_entrada, negativa, datosolicitar, duranteDel, duranteAl) 
//               VALUES (2, '', '".$Pnombre."', '".$Snombre."', '".$Papellido."', '".$Sapellido."', '".$Capellido."',
//                   '', '', '', '', '', '', '".$Nfolio."', 0, '".$hoy."','', '', '', '', '".$user."', '".$IP."', '".$Asunto."', '".$NfolioEntrada."', ".$Negativa.", '".$txtsolicitud."', '".$DuranteDel."', '".$DuranteAl."')";
//             }

//               $result = ejecutarQuery($db, $sql);

//               if ($result) {
//                   $nuevo = datoNuevo($db);
                  
//                   $sqlAsunto = "SELECT nombre, cargo, asunto, dependencia FROM asunto WHERE id=".$Asunto;

//                   $Asun = ejecutarQuery($db, $sqlAsunto);
//                   $respAsunto = $Asun->fetch_assoc();


//                   if ($respAsunto) {
//                       $DatoAsunto = $respAsunto['nombre'].", ".$respAsunto['cargo'].", ".$respAsunto['asunto'].", ".$respAsunto['dependencia'];
                        
//                       $sql2 = "INSERT INTO impresiones (orden_pago, id_firma, fecha_reimpresion, motivo_reimpresion, boleta_banco, id_concepto, 
//                         tipo_solicitud, usuario_genera, ip_local) 
//                         VALUES (".$nuevo.", 1, '".$hoy."', '', '', 2, 0, '".$user."', '".$IP."')";
//                       $result2 = ejecutarQuery($db, $sql2);

//                       if ($result2) {
//                         $db->commit();
//                         $tipo = "OFICIAL";
//                         $QR = getQR($nuevo, $user, $IP, $tipo);
//                         if ($DuranteDel!=""&&$DuranteAl!="") {
//                           $FLetrasDel = fechaALetras(date("d/m/Y",strtotime($DuranteDel)));
//                           $FLetrasAl = fechaALetras(date("d/m/Y",strtotime($DuranteAl)));
//                         }else{
//                           $FLetrasDel = "";
//                           $FLetrasAl = "";
//                         }
//                         $fechaLetras = fechaALetras(date("d/m/Y",strtotime($Fredaccion)));
//                         $fechaL = fechaL(date('Y-m-d',strtotime($Fredaccion)));
                        

//                         $data = "fecha=".$fechaLetras."&folio=".$NfolioEntrada."&asunto=".$DatoAsunto."&nombre=".$nombreCompeto."&Nfolio=".$Nfolio."&QR=".$QR."&Movimiento=NO&duranteDel=".$FLetrasDel."&duranteAl=".$FLetrasAl;
//                         $printNegativa = "nombre=".$nombreCompeto."&fecha=".$fechaL;
                        
//                         if ($Negativa==3) {
//                           $printNegativa .= "&datosolicitar=".$txtsolicitud;
//                         }

//                         $data = array(
//                          'message'=> ''.$data.'',
//                          'tipoNegativa'=> ''.$Negativa.'',
//                          'negativaDatos'=> ''.$printNegativa.'',
//                          'case'=> 4);
                         
//                         echo json_encode($data);

//                        //  $data = array(
//                        // 'message'=> ''.$data.'',
//                        // 'case'=> 2);
//                        //  // 
//                        //  echo json_encode($data); 
//                       }else{
//                         $db->rollback();
//                         $data = array(
//                        'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
//                                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
//                                         Error al realizar la transaccion
//                                       </div>',
//                        'case'=> 3);
//                         // 
//                         echo json_encode($data);
//                       }

//                   }else{
//                       $db->rollback();
//                       $data = array(
//                      'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
//                                     <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
//                                       Error al realizar la transaccion
//                                     </div>',
//                      'case'=> 3);
//                       // 
//                       echo json_encode($data);
//                   }
//               }else{
//                 $db->rollback();
//                       $data = array(
//                      'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
//                                     <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
//                                       Error al realizar la transaccion
//                                     </div>',
//                      'case'=> 3);
//                       // 
//                       echo json_encode($data);
//               }

//           }
//           else{
//             # SI TIENE MOVIMIENTO MIGRATORIO
//             $sql = "INSERT INTO datosgenerales (id_concepto, id_pais, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, 
//               apellido_casada, nacionalidad, tipo_documento, numero_documento, lugar_documento, jefe_arraigo, resolucion, numero_folio, 
//               tipo_solicitud, fecha_certificacion, fecha_redaccion, boleta_banco, valor_concepto, fecha_deportado, vuelo_proveniente, usuario_genera, ip_local, 
//               asunto, folio_entrada, duranteDel, duranteAl) 
//               VALUES (2, '', '".$Pnombre."', '".$Snombre."', '".$Papellido."', '".$Sapellido."', '".$Capellido."',
//                   '', '', '', '', '', '', '".$Nfolio."', 0, '".$hoy."', '".$Fredaccion."','', '', '', '', '".$user."', '".$IP."', '".$Asunto."', '".$NfolioEntrada."', '".$DuranteDel."', '".$DuranteAl."')";

//             $result = ejecutarQuery($db, $sql);

//             if ($result) {
//                 $nuevo = datoNuevo($db);
                
//                 $sqlAsunto = "SELECT nombre, cargo, asunto, dependencia FROM asunto WHERE id=".$Asunto;

//                 $Asun = ejecutarQuery($db, $sqlAsunto);
//                 $respAsunto = $Asun->fetch_assoc();


//                 if ($respAsunto) {
//                     $DatoAsunto = $respAsunto['nombre'].", ".$respAsunto['cargo'].", ".$respAsunto['asunto'].", ".$respAsunto['dependencia'];
                      
//                     $sql2 = "INSERT INTO impresiones (orden_pago, id_firma, fecha_reimpresion, motivo_reimpresion, boleta_banco, id_concepto, 
//                       tipo_solicitud, usuario_genera, ip_local) 
//                       VALUES (".$nuevo.", 1, '".$hoy."', '', '', 2, 0, '".$user."', '".$IP."')";
//                     $result2 = ejecutarQuery($db, $sql2);

//                     if ($result2) {
//                       $db->commit();
//                       $tipo = "OFICIAL";
//                       $QR = getQR($nuevo, $user, $IP, $tipo);
//                       if ($DuranteDel!=""&&$DuranteAl!="") {
//                         $FLetrasDel = fechaALetras(date("d/m/Y",strtotime($DuranteDel)));
//                         $FLetrasAl = fechaALetras(date("d/m/Y",strtotime($DuranteAl)));
//                       }else{
//                         $FLetrasDel = "";
//                         $FLetrasAl = "";
//                       }
//                       $fechaLetras = fechaALetras(date("d/m/Y",strtotime($Fredaccion)));
//                       $fechaL = fechaL(date('Y-m-d',strtotime($Fredaccion)));
//                       // $fechaLetras = fechaALetras(date('d/m/Y'));
//                       $data = "fecha=".$fechaLetras."&folio=".$NfolioEntrada."&asunto=".$DatoAsunto."&nombre=".$nombreCompeto."&Nfolio=".$Nfolio."&QR=".$QR."&duranteDel=".$FLetrasDel."&duranteAl=".$FLetrasAl;

//                       $data = array(
//                      'message'=> ''.$data.'',
//                      'case'=> 2);
//                       // 
//                       echo json_encode($data); 
//                     }else{
//                       $db->rollback();
//                       $data = array(
//                      'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
//                                     <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
//                                       Error al realizar la transaccion
//                                     </div>',
//                      'case'=> 3);
//                       // 
//                       echo json_encode($data);
//                     }
//                 }
            
//             }else{
//                 $db->rollback();
//                 $data = array(
//                'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
//                               <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
//                                 Error al realizar la transaccion
//                               </div>',
//                'case'=> 3);
//                 // 
//                 echo json_encode($data);
//             }
//           }
//     }
//   }

// }

// function modPaticularDatos()
// {
//   if (!empty($_POST['NordenMod'])) {
//       $numeroOrden=$_POST['NordenMod'];
//       //$numeroBoleta = $_POST['Nboleta'];
      
//         $sql = "SELECT orden_pago, id_concepto, id_pais, primer_nombre, segundo_nombre, primer_apellido, 
//                 segundo_apellido, apellido_casada, lugar_ingreso, fecha_ingreso, dias_permacer, nacionalidad, tipo_documento, numero_documento, 
//                 lugar_documento, resolucion, boleta_banco, numero_folio, valor_concepto, tipo_solicitud, 
//                 fecha_deportado, vuelo_proveniente, negativa, datosolicitar FROM datosgenerales WHERE 
//                 orden_pago=".$numeroOrden;
//         $db = obtenerConexion();
//         $orden = ejecutarQuery($db, $sql);
//         $resp = $orden->fetch_assoc();
//     if ($resp['id_concepto']==8) {
//         $data = array(
//          'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
//             <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
//               La orden de pago No.: <strong>'.$resp['orden_pago'].'</strong> pertenece a CERTIFICACIÓN DE CARENCIA DE ARRAIGO ',
//          'case'=> 2);
//         // 
//         echo json_encode($data);
//     }else if ($resp['id_concepto']==1) {
//         $data = array(
//          'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
//             <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
//               La orden de pago No.: <strong>'.$resp['orden_pago'].'</strong> pertenece a MULTA POR PERMANENCIA ILEGAL EN EL PAÍS DE CONTRO MIGRATORIO',
//          'case'=> 2);
//         // 
//         echo json_encode($data);
//     }else{

//         if ($resp['orden_pago']==$numeroOrden) {
//             if ($resp['boleta_banco']==0||$resp['boleta_banco']==null) {
//                 $data = array(
//                  'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
//                     <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
//                       La orden de pago No.: <strong>'.$resp['orden_pago'].'</strong> no se encuentra generada. 
//                        Desea generar la certificacion.  
//                       <a href="?ac=certificacion" class="btn btn-success btn-shadow" role="button">
//                         <span class="glyphicon glyphicon-file"></span>
//                         Generar Certificacion
//                       </a>
//                       </div>',
//                  'case'=> 2);
//                 // 
//                 echo json_encode($data);

//             }else{


//                 $nacional="";
//                 $paises = obtenerPaises();
//                 foreach ($paises as $pais) {
//                     if ($pais->id==$resp['nacionalidad']) {
//                       $nacional.= '<option value="'.$pais->id.'" selected>'.$pais->nacionalidad.'</option>';        
//                     }else{
//                       $nacional.= '<option value="'.$pais->id.'">'.$pais->nacionalidad.'</option>';        
//                     } 
//                 }

//                 $idpais="";
//                 $paises = obtenerPaises();
//                 foreach ($paises as $pais) {
//                     if ($pais->id==$resp['id_pais']) {
//                       $idpais.= '<option value="'.$pais->id.'" selected>'.$pais->nombre.'</option>';        
//                     }else{
//                       $idpais.= '<option value="'.$pais->id.'">'.$pais->nombre.'</option>';        
//                     } 
//                 }

//                 if ($resp['tipo_solicitud']==0) {
//                     $data = array(
//                      'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
//                                     <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
//                                       La orden de pago No.: <strong>'.$numeroOrden.'</strong> corresponde a una certificacion <strong>OFICIAL!</strong>. </strong> Ingrese una orden de pago correspondiente a una certificación <strong>PARTICULAR!</strong>.  
//                                     </div>',
//                      'case'=> 1);
//                     // 
//                     echo json_encode($data);      
                
//                 }else{

//                   $tipoDoc="";
//                   if ($resp['tipo_documento']=="DOCUMENTO PERSONAL DE IDENTIFICACIÓN") {
//                     $tipoDoc='
//                       <option value="1" selected>DOCUMENTO PERSONAL DE IDENTIFICACIÓN</option>
//                       <option value="2">PASAPORTE</option>
//                       <option value="3">VISA</option>
//                       <option value="4">TARJETA DE VISITANTE</option>
//                       <option value="5">CERTIFICACION DE NACIMIENTO</option>
//                       ';
//                   }elseif ($resp['tipo_documento']=="PASAPORTE") {
//                     $tipoDoc='
//                       <option value="1" >DOCUMENTO PERSONAL DE IDENTIFICACIÓN</option>
//                       <option value="2" selected>PASAPORTE</option>
//                       <option value="3">VISA</option>
//                       <option value="4">TARJETA DE VISITANTE</option>
//                       <option value="5">CERTIFICACION DE NACIMIENTO</option>
//                       ';
//                   }elseif ($resp['tipo_documento']=="VISA") {
//                     $tipoDoc='
//                       <option value="1" >DOCUMENTO PERSONAL DE IDENTIFICACIÓN</option>
//                       <option value="2" >PASAPORTE</option>
//                       <option value="3" selected>VISA</option>
//                       <option value="4">TARJETA DE VISITANTE</option>
//                       <option value="5">CERTIFICACION DE NACIMIENTO</option>
//                       ';
//                   }elseif ($resp['tipo_documento']=="TARJETA DE VISITANTE") {
//                     $tipoDoc='
//                       <option value="1" >DOCUMENTO PERSONAL DE IDENTIFICACIÓN</option>
//                       <option value="2" >PASAPORTE</option>
//                       <option value="3" >VISA</option>
//                       <option value="4" selected>TARJETA DE VISITANTE</option>
//                       <option value="5">CERTIFICACION DE NACIMIENTO</option>
//                       ';
//                   }elseif ($resp['tipo_documento']=="CERTIFICACION DE NACIMIENTO") {
//                     $tipoDoc='
//                       <option value="1" >DOCUMENTO PERSONAL DE IDENTIFICACIÓN</option>
//                       <option value="2" >PASAPORTE</option>
//                       <option value="3" >VISA</option>
//                       <option value="4" >TARJETA DE VISITANTE</option>
//                       <option value="5" selected>CERTIFICACION DE NACIMIENTO</option>
//                       ';
//                   }
//                   if ($resp['vuelo_proveniente']!=NULL||$resp['vuelo_proveniente']!="") {
//                     // echo $resp['fecha_deportado'];
//                     $FechaDeport=date("d-m-Y",strtotime($resp['fecha_deportado']));
//                     $depor = '
//                           <div class="deportado" id="deportado" >
//                               <div class="form-group col-xl-6 col-sm-6 col-md-6 col-md-offset-">
//                                 <label for="Fdeportacion">Fecha de Deportacion: <span class="sm">(Campo Obligatorio)</span></label>
//                                 <div class="input-group date">
//                                   <input type="text" class="form-control" value="'.$FechaDeport.'" id="FechaDeporMod" data-toggle="tooltip" data-placement="right" title="Fecha de Deportacion" data-campo="Fdeportacion" onchange="modif(this);" required readonly>
//                                   <span class="input-group-addon">
//                                     <i class="glyphicon glyphicon-calendar"></i>
//                                   </span>
//                                 </div>
//                               </div>
//                               <div class="form-group col-xl-6 col-sm-6 col-md-6">
//                                 <label for="Vproveniente">Vuelo Proveniente: <span class="sm">(Campo Obligatorio)</span></label>
//                                 <input type="text" class="form-control" value="'.$resp['vuelo_proveniente'].'" id="VprovenienteMod" placeholder="Ej. MESA, ARIZONA DE LOS ESTADOS UNIDOS DE NORTEAMERICA" data-toggle="tooltip" data-placement="right" title="Vuelo Proveniente" data-campo="Fdeportacion" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" onchange="modif(this);" required>
//                               </div>
//                           </div>
//                           <script>
//                           $(".input-group.date").datepicker({
//                               format: "dd-mm-yyyy",
//                               language: "es",
//                               autoclose: true,
//                               endDate: "1d",
//                               orientation: "top auto"
//                           });
//                           </script>';
//                   }else{
//                     $depor ='';
//                   }
                  
//                   if ($resp['negativa']!=0&&$resp['negativa']!=NULL) {
//                     $sol ='<div id="DsolicitudMod" class="form-group col-xl-12 col-sm-12 col-md-12" hidden>
//                               <label for="Dsolicitud">Datos a solicitar: <span class="sm">(Campo Obligatorio)</span></label>
//                               <input type="text" class="form-control" value="" id="txtsolicitudMod" placeholder="Ej. FAVOR ENVIAR FECHA DE NACIMIENTO..." data-toggle="tooltip" data-placement="right" title="Datos a solicitar" data-campo="Dsolicitud" style="text-transform:uppercase;" onchange="modif(this);" required>
//                             </div>';
                    
//                     switch ($resp['negativa']) {
//                       case 1:
//                         $option = '
//                                 <option value="1" selected>NEGATIVA</option>
//                                 <option value="2">NEGATIVA COMÚN</option>
//                                 <option value="3">NEGATIVA SOLICITUD DE DATOS</option>';
//                         break;
//                       case 2:
//                         $option = '
//                                 <option value="1" >NEGATIVA</option>
//                                 <option value="2" selected>NEGATIVA COMÚN</option>
//                                 <option value="3">NEGATIVA SOLICITUD DE DATOS</option>';
//                         break;
//                       case 3:
//                         $option = '
//                                 <option value="1" >NEGATIVA</option>
//                                 <option value="2" >NEGATIVA COMÚN</option>
//                                 <option value="3" selected>NEGATIVA SOLICITUD DE DATOS</option>';
//                         $sol ='
//                             <div id="DsolicitudMod" class="form-group col-xl-12 col-sm-12 col-md-12" >
//                               <label for="Dsolicitud">Datos a solicitar: <span class="sm">(Campo Obligatorio)</span></label>
//                               <input type="text" class="form-control" value="'.$resp['datosolicitar'].'" id="txtsolicitudMod" placeholder="Ej. FAVOR ENVIAR FECHA DE NACIMIENTO..." data-toggle="tooltip" data-placement="right" title="Datos a solicitar" data-campo="Dsolicitud" style="text-transform:uppercase;" onchange="modif(this);" required>
//                             </div>';
//                         break;
//                     }
//                     // $negativa='paso2';
//                     $negativa='
//                           <div id="Mfalse" class="col-xl-12 col-sm-12 col-md-12 well">
//                             <legend><span>Negativa</span></legend>
//                             <div class="form-group col-xl-12 col-sm-12 col-md-12">
//                               <label for="Negativa" >Tipo de Negativa: <span class="sm">(Campo Obligatorio)</span></label>
//                               <select id="cboNegativaMod" class="form-control" data-toggle="tooltip" data-placement="right" title="Seleccione Tipo de Negativa" onchange="modif(this);">
//                                 '.$option.'
//                               </select>
//                             </div>
//                             '.$sol.'
//                           </div>';

//                   }else if($resp['id_concepto']==9){
//                     $fecha = date('d-m-Y', strtotime($resp['fecha_ingreso']));
//                     $negativa = '
//                         <div class="form-group col-xl-6 col-sm-6 col-md-6">
//                           <label for="InFrontera">Ingreso por la Frontera: <span class="sm">(Campo Obligatorio)</span></label>
//                           <input type="text" value="'.$resp['lugar_ingreso'].'" onchange="modif(this);" class="form-control" id="InFronteraMod" data-toggle="tooltip" data-placement="right" title="Ingreso por la Frontera" data-campo="Nboleta" placeholder="Ingreso por la Frontera" style="text-transform:uppercase;" autofocus required>
//                         </div>
//                         <div class="form-group col-xl-6 col-sm-6 col-md-6">
//                           <label for="Fingreso">Fecha: <span class="sm">(Campo Obligatorio)</span></label>
//                           <div class="input-group date">
//                             <input type="text" value="'.$fecha.'" onchange="modif(this);" class="form-control" id="FingresoMod" data-toggle="tooltip" data-placement="right" title="FECHA EN QUE INGRESO" placeholder="FECHA EN QUE INGRESO" data-campo="Fingreso" required readonly>
//                             <span class="input-group-addon">
//                               <i class="glyphicon glyphicon-calendar"></i>
//                             </span>
//                           </div>
//                         </div>
//                         <div class="form-group col-xl-6 col-sm-6 col-md-6">
//                           <label for="Sdias">Dias para salir: <span class="sm">(Campo Obligatorio)</span></label>
//                           <input type="number" value="'.$resp['dias_permacer'].'" onchange="modif(this);" class="form-control" id="SdiasMod" data-toggle="tooltip" data-placement="right" title="DIAS QUE TIENE PARA SALIR" data-campo="Nboleta" placeholder="DIAS QUE TIENE PARA SALIR" onkeypress="return checkSoloNum(event)" autofocus required>
//                         </div>';

//                   }else{
//                     $negativa = '
//                         <div class="form-group col-xl-12 col-sm-12 col-md-12 col-md-offset-">
//                           <label for="NfolioMod">Numero de Folio(s): <span class="sm">(Campo Obligatorio)</span></label>
//                           <input type="number" value="'.$resp['numero_folio'].'" class="form-control" id="NfolioMod" data-toggle="tooltip" data-placement="right" title="Ingresar Numero de Folio(s) del Reporte" data-campo="Nfolio" placeholder="Numero de Folio(s) del Reporte" onkeypress="return checkSoloNum(event)" onchange="modif(this);" required>
//                         </div> ';
//                   }                     

//                 $data = array(
//                     'message' => '
//                             <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xs-offset-0 col-sm-offset-0 col-md-offset-0 col-lg-offset-0 toppad" >
//                               <div class="panel panel-danger">
//                                 <div class="panel-heading">
//                                   <h3 class="panel-title">Modificacion de Certificación con Orden de Pago No. <span id="nOrden"><strong>'.$resp['orden_pago'].'</strong></span></h3>
//                                 </div>
//                                 <div class="panel-body">
//                                     <form method="post" id="FormOrdenPago" class="col-xl-12 col-sm-12 col-md-12">
//                                       <div class="form-group col-xl-6 col-sm-6 col-md-6">
//                                         <label for="Pnombre">Primer Nombre: <span class="sm">(Campo Obligatorio)</span></label>
//                                         <input type="text" class="form-control" value="'.$resp['primer_nombre'].'" id="PnombreMod" data-toggle="tooltip" data-placement="right" title="Ingresar Primer Nombre" data-campo="Pnombre" placeholder="Primer Nombre" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" onchange="modif(this);" required autofocus>
//                                       </div>
//                                       <div class="form-group col-xl-6 col-sm-6 col-md-6">
//                                         <label for="Snombre">Segundo Nombre: </label>
//                                         <input type="text" class="form-control" value="'.$resp['segundo_nombre'].'" id="SnombreMod" placeholder="Segundo Nombre" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" onchange="modif(this);">
//                                       </div>
//                                       <div class="form-group col-xl-6 col-sm-6 col-md-6">
//                                         <label for="Papellido">Primer Apellido: <span class="sm">(Campo Obligatorio)</span></label>
//                                         <input type="text" class="form-control" value="'.$resp['primer_apellido'].'" id="PapellidoMod" data-toggle="tooltip" data-placement="right" title="Ingresar Primer Apellido" placeholder="Primer Apellido" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" onchange="modif(this);" required>
//                                       </div>
//                                       <div class="form-group col-xl-6 col-sm-6 col-md-6">
//                                         <label for="Sapellido">Segundo Apellido: </label>
//                                         <input type="text" class="form-control" value="'.$resp['segundo_apellido'].'" id="SapellidoMod" placeholder="Segundo Apellido" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" onchange="modif(this);">
//                                       </div>
//                                       <div class="form-group col-xl-6 col-sm-6 col-md-6">
//                                         <label for="Capellido">Apellido de Casada: </label>
//                                         <input type="text" class="form-control" value="'.$resp['apellido_casada'].'" id="CapellidoMod" placeholder="Apellido de Casada" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" onchange="modif(this);">
//                                       </div>
//                                       <div class="form-group col-xl-6 col-sm-6 col-md-6">
//                                         <label for="nacionalidad">Nacionalidad <span class="sm">(Campo Obligatorio)</span></label>
//                                         <select id="cboNacionalidadMod" class="form-control" data-toggle="tooltip" data-placement="right" title="Seleccione la Nacionalidad" style="text-transform:uppercase;" onchange="modif(this);">
//                                           <option value="0">Seleccionar...</option>
//                                           '.$nacional.'
//                                       </select required>
//                                       </div>
//                                       <div class="form-group col-xl-6 col-sm-6 col-md-6">
//                                         <label for="TipoDoc">Tipo de Documento: <span class="sm">(Campo Obligatorio)</span></label>
//                                         <select id="cboTipoDocMod" class="form-control" data-toggle="tooltip" data-placement="right" title="Seleccione Tipo de Documento" onchange="modif(this);">
//                                           <option value="0">Seleccionar...</option>
//                                           '.$tipoDoc.'
//                                         </select required>
//                                       </div>
//                                       <div class="form-group col-xl-6 col-sm-6 col-md-6">
//                                         <label for="NumDocMod">Numero de Documento: <span class="sm">(Campo Obligatorio)</span></label>
//                                         <input type="text" class="form-control" value="'.$resp['numero_documento'].'" id="NumDocMod" placeholder="Numero de Documento" data-toggle="tooltip" data-placement="right" title="Ingrese Numero de Documento" style="text-transform:uppercase;" onchange="modif(this);" required>
//                                       </div>
//                                       <div class="form-group col-xl-6 col-sm-6 col-md-6">
//                                         <label for="paisExtDocMod">Pais donde se extendio el Documento: <span class="sm">(Campo Obligatorio)</span></label>
//                                         <select id="cboPaisMod" class="form-control" data-toggle="tooltip" data-placement="right" title="Seleccione Pais donde se extendio el Documento" style="text-transform:uppercase;" onchange="modif(this);">
//                                           <option value="0">Seleccionar...</option>
//                                           '.$idpais.'
//                                       </select required>
//                                       </div>
//                                       <div class="form-group col-xl-6 col-sm-6 col-md-6">
//                                         <label for="LugarExtDoc">Lugar donde se extendio el Documento: <span class="sm">(Campo Obligatorio)</span></label>
//                                         <input type="text" class="form-control" value="'.$resp['lugar_documento'].'" id="LugarExtDocMod" placeholder="Lugar donde se extendio el Documento" data-toggle="tooltip" data-placement="right" title="Ingrese lugar donde se extendio el Documento" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" onchange="modif(this);" required>
//                                       </div>
//                                     '.$negativa.$depor.'
//                                     </form>
//                                 </div>
//                               </div>
//                               <div class="col-xl-12 col-sm-12 col-md-12">
//                                <div class="col-xl-3 col-sm-3 col-md-3">
//                                 <span class="pull-left">
//                                   <button type="button" id="btn_atras"  class="btn btn-default btn-lg btn-shadow" onclick="tipomod()" tabindex=1 >
//                                       <span class="glyphicon glyphicon-chevron-left"></span>
//                                       Atras
//                                   </button>
//                                 </span>
//                                </div>
//                                <div class="col-xl-6 col-sm-6 col-md-6 col-md-offset-2">
//                                  <button type="button" id="ConfirParticular"  class="btn btn-primary btn-lg btn-shadow" onclick="confirmarParticular()" tabindex=0>
//                                    <span style="font-size:1.3em;margin:0; padding:0;" class="glyphicon glyphicon-floppy-disk"> </span><br>
//                                    GUARDAR
//                                  </button> 
//                                </div>
//                               </div>
//                             </div>
//                             <script>
//                             $(".input-group.date").datepicker({
//                                 format: "dd-mm-yyyy",
//                                 language: "es",
//                                 autoclose: true,
//                                 endDate: "1d",
//                                 orientation: "top auto"
//                             });
//                             $( document ).ready(function() {                            
//                               $("html, body").animate({ scrollTop: 238 }, 1000);
//                               cargarData();
//                               $("#cboNegativaMod").change(function() {
//                                 var negativa = $(this).val();
//                                 if(negativa == 3)
//                                 {
//                                   $( "#DsolicitudMod" ).fadeIn("slow");
//                                   $( "#txtsolicitudMod" ).focus();
//                                 }else{
//                                   $( "#DsolicitudMod" ).fadeOut("slow");
//                                 }

//                               });
//                             });
//                             </script>
//                     ',
//                     'case' => 3 );
//                   //
//                   echo json_encode($data);
//                 }    
//             }

//         }else{

//             $data = array(
//                  'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
//                                 <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
//                                   La orden de pago No.: <strong>'.$numeroOrden.' NO existe!. </strong> Desea generar una orden de pago.  <a href="?ac=ordenpago" class="btn btn-info btn-shadow" role="button">
//                                     <span class="glyphicon glyphicon-th-list"></span>
//                                     Generar Orden de Pago
//                                   </a>
//                                 </div>',
//                  'case'=> 1);
//             // 
//             echo json_encode($data);

//         }

//     }
//   }else{
//       echo "Error en los datos";
//   }

// }

// function guardarModParticular()
// {
//     $ordenN = $_POST['Norden'];                                  
//     $sql = "SELECT id_concepto, id_pais, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, apellido_casada, 
//             nacionalidad, tipo_documento, numero_documento, lugar_documento, resolucion, boleta_banco, numero_folio, fecha_certificacion,
//             tipo_solicitud, lugar_ingreso, fecha_ingreso, dias_permacer, fecha_deportado, vuelo_proveniente, asunto, folio_entrada, negativa, datosolicitar FROM datosgenerales WHERE orden_pago=".$ordenN;
    
//     $db = obtenerConexion();
//     $orden = ejecutarQuery($db, $sql);
//     $datosOrdenP = $orden->fetch_assoc();  


//     $SQLmod='INSERT INTO modificaciones(orden_pago, id_pais, id_paisanterior, primer_nombre, pnombre_anterior, 
//           segundo_nombre, snombre_anterior, primer_apellido, papellido_anterior, segundo_apellido, sapellido_anterior,
//           apellido_casada, acasada_anterior, nacionalidad, nacionalidad_anterior, tipo_documento, tdocumento_anterior,
//           numero_documento, numdocumento_anterior, lugar_documento, lugardocumento_anterior, lugar_ingreso, lugar_ingresoanterior,
//           fecha_ingreso, fecha_ingresoanterior, dias_permanecer, dias_permaneceranterior,id_concepto, id_conceptoanterior, 
//           menor_edad, menoredad_anterior, numero_folio, numerofolio_anterior, fecha_impresion, boleta_banco, fecha_deportado, 
//           fechadeportado_anterior, vuelo_proveniente, vueloproveniente_anterior, usuario_genera, ip_local, asunto, 
//           asunto_anterior, folio_entrada, folioentrada_anterior, negativa, negativa_anterior, datosolicitar, 
//           datosolicitar_anterior) VALUES ('.$ordenN.',';

  

//     $SQLini = "UPDATE datosgenerales SET ";
//     $SQLupd = '';
  
//     // $Pnombre = $_POST['Pnombre'];

//     if(!empty($_POST['cboPais'])){
//         $cboPais = $_POST['cboPais'];
//         $cboPaisANT =$_POST['cboPaisANT'];
//         $SQLmod.='"'.$cboPais.'", "'.$cboPaisANT.'",';
//         $SQLupd.='id_pais="'.$cboPais.'"'; 
//     }else{
//         $SQLmod.='"'.$datosOrdenP['id_pais'].'", "'.$datosOrdenP['id_pais'].'",';
//     }

//     if(!empty($_POST['Pnombre'])){
//         $Pnombre =$_POST['Pnombre'];
//         $PnombreANT =$_POST['PnombreANT'];
//         $SQLmod.='"'.$Pnombre.'", "'.$PnombreANT.'",';
//         if ($SQLupd!="") {
//           $SQLupd.=',primer_nombre="'.$Pnombre.'"';
//         }else{
//           $SQLupd.='primer_nombre="'.$Pnombre.'"';
//         }
//     }else{
//         $SQLmod.='"'.$datosOrdenP['primer_nombre'].'", "'.$datosOrdenP['primer_nombre'].'",';
//     }

//     if(!empty($_POST['Snombre'])){
//         $Snombre =$_POST['Snombre'];
//         $SnombreANT =$_POST['SnombreANT'];
//         $SQLmod.='"'.$Snombre.'", "'.$SnombreANT.'",';
//         if ($SQLupd!="") {
//           $SQLupd.=', segundo_nombre="'.$Snombre.'"';
//         }else{
//           $SQLupd.=' segundo_nombre="'.$Snombre.'"';
//         }
//     }else{
//       if(isset($_POST['Snombre'])){
//         if ($SQLupd!="") {
//           $SQLupd.=', segundo_nombre="'.$_POST['Snombre'].'"';
//         }else{
//           $SQLupd.=' segundo_nombre="'.$_POST['Snombre'].'"';
//         }
//       }

//         $SQLmod.='"'.$datosOrdenP['segundo_nombre'].'", "'.$datosOrdenP['segundo_nombre'].'",';
//     }

//     if(!empty($_POST['Papellido'])){
//         $Papellido =$_POST['Papellido'];
//         $PapellidoANT =$_POST['PapellidoANT'];
//         $SQLmod.='"'.$Papellido.'", "'.$PapellidoANT.'",';

//         if ($SQLupd!="") {
//           $SQLupd.=',primer_apellido="'.$Papellido.'"';
//         }else{
//           $SQLupd.='primer_apellido="'.$Papellido.'"';
//         }
//     }else{
//         $SQLmod.='"'.$datosOrdenP['primer_apellido'].'", "'.$datosOrdenP['primer_apellido'].'",';
//     }

//     if(!empty($_POST['Sapellido'])){
//         $Sapellido = $_POST['Sapellido'];
//         $SapellidoANT =$_POST['SapellidoANT'];
//         $SQLmod.='"'.$Sapellido.'", "'.$SapellidoANT.'",';

//         if ($SQLupd!="") {
//           $SQLupd.=',segundo_apellido="'.$Sapellido.'"';
//         }else{
//           $SQLupd.=' segundo_apellido="'.$Sapellido.'"';
//         }
//     }else{
//         if(isset($_POST['Sapellido'])){
//           if ($SQLupd!="") {
//             $SQLupd.=',segundo_apellido="'.$_POST['Sapellido'].'"';
//           }else{
//             $SQLupd.=' segundo_apellido="'.$_POST['Sapellido'].'"';
//           }
//         }

//         $SQLmod.='"'.$datosOrdenP['segundo_apellido'].'", "'.$datosOrdenP['segundo_apellido'].'",';
//     }

//     if(!empty($_POST['Capellido'])){
//         $Capellido = $_POST['Capellido'];
//         $CapellidoANT =$_POST['CapellidoANT'];
//         $SQLmod.='"'.$Capellido.'", "'.$CapellidoANT.'",';

//         if ($SQLupd!="") {
//           $SQLupd.=',apellido_casada="'.$Capellido.'"';
//         }else{
//           $SQLupd.=' apellido_casada="'.$Capellido.'"';
//         }
//     }else{
//         if(isset($_POST['Capellido'])){
//           if ($SQLupd!="") {
//             $SQLupd.=',apellido_casada="'.$_POST['Capellido'].'"';
//           }else{
//             $SQLupd.=' apellido_casada="'.$_POST['Capellido'].'"';
//           }
//         }
//         $SQLmod.='"'.$datosOrdenP['apellido_casada'].'", "'.$datosOrdenP['apellido_casada'].'",';
//     }

//     if(!empty($_POST['cboNacionalidad'])){
//         $cboNacionalidad = $_POST['cboNacionalidad'];
//         $cboNacionalidadANT =$_POST['cboNacionalidadANT'];
//         $SQLmod.='"'.$cboNacionalidad.'", "'.$cboNacionalidadANT.'",';

//         if ($SQLupd!="") {
//           $SQLupd.=', nacionalidad="'.$cboNacionalidad.'"';
//         }else{
//           $SQLupd.=' nacionalidad="'.$cboNacionalidad.'"';
//         }

//     }else{
//         $SQLmod.='"'.$datosOrdenP['nacionalidad'].'", "'.$datosOrdenP['nacionalidad'].'",';
//     }

//     if(!empty($_POST['cboTipoDoc'])){
        
//         switch ($_POST['cboTipoDoc']) {
//           case 1:
//            $cboTipoDoc = 'DOCUMENTO PERSONAL DE IDENTIFICACIÓN';
//             break;
//           case 2:
//            $cboTipoDoc = 'PASAPORTE';
//             break;
//           case 3:
//            $cboTipoDoc = 'VISA';
//             break;
//           case 4:
//            $cboTipoDoc = 'TARJETA DE VISITANTE';
//             break;
//           case 5:
//            $cboTipoDoc = 'CERTIFICACION DE NACIMIENTO';
//             break;
          
//         }
//         $cboTipoDocANT =$_POST['cboTipoDocANT'];
//         $SQLmod.='"'.$cboTipoDoc.'", "'.$cboTipoDocANT.'",';

//         if ($SQLupd!="") {
//           $SQLupd.=',tipo_documento="'.$cboTipoDoc.'"';
//         }else{
//           $SQLupd.=' tipo_documento="'.$cboTipoDoc.'"';
//         }
//     }else{
//         $SQLmod.='"'.$datosOrdenP['tipo_documento'].'", "'.$datosOrdenP['tipo_documento'].'",';
//     }

//     if(!empty($_POST['NumDoc'])){
//         $NumDoc = $_POST['NumDoc'];
//         $NumDocANT =$_POST['NumDocANT'];
//         $SQLmod.='"'.$NumDoc.'", "'.$NumDocANT.'",';

//         if ($SQLupd!="") {
//           $SQLupd.=',numero_documento="'.$NumDoc.'"';
//         }else{
//           $SQLupd.=' numero_documento="'.$NumDoc.'"';
//         }
//     }else{
//         $SQLmod.='"'.$datosOrdenP['numero_documento'].'", "'.$datosOrdenP['numero_documento'].'",';
//     }

//     if(!empty($_POST['LugarExtDoc'])){
//         $LugarExtDoc = $_POST['LugarExtDoc'];
//         $LugarExtDocANT =$_POST['LugarExtDocANT'];
//         $SQLmod.='"'.$LugarExtDoc.'", "'.$LugarExtDocANT.'",';

//         if ($SQLupd!="") {
//           $SQLupd.=',lugar_documento="'.$LugarExtDoc.'"';
//         }else{
//           $SQLupd.=' lugar_documento="'.$LugarExtDoc.'"';
//         }
//     }else{
//         $SQLmod.='"'.$datosOrdenP['lugar_documento'].'", "'.$datosOrdenP['lugar_documento'].'",';
//     }

//     if(!empty($_POST['InFrontera'])){
//         $InFrontera = $_POST['InFrontera'];
//         $InFronteraANT =$_POST['InFronteraANT'];
//         $SQLmod.='"'.$InFrontera.'", "'.$InFronteraANT.'",';

//         if ($SQLupd!="") {
//           $SQLupd.=',lugar_ingreso="'.$InFrontera.'"';
//         }else{
//           $SQLupd.=' lugar_ingreso="'.$InFrontera.'"';
//         }
//     }else{
//         $SQLmod.='"'.$datosOrdenP['lugar_ingreso'].'", "'.$datosOrdenP['lugar_ingreso'].'",';
//     }

//     if(!empty($_POST['Fingreso'])){
//         $Fingreso = date('Y-m-d', strtotime($_POST['Fingreso']));
//         $FingresoANT =date('Y-m-d', strtotime($_POST['FingresoANT']));
//         $SQLmod.='"'.$Fingreso.'", "'.$FingresoANT.'",';

//         if ($SQLupd!="") {
//           $SQLupd.=',fecha_ingreso="'.$Fingreso.'"';
//         }else{
//           $SQLupd.=' fecha_ingreso="'.$Fingreso.'"';
//         }
//     }else{
//         $SQLmod.='"'.$datosOrdenP['fecha_ingreso'].'", "'.$datosOrdenP['fecha_ingreso'].'",';
//     }

//     if(!empty($_POST['Sdias'])){
//         $Sdias = $_POST['Sdias'];
//         $SdiasANT =$_POST['SdiasANT'];
//         $SQLmod.='"'.$Sdias.'", "'.$SdiasANT.'",';

//         if ($SQLupd!="") {
//           $SQLupd.=', dias_permacer="'.$Sdias.'"';
//         }else{
//           $SQLupd.=' dias_permacer="'.$Sdias.'"';
//         }
//     }else{
//         $SQLmod.='"'.$datosOrdenP['dias_permanecer'].'", "'.$datosOrdenP['dias_permanecer'].'",';
//     }


//     $SQLmod.=$datosOrdenP['id_concepto'].', '.$datosOrdenP['id_concepto'].',';
//     $SQLmod.='0, 0,';

//     if(!empty($_POST['Nfolio'])){
//         $Nfolio = $_POST['Nfolio'];
//         $NfolioANT =$_POST['NfolioANT'];
//         $SQLmod.=$Nfolio.', '.$NfolioANT.',';

//         if ($SQLupd!="") {
//           $SQLupd.=',numero_folio='.$Nfolio.'';
//         }else{
//           $SQLupd.=' numero_folio='.$Nfolio.'';
//         }
//     }else{
//         $Nfolio ="";
//         $SQLmod.=$datosOrdenP['numero_folio'].', '.$datosOrdenP['numero_folio'].',';
//     }
    
//     $hoy = date("Y-m-d H:i:s");
//     $SQLmod.='"'.$hoy.'","'.$datosOrdenP['boleta_banco'].'",';
//     // $SQLmod.='"'.$datosOrdenP['fecha_certificacion'].'","'.$datosOrdenP['boleta_banco'].'",';

//     if(!empty($_POST['FechaDepor'])){
//         $FechaDeport=date("Y-m-d",strtotime($_POST['FechaDepor']));
//         $FechaDeportANT=date("Y-m-d",strtotime($_POST['FechaDeporANT']));
//         // $FechaDepor = $_POST['FechaDepor'];
//         // $FechaDeporANT =$_POST['FechaDeporANT'];
//         $SQLmod.='"'.$FechaDeport.'", "'.$FechaDeportANT.'",';

//         if ($SQLupd!="") {
//           $SQLupd.=',fecha_deportado="'.$FechaDeport.'"';
//         }else{
//           $SQLupd.=' fecha_deportado="'.$FechaDeport.'"';
//         }
//     }else{
//         $FechaDepor ="";
//         $SQLmod.='"'.$datosOrdenP['fecha_deportado'].'", "'.$datosOrdenP['fecha_deportado'].'",';
//     }

//     if(!empty($_POST['Vproveniente'])){
//         $Vproveniente = $_POST['Vproveniente'];
//         $VprovenienteANT =$_POST['VprovenienteANT'];
//         $SQLmod.='"'.$Vproveniente.'", "'.$VprovenienteANT.'",';

//         if ($SQLupd!="") {
//           $SQLupd.=',vuelo_proveniente="'.$Vproveniente.'"';
//         }else{
//           $SQLupd.=' vuelo_proveniente="'.$Vproveniente.'"';
//         }

//     }else{
//         $Vproveniente ="";
//         $SQLmod.='"'.$datosOrdenP['vuelo_proveniente'].'", "'.$datosOrdenP['vuelo_proveniente'].'",';
//     }

//     $user = $_SESSION['id'];
//     $IP = getIP();
//     $SQLmod.=$user.',"'.$IP.'",';

//     if(!empty($_POST['asunto'])){
//         $asunto = $_POST['asunto'];
//         $asuntoANT =$_POST['asuntoANT'];
//         $SQLmod.='"'.$asunto.'", "'.$asuntoANT.'",';

//         if ($SQLupd!="") {
//           $SQLupd.=',asunto="'.$asunto.'"';
//         }else{
//           $SQLupd.=' asunto="'.$asunto.'"';
//         }
//     }else{
//         if ($datosOrdenP['asunto']!=NULL) {
//           $SQLmod.='"'.$datosOrdenP['asunto'].'", "'.$datosOrdenP['asunto'].'",';
//         }else{
//           $SQLmod.='"", "",';

//         }
//     }

//     if(!empty($_POST['NfolioEntrada'])){
//         $NfolioEntrada = $_POST['NfolioEntrada'];
//         $NfolioEntradaANT =$_POST['NfolioEntradaANT'];
//         $SQLmod.=$NfolioEntrada.', '.$NfolioEntradaANT.', ';

//         if ($SQLupd!="") {
//           $SQLupd.=',folio_entrada='.$NfolioEntrada.'';
//         }else{
//           $SQLupd.=' folio_entrada='.$NfolioEntrada.'';
//         }
//     }else{

//         if ($datosOrdenP['folio_entrada']!=NULL) {
//           $SQLmod.=$datosOrdenP['folio_entrada'].', '.$datosOrdenP['folio_entrada'].'';
//         }else{
//           $SQLmod.='0, 0,';
//         }
//     }

//     if(!empty($_POST['cboNegativa'])){
//       $cboNegativ = $_POST['cboNegativa'];
//       $cboNegativANT =$_POST['cboNegativaANT'];
//       $SQLmod.=$cboNegativ.', '.$cboNegativANT.',';

//       if ($SQLupd!="") {
//         $SQLupd.=', negativa='.$cboNegativ.'';
//       }else{
//         $SQLupd.=' negativa='.$cboNegativ.'';
//       }
//     }else{
//       if ($datosOrdenP['negativa']!=NULL||$datosOrdenP['negativa']!=0) {
//         $SQLmod.=$datosOrdenP['negativa'].', '.$datosOrdenP['negativa'].',';
//       }else{
//         $SQLmod.='0, 0,';
//       }        
//     }

//     if(!empty($_POST['txtsolicitud'])){
//       $txtsolicitud = $_POST['txtsolicitud'];
//       $txtsolicitudANT =$_POST['txtsolicitudANT'];
//       $SQLmod.='"'.$txtsolicitud.'", "'.$txtsolicitudANT.'"';

//       if ($SQLupd!="") {
//         $SQLupd.=', datosolicitar="'.$txtsolicitud.'"';
//       }else{
//         $SQLupd.=' datosolicitar="'.$txtsolicitud.'"';
//       }
//     }else{
//       if ($_POST['cboNegativa']==3&&$datosOrdenP['datosolicitar']!=NULL||$datosOrdenP['datosolicitar']!='') {
//         $SQLmod.='"'.$datosOrdenP['datosolicitar'].'", "'.$datosOrdenP['datosolicitar'].'"';
//       }else{
//         $SQLmod.="'',''";
//       }        
//     }

//     $SQLmod.=')';
//     // $hoy = date("Y-m-d H:i:s");
//     // $SQLini.=$SQLupd.', fecha_certificacion ="'.$hoy.'"  WHERE orden_pago='.$ordenN;
//     $SQLini.=$SQLupd.' WHERE orden_pago='.$ordenN;
//     // echo $SQLmod;
//     $db = obtenerConexion();
//     $db->autocommit(FALSE);
//     $db = obtenerConexion();
//     $result = ejecutarQuery($db, $SQLmod);
    
//       // echo $SQLini;
//     if ($result) {
      
//       // $db = obtenerConexion();
//       $result2 = ejecutarQuery($db, $SQLini);

//       if ($result2) {
//           $db->commit();
//         // echo "correcto";
//           $sqlN = "SELECT primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, apellido_casada, boleta_banco, numero_folio, 
//             fecha_certificacion, fecha_deportado, vuelo_proveniente, asunto, folio_entrada, negativa, datosolicitar FROM datosgenerales WHERE orden_pago=".$ordenN;
//           $db = obtenerConexion();
//           $ordenNE = ejecutarQuery($db, $sqlN);
//           $datosNE = $ordenNE->fetch_assoc(); 

//           // $FechaDeport=date("Y-m-d",strtotime($datosNE['fecha_deportado']));
//           // $fechaLetras = fechaALetras(date('d/m/Y'));
//           $fechaLetras = fechaALetras(date('d/m/Y',strtotime($datosNE['fecha_certificacion'])));
//           $fechaL = fechaL(date('Y-m-d',strtotime($datosNE['fecha_certificacion'])));
//           // $fechaL = fechaL(date('Y-m-d'));
//           // echo $datosNE['id_concepto'];

//           if ($datosOrdenP['id_concepto']==9) {
//               $sql2 = "INSERT INTO impresiones (orden_pago, id_firma, fecha_reimpresion, motivo_reimpresion, boleta_banco, id_concepto, 
//                       tipo_solicitud, usuario_genera, ip_local) 
//                       VALUES (".$ordenN.", 1, '".$hoy."', 'MODIFICACION DE DATOS', '".$datosOrdenP['boleta_banco']."', ".$datosOrdenP['id_concepto'].", 1, '".$user."', '".$IP."')";
//               $db = obtenerConexion();
//               $result = ejecutarQuery($db, $sql2);
//               $tipo = "PARTICULAR ESTATUS";
//               $QR = getQR($ordenN, $user, $IP, $tipo);

//               $sql = "SELECT dg.orden_pago, dg.id_concepto, dg.nacionalidad , ps.nacionalidad_pais, dg.primer_nombre, dg.segundo_nombre, dg.primer_apellido, dg.segundo_apellido, 
//                       dg.apellido_casada, dg.tipo_documento, dg.numero_documento, dg.lugar_ingreso, dg.fecha_ingreso, dg.dias_permacer
//                        FROM datosgenerales dg, paises ps WHERE dg.nacionalidad=ps.id_pais AND orden_pago=".$ordenN;
//               $orden = ejecutarQuery($db, $sql);
//               $resp = $orden->fetch_assoc();
//               $fechaL = fechaL(date('Y-m-d',strtotime($resp['fecha_ingreso'])));
//               $printEstatus="nombre=".$resp["primer_nombre"]." ".$resp["segundo_nombre"]." ".$resp["primer_apellido"]
//                               ." ".$resp["segundo_apellido"]." ".$resp["apellido_casada"]."&documento="
//                               .$resp["tipo_documento"]."&numeroDoc=".$resp["numero_documento"]."&nacionalidad="
//                               .$resp["nacionalidad_pais"]."&lugar=".$resp["lugar_ingreso"]."&fechaIngreso=".$fechaL
//                               ."&dias=".$resp["dias_permacer"]."&fecha=".$fechaLetras."&QR=".$QR;
            
//               $data = array(
//              'message'=> $printEstatus,
//              'case'=> 6);
//               echo json_encode($data);

//           }else{
//             if ($datosNE['negativa']!=0&&$datosNE['negativa']!=NULL) {
//               # Negativa...
//               if (!empty($datosNE['Vproveniente'])&&!empty($datosNE['FechaDepor'])) {
//                   // Negativa Deportado
//                   $sql2 = "INSERT INTO impresiones (orden_pago, id_firma, fecha_reimpresion, motivo_reimpresion, boleta_banco, id_concepto, 
//                   tipo_solicitud, usuario_genera, ip_local) 
//                   VALUES (".$ordenN.", 1, '".$hoy."', 'MODIFICACION DE DATOS', '".$datosNE['boleta_banco']."', 2, 1, '".$user."', '".$IP."')";
//                   $db = obtenerConexion();
//                   $result = ejecutarQuery($db, $sql2);
//                   $tipo = "PARTICULAR DEPORTADO";
//                   $QR = getQR($ordenN, $user, $IP, $tipo);

//                   $printDeportado="nombre=".$datosNE["primer_nombre"]." ".$datosNE["segundo_nombre"]." ".$datosNE["primer_apellido"]." ".$datosNE["segundo_apellido"]." ".$datosNE["apellido_casada"]."&fechaDeportado=".FechaL($datosNE["fecha_deportado"])."&Vproveniente=".$datosNE["vuelo_proveniente"]."&Nfolio=".$datosNE["numero_folio"]."&fecha=".$fechaLetras."&QR=".$QR."&Movimiento=NO";
//                   $printNegativa = "nombre=".$datosNE["primer_nombre"]." ".$datosNE["segundo_nombre"]." ".$datosNE["primer_apellido"]." ".$datosNE["segundo_apellido"]." ".$datosNE["apellido_casada"]."&fecha=".$fechaL;
                  
//                   if ($datosNE["negativa"]==3) {
//                    $printNegativa .= "&datosolicitar=".$datosNE["datosolicitar"];
//                   }

//                   $data = array(
//                    'message'=> $printDeportado,
//                    'tipoCertificacion'=> 1,
//                    'tipoNegativa'=> $datosNE["negativa"],
//                    'negativaDatos'=> $printNegativa,
//                    'case'=> 5);
                  
//                   echo json_encode($data);


//               }
//               else{

//                   $sql2 = "INSERT INTO impresiones (orden_pago, id_firma, fecha_reimpresion, motivo_reimpresion, boleta_banco, id_concepto, 
//                     tipo_solicitud, usuario_genera, ip_local) 
//                     VALUES (".$ordenN.", 1, '".$hoy."', 'MODIFICACION DE DATOS', '".$datosNE['boleta_banco']."', 2, 1, '".$user."', '".$IP."')";
//                   $db = obtenerConexion();
//                   $result = ejecutarQuery($db, $sql2);
//                   $tipo = "PARTICULAR";
//                   $QR = getQR($ordenN, $user, $IP, $tipo);

//                   $printParticular="nombre=".$datosNE["primer_nombre"]." ".$datosNE["segundo_nombre"]." ".$datosNE["primer_apellido"]." ".$datosNE["segundo_apellido"]." ".$datosNE["apellido_casada"]."&Nfolio=".$datosNE["numero_folio"]."&fecha=".$fechaLetras."&QR=".$QR."&Movimiento=NO";
//                   // $printDeportado="nombre=".$datosNE["primer_nombre"]." ".$datosNE["segundo_nombre"]." ".$datosNE["primer_apellido"]." ".$datosNE["segundo_apellido"]." ".$datosNE["apellido_casada"]."&fechaDeportado=".FechaL($datosNE["fecha_deportado"])."&Vproveniente=".$datosNE["vuelo_proveniente"]."&Nfolio=".$datosNE["numero_folio"]."&fecha=".$fechaLetras."&QR=".$QR."&Movimiento=NO";
//                   $printNegativa = "nombre=".$datosNE["primer_nombre"]." ".$datosNE["segundo_nombre"]." ".$datosNE["primer_apellido"]." ".$datosNE["segundo_apellido"]." ".$datosNE["apellido_casada"]."&fecha=".$fechaL;
                  
//                   if ($datosNE["negativa"]==3) {
//                    $printNegativa .= "&datosolicitar=".$datosNE["datosolicitar"];
//                   }

//                   $data = array(
//                    'message'=> $printParticular,
//                    'tipoCertificacion'=> 0,
//                    'tipoNegativa'=> $datosNE["negativa"],
//                    'negativaDatos'=> $printNegativa,
//                    'case'=> 5);
                  
//                   echo json_encode($data);
             
//               }

//             }else{
//               # Con Movimiento Migratorio
//               if (!empty($datosNE["vuelo_proveniente"])&&!empty($datosNE["fecha_deportado"])) {
//                 //Deportado
//                 $sql2 = "INSERT INTO impresiones (orden_pago, id_firma, fecha_reimpresion, motivo_reimpresion, boleta_banco, id_concepto, 
//                   tipo_solicitud, usuario_genera, ip_local) VALUES (".$ordenN.", 1, '".$hoy."', 'MODIFICACION DE DATOS', 
//                   '".$datosNE['boleta_banco']."', 2, 1, '".$user."', '".$IP."')";
//                 $db = obtenerConexion();
//                 $result = ejecutarQuery($db, $sql2);
//                 $tipo = "PARTICULAR DEPORTADO";
//                 $QR = getQR($ordenN, $user, $IP, $tipo);
             
                
//                 $printDeportado="nombre=".$datosNE["primer_nombre"]." ".$datosNE["segundo_nombre"]." ".$datosNE["primer_apellido"]." ".$datosNE["segundo_apellido"]." ".$datosNE["apellido_casada"]."&fechaDeportado=".FechaL($datosNE["fecha_deportado"])."&Vproveniente=".$datosNE["vuelo_proveniente"]."&Nfolio=".$datosNE["numero_folio"]."&fecha=".$fechaLetras."&QR=".$QR;
                
//                 $data = array(
//                'message'=> $printDeportado,
//                'case'=> 1);
//                 // 
//                 echo json_encode($data);
//               }
//               else{
//                 // $sql.= " WHERE orden_pago=".$numeroOrden;
//                 // $db = obtenerConexion();
//                 // $impresion = ejecutarQuery($db, $sql);
//                 //$fechaLetras = fechaALetras(date('d/m/Y'));
           
//                 $sql2 = "INSERT INTO impresiones (orden_pago, id_firma, fecha_reimpresion, motivo_reimpresion, boleta_banco, id_concepto, 
//                   tipo_solicitud, usuario_genera, ip_local) 
//                   VALUES (".$ordenN.", 1, '".$hoy."', 'MODIFICACION DE DATOS', '".$datosNE['boleta_banco']."', 2, 1, '".$user."', '".$IP."')";
//                 $db = obtenerConexion();
//                 $result = ejecutarQuery($db, $sql2);
//                 $tipo = "PARTICULAR";
//                 $QR = getQR($numeroOrden, $user, $IP, $tipo);
                
//                 $printParticular="nombre=".$datosNE["primer_nombre"]." ".$datosNE["segundo_nombre"]." ".$datosNE["primer_apellido"]." ".$datosNE["segundo_apellido"]." ".$datosNE["apellido_casada"]."&Nfolio=".$datosNE["numero_folio"]."&fecha=".$fechaLetras."&QR=".$QR;
                
//                 $data = array(
//                'message'=> $printParticular,
//                'case'=> 2);
//                 // 
//                 echo json_encode($data);
         
//               }
            
//             }
//           }

//       }else{
//         $db->rollback();
//         $data = array(
//        'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
//                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
//                         Error al realizar la transaccion
//                       </div>',
//        'case'=> 3);
//         // 
//         echo json_encode($data);
//         // echo "Error al ejecutar query UPD";
//       }
//     }else{
//       $db->rollback();
//       $data = array(
//      'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
//                     <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
//                       Error al realizar la transaccion 1
//                     </div>',
//      'case'=> 3);
//       // 
//       echo json_encode($data);
//         // echo "Error al ejecutar query Mod";
//     }

// }

// function modOficialDatos()
// {
//   $NfolioEntrada = $_POST['NfolioEntrada'];
//   $sql = "SELECT orden_pago, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, apellido_casada, numero_folio, 
//   asunto, folio_entrada, negativa, datosolicitar, variasPersonas FROM datosgenerales WHERE folio_entrada='".$NfolioEntrada."'";
//   $db = obtenerConexion();
//   $orden = ejecutarQuery($db, $sql);
//   $resp = $orden->fetch_assoc();
//   //echo $;
//   if ($resp['folio_entrada']==NULL||$resp['folio_entrada']=="") {
//     $data = array(
//            'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
//               <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
//                 El folio de entrada No.: <strong>'.$NfolioEntrada.'</strong> no se encuentra registrado a ninguna Certificación <strong>Oficial</strong>',
//            'case'=> 1);
//     // 
//     echo json_encode($data);
    
//   }else{
//     $asuntos = obtenerAsunto();
//     $DatosAsunto='';
//     foreach ($asuntos as $asunto) {
//       if ($asunto->id==$resp['asunto']) {
//         $DatosAsunto.= '<option value="'.$asunto->id.'" title="Cargo:'.$asunto->cargo.'||Asunto:'.$asunto->asunto.'||Dependencia:'.$asunto->dependencia.'" selected>'.$asunto->nombre.'</option>';        
//       }else{
//         $DatosAsunto.= '<option value="'.$asunto->id.'" title="Cargo:'.$asunto->cargo.'||Asunto:'.$asunto->asunto.'||Dependencia:'.$asunto->dependencia.'">'.$asunto->nombre.'</option>';        
//       }
//     }


//     if ($resp['variasPersonas']!=NULL||$resp['variasPersonas']!=0) {
//       # VARIAS PERSONAS
//       $fila="";
//       $db = obtenerConexion();
//       $sql = "SELECT primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, 
//                   apellido_casada, negativa, datosolicitar FROM persona WHERE datogeneral=".$resp['orden_pago'];

//       $resultDat = ejecutarQuery($db, $sql);
//       $cantidad=1;
//       while($row = $resultDat->fetch_assoc()){
        
//         if ($row['negativa']==0) {
//           $DatMob= '<a class="btn btn-primary checkSI active" style="font-weight: bold;padding: 6px 15px;">
//                       <input id="checkSI" num=""  type="radio" name="chekMovimiento" value="SI" >SI
//                     </a>';
//         }else{
//           $DatMob= '<a class="btn btn-primary checkNO active" style="font-weight: bold;" onclick="checkMov(checkNO)">
//                       <input id="checkNO" num=""  type="radio" name="chekMovimiento" value="NO">NO
//                   </a>';
//         }
          
//         $fila.='
//               <tr id="fila'.$cantidad.'" name="fila" class="cont">
//                 <td class="col-xl-2 col-sm-2 col-md-2" style="padding-left: 0px; padding-right: 0px;width: 46px;">
//                   <span  class="close" id="1" style="font-size:28px;float: left;padding: 0;" >'.$cantidad.'</span>
//                 </td>
//                 <td class="col-xl-2 col-sm-2 col-md-2" style="padding-right: 0px;">
//                   <input onchange="modif(this);" type="text" name="Pnombre" value="'.$row['primer_nombre'].'" class="form-control Pnombre" style="text-transform:uppercase;" id="Pnombre'.$cantidad.'" data-toggle="tooltip" data-placement="left" title="Ingresar Primer Nombre" data-campo="Pnombre" placeholder="Primer Nombre"  onkeypress="return validarLetras(event)" required autofocus>
//                 </td>
//                 <td class="col-xl-2 col-sm-2 col-md-2" style="padding-right: 0;">
//                   <input onchange="modif(this);" type="text" name="Snombre" value="'.$row['segundo_nombre'].'" class="form-control" id="Snombre'.$cantidad.'" placeholder="Segundo Nombre" style="text-transform:uppercase;" onkeypress="return validarLetras(event)">
//                 </td>
//                 <td class="col-xl-2 col-sm-2 col-md-2" style="padding-right: 0;">
//                   <input onchange="modif(this);" type="text" name="Papellido" value="'.$row['primer_apellido'].'" class="form-control Papellido" id="Papellido'.$cantidad.'" data-toggle="tooltip" data-placement="left" title="Ingresar Primer Apellido" placeholder="Primer Apellido" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" required>
//                 </td>
//                 <td class="col-xl-2 col-sm-2 col-md-2" style="padding-right: 0;">
//                   <input onchange="modif(this);" type="text" name="Sapellido" value="'.$row['segundo_apellido'].'" class="form-control" id="Sapellido'.$cantidad.'" placeholder="Segundo Apellido" style="text-transform:uppercase;" onkeypress="return validarLetras(event)">
//                 </td>
//                 <td class="col-xl-2 col-sm-2 col-md-2" style="padding-right: 0;">
//                   <input onchange="modif(this);" type="text" name="Capellido" value="'.$row['apellido_casada'].'" class="form-control" id="Capellido'.$cantidad.'" placeholder="Apellido de Casada" style="text-transform:uppercase;" onkeypress="return validarLetras(event)">
//                 </td>
//                 <td class="col-xl-1 col-sm-1 col-md-1" style="padding-right: 0;">
//                   <div class="col-xl-12 col-sm-12 col-md-12" style="padding-right: 0;padding-left: 0;width: 102px;">
//                     <div id="chekMovimiento" name="chekMovimiento" class="btn-group chekMovimiento" data-toggle="buttons" style="padding-left:0;padding-right:0;margin-right: -1em;" data-toggle="tooltip" data-placement="bottom" title="Tiene Movimiento Migratorio" data-campo="chekMovimiento">
//                       '.$DatMob.'
//                     </div>
//                   </div>
                  
//                 </td>
//               </tr>';
//         $cantidad++;
//       }

//     $data = array(
//       'message' => '
//               <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 toppad" >
//                 <div class="panel panel-danger">
//                   <div class="panel-heading">
//                     <h3 class="panel-title">Modificacion de Certificación con Folio de Entrada No. <span id="NfolioEntradaMod"><strong>'.$resp['folio_entrada'].'</strong></span></h3>
//                   </div>
//                   <div class="panel-body">
//                     <div class="row">             
//                       <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
//                         <div class="form-horizontal">
//                           <div class="form-group col-xl-12 col-sm-12 col-md-12">
//                             <label for="Asunto">Asunto: <span class="sm">(Campo Obligatorio)</span></label>
//                               <select id="cboAsuntoMod"  num="" class="form-control" data-toggle="tooltip" data-placement="top" title="Seleccione Asunto de la Certificación" data-campo="Asunto" onchange="modif(this);">
//                                 '.$DatosAsunto.'
//                               </select>
//                           </div>
//                           <table id="tabla" class="table table-hover table-fixed col-xl-12 col-sm-12 col-md-12">
//                             <thead>
//                               <tr>
//                                 <th class="col-xl-1 col-sm-1 col-md-1" style="padding-left: 0px; padding-right: 0px;width: 46px;">
//                                   <span style="">#</span>
//                                 </th>
//                                 <th class="col-xl-2 col-sm-2 col-md-2" style="padding-right: 0px;margin-left: 5px;">Primer Nombre<span>*</span></th>
//                                 <th class="col-xl-2 col-sm-2 col-md-2" style="padding-right: 0px;margin-left: 5px;">Segundo Nombre</th>
//                                 <th class="col-xl-2 col-sm-2 col-md-2" style="padding-right: 0px;margin-left: 5px;">Primer Apellido<span>*</span></th>
//                                 <th class="col-xl-2 col-sm-2 col-md-2" style="padding-right: 0px;margin-left: 5px;">Segundo Apellido</th>
//                                 <th class="col-xl-2 col-sm-2 col-md-2" style="padding-right: 0px;margin-left: 5px;">Apellido de Casada</th>
//                                 <th class="col-xl-1 col-sm-1 col-md-1" style="padding-right: 0px;margin-left: 0px;">Movimiento</th>
//                               </tr>
//                             </thead>
//                             <tbody>
//                               '.$fila.'
//                             </tbody>
//                             </table>
//                             <span class="pull-left sm">( * Campos Obligatorios)</span>
//                         </div>
//                       </div>
//                     </div>
//                   </div>
//                 </div>      
//               </div>
//               <div class="col-xl-12 col-sm-12 col-md-12">
//                  <div class="col-xl-3 col-sm-3 col-md-3">
//                   <span class="pull-left">
//                     <button type="button" id="btn_atras"  class="btn btn-default btn-lg btn-shadow" onclick="tipomod()" tabindex=1>
//                         <span class="glyphicon glyphicon-chevron-left"></span>
//                         Atras
//                     </button>
//                   </span>
//                  </div>
//                  <div class="col-xl-6 col-sm-6 col-md-6 col-md-offset-2">
//                    <button type="button" id="ConfirParticular"  class="btn btn-primary btn-lg btn-shadow" onclick="confOficialV()" tabindex=0>
//                      <span style="font-size:1.3em;margin:0; padding:0;" class="glyphicon glyphicon-floppy-disk"> </span><br>
//                      GUARDAR
//                    </button> 
//                  </div>
//                 </div>
//               </div>
//           <script>
//             $( document ).ready(function() {                            
//               cargarData('.$cantidad.');
//             });
//           </script>
              
//       ',
//       'case' => 3 );
      
//       echo json_encode($data);




//     }else{
//       #UNICA
//         if ($resp['negativa']!=0) {
//         $sol ='<div id="DsolicitudMod" class="form-group col-xl-12 col-sm-12 col-md-12" hidden>
//                   <label for="Dsolicitud">Datos a solicitar: <span class="sm">(Campo Obligatorio)</span></label>
//                   <input type="text" class="form-control" value="" id="txtsolicitudMod" placeholder="EJ. FAVOR ENVIAR FECHA DE NACIMIENTO..." data-toggle="tooltip" data-placement="right" title="Datos a solicitar" data-campo="Dsolicitud" style="text-transform:uppercase;" onchange="modif(this);" required>
//                 </div>';
        
//         switch ($resp['negativa']) {
//           case 1:
//             $option = '
//                     <option value="1" selected>NEGATIVA</option>
//                     <option value="2">NEGATIVA COMÚN</option>
//                     <option value="3">NEGATIVA SOLICITUD DE DATOS</option>';
//             break;
//           case 2:
//             $option = '
//                     <option value="1" >NEGATIVA</option>
//                     <option value="2" selected>NEGATIVA COMÚN</option>
//                     <option value="3">NEGATIVA SOLICITUD DE DATOS</option>';
//             break;
//           case 3:
//             $option = '
//                     <option value="1" >NEGATIVA</option>
//                     <option value="2" >NEGATIVA COMÚN</option>
//                     <option value="3" selected>NEGATIVA SOLICITUD DE DATOS</option>';
//             $sol ='
//                 <div id="DsolicitudMod" class="form-group col-xl-12 col-sm-12 col-md-12" >
//                   <label for="Dsolicitud">Datos a solicitar: <span class="sm">(Campo Obligatorio)</span></label>
//                   <input type="text" class="form-control" value="'.$resp['datosolicitar'].'" id="txtsolicitudMod" placeholder="Ej. FAVOR ENVIAR FECHA DE NACIMIENTO..." data-toggle="tooltip" data-placement="right" title="Datos a solicitar" data-campo="Dsolicitud" style="text-transform:uppercase;" onchange="modif(this);" required>
//                 </div>';
//             break;
//         }
//         // $negativa='paso2';
//         $negativa='
//               <div id="Mfalse" class="col-xl-12 col-sm-12 col-md-12 well">
//                 <legend><span>Negativa</span></legend>
//                 <div class="form-group col-xl-12 col-sm-12 col-md-12">
//                   <label for="Negativa" >Tipo de Negativa: <span class="sm">(Campo Obligatorio)</span></label>
//                   <select id="cboNegativaMod" class="form-control" data-toggle="tooltip" data-placement="right" title="Seleccione Tipo de Negativa" onchange="modif(this);">
//                     '.$option.'
//                   </select>
//                 </div>
//                 '.$sol.'
//               </div>';

//       }else{
//         $negativa = '
//             <div class="form-group col-xl-12 col-sm-12 col-md-12 col-md-offset-">
//               <label for="NfolioMod">Numero de Folio(s): <span class="sm">(Campo Obligatorio)</span></label>
//               <input type="number" value="'.$resp['numero_folio'].'" class="form-control" id="NfolioMod" data-toggle="tooltip" data-placement="right" title="Ingresar Numero de Folio(s) del Reporte" data-campo="Nfolio" placeholder="Numero de Folio(s) del Reporte" onkeypress="return checkSoloNum(event)" onchange="modif(this);" required>
//             </div> ';
//       }  

//         $data = array(
//         'message' => '
//           <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xs-offset-0 col-sm-offset-0 col-md-offset-0 col-lg-offset-0 toppad" >
//             <div class="panel panel-danger">
//               <div class="panel-heading">
//                 <h3 class="panel-title">Modificacion de Certificación con Folio de Entrada No. <span id="NfolioEntradaMod"><strong>'.$resp['folio_entrada'].'</strong></span></h3>
//               </div>
//               <div class="panel-body">
//                   <form method="post" id="FormOrdenPago" class="col-xl-12 col-sm-12 col-md-12">
//                     <div class="form-group col-xl-12 col-sm-12 col-md-12">
//                       <label for="Asunto">Asunto: <span class="sm">(Campo Obligatorio)</span></label>
//                         <select id="cboAsuntoMod"  num="" class="form-control" data-toggle="tooltip" data-placement="top" title="Seleccione Asunto de la Certificación" data-campo="Asunto" onchange="modif(this);">
//                           '.$DatosAsunto.'
//                         </select>
//                     </div>
//                     <div class="form-group col-xl-6 col-sm-6 col-md-6">
//                       <label for="Pnombre">Primer Nombre: <span class="sm">(Campo Obligatorio)</span></label>
//                       <input type="text" class="form-control" value="'.$resp['primer_nombre'].'" id="PnombreMod" data-toggle="tooltip" data-placement="right" title="Ingresar Primer Nombre" data-campo="Pnombre" placeholder="Primer Nombre" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" onchange="modif(this);" required autofocus>
//                     </div>
//                     <div class="form-group col-xl-6 col-sm-6 col-md-6">
//                       <label for="Snombre">Segundo Nombre: </label>
//                       <input type="text" class="form-control" value="'.$resp['segundo_nombre'].'" id="SnombreMod" placeholder="Segundo Nombre" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" onchange="modif(this);">
//                     </div>
//                     <div class="form-group col-xl-6 col-sm-6 col-md-6">
//                       <label for="Papellido">Primer Apellido: <span class="sm">(Campo Obligatorio)</span></label>
//                       <input type="text" class="form-control" value="'.$resp['primer_apellido'].'" id="PapellidoMod" data-toggle="tooltip" data-placement="right" title="Ingresar Primer Apellido" placeholder="Primer Apellido" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" onchange="modif(this);" required>
//                     </div>
//                     <div class="form-group col-xl-6 col-sm-6 col-md-6">
//                       <label for="Sapellido">Segundo Apellido: </label>
//                       <input type="text" class="form-control" value="'.$resp['segundo_apellido'].'" id="SapellidoMod" placeholder="Segundo Apellido" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" onchange="modif(this);">
//                     </div>
//                     <div class="form-group col-xl-6 col-sm-6 col-md-6">
//                       <label for="Capellido">Apellido de Casada: </label>
//                       <input type="text" class="form-control" value="'.$resp['apellido_casada'].'" id="CapellidoMod" placeholder="Apellido de Casada" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" onchange="modif(this);">
//                     </div>
//                     '.$negativa.'
//                   </form>
//               </div>
//             </div>
//             <div class="col-xl-12 col-sm-12 col-md-12">
//              <div class="col-xl-3 col-sm-3 col-md-3">
//               <span class="pull-left">
//                 <button type="button" id="btn_atras"  class="btn btn-default btn-lg btn-shadow" onclick="tipomod()" tabindex=1>
//                     <span class="glyphicon glyphicon-chevron-left"></span>
//                     Atras
//                 </button>
//               </span>
//              </div>
//              <div class="col-xl-6 col-sm-6 col-md-6 col-md-offset-2">
//                <button type="button" id="ConfirParticular"  class="btn btn-primary btn-lg btn-shadow" onclick="confirmarOficial()" tabindex=0>
//                  <span style="font-size:1.3em;margin:0; padding:0;" class="glyphicon glyphicon-floppy-disk"> </span><br>
//                  GUARDAR
//                </button> 
//              </div>
//             </div>
//           </div>
//           <script>
//             $( document ).ready(function() {                            
//               cargarData(0);

//               $("#cboNegativaMod").change(function() {
//                 var negativa = $(this).val();
//                 if(negativa == 3)
//                 {
//                   $( "#DsolicitudMod" ).fadeIn("slow");
//                   $( "#txtsolicitudMod" ).focus();
//                 }else{
//                   $( "#DsolicitudMod" ).fadeOut("slow");
//                 }
//               });
//             });
//           </script>
//         ',
//         'case' => 3 );
//         echo json_encode($data);
//     }
//   }

// }

// function guardarModOficial()
// {
//     if ($_POST['varios']==1) {
//       # VARIOS...
//       $data = json_decode(stripslashes($_POST['datos']));
//       $i=1;
//       foreach($data as $dato=>$valor)
//       {
//         $i++;  

//       }

//       $NfolioEntrada = $_POST['NfolioEntrada'];
//       $sql = "SELECT orden_pago, primer_nombre, primer_apellido, folio_entrada, fecha_certificacion, fecha_redaccion, variasPersonas, asunto FROM datosgenerales WHERE folio_entrada='".$NfolioEntrada."'";
//       $db = obtenerConexion();
//       $ordendat = ejecutarQuery($db, $sql);
//       $resp = $ordendat->fetch_assoc();
//       $orden = $resp['orden_pago'];
//       $hoy = date("Y-m-d H:i:s");
//       $fechaAnterior = $resp['fecha_redaccion'];
//       // INICIO
//       $errorAsunt = false; 
//       $Asunto = $data->{Asunto};
//       if ($Asunto!=$resp['asunto']) {
//         $errorAsunt = true;
//         $sql = "UPDATE datosgenerales SET fecha_redaccion='".$hoy."', fecha_certificacion='".$hoy."', asunto=".$Asunto." WHERE orden_pago=".$orden;
//               // echo $sql2;
//         $db = obtenerConexion();
//         $resultPersona = ejecutarQuery($db, $sql);
//         if ($resultPersona) {
//           $errorAsunt = false; 
//         }
//       }else{
//         $errorAsunt = true;
//         $sql = "UPDATE datosgenerales SET fecha_redaccion='".$hoy."', fecha_certificacion='".$hoy."' WHERE orden_pago=".$orden;
//               // echo $sql2;
//         $db = obtenerConexion();
//         $resultPersona = ejecutarQuery($db, $sql);
//         if ($resultPersona) {
//           $errorAsunt = false; 
//         }

//       }

//       if ($errorAsunt) {
//         $db->rollback();
//         $Resp = array(
//            'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
//             <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
//             <strong>Error en la transaccion--1</strong>
//             </div>',
//            'case'=> 3);
            
//         echo json_encode($Resp);
//       }else{
//         $user = $_SESSION['id'];
//         $IP = getIP();
        

//         $db = obtenerConexion();
//         $db->autocommit(FALSE);
      
      
//       $sqlAnt = "SELECT primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, apellido_casada, negativa, datosolicitar FROM persona WHERE datogeneral=".$orden;
//       $db = obtenerConexion();
//       $pers = ejecutarQuery($db, $sqlAnt);
//       // $AnteriorPersona = $pers->fetch_assoc();
//       $errorPersona = true;
//       // $DatPers=array();
//       foreach($data as $dato=>$valor)
//       { 
//         // $Persona = $pers->fetch_assoc();
//         $Persona=mysqli_fetch_assoc($pers);
//         $dt = array();
//         foreach((array) $valor as $name=>$val)
//         {
//             if ($name!="0") {
//               $dt[] = $val;
//             }
//         }
//         if (!empty($dt)) {
//               // print_r($dt);print_r($Persona);
//               if ($Persona['negativa']==NULL||$Persona['negativa']=='') {
//                $neg = 0;
//               }else{
//                 $neg = $Persona['negativa'];
//               }

//               $sql2 = "INSERT INTO modificacionpersona (datogeneral, primer_nombre, primer_nombreanterior, segundo_nombre, 
//                 segundo_nombreanterior, primer_apellido, primer_apellidoanterior, segundo_apellido, segundo_apellidoanterior, apellido_casada, apellido_casadaanterior, negativa, datosolicitar, fecha_impresionanterior) 
//                VALUES (".$orden.", '".$dt[0]."', '".$Persona['primer_nombre']."', '".$dt[1]."', '".$Persona['segundo_nombre']."', '".$dt[2]."', '".$Persona['primer_apellido']."', 
//                 '".$dt[3]."', '".$Persona['segundo_apellido']."', '".$dt[4]."', '".$Persona['apellido_casada']."', ".$neg.", '".$Persona['datosolicitar']."', '". $fechaAnterior."')";
//               // echo "SQLL-------".$sql2;
//               $DatPers[] = array($neg,$Persona['datosolicitar']);
//               $resultPersona = ejecutarQuery($db, $sql2);
//               if ($resultPersona) {
//                 $errorPersona=false;
//               }              
//         }
//       }
//       // print_r($DatPers);
//       // while($Persona = $pers->fetch_assoc()){
//       //   $sql2 = "INSERT INTO modificacionpersona (datogeneral, primer_nombreanterior, segundo_nombreanterior, primer_apellidoanterior, segundo_apellidoanterior, 
//       //           apellido_casadaanterior, negativa, datosolicitar) 
//       //          VALUES (".$orden.", '".$Persona['primer_nombre']."', '".$Persona['segundo_nombre']."', '".$Persona['primer_apellido']."', '".$Persona['segundo_apellido']."', 
//       //           '".$Persona['apellido_casada']."')";

//       //   $resultPersona = ejecutarQuery($db, $sql2);
//       //   if ($resultPersona) {
//       //     $errorPersona=true;
//       //   }
//       // }

//       if ($errorPersona) {
//         $db->rollback();
//         $Resp = array(
//            'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
//             <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
//             <strong>Error en la transaccion--2</strong>
//             </div>',
//            'case'=> 3);
            
//         echo json_encode($Resp);
//       }else{
//           # Eliminar datos anterior en persona
//           $sql = "DELETE FROM persona WHERE datogeneral=".$orden;
//           // echo("eLIMINARsql---".$sql);
//           $resultDelete = ejecutarQuery($db, $sql);
//           if (!$resultDelete) {
//               $db->rollback();
//               $Resp = array(
//                  'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
//                   <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
//                   <strong>Error en la transaccion--D</strong>
//                   </div>',
//                  'case'=> 3);
                  
//               echo json_encode($Resp);
//           }else{
//             $error=true;
//             $i=0;
//             foreach($data as $dato=>$valor)
//             { 
//               $dt = array();
              
//               foreach((array) $valor as $name=>$val)
//               {
//                 if ($name!="0") {
//                   $dt[] = $val;
//                 }
//               }
//               if (!empty($dt)) {
//                 // print_r($dt);
//                 $sql2 = "INSERT INTO persona (datogeneral, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, 
//                   apellido_casada, negativa, datosolicitar) 
//                   VALUES (".$orden.", '".$dt[0]."', '".$dt[1]."', '".$dt[2]."', '".$dt[3]."', '".$dt[4]."', ".$DatPers[$i][0].", '".$DatPers[$i][1]."')";
//                 // echo "---DatPers==".$DatPers[$i][1]."----------";
//                 $resultPersona = ejecutarQuery($db, $sql2);
//                 if ($resultPersona) {
//                   $error=false;
//                 }
//               }
//               $i++;
//             }

//             if ($error) {
//               $db->rollback();
//               $Resp = array(
//                  'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
//                   <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
//                   <strong>Error en la transaccion--3</strong>
//                   </div>',
//                  'case'=> 3);
                  
//               echo json_encode($Resp);
//             }else{
              
//               $sql2 = "INSERT INTO impresiones (orden_pago, id_firma, fecha_reimpresion, motivo_reimpresion, boleta_banco, id_concepto, 
//                            tipo_solicitud, usuario_genera, ip_local) 
//                            VALUES (".$orden.", 1, '".$hoy."', 'MODIFICACION DE DATOS OFICIAL', '', 2, 0, '".$user."', '".$IP."')";
//               $impre = ejecutarQuery($db, $sql2);
              
//               if ($impre) {
//                   $db->commit();
//                   $sql = "SELECT orden_pago, primer_nombre, primer_apellido, numero_folio, fecha_certificacion, fecha_redaccion, folio_entrada, variasPersonas, asunto FROM datosgenerales WHERE orden_pago=".$orden;
//                   $db = obtenerConexion();
//                   $ordendat = ejecutarQuery($db, $sql);
//                   $respAct = $ordendat->fetch_assoc();
//                   $sql3 = "SELECT primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, 
//                         apellido_casada, negativa, datosolicitar FROM persona WHERE datogeneral=".$orden;
                  
//                   // echo $sql3;
//                   $resultInf = ejecutarQuery($db, $sql3);

//                   $sqlAsunto = "SELECT nombre, cargo, asunto, dependencia FROM asunto WHERE id=".$respAct['asunto'];

//                   $Asun = ejecutarQuery($db, $sqlAsunto);
//                   $respAsunto = $Asun->fetch_assoc();
//                   $DatoAsunto = $respAsunto['nombre'].", ".$respAsunto['cargo'].", ".$respAsunto['asunto'].", ".$respAsunto['dependencia'];
                  
//                   $tipo = "OFICIAL";
//                   $QR = getQR($orden, $user, $IP, $tipo);
//                   $fechaLetras = fechaALetras(date('d/m/Y',strtotime($respAct['fecha_certificacion'])));
//                   $fechaL = fechaL(date('Y-m-d',strtotime($respAct['fecha_certificacion'])));

//                   $dataCertificacion = "fecha=".$fechaLetras."&asunto=".$DatoAsunto."&Nfolio=".$respAct['numero_folio']."&QR=".$QR."&idDato=".$orden;
//                   $Infos = array(
//                   'case'=> 5,
//                   'dataCertificacion' => $dataCertificacion
//                   );
//                   while($row = $resultInf->fetch_assoc()){
//                       $inf = array(
//                         'nombre' => $row['primer_nombre'].' '.$row['segundo_nombre'].' '.$row['primer_apellido'].' '.$row['segundo_apellido'].' '.$row['apellido_casada'],
//                         'fecha' => $fechaL,
//                         'tipoNegativa' => $row['negativa'],
//                         'negativaDatos' => $row['datosolicitar'],
//                       );
//                       array_push($Infos, $inf);
//                   }

//                   echo json_encode($Infos);
                

//               }else{
//                 $db->rollback();
//                 $Resp = array(
//                        'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
//                                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
//                                         <strong>Error en la transaccion--4</strong>
//                                       </div>',
//                        'case'=> 3);
                      
//                 echo json_encode($Resp);

//               }
//             }
//           }
//       }

//       }
      
//       // FIN

//     }else{
//       # UNICO
//       $NfolioEntrada = $_POST['NfolioEntrada'];                                  
//       $sql = "SELECT orden_pago, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, apellido_casada, 
//               fecha_certificacion, fecha_redaccion, numero_folio, asunto, folio_entrada, negativa, datosolicitar FROM datosgenerales WHERE folio_entrada='".$NfolioEntrada."'";
//       $db = obtenerConexion();
//       $orden = ejecutarQuery($db, $sql);
//       $datoOficial = $orden->fetch_assoc();  

//       $SQLmod='INSERT INTO modificaciones(orden_pago, primer_nombre, pnombre_anterior, segundo_nombre, snombre_anterior, 
//             primer_apellido, papellido_anterior, segundo_apellido, sapellido_anterior, apellido_casada, acasada_anterior, 
//             id_concepto, id_conceptoanterior, numero_folio, numerofolio_anterior, fecha_impresion, usuario_genera, ip_local, 
//             asunto, asunto_anterior, folio_entrada, folioentrada_anterior, negativa, negativa_anterior, datosolicitar, 
//             datosolicitar_anterior) VALUES ('.$datoOficial['orden_pago'].',';

//       $SQLini = "UPDATE datosgenerales SET ";
//       $SQLupd = '';
    
//       // $Pnombre = $_POST['Pnombre'];

//       if(!empty($_POST['Pnombre'])){
//           $Pnombre =$_POST['Pnombre'];
//           $PnombreANT =$_POST['PnombreANT'];
//           $SQLmod.='"'.$Pnombre.'", "'.$PnombreANT.'",';
//           if ($SQLupd!="") {
//             $SQLupd.=',primer_nombre="'.$Pnombre.'"';
//           }else{
//             $SQLupd.='primer_nombre="'.$Pnombre.'"';
//           }
//       }else{
//           $SQLmod.='"'.$datoOficial['primer_nombre'].'", "'.$datoOficial['primer_nombre'].'",';
//       }

//       if(!empty($_POST['Snombre'])){
//           $Snombre =$_POST['Snombre'];
//           $SnombreANT =$_POST['SnombreANT'];
//           $SQLmod.='"'.$Snombre.'", "'.$SnombreANT.'",';
//           if ($SQLupd!="") {
//             $SQLupd.=', segundo_nombre="'.$Snombre.'"';
//           }else{
//             $SQLupd.=' segundo_nombre="'.$Snombre.'"';
//           }
//       }else{
//         if(isset($_POST['Snombre'])){
//           if ($SQLupd!="") {
//             $SQLupd.=', segundo_nombre="'.$_POST['Snombre'].'"';
//           }else{
//             $SQLupd.=' segundo_nombre="'.$_POST['Snombre'].'"';
//           }
//         }

//           $SQLmod.='"'.$datoOficial['segundo_nombre'].'", "'.$datoOficial['segundo_nombre'].'",';
//       }

//       if(!empty($_POST['Papellido'])){
//           $Papellido =$_POST['Papellido'];
//           $PapellidoANT =$_POST['PapellidoANT'];
//           $SQLmod.='"'.$Papellido.'", "'.$PapellidoANT.'",';

//           if ($SQLupd!="") {
//             $SQLupd.=',primer_apellido="'.$Papellido.'"';
//           }else{
//             $SQLupd.='primer_apellido="'.$Papellido.'"';
//           }
//       }else{
//           $SQLmod.='"'.$datoOficial['primer_apellido'].'", "'.$datoOficial['primer_apellido'].'",';
//       }

//       if(!empty($_POST['Sapellido'])){
//           $Sapellido = $_POST['Sapellido'];
//           $SapellidoANT =$_POST['SapellidoANT'];
//           $SQLmod.='"'.$Sapellido.'", "'.$SapellidoANT.'",';

//           if ($SQLupd!="") {
//             $SQLupd.=',segundo_apellido="'.$Sapellido.'"';
//           }else{
//             $SQLupd.=' segundo_apellido="'.$Sapellido.'"';
//           }
//       }else{
//           if(isset($_POST['Sapellido'])){
//             if ($SQLupd!="") {
//               $SQLupd.=',segundo_apellido="'.$_POST['Sapellido'].'"';
//             }else{
//               $SQLupd.=' segundo_apellido="'.$_POST['Sapellido'].'"';
//             }
//           }

//           $SQLmod.='"'.$datoOficial['segundo_apellido'].'", "'.$datoOficial['segundo_apellido'].'",';
//       }

//       if(!empty($_POST['Capellido'])){
//           $Capellido = $_POST['Capellido'];
//           $CapellidoANT =$_POST['CapellidoANT'];
//           $SQLmod.='"'.$Capellido.'", "'.$CapellidoANT.'",';

//           if ($SQLupd!="") {
//             $SQLupd.=',apellido_casada="'.$Capellido.'"';
//           }else{
//             $SQLupd.=' apellido_casada="'.$Capellido.'"';
//           }
//       }else{
//           if(isset($_POST['Capellido'])){
//             if ($SQLupd!="") {
//               $SQLupd.=',apellido_casada="'.$_POST['Capellido'].'"';
//             }else{
//               $SQLupd.=' apellido_casada="'.$_POST['Capellido'].'"';
//             }
//           }
//           $SQLmod.='"'.$datoOficial['apellido_casada'].'", "'.$datoOficial['apellido_casada'].'",';
//       }
         
//       $SQLmod.='2, 2,';

//       if(!empty($_POST['Nfolio'])){
//           $Nfolio = $_POST['Nfolio'];
//           $NfolioANT =$_POST['NfolioANT'];
//           $SQLmod.=$Nfolio.', '.$NfolioANT.',';

//           if ($SQLupd!="") {
//             $SQLupd.=',numero_folio='.$Nfolio.'';
//           }else{
//             $SQLupd.=' numero_folio='.$Nfolio.'';
//           }
//       }else{
//           $Nfolio ="";
//           $SQLmod.=$datoOficial['numero_folio'].', '.$datoOficial['numero_folio'].',';
//       }

      
//       $SQLmod.='"'.$datoOficial['fecha_certificacion'].'",';

//       $user = $_SESSION['id'];
//       $IP = getIP();
//       $SQLmod.=$user.',"'.$IP.'",';

//       if(!empty($_POST['asunto'])){
//             $asunto = $_POST['asunto'];
//             $asuntoANT =$_POST['asuntoANT'];
//             $SQLmod.='"'.$asunto.'", "'.$asuntoANT.'",';

//             if ($SQLupd!="") {
//               $SQLupd.=',asunto="'.$asunto.'"';
//             }else{
//               $SQLupd.=' asunto="'.$asunto.'"';
//             }
//         }else{
//             if ($datosOrdenP['asunto']!=NULL) {
//               $SQLmod.='"'.$datosOrdenP['asunto'].'", "'.$datosOrdenP['asunto'].'",';
//             }else{
//               $SQLmod.='"", "",';

//             }
//         }


//       $SQLmod.='"'.$NfolioEntrada.'", "'.$NfolioEntrada.'",';
//       if(!empty($_POST['cboNegativa'])){
//         $cboNegativ = $_POST['cboNegativa'];
//         $cboNegativANT =$_POST['cboNegativaANT'];
//         $SQLmod.=$cboNegativ.', '.$cboNegativANT.',';

//         if ($SQLupd!="") {
//           $SQLupd.=', negativa='.$cboNegativ.'';
//         }else{
//           $SQLupd.=' negativa='.$cboNegativ.'';
//         }
//       }else{
//         if ($datosOrdenP['negativa']!=NULL||$datosOrdenP['negativa']!=0) {
//           $SQLmod.=$datosOrdenP['negativa'].', '.$datosOrdenP['negativa'].',';
//         }else{
//           $SQLmod.='0, 0,';
//         }        
//       }

//       if(!empty($_POST['txtsolicitud'])){
//         $txtsolicitud = $_POST['txtsolicitud'];
//         $txtsolicitudANT =$_POST['txtsolicitudANT'];
//         $SQLmod.='"'.$txtsolicitud.'", "'.$txtsolicitudANT.'"';

//         if ($SQLupd!="") {
//           $SQLupd.=', datosolicitar="'.$txtsolicitud.'"';
//         }else{
//           $SQLupd.=' datosolicitar="'.$txtsolicitud.'"';
//         }
//       }else{
//         if ($_POST['cboNegativa']==3&&$datosOrdenP['datosolicitar']!=NULL||$datosOrdenP['datosolicitar']!='') {
//           $SQLmod.='"'.$datosOrdenP['datosolicitar'].'", "'.$datosOrdenP['datosolicitar'].'"';
//         }else{
//           $SQLmod.="'',''";
//         }        
//       }

//       $SQLmod.=')';
//       $hoy = date("Y-m-d H:i:s");
//       $SQLini.=$SQLupd.', fecha_certificacion="'.$hoy.'" WHERE folio_entrada="'.$NfolioEntrada.'"';
      
//       // echo "ModificarSQL===".$SQLmod."*****ActualizarSQL==".$SQLini;
//       $db = obtenerConexion();
//       $db->autocommit(FALSE);
//       // $db = obtenerConexion();
//       $result = ejecutarQuery($db, $SQLmod);
//       if ($result) {
//         // echo $SQLini;
//         // $db = obtenerConexion();
//         $result2 = ejecutarQuery($db, $SQLini);

//         if ($result2) {
//           // echo "correcto";
//             $db->commit();
//             $sqlN = "SELECT orden_pago, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, apellido_casada, numero_folio, 
//               asunto, folio_entrada, fecha_certificacion, negativa, datosolicitar FROM datosgenerales WHERE folio_entrada='".$NfolioEntrada."'";
//             $db = obtenerConexion();
//             $ordenNE = ejecutarQuery($db, $sqlN);
//             $datosNE = $ordenNE->fetch_assoc(); 
//             // $fechaLetras = fechaALetras(date('d/m/Y'));
//             $fechaLetras = fechaALetras(date('d/m/Y',strtotime($datosNE['fecha_certificacion'])));
//             $fechaL = fechaL(date('Y-m-d',strtotime($datosNE['fecha_certificacion'])));

//             $sqlAsunto = "SELECT nombre, cargo, asunto, dependencia FROM asunto WHERE id=".$datosNE['asunto'];
//             $Asun = ejecutarQuery($db, $sqlAsunto);
//             $respAsunto = $Asun->fetch_assoc();
//             $DatoAsunto = $respAsunto['nombre'].', '.$respAsunto['cargo'].', '.$respAsunto['dependencia'].', '.$respAsunto['asunto'];
         

//             if ($datosNE['negativa']!=NULL||$datosNE['negativa']!=0) {
//               # UNICA CON NEGATIVA
//               $sql2 = "INSERT INTO impresiones (orden_pago, id_firma, fecha_reimpresion, motivo_reimpresion, boleta_banco, id_concepto, 
//               tipo_solicitud, usuario_genera, ip_local) 
//               VALUES (".$datosNE['orden_pago'].", 1, '".$hoy."', '".$motivo."', '', 2, 0, '".$user."', '".$IP."')";
//               $db = obtenerConexion();
//               $result = ejecutarQuery($db, $sql2);
//               $tipo = "OFICIAL";
//               $QR = getQR($numeroOrden, $user, $IP, $tipo);

//               $printOficial="fecha=".$fechaLetras."&asunto=".$DatoAsunto."&nombre=".$datosNE["primer_nombre"]." ".$datosNE["segundo_nombre"]." ".$datosNE["primer_apellido"]." ".$datosNE["segundo_apellido"]." ".$datosNE["apellido_casada"]."&Nfolio=".$datosNE["numero_folio"]."&QR=".$QR."&Movimiento=NO";
//               $printNegativa = "nombre=".$datosNE["primer_nombre"]." ".$datosNE["segundo_nombre"]." ".$datosNE["primer_apellido"]." ".$datosNE["segundo_apellido"]." ".$datosNE["apellido_casada"]."&fecha=".$fechaL;

//               if ($datosNE["negativa"]==3) {
//                $printNegativa .= "&datosolicitar=".$datosNE["datosolicitar"];
//               }
           
//               $data = array(
//                'message'=> $printOficial,
//                'tipoNegativa'=> $datosNE["negativa"],
//                'negativaDatos'=> $printNegativa,
//                'case'=> 2);
              
//               echo json_encode($data);             
//             }else{
//               # UNICA SIN NEGATIVA
//               $sql2 = "INSERT INTO impresiones (orden_pago, id_firma, fecha_reimpresion, motivo_reimpresion, boleta_banco, id_concepto, 
//               tipo_solicitud, usuario_genera, ip_local) 
//               VALUES (".$resp['orden_pago'].", 1, '".$hoy."', '".$motivo."', '', 2, 0, '".$user."', '".$IP."')";
//               $db = obtenerConexion();
//               $result = ejecutarQuery($db, $sql2);
//               $tipo = "OFICIAL";
//               $QR = getQR($numeroOrden, $user, $IP, $tipo);


//               $printOficial="fecha=".$fechaLetras."&asunto=".$DatoAsunto."&nombre=".$datosNE["primer_nombre"]." ".$datosNE["segundo_nombre"]." ".$datosNE["primer_apellido"]." ".$datosNE["segundo_apellido"]." ".$datosNE["apellido_casada"]."&Nfolio=".$datosNE["numero_folio"]."&QR=".$QR;

//               $data = array(
//              'message'=> $printOficial,
//              'case'=> 1);
              
//               echo json_encode($data);
              
//             }

            

       
          

//         }else{
//           $db->rollback();
//           $data = array(
//          'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
//                         <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
//                           Error al realizar la transaccion
//                         </div>',
//          'case'=> 3);
          
//           echo json_encode($data);
//           // echo "Error al ejecutar query UPD";
//         }
//       }else{
//           $db->rollback();
//           $data = array(
//          'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
//                         <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
//                           Error al realizar la transaccion
//                         </div>',
//          'case'=> 3);
          
//           echo json_encode($data);
//           // echo "Error al ejecutar query Mod";
//       }

//   }

// }

// function reimprisionParticular()
// {
//   if (!empty($_POST['NordenReim'])) {
//       $numeroOrden=$_POST['NordenReim'];
//       //$numeroBoleta = $_POST['Nboleta'];

//         $sql = "SELECT dg.orden_pago, dg.id_pais, dg.id_concepto, cp.nombre_concepto, dg.primer_nombre, dg.segundo_nombre, dg.primer_apellido, 
//                 dg.segundo_apellido, dg.apellido_casada, ps.nacionalidad_pais, ps.nombre_pais , dg.nacionalidad, dg.tipo_documento, dg.numero_documento, 
//                 dg.tipo_solicitud, dg.numero_folio, dg.negativa, dg.lugar_ingreso, dg.fecha_ingreso, dg.dias_permacer, dg.lugar_documento, dg.boleta_banco, dg.valor_concepto, dg.estado 
//                 FROM datosgenerales dg, conceptos cp, paises ps WHERE dg.id_concepto = cp.id_concepto AND dg.nacionalidad= ps.id_pais AND dg.orden_pago=".$numeroOrden;
      
//         // $sql = "SELECT orden_pago, tipo_solicitud, id_concepto, id_pais, primer_nombre, segundo_nombre, 
//         //         primer_apellido, segundo_apellido, apellido_casada, nacionalidad, tipo_documento, 
//         //         numero_documento, lugar_documento, resolucion, boleta_banco, numero_folio, valor_concepto, 
//         //         tipo_solicitud, lugar_ingreso, fecha_ingreso, dias_permacer, fecha_deportado, vuelo_proveniente, negativa, datosolicitar FROM datosgenerales WHERE 
//         //         orden_pago=".$numeroOrden;
//         $db = obtenerConexion();
//         $orden = ejecutarQuery($db, $sql);
//         $resp = $orden->fetch_assoc();

//     if ($resp['id_concepto']==8) {
//         $data = array(
//          'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
//             <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
//               La orden de pago No.: <strong>'.$resp['orden_pago'].'</strong> pertenece a CERTIFICACIÓN DE CARENCIA DE ARRAIGO ',
//          'case'=> 2);
        
//         echo json_encode($data);
//     }else if ($resp['id_concepto']==1) {
//         $data = array(
//          'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
//             <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
//               La orden de pago No.: <strong>'.$resp['orden_pago'].'</strong> pertenece a MULTA POR PERMANENCIA ILEGAL EN EL PAÍS DE CONTRO MIGRATORIO',
//          'case'=> 2);
//         // 
//         echo json_encode($data);
//     }else{

//         if ($resp['orden_pago']==$numeroOrden) {
//             if ($resp['boleta_banco']==0||$resp['boleta_banco']==null) {
                
//               if ($resp['tipo_solicitud']==0) {
//                 $data = array(
//                  'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
//                     <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
//                       La orden de pago No.: <strong>'.$resp['orden_pago'].'</strong> pertenece a una Certificacion <strong>OFICIAL</strong>. 
//                       </div>',
//                  'case'=> 2);
                
//                 echo json_encode($data);
//               }else{
//                 $data = array(
//                  'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
//                     <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
//                       La orden de pago No.: <strong>'.$resp['orden_pago'].'</strong> no se encuentra generada. 
//                        Desea generar la certificacion.  
//                       <a href="?ac=certificacion" class="btn btn-success btn-shadow" role="button">
//                         <span class="glyphicon glyphicon-file"></span>
//                         Generar Certificacion
//                       </a>
//                       </div>',
//                  'case'=> 2);
                
//                 echo json_encode($data);
//               }

//             }else{
//                 $NegReim = '';
//                 $depor = '';
//                 if ($resp['id_concepto']==9) {
//                   $Movimiento='
//                       <tr hidden>
//                         <td id="idConceptoReim" >'.$resp['id_concepto'].'</td>
//                       </tr>
//                       <tr>
//                         <td style="width:14em;">Frontera:</td>
//                         <td id="tb-Infrontera" style="font-weight: 700;">'.$resp['lugar_ingreso'].'</td>
//                       </tr>
//                       <tr>
//                         <td style="width:14em;">Fecha Ingreso:</td>
//                         <td id="tb-Fingreso" style="font-weight: 700;">'.date("d/m/Y",strtotime($resp['fecha_ingreso'])).'</td>
//                       </tr>
//                       <tr>
//                         <td style="width:14em;">Dias para Permanecer:</td>
//                         <td id="tb-Sdias" style="font-weight: 700;">'.$resp['dias_permacer'].'</td>
//                       </tr>';

//                 }else{
//                   if ($resp['negativa']!=0&&$resp['negativa']!=NULL) {
                    
//                     $NegReim = '<div class="col-xl-3 col-sm-3 col-md-3">
//                                   <label class="checkbox">
//                                     <input type="checkbox" value="printNegativa" id="printNegativa"> Reimprimir Negativa
//                                   </label>
//                                 </div>';
//                     switch ($resp['negativa']) {
//                       case 1:
//                         $txtNegativa = 'NEGATIVA';
//                         break;
//                       case 2:
//                         $txtNegativa = 'NEGATIVA COMÚN';
//                         break;
//                       case 3:
//                         $txtNegativa = 'NEGATIVA SOLICITUD DE DATOS';
//                         break;
//                     }

//                     $Movimiento = '<tr>
//                       <td style="width:14em;">Tipo de Negativa:</td>
//                       <td id="tb-negativa" style="font-weight: 700;">'.$txtNegativa.'</td>
//                       <td id="tb-Nnegativa" style="font-weight: 700;" hidden>'.$resp['negativa'].'</td>
//                     </tr>';
//                     if ($resp['negativa']==3) {
//                       $Movimiento .= '<tr>
//                       <td style="width:14em;">Datos a Solicitar:</td>
//                       <td id="tb-txtsolicitud" style="font-weight: 700;">'.$resp['datosolicitar'].'</td>
//                     </tr>';
//                     }

//                   }else{
//                     $NegReim = '';
//                     $Movimiento='<tr>
//                       <td style="width:14em;">Numero de Folio(s):</td>
//                       <td id="tb-Nfolio" style="font-weight: 700;">'.$resp['numero_folio'].'</td>
//                     </tr>';
//                   }


//                 if ($resp['vuelo_proveniente']!=NULL||$resp['vuelo_proveniente']!="") {
//                     $FechaDeport=date("d-m-Y",strtotime($resp['fecha_deportado']));
//                     $depor = '
//                       <tr>
//                         <td style="width:14em;">Fecha Deportado:</td>
//                         <td style="font-weight: 700;">'.$FechaDeport.'</td>
//                       </tr>
//                       <tr>
//                         <td style="width:14em;">Vuelo Proveniente:</td>
//                         <td style="font-weight: 700;">'.$resp['vuelo_proveniente'].'</td>
//                       </tr>  
//                     ';
//                   }else{
//                     $depor = '';
//                   } 
//                 }

//                 $data = array(
//                     'message' => '
//                             <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xs-offset-0 col-sm-offset-0 col-md-offset-0 col-lg-offset-0 toppad" >
//                               <div class="panel panel-info">
//                                 <div class="panel-heading">
//                                   <h3 class="panel-title">Datos de la Orden de Pago No. <span id="nOrden"><strong>'.$resp['orden_pago'].'</strong></span></h3>
//                                 </div>
//                                 <div class="panel-body">
//                                   <div class="row">             
//                                      <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 "> 
//                                       <table class="table table-user-information">
//                                         <tbody>
//                                           <tr>
//                                             <td>Primer Nombre:</td>
//                                             <td style="font-weight: 700;">'.$resp['primer_nombre'].'</td>
//                                           </tr>
//                                           <tr>
//                                             <td style="width:14em;">Segundo Nombre:</td>
//                                             <td style="font-weight: 700;">'.$resp['segundo_nombre'].'</td>
//                                           </tr>
//                                           <tr>
//                                             <td style="width:14em;">Primer Apellido:</td>
//                                             <td style="font-weight: 700;">'.$resp['primer_apellido'].'</td>
//                                           </tr>
//                                           <tr>
//                                             <td style="width:14em;">Segundo Apellido:</td>
//                                             <td style="font-weight: 700;">'.$resp['segundo_apellido'].'</td>
//                                           </tr>
//                                           <tr>
//                                             <td style="width:14em;">Apellido de Casada:</td>
//                                             <td style="font-weight: 700;">'.$resp['apellido_casada'].'</td>
//                                           </tr>
//                                           <tr>
//                                             <td style="width:14em;">Nacionalidad:</td>
//                                             <td style="font-weight: 700;">'.strtoupper($resp['nacionalidad_pais']).'</td>
//                                           </tr>
//                                           <tr>
//                                             <td style="width:14em;">Tipo de Documento:</td>
//                                             <td style="font-weight: 700;">'.$resp['tipo_documento'].'</td>
//                                           </tr>
//                                           <tr>
//                                             <td style="width:14em;">Numero de Documento:</td>
//                                             <td style="font-weight: 700;">'.$resp['numero_documento'].'</td>
//                                           </tr>
//                                         </tbody>
//                                       </table>
//                                     </div>

//                                     <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 "> 
//                                       <table class="table table-user-information">
//                                         <tbody>
//                                           <tr>
//                                             <td style="width:14em;">Pais extendio Documento:</td>
//                                             <td style="font-weight: 700;">'.$resp['id_pais'].'</td>
//                                           </tr>
//                                           <tr>
//                                             <td style="width:14em;">Lugar extendio Documento:</td>
//                                             <td style="font-weight: 700;">'.$resp['lugar_documento'].'</td>
//                                           </tr>
//                                           <tr>
//                                             <td style="width:14em;">Concepto:</td>
//                                             <td style="font-weight: 700;">'.$resp['nombre_concepto'].'</td>
//                                           </tr>
//                                           <tr>
//                                             <td style="width:14em;">Valor Concepto:</td>
//                                             <td style="font-weight: 700;">Q.'.$resp['valor_concepto'].'</td>
//                                           </tr>
//                                           <tr>
//                                             <td style="width:14em;">Boleta del banco No.:</td>
//                                             <td style="font-weight: 700;">'.$resp['boleta_banco'].'</td>
//                                           </tr>
//                                           '.$Movimiento.$depor.'              
//                                         </tbody>
//                                       </table>
//                                     </div>
//                                   </div>
//                                 </div>
//                               </div>      
//                             </div>
//                                 <div class="form-group col-xl-10 col-sm-10 col-md-10 col-md-offset-1">
//                                         <label for="MtReimpresion">Motivo de la Reimpresion: <span class="sm">(Campo Obligatorio)</span></label>
//                                         <textarea class="form-control" rows="3" id="motivoReimpresion" style="text-transform:uppercase;" data-toggle="tooltip" data-placement="right" title="Ingresar Motivo de la reimpresion" data-campo="motivoReimpresion"></textarea>
//                                 </div>
//                                 <br>
//                                   <div class="col-xl-3 col-sm-3 col-md-3 col-md-offset-0">
//                                   <span class="pull-left">
//                                   <button type="button" id="btn_atras"  class="btn btn-default btn-lg btn-shadow" onclick="tiporeimp()" tabindex=1 >
//                                     <span class="glyphicon glyphicon-chevron-left"> </span>
//                                     Atras
//                                   </button>
//                                   </span>
//                                   </div>
//                                 <div class="col-xl-3 col-sm-3 col-md-3 col-md-offset-2">
//                                   <button type="button" id="btn_reimprimir"  class="btn btn-primary btn-lg btn-shadow" onclick="reimprimir_datos()" tabindex=0 >
//                                     <span class="glyphicon glyphicon-print"> </span>
//                                     Imprimir
//                                   </button> 
//                                 </div>
//                                 '.$NegReim.'
//                             </div>
                            
//                     ',
//                     'case' => 3 );
//                     //
//                     echo json_encode($data);
//                 }    
            

//         }else{

//             $data = array(
//                  'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
//                                 <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
//                                   La orden de pago No.: <strong>'.$numeroOrden.' NO existe!. </strong> Desea generar una orden de pago.  <a href="?ac=ordenpago" class="btn btn-info btn-shadow" role="button">
//                                     <span class="glyphicon glyphicon-th-list"></span>
//                                     Generar Orden de Pago
//                                   </a>
//                                 </div>',
//                  'case'=> 1);
            
//             echo json_encode($data);

//         }
//     }

//     }else{
//         echo "Error en los datos";
//     }

// }


// function impreParticular()
// {
//   if (!empty($_POST['Norden'])&&!empty($_POST['motivo'])) {
//       $numeroOrden=$_POST['Norden'];
//       $motivo = $_POST['motivo'];
//       $hoy = date("Y-m-d H:i:s");
//       $user = $_SESSION['id'];
//       $IP = getIP();


//       $sql = "SELECT primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, apellido_casada, 
//               boleta_banco, numero_folio, fecha_certificacion, fecha_deportado, vuelo_proveniente, negativa, 
//               datosolicitar FROM datosgenerales WHERE orden_pago=".$numeroOrden;
//       $db = obtenerConexion();
//       $orden = ejecutarQuery($db, $sql);
//       $resp = $orden->fetch_assoc();



//       // $FechaDeport=date("Y-m-d",strtotime($_POST['FechaDepor']));
//       $fechaLetras = fechaALetras(date('d/m/Y',strtotime($resp['fecha_certificacion'])));
//       $fechaL = fechaL(date('Y-m-d',strtotime($resp['fecha_certificacion'])));

//       if (!empty($_POST['idConcepto'])) {
//         $sql2 = "INSERT INTO impresiones (orden_pago, id_firma, fecha_reimpresion, motivo_reimpresion, boleta_banco, id_concepto, 
//                 tipo_solicitud, usuario_genera, ip_local) 
//                 VALUES (".$numeroOrden.", 1, '".$hoy."', '".$motivo."', '".$resp['boleta_banco']."', 2, 1, '".$user."', '".$IP."')";
//         $db = obtenerConexion();
//         $result = ejecutarQuery($db, $sql2);
//         $tipo = "PARTICULAR";
//         $QR = getQR($numeroOrden, $user, $IP, $tipo);

//         $sql = "SELECT dg.orden_pago, dg.id_concepto, dg.id_pais, ps.nacionalidad_pais, dg.primer_nombre, dg.segundo_nombre, dg.primer_apellido, dg.segundo_apellido, 
//                 dg.apellido_casada, dg.tipo_documento, dg.numero_documento, dg.lugar_ingreso, dg.fecha_ingreso, dg.dias_permacer
//                  FROM datosgenerales dg, paises ps WHERE dg.nacionalidad=ps.id_pais AND orden_pago=".$numeroOrden;
//         $orden = ejecutarQuery($db, $sql);
//         $resp = $orden->fetch_assoc();
//         $fechaL = fechaL(date('Y-m-d',strtotime($resp['fecha_ingreso'])));
//         $printEstatus="nombre=".$resp["primer_nombre"]." ".$resp["segundo_nombre"]." ".$resp["primer_apellido"]
//                         ." ".$resp["segundo_apellido"]." ".$resp["apellido_casada"]."&documento="
//                         .$resp["tipo_documento"]."&numeroDoc=".$resp["numero_documento"]."&nacionalidad="
//                         .$resp["nacionalidad_pais"]."&lugar=".$resp["lugar_ingreso"]."&fechaIngreso=".$fechaL
//                         ."&dias=".$resp["dias_permacer"]."&fecha=".$fechaLetras."&QR=".$QR;
        
//         $data = array(
//        'message'=> $printEstatus,
//        'case'=> 6);
//         echo json_encode($data);



//        //  $printParticular="nombre=".$resp["primer_nombre"]." ".$resp["segundo_nombre"]." ".$resp["primer_apellido"]." ".$resp["segundo_apellido"]." ".$resp["apellido_casada"]."&Nfolio=".$resp["numero_folio"]."&fecha=".$fechaLetras."&QR=".$QR;
        
//        //  $data = array(
//        // 'message'=> ''.$printParticular.'',
//        // 'case'=> 1);
        
//        //  echo json_encode($data);


//       }else{
//         if ($resp['negativa']!=0&&$resp['negativa']!=NULL) {
//           # Negativa...
//           if ($resp['vuelo_proveniente']!=NULL||$resp['vuelo_proveniente']!="") {
//               // Negativa Deportado
//               $sql2 = "INSERT INTO impresiones (orden_pago, id_firma, fecha_reimpresion, motivo_reimpresion, boleta_banco, id_concepto, 
//               tipo_solicitud, usuario_genera, ip_local) 
//               VALUES (".$numeroOrden.", 1, '".$hoy."', '".$motivo."', '".$resp['boleta_banco']."', 2, 1, '".$user."', '".$IP."')";
//               $db = obtenerConexion();
//               $result = ejecutarQuery($db, $sql2);
//               $tipo = "PARTICULAR DEPORTADO";
//               $QR = getQR($numeroOrden, $user, $IP, $tipo);

//               $printDeportado="nombre=".$resp["primer_nombre"]." ".$resp["segundo_nombre"]." ".$resp["primer_apellido"]." ".$resp["segundo_apellido"]." ".$resp["apellido_casada"]."&fechaDeportado=".FechaL($resp["fecha_deportado"])."&Vproveniente=".$resp["vuelo_proveniente"]."&Nfolio=".$resp["numero_folio"]."&fecha=".$fechaLetras."&QR=".$QR."&Movimiento=NO";
//               $printNegativa = "nombre=".$resp["primer_nombre"]." ".$resp["segundo_nombre"]." ".$resp["primer_apellido"]." ".$resp["segundo_apellido"]." ".$resp["apellido_casada"]."&fecha=".$fechaL;
              
//               if ($resp["negativa"]==3) {
//                $printNegativa .= "&datosolicitar=".$resp["datosolicitar"];
//               }
//               $NegReim = 0;
//               if (!empty($_POST['ReimNeg'])) {
//                 $NegReim = 1;
//               }
//              //  $data = array(
//              // 'message'=> ''.$printDeportado.'',
//              // 'case'=> 1);
              
//              //  echo json_encode($data);

//               $data = array(
//                'message'=> $printDeportado,
//                'tipoCertificacion'=> 1,
//                'tipoNegativa'=> $resp["negativa"],
//                'negativaDatos'=> $printNegativa,
//                'printN' => $NegReim,
//                'case'=> 5);
              
//               echo json_encode($data);


//           }
//           else{

//               $sql2 = "INSERT INTO impresiones (orden_pago, id_firma, fecha_reimpresion, motivo_reimpresion, boleta_banco, id_concepto, 
//                 tipo_solicitud, usuario_genera, ip_local) 
//                 VALUES (".$numeroOrden.", 1, '".$hoy."', '".$motivo."', '".$resp['boleta_banco']."', 2, 1, '".$user."', '".$IP."')";
//               $db = obtenerConexion();
//               $result = ejecutarQuery($db, $sql2);
//               $tipo = "PARTICULAR";
//               $QR = getQR($numeroOrden, $user, $IP, $tipo);

//               $printParticular="nombre=".$resp["primer_nombre"]." ".$resp["segundo_nombre"]." ".$resp["primer_apellido"]." ".$resp["segundo_apellido"]." ".$resp["apellido_casada"]."&Nfolio=".$resp["numero_folio"]."&fecha=".$fechaLetras."&QR=".$QR."&Movimiento=NO";
//               // $printDeportado="nombre=".$resp["primer_nombre"]." ".$resp["segundo_nombre"]." ".$resp["primer_apellido"]." ".$resp["segundo_apellido"]." ".$resp["apellido_casada"]."&fechaDeportado=".FechaL($resp["fecha_deportado"])."&Vproveniente=".$resp["vuelo_proveniente"]."&Nfolio=".$resp["numero_folio"]."&fecha=".$fechaLetras."&QR=".$QR."&Movimiento=NO";
//               $printNegativa = "nombre=".$resp["primer_nombre"]." ".$resp["segundo_nombre"]." ".$resp["primer_apellido"]." ".$resp["segundo_apellido"]." ".$resp["apellido_casada"]."&fecha=".$fechaL;
              
//               if ($resp["negativa"]==3) {
//                $printNegativa .= "&datosolicitar=".$resp["datosolicitar"];
//               }
//               $NegReim = 0;
//               if (!empty($_POST['ReimNeg'])) {
//                 $NegReim = 1;
//               }
//              //  $data = array(
//              // 'message'=> ''.$printDeportado.'',
//              // 'case'=> 1);
              
//              //  echo json_encode($data);

//               $data = array(
//                'message'=> $printParticular,
//                'tipoCertificacion'=> 0,
//                'tipoNegativa'=> $resp["negativa"],
//                'negativaDatos'=> $printNegativa,
//                'printN' => $NegReim,
//                'case'=> 5);
              
//               echo json_encode($data);




//              //  $printParticular="nombre=".$resp["primer_nombre"]." ".$resp["segundo_nombre"]." ".$resp["primer_apellido"]." ".$resp["segundo_apellido"]." ".$resp["apellido_casada"]."&Nfolio=".$resp["numero_folio"]."&fecha=".$fechaLetras."&QR=".$QR;
              
//              //  $data = array(
//              // 'message'=> ''.$printParticular.'',
//              // 'case'=> 2);
              
//              //  echo json_encode($data);
         
//           }

//         }else{
//           # Con Movimiento Migratorio
//           if ($resp['vuelo_proveniente']!=NULL||$resp['vuelo_proveniente']!="") {
//               //Deportado
//               $sql2 = "INSERT INTO impresiones (orden_pago, id_firma, fecha_reimpresion, motivo_reimpresion, boleta_banco, id_concepto, 
//               tipo_solicitud, usuario_genera, ip_local) 
//               VALUES (".$numeroOrden.", 1, '".$hoy."', '".$motivo."', '".$resp['boleta_banco']."', 2, 1, '".$user."', '".$IP."')";
//               $db = obtenerConexion();
//               $result = ejecutarQuery($db, $sql2);
//               $tipo = "PARTICULAR DEPORTADO";
//               $QR = getQR($numeroOrden, $user, $IP, $tipo);

//               $printDeportado="nombre=".$resp["primer_nombre"]." ".$resp["segundo_nombre"]." ".$resp["primer_apellido"]." ".$resp["segundo_apellido"]." ".$resp["apellido_casada"]."&fechaDeportado=".FechaL($resp["fecha_deportado"])."&Vproveniente=".$resp["vuelo_proveniente"]."&Nfolio=".$resp["numero_folio"]."&fecha=".$fechaLetras."&QR=".$QR;
              
//               $data = array(
//              'message'=> ''.$printDeportado.'',
//              'case'=> 2);
              
//               echo json_encode($data);

//           }
//           else{

//               $sql2 = "INSERT INTO impresiones (orden_pago, id_firma, fecha_reimpresion, motivo_reimpresion, boleta_banco, id_concepto, 
//                 tipo_solicitud, usuario_genera, ip_local) 
//                 VALUES (".$numeroOrden.", 1, '".$hoy."', '".$motivo."', '".$resp['boleta_banco']."', 2, 1, '".$user."', '".$IP."')";
//               $db = obtenerConexion();
//               $result = ejecutarQuery($db, $sql2);
//               $tipo = "PARTICULAR";
//               $QR = getQR($numeroOrden, $user, $IP, $tipo);

//               $printParticular="nombre=".$resp["primer_nombre"]." ".$resp["segundo_nombre"]." ".$resp["primer_apellido"]." ".$resp["segundo_apellido"]." ".$resp["apellido_casada"]."&Nfolio=".$resp["numero_folio"]."&fecha=".$fechaLetras."&QR=".$QR;
              
//               $data = array(
//              'message'=> ''.$printParticular.'',
//              'case'=> 1);
              
//               echo json_encode($data);
         
//           }
        
//         }
//       }
//   } 

// }

// function reimprisionOficial()
// {
//   if (!empty($_POST['NfolioEntrada'])) {
//       $NfolioEntrada=$_POST['NfolioEntrada'];
//       //$numeroBoleta = $_POST['Nboleta'];
      
//         $sql = "SELECT orden_pago, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, 
//                 apellido_casada, tipo_solicitud, numero_folio,  asunto, folio_entrada, negativa, variasPersonas FROM datosgenerales WHERE 
//                 folio_entrada='".$NfolioEntrada."'";
//         $db = obtenerConexion();
//         $orden = ejecutarQuery($db, $sql);
//         $resp = $orden->fetch_assoc();


//         if ($resp) {
//               $sqlAsunto = "SELECT nombre, cargo, asunto, dependencia FROM asunto WHERE id=".$resp['asunto'];
//               $Asun = ejecutarQuery($db, $sqlAsunto);
//               $respAsunto = $Asun->fetch_assoc();

//               if ($resp['folio_entrada']==$NfolioEntrada) {
//                  if ($resp['tipo_solicitud']==1) {
//                         $data = array(
//                        'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
//                           <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
//                             La orden de pago No.: <strong>'.$resp['orden_pago'].'</strong> pertenece a una Certificacion <strong>PARTICULAR</strong>. 
//                             </div>',
//                        'case'=> 2);
//                       // 
//                       echo json_encode($data);

//                   }else{

//                       if ($resp['variasPersonas']!=0||$resp['variasPersonas']!=NULL) {
//                         # Varias Personas
//                         // if ($resp['negativa']!=NULL||$resp['negativa']!=0) {
                          
                            
//                         //     switch ($resp['negativa']) {
//                         //       case 1:
//                         //         $txtNegativa = 'NEGATIVA';
//                         //         break;
//                         //       case 2:
//                         //         $txtNegativa = 'NEGATIVA COMÚN';
//                         //         break;
//                         //       case 3:
//                         //         $txtNegativa = 'NEGATIVA SOLICITUD DE DATOS';
//                         //         break;
//                         //     }

//                         //     $Movimiento = '<tr>
//                         //       <td style="width:14em;">Tipo de Negativa:</td>
//                         //       <td id="tb-negativa" style="font-weight: 700;">'.$txtNegativa.'</td>
//                         //       <td id="tb-Nnegativa" style="font-weight: 700;" hidden>'.$resp['negativa'].'</td>
//                         //     </tr>';
//                         //     if ($resp['negativa']==3) {
//                         //       $Movimiento .= '<tr>
//                         //       <td style="width:14em;">Datos a Solicitar:</td>
//                         //       <td id="tb-txtsolicitud" style="font-weight: 700;">'.$resp['datosolicitar'].'</td>
//                         //     </tr>';
//                         //     }
//                         // }


//                             $fila="";

//                             $db = obtenerConexion();
//                             $sql = "SELECT primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, 
//                                         apellido_casada, negativa, datosolicitar FROM persona WHERE datogeneral=".$resp['orden_pago'];

//                             $resultDat = ejecutarQuery($db, $sql);
//                             $cantidad=1;
//                             while($row = $resultDat->fetch_assoc()){
//                               if ($row['negativa']==0) {
//                                 $DatMob= '<a class="btn btn-primary checkSI active" style="font-weight: bold;padding: 6px 15px;">
//                                             <input id="checkSI" num=""  type="radio" name="chekMovimiento" value="SI" >SI
//                                           </a>';
//                               }else{
//                                 $DatMob= '<a class="btn btn-primary checkNO active" style="font-weight: bold;" onclick="checkMov(checkNO)">
//                                             <input id="checkNO" num=""  type="radio" name="chekMovimiento" value="NO">NO
//                                         </a>';
//                                 $NegReim = '<div class="col-xl-3 col-sm-3 col-md-3">
//                                           <label class="checkbox">
//                                             <input type="checkbox" value="printNegativa" id="printNegativa"> Reimprimir Negativa
//                                           </label>
//                                         </div>';
//                               }
                                
//                               $fila.='
//                                     <tr id="fila1" name="fila" class="cont">
//                                       <td class="col-xl-2 col-sm-2 col-md-2" style="padding-left: 0px; padding-right: 0px;width: 46px;">
//                                         <span  class="close" id="1" style="font-size:28px;float: left;padding: 0;" >'.$cantidad.'</span>
//                                       </td>
//                                       <td class="col-xl-2 col-sm-2 col-md-2" style="padding-right: 0px;">
//                                         <p class="form-control-static text-center" >'.$row['primer_nombre'].'</p>
//                                       </td>
//                                       <td class="col-xl-2 col-sm-2 col-md-2" style="padding-right: 0;">
//                                         <p class="form-control-static text-center" >'.$row['segundo_nombre'].'</p>
//                                       </td>
//                                       <td class="col-xl-2 col-sm-2 col-md-2" style="padding-right: 0;">
//                                         <p class="form-control-static text-center" >'.$row['primer_apellido'].'</p>
//                                       </td>
//                                       <td class="col-xl-2 col-sm-2 col-md-2" style="padding-right: 0;">
//                                         <p class="form-control-static text-center" >'.$row['segundo_apellido'].'</p>
//                                       </td>
//                                       <td class="col-xl-2 col-sm-2 col-md-2" style="padding-right: 0;">
//                                         <p class="form-control-static text-center" >'.$row['apellido_casada'].'</p>
//                                       </td>
//                                       <td class="col-xl-1 col-sm-1 col-md-1" style="padding-right: 0;">
//                                           <div id="chekMovimiento" name="chekMovimiento" class="btn-group chekMovimiento" data-toggle="buttons" style="padding-left:0;padding-right:0;margin-right: -1em;" data-toggle="tooltip" data-placement="bottom" title="Tiene Movimiento Migratorio" data-campo="chekMovimiento">
//                                            '.$DatMob.'
//                                           </div>
//                                       </td>
//                                     </tr>';
//                               $cantidad++;
//                             }

//                           $data = array(
//                             'message' => '
//                                     <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 toppad" >
//                                       <div class="panel panel-info">
//                                         <div class="panel-heading">
//                                           <h3 class="panel-title">Datos de Folio de Entrada No. <span id="NfolioEntradaReim"><strong>'.$resp['folio_entrada'].'</strong></span></h3>
//                                         </div>
//                                         <div class="panel-body">
//                                           <div class="row">             
//                                             <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
//                                               <div class="form-horizontal">
//                                                 <div class="form-horizontal form-group col-xl-12 col-sm-12 col-md-12">
//                                                   <div for="Asunto" class="col-xl-2 col-sm-2 col-md-2 Colet text-center" style="padding-right:0;"><p style="font-weight: bold;">Asunto:</p></div>
//                                                   <div class="col-xl-10 col-sm-10 col-md-10 Colet" style="padding-left:0;padding-top:0;">
//                                                       <p class="form-control-static text-left" style="padding-top:0;">'.$respAsunto['nombre'].', '.$respAsunto['cargo'].', '.$respAsunto['dependencia'].', '.$respAsunto['asunto'].'</p>
//                                                   </div>
//                                                 </div>

//                                                 <table id="tabla" class="table table-hover table-fixed col-xl-12 col-sm-12 col-md-12 Colet">
//                                                   <thead>
//                                                     <tr>
//                                                       <th class="col-xl-1 col-sm-1 col-md-1" style="padding-left: 0px; padding-right: 0px;width: 46px;">
//                                                         <span style="">#</span>
//                                                       </th>
//                                                       <th class="col-xl-2 col-sm-2 col-md-2 text-center">Primer Nombre</th>
//                                                       <th class="col-xl-2 col-sm-2 col-md-2 text-center">Segundo Nombre</th>
//                                                       <th class="col-xl-2 col-sm-2 col-md-2 text-center">Primer Apellido</th>
//                                                       <th class="col-xl-2 col-sm-2 col-md-2 text-center">Segundo Apellido</th>
//                                                       <th class="col-xl-2 col-sm-2 col-md-2 text-center">Apellido de Casada</th>
//                                                       <th class="col-xl-1 col-sm-1 col-md-1 text-center">Movimiento</th>
//                                                     </tr>
//                                                   </thead>
//                                                   <tbody>
//                                                     '.$fila.'
//                                                   </tbody>
//                                                   </table>
//                                               </div>
//                                             </div>
//                                           </div>
//                                         </div>
//                                       </div>      
//                                     </div>
//                                         <div class="form-group col-xl-10 col-sm-10 col-md-10 col-md-offset-1">
//                                             <label for="MtReimpresion">Motivo de la Reimpresion: <span class="sm">(Campo Obligatorio)</span></label>
//                                             <textarea class="form-control" rows="3" id="motivoReimpresion" style="text-transform:uppercase;" data-toggle="tooltip" data-placement="right" title="Ingresar Motivo de la reimpresion" data-campo="motivoReimpresion"></textarea>
//                                         </div>
//                                         <br>
//                                           <div class="col-xl-3 col-sm-3 col-md-3 col-md-offset-0">
//                                           <span class="pull-left">
//                                           <button type="button" id="btn_atras"  class="btn btn-default btn-lg btn-shadow" onclick="tiporeimp()" tabindex=1 >
//                                             <span class="glyphicon glyphicon-chevron-left"> </span>
//                                             Atras
//                                           </button>
//                                           </span>
//                                           </div>
//                                         <div class="col-xl-3 col-sm-3 col-md-3 col-md-offset-2">
//                                           <button type="button" id="btn_reimprimir"  class="btn btn-primary btn-lg btn-shadow" onclick="reimprimir_oficial()" tabindex=0 >
//                                             <span class="glyphicon glyphicon-print"> </span>
//                                             Imprimir
//                                           </button> 
//                                         </div>
//                                         '.$NegReim.'
//                                     </div>
                                    
//                             ',
//                             'case' => 3 );
                            
//                             echo json_encode($data);

//                       }else{
//                         # Unica 

//                         if ($resp['negativa']!=0) {
                          
//                           $NegReim = '<div class="col-xl-3 col-sm-3 col-md-3">
//                                         <label class="checkbox">
//                                           <input type="checkbox" value="printNegativa" id="printNegativa"> Reimprimir Negativa
//                                         </label>
//                                       </div>';
//                           switch ($resp['negativa']) {
//                             case 1:
//                               $txtNegativa = 'NEGATIVA';
//                               break;
//                             case 2:
//                               $txtNegativa = 'NEGATIVA COMÚN';
//                               break;
//                             case 3:
//                               $txtNegativa = 'NEGATIVA SOLICITUD DE DATOS';
//                               break;
//                           }

//                           $Movimiento = '<tr>
//                             <td style="width:14em;">Tipo de Negativa:</td>
//                             <td id="tb-negativa" style="font-weight: 700;">'.$txtNegativa.'</td>
//                             <td id="tb-Nnegativa" style="font-weight: 700;" hidden>'.$resp['negativa'].'</td>
//                           </tr>';
//                           if ($resp['negativa']==3) {
//                             $Movimiento .= '<tr>
//                             <td style="width:14em;">Datos a Solicitar:</td>
//                             <td id="tb-txtsolicitud" style="font-weight: 700;">'.$resp['datosolicitar'].'</td>
//                           </tr>';
//                           }

//                           $data = array(
//                             'message' => '
//                                     <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-xs-offset-1 col-sm-offset-1 col-md-offset-1 col-lg-offset-1 toppad" >
//                                       <div class="panel panel-info">
//                                         <div class="panel-heading">
//                                           <h3 class="panel-title">Datos de Folio de Entrada No. <span id="NfolioEntradaReim"><strong>'.$resp['folio_entrada'].'</strong></span></h3>
//                                         </div>
//                                         <div class="panel-body">
//                                           <div class="row">             
//                                              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 "> 
//                                               <table class="table table-user-information">
//                                                 <tbody>
//                                                   <tr>
//                                                     <td style="width:14em;">Primer Nombre:</td>
//                                                     <td style="font-weight: 700;">'.$resp['primer_nombre'].'</td>
//                                                   </tr>
//                                                   <tr>
//                                                     <td style="width:14em;">Segundo Nombre:</td>
//                                                     <td style="font-weight: 700;">'.$resp['segundo_nombre'].'</td>
//                                                   </tr>
//                                                   <tr>
//                                                     <td style="width:14em;">Primer Apellido:</td>
//                                                     <td style="font-weight: 700;">'.$resp['primer_apellido'].'</td>
//                                                   </tr>
//                                                   <tr>
//                                                     <td style="width:14em;">Segundo Apellido:</td>
//                                                     <td style="font-weight: 700;">'.$resp['segundo_apellido'].'</td>
//                                                   </tr>
//                                                   <tr>
//                                                     <td style="width:14em;">Apellido de Casada:</td>
//                                                     <td style="font-weight: 700;">'.$resp['apellido_casada'].'</td>
//                                                   </tr>
//                                                   <tr>
//                                                     <td style="width:14em;">Folio(s):</td>
//                                                     <td style="font-weight: 700;">'.$resp['numero_folio'].'</td>
//                                                   </tr> 
//                                                   <tr>
//                                                     <td style="width:14em;">Asunto:</td>
//                                                     <td style="font-weight: 700;">'.$respAsunto['nombre'].', '.$respAsunto['cargo'].', '.$respAsunto['dependencia'].', '.$respAsunto['asunto'].'</td>
//                                                   </tr> 
//                                                   '.$Movimiento.'   
//                                                 </tbody>
//                                               </table>
//                                             </div>
//                                           </div>
//                                         </div>
//                                       </div>      
//                                     </div>
//                                         <div class="form-group col-xl-10 col-sm-10 col-md-10 col-md-offset-1">
//                                                 <label for="MtReimpresion">Motivo de la Reimpresion: <span class="sm">(Campo Obligatorio)</span></label>
//                                                 <textarea class="form-control" rows="3" id="motivoReimpresion" style="text-transform:uppercase;" data-toggle="tooltip" data-placement="right" title="Ingresar Motivo de la reimpresion" data-campo="motivoReimpresion"></textarea>
//                                         </div>
//                                         <br>
//                                           <div class="col-xl-3 col-sm-3 col-md-3 col-md-offset-0">
//                                           <span class="pull-left">
//                                           <button type="button" id="btn_atras"  class="btn btn-default btn-lg btn-shadow" onclick="tiporeimp()" tabindex=1 >
//                                             <span class="glyphicon glyphicon-chevron-left"> </span>
//                                             Atras
//                                           </button>
//                                           </span>
//                                           </div>
//                                         <div class="col-xl-3 col-sm-3 col-md-3 col-md-offset-2">
//                                           <button type="button" id="btn_reimprimir"  class="btn btn-primary btn-lg btn-shadow" onclick="reimprimir_oficial()" tabindex=0 >
//                                             <span class="glyphicon glyphicon-print"> </span>
//                                             Imprimir
//                                           </button> 
//                                         </div>
//                                         '.$NegReim.'
//                                     </div>
                                    
//                             ',
//                             'case' => 3 );
                            
//                             echo json_encode($data);

//                         }else{

//                           $data = array(
//                             'message' => '
//                                     <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-xs-offset-1 col-sm-offset-1 col-md-offset-1 col-lg-offset-1 toppad" >
//                                       <div class="panel panel-info">
//                                         <div class="panel-heading">
//                                           <h3 class="panel-title">Datos de Folio de Entrada No. <span id="NfolioEntradaReim"><strong>'.$resp['folio_entrada'].'</strong></span></h3>
//                                         </div>
//                                         <div class="panel-body">
//                                           <div class="row">             
//                                              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 "> 
//                                               <table class="table table-user-information">
//                                                 <tbody>
//                                                   <tr>
//                                                     <td style="width:14em;">Primer Nombre:</td>
//                                                     <td style="font-weight: 700;">'.$resp['primer_nombre'].'</td>
//                                                   </tr>
//                                                   <tr>
//                                                     <td style="width:14em;">Segundo Nombre:</td>
//                                                     <td style="font-weight: 700;">'.$resp['segundo_nombre'].'</td>
//                                                   </tr>
//                                                   <tr>
//                                                     <td style="width:14em;">Primer Apellido:</td>
//                                                     <td style="font-weight: 700;">'.$resp['primer_apellido'].'</td>
//                                                   </tr>
//                                                   <tr>
//                                                     <td style="width:14em;">Segundo Apellido:</td>
//                                                     <td style="font-weight: 700;">'.$resp['segundo_apellido'].'</td>
//                                                   </tr>
//                                                   <tr>
//                                                     <td style="width:14em;">Apellido de Casada:</td>
//                                                     <td style="font-weight: 700;">'.$resp['apellido_casada'].'</td>
//                                                   </tr>
//                                                   <tr>
//                                                     <td style="width:14em;">Folio(s):</td>
//                                                     <td style="font-weight: 700;">'.$resp['numero_folio'].'</td>
//                                                   </tr> 
//                                                   <tr>
//                                                     <td style="width:14em;">Asunto:</td>
//                                                     <td style="font-weight: 700;">'.$respAsunto['nombre'].', '.$respAsunto['cargo'].', '.$respAsunto['dependencia'].', '.$respAsunto['asunto'].'</td>
//                                                   </tr>    
//                                                 </tbody>
//                                               </table>
//                                             </div>
//                                           </div>
//                                         </div>
//                                       </div>      
//                                     </div>
//                                         <div class="form-group col-xl-10 col-sm-10 col-md-10 col-md-offset-1">
//                                                 <label for="MtReimpresion">Motivo de la Reimpresion: <span class="sm">(Campo Obligatorio)</span></label>
//                                                 <textarea class="form-control" rows="3" id="motivoReimpresion" style="text-transform:uppercase;" data-toggle="tooltip" data-placement="right" title="Ingresar Motivo de la reimpresion" data-campo="motivoReimpresion"></textarea>
//                                         </div>
//                                         <br>
//                                           <div class="col-xl-3 col-sm-3 col-md-3 col-md-offset-0">
//                                           <span class="pull-left">
//                                           <button type="button" id="btn_atras"  class="btn btn-default btn-lg btn-shadow" onclick="tiporeimp()" tabindex=1 >
//                                             <span class="glyphicon glyphicon-chevron-left"> </span>
//                                             Atras
//                                           </button>
//                                           </span>
//                                           </div>
//                                         <div class="col-xl-3 col-sm-3 col-md-3 col-md-offset-2">
//                                           <button type="button" id="btn_reimprimir"  class="btn btn-primary btn-lg btn-shadow" onclick="reimprimir_oficial()" tabindex=0 >
//                                             <span class="glyphicon glyphicon-print"> </span>
//                                             Imprimir
//                                           </button> 
//                                         </div>
//                                     </div>
                                    
//                             ',
//                             'case' => 3 );
//                             //
//                             echo json_encode($data);
                          
//                         }
//                       } 
//                   }   
//               }else{

//                   $data = array(
//                        'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
//                                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
//                                         El folio de entrada No.: <strong>'.$NfolioEntrada.' NO existe!. </strong>
//                                       </div>',
//                        'case'=> 1);
//                   // 
//                   echo json_encode($data);

//               }
          
//         }else{
//           $data = array(
//          'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
//                         <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
//                           El folio de entrada No.'.$_POST['NfolioEntrada'].' NO existe!
//                         </div>',
//          'case'=> 1);
    
//       echo json_encode($data);
//         }
//     }else{
//       $data = array(
//          'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
//                         <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
//                           Error en los datos
//                         </div>',
//          'case'=> 1);
    
//       echo json_encode($data);
//       // echo "Error en los datos";
//     }

// }


// function impreOficial()
// {
//    if (!empty($_POST['NfolioEntrada'])&&!empty($_POST['motivo'])) {
//       $NfolioEntrada=$_POST['NfolioEntrada'];
//       $motivo = $_POST['motivo'];
//       $hoy = date("Y-m-d H:i:s");
//       $user = $_SESSION['id'];
//       $IP = getIP();

//       $sql = "SELECT orden_pago, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, 
//                 apellido_casada, numero_folio, fecha_certificacion, fecha_redaccion, asunto, folio_entrada, negativa, datosolicitar, variasPersonas FROM datosgenerales WHERE 
//                 folio_entrada='".$NfolioEntrada."'";


//       $db = obtenerConexion();
//       $NFol = ejecutarQuery($db, $sql);
//       $resp = $NFol->fetch_assoc();
      
//       if ($resp) {
//           $numeroOrden = $resp['orden_pago'];
//           $fechaLetras = fechaALetras(date('d/m/Y',strtotime($resp['fecha_certificacion'])));
//           $fechaL = fechaL(date('Y-m-d',strtotime($resp['fecha_certificacion'])));
//           $Nfolio = $resp['numero_folio'];
//           // $fechaLetras = fechaALetras(date('d/m/Y'));
//           $sqlAsunto = "SELECT nombre, cargo, asunto, dependencia FROM asunto WHERE id=".$resp['asunto'];
//           $Asun = ejecutarQuery($db, $sqlAsunto);
//           $respAsunto = $Asun->fetch_assoc();
//           $DatoAsunto = $respAsunto['nombre'].', '.$respAsunto['cargo'].', '.$respAsunto['asunto'].', '.$respAsunto['dependencia'];

//           if ($resp['variasPersonas']!=0||$resp['variasPersonas']!=NULL) {
//             # VARIAS PERSONAS
//               $sql3 = "SELECT primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, 
//                     apellido_casada, negativa, datosolicitar FROM persona WHERE datogeneral=".$numeroOrden;
              
//               // echo $sql3;
//               $resultInf = ejecutarQuery($db, $sql3);
//               $tipo = "OFICIAL";
//               $QR = getQR($numeroOrden, $user, $IP, $tipo);
//               $fechaLetras = fechaALetras(date('d/m/Y',strtotime($resp['fecha_redaccion'])));
//               $fechaL = fechaL(date('Y-m-d',strtotime($resp['fecha_redaccion'])));


//               $dataCertificacion = "fecha=".$fechaLetras."&folio=".$NfolioEntrada."&asunto=".$DatoAsunto."&Nfolio=".$Nfolio."&QR=".$QR."&idDato=".$numeroOrden;
//               $NegReim = 0;
//               if (!empty($_POST['ReimNeg'])) {
//                 $NegReim = 1;
//               }
//               $Infos = array(
//               'case'=> 5,
//               'dataCertificacion' => $dataCertificacion,
//               'printN' => $NegReim
//               );
//               while($row = $resultInf->fetch_assoc()){
//                   $inf = array(
//                     'nombre' => $row['primer_nombre'].' '.$row['segundo_nombre'].' '.$row['primer_apellido'].' '.$row['segundo_apellido'].' '.$row['apellido_casada'],
//                     'fecha' => $fechaL,
//                     'tipoNegativa' => $row['negativa'],
//                     'negativaDatos' => $row['datosolicitar'],
//                   );
//                   array_push($Infos, $inf);
//               }

//               echo json_encode($Infos);




//           }else{
//             # UNICA 
//             $fechaLetras = fechaALetras(date('d/m/Y',strtotime($resp['fecha_certificacion'])));
//             $fechaL = fechaL(date('Y-m-d',strtotime($resp['fecha_certificacion'])));

//             if ($resp['negativa']!=0) {
//               # UNICA CON NEGATIVA
//               $sql2 = "INSERT INTO impresiones (orden_pago, id_firma, fecha_reimpresion, motivo_reimpresion, boleta_banco, id_concepto, 
//               tipo_solicitud, usuario_genera, ip_local) 
//               VALUES (".$resp['orden_pago'].", 1, '".$hoy."', '".$motivo."', '', 2, 0, '".$user."', '".$IP."')";
//               $db = obtenerConexion();
//               $result = ejecutarQuery($db, $sql2);
//               $tipo = "OFICIAL";
//               $QR = getQR($numeroOrden, $user, $IP, $tipo);

//               $printOficial="fecha=".$fechaLetras."&folio=".$NfolioEntrada."&asunto=".$DatoAsunto."&nombre=".$resp["primer_nombre"]." ".$resp["segundo_nombre"]." ".$resp["primer_apellido"]." ".$resp["segundo_apellido"]." ".$resp["apellido_casada"]."&Nfolio=".$resp["numero_folio"]."&QR=".$QR."&Movimiento=NO";
//               $printNegativa = "nombre=".$resp["primer_nombre"]." ".$resp["segundo_nombre"]." ".$resp["primer_apellido"]." ".$resp["segundo_apellido"]." ".$resp["apellido_casada"]."&fecha=".$fechaL;

//               if ($resp["negativa"]==3) {
//                $printNegativa .= "&datosolicitar=".$resp["datosolicitar"];
//               }
//               $NegReim = 0;
//               if (!empty($_POST['ReimNeg'])) {
//                 $NegReim = 1;
//               }
           
//               $data = array(
//                'message'=> $printOficial,
//                'tipoNegativa'=> $resp["negativa"],
//                'negativaDatos'=> $printNegativa,
//                'printN' => $NegReim,
//                'case'=> 4);
              
//               echo json_encode($data);             
//             }else{
//               # UNICA SIN NEGATIVA
//               $sql2 = "INSERT INTO impresiones (orden_pago, id_firma, fecha_reimpresion, motivo_reimpresion, boleta_banco, id_concepto, 
//               tipo_solicitud, usuario_genera, ip_local) 
//               VALUES (".$resp['orden_pago'].", 1, '".$hoy."', '".$motivo."', '', 2, 0, '".$user."', '".$IP."')";
//               $db = obtenerConexion();
//               $result = ejecutarQuery($db, $sql2);
//               $tipo = "OFICIAL";
//               $QR = getQR($numeroOrden, $user, $IP, $tipo);

//               $printOficial="fecha=".$fechaLetras."&folio=".$NfolioEntrada."&asunto=".$DatoAsunto."&nombre=".$resp["primer_nombre"]." ".$resp["segundo_nombre"]." ".$resp["primer_apellido"]." ".$resp["segundo_apellido"]." ".$resp["apellido_casada"]."&Nfolio=".$resp["numero_folio"]."&QR=".$QR;
              
//               $data = array(
//              'message'=> ''.$printOficial.'',
//              'case'=> 1);
               
//               echo json_encode($data);
              
//             }
//           } 
//       }else{
//         $data = array(
//          'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
//                         <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
//                           El folio de entrada No.'.$_POST['NfolioEntrada'].' NO existe!
//                         </div>',
//          'case'=> 2);
    
//         echo json_encode($data);
//       }
//   }else{
//       $data = array(
//          'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
//                         <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
//                           Error en los datos!
//                         </div>',
//          'case'=> 2);
    
//         echo json_encode($data);    
//   }
// }

// function addAsunto()
// {
//   if (!empty($_POST['Anombre'])&&!empty($_POST['Acargo'])&&!empty($_POST['Adependencia'])) {
//       $Anombre=$_POST['Anombre'];
//       $Acargo = $_POST['Acargo'];
//       $Adependencia = $_POST['Adependencia'];
//       $hoy = date("Y-m-d H:i:s");
//       $user = $_SESSION['id'];
//       $IP = getIP();
      
//       $sql = "INSERT INTO asunto (nombre, cargo, dependencia, usuario, fecha, ip) 
//               VALUES ('".$Anombre."', '".$Acargo."', '".$Adependencia."', ".$user.", '".$hoy."', '".$IP."')";
      
//       if (!empty($_POST['Asunto'])) {
//         $asunto = $_POST['Asunto'];
//         $sql = "INSERT INTO asunto (nombre, cargo, asunto,  dependencia, usuario, fecha, ip) 
//               VALUES ('".$Anombre."', '".$Acargo."', '".$asunto."', '".$Adependencia."', ".$user.", '".$hoy."', '".$IP."')";
//       }

//       $db = obtenerConexion();
//       $asunto = ejecutarQuery($db, $sql);
      
//       if ($asunto) {
//         $data = array('case'=> 1);
//         echo json_encode($data);

//       }else{
//         $data = array('case'=> 2);
//         echo json_encode($data);
//       }      
//   }else{
//     $data = array('case'=> 3);
        
//     echo json_encode($data);
//   }
// }

// function modAsunto()
// {
//   if (!empty($_POST['idAsunto'])&&!empty($_POST['Anombre'])&&!empty($_POST['Acargo'])&&!empty($_POST['Adependencia'])) {
//       $Anombre=$_POST['Anombre'];
//       $Acargo = $_POST['Acargo'];
//       $Adependencia = $_POST['Adependencia'];
//       $asunto = $_POST['Asunto'];
//       $idAsunto = $_POST['idAsunto'];
//       $hoy = date("Y-m-d H:i:s");
//       $user = $_SESSION['id'];
//       $IP = getIP();
      
//       // $sql = "INSERT INTO asunto (nombre, cargo, dependencia, usuario, fecha, ip) 
//       //         VALUES ('".$Anombre."', '".$Acargo."', '".$Adependencia."', ".$user.", '".$hoy."', '".$IP."')";
      
//       $sql = "UPDATE asunto SET nombre='".$Anombre."', cargo='".$Acargo."', dependencia='".$Adependencia."', 
//               usuario=".$user.", fecha='".$hoy."', ip='".$IP."',  asunto='".$asunto."' WHERE id=".$idAsunto;
      

//       $db = obtenerConexion();
//       $asunto = ejecutarQuery($db, $sql);
      
//       if ($asunto) {
//         $data = array('case'=> 1);
//         echo json_encode($data);

//       }else{
//         $data = array('case'=> 2);
//         echo json_encode($data);
//       }      
//   }else{
//     $data = array('case'=> 3);
        
//     echo json_encode($data);
//   }
// }




function FechaL($fecha)
{
  //Formato 2015-04-14
  $dat = new DateTime($fecha);
  $fecha = $dat->format('d M Y ');
  $fecha = str_replace('Jan','DE ENERO DEL',$fecha);
  $fecha = str_replace('Feb','DE FEBRERO DEL',$fecha);
  $fecha = str_replace('Mar','DE MARZO DEL',$fecha); 
  $fecha = str_replace('Apr','DE ABRIL DEL',$fecha);
  $fecha = str_replace('May','DE MAYO DEL',$fecha);
  $fecha = str_replace('Jun','DE JUNIO DEL',$fecha);
  $fecha = str_replace('Jul','DE JULIO DEL',$fecha);
  $fecha = str_replace('Aug','DE AGOSTO DEL',$fecha);
  $fecha = str_replace('Sep','DE SEPTIEMBRE DEL',$fecha);
  $fecha = str_replace('Oct','DE OCTUBRE DEL',$fecha);
  $fecha = str_replace('Nov','DE NOVIEMBRE DEL',$fecha);
  $fecha = str_replace('Dec','DE DICIEMBRE DEL',$fecha);
  return $fecha; 

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
function getQR($numeroOrden, $user, $IP, $tipo)
{
  //Generación del código QR
  $codigo = "../QR/".$numeroOrden."-".date('dmy').".png";  
  $h = date('h:i');
  $fecha = date('d/m/Y');

  $info = "Usuario:$user\n"
  . "FECHA: $fecha\n"
  . "HORA: $h\n"
  . "IP: $IP\n"
  . "TIPO: $tipo\n"
  . "ORDEN DE PAGO: $numeroOrden";

  QRcode::png($info, $codigo);

  $rut=$numeroOrden."-".date('dmy').".png";
  return $rut; 
}


?>