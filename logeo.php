<?php
// session_start();


//$usuario = $_POST["usuario"];
//$pass=  md5($_POST["pass"]);



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
	$us = "DCA";
	$password = "7ce6f00be338293d5dc539a558bac254";
	// $id;
	// $nombre;
	// $permiso;
	$pss = md5("*DGM2015A");
	// $stid = oci_parse($conn, "begin :r := AUTENTICA_USR_CERTIFICACION('".$us."', 123, :id, :nombre, :permiso); end;");
	$stid = oci_parse($conn, "begin AUTENTICA_USR_CERTIFICACION(:us,:pass,:p1,:p2,:p3); end;");
	oci_bind_by_name($stid,':us',$us);
	oci_bind_by_name($stid,':pass',$pss);
	oci_bind_by_name($stid,':p1',$id, 3);
	oci_bind_by_name($stid,':p2',$nombre, 100);
	oci_bind_by_name($stid,':p3',$permiso, 5);
	
	oci_execute($stid);
	
	echo "ID -".$id;
	echo "Nombre -".$nombre;
	echo "Permiso -".$permiso;
	// if (!$stid)
	// {
	// 	$e = oci_error($conn);  
 //        trigger_error(htmlentities($e['message']), E_USER_ERROR);
		
	// 	echo "Usuario y/o Constraseña incorrecta"; 
	// 	exit;
	// }
	// else
	// {	

	// 	echo $z;
	// 	echo "<br>";
	// 	echo $z;
	// 	echo "<br>";

	// 	if($Z==4946)
	// 	{
	// 		$_SESSION["ARRAIGO"] = $Z;
	// 	     echo "<script type='text/javascript'>
	// 	 	 window.location='../imprimircert.php';    
	// 	     </script>";
	// 	     exit;
	// 	}


	// 	else if($Z==4947)
	// 	{
	// 		$_SESSION["MODIFICA"] = $Z;
	// 	     echo "<script type='text/javascript'>
	// 	 	 window.location='../modificacion.php';    
	// 	     </script>";
	// 	     exit;
	// 	}


	// 	else
	// 	{
	// 		$_SESSION["REPORTES"] = $Z;
	// 	     echo "<script type='text/javascript'>
	// 	 	 window.location='../reportes.php';    
	// 	     </script>";
	// 	     exit;
	// 	}


	// 	echo "<BR> La sesión creada es ". print_r($_SESSION);
		
	// } 	

}

?>