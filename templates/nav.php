<?php 
require_once('res/funciones.php');
ini_set('display_errors', 'Off');
ini_set('display_errors', 0); 

// if(!isset($_SESSION)) 
// { 
//     session_start(); 
// }

// if (!empty($_POST['usuario'])&&!empty($_POST['password'])) {    
//   logeo($_POST['usuario'], $_POST['password']);
//   if(isset($_SESSION['id'])&&!empty($_SESSION['id'])){

//      if (isset($_GET['ac'])) {
//         switch ($_GET['ac']) {
//           case 'inicio':
//             echo '<script type="text/javascript">window.location="?ac=inicio";</script>';
//             break;
//           case 'ordenpago':
//             echo '<script type="text/javascript">window.location="?ac=ordenpago";</script>';
//             break;

//           case 'certificacion':
//             echo '<script type="text/javascript">window.location="?ac=certificacion";</script>';
//             break;
//           case 'oficial':
//             echo '<script type="text/javascript">window.location="?ac=oficial";</script>';
//             break;
//           case 'reporte':
//             echo '<script type="text/javascript">window.location="?ac=reporte";</script>';
//             break;

//           case 'cambio':
//             echo '<script type="text/javascript">window.location="?ac=cambio";</script>';
//             break;


//           }

//         }else{
//           echo '<script type="text/javascript">window.location="?ac=inicio";</script>';
//         }
//   }else{
//     echo "<script> $(document).on('ready',function(){ $.bootstrapGrowl('Usuario y/o contraseña <strong>Incorrecta!</strong>', {type: 'danger', width: '500', offset: {from: 'top', amount: 90}, delay: 4000, stackup_spacing: 10 }); });</script>";
//   }
// }

// if (!empty($_POST['actual_pass'])&&!empty($_POST['nuevo_pass'])) {    
//   if(isset($_SESSION['id'])&&!empty($_SESSION['id'])){
//     $resp = cambioPass($_POST['actual_pass'], $_POST['actual_pass'], $_SESSION['id']);
//     echo ($resp);
//   }
// }

?>



<div class="navbar-wrapper">
  <div class="container">
    <nav class="navbar navbar-inverse navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/">Test Solution</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li id="inicio" class="active"><a href="?ac=inicio">Inicio</a></li>
            <li id="test" class=""><a href="?ac=test">My Antivirus Test</a></li>
            <li id="antivirus" class=""><a href="?ac=antivirus">Antivirus</a></li>
            <li id="acerca" class=""><a href="?ac=acerca">Acerca</a></li>
            <li id="contacto" class=""><a href="?ac=contacto">Contacto</a></li>
          </ul>
          <ul class="nav navbar-nav pull-right">
            <li id="login" class=""><a href="?ac=login">Login</a></li>
          </ul>
        </div>
      </div>
    </nav>

  </div>
</div>



<?php 
if (isset($_GET['ac'])) {
  switch ($_GET['ac']) {
    case 'inicio':
      echo "<script> $(document).on('ready',function(){ $('#inicio').addClass('active');$('#test').removeClass('active');$('#antivirus').removeClass('active');$('#acerca').removeClass('active');$('#contacto').removeClass('active');$('#login').removeClass('active'); });</script>";
    break;
    case 'test':
      echo "<script> $(document).on('ready',function(){ $('#inicio').removeClass('active');$('#test').addClass('active');$('#antivirus').removeClass('active');$('#acerca').removeClass('active');$('#contacto').removeClass('active');$('#login').removeClass('active'); });</script>";
    break;
    case 'antivirus':
      echo "<script> $(document).on('ready',function(){ $('#inicio').removeClass('active');$('#test').removeClass('active');$('#antivirus').addClass('active');$('#acerca').removeClass('active');$('#contacto').removeClass('active');$('#login').removeClass('active'); });</script>";
    break;
    case 'acerca':
      echo "<script> $(document).on('ready',function(){ $('#inicio').removeClass('active');$('#test').removeClass('active');$('#antivirus').removeClass('active');$('#acerca').addClass('active');$('#contacto').removeClass('active');$('#login').removeClass('active'); });</script>";
    break;
    case 'contacto':
      echo "<script> $(document).on('ready',function(){ $('#inicio').removeClass('active');$('#test').removeClass('active');$('#antivirus').removeClass('active');$('#acerca').removeClass('active');$('#contacto').addClass('active');$('#login').removeClass('active'); });</script>";
    break;
    case 'login':
      echo "<script> $(document).on('ready',function(){ $('#inicio').removeClass('active');$('#test').removeClass('active');$('#antivirus').removeClass('active');$('#acerca').removeClass('active');$('#contacto').removeClass('active');$('#login').addClass('active'); });</script>";
    break;
  }
}


 ?>

<!-- <div id="navLog" >
  
<nav class="navbar navbar-static-top" role="navigation" >
      <div class="container">
        <div class="navbar-header">
          <a href="#">
            <div class="navbar-brand">
              <img alt="DGM" src="img/migraLogo.png" />
            </div>
              <div class="navbar-text titulo">Movimiento Migratorio</div>
          </a>
        </div>
        <div class="navbar-inner" id="wait">
            <!-- <img src="img/wait1.gif" width="35" height="35" /> 
        </div>
        <ul class="nav pull-right"> -->
      <?php 
      // if(isset($_SESSION['nombre'])&&!empty($_SESSION['nombre'])){
      //   if (isset($_GET['ac'])) {
      //     $dir ='?ac='.$_GET['ac'];
      //   }else{
      //     $dir = '';
      //   }
      //   echo '
      //   <li class="dropdown nav-login">
      //         <a class="dropdown-toggle" href="#" data-toggle="dropdown">
      //           <span class="glyphicon glyphicon-user"></span>
      //           '.$_SESSION['user'].'  <strong class="caret"></strong>
      //         </a>
      //         <ul class="dropdown-menu" style="margin-left:-12em;padding: 20px; padding-bottom: 5px;">
      //           <li>
      //               <div class="navbar-login" >
      //                   <div class="row" >
      //                       <div class="col-lg-4" style="padding-left:1.5em;padding-right: 0;padding-bottom: 0;">
      //                           <p class="text-center" >
      //                               <span style="font-size: 87px;" class="glyphicon glyphicon-user icon-size"></span>
      //                           </p>
      //                       </div>
      //                       <div class="col-lg-8" style="padding-left: 2em;">
      //                           <p class="text-left"><strong style="font-size:1em;">'.$_SESSION['nombre'].'</strong></p>
      //                           <!--<p class="text-left small"></p>-->
      //                           <br>
      //                           <p class="text-left">
      //                               <a id="userConf" class="btn btn-primary btn-block btn-sm">
      //                                 <span class="glyphicon glyphicon-cog"></span>
      //                                 Configuracion
      //                               </a>
      //                           </p>
      //                       </div>
      //                   </div>
      //               </div>
      //           </li>
      //             <li class="divider"></li>
      //             <li>
      //                 <div class="navbar-login navbar-login-session">
      //                     <div class="row">
      //                         <div class="col-lg-12">
      //                             <p>
      //                                 <a href="logout.php/'.$dir.'" class="btn btn-danger btn-block">
      //                                   <span class="glyphicon glyphicon-off"></span>
      //                                   Cerrar Sesión
      //                                 </a>
      //                             </p>
      //                         </div>
      //                     </div>
      //                 </div>
      //             </li>
      //     </ul>
      //     </li> 
      //   ';
      // }else{
      //   if (isset($_GET['ac'])) {
      //     $dir ='?ac='.$_GET['ac'];
      //   }else{
      //     $dir = '';
      //   }
      //   echo '
      //   <li class="dropdown nav-login">
      //         <a class="dropdown-toggle" href="#" data-toggle="dropdown">Iniciar sesión <strong class="caret"></strong></a>
      //           <div class="dropdown-menu" style="margin-left:-6.5em;padding: 20px; padding-bottom: 5px;">
      //             <form action="/CertificacionHistorico/'.$dir.'" method="post" accept-charset="UTF-8">
      //               <input style="margin-bottom: 15px; padding-left:15px;" class="form-control" type="text" placeholder="Usuario" id="usuario" name="usuario">
      //               <input style="margin-bottom: 15px; padding-left:15px;" class="form-control" type="password" placeholder="Contraseña" id="pass" name="password">
      //               <button class="btn btn-primary btn-block" type="submit">Ingresar</button>
      //             </form>
      //           </div>
      //         </li>
      //   ';
      // }

      ?>
<!--         </ul>
      </div>
</nav> -->

<!-- MODAL CONFIGURACION -->
<!-- <div id="ModalUser" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title Colet" style="font-weight: 700;">Datos de Usuario</h4>
      </div>
      <div class="modal-body">
        <div id="datosUser">
          <div class="img-thumbnail col-xl-3 col-sm-3 col-md-3" style="padding:0.5em 0.5em 0.2em 0.5em;">
            <span style="font-size: 125px;color:#616161;" class="glyphicon glyphicon-user"></span>
          </div>
          <div id="datosUser" class="col-xl-9 col-sm-9 col-md-9">
              <strong class="Colet">Datos de Usuario</strong><br> 
              <table class="table table-condensed table-responsive table-user-information">
                  <tbody>
                  <tr>
                      <td style="color:#616161;">Usuario:</td>
                      <td style="color:#616161;"><b><?php echo $_SESSION['user']; ?></b></td>
                  </tr>
                  <tr>
                      <td style="color:#616161;">Nombre:</td>
                      <td style="color:#616161;"><b><?php echo $_SESSION['nombre']; ?></b></td>
                  </tr>
                  <tr>
                    <td>
                      <strong class="Colet">Modificacion de Contraseña</strong><br>
                    </td>
                    <td></td>
                  </tr>
                  <tr>
                      <td style="color:#616161;">Contraseña Actual:</td>
                      <td><input type="password" class="form-control" id="APass" data-toggle="tooltip" data-placement="right" title="Ingresar Contraseña Actual" data-campo="APass" placeholder="Contraseña Actual" required autofocus></td>
                  </tr>
                  <tr>
                      <td style="color:#616161;">Nueva Contraseña:</td>
                      <td><input type="password" class="form-control" id="APassNew" data-toggle="tooltip" data-placement="right" title="Ingresar Nueva Contraseña" data-campo="APass" placeholder="Nueva Contraseña" required autofocus></td>
                  </tr>
                  <tr>
                      <td style="color:#616161;">Repetir Nueva Contraseña:</td>
                      <td><input type="password" class="form-control" id="APassNewR" data-toggle="tooltip" data-placement="right" title="Repetir Nueva Contraseña" data-campo="APass" placeholder="Repetir Nueva Contraseña" required autofocus></td>
                  </tr>
                  </tbody>
              </table>
              
          </div>
          <div style="margin-left: 20em;">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button> 
            <button id="ModPass" type="button" class="btn btn-danger">
              <span class="glyphicon glyphicon-pencil"></span>
              Modificar Contraseña
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div> -->

<script>

// $("#btn_ingresar").click(function(){
//   //alert("usuario: "+$("#usuario").val()+" Pass: "+$("#pass").val());  
//   var datos = "usuario="+$("#usuario").val()+"&pass:"+$("#pass").val();
//   //alert(datos);
  
//   var url = "res/login.php"; 
//     $.ajax({
//           type: "POST",
//           url: url,
//           data: datos,
//           success: function(data)
//           {
//             $('.progress-bar').css('width','100%');
//             $("#ordenResp").html(data); // Mostrar la respuestas del script PHP.
//             $("#ModalConfirm").modal('hide');
//           },
//           error: function() {
//             // Error 
//           }

//     });
//     return false;
// });

// $("#userConf").click(function(){
//   $("#ModalUser").modal('show');
// });

// $("#ModPass").click(function(){
//   if($('#APass').val()==""){
//     $('#APass').focus();
//     $('#APass').tooltip('show');
//   }else{
//     if($('#APassNew').val()==""){
//       $('#APassNew').focus();
//       $('#APassNew').tooltip('show');
//     }else{
//       if($('#APassNewR').val()==""){
//         $('#APassNewR').focus();
//         $('#APassNewR').tooltip('show');
//       }else{
//         if($('#APassNew').val()!=$('#APassNewR').val()){
//           $.bootstrapGrowl("<h4 class='text-center' style='margin-top:1px;margin-bottom:-3px;'><strong>Las contraseñas nuevas no coinciden!</strong></h4>", {
//             type: 'danger',
//             width: '500',
//             offset: {from: 'top', amount: 90}, // 'top', or 'bottom'
//             stackup_spacing: 10
//           });
//         }else{
//           if($('#APassNew').val().length < 6){
//             $.bootstrapGrowl("<h5 class='text-center' style='margin-top:1px;margin-bottom:-3px;'><strong>La nueva contraseña debe ser al menos de 6 digitos!</strong></h5>", {
//               type: 'danger',
//               width: '500',
//               offset: {from: 'top', amount: 90}, // 'top', or 'bottom'
//               stackup_spacing: 10
//             });
//           }else{
//             if(!tiene_numeros($('#APassNew').val())){
//               $.bootstrapGrowl("<h5 class='text-center' style='margin-top:1px;margin-bottom:-3px;'><strong>La nueva contraseña debe tener al menos un numero!</strong></h5>", {
//                 type: 'danger',
//                 width: '500',
//                 offset: {from: 'top', amount: 90}, // 'top', or 'bottom'
//                 stackup_spacing: 10
//               });
//             }else{
//               if(!tiene_letras($('#APassNew').val())){
//                 $.bootstrapGrowl("<h5 class='text-center' style='margin-top:1px;margin-bottom:-3px;'><strong>La nueva contraseña debe tener al menos una Letra!</strong></h5>", {
//                   type: 'danger',
//                   width: '500',
//                   offset: {from: 'top', amount: 90}, // 'top', or 'bottom'
//                   stackup_spacing: 10
//                 });
//               }else{

//                 // if(tiene_minusculas($('#APassNew').val())){
//                 //   $.bootstrapGrowl("<h5 class='text-center' style='margin-top:1px;margin-bottom:-3px;'><strong>La nueva contraseña debe tener al menos una Minuscula!</strong></h5>", {
//                 //     type: 'danger',
//                 //     width: '500',
//                 //     offset: {from: 'top', amount: 90}, // 'top', or 'bottom'
//                 //     stackup_spacing: 10
//                 //   });
//                 // }else{

//                 //   if(tiene_mayusculas($('#APassNew').val())){
//                 //     $.bootstrapGrowl("<h5 class='text-center' style='margin-top:1px;margin-bottom:-3px;'><strong>La nueva contraseña debe tener al menos una Mayuscula!</strong></h5>", {
//                 //       type: 'danger',
//                 //       width: '500',
//                 //       offset: {from: 'top', amount: 90}, // 'top', or 'bottom'
//                 //       stackup_spacing: 10
//                 //     });
//                 //   }else{
//                     var datos = "&actual_pass="+$('#APass').val()+"&nuevo_pass="+$('#APassNew').val();
//                     var url = "certificacion/funcion_certificacion.php"; 
//                     $.ajax({
//                       type: "POST",
//                       url: "res/funciones.php",
//                       data: datos,
//                       success: function(data)
//                       {
//                         console.log(data);
//                         var jorden = JSON.parse(data);
//                         switch(jorden.case){
//                           case 1:
//                             $("#ModalUser").modal('hide');
//                             $.bootstrapGrowl("<h4 class='text-center' style='margin-top:1px;margin-bottom:-3px;'><strong>Contraseña modificada Correctamente!</strong></h4>", {
//                               type: 'success',
//                               width: '500',
//                               offset: {from: 'top', amount: 90}, // 'top', or 'bottom'
//                               stackup_spacing: 10
//                             });
//                             $('#APass').val("");
//                             $('#APassNew').val("");
//                             $('#APassNewR').val("");

//                           break;
//                           case 2:
//                             $.bootstrapGrowl("<h4 class='text-center' style='margin-top:1px;margin-bottom:-3px;'><strong>Contraseña actual incorrecta!</strong></h4>", {
//                                 type: 'danger',
//                                 width: '500',
//                                 offset: {from: 'top', amount: 90}, // 'top', or 'bottom'
//                                 stackup_spacing: 10
//                               });
//                           break;
//                           case 2:
//                             $.bootstrapGrowl("<h4 class='text-center' style='margin-top:1px;margin-bottom:-3px;'><strong>Error al Modificar la Contraseña!</strong></h4>", {
//                                 type: 'danger',
//                                 width: '500',
//                                 offset: {from: 'top', amount: 90}, // 'top', or 'bottom'
//                                 stackup_spacing: 10
//                               });
//                           break;
//                         }
//                       }
//                     });
//                 //   }
//                 // }
//               }
//             }
//           }
//         }
//       }
//     }
//   }
// });

// function tiene_numeros(texto){
//   var numeros="0123456789";
//    for(i=0; i<texto.length; i++){
//       if (numeros.indexOf(texto.charAt(i),0)!=-1){
//          return 1;
//       }
//    }
//    return 0;
// }
// function tiene_letras(texto){
//   var letras="abcdefghyjklmnñopqrstuvwxyz";
//    texto = texto.toLowerCase();
//    for(i=0; i<texto.length; i++){
//       if (letras.indexOf(texto.charAt(i),0)!=-1){
//          return 1;
//       }
//    }
//    return 0;
// }
// function tiene_minusculas(texto){
//   var letras="abcdefghyjklmnñopqrstuvwxyz";
//    for(i=0; i<texto.length; i++){
//       if (letras.indexOf(texto.charAt(i),0)!=-1){
//          return 1;
//       }
//    }
//    return 0;
// }
// function tiene_mayusculas(texto){
//   var letras_mayusculas="ABCDEFGHYJKLMNÑOPQRSTUVWXYZ";
//    for(i=0; i<texto.length; i++){
//       if (letras_mayusculas.indexOf(texto.charAt(i),0)!=-1){
//          return 1;
//       }
//    }
//    return 0;
// }

</script>
</div>