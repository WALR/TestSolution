<?php 
require_once('conexion.php'); 
if(!isset($_SESSION)) 
{ 
    session_start(); 
}

function valor_actual()
{
    $sql = "SELECT id, valor_dolar, usuario, ip, fecha from tipo_cambio order by fecha DESC LIMIT 1"; 

    $db = obtenerConexion();
    $result = ejecutarQuery($db, $sql);
    $data = $result->fetch_assoc();
    // $resp = $orden->fetch_assoc();
    
    return $data;   
}

function sessionExp()
{
    if(isset($_SESSION["tiempo"])) 
    { 
      $tiempoInicio = $_SESSION["tiempo"]; 
      $ahora = date("Y-n-j H:i:s"); 
      $tiempo_transcurrido = (strtotime($ahora)-strtotime($tiempoInicio)); 
      //compara tiempo trascurrido 
       if($tiempo_transcurrido >= 600) { 
       //si pasaron 10 minutos o más 
            if(session_destroy())
            {
                session_unset();
                if (isset($_GET['ac'])) {
                    switch ($_GET['ac']) {
                        case 'inicio':
                            header ("Location: /CertificacionHistorico/?ac=inicio");
                            break;
                        case 'ordenpago':
                            header ("Location: /CertificacionHistorico/?ac=ordenpago");
                            break;

                        case 'certificacion':
                            header ("Location: /CertificacionHistorico/?ac=certificacion");
                            break;

                        case 'reporte':
                            header ("Location: /CertificacionHistorico/?ac=reporte");
                            break;

                        case 'cambio':
                            header ("Location: /CertificacionHistorico/?ac=cambio");
                            break;
                    }

                }else{
                    header ("Location: /CertificacionHistorico/");
                }
            }

        }else { 
            $_SESSION["tiempo"] = $ahora; 
        } 
    }
}

function sessionExpAJAX()
{
    if(isset($_SESSION["tiempo"])) 
    { 
      $tiempoInicio = $_SESSION["tiempo"]; 
      $ahora = date("Y-n-j H:i:s"); 
      $tiempo_transcurrido = (strtotime($ahora)-strtotime($tiempoInicio)); 
      //compara tiempo trascurrido 
       if($tiempo_transcurrido >= 600) { 
       //si pasaron 10 minutos o más 
            if(session_destroy())
            {
                session_unset();
                return true;
            }

        }else { 
            $_SESSION["tiempo"] = $ahora;
            return false; 
        } 
    }
}


function logeo($user, $pass)
{
    // $respuesta = loginOracle($user, $pass);
    $respuesta = login($user, $pass);

    switch ($respuesta['case']) {
        case '1':
            return false;
            break;

        case '2':
            return false;
            break;

        case '3':
            if(!isset($_SESSION)) 
            { 
                session_start(); 
            }
            $_SESSION['id'] = $respuesta['id'];
            $_SESSION['nombre'] = $respuesta['nombre'];
            $_SESSION['user'] = $respuesta['usuario'];
            $_SESSION['permiso']= $respuesta['permiso'];
            $_SESSION["tiempo"]= date("Y-n-j H:i:s");
            // $_SESSION['tiempo'] = 5;

            return $respuesta;
            break;
    }
    
}

if (!empty($_POST['actual_pass'])&&!empty($_POST['nuevo_pass'])){
   $actual =  $_POST['actual_pass'];
   $nuevo = $_POST['nuevo_pass'];
   $idUser = $_SESSION['id'];

   cambioPass($actual, $nuevo, $idUser);

}

function cambioPass($actuald, $nuevod, $idUser)
{
    $actual = md5($actuald);
    $nuevo = md5($nuevod);

    $user = "SELECT id, usuario, primer_nombre, segundo_nombre, 
    primer_apellido, segundo_apellido, apellido_casada, permiso 
    FROM usuario WHERE id=$idUser AND password='".$actual."'";

    $db = obtenerConexion();
    $User = ejecutarQuery($db, $user);

    // echo $user;
    if (!$User)
    {
        
        $respuesta = array(
       'incorrecta'=> 'Constraseña incorrecta',
       'case'=> 2);
            
        echo json_encode($respuesta); 
    }else{
        $row = $User->num_rows;
        if ($row==1) {
            $userUPD = "UPDATE usuario SET password='".$nuevo."' WHERE id=$idUser";           

            $db = obtenerConexion();
            $UserUPD = ejecutarQuery($db, $userUPD);
            
            if ($UserUPD) {
                $respuesta = array(
               'correcto'=> 'Constraseña modificada Correctamente',
               'case'=> 1);
                echo json_encode($respuesta);
            }else{
                $respuesta = array(
               'incorrecta'=> 'Error al actualizar la contraseña',
               'case'=> 3);
                    
                echo json_encode($respuesta); 

            }
        }else{
            $respuesta = array(
           'incorrecta'=> 'Constraseña incorrecta',
           'case'=> 2);

            echo json_encode($respuesta);
        }
    }
}


function obtenerPaises() {
    $paises = array();
    $sql = "SELECT id_pais, nombre_pais, nacionalidad_pais from paises ORDER BY nombre_pais"; 
    $db = obtenerConexion();
    $db -> query("SET NAMES 'UTF8' ");
    // obtenemos todos los países
    $result = ejecutarQuery($db, $sql);
    // creamos objetos de la clase país y los agregamos al arreglo
    while($row = $result->fetch_assoc()){
        // $row['nombre_pais'] = mb_convert_encoding($row['nombre_pais'], 'UTF-8', mysqli_character_set_name($db));
        // $row['nacionalidad_pais'] = mb_convert_encoding($row['nacionalidad_pais'], 'UTF-8', mysqli_character_set_name($db));          
        $pais = new pais($row['id_pais'], $row['nombre_pais'], $row['nacionalidad_pais']);
        array_push($paises, $pais);
    }

        cerrarConexion($db, $result);

        // devolvemos el arreglo
        
        return $paises;
}

class pais {
    public $id;
    public $nombre;
    public $nacionalidad;

    function __construct($id, $nombre, $nacionalidad) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->nacionalidad = $nacionalidad;
    }
}

function obtenerConcepto() {
    $conceptos = array();
    $sql = "SELECT id_concepto, nombre_concepto, valor_concepto from conceptos"; 
    $db = obtenerConexion();
    // obtenemos todos los países
    $result = ejecutarQuery($db, $sql);
    // creamos objetos de la clase país y los agregamos al arreglo
    while($row = $result->fetch_assoc()){
        // $row['nombre_concepto'] = $row['nombre_concepto'];                  
        $concepto = new concepto($row['id_concepto'], $row['nombre_concepto'], $row['valor_concepto']);
        array_push($conceptos, $concepto);
    }

        cerrarConexion($db, $result);

        // devolvemos el arreglo
        
        return $conceptos;
}

class concepto {
    public $id;
    public $nombre;
    public $valor;

    function __construct($id, $nombre, $valor) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->valor = $valor;
    }
}

function obtenerAsunto() {
    $asuntos = array();
    $sql = "SELECT id, nombre, cargo, asunto, dependencia from asunto"; 
    $db = obtenerConexion();
    // obtenemos todos los asuntos
    $result = ejecutarQuery($db, $sql);
    // creamos objetos de la clase asunto y los agregamos al arreglo
    while($row = $result->fetch_assoc()){                  
        $asunto = new asunto($row['id'], $row['nombre'], $row['cargo'], $row['asunto'], $row['dependencia']);
        array_push($asuntos, $asunto);
    }

        cerrarConexion($db, $result);

        // devolvemos el arreglo
        
        return $asuntos;
}

class asunto {
    public $id;
    public $nombre;
    public $cargo;
    public $asunto;
    public $dependencia;

    function __construct($id, $nombre, $cargo, $asunto, $dependencia) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->cargo = $cargo;
        $this->asunto = $asunto;
        $this->dependencia = $dependencia;
    }
}
function DatosAsunto()
{
  $sql = "SELECT id, nombre, cargo, dependencia, asunto from asunto"; 
    $db = obtenerConexion();
    $result = ejecutarQuery($db, $sql);
    $fila ="";
    while($row = $result->fetch_assoc()){
      $fila.='<tr>
                <td class="col-xl-3 col-sm-3 col-md-3" >
                  <div id="nombre'.$row['id'].'" class="text-center">'.$row['nombre'].'</div>
                </td>
                <td class="col-xl-2 col-sm-2 col-md-2" >
                  <div id="cargo'.$row['id'].'" class="text-center">'.$row['cargo'].'</div>
                </td>
                <td class="col-xl-2 col-sm-2 col-md-2" >
                  <div id="dependencia'.$row['id'].'" class="text-center">'.$row['dependencia'].'</div>
                </td>
                <td class="col-xl-4 col-sm-4 col-md-4" >
                  <div id="asunto'.$row['id'].'" class="text-center">'.$row['asunto'].'</div>
                </td>
                <td class="col-xl-1 col-sm-1 col-md-1">
                  <div class="btn-group text-center"  role="group" aria-label="accion" style="margin-left: 2em;" '.$disa.'>
                    <button type="button" onclick="modificarA('.$row['id'].');" class="btn btn-default" title="Modificar" style="padding: 5px 8px;">
                      <span class="glyphicon glyphicon-pencil"></span>
                    </button>
                  </div>
                </td>
              </tr>
            ';
    }
  return $fila;            
}




function obtenerAntivirus() {
    $antivirus = array();
    $sql = "SELECT id, nombre, descripcion, precio, imagen from antivirus ORDER BY nombre"; 
    $db = obtenerConexion();
    $db -> query("SET NAMES 'UTF8' ");
    // obtenemos todos los países
    $result = ejecutarQuery($db, $sql);
    // creamos objetos de la clase país y los agregamos al arreglo
    while($row = $result->fetch_assoc()){
        // $row['nombre_pais'] = mb_convert_encoding($row['nombre_pais'], 'UTF-8', mysqli_character_set_name($db));
        // $row['nacionalidad_pais'] = mb_convert_encoding($row['nacionalidad_pais'], 'UTF-8', mysqli_character_set_name($db));          
        $antiviru = new antiviru($row['id'], $row['nombre'], $row['descripcion'], $row['precio'], $row['imagen']);
        array_push($antivirus, $antiviru);
    }

        cerrarConexion($db, $result);

        // devolvemos el arreglo
        
        return $antivirus;
}

class antiviru {
    public $id;
    public $nombre;
    public $descripcion;
    public $precio;
    public $imagen;

    function __construct($id, $nombre, $descripcion, $precio, $imagen) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->precio = $precio;
        $this->imagen = $imagen;
    }
}





?>