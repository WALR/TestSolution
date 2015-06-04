<?php 
function obtenerConexion() {
    $db = new mysqli('localhost', 'root', '*migra123', 'bdcertificaciones');
    // $db = new mysqli('localhost', 'certificacionMov', '*migra123**', 'bdcertificaciones');
    // $db = new mysqli('localhost', 'root', '123', 'bdcertificaciones');
    $db -> query("SET NAMES 'UTF8' ");

    if($db->connect_errno > 0){
	    die('Unable to connect to database [' . $db->connect_error . ']');
    }
        return $db; 
}

function cerrarConexion($db) {
    //$query->free();
    $db->close();
}

function ejecutarQuery($db, $sql) {
    if(!$resultado = $db->query($sql)){
        return $resultado;
        // die('Error al ejecutar el Query [' . $db->error . ']');
    }
    return $resultado;
}

// function QueryTrans($db, $sql, $sql2)
// {
//     $db->query("SET SET AUTOCOMMIT=0;");
//     $db->query("BEGIN");

//     $resultado = $db->query($sql);
//     $dato = $db->insert_id;
//     $resultado = $db->query($sql2);

//     if ($resultado) {
//         $db->query("COMMIT");
//         return $resultado;
//     }
//     else{
//         $db->query("ROLLBACK");
//         return $resultado;
//     }   

// }

function datoNuevo($db)
{
    $dato = $db->insert_id;
    return $dato;
}

function login($user, $pass)
{
    // session_start();
    $usuario = $user;
    $password=  md5($pass);

    $db = obtenerConexion();
    $user = "SELECT id, usuario, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, apellido_casada, permiso FROM usuario WHERE usuario='$usuario' AND password='".$password."'";
    $User = ejecutarQuery($db, $user);
       
    if (!$User)
    {
        
        $respuesta = array(
       'incorrecta'=> 'Usuario y/o Constraseña incorrecta',
       'case'=> 2);
            
        return $respuesta; 
        exit;
    }else{
        $row = $User->num_rows;
        if ($row==1) {
            $respUser = $User->fetch_assoc();
            $respuesta = array(
           'id'=> $respUser['id'],
           'usuario'=> $respUser['usuario'],
           'nombre'=> $respUser['primer_nombre'].' '.$respUser['segundo_nombre'].' '.$respUser['primer_apellido'].' '.$respUser['segundo_apellido'].' '.$respUser['apellido_casada'],
           'permiso'=> $respUser['permiso'],
           'case'=> 3);

            return $respuesta;
            exit;
        }else{
            $respUser = $User->fetch_assoc();
            $respuesta = array(
           'incorrecta'=> 'Usuario y/o Constraseña incorrecta',
           'case'=> 2);
        }

    }
}

function loginOracle($user, $pass)
{
    // session_start();
    $usuario = $user;
    $password=  md5($pass);

    $conOracle= "(DESCRIPTION =
        (ADDRESS_LIST =
            (ADDRESS = (PROTOCOL = TCP)(HOST = 10.200.3.1)(PORT = 1521))
            )
    (CONNECT_DATA =
        (SID = SIOMDBGT1)
        )
    )";   

    $conn = oci_connect('certificacion', 'certificacionDGM', $conOracle);

    if ($conn) {
        //$us = "RLOBOS";
        //$PS=  "e3ce8c7a2a5eba557c9412d9f7d533cc";
        // $us = "DCA";
        // $password = "7ce6f00be338293d5dc539a558bac254";
        // $id;
        // $nombre;
        // $permiso;
        //$pss = md5("*DGM2015A");
        // $stid = oci_parse($conn, "begin :r := AUTENTICA_USR_CERTIFICACION('".$us."', 123, :id, :nombre, :permiso); end;");
        $stid = oci_parse($conn, "begin AUTENTICA_USR_CERTIFICACION(:us,:pass,:p1,:p2,:p3); end;");
        oci_bind_by_name($stid,':us',$usuario);
        oci_bind_by_name($stid,':pass', $password);
        oci_bind_by_name($stid,':p1',$id, 5);
        oci_bind_by_name($stid,':p2',$nombre, 100);
        oci_bind_by_name($stid,':p3',$permiso, 9);
        
        oci_execute($stid);
        
        if (!$stid)
        {
            //$e = oci_error($conn);  
            //trigger_error(htmlentities($e['message']), E_USER_ERROR);

            $respuesta = array(
           'incorrecta'=> 'Usuario y/o Constraseña incorrecta',
           'case'=> 2);
                
            return $respuesta; 
            exit;
        }else{
            $respuesta = array(
           'id'=> ''.$id,
           'usuario'=> ''.$user,
           'nombre'=> ''.$nombre,
           'permiso'=> ''.$permiso,
           'case'=> 3);

            return $respuesta;
            exit;

        }
        // else
        // {    

        //     $usuario = array(
        //    'id'=> ''.$id,
        //    'nombre'=> ''.$nombre,
        //    'permiso'=> ''.$permiso,
        //    'case'=> 2);

        //     return $respuesta

        //     // echo "ID -".$id;
        //     // echo "Nombre -".$nombre;
        //     // echo "Permiso -".$permiso;

        //      // echo $z;
        //      // echo "<br>";
        //      // echo $z;
        //      // echo "<br>";

        //      // if($Z==4946)
        //      // {
        //      //     $_SESSION["ARRAIGO"] = $Z;
        //      //      echo "<script type='text/javascript'>
        //      //      window.location='../imprimircert.php';    
        //      //      </script>";
        //      //      exit;
        //      // }


        //      // else if($Z==4947)
        //      // {
        //      //     $_SESSION["MODIFICA"] = $Z;
        //      //      echo "<script type='text/javascript'>
        //      //      window.location='../modificacion.php';    
        //      //      </script>";
        //      //      exit;
        //      // }


        //      // else
        //      // {
        //      //     $_SESSION["REPORTES"] = $Z;
        //      //      echo "<script type='text/javascript'>
        //      //      window.location='../reportes.php';    
        //      //      </script>";
        //      //      exit;
        //      // }


        //      // echo "<BR> La sesión creada es ". print_r($_SESSION);
            
        // }    

    }else{
        $respuesta = array(
           'conexion'=> 'Error en la conexion a la DB',
           'case'=> 1);
        return $respuesta;
    }
    
}


?>