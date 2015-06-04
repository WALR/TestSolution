<?php 
session_start();
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

         case 'oficial':
      header ("Location: /CertificacionHistorico/?ac=oficial");
            break;

          case 'reporte':
			header ("Location: /CertificacionHistorico/?ac=reporte");
            break;

          case 'cambio':
			header ("Location: /CertificacionHistorico/?ac=cambio");
            break;
          }

    }else{
		header ("Location: /CertificacionHistorico/?ac=inicio");
    }
}

 ?>