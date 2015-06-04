<?php 
ini_set('display_errors', 'On');
ini_set('display_errors', 1); 
require_once('../res/conexion.php'); 
if(!isset($_SESSION)) 
{ 
    session_start(); 
}


if (!empty($_POST['fun'])) {

	switch ($_POST['fun']) {
		case '1':
			valor_nuevo();
		 break;
	}

}

function valor_nuevo()
{
	
	if (!empty($_POST['ValorDolar'])) {
		$valorDolar = $_POST['ValorDolar'];
		$user = $_SESSION['id'];//$_SESSION['usuario'];
        $IP = getip();
        $hoy = date("Y-m-d H:i:s");

		$sql = "INSERT INTO tipo_cambio (valor_dolar, usuario, ip, fecha) 
				VALUES (".$valorDolar.", ".$user.", '".$IP."', '".$hoy."')"; 

		$db = obtenerConexion();
        $db->autocommit(FALSE);
        $result = ejecutarQuery($db, $sql);

        if ($result) {
        	$valorQ = $valorDolar*5;
        	$up2 = "UPDATE conceptos SET valor_concepto=".$valorQ." WHERE id_concepto=2";
			$result2 = ejecutarQuery($db, $up2);

			if ($result2) {
	        	$up8 = "UPDATE conceptos SET valor_concepto=".$valorQ." WHERE id_concepto=8";
	        	$result3 = ejecutarQuery($db, $up8);

	        	$up9 = "UPDATE conceptos SET valor_concepto=".$valorQ." WHERE id_concepto=9";
	        	$result4 = ejecutarQuery($db, $up9);

	        	if ($result4) {
	        		$db->commit();
	        		$data = array(
			       'case'=> 2);
	        		
	        		echo json_encode($data);
	        		
	        	}else{
	        		$db->rollback();
			        $data = array(
			       'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
			                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			                        Error al realizar la transaccion
			                      </div>',
			       'case'=> 1);
			        
	        		echo json_encode($data);
	        	}
			
			}else{
				$db->rollback();
		        $data = array(
		       'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
		                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		                        Error al realizar la transaccion
		                      </div>',
		       'case'=> 1);
		        
	        	echo json_encode($data);
			}

        }else{
        	$db->rollback();
	        $data = array(
	       'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
	                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	                        Error al realizar la transaccion
	                      </div>',
	       'case'=> 1);
	        
	        echo json_encode($data);
        }


	}else{
		//$db->rollback();
        $data = array(
       'message'=> '<div class="alert alert-danger alert-dismissible text-center" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        Error en los datos
                      </div>',
       'case'=> 1);
        
        echo json_encode($data);
	}	
}




function getip()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))
      $ip = $_SERVER['HTTP_CLIENT_IP'];
    else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
      $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else $ip = $_SERVER['REMOTE_ADDR'];

    return $ip; 
}

?>